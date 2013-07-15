<?php

class Order_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function createOrder($book_id,$trade_method)
	{
		//checkout the book available
		if($order_id = $this->find_order_id_by_book_id($book_id))
		{
			$trade_status = $this->find_trade_status($order_id);
			if($trade_status != 3)
			{
				return array(FALSE,'the book is not available');
			}
		}

		$uploader = $this->find_uploader_by_book_id($book_id);
		$saler_id = $this->find_user_id_by_username($uploader);
		$current_username = $this->session->userdata("username");
		$buyer_id = $this->find_user_id_by_username($current_username);

		$this->db->query("INSERT INTO order_list
			(book_id,saler_id,buyer_id,trade_method,trade_status,book_status,money_status)
			VALUES($book_id,$saler_id,$buyer_id,$trade_method,1,1,1)");
		//trade start ,book at saler hand,buyer should give saler money

		if($this->db->affected_rows())
		{
			$order_id = $this->db->insert_id();
			$this->orderRecorder($order_id);
			return array($order_id,'a new order has been created');
		}
		else
		{
			return array(FALSE,'order can not be created due to system error');
		}
	}

	function getBookFromSaler($book_id)
	{
		if($order_id = $this->find_order_id_by_book_id($book_id))
		{
			$book_status = $this->find_book_status($order_id);
			if($book_status == 1)// 1-书在卖家
			{
				$this->db->query("UPDATE order_list SET book_status = 2 WHERE id = $order_id");
				// 2 means book at delegation's hand
				if($this->db->affected_rows())
				{
					$this->orderRecorder($order_id);
					return array($order_id,'got book');
				}
				else
				{
					return array(FALSE,'system error');
				}
			}
			else
			{
				return array(FALSE,'system error');
			}
		}
		else
		{
			return array(FALSE,'the book is in the order list');
		}
		
	}

	function giveBookToBuyer($book_id)
	{
		if($order_id = $this->find_order_id_by_book_id($book_id))
		{
			$book_status = $this->find_book_status($order_id);
			if($book_status == 2)// 2-书在手上
			{
				$this->db->query("UPDATE order_list SET book_status = 3 WHERE id = $order_id");
				// 3-书在买家
				if($this->db->affected_rows())
				{
					$this->orderRecorder($order_id);
					return array($order_id,'got book');
				}
				else
				{
					return array(FALSE,'system error');
				}
			}
			else
			{
				return array(FALSE,'system error');
			}
		}
		else
		{
			return array(FALSE,'the book is in the order list');
		}

	}

	function giveMoneyToSaler($book_id)
	{
		if($order_id = $this->find_order_id_by_book_id($book_id))
		{
			$money_status = $this->find_money_status($order_id);
			switch ($money_status) {
				case 1: //1-买家应该给卖家钱，中介钱为0，  
					$this->db->query("UPDATE order_list SET money_status = 2 WHERE id = $order_id");
					//2-中介先付给卖家钱，中介钱为-x，
					if($this->db->affected_rows())
					{
						$this->orderRecorder($order_id);
						return array($order_id,'money has been given to saler from delegation');
					}
					else
					{
						return array(FALSE,'system error');
					}
					break;
				case 3://3-中介先收到买家钱，中介钱为+x，
					$this->db->query("UPDATE order_list SET money_status = 4 WHERE id = $order_id");
					//  4-交易完成，中介钱为0
					if($this->db->affected_rows())
					{
						$this->orderRecorder($order_id);
						return array($order_id,'money trade finished');
					}
					else
					{
						return array(FALSE,'system error');
					}
					break;
				
				default:
					return array(FALSE,'system error');
					break;
			}
		}
		else
		{
			return array(FALSE,'the book is in the order list');
		}
		
	}

	function getMoneyFromBuyer($book_id)
	{
		if($order_id = $this->find_order_id_by_book_id($book_id))
		{
			$money_status = $this->find_money_status($order_id);
			switch ($money_status) {
				case 1: //1-买家应该给卖家钱，中介钱为0，  
					$this->db->query("UPDATE order_list SET money_status = 3 WHERE id = $order_id");
					// 3-中介先收到买家钱，中介钱为+x，
					if($this->db->affected_rows())
					{
						$this->orderRecorder($order_id);
						return array($order_id,'money has been given to saler from delegation');
					}
					else
					{
						return array(FALSE,'system error');
					}
					break;
				case 2://2-中介先付给卖家钱，中介钱为-x，
					$this->db->query("UPDATE order_list SET money_status = 4 WHERE id = $order_id");
					//  4-交易完成，中介钱为0
					if($this->db->affected_rows())
					{
						$this->orderRecorder($order_id);
						return array($order_id,'money trade finished');
					}
					else
					{
						return array(FALSE,'system error');
					}
					break;
				
				default:
					return array(FALSE,'system error');
					break;
			}
		}
		else
		{
			return array(FALSE,'the book is in the order list');
		}
	}

	function closeOrder($book_id,$set_trade_status)
	{
		if($order_id = $this->find_order_id_by_book_id($book_id))
		{
			$trade_status = $this->find_trade_status($order_id);
			switch ($trade_status) {
				case 1: //1-交易开始
					$this->db->query("UPDATE order_list SET trade_status = $set_trade_status,finish_time = NOW() WHERE id = $order_id");
					if($this->db->affected_rows())
					{
						$this->orderRecorder($order_id);
						return array($order_id,'trade finished');
					}
					else
					{
						return array(FALSE,'system error');
					}
					break;
				default:
					return array(FALSE,'system error');
					break;
			}
		}
		else
		{
			return array(FALSE,'the book is in the order list');
		}
	}

	function setTradeRemarks($book_id,$remarks)
	{
		if($order_id = $this->find_order_id_by_book_id($book_id))
		{
			return array(FALSE,'the book is in the order list');
		}
		$this->db->query("UPDATE order_list SET remarks = $remarks WHERE id = $order_id");
		if($this->db->affected_rows())
		{
			return array($order_id,'remarks have been updated');
		}
		else
		{
			return array(FALSE,'system error');
		}
	}

	function getTradeRemarks($book_id)
	{
		if($order_id = $this->find_order_id_by_book_id($book_id))
		{
			return array(FALSE,'the book is in the order list');
		}
		$remarks_query = $this->db->query("SELECT remarks FROM order_list WHERE id = $order_id");
		$remarks = $remarks_query->row()->remarks;
		return $remarks;
	}

	function changeTradeMethod($book_id,$trade_method)
	{
		$order_id = $this->find_order_id_by_book_id($book_id);
		$this->db->query("UPDATE order_list SET trade_method = $trade_method 
			WHERE id = $order_id");
	}

	function tradeDetail($order_id)
	{
		$trade_info = array();
		$query = $this->db->query("SELECT * FROM order_list WHERE id = $order_id");
		if($query->num_rows())
		{
			$order_brief_object = $query->row();
			$trade_info['order_brief'] = $query->row_array();
		}
		else
		{
			return -1;
		}
		

		$book_info_query = $this->db->query("SELECT * FROM book WHERE id = $order_brief_object->book_id");
		$book_info_result = $book_info_query->result_array();
		$trade_info['book_info'] = $book_info_result[0];

		$saler_info_query = $this->db->query("SELECT * FROM user WHERE id = $order_brief_object->saler_id");
		$saler_info_result = $saler_info_query->result_array();
		$trade_info['saler_info'] = $saler_info_result[0];

		$buyer_info_query = $this->db->query("SELECT * FROM user WHERE id = $order_brief_object->buyer_id");
		$buyer_info_result = $buyer_info_query->result_array();
		$trade_info['buyer_info'] = $buyer_info_result[0];

		$order_detail_query = $this->db->query("SELECT * FROM order_record WHERE order_id = $order_brief_object->id");
		$order_detail_result = $order_detail_query->result_array();
		$trade_info['order_detail'] = $buyer_info_result;

		$trade_method_dict = array(
			'0'=>"unset",
			'1'=>'委托',
			'2'=>'自行',
			);

		$money_status_dict = array(
			'0'=>'unset',
			'1'=>'未付卖家',
			'2'=>'已付卖家',
			'3'=>'未付卖家',
			'4'=>'钱款付清',
			);

		$book_status_dict = array(
			'0'=>'unset',
			'1'=>'书在卖家',
			'2'=>'书在手上',
			'3'=>'送书完成',
			);

		$trade_status_dict = array(
			'0'=>'unset',
			'1'=>'开始',
			'2'=>'完成',
			'3'=>'取消',
			);

		$trade_info['order_brief']['trade_method_dict'] = $trade_method_dict[$trade_info['order_brief']['trade_method']];
		$trade_info['order_brief']['money_status_dict'] = $money_status_dict[$trade_info['order_brief']['money_status']];
		$trade_info['order_brief']['book_status_dict'] = $book_status_dict[$trade_info['order_brief']['book_status']];
		$trade_info['order_brief']['trade_status_dict'] = $trade_status_dict[$trade_info['order_brief']['trade_status']];

		return $trade_info;
	}


	private function orderRecorder($order_id)
	{
		$operator_name = $this->session->userdata("username");
		$operator_id = $this->find_user_id_by_username($operator_name);
		//get the operate code
		$query = $this->db->query("SELECT trade_method,trade_status,book_status,money_status 
			FROM order_list WHERE id = $order_id");
		if($query->num_rows())//if get the code
		{
			$result = $query->result();
			$row1 = $result[0];
			$operate_code = strval($row1->trade_method).strval($row1->trade_status).strval($row1->book_status).strval($row1->money_status);
			$add_record_query = $this->db->query("INSERT INTO order_record (order_id,operator_id,operate_code)VALUES($order_id,$operator_id,$operate_code)");
			if($this->db->affected_rows())
			{
				$record_id = $this->db->insert_id();
				return array($record_id,'record has been added');
			}
			else
			{
				return array(FALSE,'system error');
			}
		}
		else
		{
			return -1;
		}
		
	}

	private function find_order_id_by_book_id($book_id)
	{
		//find out the last order_id through the book_id,then change the status.
		//change the order status through book_id is not suggested,because a book may be subscribed several times.
		$get_id_query = $this->db->query("SELECT id FROM order_list WHERE book_id = $book_id ORDER BY id DESC");
		if($get_id_query->num_rows())
		{
			$get_id_result = $get_id_query->result();
			$row1 = $get_id_result[0];
			return $row1->id;
			//return the order_id
		}
		else
		{
			return 0;
			//can not find order_id
		}
	}

	private function find_user_id_by_username($username)
	{
		//FIND out the new_sub id 
		$query = $this->db->query("SELECT id FROM user WHERE username = \"$username\"");
		$result = $query->result();
		$row1 = $result[0];
		$user_id = $row1->id;
		return $user_id;
	}

	private function find_uploader_by_book_id($book_id)
	{
		$query = $this->db->query("SELECT uploader FROM book WHERE id = $book_id");
		$result = $query->result();
		$row1 = $result[0];
		$uploader = $row1->uploader;
		return $uploader;
	}

	private function find_trade_status($order_id)
	{
		$query = $this->db->query("SELECT trade_status FROM order_list WHERE id = $order_id");
		if($query->num_rows())
		{
			$result = $query->result();
			$row1 = $result[0];
			return $row1->trade_status;
		}
		else
		{
			return -1;
		}
	}

	private function find_money_status($order_id)
	{
		$query = $this->db->query("SELECT money_status FROM order_list WHERE id = $order_id");
		if($query->num_rows())
		{
			$result = $query->result();
			$row1 = $result[0];
			return $row1->money_status;
		}
		else
		{
			return -1;
		}
	}

	private function find_book_status($order_id)
	{
		$query = $this->db->query("SELECT book_status FROM order_list WHERE id = $order_id");
		if($query->num_rows())
		{
			$result = $query->result();
			$row1 = $result[0];
			return $row1->book_status;
		}
		else
		{
			return -1;
		}
	}

}
