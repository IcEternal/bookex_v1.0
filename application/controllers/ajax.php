<?php 
	class Ajax extends CI_Controller {
		function __construct() {
			parent::__construct();
			
		}

		function loginCheck(){
			$this->load->model('user_model');
			if ($this->user_model->username_check() != 1) echo'该用户名不存在';
			else if ($this->user_model->password_check() != 1) echo'密码错误';
			//$this->CI_Controller('login')->validate_credentials();
			//$this->login->validate_credentials();
			else echo'登陆成功';
		}

		function signupCheck(){
			$this->load->model("user_model");
			$username = $this->input->post('username');
			if (strlen($username) < 4 || strlen($username) > 16) echo '用户名长度不合法。';
			else if ($this->user_model->username_check() == 1) echo '该用户名已存在。';
			else {
				$password = $this->input->post('password');
				$confirm = $this->input->post('confirm');
				if (strlen($password) < 6 || strlen($password) > 32) echo '密码长度不合法。';
				else if (strcmp($password, $confirm) != 0) echo '密码输入不符。';
			}
			echo '注册成功。';
		}

		function test(){
			echo "haha";
		}


	}