<?php
/*
================================================================
chrome_connection.php

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
				Chrome设置代理方法
				<a href="<?php echo site_url() ?>/welcome/tips_for_internet_connection">查看其他浏览器设置方法</a>
			</h2>
		    <dl class="dl-horizontal">
		    <dt>PreStep</dt>
			<dd><p>连接无线网 <strong>SJTU@DORM</strong> 或者 <strong>SJTU-WEB@DORM</strong></p>
				<p>这一步看RP，不一定能连上，提示输入用户名密码的时候就输入<strong>jAccount</strong></p>
			</dd>
			<dt>Step 1</dt>
			<dd>
				<p>进入chrome的 <b>设置->网络->更改代理服务器设置</b></p>
				<p>如果 <b>更改代理服务器设置</b> 是灰色的，说明已经装了一个代理插件，直接在插件里面设置即可。</p>
			 </dd>
			 <br />
			<dt>Step 2</dt>
		    	<dd>弹出<b>Internet属性</b>窗口，选择窗口下方的<b>局域网（LAN）设置</b></dd>
		    	<br />
		    	<dt>Step 3</dt>
		    	<dd>
		    		<p>在代理服务器一栏，地址：<b>inproxy.sjtu.edu.cn</b>    端口：<b>80</b>或<b>8000</b> </p>
		    		<p>也可能使用地址：<b>cache.sjtu.edu.cn</b>    端口：<b>8080</b></p>
		    	</dd>
			<dt>Step 4</dt>
                        <dd>
				<p>用浏览器随便上一个外网，有可能弹出窗口输入 <strong>jAccount</strong>，输入自己的 <strong>jAccount</strong>。</p>
				<p>完工~</p>
			</dd>
                        <br />
		    </dl>
	</div>

<?php include("includes/footer.php"); ?>
