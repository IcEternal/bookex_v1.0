<?php 
	
class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->auth->normal_admin();
	}

	function index()
	{
		$this->db->where('del !=',TRUE);
		$data = array();
		//书籍统计信息
		$book_result = $this->db->select('count(id) AS book_num')->where('del !=',TRUE)->from('book')->get()->result();
		$row1 = $book_result[0];
		$data['book_num'] = $row1->book_num;

		$book_result = $this->db->select('count(id) AS book_num')->from('book')->where('del !=',TRUE)->where('finishtime',0)->where('subscriber','N')->get()->result();
		$row1 = $book_result[0];
		$data['book_unreserved_num'] = $row1->book_num;

		$book_result = $this->db->select('count(id) AS book_num')->from('book')
		->where('del !=',TRUE)->where('subscriber !=','N')->where('finishtime',0)->get()->result();
		$row1 = $book_result[0];
		$data['book_reserved_num'] = $row1->book_num;

		$book_result = $this->db->select('count(id) AS book_num')->from('book')
		->where('del !=',TRUE)->where('finishtime >',0)->get()->result();
		$row1 = $book_result[0];
		$data['book_traded_num'] = $row1->book_num;

		$book_result = $this->db->select('count(id) AS book_num')->from('book')
		->where('del',TRUE)->get()->result();
		$row1 = $book_result[0];
		$data['book_del_num'] = $row1->book_num;
		
		//用户统计信息
		$user_result = $this->db->select('count(id) AS user_num')->from('user')->get()->result();
		$row1 = $user_result[0];
		$data['user_num'] = $row1->user_num;

		//分类统计信息
		$book_result = $this->db->select('count(id) AS book_num')->from('book')
		->where('del !=',TRUE)->where('class','')->get()->result();
		$row1 = $book_result[0];
		$data['unclassify_num'] = $row1->book_num;

		//交易信息统计
		$common_condition = "WHERE subscriber != 'N' AND finishtime = 0 AND use_phone = 0 AND del != TRUE";
		$query_str = "SELECT COUNT(DISTINCT uploader) AS buyer_num,COUNT(DISTINCT subscriber) AS saler_num FROM book $common_condition";
		$result = $this->db->query($query_str)->result();
		$row1 = $result[0];
		$data['buyer_num'] = $row1->buyer_num;
		$data['saler_num'] = $row1->saler_num;
		$this->load->view('admin/index',$data);
	}

	//展示书本，
	function book()
	{

		//导入model
		$this->load->model('admin_model');
		$this->load->model('pagination_model');

		//从页面获取数据
		//貌似get方法获取不存在的 键，返回的值为0,
		//所以通过判断语句设置 应该从get中得到的值
		$book_name = $this->input->get('book_name')?$this->input->get('book_name'):null;
		$uploader = $this->input->get('uploader')?$this->input->get('uploader'):null;
		$subscriber = $this->input->get('subscriber')?$this->input->get('subscriber'):null;
		$no_reserve = $this->input->get('no_reserve')?$this->input->get('no_reserve'):0;
		$reserved = $this->input->get('reserved')?$this->input->get('reserved'):0;
		$del = $this->input->get('del')?$this->input->get('del'):0;
		$traded = $this->input->get('traded')?$this->input->get('traded'):0;
		$offset = $this->input->get('offset')?$this->input->get('offset'):0;
		$self = $this->input->get('self')?$this->input->get('self'):0;

		//进行搜索
		$search_data = array(
			'book_name' => $book_name, 
			'uploader' => $uploader,
			'subscriber' => $subscriber,
			'no_reserve' => $no_reserve,
			'reserved' => $reserved,
			'del'=>$del,
			'traded' => $traded,
			'self'=>$self
			);
		//参数：搜索内容，偏移量，每页显示数
		//返回：总记录数，搜索结果数组
		list($total,$book_result) = $this->admin_model->book_search($search_data,$offset,10);

		//页码导航
		$link_config = array(
			'total'=>$total,
			'offset'=>$offset,
			'search_data'=>$search_data,
			'pre_url'=>'admin/book',
			);
		$this->pagination_model->initialize($link_config);
		$link_array = $this->pagination_model->create_link();

		//页面显示
		$data = array(
			'search_data' => $search_data, 
			'book_info' => $book_result, 
			'link_array' => $link_array, 
			'total_rows'=>$total,
			);
		$this->load->view('admin/book',$data);
	}

	//修改书本分类，
	function book_classify()
	{
		$this->auth->super_admin();
		//导入model
		$this->load->model('admin_model');
		$this->load->model('pagination_model');

		//从页面获取数据
		//貌似get方法获取不存在的 键，返回的值为0,
		//所以通过判断语句设置 应该从get中得到的值
		$book_name = $this->input->get('book_name')?$this->input->get('book_name'):null;
		$class_status = $this->input->get('class_status')?$this->input->get('class_status'):null;
		$class_name = $this->input->get('class_name')?$this->input->get('class_name'):null;
		$offset = $this->input->get('offset')?$this->input->get('offset'):0;

		//进行搜索
		$search_data = array(
			'book_name' => $book_name, 
			'class_status' => $class_status,
			'class_name' => $class_name,
			);
		//参数：搜索内容，偏移量，每页显示数
		//返回：总记录数，搜索结果数组
		list($total,$book_result) = $this->admin_model->class_search($search_data,$offset,10);

		//页码导航
		$link_config = array(
			'total'=>$total,
			'offset'=>$offset,
			'search_data'=>$search_data,
			'pre_url'=>'admin/book_classify',
			);
		$this->pagination_model->initialize($link_config);
		$link_array = $this->pagination_model->create_link();

		//页面显示
		$data = array(
			'search_data' => $search_data, 
			'book_info' => $book_result, 
			'link_array' => $link_array, 
			'total_rows'=>$total,
			);
		$this->load->view('admin/book_classify',$data);
	}

	//修改书本
	//url 传递书本id
	function book_modify()
	{
		$this->auth->super_admin();
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$data = array();
		//从user表中找到该书的上传者id
		if($result = $this->db->select('user.id')->from('user')
		->join('book','book.uploader = user.username')
		->where('book.id',$id)->get()->result())
		{
			$row1 = $result[0];
			$data['uploader_id'] = $row1->id;
		}
		//从user表中找到该书的预订者id
		if($result = $this->db->select('user.id')->from('user')
		->join('book','book.subscriber = user.username')
		->where('book.id',$id)->get()->result())
		{
			$row1 = $result[0];
			$data['subscriber_id'] = $row1->id;
		}

		if($this->input->post('submit'))
		{
			$data['info'] = $this->admin_model->modify_validation($id);
		}
		else
		{
			$data['info'] = array('status'=>'1','message'=>'管理员修改图书信息');
		}
		$this->load->model('book_model');
		$query = $this->book_model->get_book($id);
		$data['id'] = $id;
		$data['name'] = $query->name;
		$data['author'] = $query->author;
		$data['price'] = $query->price;
		$data['originprice'] = $query->originprice;
		$data['publisher'] = $query->publisher;
		$data['isbn'] = $query->ISBN;
		$data['description'] = $query->description;
		$data['subscribetime'] = $query->subscribetime;
		$data['finishtime'] = $query->finishtime;
		$data['uploader'] = $query->uploader;
		$data['subscriber'] = $query->subscriber;
		$data['title'] = '修改书本信息';
		$data['show'] = $query->show_phone;
		$data['class'] = $query->class;
		
		$this->load->view('admin/book_modify', $data);
	}

	function book_delete()
	{
		$this->auth->super_admin();
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$this->admin_model->book_delete($id);
	}

	function book_hasit()
	{
		$this->auth->super_admin();
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$this->admin_model->book_hasit($id);
	}
	function book_trade()
	{
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$this->admin_model->book_trade($id);
	}

	function user()
	{		
		$this->auth->super_admin();

		//导入model
		$this->load->model('admin_model');
		$this->load->model('pagination_model');

		//从页面获取数据
		//貌似get方法获取不存在的 键，返回的值为0,
		//所以通过判断语句设置 应该从get中得到的值
		$username = $this->input->get('username')?$this->input->get('username'):null;
		$phone = $this->input->get('phone')?$this->input->get('phone'):null;
		$email = $this->input->get('email')?$this->input->get('email'):null;
		$stu_num = $this->input->get('stu_num')?$this->input->get('stu_num'):null;
		$order_by_up = $this->input->get('order_by_up')?$this->input->get('order_by_up'):0;
		$offset = $this->input->get('offset')?$this->input->get('offset'):0;
		//进行搜索
		$search_data = array(
			'username' => $username, 
			'phone' => $phone,
			'email' => $email,
			'stu_num' => $stu_num,
			'order_by_up' => $order_by_up,
			);
		//参数：搜索内容，偏移量，每页显示数
		//返回：总记录数，搜索结果数组
		list($total,$user_result) = $this->admin_model->user_search($search_data,$offset,10);

		//页码导航
		$link_config = array(
			'total'=>$total,
			'offset'=>$offset,
			'search_data'=>$search_data,
			'pre_url'=>'admin/user',
			);
		$this->pagination_model->initialize($link_config);
		$link_array = $this->pagination_model->create_link();

		//页面显示
		$data = array(
			'search_data' => $search_data, 
			'user_info' => $user_result, 
			'link_array' => $link_array, 
			'total_rows'=>$total,
			);
		$this->load->view('admin/user',$data);
		
	}

	function user_modify(){
		$this->auth->super_admin();
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$data = array();
		//统计用户上传书籍
		//up_book_num
		$result = $this->db->select('count(book.uploader) as up_book_num')->from('user')
		->join('book','user.username = book.uploader','left')->where('user.id',$id)->get()->result();
		$row1 = $result[0];
		$data['up_book_num'] = $row1->up_book_num;
		//sub_book_num
		$result = $this->db->select('count(book.subscriber) as sub_book_num')->from('user')
		->join('book','user.username = book.subscriber','left')->where('user.id',$id)->get()->result();
		$row1 = $result[0];
		$data['sub_book_num'] = $row1->sub_book_num;
		//sub_book_num
		$result = $this->db->select('count(book.id) as traded_book_num')->from('user')
		->join('book','user.username = book.uploader','left')->where('user.id',$id)->where('finishtime >',0)->get()->result();
		$row1 = $result[0];
		$data['traded_book_num'] = $row1->traded_book_num;
		//up_book_money
		$result = $this->db->select('sum(book.price) as up_book_money')->from('user')
		->join('book','user.username = book.uploader','left')->where('user.id',$id)->get()->result();
		$row1 = $result[0];
		$data['up_book_money'] = $row1->up_book_money;

		if($this->input->post('submit'))
		{
			$data['info'] =  $this->admin_model->user_modify_validation($id);
		}
		else
		{
			$data['info'] = array('status'=>'1','message'=>'管理员修改用户信息');
		}

		$query = $this->admin_model->get_user($id);
		$data['id'] = $id;
		$data['username'] = $query->username;
		$data['email'] = $query->email;
		$data['phone'] = $query->phone;
		$data['student_number'] = $query->student_number;
		$data['title'] = '更改个人信息';
		$data['dormitory'] = $query->dormitory;
		$data['remarks'] = $query->remarks;
		$this->load->view('admin/user_modify', $data);
	}

	function modify_book_class(){
		$this->auth->super_admin();
		$book_id = $_GET['book_id'];
		$this->db->set('class',$_GET['classname']);
		$this->db->where('id',$book_id);
		$this->db->update('book');
		if($this->db->affected_rows() == 0)
		{
			echo '更新失败';
		}
		else
		{
			$result = $this->db->select('class')->where('id',$book_id)->get('book')->result();
			$row1 = $result[0];
			echo $row1->class;
		}
	}

	function trade()
	{
		//导入model
		$this->load->model('admin_model');
		$this->load->model('book_model');

		//筛选出可以交易的书的统一条件
		$common_condition = "WHERE subscriber != 'N' AND finishtime = 0 AND use_phone = 0 AND del != TRUE";
		//卖家信息
		$query_str = "SELECT COUNT(book.id) AS book_num,SUM(book.price) AS book_money,book.uploader,user.dormitory,user.phone,user.remarks,user.id AS user_id 
		FROM book INNER JOIN user ON 
		book.uploader = user.username $common_condition group by uploader ORDER BY subscribetime ASC";
		$saler_info = $this->db->query($query_str)->result_array();
		//获取每个卖家的详细信息
		$sale_book = array();
		foreach ($saler_info as $saler) {
			$username = $saler['uploader'];
			$query_str = "SELECT book.status,book.id,book.name,book.price,book.subscriber,book.discounted,book.freed,user.phone,user.dormitory,user.id AS user_id FROM book 
			INNER JOIN user ON book.subscriber = user.username $common_condition AND uploader = '$username'";
			$sale_book[$username] = $this->db->query($query_str)->result();
		}

		//买家信息
		$query_str = "SELECT COUNT(book.id) AS book_num,SUM(book.price) AS book_money,book.subscriber,user.dormitory,user.phone,user.remarks,user.id AS user_id 
		FROM book INNER JOIN user ON 
		book.subscriber = user.username $common_condition group by subscriber ORDER BY subscribetime ASC";
		$buyer_info = $this->db->query($query_str)->result_array();
		//获取每个买家的详细信息
		$buy_book = array();
		foreach ($buyer_info as $buyer) {
			$username = $buyer['subscriber'];
			$query_str = "SELECT book.status, book.id,book.name,book.price,book.uploader,book.discounted,book.freed,user.dormitory,user.phone,user.id AS user_id FROM book 
			INNER JOIN user ON book.uploader = user.username $common_condition AND subscriber = '$username'";
			$buy_book[$username] = $this->db->query($query_str)->result();
		}

		//页面显示
		$data = array(
			'saler_info'=>$saler_info,
			'sale_book'=>$sale_book,
			'buyer_info'=>$buyer_info,
			'buy_book'=>$buy_book,
			);
		$this->load->view('admin/trade',$data);
	}

	//New functions for receiver, sender and status for a book.
	function next_operation(){
		$id = $_GET['book_id'];
		$this->load->model('book_model');
		echo $this->book_model->next_operation($id);
	}

	function prev_operation(){
		$id = $_GET['book_id'];
		$this->load->model('book_model');
		echo $this->book_model->prev_operation($id);
	}

	function deal_done(){
		$id = $_GET['book_id'];
		$this->load->model('book_model');
		echo $this->book_model->deal_done($id);
	}

	function book_deleted(){
		$id = $_GET['book_id'];
		$this->load->model('book_model');
		echo $this->book_model->book_deleted($id);
	}
	
	function deal_canceled(){
		$id = $_GET['book_id'];
		$this->load->model('book_model');
		echo $this->book_model->deal_canceled($id);
	}

	function change_remark()
	{
		$id = $_POST['user_id'];
		$remark = $_POST['remark'];
		echo $this->book_model->change_remark($id,$remark);
	}

	//2013.10.7 generate discount and free ticket
	function generate_ticket($type) {
		if ($type == 1) 
			$database = "discount_ticket";
		else 
			$database = "free_ticket";
		$arr = $this->db->query("SELECT * from $database WHERE activated = 0 LIMIT 1")->result();
		$row = $arr[0];
		$id = $row->id;
		$this->db->query("UPDATE $database SET activated=1 WHERE id=$id");
		echo $row->ticket_id;
	}
	
	function service()
	{

		//导入model
		$this->load->model('admin_model');
		$this->load->model('pagination_model');

		//从页面获取数据
		//貌似get方法获取不存在的 键，返回的值为0,
		//所以通过判断语句设置 应该从get中得到的值
		$service_name = $this->input->get('service_name')?$this->input->get('service_name'):NULL;
		$seller = $this->input->get('seller')?$this->input->get('seller'):NULL;
		$buyer = $this->input->get('buyer')?$this->input->get('buyer'):NULL;
		$status = $this->input->get('status')?$this->input->get('status'):0;
		$offset = $this->input->get('offset')?$this->input->get('offset'):0;
		

		//进行搜索
		$search_data = array(
			'service_name' => $service_name, 
			'seller' => $seller,
			'buyer' => $buyer,
			'status' => $status,
			);
		//参数：搜索内容，偏移量，每页显示数
		//返回：总记录数，搜索结果数组
		list($total,$search_result) = $this->admin_model->service_search($search_data,$offset,10);

		//页码导航
		$link_config = array(
			'total'=>$total,
			'offset'=>$offset,
			'search_data'=>$search_data,
			'pre_url'=>'admin/service',
			);
		$this->pagination_model->initialize($link_config);
		$link_array = $this->pagination_model->create_link();

		//页面显示
		$data = array(
			'search_data' => $search_data, 
			'service_info' => $search_result, 
			'link_array' => $link_array, 
			'total_rows'=>$total,
			);
		$this->load->view('admin/service',$data);
	}


	//end
}
