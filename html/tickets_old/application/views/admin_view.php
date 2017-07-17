<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/960.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/text.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/reset.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css" media="screen"/>
</head>
<body>
<?php
$usuario = array('name' => 'usuario', 'placeholder' => 'Correo electrónico');
$perfil = array('name' => 'perfil', 'type' => 'hidden', 'value' => 'cliente');


$company_name = array('name' => 'Nombre empresa');

$company_name = array('name' => 'company_name', 'placeholder' => '');
$company_nit = array('name' => 'company_nit', 'placeholder' => '');
$company_phone = array('name' => 'company_phone', 'placeholder' => '');
$company_address = array('name' => 'company_address', 'placeholder' => '');
$company_contract = array('name' => 'company_contract', 'placeholder' => '');
$contract_date = array('name' => 'contract_date', 'placeholder' => '');
$responsable = array('name' => 'responsable', 'placeholder' => '');
$cellphone = array('name' => 'cellphone', 'placeholder' => '');
$descripcion = array('name' => 'descripcion');
$pass = array('name' => 'pass', 'placeholder' => 'introduce tu password');

$submit = array('name' => 'submit', 'value' => 'crear', 'title' => 'Crear');
?>
<div class="container_12">
    <div class="menu">
        <h3>Menu</h3>
        <ul>
            <li id="men1">Crear cliente</li>

        </ul>
    </div>

    <div class="grid_12">
        <div class="header">
            <h1 style="text-align: center">Bienvenido de nuevo <?= $this->session->userdata('perfil') ?></h1>
            <a href="<?php echo base_url(); ?>login/logout_ci" class="cerrar">Cerrar sesión</a>
        </div>
        <h2 id="ancla1">Crear cliente</h2>

        <?= form_open(base_url() . 'admin/crear_user') ?>

        
        <label for="company_name">Nombre empresa:</label>
        <?= form_input($company_name) ?><p><?= form_error('company_name') ?>

            <label for="company_nit">NIT:</label>
        <?= form_input($company_nit) ?><p><?= form_error('company_nit') ?>

            <label for="company_phone">Télefono empresa:</label>
        <?= form_input($company_phone) ?><p><?= form_error('company_phone') ?>

            <label for="company_address">Dirección:</label>
        <?= form_input($company_address) ?><p><?= form_error('company_address') ?>

            <label for="company_contract">Contrato:</label>
        <?= form_input($company_contract) ?><p><?= form_error('company_contract') ?>

            <label for="contract_date">Fecha Contrato:</label>
        <?= form_input($contract_date) ?><p><?= form_error('contract_date') ?>

            <label for="descripcion">Descripción:</label>
        <?= form_input($descripcion) ?><p><?= form_error('descripcion') ?>

            <label for="responsable">Nombre responsable:</label>
        <?= form_input($responsable) ?><p><?= form_error('responsable') ?>

            <label for="cellphone">Celular responsable:</label>
        <?= form_input($cellphone) ?><p><?= form_error('cellphone') ?>

            <label for="usuario">Correo electrónico:</label>
        <?= form_input($usuario) ?><p><?= form_error('usuario') ?>
        <?= form_input($perfil) ?><p><?= form_error('usuario') ?>

            <label for="pass">Contraseña:</label>
        <?= form_input($pass) ?><p><?= form_error('pass') ?>

            <?= form_submit($submit) ?>
            <?= form_close() ?>
    </div>
    <table>

        <tr>
            <th>id</th>
            <th>Empresa</th>
            <th>Contrato</th>                        
            <th>Responsable</th>
            <th>Email</th>
            <th>Celular</th>            
            <th>Descripcion</th>
        <tr>

            <?php
            foreach ($users as $us) {
                echo "<tr>";
                echo "<td>" . $us->id . "</td>";
                echo "<td>" . $us->company_name . "</td>";
                echo "<td>" . $us->company_contract . "</td>";
                echo "<td>" . $us->responsable . "</td>";
                echo "<td>" . $us->username . "</td>";
                echo "<td>" . $us->cellphone . "</td>";
                echo "<td>" . $us->descripcion . "</td>";
                echo "</tr>";
            }
            ?>

    </table>
</div>
</body>
</html>
