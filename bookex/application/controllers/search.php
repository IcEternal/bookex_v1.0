<?php 
	class Search extends CI_Controller {
		
		function index(){
			$this->load->library('form_validation');
			$this->load->model('search_model');

			$data = $this->search_model->getResult();
			$data['data']['title'] = '搜索结果';
			$this->load->view('search_result', $data);
		}

	}
