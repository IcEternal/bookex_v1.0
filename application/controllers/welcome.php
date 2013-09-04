<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data["first"] = false;
		if (1>0) {
			$data["first"] = true;
			$this->load->model('recommend_model');
			$data["recommend"]=$this->recommend_model->getResult();
		}
		$this->load->view('index', $data);
	}

	function about() {
		$data['data']['title'] = '关于';
		$this->load->view('about');
	}

	function contact() {
		$data['data']['title'] = '联系我们';
		$this->load->view('contact');
	}

	function act_detail() {
		$this->load->view('act_detail');
	}

	function prize_user() {
		$this->load->view('prize_user');
	}

	function norespon() {
                $this->load->view("norespon");
        }

}
