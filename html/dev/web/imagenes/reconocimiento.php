<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TAXIS YA</title>
<meta name="viewport" content="width=1024, maximum-scale=2">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="favicon.ico">
<link rel="apple-touch-icon-precomposed" href="favicon.ico">
<meta http-equiv="content-language" content="es" />
<meta http-equiv="pragma" content="No-Cache" />
<meta name="Keywords" lang="es" content="" />
<meta name="Description" lang="es" content="" />
<meta name="copyright" content="imaginamos.com" />
<meta name="date" content="2013" />
<meta name="author" content="diseño web: imaginamos.com" />
<meta name="robots" content="All" />

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->

<style>
.img-rec1 img{
	width:230px;
	margin-top:50px;
}
.img-rec2 img{
	width:180px;
	margin: auto;
	margin-top:50px;	
}
.img-rec3 img{
	width:150px;
	margin-top:50px;
}
</style>

<link href="css/taxisya.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.slider.js"></script>
<script type="text/javascript" src="js/banner.js"></script>
<script type="text/javascript" src="http://www.imaginamos.com/footer_ahorranito/jquery.ahorranito.js"></script>
<script type="text/javascript" src="js/ahorranito.js"></script>
<script>
$(document).ready(function () {	    
	function moveIrrDown (el){		
		$('.img-rec1').animate({'marginTop':'-10px'},1300,function(){moveIrrUp($(this));});
	}
	function moveIrrUp (el){
		$('.img-rec1').animate({'marginTop':'0px'},1300,function(){moveIrrDown($(this));});
	}
	moveIrrDown();
});

$(document).ready(function () {	    
	function moveIrrDown (el){		
		$('.img-rec2').animate({'marginTop':'10px'},1000,function(){moveIrrUp($(this));});
	}
	function moveIrrUp (el){
		$('.img-rec2').animate({'marginTop':'0px'},1300,function(){moveIrrDown($(this));});
	}
	moveIrrDown();
});

$(document).ready(function () {	    
	function moveIrrDown (el){		
		$('.img-rec3').animate({'marginTop':'-10px'},1300,function(){moveIrrUp($(this));});
	}
	function moveIrrUp (el){
		$('.img-rec3').animate({'marginTop':'0px'},1300,function(){moveIrrDown($(this));});
	}
	moveIrrDown();
});

</script>
<style>
.list_carousel {
background-color: #fff;
width: 883px;
margin:0px auto;
margin-top:20px;
margin-bottom:20px;
	border-radius:5px;
-webkit-box-shadow: 1px 1px 12px rgba(50, 50, 50, 0.75);
-moz-box-shadow:    1px 1px 12px rgba(50, 50, 50, 0.75);
box-shadow:         1px 1px 12px rgba(50, 50, 50, 0.75);				
}
.list_carousel ul {
	margin:0px auto;
	padding: 0;
	list-style: none;
	display: block;
}
.list_carousel li {
	width: 260px; 
	height: 230px;
	float:left;
	margin-top:0px;
	margin-left:12px;
	margin-right:15px;
	margin-bottom:10px;
}
.list_carousel.responsive {
	width: auto;
	margin-left: 0;
}
.clearfix {
	float: none;
	clear: both;
}
.flechas{
	border-radius:0px 0px 5px 5px;
	height:30px;
	background:#333;
}
.prev {
float: left;
margin-top:8px;
margin-left: 400px;
width:11px;
height:18px;
background:url(imagenes/pag-prev.png) no-repeat center;
}
.next {
float: right;
margin-top:8px;
margin-right: 400px;
width:11px;
height:18px;
background:url(imagenes/pag-next.png) center no-repeat;
}
</style>
<script type="text/javascript" language="javascript" src="js/jquery.carrusel.js"></script>
<script type="text/javascript" language="javascript">
	$(function() {
		$('#foo2').carouFredSel({
			auto: true,
			prev: '#prev2',
			next: '#next2',
			pagination: "#pager2",
			mousewheel: true,
			swipe: {
				onMouse: true,
				onTouch: true
			}
		});
	});
</script>
</head>

<body>
<?php include("header-internas.php"); ?>
<div class="logotipo-margen"> <a href="index.php" class="logotipo"></a><a href="index.php?base&seccion=pedir-taxi" class="boton-pedirtaxi-internas"></a></div>
<div class="main-internas">
  <div class="margen">
    <h1>reconocimiento</h1>

<div style="width:100%; min-height:300px; overflow:hidden; margin: 20px 0 20px 0">

<div class="list_carousel">
    <ul id="foo2">
    <li>
        <a href="javascript:;" id="btn-down-1">
        <div class="img-rec1">
        <img src="imagenes/l1.png" />    
        </div>    
        </a>
      </li>
    <li>
        <a href="javascript:;" id="btn-down-1">
        <div class="img-rec2">
        <img src="imagenes/l2.png" />    
        </div>    
        </a>
      </li>       
    <li>
        <a href="javascript:;" id="btn-down-1">
        <div class="img-rec3">
        <img src="imagenes/l3.png" />    
        </div>    
        </a>
      </li>
       <li>
        <a href="javascript:;" id="btn-down-1">
        <div class="img-rec1">
        <img src="imagenes/l1.png" />    
        </div>    
        </a>
      </li>
    <li>
        <a href="javascript:;" id="btn-down-1">
        <div class="img-rec2">
        <img src="imagenes/l2.png" />    
        </div>    
        </a>
      </li>       
    <li>
        <a href="javascript:;" id="btn-down-1">
        <div class="img-rec3">
        <img src="imagenes/l3.png" />    
        </div>    
        </a>
      </li>
    </ul> 
        <div class="clearfix"></div>
       <div class="flechas"> 
        <a id="prev2" class="prev" href="#"></a>
        <a id="next2" class="next" href="#"></a>
       </div>  
   </div>    

  

    
    <div class="clear"></div>
    
<div id="txtServ1">    
  <h2 style="text-align:center; width:800px; margin:0px auto;">Participación activa en diferentes cursos de capacitación a nuestros  afiliados.</h2>
</div>
  </div>
</div>
<?php include("footer.php"); ?>

</body>
</html>
