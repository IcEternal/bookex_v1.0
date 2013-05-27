<?php 
	
class Admin extends CI_Controller {
	function index()
	{
		$data = array();
		$book_result = $this->db->select('count(id) AS book_num')->from('book')->get()->result();
		$row1 = $book_result[0];
		$data['book_num'] = $row1->book_num;

		$book_result = $this->db->select('count(id) AS book_num')->from('book')->where('subscriber','N')->get()->result();
		$row1 = $book_result[0];
		$data['book_unreserved_num'] = $row1->book_num;

		$book_result = $this->db->select('count(id) AS book_num')->from('book')
		->where('subscriber !=','N')->where('finishtime',0)->get()->result();
		$row1 = $book_result[0];
		$data['book_reserved_num'] = $row1->book_num;

		$book_result = $this->db->select('count(id) AS book_num')->from('book')
		->where('finishtime >',0)->get()->result();
		$row1 = $book_result[0];
		$data['book_traded_num'] = $row1->book_num;

		
		$user_result = $this->db->select('count(id) AS user_num')->from('user')->get()->result();
		$row1 = $user_result[0];
		$data['user_num'] = $row1->user_num;
		
		$this->load->view('admin/index',$data);
	}

	//展示书本，
	//参数total_rows 表示每页显示多少行
	function book()
	{
		$this->load->model('admin_model');
		$cur_page = $this->uri->segment(3);
		//搜索结果显示
		$result = $this->admin_model->book_search($cur_page,10);//传入当前页，每页显示数
		$query = $result['query'];
		$total_rows = $result['total_rows'];
		//页码显示
		$this->admin_model->page_set($total_rows,10,'book');//参数：结果数,每页显示数,模式
		$data['book_info'] = $query->result();
		
		$this->load->view('admin/book',$data);
	}

	//修改书本
	//url 传递书本id
	function book_modify()
	{
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$data = array();
		//从user表中找到该书的上传者id
		$result = $this->db->select('user.id')->from('user')
		->join('book','book.uploader = user.username')
		->where('book.id',$id)->get()->result();
		$row1 = $result[0];
		$data['uploader_id'] = $row1->id;

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
		
		$this->load->view('admin/book_modify', $data);
	}

	function book_delete()
	{
		$id = $this->uri->segment(3);
		$this->load->model('admin_model');
		$this->admin_model->book_delete($id);
	}

	function user()
	{
		$this->load->model('admin_model');
		$cur_page = $this->uri->segment(3);
		//搜索结果显示
		$result 	= $this->admin_model->user_search($cur_page,10);//传入当前页，每页显示数
		$query 		= $result['query'];
		$total_rows = $result['total_rows'];
		//页码显示
		$this->admin_model->page_set($total_rows,10,'user');//参数：结果数,每页显示数，模式
		$data['user_info'] = $query->result();
		$this->load->view('admin/user',$data);
	}

	function user_modify(){
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
		$this->load->view('admin/user_modify', $data);
	}

	//预设条件搜索,就像带有信息的url，用get处理，这里用session
	function sess_book_search($uploader)
	{
		//清除书本搜索session
		$this->session->unset_userdata('no_reserve');
		$this->session->unset_userdata('reserved');
		$this->session->unset_userdata('traded');

		$this->session->unset_userdata('book_info');
		$this->session->unset_userdata('uploader');
		$this->session->unset_userdata('subscriber');

		$search_data = array(
		'book_info' => $this->input->post('book_info'),//如果post的值未设置，函数传回false ，然后session也会被设置
		'uploader' => $uploader,
		'subscriber' => $this->input->post('subscriber'),
		'no_reserve' => 1,
		'reserved' => 1,
		'traded' => 1);
		$this->session->set_userdata($search_data);

		redirect(site_url().'/admin/book');
	}

}