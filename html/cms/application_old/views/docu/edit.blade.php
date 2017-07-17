 <?php
  $driver_id=$items[0]->id;
?>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript">

  enviarImagen($('#img1'), $('#gradosImg1'),$('#fileImg1'));
  enviarImagen($('#img2'), $('#gradosImg2'),$('#fileImg2'));
  enviarImagen($('#img3'), $('#gradosImg3'),$('#fileImg3'));
  enviarImagen($('#img4'), $('#gradosImg4'),$('#fileImg4'));
  enviarImagen($('#img5'), $('#gradosImg5'),$('#fileImg5'));

  var enviarForm = function (){
      console.log(document.getElementById('calificar').src);
      console.log(document.getElementById('aprobado').checked);
      console.log(document.getElementById('rechazado').checked);
      //console.log(document.getElementById('eliminado').checked);
      console.log(document.getElementById('pendiente').checked);
      console.log(<?php echo $driver_id; ?>);

      if(confirm('Esta seguro de actualizar el estado de la información ?')==true){document.getElementById('calificar').src='http://taxisya.co/cms/application/views/docu/calificar.php?a='+document.getElementById('aprobado').checked+'&r='+document.getElementById('rechazado').checked+'&e='+document.getElementById('eliminado').checked+'&p='+document.getElementById('pendiente').checked+'&i=<?php echo $driver_id; ?>';};

    };
  
</script>

