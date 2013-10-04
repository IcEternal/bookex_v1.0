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
		.delivery-page
		{
			float: right;
			margin-bottom: 30px;
		}
		.title
		{
			float: left;
		}
		.right
		{
			float: right;
		}
		.right-margin
		{
			margin-right: 5px;
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
          <li><a href="<?php echo site_url('welcome/about') ?>"><b>如何使用?</b></a></li>
          <li><a href="<?php echo site_url('welcome/contact') ?>">联系我们</a></li>
        </ul>
      </div><!--/.nav-collapse -->
      <form class="navbar-search pull-left" action="<?php echo site_url('search') ?>" method="get" accept-charset="utf-8">
			  <input id="key" name="key" type="text" class="search-query" value = "<?php echo isset($key)?$key:'';?>" placeholder="搜索">
			</form>
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

<div class="container">
	<div class="row">
		<div class="span12">
			<h3 class="title"><?php echo $title;?></h3>
			<div class="delivery-page">
				<a class="btn btn-large btn-primary" href="<?php echo site_url('delivery/check_submit');?>">检查委托</a>
				<a class="btn btn-large btn-primary" href="<?php echo site_url('delivery/make_order');?>">生成订单</a>
				<a class="btn btn-large btn-primary" href="<?php echo site_url('delivery/seller_manange');?>">卖家管理</a>
				<a class="btn btn-large btn-primary" href="<?php echo site_url('delivery/buyer_manange');?>">买家管理</a>
				<a class="btn btn-large" href="<?php echo site_url('delivery');?>">返回</a>
			</div>
		</div>

		
