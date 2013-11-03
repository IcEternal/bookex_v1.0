<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>BookEx - 上海交大二手书-SJTU二手书-上海交通大学二手书交易平台</title>
	<link rel="stylesheet" href="<?php echo base_url() ?>public/css/bootstrap.min.css">
	<style>
		body {
			padding-top: 60px;
		}
		
		a.rr-share {
			position: relative;
			right: 23px;
		}
	</style>
<style type="text/css">
input[type="text"] .i_remark
{
	margin-bottom: 0px;
	padding: 0px;
	float: right;
	width: 350px;
	height: 30px;
}
table .person-info
{
	padding: 0px;
	padding-left: 5px;
}
table .person-info span
{
	margin-top:8px;
}
</style>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="<?php echo site_url() ?>">BookEx</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <!-- <li><a href="<?php echo site_url('welcome/about') ?>"><b>如何使用?</b></a></li>
          <li><a href="<?php echo site_url('welcome/contact') ?>">联系我们</a></li> -->
          <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	            	<b style="color:white">活动区书本</b>
	            	<b class="caret"></b>
	          	</a>
	            <ul class="dropdown-menu">
				    <li><a href="<?php echo site_url('book_view/discount'); ?>">抵价券使用区</a></li>
				    <li><a href="<?php echo site_url('book_view/free'); ?>">兑书券使用区</a></li>
				    <li class="divider"></li>
				    <li><a href="<?php echo site_url('welcome/act_detail'); ?>">活动规则说明</a></li>
				</ul>
	        </li>
        </ul>
      </div><!--/.nav-collapse -->
      <form class="navbar-search pull-left" action='<?php 
      	$scope = $this->uri->segment(2);
      	if ($scope == 'discount' || $scope == 'free') 
      		echo site_url("book_view/$scope");
      	else 
      		echo site_url('search'); ?>' method="get" accept-charset="utf-8">
			  <input id="key" name="key" type="text" class="search-query" value = "<?php echo isset($key)?$key:'';?>" placeholder="搜索">
			</form>
      	<?php 
					$is_logged_in = $this->session->userdata('is_logged_in');
					if (!isset($is_logged_in) || $is_logged_in != true): 
				?>
	        <form class="navbar-form pull-right" action="<?php echo site_url('login/validate_credentials') ?>" method="post" accept-charset="utf-8">
						<input class="span2" type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="用户名/邮箱名">

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
					    <li><a href="<?php echo site_url('site/user_collection'); ?>">书本收藏夹</a></li>
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

