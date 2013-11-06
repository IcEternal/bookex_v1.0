
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>BookEx - 上海交大二手书-SJTU二手书-上海交通大学二手书交易平台</title>
	<link rel="stylesheet" href="<?php echo base_url() ?>public/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>public/css/style.css">
	<style>
		body {
			padding-top: 60px;
		}

		#indexlist {
			width: 720px;
			margin:auto;
			text-align: center;
			margin-top:-15px;
			padding-left: 20px;
			font-weight: bold;
		}

		#indexlist a {
			margin-right: 20px;
		}
		
	</style>
</head>
<body>



<?php if (isset($first)): ?>
<?php if ($first) :?>
<?php endif; ?>
<?php endif; ?>

<div class="navbar navbar navbar-fixed-top" style="z-index:1;">
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
	        <li><a href="<?php echo site_url('welcome/contact') ?>">联系我们</a></li>
	        <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	            	<b style="color:red">活动区书本</b>
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
<?php if (isset($nobook)): ?>
	<div class="alert alert-info fade in">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
                <div>点击右上方的 <b>上传书本</b> 即可上传书本！</div>
	</div>
<?php endif; ?>
<?php if (isset($first)): ?>
<?php if ($first) :?>
	<div class="alert alert-info fade in">
		 <button type="button" class="close" data-dismiss="alert">&times;</button>
		 <div>在右上方注册登录后即可上传书本！</div>
	</div>
<?php endif; ?>
<?php endif; ?>
<div class="alert alert-info fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <div>当前平台上可交易书本数量为<strong><?php echo $tot_book ?></strong>本,共交易<strong><?php echo $tot ?></strong>本,为同学们省下了<strong><?php echo $save ?></strong>元!喜欢这个网站的话请在右边分享哦~</div>
</div>
<div class="alert alert-info fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <div><b>BookEx</b>有主页菌啦～<b><a href="http://www.renren.com/558600685/profile" target=_blank>博易BookEx</a></b>～每天都会推送一些BookEx上的新物品哦～</div>
</div>
</div>


<div class="container" id="index" <?php if ($no_recommend) echo 'style="padding-bottom:250px"' ?>>
	<h1><a href="<?php echo site_url(); ?>">BookEX</a></h1>
	<form action="<?php echo site_url('search') ?>" method="get" accept-charset="utf-8">
		<input class="text" type="text" name="key" value placeholder="输入书名,作者或上传用户, 若无关键字则显示所有书本">
		<input class="submit" type="submit" name="submit" value="">
	</form>
	<div id="indexlist"></div>
	<?php if (!$no_recommend) { $this->load->view('includes/recommend');} ?>
</div>

<div id="index_footer">
	<a href="<?php echo site_url('welcome/norespon') ?>"><p>免责声明</p></a>
	<p>Copy Right © 2013 BookEx</p>
</div>

<script src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("#navigate").click(function(){
    $("#navigate").fadeOut();
  });
});
</script>

<div class="container" style="display:none">
<script language="javascript" type="text/javascript" src="http://js.users.51.la/15806741.js"></script>
</div>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40837479-1', 'sjtu.edu.cn');
  ga('send', 'pageview');

</script>

<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=slide&amp;img=2&amp;mini=1&amp;pos=right&amp;uid=4388338" ></script> 
<script type="text/javascript" id="bdshell_js"></script> 
<script type="text/javascript">
	//在这里定义bds_config
	var bds_config = {'bdTop':200,'bdText':'BookEx - 交大校内二手书交易平台。网站今年5月上线，现在共有近2000本书，价格十分优惠学长学姐说不定还会留下精致的笔记哈~快来看看吧','bdDesc':'交大校内二手书交易网站','bdComment':'以后有想卖掉的书就可以传在BookEx上咯，很多教材也能在平台上轻松找到哦~!','bdPic':'<?php echo base_url() ?>public/img/advertise.png'};
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
</script>
<!-- Baidu Button END -->
<style>
		.mshare {display:none;}
</style>
<script>
	$(function (){
		$.ajax({
	        type:"GET",
	        url:"<?php echo base_url(); ?>classification.xml",
	        dataType:"xml",
	        success:function(xml){
	        	//构建分类导航栏，在DOM中hide
	            var indexlist = $("<p>").addClass("indexlist");
	            $(xml).find("class").each(function(i){
	                var classname = $(this).attr("name");
	                var lv = $(this).attr("lv");
	                if(lv == 1)
	                {
                    var url = "<?php echo site_url('book_view/book') ?>"+"/"+classname+"/1";
                    url = encodeURI(url);
                    var anchor = $("<a>").text(classname).attr("href", url);
                    indexlist.append(anchor);
	                }
	            });
							$("#indexlist").html(indexlist);
	        }
	    });
	});
</script>
</body>
</html>
