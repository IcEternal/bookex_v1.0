<?php
/*
================================================================
book_view.php

include: includes/header.php
		 includes/footer.php

Show the books of categories

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
	$row_num = 3;
?>

<?php include("includes/header.php"); ?>

<div id="content"><!-- structure -->

	<h2>
		<?php echo $class ?> 
		<span class="forh2"> 共有 <?php echo $count ?> 条结果</span>
		<span class="pull-right">
				<a href="<?php echo site_url();?>/search?key=">查看平台全部书本</a>
		</span>
		<div class="fixed"></div><!-- clear for <pull-right>'s float -->
	</h2>
	<?php
		if ($count == 0) {
		// 404
	?>
			<a href="<?php echo site_url('welcome/act_detail') ?>">
				<img src = "<?php echo base_url('public/img/notFound.png'); ?>" style = "width:100%;" />
			</a>
	<?php
		} else {
			foreach ($result as $index => $item):
	?>
				<div class="book-list">
					<a target="_blank" href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" target="_blank" >
						<div class="pic-box">
							<img src = "<?php echo base_url('get_data.php?id='.$item->id); ?>" width="130px" />
						</div>
					</a>
				

				    <div class="book-name">
				    	<a target="_blank" href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" target="_blank" >										
			        		<?php
				              	$text = $item->name;
				              	if (strlen($text) > 16)
				                	$text = $this->search_model->getstr($text, 16).' ...';
				              	echo $text;
				            ?>
				        </a>
				    </div>

			        <div class="book-price">
					    <span class="now">
							￥<?php echo $item->price; ?>
						</span>
						<span class="original">
							￥<?php echo $item->originprice; ?>
						</span>
					</div>
				</div>
	<?php 	
			endforeach;
	?>
			<div class="fixed"></div><!-- clear for <book-list>'s float -->
	<?php 
			$url = site_url("book_view/book/$class/");
			// Page navigation
	?>
			<div class="pagination">
			  <ul>
			  	<?php
			    	if ($page > 1) {
			     ?>
			    <li class="<?php $tmp = $page - 1; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url.'/'."$tmp"; else echo '#'; ?>">上一页</a></li>
			    <?php }
			    if ($page > 5) { ?>
			    <li class="<?php $tmp = $page - 5; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php }
			    	if ($page > 4) {
			     ?>
			    <li class="<?php $tmp = $page - 4; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php }
			    	if ($page > 3) {
			     ?>
			    <li class="<?php $tmp = $page - 3; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php }
			    	if ($page > 2) {
			     ?>
			    <li class="<?php $tmp = $page - 2; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php }
			    	if ($page > 1) {
			     ?>
			    <li class="<?php $tmp = $page - 1; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php } 
			    	if ($page > 0) {
			    ?>
			    <li class="active <?php $tmp = $page; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php }
			    if ($page * 21 < $count) { ?>
			    <li class="<?php $tmp = $page + 1; if (($tmp - 1) *21 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 21 < $count) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php }
			    	if (($page + 1) * 21 < $count) {
			     ?>
			    <li class="<?php $tmp = $page + 2; if (($tmp - 1) *21 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 21 < $count) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php }
			    	if (($page + 2) * 21 < $count) {
			     ?>
			    <li class="<?php $tmp = $page + 3; if (($tmp - 1) *21 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 21 < $count) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php }
			    	if (($page + 3) * 21 < $count) {
			     ?>
			    <li class="<?php $tmp = $page + 4; if (($tmp - 1) *21 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 21 < $count) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php }
			    	if (($page + 4) * 21 < $count) {
			     ?>
			    <li class="<?php $tmp = $page + 5; if (($tmp - 1) *21 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 21 < $count) echo $url.'/'."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
			    <?php } 
			    	if ($page * 21 < $count) { 
			    ?>
			    <li class="<?php $tmp = $page + 1; if (($tmp - 1) *21 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 21 < $count) echo $url.'/'."$tmp"; else echo '#'; ?>">下一页</a></li>
			  <?php } ?>
			  </ul>
			</div>
	<?php } ?>
</div><!-- content -->
<div id="sidebar">
	<h2>分类目录</h2>
	<?php include("includes/navlist.php"); ?>
</div>

<?php 
// big box alert
if (!$never_show_activity && isOfActivity($class)) { ?>
	<div class="modal in fade" id="shareInfo">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4><span style="font-size: 20px; font-weight: bold;">双11活动商品购买特权</span><br/><br/>
	    	<p>送一张贺卡~还有代送业务和免费兑书券哦~</p></h4>
	  </div>
	  <div class="modal-body">
	  	<img src="<?php echo base_url()?>/public/img/activity.png">
	  </div>
	  <div class="modal-footer">
	    <a class="btn" id="never_show_activity_prompt" data-dismiss="modal" aria-hidden="true">不再显示</a>
	    <a class="btn" data-dismiss="modal" aria-hidden="true">关闭</a>
	  </div>
	</div>
<?php } ?> 

<script type="text/javascript">
	var never_show_activity = function(event) {
		event.stopPropagation();
		$.ajax({url: "<?php echo site_url();?>/ajax/neverShowActivity"});
		$("#shareInfo").modal('hide');
	}

	$("#never_show_activity_prompt").css({"cursor":"pointer"}).bind("click", never_show_activity);
</script>

<script type="text/javascript">
	$("#shareInfo").modal('show');
</script>

<?php include("includes/footer.php"); ?>
