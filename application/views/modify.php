<?php
/*
================================================================
modify.php

The page of user details modifying.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
<?php if (form_error('password') != ''): ?>
	<div class="main-alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('password'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('password_confirm') != ''): ?>
	<div class="main-alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('password_confirm'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('email') != ''): ?>
	<div class="main-alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('email'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('phone') != ''): ?>
	<div class="main-alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('phone'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('student_number') != ''): ?>
	<div class="main-alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('student_number'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('dormitory') != ''): ?>
	<div class="main-alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('dormitory'); ?>
	</div>
<?php endif; ?>

<div class="main-alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>友情提醒!</strong> 邮箱是找回账号密码的唯一方式，请正确填写.
</div>

<div id="signup_form" class="content-full"><!-- structure -->
	<fieldset>
		<h2><?php echo $username ?></h2>
		<form class="form-horizontal" action="<?php echo site_url('login/modify_validation') ?>" method="post" accept-charset="utf-8">
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
				<span class="help-block">手机号码是您交易时的唯一联系方式。BookEx承诺不会泄露您的信息</span>
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
			      	<span class="help-block">填写寝室可以让我们更快捷的为您送书与取书。</span>
			    </div>
			</div>
			<div class="control-group">
			    <div class="controls">
			      	<button type="submit" class="btn">修改</button>
			    </div>
			</div>
		</form>
	</fieldset>
</div><!-- content-full -->