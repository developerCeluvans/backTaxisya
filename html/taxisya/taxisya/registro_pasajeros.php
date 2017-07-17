<?php

  include ("conexion.php");	$conex = ConectarCMS();
  
  if($_POST){
    foreach($_POST as $nombre_campo => $valor){ 
      $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
      eval($asignacion); 
    }
    
    if($pass==$pass2){
      
      if(!trim($name) || !trim($email) || !trim($pass) || !trim($pass2) ||  !trim($celular)){
        
        echo "
          <script>
            alert('Faltan datos por digitar !');
          </script>
        ";
        
      }else{
    
        $cons="select * from users where email='$email'";
        $resu=mysql_query($cons);
        $tota=mysql_num_rows($resu);
        
        if($tota>0){
          
          echo "
            <script>
              alert('El usuario ya se encuentra registrado !');
              window.location='registro_pasajeros.php';
            </script>
          ";
          die();
          
        }else{
        
          $cons="select max(id)+1 from users";
          $resu=mysql_query($cons);
          while($row=mysql_fetch_row($resu)){
            $id=$row[0];
          }
            
            $cons="insert into users values ('$id','$name','$email','','','','$pass','$celular','','','','','','','','','')";
            mysql_query($cons);
            
            echo "
              <script>
                alert('Se registro el pasajero satisfactoriamnete !');
                window.location='http://taxisya.co';
              </script>
            ";
            die();
            
        }
          
      }
      
    }else{
      
      echo "
        <script>
          alert('La contrasena no es la misma a su confirmacion, por favor verificar !');
          document.getElementById('pass').value='';
          document.getElementById('pass2').value='';
          document.getElementById('pass').focus();
          window.location='http://taxisya.co';
        </script>
      ";
      
    }
    
  }
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Registro de Pasajeros</title>
    <link href="/templates/citycab/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="libraries/jquery.bxslider.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/registro2.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="libraries/jquery.bxslider.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <header>
      <div class="container bar">
        <div class="row">
          <div class="logo">
            <a href="http://www.taxisya.co/index.php"><img src="img/logo.png" alt="logo"></a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <nav>
              <ul>
                <li><a href="http://www.taxisya.co/index.php">Inicio</a></li>
                <li><a href="http://www.taxisya.co/index.php/about">Nosotros</a></li>
                <li><a href="http://www.taxisya.co/index.php/faq">Servicios</a></li>
                <li><a href="http://www.taxisya.co/taxisya/tramites.html">Trámites y consultas</a></li>
                <li><a href="http://www.taxisya.co/index.php/more">Contáctenos</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <div class="registro_pasajeros">
      <div class="container">
        <form action="registro_pasajeros.php" class="registro_taxistas" name="form" id="form" method="POST">
          <input type='hidden' value='' id='vacio' name='vacio' />
          <div class="text-tag"> Nombre</div>
          <div>
              <input type="text" class="name" name="name" id="name" value="<?php echo $name ?>" />
          </div>
          <div class="text-tag"> Usuario para ingresar - Correo electrónico</div>
          <div>
              <input type="text" placeholder="example@dominio.com" name="email" id="email" class="login" value="<?php echo $email ?>" />
          </div>
          <div class="text-tag">Celular</div>
          <div>
              <input type="text" class="cellphone" name="celular" id="celular" value="<?php echo $celular ?>" />
          </div>
          <div class="text-tag"> Contraseña del pasajero</div>
          <div>
              <input type="password" placeholder="Contraseña" class="pass" name="pass" id="pass" value="<?php echo $pass ?>" />
          </div>
          <div class="text-tag"> Confirmar contrase&ntilde;a</div>
          <div>
              <input type="password" placeholder="Contraseña" class="pass2" name="pass2" id="pass2" value="<?php echo $pass2 ?>" />
          </div>
          <input type="submit" class="enviar_registro" name="enviar_registro" id="enviar_registro" value="Enviar">
        </form>
      </div>
    </div>
  </body>
</html>

<?php mysql_close($conex); ?>
