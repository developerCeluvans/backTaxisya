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
<script src="js/pop-up.js"></script> 
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
          </ul>
          <div id="pagina-1" class="ui-tabs-panel">
          <form name="formuno" method="post" action="" class="pedir-taxi">
            <fieldset>
              <legend>Paso <span class="rojo">2</span> &iquest;Donde te recogemos?</legend>
              <div class="clear"></div>
           
              <p class="nomenclatura">
                <input type="radio" name="nomenclatura" value="si" id="nomenclatura" class="cform"/>
                <label for="si" class="lblr">Nomenclatura antigua</label>
                 </p>  <p class="nomenclatura-2">
                <input type="radio" name="nomenclatura" value="no" id="nomenclatura" class="cform"/>
                <label for="no" class="lblr">Nomenclatura nueva</label>
              </p>
              <div class="clear"></div>
              <!--<p class="barrio">
                <label for="select">Barrio </label>
                <select id="barrio" name="data[select]" class="cform">
                    <option value="0"></option>
                    <?php $barrio = DbHandler::GetAll("SELECT id, titulo FROM barrio ORDER BY titulo ASC");
                    $contador = count($barrio);
                    for($i=0; $i<$contador; $i++):
                     ?>
                    <option value="<?= utf8_encode($barrio[$i]['titulo']); ?>"><?= utf8_encode($barrio[$i]['titulo']); ?></option>
                     <?php   
                    endfor;
                    ?>
                </select>
              </p>
              <div class="clear"></div>-->
              <p class="calle">
                <select id="dir" name="data[select]" class="cform">
                    <?php $dir = DbHandler::GetAll("SELECT id, titulo FROM tipo_dir ORDER BY id ASC");
                    $contador2 = count($dir);
                    for($j=0; $j<$contador2; $j++):
                        ?> <option value="<?= utf8_encode($dir[$j]['titulo']); ?>"><?= utf8_encode($dir[$j]['titulo']); ?></option><?php
                    endfor;
                    ?>
                </select>
              </p>
              <p class="calle-numero">
                <input id="dirnum" class="limit" onkeypress="return soloNumeros(event)" onpaste="return false" name="" type="text" />
              </p>
              <p class="letra">
                <select id="letra1"  name="data[select]" class="cform">
                    <?php $senalador = DbHandler::GetAll("SELECT id, senalador FROM tipo_senalador ORDER BY senalador ASC");
                    $contador3 = count($senalador);
                    for($k=0; $k<$contador3; $k++):
                        ?><option value="<?= utf8_encode($senalador[$k]['senalador']); ?>"><?= utf8_encode($senalador[$k]['senalador']); ?></option><?php
                    endfor;
                    ?>
                </select>
              </p>
              <span class="numeral">
                #
              </span>
              <p class="calle-numero">
                <input id="dirnum2" class="limit" onkeypress="return soloNumeros(event)" onpaste="return false" name="" type="text" />
              </p>
              <p class="letra">
                <select id="letra2" name="data[select]" class="cform">
                  <?php 
                    for($k=0; $k<$contador3; $k++):
                        ?><option value="<?= utf8_encode($senalador[$k]['senalador']); ?>"><?= utf8_encode($senalador[$k]['senalador']); ?></option><?php
                    endfor;
                    ?>
                </select>
              </p> <span class="numeral-2">
                -
              </span>
              <p class="calle-numero">
                <input id="dirnum3" class="limit" onkeypress="return soloNumeros(event)" onpaste="return false" name="" type="text" />
              </p>
              <p class="letra">
                <select id="letra3" name="data[select]" class="cform">
                 <?php 
                    for($k=0; $k<$contador3; $k++):
                        ?><option value="<?= utf8_encode($senalador[$k]['senalador']); ?>"><?= utf8_encode($senalador[$k]['senalador']); ?></option><?php
                    endfor;
                    ?>
                </select>
              </p>
              <div class="clear"></div>
              <p class="servicio-horas">
                <input id="check" type="checkbox" name="data[check]" value="female" class="cform"/>
                <label for="servicio-horas" class="lblr">Servicio por horas</label>
              </p>
              <div class="clear"></div>
              <p class="num-tel">
                <label for="select">Bloque / Torre / Interior </label>
               <input id="bti"  name="" type="text" style="width: 30%;" />
              </p>
