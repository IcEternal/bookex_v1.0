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
	$author = $info->author;
	$price = $info->price;
	$publisher = $info->publisher;
	$ISBN = $info->ISBN;
	$description = $info->description;
	$uploader = $info->uploader;
	$subscriber = $sub;
	$originprice = $info->originprice;
	$finished = ($info->finishtime != "0000-00-00 00:00:00");
	$show = $info->show_phone;
	$use = $info->use_phone;
	$err = $err_mes;
	$del = $info->del;
	$is_success = $is_succ;
	$status = $info->status;

	function get_status_string($status){
		if ($status == 0) return "未取书";
		elseif ($status == 1) return "正在取书";
		elseif ($status == 2) return "书本已到达BookEx";
		elseif ($status == 3) return "正在送书";
		elseif ($status == 4) return "交易成功";
		elseif ($status == 5) return "卖家找不到该书本";
	}

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
	if (($err == '订购成功！工作人员从卖家拿到书后会与您联系') || ($err == '订购成功！手机号已在图片下方显示。')) { ?>
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

	<?php if ($show == true && $err == '订购成功！工作人员从卖家拿到书后会与您联系') { ?>
		<?php if ($mustphone) redirect("book_details/use_phone/$id"); ?>
		<div class="modal hide fade" id="phoneInfo">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3>提示</h3>
		  </div>
		  <div class="modal-body">
		    <p>对方支持当面交易,手机号为 <?php echo $phone ?>.</p>
		    <p><strong>自行当面交易</strong> 后，手机号会在书本图片下方显示。</p>
		    <br/>
		    <p> <?php if (!$mustphone) {?> 工作人员从卖家取书后联系，速度慢<a data-dismiss="modal" aria-hidden="true" id="do_not_use_phone">委托BookEx取书</a><?php } ?></p>
		    <br/>
		    <p>速度快又方便, 还能认识些同学, 选择<a class="btn" href='<?php echo site_url("book_details/use_phone/$id") ?>'><b>自行当面交易</b></a></p>
		  </div>
		</div>
	<?php } ?>

	<?php 
		$url = $_SERVER['PHP_SELF'];
		if (strpos($url, 'order') != false && $info->discounted == 0 && $info->freed == 0 && ($info->discount_sup == 1 || $info->free_sup == 1)){ 
	?>
			<div class="modal hide fade" id="ticketInput">
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h3>订购成功，提示</h3>
			  </div>
			  <div class="modal-body">
			  	<?php if ($info->discount_sup == 1){ ?>
			    <p>该书支持抵价券，你可以在下面的输入框输入使用。</p>
			    <p>抵价券一旦使用后，即使取消订单该券也将视为已使用。</p>
			    <input class="span3" type="text" id="discount_ticket_input" name="discount_ticket" placeholder="输入抵价码">
			    <a class="btn btn-primary" data-dismiss="" aria-hidden="true" id="discount_button">确定</a>
			    <?php } ?>
			    <?php if ($info->free_sup == 1){ ?>
			    <p>该书支持免费券，你可以在下面的输入框输入使用。</p>
			    <p>免费券一旦使用后，即使取消订单该券也将视为已使用。</p>
			    <input class="span3" type="text" id="free_ticket_input" name="free_ticket" placeholder="输入免费码">
			    <a class="btn btn-primary" data-dismiss="" aria-hidden="true" id="free_button">确定</a>
			    <?php } ?>
			    <p id="ticket_message"></p>
			  </div>
			  <div class="modal-footer">
			    <a class="btn" data-dismiss="modal" aria-hidden="true" id="do_not_use_ticket">不使用</a>
			  </div>
			</div>
	<?php }  
// alert END
	?>

<div id="content"><!-- structure -->

	<h2>
		<strong> <?php echo $name; ?> </strong>
		<?php
			$user = $this->session->userdata('username');
			if ($uploader == $user) { 
			// if the user is the book's owner
		?>
			<a href="<?php echo site_url('book_upload/modify') ?>/<?php echo $id ?>"> 
				<span> 
				<?php
					if ($finished == false) 
						echo "编辑";
				?>
				</span>
			</a>
		<?php 
			}
			// check if the user has collected the book.
			if ($collect == 0) {
		?>
				<a href="<?php echo site_url('book_details/user_collect') ?>/<?php echo $id ?>" class="pull-right"> 
					<span> 
						收藏
					</span>
				</a>
		<?php
			} else {
		?>
				<a href="<?php echo site_url('book_details/user_cancel_collect') ?>/<?php echo $id ?>" class="pull-right"> 
					<span> 
						取消收藏
					</span>
				</a>
		<?php
			}
		?>
	</h2>

	<div class = "row-fluid">
		<p class = "span2">  <strong> 价格 </strong> </p>
		<p class = "span10" style = "font-size: 17px; color: #ff0000;">
			<strong> ￥<?php echo $price; ?> </strong>
			<span style = "text-decoration: line-through; font-size: 12px; color: #999">
				￥<?php echo $originprice; ?>
			</span>
		</p>
	</div>

	<div class = "row-fluid">
		<p class = "span2"> <strong> 作者 </strong> </p>
		<p class = "span10"> <?php echo $author; ?> </p>
	</div>

	<div class = "row-fluid">
		<p class = "span2"> <strong> 上传人 </strong> </p>
		<p class = "span10"> <?php echo $uploader; ?> </p>
	</div>

	<div class = "row-fluid">
		<p class = "span2"> <strong> 出版社 </strong> </p>
		<p class = "span10"> <?php echo $publisher; ?> </p>
	</div>


	<?php if ($uploader == $user && $subscriber!='N') { ?>
		<div class = "row-fluid">
        <p class = "span2"> <strong>  <?php echo "交易类型:"; ?></strong> </p>
        <p class = "span10"><?php
          if ($use == 1){
            $subscriber_phone = $user_phone[0]->phone;
            echo "自行交易（买家手机：$subscriber_phone ）";
          }
          else {
            echo "委托交易";
          }
        ?></p>
      </div>
    <?php } ?>

	<div class = "row-fluid">
		<p class = "span2"> <strong> 豆瓣链接 </strong> </p>
		<p class = "span10"> 

			<?php if ($ISBN != "") { ?>
				<a href="http://book.douban.com/isbn/<?php echo $ISBN ?>" target="_blank">点击此处转到豆瓣查看详细评价</a>
				<br/>可能有少量书籍ISBN输入有误从而导致链接不正确，请谅解！
			<?php } else {?>
				很抱歉！此书没有提供ISBN，无法给出豆瓣链接。
			<?php } ?>

		</p>
	</div>

	<div class="fake-back"></div>
	<div class="content-intitle">简介</div>
	<?php echo $description; ?>

</div><!-- content -->

<div id="sidebar"><!-- structure -->
	<div id="book-details-image">
		<img src = "<?php echo base_url('get_data.php?id='.$id); ?>" width="230px" />
	</div>
	
	<div class="sidebarbutton">
		<?php 
				if ($user == $subscriber && $use == true) { ?>
					<p> <strong> 手机号: </strong> &nbsp; <?php echo $phone; ?> </p>
		<?php 
				}
				if ($finished) {
		?>
					<a class = "btn disabled"> 已交易 </a>
		<?php
				} else if ($del) {
		?>
					<a class = "btn disabled"> 已删除 </a>
		<?php
				} else if ($st == true) {
					if ($uploader == $user) {
						if ($subscriber == 'N') {
		?>
							<a class = "btn disabled"> 未预订 </a>
		<?php
						} else if ($status == 0) {
		?>
							<a class = "btn" href = "<?php echo site_url('book_details/uploader_cancel/'.$id); ?>"> 已预订，取消该订单 </a>
		<?php
						} else {
		?>
							<a class = "btn disabled"> <?php echo get_status_string($status); ?> </a>
		<?php
						}

					} else if ($subscriber == 'N') {
		?>
						<a class = "btn" href = "<?php echo site_url('book_details/order/'.$id); ?>"> 预订 </a>
		<?php
					} else {
						if ($subscriber == $user) {
							if ($status == 0){
		?>
								<a class = "btn" href = "<?php echo site_url('book_details/user_cancel/'.$id); ?>"> 取消订单 </a>
		<?php 
							} else {
		?>
								<a class = "btn disabled" > <?php echo get_status_string($status); ?> </a>
		<?php 
							}
						} else {
		?>
							<a class = "btn disabled"> 已被预订 </a>
		<?php
						}
					}
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
