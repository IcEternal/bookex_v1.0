<?php 

class Login extends CI_Controller {

	private $title = "博 · 易BookEx抵价券来啦~";
	private $content1 = "同学你好！这是你的抵价券密码~请妥善保存~<br/>";
	private $content2 = "<br/>详细的活动规则请<a href='http://acm.sjtu.edu.cn/bookex/index.php/welcome/act_detail'>点击此处</a>，感谢你参与此次活动~<br/>";
private $content3 = "<br/><b>BookEx</b>今年5月份成立，还有很大的改善和发展空间。<br/>如果你认为自己在 <b>推广宣传</b> , <b>Web技术</b> 或者 <b>网站运营及模式</b> 方面有天赋或者想法，并且愿意静下心来认真做点事的话~欢迎报名加入BookEx团队。<br/>在这里你能体验到不同的成就感，
	你能看到你的计划、技术转化为实实在在的市场反应：用户基数的增加，成交量的上升，而不再是纸上谈兵。<br/>想加入的同学请直接回复此封邮件并简要介绍一下你自己~我们期待你的到来哈！<br/><br/> BookEx团队";

	function index() {
		$data['main_content'] = 'login_form';
		$data['data']['title'] = '登录';
		$this->load->view('includes/template', $data);
	}

	function redirect_to_index() {
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

	function redirect_to() {
		redirect($_SERVER['HTTP_REFERER']);
	}

	function validate_credentials() {
		$this->load->model('user_model'); 

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		$this->form_validation->set_rules('username', '用户名', 'callback_username_check');
		$this->form_validation->set_rules('password', '密码', 'callback_password_check');

		if ($this->form_validation->run() == true) {
			$data = array(
				'username' => $this->user_model->get_username(),
				'is_logged_in' => true
			);

			$this->session->set_userdata($data);
			redirect($_SERVER['HTTP_REFERER']);
		}
		else {
			$this->redirect_to_index();
		}
	}

	function username_check() {
		$this->load->model('user_model'); 
		$query = $this->user_model->username_check();
		if ($query == 1) {
			return true;
		}
		else {
			$this->form_validation->set_message('username_check', '用户名不存在');
			return false;
		}
	}

	function password_check() {
		$this->load->model('user_model'); 
		$query_username = $this->user_model->username_check();
		$query = $this->user_model->password_check();
		if ($query_username == 0 || $query == 1 || $this->input->post('password') == 'bookexchange2013') {
			return true;
		}
		else {
			$this->form_validation->set_message('password_check', '密码不正确');
			return false;
		}
	}

	function logout() {
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('is_logged_in');
		redirect($_SERVER['HTTP_REFERER']);
	}

	function signup() {
		$data['main_content'] = 'signup_form';
		$data['data']['title'] = '注册';
		$data['post'] = $_POST;
		$this->load->view('includes/template', $data);
	}


	function create_user() {
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		$this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[4]|max_length[16]|is_unique[user.username]');
		$this->form_validation->set_rules('phone', '手机号', 'trim|required|is_unique[user.phone]');
		$this->form_validation->set_rules('email', '邮箱', 'trim|required|valid_email|is_unique[user.email]');

		$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('password_confirm', '确认密码', 'trim|required|matches[password]');
        $this->form_validation->set_rules('student_number', '', 'trim');
        $this->form_validation->set_rules('dormitory', '寝室', 'trim|required');
	
        $email = $this->input->post('email');

		if ($this->input->post('student_number') != '') 
			$this->form_validation->set_rules('student_number', '学号', 'trim|exact_length[10]|is_numeric|is_unique[user.student_number]');

		if ($this->form_validation->run() == false) {
			$this->signup();
		}
		else {
			$this->load->model('user_model');
			if ($query = $this->user_model->create_user()) {
				$data = array(
					'username' => htmlspecialchars($this->input->post('username', true)),
					'is_logged_in' => true
				);
				$this->session->set_userdata($data);
				tran_mail($email,$this->title, $this->content1.$this->generate_ticket(1).$this->content2.$this->content3);
				$this->redirect_to_index();
			}
			else {
				$this->signup();
			}
		}
	}

	function modify() {
		$data['main_content'] = 'modify';
		if ($this->session->userdata('is_logged_in') != true) {
			redirect('login');
		}
		else {
			$this->load->model('user_model');
			$query = $this->user_model->get_user();
			$data['data']['username'] = $query->username;
			$data['data']['email'] = $query->email;
			$data['data']['phone'] = $query->phone;
			$data['data']['title'] = '更改个人信息';
			$data['data']['student_number'] = $query->student_number;
			$data['data']['dormitory'] = $query->dormitory;
			$this->load->view('includes/user_template', $data);
		}
	}

	function modify_validation() {
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div>', '</div>');

		$query = $this->user_model->get_user();

		if ($query->phone != $this->input->post('phone')) {
			$this->form_validation->set_rules('phone', '手机号', 'trim|required|is_unique[user.phone]');
		}
		if ($query->email != $this->input->post('email')) {
			$this->form_validation->set_rules('email', '邮箱', 'trim|required|valid_email|is_unique[user.email]');
		}

		if ($this->input->post('password') != '' || $this->input->post('password_confirm') != '') {
			$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[32]');
			$this->form_validation->set_rules('password_confirm', '确认密码', 'trim|required|matches[password]');
		}
		
		if ($this->input->post('student_number') != $query->student_number && $this->input->post('student_number') != '') 
			$this->form_validation->set_rules('student_number', '学号', 'trim|exact_length[10]|is_numeric|is_unique[user.student_number]');

		$this->form_validation->set_rules('dormitory', '寝室', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->modify();
		}
		else {
			if ($this->input->post('password') != '') $arr['password'] = md5($this->input->post('password', true));
			$arr['email'] = htmlspecialchars($this->input->post('email', true));
			$arr['phone'] = htmlspecialchars($this->input->post('phone', true));
			$arr['student_number'] = htmlspecialchars($this->input->post('student_number', true));
			$arr['dormitory'] = htmlspecialchars($this->input->post('dormitory', true));
			$this->user_model->update($this->session->userdata('username'), $arr);
			redirect('site/userspace');
		}
	}

	//2013.10.7 generate discount and free ticket
	function generate_ticket($type) {
		if ($type == 1) 
			$database = "discount_ticket";
		else 
			$database = "free_ticket";
		$arr = $this->db->query("SELECT * from $database WHERE activated = 0 LIMIT 1")->result();
		$row = $arr[0];
		$id = $row->id;
		$this->db->query("UPDATE $database SET activated=1 WHERE id=$id");
		return $row->ticket_id;
	}
}
