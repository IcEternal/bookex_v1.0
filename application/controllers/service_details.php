 <?php

class Service_details extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('service_model');
		$this->load->model('user_collection_model');
	}

	function load_page($book_id, $message, $is_succ) {
		$data['page'] = 'service_details';
		$res = $this->service_model->get_service_infomation($book_id);
		$data['info']['info'] = $res;
		$data['info']['subscribed'] = $this->service_model->getSubscribed($book_id, $this->session->userdata('username'));
		$data['info']['err_mes'] = $message;
		$data['info']['is_succ'] = $is_succ;
		$data['info']['title'] = '详细书本信息';
		$this->load->view('includes/template_book_details', $data);
	}

	function service($book_id) {
		if ($this->service_model->is_service_exist($book_id) <= 0) {
			#book is not exist
			return;
		}
		$this->load_page($book_id, '', true);
	}

	function uploader_cancel($book_id) {
		$this->auth->uploader($book_id);
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
		if ($book_info->status > 1){
			$this->load_page($book_id, '书本已经送出，不能取消订单。', false);
			return;
		}
		$this->book_model->update_subscriber($book_id, 'N');

		$this->load_page($book_id, '成功取消订单！', true);
	}

	function user_cancel($book_id) {
		//$this->auth->subscriber($book_id);
		$this->load->model('service_model');
		if ($this->service_model->is_service_exist($book_id) <= 0) {
			#book is not exist
			return;
		}

		if (!$this->service_model->getSubscribed($book_id)) {
			$this->load_page($book_id, '您还未订购该书', false);
			return;
		}

		$this->service_model->serviceCancel($book_id);
		redirect('site/userspace');	
	}

	function order($book_id) {
		$this->load->model('service_model');
		if ($this->service_model->is_service_exist($book_id) <= 0) {
			#book is not exist
			return;
		}

		$service_info = $this->service_model->get_service_infomation($book_id);
		$user = $this->session->userdata('username');
		$is_logged_in = $this->session->userdata('is_logged_in');

		if ($is_logged_in == true) {

			if ($service_info->remain == 0) {
				$this->load_page($book_id, '该服务已没有库存', false);
				return;
			}
			$this->load->model('user_model');
			$id = $this->user_model->getUserIDByUsername($user);
			$trade_arr = array(
					'buyer_id' => $id,
					'service_id' => $book_id
				);
			$this->db->query("UPDATE service set remain = remain-1 where id = $book_id");
			$this->db->insert('service_trade', $trade_arr);
			$insert_id = $this->db->insert_id();
			$this->db->query("UPDATE service_trade set subscribetime = now() where id = $insert_id");
			$this->load_page($book_id, '订购成功！', true);
		}
		else {
			$this->load_page($book_id, '您还未登入', false);
			return;
		}
	}
}
