<?php

if(!function_exists('jd_stopattack')){
	function jd_stopattack(){
		$getfilter="'|\\b(and|or)\\b.+?(>|<|=|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
		$postfilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
		$cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

		$referer=empty($_SERVER['HTTP_REFERER']) ? array() : array($_SERVER['HTTP_REFERER']);

		foreach($_GET as $key=>$value){
			__stopattack($key,$value,$getfilter);
		}
		foreach($_POST as $key=>$value){
			__stopattack($key,$value,$postfilter);
		}
		foreach($_COOKIE as $key=>$value){
			__stopattack($key,$value,$cookiefilter);
		}
		foreach($referer as $key=>$value){
			__stopattack($key,$value,$getfilter);
		}
	}

	function __stopattack($StrFiltKey,$StrFiltValue,$ArrFiltReq){
		$StrFiltValue=__arr_foreach($StrFiltValue);
		if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){
			//__slog("<br><br>操作IP: ".$_SERVER["REMOTE_ADDR"]."<br>操作时间: ".strftime("%Y-%m-%d %H:%M:%S")."<br>操作页面:".$_SERVER["PHP_SELF"]."<br>提交方式: ".$_SERVER["REQUEST_METHOD"]."<br>提交参数: ".$StrFiltKey."<br>提交数据: ".$StrFiltValue);
			print  "<div style=\"position:fixed;top:0px;width:100%;height:100%;background-color:white;color:red;font-weight:bold;border-bottom:5px solid #999;\"><br>您提交的参数非法,系统已记录您的本次操作！</div>";
			exit();
		}
		if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){
			//__slog("<br><br>操作IP: ".$_SERVER["REMOTE_ADDR"]."<br>操作时间: ".strftime("%Y-%m-%d %H:%M:%S")."<br>操作页面:".$_SERVER["PHP_SELF"]."<br>提交方式: ".$_SERVER["REQUEST_METHOD"]."<br>提交参数: ".$StrFiltKey."<br>提交数据: ".$StrFiltValue);
			print  "<div style=\"position:fixed;top:0px;width:100%;height:100%;background-color:white;color:red;font-weight:bold;border-bottom:5px solid #999;\"><br>您提交的参数非法,系统已记录您的本次操作！</div>";
			exit();
		}
	}

	function __slog($logs)
	{
		$toppath=$_SERVER["DOCUMENT_ROOT"]."/log.htm";
		$Ts=fopen($toppath,"a+");
		fputs($Ts,$logs."\r\n");
		fclose($Ts);
	}

	function __arr_foreach($arr) {
		static $str;
		if (!is_array($arr)) {
			return $arr;
		}
		foreach ($arr as $key => $val ) {
			if (is_array($val)) {
				__arr_foreach($val);
			} else {
				$str[] = $val;
			}
		}
		return implode($str);
	}
}

?>