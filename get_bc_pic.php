<?php  
if(isset($_GET['id'])) {  
	$id = $_GET['id'];
	$connect = MYSQL_CONNECT("172.16.6.107", "bookex", "Xy!SpJZlpS2m") or die("Unable to connect to MySQL server");
	mysql_select_db("bookex") or die("Unable to select database");

	if($id)
	{
		$query = "select * from book_collect where bc_id='$id'";  
		$result = @MYSQL_QUERY($query);  
		$out=mysql_fetch_array($result);
		if (empty($out["img"])) {
			$query = "select * from book where id=1 ";  
			$result = @MYSQL_QUERY($query);  

			$out=mysql_fetch_array($result);
			$data=$out['img'];
		}
		else 
			$data=$out["img"];
		Header( "Content-type: image/jpg");  
		echo $data;  
	}
	else
	{
		$query = "select * from book where id=1 ";  
		$result = @MYSQL_QUERY($query);  

		$out=mysql_fetch_array($result);
		$data=$out['img'];
		Header( "Content-type: image/jpg");  
		echo $data; 
	}
}
