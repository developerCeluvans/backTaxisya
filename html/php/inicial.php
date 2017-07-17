<?php

  if($_POST['proc']=='registrar_agenda'){
      
    foreach($_POST as $nombre_campo => $valor){ 
      $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
      eval($asignacion); 
    }
    
    //  Validar registro del usuario
    
    $cons="select id from users where mail='$mail'";
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
    
    $cons="insert into schedules values ('$id_agenda','$id_user','','$fecha','$tipo_agen','','','','$telefono','','','$fin',now(),'0000-00-00 00:00:00','','','','$inicio')";
    mysql_query($cons);
    
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