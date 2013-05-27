<?php

class Book_details extends CI_Controller {

	function load_page($book_id, $message, $is_succ) {
		$data['page'] = 'book_details';
		$res = $this->book_model->get_book_infomation($book_id);
		$data['info']['info'] = $res;
		$data['info']['err_mes'] = $message;
		$data['info']['is_succ'] = $is_succ;
		$data['info']['title'] = '详细书本信息';
		$data['info']['rr_share'] = $this->book_model->rr_share('BookEx交大校内二手书交易网','图书名:  '.$res->name.';     作者:  '.$res->author.';     原价:  '.$res->originprice.'元;     现在只要 '.$res->price.'元 哦！',base_url('get_data.php?id='.$book_id),'pull-right');
		$this->load->view('includes/template_book_details', $data);
	}

	function book($book_id) {
		$this->load->model('book_model');
		if ($this->book_model->is_book_exist($book_id) <= 0) {
			#book is not exist
			return;
		}
		$this->load_page($book_id, '', true);
	}

	function uploader_cancel($book_id) {

		$this->load->model('book_model');
		if ($this->book_model->is_book_exist($book_id) <= 0) {
			#book is not exist
			return;
		}

		$book_info = $this->book_model->get_book_infomation($book_id);
		$user = $this->session->userdata('username');

		if ($user != $book_info->uploader) {
			$this->load_page($book_id, '您不是本书的上传者', false);
			return;
		}

		$this->book_model->update_subscriber($book_id, 'N');

		$this->load_page($book_id, '成功取消订单！', true);
	}

	function user_cancel($book_id) {
		$this->load->model('book_model');
		if ($this->book_model->is_book_exist($book_id) <= 0) {
			#book is not exist
			return;
		}
		$book_info = $this->book_model->get_book_infomation($book_id);
		$user = $this->session->userdata('username');

		if ($user != $book_info->subscriber) {
			$this->load_page($book_id, '您还未订购该书', false);
			return;
		}

		$this->book_model->update_subscriber($book_id, 'N');
		$this->load_page($book_id, '成功取消订单！', true);
	}

	function order($book_id) {
		$this->load->model('book_model');
		if ($this->book_model->is_book_exist($book_id) <= 0) {
			#book is not exist
			return;
		}

		$book_info = $this->book_model->get_book_infomation($book_id);
		$user = $this->session->userdata('username');
		$is_logged_in = $this->session->userdata('is_logged_in');

		if ($is_logged_in == true) {
			if ($book_info->subscriber != 'N') {
				$this->load_page($book_id, '该书已被订购', false);
				return;
			}

			$this->book_model->update_subscriber($book_id, $user);
			$this->load_page($book_id, '订购成功！工作人员将于1天内于您联系', true);
		}
		else {
			$this->load_page($book_id, '您还未登入', false);
			return;
		}
	}
}
