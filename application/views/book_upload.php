<?php
/*
================================================================
book_upload.php

include: includes/book_upload_form.php

The page of book uploading.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>

<?php //alert ?>
<?php if (form_error('bookname') != ''): ?>
	<div class="main-alert">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
  	<?php echo form_error('bookname'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('price') != ''): ?>
	<div class="main-alert">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
  	<?php echo form_error('price'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('originprice') != ''): ?>
	<div class="main-alert">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
  	<?php echo form_error('originprice'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('userfile') != ''): ?>
	<div class="main-alert">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
  	<?php echo form_error('userfile'); ?>
	</div>
<?php endif; ?>
<?php if (isset($isbn_error)): ?>
	<div class="main-alert">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
  	<?php echo $isbn_error; ?>
	</div>
<?php endif; ?>

<div class="content-full"><!-- structure -->
	<h2>快速上传书本</h2>
	<div class="row">
		<div class="span5">
			<form class="form-search" action="<?php echo site_url('book_upload/book_isbn') ?>" method="get" accept-charset="utf-8">
			  <input type="text" name ="book_isbn" class="input-medium search-query">
			  <button id="isbn_btn" type="submit" class="btn">通过ISBN快速上传</button>
			</form>
		</div>
		<div class="span7">
			<form class="form-search" action="<?php echo site_url('book_upload/book_select') ?>" method="get" accept-charset="utf-8">
			  <input type="text" name ="book_name" class="input-medium search-query">
			  <button id="q_btn" type="submit" class="btn">搜索书名上传</button>
			</form>
		</div>
	</div>
</div><!-- content-full -->
<div class="content-full"><!-- structure -->
	<h2>
		上传 其他二手物品 或 Service 请<a href=" <?php echo site_url().'/book_upload/upload_other' ?>">点击此处</a>
	</h2>
</div><!-- content-full -->

<div class="content-full"><!-- structure -->
	<h2>或 自行填写书本信息</h2>
	<?php $this->load->view('includes/book_upload_form'); ?>
</div><!-- content-full -->


<div class="modal fade hide" id="dataLoad">
  <div class="modal-header">
    <h3>提示</h3>
  </div>
  <div class="modal-body">
    <p>正在从豆瓣拉取书本信息...</p>
    <p>读取时间取决于当前网络环境...</p>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal" aria-hidden="true">关闭提示框继续等待</a>
  </div>
</div>