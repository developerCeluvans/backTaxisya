<?php
		
		$fecha = $_GET["datepicker2"];	$fechaArray = explode("-",$fecha);	$fechaBD = $fechaArray[2]."-".$fechaArray[1]."-".$fechaArray[0]; 	$fechaEmail = str_replace("-","/",$fecha);
		echo "Nombre ".$nombre = "Jackeline Ortega";	$nombre = strtoupper($nombre); //$_POST["nombre"];
		echo " Mail ".$mail = "jackelinortega@gmail.com"; //$_POST["mail"];
		echo " Mensaje ".$message = "Hola soy el mensaje ".rand(0,259982); //$_POST["message"];
		
		require("PHPMailer/class.phpmailer.php");
		
		$mail2 = new PHPMailer();
		$mail2->IsSMTP();
		$mail2->SMTPAuth = true;
		$mail2->SMTPSecure = "ssl";
		$mail2->Host = "smtp.gmail.com";
		$mail2->Port = 465;
		$mail2->Username = "taxisya.cms@gmail.com";
		$mail2->Password = "t4x1sy42015";
		
		$mail2->From = $mail;
		$mail2->FromName = $nombre;
		$mail2->Subject = 'TAXISYA CONTACTO '.$hoy.' - No responder este mensaje';
		$mail2->AddAddress('jackelinortega@gmail.com');
		
		$body .="<img width='80' height='80' src='http://104.237.131.48/taxisya/img/logo.png'>";
		$body .="<span style='color:#393A40'>&nbsp;<br />&nbsp;<br />Estimado Usuario, le fue enviada la siguiente informacion del formulario de contacto de la web:<br />&nbsp;<br />";
		$body .=$message."<br />&nbsp;<br />";
		$body .="Att, ".$nombre."<br />".$mail;
		$body .="&nbsp;<br />&nbsp;<br />Para responder este mensaje haga click aqui ".$mail.". No responda este mensaje a traves del boton responder de su servicio de correo, ya que es generado desde la pagina web de manera automatica, que tenga un buen dia.</span>";
		
		$mail2->Body = $body;
		$mail2->IsHTML(true);
		$mail2->Send();
?>
<script>alert("Gracias por contactarnos, responderemos a tu inquietud en la brevedad posible!"); document.location.href="http://104.237.131.48/index.php"; </script>
