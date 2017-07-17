$(document).ready(function(){
 // Muestra y oculta los menœs
   $('ul li:has(ul)').hover(
      function(e)
      {
         $(this).find('ul').css({visibility: "visible",display: "none"}).fadeIn(); 
      },
      function(e)
      {
         $(this).find('ul').css({display: "none"});
      }
   );	   
	function moveIrrDown (el){
		$('.boton-premios').animate({'top':270},2000,function(){moveIrrUp($(this));});
	}
	function moveIrrUp (el){
		$('.boton-premios').animate({'top':290},2000,function(){moveIrrDown($(this));});
	}
	moveIrrDown();
});