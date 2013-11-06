<?php $this->load->view('delivery/header') ?>
<!-- in the row	 -->
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
		'31'=>'等待收书',
		'41'=>'超时取消',
		'42'=>'无书取消',
		'51'=>'已收到书',
		'61'=>'订单完成，succ',
		'62'=>'订单完成，fail',
		);
		?>
		<?php foreach ($order_list as $order) :?>
		<table class="table table-bordered table-hover">
			<tr class='info'>
				<td colspan=5 >
				<?php
				$user_anchor = anchor_popup(site_url('admin/user_modify/'.$order['buyer_detail']['id']),$order['buyer_detail']['username']);
				echo '买家：';
				echo '  <i class="icon-user"></i>  '.$user_anchor.'('.$order['buyer_detail']['phone'].')';
				echo '  <i class="icon-home"></i>  '.$order['buyer_detail']['dormitory'];
				echo '  <i class="icon-info-sign"></i>  '.$order['buyer_detail']['student_number'];
				if($order['buyer_detail']['show_phone'])
				{
					echo ' 支持自行交易';
				}
				else
				{
					echo ' 不支持自行交易';
				}
					?>
				</td>
			</tr>
			<?php if($order['order_ready'])echo "<tr class='success'>"; else echo "<tr class='info'>";?>
				<td colspan=2>
					订单编号：<?php echo $order['id'];?>
					<span class="label label-info right">生成时间：<?php echo $order['create_time'];?></span>
				</td>
				<td colspan=3 >
					<?php
					if($order['order_ready'])
					{
						$close_order_anchor = anchor(site_url('delivery/close_order/'.$order['id']),
							'<span class="label label-success right">买家完成取书</span>');
						echo '通知买家来取书'.$close_order_anchor.'<span class="label label-success right right-margin">生成短信</span>';
					}
					else
					{
						echo '订单下书籍还未准备好';
					}
					?>
				</td>
			</tr>
			<tr class="info">
				<td colspan=2>
					<form class="form-inline" method='post' action='<?php echo site_url('delivery/add_order_msg');?>' >
					  <input type="text" name='msg' placeholder="订单笔记">
					  <input type='hidden' name='order_id' value='<?php echo $order['id'];?>' >
					  <button type="submit" class="btn">自定义新增</button>
					  <a href="<?php echo site_url('delivery/add_order_msg?order_id='.
					  $order['id'].'&msg=已通知买家来取书')?>" class="btn">已通知买家来取书</a>
					</form>
				</td>
				<td colspan=3>
				<?php
				$new = '(最新)';
				foreach ($order['msg_list'] as $msg) {
					echo '<i class="icon-comment"></i>'.substr($msg['contact_time'],5,11).' '.$msg['msg'].$new;
					echo anchor(site_url('delivery/del_msg/'.$msg['id']),'<span class="label label-important right"><i class="icon-remove icon-white"></i></span>');
					echo '<span class="label label-info right right-margin">by: '.$msg['op_info']['username'].'</span>';
					echo '<br>';
					$new = NULL;
				}
				?>
				</td>
			</tr>

			
			<?php
			foreach ($order['submit_info'] as $submit) :?>
			<?php 
			$over_time_cancel = anchor(site_url('delivery/over_time_cancel/'.$submit['id']),
			"<span class='label label-important right'>超时取消</span>");
			$revocation = anchor(site_url('delivery/revocation/'.$submit['id']),"<span class='label label-important right'>回到等待收书</span>");
			?>
				<?php if($submit['status'] == 31)echo "<tr>";else echo "<tr class='success'>";?>
				<td width=5%>#<?php echo $submit['id'];?></td>
				<td width=46%><?php echo anchor_popup($book_url.'/'.$submit['book_detail']['id'],$submit['book_detail']['name']);?>
					<span class="label label-info right"><?php echo $submit_status[$submit['status']];?></span>
				</td>
				<td width=24%>卖家 <?php echo anchor_popup($user_url.'/'.$submit['seller_detail']['id'],$submit['seller_detail']['username']).
				'('.$submit['seller_detail']['phone'].')';?></td>
				<td width=6%>￥<?php echo $submit['book_detail']['price'];?></td>
				<td width=19%><?php if($submit['status'] == 31){echo $over_time_cancel;}
					else{echo $revocation;}?></td>
				</tr>
			<?php endforeach;?>
		</table>
		<?php endforeach;?>
	</div><!-- end of span12	 -->
</div><!-- end of row -->
</body>
</html>