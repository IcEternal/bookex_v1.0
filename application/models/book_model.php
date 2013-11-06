<?php

class Book_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
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

	function isService($id) {
		$result = $this->db->select('*')->from("book")->where('id', $id)->get()->result();
		if (isOfService($result[0]->class)) return true;
		return false;
	}

	function findUnfinishedServiceTradeId($serviceId) {
		$user_id = $this->user_model->getIdByUsername();
		$query = $this->db->query("select * from service_trade where buyer_id = $user_id and service_id = $serviceId and finishtime = 0");
		if ($query->num_rows() == 0) 
			return 0;
		else 
			$res = $query->result();
			return $res[0]->id;
	}


	function addServiceRecord($serviceId, $newSub) {
		$tradeId = $this->findUnfinishedServiceTradeId($serviceId);
		if ($newSub == 'N') {
			$this->db->query("UPDATE service_trade SET finishtime = now() where id = $tradeId");
			$this->db->query("UPDATE service_trade SET canceled = 1 where id = $tradeId");
		}
		else {
			if ($tradeId != 0) return;
			$userId = $this->user_model->getIdByUsername();
			$this->db->query("INSERT INTO service_trade(service_id, buyer_id, subscribetime) values ($serviceId, $userId, now())");
		}
	}

	function update_subscriber($book_id, $new_sub) {
		$result = $this->db->select('*')->from("book")->where('id', $book_id)->get()->result();
		if ($this->isService($book_id)) {
			$this->addServiceRecord($book_id, $new_sub);
		}
		else {
			$old_sub = $result[0]->subscriber;
			if ($result[0]->discounted == 1 || $result[0]->freed == 1){
				$this->db->query("UPDATE user SET used_ticket = used_ticket - 1 WHERE username = \"$old_sub\";");
			}
			$arr = array(
				'subscriber' => $new_sub
			);
			if ($new_sub == 'N') {
				$arr['use_phone'] = false;
				$arr['discounted'] = 0;
				$arr['freed'] = 0;
			}
			$this->db->where('id', $book_id);
			$this->db->update('book', $arr);
			$this->db->query("UPDATE book SET subscribetime = now(), status = 0 WHERE id = \"$book_id\"");
		}

		//delivery system
		/*
		$this->load->model('delivery_model','delivery');
		if($new_sub == 'N')
		{
			$query_submit = $this->db->query("SELECT * FROM delegation_list 
				WHERE book_id = $book_id ORDER BY create_time DESC");
			$row = $query_submit->first_row();
			$submit_id = $row->id;
			$this->delivery->user_cancel($submit_id);
		}
		else
		{
			$book_query = $this->db->query("SELECT * FROM book WHERE id = $book_id");
			$row = $book_query->first_row();
			$uploader = $row->uploader;
			$seller_id = $this->delivery->get_userid_from_username($uploader);
			$buyer_id = $this->delivery->get_userid_from_username($new_sub);
			$this->delivery->create_submit($buyer_id,$seller_id,$book_id);
		}
		*/
	}

	function use_phone($book_id) {
		$this->db->where('id', $book_id);
		$arr = array(
			'use_phone' => true
		);
		$this->db->update('book', $arr);

		//delivery system
		//use phone mean the delegation is canceled
		/*
		$this->load->model('delivery_model','delivery');
		$query_submit = $this->db->query("SELECT * FROM delegation_list 
				WHERE book_id = $book_id ORDER BY create_time DESC");
		$row = $query_submit->first_row();
		$submit_id = $row->id;
		$this->delivery->user_cancel($submit_id);
		*/
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
			'hasimg' => false,
			'class' => htmlspecialchars($this->input->post('class'), true)
		);

		$this->load->model('user_model');  
    	$username = $this->session->userdata('username'); 
		if ($this->input->post('show') == 1) {
			$new_book_insert_data['show_phone'] = true;
			$this->user_model->update_use_phone($username, true); 
		}
		else {
			$new_book_insert_data['show_phone'] = false;
			$this->user_model->update_use_phone($username, false); 
		}
		if ($_FILES['userfile']['error'] == 0) {
			$userfile_data = $_FILES['userfile']['tmp_name'];
			$data = fread(fopen($userfile_data, "r"), filesize($userfile_data));

			$new_book_insert_data['img'] = $data;
			$new_book_insert_data['hasimg'] = true;
		}

		$flag = $this->db->insert('book', $new_book_insert_data); 
		if ($flag) 
			return mysql_insert_id();
		else 
			return 0;
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
		$this->db->where('id', $id)->where('subscriber', 'N');
		$this->db->query("UPDATE book SET deltime = now() WHERE (id = \"$id\" and subscriber=\"N\")");
		$arr = array('del' => true);
		return $this->db->update('book', $arr);
	}

	function book_finish($id) {
		if ($this->isService($id)) {
			$tradeId = $this->findUnfinishedServiceTradeId($id);
			if ($tradeId == 0) 
				return 0;
			else {
				return $this->db->query("UPDATE service_trade SET finishtime = now() WHERE id = $tradeId");
			}
		}
		else 
			return $this->db->query("UPDATE book SET finishtime = now() WHERE id = \"$id\"");
	}

	
  function rr_share($title,$description,$pic_url,$class="",$img="",$message="我在BookEx交大校内二手书交易网出售一本书哦，大家快来看看吧！")
	{
		$url = urlencode('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$params['url']=$url;
		$params['title']=$title;
		$params['description']=$description;
		$params['pic_url']=$pic_url;
		$params['message']=$message;
		$params_url = http_build_query($params);
		return '<a class="'.$class.'" target="_blank" href="http://widget.renren.com/dialog/share?'.$params_url.'"><img src="http://xnimg.cn/xnapp/share/img/v/180_24.png" alt="分享到人人"></a>';
	}

	
	function fast_add_book($bc_id) {
		$result = $this->db->select('img')->from('book_collect')->where('bc_id',$bc_id)->get()->result();
		$row1 = $result[0];
		$img = $row1->img;
		$new_book_insert_data = array(
			'name' => htmlspecialchars($this->input->post('bookname', true)),
			'author' => htmlspecialchars($this->input->post('author', true)),
			'price' => htmlspecialchars($this->input->post('price', true)),
			'originprice' => htmlspecialchars($this->input->post('originprice', true)),
			'publisher' => htmlspecialchars($this->input->post('publisher', true)),
			'ISBN' => htmlspecialchars($this->input->post('isbn', true)),
			'description' => nl2br(htmlspecialchars($this->input->post('description'), true)),
			'uploader' => htmlspecialchars($this->input->post('uploader'), true),
			'class' => htmlspecialchars($this->input->post('class'), true),
		);
		$this->load->model('user_model');  
    	$username = $this->session->userdata('username'); 
		if ($this->input->post('show') == 1) {
			$new_book_insert_data['show_phone'] = true;
			$this->user_model->update_use_phone($username, true); 
		}
		else {
			$new_book_insert_data['show_phone'] = false;
			$this->user_model->update_use_phone($username, false); 
		}
		if (strlen($img) >= 1500) {
			$new_book_insert_data['img'] = $img;
			$new_book_insert_data['hasimg'] = TRUE;
		}
		else {
			$new_book_insert_data['hasimg'] = FALSE;
		}

		$flag = $this->db->insert('book', $new_book_insert_data); 
		if ($flag) 
			return mysql_insert_id();
		else 
			return 0;
	}

	
	//参数：图书名称,最多返回多少条记录
	//返回：豆瓣查询该图书名称的结果数组
	// array(
	//    0=>array(title=>value,self=>value,alternate=>value...)
	//    1=>array(title=>value,self=>value,alternate=>value...)
	//    ...)
	function get_db_q($book_name,$num)
	{
		$book_array = array();
		$db_namespace = 'http://www.douban.com/xmlns/';

		$book_name = urlencode($book_name);
		$xml_url = "http://api.douban.com/book/subjects?q=$book_name&start-index=1&max-results=$num";
		if($xml = @simplexml_load_file($xml_url))
		{
			foreach ($xml->entry as $book) {
				$book_info = array();
				$book_info['title'] = $book->title;
				//获取link中的属性
				//转化为数组，名称为self,alternate,image,mobile
				foreach ($book->link as $value) {
					$ref = $value->attributes()->rel;
					$href = $value->attributes()->href;
					$book_info["$ref"] = $href;
				}
				// $book_info['img_url'] = $book->link[2]['href'];//如果知道图片url在xml中的位置，这个可以直接获取
				$db = $book->children($db_namespace);
				//获取豆瓣命名空间中的属性和值
				//转化为数组，名称为isbn10,isbn13,author,pirce,publisher,pubdate
				foreach ($db as $value) {

					$name = $value->attributes()->name;
					if(array_key_exists("$name",$book_info))
					{
						$book_info["$name"] .= ' | '.$value;
					}
					else
					{
						$book_info["$name"] = $value;
					}
					
				}
				//设置个大图
				$book_info["lpic"] = str_replace('spic', 'lpic', $book_info['image']);
				if(isset($book_info['isbn13']))
				{
					$book_info["bc_id"] = $this->collect_book_info($book_info);
					array_push($book_array, $book_info);
				}
			}
		}
		return $book_array;
	}

	//参数：isbn，豆瓣支持10或13位isbn，并且能识别带'-'的isbn
	//返回：豆瓣查询改isbn的图书信息数组
	// array(title=>value,self=>value,alternate=>value...)
	function get_db_isbn($isbn)
	{
		$db_namespace = 'http://www.douban.com/xmlns/';
		$xml_url = "http://api.douban.com/book/subject/isbn/$isbn";
		$book_info = array();
		if($book = @simplexml_load_file($xml_url))
		{
			simplexml_load_file($xml_url);
			//$book_info['title'] = $book->title;
			//获取link中的属性
			//转化为数组，名称为self,alternate,image,mobile
			foreach ($book->link as $value) {
				$ref = $value->attributes()->rel;
				$href = $value->attributes()->href;
				$book_info["$ref"] = $href;
			}
			// $book_info['img_url'] = $book->link[2]['href'];//如果知道图片url在xml中的位置，这个可以直接获取
			$db = $book->children($db_namespace);
			//获取豆瓣命名空间中的属性和值
			//转化为数组，名称为isbn10,isbn13,author,pirce,publisher,pubdate
			foreach ($db as $value) {
				$name = $value->attributes()->name;
				if(array_key_exists("$name",$book_info))
				{
					$book_info["$name"] .= ' | '.$value;
				}
				else
				{
					$book_info["$name"] = $value;
				}
			}
			//设置个大图
			$book_info["lpic"] = str_replace('spic', 'lpic', $book_info['image']);
			$book_info["bc_id"] = $this->collect_book_info($book_info);
		}
		return $book_info;
	}

	//参数：一本书的信息
	function collect_book_info($book_info)
	{
		$query = $this->db->select('bc_id')->from('book_collect')->where('ISBN',$book_info['isbn13'])->get();
		if($query->num_rows())
		{
			$result = $query->result();
			$row1 = $result[0];
			if (empty($row1->img))
				return $row1->bc_id;
		}
		$pic_url = $book_info['lpic'];
		ob_start(); 
		readfile($pic_url); 
		$img = ob_get_contents(); 
		ob_end_clean();

		$title = isset($book_info['title'])?$book_info['title']:NULL; 
		$author = isset($book_info['author'])?$book_info['author']:NULL; 
		$translator = isset($book_info['translator'])?$book_info['translator']:NULL; 
		$price = isset($book_info['price'])?$book_info['price']:NULL; 
		$publisher = isset($book_info['publisher'])?$book_info['publisher']:NULL; 
		$pubdate = isset($book_info['pubdate'])?$book_info['pubdate']:NULL; 
		$isbn13 = isset($book_info['isbn13'])?$book_info['isbn13']:NULL; 
		
		$book_data = array(
		'title' => "$title", 
		'author' => "$author", 
		'translator' => "$translator",
		'price' => "$price",  
		'publisher' => "$publisher", 
		'pubdate' => "$pubdate", 
		'ISBN' => "$isbn13", 
		);

		if (strlen($img) > 1500) {
			$book_data['img'] = $img;
		}

		$this->db->insert('book_collect',$book_data);
		if($this->db->affected_rows()==1)
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}

	function get_uploader_by_id($id) {
		$query = $this->db->select('uploader')->from('book')->where('id', $id)->get()->result();
		$row = $query[0];
		return $row->uploader;
	}

	function get_subscriber_by_id($id) {
		$query = $this->db->select('subscriber')->from('book')->where('id', $id)->get()->result();
		$row = $query[0];
		return $row->subscriber;
	}

	function get_phone_by_book_id($id) {
		$uploader = $this->get_uploader_by_id($id);
		$query = $this->db->select('phone')->where('username', $uploader)->from('user')->get()->result();
		$row = $query[0];
		$phone = $row->phone;
		return $phone;
	}

	function is_uploader($book_id) {
		if (strtolower($this->session->userdata('username')) == strtolower($this->get_uploader_by_id($book_id))) return true;
		return false;
	}

	function is_subscriber($book_id) {
		if ($this->isService($book_id)) {
			$tradeId = $this->findUnfinishedServiceTradeId($book_id);
			return ($tradeId != 0);
		}
		if (strtolower($this->session->userdata('username')) == strtolower($this->get_subscriber_by_id($book_id))) return true;
		return false;
	}

	//Record when someone see the view of a book.
	function record_id($book_id, $username){
		$this->db->query("INSERT INTO book_view (bookid, viewer, viewtime) VALUES (\"$book_id\", \"$username\", now());");
	}

	//Change the status of a book.	
	function status_update($id, $status){
		$this->db->query("UPDATE book SET status = $status WHERE id = $id;");
		if ($status == 4) $this->db->query("UPDATE book SET finishtime = now() WHERE id = $id;");
		if ($status == 5) $this->db->query("UPDATE book SET finishtime = 0 WHERE id = $id;");
		return $this->get_status_string($id);
	}

	function operator_update($id, $op) {
		if ($op == 'rec') 
			$str = 'receiver';
		else 
			$str = 'sender'; 
		$username = $this->session->userdata('username');
		$this->db->query("UPDATE book SET $str = '$username' WHERE id = $id");
	}


	function get_result($id){
		return $this->db->select('*')->from('book')->where('id', $id)->get()->result();
	}

	function get_status_string($id){
		$result = $this->get_result($id);
		if (!array_key_exists(0, $result)) return "失败";
		$status = $result[0]->status;
		$current_user = $this->session->userdata("username");
		if ($status == 0) return "未取书";
		elseif ($status == 1) {
			if ($current_user != $result[0]->receiver) return $result[0]->receiver."正在取书";
			return $result[0]->receiver."正在取书.";
		}
		elseif ($status == 2) return $result[0]->receiver."送到易班";
		elseif ($status == 3) {
			if ($current_user != $result[0]->sender) return $result[0]->sender."正在送书";
			return $result[0]->sender."正在送书.";
		}
		elseif ($status == 4) return $result[0]->sender."交易成功";
		elseif ($status == 5) return $result[0]->receiver."书本卖家找不到";
	}

	function next_operation($id){
		if (!$this->session->userdata('is_logged_in')) return "失败";
		$username = $this->session->userdata('username');
		$result = $this->get_result($id);
		if (!array_key_exists(0, $result)) return "失败";
		$status = $result[0]->status;
		if ($status == 0){
			$this->db->query("UPDATE book SET receiver = \"$username\" WHERE id = $id;");
			return $this->status_update($id, $status + 1);

		}
		elseif ($status == 1){
			if ($username != $result[0]->receiver) return "失败, ".$this->get_status_string($id);
			return $this->status_update($id, $status + 1);
		}
		elseif ($status == 2){
			$this->db->query("UPDATE book SET sender = \"$username\" WHERE id = $id;");
			return $this->status_update($id, $status + 1);
		}
		/*else if ($status == 3){
			if ($username != $result[0]->sender) return "失败, ".$this->get_status_string($id);
			return $this->status_update($id, $status + 1);
		}*/
		return "失败, ".$this->get_status_string($id);
	}

	function prev_operation($id){
		if (!$this->session->userdata('is_logged_in')) return "失败";
		$username = $this->session->userdata('username');
		$result = $this->get_result($id);
		if (!array_key_exists(0, $result)) return "失败";
		$status = $result[0]->status;
		if ($status == 1){
			if ($username != $result[0]->receiver) return "失败, ".$this->get_status_string($id);
			return $this->status_update($id, $status - 1);
		}
		elseif ($status == 2){
			if ($username != $result[0]->receiver) return "失败, ".$this->get_status_string($id);
			return $this->status_update($id, $status - 1);
		}
		else if ($status == 3){
			if ($username != $result[0]->sender) return "失败, ".$this->get_status_string($id);
			return $this->status_update($id, $status - 1);
		}
		else if ($status == 5) {
			$this->operator_update($id, 'rec');
			return $this->status_update($id, 2);
		}
		return "失败, ".$this->get_status_string($id);
	}

	function deal_done($id){
		if (!$this->session->userdata('is_logged_in')) return "失败";
		$username = $this->session->userdata('username');
		$result = $this->get_result($id);
		if (!array_key_exists(0, $result)) return "失败";
		$status = $result[0]->status;
		$this->operator_update($id, 'sen');
		return $this->status_update($id, 4);
	}

	function book_deleted($id){
		if (!$this->session->userdata('is_logged_in')) return "失败";
		$username = $this->session->userdata('username');
		$result = $this->get_result($id);
		if (!array_key_exists(0, $result)) return "失败";
		$status = $result[0]->status;
		$this->operator_update($id, 'rec');
		return $this->status_update($id, 5);
	}

	function deal_canceled($id){
		$this->operator_update($id, 'rec');
		$this->db->query("UPDATE book set subscriber = \"N\", subscribetime = NULL, status = 0 WHERE id = $id");
	}

	function change_remark($id,$remark)
	{
		$this->db->query("UPDATE user set remarks = '$remark' WHERE id = $id");
		if($this->db->affected_rows())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}

	//ticket functions
	function check_discount_ticket($id, $ticket){
		if ($ticket == '') return "输入不能为空。";
		$user = $this->session->userdata('username');
		$result = $this->db->select('used_ticket')->from('user')->where('username',$user)->get()->result();
		if ($result[0]->used_ticket == 5) return "用户已经使用了5张券了。";
		$result = $this->db->select('discounted')->from('book')->where('id', $id)->get()->result();
		if ($result[0]->discounted == 1) return "该书本已经使用抵价券了。";
		$result = $this->db->select('used')->from('discount_ticket')->where('ticket_id', $ticket)->where('activated', 1)->get();
		if ($result->num_rows == 0) return "该号码不存在。";
		$result = $result->result();
		if ($result[0]->used == 1) return "该号码已经被使用。";
		$this->use_discount_ticket($id, $ticket);
		return "使用成功";
	}

	function check_free_ticket($id, $ticket){
		if ($ticket == '') return "输入不能为空。";
		$user = $this->session->userdata('username');
		$result = $this->db->select('used_ticket')->from('user')->where('username',$user)->get()->result();
		if ($result[0]->used_ticket == 5) return "用户已经使用了5张券了。";
		$result = $this->db->select('freed')->from('book')->where('id', $id)->get()->result();
		if ($result[0]->freed == 1) return "该书本已经使用免费券了。";
		$result = $this->db->select('used')->from('free_ticket')->where('ticket_id', $ticket)->where('activated', 1)->get();
		if ($result->num_rows == 0) return "该号码不存在。";
		$result = $result->result();
		if ($result[0]->used == 1) return "该号码已经被使用。";
		$this->use_free_ticket($id, $ticket);
		return "使用成功";
	}

	function use_discount_ticket($id, $ticket){
		$user = $this->session->userdata('username');
		$this->db->query("UPDATE discount_ticket SET used = 1 WHERE ticket_id = \"$ticket\";");
		$this->db->query("UPDATE user SET used_ticket = used_ticket + 1 WHERE username = \"$user\";");
		$this->db->query("UPDATE book SET discounted = 1 WHERE id = $id;");

	}

	function use_free_ticket($id, $ticket){
		$user = $this->session->userdata('username');
		$this->db->query("UPDATE free_ticket SET used = 1 WHERE ticket_id = \"$ticket\";");
		$this->db->query("UPDATE user SET used_ticket = used_ticket + 1 WHERE username = \"$user\";");
		$this->db->query("UPDATE book SET freed = 1 WHERE id = $id;");

	}
}
