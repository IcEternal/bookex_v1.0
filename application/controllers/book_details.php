 <?php

class Book_details extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('book_model');
		$this->load->model('user_model');
		$this->load->model('user_collection_model');
	}

	function getSubscriber($book_id) {
		if ($this->book_model->isService($book_id)) {
			$tradeId = $this->book_model->findUnfinishedServiceTradeId($book_id);
			if ($tradeId != 0) 
				return $this->session->userdata('username');
			return "N";
		}
		else {
			$res = $this->book_model->get_book_infomation($book_id);
			return $res->subscriber;
		}
	}

	function load_page($book_id, $message, $is_succ) {
		$data['page'] = 'book_details';
		$res = $this->book_model->get_book_infomation($book_id);

		$userId = $this->user_model->getIdByUsername();
		if ($userId == 0) 
			$data['info']['never_show_activity'] = 0;
		else {
			$data['info']['never_show_activity'] = $this->user_model->get_user()->never_show_activity;
		}
		$data['info']['info'] = $res;
		$data['info']['sub'] = $this->getSubscriber($book_id);
		$data['info']['err_mes'] = $message;
		$data['info']['is_succ'] = $is_succ;
		$data['info']['title'] = '详细书本信息';
		$data['info']['phone'] = $this->book_model->get_phone_by_book_id($res->id);
		$data['info']['collect'] = $this->user_collection_model->find($book_id);
		$data['info']['mustphone'] = isOfSecondHand($res->class) || isOfService($res->class) || isOfActivity($res->class);
		if ($res->use_phone == 1) {
			$this->load->model('search_model');
			$data['info']['user_phone'] = $this->search_model->getUserPhone($res->subscriber);
		}
		$this->load->view('includes/template_book_details', $data);
	}

	function book($book_id) {
		if ($this->book_model->is_book_exist($book_id) <= 0) {
			#book is not exist
			return;
		}
		$username = "N";
		if ($this->session->userdata("is_logged_in")) $username = $this->session->userdata("username");
		$this->book_model->record_id($book_id, $username);
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
		$this->auth->subscriber($book_id);
		$this->load->model('book_model');
		if ($this->book_model->is_book_exist($book_id) <= 0) {
			#book is not exist
			return;
		}
		$book_info = $this->book_model->get_book_infomation($book_id);
		$user = strtolower($this->session->userdata('username'));

		if ($user != $this->getSubscriber($book_id)) {
			$this->load_page($book_id, '您还未订购该书', false);
			return;
		}
		if ($book_info->status > 1){
			$this->load_page($book_id, '书本已经送出，不能取消订单。', false);
			return;
		}
		if ($book_info->finishtime != 0) {
			$this->load_page($book_id, '该书已交易', false);
			return;
		}

		$this->book_model->update_subscriber($book_id, 'N');
		redirect('site/userspace');	
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

			if ($book_info->finishtime != 0) {
				$this->load_page($book_id, '该书已交易', false);
				return;
			}

			$this->book_model->update_subscriber($book_id, $user);
			$this->load_page($book_id, '订购成功！工作人员从卖家拿到书后会与您联系', true);
		}
		else {
			$this->load_page($book_id, '您还未登入', false);
			return;
		}
	}

	function use_phone($book_id) {
		$this->auth->subscriber($book_id);
		$this->load->model('book_model');
		$this->book_model->use_phone($book_id);
		$this->load_page($book_id, '订购成功！手机号已在图片下方显示。', true);
	}

	function user_collect($book_id) {
		$this->load->model('user_collection_model');
		$this->user_collection_model->collect($book_id);
		redirect("book_details/book/$book_id");
	}

	function user_cancel_collect($book_id) {
		$this->load->model('user_collection_model');
		$this->user_collection_model->cancel_collect($book_id);
		redirect($_SERVER["HTTP_REFERER"]); 
	}

	//use ticket function
	function use_discount_ticket(){
		$ticket = $this->input->get("ticket");
		$book_id = $this->input->get("book_id");
		$this->load->model('book_model');
		echo $this->book_model->check_discount_ticket($book_id, $ticket);
	}

	function use_free_ticket(){
		$ticket = $this->input->get("ticket");
		$book_id = $this->input->get("book_id");
		$this->load->model('book_model');
		echo $this->book_model->check_free_ticket($book_id, $ticket);
	}
}
