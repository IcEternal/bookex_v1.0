/* navigation bar */
$(document).ready(function(){
	$(".nav-drop").hover(function(){
		$(this).find(".nav-line").stop().animate({height:"204px"},"slow");
		$(this).find("ul:first").stop().animate({height:"168px"});
	},function(){
		$(this).find(".nav-line").stop().animate({height:"0px"});
		$(this).find("ul:first").stop().animate({height:"0px"});
	});
	$(".nav-main").hover(function(){
		$(this).find(".nav-line").stop().animate({height:"40px"});
	},function(){
		$(this).find(".nav-line").stop().animate({height:"0px"});
	});
});