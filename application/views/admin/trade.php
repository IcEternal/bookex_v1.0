<?php $this->load->view('includes/header') ?>
	<div class="container">
		
		<div class="alert alert-error fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <div>等待交易的书籍，不包括选择自行交易的图书</div>
		</div>

		<a class="btn btn-primary" href="<?php echo site_url().'/admin';?>"/>返回管理主页</a>
		<div class="row">
		  <div class="span12">
		  	<h3>卖书者<?php echo count($saler_info);?>位</h3>
		  	<?php foreach ($saler_info as $saler) :
		  	$user_url = site_url().'/admin/user_modify/'.$saler['user_id'];?>
		  	
			<table class="table table-bordered table-hover">
				<tr class="success">
					<td width=50% colspan="6"><?php 
				  	printf(
				  		'卖书者：<a target="_blank" href="%s"><span class="label label-info">%s</span></a>
				  		电话：<span>%s</span>
						寝室: <span class="label label-info">%s</span>
				  		书本数：<span class="label label-info">%s</span>
				  		书本金额：<span class="label label-info">%s元</span>
				  		',$user_url,$saler['uploader'],$saler['phone'],$saler['dormitory'],$saler['book_num'],$saler['book_money']
				  		);
				  	?>
				    </td>
		  		</tr>
				<?php if ($saler['remarks']!="") { ?>
		  		<tr class="alert">
		  			<td width=100% colspan="6"><?php echo $saler['remarks'] ?></td>
		  		</tr>
				<?php } ?>
				<?php foreach ($sale_book[$saler['uploader']] as $book) :
				$book_url = site_url().'/admin/book_modify/'.$book->id;
				$user_url = site_url().'/admin/user_modify/'.$book->user_id;
				$book_status_string = $this->book_model->get_status_string($book->id);
				$current_user = $this->session->userdata('username');
				?>
				<tr>
		  			<td width=20%>		  				
					  	<span class="label label-info status" book_id="<?php echo $book->id ?>" status="1" style="margin-right:20px;"><?php echo $this->book_model->get_status_string($book->id); ?></span>
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
				<tr>
					<td>#<a target="_blank" href="<?php echo $book_url;?>"><?php echo $book->name;?></a></td>
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
		  			</td>
		  		</tr>
				<?php if ($buyer['remarks']!="") { ?>
		  		<tr class="alert">
		  			<td width=100% colspan=6><?php echo $buyer['remarks'] ?></td>
		  		</tr>
				<?php } ?>
				<?php foreach ($buy_book[$buyer['subscriber']] as $book) :
				$book_url = site_url().'/admin/book_modify/'.$book->id;
				$user_url = site_url().'/admin/user_modify/'.$book->user_id;?>
				<tr>
		  			<td width=20%>		  				
					  	<span class="label label-info status" book_id="<?php echo $book->id ?>" status="1"><?php echo $this->book_model->get_status_string($book->id); ?></span>
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
				<tr>
					<td >#<a target="_blank" href="<?php echo $book_url;?>"><?php echo $book->name;?></a></td>
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
<?php $this->load->view('admin/footer') ?>


