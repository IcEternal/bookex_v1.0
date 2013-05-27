<?php 
	
class Login extends CI_Controller {

	function index() {
		$data['main_content'] = 'login_form';
		$data['data']['title'] = '登录';
		$this->load->view('includes/template', $data);
	}

	function redirect_to_index() {
		$this->load->view('index');
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
				'username' => $this->input->post('username'),
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
		if ($query_username == 0 || $query == 1) {
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
				$arr["nobook"] = true;
				$this->load->view("index", $arr);
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

		if ($this->form_validation->run() == false) {
			$this->modify();
		}
		else {
			if ($this->input->post('password') != '') $arr['password'] = md5($this->input->post('password', true));
			$arr['email'] = htmlspecialchars($this->input->post('email', true));
			$arr['phone'] = htmlspecialchars($this->input->post('phone', true));
			$arr['student_number'] = htmlspecialchars($this->input->post('student_number', true));
			$this->user_model->update($this->session->userdata('username'), $arr);
			redirect('site/userspace');
		}
	}
}
