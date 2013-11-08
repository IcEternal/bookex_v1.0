<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth {

	private $admin = array('zukou', 'haichongfu2003', 'devillaw_zhc', 'zhcpzyjtx','Metamorphosis','gengyan','西南某馒头','jennasongsong','huanghaixin008','yellowoo', 'c462809','小汤包子','strayer','wangsijie','CJ0405','double11');
	private $sender = array();
	private $receiver = array();

	var $CI;

	public function __construct()
	{
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();
		$this->CI->load->model('user_model');
		$this->CI->load->model('book_model');
	}

	function is_admin() {
		return $this->CI->user_model->is_admin();
	}

	function is_uploader($book_id) {
		return $this->CI->book_model->is_uploader($book_id);
	}

	function is_subscriber($book_id) {
		return $this->CI->book_model->is_subscriber($book_id);
	}

	function auth_denied() {
		redirect('login');
	}

	function admin() {
		if (!$this->is_admin()) $this->auth_denied();
	}

	function uploader($book_id) {
		if (!$this->is_uploader($book_id) && !$this->is_admin()) $this->auth_denied();
	}

	function subscriber($book_id) {
		if (!$this->is_subscriber($book_id) && !$this->is_admin()) $this->auth_denied();
	}

	function uploader_or_subscriber($book_id) {
		if (!$this->is_subscriber($book_id) && !$this->is_uploader($book_id) && !$this->is_admin()) $this->auth_denied();
	}

 	//管理员
	function is_super_admin()
	{
		return (in_array($this->CI->session->userdata('username'), $this->admin));
	}

	function is_sender()
	{
		$username = $this->CI->session->userdata('username');
		return in_array($username,$this->sender);
	}

	function is_receiver()
	{
		$username = $this->CI->session->userdata('username');
		return in_array($username,$this->receiver);
	}

	function super_admin()
	{
		if(!$this->is_super_admin() )
		{
			$this->auth_denied();
		}
	}

	function normal_admin()
	{
		if(!$this->is_super_admin() && !$this->is_receiver() && !$this->is_sender() )
		{
			$this->auth_denied();
		}
	}

}
