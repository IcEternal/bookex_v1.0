<?php
class Delivery_model extends CI_Model {
	function __construct() {
		parent::__construct();
		//get op_di from session
		$this->load->model('book_model');
		$this->op_id = $this->get_userid_from_username($this->session->userdata('username') );
	}

	private $submit_status = array(
		'0'=>'未处理',
		'11'=>'委托方拒绝交易',
		'12'=>'审核前用户取消',
		'21'=>'已审核，等待生成订单',
		'31'=>'已生成订单，正在收书',
		'41'=>'超时取消',
		'51'=>'委托方已收到书',
		'61'=>'订单完成，succ',
		'12'=>'订单完成，fail',
		
		);

	private $order_status = array(
		'0'=>'未处理',
		'1'=>'等待收集图书',
		'2'=>'订单完成'
		);

	private $op_id = 1;
//==========================================================================
//submit method
//==========================================================================
	function create_submit($buyer_id,$seller_id,$book_id)
	{
		$buyer_id = (int)$buyer_id;
		$seller_id = (int)$seller_id;
		$book_id = (int)$book_id;
		$insert = $this->db->query("INSERT INTO 
			delegation_list(buyer_id,seller_id,book_id)
			VALUE($buyer_id,$seller_id,$book_id)");
		if($this->db->affected_rows() == 1)
		{
			$submit_id = $this->db->insert_id();
			$this->record($submit_id,0);
			return $submit_id;
		}
		else
		{
			return FALSE;
		}
	}

	function delegation_deny($submit_id)
	{
		//0-未处理 
		if($this->get_submit_status($submit_id) != 0)
		{
			return FALSE;
		}
		//11-委托方拒绝交易
		$status = 11;
		$this->record($submit_id,$status);
		return $this->change_submit_status($submit_id,$status);
	}

	function user_cancel($submit_id)
	{
		//0-未处理 
		if($this->get_submit_status($submit_id) > 20)
		{
			return FALSE;
		}
		//12-审核前用户取消
		$status = 12;
		$this->record($submit_id,$status);

		/////////////
		//change the book table status using book model
		$submit_detail = $this->get_submit_detail($submit_id);
		$book_id = $submit_detail['book_id'];
		$this->book_model->user_cancel($book_id);
		/////////////

		return $this->change_submit_status($submit_id,$status);

	}

	function pass_submit($submit_id)
	{
		//0-未处理 
		if($this->get_submit_status($submit_id) != 0)
		{
			return FALSE;
		}
		//21-已审核，等待生成订单 
		$status = 21;
		$this->record($submit_id,$status);
		return $this->change_submit_status($submit_id,$status);
	}

	function merge_into_order($submit_id,$order_id)
	{
		//21-已审核，等待生成订单 
		if($this->get_submit_status($submit_id) != 21)
		{
			return FALSE;
		}
		//31-已生成订单，正在收书
		$status = 31;
		$update = $this->db->query("UPDATE delegation_list
			SET status = $status,order_id = $order_id WHERE id = $submit_id");
		if($this->db->affected_rows() == 1)
		{
			$this->record($submit_id,$status);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function over_time_cancel($submit_id)
	{
		//31-已生成订单，正在收书
		if($this->get_submit_status($submit_id) != 31)
		{
			return FALSE;
		}
		//41-超时取消（卖家迟迟不给书，买家通过管理员取消委托）
		$status = 41;
		$this->record($submit_id,$status);
		/////////////
		//管理员取消。在买家长期收不到书的情况下联系管理员取消。
		//没有验证身份，也不管书是否已送出,将书籍释放，可被搜索和再次预定
		$submit_detail = $this->get_submit_detail($submit_id);
		$book_id = $submit_detail['book_id'];
		$this->book_model->update_subscriber($book_id, 'N');
		/////////////
		return $this->change_submit_status($submit_id,$status);
	}

	function no_book_cancel($submit_id)
	{
		//31-已生成订单，正在收书
		if($this->get_submit_status($submit_id) != 31)
		{
			return FALSE;
		}
		//42-卖家无书取消
		$status = 42;
		$this->record($submit_id,$status);
		/////////////
		$submit_detail = $this->get_submit_detail($submit_id);
		$book_id = $submit_detail['book_id'];
		$this->book_model->book_deleted($book_id);
		/////////////
		return $this->change_submit_status($submit_id,$status);
	}

	function got_book($submit_id)
	{
		//31-已生成订单，正在收书
		if($this->get_submit_status($submit_id) != 31)
		{
			return FALSE;
		}
		//51-委托方已收到书 
		$status = 51;
		$this->record($submit_id,$status);
		/////////////
		$submit_detail = $this->get_submit_detail($submit_id);
		$book_id = $submit_detail['book_id'];
		// 2 表示书送到易班
		$this->book_model->status_update($book_id,2);
		/////////////
		return $this->change_submit_status($submit_id,$status);
	}

	function over_submit($submit_id)
	{
		$current_status = $this->get_submit_status($submit_id);
		if($current_status == 51)
		{
			//61-订单完成，订单中这本书买家已收到
			$this->record($submit_id,61);
			/////////////
			$submit_detail = $this->get_submit_detail($submit_id);
			$book_id = $submit_detail['book_id'];
			$this->book_model->deal_done($book_id);
			/////////////
			return $this->change_submit_status($submit_id,61);
		}
		//41-超时取消（卖家迟迟不给书，买家通过管理员取消委托）42-卖家无书取消
		else if(($current_status == 41) OR ($current_status == 42) )
		{
			//62-订单完成，订单中这本书买家未收到
			$this->record($submit_id,62);
			return $this->change_submit_status($submit_id,62);
		}
		else
		{
			return FALSE;
		}
	}

	private function change_submit_status($submit_id,$status)
	{
		$update = $this->db->query("UPDATE delegation_list 
			SET status = $status WHERE id = $submit_id");
		if($this->db->affected_rows() == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	private function get_submit_status($submit_id)
	{
		$query = $this->db->query("SELECT status FROM delegation_list
			WHERE id = $submit_id");
		$row = $query->first_row();
		return $row->status;
	}
//==========================================================================
//END OF submit method
//==========================================================================


//==========================================================================
//order method
//==========================================================================
	function create_order($buyer_id)
	{
		$insert = $this->db->query("INSERT INTO order_list
			(buyer_id,status) VALUE
			($buyer_id,1)");
		if($this->db->affected_rows() == 1)
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}

	function close_order($order_id)
	{
		//检查订单状态
		$query_order = $this->db->query("SELECT status FROM order_list WHERE id = $order_id");
		$row = $query_order->first_row();
		$order_status = $row->status;
		//1-订单已生成，等待收集图书
		if($row->status != 1)
			return FALSE;
		//检查订单下每个submit
		if($this->check_order($order_id) === FALSE)
			return FALSE;
		//更新submit状态
		$query_submit = $this->db->query("SELECT id FROM delegation_list
			WHERE order_id = $order_id AND (status BETWEEN 40 AND 60)");
		$query_submit_result = $query_submit->result();
		foreach ($query_submit_result as $submit) {
			$this->over_submit($submit->id);
		}
		//更新订单状态
		$update_order = $this->db->query("UPDATE order_list
			SET status = 2 WHERE id = $order_id");
		return TRUE;
	}

	//return
	//TRUE - all the books in the order have been got or canceled ,we can close the order
	//FALSE - there are some books in the order waiting to get
	private function check_order($order_id)
	{
		//31-已生成订单，正在收书
		$query = $this->db->query("SELECT * FROM delegation_list
			WHERE order_id = $order_id AND status = 31");
		if($query->num_rows() )
		{
			return FALSE;
		}
		return TRUE;
	}
//==========================================================================
//END OF order method
//==========================================================================


//==========================================================================
//contact method
//==========================================================================
	function add_order_msg($order_id,$msg)
	{
		$insert = $this->db->query("INSERT INTO trade_msg
			(order_id,msg,op_id)VALUE($order_id,'$msg',$this->op_id)");
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return FALSE;
	}
	function add_buyer_msg($buyer_id,$msg)
	{
		$insert = $this->db->query("INSERT INTO trade_msg
			(buyer_id,msg,op_id)VALUE($buyer_id,'$msg',$this->op_id)");
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return FALSE;
	}
	function add_seller_msg($seller_id,$msg)
	{
		$insert = $this->db->query("INSERT INTO trade_msg
			(seller_id,msg,op_id)VALUE($seller_id,'$msg',$this->op_id)");
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return FALSE;
	}
	function del_msg($msg_id)
	{
		$update = $this->db->query("UPDATE trade_msg SET del = 1 WHERE id = $msg_id");
		if($this->db->affected_rows() == 1)
			return TRUE;
		else
			return FALSE;
	}

//==========================================================================
//END OF contact method
//==========================================================================


//==========================================================================
//recorder method
//==========================================================================
	function record($submit_id,$status)
	{
		$this->db->query("INSERT INTO delegation_record
			(submit_id,submit_status,op_id)
			VALUE($submit_id,$status,$this->op_id)
			");
		if($this->db->affected_rows() == 1)
			return $this->db->insert_id();
		else
			return FALSE;
	}

	function revocation($submit_id)
	{
		$query_record = $this->db->query("SELECT id,submit_status FROM delegation_record
			WHERE submit_id = $submit_id AND revocation = 0 ORDER BY op_time DESC");
		if($query_record->num_rows() < 2)
			return FALSE;
		$result = $query_record->result();
		$row_first = $result[0];
		$row_second = $result[1];
		$last_status = $row_second->submit_status;
		$last_id = $row_second->id;
		$current_id = $row_first->id;

		//set revocation status to record
		$update_record = $this->db->query("UPDATE delegation_record SET revocation = 1 WHERE id = $current_id");
		$update_submit = $this->db->query("UPDATE delegation_list SET status = $last_status WHERE id = $submit_id");
		/////////////
		$current_status = $row_first->submit_status;
		if($current_status == 12 OR $current_status == 41)//用户取消,超时取消，book表中subscriber 已为N   
		{

			$submit_id = $row_first->submit_id;
			$submit_detail = $this->get_submit_detail($submit_id);
			$book_id = $submit_detail->book_id;
			$buyer_id = $submit_detail->buyer_id;
			$buyer_username = $this->get_username_from_userid($buyer_id);

			//如果撤销操作前，这本释放了的书，有被人预定了，怎么办？不执行操作
			$query_book = $this->db->query("SELECT * FROM book WHERE id = $book_id");
			$row = $query_book->first_row();
			if($row->subscriber == 'N')
			{
				$this->db->query("UPDATE book SET subscribetime = now(), status = 0,subscriber = '$buyer_username' WHERE id = \"$book_id\"");
			}
			else
			{
				$update_record = $this->db->query("UPDATE delegation_record SET revocation = 0 WHERE id = $current_id");
				$update_submit = $this->db->query("UPDATE delegation_list SET status = $current_status WHERE id = $submit_id");
			}
		}
		if($current_status == 42)//卖家无书,book表中为status = 5
		{
			$this->book_model->status_update($id, 1);//正在取书
		}
		if ($current_status == 51) //已从卖家拿到书
		{
			$this->book_model->status_update($id, 2);//返回正在取书状态
		}
		if($current_status == 61)//交易完成
		{
			$this->book_model->status_update($id, 3);//返回正在取书状态
		}
		/////////////
		return TRUE;
	}

//==========================================================================
//END OF record method
//==========================================================================

//==========================================================================
//常用方法
//==========================================================================
	function gather_submit_into_order($buyer_id)
	{
		//创建一个空订单
		$order_id = $this->create_order($buyer_id);
		//找出所有等待合成订单且买家是buyer_id的submit
		$waiting_submits = $this->find_waiting_submit($buyer_id);
		foreach ($waiting_submits as $submit) {
			$submit_id = $submit['id'];
			$this->merge_into_order($submit_id,$order_id);
		}
	}

	function user_detail($user_id)
	{
		$query_user = $this->db->query("SELECT * FROM user WHERE id = $user_id");
		return $query_user->first_row('array');
	}

	function book_detail($book_id)
	{
		$query_book = $this->db->query("SELECT * FROM book WHERE id = $book_id");
		return $query_book->first_row('array');
	}

	private function find_waiting_submit($buyer_id)
	{
		//21-已审核，等待生成订单
		$query = $this->db->query("SELECT * FROM delegation_list 
			WHERE status = 21 AND buyer_id = $buyer_id");
		return $query->result_array();
	}

	//对所有的submit进行搜索、排序
	function submit_search($search_data,$offset,$limit)
	{
		$order_condition = 'ORDER BY id DESC';
		if($search_data['order_by_status'] != NULL)
		{
			$order_condition = 'ORDER BY status ASC,buyer_id,create_time DESC';
		}
		$total_query = $this->db->query("SELECT * FROM delegation_list $order_condition");
		$query = $this->db->query("SELECT * FROM delegation_list $order_condition LIMIT $offset,$limit");
		$total_rows = $total_query->num_rows();
		$result = $query->result_array();
		return array($total_rows,$result);
	}

	//对已经审核通过，等待生成订单的submit，按买家用户名排列
	//提供按用户名分类的详细submit_list 
	function passed_submit_search()
	{
		$buyer_query = $this->db->query("SELECT DISTINCT buyer_id FROM delegation_list
			INNER JOIN user ON user.id = delegation_list.buyer_id
			WHERE status = 21 ORDER BY delegation_list.create_time");
		$buyer_list = $buyer_query->result_array();
		foreach ($buyer_list as $key => $buyer) {
			$buyer_id = $buyer['buyer_id'];
			//获取买家用户详情
			$query_buyer = $this->db->query("SELECT * FROM user WHERE id = $buyer_id");
			$buyer_list[$key]['buyer_detail'] = $query_buyer->first_row('array');
			//获取买家的委托详情
			$submit_query = $this->db->query("SELECT * FROM delegation_list 
				WHERE buyer_id = $buyer_id AND status = 21");
			$submit_list = $submit_query->result_array();
			$buyer_list[$key]['submit_info'] = $this->supplement_submit($submit_list);
		}
		return $buyer_list;
	}

	//对已经生成订单的的submit，按卖家用户名排列
	//提供按用户名分类的详细submit_list 
	function ordered_submit_by_seller_id()
	{
		$seller_query = $this->db->query("SELECT DISTINCT seller_id FROM delegation_list
			INNER JOIN user ON user.id = delegation_list.seller_id
			WHERE (status BETWEEN 30 AND 60) ORDER BY delegation_list.create_time DESC");
		$seller_list = $seller_query->result_array();
		foreach ($seller_list as $key => $seller) {
			$seller_id = $seller['seller_id'];
			//获取卖家用户详情
			$query_seller = $this->db->query("SELECT * FROM user WHERE id = $seller_id");
			$seller_list[$key]['seller_detail'] = $query_seller->first_row('array');
			//获取卖家被订购的书的详情
			$submit_query = $this->db->query("SELECT * FROM delegation_list 
				WHERE seller_id = $seller_id AND (status BETWEEN 30 AND 60)");
			$submit_list = $submit_query->result_array();
			$seller_list[$key]['submit_info'] = $this->supplement_submit($submit_list);
			//获取卖家笔记
			$msg_query = $this->db->query("SELECT * FROM trade_msg WHERE seller_id = $seller_id AND del = 0 ORDER BY contact_time DESC");
			$seller_list[$key]['msg_list'] = $msg_query->result_array();
			//获取操作员信息
			foreach ($seller_list[$key]['msg_list'] as $i => $msg) {
				$op_id = $msg['op_id'];
				$query_op = $this->db->query("SELECT * FROM user WHERE id = $op_id");
				$seller_list[$key]['msg_list'][$i]['op_info'] = $query_op->first_row('array');
			}
		}
		return $seller_list;
	}

	//对已经生成订单的submit ，展示出来
	function ordered_submit_by_order_id()
	{
		$order_query = $this->db->query("SELECT order_list.* FROM order_list
			INNER JOIN user ON user.id = order_list.buyer_id
			WHERE status = 1 ORDER BY order_list.id ASC");
		$order_list = $order_query->result_array();
		foreach ($order_list as $key => $order) {
			$order_id = $order['id'];
			//获取买家用户详情
			$buyer_id = $order['buyer_id'];
			$query_buyer = $this->db->query("SELECT * FROM user WHERE id = $buyer_id");
			$order_list[$key]['buyer_detail'] = $query_buyer->first_row('array');
			//获取订单下的委托详情
			$submit_query = $this->db->query("SELECT * FROM delegation_list 
				WHERE order_id = $order_id AND (status BETWEEN 30 AND 60)");
			$submit_list = $submit_query->result_array();
			$order_list[$key]['submit_info'] = $this->supplement_submit($submit_list);
			//检查订单是否可以close
			$order_list[$key]['order_ready'] = $this->check_order($order_id);
			//获取订单笔记
			$msg_query = $this->db->query("SELECT * FROM trade_msg WHERE order_id = $order_id AND del = 0 ORDER BY contact_time DESC");
			$order_list[$key]['msg_list'] = $msg_query->result_array();
			//获取操作员信息
			foreach ($order_list[$key]['msg_list'] as $i => $msg) {
				$op_id = $msg['op_id'];
				$query_op = $this->db->query("SELECT * FROM user WHERE id = $op_id");
				$order_list[$key]['msg_list'][$i]['op_info'] = $query_op->first_row('array');
			}
		}
		return $order_list;
	}


	//根据delegation_list中提供的book_id user_id 信息获取详细信息
	function supplement_submit($submit_list)
	{
		foreach ($submit_list as $key => $submit) {
			$book_id = $submit['book_id'];
			$buyer_id = $submit['buyer_id'];
			$seller_id = $submit['seller_id'];
			$submit_id = $submit['id'];

			$query_book = $this->db->query("SELECT * FROM book WHERE id = $book_id");
			$submit_list[$key]['book_detail'] = $query_book->first_row('array');
			$query_buyer = $this->db->query("SELECT * FROM user WHERE id = $buyer_id");
			$submit_list[$key]['buyer_detail'] = $query_buyer->first_row('array');
			$query_seller = $this->db->query("SELECT * FROM user WHERE id = $seller_id");
			$submit_list[$key]['seller_detail'] = $query_seller->first_row('array');
			$query_record = $this->db->query("SELECT * FROM delegation_record 
				WHERE revocation = 0 AND submit_id = $submit_id
				ORDER BY op_time");
			$submit_list[$key]['submit_record'] = $query_record->result_array();
		}
		return $submit_list;
	}

	function get_userid_from_username($username)
	{
		$query = $this->db->query("SELECT id FROM user WHERE username = '$username'");
		if($query->num_rows() )
		{
			$row = $query->first_row();
			return $row->id;
		}
		else
		{
			return FALSE;
		}
	}

	function get_username_from_userid($user_id)
	{
		$query = $this->db->query("SELECT username FROM user WHERE id = $user_id");
		if($query->num_rows() )
		{
			$row = $query->first_row();
			return $row->username;
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_submit_detail($submit_id)
	{
		$query = $this->db->query("SELECT * FROM delegation_list WHERE id = $submit_id");
		if($query->num_rows() )
			return $query->first_row('array');
		else
			return FALSE;
	}

}
