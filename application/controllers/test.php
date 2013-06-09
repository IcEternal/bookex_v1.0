<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		$this->db->where('finishtime > 0');
		$query = $this->db->get('book')->result();
		$diff = 0;
		foreach ($query as $row) {
			$diff += $row->originprice - $row->price;
		}
		echo $diff;
	}

}
