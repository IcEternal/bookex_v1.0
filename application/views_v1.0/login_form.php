<div class="container">
<?php if (form_error('username') != ''): ?>
	<div class="alert alert-error fade in">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('username'); ?>
	</div>
<?php endif; ?>
<?php if (form_error('password') != ''): ?>
	<div class="alert alert-error fade in">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('password'); ?>
	</div>
<?php endif; ?>
</div>


<div class="container" id="login_form">
	<fieldset>
		<legend>Login</legend>
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


