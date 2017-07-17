<?php
      
  include ("conexion.php");	$conex = ConectarCMS();
  
  if($_POST['proc']=='registrar'){
    
    foreach($_POST as $nombre_campo => $valor){ 
      $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
      eval($asignacion); 
    } 
    
    $cons="select * from drivers where cedula='$identificacion' and status!='rechazado'";
    $resu=mysql_query($cons);
    $tota=mysql_num_rows($resu);
    
    if($tota==0){
      
      $cons="select max(id)+1 from drivers";
      $resu=mysql_query($cons);
      while($row=mysql_fetch_row($resu)){
        $id=$row[0];
      }
      
      
      /*  Guardar foto  */
      if (is_uploaded_file($_FILES['foto']['tmp_name'])){
        $foto = $_FILES['foto']['name'];
        $datos=explode('.',$foto);
        $formato='.'.$datos[1];
        $ruta='../dev/cms/public/img/drivers/'.$id.$formato;
        $picture="cms/public/img/drivers/".$id.$formato;
        @unlink($ruta);
        move_uploaded_file($_FILES['foto']['tmp_name'],$ruta);
      }
      
      /*  Guardar documento 1  */
      if (is_uploaded_file($_FILES['cedula']['tmp_name'])){
        $foto = $_FILES['cedula']['name'];
        $datos=explode('.',$foto);
        $formato='.'.$datos[1];
        $ruta='../dev/cms/public/uploads/docs/doc1_'.$id.$formato;
        $document1="cms/public/uploads/docs/doc1_".$id.$formato;
        @unlink($ruta);
        move_uploaded_file($_FILES['cedula']['tmp_name'],$ruta);
      }
      
      /*  Guardar documento 2  */
      if (is_uploaded_file($_FILES['licencia']['tmp_name'])){
        $foto = $_FILES['licencia']['name'];
        $datos=explode('.',$foto);
        $formato='.'.$datos[1];
        $ruta='../dev/cms/public/uploads/docs/doc2_'.$id.$formato;
        $document2="cms/public/uploads/docs/doc2_".$id.$formato;
        @unlink($ruta);
        move_uploaded_file($_FILES['licencia']['tmp_name'],$ruta);
      }
      
      /*  Guardar documento 3  */
      if (is_uploaded_file($_FILES['propiedad']['tmp_name'])){
        $foto = $_FILES['propiedad']['name'];
        $datos=explode('.',$foto);
        $formato='.'.$datos[1];
        $ruta='../dev/cms/public/uploads/docs/doc3_'.$id.$formato;
        $document3="cms/public/uploads/docs/doc3_".$id.$formato;
        @unlink($ruta);
        move_uploaded_file($_FILES['propiedad']['tmp_name'],$ruta);
      }
      
      /*  Guardar documento 4  */
      if (is_uploaded_file($_FILES['operacion']['tmp_name'])){
        $foto = $_FILES['operacion']['name'];
        $datos=explode('.',$foto);
        $formato='.'.$datos[1];
        $ruta='../dev/cms/public/uploads/docs/doc4_'.$id.$formato;
        $document4="cms/public/uploads/docs/doc4_".$id.$formato;
        @unlink($ruta);
        move_uploaded_file($_FILES['operacion']['tmp_name'],$ruta);
      }
      
      /*  Registrar carro  */
      
      $cons="select id from cars where placa='$placa'";
      $resu=mysql_query($cons);
      $tota=mysql_num_rows($resu);
      
      if($tota>0){
        
        while($row=mysql_fetch_row($resu)){
          $car_id=$row[0];
        }
        
      }else{
        
        $cons="select max(id)+1 from cars";
        $resu=mysql_query($cons);
        while($row=mysql_fetch_row($resu)){
          $car_id=$row[0];
        }
        
        $cons="SET FOREIGN_KEY_CHECKS=0";
        mysql_query($cons);
        
        $cons="insert into cars values ('$car_id','$placa','$linea','$marca','$movil','$compania','00-00-00 00:00:00','$modelo','$ciudad')";
        mysql_query($cons);
        
      }
      
      $cons="SET FOREIGN_KEY_CHECKS=0";
      mysql_query($cons);
      
      $cons="insert into drivers values ('$id','$email',MD5('$pass'),'$car_id','$celular','$telefono','$picture','nuevo','','$nombre','$apellido','$email',now(),'','','',now(),'','$licencia','','$identificacion','$direccion','$telefono',now(),'','$ciudad')";
      mysql_query($cons);
      
      // echo "Registrar conductor: ".$cons."<br/>";
      
      $cons="SET FOREIGN_KEY_CHECKS=0";
      mysql_query($cons);
      
      $cons="insert into drivers_cars values ('$id','$car_id')";
      mysql_query($cons);
        
      // echo "Enlazar carro y conductor: ".$cons."<br/>";
      
      $cons="SET FOREIGN_KEY_CHECKS=0";
      mysql_query($cons);
      
      $cons="insert into regi_webb values ('$id')";
      mysql_query($cons);
      
      // echo "Registrar log web: ".$cons."<br/>";
      
      $cons="select max(id)+1 from cms_documents";
      $resu=mysql_query($cons);
      while($row=mysql_fetch_row($resu)){
        $document_id=$row[0];
      }
      
      $cons="SET FOREIGN_KEY_CHECKS=0";
      mysql_query($cons);
      
      $cons="insert into cms_documents values('$document_id','$document1','$document2','$document3','$document4','$id',now(),now())";
      mysql_query($cons);
      
      // echo "Registrar documentos del conductor: ".$cons."<br/>";
      
      $cabeceras = 'MIME-Version: 1.0' . "\r\n";
      $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
      $cabeceras .= 'From: TaxisYa';
      $titulo = 'Taxisya - Registro de conductor';
 
      $mensaje = '<html>'.
        '<head><title>Taxisya - Registro de conductor</title></head>'.
        '<body><h1>Taxisya - Registro de conductor</h1>'.
        'Buen dia,<br><br>Se ha registrado como conductor a Taxisya con los siguientes datos:<br><br>'.
        'Pais:'.$pais.'<br>'.
        'Departamento:'.$departamento.'<br>'.
        'Ciudad:'.$ciudad.'<br>'.
        'Nombre:'.$nombre.'<br>'.
        'Identificacion:'.$identificacion.'<br>'.
        'Licencia:'.$licencia.'<br>'.
        'Celular:'.$celular.'<br>'.
        'Telefono:'.$telefono.'<br>'.
        'Direccion:'.$direccion.'<br>'.
        'E-mail:'.$email.'<br>'.
        'Password:'.$pass.'<br>'.
        'Placa:'.$placa.'<br>'.
        'Marca:'.$marca.'<br>'.
        'Linea del vehiculo:'.$linea.'<br>'.
        'Movil del vehiculo:'.$movil.'<br>'.
        'Modelo:'.$modelo.'<br>'.
        'Compania:'.$compania.'<br><br>'.
        'Gracias.'.
        '</body>'.
        '</html>';
      
      $para = $email;
      
      mail($para, $titulo, $mensaje, $cabeceras);
      
      echo "
        <script>
          alert('Se registro correctamente y se ha enviado notificacion !');
          window.location='http://www.taxisya.co/index.php';
        </script>
      ";
      die();
      
    }else{
      
      echo "
        <script>
          alert('Ya existe un registro con la cedula $identificacion !');
          window.location='registro.php';
        </script>
      ";
      die();
      
    }
    
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de Conductores</title>
	<link href="/templates/citycab/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link href="libraries/jquery.bxslider.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="css/registro2.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libraries/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>
	<script>



	function cargarDiv(div,url)
	{
		  $(div).load(url);
	}

	function ConsultCedulaConduc()
	{
		var cedula = $("#cedula").val(), cadena = "cedula="+cedula;
			cargarDiv("#cedAjax","consultarCedConductor.php?"+cadena);
	}
  
  function cambia_color(id){
    
    document.getElementById('ok_'+id).style.display='block';
    
  }
  
	</script>
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
<div class="registro">
	<div class="container">
		<form enctype="multipart/form-data" action="registro.php" class="registro_taxistas" name="form" id="form" method="POST">
          <input type='hidden' value='' id='proc' name='proc'>
	        <div class="text-tag"> Pa&iacute;s</div>
	        <div>
              <select class="campo_select" name="pais" id="pais" onchange="submit();">
                <option>- Seleccionar -</option>
                <?php
                  $cons="select id,name from cms_countries order by 2";
                  $resu=mysql_query($cons);
                  while($row=mysql_fetch_row($resu)){
                    $id=$row[0];
                    $name=utf8_encode($row[1]);
                    $vali="";
                    if($_POST['pais']){
                      if($_POST['pais']==$id)
                        $vali="selected";
                    }
                    echo "
                      <option value='$id' $vali>$name</option>
                    ";
                  }
                ?>
              </select>
	        </div>
          <div class="text-tag"> Departamento</div>
	        <div>
              <select class="campo_select" name="departamento" id="departamento" onchange="submit();">
                <option>- Seleccionar -</option>
                <?php
                  if($_POST['pais'])
                    $country=$_POST['pais'];
                  else
                    $country=0;
                  $cons="select id,name from cms_departments where country_id='$country' order by 2";
                  $resu=mysql_query($cons);
                  while($row=mysql_fetch_row($resu)){
                    $id=$row[0];
                    $name=utf8_encode($row[1]);
                    $vali="";
                    if($_POST['departamento']){
                      if($_POST['departamento']==$id)
                        $vali="selected";
                    }
                    echo "
                      <option value='$id' $vali>$name</option>
                    ";
                  }
                ?>
              </select>
	        </div>
          <div class="text-tag"> Ciudad</div>
	        <div>
              <select class="campo_select" name="ciudad" id="ciudad" onchange="submit();">
                <option>- Seleccionar -</option>
                <?php
                    $country=0;
                    $departamento=0;
                  if($_POST['pais'])
                    $country=$_POST['pais'];
                  if($_POST['departamento'])
                    $departamento=$_POST['departamento'];
                  $cons="select id,name from cms_cities where country_id='$country' and department_id='$departamento' order by 2";
                  $resu=mysql_query($cons);
                  while($row=mysql_fetch_row($resu)){
                    $id=$row[0];
                    $name=utf8_encode($row[1]);
                    $vali="";
                    if($_POST['ciudad']){
                      if($_POST['ciudad']==$id)
                        $vali="selected";
                    }
                    echo "
                      <option value='$id' $vali>$name</option>
                    ";
                  }
                ?>
              </select>
	        </div>
          <div class="text-tag"> Nombre</div>
	        <div>
	            <input type="text" class="name" name="nombre" id="nombre" placeholder="Digite su nombre" />
	        </div>
	        <div class="text-tag"> Identificaci&oacute;n</div>
	        <div>
	            <input type="text" class="name" name="identificacion" id="identificacion" />
	        </div>
          <div class="text-tag"> Licencia de Conducci&oacute;n</div>
	        <div>
	            <input type="text" class="name" name="licencia" id="licencia" />
	        </div>
          <div class="text-tag"> Celular</div>
	        <div>
	            <input type="text" class="name" name="celular" id="celular" />
	        </div>
          <div class="text-tag"> Tel&eacute;fono</div>
	        <div>
	            <input type="text" class="name" name="telefono" id="telefono" />
	        </div>
          <div class="text-tag"> Direcci&oacute;n</div>
	        <div>
	            <input type="text" class="name" name="direccion" id="direccion" />
	        </div>
          <div class="text-tag"> E-mail(Correo electr&oacute;nico)</div>
	        <div>
	            <input type="text" class="name" name="email" id="email" />
	        </div>
          <div class="text-tag"> Tu contrase&ntilde;a</div>
	        <div>
	            <input type="text" class="name" name="pass" id="pass" />
	        </div>
          <div class="text-tag"> Placa del vehiculo</div>
	        <div>
	            <input type="text" class="name" name="placa" id="placa" />
	        </div>
          <div class="text-tag"> Marca del vehiculo</div>
	        <div>
	            <input type="text" class="name" name="marca" id="marca" />
	        </div>
          <div class="text-tag"> Línea del vehiculo</div>
	        <div>
	            <input type="text" class="name" name="linea" id="linea" />
	        </div>
          <div class="text-tag"> M&oacute;vil del vehiculo</div>
	        <div>
	            <input type="text" class="name" name="movil" id="movil" />
	        </div>
          <div class="text-tag"> Modelo del vehiculo</div>
	        <div>
	            <input type="text" class="name" name="modelo" id="modelo" />
	        </div>
          <div class="text-tag"> Compa&ntilde;ia del vehiculo</div>
	        <div>
	            <input type="text" class="name" name="compania" id="compania" />
	        </div>
          <div class="text-tag"></div>
          <div class="fileUpload">
              <span>Añadir Foto Conductor</span>
              <input type="file" class="photo" name="foto" id="foto" onchange="cambia_color('foto');" />&nbsp;<center><img src='ok.png' id='ok_foto' style='display:none;position: absolute;margin-top: -8%;margin-left: -4%;'/></center>
          </div>

          <div class="fileUpload">
              <span>Añadir Foto C&eacute;dula</span>
              <input type="file" class="photo" name="cedula" id="cedula" onchange="cambia_color('cedula');" />&nbsp;<center><img src='ok.png' id='ok_cedula' style='display:none;position: absolute;margin-top: -8%;margin-left: -4%;'/></center>
          </div>

          <div class="fileUpload">
              <span>Añadir Foto Licencia</span>
              <input type="file" class="photo" name="licencia" id="licencia" onchange="cambia_color('licencia');" />&nbsp;<center><img src='ok.png' id='ok_licencia' style='display:none;position: absolute;margin-top: -8%;margin-left: -4%;'/></center>
          </div>

          <div class="fileUpload">
              <span>Añadir Tarjeta Propiedad</span>
              <input type="file" class="photo" name="propiedad" id="propiedad" onchange="cambia_color('propiedad');" />&nbsp;<center><img src='ok.png' id='ok_propiedad' style='display:none;position: absolute;margin-top: -8%;margin-left: -4%;'/></center>
          </div>
          <div class="fileUpload">
              <span>Añadir Tarjeta Operaci&oacute;n</span>
              <input type="file" class="photo" name="operacion" id="operacion" onchange="cambia_color('operacion');" />&nbsp;<center><img src='ok.png' id='ok_operacion' style='display:none;position: absolute;margin-top: -8%;margin-left: -4%;'/></center>
          </div>
	        <input type="button" class="enviar_registro" name="enviar_registro" id="enviar_registro" value="Enviar" onclick="document.getElementById('proc').value='registrar';submit();">
		</form>
	</div>
</div>
<script>
	document.getElementById("files").onchange = function () {
	    document.getElementById("uploadFile").value = this.value;
	};
	document.getElementById("photo").onchange = function () {
	    document.getElementById("uploadImage").value = this.value;
	};

	document.getElementById("document").onchange = function () {
	    document.getElementById("uploadImage2").value = this.value;
	};

	document.getElementById("document2").onchange = function () {
	    document.getElementById("uploadImage3").value = this.value;
	};
	document.getElementById("document3").onchange = function () {
	    document.getElementById("uploadImage4").value = this.value;
	};


</script>
<?php mysql_close($conex); ?>
</body>
</html>
