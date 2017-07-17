<?php
/*
  |--------------------------------------------------------------------------
  | Rutas V2
  |--------------------------------------------------------------------------
 */
//Servicios paginados
Route::get('v2/services/(:num)/json', array('uses' => 'ServicesV2@get_services_JSON'));
Route::get('services', array('uses' => 'ServicesV2@get_service'));
//Route::get('v2/drivers/(:num)/json', array('uses' => 'DriversV2@get_drivers_JSON'));
Route::get('v2/drivers/(:num)/json', array('uses' => 'ServicesV2@get_drivers_JSON'));
//Route::get('drivers', array('uses' => 'DriversV2@get_driver'));
Route::get('drivers', array('uses' => 'ServicesV2@get_driver'));

Route::get('v2/placas/(:num)/json', array('uses' => 'ServicesV2@get_cars_JSON'));
Route::get('placas', array('uses' => 'ServicesV2@get_car'));

/*
  |--------------------------------------------------------------------------
  | Fin de rutas V2
  |--------------------------------------------------------------------------
 */





Route::get('/', array('before' => 'auth2', 'do' => function() {
//return View::make('home.index');
        /* if (Auth::check()) {
          return Redirect::to('/dashboard');
          } else { */
//return View::make('home.index');
//}
    }));

Route::get('dashboard', array('uses' => 'dashboard@index')); //ok
// Route for User
Route::post('user', array('uses' => 'user@index')); //ok
// Route for User
Route::post('user/edit', array('uses' => 'user@edit'));
// Route for deleting user
Route::post('user/del', array('uses' => 'user@del'));
// Route for Service
Route::post('service', array('uses' => 'service@index'));
// Route for Service
Route::post('service/view', array('uses' => 'service@index'));
//Route to cancel service
Route::post('service/cancel', array('uses' => 'service@cancel'));
//Route to cancel service
Route::post('service/cancel2', array('uses' => 'service@cancel2'));
//Route to cancel service
Route::post('service/edit', array('uses' => 'service@edit'));
// Route for Schedule
Route::post('schedule', array('uses' => 'schedule@index'));
// Route for Schedule
Route::post('schedule/edit', array('uses' => 'schedule@edit'));
// Route for Schedule
Route::post('schedule/update', array('uses' => 'schedule@update'));
// Route for Drivers
//Route::post('driver', array('uses' => 'driver@index'));
Route::post('driver', array('uses' => 'driver@index'));
//Route::get('driver', array('uses' => 'DriversV2@get_drivers_JSON'));
// Route for Drivers

Route::post('driver/new', array('uses' => 'driver@new'));
// Route for Drivers
Route::post('driver/create', array('uses' => 'driver@create'));
// Route for Drivers
Route::post('driver/edit', array('uses' => 'driver@edit'));
// Route for update drivers
Route::post('driver/update', array('uses' => 'driver@update'));
//Afiliaciones vencidas
Route::post('driver/expired', array('uses' => 'driver@expired'));
// Route for Drivers
Route::post('driver/reset', array('uses' => 'driver@reset'));
//eliminar conductor
Route::post('driver/del', array('uses' => 'driver@del'));
//Webcam pic uploader
Route::post('driver/wcuploader', array('uses' => 'driver@wcuploader'));
// Notificar conductores vigencia
Route::post('driver/warning',array('uses' => 'driver@sendwarning'));
// Notificar conductores vigencia
Route::post('notifier/expired',array('uses','notifier@expired'));
//Route for Services
Route::post('service/request', array('uses' => 'service@requested'));
//Route for Services
Route::post('service/search', array('uses' =>'service@search'));
//Route for Services
Route::post('service/add', array('uses' =>'service@add'));
//Route for Services
Route::post('service/filladdress', array('uses' =>'service@filladdress'));
//Route for Services
Route::post('service/realrequest',array('uses' =>'service@request'));
//Route::post('service/search', array('before' => 'userAuth', 'as' => 'reg_address', 'uses' => 'address@register'));
//Route to realtime
Route::post('realtime/service', function() {
            /* $response = "<iframe src = \"http://104.237.131.48:3700/service\" style=\"width:100%;height:800px;\">
              <p>Your browser does not support iframes.</p>
              </iframe>"; */
            $response = '<script type="text/javascript">window.open("http://www.taxisya.co/service","","height=680,width=980");</script>'; //"RealTimeService","height=200,width=200"
            return $response;
        });
Route::post('realtime/schedule', function() {
            /* $response = "<iframe src = \"http://104.237.131.48:3700\" style=\"width:100%;height:800px;\">
              <p>Your browser does not support iframes.</p>
              </iframe>"; */
            $response = '<script type="text/javascript">window.open("http://104.237.131.48:3701/schedule/'.Auth::user()->customer_id.'","realTimeSchedules");</script>';

            return $response;
        });
// Route for reports
//Route::post('report/new', array('uses' => 'report@new'));

// Se AGREGO ACA LA RUTA PARA GUARDAR LA IMAGEN

Route::post('actualizarImagen', array('uses'=> 'driver@actualizarImagen'));

