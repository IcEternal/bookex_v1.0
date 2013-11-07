<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$first = ($this->session->userdata('first') !== true);
		$arr = array('test' => true);
		$this->session->set_userdata($arr);
		$has_cookie = true;
		if ($this->session->userdata('test') != true) {
			$has_cookie = false;
		}
		if (isMobile() && $first && $has_cookie) {
			$data = array(
				'first' => true
			);
			$this->session->set_userdata($data);
			$this->load->view('mobile');
		}
		else {
			$data['no_recommend'] = isMobile();
			if (!$this->session->userdata('is_logged_in')) {
				$data["first"] = true;
			}
			if (1>0) {
				$this->load->model('recommend_model');
				$data["recommend"]=$this->recommend_model->getResult();
			}
			$this->db->where('finishtime > 0 AND subscriber != "N"');
			$arr = $this->db->get('book')->result();
			$tot = 0;
			$save = 0;
			foreach ($arr as $row) {
				$tot += 1;
				$save += $row->originprice - $row->price;
			}
			$this->db->where('del != true AND finishtime = 0 AND subscriber = "N"');
			$arr = $this->db->select('COUNT(*) AS total_rows')->get('book')->result();
			$row = $arr[0];
			$data['tot_book'] = $row->total_rows;
			$data['tot'] = $tot;
			$data['save'] = $save;
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

	function act_double11() {
		$this->load->view('act_double11');
	}

	function prize_user() {
		$this->load->view('prize_user');
	}

	function norespon() {
        $this->load->view("norespon");
    }

    function tips_for_internet_connection() {
        $this->load->view("tips_for_internet_connection");
    }

    function chrome_connection() {
        $this->load->view("chrome_connection");
    }

    function ie_connection() {
        $this->load->view("ie_connection");
    }

    function firefox_connection() {
        $this->load->view("firefox_connection");
    }

}
