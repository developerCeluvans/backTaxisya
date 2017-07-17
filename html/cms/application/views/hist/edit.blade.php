<div class="profileSetting" >
  <div class="avartar" id="avatar">
    <img src="<?php echo '../../'.$items[0]->picture; ?>" width="180" height="180" alt="avatar" />
  </div>
</div>

<p>&nbsp;</p>
<hr/>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div style="display:table;width:77%;">

  <div style="display:table-row;">
    
    <div style="display:table-cell;width:36%;">

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

    
    </div>
    
    <div style="display:table-cell;width:75%;">
    
      <div style='display:table;width:100%;'>
      
        <div style='display:table-row;'>
        
          <div style='display:table-cell;text-align:center;padding:5px;'>
            <label> Documento</label>
            <a href="<?php echo '../../'.$items[0]->documento1; ?>" target="_blacnk">
              <img src="<?php echo '../../'.$items[0]->documento1; ?>" width="200">
            </a>
          </div>
          
          <div style='display:table-cell;text-align:center;padding:5px;'>
          
            <label> Licencia</label>
            <a href="<?php echo '../../'.$items[0]->documento2; ?>" target="_blacnk">
              <img src="<?php echo '../../'.$items[0]->documento2; ?>" width="200">
            </a>
          
          </div>
          
        </div>
        
      </div>
      
      
    
    </div>
    
  </div>
  
</div>

<p>&nbsp;</p>
<hr/>
<p>&nbsp;</p>
<center>
<h3><b>Datos del vehiculo:</b></h3>
</center>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div style="display:table;">
  <div style="display:table-row;">
    <div style="display:table-cell;">
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

      <div id="detalle_vehiculo">
      
      </div>

    <!------------------------------------------------------------------------------------------------> 
    </div>
    
    <div style="display:table-cell;">
    
      <div style='display:table;width:100%;'>
      
        <div style='display:table-row;'>
        
          <div style='display:table-cell;text-align:center;padding:52px;'>
        
            <label> T.Propiedad</label>
            <a href="<?php echo '../../'.$items[0]->documento3; ?>" target="_blank">
              <img src="<?php echo '../../'.$items[0]->documento3; ?>" width="200">
            </a>
          
          </div>
          
          <div style='display:table-cell;text-align:center;padding:5px;'>
          
            <label> T.Operación</label>
            <a href="<?php echo '../../'.$items[0]->documento4; ?>" target="_blank">
              <img src="<?php echo '../../'.$items[0]->documento4; ?>" width="200">
            </a>
          
          </div>
          
        </div>
        
      </div>
    
      
             
      
    
    </div>
    
  </div>
</div>

<div class="span4">
    
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
      
      <?php if($items[0]->token=='NULL'){?>
        <input type='button' value='Enviar' onclick="if(confirm('Esta seguro de actualizar el estado de la información ?')==true){document.getElementById('calificar').src='http://taxisya.co/cms/application/views/docu/calificar.php?a='+document.getElementById('aprobado').checked+'&r='+document.getElementById('rechazado').checked+'&e='+document.getElementById('eliminado').checked+'&p='+document.getElementById('pendiente').checked+'&i=<?php echo $driver_id; ?>';};">
      <?php }else{ ?>
        <input type='button' value='Enviar' onclick="if(confirm('Esta seguro de actualizar el estado de la información ?')==true){document.getElementById('calificar').src='http://taxisya.co/cms/application/views/docu/calificar.php?a='+document.getElementById('aprobado').checked+'&r='+document.getElementById('rechazado').checked+'&p='+document.getElementById('pendiente').checked+'&i=<?php echo $driver_id; ?>';};">
      <?php } ?>
    </form>
    
    <iframe src='' frameborder='no' scrolling='no' id='calificar'>
    
  </div>


