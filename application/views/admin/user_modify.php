<?php $this->load->view('includes/header') ?>

<div class="container">
<?php if (form_error('password') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('password'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('password_confirm') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('password_confirm'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('email') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('email'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('phone') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('phone'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('student_number') != ''): ?>
	<div class="alert alert-error fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo form_error('student_number'); ?>
	</div>
<?php endif; ?>

<div class="alert <?php if($info['status']){echo 'alert-success';}else{echo 'alert-error';} //status=1表示成功信息，0表示失败?> fade in">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <?php echo $info['message'];?>
	</div>
</div>


<div id="signup_form" class="container">
<fieldset>
	<legend><?php echo $username ?></legend>
	<div class="row">
	<div class="span3">
		<style type="text/css">
			table{
				margin-top: 20px;
			}
		</style>
		<table class="table table-bordered table-hover">

			<tr><td>上传数</td><td><a target="_blank" href="<?php echo site_url().'/admin/book?no_reserve=1&reserved=1&traded=1&uploader='.urlencode($username); ?>"><?php echo $up_book_num; ?></a></td></tr>
			<tr><td>预订数</td><td><a target="_blank" href="<?php echo site_url().'/admin/book?no_reserve=1&reserved=1&traded=1&subscriber='.urlencode($username); ?>"><?php echo $sub_book_num; ?></a></td></tr>
			<tr><td>交易数</td><td><?php echo $traded_book_num; ?></td></tr>
			<tr><td>上传金额</td><td>￥<?php echo $up_book_money; ?></td></tr>
			<tr><td>买入金额</td><td>￥</td></tr>
			<tr><td>卖出金额</td><td>￥</td></tr>
			<tr><td>注册时间</td><td></td></tr>
			<tr><td>上次登录时间</td><td></td></tr>
		</table>
	</div>

	<div class="span9">
	<form class="form-horizontal" action="<?php echo site_url('admin/user_modify/'.$id) ?>" method="post" accept-charset="utf-8">
		<div class="control-group">
		    <label class="control-label" for="password">密码</label>
		    <div class="controls">
		     	<input type="password" id="password" name="password" placeholder="密码">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="password_confirm">确认密码</label>
		    <div class="controls">
		     	<input type="password" id="password_confirm" name="password_confirm" placeholder="确认密码">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="email">邮箱</label>
		    <div class="controls">
		      	<input type="text" id="email" name="email" value="<?php echo $email ?>" placeholder="邮箱">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="phone">手机号码</label>
		    <div class="controls">
		      	<input type="text" id="phone" name="phone" value="<?php echo $phone ?>" placeholder="手机号码">
			<span class="help-block">手机号码是您交易时的唯一联系方式。BookEx保证不会泄露您的信息</span>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="student_number">学号</label>
		    <div class="controls">
		      	<input type="text" id="student_number" name="student_number" value="<?php echo $student_number ?>" placeholder="交大学号">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="dormitory">寝室</label>
		    <div class="controls">
		      	<input type="text" id="dormitory" name="dormitory" value="<?php echo $dormitory ?>" placeholder="寝室">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="remarks">交易备注</label>
		    <div class="controls">
		      	<textarea id="remarks" name="remarks" rows=5><?php echo $remarks; ?></textarea>
		    </div>
		</div>
		<div class="control-group">
		    <div class="controls">
		      	<input type="submit" name="submit" value="修改" class="btn">
		    </div>
		</div>
	</form>
	</div><!-- end of span9	 -->
	</div><!-- end of row -->

</fieldset>
</div>

<?php $this->load->view('admin/footer') ?>
