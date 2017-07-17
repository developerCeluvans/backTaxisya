<?php
require("PHPMailerAutoload.php");
foreach ($_POST as $key => $value)
    {
            $arrinputs[$key] = $value;
            $$key = $value;	
    }
 /*$emaildestino = 'miriam.nino@hotmail.com'; */
 $emaildestino = 'taxisya2013@gmail.com'; 
 
 $mensaje='
    Estimado Usuario: '.$nombre.'<br />
    Su servicio ha sido procesado pronto nos comunicaremos con ud.
    <p><h4>Datos de Usuario</h4></p>
    Teléfono: '.$tel.'<br />
    Email: '.$email.'<br />
    '.$serv.'<br />
    Número de servicios solicitados: '.$ntaxis.'<br />
<h3>Nomenclatura: '.$nomenclatura.'</h3><br />
<h2>'.$dir.'</h2>
';
 $message =
'
<head>
<!-- If you delete this tag, the sky will fall on your head -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ZURBemails</title>
	
<link rel="stylesheet" type="text/css" href="'.$_SERVER['SERVER_NAME'].'/controllers/stylesheets/email.css" />

</head>
<body bgcolor="#FFFFFF">
<link rel="stylesheet" type="text/css" href="'.$_SERVER['SERVER_NAME'].'/controllers/stylesheets/email.css" />
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
                                        <p><img src="'.$_SERVER['SERVER_NAME'].'/imagenes/logotipo.png" width="600" /></p><!-- /hero -->

                                        <!-- Callout Panel -->
                                        <p class="callout">
                                                Puedes encontrar más sobre TaxisYa en nuestro sitio web oficial. <a href="'.$_SERVER['SERVER_NAME'].'/taxisya_prog/">Visítanos!!</a>
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

/*//email a usuario
$mail = new PHPMailer();
$mail->Host = "localhost";
//$mail->From = "info@taxisya.com";
$mail->From = $emaildestino;
$mail->FromName = "Tu Taxisya";
$mail->Subject = 'Servicio desde sitio web';
$mail->AddAddress($email);
//$mail->AddAddress($email);
$body = "<strong>Mensaje</strong><br><br>";
$body.= wordwrap($message, 70)."<br>";
$mail->Body = $body;
$mail->IsHTML(true);
$mail->Send();

//email a operadora
$mail2 = new PHPMailer();
$mail2->Host = "localhost";
//$mail->From = "info@taxisya.com";
$mail2->From = $email;
$mail2->FromName = "Tu Taxisya";
$mail2->Subject = 'Servicio desde sitio web';
$mail2->AddAddress($emaildestino);
//$mail->AddAddress($email);
$body2 = "<strong>Mensaje</strong><br><br>";
$body2.= wordwrap($message, 70)."<br>";
$mail2->Body = $body2;
$mail2->IsHTML(true);
$mail2->Send();*/

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.taxisya.com.co';  // Specify main and backup server mail.taxisya.com.co  smtp.emailsrvr.com
$mail->Port = 587; 
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'reservas@taxisya.com.co';                            // SMTP username
$mail->Password = 'res2013hvw';                           // SMTP password
//$mail->SMTPSecure = 'secure.emailsrvr.com';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'reservas@taxisya.com.co';
$mail->FromName = 'Reservas Sitio Web';
$mail->addAddress('taxisya2013@gmail.com', 'Reservas');  // Add a recipient
$mail->addReplyTo($email);
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Reservas en linea';
$mail->Body    = $message;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}
else {
    echo '...Su servicio está en proceso, en breve le informaremos el móvil que le atenderá, por favor revise su bandeja de entrada...';
}

/*if($mail->Send()){
    echo 'Su servicio está en proceso, en breve le informaremos el móvil que le atenderá, por favor revise su bandeja de entrada.';
}else{
    echo 'Su servicio no ha sido procesado, por favorIntentelo Nuevamente!.';
}*/
?>
