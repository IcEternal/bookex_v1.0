<?php 

class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function username_check() {
		$username = $this->input->post('username');
		$condition = "username = \"$username\" OR email = \"$username\"";
		$this->db->or_where($condition);
		$query = $this->db->get('user');

		return $query->num_rows;
	}

	function password_check() {
		$username = $this->input->post('username');
		$condition = "(username = \"$username\" OR email = \"$username\")";
		$this->db->where($condition);
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('user');
		
		return $query->num_rows;
	}

	function get_username(){
		$username = $this->input->post('username');
		$condition = "(username = \"$username\" OR email = \"$username\")";
		$this->db->where($condition);
		$query = $this->db->get('user')->result();
		
		return $query[0]->username;
	}

	function getIdByUsername($user = "") {
		if ($user == "") {
			$user = $this->session->userdata('username');
		} 
		$query = $this->db->query("select id from user where username = '$user'");
		if ($query->num_rows() == 0) {
			return 0;
		}
		$res = $query->result();
		return $res[0]->id;
	}

	function get_user() {
		$this->db->where('username', $this->session->userdata('username'));
		$query = $this->db->get('user')->result();

		return $query[0];
	}

	function create_user() {
		$new_user_insert_data = array(
			'username' => htmlspecialchars($this->input->post('username', true)),
			'password' => md5($this->input->post('password', true)),
			'phone' => htmlspecialchars($this->input->post('phone', true)),
			'email' => htmlspecialchars($this->input->post('email', true)),
            'student_number' => htmlspecialchars($this->input->post('student_number', true)),
            'dormitory' => htmlspecialchars($this->input->post('dormitory', true)),
            'show_phone' => 1
		);

		$flag = $this->db->insert('user', $new_user_insert_data);
		$username = htmlspecialchars($this->input->post('username', true));
		$this->db->query("UPDATE user SET registertime = now() where username = ?", array($username));
		return $flag;
	}

	function update($username, $arr) {
		$this->db->where('username', $username);
		$this->db->update('user', $arr);
	}

	function get_use_phone() {
		$this->db->where('username', $this->session->userdata('username'));
		$query = $this->db->get('user')->result();
		$arr = $query[0];
		$use_or_not = $arr->show_phone;
		return $use_or_not;
	}


	function update_use_phone($username, $use_or_not) {
		$this->db->where('username', $username);
		$arr = array(
			'show_phone' => $use_or_not
		);
		$this->db->update('user', $arr);
	}

	function is_admin() {
		return ($this->session->userdata('username') == 'zhcpzyjtx');
	}
}
