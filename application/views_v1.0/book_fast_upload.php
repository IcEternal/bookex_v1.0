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
<?php if (form_error('class') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('class'); ?>
	</div>
<?php endif; ?>
</div>


<div id="book_upload" class="container">
<fieldset>
	<legend>快速上传书本</legend>
	<div class="row">
		<div id = "left" class = "span3 text-center">
			<div class="thumbnail">
				<div class="image" style = "width:100%">
					<img src =" <?php echo base_url('get_bc_pic.php?id='.$bc_id); ?>" style = "width:100%" />
				</div>
			</div>
		</div>
		<div class="span9">
			<form class="form-horizontal" action="<?php echo site_url('book_upload/fast_upload_validation/'.$bc_id) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
			<div class="control-group">
			    <label class="control-label" for="bookname">书本名称</label>
			    <div class="controls">
			      	<input type="text" id="bookname" name="bookname" value="<?php echo isset($book_info->title)?$book_info->title:set_value('bookname'); ?>" placeholder="书本名称">
			    </div>
			</div>
			<div class="control-group">
			    <label class="control-label" for="author">作者</label>
			    <div class="controls">
			     	<input type="text" id="author" name="author" value="<?php echo isset($book_info->author)?$book_info->author:set_value('author'); ?>" placeholder="作者">
			    	<span class="help-inline">如有多个作者请用空格分开.</span>
			    </div>
			</div>
			<div class="control-group">
			    <label class="control-label" for="publisher">出版社</label>
			    <div class="controls">
			      	<input type="text" id="publisher" name="publisher" value="<?php echo isset($book_info->publisher)?$book_info->publisher:set_value('publisher'); ?>" placeholder="出版社">
			    </div>
			</div>
			<div class="control-group">
			    <label class="control-label" for="isbn">ISBN</label>
			    <div class="controls">
			      <input type="text" id="isbn" name="isbn" readonly="readonly" value="<?php echo isset($book_info->ISBN)?$book_info->ISBN:set_value('isbn'); ?>" placeholder="ISBN">
			    </div>
			</div>
			<div class="control-group">
		    <label class="control-label" for="originprice">原价</label>
		    <div class="controls">
		     	<input type="text" id="originprice" name="originprice" value="<?php echo isset($book_info->price)?$book_info->price:set_value('originprice'); ?>" placeholder="原价">
		    	<span class="help-inline">如为美元或其他计价单位请自行转换为人民币为单位,谢谢!</span>
		    </div>
			</div>
			<div class="control-group">
		    <label class="control-label" for="price">售出价格</label>
		    <div class="controls">
		     	<input type="text" id="price" name="price" value="<?php echo set_value('price'); ?>" placeholder="售出价格">
		    </div>
			</div>

			<div class="control-group">
			    <label class="control-label" for="class">图书分类</label>
			    <div class="controls">
			     	<input type="text" id="class" readonly="readonly"
				     	data-toggle="popover" 
				     	name="class" 
				     	value="<?php echo set_value('class')?set_value('class'):'教材教辅';?>" 
				     	placeholder="图书分类">
		    	</div>
			</div>

			<div class="control-group">
		    <div class="controls">
		      <label class="checkbox">
		        <input type="checkbox" name="show" value="1"  
							<?php   
							if (isset($use_or_not)) {  
							if ($use_or_not) echo 'checked="checked"';  
							}  
							?>  
						> 愿意自行交易  

		      </label>
		      <span class="help-block">选择自行交易可以出去走走并且认识新同学哈～<br/>选中此项后，预订此书的用户将能看到您的手机号码。</span>
		    </div>
	  	</div>
			<div class="control-group">
			    <label class="control-label" for="description">简介</label>
			    <div class="controls">
			     	<textarea name="description" id="description" cols="60" rows="5"><?php echo set_value('description') ?></textarea>
			     	<span class="help-inline">比如新旧程度，有无笔记（笔记质量好坏）等。</span>
			    </div>
			</div>
		  <input type="hidden" id="uploader" name="uploader" value="<?php echo $this->session->userdata('username') ?>">
			<div class="control-group">
			    <div class="controls">
			      	<button type="submit" class="btn">确认上传</button>
			    </div>
		</div>
		</form>
		</div><!-- span 8 -->
	</div><!-- row -->
	
</fieldset>
</div>
