<?php

/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/

require("PHPMailer/class.phpmailer.php");

	   	
	$mail2 = new PHPMailer();
	$mail2->IsSMTP();
	$mail2->SMTPAuth = true;
	$mail2->SMTPSecure = "ssl";
	$mail2->Host = "smtp.gmail.com";
	$mail2->Port = 465;
	$mail2->Username = "pruebasimaginamos@gmail.com";
	$mail2->Password = "123Usuario2011";
	
	
	$mail2->From = "pruebasimaginamos@gmail.com"; 
    $mail2->FromName = "Andemos";
    $mail2->Subject = 'Notificacion de Registro Andemos';
	$mail2->AddAddress('jackelinortega@gmail.com');   
    
    
	$body .="<h2>DATOS DE REGISTRO EN ANDEMOS: </h2>";
	$body .="Nombre : "; 
	$body .="".$nombre."<br />";
	$body .="Apellido : "; 
	$body .="".$apellido."<br />";
	$body .="Correo Electronico : ";   
	$body .="".$correo."<br />";
	$body .="Empresa : "; 
	$body .="".$empresa."<br />";
	$body .="NIT : ";   
	$body .="".$nit."<br />";
	$body .="Celular : "; 
	$body .="".$celular."<br />";
	$body .="Dirección : "; 
	$body .="".$direccion."<br />";
	    
	$mail2->Body = $body;
    $mail2->IsHTML(true);
    $mail2->Send();
	
	exit();  
?>