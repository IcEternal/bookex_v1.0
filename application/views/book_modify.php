<?php
/*
================================================================
book_modify.php

The page of book modifying.

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
<?php if (form_error('class') != ''): ?>
	<div class="main-alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('class'); ?>
	</div>
<?php endif; ?>

<div class="content-full"><!-- structure -->
	<h2>修改<?php echo notOfBook($class)?"物品或服务":"书本";?>信息</h2>
	<form class="form-horizontal" action="<?php echo site_url('book_upload/modify_validation') ?>/<?php echo $id ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<div class="control-group">
		    <label class="control-label" for="bookname"><?php echo notOfBook($class)?"物品或服务":"书本";?>名称</label>
		    <div class="controls">
		      	<input type="text" id="bookname" name="bookname" value="<?php echo $name?>" placeholder="<?php echo notOfBook($class)?"物品或服务":"书本";?>名称">
		    </div>
		</div>
		<?php if (!notOfBook($class)) { ?>
		<div class="control-group">
		    <label class="control-label" for="author">作者</label>
		    <div class="controls">
		     	<input type="text" id="author" name="author" value="<?php echo $author ?>" placeholder="作者">
		    	<span class="help-inline">如有多个作者请用空格分开.</span>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="publisher">出版社</label>
		    <div class="controls">
		      	<input type="text" id="publisher" name="publisher" value="<?php echo $publisher ?>" placeholder="出版社">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="isbn">ISBN</label>
		    <div class="controls">
		      <input type="text" id="isbn" name="isbn" value="<?php echo $isbn ?>" placeholder="ISBN">
		    	<span class="help-inline">选填</span>	
		    </div>
		</div>
		<?php } ?>
		<div class="control-group">
	    <label class="control-label" for="originprice">原价</label>
	    <div class="controls">
	     	<input type="text" id="originprice" name="originprice" value="<?php echo $originprice ?>" placeholder="原价">
	    </div>
		</div>
		<div class="control-group">
	    <label class="control-label" for="price">售出价格</label>
	    <div class="controls">
	     	<input type="text" id="price" name="price" value="<?php echo $price ?>" placeholder="售出价格">
	    </div>
		</div>
		
		<div class="control-group">
		    <label class="control-label" for="class">图书分类</label>
		    <div class="controls">
		     	<input type="text" id="class" readonly="readonly"
			     	data-toggle="popover" 
			     	name="class" 
			     	value="<?php echo $class; ?>" 
			     	placeholder="图书分类">
	    	</div>
		</div>

		<div class="control-group">
	    <div class="controls">
	      <label class="checkbox">
	        <input type="checkbox" name="show" value="1" 
	        <?php if($show == true){echo 'checked="checked"';}?> > 愿意自行交易
	      </label>
	      <span class="help-block">选中此项后，预订此书的用户将能看到您的手机号码。</span>
	    </div>
	  </div>
		<div class="control-group">
	    <label class="control-label" for="description">简介</label>
	    <div class="controls">
	     	<textarea name="description" id="description" cols="60" rows="5"><?php echo $description ?></textarea>
	     	<span class="help-inline">
	     		<?php echo notOfBook($class)?
	     		"简单描述下服务或者物品。<br/>请勿在介绍中出现手机号等联系方式，如有必要请致信bookex@163.com<br/>工作人员会对您上传的服务及物品进行审核<br/>若有商业行为或侵害他人利益嫌疑的，我们会通知您并删除该服务及物品"
	     		:
	     		"比如新旧程度，有无笔记（笔记质量好坏）等";?>
	     	</span>
	    </div>
		</div>
		<div class="control-group">
	    <label class="control-label" for="description">上传图片</label>
	    <div class="controls">
	    	<input type="hidden" name="max_file_size" value="2000000">
	     	<input type="text" id="filename" class="disabled" style="width: 148px;" disabled>
				<input type="button" class="btn" onclick="file.click();" value="浏览">  
				<input style="display: none" type="file" id="file" name="userfile" onchange="filename.value=this.value">
		<span class="help-inline">上传图片有助于提高书的出售率哦～</span>
                <span class="help-block">若不上传图片则将会使用默认图片.<br /> 书本图片可以在z.cn亚马逊上轻松找到哦～</span>

	    </div>
		</div>				
	  
	  	<input type="hidden" id="uploader" name="uploader" value="<?php echo $this->session->userdata('username') ?>">
		<div class="control-group">
		    <div class="controls">
		      	<button type="submit" class="btn">确认上传</button>
		    </div>
		</div>
	</form>
</div><!-- content-full -->

<?php include("includes/upload_form_ajax.php") ?>
