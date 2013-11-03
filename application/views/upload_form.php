<?php
/*
================================================================
upload_form.php

Unknown page.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
<html>
<head>
<meta charset="utf-8">
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('upload/do_upload');?>

<form class="form-horizontal" action="<?php echo site_url('book_upload/upload') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<input type="text" id="filename" class="disabled" style="width: 148px;" disabled>
				<input type="button" class="btn" onclick="file.click();" value="浏览">  
				<input style="display: none" type="file" id="file" name="userfile" onchange="filename.value=this.value">

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>