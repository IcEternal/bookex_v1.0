<div class="container">
<?php if (form_error('bookname') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('bookname'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('price') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('price'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('originprice') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('originprice'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('userfile') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('userfile'); ?>
	</div>
<?php endif; ?>
<?php if (isset($isbn_error)): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $isbn_error; ?>
	</div>
<?php endif; ?>
</div>

<div id="book_upload" class="container">
<fieldset>
	<legend>快速上传书本</legend>
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
	<legend>上传 其他二手物品 或 Service 请<a href=" <?php echo site_url().'/book_upload/upload_other' ?>">点击此处</a>
	</legend>
	<legend>或 自行填写书本信息</legend>
	<?php $this->load->view('includes/book_upload_form'); ?>
</fieldset>
</div>


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

<!-- 51.la script -->
<div class="container" style="display:none">
<script language="javascript" type="text/javascript" src="http://js.users.51.la/15806741.js"></script>
</div>

