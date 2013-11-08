<?php $this->load->view('includes/header') ?>
	<div class="container">
		<h3>服务交易管理</h3>
		<hr>
		<div class="row">
		  <div class="span12">
		  	<h3>搜索条件</h3>
		  	<form action="" method="GET" class="form-inline">
		  	<input type="text" class="input-small" name="service_name" placeholder="服务名" value="<?php echo $search_data['service_name'];?>">
  			<input type="text" class="input-small" name="seller" placeholder="出售服务者" value="<?php echo $search_data['seller'];?>">
  			<input type="text" class="input-small" name="buyer" placeholder="预订者" value="<?php echo $search_data['buyer'];?>">
  			<label class="radio inline">
			  <input type="radio" name="status" value="0" <?php
			  if($search_data['status'] == 0){echo 'checked="checked"';}?> > 全部
			</label>
			<label class="radio inline">
			  <input type="radio" name="status" value="1" <?php
			  if($search_data['status'] == 1){echo 'checked="checked"';}?> > 正在服务
			</label>
			<label class="radio inline">
			  <input type="radio" name="status" value="3" <?php if($search_data['status']  == 3){echo 'checked="checked"';}?> > 已完成
			</label>
			<label class="radio inline">
			  <input type="radio" name="status" value="2" <?php if($search_data['status']  == 2){echo 'checked="checked"';}?> > 已取消
			</label>
			<button class="btn btn-primary" type="submit" name="submit" value="1" >搜索</button>
			<a class="btn btn-primary" href="<?php echo site_url().'/admin/service';?>"/>重置</a>
			<a class="btn btn-primary" href="<?php echo site_url().'/admin';?>"/>返回</a>
			</form>
			<a ></a>
		  </div>
		  <div class="span12">
		  	<table  class="table table-bordered table-hover">
				<tr>
					<th width="10%">交易ID</th>
					<th width="30%">服务信息</th>
					<th width="10%">价格</th>
					<th width="20%">卖家</th>
					<th width="20%">买家</th>
					<th>交易状态</th>
				</tr>
				<?php foreach ($service_info as $service) {
					if($service->finishtime == 0 AND $service->canceled == 0)
					{
						$status = '正在服务';
						$color = 'class="success"';
					}
					else if( $service->canceled == 1)
					{
						$status = '已取消';
						$color = 'class="error"';
					}
					else if( $service->canceled == 0 AND $service->finishtime > 0)
					{
						$status = '已完成';
						$color = 'class="warning"';
					}
					else
					{
						$status = '未知';
						$color = NULL;
					}
					$service_detail_link = anchor(site_url('admin/book_modify/'.$service->service_id),$service->name );
					echo "<tr $color >
							<td> $service->id </td>
							<td> $service_detail_link </td>
							<td> $service->price </td>
							<td> $service->seller </td>
							<td> $service->buyer </td>
							<td> $status </td>
						  </tr>";
				}
				?>
			</table>
			<div class="pagination">
				<ul>
				<?php
				foreach ($link_array as $key => $value) {
					echo $value;
				}
				?>
				</ul>
			</div>
		  </div>
		</div><!-- end of row -->


	</div>
</body>
</html>
