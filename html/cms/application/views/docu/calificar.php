<?php

  require_once('/usr/share/php/PHPMailer/class.phpmailer.php');

  $cone=mysql_connect('localhost','taxisya_user','AJX9PbHpBECHGD7s');
  mysql_select_db('appsuser_taxisya');

  
  $a=$_REQUEST['a'];
  $r=$_REQUEST['r'];
  $i=$_REQUEST['i'];
  $p=$_REQUEST['p'];
  
  if($_REQUEST['e']){
    $e=$_REQUEST['e'];
  }
  
  if($a=='true'){
    $cons="update drivers set available='1',status='true',account_status='true' where id='$i'";
    mysql_query($cons);
    $mensaje="Se aprobo el conductor correctamente !";
    
    
    /*  Enviar correo de aprobación  */
    
    $cons="select email from drivers where id='$i'";
    $resu=mysql_query($cons);
    while($row=mysql_fetch_row($resu)){
      $email=$row[0];
    }
    
    $para      = $email;
    $titulo    = 'Se aprobo cuenta de taxista satisfactoriamente !';
    $mensaje   = 'Buen dia, fue aprobado su registro como taxista en Taxisya';
    $cabeceras = 'From: webmaster@taxisya.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

   //mail($para, $titulo, $mensaje, $cabeceras);
    //mail();

    $mailer = new PHPMailer;

        $SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $SMTPAuth = true;  // authentication enabled
        $SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $Host = 'smtp.gmail.com';
        $Port = 465;
        $Username = "taxisya.cms@gmail.com";
        $Password = "t4x1sy42015";
        $entidad = $from = "taxisYa";
        $from_name = "Soporte " . $entidad;

        $mailer->IsSMTP();
        $mailer->SMTPDebug = 1;
        //$mailer->SMTPAuth = true;
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = $SMTPSecure;
        $mailer->Host = $Host;
        $mailer->Port = $Port;
        $mailer->CharSet = 'UTF-8';
        $mailer->Username = $Username;
        $mailer->Password = $Password;
        $mailer->From = $from;
        $mailer->FromName = $from_name;

        try {
            $mailer->AddAddress($email, $email);
            $subject = $titulo;//"taxisYa, solicitud de registro recibida";
            $mailer->Subject = "=?UTF-8?B?".base64_encode($subject)."?=";
            $mailer->Body =$mensaje;// $msg;
            $mailer->IsHTML(true);
            $mailer->Send();
        } catch (Exception $e) {
            //return Response::json(array('error' => 3, 'msg' => $e->getMessage() ));
        }
    
  }else{
    if($r=='true'){
      
      $cons="select email from drivers where id='$i'";
      $resu=mysql_query($cons);
      while($row=mysql_fetch_row($resu)){
        $email=$row[0];
      }


      $cons="SET FOREIGN_KEY_CHECKS=0";
      mysql_query($cons);
      $cons="delete from drivers_cars where drivers_id='$i'";
      mysql_query($cons);
      $cons="delete from cms_documents where driver_id='$i'";
      mysql_query($cons);
      $cons="update drivers set available='0',status='rechazado',email='rechazado',cedula='rechazado' where id='$i'";
      mysql_query($cons);
      $mensaje="El conductor fue rechazado correctamente !";

      
    
    $para      = $email;
    $titulo    = 'Se rechazo cuenta de taxista satisfactoriamente !';
    //$mensaje   = 'Buen dia, fue aprobado su registro como taxista en Taxisya';
    $cabeceras = 'From: webmaster@taxisya.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

   //mail($para, $titulo, $mensaje, $cabeceras);
    //mail();

    $mailer = new PHPMailer;

        $SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $SMTPAuth = true;  // authentication enabled
        $SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $Host = 'smtp.gmail.com';
        $Port = 465;
        $Username = "taxisya.cms@gmail.com";
        $Password = "t4x1sy42015";
        $entidad = $from = "taxisYa";
        $from_name = "Soporte " . $entidad;

        $mailer->IsSMTP();
        $mailer->SMTPDebug = 1;
        //$mailer->SMTPAuth = true;
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = $SMTPSecure;
        $mailer->Host = $Host;
        $mailer->Port = $Port;
        $mailer->CharSet = 'UTF-8';
        $mailer->Username = $Username;
        $mailer->Password = $Password;
        $mailer->From = $from;
        $mailer->FromName = $from_name;

        try {
            $mailer->AddAddress($email, $email);
            $subject = $titulo;//"taxisYa, solicitud de registro recibida";
            $mailer->Subject = "=?UTF-8?B?".base64_encode($subject)."?=";
            $mailer->Body =$mensaje;// $msg;
            $mailer->IsHTML(true);
            $mailer->Send();
        } catch (Exception $e) {
            //return Response::json(array('error' => 3, 'msg' => $e->getMessage() ));
        }


    }else{
      if($e=='true'){
        $cons="SET FOREIGN_KEY_CHECKS=0";
        mysql_query($cons);
        $cons="delete from cms_documents where driver_id='$i'";
        mysql_query($cons);
        $cons="delete from drivers_cars where drivers_id='$i'";
        mysql_query($cons);
        $cons="delete from drivers where id='$i'";
        mysql_query($cons);
        $mensaje="Se elimino el conductor correctamente !";
      }else{
        
        if($p=='true'){
          $cons="SET FOREIGN_KEY_CHECKS=0";
          mysql_query($cons);
          $cons="update drivers set status='nuevo' where id='$i'";
          mysql_query($cons);
          $mensaje="El conductor quedo pendiente !";
        }
        
      }
    }
  }
  
  echo "
    <script>
      alert('$mensaje');
      parent.window.location='http://www.taxisya.co/cms/public/dashboard';
    </script>
  ";
  
  die();

?>
