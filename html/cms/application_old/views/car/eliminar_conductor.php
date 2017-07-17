<?php
  
  $cone=mysql_connect('localhost','taxisya_user','AJX9PbHpBECHGD7s');
  mysql_select_db('appsuser_taxisya');
  
  $var=$_REQUEST['var'];
  
  $cons="SET FOREIGN_KEY_CHECKS=0";
  mysql_query($cons);
  
  $cons="delete from cars where id='$var'";
  mysql_query($cons);
  
  echo "
    <script>
      alert('Se elimino el vehiculo correctamente !');
      parent.window.location='http://www.taxisya.co/cms/public/dashboard';
    </script>";
  
?>