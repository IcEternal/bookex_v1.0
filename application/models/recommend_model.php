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
			$this->load->model("search_model");
			//we need at least a $result and a $count returned.
			return $this->search_model->getResult();
		}
}
