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
<?php if (form_error('class') != ''): ?>
	<div class="alert alert-error fade in">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('class'); ?>
	</div>
<?php endif; ?>
</div>



<div id="book_modify" class="container">
<fieldset>
	<legend>修改书本信息</legend>
	<form class="form-horizontal" action="<?php echo site_url('book_upload/modify_validation') ?>/<?php echo $id ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<div class="control-group">
		    <label class="control-label" for="bookname">书本名称</label>
		    <div class="controls">
		      	<input type="text" id="bookname" name="bookname" value="<?php echo $name?>" placeholder="书本名称">
		    </div>
		</div>
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
	     	<span class="help-inline">比如新旧程度，有无笔记（笔记质量好坏）等<br/>若您想当面交易，可以将您的手机号写在简介中</span>
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
</fieldset>
</div>
