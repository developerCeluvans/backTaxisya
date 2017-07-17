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
    </div>
</div>

<div id="sidebar" class="sidebar">
    <!--Sidebar-->
    <div class="sidebar-page">
        <span class="sidebar-title">Acciones</span>

        <div class="feature-menu">
            <ul>
                <li id="men1"><a href='<?php echo site_url('secretary/service_management') ?>'>Crear servicios</a></li>
                <li id="men1"><a href='<?php echo site_url('secretary/tickets_management') ?>'>Ver servicios</a></li>
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
