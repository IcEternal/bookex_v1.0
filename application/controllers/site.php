<?php 

class Site extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->is_logged_in();
	}

	function userspace($err = 0) {
		$this->load->model('search_model');
		$this->load->model('book_model');
		$this->load->helper('text');
		$data = $this->search_model->getUserspaceResult($err);
		$data['data']['title'] = '用户空间';
		$this->load->view('userspace', $data);
	}

	function user_collection() {
		$this->load->model('search_model');
		$this->load->model('book_model');
		$this->load->helper('text');
		$data = $this->search_model->getUserCollection();
		$data['data']['title'] = '收藏夹';
		$data['user'] = $this->session->userdata('username');
		$this->load->view('user_collection', $data);
	}

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');

		if (!isset($is_logged_in) || $is_logged_in != true) {
			redirect('login');
		}
	}

}
