<?php $this->load->view('includes/header') ?>

<style type="text/css">
	table
	{
		margin-top: 20px;
	}
</style>
	<div class="container">
		<div class="alert alert-error fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <div>管理员模式</div>
		</div>
		<?php ?>

		<div class="row">
		  <div class="span6">
		  	<a class="btn btn-primary" href="<?php echo site_url().'/admin/book?no_reserve=1&reserved=1&traded=1';?>">图书管理</a>
		  	<table class="table table-bordered table-hover">
		  		<tr><th>统计信息</th><th>(本)</th></tr>
		  		<tr><td>图书总数</td><td><?php echo $book_num;?></td></tr>
		  		<tr><td>图书未预定数</td><td><?php echo $book_unreserved_num;?></td></tr>
		  		<tr><td>图书预定数(等待交易)</td><td><?php echo $book_reserved_num;?></td></tr>
		  		<tr><td>图书交易数</td><td><?php echo $book_traded_num;?></td></tr>
		  		<tr><td><?php echo anchor('/admin/book?del=1&no_reserve=1&reserved=1&traded=1','图书删除数');?></td><td><?php echo $book_del_num;?></td></tr>
		  	</table>

		  	<a class="btn btn-primary" href="<?php echo site_url().'/admin/book_classify';?>">图书分类</a>
		  	<table class="table table-bordered table-hover">
		  		<tr><td>统计信息</td><td>(本)</td></tr>
		  		<tr><td>未分类图书</td><td><?php echo $unclassify_num;?></td></tr>
		  	</table>
		  </div>
		  <div class="span6">
		  	<a class="btn btn-primary" href="<?php echo site_url().'/admin/user?order_by_up=1';?>">会员管理</a>
		  	<table class="table table-bordered table-hover">
		  		<tr><td>统计信息</td><td>人数</td></tr>
		  		<tr><td>会员总数</td><td><?php echo $user_num;?></td></tr>
		  		<tr><td>今日新增</td><td><?php echo $user_num;?></td></tr>
		  	</table>

		  	<a class="btn btn-primary" href="<?php echo site_url().'/admin/trade';?>">今日交易</a>
		  	<table class="table table-bordered table-hover">
		  		<tr><td>交易双方</td><td>人数</td></tr>
		  		<tr><td>买家数目</td><td><?php echo $buyer_num;?></td></tr>
		  		<tr><td>卖家数目</td><td><?php echo $saler_num;?></td></tr>
		  	</table>
		  	
		  	<!-- 生成抵价券 -->
		  	<a class="btn btn-primary" id="generate_discount" style="margin-bottom: 10px">生成抵价券</a>
		  	<input type="text" id="discount_ticket" /><br/>
		  	<a class="btn btn-primary" id="generate_free" style="margin-bottom: 10px">生成赠书券</a>
		  	<input type="text" id="free_ticket" /><br/>
		  	<!-- end of generating -->
		  </div>
		</div>
	</div>

<?php $this->load->view('admin/footer') ?>