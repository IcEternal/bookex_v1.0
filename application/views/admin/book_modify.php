<?php $this->load->view('includes/header') ?>

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
	<div class="alert <?php if($info['status']){echo 'alert-success';}else{echo 'alert-error';} //status=1表示成功信息，0表示失败?> fade in">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <?php echo $info['message'];?>
	</div>
	
</div>

<div id="book_modify" class="container">
<fieldset>
	<legend>修改<?php echo notOfBook($class)?"物品或服务":"书本";?>信息</legend>
	<div class="row">
	<div class="span3">
		<style type="text/css">
			table{
				margin-top: 20px;
			}

		</style>
		<img src = "<?php echo base_url('get_data.php?id='.$id); ?>" style = "width:100%" />
		<table class="table table-bordered table-hover">
			<tr><td>上传人</td><td><a target="_blank" href="<?php echo site_url('admin/user_modify/'.$uploader_id) ?>"><?php echo $uploader;?></a></td></tr>
			<tr><td>预订人</td><td><?php if(isset($subscriber_id)){echo anchor(site_url('admin/user_modify/'.$subscriber_id),$subscriber);}else{echo $subscriber;}?></td></tr>
			<tr><td>预定记录</td><td><?php echo $subscribetime?></td></tr>
			<tr><td>交易时间</td><td><?php echo $finishtime?></td></tr>
		</table>
	</div>

	<div class="span9">
	<form class="form-horizontal" action="<?php echo site_url('admin/book_modify/'.$id) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
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
	     		"简单描述下服务或者物品。<br/>工作人员会对您上传的服务及物品进行审核<br/>若有商业行为或侵害他人利益嫌疑的，我们会通知您并删除该服务及物品"
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
	    </div>
		</div>				
		<div class="control-group">
		    <div class="controls">
		      	<input type="submit" class="btn" name="submit" value="确认上传">
		</div>
	</form>
	</div>
	</div>
</fieldset>
</div>
<?php $this->load->view('includes/footer') ?>