<?php 

class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function username_check() {
		$this->db->where('username', $this->input->post('username'));
		$query = $this->db->get('user');

		return $query->num_rows;
	}

	function password_check() {
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('user');
		
		return $query->num_rows;
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
			'student_number' => htmlspecialchars($this->input->post('student_number', true))
		);

		return $this->db->insert('user', $new_user_insert_data);
	}

	function update($username, $arr) {
		$this->db->where('username', $username);
		$this->db->update('user', $arr);
	}
}
