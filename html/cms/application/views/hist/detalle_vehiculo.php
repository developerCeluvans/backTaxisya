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
    border:1px solid #dddddd;
  }
  .titulo{
    font-weight:bold;
  }
  .campos{
    width:100px;
  }
  .fecha_pago{
    width:130px!important;
  }
  .boton{
    width:32%;
  }
  .boton:hover{
    cursor:pointer;
    opacity:0.4;
  }
  .centro{
    text-align:center;
  }

</style>

<script>
  function cambiar(proc,id,driver){
    var placa=document.getElementById('d_placa'+id).value;
    var movil=document.getElementById('d_movil'+id).value;
    var marca=document.getElementById('d_marca'+id).value;
    var modelo=document.getElementById('d_modelo'+id).value;
    var empresa=document.getElementById('d_empresa'+id).value;
    var pago=document.getElementById('d_pago'+id).value;
    var fecha_pago=document.getElementById('d_pago'+id).value;
    var datos='placa='+placa+'&movil='+movil+'&marca='+marca+'&modelo='+modelo+'&empresa='+empresa+'&pago='+pago+'&proc='+proc+'&id='+id;
    document.getElementById('proceso').src='http://www.taxisya.co/cms/application/views/docu/proceso.php?'+datos;
    if(proc=='guardar'){
      alert('Se actualizo el registro correctamente !');
    }else{
      alert('Se elimino el registro correctamente !')
    }
    $(document).ready(function() {
      $("#detalle_vehiculo").load('http://www.taxisya.co/cms/application/views/docu/detalle_vehiculo.php?id='+driver);
    });
  }
</script>

<div class="tabla">
  
  <?php
    
    $cone=mysql_connect('localhost','taxisya_user','AJX9PbHpBECHGD7s');
    mysql_select_db('appsuser_taxisya_de');
  
  
    $id_driver=$_REQUEST['id'];
    $cons="select id,placa,movil,car_brand,model,empresa,pay_date from cars where id in (select cars_id from drivers_cars where drivers_id='$id_driver')";
    $resu=mysql_query($cons);
    while($row=mysql_fetch_row($resu)){
      $id=$row[0];
      $placa=$row[1];
      $movil=$row[2];
      $car_brand=$row[3];
      $model=$row[4];
      $empresa=$row[5];
      $pay_date=$row[6];
      
      if($pay_date=="0000-00-00 00:00:00" || $pay_date=="")
        $vali_pay_date="";
      else
        $vali_pay_date="disabled";
      
      echo "
      
        <div class='columna'>
          
          <div class='celda titulo'>
            Placa
          </div>
          <div class='celda'>
            $placa
          </div>
          
        </div>
        <div class='columna'>
          
          <div class='celda titulo'>
            Móvil
          </div>
          <div class='celda'>
            $movil
          </div>
          
        </div>
        <div class='columna'>
          
          <div class='celda titulo'>
            Marca
          </div>
          <div class='celda'>
            $car_brand
          </div>
          
        </div>
        <div class='columna'>
          
          <div class='celda titulo'>
            Modelo
          </div>
          <div class='celda'>
            $model
          </div>
          
        </div>
        <div class='columna'>
          
          <div class='celda titulo'>
            Empresa
          </div>
          <div class='celda'>
            $empresa
          </div>
          
        </div>
        <div class='columna'>
          
          <div class='celda titulo'>
            Fecha último pago
          </div>
          <div class='celda'>
            <input type='text' id='fech_pago' name='fech_pago' value='$pay_date' $vali_pay_date />
          </div>
          
        </div>
        
      ";
    }
  ?>
  
</div>

<iframe id='proceso' src='' frameborder='no' scrolling='no' height="30px"></iframe>

<hr/>

<br/><br/>