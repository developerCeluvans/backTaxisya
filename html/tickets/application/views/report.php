<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/probe.css" media="screen"/>

    <?php
    foreach ($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>"/>
    <?php endforeach; ?>
    <?php foreach ($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
</head>


<?php $this->load->view('page_header'); ?>
<body>


<div class="blog">

    <div id="blog_text">
        <?php echo $output; ?>

        <?= form_open(base_url() . 'customers/users_admin_management') ?>
        <div id="presupuesto">
            <label for="usuario">Presupuesto:</label>
            <input type="text" name="presuspuesto" value="" readonly>
            <label for="usuario">Utilizado:</label> <input type="text" name="utilizado" value="" readonly>
            <label for="usuario">Restante:</label> <input type="text" name="restante" value="" readonly>
        </div>

        <input type="hidden" name="cliente_id" value="<?php echo $this->session->userdata('id_cliente'); ?>">
        <div>
            <label for="usuario">Selecciona la fecha inicial:</label>
            <input type="text" id="datepicker">

            <label for="">Selecciona la fecha final:</label>
            <input type="text" id="datepicker2">



        </div>

        <?= form_close() ?>
    </div>
</div>

<div id="sidebar" class="sidebar">
    <!--Sidebar-->
    <div class="sidebar-page">
        <span class="sidebar-title">Acciones</span>

        <div class="feature-menu">
            <ul>

                <li id="men1"><a href='<?php echo site_url('reports/service_management') ?>'>Servicios</a></li>

            </ul>
        </div>
    </div>
    <!--/Sidebar-->
</div>


</div>
</body>
<?php $this->load->view('page_footer'); ?>
</html>
