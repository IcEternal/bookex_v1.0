<?php 
// big box alert
if ($err == "") { ?>
	<div class="modal in fade" id="shareInfo">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4>订购成功~喜欢这个网站的话请分享一下哈~</h4>
	  </div>
	  <div class="modal-body">
	  </div>
	  <div class="modal-footer">
	    <a class="btn" data-dismiss="modal" aria-hidden="true">取消</a>
	  </div>
	</div>
<?php } ?> 

<?php 
	if ($err == '订购成功！工作人员从卖家拿到书后会与您联系') {
		redirect("book_details/use_phone/$id"); 
	}
?>

<?php 
// big box alert
if ($err == '订购成功！手机号已在图片下方显示。') { ?>
	<div class="modal hide fade" id="shareInfo">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4>订购成功~</h4>
	  </div>
	  <div class="modal-body">
		<p>您已订购成功，请发送短信到 15900895060 或 18818270883 提出具体服务要求。</p> 
		<p>我们于10日晚上统一发送礼品 + 兑书券（可免费兑换活动区书本）+ 贺卡（需自行填写）+ 代送服务（害羞滴汉子有福啦！）</p>
	  </div>
	</div>
<?php } ?> 
