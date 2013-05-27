<?php include("includes/header.php"); ?>
<div id = "search_content" class = "container" style = "font-family: verdana; word-break: break-all; font-size: 15px;">
	<legend><?php echo $key ?></legend>
	<?php

		if ($count == 0) {
		?>

			<div class = "row"> 
				<a href="<?php echo site_url('welcome/act_detail') ?>">
				<img src = "<?php echo base_url('public/img/notFound.jpg'); ?>" style = "width:100%;" />
				</a>
			</div>

		<?php
		}
		else {
?>

	<?php foreach ($result as $item): ?>
		<div class = "row">
			<div id = "left" class = "span3 text-center">
				<div class="thumbnail">
					<a href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" >
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
				<a href="<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>">
				  详细页面
				</a>
			</p>
			<ul class="nav nav-list span12">
				<li class="divider"></li>
			</ul>
		</div>
	<?php endforeach;
		$url = site_url("search?key=$key&page=");
	?>


	<div class = "row">
		<div class = "span12 text-left">

<div class="pagination">
  <ul>
    <li class="<?php $tmp = $page - 1; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>">前一页</a></li>
    <?php if ($page > 2) { ?>
    <li class="<?php $tmp = $page - 2; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
    <?php }
    	if ($page > 1) {
     ?>
    <li class="<?php $tmp = $page - 1; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
    <?php } ?>
    <li class="<?php $tmp = $page; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
    <?php if ($page * 20 < $count) { ?>
    <li class="<?php $tmp = $page + 1; if (($tmp - 1) *20 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 20 < $count) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
    <?php }
    	if (($page + 1) * 20 < $count) {
     ?>
    <li class="<?php $tmp = $page + 2; if (($tmp - 1) *20 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 20 < $count) echo $url."$tmp"; else echo '#'; ?>"><?php echo $tmp ?></a></li>
    <?php } ?>
    <li class="<?php $tmp = $page + 1; if (($tmp - 1) *20 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 20 < $count) echo $url."$tmp"; else echo '#'; ?>">后一页</a></li>
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

		?>
		</div>
	</div>






<?php
		}
	?>
</div>
<?php include("includes/footer.php"); ?>
