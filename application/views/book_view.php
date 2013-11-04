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
				<img src = "<?php echo base_url('public/img/notFound.jpg'); ?>" style = "width:100%;" />
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

<?php include("includes/footer.php"); ?>