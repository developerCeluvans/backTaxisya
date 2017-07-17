<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/jquery-ui-1.11.4/jquery-ui.css'); ?>" />
    <?php
    foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>"/>
    <?php endforeach; ?>
    <?php foreach ($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>

    <script src="<?php echo base_url('assets/jquery-ui-1.11.4/jquery-ui.js'); ?>"></script>
</head>

<?php $this->load->view('page_header'); ?>
<body>

<div class="blog">

<?php

$tot_tickets = array('name' => 'tot_tickets', 'placeholder' => '');
$tot_hours = array('name' => 'tot_hours', 'placeholder' => '');
$tot_commit = array('name' => 'tot_commit', 'placeholder' => '');

$cost_id = array('name' => 'cost_id');

?>
    <div id="blog_text">
        <?php echo $output; ?>

            <?= form_open(base_url() . 'managers/crear_ticket') ?>
        <div id="create_find">

        <div style="margin-top: 12px; text-align: center; font-size: 23px;">
            <label for="inicial">Selecciona cantidad, horas vigencia y observación para crear el vale:</label>
        </div>

        <div>
            <input type="hidden" name="cliente_id" value="<?php echo $this->session->userdata('id_cliente'); ?>">
            <div class="cont-tick" style ="margin-top: 10px;">
                <label for="usuario">Cantidad:</label><?= form_input($tot_tickets) ?> <?= form_error('tot_tickets') ?>
            </div>
            <div class="cont-tick" style ="margin-top: 5px;">
                <label for="usuario">Horas de vigencia:</label><?= form_input($tot_hours) ?> <?= form_error('tot_hours') ?>
            </div>
            <div class="cont-tick" style ="margin-top: 5px;">
                <label for="usuario" required="required">Dependencia:</label><?= form_input($tot_commit) ?> <?= form_error('tot_commit') ?>
                <input type="submit" name="submit" value="crear" id="crear_tickt" title="Crear" class="btn btn-mini">
            </div>

            <?= form_close() ?>
        </div>

        <div style="margin-top: 12px; text-align: center; font-size: 23px;">
            <label for="inicial">Selecciona fecha inicial y fecha final para filtrar:</label>
        </div>

        <div style ="margin-top: 10px;">
            <?= form_open(base_url() . 'managers/crear_ticket') ?>
            <label for="inicial">Fecha inicial:</label>
            <?php $attributes = 'id="inicial" placeholder="fecha inicial"';
            echo form_input('inicial', set_value('inicial'), $attributes); ?>
            <label for="inicial"></label>
        </div>

        <div style ="margin-top: 5px;">
            <label for="final">Fecha final:</label>
            <?php $attributes = 'id="final" placeholder="fecha final"';
            echo form_input('final', set_value('final'), $attributes); ?>
            <label for="final"></label>

            <input id="form-button-save" type="submit" value="Filtrar" class="btn btn-mini"></input>
            <?= form_close() ?>
        </div>

        </div>
    </div>
</div>

<div id="sidebar" class="sidebar">
    <!--Sidebar-->
    <div class="sidebar-page">
        <span class="sidebar-title">Acciones</span>

        <div class="feature-menu">
            <ul>

                <li id="men1"><a href='<?php echo site_url('managers/users_manager_management') ?>'>Usuarios reportes</a></li>
                <li id="men1"><a href='<?php echo site_url('managers/tickets_management') ?>'>Generar vales</a></li>
                <li id="men1"><a href='<?php echo site_url('managers/service_management') ?>'>Servicios</a></li>
            </ul>
        </div>
    </div>
    <!--/Sidebar-->
</div>


</div>
<script type="text/javascript">
    $(function() {
        $("#inicial").datepicker();
    });
    $(function() {

        $("#final").datepicker();
    });
</script>
</body>
<?php $this->load->view('page_footer'); ?>
</html>
