<?php

  $cone=mysql_connect("localhost","root","imaginamos2015");
  mysql_select_db("appsuser_taxisya_de");

  if($_POST['proc']=='registrar_agenda'){
      
    foreach($_POST as $nombre_campo => $valor){ 
      $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
      eval($asignacion); 
    }
    
    //  Validar registro del usuario
    
    $cons="select id from users where email='$mail'";
    $resu=mysql_query($cons);
    $tota=mysql_num_rows($resu);
    
    if($tota>0){
      
      while($row=mysql_fetch_row($resu)){
        $id_user=$row[0];
      }
      
    }else{
      
      echo "
        <script>
          alert('El usuario no se encuentra registrado, por favor registrarse !');
          window.location='index.php';
        </script>
      ";
      
      die();
      
    }
    
    //  Registrar agendamiento
    
    $cons="select max(id)+1 from schedules";
    $resu=mysql_query($cons);
    while($row=mysql_fetch_row($resu)){
      $id_agenda=$row[0];
    }
    
    $fecha=$cuando.':'.$hora;
    
    $cons="SET FOREIGN_KEY_CHECKS=0";
    mysql_query($cons);
    
    $cons="insert into schedules values ('$id_agenda','$id_user',NULL,'$fecha','$tipo_agen','','','','$telefono','','','$fin',now(),'0000-00-00 00:00:00','1','0','','$inicio','','')";
    mysql_query($cons,$cone);
    
    // echo $cons;
    
    // die();
    
    echo "
      <script>
        alert('Se registro el agendamiento correctamente !');
        window.location='index.php';
      </script>
    ";
    
    die();
    
  }


/**
 * @package Helix Framework
 * Template Name - Shaper Helix
 * Template Version 1.0.3
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2013 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');   

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"  lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"  lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"  lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $this->language; ?>"> <!--<![endif]-->
    <head>
        
        <link rel="stylesheet" type="text/css" href="http://www.taxisya.co/taxisya/css/main.css">	
        <link rel="stylesheet" type="text/css" href="http://www.taxisya.co/taxisya/css/bootstrap.min.css">	
        
        <link href="http://www.taxisya.co/taxisya/libraries/jquery.bxslider.css" rel="stylesheet" />
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
        
        <script type="text/javascript">
          $(document).ready(function() {
            <?php
            
              $para="";
            
              if(trim($_POST['pais'])){
                $pais=$_POST['pais'];
              }else{
                $pais="";
              }
              
              if(trim($_POST['departamento'])){
                $departamento=$_POST['departamento'];
              }else{
                $departamento="";
              }
              
              if(trim($_POST['ciudad'])){
                $ciudad=$_POST['ciudad'];
              }else{
                $ciudad="";
              }
              
              if($pais)
                $para.="pais=".$pais;
              
              if($departamento)
                $para.="&departamento=".$departamento;
              
              if($ciudad && $departamento)
                $para.="&ciudad=".$ciudad;
              
            ?>
            
            $("#formulario_contactenos").load('http://www.taxisya.co/templates/citycab/contactenos.php?<?php echo $para; ?>');
            
            $("#form_ubicacion").load('http://www.taxisya.co/procesos/form_ubicacion/index.php');
            
          });
        </script>
        
        <jdoc:include type="head" />
        <?php
            $this->helix->Header()
            ->setLessVariables(array(
                    'preset'=>$this->helix->Preset(),
                    'header_color'=> $this->helix->PresetParam('_header'),
                    'bg_color'=> $this->helix->PresetParam('_bg'),
                    'text_color'=> $this->helix->PresetParam('_text'),
                    'link_color'=> $this->helix->PresetParam('_link'),
                ))
            ->addCSS('uikit.almost-flat.css')
            ->addCSS('effects.css')
            ->addCSS('glass.css')
            ->addLess('master', 'template')
            ->addLess( 'presets',  'presets/'.$this->helix->Preset() )
            ->addJS('uikit.min.js')
            ->addJS('template.js');
        ?>
        
        <script type="text/javascript">
          $(document).ready(function(){
            $('a[href^="#"]').on('click',function (e) {
                e.preventDefault();

                var target = this.hash;
                var $target = $(target);

                $('html, body').stop().animate({
                    'scrollTop': $target.offset().top
                }, 900, 'swing', function () {
                    window.location.hash = target;
                });
            });
          });
          
          
          $(document).ready(function(){

            // Begin This is the Bar by Gtr - (Accordion) sin Plugins 

              $('.cont-a').hide();
              $("#accordion h3").click(function(){
                $(this).next().slideToggle("fast").siblings(".cont-a").slideUp("fast");
              });

              // End the Bar (Accordion)

          });
            
        </script>      
        
    </head>
    <body <?php echo $this->helix->bodyClass('bg hfeed clearfix'); ?>>
		<div class="body-innerwrapper">
        <!--[if lt IE 8]>
        <div class="chromeframe alert alert-danger" style="text-align:center">You are using an <strong>outdated</strong> browser. Please <a target="_blank" href="http://browsehappy.com/">upgrade your browser</a> or <a target="_blank" href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</div>
        <![endif]-->
        <?php
            $this->helix->layout();
            $this->helix->Footer();
        ?>
        <jdoc:include type="modules" name="debug" />
		</div>
    </body>
</html>