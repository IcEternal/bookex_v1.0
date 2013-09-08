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
		if ($new_sub == 'N') {
			$arr['use_phone'] = false;
		}
		$this->db->update('book', $arr);
		$this->db->query("UPDATE book SET subscribetime = now() WHERE id = \"$book_id\"");
	}

	function use_phone($book_id) {
		$this->db->where('id', $book_id);
		$arr = array(
			'use_phone' => true
		);
		$this->db->update('book', $arr);
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
		$this->db->where('id', $id);
		$this->db->query("UPDATE book SET deltime = now() WHERE id = \"$id\"");
		$arr = array('del' => true);
		return $this->db->update('book', $arr);
	}

	function book_finish($id) {
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
		if ($this->session->userdata('username') == $this->get_uploader_by_id($book_id)) return true;
		return false;
	}

	function is_subscriber($book_id) {
		if ($this->session->userdata('username') == $this->get_subscriber_by_id($book_id)) return true;
		return false;
	}

	//Record when someone see the view of a book.
	function record_id($book_id, $username){
		$this->db->query("INSERT INTO book_view (bookid, viewer, viewtime) VALUES (\"$book_id\", \"$username\", now());");
	}

	//Change the status of a book.	
	function status_update($id, $status){
		$this->db->query("UPDATE book SET status = $status WHERE id = $id;");
	}


	function get_result($id){
		return $this->db->select('*')->from('book')->where("id=\"$id\"")->get()->result();
	}

	function next_operation($id){
		if (!$this->session->userdata('is_logged_in')) return "失败";
		$username = $this->session->userdata('username');
		$result = $this->get_result($id);
		if (!array_key_exists($result, 0)) return "失败";
		$status = $result[0]->status;
		if ($status == 0){
			$this->status_update($id, $status + 1);
			$this->db->query("UPDATE book SET receiver = \"$username\" WHERE id = $id;");
		}
		elseif ($status == 1){
			if ($username != $result[0]->receiver) return "失败";
			$this->status_update($id, $status + 1);
		}
		elseif ($status == 2){
			$this->status_update($id, $status + 1);
			$this->db->query("UPDATE book SET sender = \"$username\" WHERE id = $id;");
		}
		else if ($status == 3){
			if ($username != $result[0]->sender) return "失败";
			$this->status_update($id, $status + 1);
		}
		return "失败";
	}

	function prev_operation($id){
		if (!$this->session->userdata('is_logged_in')) return "失败";
		$username = $this->session->userdata('username');
		$result = $this->get_result($id);
		if (!array_key_exists($result, 0)) return "失败";
		$status = $result[0]->status;
		if ($status == 1){
			if ($username != $result[0]->receiver) return "失败";
			$this->status_update($id, $status - 1);
		}
		elseif ($status == 2){
			if ($username != $result[0]->receiver) return "失败";
			$this->status_update($id, $status - 1);
		}
		else if ($status == 3){
			if ($username != $result[0]->sender) return "失败";
			$this->status_update($id, $status - 1);
		}
		return "失败";
	}

	function deal_done($id){
		if (!$this->session->userdata('is_logged_in')) return "失败";
		$username = $this->session->userdata('username');
		$result = $this->get_result($id);
		if (!array_key_exists($result, 0)) return "失败";
		$status = $result[0]->status;
		if ($status == 2 || $status == 3){
			$this->status_update($id, 4);
		}
		return "失败";
	}

	function book_deleted($id){
		if (!$this->session->userdata('is_logged_in')) return "失败";
		$username = $this->session->userdata('username');
		$result = $this->get_result($id);
		if (!array_key_exists($result, 0)) return "失败";
		if ($status == 1){
			$this->status_update($id, 5);
		}
		return "失败";
	}

	function deal_canceled($id){
		$this->db->query("UPDATE book set subscriber = \"N\", subscribetime = NULL, status = 0 WHERE id = $id");
	}	



}
