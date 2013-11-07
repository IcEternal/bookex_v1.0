<?php

class Admin_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function class_search($data,$offset,$limit)
	{
		$this->class_search_condition($data);
		$result = $this->db->select('COUNT(*) AS total_rows')->get('book')->result();
		$row1 = $result[0];
		$total_rows = $row1->total_rows;

		$this->class_search_condition($data);
		$book_result = $this->db->select('id,name,uploader,class')
		->limit($limit,$offset)->order_by('id','DESC')->get('book')->result();

		return array($total_rows,$book_result);
	}

	function class_search_condition($data)
	{
		$this->db->like('name',$data['book_name']);
		$this->db->like('class',$data['class_name']);
		$this->db->where('del !=',TRUE);


		switch ($data['class_status']) {
			case 1:
				$this->db->where('class !=','');
				break;
			case 2:
				$this->db->where('class','');
				break;
			default:
				break;
		}
	}

	function book_search($data,$offset,$limit)
	{

		//预搜索，找出能有多少个结果
		$this->book_search_condition($data);
		$pre_query = $this->db->select('id')->from('book')->get();
		$total_rows = $pre_query->num_rows();
		//内容搜索，将所有信息显示，并对结果根据页码进行limit
		$this->book_search_condition($data);
		$book_result = $this->db->select('book.id,book.use_phone,class,name,price,originprice,uploader,subscriber,finishtime,del,book.has AS hasit,a.id AS uploader_id,b.id AS subscriber_id')
		->from('book')->join('user AS a','a.username = book.uploader','left')->join('user AS b','b.username = book.subscriber','left')
		->limit($limit,$offset)->order_by('id','DESC')->get()->result();

		return array($total_rows,$book_result);
	}

	function book_search_condition($data)
	{
		$this->db->like('name',$data['book_name']);
		$this->db->like('uploader',$data['uploader']);
		$this->db->like('subscriber',$data['subscriber']);
		//url参数中有del时，找出被删除的书籍
		if($data['del'] == 0)
		{
			$this->db->where('del !=',TRUE);
		}
		else
		{
			$this->db->where('del',TRUE);
			$this->db->order_by('deltime', 'DESC');
		}
		//只显示自行交易的书
		if($data['self'])
		{
			$this->db->where('use_phone',1);
		}

		if($data['no_reserve'] == 0)//表示未勾选时，搜索结果不包含未预定的书
		{
			$this->db->where('(subscriber != "N" OR finishtime > 0)');
		}
		if($data['reserved'] == 0)//表示未勾选时，搜索结果不包含已预定的书
		{
			$this->db->where('(subscriber = "N" OR finishtime > 0)');
		}
		if($data['traded'] == 0)//表示未勾选时，搜索结果不包含已交易的书
		{
			$this->db->where('finishtime',0);
		}
		if ($data['no_reserve'] == 0 && $data['reserved'] == 0) {
			$this->db->order_by('finishtime', 'DESC');
		}
		if ($data['no_reserve'] == 0 && $data['traded'] == 0) {
			$this->db->order_by('subscribetime', 'DESC');
		}
	}

	function user_search($data,$offset,$limit)
	{
		//预搜索，找出能有多少个结果
		$this->user_search_condition($data);
		$pre_query = $this->db->select('id')->from('user')->get();
		$total_rows = $pre_query->num_rows();
		//内容搜索，将所有信息显示，并对结果根据页码进行limit
		$this->user_search_condition($data);
		if($data['order_by_up'])
		{
			$this->db->order_by('up_num','DESC');
		}
		$user_result = $this->db->select('user.id,user.username,user.phone,user.email,user.student_number,count(book.id) AS up_num')
		->from('user')->join('book','user.username = book.uploader AND book.del != true','left')->group_by('user.id')
		->limit($limit,$offset)->order_by('id','DESC')->get()->result();
		return array($total_rows,$user_result);
	}

	function user_search_condition($data)
	{
		$this->db->like('username',$data['username']);
		$this->db->like('phone',$data['phone']);
		$this->db->like('email',$data['email']);
		$this->db->like('student_number',$data['stu_num']);
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

	function book_hasit($id)
	{
		$this->load->model('book_model');
		$data = array('has'=>'1');
		$this->db->where('id', $id);
		$this->db->update('book',$data);
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
			$arr['dormitory'] = htmlspecialchars($this->input->post('dormitory', true));
			$arr['remarks'] = htmlspecialchars($this->input->post('remarks', true));
			//user_model update
			$this->db->where('id', $id);
			$this->db->update('user', $arr);
			return array('status'=>'1','message'=>'修改成功！');
		}
	}

	//Auto-generating statistic
	function getStatistic($days){
		
	}
	
	function service_search($data,$offset,$limit)
	{
		//预搜索，找出能有多少个结果
		$condition_str = $this->service_search_condition($data);
		$condition_str = ($condition_str=='')?'1':substr($condition_str,3);
		$search_str = "SELECT * FROM service_search WHERE ".$condition_str;
		$pre_query = $this->db->query($search_str);
		$total_rows = $pre_query->num_rows();
		//内容搜索，将所有信息显示，并对结果根据页码进行limit
		$search_str .= " ORDER BY id DESC LIMIT $offset ,$limit ";
		$search_query = $this->db->query($search_str);
		$search_result = $search_query->result();
		return array($total_rows,$search_result);
	}

	function service_search_condition($data)
	{
		$condition_str = NULL;
		if($data['service_name'] != NULL)
		{
			$service_name = $data['service_name'];
			$condition_str .= "AND name LIKE '%$service_name%'";
		}

		if($data['seller'] != NULL)
		{
			$seller = $data['seller'];
			$condition_str .= "AND seller LIKE '%$seller%'";
		}

		if($data['buyer'] != NULL)
		{
			$buyer = $data['buyer'];
			$condition_str .= "AND buyer LIKE '%$buyer%'";
		}

		//1 - 正在进行，未取消或完成
		//2 - 已取消
		//3 - 已完成
		switch ($data['status']) {
			case '1':
			{
				$condition_str .= "AND canceled = 0 AND finishtime = 0";
				break;
			}
			case '2':
			{
				$condition_str .= "AND canceled = 1";
				break;
			}
			case '3':
			{
				$condition_str .= "AND canceled = 0 AND finishtime > 0";
				break;
			}
			default:
			{
				$condition_str .= NULL;
				break;
			}
		}
		return $condition_str;
	}


}
