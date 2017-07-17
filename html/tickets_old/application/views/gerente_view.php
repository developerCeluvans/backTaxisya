<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/960.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/text.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/reset.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css" media="screen"/>
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
</head>
<body>
<?php
$direccion = array('name' => 'direccion', 'placeholder' => 'Direccion');
$comentario = array('name' => 'comentario');
$type = array('name' => 'type', 'type' => 'hidden', 'value' => '1');
$submit = array('name' => 'submit', 'value' => 'crear', 'title' => 'Crear');


$usuario = array('name' => 'usuario', 'placeholder' => 'nombre de usuario');
$perfil = array('name' => 'perfil', 'type' => 'hidden', 'value' => 'reporte');
$descripcion = array('name' => 'descripcion');

$pass = array('name' => 'pass', 'placeholder' => 'introduce tu password');
$submit = array('name' => 'submit', 'value' => 'crear', 'id' => 'crear_tick', 'title' => 'Crear');

$tot_tickets = array('name' => 'tot_tickets', 'placeholder' => '');

$cost_id = array('name' => 'cost_id');

?>
<div class="container_12">
    <div class="menu">
        <h3>Menu</h3>
        <ul>
            <li id="men1">Crear usuario reporte</li>
            <li id="men3">Crear Ticket</li>
        </ul>
    </div>
    <div class="grid_12">
        <div class="header">
            <h1 style="text-align: center">Bienvenido de nuevo <?= $this->session->userdata('perfil') ?></h1>
            <a href="<?php echo base_url(); ?>login/logout_ci" class="cerrar">Cerrar sesión</a>
        </div>


        <div class="cont-serv">
            <h2 id="ancla1">Crear usuario reporte</h2>
            <?= form_open(base_url() . 'cliente/crear_user') ?>

            <label for="usuario">Usuario:</label>
            <?= form_input($usuario) ?><p><?= form_error('usuario') ?>
            <?= form_input($perfil) ?><p><?= form_error('usuario') ?>

                <label for="pass">Contraseña:</label>
            <?= form_input($pass) ?><p><?= form_error('pass') ?>

                <label for="descripcion">Descripcion:</label>
            <?= form_input($descripcion) ?><p><?= form_error('descripcion') ?>
                <input type="hidden" name="id_cliente" value="<?= $this->session->userdata('id_cliente') ?>">
                <?= form_submit($submit) ?>
                <?= form_close() ?>

            <table>

                <tr>
                    <th>id</th>
                    <th>Usuario</th>
                    <th>Descripcion</th>
                <tr>

                    <?php
                    foreach ($users as $us) {
                        if ($us->perfil == "reporte") {
                            echo "<tr>";
                            echo "<td>" . $us->id . "</td>";
                            echo "<td>" . $us->username . "</td>";
                            echo "<td>" . $us->descripcion . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>

            </table>

            <br>
            <hr>


            </table>

            <br>
            <hr>
            <h2 id="ancla3">Crear Ticket</h2>
                <div class="men_prefi"></div>
             
                <?= form_open(base_url() . 'cliente/crear_ticket') ?>
                <input type="hidden" name="cliente_id" value="<?php echo $this->session->userdata('id_cliente'); ?>">

                <div class="cont-tick">
                </div>

                <label for="usuario">Centro de costo:</label>
                <?= form_dropdown('cost_id', $cost_centers,set_value('cost_id', $cost_id), 'id="cost_id"'); ?><p><?= form_error('cost_id') ?>


    
               <label for="usuario">Cantidad:</label>
               <?= form_input($tot_tickets) ?><p><?= form_error('tot_tickets') ?>

                <input type="submit" name="submit" value="crear" id="crear_tickt" title="Crear">
                <?= form_close() ?>


                <table>

                    <tr>
                        <th>id</th>
                        <th>ticket</th>
                        <th>Estado</th>
                    <tr>

                        <?php

                        foreach ($tickets as $tic) {
                            echo "<tr>";
                            echo "<td>" . $tic->id . "</td>";
                            echo "<td>" . $tic->ticket . "</td>";
                            if ($tic->status == 0) {
                                $estado = "Activo";
                            } else {
                                $estado = "Inactivo";
                            }
                            echo "<td>" . $estado . "</td>";
                            echo "</tr>";
                        }
                        ?>

                </table>
                <br>
                <hr>

        </div>
    </div>
</div>
<script>

    $("#men1").click(function () {
        $('html,body').animate({scrollTop: $("#ancla1").offset().top}, 2000);
    });

    $("#men2").click(function () {
        $('html,body').animate({scrollTop: $("#ancla2").offset().top}, 2000);
    });

    $("#men3").click(function () {
        $('html,body').animate({scrollTop: $("#ancla3").offset().top}, 2000);
    });


    function add_ticket() {
        var cont = '<label for="ticket">Prefijo Ticket:</label><input type="text" id="ticket" name="ticket[]"  onkeyup="validar_pre()" placeholder="Ticket" maxlength="2"><br>';
        $('.cont-tick').append(cont);
    }

    function validar_pre() {
        var ticket = $('#ticket').val();
        var cont = ticket.length;

        if (cont == 2) {
            console.log(ticket);

            $.ajax({
                url: "<?=base_url()?>cliente/buscar_ticket",
                data: {ticket: ticket},
                type: "POST",
                dataType: "json",
                success: function (data) {
                    if (data) {
                        alert(data);
                        $('#crear_tickt').prop('disabled', true);
                    } else {
                        $('#crear_tickt').removeAttr('disabled');
                    }

                    return data;
                }
            });

        }

    }
</script>
</body>
</html>
