<?php header('Cache-Control: max-age=8'); ?>

<?php include("includes/header.php"); ?>
<div class="container">
	<div class="well">
		<legend>
			<span>新生上外网方法</span>
			
			<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare" style="float:right">
				<a class="bds_renren"></a>
				<a class="bds_tsina"></a>
				<a class="bds_qzone"></a>
				<a class="bds_tqq"></a>
				<a class="bds_t163"></a>
				<span class="bds_more"></span>
			</div>
		</legend>

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

</div>


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
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=4388338" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
var bds_config = {'bdText':'开网要等到10月份!?不能忍！新生上外网简易教程~不保证100%成功，看谁RP好咯~','bdDesc':'交大校内二手书交易网站','bdComment':'','bdPic':'<?php echo base_url() ?>public/img/logo.jpg'};
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END -->
<?php include("includes/footer.php"); ?>
