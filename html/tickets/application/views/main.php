<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    </div>
</div>

<div id="sidebar" class="sidebar">
    <!--Sidebar-->
    <div class="sidebar-page">
        <span class="sidebar-title">Acciones</span>

        <div class="feature-menu">
            <ul>

                <li id="men1"><a href='<?php echo site_url('main/companies_management') ?>'>Empresas</a></li>
                <li id="men1"><a href='<?php echo site_url('main/users_management') ?>'>Usuarios Empresas</a></li>

            </ul>
        </div>
    </div>
    <!--/Sidebar-->
</div>

</div>
</body>
<?php $this->load->view('page_footer'); ?>
</html>
