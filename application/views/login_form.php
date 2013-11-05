<?php
/*
================================================================
login_form.php

include: includes/header.php
		 includes/footer.php

The user login page.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
<?php
	// when log in success, redirect to index.
	$is_logged_in = $this->session->userdata('is_logged_in');
	if (isset($is_logged_in) && $is_logged_in == true){
		header("Location: " . site_url());
	}
?>
<?php if (form_error('username') != ''): ?>
	<div class="main-alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('username'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('password') != ''): ?>
	<div class="main-alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('password'); ?>
	</div>
<?php endif; ?>

<div class="content-full">
	<div id="login_form">
		<fieldset>
			<h2>登录</h2>
			<form class="form-horizontal" action="<?php echo site_url('login/validate_credentials') ?>" method="post" accept-charset="utf-8">
				<div class="control-group">
					<label class="control-label" for="username">用户名</label>
					<div class="controls">
							<input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="用户名/邮箱名">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">密码</label>
					<div class="controls">
							<input type="password" id="password" name="password" placeholder="密码">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
							<button type="submit" class="btn">登录</button>
							<a href="<?php echo site_url('login/signup') ?>" class="btn">注册</a>
					</div>
				</div>
			</form>
		</fieldset>
	</div>
</div>