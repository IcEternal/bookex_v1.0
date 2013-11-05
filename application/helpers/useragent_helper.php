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
	// $config['smtp_host'] = 'smtpcloud.sohu.com';
	// $config['smtp_user'] = 'postmaster@pingpang.sendcloud.org';
	// $config['smtp_pass'] = 'ITFDaKG0';
	$config['smtp_host'] = 'smtp.163.com';
	$config['smtp_user'] = 'tangqi00mail@163.com';
	$config['smtp_pass'] = 'foxami00';
	$config['smtp_port'] = '25';
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'text';
	$ci->email->initialize($config);
	
	//以下设置Email内容
	$ci->email->from('tangqi00mail@163.com', 'Pingpang magazine');
	$ci->email->to($to);
	$ci->email->subject($title);
	$ci->email->message($content);

	$ci->email->send();
	echo $ci->email->print_debugger();

}
//批量、短时发送
function batch_mail($to,$title,$content)
{
	//echo "<meta charset='utf8'>";
	//echo "sendCloud 批量邮件程序开始<br>";

	$post_arr = array(
		'to'=>$to,
		'title'=>$title,
		'content'=>$content
		);
	$data_str = http_build_query($post_arr);
	$url = 'http://zukou.sinaapp.com/index.php/api/email/batch_mail';
	
	// 设置完毕，发送到 自己设置的sina服务器上，服务器返回数据
	// 返回数据格式：json (to result) 
	// result = 0 表示任务执行失败
	$ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
    $result_json = curl_exec($ch);
    curl_close($ch);
	$result_arr = json_decode($result_json);
	if($result_arr == NULL)
	{
		//echo '与新浪服务器连接失败';
		return;
	}
	else
	{
		//echo '与新浪服务器连接成功';
	}

	//echo '发送到'.$result_arr->to.'<br>';
	if($result_arr->result)
	{
		$show_result = '成功';
	}
	else
	{
		$show_result = '失败';
	}
	//echo '状态:'.$show_result.'<br>';
}
//触发，单个邮件
function tran_mail($to,$title,$content)
{
	//echo "<meta charset='utf8'>";
	//echo "sendCloud 触发邮件程序开始<br>";

	$post_arr = array(
		'to'=>$to,
		'title'=>$title,
		'content'=>$content
		);
	$data_str = http_build_query($post_arr);
	$url = 'http://zukou.sinaapp.com/index.php/api/email/tran_mail';
	
	// 设置完毕，发送到 自己设置的sina服务器上，服务器返回数据
	// 返回数据格式：json (to result) 
	// result = 0 表示任务执行失败
	$ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
    $result_json = curl_exec($ch);
    curl_close($ch);
	$result_arr = json_decode($result_json);
	if($result_arr == NULL)
	{
		//echo '与新浪服务器连接失败';
		return;
	}
	else
	{
		//echo '与新浪服务器连接成功';
	}

	//echo '发送到'.$result_arr->to.'<br>';
	if($result_arr->result)
	{
		$show_result = '成功';
	}
	else
	{
		$show_result = '失败';
	}
	//echo '状态:'.$show_result.'<br>';
}
