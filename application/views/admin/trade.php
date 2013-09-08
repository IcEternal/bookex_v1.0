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
					<td width=50% colspan="5"><?php 
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
		  			<td width=100% colspan="5"><?php echo $saler['remarks'] ?></td>
		  		</tr>
				<?php } ?>
				<?php foreach ($sale_book[$saler['uploader']] as $book) :
				$book_url = site_url().'/admin/book_modify/'.$book->id;
				$user_url = site_url().'/admin/user_modify/'.$book->user_id;
				?>
				<tr>
		  			<td width=100% colspan="5">		  				
					  	<span class="label label-info status" book_id="<?php echo $book->id ?>">当前状态</span>
					  	<span class="label label-info next_operation" book_id="<?php echo $book->id ?>">下一步操作</span>
					  	<span class="label label-info prev_operation" book_id="<?php echo $book->id ?>">上一步操作</span>
					  	<span class="label label-info deal_done" book_id="<?php echo $book->id ?>">完成交易</span>
					  	<span class="label label-info book_deleted" book_id="<?php echo $book->id ?>">卖家那儿取不到书</span>
					  	<span class="label label-info deal_canceled" book_id="<?php echo $book->id ?>">取消此订单</span>
		  			</td>
		  		</tr>
				<tr>
					<td>#<a target="_blank" href="<?php echo $book_url;?>"><?php echo $book->name;?></a></td>
					<td width=10%>￥<?php echo $book->price;?></td>
					<td width=35%>买家@<a target="_blank" href="<?php echo $user_url;?>"><?php echo $book->subscriber;?></a>(<?php echo $book->phone;?>)</td>
					<td width=10%><?php echo $book->dormitory; ?></td>
					<td width=5%><?php echo anchor(site_url('admin/book_trade/'.$book->id),'<i class="icon-ok"></i>');?></td>
				</tr>

				<?php endforeach;?>
			</table>
		    <?php endforeach;?>
		  		
			<h3>买书者<?php echo count($buyer_info);?>位</h3>
		  	<?php foreach ($buyer_info as $buyer) :
		  	$user_url = site_url().'/admin/user_modify/'.$buyer['user_id'];?>
		  	
			<table class="table table-bordered table-hover">
				<tr class="success">
					<td width=50% colspan="5">
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
		  			<td width=100% colspan=5><?php echo $buyer['remarks'] ?></td>
		  		</tr>
				<?php } ?>
				<?php foreach ($buy_book[$buyer['subscriber']] as $book) :
				$book_url = site_url().'/admin/book_modify/'.$book->id;
				$user_url = site_url().'/admin/user_modify/'.$book->user_id;?>
				<tr>
		  			<td width=100% colspan="5">		  				
					  	<span class="label label-info status" book_id="<?php echo $book->id ?>">当前状态</span>
					  	<span class="label label-info next_operation" book_id="<?php echo $book->id ?>">下一步操作</span>
					  	<span class="label label-info prev_operation" book_id="<?php echo $book->id ?>">上一步操作</span>
					  	<span class="label label-info deal_done" book_id="<?php echo $book->id ?>">完成交易</span>
					  	<span class="label label-info book_deleted" book_id="<?php echo $book->id ?>">卖家那儿取不到书</span>
					  	<span class="label label-info deal_canceled" book_id="<?php echo $book->id ?>">取消此订单</span>
		  			</td>
		  		</tr>
				<tr>
					<td>#<a target="_blank" href="<?php echo $book_url;?>"><?php echo $book->name;?></a></td>
					<td width=10%>￥<?php echo $book->price;?></td>
					<td width=35%>卖家@<a target="_blank" href="<?php echo $user_url;?>"><?php echo $book->uploader;?></a>(<?php echo $book->phone;?>)</td>
					<td width=10%><?php echo $book->dormitory?></td>
					<td width=5%><?php echo anchor(site_url('admin/book_trade/'.$book->id),'<i class="icon-ok"></i>');?></td>
				</tr>
				<?php endforeach;?>
			</table>
		    <?php endforeach;?>
		  </div>
		</div>
	</div>
<?php $this->load->view('admin/footer') ?>