Route::get('rotarImagen', function(){

  //dd('HOLA MUNDOTE');
  $urlImg = Input::get('urlImg');
  $angulo = Input::get('angulo');
  $pathImg = Input::get('pathImg');

  //$new_file=$sourceName;
  $filename = dirname(__FILE__).'/../'.$pathImg;
  $new_file = $filename;
  //$filename = $urlImg;
  $rotang = $angulo;

  if ($angulo == 90){
    $rotang = 270;
  } else if($angulo == 270){
    $rotang = 90;
  }

  list($width, $height, $type, $attr) = getimagesize($filename);
  
  $size = getimagesize($filename);
  
  $respuesta = '{"exito":1}';
  try{
    switch($size['mime']){
        case 'image/jpeg':
                         $source = imagecreatefromjpeg($filename);
                         $bgColor= imageColorAllocateAlpha($source, 0, 0, 0, 0);
                         $rotation = imagerotate($source, $rotang,$bgColor);
                         imagealphablending($rotation, false);
                         imagesavealpha($rotation, true);
                         imagecreate($width,$height);
                         imagejpeg($rotation,$new_file);
                         //chmod($filename, 0777);
        break;
        case 'image/png':

                         $source = imagecreatefrompng($filename);
                         $bgColor = imageColorAllocateAlpha($source, 0, 0, 0, 0);
                         $rotation = imagerotate($source, $rotang,$bgColor);
                         imagealphablending($rotation, false);
                         imagesavealpha($rotation, true);
                         imagecreate($width,$height);
                         imagepng($rotation,$new_file);
                         //chmod($filename, 0777);
        break;
        case 'image/gif':

                         $source = imagecreatefromgif($filename);
                         $bgColor=imageColorAllocateAlpha($source, 0, 0, 0, 0);
                         $rotation = imagerotate($source, $rotang,$bgColor);
                         imagealphablending($rotation, false);
                         imagesavealpha($rotation, true);
                         imagecreate($width,$height);
                         imagegif($rotation,$new_file);
                         //chmod($filename, 0777);
        break;
        case 'image/vnd.wap.wbmp':
                         $source = imagecreatefromwbmp($filename);
                         $bgColor=imageColorAllocateAlpha($source, 0, 0, 0, 0);
                         $rotation = imagerotate($source,$rotang,$bgColor);
                         imagealphablending($rotation, false);
                         imagesavealpha($rotation, true);
                         imagecreate($width,$height);
                         imagewbmp($rotation,$new_file);
                         //chmod($filename, 0777);
        break;
    }
  } catch(Exception $e){
    $respuesta = '{"exito":0}';
  }  


  //dd($size['mime'].' '. print_r($size,true).' '.(dirname(__FILE__).'/../'.$pathImg). ' '. $pathImg);

  //return "Hola Mundito ".$urlImg.' '.$angulo;

  return $respuesta;


});


// FIN SE CREO LA RUTA



/*
  |--------------------------------------------------------------------------
  | Application 404 & 500 Error Handlers
  |--------------------------------------------------------------------------
  |
  | To centralize and simplify 404 handling, Laravel uses an awesome event
  | system to retrieve the response. Feel free to modify this function to
  | your tastes and the needs of your application.
  |
  | Similarly, we use an event to handle the display of 500 level errors
  | within the application. These errors are fired when there is an
  | uncaught exception thrown in the application. The exception object
  | that is captured during execution is then passed to the 500 listener.
  |
 */

Event::listen('404', function() {
            //return Response::error('404');
            return View::make('common.404');
        });

Event::listen('500', function($exception) {
            return Response::error('500');
        });

/*
  |--------------------------------------------------------------------------
  | Route Filters
  |--------------------------------------------------------------------------
  |
  | Filters provide a convenient method for attaching functionality to your
  | routes. The built-in before and after filters are called before and
  | after every request to your application, and you may even create
  | other filters that can be attached to individual routes.
  |
  | Let's walk through an example...
  |
  | First, define a filter:
  |
  |		Route::filter('filter', function()
  |		{
  |			return 'Filtered!';
  |		});
  |
  | Next, attach the filter to a route:
  |
  |		Route::get('/', array('before' => 'filter', function()
  |		{
  |			return 'Hello World!';
  |		}));
  |
 */

Route::filter('before', function() {
            // Do stuff before every request to your application...
        });

Route::filter('after', function($response) {
            header("cache-Control: no-store, no-cache, must-revalidate");
            header("cache-Control: post-check = 0, pre-check = 0", false);
            header("Pragma: no-cache");
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        });

Route::filter('csrf', function() {
            if (Request::forged())
                return Response::error('500');
        });

Route::filter('auth', function() {
            if (Auth::guest())
            //return Redirect::to('login');
                return Redirect::to('/');
        });
Route::filter('auth2', function() {
            if (Auth::guest()) {
                //return Redirect::to('login');
                //return Redirect::to('/');
                return View::make('home.index');
            } else {
                return Redirect::to('/dashboard');
            }
        });
Route::controller('car');
Route::controller('docu');
Route::controller('hist');
Route::controller('country');
Route::controller('department');
Route::controller('city');


Route::controller('administrator');
Route::controller('notifier');
Route::controller('report');
Route::controller('test');
Route::controller('appversion');
Route::controller('customer');
Route::post('customer/new', array('uses' => 'customer@new'));
Route::post('customer/edit', array('uses' => 'customer@edit'));
Route::post('customer/update', array('uses' => 'customer@update'));



Route::get('logout', function() {
            Auth::logout();
            return Redirect::to('/');
        });



// Route for Complain_Controller
Route::controller('complain');
