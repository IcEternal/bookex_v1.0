
<?php $this->load->view('includes/header') ?>
<?php
		
		function getColorByStr($str, $currentUser){
			if (strpos($str, '正在取书.')) return '#99FF00';
			elseif (strpos($str, '送到易班')) return '#FF0000';
			elseif (strpos($str, '正在送书.')!= false and strpos($str, $currentUser) >= 0) return '#999900';
			elseif (strpos($str, '找不到')) return '#333333';
			else return '#3A87AD';
		}
?>
	<div class="container">
		
		<div class="alert alert-error fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <div>等待交易的书籍，不包括选择自行交易的图书</div>
		</div>
		<script type="text/javascript" src="<?php echo base_url() ?>public/js/ZeroClipboard.js"></script>
		<script type="text/javascript">
			ZeroClipboard.setMoviePath("<?php echo base_url() ?>public/js/ZeroClipboard.swf"); 
		</script>


		<a class="btn btn-primary" href="<?php echo site_url().'/admin';?>"/>返回管理主页</a>
		<div class="row">
		  <div class="span12">
		  	<h3>卖书者<?php echo count($saler_info);?>位</h3>
		  	<?php foreach ($saler_info as $saler) :
		  	$user_url = site_url().'/admin/user_modify/'.$saler['user_id'];?>
		  	
			<table class="table table-bordered table-hover">
				<tr class="success ">
					<td width=50% colspan="6" user_id="<?php echo $saler['user_id'];?>" class="person-info"><span><?php 
				  	printf(
				  		'卖书者：<a target="_blank" href="%s"><span class="label label-info">%s</span></a>
				  		电话：<span>%s</span>
						寝室: <span class="label label-info">%s</span>
				  		书本数：<span class="label label-info">%s</span>
				  		书本金额：<span class="label label-info">%s元</span>
				  		',$user_url,$saler['uploader'],$saler['phone'],$saler['dormitory'],$saler['book_num'],$saler['book_money']
				  		);
				  	?></span>
				  	<input class="i_remark" type="text" value="<?php echo $saler['remarks'];?>" placeholder="备注">
				  	<?php 
				  		$message = "同学你好，您的";
				  		$bookmessage = "";
		  				foreach ($sale_book[$saler['uploader']] as $book){
		  					$bookname = $book->name;
		  					if ($book->status < 2) $bookmessage = $bookmessage."《".$bookname."》,￥$book->price"." ";
		  				}
					  	$message = "$message $bookmessage 被预定了。您可以在晚上8点半-10点 在逸夫楼圆厅易班工作室交易。 "; 
					  	//$postfix = "由于BookEx是促进书籍循环的公益组织，由交大学生志愿服务，时间精力有限。现在全校推广期提供一个月的免费送书服务，时间为每星期三与星期六晚，我们仍然真诚的希望您能到固定地点完成交易，谢谢！";
					    $postfix = "现在来易班圆厅交易可以得到BookEx送上的精美礼品哦！数量有限，送完为止！";
					  ?>
					<a  href="javascript:void(0)">
				  		<span id="createSalerText<?php echo $saler['user_id']; ?>" class="label label-info">生成短信</span>
				  	</a>
				  	<script language="javascript" type="text/javascript">
					  		document.getElementById("createSalerText<?php echo $saler['user_id']; ?>").onclick=function(){
					  			
					  			var str = "<?php echo $message ?>" + "\r\n" + "\r\n" + "<?php echo $postfix ?>" ;
								var clip = new ZeroClipboard.Client();
								var id = $(this).attr("id");  

								clip.setHandCursor( true );
								clip.setText(str);      

								clip.addEventListener('complete', function (client, text) {
								        alert("复制成功!!");
								});

								clip.glue(id);
					  		}

					</script>
				    </td>
		  		</tr>
				<?php foreach ($sale_book[$saler['uploader']] as $book) :
				$book_url = site_url().'/admin/book_modify/'.$book->id;
				$user_url = site_url().'/admin/user_modify/'.$book->user_id;
				$book_status_string = $this->book_model->get_status_string($book->id);
				$free_model = NULL;
				$free_color = NULL;
				$currentUser = $this->session->userdata('username');
				if($book->freed)
				{
					$free_model = "<span class='label label-warning'>兑</span>";
					$free_color = "class='error'";
				}
				else if($book->discounted)
				{
					$free_model = "<span class='label label-warning'>抵</span>";
					$free_color = "class='error'";
				}


				?>
				<tr <?php echo $free_color;?>>
		  			<td  width=20%>
		  				<?php $str = $this->book_model->get_status_string($book->id); ?>		  				
					  	<span class="label label-info status" book_id="<?php echo $book->id ?>" status="1" style="margin-right:20px; <?php echo 'background-color: '.getColorByStr($str, $currentUser).';'; ?>"><?php echo $str; ?></span>
					</td>
					<td width=10%>  	
					  	<span class="label label-info next_operation" book_id="<?php echo $book->id ?>" style="margin-right:20px;">下一步操作</span>
					</td>
					<td width=35%>  	
					  	<span class="label label-info prev_operation" book_id="<?php echo $book->id ?>" style="margin-right:20px;">上一步操作</span>
					</td>
					<td width=10%>  	
					  	<span class="label label-info deal_done" book_id="<?php echo $book->id ?>" style="margin-right:20px;">完成交易</span>
					</td>
					<td>  	
					  	<span class="label label-info book_deleted" book_id="<?php echo $book->id ?>" style="margin-right:20px;">卖家说书没了</span>
					</td>
					<td>  	
					  	<span class="label label-info deal_canceled" book_id="<?php echo $book->id ?>">取消此订单</span>
		  			</td>
		  		</tr>
				<tr <?php echo $free_color;?>>
					<td>#<?php echo $free_model; ?><a target="_blank" href="<?php echo $book_url;?>"><?php echo $book->name;?></a></td>
					<td>￥<?php echo $book->price;?></td>
					<td>买家@<a target="_blank" href="<?php echo $user_url;?>"><?php echo $book->subscriber;?></a>(<?php echo $book->phone;?>)</td>
					<td><?php echo $book->dormitory; ?></td>
					<td></td>
					<td></td>
				</tr>

				<?php endforeach;?>
			</table>
		    <?php endforeach;?>
		  		
			<h3>买书者<?php echo count($buyer_info);?>位</h3>
		  	<?php foreach ($buyer_info as $buyer) :
		  	$user_url = site_url().'/admin/user_modify/'.$buyer['user_id'];?>
		  	
			<table class="table table-bordered table-hover">
				<tr class="success">
					<td width=50% colspan="6">
						<?php 
					  	printf(
					  		'买书者：<a target="_blank" href="%s"><span class="label label-success">%s</span></a>
					  		电话：<span>%s</span>
					  		寝室: <span class="label label-success">%s</span>
					  		书本数：<span class="label label-success">%s</span>
					  		书本金额：<span class="label label-success">%s元</span>
					  		',$user_url,$buyer['subscriber'],$buyer['phone'],$buyer['dormitory'],$buyer['book_num'],$buyer['book_money']
					  		);
		  			?>
		  			<a  href="javascript:void(0)">
				  		<span id="createBuyerText<?php echo $buyer['user_id']; ?>" class="label label-info">生成短信</span>
				  	</a>
		  			</td>
		  			<?php 
				  		$message = "同学你好，您的";
				  		$bookmessage = "";
		  				foreach ($buy_book[$buyer['subscriber']]  as $book){
		  					$bookname = $book->name;
		  					$bookmessage = "$bookmessage"."《".$bookname."》,￥$book->price"." ";
		  				}
					  	$message = "$message $bookmessage 已经到货。您可以在晚上8点半-10点 在逸夫楼圆厅易班工作室取书。 "; 
					?>
		  			
				  	<script language="javascript" type="text/javascript">
					  		document.getElementById("createBuyerText<?php echo $buyer['user_id']; ?>").onclick=function(){
					  			
					  			var str = "<?php echo $message ?>" + "\r\n" + "\r\n" + "<?php echo $postfix ?>" ;
								var clip = new ZeroClipboard.Client();
								var id = $(this).attr("id");  

								clip.setHandCursor( true );
								clip.setText(str);      

								clip.addEventListener('complete', function (client, text) {
								        alert("复制成功!!");
								});

								clip.glue(id);
					  		}

					</script>
		  		</tr>

				<?php if ($buyer['remarks']!="") { ?>
		  		<tr class="alert">
		  			<td width=100% colspan=6><?php echo $buyer['remarks'] ?></td>
		  		</tr>
				<?php } ?>
				<?php foreach ($buy_book[$buyer['subscriber']] as $book) :
				$book_url = site_url().'/admin/book_modify/'.$book->id;
				$user_url = site_url().'/admin/user_modify/'.$book->user_id;
				$free_model = NULL;
				$free_color = NULL;
				if($book->freed)
				{
					$free_model = "<span class='label label-warning'>兑</span>";
					$free_color = "class='error'";
				}
				else if($book->discounted)
				{
					$free_model = "<span class='label label-warning'>抵</span>";
					$free_color = "class='error'";
				}
				?>
				<tr <?php echo $free_color;?> >
		  			<td  width=20%>
		  				<?php $str = $this->book_model->get_status_string($book->id); ?>		  				
					  	<span class="label label-info status" book_id="<?php echo $book->id ?>" status="1" style="margin-right:20px; <?php echo 'background-color: '.getColorByStr($str, $currentUser).';'; ?>"><?php echo $str; ?></span>
					</td>
					<td  width=10%>  	
					  	<span class="label label-info next_operation" book_id="<?php echo $book->id ?>">下一步操作</span>
					</td>
					<td width=35%>  	
					  	<span class="label label-info prev_operation" book_id="<?php echo $book->id ?>">上一步操作</span>
					</td>
					<td width=10%>  	
					  	<span class="label label-info deal_done" book_id="<?php echo $book->id ?>">完成交易</span>
					</td>  	
					<td>
						<span class="label label-info book_deleted" book_id="<?php echo $book->id ?>">卖家说书没了</span>
					</td>
					<td>  	
					  	<span class="label label-info deal_canceled" book_id="<?php echo $book->id ?>">取消此订单</span>
		  			</td>
		  		</tr>
				<tr <?php echo $free_color;?> >
					<td >#<?php echo $free_model; ?><a target="_blank" href="<?php echo $book_url;?>"><?php echo $book->name;?></a></td>
					<td>￥<?php echo $book->price;?></td>
					<td>卖家@<a target="_blank" href="<?php echo $user_url;?>"><?php echo $book->uploader;?></a>(<?php echo $book->phone;?>)</td>
					<td><?php echo $book->dormitory?></td>
					<td></td>
					<td></td>
				</tr>
				<?php endforeach;?>
			</table>
		    <?php endforeach;?>
		  </div>
		</div>
	</div>
<?php $this->load->view('admin/footer'); ?>


