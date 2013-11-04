<?php
/*
================================================================
index_logined.php

include: includes/header.php
		 includes/footer.php

The welcome page of an old user.

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
function showItem($item){ ?>
	<div class="book-list">
		<a target="_blank" href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" >
			<div class="pic-box">
				<img src="<?php echo base_url('get_data.php?id='.$item->id); ?>" width="130px" />
			</div>
		</a>

		<div class="book-name">
			<a target="_blank" href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" >
			<?php 
				$text = $item->name;
	        	if (strlen($text) > 13) $text = getstr($text, 13).' ...';
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

<?php }
//$result = mysql_fetch_row($recommend["result"]);
$result = $recommend["result"];
$count = 20;
?>

<?php include("header.php"); ?>

<div id="content">
	<h2>推荐书目</h2>
	<?php
		for ($i = 0; $i < $count; $i++) {
			showItem($result[$i]);
		}
	?>
	<div class="fixed"></div>
</div>

<div id="sidebar">
	<h2>分类目录</h2>
	<?php include("navlist.php"); ?>
</div>

<?php include("footer.php"); ?>