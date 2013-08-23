<?php 
	
class Admin extends CI_Controller {
	function index()
	{$this->db->where('del !=',TRUE);
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');
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
		//权限控制
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');

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

		//进行搜索
		$search_data = array(
			'book_name' => $book_name, 
			'uploader' => $uploader,
			'subscriber' => $subscriber,
			'no_reserve' => $no_reserve,
			'reserved' => $reserved,
			'del'=>$del,
			'traded' => $traded,
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
		//权限控制
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');

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
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');
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
		
		$this->load->view('admin/book_modify', $data);
	}

	function book_delete()
	{
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$this->admin_model->book_delete($id);
	}

	function book_hasit()
	{
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$this->admin_model->book_hasit($id);
	}

	function book_trade()
	{
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$this->admin_model->book_trade($id);
	}

	function book_cancel()
	{
		if ($this->session->userdata('username') != 'jtxpzyzhc') redirect('login');
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$this->admin_model->book_cancel($id);
	}

	function book_pay()
	{
		if ($this->session->userdata('username') != 'jtxpzyzhc') redirect('login');
		$id = $this->uri->segment(3);
		$this->load->model(order_model);
		$this->order_model->giveMoneyToSaler($id);
		redirect($_SERVER['HTTP_REFERER']);
	}

	
	function pay_get_book()
	{
		if ($this->session->userdata('username') != 'jtxpzyzhc') redirect('login');
		$id = $this->uri->segment(3);
		$this->load->model(order_model);
		$this->order_model->giveMoneyToSaler($id);
		$this->book_hasit();
		redirect($_SERVER['HTTP_REFERER']);
	}

	function user()
	{
		//权限控制
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');

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
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');
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
		
		//权限控制;
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');
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
		//权限控制;
		if ($this->session->userdata('username') != 'zhcpzyjtx') redirect('login');

		//导入model
		$this->load->model('admin_model');
		$this->load->model("order_model");

		$condition = 'trade_method = 1 AND trade_status = 1';

		$saler_query = $this->db->query("SELECT order_list.saler_id,
			COUNT(order_list.book_id)AS book_num,SUM(book.price) AS sum_price
			FROM order_list INNER JOIN book ON order_list.book_id = book.id WHERE $condition
			GROUP BY saler_id");
		$saler_list = $saler_query->result_array();
		foreach ($saler_list as $index => $saler) {
			$saler_id = $saler['saler_id'];
			$order_list_query = $this->db->query("SELECT id FROM order_list WHERE $condition");
			$saler_list[$index]['order_list'] = $order_list_query->result_array();
		}


		//页面显示
		$data = array(
			'saler_list'=>$saler_list,
			);
		$this->load->view('admin/trade',$data);
	}

	function order()
	{
		//权限控制
		if ($this->session->userdata('username') != 'jtxpzyzhc') redirect('login');

		//导入model
		$this->load->model('admin_model');
		$this->load->model('pagination_model');
		$this->load->model('order_model');

		//从页面获取数据
		//貌似get方法获取不存在的 键，返回的值为0,
		//所以通过判断语句设置 应该从get中得到的值
		$saler = $this->input->get('saler')?$this->input->get('saler'):0;
		$buyer = $this->input->get('buyer')?$this->input->get('buyer'):0;
		$offset = $this->input->get('offset')?$this->input->get('offset'):0;

		//进行搜索
		$search_data = array(
		"saler"=>	$saler ,
		"buyer"=>	$buyer 
			);
		//参数：搜索内容，偏移量，每页显示数
		//返回：总记录数，搜索结果数组
		list($total,$order_list) = $this->admin_model->order_search($search_data,$offset,10);

		//页码导航
		$link_config = array(
			'total'=>$total,
			'offset'=>$offset,
			'search_data'=>$search_data,
			'pre_url'=>'admin/order',
			);
		$this->pagination_model->initialize($link_config);
		$link_array = $this->pagination_model->create_link();

		//页面显示
		$data = array(
			'order_list'=>$order_list,
			'link_array'=>$link_array,
			'search_data'=>$search_data,
			'total_rows'=>$total,
			);
		$this->load->view('admin/order',$data);
	}


	function get_trade_remarks($book_id)
	{
		$this->load->model("order_model");
		$remarks = $this->order_model->getTradeRemarks($book_id);
		return $remarks;
	}

	function set_trade_remarks($book_id,$remarks)
	{
		$this->load->model("order_model");
		$this->order_model->setTradeRemarks($book_id,$remarks);
	}
}
