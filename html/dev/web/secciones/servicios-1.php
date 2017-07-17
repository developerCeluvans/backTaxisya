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
.list li{
	list-style-type:circle !important;
	color: rgb(51, 51, 51);
	font-family: MyriadPro-Regular;
	font-size: 16px;
	line-height: 20px;
	margin:0 0 5px 30px;
}
/*-------------------Acordeon------------------------*/
 #accordion { /* el rectángulo contenedor */
    width: 600px;
	float:left;
	margin:10px 0 0 0px;
  }
  #accordion h3 { /* los enlaces que despliegan y contraen el contenido */
   width:600px;
	background:rgb(38, 76, 159);
	font-family: 'MyriadPro-Bold';
	font-size:20px;
	margin:0px;
	padding:7px;
	color:#FFF;
	border: 1px solid rgb(213, 213, 213);
	-moz-border-radius-topleft: 5px;
	-webkit-border-top-left-radius: 5px;
	 border-top-left-radius: 5px;
	-moz-border-radius-topright: 5px;
	-webkit-border-top-right-radius: 5px;
	border-top-right-radius: 5px;
  }
  #accordion h3:hover { /* efecto hover sobre esos enlaces */
    -moz-box-shadow: 0 0 10px #000 inset;
    -webkit-box-shadow: 0 0 10px #000 inset;
    box-shadow: 0 0 10px #000 inset;
    background-color: rgb(9, 33, 112);
    color: #FFF;
	cursor:pointer;
  }
  #accordion h3 span { /* una imagen que permuta segñun el estado del contenido */
    background: transparent url(../imagenes/flechas-acordeon.gif) no-repeat right top;
    display: block;
    height: 16px;
    position: absolute;
    right: 20px;
    top: 7px;
    width: 16px;
  }
  #accordion h3.active span { /* desplegado */
    background-position: right bottom;
  }
  #accordion .cont-a { /* el contenido */
	width:600px;
	min-height:10px;
	overflow:hidden;
	padding:4px;
	margin:0 0 6px 0px;
	background: #EEE;
	border: 1px solid rgb(213, 213, 213);
	-moz-border-radius-bottomright: 11px;
	-webkit-border-bottom-right-radius: 11px;
	border-bottom-right-radius: 11px;
	-moz-border-radius-bottomleft: 11px;
	-webkit-border-bottom-left-radius: 11px;
	border-bottom-left-radius: 11px;
  }
  
  #accordion .cont-a li{
	  margin:0 0 0 20px;
	  list-style-type:disc;	  
		font-size: 14px;
		margin-bottom: 6px;
		color: #4b4b4b;
		font-family: 'MyriadPro-Regular';
  }
  #accordion .cont-a li strong{ font-weight:bold;}


</style>
<link href="css/taxisya.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://repositorio.imaginamos.com.co/JES/william-villalba/renta-espacio/js/jquery-1.9.1.min.js"></script>
<script>
//ACORDEON
$(document).ready(function(){
	$("#accordion h3:first").addClass("active");
	  $("#accordion .cont-a:not(:first)").hide();
	  $("#accordion h3").click(function(){
		$(this).next(".cont-a").slideToggle("slow")
		.siblings(".cont-a:visible").slideUp("slow");
		$(this).toggleClass("active");
		$(this).siblings("h3").removeClass("active");
     });
});
</script>
<script type="text/javascript" src="js/jquery.slider.js"></script>
<script type="text/javascript" src="js/banner.js"></script>
<script type="text/javascript" src="http://www.imaginamos.com/footer_ahorranito/jquery.ahorranito.js"></script>
<script type="text/javascript" src="js/ahorranito.js"></script>
</head>

<body>

 <?php include("header-internas.php"); ?>
