<?php $this->load->view('includes/header') ?>

<style type="text/css">
	.remarks
	{
		margin:0;

	}
</style>
	<div class="container">
		<div class="alert alert-error fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <div>等待交易的书籍，不包括选择自行交易的图书</div>
		</div>

		<a class="btn btn-primary" href="<?php echo site_url().'/admin';?>"/>返回管理主页</a>
		<div class="row">
		  <div class="span12">
		  	<h3>卖书者<?php echo count($saler_list);?>位</h3>
		  	<?php foreach ($saler_list as $saler) :
		  	$sum_price = $saler['sum_price'];
		  	$book_num = $saler['book_num'];
		  	$saler_id = $saler['saler_id'];

		  	$saler_url = site_url().'/admin/user_modify/'.$saler_id;

		  	$saler_query = $this->db->query("SELECT * FROM user WHERE id = $saler_id");
		  	$saler_detail = $saler_query->row();
		  	?>

			<table class="table table-bordered table-hover">
				<tr class="success">
					<td width=50% colspan="5"><?php
					echo "
					卖书者:$saler_detail->username
					电话:$saler_detail->phone
					寝室:$saler_detail->dormitory
					书本数:$book_num
					书本金额:$sum_price 元
					"
				  	?>
				    </td>
		  		</tr>
				
				<?php foreach ($saler['order_list'] as $order):
				$order_id = $order['id'];
				$order_detail = $this->order_model->tradeDetail($order_id);
				$book_id = $order_detail['book_info']['id'];
				$book_url = site_url().'/admin/book_modify/'.$book_id;
				$buyer_url = site_url().'/admin/user_modify/'.$order_detail['buyer_info']['id'];
				$book_name = $order_detail['book_info']['name'];
				$book_name = (mb_strlen($book_name)>10)?mb_substr($book_name,0,10).'..':$book_name;
				$book_price = $order_detail['book_info']['price'];
				$buyer_name = $order_detail['buyer_info']['username'];
				$buyer_phone = $order_detail['buyer_info']['phone'];
				$buyer_dormitory = $order_detail['buyer_info']['dormitory'];

				$trade_method = $order_detail['order_brief']['trade_method_dict'];
				$trade_status = $order_detail['order_brief']['trade_status_dict'];
				$money_status = $order_detail['order_brief']['money_status_dict'];
				$book_status = $order_detail['order_brief']['book_status_dict'];


				$finish_link = site_url("admin/book_trade/$book_id");
				$cancel_link = site_url("admin/book_cancel/$book_id");
				$pay_link = site_url("admin/book_pay/$book_id");
				$get_book_link = site_url("admin/book_hasit/$book_id");
				$pay_get_link = site_url("admin/pay_get_book/$book_id");

				$finish_anchor = anchor($finish_link,"<span class='label label-info'>完成交易</span>");
				$cancel_anchor = anchor($cancel_link,"<span class='label label-error'>取消交易</span>");
				$pay_anchor = anchor($pay_link,"<span class='label label-success'>$money_status</span>");
				$get_book_anchor = anchor($get_book_link,"<span class='label label-success'>$book_status</span>");
				$pay_get_anchor = anchor($pay_get_link,"<span class='label label-success'>pay and Get</span>");
				?>
				<tr>
					<td width=20%>#<a target="_blank" href="<?php echo $book_url;?>"><?php echo $book_name;?></a></td>
					<td width=5%>￥<?php echo $book_price;?></td>
					<td width=25%>买家@<a target="_blank" href="<?php echo $buyer_url;?>"><?php echo $buyer_name;?></a>(<?php echo $buyer_phone;?>)</td>
					<td width=10%><?php echo $buyer_dormitory; ?></td>
					<td><?php echo $cancel_anchor.' '.$pay_anchor.' '.$get_book_anchor
					.' '.$pay_get_anchor.' '.$finish_anchor;?></td>
				</tr>
				<?php endforeach;?>
			</table>
		    <?php endforeach;?>
		  	
		  </div>
		</div>
	</div>
</body>
</html>