<div class="row-fluid">
    <div style="text-align:left;width:22%;">
        
        <div class="profileSetting" >
            <div class="avartar" id="avatar">
			   	     <!--
              < ? php echo '../../'.$items[0]->picture;  javaScript:rotar($('#img1'),45);  http://taxisya.co/cms/public/img/drivers/976.jpg?>
            -->
                <img src="<?php echo '../../'.$items[0]->picture;  ?>" width="180" height="180" alt="avatar" id="img1" />
                <input type="button" onclick="javaScript:rotar($('#img1'),0,$('#gradosImg1'));"  value="0°"></input>
                <input type="button" onclick="javaScript:rotar($('#img1'),90,$('#gradosImg1'));"  value="90°"></input>   
                <input type="button" onclick="javaScript:rotar($('#img1'),180,$('#gradosImg1'));"  value="180°"></input>
                <input type="button" onclick="javaScript:rotar($('#img1'),270,$('#gradosImg1'));"  value="270°"></input>
                <input type="file" id="fileImg1"/>
                <input type="button" onclick="javaScript:enviarImagen($('#img1'), $('#gradosImg1'),$('#fileImg1'));"  value="Guardar"></input>
                <input type="hidden" value="0" id="gradosImg1"></input>
			       </div>

        </div>
        <hr/>
    </div>

    <div class="span4" style="width:45%!important;">

        <div class="section ">
            <label> Nombre<small> de conductor</small></label>
            <div>
                <input type="text" class="validate[required] large" value="<?php echo $items[0]->name.' '.$items[0]->lastname; ?>" name="name" id="name">
            </div>
        </div>

        <div class="section ">
            <label> Cédula</small></label>
            <div>
                <input type="text" class="validate[required] large" value="<?php echo $items[0]->cedula; ?>" name="name" id="name">
            </div>
        </div>

        <div class="section ">
            <label> Correo</label>
            <div>
                <input type="text" class="validate[required] large" value="<?php echo $items[0]->email; ?>" name="name" id="name">
            </div>
        </div>

        <div class="section ">
            <label> Celular</label>
            <div>
                <input type="text" class="validate[required] large" value="<?php echo $items[0]->cellphone; ?>" name="name" id="name">
            </div>
        </div>

        <div class="section ">
            <label> Direccion</label>
            <div>
                <input type="text" class="validate[required] large" value="<?php echo $items[0]->dir; ?>" name="name" id="name">
            </div>
        </div>

        <div class="section ">
            <label> Licencia</label>
            <div>
                <input type="text" class="validate[required] large" value="<?php echo $items[0]->license; ?>" name="name" id="name">
            </div>
        </div>

        <!--------------------------  Agregar vehiculo al conductor  ------------------------------------->

        <?php
          $driver_id=$items[0]->id;
        ?>

        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

        <script type="text/javascript">
          $(document).ready(function() {
            $("#detalle_vehiculo").load('http://www.taxisya.co/cms/application/views/docu/detalle_vehiculo.php?id=<?php echo $driver_id; ?>');
          });
        </script>

        <p>&nbsp;</p><p>&nbsp;</p>
        <p>&nbsp;</p><p>&nbsp;</p>
        
        <div id="detalle_vehiculo">
        </div>


        <!------------------------------------------------------------------------------------------------>


    </div>
    
    <div class="span4">

        <div class="section ">
           <label> Documento</label>
           <div>
            <!-- <a href="<?php echo '../../'.$items[0]->documento1; ?>" target="_blacnk"> -->
                <img src="<?php echo '../../'.$items[0]->documento1; ?>" width="200" id="img2">
                <br/>
                <input type="button" onclick="javaScript:rotar($('#img2'),0,$('#gradosImg2'));"  value="0°"></input>
                <input type="button" onclick="javaScript:rotar($('#img2'),90,$('#gradosImg2'));"  value="90°"></input>   
                <input type="button" onclick="javaScript:rotar($('#img2'),180,$('#gradosImg2'));"  value="180°"></input>
                <input type="button" onclick="javaScript:rotar($('#img2'),270,$('#gradosImg2'));"  value="270°"></input>
                <br/>
                <input type="file" id="fileImg2"/>
                <input type="button" onclick="javaScript:enviarImagen($('#img2'), $('#gradosImg2'),$('#fileImg2'));"  value="Guardar"></input>
                <input type="hidden" value="0" id="gradosImg2"></input>
             <!--</a>-->
           </div>
    </div>
    <p>&nbsp;</p>
		<div class="section ">
            <label> Licencia</label>
            <div>
             <!--<a href="<?php echo '../../'.$items[0]->documento2; ?>" target="_blacnk">-->
                <img src="<?php echo '../../'.$items[0]->documento2; ?>" width="200" id="img3">
                <br/>
                <input type="button" onclick="javaScript:rotar($('#img3'),0,$('#gradosImg3'));"  value="0°"></input>
                <input type="button" onclick="javaScript:rotar($('#img3'),90,$('#gradosImg3'));"  value="90°"></input>   
                <input type="button" onclick="javaScript:rotar($('#img3'),180,$('#gradosImg3'));"  value="180°"></input>
                <input type="button" onclick="javaScript:rotar($('#img3'),270,$('#gradosImg3'));"  value="270°"></input>
                <br/>
                <input type="file" id="fileImg3"/>
                <input type="button" onclick="javaScript:enviarImagen($('#img3'), $('#gradosImg3'),$('#fileImg3'));"  value="Guardar"></input>
                <input type="hidden" value="0" id="gradosImg3"></input>
             <!--</a>-->
           </div>
           
           <p>&nbsp;</p><p>&nbsp;</p>
           
           <div class="span4">
		
		<div class="section ">
           <label> T.Propiedad</label>
          <div>
             <!--<a href="<?php echo '../../'.$items[0]->documento3; ?>" target="_blacnk"> -->
                <img src="<?php echo '../../'.$items[0]->documento3; ?>" width="200" id="img4">
                <br/>
                <input type="button" onclick="javaScript:rotar($('#img4'),0,$('#gradosImg4'));"  value="0°"></input>
                <input type="button" onclick="javaScript:rotar($('#img4'),90,$('#gradosImg4'));"  value="90°"></input>   
                <input type="button" onclick="javaScript:rotar($('#img4'),180,$('#gradosImg4'));"  value="180°"></input>
                <input type="button" onclick="javaScript:rotar($('#img4'),270,$('#gradosImg4'));"  value="270°"></input>
                <br/>
                <input type="file" id="fileImg4"/>
                <input type="button" onclick="javaScript:enviarImagen($('#img4'), $('#gradosImg4'),$('#fileImg4'));"  value="Guardar"></input>
                <input type="hidden" value="0" id="gradosImg4"></input>
             <!--</a>-->
             </a>
           </div>
        </div>

        <p>&nbsp;</p>
        
        <div class="section ">
           <label> T.Operación</label>
          <div>
             <!--<a href="<?php echo '../../'.$items[0]->documento4; ?>" target="_blacnk">-->
                <img src="<?php echo '../../'.$items[0]->documento4; ?>" width="200" id="img5">
                <br/>
                <input type="button" onclick="javaScript:rotar($('#img5'),0,$('#gradosImg5'));"  value="0°"></input>
                <input type="button" onclick="javaScript:rotar($('#img5'),90,$('#gradosImg5'));"  value="90°"></input>   
                <input type="button" onclick="javaScript:rotar($('#img5'),180,$('#gradosImg5'));"  value="180°"></input>
                <input type="button" onclick="javaScript:rotar($('#img5'),270,$('#gradosImg5'));"  value="270°"></input>
                <br/>
                <input type="file" id="fileImg5"/>
                <input type="button" onclick="javaScript:enviarImagen($('#img5'), $('#gradosImg5'),$('#fileImg5'));"  value="Guardar"></input>
                <input type="hidden" value="0" id="gradosImg5"></input>
             <!--</a>-->
             </a>
           </div>
        </div>

    </div>
    </div>
    
    


    </div>
    
    
	
