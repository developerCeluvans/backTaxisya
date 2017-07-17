

<!--------------------------  Agregar vehiculo al conductor  ------------------------------------->
        
        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        
        <script type="text/javascript">
          $(document).ready(function() {
            $("#detalle_vehiculo").load('http://www.taxisya.co/cms/application/views/driver/detalle_vehiculo.php');
          });
        </script>
        
        <div id="detalle_vehiculo">
        </div>
        
        
        <!------------------------------------------------------------------------------------------------>


<style>

  .tabla{
    display:table;
  }
  .columna{
    display:table-row;
  }
  .celda{
    display:table-cell;
    padding-left:5px;
    padding-right:5px;
    padding-top:2px;
    padding-bottom:2px;
  }
  .titulo{
    font-weight:bold;
  }
  .campos{
    width:62px;
  }
  .fecha_pago{
    width:130px!important;
  }
  .boton:hover{
    cursor:pointer;
    opacity:0.4;
  }
  .centro{
    text-align:center;
  }

</style>

<br/><br/>

<hr/>

<h3><b>Registrar vehiculo:</b></h3>

<div class="tabla">
  <div class="columna">
    <div class="celda centro">
      <img src="http://www.taxisya.co/images/save.png" class="boton" alt='Guardar' title='Guardar'>
    </div>
    <div class="celda titulo">
      Placa
    </div>
    <div class="celda titulo">
      M&oacute;vil
    </div>
    <div class="celda titulo">
      Marca
    </div>
    <div class="celda titulo">
      L&iacute;nea
    </div>
    <div class="celda titulo">
      Modelo
    </div>
    <div class="celda titulo">
      Empresa
    </div>
    <div class="celda titulo">
      Fecha &uacute;ltimo pago
    </div>
  </div>
  <div class="columna">
    <div class="celda centro">
    </div>
    <div class="celda titulo">
      <input type="text" id='d_placa' class="campos">
    </div>
    <div class="celda titulo">
      <input type="text" id='d_movil' class="campos">
    </div>
    <div class="celda titulo">
      <input type="text" id='d_marca' class="campos">
    </div>
    <div class="celda titulo">
      <input type="text" id='d_linea' class="campos">
    </div>
    <div class="celda titulo">
      <select id='d_modelo' class="campos">
        <?php
          for($c=2017;$c>=1947;$c--){
            echo "<option value='$c'>$c</option>";
          }
        ?>
      </select>
    </div>
    <div class="celda titulo">
      <input type="text" id='d_empresa' class="campos">
    </div>
    <div class="celda titulo">
      <input type="date" id='d_pago' class="campos fecha_pago">
    </div>
  </div>
</div>

<hr/>

<br/><br/>