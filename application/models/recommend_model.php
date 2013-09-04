<?php 

class Recommend_model extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function getResult(){
			$this->load->model("search_model");
			//we need at least a $result and a $count returned.
			return $this->search_model->getResult();
		}
}