</div>

<div class="row-fluid">
    
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    
    <h3><b>Validar Informaci&oacute;n:</b></h3>
    
    <p>&nbsp;</p>
    
    <?php
    
      if($items[0]->token!='NULL')
        $resultado="En la App";
      else
        $resultado="En la página web";
    
    ?>
    
    <strong>Registrado en: </strong><?php echo  $resultado; ?>
    
    <p>&nbsp;</p>
    
    <strong>Califique la información y los documentos del conductor:</strong>
    
    <p>&nbsp;</p>
    
    <form action="#" method="POST">
      <input type="radio" id='aprobado' name="calificar" value="aprobado" checked>Aprobado<br>
      <input type="radio" id='rechazado' name="calificar" value="rechazado">Rechazado<br>
      <input type="radio" id='pendiente' name="calificar" value="pendiente">Pendiente<br>
      
      <?php if($items[0]->token=='NULL'){?>
      <input type="radio" id='eliminado' name="calificar" value="eliminado">Eliminado
      <?php } ?>
        
        
      <p>&nbsp;</p>
      
      <?php 
        //echo $items[0]->token;
        if($items[0]->token=='NULL'){?>
        
        <input type='button' value='Enviar' onclick="if(confirm('Esta seguro de actualizar el estado de la información ?')==true){document.getElementById('calificar').src='http://taxisya.co/cms/application/views/docu/calificar.php?a='+document.getElementById('aprobado').checked+'&r='+document.getElementById('rechazado').checked+'&e='+document.getElementById('eliminado').checked+'&p='+document.getElementById('pendiente').checked+'&i=<?php echo $driver_id; ?>';};">
      <?php }else{ ?>
        <input type='button' value='Enviar' onclick="if(confirm('Esta seguro de actualizar el estado de la información ?')==true){document.getElementById('calificar').src='http://taxisya.co/cms/application/views/docu/calificar.php?a='+document.getElementById('aprobado').checked+'&r='+document.getElementById('rechazado').checked+'&p='+document.getElementById('pendiente').checked+'&i=<?php echo $driver_id; ?>';};">
      <?php } ?>
    </form>
    
    <iframe src='' frameborder='no' scrolling='no' id='calificar'>
    
  </div>


