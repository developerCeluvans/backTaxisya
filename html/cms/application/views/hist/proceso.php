<?php
  
  $cone=mysql_connect('localhost','taxisya_user','AJX9PbHpBECHGD7s');
  mysql_select_db('appsuser_taxisya_de');
  
  if($_REQUEST['proc']){
    $proc=$_REQUEST['proc'];
    $id=$_REQUEST['id'];
    $placa=$_REQUEST['placa'];
    $movil=$_REQUEST['movil'];
    $marca=$_REQUEST['marca'];
    $modelo=$_REQUEST['modelo'];
    $empresa=$_REQUEST['empresa'];
    $pago=$_REQUEST['pago'];
    switch ($proc){
      case "guardar":{
        $cons="update cars set placa='$placa',movil='$movil',car_brand='$marca',model='$modelo',empresa='$empresa',pay_date='$pago'  where id='$id'";
        mysql_query($cons);
      }
      break;
      case "eliminar":{
        $cons="delete from cars where id='$id'";
        mysql_query($cons);
      }
      break;
    }
  }
?>