<!--              <div class="clear"></div>-->
              <p class="num-tel">
                <label style="margin-left: 50px;"  for="select">Apartamento / Oficina </label>
                 <input id="aptofi" name="" type="text" style="width: 30%;" />
              </p>
            </fieldset>
            
             <div class="block"></div> 
            <div class="ejemplo-box">
              <div class="ejemplo">Este es un ejemplo:</div>
              <fieldset>
                <div class="direccion"> Mi direccion es Cra 3a # 58 -92 Apartamento 402 Interior 3 en Chapinero</div>
                <div class="clear"></div>
           
              <p class="nomenclatura">
                <input type="radio" name="datax[radio]" value="si" disabled="disabled" id="si" class="cform">
                <label for="si" class="lblr">Nomenclatura antigua</label>
                 </p>  
                 <p class="nomenclatura-2">
                <input type="radio" name="datax[radio]" value="no" disabled="disabled" checked="checked" id="no" class="cform">
                <label for="no" class="lblr">Nomenclatura nueva</label>
              </p>
              <div class="clear"></div>
                <!--<p class="barrio">
                  <label for="select">Barrio </label>
                  <select name="data[select]" class="cform">
                    <option value="">Chapinero</option>
                  </select>
                </p>
                <div class="clear"></div>-->
                <p class="calle">
                  <select name="data[select]" class="cform">
                    <option value="2">Carrera</option>
                  </select>
                </p>
                <p class="calle-numero">
                  <input name="" type="text" value="3" />
                </p>
                <p class="letra">
                  <select name="data[select]" class="cform">
                    <option value="1">A</option>
                  </select>
                </p>
                <p class="calle-numero">
                  <input name="" type="text" value="58" />
                </p>
                <p class="letra">
                  <select name="data[select]" class="cform">
                    <option value="1"></option>
                  </select>
                </p>
                <p class="calle-numero">
                  <input name="" type="text" value="92" />
                </p>
                <p class="letra">
                  <select name="data[select]" class="cform">
                    <option value="1"></option>
                  </select>
                </p>
                <div class="clear"></div>
                <p class="servicio-horas">
                  <input type="checkbox" name="data[check]" value="female" checked="checked" id="optiona" class="cform">
                  <label for="servicio-horas" class="lblr">Servicio por horas</label>
                </p>
                <div class="clear"></div>
                <p class="bloque">
                  <label for="select">Bloque / Torre / Interior </label>
                  <select name="data[select]" class="cform">
                    <option value="1">3</option>
                  </select>
                </p>
                <p class="apto">
                  <label for="select">Apartamento / Oficina </label>
                  <select name="data[select]" class="cform">
                    <option value="1">402</option>
                  </select>
                </p>
              </fieldset>
                   <a href="index.php?base&seccion=pedir-taxi" class="boton-pedir">Anterior</a>
                   
            </div>
                </form>
            </div>
             
            <div id="pagina-2" class="ui-tabs-panel ui-tabs-hide">
             <form class="pedir-taxi" >
            <fieldset>
              <legend>Paso <span class="rojo">3</span></legend>
              <p class="nombre">
                <label for="select">Nombre y Apellidos</label>
                <input id="nombre" name="" type="text" value="" />
              </p>
              <div class="clear"></div>
            <p class="num-tel">
                <label for="select">N&uacute;mero de Tel&eacute;fono</label>
                <input onkeypress="return soloNumeros(event)" onpaste="return false" id="tel" name="" type="text" value="" />
              </p>
                   <div class="clear"></div>
             <p class="nombre">
                <label for="select">Correo Electr&oacute;nico</label>
                <input id="email" name="" type="text" value="" />
              </p>
              <div class="clear"></div>
              <p class="taxis">
                <label for="select">&iquest;Cuantos taxis necesita?</label>
                <select id="ntaxis" name="data[select]" class="cform">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                </select>
              </p>
              <input name=""  id="tutaxi" onclick="return false" type="button" class="solicitar-servicio" value="Solicitar servicio" />
              
              <a id="okmesagge" href="#mensaje-enviado" class="login-window"></a>
              
              <div id="mensajeerror" class="mensajeerror">Recuerde que los campos de direcci&oacute;n, nombre, tel&eacute;fono e email son abligatorios.</div>
              
              <div id="mensajeerroremail" class="mensajeerroremail">La direcci&oacute;n de correo electr&oacute;nico es invalida</div>
            </fieldset>
           </form>
        </div>
           
      </div>
         
    </div>
  </div>
