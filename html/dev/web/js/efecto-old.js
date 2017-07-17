$(document).ready(function(){
		
		$(".bounce").hover(function() {
		     $(this).stop().animate({ marginTop: "-7px" }, 500,'easeOutBounce');
		},function(){
		    $(this).stop().animate({ marginTop: "0px" }, 500,'easeOutBounce');
		   
		});
		
		//DESTACADO
		$(".destacado-1").css("opacity","0");
		$.timer(500, function (temporizador) {
			 $(".destacado-1").animate({
				opacity: 1, marginTop: "28px"})
			 temporizador.stop();
			 
		});
		$.timer(800, function (temporizador) {
			 $(".destacado-2").animate({opacity: 1, marginTop: "6px"})
			 temporizador.stop();
		});
		
		$.timer(1300, function (temporizador) {
			 $(".destacado-3").animate({opacity: 1, marginTop: "0px"})
			 temporizador.stop();
		});
		
		$.timer(1600, function (temporizador) {
			 $(".destacado-4").animate({opacity: 1, marginTop: "6px"})
			 temporizador.stop();
		});
		$.timer(1900, function (temporizador) {
			 $(".destacado-5").animate({opacity: 1, marginTop: "28px"})
			 temporizador.stop();
		});
		$.timer(2300, function (temporizador) {
			 $(".texto-destacado").animate({
				opacity: 1, marginLeft: "28px"},1000)
			 temporizador.stop();
			 
		});
		
		$(".mask").css("opacity","0");
		
		$(".btn-mask").hover(function() {
		    $(this).stop().children(".mask").animate({opacity: 1}, 400)
		},function(){
		    $(this).stop().children(".mask").animate({opacity: 0}, 400)
		   
		});
		
		//btn ver-colecci˜n
		$(".coleccion-btn-ver").hover(function() {
		     $(this).stop().animate({ marginTop: "-62px" }, 500,'easeOutBounce');
		},function(){
		    $(this).stop().animate({ marginTop: "0px" }, 500,'easeOutBounce');
		   
		});
		
		//SOMOS
		
		
		$.timer(300, function (temporizador) {
			 $(".img-somos").animate({
				opacity: 1, marginTop: "28px"},800)
			 temporizador.stop();
			 
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
		
		$.timer(500, function (temporizador) {
			 $(".anima-tienda-1").animate({
				opacity: 1, marginTop: "0"},800)
			 temporizador.stop();
			 
		});
		$.timer(800, function (temporizador) {
			 $(".anima-tienda-2").animate({
				opacity: 1, marginTop: "0"},800)
			 temporizador.stop();
			 
		});
		
		//RECOMENDACION
		
		$(".ecomendacion-ver-mas-up").hover(function() {
		     $(this).stop().animate({ marginTop: "-31px" }, 500,'easeOutBounce');
		},function(){
		    $(this).stop().animate({ marginTop: "0px" }, 500,'easeOutBounce');
		   
		});
		
		$(".img-recomendacion").hover(function(e) {
			$(this).children(".rollover-recomendacion").animate({opacity:1});
		},
			function(e) {
				$(this).children(".rollover-recomendacion").animate({opacity:0});
				}
			);
		
		
});

