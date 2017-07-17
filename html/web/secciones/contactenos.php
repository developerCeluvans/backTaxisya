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

<link href="css/taxisya.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.slider.js"></script>
<script type="text/javascript" src="js/banner.js"></script>
<script type="text/javascript" src="http://www.imaginamos.com/footer_ahorranito/jquery.ahorranito.js"></script>
<script type="text/javascript" src="js/ahorranito.js"></script>
<link rel="stylesheet" href="css/validationEngine.jquery.css" media="all">
<script type="text/javascript" src="js/jquery.validationEngine-es.js"></script>
 <script type="text/javascript" src="js/jquery.validationEngine.js"></script>
</head>

<body>
<?php include("header-internas.php"); ?>
<div class="logotipo-margen"> <a href="index.php" class="logotipo"></a><a href="index.php?base&seccion=pedir-taxi" class="boton-pedirtaxi-internas"></a></div>
<div class="main-internas">
  <div class="margen">
    <h1> contáctenos </h1>
   
  <form class="cont_left" action="controllers/contacto.php" method="post">
    <label>Nombre</label>
    <input name="nombre"  type="text" class="input validate[required]" value="" />
      <label>Correo electrónico</label>
    <input name="email"  type="text" class="validate[required,custom[email]] input" value="" />
    <label>Teléfono / Celular</label>
    <input name="tel"  type="text" class="input validate[required]" value="" />
  <label>Asunto</label>
    <input name="asunto"  type="text" class="input validate[required]" value="" />

    <label>Comentario</label>
    <textarea class="validate[required]" name="comentario"></textarea>
   
    <input class="boton-enviar" value="Enviar" name="Submit" type="submit"/>
  </form>
  <div class="cont_right">
  <div class="imagen"><img src="imagenes/comunicacion.jpg" /></div>

<p><strong>TAXIS YA</strong> </p>
    <p>Calle 1C Bis # 18 - 34 / Barrio Eduardo Santos - Bogotá <br />    
      (57-1) 2891603 /  2.000.000<br />
      (57-1) 4111112 / (57-1) 3333333<br />      
      info@taxisya.com</p>
  </div>
    
  </div>
</div>
<?php include("footer.php"); ?>
<script>
$(".cont_left").validationEngine();
</script>
</body>
</html>
<?php 
if(isset($_GET['ok'])){
    ?>
<script type="text/javascript" >
    $(document).ready(function(){
        alert(' Mensaje enviado con Éxito');
//        document.getElementById('mensaje').innerHTML = ' Mensaje enviado con Éxito';
//        $('#boton-contacto').click();
    });
</script>
        <?php
}elseif(isset($_GET['error'])){
    ?><script type="text/javascript" >
    $(document).ready(function(){
        alert('Error trata nuevamente.');
//        document.getElementById('mensaje').innerHTML = ' Error trata nuevamente.';
//        $('#boton-contacto').click();
    });
</script>
        <?php
}
?>