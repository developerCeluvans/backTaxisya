/*!
  app.js
  daniel.diaz@imaginamos.co
 */

 var enviarImagen = function(obj, cantidad, fileImg){
	
 	console.log(window.location);
 	var urlServer = window.location.href;
 	console.log(urlServer);
 	var dominio = urlServer.indexOf('public');
 	console.log(dominio);
 	urlServer = urlServer.substring(0,dominio+6);
 	console.log(urlServer);

 	var imgPATH = obj[0].src;

 	dominio = obj[0].src.indexOf('public');
 	console.log(dominio);
 	
 	var opcional = obj[0].src.indexOf('?');

 	var pathImg = obj[0].src.substring(dominio, obj[0].src.length);
 	if (opcional > 0){
 		pathImg = obj[0].src.substring(dominio, opcional);
 	}
 	
 	console.log('pathImg = '+pathImg);

	console.log(fileImg[0]['files'].length);	
	if (fileImg[0]['files'].length > 0){
		console.log('Procesar subida de la Imagen');

		var data = new FormData();
		jQuery.each(fileImg[0]['files'], function(i, file) {
		    console.log('entre '+i);
		    console.log(file);
		    data.append('file-'+i, file);
		});

		data.append('pathImg',pathImg);

		console.log(data);
		$.ajax({
		    url: urlServer+"/actualizarImagen",
		    data: data,
		    cache: false,
		    contentType: false,
		    processData: false,
		    type: 'POST',
		    success: function(html){
		        console.log(html);
		    	var res = JSON.parse(html);
			    console.log(res.exito);
			    if (res.exito == 1){
			    	var d = new Date();
					obj.removeAttr("src");
					console.log(imgPATH);
					obj.attr("src", imgPATH+"?"+d.getTime());
					rotar(obj, 0, cantidad)
					//alert('Todo Bien');
					fileImg.val("");
			    } else {
			    	alert('error');
			    }
		    }
		});
	} else {	

	 	//urlServer += obj.currentSrc;
	 	console.log(urlServer+"/rotarImagen?urlImg="+obj[0].src+'&angulo='+cantidad.val()+'&pathImg='+pathImg);

	 	$.ajax({
		  url: urlServer+"/rotarImagen?urlImg="+obj[0].src+'&angulo='+cantidad.val()+'&pathImg='+pathImg,
		  cache: false,
		  success: function(html){
		    console.log(html);
		    var res = JSON.parse(html);
		    console.log(res.exito);
		    if (res.exito == 1){
		    	var d = new Date();
				obj.removeAttr("src");
				console.log(imgPATH);
				obj.attr("src", imgPATH+"?"+d.getTime());
				rotar(obj, 0, cantidad)
				//alert('Todo Bien');
		    } else {
		    	alert('error');
		    }
		  }
		});
	}
 	cantidad.val(0);

 };

 var rotar = function(obj, angulo, cantidad){ 
   	console.log("Hola Mundo Cruel");
   	console.log(obj);
    obj.css({'transform': 'rotate('+angulo+'deg)'});
    cantidad.val(angulo);
}; 

