<?php

class Book_upload extends CI_Controller {
	function index() {
		if ($this->session->userdata('is_logged_in') != true) {
			redirect('login');
		}
		$data['main_content'] = 'book_upload';
		$data['data']['title'] = '上传书本';
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
		$this->form_validation->set_rules('price', '售出价格', 'trim|required|is_numeric');

		$this->form_validation->set_rules('userfile', '', 'callback_do_upload');

		if ($this->form_validation->run() == false) {
			$this->index();
		}
		else {
			$this->load->model('book_model');
			if ($query = $this->book_model->add_book()) {
				redirect('site/userspace/3');
			}
			else {
				$this->index();
			}
		}
	}

	function modify($id) {
		$data['main_content'] = 'book_modify';
		$this->load->model('book_model');
		$query = $this->book_model->get_book($id);
		if ($this->session->userdata('username') != $query->uploader) {
			redirect('login');
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
			$data['data']['title'] = '修改书本信息';
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
				'description' => nl2br(htmlspecialchars($this->input->post('description'), true))
			  );

			if ($_FILES['userfile']['error'] == 0) {
				$userfile_data = $_FILES['userfile']['tmp_name'];
				$data = fread(fopen($userfile_data, "r"), filesize($userfile_data));

				$arr['img'] = $data;
				$arr['hasimg'] = true;
			}

			$this->book_model->update($id, $arr);
			redirect('site/userspace/4');
		}
	}

	function book_delete($id) {
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
}
