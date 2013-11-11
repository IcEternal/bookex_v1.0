<?php
/*
================================================================
search_result.php

The page of search results.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
<?php include("includes/header.php"); ?>

<div class="content-full">
	<h2>
		<?php echo $key ?> 
		<span class="forh2"> 共有 <?php echo $count ?> 条搜索结果</span>
		<span class="pull-right">
		<?php if ($key != "") {?>
			<a href="<?php echo site_url();?>/search?key=" class="">查看平台全部书本</a>
			或
		<?php } ?>
			<a href="<?php echo site_url();?>/book_view/book/教材教辅/" class="">根据分类查看书本</a>
		</span>
	</h2>
	<?php
		if ($count == 0) {
	?>
			<div class = "row"> 
				<a href="<?php echo site_url('welcome/act_detail') ?>">
				<img src = "<?php echo base_url('public/img/notFound.png'); ?>" style = "width:100%;" />
				</a>
			</div>
	<?php
		} else {
			foreach ($result as $item): 
	?>
				<div class = "row">
					<div id = "left" class = "span3 text-center">
						<div class="thumbnail">
							<a target="_blank" href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" target="_blank">
								<div class="image" style = "width:100%">
									<img src = "<?php echo base_url('get_data.php?id='.$item->id); ?>" style = "width:70%" />
								</div>
							</a>
						</div>
					</div>

					<div id = "right" class = "span7 offset1">
						<div class = "row-fluid">
							<p class = "span2"> <strong> 图书名 </strong> </p>
							<p class = "span10"> <?php echo $item->name; ?> </p>
						</div>

						<div class = "row-fluid">
							<p class = "span2">  <strong> 价格 </strong> </p>
							<p class = "span9" style = "font-size: 17px; color: #ff0000;">
								<strong> ￥<?php echo $item->price; ?> </strong>
								<span style = "text-decoration: line-through; font-size: 12px; color: #999">
									￥<?php echo $item->originprice; ?>
								</span>
							</p>
						</div>

						<div class = "row-fluid">
							<p class = "span2"> <strong> 作者 </strong> </p>
							<p class = "span10"> <?php echo $item->author; ?> </p>
						</div>

						<div class = "row-fluid">
							<p class = "span2"> <strong> 出版社 </strong> </p>
							<p class = "span10"> <?php echo $item->publisher; ?> </p>
						</div>

						<div class = "row-fluid">
							<p class = "span2"> <strong> 简介 </strong> </p>
							<p class = "span10">
								<?php
					              $text = $item->description;
					              $this->load->model("search_model");
					              if (strlen($text) > 300)
					                $text = $this->search_model->getstr($text, 300).' ...';
					              echo $text;
					            ?>
							</p>
						</div>
					</div>
					<p>
						<a target="_blank" href="<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>">
						  详细页面
						</a>
					</p>
					<ul class="nav nav-list span12">
						<li class="divider"></li>
					</ul>
				</div>
	<?php 
			endforeach;
	?>
	<?php $url = site_url("search?key=$key&page="); ?>

	<div class="pagination">
	  <ul>
	  	<?php
	    	if ($page > 1) {
	     ?>
	    <li class="<?php $tmp = $page - 1; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>">前一页</a></li>
	    <?php }
	    if ($page > 5) { ?>
	    <li class="<?php $tmp = $page - 5; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php }
	    	if ($page > 4) {
	     ?>
	    <li class="<?php $tmp = $page - 4; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php }
	    	if ($page > 3) {
	     ?>
	    <li class="<?php $tmp = $page - 3; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php }
	    	if ($page > 2) {
	     ?>
	    <li class="<?php $tmp = $page - 2; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php }
	    	if ($page > 1) {
	     ?>
	    <li class="<?php $tmp = $page - 1; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php } 
	    	if ($page > 0) {
	    ?>
	    <li class="active <?php $tmp = $page; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php }
	    if ($page * 20 < $count) { ?>
	    <li class="<?php $tmp = $page + 1; if (($tmp - 1) *20 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 20 < $count) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php }
	    	if (($page + 1) * 20 < $count) {
	     ?>
	    <li class="<?php $tmp = $page + 2; if (($tmp - 1) *20 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 20 < $count) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php }
	    	if (($page + 2) * 20 < $count) {
	     ?>
	    <li class="<?php $tmp = $page + 3; if (($tmp - 1) *20 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 20 < $count) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php }
	    	if (($page + 3) * 20 < $count) {
	     ?>
	    <li class="<?php $tmp = $page + 4; if (($tmp - 1) *20 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 20 < $count) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php }
	    	if (($page + 4) * 20 < $count) {
	     ?>
	    <li class="<?php $tmp = $page + 5; if (($tmp - 1) *20 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 20 < $count) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
	    <?php } 
	    	if ($page * 20 < $count) { 
	    ?>
	    <li class="<?php $tmp = $page + 1; if (($tmp - 1) *20 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 20 < $count) echo $url."$tmp"; else echo '#'; ?>">后一页</a></li>
	  <?php } ?>
	  </ul>
	</div>

	<?php 
		function generatePageLabel($url, $txt, $class){
			echo "<a href=\"$url\" class=\"page $class\">$txt</a>\n";
		}

		function showPageLabel($count, $page, $key){
			echo "<div class=\"page_wrapper\">";
			$prev = $page - 1;
			if ($page > 1) 
				generatePageLabel("search.php?key=$key&page=$prev", "上一页", "page_word");
			for ($i = 1; ($i-1)*20 < $count; $i ++)
				if ($i == $page)
					generatePageLabel("search.php?key=$key&page=$i", "$i", "page_current");	
				else
					generatePageLabel("search.php?key=$key&page=$i", "$i", "page_num");
				$nxt = $page + 1;
				if ($page * 20 < $count)
					generatePageLabel("search.php?key=$key&page=$nxt", "下一页", "page_word");
				echo "</div>";
			}
		}	
	?>

</div><!-- content-full -->

<?php include("includes/footer.php"); ?>
