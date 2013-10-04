<?php $this->load->view('delivery/header') ?>
<!-- in the row	 -->
	<div class="span12">
		<p><?php echo $quantity;?></p>
		<?php foreach ($buyer_list as $buyer) :?>
		<table class="table table-bordered table-hover">
			<tr>
				<th colspan=5>
				<?php
				$generate_order = anchor(site_url('delivery/gather_submit_into_order/'.$buyer['buyer_detail']['id']),'<span class="label label-success right">生成订单</span>');
				$user_anchor = anchor_popup(site_url('admin/user_modify/'.$buyer['buyer_detail']['id']),$buyer['buyer_detail']['username']);
				echo '买家：';
				echo '  <i class="icon-user"></i>  '.$user_anchor.'('.$buyer['buyer_detail']['phone'].')';
				echo '  <i class="icon-home"></i>  '.$buyer['buyer_detail']['dormitory'];
				echo '  <i class="icon-info-sign"></i>  '.$buyer['buyer_detail']['student_number'];
				if($buyer['buyer_detail']['show_phone'])
				{
					echo ' 支持自行交易';
				}
				else
				{
					echo ' 不支持自行交易';
				}
				echo $generate_order;
				?>
				</th>
				
			</tr>
			<?php
			$book_url = site_url('book_details/book/');
			$user_url = site_url('admin/user_modify/');
			foreach ($buyer['submit_info'] as $submit) :?>
			<?php $revocation = anchor(site_url('delivery/revocation/'.$submit['id']),
			"<span class='label label-important right'>恢复未审核状态</span>");?>
				<tr>
				<td width=5%>#<?php echo $submit['id'];?></td>
				<td width=50%><?php echo anchor_popup($book_url.'/'.$submit['book_detail']['id'],$submit['book_detail']['name']);?></td>
				<td width=25%><?php echo anchor_popup($user_url.'/'.$submit['seller_detail']['id'],$submit['seller_detail']['username']).
				'('.$submit['seller_detail']['phone'].')';?></td>
				<td width=6%>￥<?php echo $submit['book_detail']['price'];?></td>
				<td width=19%><?php echo $revocation;?></td>
				</tr>
			<?php endforeach;?>
		</table>
		<?php endforeach;?>
	</div><!-- end of span12	 -->
</div><!-- end of row -->
<script src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
</body>
</html>
