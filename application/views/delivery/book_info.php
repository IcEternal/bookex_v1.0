<?php $this->load->view('delivery/header') ?>
<!-- in the span12	 -->
	<div class="well">
		<div class="row">
			<div class="span3">
				<?php $id = $book_info['id'];?>
				<img src = "<?php echo base_url('get_data.php?id='.$id); ?>" style = "width:200px" />
			</div>
			<div class="span8">
				<h4>图书信息</h4>
				<table class="table table-bordered table-hover">
					<tr>
						<td width="10%">书名</td>
						<td width="40%"><?php echo $book_info['name'];?></td>
						<td width="10%">作者</td>
						<td width="40%"><?php echo $book_info['author'];?></td>
					</tr>
					<tr>
						<td>原价</td>
						<td>￥<?php echo $book_info['price'];?></td>
						<td>售价</td>
						<td>￥<?php echo $book_info['originprice'];?></td>
					</tr>
					<tr>
						<td>出版社</td>
						<td><?php echo $book_info['publisher'];?></td>
						<td>ISBN</td>
						<td><?php echo $book_info['ISBN'];?></td>
					</tr>
					<tr>
						<td>描述</td>
						<td colspan="3"><?php echo $book_info['description'];?></td>
					</tr>
					<tr>
						<td>上传者</td>
						<td colspan="3"><?php echo $book_info['uploader'];?></td>
					</tr>
				</table>
				<hr>
				<h4>交易信息</h4>
				<table class="table table-bordered table-hover">
					<tr>
						<td>上传时间</td>
						<td>空</td>
					</tr>
					<tr>
						<td>预定时间</td>
						<td><?php echo $book_info['subscribetime'];?></td>
					</tr>
					<tr>
						<td>完成交易时间</td>
						<td><?php echo $book_info['finishtime'];?></td>
					</tr>
					<tr>
						<td>删除时间</td>
						<td><?php echo $book_info['deltime'];?></td>
					</tr>
				</table>
				<hr>
				<h4>委托信息</h4>
				<table class="table table-bordered table-hover">
				<?php 
				foreach ($book_info['trade_info'] as $key => $value) {
					$submit_status = array(
					'0'=>'未处理',
					'11'=>'已审核，等待生成订单',
					'12'=>'已生成订单，正在收书',
					'13'=>'已收到书',
					'14'=>'买家收到书，交易完成',
					'21'=>'委托方拒绝交易',
					'22'=>'用户取消',
					'23'=>'超时取消',
					'24'=>'卖家无书取消',
					'25'=>'其他取消'
					);
					$create_time = $book_info['trade_info']['create_time'];
					$status = $book_info['trade_info']['status'];
					$status = $submit_status[$status];
					echo "<tr>
						<td>委托时间</td>
						<td>$create_time</td>
					</tr>
					<tr>
						<td>委托时间</td>
						<td>$status</td>
					</tr>";
				}
				?>
				</table>
			</div>
		</div>
		
	</div>
	</div><!-- end of span12	 -->
</div><!-- end of row -->
</body>
</html>