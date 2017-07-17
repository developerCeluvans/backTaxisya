<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/960.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/text.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/reset.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css" media="screen"/>
    -->

<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body>

<div class="container_12">
	<div>
        <div class="header">
            <h1 style="text-align: center">Bienvenido de nuevo <?= $this->session->userdata('role') ?></h1>
            <a href="<?php echo base_url(); ?>login/logout_ci" class="cerrar">Cerrar sesión</a>
        </div>
	    <div class="menu">
        <h3>Menu</h3>
        <ul>
            <li id="men1">Crear cliente</li>
            <li id="men1"><a href='<?php echo site_url('tickets/companies_management')?>'>Empresas</a> </li> 
            <li id="men1"><a href='<?php echo site_url('tickets/users_management')?>'>Usuarios Empresas</a></li>


        </ul>
        </div>
		 
		<a href='<?php echo site_url('tickets/companies_management')?>'>Empresas</a> | 
		<a href='<?php echo site_url('tickets/users_management')?>'>Usuarios Empresas</a> | 
		
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>

</div>
</body>
</html>
