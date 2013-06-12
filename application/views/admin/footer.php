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

	});
	</script>

</body>
</html>

