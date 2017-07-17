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
<script type="text/javascript" src="js/jquery-ui-1.7.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.custom.forms-0.5.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="http://www.imaginamos.com/footer_ahorranito/jquery.ahorranito.js"></script>
<script type="text/javascript" src="js/ahorranito.js"></script>
</head>

<body>
<?php include("header-internas.php"); ?>
<div class="logotipo-margen"> <a href="index.php" class="logotipo"></a></div>
<div class="main-internas">
<div class="margen">
  <h1>Pide tu TAXI YA</h1>
  <div class="box-pedirtaxi">
    <div id="page-wrap">
      <div id="tabs">
        <ul>
          <li><a href="#pagina-1"></a></li>
          <li><a href="#pagina-2"></a></li>
          <li><a href="#pagina-3"></a></li>
        </ul>
        <div id="pagina-1" class="ui-tabs-panel">
          <form method="get" action="" class="pedir-taxi">
            <fieldset>
              <legend>Paso <span class="rojo">2</span></legend>
              <div class="clear"></div>
              <p class="reservar">
                <label for="select">¿Para qué desea reservar? </label>
                <select name="data[select]" class="cform">
                  <option value=""></option>
                  <option value="1">Carrera al aeropuerto</option>
                  <option value="2">Viaje fuera de la ciudad</option>
                  <option value="3">Servicio en la madrugada</option>
                  <option value="4">Servicio por horas</option>
                </select>
              </p>
                  <p class="hora-recogida">
                <label for="select">¿A que hora desea que lo recojamos? </label>
                <select name="data[select]" class="cform">
                  <option value=""></option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
        <legend>Paso <span class="rojo">3</span></legend>
              <div class="clear"></div>
              <p class="nomenclatura">
                <input type="radio" name="data[radio]" value="si" id="si" class="cform">
						<label for="si" class="lblr">Si</label><br />

                      
					
			
             
           
  <input type="radio" name="data[radio]" value="no" id="no" class="cform">
                <label for="no" class="lblr">No</label>
                
              </p>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>&nbsp;&nbsp;&nbsp;
                 <select name="data[select]" class="cform">
                  <option value=""></option>
                  <option value="1">00</option>
                  <option value="2">01</option>
                  <option value="3">02</option>
                  <option value="4">04</option>
                  <option value="5">05</option>
                  <option value="6">06</option>
       
                  <option value="7">07</option>
                  <option value="8">08</option>
                  <option value="9">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>&nbsp;&nbsp;&nbsp;
                 <select name="data[select]" class="cform">
                  <option value=""></option>
                  <option value="1">AM</option>
                  <option value="2">PM</option>
                  
                </select>
              </p>
            </fieldset>
            <a href="pedir-taxi.php" class="boton-pedir">Anterior</a>
          
        </div>
        <div id="pagina-2" class="ui-tabs-panel ui-tabs-hide">  
            <fieldset>
              <legend>Paso <span class="rojo">3</span></legend>
              <div class="clear"></div>
              <p class="nomenclatura">
                <input type="radio" name="data[radio]" value="si" id="si" class="cform">
						<label for="si" class="lblr">Si</label><br />

                      
					
			
             
           
  <input type="radio" name="data[radio]" value="no" id="no" class="cform">
                <label for="no" class="lblr">No</label>
                
              </p>
                  <p class="hora-recogida">
                <label for="select">¿A que hora desea que lo recojamos? </label>
                <select name="data[select]" class="cform">
                  <option value=""></option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
       
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>&nbsp;&nbsp;&nbsp;
                 <select name="data[select]" class="cform">
                  <option value=""></option>
                  <option value="1">00</option>
                  <option value="2">01</option>
                  <option value="3">02</option>
                  <option value="4">04</option>
                  <option value="5">05</option>
                  <option value="6">06</option>
       
                  <option value="7">07</option>
                  <option value="8">08</option>
                  <option value="9">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>&nbsp;&nbsp;&nbsp;
                 <select name="data[select]" class="cform">
                  <option value=""></option>
                  <option value="1">AM</option>
                  <option value="2">PM</option>
                  
                </select>
              </p>
            </fieldset>
          
          </form> </div>
        <div id="pagina-3" class="ui-tabs-panel ui-tabs-hide"> 3 </div>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