<div class="logotipo-margen"> <a href="index.php" class="logotipo"></a><a href="index.php?base&seccion=pedir-taxi" class="boton-pedirtaxi-internas"></a></div>
<div class="main-internas">
  <div class="margen">
    <h1>nuestros servicios</h1>
    
     <center><img src="imagenes/ser.png" style="margin:14px 0 0 0;" /></center>    
    
<div id="accordion">
    <h3 id="galeria1">Afiliación: <span></span></h3>
          <div class="cont-a"> 
          
    <div class="servicios-left">
      <div class="imagen"><img src="imagenes/afiliacion.jpg" /></div>
       <div class="titulo"> Afiliación: </div>
       <div class="texto"><p>Para TAXIS YA S.A, es un honor contar con su vinculación a nuestra compañía, se puede hacer con vehículo nuevo (MATRICULA) o por cambio de empresa (VEHICULO USADO).</p>
    </div>      
     <div class="clear"></div>
    </div> 
     
          </div>
          
           <h3 id="galeria1">Asesoría de Acompañamiento Jurídico: <span></span></h3>
          <div class="cont-a"> 
          
      <div class="servicios-right"><div class="imagen"><img src="imagenes/asesoria.jpg" /></div>
      <div class="titulo">Asesoría de Acompañamiento Jurídico: </div>
         <div class="texto"><p>TAXIS YA S.A, junto a su pull de abogados brindan a nuestros afiliados una orientación y asesoría en asuntos legales respecto al sistema de actividades del transporte.</p></div></div>
     
          </div>
          
           <h3 id="galeria1">Servicios de Comunicación: <span></span></h3>
          <div class="cont-a"> 
          
             <div class="servicios-left">
      <div class="imagen"><img src="imagenes/comunicacion.jpg" /></div>
       <div class="titulo">Servicios de Comunicación: </div>
       <div class="texto"><p>TAXIS YA S.A, siempre está a la vanguardia de la tecnología para brindar el mejor servicio de transporte a nuestros afiliados y usuarios, es por este motivo que la empresa tiene a su disposición:</p></div></div>
     
          </div>
          
          <h3 id="galeria1">Servicios de Comunicación: <span></span></h3>
          <div class="cont-a"> 
          
      <div class="servicios-right"><div class="imagen"><img src="imagenes/radio.jpg" /></div>
      <div class="titulo">Servicio de Radio telefono:  </div>
         <div class="texto"><p>A través del cual se permite la comunicación de sonidos (en especial la voz) por ondas radioeléctricas entre 2 estaciones fijas o móviles con la posibilidad de transmitir, de manera simultánea o alternativa, en ambos sentidos.</p></div></div>
     
          </div>
          
          <h3 id="galeria1">I.V.R:  <span></span></h3>
          <div class="cont-a"> 
          
    <div class="servicios-left"><div class="imagen"><img src="imagenes/ivr.jpg" /></div>
      <div class="titulo">I.V.R:  </div>
         <div class="texto"><p>Es el sistema de voz, donde le permite a nuestros usuarios comunicarse de forma ágil y rápida con nuestros números telefónicos <strong>2.00.00.00</strong>  o  <strong>3.33.33.33,</strong>  eligiendo la opción automática que se prefiera ahorrando tiempo en su comunicación.</p></div></div>
     
          </div>
          
           <h3 id="galeria1">Satelital:  <span></span></h3>
          <div class="cont-a"> 
          
      <div class="servicios-right"><div class="imagen"><img src="imagenes/satelital.jpg" /></div>
      <div class="titulo">Satelital:  </div>
         <div class="texto"><p>Es el sistema de comunicación y localización que se da por medio de un dispositivo (GPS), para una mayor seguridad de nuestros afiliados y usuarios.</p></div></div>   
     
          </div>
          
          <h3 id="galeria1">Aplicativo móvil:  <span></span></h3>
          <div class="cont-a"> 
          
      <div class="servicios-left"><div class="imagen"><img src="imagenes/movil.jpg" /></div>
      <div class="titulo">Aplicativo móvil: </div>
         <div class="texto"><p>El sistema que por medio  de un programa instalable en su teléfono celular brinda  una solución completa que permite a los usuarios de teléfonos celulares solicitar un servicio de taxi en cualquier parte de la ciudad y con la garantía de ser atendido por el móvil más cercano a su ubicación, disminuyendo los tiempos de atención, ofreciendo una mayor seguridad ya que el  aplicativo provee una alta calidad de imágenes y de esta forma visualizar los móviles en el mapa. Este aplicativo integra las ventajas de las nuevas plataformas móviles con las funcionalidades que ofrece el sistema de seguimiento GPS vehicular o de personas. (Es compatible con móviles con sistema ANDROID –ISO.)</p></div></div>     
     
          </div>
          
          <h3 id="galeria1">Asesoria en Tramites: <span></span></h3>
          <div class="cont-a"> 
          
         <div class="servicios-right"><div class="imagen"><img src="imagenes/tramites.jpg" /></div>
      <div class="titulo">Asesoria en Tramites: </div>
         <div class="texto"><p>TAXIS YA S.A, cuenta con un grupo de colaboradores dispuestos a asesorarle de una forma eficaz y con la excelencia que es merecedor cada uno de nuestros afiliados en sus trámites internos a nuestra compañía y con las demás entidades relacionadas con su vehículo.</p></div></div>   
     
          </div> 
          
          <h3 id="galeria1">Compra y Venta de vehículos y Cupos( FINANCIACION):  <span></span></h3>
          <div class="cont-a"> 
          
         <div class="servicios-left"><div class="imagen"><img src="imagenes/compra.jpg" /></div>
      <div class="titulo">Compra y Venta de vehículos y Cupos( FINANCIACION):   </div>
         <div class="texto"><p>Nuestra empresa se ha destacado  en el mercado del transporte por su seriedad, confiabilidad, responsabilidad y cumplimiento en la gestión de compra y venta de vehículos y de cupos, contando con una gran vitrina la cual tiene el respaldo de las mejores marcas de taxis.</p></div></div>    
     
          </div>
          
          <h3 id="galeria1">Compra y Venta de vehículos y Cupos( FINANCIACION):  <span></span></h3>
          <div class="cont-a"> 
          
         <div class="servicios-right"><div class="imagen"><img src="imagenes/capacitacion.jpg" /></div>
      <div class="titulo">Compra y Venta de vehículos y Cupos( FINANCIACION): </div>
         <div class="texto"><p>TAXIS YA S.A, está comprometida con sus afiliados y con la comunidad capacitando activamente a todos nuestros afiliados en entidades como son: SENA, POLICIA NACIONAL, POLICIA METROPOLITANA, SEGUROS DEL ESTADO, UNIVERSIDADES LOCALES, contribuyendo así con un alto grado de RESPONSABILIDAD SOCIAL EMPRESARIAL.</p></div></div>     
     
          </div> 
          
          <h3 id="galeria1">Financiacion de vehículos:  <span></span></h3>
          <div class="cont-a"> 
          
         <div class="servicios-left"><div class="imagen"><img src="imagenes/asesoria.jpg" /></div>
      <div class="titulo">Financiacion de vehículos: </div>
         <div class="texto"><p>TAXIS YA S.A,  en sus instalaciones cuenta con  puntos de venta de seguros tales como son: CONTRACTUAL, EXTRACONTRACTUAL, TODO RIESGO, SOAT</p></div></div>     
     
          </div> 
          
          <h3 id="galeria1">Venta de Seguros RCC, RCE , SOAT:  <span></span></h3>
          <div class="cont-a"> 
          
         <div class="servicios-right "><div class="imagen"><img src="imagenes/seguros.jpg" /></div>
      <div class="titulo"> Venta de Seguros RCC, RCE , SOAT.</div>
         <div class="texto"><p></p></div></div>    
     
          </div>          
          
</div><!--------------Fin Acordeon-------------->
    
  </div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
