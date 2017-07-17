// JavaScript Document
    $(document).ready(function(){
		$('.boton-pedirtaxi').animate({'right': 30}, 700);
	function moveIrrDown (el){
		
		$('.boton-pedirtaxi').animate({'top':80},500,function(){moveIrrUp($(this));});
	}
	function moveIrrUp (el){
		$('.boton-pedirtaxi').animate({'top':90},500,function(){moveIrrDown($(this));});
	}
	moveIrrDown();
	    

});
    $(document).ready(function(){
		$('.boton-pedirtaxi-internas').animate({'right': 0}, 700);
	function moveIrrDown (el){
		
		$('.boton-pedirtaxi-internas').animate({'top':-5},500,function(){moveIrrUp($(this));});
	}
	function moveIrrUp (el){
		$('.boton-pedirtaxi-internas').animate({'top':0},500,function(){moveIrrDown($(this));});
	}
	moveIrrDown();
	    

});
         $(document).ready(function() {
               $('.footer-ahorranito').ahorranito({
				   type:1,
				   fontColor1:'#FFF',
				   height: 30
			   });
          });


		$(document).ready(function (){
$("#fondo-slider").animate({top:0}, 2000);
});
		$(document).ready(function (){
$("#logo-slider").animate({left: 180}, 2000);
});
	
  	$(document).ready(function (){
$("#tele-slider").animate({right: 190}, 2000);
});


	
  

	$(document).ready(function (){
		
		
		
		
	$(".m1 a").hover(function(){
  $(this).animate({ backgroundPositionY: "-97px" }, 250);
  }, function () {
  $(this).animate({ backgroundPositionY: "0px",}, 250); });
  
  $(".m2 a").hover(function(){
  $(this).animate({ backgroundPositionY: "-97px" }, 250);
  }, function () {
  $(this).animate({ backgroundPositionY: "0px",}, 250); });
  
   $(".m3 a").hover(function(){
  $(this).animate({ backgroundPositionY: "-97px" }, 250);
  }, function () {
  $(this).animate({ backgroundPositionY: "0px",}, 250); });
  
   $(".m4 a").hover(function(){
  $(this).animate({ backgroundPositionY: "-97px" }, 250);
  }, function () {
  $(this).animate({ backgroundPositionY: "0px",}, 250); });
  
   $(".m5 a").hover(function(){
  $(this).animate({ backgroundPositionY: "-97px" }, 250);
  }, function () {
  $(this).animate({ backgroundPositionY: "0px",}, 250); });
  
   $(".m6 a").hover(function(){
  $(this).animate({ backgroundPositionY: "-97px" }, 250);
  }, function () {
  $(this).animate({ backgroundPositionY: "0px",}, 250); });
  
   $(".m7 a").hover(function(){
  $(this).animate({ backgroundPositionY: "-97px" }, 250);
  }, function () {
  $(this).animate({ backgroundPositionY: "0px",}, 250); });
  
  
  
  });
  
  		$(document).ready(function (){
 
  		$(function() {

			var $tabs = $('#tabs').tabs();
	
			$(".ui-tabs-panel").each(function(i){
	
			  var totalSize = $(".ui-tabs-panel").size() - 1;
	
			  if (i != totalSize) {
			      next = i + 2;
		   		  $(this).append("<a href='#' class='next-tab mover' rel='" + next + "'>Siguiente</a>");
			  }
	  
			  if (i != 0) {
			      prev = i;
		   		  $(this).append("<a href='#' class='prev-tab mover' rel='" + prev + "'>Anterior</a>");
			  }
   		
			});
	
			$('.next-tab, .prev-tab').click(function() { 
		           $tabs.tabs('select', $(this).attr("rel"));
		           return false;
		       });
       

		});
		
	});
