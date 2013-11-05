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
