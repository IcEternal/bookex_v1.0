<?php $this->load->view('includes/header') ?>
	<div class="container">
		<div class="alert alert-error fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <div>order list</div>
		</div>
		<div class="row">
		  <!-- <div class="span12">
		  	<h3>搜索条件</h3>
		  	<form action="" method="GET" class="form-inline">
		  		<input type="text" name="buyer" class="input-small" value="<?php echo $search_data['buyer'];?>">
	
				<button class="btn btn-primary" type="submit" name="submit" value="1" >搜索</button>
				<a class="btn btn-primary" href="<?php echo site_url().'/admin/order';?>"/>重置</a>
				<a class="btn btn-primary" href="<?php echo site_url().'/admin';?>"/>返回</a>
		  	</form>
		  </div> -->
		  <div class="span12">
		  	<!-- <h3>搜索结果</h3> -->
		  <a class="btn btn-primary" href="<?php echo site_url().'/admin';?>"/>返回</a>
		  	
		  	<p><?php echo $total_rows;?> orders </p>
			<table  class="table table-condensed">
				<tr>
					<th width="5%">id</th>
					<th width="17%">book_name</th>
					<th>saler</th>
					<th>buyer</th>
					<th>start_time</th>
					<th>交易状态</th>
					<th>money</th>
					<th>book</th>
					<th>operate</th>
					<th>remark</th>
				</tr>
				<?php
				foreach ($order_list as $order) {
					$trade_info = $this->order_model->tradeDetail($order['id']);

					$order_id = $order['id'];
					$book_id = $trade_info['book_info']['id'];
					$book_name = $trade_info['book_info']['name'];
					$book_name = (mb_strlen($book_name)>10)?mb_substr($book_name,0,10).'..':$book_name;
					$saler_name = $trade_info['saler_info']['username'];
					$buyer_name = $trade_info['buyer_info']['username'];
					$start_time = date("m-d",strtotime($trade_info['order_brief']['start_time']));
					$trade_method = $trade_info['order_brief']['trade_method_dict'];
					$trade_status = $trade_info['order_brief']['trade_status_dict'];
					$money_status = $trade_info['order_brief']['money_status_dict'];
					$book_status = $trade_info['order_brief']['book_status_dict'];

					$finish_link = site_url("admin/book_trade/$book_id");
					$cancel_link = site_url("admin/book_cancel/$book_id");
					$pay_link = site_url("admin/book_pay/$book_id");
					$get_book_link = site_url("admin/book_hasit/$book_id");
					$pay_get_link = site_url("admin/pay_get_book/$book_id");

					$finish_anchor = anchor($finish_link,"<i class='icon-ok'></i>");
					$cancel_anchor = anchor($cancel_link,"<i class='icon-remove'></i>");
					$pay_anchor = anchor($pay_link,"<span class='label label-success'>Pay</span>");
					$get_book_anchor = anchor($get_book_link,"<span class='label label-success'>Get</span>");
					$pay_get_anchor = anchor($pay_get_link,"<span class='label label-success'>pay and Get</span>");
					
					if($trade_info['order_brief']['trade_method'] == 1 && $trade_info['order_brief']['trade_status'] == 1)
					{
						echo '<tr class="success">';
						$trade_operator = $finish_anchor.$cancel_anchor;
					}
					else
					{
						echo "<tr>";
						$trade_operator = '';
					}
						

					if($trade_method == '委托')
					{
						$trade_method = '';
					}
					else
					{
						$money_status = '';
						$book_status = '';
						$pay_anchor = '';
						$get_book_anchor = '';
						$pay_get_anchor = '';
					}

					if($trade_info['order_brief']['trade_status'] != 1)
					{
						$money_status = '';
						$book_status = '';
						$pay_anchor = '';
						$get_book_anchor = '';
						$pay_get_anchor = '';
					}

					if($trade_info['order_brief']['book_status'] == 2)
					{
						$get_book_anchor = '';
						$pay_get_anchor = '';
					}

					if($trade_info['order_brief']['money_status'] == 2)
					{
						$pay_anchor = '';
						$pay_get_anchor = '';
					}



					echo "
						<td>$order_id</td>
						<td>$book_name</td>
						<td>$saler_name</td>
						<td>$buyer_name</td>
						<td>$start_time</td>
						<td>$trade_status $trade_method $trade_operator</td>
						<td>$money_status $pay_anchor</td>
						<td>$book_status $get_book_anchor</td>
						<td>$pay_get_anchor</td>
					</tr>
					";
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
		</div>
	</div>

</body>
</html>

<?php $this->load->view('admin/footer') ?>
