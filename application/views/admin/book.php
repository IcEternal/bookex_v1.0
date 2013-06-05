<?php $this->load->view('admin/header') ?>
	<div class="container">
		<?php if ($this->session->userdata('del_result') === 'succ'): ?>
			<div class="alert alert-success fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <?php echo '删除信息成功'; 
		  $this->session->unset_userdata('del_result');
		  ?>
			</div>
		<?php endif; ?>

		<?php if ($this->session->userdata('del_result') === 'fail'): ?>
			<div class="alert alert-success fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <?php echo '删除信息失败'; 
		  $this->session->unset_userdata('del_result');
		  ?>
			</div>
		<?php endif; ?>

		<div class="alert alert-error fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <div>书本管理  绿色行代表用户选择自行交易,无须送书！</div>
		</div>
		<div class="alert alert-error fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <div>管理员们请注意，删除按钮没有确认框，请勿手滑删掉书本信息！！！！！</div>
		</div>
		<div class="row">
		  <div class="span3">
		  	<h3>搜索条件</h3>
		  	<p>每个空都为约束条件</p>
			<?php
			
			echo form_open('admin/book');
			echo form_label('图书信息','book_info');
			echo form_input('book_info',$search_data['book_info']);
			echo form_label('上传者','uploader');
			echo form_input('uploader',$search_data['uploader']);
			echo form_label('预订者','subscriber');
			echo form_input('subscriber',$search_data['subscriber']);
			echo form_label('书籍状态','status');
			?>
			<label class="checkbox inline">
			  <input type="checkbox" name="no_reserve" value="1" <?php //检测session是否设置，检测是否为0
			  if($search_data['no_reserve']){echo 'checked="checked"';}?> > 未预定
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" name="reserved" value="1" <?php if($search_data['reserved']){echo 'checked="checked"';}?> > 已预定
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" name="traded" value="1" <?php if($search_data['traded']){echo 'checked="checked"';}?> > 已交易
			</label>
			<div class="submit">
			<input class="btn btn-primary" type="submit" name="submit" value="搜索"  />
			<a class="btn btn-primary" href="<?php echo site_url().'/admin/book/index';?>"/>重置</a>
			<a class="btn btn-primary" href="<?php echo site_url().'/admin';?>"/>返回</a>
			</div>
			</form>
			<a ></a>
		  </div>
		  <div class="span9">
		  	<h3>搜索结果</h3>
		  	<p>找到<?php echo $total_rows;?>本书，默认按上传时间排序，最新上传第一位</p>
			<table  class="table table-bordered table-hover">
				<tr>
					<th>图书名</th>
					<th>价格</th>
					<th>原价</th>
					<th>上传者</th>
					<th>预订者</th>
					<th>交易</th>
					<th></th>
				</tr>
				<?php
				foreach ($book_info as $row) {
					$modify_url = site_url().'/admin/book_modify/'.$row->id;
					$delete_url = site_url().'/admin/book_delete/'.$row->id;
					$uploader_url = site_url().'/admin/user_modify/'.$row->uploader_id;
					// if($row->subscriber_id)
					// {$subscriber_url = site_url().'/admin/user_modify/'.$row->subscriber_id;}else
					// {$subscriber_url = '#';}
					if(isset($row->subscriber_id)){$subscriber_url = anchor(site_url('admin/user_modify/'.$row->subscriber_id),$row->subscriber);}
					else{$subscriber_url = $row->subscriber;}
					if($row->finishtime > 0){$trade_status = '已完成';}
					else{
						if($row->subscriber == 'N')
						{
							$trade_status = '等待预定';
						}
						else
						{
							$trade_status = anchor(site_url('admin/book_trade/'.$row->id),'完成交易');
						}
						
					}
					$style = '';
					if ($row->use_phone == true) {
						$style = 'class="success"';
					}
					printf('
						<tr %s>
						<td><a href="%s" target="_blank"><i class="icon-pencil"></i>%s</a></td>
						<td>%s</td>
						<td>%s</td>
						<td><a href="%s" target="_blank">%s</a></td>
						<td>%s</td>
						<td>%s</td>
						<td><a href="%s"><i class="icon-remove"></i></a></td></tr>',$style,$modify_url,$row->name,$row->price,$row->originprice,$uploader_url,$row->uploader,$subscriber_url,$trade_status,$delete_url);
				}
				?>
				

			</table>
			<?php
			echo $this->pagination->create_links();
			?>
		  </div>
		</div>
	</div>

<script src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
</body>
</html>

<?php $this->load->view('admin/footer') ?>
