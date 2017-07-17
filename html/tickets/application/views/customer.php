<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/jquery-ui-1.11.4/jquery-ui.css'); ?>" />
    <?php
    foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <?php foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <!--load jquery-->
    <!--script src="<?php echo base_url('assets/js/jquery-3.2.1.js'); ?>"></script-->
    <script src="<?php echo base_url('assets/jquery-ui-1.11.4/jquery-ui.js'); ?>"></script>

</head>
<?php $this->load->view('page_header'); ?>
<body>

<div class="blog">
    <div id="blog_text">
        <?php echo $output; ?>
    </div>
    <div id="presupuesto">
        <label for="usuario">Restante:</label> <input type="text" name="restante" value="<?php $this->load->view('budget'); ?>" readonly>
        <label for="usuario">Utilizado:</label> <input type="text" name="utilizado" value="" readonly>
        <label for="usuario">Restante:</label> <input type="text" name="restante" value="<?php $this->load->view('available'); ?>" readonly>
    </div>

    <?= form_open(base_url() . 'customers/users_admin_management') ?>

    <input type="hidden" name="cliente_id" value="<?php echo $this->session->userdata('id_cliente'); ?>">
    <div>
        <label for="inicial">Selecciona la fecha inicial:</label>
        <?php $attributes = 'id="inicial" placeholder="fecha inicial"';
        echo form_input('inicial', set_value('inicial'), $attributes); ?>
        <label for="inicial"></label>

        <label for="final">Selecciona la fecha final:</label>
        <?php $attributes = 'id="final" placeholder="fecha final"';
        echo form_input('final', set_value('final'), $attributes); ?>
        <label for="final"></label>

        <input id="form-button-save" type="submit" value="Filtrar" class="btn btn-mini"></input>
    </div>

    <?= form_close() ?>
</div>

<div id="sidebar" class="sidebar">
    <!--Sidebar-->
    <div class="sidebar-page">
        <span class="sidebar-title">Acciones</span>

        <div class="feature-menu">
            <ul>
                <li id="men1"><a href='<?php echo site_url('customers/cost_centers_admin_management')?>'>Centros de costo</a> </li>
                <li id="men1"><a href='<?php echo site_url('customers/users_admin_management')?>'>Gerentes</a></li>
                <li id="men1"><a href='<?php echo site_url('customers/service_management')?>'>Servicios</a></li>  <!--perfil4-->
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

