<?php
/*
================================================================
header.php

The header page of this site.

The site structure map:

	<header.php>	|	<div header-container>
					|		<div header>
					|	
	<main.php>		|	<div main-container>
					|		<div main>
					|			<div content><div sidebar>   or   <div content-full>
					|	
	<footer.php>	|	<div footer>

The navigation bar:
	
	we use <li class="nav-main"><a><span class="nav-text">MENU</span><span class="nav-line"></span></a></li>

	the class nav-line is the white line on the top of MENU, via jQuery can achieve the sepcial effect.

	ps. the second ul's height is fixed and we don't support a third ul. :)

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<!--
@B@B@B@B@B@@@@@@@@@@:..M@B@B@B@B@B@B@B@B@B@@@B@@@B@B@B@B@B@B@B@B@B@B@B@B@B@@@B@B@@@@@B@B@B@B@B@B@B@B@B@B@B@B@B@B@B@B@Bqv8B@B@B@B@@@B@B@B:.,B@Bi @B@@@B
B@B@B@B@B@G1vi   OB@   q@@B:i@B@B@B@B@B@0rrvvYLL7vr;irri:,.             r@B@@@7..,,,,:,,,:,:::::,,,,,:,:,,,,..u@B@B@B@   OB@B@@@B@B@B@B@   @B,   BB@@@
@2               ,@B   F@B    iB@B@B@B@BF                            .. rB@B@B                                ,B@B@B@k  ;@@B@B@B@B@B@@@B   B@BX   MB@B
@O         .1EM@B@B@   kB@B5    :BB@@@B@B8M@i  2B@B@B@   @B@B@B@@@.  MB@B@B@B@MOB@B@BBMMMMM@5   B@MMMMM@B@B@B8B@B@B@B   JPujLOr       .,   ,.,i    . ,
@B@B@B@@;  u@B@@@B@B,  2@B@@@u    EB@B@B@B@BB   iB@B@B8   LB@B@@M   :B@@@B@B@@@B@BUB@B@B@B@BM   @B@B@B@B@51B@B@B@B@B:        ..                       
B@B@B@B@i  uB@B@B@B@L  5B@B@B@BU:@B@B@B@B@B@B@:  XB@B@B@  :@B@@@   FB@B@B@B@@@B@r   0@B@B@B@q   B@B@B@@@:   1@@@@@BJ  .@MMGG0@B@B@B@B@B@   @@@B@B@@@B@
BS0qE0GM,  iBE0q0qZM7  :B0ENEZBB@@GFN@@B                                 B@B@@@B@r   i@B@B@@0   @B@B@B@    u@B@B@Br   @B@B@B@B@@@B@B@B@B   B@B@B@B@B@@
                                     @B@   ....:,,:,...,,:.......:,...   @B@B@B@B@G    @@@@@P   B@B@@G    B@B@B@B@   2BOG8NN5@B.                    k@
EvLLYLuF.  ,FJJLJYjUr   XuJLJJ2qZXuvuB@B   B@B@B@B@  .@B@B@B@B@B@B@@@B   B@B@B@B@B@@    ZB@BN   @B@Bi   ;B@B@B@B@B@Lr        J@,  i2uYU5   J1JJj5   EB
B@B@B@B@i  UB@B@B@B@B   B@@@B@BBJ@B@B@@MiiiOOOGMM@.  :BMGOG8GOZ8GOGOOOiii0@@B@@@B@B@@.   1B@q   B@Z    G@@B@B@B@B@B@BF7  ,Xuv@B:  B@B@B@.  @B@@@BJ  G@
@B@B@B@B:  j@@@@@@@B@   @B@B@Bv   LB@B@                                   8B@B@B@B@B@Br P@@BM   @B@P r@@@B@B@B@B@B@B@B@  U@B@B@:  uBMOBB   ZBOMM@:  8B
@@@@B@B@i  iGj:.   @B.  5@B@B    LB@B@BuvuJjYuUO:   00SS5S1S5FFS1SFS1FuuLLB@BMM@B@B@B@B@B@@@k   B@B@@@B@@@B@@@BMB@8XEB5  iBO00B;                    G@
BXkvr,             B@v  :B@7    @B@B@B@B@@@B@B@@   B@B@B@B@B@B@B@B@B@B@B@B@Bu                                   O@            O7  rFUu5k   uSuuUP.  OB
u          .7uNM@@B@B@   0    2@B@@@B@B@B@B@B@1                       B@@@@@8,:i:::i:i:i::ir:   r;:i:::::i:::i,:@@F7v27  ,1Jvv@;  B@B@@@.  @B@B@BJ  G@
@. iJS@Bi  u@B@B@B@B@@;     r@@B@@@@@B@B@B@B@:      :SkYv77rv7UkU     @B@B@B@B@B@B@B@B@B@@@B@   @B@@@B@B@B@B@B@B@B@B@B@  L@B@B@:  jMOZMB   NMZGO@:  OB
B@B@B@@@:  7B@B@B@B@B1    i@B@B@B5 :F@B@B@BG   .B@   rB@B@B@B@BM.   u@@@B@B@B@B@B@B@B@@@B@B@0   B@B@B@@@B@B@@@B@B@B@B@O  r@@B@@i                    G@
@@@B@B@B:  r@@@B@BE.      ,B@@@B@:  .B@B@B,   vB@B@L    uB@@M:    1B@B@@@B@B@B@B@@@@@B@B@B@BN   @@@B@B@B@B@B@B@@@@@B@BO  7@BBZ@:  L8Pk08   XGkPqM,  OB
B@B@B@@@:  7B@BN:     F@.   B@B@B   O@BO.   .@B@B@B@BB.        LB@B@B@@@B@B@B@B@B@B@B@B@B@B@P   B@@@B@B@B@B@B@B@B@@@B@M  LB,  B;  O@B@B@   @@@B@Bv  Z@
@B@@@B@B,  i@2     r@B@B@.   U@@B   @Bi   .B@B@B@B@MXY.        :uUGB@@@B@B@@@B@B@B@B@B@B@B@B0   @B@B@B@B@B@B@B@@@B@B@@0      :@i  PB@B@@   B@B@B@i  EB
B@         SB@J 7BB@B@B@B@L    :   UB@B  GBMPL:.        ikB8r             S@@@@@B@B@B@B@B@@@q   B@B@B@B@B@B@@@@@B@B@BO     1B@B:  F@B@B@   @:.,i.   M@
@Br      :GB@B@@@B@@@B@B@B@Bj     u@@B@B@@B      .iU8@@B@B@B@B@@@SYi,    ;@B@@@@@@@B@B@B@B@BP   @B@B@B@B@B@B@@@B@B@B@Bu iB@B@@@:  kB@B@B.  Br     .q@B
-->
<!-- 源代码真心不好看，还是别往下看了吧。 -->
<title>BookEx - 上海交大二手书-SJTU二手书-上海交通大学二手书交易平台</title>
<link rel="stylesheet" href="<?php echo base_url() ?>public/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>public/css/style.css">
<link rel ="Shortcut Icon" href="<?php echo base_url() ?>/favicon.ico">
<script type="text/javascript" src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/all.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
</head>
<body>

<div id="header-container"><!-- structure -->
	<div id="header"><!-- structure -->

		<div id="logo">
			<?php // the <span> in <h1> will be hiddin and the <logo> has a background picture as logo. ?>
			<a href="<?php echo base_url() ?>"><h1><span>BookEx</span></h1></a>
		</div><!-- logo -->

		<div id="search">
			<?php // it has a background picture ?>
			<form action="<?php echo site_url('search') ?>" method="get" accept-charset="utf-8">
				<input type="text" name="key" id="searchform" />
				<input type="submit" name="submit" id="searchbutton" value="" />
			</form>
		</div><!-- search -->

		<div class="fixed"></div><!-- clear for <logo> and <search>'s float -->

		<div id="navi">
	        <ul>
	        	<li class="nav-main"><a href="<?php echo site_url() ?>"><span class="nav-line"></span><span class="nav-text">首页</span></a></li>
	          <li class="nav-main"><a href="<?php echo site_url('welcome/about') ?>"><span class="nav-line"></span><span class="nav-text">如何使用</span></a></li>
	          <li class="nav-main"><a href="<?php echo site_url('welcome/contact') ?>"><span class="nav-text">联系我们</span><span class="nav-line"></span></a></li>
	          <li class="nav-drop"><span class="nav-text"><a href="#">双十一专区</a>
		            <ul>
	          			<li><a href="<?php echo site_url('book_view/book/activity') ?>">活动物品</a></li>
					    <li><a href="<?php echo site_url('welcome/act_double11'); ?>">活动介绍</a></li>
					</ul>
		      </span><span class="nav-line"></span></li>
	          <li class="nav-drop"><span class="nav-text"><a href="#">活动区书本</a>
		            <ul>
					    <li><a href="<?php echo site_url('book_view/discount'); ?>">抵价券使用区</a></li>
					    <li><a href="<?php echo site_url('book_view/free'); ?>">兑书券使用区</a></li>
					    <li><a href="<?php echo site_url('welcome/act_detail'); ?>">活动规则说明</a></li>
					</ul>
		      </span><span class="nav-line"></span></li>
	        </ul>
		</div><!-- navi -->

		<div id="userbox">
	      	<?php 
				$is_logged_in = $this->session->userdata('is_logged_in');
				if (!isset($is_logged_in) || $is_logged_in != true): 
				// for a guest
			?>
				<ul>
					<li class="nav-main"><a href="<?php echo site_url('login') ?>" ><span class="nav-text">登录</span><span class="nav-line"></span></a></li>
					<li class="nav-main"><a href="<?php echo site_url('login/signup') ?>" ><span class="nav-text">注册</span><span class="nav-line"></span></a></li>
				</ul>
			<?php else: 
				// for old user
			?>
				<ul>
					<li class="nav-main"><a href="<?php echo site_url('book_upload') ?>"><span class="nav-text">上传书本</span><span class="nav-line"></span></a></li>
					<li class="nav-drop">
	            		<a href="#">
	            			<span class="nav-text"><?php echo $this->session->userdata('username'); ?></span><span class="nav-line"></span>
	          			</a>
	            		<ul>
						    <li><a href="<?php echo site_url('site/userspace'); ?>">用户空间</a></li>
						    <li><a href="<?php echo site_url('site/user_collection'); ?>">书本收藏夹</a></li>
						    <li><a href="<?php echo site_url('login/modify') ?>">修改个人信息</a></li>
						    <li><a href="<?php echo site_url('login/logout'); ?>">登出</a></li>
						</ul>
	          		</li>
	        	</ul>

			<?php endif; ?>
		</div><!-- userbox -->

		<div class="fixed"></div><!-- clear for <navi> and <userbox>'s float -->

	</div><!-- header -->
</div><!-- header-container -->

<div id="main-container"><!-- structure -->
	<div id="main"><!-- structure -->
