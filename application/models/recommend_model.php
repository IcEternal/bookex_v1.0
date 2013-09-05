<?php 

class Recommend_model extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function getstr($string, $length, $encoding  = 'utf-8') {   
		    $this->load->model("search_model");
		    return $this->search_model->getstr($string, $length, $encoding);
		}
		
		function getResult(){
			$data['result'] = $this->db->query('SELECT id, name, originprice, price from book where (recommend = 1 AND finishtime = 0 AND del = 0 AND hasimg = 1) ORDER BY rand()')->result();
			//we need at least a $result and a $count returned.
			return $data;
		}
}
