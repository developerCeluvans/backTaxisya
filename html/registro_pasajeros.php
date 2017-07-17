<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Taxisya - Registro de Conductores</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">	
	<link href="libraries/jquery.bxslider.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="css/registro2.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libraries/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>
	<script>
	function cargarDiv(div,url)
	{
		  $(div).load(url);
	}

	function ConsultCedulaConduc()
	{
		var cedula = $("#cedula").val(), cadena = "cedula="+cedula;
			cargarDiv("#cedAjax","consultarCedConductor.php?"+cadena);		
	}
	</script>
</head>
<body>
<?php	include ("conexion.php");	$conex = ConectarCMS(); ?>
<div class="registro">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form action="registrarConductor.php" class="registro_taxistas" name="form" id="form" method="POST">
			        <div class="text-tag"> Nombre de conductor</div>   
			        <div> 
			            <input type="text" class="name" name="name" id="name">
			        </div>
			        <div class="text-tag"> Apellido de conductor</div>   
			        <div> 
			            <input type="text" class="lastname" name="lastname" id="lastname">
			        </div>
			        <div class="text-tag"> Usuario para entrar - Correo electrónico</div>
			        <div>
			            <input type="text" placeholder="example@dominio.com" name="login" id="login" class="login">
			        </div>
			        <div class="text-tag"> Contraseña de conductor</div>
			        <div>
			            <input type="password" placeholder="Contraseña" class="password" name="password" id="password">
			        </div>
					<div class="content-filter-input">
						<div class="text-tag">VEHICULO, Placa, Referencia</div>
                        <input type="text" class="vehiculo_exist" name="cars_id" id="cars_id">
					</div>
			        <div class="text-tag">CELULAR</div>   
			        <div> 
			            <input type="text" class="cellphone" name="cellphone" id="cellphone">
			        </div>
			        <div class="text-tag">TELÉFONO FIJO</div>   
			        <div> 
			            <input type="text" class="telephone" name="telephone" id="telephone">
			        </div>
			        <div class="text-tag">CÉDULA DE CONDUCTOR</div>   
			        <div> 
			            <input type="text" class="cedula" name="cedula" id="cedula" onkeyup="javascript:ConsultCedulaConduc();">
						<div id="cedAjax" name="cedAjax" align="center" style="color:#FFFFFF"></div>
			        </div>
			        <div class="text-tag">LICENCIA DE CONDUCCIÓN</div>   
			        <div> 
			            <input type="text" class="license" name="license" id="license">
			        </div>
			        <div class="text-tag">DIRECCION DE RESIDENCIA</div>   
			        <div> 
			            <input type="text" class="dir" name="dir" id="dir">
			        </div>
			            <input type="submit" class="enviar_registro" name="enviar_registro" id="enviar_registro" value="Enviar">
			        </div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php mysql_close($conex); ?>
</body>
</html>