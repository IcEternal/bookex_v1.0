

<script src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>

<script>
	$(function (){
		$.ajax({
	        type:"GET",
	        url:"<?php echo base_url(); ?>classification.xml",
	        dataType:"xml",
	        success:function(xml){
	        	//构建分类导航栏，在DOM中hide
	            var nav = $("<ul>").addClass("nav").addClass("nav-list");
	            var lv1class;
	            $(xml).find("class").each(function(i){
	                var classname = $(this).attr("name");
	                var lv = $(this).attr("lv");
	                if(lv == 1)
	                {
	                		lv1class = classname;
	                    var li = $("<li>").addClass("nav-header").attr("name",classname);
	                    // var divider = $("<li>").addClass("divider");
	                    var url = "<?php echo site_url('book_view/book') ?>"+"/"+classname+"/1";
	                    url = encodeURI(url);
	                    var anchor = $("<a>").text(classname).attr({"href":url}).css({"font-size":"15px","color":"#E47911"});
	                    var url_classname = "<?php echo urldecode($this->uri->segment(3));?>";
	                    li.append(anchor);
	                    nav.append(li);
	                    // nav.append(divider);
	                }
	                else //if(lv == 2)
	                {
	                    var li = $("<li>").attr("name",classname);
	                    var url = "<?php echo site_url('book_view/book') ?>"+"/"+lv1class+"-"+classname+"/1";
	                    url = encodeURI(url);
	                    var anchor = $("<a>").text(classname).attr("href", url);
	                    var url_classname = "<?php echo urldecode($this->uri->segment(3));?>";
	                    if((lv1class+"-"+classname) == url_classname)
	                    {
	                    	li.addClass("active").append(anchor);
	                    }
	                    else
	                    {
	                    	li.append(anchor);
	                    }
	                    nav.append(li);
	                }
	            });
	            $("#navlist").html(nav);
					}
		});
	});
</script>
<script>
	$(function (){
		$.ajax({
	        type:"GET",
	        url:"<?php echo base_url(); ?>classification.xml",
	        dataType:"xml",
	        success:function(xml){
	        	//构建分类导航栏，在DOM中hide
	            var classification = $("<div>").addClass("classification");
	            $(xml).find("class").each(function(i){
	                var classname = $(this).attr("name");
	                var lv = $(this).attr("lv");
	                if(lv == 1)
	                {
	                    var lv1 = $("<div>").addClass("lv1").attr("name",classname);
	                    var title = $("<a>").text(classname);
	                    var lv2 = $("<p>").addClass("lv2");
	                    lv1.append(title);
	                    lv1.append(lv2);
	                    classification.append(lv1);
	                }
	                else //if(lv == 2)
	                {
	                    var lv2name = $("<a>").text(classname);
	                    classification.find(".lv2").last().append(lv2name).append(" | ");
	                }
	            });
	            // 对导航栏按钮绑定 点击事件  尝试用classification绑定事件，只能点击一次，事件就失效，css没有失效
	            $("div.controls").delegate("a","click",function(e){
	            	if($(this).parent().attr("class") == "lv1")
	            	{
	            		var classname = $(this).text();
	            	}
	            	else
	            	{
	            		var classname = $(this).parent().parent().attr("name")+'-'+$(this).text();
	            	}
           			$("[name=class]").attr('value',classname);
           			$('#class').popover('hide');
           		});
           		classification.find("a").css({"cursor":"pointer","white-space":"nowrap","color":"#003399"});
           		classification.find(".lv1").children("a").css({"font-weight":"bold","color":"#E47911"});
	            // #class 是输入框
	            $("#class").popover(
				{
					title:"图书分类",
					html:1,
					content:classification,
				});
				//输入框 鼠标指针形状
				$("#class").css("cursor","pointer");
	        }
	    });
	});
</script>


<script type="text/javascript">
  $("#isbn_btn").click(function(){$("#dataLoad").modal('show');});
  $("#q_btn").click(function(){$("#dataLoad").modal('show');}); //为指定按钮添加数据加载动态显示：即将DIV显示出来
</script>
</body>
</html>
