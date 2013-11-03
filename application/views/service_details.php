<?php
/*
================================================================
book_details.php

include: includes/header.php
		 includes/footer.php

The page of the book details.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>

<?php
	// reset
	$st = $this->session->userdata('is_logged_in');
	$user = $this->session->userdata('username');
	$id = $info->id;
	$name = $info->name;
	$price = $info->price;
	$description = $info->description;
	$uploader = $info->uploader;
	$show = $info->show_phone;
	$err = $err_mes;
	$del = ($info->remain == 0);
	$is_success = $is_succ;

?>

	<?php
// alert BEGIN
	// result alert
		if ($err != "")
			if ($is_success == true) {
	?>
				<div class="main-alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong></strong> <?php echo $err; ?>
				</div>
	<?php
			}
			else
			{
	?>
				<div class="main-alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong></strong> <?php echo $err; ?>
				</div>
	<?php
			}
	?>

	<?php 
	// big box alert
	if (($err == '订购成功！工作人员将于1天内于您联系') || ($err == '订购成功！手机号已在图片下方显示。')) { ?>
		<div class="modal hide fade" id="shareInfo">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h4>订购成功~喜欢这个网站的话请分享一下哈~</h4>
		  </div>
		  <div class="modal-body">
			<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare" style="margin: auto">
				<a class="bds_renren"></a>
				<a class="bds_tsina"></a>
				<a class="bds_qzone"></a>
				<a class="bds_tqq"></a>
				<a class="bds_t163"></a>
				<span class="bds_more"></span>
			</div>
		  </div>
		  <div class="modal-footer">
		    <a class="btn" data-dismiss="modal" aria-hidden="true">取消</a>
		  </div>
		</div>
	<?php } ?> 

	<?php if ($show == true && $err == '订购成功！工作人员将于1天内于您联系') { ?>
		<?php if ($mustphone) redirect("book_details/use_phone/$id"); ?>
		<div class="modal hide fade" id="phoneInfo">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3>提示</h3>
		  </div>
		  <div class="modal-body">
		    <p>对方支持当面交易,手机号为 <?php echo $phone ?>.</p>
		    <p>点击下方的 <strong>自行当面交易</strong> 后，手机号会在书本图片下方显示。</p>
		    <p>推荐使用 <strong>自行当面交易</strong>，可以出去走走并且认识新同学哈~</p>
		    <p>如果您不想当面交易,请点击下方的 <strong>委托交易</strong> 按钮, 我们会短信联系您。</p>
		    <p>PS: 若您订购的是二手书以外的物品，则只能当面交易~</p>
		  </div>
		  <div class="modal-footer">
		    <?php if (!$mustphone) {?><a class="btn" data-dismiss="modal" aria-hidden="true" id="do_not_use_phone">委托交易</a><?php } ?>
		    <a href='<?php echo site_url("book_details/use_phone/$id") ?>' class="btn btn-primary">自行当面交易</a>
		  </div>
		</div>
	<?php } ?>

	

<div id="content"><!-- structure -->

	<h2>
		<strong> <?php echo $name; ?> </strong>
	</h2>

	<div class = "row-fluid">
		<p class = "span2">  <strong> 价格 </strong> </p>
		<p class = "span10" style = "font-size: 17px; color: #ff0000;">
			<strong> ￥<?php echo $price; ?> </strong>
		</p>
	</div>


	<div class = "row-fluid">
		<p class = "span2"> <strong> 简介 </strong> </p>
		<p class = "span10">
			<?php echo $description; ?>
		</p>
	</div>


</div><!-- content -->

<div id="sidebar"><!-- structure -->
	<div id="book-details-image">
		<img src = "<?php echo base_url('get_service_data.php?id='.$id); ?>" width="230px" />
	</div>
	<p> <strong> 上传人: </strong> &nbsp; <?php echo $uploader; ?></p>
	<div class="sidebarbutton">
		<?php 
				if ($del) {
		?>
					<a class = "btn disabled"> 已删除 </a>
		<?php
				} else if (!$subscribed && $uploader != $user) {
		?>
						<a class = "btn" href = "<?php echo site_url('service_details/order/'.$id); ?>"> 预订 </a>
		<?php
				} else if ($subscribed) {
		?>
								<a class = "btn" href = "<?php echo site_url('service_details/user_cancel/'.$id); ?>"> 取消订单 </a>
		<?php 
				} else if ($uploader == $user) {
		?>
					<a class = "btn disabled"> 您是上传者 </a>
		<?php 
				} else {
		?>
					<a class = "btn disabled"> 您还未登入 </a>
		<?php
				}
		?>
	</div>
</div> <!-- sidebar -->

<?php //promo code ?>
<script type="text/javascript">

	var discount_ticket = function(event){
		event.stopPropagation();
		var ticket = document.getElementById("discount_ticket_input").value;
		$.get(
            "<?php echo site_url();?>/book_details/use_discount_ticket",
            {"book_id":"<?php echo $id; ?>", "ticket": ticket},
            function(data)
            {
            	
            	$("#ticket_message").text(data);
            	if (data.indexOf("使用成功") >= 0) location.reload();
            });
	}

	var free_ticket = function(event){
		event.stopPropagation();
		var ticket = document.getElementById("free_ticket_input").value;
		$.get(
            "<?php echo site_url();?>/book_details/use_free_ticket",
            {"book_id":"<?php echo $id; ?>", "ticket": ticket},
            function(data)
            {
            	
            	$("#ticket_message").text(data);
            	if (data.indexOf("使用成功") >= 0) location.reload();
            });
	}

	$("#discount_button").css({"cursor":"pointer"}).bind("click", discount_ticket);

	$("#free_button").css({"cursor":"pointer"}).bind("click", free_ticket);

</script>

<?php
	//big box alert when click the buy button.
?>
<script type="text/javascript">
  $("#phoneInfo").modal('show');
</script>
<script type="text/javascript">
	if ($("#phoneInfo").size()<=0) 
		$("#shareInfo").modal('show');
</script>
<script type="text/javascript">
	$("#ticketInput").modal('show');
</script>
<script type="text/javascript">
  $("#do_not_use_phone").click(function() {
  	$("#shareInfo").modal('show');
  });
</script>
<script type="text/javascript" id="bdshare_js" data="type=slide&amp;img=2&amp;mini=1&amp;pos=right&amp;uid=4388338" ></script> 
         <script type="text/javascript" id="bdshell_js"></script> 
         <script type="text/javascript">
        var bds_config = {'bdText':'<?php echo '我在交大校内二手书交易平台BookEx上找到了一本好书～书名:  '.$name.';     作者:  '.$author.';     原价:  '.$originprice.'元;     现在只要 '.$price.'元 哦！'?>','bdDesc':'BookEx - 交大校内二手书交易平台。可以自己随心定价，不必再被二手书店赚取差价啦！迎合书本循环利用理念，为同学们创造方便舒适的使用环境！现在网站上资源不少，可以去看看哦～','bdPic':'<?php echo base_url();?>get_data.php?id=<?php echo $id?>'};
        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
</script>

<?php include("includes/footer.php"); ?>