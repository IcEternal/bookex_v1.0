<?php $this->load->view('includes/header') ?>
	<div class="container">
		<a class="btn btn-primary btn-block" href="<?php echo site_url().'/admin';?>"/>返回管理主页</a>
		<div class="row">
		  <div class="span12">
		  	<h3>卖书者<?php echo count($saler_info);?>位</h3>
		  	<?php foreach ($saler_info as $saler) :
		  	$user_url = site_url().'/admin/user_modify/'.$saler['user_id'];?>
		  	<?php 
		  	printf(
		  		'<p>卖书者：<a target="_blank" href="%s"><span class="label label-info">%s</span></a>
		  		电话：<span class="label label-info">%s</span>
		  		书本数：<span class="label label-info">%s</span>
		  		书本金额：<span class="label label-info">%s元</span></p>
		  		',$user_url,$saler['uploader'],$saler['phone'],$saler['book_num'],$saler['book_money']
		  		);
		  	?>
			<table class="table table-bordered table-hover">
				<tr>
					<td>书名</td>
					<td>售价</td>
					<td>买家</td>
					<td>买家电话</td>
					<td>完成交易</td>
				</tr>
				<?php foreach ($sale_book[$saler['uploader']] as $book) :
				$book_url = site_url().'/admin/book_modify/'.$book->id;
				$user_url = site_url().'/admin/user_modify/'.$book->user_id;
				?>
				<tr>
					<td><a target="_blank" href="<?php echo $book_url;?>"><?php echo $book->name;?></a></td>
					<td><?php echo $book->price;?>元</td>
					<td><a target="_blank" href="<?php echo $user_url;?>"><?php echo $book->subscriber;?></a></td>
					<td><?php echo $book->phone;?></td>
					<td><?php echo anchor(site_url('admin/book_trade/'.$book->id),'完成交易');?></td>
				</tr>
				<?php endforeach;?>
			</table>
		    <?php endforeach;?>
		  		
			<h3>买书者<?php echo count($buyer_info);?>位</h3>
		  	<?php foreach ($buyer_info as $buyer) :
		  	$user_url = site_url().'/admin/user_modify/'.$buyer['user_id'];?>
		  	<?php 
		  	printf(
		  		'买书者：<a target="_blank" href="%s"><span class="label label-success">%s</span></a>
		  		电话：<span class="label label-success">%s</span>
		  		书本数：<span class="label label-success">%s</span>
		  		书本金额：<span class="label label-success">%s元</span>
		  		',$user_url,$buyer['subscriber'],$buyer['phone'],$buyer['book_num'],$buyer['book_money']
		  		);
		  	?>
			<table class="table table-bordered table-hover">
				<tr>
					<td>书名</td>
					<td>售价</td>
					<td>卖家</td>
					<td>卖家电话</td>
					<td>完成交易</td>
				</tr>
				<?php foreach ($buy_book[$buyer['subscriber']] as $book) :
				$book_url = site_url().'/admin/book_modify/'.$book->id;
				$user_url = site_url().'/admin/user_modify/'.$book->user_id;?>
				<tr>
					<td><a target="_blank" href="<?php echo $book_url;?>"><?php echo $book->name;?></a></td>
					<td><?php echo $book->price;?>元</td>
					<td><a target="_blank" href="<?php echo $user_url;?>"><?php echo $book->uploader;?></a></td>
					<td><?php echo $book->phone;?></td>
					<td><?php echo anchor(site_url('admin/book_trade/'.$book->id),'完成交易');?></td>
				</tr>
				<?php endforeach;?>
			</table>
		    <?php endforeach;?>
		  </div>
		</div>
	</div>

<script src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
</body>
</html>

<?php $this->load->view('includes/footer') ?>
