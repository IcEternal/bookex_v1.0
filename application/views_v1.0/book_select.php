<div class="container">
<?php if (form_error('bookname') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('bookname'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('price') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('price'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('originprice') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('originprice'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('userfile') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('userfile'); ?>
	</div>
<?php endif; ?>
<?php if (isset($q_error)): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $q_error; ?>
	</div>
<?php endif; ?>
</div>


<div id="book_upload" class="container">
	<legend>选择书本</legend>
	<?php foreach ($book_list as $item): ?>
		<div class = "row">
			<div id = "left" class = "span3 text-center">
				<div class="thumbnail">
						<div class="image" style = "width:100%">
							<img src =" <?php echo base_url('get_bc_pic.php?id='.$item['bc_id']); ?>" style = "width:60%" />
						</div>
				</div>
			</div>
			<div id = "right" class = "span7">
				<div class = "row-fluid">
					<p class = "span2"> <strong> 图书名 </strong> </p>
					<p class = "span10"> <?php if(isset($item['title']))echo $item['title']; ?> </p>
				</div>

				<div class = "row-fluid">
					<p class = "span2">  <strong> 原价 </strong> </p>
					<p class = "span4"> <?php if(isset($item['price']))echo $item['price']; ?> </p>
					<p class = "span2">  <strong> ISBN </strong> </p>
					<p class = "span4"> <?php if(isset($item['isbn13']))echo $item['isbn13']; ?> </p>
				</div>

				<div class = "row-fluid">
					<p class = "span2"> <strong> 作者 </strong> </p>
					<p class = "span4"> <?php if(isset($item['author']))echo $item['author']; ?> </p>
					<p class = "span2"> <strong> 译者 </strong> </p>
					<p class = "span4"> <?php if(isset($item['translator']))echo $item['translator']; ?> </p>
				</div>

				<div class = "row-fluid">
					<p class = "span2"> <strong> 出版社 </strong> </p>
					<p class = "span4"> <?php if(isset($item['publisher']))echo $item['publisher']; ?> </p>
					<p class = "span2"> <strong> 出版时间 </strong> </p>
					<p class = "span4"> <?php if(isset($item['pubdate']))echo $item['pubdate']; ?> </p>
				</div>

			</div>
			<p>
				<a href="<?php echo site_url('book_upload/book_fast_upload/'.$item['bc_id']); ?>">
				  这是我想出售的书籍
				</a>
			</p>
			<p>
				<a target="_blank" href=" <?php if(isset($item['alternate']))echo $item['alternate']; ?> ">
				  查看豆瓣上的评价
				</a>
			</p>
			<ul class="nav nav-list span12">
				<li class="divider"></li>
			</ul>
		</div>
	<?php endforeach;?>
	<legend>没有找到？试试其他搜索方式：</legend>
	<div class="row">
		<div class="span5">
			<form class="form-search" action="<?php echo site_url('book_upload/book_isbn') ?>" method="get" accept-charset="utf-8">
			  <input type="text" name ="book_isbn" class="input-medium search-query">
			  <button id="isbn_btn" type="submit" class="btn">通过ISBN快速上传</button>
			</form>
		</div>
		<div class="span7">
			<form class="form-search" action="<?php echo site_url('book_upload/book_select') ?>" method="get" accept-charset="utf-8">
			  <input type="text" name ="book_name" class="input-medium search-query">
			  <button id="q_btn" type="submit" class="btn">搜索书名上传</button>
			</form>
		</div>
	</div>
	<legend>或 自行填写书本信息</legend>
	<?php $this->load->view('includes/book_upload_form'); ?>
</div>

<div class="modal fade hide" id="dataLoad">
  <div class="modal-header">
    <h3>提示</h3>
  </div>
  <div class="modal-body">
    <p>正在从豆瓣拉取书本信息...</p>
    <p>读取时间取决于当前网络环境...</p>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal" aria-hidden="true">关闭提示框继续等待</a>
  </div>
</div>
