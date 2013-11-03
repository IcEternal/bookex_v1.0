<?php
/*
================================================================
upload_other.php

The upload page of service or other things.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
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

<div id="book_upload" class="content-full">
	<h2>请填写信息</h2>
	<form class="form-horizontal" action="<?php echo site_url('service_upload/upload_validation') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<div class="control-group">
		    <label class="control-label" for="bookname">服务名称</label>
		    <div class="controls">
		      	<input type="text" id="bookname" name="bookname" value="<?php echo set_value('bookname'); ?>" placeholder="服务名称">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="price">售出价格</label>
		    <div class="controls">
		     	<input type="text" id="price" name="price" value="<?php echo set_value('price'); ?>" placeholder="售出价格">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="remain">数量（库存）</label>
		    <div class="controls">
		     	<input type="text" id="remain" name="remain" value="<?php if (set_value('remain') == '') echo 1; else echo set_value('remain'); ?>" placeholder="数量（库存）">
		    </div>
		</div>

		<div class="control-group">
		    <label class="control-label" for="class">分类</label>
		    <div class="controls">
		     	<input type="text" id="class" readonly="readonly"
			     	data-toggle="popover" 
			     	name="class" 
			     	value="<?php echo set_value('class')?set_value('class'):'Service';?>" 
			     	placeholder="分类">
	    	</div>
		</div>

		<div class="control-group">
	    <div class="controls">
	      <label class="checkbox">
	        	<input type="checkbox" name="show" value="1" disabled checked="checked"> 愿意自行交易 
	      </label>
	      <span class="help-block">其他二手物品以及Service必须选择自行交易哦~<br/>即预订后买家能看到你的手机号~</span>
	    </div>
	    <input type="hidden" name="show" value="1"> 
  		</div>
		<div class="control-group">
	    <label class="control-label" for="description">简介</label>
	    <div class="controls">
	     	<textarea name="description" id="description" cols="60" rows="5"><?php echo set_value('description') ?></textarea>
	    </div>
		</div>
		<div class="control-group">
	    <label class="control-label" for="description">上传图片</label>
	    <div class="controls">
	    	<input type="hidden" name="max_file_size" value="2000000">
	     	<input type="text" id="filename" class="disabled" style="width: 148px;" disabled>
				<input type="button" class="btn" onclick="file.click();" value="浏览">  
				<input style="display: none" type="file" id="file" name="userfile" onchange="filename.value=this.value">
	     	<span class="help-inline">上传图片会使搜索排名靠前哦～</span>
	    </div>
		</div>			
	  	<input type="hidden" id="uploader" name="uploader" value="<?php echo $this->session->userdata('username') ?>">
		<div class="control-group">
		    <div class="controls">
		      	<button type="submit" class="btn">确认上传</button>
		    </div>
		</div>
	</form>
</div>

