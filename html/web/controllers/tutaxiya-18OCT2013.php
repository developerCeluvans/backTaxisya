<?php
require("class.phpmailer.php");
foreach ($_POST as $key => $value)
    {
            $arrinputs[$key] = $value;
            $$key = $value;	
    }
 /*$emaildestino = 'miriam.nino@hotmail.com'; */
 $emaildestino = 'taxisya2013@gmail.com'; 
 
 $mensaje='
     <p>Estimado Usuario: '.$nombre.'</p><br />
    <p>Su servicio ha sido procesado pronto nos comunicaremos con ud. </p>

    <p>Datos de Usuario: </p>
    <p>Teléfono: '.$tel.' </p>
    <p>Email: '.$email.' </p><br />
    <p>'.$serv.'</p>    
    <p>Número de servicios solicitados: '.$ntaxis.'</p>    
    
<p>Dirección: 
<h3>Nomenclatura: '.$nomenclatura.'</h3><br />
<h2>'.$dir.'</h2>
</p>


';
 $message =
'
<head>
<!-- If you delete this tag, the sky will fall on your head -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ZURBemails</title>
	
<link rel="stylesheet" type="text/css" href="'.$_SERVER['SERVER_NAME'].'/HF/taxisya_prog/controllers/stylesheets/email.css" />

</head>
<body bgcolor="#FFFFFF">
<link rel="stylesheet" type="text/css" href="'.$_SERVER['SERVER_NAME'].'/HF/taxisya_prog/controllers/stylesheets/email.css" />
<table class="body-wrap">
<tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">

                <div class="content">
                <table>
                        <tr>
                                <td>

                                        <h3>TaxisYa.com.co</h3>
                                        <p class="lead">Gracias por utilizar los servicios de TaxisYa.com.co</p>

                                        <!-- A Real Hero (and a real human being) -->
                                        <p><img src="'.$_SERVER['SERVER_NAME'].'/HF/taxisya_prog/imagenes/logotipo.png" width="600" /></p><!-- /hero -->

                                        <!-- Callout Panel -->
                                        <p class="callout">
                                                Puedes encontrar más sobre TaxisYa en nuestro sitio web oficial. <a href="'.$_SERVER['SERVER_NAME'].'/HF/taxisya_prog/">Visítanos!!</a>
                                        </p><!-- /Callout Panel -->

                                        <h3>Servicio Procesado <small></small></h3>
                                        '.$mensaje.'
                                       

                                        <br/>
                                        <br/>							

                                        <!-- social & contact -->
                                        <table class="social" width="100%">
                                                <tr>
                                                        <td>

                                                                <!--- column 1 -->
                                                                <table align="left" class="column">
                                                                        <tr>
                                                                                <td>				

                                                                                        <h5 class="">Connect with Us:</h5>
                                                                                        <p class=""><a href="#" class="soc-btn fb">Facebook</a> <a href="#" class="soc-btn tw">Twitter</a> <a href="#" class="soc-btn gp">Google+</a></p>


                                                                                </td>
                                                                        </tr>
                                                                </table><!-- /column 1 -->	

                                                                <!--- column 2 -->
                                                                <table align="left" class="column">
                                                                        <tr>
                                                                                <td>				

                                                                                        <h5 class="">Contact Info:</h5>												
                                                                                        <p>Phone: <strong>2 000 000</strong><br/>
                                                                                        Email: <strong><a href="emailto:"></a></strong></p>

                                                                                </td>
                                                                        </tr>
                                                                </table><!-- /column 2 -->

                                                                <span class="clear"></span>	

                                                        </td>
                                                </tr>
                                        </table><!-- /social & contact -->


                                </td>
                        </tr>
                </table>
                </div>

        </td>
        <td></td>
</tr>
</table><!-- /BODY -->

</body>

';
 
  $mail = new PHPMailer();
$mail->Host = "localhost";
$mail->From = "info@taxisya.com";
$mail->FromName = "Contacto";
$mail->Subject = 'Contacto desde sitio web';
$mail->AddAddress($emaildestino);
$mail->AddAddress($email);
$body = "<strong>Mensaje</strong><br><br>";
$body.= wordwrap($message, 70)."<br>";
$mail->Body = $body;
$mail->IsHTML(true);
$mail->Send(); 
if($mail->Send()){
    echo 'Su servicio está en proceso, en breve le informaremos el móvil que le atenderá, por favor revise su bandeja de entrada.';
}else{
    echo 'Su servicio no ha sido procesado, por favorIntentelo Nuevamente!.';
}
?>
