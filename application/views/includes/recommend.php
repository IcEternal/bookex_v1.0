<?php 
$width=190;
$blank=30;

function getstr($string, $length, $encoding  = 'utf-8') {   
		    $string = trim($string);   
		    
		    if($length && strlen($string) > $length) {   
		        //截断字符   
		        $wordscut = '';   
		        if(strtolower($encoding) == 'utf-8') {   
		            //utf8编码   
		            $n = 0;   
		            $tn = 0;   
		            $noc = 0;   
		            while ($n < strlen($string)) {   
		                $t = ord($string[$n]);   
		                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {   
		                    $tn = 1;   
		                    $n++;   
		                    $noc++;   
		                } elseif(194 <= $t && $t <= 223) {   
		                    $tn = 2;   
		                    $n += 2;   
		                    $noc += 2;   
		                } elseif(224 <= $t && $t < 239) {   
		                    $tn = 3;   
		                    $n += 3;   
		                    $noc += 2;   
		                } elseif(240 <= $t && $t <= 247) {   
		                    $tn = 4;   
		                    $n += 4;   
		                    $noc += 2;   
		                } elseif(248 <= $t && $t <= 251) {   
		                    $tn = 5;   
		                    $n += 5;   
		                    $noc += 2;   
		                } elseif($t == 252 || $t == 253) {   
		                    $tn = 6;   
		                    $n += 6;   
		                    $noc += 2;   
		                } else {   
		                    $n++;   
		                }   
		                if ($noc >= $length) {   
		                    break;   
		                }   
		            }   
		            if ($noc > $length) {   
		                $n -= $tn;   
		            }   
		            $wordscut = substr($string, 0, $n);   
		        } else {   
		            for($i = 0; $i < $length - 1; $i++) {   
		                if(ord($string[$i]) > 127) {   
		                    $wordscut .= $string[$i].$string[$i + 1];   
		                    $i++;   
		                } else {   
		                    $wordscut .= $string[$i];   
		                }   
		            }   
		        }   
		        $string = $wordscut;   
		    }   
		    return trim($string);   
		}
function showItem($item, $blank, $width, $offset){ ?>
	<div class="container" style="height:200px; width:<?php echo $width; ?>px; float:left; margin-left: <?php echo $blank; ?>px;">
				<img src = "<?php echo base_url('get_data.php?id='.$item->id); ?>" style = "height:100%; margin-left:0px; " />
		<div class="carousel-caption" style="width:<?php echo $width-30; ?>px; margin-left: <?php echo $offset ?>px;">
			<h4 style="font-size: 13px;"><?php 
				$text = $item->name;
	            if (strlen($text) > 20) $text = getstr($text, 20).' ...';
	            echo $text;?></h4>
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
	<legend style="text-align: left">
		<small>推荐书目</small>
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