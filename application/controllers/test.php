<?php 

class Test extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index() {
		$this->db->where('finishtime > 0 AND subscriber != "N"');
		$arr = $this->db->get('book')->result();
		$tot = 0;
		$save = 0;
		foreach ($arr as $row) {
			$tot += $row->price;
			$save += $row->originprice - $row->price;
		}
		echo "total saved:  ".$save."!!<br/>";
		echo "total sold:  ".$tot."!!";
	}
}
