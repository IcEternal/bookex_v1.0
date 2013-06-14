<?php
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
					$subscriber = $info->subscriber;
					$originprice = $info->originprice;
					$finished = ($info->finishtime != "0000-00-00 00:00:00");
					$show = $info->show_phone;
					$use = $info->use_phone;
					$err = $err_mes;
					$is_success = $is_succ;
?>

<style type="text/css">
	p {
		word-break: break-all;
		font-size: 15px;
	}
</style>


<div class = "container" style = "font-family: verdana">

<?php
	if ($err != "")
		if ($is_success == true) {
			?>

			<div class="alert alert-success fade in">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong></strong> <?php echo $err; ?>
			</div>

			<?php
		}
		else
		{
			?>


			<div class="alert alert-error fade in">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong></strong> <?php echo $err; ?>
			</div>

			<?php
		}
?>

<?php if ($show == true && $err == '订购成功！工作人员将于1天内于您联系') { ?>
	<div class="modal hide fade" id="phoneInfo">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h3>提示</h3>
	  </div>
	  <div class="modal-body">
	    <p>对方支持当面交易,手机号为 <?php echo $phone ?>.</p>
	    <p>点击下方的 <strong>自行当面交易</strong> 后，手机号会在书本图片下方显示。</p>
	    <p>如果您不想当面交易,请点击下方的 <strong>委托交易</strong> 按钮, 我们会联系您并送书上门。</p>
	  </div>
	  <div class="modal-footer">
	    <a href='<?php echo site_url("book_details/use_phone/$id") ?>' class="btn">自行当面交易</a>
	    <a class="btn btn-primary" data-dismiss="modal" aria-hidden="true">委托交易</a>
	  </div>
	</div>
<?php } ?> 
	<div class="alert alert-info fade in">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	点击右侧 <strong>分享</strong> 按钮即可选择将本书信息分享到人人、微博、QQ空间等平台。   好书就要让更多人看到！
	</div>

	<div class = "row">
		<div id = "left" class = "span4 text-center">
			<div class="thumbnail">

				<img src = "<?php echo base_url('get_data.php?id='.$id); ?>" style = "width:80%" />
				<p></p>
				<p> <strong> 上传人: </strong> &nbsp <?php echo $uploader; ?> </p>
			  <?php if ($user == $subscriber && $use == true) { ?>
			  	<p> <strong> 手机号: </strong> &nbsp <?php echo $phone; ?> </p>
			  <?php } ?>
				<?php
					if ($finished) {
						?>
						<a class = "btn disabled"> 已交易 </a>
						<?php
					}
					else if ($st == true) {
						if ($uploader == $user) {
							if ($subscriber == 'N') {
								?>

								<a class = "btn disabled"> 未预订 </a>

								<?php
							}
							else {
								?>

								<a class = "btn" href = "<?php echo site_url('book_details/uploader_cancel/'.$id); ?>"> 已预订，取消该订单 </a>

								<?php
							}
						}
						else if ($subscriber == 'N') {
							?>

								<a class = "btn" href = "<?php echo site_url('book_details/order/'.$id); ?>"> 预订 </a>

							<?php
						}
						else {
							if ($subscriber == $user) {
								?>

								<a class = "btn" href = "<?php echo site_url('book_details/user_cancel/'.$id); ?>"> 取消订单 </a>

								<?php
							}
							else {
								?>

								<a class = "btn disabled"> 已被预订 </a>

								<?php
							}
						}
					}
					else {
						?>

						<a class = "btn disabled"> 您还未登入 </a>

						<?php
					}
				?>
					
			</div>
		</div>

		<div id = "right" class = "span7 offset1">
			<legend>
				<strong> <?php echo $name; ?> </strong>
				
				<?php
					$user = $this->session->userdata('username');
					if ($uploader == $user) { 
				?>
					<a href="<?php echo site_url('book_upload/modify') ?>/<?php echo $id ?>"> 
						<span style = "font-size: 12px;"> 
							<?php
								if ($finished == false) 
									echo "编辑";
							?>
						<span>
					</a>
				<?php } ?>


			</legend>
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
				<p class = "span2"> <strong> 出版社 </strong> </p>
				<p class = "span10"> <?php echo $publisher; ?> </p>
			</div>

			<div class = "row-fluid">
				<p class = "span2"> <strong> 简介 </strong> </p>
				<p class = "span10">
					<?php echo $description; ?>
				</p>
			
			</div>

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


	</div>
</div>

<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=slide&amp;img=2&amp;pos=right&amp;uid=4388338" ></script> 
<script type="text/javascript" id="bdshell_js"></script> 
<script type="text/javascript">
	//在这里定义bds_config
	var bds_config = {'bdText':'<?php echo '我在交大校内二手书交易平台BookEx上找到了一本好书～书名:  '.$name.';     作者:  '.$author.';     原价:  '.$originprice.'元;     现在只要 '.$price.'元 哦！'?>','bdDesc':'BookEx - 交大校内二手书交易平台。可以自己随心定价，不必再被二手书店赚取差价啦！迎合书本循环利用理念，为同学们创造方便舒适的使用环境！现在网站上资源不少，可以去看看哦～','bdPic':'<?php echo base_url();?>get_data.php?id=<?php echo $id?>'};
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
</script>
