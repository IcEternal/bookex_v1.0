<?php 
function isMobile() {
	$agent = $_SERVER['HTTP_USER_AGENT']; 
	if(strpos($agent,"NetFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") 
	|| strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS")) 
	return true;
	return false;
}

function send_mail($to,$title,$content)
{
	$ci = &get_instance();
	$ci->load->library('email');            //加载CI的email类
	
	//以下设置Email参数
	$config['protocol'] = 'smtp';
	$config['smtp_host'] = 'smtp.163.com';
	$config['smtp_user'] = 'bookex';
	$config['smtp_pass'] = '2013bookexchange';
	$config['smtp_port'] = '25';
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	$ci->email->initialize($config);
	
	//以下设置Email内容
	$ci->email->from('bookex@163.com', 'BookEx');
	$ci->email->to($to);
	$ci->email->subject($title);
	$ci->email->message($content);

	$ci->email->send();
	//echo $ci->email->print_debugger();
}