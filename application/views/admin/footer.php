<script src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
<script>
	$(function (){
		var makeup = function()
		{
			var content = $("<div>").addClass("popover-content");
			$.ajax({
		        type:"GET",
		        url:"<?php echo base_url(); ?>classification.xml",
		        dataType:"xml",
		        success:function(xml){
		        	//构建分类导航栏，在DOM中hide
		            $(xml).find("class").each(function(i){
		                var classname = $(this).attr("name");
		                var lv = $(this).attr("lv");
		                if(lv == 1)
		                {
		                    var lv1 = $("<div>").addClass("lv1").attr("name",classname);
		                    var title = $("<a>").css({"cursor":"pointer","font-weight":"bold","color":"#E47911"}).text(classname);
		                    var lv2 = $("<p>").addClass("lv2");
		                    lv1.append(title);
		                    lv1.append(lv2);
		                    content.append(lv1);
		                }
		                else //if(lv == 2)
		                {
		                    var lv2name = $("<a>").css({"cursor":"pointer","white-space":"nowrap","color":"#003399"}).text(classname);
		                    content.find(".lv2").last().append(lv2name).append(" | ");
		                }
		            });
		        }
		    });//将xml中的分类信息加载到 div.popover-content 完毕~

			var arrow = $("<div>").addClass("arrow");
			var title = $("<h3>").addClass("popover-title").text("图书分类");

			var pop_class =$("<div>").addClass("popover").addClass("left");
			pop_class.append(arrow).append(title).append(content);

			return pop_class;
		}
		var pop_class = makeup();
		//先从xml文件中读取数据，把分类框弄好

		//这是修改一本书分类的执行函数
		var changeOne = function(classname,span){
			$.get(
	            "<?php echo site_url();?>/admin/modify_book_class",
	            {'classname':classname,"book_id":span.attr("book_id")},
	            function(data)
	            {
	            	span.text(data);
	            });
		}
		//这是批量修改书分类的执行函数
		var changeAll = function(classname){
			$('.selectBook').each(function(){
				var book = $(this);
				if(book.prop('checked') == true)
				{
					$.get(
		            "<?php echo site_url();?>/admin/modify_book_class",
		            {'classname':classname,"book_id":book.attr("book_id")},
		            function(data)
		            {
		            	book.parents('tr').find('span.classification').text(data);
		            });
				}
			});
		}

		//点击后触发的函数
		var clickFunc = function(event){
			event.stopPropagation();
			var span = $(this);
           	span.after(pop_class);
           	pop_class.show();
           	//点击其他任何元素，弹出框消失
           	$("body:not(.popover)").bind("click",function(){
           		$('.popover').remove();
           	});
           	//给所有的anchor绑定事件，单击时，会向数据库添加信息
			pop_class.find("a").bind("click",function(){
				var anchor = $(this);
				if(anchor.parent().attr("class") == "lv1")
            	{
            		var classname = anchor.text();
            	}
            	else
            	{
            		var classname = anchor.parent().parent().attr("name")+'-'+anchor.text();
            	}
				if(span.attr('id') == 'classAll')
				{
					changeAll(classname);
				}else if(span.hasClass('classification'))
				{
					changeOne(classname,span);
				}else if(span.attr('id') == 'class_name')
				{
					span.attr('value',classname);
				}
       			$('.popover').remove();
			});
			var left = span.offset().left-pop_class.width();
			var top = span.offset().top-pop_class.height()/2;
			if(left<0)
			{
				pop_class.removeClass('left');
				pop_class.addClass('right');
				left = span.offset().left+pop_class.width()-50;
				top = span.offset().top-pop_class.height()/2+10;
				pop_class.css(
				{
					"position":"absolute",
					"top":top,
					"left":left,
				});
			}
			else if(top<20)
			{
				top -= (top-50);
				pop_class.css(
				{
					"position":"absolute",
					"top":top,
					"left":left,
				});
			}
			else
			{
				pop_class.css(
				{
					"position":"absolute",
					"top":top,
					"left":left,
				});
			}

			
			
		}
		//给每本数的按钮绑定点击事件
		$(".classification").css({"cursor":"pointer"}).bind("click",clickFunc);

		//给批量修改 勾选框 绑定事件
		$('#selectAllBook').click(function(){
			if($('#selectAllBook').prop('checked') == true)
			{
				$('.selectBook').prop('checked',true);
			}
			else
			{
				$('.selectBook').prop('checked',false);
			}
		});

		//给批量修改的按钮绑定点击事件
		$('#classAll').css({"cursor":"pointer"}).bind("click",clickFunc);

		//给input框绑定点击事件
		$('#class_name').css({"cursor":"pointer"}).bind("click",clickFunc);


		function getColorByData(data){
			if (data.indexOf("正在取书") >= 0 && data.indexOf("失败") == -1) return "#99FF00";
	        else if (data.indexOf("正在送书") >= 0 && data.indexOf("失败") == -1) return "#999900";
	        else if (data.indexOf("送到易班") >= 0) return "#FF0000";
	        else if (data.indexOf("找不到") >= 0) return "#333333";
	        else if (data.indexOf("") >= 0) return "#3A87AD";
		}

		var clicknext = function(event){
			event.stopPropagation();
			span = $(this);
			$.get(
	            "<?php echo site_url();?>/admin/next_operation",
	            {"book_id":span.attr("book_id")},
	            function(data)
	            {
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").text(data);
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").css("background-color", getColorByData(data));
	            });
		}

		var clickprev = function(event){
			event.stopPropagation();
			span = $(this);
			$.get(
	            "<?php echo site_url();?>/admin/prev_operation",
	            {"book_id":$(this).attr("book_id")},
	            function(data)
	            {
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").text(data);
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").css("background-color", getColorByData(data));
	            });
		}

		var clickdone = function(event){
			event.stopPropagation();
			span = $(this);
			$.get(
	            "<?php echo site_url();?>/admin/deal_done",
	            {"book_id":$(this).attr("book_id")},
	            function(data)
	            {
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").text(data);
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").css("background-color", getColorByData(data));
	            });
		}

		var clickdelete = function(event){
			event.stopPropagation();
			span = $(this);
			$.get(
	            "<?php echo site_url();?>/admin/book_deleted",
	            {"book_id":$(this).attr("book_id")},
	            function(data)
	            {
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").text(data);
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").css("background-color", getColorByData(data));
	            });
		}

		var clickcancel = function(event){
			event.stopPropagation();
			span = $(this);
			$.get(
	            "<?php echo site_url();?>/admin/deal_canceled",
	            {"book_id":$(this).attr("book_id")},
	            function(data)
	            {
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").text(data);
	            	$("span[book_id='"+span.attr("book_id")+"'][status='1']").css("background-color", getColorByData(data));
	            });
		}
		//给下一步按钮绑定点击事件
		$(".next_operation").css({"cursor":"pointer"}).bind("click", clicknext);

		//给上一步按钮绑定点击事件
		$(".prev_operation").css({"cursor":"pointer"}).bind("click", clickprev);

		//给完成交易按钮绑定点击事件
		$(".deal_done").css({"cursor":"pointer"}).bind("click", clickdone);

		//给标记删除按钮绑定点击事件
		$(".book_deleted").css({"cursor":"pointer"}).bind("click", clickdelete);

		//给取消订单按钮绑定点击事件
		$(".deal_canceled").css({"cursor":"pointer"}).bind("click", clickcancel);

	
	});
	</script>
