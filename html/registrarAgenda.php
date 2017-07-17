<?php
		include ("conexion.php");
		$conex = Conectar();
		
		$fecha = $_GET["datepicker2"];	$fechaArray = explode("-",$fecha);	$fechaBD = $fechaArray[2]."-".$fechaArray[1]."-".$fechaArray[0]; 	$fechaEmail = str_replace("-","/",$fecha);
		$hora = $_GET["text9"];
		$origen = $_GET["text3"];
		$destino = $_GET["text4"];
		$telefono = $_GET["text10"];
		$hoy = date("d/m/Y h:m:s");

		mysql_query("INSERT INTO agenda_taxi (ageFecha, ageHora, ageOrigen, ageDestino, ageTelefono) VALUES ('$fechaBD','$hora','$origen','$destino','$telefono')",$conex);
		
		require("PHPMailer/class.phpmailer.php");
		
		$mail2 = new PHPMailer();
		$mail2->IsSMTP();
		$mail2->SMTPAuth = true;
		$mail2->SMTPSecure = "ssl";
		$mail2->Host = "smtp.gmail.com";
		$mail2->Port = 465;
		$mail2->Username = "taxisya.cms@gmail.com";
		$mail2->Password = "t4x1sy42015";
		
		
		$mail2->From = "notificaciones@taxisya.com.co"; 
		$mail2->FromName = "TAXISYA WEB";
		$mail2->Subject = 'Solicitud de Servicio de Taxi '.$hoy.' - No responder este mensaje';
		$mail2->AddAddress('jackelinortega@gmail.com');
		//$mail2->AddAddress('gustavo.romero@imaginamos.com.co');   
		
		$body .="<table><tr><td colspan='2'><span style='color:#393A40'>&nbsp;<br />&nbsp;<br />Estimado Usuario,<br />&nbsp;<br />";
		$body .="Le informamos de la <b> solicitud de un nuevo serivicio desde la web </b>, le recordamos dar confirmacion al cliente en la brevedad posible, los datos son los siguientes:<br />&nbsp;<br /></td></tr>";
		$body .="<tr><td width='100'><img width='80' height='80' src='http://104.237.131.48/taxisya/img/logo.png'></td>";
		$body .="<td style='font-size:14px; font-weight:bold;'>Fecha : ".$fechaEmail."<br />";
		$body .="Hora : ".$hora."<br />";
		$body .="Origen : ".$origen."<br />";
		$body .="Destino : ".$destino."<br />";
		$body .="Telefono : ".$telefono."<br /></td></tr>";
		$body .="<tr><td colspan='2'>&nbsp;<br />No responda este mensaje, ya que es generado desde la pagina web, que tenga un buen dia.</span></td></tr></table>";
		$body .="&nbsp; <br />&nbsp; <br />";	//<font size='1' color=''>
		
		
		$mail2->Body = $body;
		$mail2->IsHTML(true);
		$mail2->Send();
		?>
		<script>alert("Gracias por confiar en nosotros, hemos agendado tu servicio!"); document.location.href="http://104.237.131.48/index.php"; </script>
