<?php
function jd_ci() {
	return ($ci = &get_instance());
}

function jd_media_url($media) {
	return site_url("/media/$media->id");
}

function jd_play_url($mp3) {
	return site_url("/play/$mp3->id");
}

function jd_down_url($mp3){
	return site_url("/download/$mp3->id");
}

function jd_packdown_url($media){
	return site_url("/packdown/$media->id");
}

function jd_search_url($keyword){
	return site_url("/search?key=".urlencode($keyword));
}
function jd_tag_url($tag){
	return site_url("/tag/".urlencode($tag));
}

function jd_pagination($baseurl, $total, $limit, $segment) {
	jd_ci() -> load -> library('pagination');
	$config['base_url'] = site_url($baseurl);
	$config['total_rows'] = $total;
	$config['num_links'] = '5';
	$config['uri_segment'] = $segment;
	$config['per_page'] = $limit;
	$config['first_link'] = '首页';
	$config['last_link'] = '尾页';
	$config['page_query_string'] = TRUE;
	$config['query_string_segment'] = 'page';
	jd_ci() -> pagination -> initialize($config);
	$links = jd_ci() -> pagination -> create_links();
	return $links;
}

function jd_palylist_520tingshu($book_url){
	preg_match_all('/\\d+/', $book_url,$out);
	$play_link = "http://www.520tingshu.com/video/?" .$out[0][1]. "-0-0.html";
	$html = jd_request($play_link);
	preg_match_all("/\\/playdata.*?\\.js/", $html ,$out);
	$js_link = "http://www.520tingshu.com/".$out[0][0];
	$js_content = jd_request($js_link);
	preg_match_all("/(\\\u.*?\\$\\d+)/", $js_content ,$out);
	$rows = array();
	foreach ($out[0] as $line){
		$index = strpos($line, '$');
		$title = jd_unicode_decode(substr($line, 0,$index));
		$mp3link = "http://www.520tingshu.com/ting/down.php?id=".substr($line,$index+1);
		$rows [] = array("title"=>$title,"mp3link"=>$mp3link);
	}
	return $rows;
}
function jd_fetch_5tps_mp3($url){
	$response = jd_request($url);
	preg_match_all('/<embed.*?src="(.*?)"/', $response, $out);
	if(isset($out[1][0])){
		return $out[1][0];
	}else{
		return "";
	}
}

function jd_request($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//处理重定向
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//处理返回信息
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent'=>'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11'));
	$response = curl_exec($ch);//接收返回信息
	if($error = curl_errno($ch)){//出错则显示错误信息
		return $error;
	}
	curl_close($ch); //关闭curl链接
	return $response;
}

// unicode - utf8
function jd_unicode_decode($name)
{
	//return preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $name);
	return '';
}

function __zhuanhuan($url) {
	$urlodd=explode('//',$url,2);//把链接分成2段，//前面是第一段，后面的是第二段
	$head=strtolower($urlodd[0]);//PHP对大小写敏感，先统一转换成小写，不然 出现HtTp:或者ThUNDER:这种怪异的写法不好处理
	$behind=$urlodd[1];
	if($head=="thunder:"){
		$url=substr(base64_decode($behind), 2, -2);//base64解密，去掉前面的AA和后面ZZ
	}elseif($head=="flashget:"){
		$url1=explode("&",$behind,2);
		$url=substr(base64_decode($url1[0]), 10, -10);//base64解密，去掉前面后的[FLASHGET]
	}elseif($head=="qqdl:"){
		$url=base64_decode($behind);//base64解密
	}elseif($head=="http:"||$head=="ftp:"||$head=="mms:"||$head=="rtsp:"||$head=="https:"){
		$url=$url;//常规地址仅支持http,https,ftp,mms,rtsp传输协议，其他地貌似很少，像XX网盘实际上也是基于base64，但是有的解密了也下载不了
	}else{
		echo "本页面暂时不支持此协议";
	}
	return $url;
}

function jd_down_xunlei($url){
	$url=__zhuanhuan($url);
	$url_thunder="thunder://".base64_encode("AA".$url."ZZ");
	return $url_thunder;
}
function jd_down_flashget($url){
	$url=__zhuanhuan($url);
	$url_flashget="Flashget://".base64_encode("[FLASHGET]".$url."[FLASHGET]")."&aiyh";
	return $url_flashget;

}
function jd_down_qq($url){
	$url=__zhuanhuan($url);
	$url_qqdl="qqdl://".base64_encode($url);
}

function jd_player_mp3($mp3link){
	$player = '';
	$player.= '<object type="application/x-shockwave-flash" data="public/dewplayer/dewplayer.swf" width="200" height="20" id="dewplayer" name="dewplayer">';
	$player.= '<param name="movie" value="public/dewplayer/dewplayer.swf" />';
	$player.= '<param name="flashvars" value="volume=100&autostart=true&mp3='.$mp3link.'" />';
	$player.= '<param name="wmode" value="transparent" />';
	$player.= '</object>';
	return $player;
}

function jd_player_wma($mp3link){
	$player = '';
	$player.= '<object id="player" height="64" width="260" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6">';
	$player.= '<param NAME="AutoStart" VALUE="-1">';
	$player.= '<param NAME="Balance" VALUE="0">';
	$player.= '<param name="enabled" value="-1">';
	$player.= '<param NAME="EnableContextMenu" VALUE="-1">';
	$player.= '<param NAME="url" VALUE="'.$mp3link.'">';
	$player.= '<param NAME="PlayCount" VALUE="1">';
	$player.= '<param name="rate" value="1">';
	$player.= '<param name="currentPosition" value="0">';
	$player.= '<param name="currentMarker" value="0">';
	$player.= '<param name="defaultFrame" value="">';
	$player.= '<param name="invokeURLs" value="0">';
	$player.= '<param name="baseURL" value="">';
	$player.= '<param name="stretchToFit" value="0">';
	$player.= '<param name="volume" value="50">';
	$player.= '<param name="mute" value="0">';
	$player.= '<param name="uiMode" value="mini">';
	$player.= '<param name="windowlessVideo" value="0">';
	$player.= '<param name="fullScreen" value="0">';
	$player.= '<param name="enableErrorDialogs" value="-1">';
	$player.= '<param name="SAMIStyle" value>';
	$player.= '<param name="SAMILang" value>';
	$player.= '<param name="SAMIFilename" value>';
	$player.= '</object>';
	return  $player;
}
?>