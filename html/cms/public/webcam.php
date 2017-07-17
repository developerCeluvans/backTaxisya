<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>JPEGCam Test Page</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Joseph Huckaby">
	<!-- Date: 2008-03-15 -->
</head>
<body>
	<table><tr><td valign=top>
	
	<!-- First, include the JPEGCam JavaScript Library -->
	<script type="text/javascript" src="webcam.js"></script>
	
	<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( "test.php?id=<?php echo $_GET['id'] ?>");
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
	
	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(320, 240) );
	</script>
	
	<!-- Some buttons for controlling things -->
	<br/><form>
		<input type=button value="Configurar" onClick="webcam.configure()">
		&nbsp;&nbsp;
		<input type=button value="Capturar Foto" onClick="take_snapshot()">
		&nbsp;&nbsp;
		<input type=button value="Sair" onClick="window.close()">
	</form>
	
	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function take_snapshot() {
			// take snapshot and upload to server
			//document.getElementById('upload_results').innerHTML = '<h1>Uploading...</h1>';
			webcam.snap();
		}
		
		function my_completion_handler(msg) {
			// extract URL out of PHP output
			//
			if (msg.match(/(http\:\/\/\S+)/)) {
				var image_url = RegExp.$1;
				// show JPEG image in page
				/*document.getElementById('upload_results').innerHTML = 
					'<h1>Upload Successful!</h1>' + 
					'<h3>JPEG URL: ' + image_url + '</h3>' + 
					'<img src="' + image_url + '">';
				*/
				// reset camera for another shot
				webcam.reset();
			}
			else alert("PHP Error: " + msg);
			//image_url = image_url.replace("http://localhost/cms/public/","");
			console.log(image_url);
			//window.opener.$('#avatar').attr('src',image_url); width=​"180" height=​"180" alt=​"avatar"
			//window.opener.$('#avatar').attr('src', image_url);//html('<img src=​"' + image_url + '?v=1412376412.5856"  width=​"180" height=​"180" alt=​"avatar" >');
			window.opener.dataPoster("driver-<?php echo $_GET['id'] ?>-edit");
			window.close();

		}
	</script>
	
	</td></tr></table>
</body>
</html>
