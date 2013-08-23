<?php 

class User_collection_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function condition($username, $book_id) {
		$this->db->where('username', $username);
		$this->db->where('book_id', $book_id);
	}

	function settime($username, $book_id, $which) {
		$this->db->query("UPDATE user_collection SET $which = now() WHERE username = \"$username\" AND book_id = $book_id");
	}

	function collect($username, $book_id) {
		$this->condition($username, $book_id);
		$query = $this->db->get('user_collection');

		if ($query->num_rows) {
			$this->condition($username, $book_id);
			$arr = array(
				'status' => 1
			);
			$this->db->update('user_collection', $arr);
		}
		else {
			$arr = array(
				'username' => $username,
				'book_id' => $book_id,
				'status' => 1
			);
			$this->db->insert('user_collection', $arr);
			$this->settime($username, $book_id, "begintime");
		}
	}

	function cancel_collect($username, $book_id) {
		$this->condition($username, $book_id);
		$query = $this->db->get('user_collection');

		$this->condition($username, $book_id);
		$arr = array(
			'status' => 0
		);
		$this->db->update('user_collection', $arr);
		$this->settime($username, $book_id, "endtime");
	}

	function find($username, $book_id) {
		$this->condition($username, $book_id);
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
