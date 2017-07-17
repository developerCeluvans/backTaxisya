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
  function cambiar(id){
    alert(id);
    var fech_pago=document.getElementById('fech_pago').value;
    alert(fech_pago);
    document.getElementById('proceso').src='http://www.taxisya.co/cms/application/views/docu/proceso.php?fech_pago='+fech_pago+'&id='+id;
  }
</script>

<div class="tabla">
  
  <?php
    
    $cone=mysql_connect('localhost','taxisya_user','AJX9PbHpBECHGD7s');
    mysql_select_db('appsuser_taxisya');
  
  
    $id_driver=$_REQUEST['id'];
    /*$cons="select id,placa,movil,car_brand,model,empresa,pay_date from cars where id in (select cars_id from drivers_cars where drivers_id='$id_driver')";*/
    $cons="select id,placa,movil,car_brand,model,empresa,pay_date from cars where id in (select car_id from drivers where id=$id_driver)";
    $resu=mysql_query($cons);
    while($row=mysql_fetch_row($resu)){
      $id=$row[0];
      $placa=$row[1];
      $movil=$row[2];
      $car_brand=$row[3];
      $model=$row[4];
      $empresa=$row[5];
      $pay_date=$row[6];
      $fecha=explode('-',$pay_date);
      $sepa_diaa=explode(" ",$fecha[2]);
      $fecha[2]=$sepa_diaa[0];
      $pay_date=$fecha[0].'-'.$fecha[1].'-'.$fecha[2];
      if($pay_date=="0000-00-00" || $pay_date=="")
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
            <input id='fech_pago' type='date' name='fech_pago' value='$pay_date' $vali_pay_date />
          </div>
          
        </div>
        
        <div class='columna'>
          
          <div class='celda titulo'>
            <input type='button' value='Guadar fecha' onclick=\"cambiar('$id');\">
          </div>
          <div class='celda'>
          </div>
          
        </div>
        
      ";
    }
  ?>
  
</div>

<iframe id='proceso' src='' frameborder='no' scrolling='no' height="30px"></iframe>

<hr/>

<br/><br/>