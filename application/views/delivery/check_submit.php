<?php $this->load->view('delivery/header') ?>
<!-- in the row	 -->
<style type="text/css">
	.back
	{
		float: right;
	}
</style>
	<div class="span12">
		<p><?php echo $quantity;?></p>
		<?php
		$book_url = site_url('book_details/book/');
		$user_url = site_url('admin/user_modify/');
		$submit_status = array(
		'0'=>'申请委托',
		'11'=>'交易拒绝',
		'12'=>'用户取消',
		'21'=>'审核通过',
		'31'=>'生成订单',
		'41'=>'超时取消',
		'42'=>'无书取消',
		'51'=>'已收到书',
		'61'=>'订单完成，succ',
		'62'=>'订单完成，fail',
		);
		$order_by_status_url = site_url('delivery/check_submit?order_by_status=1');
		$order_by_time_url = site_url('delivery/check_submit');
		if($this->input->get('order_by_status') )
		{
			$order_by_status_button = "<span class='label'>按状态排序</span>  ";
			$order_by_time_button = anchor($order_by_time_url,"<span class='label label-warning'>按时间/编号排序</span>");
		}
		else
		{
			$order_by_status_button = anchor($order_by_status_url,"<span class='label label-warning'>按状态排序</span>").' ';
			$order_by_time_button = "<span class='label'>按时间/编号排序</span>";
		}
		?>
		<table class="table table-bordered table-hover">
			<tr>
				<th width=7%>编号</th>
				<th width=53%><?php echo $order_by_status_button.$order_by_time_button;?></th>
				<th width=15%>买家</th>
				<th width=15%>卖家</th>
				<th width=10%>价格</th>
			</tr>
			<?php foreach ($submit_result as $submit) :?>
			<tr>
				<td  rowspan=2><?php echo $submit['id'];?></td>
				<td><?php echo anchor_popup($book_url.'/'.$submit['book_detail']['id'],$submit['book_detail']['name']);?></td>
				<td><?php echo anchor_popup($user_url.'/'.$submit['buyer_detail']['id'],$submit['buyer_detail']['username']).
				'('.$submit['buyer_detail']['phone'].')';?></td>
				<td><?php echo anchor_popup($user_url.'/'.$submit['seller_detail']['id'],$submit['seller_detail']['username']).
				'('.$submit['seller_detail']['phone'].')';?></td>
				<td>￥<?php echo $submit['book_detail']['price'];?></td>
			</tr>
			<tr>
				<td colspan=4><?php
				$icon = NULL;
				$last_status = NULL;
				foreach ($submit['submit_record'] as $key => $record) {
					$op_time = $record['op_time'];
					$status = $last_status = $record['submit_status'];
					$show_time = ($key==0)?substr($op_time,5,11):NULL;
					echo $icon;
					//echo "<span class='label label-info'>".substr($record['op_time'],5,11)."</span>";
					echo "<span class='label label-info'  title='$op_time'>".$show_time.' '.$submit_status[$status]."</span>";
					$icon = "<i class='icon-arrow-right'></i>";
				}
				$ok_status = array('11','12','61','62');
				if(in_array($last_status,$ok_status) )
					echo "<i class='icon-ok'></i>";
				else
					echo "<i class='icon-arrow-right'></i>";
				?>
				<?php
				if($submit['status'] == 0)
				{
					echo anchor(site_url('delivery/pass_submit/'.$submit['id']),"<span class='label label-success'>通过</span>");
					echo "&nbsp&nbsp&nbsp";
					echo anchor(site_url('delivery/delegation_deny/'.$submit['id']),"<span class='label label-important'>拒绝</span>");
				}
				else
				{
					echo anchor(site_url('delivery/revocation/'.$submit['id']),"<span class='label label-important back'>回到上一状态</span>");
				}
				?>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
		<div class="pagination">
			<ul>
			<?php foreach ($link_array as $value) {echo $value;} ?>
			</ul>
		</div>
	</div><!-- end of span12	 -->
</div><!-- end of row -->
</body>
</html>
