	<?php 
	// big box alert
	if (($err == '订购成功！工作人员从卖家拿到书后会与您联系') || ($err == '订购成功！手机号已在图片下方显示。')) { ?>
		<div class="modal hide fade" id="shareInfo">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h4>订购成功~喜欢这个网站的话请分享一下哈~</h4>
		  </div>
		  <div class="modal-body">
			<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare" style="margin: auto">
				<a class="bds_renren"></a>
				<a class="bds_tsina"></a>
				<a class="bds_qzone"></a>
				<a class="bds_tqq"></a>
				<a class="bds_t163"></a>
				<span class="bds_more"></span>
			</div>
		  </div>
		  <div class="modal-footer">
		    <a class="btn" data-dismiss="modal" aria-hidden="true">取消</a>
		  </div>
		</div>
	<?php } ?> 

	<?php if ($show == true && $err == '订购成功！工作人员从卖家拿到书后会与您联系') { ?>
		<?php if ($mustphone) redirect("book_details/use_phone/$id"); ?>
		<div class="modal hide fade" id="phoneInfo">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3>提示</h3>
		  </div>
		  <div class="modal-body">
		    <p>对方支持当面交易,手机号为 <?php echo $phone ?>.</p>
		    <p><strong>自行当面交易</strong> 后，手机号会在书本图片下方显示。</p>
		    <br/>
		    <p> <?php if (!$mustphone) {?> 工作人员从卖家取书后联系，速度慢<a data-dismiss="modal" aria-hidden="true" id="do_not_use_phone">委托BookEx取书</a><?php } ?></p>
		    <br/>
		    <p>速度快又方便, 还能认识些同学, 选择<a class="btn" href='<?php echo site_url("book_details/use_phone/$id") ?>'><b>自行当面交易</b></a></p>
		  </div>
		</div>
	<?php } ?>

	<?php 
		$url = $_SERVER['PHP_SELF'];
		if (strpos($url, 'order') != false && $info->discounted == 0 && $info->freed == 0 && ($info->discount_sup == 1 || $info->free_sup == 1)){ 
	?>
			<div class="modal hide fade" id="ticketInput">
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h3>订购成功，提示</h3>
			  </div>
			  <div class="modal-body">
			  	<?php if ($info->discount_sup == 1){ ?>
			    <p>该书支持抵价券，你可以在下面的输入框输入使用。</p>
			    <p>抵价券一旦使用后，即使取消订单该券也将视为已使用。</p>
			    <input class="span3" type="text" id="discount_ticket_input" name="discount_ticket" placeholder="输入抵价码">
			    <a class="btn btn-primary" data-dismiss="" aria-hidden="true" id="discount_button">确定</a>
			    <?php } ?>
			    <?php if ($info->free_sup == 1){ ?>
			    <p>该书支持免费券，你可以在下面的输入框输入使用。</p>
			    <p>免费券一旦使用后，即使取消订单该券也将视为已使用。</p>
			    <input class="span3" type="text" id="free_ticket_input" name="free_ticket" placeholder="输入免费码">
			    <a class="btn btn-primary" data-dismiss="" aria-hidden="true" id="free_button">确定</a>
			    <?php } ?>
			    <p id="ticket_message"></p>
			  </div>
			  <div class="modal-footer">
			    <a class="btn" data-dismiss="modal" aria-hidden="true" id="do_not_use_ticket">不使用</a>
			  </div>
			</div>
	<?php }  
// alert END
	?>