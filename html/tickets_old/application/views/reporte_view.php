<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/960.css" media="screen" />
		 <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/text.css" media="screen" />
		 <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/reset.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/style.css" media="screen" />
		 <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
	</head>
	<body>
		<div class="container_12">
			<div class="menu">
				<h3>Menu</h3>
				<ul>
					<li id="men1">Servicios</li>
					
				</ul>	
			</div>
			<div class="grid_12">
				<div class="header">
				<h1 style="text-align: center">Bienvenido de nuevo <?=$this->session->userdata('perfil')?></h1>
					<a href="<?php echo base_url(); ?>login/logout_ci" class="cerrar">Cerrar sesión</a>
				</div>
				
			<h2 id="ancla1">Servicios</h2>
				
			<table>
			
			<tr>
				<th>ID</th>
				<th>DIRECCION</th>
				<th>STATUS</th>
				<th>VALE</th>
				<th>ID USUARIO</th>
			<tr>
			
			<?php
			if(isset($servicios)){
			foreach($servicios as $ser){
				echo "<tr>";
				echo "<td>".$ser->id."</td>";
				echo "<td>".$ser->address."</td>";
				echo "<td>".$ser->status_id."</td>";
				echo "<td>".$ser->user_card_reference."</td>";
				echo "<td>".$ser->user_id."</td>";
				echo "</tr>";
			}
			}
			?>
			
			</table>
				
				
			</div>
		</div>	
	</body>
</html>
