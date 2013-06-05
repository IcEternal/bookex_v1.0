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
		$preset = ($this->uri->segment(3) =='preset');
		if($reset)
		{
			$search_data = array(
			'book_info'  => NULL,
			'uploader'   => NULL,
			'subscriber' => NULL,
			'no_reserve' => 1,
			'reserved'   => 1,
			'traded'     => 1,
			'admin_name' => $this->session->userdata('username')
			);
			$this->db->insert('book_search',$search_data);
		}

		if($preset)
		{
			$uploader = urldecode($this->uri->segment(4));
			$search_data = array(
			'book_info'  => NULL,
			'uploader'   => $uploader,
			'subscriber' => NULL,
			'no_reserve' => 1,
			'reserved'   => 1,
			'traded'     => 1,
			'admin_name' => $this->session->userdata('username')
			);
			$this->db->insert('book_search',$search_data);
		}

		if($this->input->post('submit')) 
		//在post提交 和 reset 情况下，执行下列语句，对搜索内容进行更新，
		//即向数据表最后一行添加搜索内容
		{
			//复选框未勾选，post中no_reserve会不存在，使用$this->input->post(),会返回FALSE
			//如果已勾选，会返回表单中设定值，图书搜索复选框value都设为1
			if($this->input->post('no_reserve') === FALSE)
			{$no_reserve = 0;}else
			{$no_reserve = $this->input->post('no_reserve');}
			if($this->input->post('reserved') === FALSE)
			{$reserved = 0;}else
			{$reserved = $this->input->post('reserved');}
			if($this->input->post('traded') === FALSE)
			{$traded = 0;}else
			{$traded = $this->input->post('traded');}

			if($this->input->post('book_info') === FALSE)
			{$book_info = NULL;}else
			{$book_info = $this->input->post('book_info');}
			if($this->input->post('uploader') === FALSE)
			{$uploader = NULL;}else
			{$uploader = $this->input->post('uploader');}
			if($this->input->post('subscriber') === FALSE)
			{$subscriber = NULL;}else
			{$subscriber = $this->input->post('subscriber');}

			$search_data = array(
			'book_info'  => $book_info,
			'uploader'   => $uploader,
			'subscriber' => $subscriber,
			'no_reserve' => $no_reserve,
			'reserved'   => $reserved,
			'traded'     => $traded,
			'admin_name' => $this->session->userdata('username')
			);
			$this->db->insert('book_search',$search_data);
		}


		//预搜索，找出能有多少个结果
		$this->book_search_condition();
		$pre_query = $this->db->select('id')->from('book')->get();
		$total_rows = $pre_query->num_rows();
		//内容搜索，将所有信息显示，并对结果根据页码进行limit
		$search_data = $this->book_search_condition();
		$query = $this->db->select('book.id,book.use_phone,name,price,originprice,uploader,subscriber,finishtime,a.id AS uploader_id,b.id AS subscriber_id')
		->from('book')->join('user AS a','a.username = book.uploader','left')->join('user AS b','b.username = book.subscriber','left')
		->limit($per_page,$cur_page)->order_by('id','DESC')->get();
		return array($query,$total_rows,$search_data);
	}

	function user_search($cur_page,$per_page)
	{
		$reset = ($this->uri->segment(3) =='index');
		if($reset)
		{
			$search_data = array(
			'username'  => NULL,
			'phone'   => NULL,
			'email' => NULL,
			'student_number' => NULL,
			'order_by_up' => 1,
			'admin_name' => $this->session->userdata('username')
			);
			$this->db->insert('user_search',$search_data);
		}

		if($this->input->post('submit'))
		{
			if($this->input->post('order_by_up') === FALSE)
			{$order_by_up = 0;}else
			{$order_by_up = $this->input->post('order_by_up');}

			if($this->input->post('username') === FALSE)
			{$username = NULL;}else
			{$username = $this->input->post('username');}
			if($this->input->post('phone') === FALSE)
			{$phone = NULL;}else
			{$phone = $this->input->post('phone');}
			if($this->input->post('email') === FALSE)
			{$email = NULL;}else
			{$email = $this->input->post('email');}
			if($this->input->post('student_number') === FALSE)
			{$student_number = NULL;}else
			{$student_number = $this->input->post('student_number');}

			$search_data = array(
			'username'       => $username,
			'phone'          => $phone,
			'email' 		 => $email,
			'student_number' => $student_number,
			'order_by_up' 	 => $order_by_up,
			'admin_name' => $this->session->userdata('username')
			);
			$this->db->insert('user_search',$search_data);
		}

		//预搜索，找出能有多少个结果
		$this->user_search_condition();
		$pre_query = $this->db->select('id')->from('user')->get();
		$total_rows = $pre_query->num_rows();
		//内容搜索，将所有信息显示，并对结果根据页码进行limit
		$search_data = $this->user_search_condition();

		if($search_data['order_by_up'])
		{
			$this->db->order_by('book_num','DESC');
		}
		
		$query = $this->db->select('user.id,user.username,user.phone,user.email,user.student_number,count(book.id) AS book_num')
		->from('user')->join('book','user.username = book.uploader','left')->group_by('user.id')
		->limit($per_page,$cur_page)->order_by('id','DESC')->get();
		return array($query,$total_rows,$search_data);
	}

	function book_search_condition()
	{
		$result = $this->db->order_by('bs_id','DESC')->limit(1)->get('book_search')->result_array();
		$row1 = $result[0];

		$this->db->like('name',$row1['book_info']);
		$this->db->like('uploader',$row1['uploader']);
		$this->db->like('subscriber',$row1['subscriber']);

		if($row1['no_reserve'] == 0)//表示未勾选时，搜索结果不包含未预定的书
		{
			$this->db->where('(subscriber != "N" OR finishtime > 0)');
		}
		if($row1['reserved'] == 0)//表示未勾选时，搜索结果不包含已预定的书
		{
			$this->db->where('(subscriber = "N" OR finishtime > 0)');
		}
		if($row1['traded'] == 0)//表示未勾选时，搜索结果不包含已交易的书
		{
			$this->db->where('finishtime',0);
		}

		return $row1;
	}

	function user_search_condition()
	{
		$result = $this->db->order_by('us_id','DESC')->limit(1)->get('user_search')->result_array();
		$row1 = $result[0];

		$this->db->like('username',$row1['username']);
		$this->db->like('phone',$row1['phone']);
		$this->db->like('email',$row1['email']);
		$this->db->like('student_number',$row1['student_number']);

		return $row1;
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
			if ($this->input->post('show') == 1) {
				$arr['show_phone'] = true;
			}
			else {
				$arr['show_phone'] = false;
			}

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

	function book_delete($id)
	{
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

	function book_trade($id)
	{

		$data = array('finishtime' => date("y-m-d h:i:s"));
		$this->db->where('id',$id);
		$this->db->update('book',$data);
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
