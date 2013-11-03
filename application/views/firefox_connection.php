<?php
/*
================================================================
firefox_connection.php

include: includes/header.php
		 includes/footer.php

Just a single page.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
<?php include("includes/header.php"); ?>

	<div class="content-full">
			<h2>
				Firefox设置代理方法
				<a href="<?php echo site_url() ?>/welcome/tips_for_internet_connection">查看其他浏览器设置方法</a>
			</h2>
		    <dl class="dl-horizontal">
		    <dt>PreStep</dt>
			<dd><p>连接无线网 <strong>SJTU@DORM</strong> 或者 <strong>SJTU-WEB@DORM</strong></p>
				<p>这一步看RP，不一定能连上，提示输入用户名密码的时候就输入<strong>jAccount</strong></p>
			</dd>
			<dt>Step 1</dt>
			<dd>点击左上方<strong>Firefox</strong>,点击<strong>选项</strong></dd>
			 <br />
			<dt>Step 2</dt>
		    <dd> <strong>高级</strong>-<strong>网络</strong>-<strong>连接</strong>-<strong>设置</strong></dd>
		    <br />
		    	<dt>Step 3</dt>
		    	<dd>
		    		<p>点击<strong>手动配置代理</strong> </p>
		    		<p>在HTTP代理中输入 <strong>cache.sjtu.edu.cn</strong> 端口输入<strong>8080</strong> </p>
		    		<p>或</p>
		    		<p>在HTTP代理中输入<strong>inproxy.sjtu.edu.cn</strong> 端口输入<strong>80</strong></p>
		    		<p>勾选 <strong>为所有协议使用相同代理</strong></p>
		    	</dd>
			<dt>Step 4</dt>
            <dd>
                点击确定，完工~
			</dd>
                        <br />
		    </dl>
	</div>

<?php include("includes/footer.php"); ?>
