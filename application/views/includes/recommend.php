<?php 
$width=190;
$blank=30;
function showItem($item, $blank, $width, $offset){ ?>
	<div class="container" style="width:<?php echo $width; ?>px; float:left; margin-left: <?php echo $blank; ?>px;">
		<a href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" style="text-align:center;">
				<img src = "<?php echo base_url('get_data.php?id='.$item->id); ?>" style = "width:<?php echo $width; ?>px; height:260px; margin-left:0px; " />
		</a>
		<div class="carousel-caption" style="width:<?php echo $width-30; ?>px; margin-left: <?php echo $offset ?>px;">
			<h4><?php echo $item->name; ?></h4>
			<p style = "font-size: 17px; color: #ff0000;">
					<strong> ￥<?php echo $item->price; ?> </strong>
					<span style = "text-decoration: line-through; font-size: 12px; color: #999">
						￥<?php echo $item->originprice; ?>
					</span>
			</p>
		</div>
	</div>

<?php }
//$result = mysql_fetch_row($recommend["result"]);
$result = $recommend["result"];
$count = 20;
?>

<div class="container"  style="width:<?php echo $width * 4 + $blank * 3; ?>px;">
	<legend>
		<small> 推荐书目</small>
	</legend>
	<div id="recommend" class="carousel slide">
		<ol class="carousel-indicators">
			<?php 
			for ($i = 0; $i < ($count + 3-fmod($count + 3, 4)) / 4; $i++) { ?>
				<li data-target="#recommend" data-slide-to="<?php echo "$i"; ?>" <?php if ($i == 0) echo "class=\"active\""; ?> ></li>
			<?php } ?>
 		</ol>
		<div class="carousel-inner">
			<?php
			for ($i = 0; $i < $count; $i++)
				if (fmod($i, 4) == 0) {?>
				<div class="item <?php if ($i == 0) echo "active"; ?>">
					<div class="row">
						<?php 
							showItem($result[$i], 20, $width, 0);
							showItem($result[$i + 1], 30, $width, ($width + $blank));;
							showItem($result[$i + 2], 30, $width, ($width + $blank) * 2);
							showItem($result[$i + 3], 30, $width, ($width + $blank) * 3);
						 ?>
					</div>
				</div>

			<?php } ?>
		</div>
			<a class="carousel-control left" href="#recommend" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#recommend" data-slide="next">&rsaquo;</a>
		</div>
	</div>
</div>