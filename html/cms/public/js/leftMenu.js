$(document).ready(function() {
    $(".main_menu li").click(function(event) {
        // this.append wouldn't work
        //$(this).append(" Clicked");
        if ($(this).attr('id') != undefined) {
            loading('Cargando', 0);
            var selector = $(this).attr('id').split("-");
            //alert(BASE+'/'+selector['0']);
            $.post(BASE + '/' + selector['0'], function(data) {
                //alert("Data Loaded: " + data);
                $('#mainContainer').empty().html(data);
                unloading();
                $('.tipsy').remove();
            });
        }
    });
});
function dataPoster(id) {
    if (id != undefined) {
        loading('Cargando', 0);
        var selector = id.split("-");
        //alert(BASE+'/'+selector['0']);
        switch (selector['2'])
        {
            case 'export':
                var exporter = BASE + '/' + selector['0'] + '/' + selector['2'] + '/' + selector['1'];
                var win = window.open(exporter, 'width=200,height=100');
                unloading();
                $('.tipsy').remove();
                break;
            case 'delete':
                if (confirm("¿Desea eliminar el registro?")) {
                    $.post(BASE + '/' + selector['0'] + '/' + 'del', {
                        id: selector['1']
                    }, function(data) {
                        unloading();
                        //alert("Data Loaded: " + data);
                        $('#mainContainer').empty().html(data); 
                        $('.tipsy').remove();
			if (selector['0'] == 'driver'){
				window.location=BASE +'/drivers';		
			}
                    });
                }
                break;
            default:
                $.post(BASE + '/' + selector['0'] + '/' + selector['2'], {
                    id: selector['1']
                }, function(data) {
                    unloading();
                    //alert("Data Loaded: " + data);
                    $('#mainContainer').empty().html(data);
                    $('.tipsy').remove();
                });
                break;
        }
        //alert(BASE+'/'+selector['0']);
        /*if (selector['2'] !== 'delete') {
         $.post(BASE + '/' + selector['0'] + '/' + selector['2'], {
         id: selector['1']
         }, function(data) {
         unloading();
         //alert("Data Loaded: " + data);
         $('#mainContainer').empty().html(data);
         $('.tipsy').remove();
         });
         } else {
         if (confirm("¿Desea eliminar el registro?")) {
         $.post(BASE + '/' + selector['0'] + '/' + 'del', {
         id: selector['1']
         }, function(data) {
         unloading();
         //alert("Data Loaded: " + data);
         $('#mainContainer').empty().html(data);
         $('.tipsy').remove();
         });
         }
         }*/
    } else {
        alert('Nos reventamos mano!');
    }
}
function jsonPoster(jsonData) {
    if (jsonData !== undefined) {
        //console.log(jsonData);
        var obj = jQuery.parseJSON(jsonData);
        //console.log(obj);
        var exporter = BASE + '/' + obj.section + '/' + obj.action + '/' + obj.tabData + '?reportType=' + obj.data.reportType + '&reportFilter=' + obj.data.reportFilter + '&reportSince=' + obj.data.reportSince + '&reportUntil=' + obj.data.reportUntil + '&specFilter=' + obj.data.specificFilter;
        var win = window.open(exporter, 'width=200,height=100');
        unloading();
        $('.tipsy').remove();
    } else {
        alert('Nos reventamos mano!');
    }
}
function formPoster(id) {
    if (id != undefined) {
        loading('Cargando', 0);
        var selector = id.split("-");
        //alert(BASE+'/'+selector['0']);
        var data = $('form').serializeArray();
        data.push({name: 'id', value: selector['1']});
        $.post(BASE + '/' + selector['0'] + '/' + selector['2'], data, function(data) {
            unloading();
            //alert("Data Loaded: " + data);
            $('#mainContainer').empty().html(data);
        });
    } else {
        alert('Nos reventamos mano!');
    }
}
function formPoster2(id) {
	//alert('Entro '+id.split("-")['1']);
    if (id != undefined) {
		loading('Cargando', 0);
        var selector = id.split("-");
        var data = $('form').serializeArray();
        data.push({name: 'id', value: selector['1']});
		data.push({name: 'phone', value: document.getElementById('telephone').value});
		data.push({name: 'name', value: document.getElementById('name').value});
		data.push({name: 'adressid',value: document.getElementById('service-0-filladdress').value});
        $.post(BASE + '/' + selector['0'] + '/' + selector['2'], data, function(data) {
            unloading();
            $('#mainContainer').empty().html(data);
        });
    } else {
        alert('Nos reventamos mano!');
    }
}
function formPosterDriver(id){
	if (id != undefined) {
        
        var selector = id.split("-");
        //alert(BASE+'/'+selector['0']);
        var data = $('form').serializeArray();	
		var validator = true;
		if(document.getElementById('car_id').value != 0){validator = validator && true;}else{validator = validator && false;}
		if(document.getElementById('name').value!=''){validator = validator && true;}else{validator = validator && false;}
		if(document.getElementById('lastname').value!=''){validator = validator && true;}else{validator = validator && false;}
		if(document.getElementById('email').value!=''){validator = validator && true;}else{validator = validator && false;}
		if(document.getElementById('pwd').value!=''){validator = validator && true;}else{validator = validator && false;}
		if(document.getElementById('cellphone').value!=''){validator = validator && true;}else{validator = validator && false;}
		if(document.getElementById('cedula').value!=''){validator = validator && true;}else{validator = validator && false;}
		if(document.getElementById('license').value!=''){validator = validator && true;}else{validator = validator && false;}
		if(document.getElementById('dir').value!=''){validator = validator && true;}else{validator = validator && false;}
		if(validator){
			loading('Cargando', 0);
			data.push({name: 'id', value: selector['1']});
			$.post(BASE + '/' + selector['0'] + '/' + selector['2'], data, function(data) {
			unloading();
			$('#mainContainer').empty().html(data);
		});
		}else{
			alert('Por favor diligencie todo los campos');
		}
    }else {
        alert('Nos reventamos mano!');
    }
}
function selectorPoster(id) {
    if (id != undefined) {
        loading('Cargando', 0);
        var selector = id.split("-");
        //alert(BASE+'/'+selector['0']);
        if (selector['2'] !== 'delete') {
            $.post(BASE + '/' + selector['0'] + '/' + selector['2'], {
                id: selector['1']
            }, function(data) {
                unloading();
                //alert("Data Loaded: " + data);
                $('#' + selector[3]).empty().html(data);
                $('.tipsy').remove();
            });
        } else {
            if (confirm("¿Desea eliminar el registro?")) {
                $.post(BASE + '/' + selector['0'] + '/' + 'del', {
                    id: selector['1']
                }, function(data) {
                    unloading();
                    //alert("Data Loaded: " + data);
                    $('#' + selector[3]).empty().html(data);
                    $('.tipsy').remove();
                });
            }
        }
    } else {
        alert('Nos reventamos mano!');
    }
}
function formRequest(id) {
		var validacion = true;
		if(document.getElementById('street').value == '')
		{
			validacion = false;
		}
		if(document.getElementById('comp1').value == '')
		{
			validacion = false;
		}
		if(document.getElementById('comp2').value == '')
		{
			validacion = false;
		}
		if(document.getElementById('no').value == '')
		{
			validacion = false;
		}
		if(document.getElementById('telephone').value == '')
		{
			validacion = false;
		}
		if(document.getElementById('name').value == '')
		{
			validacion = false;
		}
		if(validacion)
		{
			var tmpAddress = document.getElementById('street').value + " " + document.getElementById('comp1').value + " " +  document.getElementById('comp2').value + " -" + document.getElementById('no').value + " Bogotá, Colombia";
			var selector = id.split("-");
			//var tmpAddress = data.dir_index_id + " " + data.dir_comp1 + " " + data.dir_comp2 + " -" + data.dir_no + " Bogotá, Colombia";//encodeURIComponent(
			if (id != undefined) {
				var data = $('form').serializeArray();
				//$response = window.open("http://localhost:3700/service","","height=680,width=980");
				//data.push({name: 'crt_lat', value: result[0].geometry.location.lat});  
				data.push({name: 'crt_lat', value: '0'}); 
				//data.push({name: 'crt_lng', value: result[0].geometry.location.lng});  
				data.push({name: 'crt_lng', value: '0'});
				data.push({name: 'user_id', value: selector['1']});
				data.push({name: 'index_id', value:  document.getElementById('street').value}); 
				data.push({name: 'comp1', value:  document.getElementById('comp1').value}); 
				data.push({name: 'comp2', value:  document.getElementById('comp2').value});
				data.push({name: 'no', value:  document.getElementById('no').value});
				data.push({name: 'barrio', value:  document.getElementById('barrio').value});
				data.push({name: 'obs', value:  document.getElementById('obs').value});
				data.push({name: 'name', value:  document.getElementById('name').value});
				$.post(BASE + '/' + selector['0'] + '/' + selector['2'], data, function(data) {
					unloading();
					$('#mainContainer').empty().html(data);
				});
			} else {
			alert('Nos reventamos mano!');
			}
		}else{
			alert('Por favor complete todos los datos');
		}
}
