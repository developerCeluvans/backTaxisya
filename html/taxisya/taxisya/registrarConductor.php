<?php
		include ("conexion.php");
		include ("funciones.php");
		$conex = ConectarCMS();

		$login=$_POST["login"];
		$pwd=md5($_POST["password"]);
		$cellphone=$_POST["cellphone"];
		$name=$_POST["name"];
		$lastname=$_POST["lastname"];
		$email=$_POST["email"];
		$cedula=$_POST["cedula"];
		$dir=$_POST["dir"];
		$telephone=$_POST["telephone"];
		$license=$_POST["license"];
		$cars_id=$_POST["cars_id"];
		$photoName = $_FILES['photo']['name'];
		$fileName = $_FILES['files']['name'];
		$documentName = $_FILES['document']['name'];
		$documentName2 = $_FILES['document2']['name'];
		$documentName3 = $_FILES['document3']['name'];

		$today = date("Y-m-d h:m:s");

		$encontrado = ConsultCedula($_POST["cedula"]);

		if ($encontrado>0)
		{
		?>
		<script> alert ("La cedula del conductor ya existe, rectifique"); history.back(-1);	</script>
		<?php
		}
		else
		{
            // city_id
            $city_id = 3; // test

			mysql_query("INSERT INTO drivers (login, pwd, movil, cellphone, name, lastname, email, created_at, updated_at, license, cedula, dir, telephone, city_id)
			VALUES ('$login', '$pwd', '$movil', '$cellphone', '$name', '$lastname', '$email', '$today', '$today', '$license', '$cedula', '$dir', '$telephone', '$city_id')",$conex);

			$query = mysql_query("SELECT id FROM drivers WHERE cedula = '$cedula'",$conex);
			$id_driver = mysql_fetch_array($query);

			//mysql_query("INSERT INTO drivers_cars (drivers_id, cars_id) VALUES ('$id_driver[0]','$cars_id')",$conex);

			$idDriver = mysql_fetch_array(mysql_query("SELECT id FROM drivers WHERE cedula = '$cedula'"));

			if ($fileName!="")
			{

				$track = "cms/public/uploads/docs/";	//RUTA CARPETA, LE FALTA "../" no se coloca porque en el resgistro de la BD se necesita sin ese prefijo
				$oldTrack = $track.$fileName;			//RUTA COMPLETA CON ARCHIVO NOMBRE ORIGINAL

				if (copy($_FILES['files']['tmp_name'],"../".$oldTrack))
				{
					$info = pathinfo("../".$oldTrack);
					$extension = $info['extension'];
					$newName = "doc1_".$idDriver[0].".".$extension;
					$newTrack = $track.$newName;		//RUTA COMPLETA CON ARCHIVO NOMBRE NUEVO
					rename("../".$oldTrack,"../".$newTrack);	//RENOMBRAR ARCHIVO EN EL SERVIDOR
					mysql_query("INSERT INTO cms_documents (name, image, driver_id, created_at, updated_at) VALUES ('$name','$newTrack','$idDriver[0]','$today','$today')");
				}
			}

			if ($photoName!="")
			{
				$track = "cms/public/img/drivers/";		//RUTA CARPETA, LE FALTA "../" no se coloca porque en el resgistro de la BD se necesita sin ese prefijo
				$oldTrack = $track.$photoName;			//RUTA COMPLETA CON ARCHIVO NOMBRE ORIGINAL
				$newTrack = $track.$idDriver[0].".jpg";	//RUTA COMPLETA CON ARCHIVO NOMBRE NUEVO

				if (copy($_FILES['photo']['tmp_name'],"../".$oldTrack))
				{
					rename("../".$oldTrack,"../".$newTrack);
					mysql_query("UPDATE drivers SET picture = '$newTrack' WHERE id = $idDriver[0]");
				}
			}

			if ($documentName!="")
			{
				$track = "cms/public/uploads/docs/";
				$oldTrack = $track.$documentName;
				//$newTrack = $track.$idDriver[0].".jpg";
				$info = pathinfo("../".$oldTrack);
				$extension = $info['extension'];
				$newName = "doc1_".$idDriver[0].".jpg";
				$newTrack = $track.$newName;		//RUTA COMPLETA CON ARCHIVO NOMBRE NUEVO
				rename("../".$oldTrack,"../".$newTrack);	//RENOMBRAR ARCHIVO EN EL SERVIDOR
				$documentName = $newTrack;

				if (copy($_FILES['document']['tmp_name'],"../".$oldTrack))
				{
					rename("../".$oldTrack,"../".$newTrack);
				}
			}


			if ($documentName2!="")
			{
				$track = "cms/public/uploads/docs/";
				$oldTrack = $track.$documentName2;
				$info = pathinfo("../".$oldTrack);
				$newName = "doc2_".$idDriver[0].".jpg";
				$newTrack = $track.$newName;		//RUTA COMPLETA CON ARCHIVO NOMBRE NUEVO
				rename("../".$oldTrack,"../".$newTrack);	//RENOMBRAR ARCHIVO EN EL SERVIDOR
				$documentName2 = $newTrack;

				if (copy($_FILES['document2']['tmp_name'],"../".$oldTrack))
				{
					rename("../".$oldTrack,"../".$newTrack);
				}

			}


			if ($documentName3!="")
			{
				$track = "cms/public/uploads/docs/";
				$oldTrack = $track.$documentName3;
				$info = pathinfo("../".$oldTrack);
				$newName = "doc3_".$idDriver[0].".jpg";
				$newTrack = $track.$newName;		//RUTA COMPLETA CON ARCHIVO NOMBRE NUEVO
				rename("../".$oldTrack,"../".$newTrack);	//RENOMBRAR ARCHIVO EN EL SERVIDOR
				$documentName3 = $newTrack;
				if (copy($_FILES['document2']['tmp_name'],"../".$oldTrack))
				{
					rename("../".$oldTrack,"../".$newTrack);
				}


			}



            // inserta en documents
			mysql_query("INSERT INTO cms_documents (documento1, documento2, documento3, driver_id, created_at, updated_at) VALUES ('$documentName', '$documentName2', '$documentName3','$idDriver[0]','$today','$today')");


			require("PHPMailer/class.phpmailer.php");

			$mail2 = new PHPMailer();
			$mail2->IsSMTP();
			$mail2->SMTPAuth = true;
			$mail2->SMTPSecure = "ssl";
			$mail2->Host = "smtp.gmail.com";
			$mail2->Port = 465;
			$mail2->Username = "taxisya.cms@gmail.com";
			$mail2->Password = "t4x1sy42015";

			$mail2->From = "notificaciones@taxisya.com.co";
			$mail2->FromName = "TAXISYA WEB";
			$mail2->Subject = 'Registro de Conductor desde la Web '.$today.' - No responder este mensaje';
			$mail2->AddAddress('jackelinortega@gmail.com');

			$body .="<img width='80' height='80' src='http://104.237.131.48/taxisya/img/logo.png'>";
			$body .="<table><tr><td colspan='2'><span style='color:#393A40'>&nbsp;<br />&nbsp;<br />Estimado Usuario,<br />&nbsp;<br />";
			$body .="Nos complace informarle del <b> registro de un nuevo conductor desde la web </b>, le recordamos dar respuesta al mismo en la brevedad posible, los datos son los siguientes:<br />&nbsp;<br /></td></tr>";
			// $body .="<tr><td width='100'><img width='80' height='80' src='http://104.237.131.48/taxisya/img/logo.png'></td>";
			$body .="<tr><td style='font-size:12px; font-weight:bold;'>Cedula : ".$cedula."<br />";
			$body .="Apellido : ".$lastname."<br />";
			$body .="Nombre : ".$name."<br />";
			$body .="Email / Login : ".$login."<br />";
			$body .="Licencia : ".$license."<br />";
			$body .="Celular : ".$cellphone."<br />";
			$body .="Telefono Fijo : ".$telephone."<br />";
			$body .="Direccion : ".$_POST["dir"]."<br /></td>";
			$body .="<td><img width='100' height='150' src='http://104.237.131.48/".$newTrack."'></td></tr>";
			$body .="<tr><td colspan='3'>&nbsp;<br />No responda este mensaje, ya que es generado desde la pagina web, que tenga un buen dia.</span></td></tr></table>";
			$body .="&nbsp; <br />&nbsp; <br />";

			$mail2->Body = $body;
			$mail2->IsHTML(true);
			$mail2->Send();

			?>
			<script> alert("Gracias por confiar en nosotros, hemos registrado la informacion!"); document.location.href="http://104.237.131.48/index.php"; </script>
<?php	} 	?>
