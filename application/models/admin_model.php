<?php

class Admin_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}


	//页码导航设置
	//参数
	//	total_rows，总记录数
	//	per_page 每页显示记录数
	//	model book或user，为base_url提供参数
	function page_set($total_rows,$per_page,$model)
	{
		//分页设置
		//根据bootcss 设置 tag_open and tag_close
		$this->load->library('pagination');
		$config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div >';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li>';	
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$config['base_url'] = site_url('admin/'.$model);
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['num_links'] = 10;
		$this->pagination->initialize($config); 
	}

	function book_search($cur_page,$per_page)
	{
		$reset = ($this->uri->segment(3) =='index');
		if($this->input->post('submit') || $reset)
		//在提交或回到搜索首页时，对session进行赋值，数据来源post，
		//submit，session会保存提交内容；回到搜索首页，将清除session所有内容
		//搜索结果和搜索框内容都从session中获取
		{
			//多选框设置：
			//如果复选框第一次载入，没有submit，session未设定，多选框默认使用checked
			//如果submit，选择的会保持原样；取消复选框的，post将返回flase,用下列判断语句设置复选框session设为0

			if($this->input->post('no_reserve') === FALSE)
			{$no_reserve = 0;}else
			{$no_reserve = $this->input->post('no_reserve');}
			if($this->input->post('reserved') === FALSE)
			{$reserved = 0;}else
			{$reserved = $this->input->post('reserved');}
			if($this->input->post('traded') === FALSE)
			{$traded = 0;}else
			{$traded = $this->input->post('traded');}

			$search_data = array(
			'book_info' => $this->input->post('book_info'),//如果post的值未设置，函数传回false ，然后session也会被设置
			'uploader' => $this->input->post('uploader'),
			'subscriber' => $this->input->post('subscriber'),
			'no_reserve' => $no_reserve,
			'reserved' => $reserved,
			'traded' => $traded);
			$this->session->set_userdata($search_data);
			if($reset)
			{
				$this->session->unset_userdata('no_reserve');
				$this->session->unset_userdata('reserved');
				$this->session->unset_userdata('traded');
			}
		}


		//预搜索，找出能有多少个结果
		$this->search_condition();
		$pre_query = $this->db->select('id')->from('book')->get();
		$total_rows = $pre_query->num_rows();
		//内容搜索，将所有信息显示，并对结果根据页码进行limit
		$this->search_condition();
		$query = $this->db->select('book.id,name,price,originprice,uploader,subscriber,a.id AS uploader_id,b.id AS subscriber_id')
		->from('book')->join('user AS a','a.username = book.uploader')->join('user AS b','b.username = book.subscriber','left')
		->limit($per_page,$cur_page)->order_by('id','DESC')->get();
		return array('query'=>$query,'total_rows'=>$total_rows);
	}

	function user_search($cur_page,$per_page)
	{
		$reset = ($this->uri->segment(3) =='index');
		if($this->input->post('submit') || $reset)
		{
			if($this->input->post('order_by_up') === FALSE)
			{$order_by_up = 0;}else
			{$order_by_up = $this->input->post('order_by_up');}

			$search_data = array(
			'username' => $this->input->post('username'),//如果post的值未设置，函数传回false ，然后session也会被设置
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'student_number' => $this->input->post('student_number'),
			'order_by_up' => $order_by_up
			);
			$this->session->set_userdata($search_data);
		}

		//预搜索，找出能有多少个结果
		$this->user_condition();
		$pre_query = $this->db->select('id')->from('user')->get();
		$total_rows = $pre_query->num_rows();
		//内容搜索，将所有信息显示，并对结果根据页码进行limit
		$this->user_condition();
		if($this->session->userdata('order_by_up'))
		{
			$this->db->order_by('book_num','DESC');
		}
		$query = $this->db->select('user.id,user.username,user.phone,user.email,user.student_number,count(book.id) AS book_num')
		->from('user')->join('book','user.username = book.uploader','left')->group_by('user.id')
		->limit($per_page,$cur_page)->order_by('id','DESC')->get();
		return array('query'=>$query,'total_rows'=>$total_rows);
	}

	function search_condition()
	{
		$this->db->like('name',$this->session->userdata('book_info'));
		$this->db->like('uploader',$this->session->userdata('uploader'));
		$this->db->like('subscriber',$this->session->userdata('subscriber'));
		if($this->session->userdata('no_reserve') === 0)//表示未勾选时，搜索结果不包含未预定的书
		{
			$this->db->where('subscriber !=','N');
		}
		if($this->session->userdata('reserved') === 0)//表示未勾选时，搜索结果不包含已预定的书
		{
			$this->db->where('subscriber = "N" OR finishtime > 0');
		}
		if($this->session->userdata('traded') === 0)//表示未勾选时，搜索结果不包含已交易的书
		{
			$this->db->where('finishtime',0);
		}
	}

	function user_condition()
	{
		$this->db->like('username',$this->session->userdata('username'));
		$this->db->like('phone',$this->session->userdata('phone'));
		$this->db->like('email',$this->session->userdata('email'));
		$this->db->like('student_number',$this->session->userdata('student_number'));
	}


	function modify_validation($id) {
		$this->load->model('book_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		$this->form_validation->set_rules('author', '作者', 'trim');
		$this->form_validation->set_rules('publisher', '出版社', 'trim');
		$this->form_validation->set_rules('isbn', 'ISBN', 'trim');
		$this->form_validation->set_rules('description', '简介', 'trim');

		$this->form_validation->set_rules('bookname', '书本名称', 'trim|required');

		$this->form_validation->set_rules('originprice', '原价', 'trim|required|is_numeric');
		$this->form_validation->set_rules('price', '售出价格', 'trim|required|is_numeric');

		$this->form_validation->set_rules('userfile', '', 'callback_do_upload');

		if ($this->form_validation->run() == false) {
			return array('status'=>'0','message'=>'修改失败!');
		}
		else {
			$arr = array(
				'name' => htmlspecialchars($this->input->post('bookname', true)),
				'author' => htmlspecialchars($this->input->post('author', true)),
				'price' => htmlspecialchars($this->input->post('price', true)),
				'originprice' => htmlspecialchars($this->input->post('originprice', true)),
				'publisher' => htmlspecialchars($this->input->post('publisher', true)),
				'ISBN' => htmlspecialchars($this->input->post('isbn', true)),
				'description' => nl2br(htmlspecialchars($this->input->post('description'), true))
			  );

			if ($_FILES['userfile']['error'] == 0) {
				$userfile_data = $_FILES['userfile']['tmp_name'];
				$data = fread(fopen($userfile_data, "r"), filesize($userfile_data));

				$arr['img'] = $data;
				$arr['hasimg'] = true;
			}
			$this->book_model->update($id, $arr);
			return array('status'=>'1','message'=>'修改成功！');
		}
	}

	function do_upload()
	{
		if ($_FILES['userfile']['error'] == 4) return true;
		if ($_FILES['userfile']['type'] != 'image/jpeg' && $_FILES['userfile']['type'] != 'image/pjpeg' && $_FILES['userfile']['type'] != 'image/jpg' 
			&& $_FILES['userfile']['type'] != 'image/png' && $_FILES['userfile']['type'] != 'image/gif')  {
			$this->form_validation->set_message('do_upload', '图片上传失败，格式必须为jpg,png,gif且大小不得超过1M');
			return false;
		}
		if ($_FILES['userfile']['error'] || $_FILES['userfile']['size'] > 1048576) {
			$this->form_validation->set_message('do_upload', '图片上传失败，大小不得超过1M');
			return false;
		}
		return true;
	}

	function book_delete($id) {
		$this->load->model('book_model');
		$del_result = $this->book_model->book_delete($id);
		if ($del_result) {
			$this->session->set_userdata('del_result','succ');
		}
		else {
			$this->session->set_userdata('del_result','fail');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	

	function get_user($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('user')->result();
		return $query[0];
	}


	function user_modify_validation($id) {
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		$query = $this->get_user($id);

		if ($query->phone != $this->input->post('phone')) {
			$this->form_validation->set_rules('phone', '手机号', 'trim|required');
		}
		if ($query->email != $this->input->post('email')) {
			$this->form_validation->set_rules('email', '邮箱', 'trim|required|valid_email');
		}

		if ($this->input->post('password') != '' || $this->input->post('password_confirm') != '') {
			$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[32]');
			$this->form_validation->set_rules('password_confirm', '确认密码', 'trim|required|matches[password]');
		}

		if ($this->input->post('student_number') != '') 
			$this->form_validation->set_rules('student_number', '学号', 'trim|exact_length[10]|is_numeric');

		if ($this->form_validation->run() == false) {
			return array('status'=>'0','message'=>'修改失败！');
		}
		else {
			if ($this->input->post('password') != '') $arr['password'] = md5($this->input->post('password', true));
			$arr['email'] = htmlspecialchars($this->input->post('email', true));
			$arr['phone'] = htmlspecialchars($this->input->post('phone', true));
			$arr['student_number'] = htmlspecialchars($this->input->post('student_number', true));
			//user_model update
			$this->db->where('id', $id);
			$this->db->update('user', $arr);
			return array('status'=>'1','message'=>'修改成功！');
		}
	}

}