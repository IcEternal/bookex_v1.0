<?php 
function isMobile() {
	$agent = $_SERVER['HTTP_USER_AGENT']; 
	if(strpos($agent,"NetFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") 
	|| strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS")) 
	return true;
	return false;
}