</div>
</div>
<?php include("footer.php"); ?>
<script type="text/javascript" >
$(document).ready(function() {
    $('#mensajeerror').hide();
    $('#mensajeerroremail').hide();
var total_letras = 3;

$('.limit').keyup(function() {
    var longitud = $(this).val().length;
    var resto = total_letras - longitud;
    $('#numero').html(resto);
    if(resto <= 0){
        $('.limit').attr("maxlength", 3);
    }
});
$('#tutaxi').click(function(){
    var indicador = false;
    if(document.formuno.nomenclatura[0].checked){
         var nomenclatura = 'Antigua';
         indicador = true;
    }
    if(document.formuno.nomenclatura[1].checked){
         var nomenclatura = 'Nueva';
         indicador = true;
    }
//    var barrio = $('#barrio').val();
    var dir = $('#dir').val();
    var dirnum = $('#dirnum').val();
    var letra1 = $('#letra1').val();
    var dirnum2 = $('#dirnum2').val();
    var letra2 = $('#letra2').val();
    var dirnum3 = $('#dirnum3').val();
    var letra3 = $('#letra3').val();
    var nombre = $('#nombre').val();
    var tel = $('#tel').val();
    var email = $('#email').val();
    var ntaxis = $('#ntaxis').val();
    var aptofi = $('#aptofi').val();
    var bti = $('#bti').val();
    var messageError = '';
    if(aptofi!=''){
        var aptofi2 = 'Apartamento / Oficina '+aptofi;
    }else{
        var aptofi2 = '';
    }
    if(bti!=''){
        var bti2 = 'Bloque / Torre / Interior  '+bti;
    }else{
        var bti2 = '';
    }
    var direccioncompleta = 'Direccion: '+dir+' '+dirnum+letra1+' # '+dirnum2+letra2+' - '+dirnum3+letra3+' - '+bti2+' - '+aptofi2;
  if($("#check").is(':checked')){
      var servicios = 'Es un servicio contratado por horas';
  }else{
      var servicios = 'No es un servicio por horas';
  }
    if(dir=='' || dirnum2=='' || dirnum3=='' || nombre == '' || tel == ''){
        indicador = false;
    }
    if(!document.formuno.nomenclatura[0].checked && !document.formuno.nomenclatura[1].checked){
        indicador = false;
        messageError+='No ha indicado Tipo de Nomenclatura<br />';
    }
//   if(barrio==0){
//       messageError+='No ha indicado barrio<br />';
//   }
   if(dir=='' || dirnum2=='' || dirnum3==''){
       messageError+='No ha indicado direcci&oacute;n<br />';
   }
   if(nombre==''){
       messageError+='No ha indicado Nombre<br />';
   }
   if(tel==''){
       messageError+='No ha indicado Tel&eacute;fono<br />';
   }
    
    if(email==''){
        indicador=false;
         messageError+='Escriba una direcci&oacute;n de correo electr&oacute;nico<br />';
    }else{
         if(validarEmail(email)){
             $('#mensajeerroremail').fadeOut();
         }else{
           $('#mensajeerroremail').fadeIn();
            indicador = false;
         }
    }
        
    if(!indicador){
        $('#mensajeerror').html(messageError);
        $('#mensajeerror').fadeIn();
    }else{
        $('#mensajeerror').fadeOut();
        $.post('controllers/tutaxiya.php', { nombre: nombre, email: email, tel: tel, dir: direccioncompleta, serv: servicios, ntaxis: ntaxis, nomenclatura: nomenclatura } , function(datos) {
           document.getElementById('mensajerecibido').innerHTML=datos;
                $('#okmesagge').click();
            //alert(datos);
            setTimeout(function(){reloadPage(window.location.href='index.php?base&seccion=pedir-taxi');},5000);
                //document.getElementById('mensaje').innerHTML=datos;
                //$('#boton-contacto').click();
            });  
       
    }
});

});


function validarEmail(valor) {
  if (/^[0-9a-z_\-\.]+@[0-9a-z\-\.]+\.[a-z]{2,4}$/i.test(valor)){
      return true;
  } else {
      return false;
  }
}
</script>
</body>
</html>

<div id="mensaje-enviado" class="login-popup">
 <a href="#" class="close"><img src="imagenes/cerrar.png" class="btn_close" /></a>
<h1 id="mensajerecibido" >"Su servicio está en proceso en breve nos comunicaremos con usted"</h1>
  <img src="imagenes/logotipo-internas.jpg" />
</div>