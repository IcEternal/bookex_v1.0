<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>BookEx</title>
	<link rel="stylesheet" href="<?php echo base_url() ?>public/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>public/css/style.css">
	<style>
		body {
			padding-top: 60px;
		}
	</style>
</head>
<body>

<div class="navbar navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="<?php echo site_url(); ?>">BookEx</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li><a href="<?php echo site_url('welcome/about') ?>"><b>如何使用?</b></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: red;">
            	<b>活动相关</b>
          	</a>
            <ul class="dropdown-menu">
					    <li><a href="<?php echo site_url('welcome/act_detail'); ?>">活动细则</a></li>
					    <li><a href="<?php echo site_url('welcome/prize_user') ?>">中奖名单</a></li>
					  </ul>
          </li>
          <li><a href="<?php echo site_url('welcome/contact') ?>">联系我们</a></li>
        </ul>
      </div><!--/.nav-collapse -->
      	<?php 
					$is_logged_in = $this->session->userdata('is_logged_in');
					if (!isset($is_logged_in) || $is_logged_in != true): 
				?>
	        <form class="navbar-form pull-right" action="<?php echo site_url('login/validate_credentials') ?>" method="post" accept-charset="utf-8">
						<input class="span2" type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="用户名">

						<input class="span2" type="password" id="password" name="password" placeholder="密码">

						<button type="submit" class="btn">登录</button>
						<a href="<?php echo site_url('login/signup') ?>" class="btn">注册</a>
					</form>
				<?php else: ?>
				<ul class="nav pull-right">
					<li class="divider-vertical"></li>
					<li><a href="<?php echo site_url('book_upload') ?>">上传书本</a></li>
					<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            	当前用户:  <?php echo $this->session->userdata('username'); ?>
            	<b class="caret"></b>
          	</a>
            <ul class="dropdown-menu">
					    <li><a href="<?php echo site_url('site/userspace'); ?>">用户空间</a></li>
					    <li><a href="<?php echo site_url('login/modify') ?>">修改个人信息</a></li>
					    <li class="divider"></li>
					    <li><a href="<?php echo site_url('login/logout'); ?>">登出</a></li>
					  </ul>
          </li>
        </ul>
				<?php endif; ?>
    </div>
  </div>
</div>

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

<div class="container" id="index">
	<h1><a href="<?php echo site_url(); ?>">BookEX</a></h1>
	<form action="<?php echo site_url('search') ?>" method="get" accept-charset="utf-8">
		<input class="text" type="text" name="key" value placeholder="输入书本或作者">
		<input class="submit" type="submit" name="submit" value="">
	</form>
</div>

<div id="index_footer">
	<p>Copy Right © 2013 BookEx</p>
</div>

<script src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
</body>
</html>
