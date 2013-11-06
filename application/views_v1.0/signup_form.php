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
<?php if (form_error('dormitory') != ''): ?>
	<div class="alert alert-error fade in">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<?php echo form_error('dormitory'); ?>
	</div>
<?php endif; ?>
</div>


<div class="container">
	<div class="alert fade in">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>友情提醒!</strong> 邮箱是找回账号密码的唯一方式，请正确填写.
	</div>
</div>

<div id="signup_form" class="container">
<fieldset>
	<legend>Create an Account</legend>
	<form class="form-horizontal" action="<?php echo site_url('login/create_user') ?>" method="post" accept-charset="utf-8">
		<div class="control-group">
		    <label class="control-label" for="username">用户名</label>
		    <div class="controls">
		      	<input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="用户名">
		    </div>
		</div>
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
		      	<input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="邮箱">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="phone">手机号码</label>
		    <div class="controls">
		      	<input type="text" id="phone" name="phone" value="<?php echo set_value('phone'); ?>" placeholder="手机号码">
			 	<span class="help-block">手机号码是您交易时的唯一联系方式。BookEx承诺不会泄露您的信息。</span>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="student_number">学号</label>
		    <div class="controls">
		      	<input type="text" id="student_number" name="student_number" value="<?php echo set_value('student_number')?>" placeholder="交大学号">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="dormitory">寝室</label>
		    <div class="controls">
		      	<input type="text" id="dormitory" name="dormitory" value="<?php echo set_value('dormitory')?>" placeholder="寝室">
		      	<span class="help-block">填写寝室可以让我们更快捷的为您送书与取书。</span>
		    </div>
		</div>
		<div class="control-group">
		    <div class="controls">
		      	<button type="submit" class="btn">注册</button>
		    </div>
		</div>
	</form>
</fieldset>
</div>

