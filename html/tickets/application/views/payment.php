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
    <?= form_open(base_url() . 'payment/users_admin_management') ?>

    <input type="hidden" name="cliente_id" value="<?php echo $this->session->userdata('id_cliente'); ?>">
    <div>
    </div>

    <?= form_close() ?>

    <div id="create_find">

        <div style="margin-top: 12px; text-align: center; font-size: 23px;">
            <input type="hidden" name="cliente_id" value="<?php echo $this->session->userdata('id_cliente'); ?>">

            <li id="men1"><a href='<?php echo site_url('payment/sumar_tickets')?>'>Totalidad vales pagados:</a> </li>

        </div>
        <div>
        </div>
    </div>
</div>


<div id="sidebar" class="sidebar">
    <!--Sidebar-->
    <div class="sidebar-page">
        <span class="sidebar-title">Servicios</span>

        <div class="feature-menu">
            <ul>
                <li id="men1"><a href='<?php echo site_url('payment/tickets_management')?>'>Centros de pagos</a> </li>
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

