<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$first = !isset($this->session->userdata('first'));
		if ($this->useragent->isMobile() && $this->session->userdata('first')) {
			$data = array(
				'first' => true
			);
			$this->session->set_userdata($data);
			$this->load->view('mobile');
		}
		else {
			$data["first"] = false;
			if (!$this->session->userdata('is_logged_in')) {
				$data["first"] = true;
			}
			if (1>0) {
				$this->load->model('recommend_model');
				$data["recommend"]=$this->recommend_model->getResult();
			}
			$this->load->view('index', $data);
		}
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
