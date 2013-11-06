<?php 
	$row_num = 3;
?>


<?php include("includes/header.php"); ?>

<div class="container">
	<div class="row">

		<div class="span3">
			<div class="well" style="max-width: 340px; padding: 8px 0;" id="navlist">
      </div>
		</div>

		<div class="span9">
			<div class="row-fluid">
				<legend>
					<?php echo $class ?> 
					<small> 共有 <?php echo $count ?> 条结果</small>
					<span class="pull-right">
							<a href="<?php echo site_url();?>/search?key=" class=""><small style="color:blue;"><strong>查看平台全部书本</strong></small></a>
					</span>
				</legend>
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
				<?php foreach ($result as $index => $item): ?>
					<?php if ($index % $row_num == 0) { ?> 
						<ul class="thumbnails">
					<?php } ?>
							<li class="span4">
		            <div class="thumbnail">
									<a href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" >
										<div class="image" style = "height: 200px;text-align:center;">

											<img src = "<?php echo base_url('get_data.php?id='.$item->id); ?>" style = "height:90%" />

										</div>
									</a>
		              <div class="caption" style = "font-size:14px">
		                <p>书名：									
		                	<?php
					              $text = $item->name;
					              if (strlen($text) > 16)
					                $text = $this->search_model->getstr($text, 16).' ...';
					              echo $text;
					            ?>
			          		</p>
		                <p>作者：
											<?php
					              $text = $item->author;
					              if (strlen($text) > 16)
					                $text = $this->search_model->getstr($text, 16).' ...';
					              echo $text;
					            ?>
		                </p>
		                <p style = "font-size: 17px; color: #ff0000;">
											<strong> ￥<?php echo $item->price; ?> </strong>
											<span style = "text-decoration: line-through; font-size: 12px; color: #999">
												￥<?php echo $item->originprice; ?>
											</span>
										</p>
		              </div>
		            </div>
		          </li>
					<?php if ($index % $row_num == $row_num-1 || $index == $count-1-($page-1)*21) { ?> 
						</ul>
					<?php } ?>
				<?php endforeach;?>
				<?php $url = site_url("book_view/book/$class/"); ?>
				<div class = "text-left">
					<div class="pagination">
					  <ul>
					  	<?php
					    	if ($page > 1) {
					     ?>
					    <li class="<?php $tmp = $page - 1; if ($tmp > 0) echo ''; else echo 'disabled'; ?>"><a href="<?php if ($tmp > 0) echo $url.'/'."$tmp"; else echo '#'; ?>">前一页</a></li>
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
					    <li class="<?php $tmp = $page + 1; if (($tmp - 1) *21 < $count) echo ''; else echo 'disabled'; ?>"><a href="<?php if (($tmp - 1) * 21 < $count) echo $url.'/'."$tmp"; else echo '#'; ?>">后一页</a></li>
					  <?php } ?>
					  </ul>
					</div>
				</div>
				<?php } ?>
      </div>
		</div>

		
<!-- 51.la script -->
<div class="container" style="display:none">
<script language="javascript" type="text/javascript" src="http://js.users.51.la/15806741.js"></script>
</div>
<?php include("includes/footer.php"); ?>