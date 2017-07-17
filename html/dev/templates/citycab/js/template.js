jQuery(function($){

	var _rys = jQuery.noConflict();  
        _rys("document").ready(function(){  
            _rys(window).scroll(function () {  
                if (_rys(this).scrollTop() > 150) {  
                    _rys('#sp-fixed-menu-wrapper').addClass("f-sp-menu");
                    $('#sp-fixed-menu-wrapper').data('size','small');  
                } else {  
                    _rys('#sp-fixed-menu-wrapper').removeClass("f-sp-menu");
                    $('#sp-fixed-menu-wrapper').data('size','big');  
                }  
            });  
        });

        var expresionRegular = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        var enviarRegistroTaxista = function(e){

            var name = $('#name'),
                lastname = $('#lastname'),
                login = $('#login'),
                password = $('#password'),
                cellphone = $('#cellphone'),
                telephone = $('#telephone'),
                cedula = $('#cedula'),
                license = $('#license'),
                dir = $('#dir');

            if(name.val() == ""){
                e.preventDefault();
                name.css({
                    'border': '3px solid #FF9E42'
                });
                name.attr('placeholder','Digita tu nombre');
                name.focus();
                return false;
            }
            else{
                name.css({
                    'border': '1px solid #FF9E42'
                });
            }
            if(lastname.val() == ""){
                e.preventDefault();
                lastname.css({
                    'border': '3px solid #FF9E42'
                });
                lastname.attr('placeholder','Digita tu apellido');
                lastname.focus();
                return false;
            }
            else{
                lastname.css({
                    'border': '1px solid #FF9E42'
                });
            }
            if((login.val() == "")||(!expresionRegular.test(login.val()))){
                e.preventDefault();
                login.css({
                    'border': '3px solid #FF9E42'
                });
                login.attr('placeholder','Digita tu usuario');
                login.focus();
                return false;
            }
            else{
                login.css({
                    'border': '1px solid #FF9E42'
                });
            }
            if(password.val() == ""){
                e.preventDefault();
                password.css({
                    'border': '3px solid #FF9E42'
                });
                password.attr('placeholder','Digita tu contraseña');
                password.focus();
                return false;
            }
            else{
                password.css({
                    'border': '1px solid #FF9E42'
                });
            }
            if(cellphone.val() == ""){
                e.preventDefault();
                cellphone.css({
                    'border': '3px solid #FF9E42'
                });
                cellphone.attr('placeholder','Digita tu teléfono móvil');
                cellphone.focus();
                return false;
            }
            else{
                cellphone.css({
                    'border': '1px solid #FF9E42'
                });
            }
            if(telephone.val() == ""){
                e.preventDefault();
                telephone.css({
                    'border': '3px solid #FF9E42'
                });
                telephone.attr('placeholder','Digita tu teléfono');
                telephone.focus();
                return false;
            }
            else{
                telephone.css({
                    'border': '1px solid #FF9E42'
                });
            }
            if(cedula.val() == ""){
                e.preventDefault();
                cedula.css({
                    'border': '3px solid #FF9E42'
                });
                cedula.attr('placeholder','Digita tu cédula');
                cedula.focus();
                return false;
            }
            else{
                cedula.css({
                    'border': '1px solid #FF9E42'
                });
            }
            if(license.val() == ""){
                e.preventDefault();
                license.css({
                    'border': '3px solid #FF9E42'
                });
                license.attr('placeholder','Digita tu licencia de conducción');
                license.focus();
                return false;
            }
            else{
                license.css({
                    'border': '1px solid #FF9E42'
                });
            }
            if(dir.val() == ""){
                e.preventDefault();
                dir.css({
                    'border': '3px solid #FF9E42'
                });
                dir.attr('placeholder','Escribe tu dirección');
                dir.focus();
                return false;
            }
            else{
                dir.css({
                    'border': '1px solid #FF9E42'
                });
            }
        }


        /* Agendar Servicio */

    var agendarServicio = function(e){

        var fecha = $('#datepicker2'),
            hora = $('#text9'),
            origen = $('#text3'),
            destino = $('#text4'),
            telefono = $('#text10');

        if(fecha.val() == ""){
            e.preventDefault();
            fecha.css({
                'border': '3px solid #FF9E42'
            });
            fecha.attr('placeholder','Ingresa la Fecha');
            fecha.focus();
            return false;
        }
        else{
            fecha.css({
                'border': 'none'
            });
        }
        if(hora.val() == ""){
            e.preventDefault();
            hora.css({
                'border': '3px solid #FF9E42'
            });
            hora.attr('placeholder','Ingresa la Hora');
            hora.focus();
            return false;
        }
        else{
            hora.css({
                'border': 'none'
            });
        }
        if(origen.val() == ""){
            e.preventDefault();
            origen.css({
                'border': '3px solid #FF9E42'
            });
            origen.attr('placeholder','Ingresa el Origen');
            origen.focus();
            return false;
        }
        else{
            origen.css({
                'border': 'none'
            });
        }
        if(destino.val() == ""){
            e.preventDefault();
            destino.css({
                'border': '3px solid #FF9E42'
            });
            destino.attr('placeholder','Ingresa el Destino');
            destino.focus();
            return false;
        }
        else{
            destino.css({
                'border': 'none'
            });
        }
        if(telefono.val() == ""){
            e.preventDefault();
            telefono.css({
                'border': '3px solid #FF9E42'
            });
            telefono.attr('placeholder','Ingresa el telefono');
            telefono.focus();
            return false;
        }
        else{
            telefono.css({
                'border': 'none'
            });
        }
    }

        // Eventos 
        $('#form').on('submit', enviarRegistroTaxista);
        $('#chronoform-Book').on('submit', agendarServicio);

});