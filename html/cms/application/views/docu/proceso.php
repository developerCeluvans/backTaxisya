<?php

  $cone=mysql_connect('localhost','taxisya_user','AJX9PbHpBECHGD7s');
  mysql_select_db('appsuser_taxisya');
  
  $fech_pago=$_REQUEST['fech_pago'];
  $id=$_REQUEST['id'];

  $cons="update cars set pay_date='$fech_pago' where id='$id'";
  mysql_query($cons);
  
  echo "<script>alert('Se guardo la fecha correctamente !');</script>";
   
?>