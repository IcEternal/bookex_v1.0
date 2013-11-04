
<script type="text/javascript">
	$(function (){
	    var clickLogin = function(event){
		event.stopPropagation();
		span = $(this);
		$.post(
	        "<?php echo site_url();?>/ajax/loginCheck",
	        {"username":$("#username").attr('value'), "password":$("#password").attr('value')},
	        function(data)
	        {
	        		$(".message").text(data);
	                $(".message").css("display", "block");
	                if (data.indexOf("成功") >= 0){
	                	$.post("<?php echo site_url();?>/login/validate_credentials",
	                	{"username":$("#username").attr('value'), "password":$("#password").attr('value')},
	                	function(data){
							window.location.href="<?php echo site_url();?>";
	                	});
	                	//window.location.href="<?php echo site_url();?>";
	                }
	        });
	}

	$("#submitLogin").css({"cursor":"pointer"}).bind("click", clickLogin);



	});

</script>
