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
$perfil = array('name' => 'perfil', 'type' => 'hidden', 'value' => 'gerente');
$descripcion = array('name' => 'descripcion');

$pass = array('name' => 'pass', 'placeholder' => 'introduce tu password');
$submit = array('name' => 'submit', 'value' => 'crear', 'id' => 'crear_tick', 'title' => 'Crear');




// center cost
$cost_name = array('name' => 'cost_name', 'placeholder' => 'nombre centro de costo');
$cost_pref = array('name' => 'cost_pref', 'placeholder' => 'prefijo');
$cost_last = array('name' => 'cost_last', 'placeholder' => 'rango');
$cost_budg = array('name' => 'cost_budg', 'placeholder' => 'presupuesto');
$cost_avail = array('name' => 'cost_avail', 'placeholder' => 'presupuesto');



?>
<div class="container_12">
    <div class="menu">
        <h3>Menu</h3>
        <ul>
            <li id="men1">Crear gerene</li>
            <li id="men3">Crear centro de costo</li>

            <!-- <li id="men3">Crear Ticket</li> -->
        </ul>
    </div>
    <div class="grid_12">
        <div class="header">
            <h1 style="text-align: center">Bienvenido de nuevo <?= $this->session->userdata('perfil') ?></h1>
            <a href="<?php echo base_url(); ?>login/logout_ci" class="cerrar">Cerrar sesión</a>
        </div>


        <div class="cont-serv">
            <h2 id="ancla1">Crear nuevo gerente</h2>
            <?= form_open(base_url() . 'cliente/crear_user') ?>

            <label for="usuario">Usuario:</label>
            <?= form_input($usuario) ?><p><?= form_error('usuario') ?>
            <?= form_input($perfil) ?><p><?= form_error('usuario') ?>

                <label for="pass">Contraseña:</label>
            <?= form_input($pass) ?><p><?= form_error('pass') ?>

                <label for="descripcion">Descripcion:</label>
            <?= form_input($descripcion) ?><p><?= form_error('descripcion') ?>
                <input type="hidden" name="id_cliente" value="<?= $this->session->userdata('id_usuario') ?>">
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
            <h2 id="ancla3">Crear centro de costo</h2>

            <div class="men_prefi"></div>

            <?= form_open(base_url() . 'cliente/crear_cost_center') ?>
            <label for="descripcion">Nombre centro costo:</label>
            <?= form_input($cost_name) ?><p><?= form_error('cost_name') ?>
            <label for="ticket">Prefijo:</label>
            <input type="text" id="ticket" name="ticket[]"  onkeyup="validar_pre()" placeholder="prefijo" maxlength="2"><br>

            <label for="descripcion">Rango:</label>
            <?= form_input($cost_last) ?><p><?= form_error('cost_last') ?>
            <label for="descripcion">Presupuesto:</label>
            <?= form_input($cost_budg) ?><p><?= form_error('cost_budg') ?>
            <label for="descripcion">Disponible:</label>
            <?= form_input($cost_avail) ?><p><?= form_error('cost_avail') ?>

            <input type="hidden" name="id_cliente" value="<?= $this->session->userdata('id_usuario') ?>">

            <div class="cont-tick">
            </div>

            <input type="submit" name="submit" value="crear" id="crear_cost_center" title="Crear">
            <?= form_close() ?>


            <table>

                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Prefijo</th>
                    <th>Último</th>
                    <th>Presupuesto</th>
                    <th>Disponible</th>

                <tr>

                    <?php

                    foreach ($costs as $cc) {
                        echo "<tr>";
                        echo "<td>" . $cc->id . "</td>";
                        echo "<td>" . $cc->name . "</td>";
                        echo "<td>" . $cc->prefix . "</td>";
                        echo "<td>" . $cc->last_range . "</td>";
                        echo "<td>" . $cc->budget_total . "</td>";
                        echo "<td>" . $cc->budget_available . "</td>";
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
                    } else 
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
