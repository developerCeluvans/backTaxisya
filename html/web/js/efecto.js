$(document).ready(function(){
	
	$("#topnav li").hover(function(){
  $(this).animate({top:'-25px' }, 250);
  }, function () {
  $(this).animate({top:'0px'}, 250); });
  

		
		$(".bounce").hover(function() {
		     $(this).stop().animate({ marginTop: "-7px" }, 500,'easeOutBounce');
		},function(){
		    $(this).stop().animate({ marginTop: "0px" }, 500,'easeOutBounce');
		   
		});
		
		 //BTN REDES
	$(".face").hover(function(){
	  $(this).animate({ backgroundPositionY: "-34px" }, 300);
	  }, function () {
	  $(this).animate({ backgroundPositionY: "1px",}, 300); 
	});
	$(".twitter").hover(function(){
	  $(this).animate({ backgroundPositionY: "-34px" }, 300);
	  }, function () {
	  $(this).animate({ backgroundPositionY: "1px",}, 300); 
	});
	$(".youtube").hover(function(){
	  $(this).animate({ backgroundPositionY: "-34px" }, 300);
	  }, function () {
	  $(this).animate({ backgroundPositionY: "1px",}, 300); 
	});
	
		
		$(".btn-mask").hover(function() {
		    $(this).stop().children(".mask").fadeIn();
		},function(){
		    $(this).stop().children(".mask").css({display: "none"});
		   
		});
		
		$.timer(300, function (temporizador) {
			 $(".texto-destacado").fadeIn(500);
			 temporizador.stop();
			 
		});
		
		//btn ver-colecci˜n
		$(".coleccion-btn-ver").hover(function() {
		     $(this).stop().animate({ marginTop: "-62px" }, 500,'easeOutBounce');
		},function(){
		    $(this).stop().animate({ marginTop: "0px" }, 500,'easeOutBounce');
		   
		});
		
		
		
		//MAPA
		
		$(".ver-mapa-1").click(function() {
		     $(".mapa-1").show();
			 $(".mapa-2").hide();
			 $('body, html').animate({scrollTop : 880},'slow');
		});
		$(".ver-mapa-2").click(function() {
		     $(".mapa-2").show();
			 $(".mapa-1").hide();
			 $('body, html').animate({scrollTop : 880},'slow');
		});
		
		
		//RECOMENDACION
	
		
		$(".img-recomendacion").hover(function(e) {
			$(this).children(".rollover-recomendacion").fadeIn(800);
		},
			function(e) {
				$(this).children(".rollover-recomendacion").css({display: "none"});
				}
			);
		
		//ROLLOER CATALOGO
		
		
		$(".catalogo-ver").hover(function(e) {
			$(this).children(".catalogo-rollover").fadeIn(800);
		},
			function(e) {
				$(this).children(".catalogo-rollover").css({display: "none"});
				}
			);
		
});


		//MOVIMIENTO
