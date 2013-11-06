<?php $this->load->view('delivery/header') ?>
<style type="text/css">
	.step
	{
		font-size: 20px;
		font-weight: 900;
		display: block;
		margin-bottom: 20px;
		margin-top: 20px;
	}
	.well p
	{
		margin-left: 20px;
	}
</style>
<!-- in the span12	 -->
	<div class="well">
		<h3>配送系统使用说明</h3>
		<hr>
		<span class="step">Step1 检查委托</span><p> 网站上所有申请委托交易的书，都会在“检查委托”中出现。</p>
		<p>无法接受的交易请拒绝通过，并告知用户取消该申请</p>

		<span class="step">Step2 生成订单</span><p> 所有通过的委托都会在生产订单页面出现。</p>
		<p>交易按买家用户名分类，间隔一定时间（一般为一天），积累一定数量，为每个买家生产订单，
			并告知买家我们已接受该书的委托交易。</p>

		<span class="step">Step3 卖家管理</span><p> 所有生成订单的交易都会在卖家页面出现。</p>
		<p>交易按卖家用户名分类，间隔一定时间（一般为一天），积累一定数量，可以通知卖送书过来。</p>
		<p>根据卖家回应（带书过来、交易书籍不存在），选择相应操作，直至所有交易完成，停止通知卖家。</p>

		<span class="step">Step4 买家管理</span><p> 这里显示所有的订单。</p>
		<p>当一个订单下的所有书籍都处理完毕（已获取，不存在，超时），即可通知买家来取书。</p>
		<p>买家必须接受所有书籍，如果对书籍不满意，先买下，后申请退货。</p>
	</div>
		</div><!-- end of span12	 -->
	</div><!-- end of row -->
</body>
</html>