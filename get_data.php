<?php  
if(isset($_GET['id'])) {  
$id = $_GET['id'];
$connect = MYSQL_CONNECT("172.16.6.107", "bookex", "Xy!SpJZlpS2m") or die("Unable to connect to MySQL server");
mysql_select_db("bookex") or die("Unable to select database");

$query = "select hasimg,img from book where id='$id'";  
$result = @MYSQL_QUERY($query);  

$out=mysql_fetch_array($result);

if ($out['hasimg']) {
	$data=$out["img"];
	header("Cache-Control: max-age=8");
	Header( "Content-type: image/jpg");  
	echo $data;  
}
else {
	$query = "select img from book where id='1'";  
	$result = @MYSQL_QUERY($query);  

	$out=mysql_fetch_array($result);
	$data=$out['img'];
	header("Cache-Control: max-age=8");
	Header( "Content-type: image/jpg");  
	echo $data; 
} 
}
