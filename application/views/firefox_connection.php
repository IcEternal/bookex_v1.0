<?php header('Cache-Control: max-age=8'); ?>
<?php include("includes/header.php"); ?>
	<div class="container">
		<div class="well">
			<legend>
				<span>Firefox设置代理方法</span>
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
