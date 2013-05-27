<?php $this->load->view('admin/header') ?>

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
		  	<a class="btn btn-primary" href="<?php echo site_url().'/admin/book/index';?>">图书管理</a>
		  	<table class="table table-bordered table-hover">
		  		<tr><th>统计信息</th><th>(本)</th></tr>
		  		<tr><td>图书总数</td><td><?php echo $book_num;?></td></tr>
		  		<tr><td>图书未预定数</td><td><?php echo $book_unreserved_num;?></td></tr>
		  		<tr><td>图书预定数(等待交易)</td><td><?php echo $book_reserved_num;?></td></tr>
		  		<tr><td>图书交易数</td><td><?php echo $book_traded_num;?></td></tr>
		  	</table>

		  	<table class="table table-bordered table-hover">
		  		<tr><th>今日新增</th><th>(本)</th></tr>
		  		<tr><td>图书总数</td><td><?php echo $book_num;?></td></tr>
		  		<tr><td>图书未预定数</td><td><?php echo $book_unreserved_num;?></td></tr>
		  		<tr><td>图书预定数(等待交易)</td><td><?php echo $book_reserved_num;?></td></tr>
		  		<tr><td>图书交易数</td><td><?php echo $book_traded_num;?></td></tr>
		  	</table>

		  	<table class="table table-bordered table-hover">
		  		<tr><th>本周统计</th><th>(本)</th></tr>
		  		<tr><td>图书总数</td><td><?php echo $book_num;?></td></tr>
		  		<tr><td>图书未预定数</td><td><?php echo $book_unreserved_num;?></td></tr>
		  		<tr><td>图书预定数(等待交易)</td><td><?php echo $book_reserved_num;?></td></tr>
		  		<tr><td>图书交易数</td><td><?php echo $book_traded_num;?></td></tr>
		  	</table>
		  	
		  </div>
		  <div class="span6">
		  
		  	<a class="btn btn-primary" href="<?php echo site_url().'/admin/user';?>">会员管理</a>
		  	<table class="table table-bordered table-hover">
		  		<tr><td>统计信息</td><td>人数</td></tr>
		  		<tr><td>会员总数</td><td><?php echo $user_num;?></td></tr>
		  		<tr><td>今日新增</td><td><?php echo $user_num;?></td></tr>
		  	</table>
			
		  </div>
		</div>
		
	</div>

<script src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
</body>
</html>

<?php $this->load->view('admin/footer') ?>