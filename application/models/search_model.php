<?php 
	class Search_model extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function getstr($string, $length, $encoding  = 'utf-8') {   
		    $string = trim($string);   
		    
		    if($length && strlen($string) > $length) {   
		        //截断字符   
		        $wordscut = '';   
		        if(strtolower($encoding) == 'utf-8') {   
		            //utf8编码   
		            $n = 0;   
		            $tn = 0;   
		            $noc = 0;   
		            while ($n < strlen($string)) {   
		                $t = ord($string[$n]);   
		                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {   
		                    $tn = 1;   
		                    $n++;   
		                    $noc++;   
		                } elseif(194 <= $t && $t <= 223) {   
		                    $tn = 2;   
		                    $n += 2;   
		                    $noc += 2;   
		                } elseif(224 <= $t && $t < 239) {   
		                    $tn = 3;   
		                    $n += 3;   
		                    $noc += 2;   
		                } elseif(240 <= $t && $t <= 247) {   
		                    $tn = 4;   
		                    $n += 4;   
		                    $noc += 2;   
		                } elseif(248 <= $t && $t <= 251) {   
		                    $tn = 5;   
		                    $n += 5;   
		                    $noc += 2;   
		                } elseif($t == 252 || $t == 253) {   
		                    $tn = 6;   
		                    $n += 6;   
		                    $noc += 2;   
		                } else {   
		                    $n++;   
		                }   
		                if ($noc >= $length) {   
		                    break;   
		                }   
		            }   
		            if ($noc > $length) {   
		                $n -= $tn;   
		            }   
		            $wordscut = substr($string, 0, $n);   
		        } else {   
		            for($i = 0; $i < $length - 1; $i++) {   
		                if(ord($string[$i]) > 127) {   
		                    $wordscut .= $string[$i].$string[$i + 1];   
		                    $i++;   
		                } else {   
		                    $wordscut .= $string[$i];   
		                }   
		            }   
		        }   
		        $string = $wordscut;   
		    }   
		    return trim($string);   
		}


		function getKey($key){
			$newkey = '%';
			for ($i = 0; $i < mb_strlen($key, 'UTF-8'); $i++)
				$newkey = $newkey.mb_substr($key, $i, 1, 'UTF-8').'%';
			return $newkey;
		}

		function getResult(){
			$this->load->helper('safe');
			jd_stopattack();
			$page = 1;$key = '';
			$fields = "id,name,author,price,originprice,publisher,ISBN,description,uploader,subscriber,subscribetime,finishtime,hasimg";
			if (array_key_exists('page', $_GET)) $page = $_GET['page'];
			if (array_key_exists('key', $_GET)) $key = $_GET['key'];
			//add to Table search to record user's action
			if ($this->session->userdata('is_logged_in')) {
				$user = $this->session->userdata('username');
			}
			else {
				$user = 'N';
			}
			$search_arr = array(
				'haskey' => 1,
				'key' => $key,
				'searcher' => $user);
			$this->db->insert('search', $search_arr);
			$i = mysql_insert_id();
			$this->db->query("UPDATE search SET searchtime = now() where id = $i");

			$begin = ($page - 1) * 20;
			$user = $this->session->userdata('username');
			$newkey = $this->getKey($key);
			$order = "order by ((CASE WHEN name LIKE '%$key%' THEN 2 ELSE 0 END) + (CASE WHEN author LIKE '%$key%' THEN 1 ELSE 0 END)) DESC, hasimg DESC, id DESC";
			
			//add discount and free scope search
			$scope = '';
			if (array_key_exists('scope', $_GET)) {
				if ($_GET['scope'] == 'discount') {
					$scope = 'AND (discount_sup = 1)';
				}
				else {
					$scope = 'AND (free_sup = 1)';
				}
			}
			$condition = "((CONCAT(name, author) LIKE \"$newkey\" OR uploader LIKE \"$key\") AND (subscriber = \"N\" OR subscriber = \"$user\" OR uploader = \"$user\") AND (id > 1) AND del != true AND (finishtime = \"0000-00-00 00:00:00\") $scope)";



			$query = "SELECT $fields FROM book WHERE $condition $order LIMIT $begin, 20;";
			if (strlen($key) == 0)
				$query = "SELECT $fields FROM book WHERE $condition ORDER BY hasimg DESC, id DESC LIMIT $begin, 20;";

			$result = $this->db->query($query)->result();
			$query = "SELECT $fields FROM book WHERE $condition;";
			$count = $this->db->query($query)->num_rows;
			
			return array("result"=>$result,'key'=>$key,'page'=>$page, 'count'=>$count);
			//return array("result"=>$result,'key'=>$key,'page'=>$page);
		}

		function getUserPhone($user){
			$query = "SELECT phone FROM user WHERE (username = \"$user\") ;";
			return $this->db->query($query)->result();
		}

		function getUserspaceResult($err = 0){
			$this->load->helper('safe');
			jd_stopattack();
			$fields = "id,name,author,price,originprice,publisher,ISBN,description,class,uploader,subscriber,subscribetime,finishtime,hasimg,status, use_phone";
			$user = $this->session->userdata('username');
			$query = "SELECT $fields FROM book WHERE (subscriber = \"$user\" AND del != true AND finishtime = \"0000-00-00 00:00:00\");";
			$result1 = $this->db->query($query)->result();

			// search for Service
			$this->load->model('user_model');
			$buyerId = $this->user_model->getIdByUsername();
			$res = $this->db->query("SELECT service_id from service_trade where buyer_id = $buyerId and finishtime = 0")->result();
			foreach ($res as $row) {
				$row_id = $row->service_id;
				$tmp = $this->db->query("SELECT $fields FROM book WHERE id = $row_id")->result();
				$result1 []= $tmp[0];
			}

			$query = "SELECT $fields FROM book WHERE (uploader = \"$user\" AND del != true AND subscriber != \"N\" AND finishtime = \"0000-00-00 00:00:00\");";
			$result2 = $this->db->query($query)->result();
			//search for Service
			$this->load->model('user_model');
			$buyerId = $this->user_model->getIdByUsername();
			$res = $this->db->query("SELECT id FROM book WHERE (uploader = \"$user\" AND del != true AND class LIKE 'Service%')")->result();
			$tmp = array();
			foreach ($res as $row) {
				$row_id = $row->id;
				$query = $this->db->query("SELECT service_id FROM service_trade WHERE (service_id = $row_id and finishtime = 0)");
				if ($query->num_rows() > 0) {
					$res = $query->result();
					$tmp []= $res[0]->service_id;
				}
			}
			foreach ($tmp as $id) {
				$query = "SELECT $fields FROM book WHERE id = $id";
				$res = $this->db->query($query)->result();
				$result2 []= $res[0];
			}

			$query = "SELECT $fields FROM book WHERE (uploader = \"$user\" AND del != true AND finishtime = \"0000-00-00 00:00:00\") ;";
			$result3 = $this->db->query($query)->result();
			$query = "SELECT $fields FROM book WHERE ((uploader = \"$user\" OR subscriber = \"$user\") AND del != true AND finishtime != \"0000-00-00 00:00:00\") ;";
			$result4 = $this->db->query($query)->result();
			// search for Service
			$this->load->model('user_model');
			$buyerId = $this->user_model->getIdByUsername();
			$res = $this->db->query("SELECT service_id from service_trade where buyer_id = $buyerId and finishtime > 0 and canceled = 0")->result();
			foreach ($res as $row) {
				$row_id = $row->service_id;
				$tmp = $this->db->query("SELECT $fields FROM book WHERE id = $row_id")->result();
				if (!empty($tmp))
					$result4 []= $tmp[0];
			}

			$user_phone = array();
			foreach ($result2 as $book){
				if ($book->use_phone == 1){
					$user_phone["$book->id"] = $this->getUserPhone($book->subscriber);
				}
			}
			$data = array("result1"=>$result1, "result2"=>$result2, "result3"=>$result3, "result4"=>$result4, "user_phone"=>$user_phone);
			
			if ($err == 0) $data['err'] = '';
			if ($err == 1) { 
				$data['err'] = '删除成功!';
				$data['is_success'] = true;
			}
			if ($err == 2) {
				$data['err'] = '删除失败!';
				$data['is_success'] = false;
			}
			if ($err == 3) {
				$data['err'] = '上传成功!';
				$data['is_success'] = true;
			}
			if ($err == 4) {
				$data['err'] = '修改书本信息成功!';
				$data['is_success'] = true;
			}
			if ($err == 5) {
                $data['err'] = '交易完成咯~~~';
                $data['is_success'] = true;
            }
            if ($err == 6) {
                $data['err'] = '交易未能成功完成登记!可能是网络出现问题！';
                $data['is_success'] = false;
            }
			if ($err == 7) {
                $data['err'] = '该书已交易完成，不能修改信息。';
                $data['is_success'] = false;
            }

			return $data;
			//return array("result1"=>$result1, "result2"=>$result2, "result3"=>$result3, "result4"=>$result4);
		}

		function getBookByClass($class="所有书本", $page=1) {
			$this->load->helper('safe');
			jd_stopattack();
			$fields = "id,name,author,price,originprice,publisher,ISBN,description,uploader,subscriber,subscribetime,finishtime,hasimg";
			$begin = ($page - 1) * 21;
			$user = $this->session->userdata('username');
			$order = "order by hasimg DESC, id DESC";
			if ($class=="所有书本") $class="";
			
			//add to Table search to record user's action
			if ($this->session->userdata('is_logged_in')) {
				$user = $this->session->userdata('username');
			}
			else {
				$user = 'N';
			}
			$search_arr = array(
				'haskey' => 0,
				'key' => $class,
				'searcher' => $user);
			$this->db->insert('search', $search_arr);
			$i = mysql_insert_id();
			$this->db->query("UPDATE search SET searchtime = now() where id = $i");

			$condition = "(class LIKE \"%$class%\" AND del != true AND (subscriber = \"N\" OR subscriber = \"$user\" OR uploader = \"$user\") AND (id > 1) AND (finishtime = \"0000-00-00 00:00:00\"))";
			$query = "SELECT $fields FROM book WHERE $condition $order LIMIT $begin, 21;";
			$result = $this->db->query($query)->result();
			$query = "SELECT $fields FROM book WHERE $condition;";
			$count = $this->db->query($query)->num_rows;
			if ($class=="") $class="所有书本";
			return array("result"=>$result,'class'=>$class,'page'=>$page, 'count'=>$count);
		}
		
		function getUserCollection() {
			$this->load->helper('safe');
			jd_stopattack();
			$fields = "id,name,author,price,originprice,publisher,ISBN,description,uploader,subscriber,subscribetime,finishtime,hasimg";
			$user = $this->session->userdata('username');
			$query = "SELECT book_id FROM user_collection WHERE (username = \"$user\" AND status = 1)";
			$result = $this->db->query($query)->result();
			$ans = array();
			foreach ($result as $row) {
				$i = $row->book_id;
				$query = "SELECT $fields FROM book WHERE (id = $i)";
				$rem = $this->db->query($query)->result();
				$ans []= $rem[0];
			}
			$data['result'] = $ans;
			return $data;
		}
	}

