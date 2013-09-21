<?php

class Book_upload extends CI_Controller {
	function index() {
		if ($this->session->userdata('is_logged_in') != true) {
			redirect('login');
		}
		$data['main_content'] = 'book_upload';
		$data['data']['title'] = '上传书本';
		$this->load->model('user_model');  
    	$data['use_or_not'] = $this->user_model->get_use_phone();  
		$this->load->view('includes/template', $data);
	}

	function upload_other() {
		if ($this->session->userdata('is_logged_in') != true) {
			redirect('login');
		}
		$data['main_content'] = 'upload_other';
		$data['data']['title'] = '上传其他二手物品或Service';
		$this->load->view('includes/template', $data);
	}

	function do_upload()
	{
		// $result = mysql_query("show table status like 'book'");
		// $id = mysql_result($result, 0, 'Auto_increment');

	 //  $config['upload_path'] = './book_img/';
	 //  $config['allowed_types'] = 'gif|jpg|png';
	 //  $config['max_size'] = '2048';
	 //  $config['file_name'] = "$id.jpg";
	 //  $config['overwrite'] = TRUE;
	  
	 //  $this->load->library('upload', $config);
	 
	 //  if ( ! $this->upload->do_upload())
	 //  {
	 //  	$error = $this->upload->display_errors('<div>', '</div>');
	 //  	if ($error == '<div>You did not select a file to upload.</div>') {
	 //  		return true;
	 //  	}
	 //    $this->form_validation->set_message('do_upload', $error);
	 //    return false;
	 //  } 
	 //  else
	 //  {
	 //   return true;
	 //  }
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

	function upload_validation() {

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		$this->form_validation->set_rules('author', '作者', 'trim');
		$this->form_validation->set_rules('publisher', '出版社', 'trim');
		$this->form_validation->set_rules('isbn', 'ISBN', 'trim');
		$this->form_validation->set_rules('description', '简介', 'trim');

		$this->form_validation->set_rules('bookname', '书本名称', 'trim|required');

		$this->form_validation->set_rules('originprice', '原价', 'trim|required|is_numeric');
		$this->form_validation->set_rules('price', '售价', 'trim|required|is_numeric');
		$this->form_validation->set_rules('class', '图书分类', 'trim|required');

		$this->form_validation->set_rules('userfile', '', 'callback_do_upload');

		if ($this->form_validation->run() == false) {
			$this->index();
		}
		else {
			$this->load->model('book_model');
			if ($query = $this->book_model->add_book()) {
				redirect('book_details/book/'.$query);
			}
			else {
				$this->index();
			}
		}
	}

	function modify($id) {
		$this->auth->uploader($id);
		$data['main_content'] = 'book_modify';
		$this->load->model('book_model');
		$query = $this->book_model->get_book($id);
		if (($this->session->userdata('username') != $query->uploader) && ($this->session->userdata('username') != 'jtxpzyzhc')) {
			redirect('login');
		}
		else if ($query->finishtime != "0000-00-00 00:00:00") {
			redirect('site/userspace/7');
		}
		else {
			$this->load->model('book_model');
			$query = $this->book_model->get_book($id);
			$data['data']['id'] = $id;
			$data['data']['name'] = $query->name;
			$data['data']['author'] = $query->author;
			$data['data']['price'] = $query->price;
			$data['data']['originprice'] = $query->originprice;
			$data['data']['publisher'] = $query->publisher;
			$data['data']['isbn'] = $query->ISBN;
			$data['data']['description'] = str_replace("<br />", "", $query->description);
			$data['data']['class'] = $query->class;
			$data['data']['title'] = '修改书本信息';
			$data['data']['show'] = $query->show_phone;
			$this->load->view('includes/user_template', $data);
		}
	}

	function do_modify()
	{
		// $id = $this->uri->segment(3);

	 //  $config['upload_path'] = './book_img/';
	 //  $config['allowed_types'] = 'gif|jpg|png';
	 //  $config['max_size'] = '2048';
	 //  $config['file_name'] = "$id.jpg";
	 //  $config['overwrite'] = TRUE;
	  
	 //  $this->load->library('upload', $config);
	 
	 //  if ( ! $this->upload->do_upload())
	 //  {
	 //    $error = $this->upload->display_errors('<div>', '</div>');
	 //  	if ($error == '<div>You did not select a file to upload.</div>') {
	 //  		return true;
	 //  	}
	 //    $this->form_validation->set_message('do_modify', $error);
	 //    return false;
	 //  } 
	 //  else
	 //  {
	 //   return true;
	 //  }
		if (($_FILES['userfile']['error'] > 0 && $_FILES['userfile']['error'] < 4) || $_FILES['userfile']['size'] > 1048576) {
			$this->form_validation->set_message('do_modify', '图片上传失败，文件格式必须为jpg,gif,png，大小不得超过1M');
			return false;
		}
		return true;
	}

	function modify_validation($id) {
		$this->auth->uploader($id);
		$this->load->model('book_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		$this->form_validation->set_rules('author', '作者', 'trim');
		$this->form_validation->set_rules('publisher', '出版社', 'trim');
		$this->form_validation->set_rules('isbn', 'ISBN', 'trim');
		$this->form_validation->set_rules('description', '简介', 'trim');

		$this->form_validation->set_rules('bookname', '书本名称', 'trim|required');

		$this->form_validation->set_rules('originprice', '原价', 'trim|required|is_numeric');
		$this->form_validation->set_rules('price', '售价', 'trim|required|is_numeric');
		$this->form_validation->set_rules('class', '图书分类', 'trim|required');

		$this->form_validation->set_rules('userfile', '', 'callback_do_upload');

		if ($this->form_validation->run() == false) {
			$this->modify($id);
		}
		else {

			$arr = array(
				'name' => htmlspecialchars($this->input->post('bookname', true)),
				'author' => htmlspecialchars($this->input->post('author', true)),
				'price' => htmlspecialchars($this->input->post('price', true)),
				'originprice' => htmlspecialchars($this->input->post('originprice', true)),
				'publisher' => htmlspecialchars($this->input->post('publisher', true)),
				'ISBN' => htmlspecialchars($this->input->post('isbn', true)),
				'description' => nl2br(htmlspecialchars($this->input->post('description'), true)),
				'class' => htmlspecialchars($this->input->post('class'), true)

			  );

			$this->load->model('user_model');  
			$username = $this->session->userdata('username');  
			if ($this->input->post('show') == 1) {
				$arr['show_phone'] = true;
				$this->user_model->update_use_phone($username, true); 
			}
			else {
				$arr['show_phone'] = false;
				$this->user_model->update_use_phone($username, false); 
			}

			if ($_FILES['userfile']['error'] == 0) {
				$userfile_data = $_FILES['userfile']['tmp_name'];
				$data = fread(fopen($userfile_data, "r"), filesize($userfile_data));

				$arr['img'] = $data;
				$arr['hasimg'] = true;
			}

			$this->book_model->update($id, $arr);
			redirect('book_details/book/'.$id);

		}
	}

	function book_delete($id) {
		$this->auth->uploader($id);
		$this->load->model('book_model');
		$err = $this->book_model->book_delete($id);
		if ($err) {
			$err = 1;
		}
		else {
			$err = 2;
		}
		redirect("site/userspace/$err");
	}

	function book_finish($id) {
		$this->auth->uploader_or_subscriber($id);
		$this->load->model('book_model');
		$err = $this->book_model->book_finish($id);
		if ($err) {
			$err = 5;
		}
		else {
			$err = 6;
		}
		redirect("site/userspace/$err");
	}

	
	function fast_upload_validation($bc_id) {

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		$this->form_validation->set_rules('author', '作者', 'trim');
		$this->form_validation->set_rules('publisher', '出版社', 'trim');
		$this->form_validation->set_rules('isbn', 'ISBN', 'trim');
		$this->form_validation->set_rules('description', '简介', 'trim');

		$this->form_validation->set_rules('bookname', '书本名称', 'trim|required');

		$this->form_validation->set_rules('originprice', '原价', 'trim|required');
		$this->form_validation->set_rules('price', '售价', 'trim|required|is_numeric');
		$this->form_validation->set_rules('class', '图书分类', 'trim|required');

		if ($this->form_validation->run() == false) {
			$data['bc_id'] = $bc_id;
			$data['main_content'] = 'book_fast_upload';
			$data['data']['title'] = '快速上传书本';
			$this->load->model('user_model');  
    	$data['use_or_not'] = $this->user_model->get_use_phone();  
			$this->load->view('includes/template', $data);
		}
		else {
			$this->load->model('book_model');
			if ($query = $this->book_model->fast_add_book($bc_id)) {
				redirect('book_details/book/'.$query);
			}
			else {
				$data['bc_id'] = $bc_id;
				$data['main_content'] = 'book_fast_upload';
				$data['data']['title'] = '快速上传书本';
				$this->load->model('user_model');  
    		$data['use_or_not'] = $this->user_model->get_use_phone();  
				$this->load->view('includes/template', $data);
			}
		}
	}
	

	function book_select()
	{
		if ($this->session->userdata('is_logged_in') != true) {
			redirect('login');
		}
		$this->load->model('book_model');
		$search_content = htmlspecialchars($this->input->get('book_name'));
		$data['book_list'] = $this->book_model->get_db_q($search_content,5);
		$data['main_content'] = 'book_select';
		if(empty($data['book_list']))
		{
			$data['q_error'] = "无法根据您所提供的信息找到相应书籍";
		}
		$this->load->model('user_model');  
    	$data['use_or_not'] = $this->user_model->get_use_phone();
		$this->load->view('includes/template', $data);
	}

	function book_isbn()
	{
		if ($this->session->userdata('is_logged_in') != true) {
			redirect('login');
		}
		$this->load->model('book_model');
		$search_content = htmlspecialchars($this->input->get('book_isbn'));
		$data['book_info'] = $this->book_model->get_db_isbn($search_content);
		if(isset($data['book_info']['bc_id']))
		{
			$bc_id = $data['book_info']['bc_id'];
			redirect(site_url().'/book_upload/book_fast_upload/'.$bc_id);
		}
		else
		{
			$data['main_content'] = 'book_upload';
			$data['data']['title'] = '上传书本';
			$data['isbn_error'] = "无法根据您所提供的ISBN找到相应书籍";
			$this->load->model('user_model');  
    		$data['use_or_not'] = $this->user_model->get_use_phone();
			$this->load->view('includes/template', $data);
		}
	}

	function book_fast_upload($bc_id)
	{
		if ($this->session->userdata('is_logged_in') != true) {
			redirect('login');
		}
		$result = $this->db->where('bc_id',$bc_id)->get('book_collect')->result();
		$data['book_info'] = $result[0];
		$data['bc_id'] = $bc_id;

		$data['main_content'] = 'book_fast_upload';
		$this->load->model('user_model');  
    	$data['use_or_not'] = $this->user_model->get_use_phone();
		$this->load->view('includes/template', $data);
	}	
}
