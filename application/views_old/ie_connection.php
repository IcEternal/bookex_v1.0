<?php header('Cache-Control: max-age=8'); ?>
<?php include("includes/header.php"); ?>
	<div class="container">
		<div class="well">
			<legend>
				<span>IE设置代理方法</span>
				<small> <a href="<?php echo site_url() ?>/welcome/tips_for_internet_connection">查看其他浏览器设置方法</a></small>
				<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare" style="float:right">
					<a class="bds_renren"></a>
					<a class="bds_tsina"></a>
					<a class="bds_qzone"></a>
					<a class="bds_tqq"></a>
					<a class="bds_t163"></a>
					<span class="bds_more"></span>
				</div>
			</legend>
		    <dl class="dl-horizontal">
		    <dt>PreStep</dt>
			<dd><p>连接无线网 <strong>SJTU@DORM</strong> 或者 <strong>SJTU-WEB@DORM</strong></p>
				<p>这一步看RP，不一定能连上，提示输入用户名密码的时候就输入<strong>jAccount</strong></p>
			</dd>
			<dt>Step 1</dt>
			<dd>桌面右键点击<b>IE->属性</b>　或　<b>进入IE->设置</b>，进入<b>Internet属性</b></dd>
			 <br />
			<dt>Step 2</dt>
		    	<dd>在<b>连接</b>分页，选择窗口下方的<b>局域网（LAN）设置</b>。</dd>
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
	</div>

<!-- 51.la script -->
<div class="container" style="display:none">
<script language="javascript" type="text/javascript" src="http://js.users.51.la/15806741.js"></script>
</div>

<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=4388338" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
var bds_config = {'bdText':'开网要等到10月份!?不能忍！新生上外网简易教程~不保证100%成功，看谁RP好咯~','bdDesc':'交大校内二手书交易网站','bdComment':'','bdPic':'<?php echo base_url() ?>public/img/logo.jpg'};
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END -->
<?php include("includes/footer.php"); ?>
