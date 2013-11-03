<?php $this->load->view('includes/header') ?>
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
		  <div>修改图书分类</div>
		</div>
		<div class="row">
		  <div class="span12">
		  	<h3>搜索条件</h3>
		  	<form action="" method="GET" class="form-inline">
		  		<input type="text" name="book_name" placeholder="书名搜索" value="<?php echo $search_data['book_name'];?>">
		  		<input type="text" name="class_name" id="class_name" placeholder="类名搜索" value="<?php echo $search_data['class_name'];?>">
		  		<label class="radio inline">
				  <input type="radio" name="class_status" value="1" <?php if($search_data['class_status']==1)echo 'checked="checked"';?> > 已分类
				</label>
				<label class="radio inline">
				  <input type="radio" name="class_status" value="2" <?php if($search_data['class_status']==2)echo 'checked="checked"';?> > 未分类
				</label>
				<button class="btn btn-primary" type="submit" name="submit" value="1" >搜索</button>
				<a class="btn btn-primary" href="<?php echo site_url().'/admin/book_classify';?>"/>重置</a>
				<a class="btn btn-primary" href="<?php echo site_url().'/admin';?>"/>返回</a>
		  	</form>
		  </div>
		  <div class="span12">
		  	<h3>搜索结果</h3>
		  	<p>找到<?php echo $total_rows;?>本书，默认按上传时间排序，最新上传第一位</p>
		  	<form action="">
			<table  class="table table-bordered table-hover">
				<tr>
					<th><input id="selectAllBook" type="checkbox" ></th>
					<th>图书名</th>
					<th>上传者</th>
					<th><span id = "classAll" class="label label-info">批量分类</span></th>
				</tr>
				<?php
				foreach ($book_info as $row) {
					$modify_url = site_url().'/admin/book_modify/'.$row->id;
					if($row->class)
					{
						$class = $row->class;
					}else
					{
						$class = "未分类";
					}
					printf('
						<tr>
						<td><input class="selectBook" type="checkbox" book_id = "%s"></td>
						<td><a href="%s" target="_blank"><i class="icon-pencil"></i>%s</a></td>
						<td>%s</td>
						<td><span book_id="%s" class="classification label label-info">%s</span></td>
						</tr>',$row->id,$modify_url,$row->name,$row->uploader,$row->id,$class);
				}
				?>
			</table>
			</form>
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
