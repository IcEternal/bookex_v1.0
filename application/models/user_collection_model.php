<?php 

class User_collection_model extends CI_Model {

	var $username;

	function __construct() {
		parent::__construct();
		$this->username = $this->session->userdata('username');
	}

	function condition($book_id) {
		$this->db->where('username', $this->username);
		$this->db->where('book_id', $book_id);
	}

	function settime($book_id, $which) {
		$this->db->query("UPDATE user_collection SET $which = now() WHERE username = \"$this->username\" AND book_id = $book_id");
	}

	function collect($book_id) {
		$this->condition($book_id);
		$query = $this->db->get('user_collection');

		if ($query->num_rows) {
			$this->condition($book_id);
			$arr = array(
				'status' => 1
			);
			$this->db->update('user_collection', $arr);
		}
		else {
			$arr = array(
				'username' => $this->username,
				'book_id' => $book_id,
				'status' => 1
			);
			$this->db->insert('user_collection', $arr);
			$this->settime($book_id, "begintime");
		}
	}

	function cancel_collect($book_id) {
		$this->condition($book_id);
		$query = $this->db->get('user_collection');

		$this->condition($book_id);
		$arr = array(
			'status' => 0
		);
		$this->db->update('user_collection', $arr);
		$this->settime($book_id, "endtime");
	}

	function find($book_id) {
		$this->condition($book_id);
		$query = $this->db->get('user_collection');

		if ($query->num_rows) {
			$rows = $query->result();
			if ($rows[0]->status == 1) 
				return true;
			else 
				return false;
		}
		else return false;
	}
}