<script type="text/javascript">
$(document).ready(function(){
  $("input.i_remark").focus(function(){
    $(this).css("background-color","#FFFFCC");
  });
  $("input.i_remark").blur(function(){
  	var input = $(this);
  	var user_id = $(this).parent().attr('user_id');
  	var remark = $(this).val();
  	var post_data = 'user_id='+user_id+'&remark'+remark;
  	$.ajax({
  		type:'POST',
  		url:"<?php echo site_url();?>/admin/change_remark",
  		data:{'user_id':user_id,'remark':remark},
  		success:function(data){
  			if(data == 1)
  			{
  				input.css("background-color","#79FF79");
  			}
  			else
  			{
  				input.css("background-color","#FFD2D2");
  			}
  		},
  		error:function(){
			input.css("background-color","#FFD2D2");
  		}
  	});
    
  });
});
</script>

<!-- ajax for generating tickets -->
<script type="text/javascript">
	$(document).ready(function() {
		$("#generate_discount").bind("click", function() {
			$.ajax({
				type: 'GET',
				url: "<?php echo site_url(); ?>/admin/generate_ticket/1",
				dataType: 'text',
				success:function(msg) {
					$("#discount_ticket").attr('value', msg);
				} 
			});
		});

		$("#generate_free").bind("click", function() {
			$.ajax({
				type: 'GET',
				url: "<?php echo site_url(); ?>/admin/generate_ticket/2",
				dataType: 'text',
				success:function(msg) {
					$("#free_ticket").attr('value', msg);
				} 
			});
		});
	});
</script>
<!-- end -->
</body>
</html>

