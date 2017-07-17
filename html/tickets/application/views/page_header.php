<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>css/probe2.css" />
</head>
<body>

<div id="header">
    <div class="logo">
        <a href="<?php echo base_url(); ?>login/logout_ci" style="text-align: right; color: white" class="cerrar">Cerrar sesión</a>
        <!--        <img src="--><?php //echo base_url(); ?><!--images/logo.png" alt="Formget logo">-->
        <h2 style="text-align: center; color: white">Bienvenido de nuevo <?= $this->session->userdata('name') ?></h2>
    </div>

</div>