<html>
<head>
	<meta charset="utf-8">
</head>
<body>

<?php 
$str='脚本之家:http://www.jb51.net'; 
echo mb_substr($str,0,8,'utf-8');//截取头5个字，假定此代码所在php文件的编码为utf-8 
?> 

</body>
</html>