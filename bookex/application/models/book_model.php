<?php

class Book_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function is_book_exist($book_id) {
		$this->db->where('id', $book_id);
		$query = $this->db->get('book');
		return $query->num_rows;
	}

	function get_book_infomation($book_id) {
		$this->db->where('id', $book_id);
		$query = $this->db->get('book')->result();
		return $query[0];
	}

	function update_subscriber($book_id, $new_sub) {
		$this->db->where('id', $book_id);
		$arr = array(
			'subscriber' => $new_sub
		);
		$this->db->update('book', $arr);
		$this->db->query("UPDATE book SET subscribetime = now() WHERE id = \"$book_id\"");
	}

	function add_book() {
		$new_book_insert_data = array(
			'name' => htmlspecialchars($this->input->post('bookname', true)),
			'author' => htmlspecialchars($this->input->post('author', true)),
			'price' => htmlspecialchars($this->input->post('price', true)),
			'originprice' => htmlspecialchars($this->input->post('originprice', true)),
			'publisher' => htmlspecialchars($this->input->post('publisher', true)),
			'ISBN' => htmlspecialchars($this->input->post('isbn', true)),
			'description' => nl2br(htmlspecialchars($this->input->post('description'), true)),
			'uploader' => htmlspecialchars($this->input->post('uploader'), true),
			'hasimg' => false
		);
		if ($_FILES['userfile']['error'] == 0) {
			$userfile_data = $_FILES['userfile']['tmp_name'];
			$data = fread(fopen($userfile_data, "r"), filesize($userfile_data));

			$new_book_insert_data['img'] = $data;
			$new_book_insert_data['hasimg'] = true;
		}

		return $this->db->insert('book', $new_book_insert_data); 
	}

	function get_book($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('book')->result();

		return $query[0];
	}

	function update($id, $arr) {
		$this->db->where('id', $id);
		$this->db->update('book', $arr);
	}

	function book_delete($id) {
		$this->db->where('id', $id);
		return $this->db->delete('book');
	}
}
