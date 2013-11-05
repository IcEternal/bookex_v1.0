<?php
/*
================================================================
book_fast_upload.php

The page of book uploading via ISBN.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
<?php //result alert ?>
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
<?php if (form_error('class') != ''): ?>
	<div class="main-alert">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
  	<?php echo form_error('class'); ?>
	</div>
<?php endif; ?>

<div id="content"><!-- structure -->

	<h2>快速上传书本</h2>
	<div class="row">
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

</div><!-- content -->

<div id="sidebar"><!-- structure -->
	<div id="book-details-image">
		<img src = "<?php echo base_url('get_bc_pic.php?id='.$bc_id); ?>" width="230px" />
	</div>
</div><!-- sidebar -->

<script>
	$(function (){
		$.ajax({
	        type:"GET",
	        url:"<?php echo base_url(); ?>classification.xml",
	        dataType:"xml",
	        success:function(xml){
	        	//构建分类导航栏，在DOM中hide
	            var nav = $("<ul>").addClass("nav").addClass("nav-list");
	            var lv1class;
	            $(xml).find("class").each(function(i){
	                var classname = $(this).attr("name");
	                var lv = $(this).attr("lv");
	                if(lv == 1)
	                {
	                		lv1class = classname;
	                    var li = $("<li>").addClass("nav-header").attr("name",classname);
	                    // var divider = $("<li>").addClass("divider");
	                    var url = "<?php echo site_url('book_view/book') ?>"+"/"+classname+"/1";
	                    url = encodeURI(url);
	                    var anchor = $("<a>").text(classname).attr({"href":url}).css({"font-size":"15px","color":"#E47911"});
	                    var url_classname = "<?php echo urldecode($this->uri->segment(3));?>";
	                    li.append(anchor);
	                    nav.append(li);
	                    // nav.append(divider);
	                }
	                else //if(lv == 2)
	                {
	                    var li = $("<li>").attr("name",classname);
	                    var url = "<?php echo site_url('book_view/book') ?>"+"/"+lv1class+"-"+classname+"/1";
	                    url = encodeURI(url);
	                    var anchor = $("<a>").text(classname).attr("href", url);
	                    var url_classname = "<?php echo urldecode($this->uri->segment(3));?>";
	                    if((lv1class+"-"+classname) == url_classname)
	                    {
	                    	li.addClass("active").append(anchor);
	                    }
	                    else
	                    {
	                    	li.append(anchor);
	                    }
	                    nav.append(li);
	                }
	            });
	            $("#navlist").html(nav);
					}
		});
	});
</script>
<script>
	$(function (){
		$.ajax({
	        type:"GET",
	        url:"<?php echo base_url(); ?>classification.xml",
	        dataType:"xml",
	        success:function(xml){
	        	//构建分类导航栏，在DOM中hide
	            var classification = $("<div>").addClass("classification");
	            $(xml).find("class").each(function(i){
	                var classname = $(this).attr("name");
	                var lv = $(this).attr("lv");
	                if(lv == 1)
	                {
	                    var lv1 = $("<div>").addClass("lv1").attr("name",classname);
	                    var title = $("<a>").text(classname);
	                    var lv2 = $("<p>").addClass("lv2");
	                    lv1.append(title);
	                    lv1.append(lv2);
	                    classification.append(lv1);
	                }
	                else //if(lv == 2)
	                {
	                    var lv2name = $("<a>").text(classname);
	                    classification.find(".lv2").last().append(lv2name).append(" | ");
	                }
	            });
	            // 对导航栏按钮绑定 点击事件  尝试用classification绑定事件，只能点击一次，事件就失效，css没有失效
	            $("div.controls").delegate("a","click",function(e){
	            	if($(this).parent().attr("class") == "lv1")
	            	{
	            		var classname = $(this).text();
	            	}
	            	else
	            	{
	            		var classname = $(this).parent().parent().attr("name")+'-'+$(this).text();
	            	}
           			$("[name=class]").attr('value',classname);
           			$('#class').popover('hide');
           		});
           		classification.find("a").css({"cursor":"pointer","white-space":"nowrap","color":"#003399"});
           		classification.find(".lv1").children("a").css({"font-weight":"bold","color":"#E47911"});
	            // #class 是输入框
	            $("#class").popover(
				{
					title:"图书分类",
					html:1,
					content:classification,
				});
				//输入框 鼠标指针形状
				$("#class").css("cursor","pointer");
	        }
	    });
	});
</script>