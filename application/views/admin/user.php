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
		  <div>用户管理</div>
		</div>
		<div class="alert alert-error fade in">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <div>管理员们请注意，删除按钮没有确认框，请勿手滑删掉用户信息！！！！！</div>
		</div>
		<div class="row">
		  <div class="span3">
		  	<h3>搜索条件</h3>
		  	<p>每个空都为约束条件</p>
			<?php
			echo form_open('admin/user');
			echo form_label('用户名','username');
			echo form_input('username',$search_data['username']);
			echo form_label('电话','phone');
			echo form_input('phone',$search_data['phone']);
			echo form_label('邮箱','email');
			echo form_input('email',$search_data['email']);
			echo form_label('学号','student_number');
			echo form_input('student_number',$search_data['student_number']);
			?>
			<label for="order_by_up" class="checkbox inline">
				<input type="checkbox"  name="order_by_up" id="order_by_up" value="1" 
				<?php 
				if($search_data['order_by_up'])echo 'checked="checked"';?> >
				按上传量排序
			</label>
			
			<div class="submit">
			<input class="btn btn-primary" type="submit" name="submit" value="搜索"  />
			<a class="btn btn-primary" href="<?php echo site_url().'/admin/user/index';?>"/>重置</a>
			<a class="btn btn-primary" href="<?php echo site_url().'/admin';?>"/>返回</a>
			</div>
			</form>
			
		  </div>
		  <div class="span9">
		  	<h3>搜索结果</h3>
		  	<p>找到<?php echo $total_rows;?>个用户，默认按注册时间排序，最新注册第一位</p>
			<table  class="table table-bordered table-hover">
				<tr>
					<th>用户名</th>
					<th>电话</th>
					<th>邮箱</th>
					<th>学号</th>
					<th>上传数</th>
				</tr>
				<?php
				foreach ($user_info as $row) {
					$modify_url = site_url().'/admin/user_modify/'.$row->id;
					// $delete_url = site_url().'/admin/user_delete/'.$row->id;
					printf('
						<tr>
						<td><a href="%s" target="_blank"><i class="icon-pencil"></i>%s</a></td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						',$modify_url,$row->username,$row->phone,$row->email,$row->student_number,$row->book_num);
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
