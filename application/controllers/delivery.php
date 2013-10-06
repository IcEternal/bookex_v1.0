<?php 
class Delivery extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("delivery_model",'delivery');
		$this->auth->normal_admin();
	}

	function index()
	{
		$data = array(
			'title'=>'配送系统',
			'quantity'=>NULL,
			);
		$this->load->view("delivery/delivery",$data);
	}

	function check_submit()
	{
		//导入model
		$this->load->model('pagination_model');
		//从页面获取数据
		//貌似get方法获取不存在的 键，返回的值为0,
		//所以通过判断语句设置 应该从get中得到的值
		$order_by_time = $this->input->get('order_by_time')?$this->input->get('order_by_time'):null;
		$order_by_status = $this->input->get('order_by_status')?$this->input->get('order_by_status'):null;
		$offset = $this->input->get('offset')?$this->input->get('offset'):0;
		
		//进行搜索
		$search_data = array(
			'order_by_time'=>$order_by_time,
			'order_by_status'=>$order_by_status
			);
		//参数：搜索内容，偏移量，每页显示数
		//返回：总记录数，搜索结果数组
		list($total,$result) = $this->delivery->submit_search($search_data,$offset,10);

		//页码导航
		$link_config = array(
			'total'=>$total,
			'offset'=>$offset,
			'search_data'=>$search_data,
			'pre_url'=>'delivery/check_submit',
			);
		$this->pagination_model->initialize($link_config);
		$link_array = $this->pagination_model->create_link();

		//完善显示信息
		$submit_result = $this->delivery->supplement_submit($result);

		//统计信息
		$status0 = $this->db->query("SELECT * FROM delegation_list WHERE status = 0");
		$status0_num = $status0->num_rows();
		$quantity = '未处理委托：'.$status0_num.'条';

		$data = array(
			'title'=>'检查委托',
			'link_array'=>$link_array,
			'search_data'=>$search_data,
			'submit_result'=>$submit_result,
			'total'=>$total,
			'quantity'=>$quantity,
			);
		$this->load->view("delivery/check_submit",$data);
	}

	function make_order()
	{
		//统计信息
		$status21 = $this->db->query("SELECT DISTINCT buyer_id FROM delegation_list WHERE status = 21");
		$status21_num = $status21->num_rows();
		$quantity = '可生成订单'.$status21_num.'个';

		$buyer_list = $this->delivery->passed_submit_search();
		$data = array(
			'title'=>'生成订单',
			'buyer_list'=>$buyer_list,
			'quantity'=>$quantity,
			);
		$this->load->view("delivery/make_order",$data);
	}

	function seller_manange()
	{
		//统计信息
		$status1 = $this->db->query("SELECT DISTINCT seller_id FROM delegation_list WHERE  (status BETWEEN 30 AND 60)");
		$status1_num = $status1->num_rows();
		$quantity = '订单涉及'.$status1_num.'个卖家';

		$seller_list = $this->delivery->ordered_submit_by_seller_id();
		$data = array(
			'title'=>'卖家管理',
			'seller_list'=>$seller_list,
			'quantity'=>$quantity,
			);
		$this->load->view("delivery/seller_manange",$data);
	}

	function buyer_manange()
	{
		//统计信息
		$status1 = $this->db->query("SELECT * FROM order_list WHERE status = 1");
		$status1_num = $status1->num_rows();
		$quantity = '未完成订单'.$status1_num.'个';

		$order_list = $this->delivery->ordered_submit_by_order_id();
		$data = array(
			'title'=>'买家管理',
			'order_list'=>$order_list,
			'quantity'=>$quantity,
			);
		$this->load->view("delivery/buyer_manange",$data);
	}

	function user_detail()
	{
		$user_id = $this->input->get_post('user_id');
		$user_info = $this->delivery->user_detail($user_id);
		$data = array(
			'title'=>'用户详情',
			'user_info'=>$user_info
			);
		$this->load->view("delivery/user_info",$data);
	}

	function book_detail()
	{
		$book_id = $this->input->get_post('book_id');
		$book_info = $this->delivery->book_detail($book_id);
		$data = array(
			'title'=>'书本详情',
			'book_info'=>$book_info
			);
		$this->load->view("delivery/book_info",$data);
	}

	function return_goods()
	{
		echo 'return_goods';
	}


	//操作，自动跳回上一页面
	function delegation_deny($submit_id)
	{
		$this->delivery->delegation_deny($submit_id);
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	function pass_submit($submit_id)
	{
		$this->delivery->pass_submit($submit_id);
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	function revocation($submit_id)
	{
		$this->delivery->revocation($submit_id);
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	function gather_submit_into_order($buyer_id)
	{
		$this->delivery->gather_submit_into_order($buyer_id);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	
	function over_time_cancel($submit_id)
	{
		//释放书籍，处于非预定状态
		$this->delivery->over_time_cancel($submit_id);
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	function close_order($order_id)
	{
		$this->delivery->close_order($order_id);
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	function got_book($submit_id)
	{
		$this->delivery->got_book($submit_id);
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	
	function no_book_cancel($submit_id)
	{
		$this->delivery->no_book_cancel($submit_id);
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	function add_seller_msg()
	{
		$seller_id = $this->input->get_post('seller_id');
		if($msg = $this->input->get_post('msg') )
			$this->delivery->add_seller_msg($seller_id,$msg);
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	function add_order_msg()
	{
		$order_id = $this->input->get_post('order_id');
		if($msg = $this->input->get_post('msg') )
			$this->delivery->add_order_msg($order_id,$msg);
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	function del_msg($msg_id)
	{
		$query = $this->db->query("SELECT * FROM trade_msg WHERE id = $msg_id");
		$row = $query->first_row();
		$op_id = $row->op_id;

		$username = $this->session->userdata('username');
		$login_user_id = $this->delivery->get_userid_from_username($username);
		echo $login_user_id;
		if($op_id == $login_user_id || $username == 'zhcpzyjtx')
		{
			$this->delivery->del_msg($msg_id);
		}
		header("location:".$_SERVER['HTTP_REFERER']);
	}

	function import_delegation_submit()
	{
		$book_query = $this->db->query("SELECT * FROM book WHERE subscriber != 'N' 
			AND finishtime = 0  AND del != 1 AND  use_phone = 0 AND status = 0");
		$result = $book_query->result();
		echo '<meta charset=utf8>';
		foreach ($result as $book) {
			$book_id = $book->id;
			$seller = $book->uploader;
			$buyer = $book->subscriber;
			$seller_id = $this->delivery->get_userid_from_username($seller);
			$buyer_id = $this->delivery->get_userid_from_username($buyer);

			$result = ($submit_id = $this->delivery->create_submit($buyer_id,$seller_id,$book_id) )?'SUCC':'FAIL';
			$this->delivery->pass_submit($submit_id);
			echo $book_id.'-'.$seller.'-'.$buyer.'-'.$result.'<br>';
		}
	}
}
