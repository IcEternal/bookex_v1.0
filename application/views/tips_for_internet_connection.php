<?php
/*
================================================================
tips_for_internet_connection.php

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
			新生上外网方法
		</h2>

		<p>首先声明，此方法成功率不是100%，要看一点RP的哈，主要就在于你是否能连上 <strong>SJTU@DORM</strong> 或者 <strong>SJTU-WEB@DORM
		</strong> , 连不连的上应该与当前连接的人数有一定关系。</p>
		<p>一旦你能连上上面两个网站中的一个，就已经可以访问所有交大内网了，包括 <strong>BookEx</strong> ^ ^</p>
		<p>这时候只要设置代理服务器，就可以访问外网</p>
		<p>考虑到一些同学会设置代理，所以先提供一下地址和端口</p>
		<table class="table table-hover" style="width:500px">
          <thead>
            <tr>
              <th width=5%>#</th>
              <th width=20%>地址</th>
              <th width=30%>端口</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>inproxy.sjtu.edu.cn</td>
              <td>80 or 8000</td>
            </tr>
            <tr>
              <td>2</td>
              <td>cache.sjtu.edu.cn</td>
              <td>8080</td>
            </tr>
          </tbody>
        </table>
        <p>如果有提示要输入用户名密码，就输入你的 <strong>jAccount</strong></p>
		<p><strong>PS:</strong> 应该有不少同学已经知道这个方法了吧= = 我们就做个科普~</p>
		<p>请根据浏览器点击下方图标，如果教程看了有什么问题的话，可以添加飞信 <strong>572773152</strong> </p>
		<legend></legend>
		<div class="row">
			<div class="span4" style="width:200px; height:200px; margin-left:80px;">
				<a href="<?php echo site_url()?>/welcome/chrome_connection">
					<img src="<?php echo base_url() ?>/public/img/chrome.png">
				</a>
			</div>
			<div class="span4" style="width:200px; height:200px; margin-left:80px;">
				<a href="<?php echo site_url()?>/welcome/ie_connection">
					<img src="<?php echo base_url() ?>/public/img/ie.png">
				</a>
			</div>
			<div class="span4" style="width:200px; height:200px; margin-left:80px;">
				<a href="<?php echo site_url()?>/welcome/firefox_connection">
					<img src="<?php echo base_url() ?>/public/img/firefox.png">
				</a>
			</div>
		</div>

</div>

<?php include("includes/footer.php"); ?>
