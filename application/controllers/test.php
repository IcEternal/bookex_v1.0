<?php 

class Test extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index() {
		$this->db->where('finishtime > 0 AND finishtime < "2013-9-15 22:00:00" AND subscriber != "N"');
		$arr = $this->db->get('book')->result();
		$tot = 0;
		$save = 0;
		$num = 0;
		foreach ($arr as $row) {
			$tot += $row->price;
			$save += $row->originprice - $row->price;
			$num++;
		}
		echo "total saved:  ".$save."!!<br/>";
		echo "total sold:  ".$tot."!!<br/>";
		echo "total sold:  ".$num."books!";
	}

	/*
	function generate_ticket() {
		$arr = array();
		$max = 2000000000;
		//discount_ticket
		for ($i = 0;$i < 5000;$i++) {
			$x = rand(0, $max);
			while (isset($arr["$x"])) {
				$x = rand(0, $max);
			}
			$arr["$x"] = true;
			$str = (string)dechex($x);
			$data = array(
				'ticket_id' => $str,
				'activated' => false,
				'used' => false
				);
			$this->db->insert('discount_ticket', $data);
		}

		//free_ticket
		for ($i = 0;$i < 1000;$i++) {
			$x = rand(0, $max);
			while (isset($arr["$x"])) {
				$x = rand(0, $max);
			}
			$arr["$x"] = true;
			$str = (string)dechex($x);
			$data = array(
				'ticket_id' => $str,
				'activated' => false,
				'used' => false
				);
			$this->db->insert('free_ticket', $data);
		}
	}
	*/
}
