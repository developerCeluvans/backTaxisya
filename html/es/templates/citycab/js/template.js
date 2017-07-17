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

});