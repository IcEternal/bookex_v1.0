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
			<dt>Step 1</dt>
			<dd>点击右上方的<b>注册</b>按钮，按提示注册一个新账号</dd>
			 <br />
			<dt>Step 2</dt>
		    	<dd>登录后点击右上方的<b>上传书本</b>按钮，按提示填写书本信息</dd>
		    	<br />
		    	<dt>Step 3</dt>
		    	<dd>
		    		<p>坐等看中您这本书的同学预订，预订1天内工作人员会拨打您的电话。</p>
		    		<p>工作人员在取走书本的同时会将书费交予您。</p>
		    		<p>整个过程让你足不出寝，享受五星级服务哈~</p>
						<p class="text-info"> (仅限交大闵行校区同学)</p>
		    		<h4 class="text-info">您也可以选择在书本简介处留下手机号，这样预订方可以与您电话联系，直接商议当面交易的时间地点。</h4>
		    	</dd>
			<dt>Step 4</dt>
                        <dd>
				<p>交易完成后，请在 <b>用户空间</b> 中点击 <b>完成交易</b>.</p>
				<h4 class="text-error"><strong>这样可以防止有其他想购买此书的用户打扰到您.</strong></h4>
				<p>谢谢您的支持！</p>
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
