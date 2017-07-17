<?php

/*
  PRUEBAS
 */

Route::get('test/bounds', function() {

            $push = Push::make(Config::get('push::push.local'));
            $result = $push->ios("7550d82f8e343937030e7e0d8ba5b7cf01560fe07793eccb8b88ae619c1ad87f", 6, 1, 'honk.wav', 'Open', array());
            return $result;
        });
Route::get('test/production_push', function() {

            $push = Push::make();
		$pushMessage = "El certificado funciona";
                $user = User::find(43);
		$result = $push->ios($user->uuid, $pushMessage, 1, 'honk.wav');
            return $result;
        });


/*
  |--------------------------------------------------------------------------
  | Rutas API V2
  |--------------------------------------------------------------------------
 */

//Cancelar servicios pendientes mas de 5 minutos.
Route::post('v2/cancelservices', function()
{

    $result = DB::query("SELECT id
                          FROM services s
                          WHERE (s.status_id  = 1 or s.status_id = 6)
                          AND TIMESTAMPDIFF (  MINUTE , `created_at`, NOW() ) >= 1",array());

    DB::query("UPDATE services SET status_id = 7
                          WHERE (status_id  = 1 or status_id = 6)
                          AND TIMESTAMPDIFF (  MINUTE ,  `created_at`, NOW() ) >= 1");

    for( $i=0 ; $i<count($result); $i++)
    {
        $payload = array();

        $payload['service_id'] = $result[$i]->id;

        Notifier::available_drivers(PushType::REMOVE_SERVICE, $payload);
    }

    return Response::json(array('success' => TRUE));

});

//El taxista se habilita
Route::post('v2/driver/(:num)/enable', array('uses' => 'driverv2@enable'));
//El taxista se habilita
Route::post('v2/driver/(:num)/disable', array('uses' => 'driverv2@disable'));
//El taxista actualiza su posicion
Route::post('v2/driver/(:num)/updateposition', array('uses' => 'DriverV2@update_position'));
//El taxista cancela su servicio activo
Route::post('v2/driver/(:num)/cancelservice', array('uses' => 'DriverV2@cancel_service'));
//El taxista confirma un servicio
Route::post('v2/driver/(:num)/confirmservice', array('uses' => 'DriverV2@confirm_service'));
//El taxista llega a la posicion
Route::post('v2/driver/(:num)/arrive', array('uses' => 'DriverV2@arrive'));
//Mostrar informacion de taxista (iPhone)
Route::post('v2/driver/(:num)/details', array('uses' => 'DriverV2@details'));

//El usuario pide un servicio
Route::post('v2/user/(:num)/requestservice', array('uses' => 'UserV2@request_service'));
//El usuario cancela su servicio activo
Route::post('v2/user/(:num)/cancelservice', array('uses' => 'UserV2@cancel_service'));
//El usuario pide un servicio con dirección completa
Route::post('v2/user/(:num)/requestservice_address', array('uses' => 'UserV2@request_service_address'));

/*
  |--------------------------------------------------------------------------
  | Fin de rutas API V2
  |--------------------------------------------------------------------------
 */

Route::get('/', function() {
            return View::make('home.index');
        });
//Route::get('user', array('uses' => 'user@index')); //query all users
//Route::get('user/(:any)/view', array('as' => 'user', 'uses' => 'user@view')); //query id->user
//Route::get('user/new', array('as' => 'new_user', 'uses' => 'user@new')); //new user
//Route::post('user/create', array('before' => 'csrf', 'uses' => 'user@create')); //creater user
//Route::get('user/login', array('as' => 'login_user', 'uses' => 'user@login'));
Route::post('user/login', array('as' => 'verify_user', 'uses' => 'user@login'));
Route::post('user/logout', array('uses'=>'user@logout'));
Route::post('user/islogued', array('uses'=>'user@islogued'));
Route::post('driver/islogued', array('uses'=>'driver@islogued'));
//Route::get('user/(:any)/edit', array('as' => 'edit_user', 'uses' => 'user@edit'));
//Route::get('user/(:any)/locate', array('as' => 'locate_user', 'uses' => 'user@locate'));
//Route::put('user/update', array('before' => 'csrf', 'uses' => 'user@update'));
//Servicios
//Register
//Route::get('user/create', array('uses' => 'user@register'));
Route::post('user/register', array('uses' => 'user@register')); //register user validating if it exists
Route::post('user/update', array('uses' => 'user@update')); //register user validating if it exists
//Register from CMS
Route::post('user/phoneregister', array('uses' => 'user@phoneregister'));
//Update position
Route::post('user/position', array('before' => 'userAuth', 'uses' => 'user@position'));
//Buscar Usuario por telefono
Route::post('user/lookfor', array('uses' => 'user@lookfor'));
//Forgotten password
Route::post('forgotten', array('uses' => 'user@forgotten'));
//Password reset
//Route::get('pwdreset/(:any)/(:any)', array('uses' => 'user@pwdreset'));
//Confirm password
Route::post('user/pwd/confirm', array('uses' => 'user@pwdconfirm'));

//Direcciones preferidas por usuario
//Route::get('address', array('uses' => 'address@index'));
//Route::get('address/(:any)', array('as' => 'address', 'uses' => 'address@view'));
//Route::get('address/new/(:any)', array('as' => 'new_address', 'uses' => 'address@new'));
//Route::get('address/delete/(:any)', array('as' => 'del_address', 'uses' => 'address@delete'));
//Servicios
//Register
Route::post('address/register', array('before' => 'userAuth', 'as' => 'reg_address', 'uses' => 'address@register'));
//Borrar direccion
//Route::post('address/delete', array('before' => 'userAuth', 'as' => 'del_address', 'uses' => 'address@delete'));
Route::post('address/delete', array('uses' => 'address@delete'));
Route::post('address/create', array('uses' => 'address@create'));
Route::get('address/new/(:any)', array('as' => 'new_address', 'uses' => 'address@new'));


//Direcciones por usuario
//Route::post('address/byuser', array('before' => 'userAuth', 'uses' => 'address@byuser'));
Route::post('address/byuser', array('uses' => 'address@byuser'));
//Direcciones por usuario CMS
Route::post('address/cmsbyuser', array('uses' => 'address@byuser'));

//Route::get('driver', array('uses' => 'driver@index'));
//Route::get('driver/(:any)', array('as' => 'driver', 'uses' => 'driver@view'));
//Route::get('driver/new', array('as' => 'new_driver', 'uses' => 'driver@new'));
Route::post('driver/create', array('uses' => 'driver@create'));
Route::post('driver/register', array('uses' => 'driver@register'));

Route::post('driver/register_driver', array('uses' => 'driver@register_driver'));
Route::post('driver/update_register_driver', array('uses' => 'driver@update_register_driver'));



Route::post('driver/updatecar',array('uses' => 'driver@updatecar'));
Route::post('driver/warning',array('uses' => 'driver@sendwarning'));
//Route::get('driver/(:any)/edit', array('as' => 'edit_driver', 'uses' => 'driver@edit'));
//Route::put('driver/update', array('uses' => 'driver@update'));
//Route::get('driver/(:any)/locate', array('as' => 'locate_driver', 'uses' => 'driver@locate'));
//Servicios
//Actualizar posicion del conductor
Route::post('driver/position', array('before' => 'myAuth', 'uses' => 'driver@position'));
//Adquirir datos del conductor
Route::post('driver/view', array('uses' => 'driver@view'));
//Login
Route::post('driver/login', array('uses' => 'driver@login'));
//LogOut
Route::post('driver/logout', array('uses' => 'driver@logout'));
//Servicios cercanos al conductor
Route::post('driver/services', array('before' => 'myAuth', 'uses' => 'driver@services'));
//Habilitar taxista
Route::post('driver/available', array('before' => 'myAuth', 'uses' => 'driver@available'));
//Deshabilitar taxista
Route::post('driver/unavailable', array('before' => 'myAuth', 'uses' => 'driver@unavailable'));

//Route::get('car', array('uses' => 'car@index'));
//Route::get('car/(:any)', array('as' => 'car', 'uses' => 'car@view'));
//Route::get('car/new', array('as' => 'new_car', 'uses' => 'car@new'));
//Route::post('car/create', array('uses' => 'car@create'));
//Route::post('car/register', array('uses' => 'car@register'));
//Route::get('car/(:any)/edit', array('as' => 'edit_car', 'uses' => 'car@edit'));
//Route::put('car/update', array('uses' => 'car@update'));

/* Route::get('service', array('uses' => 'service@index'));
  Route::get('service/(:any)', array('as' => 'service', 'uses' => 'service@view'));
  Route::get('service/new', array('as' => 'new_service', 'uses' => 'service@new'));
  Route::post('service/create', array('uses' => 'service@create'));
  Route::post('service/register', array('uses' => 'service@register'));
  Route::get('service/(:any)/edit', array('as' => 'edit_service', 'uses' => 'service@edit'));
  Route::put('service/update', array('uses' => 'service@update'));
 */

//Route::get('service/getTaxi/(:any)', array('uses' => 'service@gettaxi'));
//Solicitar un taxi
Route::post('service/request', array('before' => 'userAuth', 'uses' => 'service@request'));
//Consulta del estado del servicio en la base de datos, $_POST['service_id']
Route::post('service/status', array('uses' => 'service@status'));
//Confirmación de la toma de servicio
Route::post('service/confirm', array('before' => 'myAuth', 'uses' => 'service@confirm'));
//Confirmación de la llegada del conductor
//Route::post('service/arrived', array('before' => 'myAuth', 'uses' => 'service@arrived'));
Route::post('service/arrived', array('uses' => 'service@arrived'));
//Mapeo de historial de conductor
Route::post('log/save', array('before' => 'myAuth', 'uses' => 'log@save'));
//Confirmación de subida del usuario
Route::post('service/ride', array('before' => 'myAuth', 'uses' => 'service@ride'));
//Confirmación de finalización del servicio
//Route::post('service/finish', array('before' => 'myAuth', 'uses' => 'service@finish'));
Route::post('service/finish', array('uses' => 'service@finish'));
//Confirmación de finalización del servicio por parte del conductor
Route::post('service/finish2', array('uses' => 'service@finish'));
//Calificación del servicio
//Route::post('service/score', array('before' => 'userAuth', 'uses' => 'service@score'));
Route::post('service/score', array('uses' => 'service@score'));
//Cancelar servicio Usuario
Route::post('service/cancel', array('before' => 'userAuth', 'uses' => 'service@cancelservice'));
//Cancelar servicio Conductor
Route::post('driver/cancel', array('before' => 'myAuth', 'uses' => 'service@drivercancel'));
//Cancelar servicio sistema
Route::post('service/systemcancel', array('uses' => 'service@systemcancel'));
//Retraso conductor
Route::post('driver/late', array('before' => 'myAuth', 'uses' => 'service@driverlate'));
//Historial del servicio
Route::post('service/user', array('before' => 'userAuth', 'uses' => 'service@user'));
Route::post('service/user2', array('uses' => 'service@user'));
//Historial del servicio
//Route::post('service/driver', array('before' => 'myAuth', 'uses' => 'service@driver'));
Route::post('service/driver', array('uses' => 'service@driver'));
//Test timer
Route::post('service/test', array('uses' => 'service@test'));
//Timer
Route::post('service/time', array('uses' => 'service@time'));
//Push Notification test service
Route::post('service/pusher', array('uses' => 'service@pusher'));
//De agendamiento a servicio
Route::post('service/cmsrequest', array('uses' => 'service@cmsrequest'));
//Cancelacion de servicio por parte de la operadora
Route::post('service/cmscancelservice', array('uses' => 'service@cmscancelservice'));

//Agendamientos
//Agendamiento
//Crear agendamiento
//Route::post('schedule/create', array('before' => 'userAuth', 'uses' => 'schedule@create'));
Route::post('schedule/create', array('uses' => 'schedule@create'));

//Asignar agendamiento
Route::post('schedule/asignar', array('uses' => 'schedule@asignar'));
//Marcar como en progreso
Route::post('schedule/progress', array('uses' => 'schedule@progress'));
//Cancelar agendamiento
Route::post('schedule/cancel', array('before' => 'userAuth', 'uses' => 'schedule@cancel'));
//Cancelar agendamiento
Route::post('schedule/cancelcms', array('uses' => 'schedule@cancelcms'));
//Finalizar y calificar agendamiento
Route::post('schedule/finish', array('before' => 'userAuth', 'uses' => 'schedule@finish'));
//Agendamientos por usuario
Route::post('schedule/user', array('before' => 'userAuth', 'uses' => 'schedule@user'));
//Agendamientos por conductor
Route::post('schedule/driver', array('before' => 'myAuth', 'uses' => 'schedule@driver'));
//De agendamiento a servicio
Route::post('schedule/daily', array('uses' => 'schedule@daily'));
//De agendamiento a servicio
Route::post('schedule/toservice', array('uses' => 'schedule@toservice'));
//Detalles de agendamiento
Route::post('schedule/details', array('uses' => 'schedule@details'));


Route::post('country', array('uses' => 'country@countries'));
Route::post('department', array('uses' => 'department@departments'));
Route::post('city', array('uses' => 'city@cities'));

Route::post('payment/confirm', array('uses' => 'payment@confirm'));

//controlador para quejas
Route::Controller('complain');
//Versionamiento de aplicacion
Route::post('app/versions', function(){
  $userVersions = AppVersion::where('version_type_id', '=', 1)->get();
  $driverVersions = AppVersion::where('version_type_id', '=', 2)->get();

  $func = function($value) {
    return array('id' => $value->id, 'version' => $value->version, 'device_type' => $value->device_type);
  };

  $userVersionsArray = array_map($func, $userVersions);
  $driverVersionsArray = array_map($func, $driverVersions);
  return Response::json(array("userVersions" => $userVersionsArray, "driverVersions" => $driverVersionsArray));
});

//Controlador para pruebas
Route::Controller('test');



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
            return Response::error('404');
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
Route::filter('myAuth', function() {

            //if ((User::login(Input::get('login'), Input::get('pwd'), Input::get('uuid'), true)) == false && (Driver::login(Input::get('login'), Input::get('pwd'), Input::get('uuid'), true)) == false) {
            if (Driver::checkDevice(Input::get('driver_id'), Input::get('uuid')) != TRUE) {
                return Response::json(array(
                            'error' => '401' // 1 ó 0 Error
                                )
                );
            }
        }
);
Route::filter('userAuth', function() {

            //if ((User::login(Input::get('login'), Input::get('pwd'), Input::get('uuid'), true)) == false && (Driver::login(Input::get('login'), Input::get('pwd'), Input::get('uuid'), true)) == false) {
            if (User::checkDevice(Input::get('user_id'), Input::get('uuid')) != TRUE) {
                return Response::json(array('error' => '401')); // 1 ó 0 Error
            }
        }
);

Route::filter('after', function($response) {
            // Do stuff after every request to your application...
        });

Route::filter('csrf', function() {
            if (Request::forged())
                return Response::error('500');
        });

Route::filter('auth', function() {
            if (Auth::guest())
                return Redirect::to('login');
        });

Route::filter('timer_cond', function($service) {
            $data = json_decode($service->content, true);
            //dd($data['id']);
            $servicio = Service::find($data['id']);

            $tmpService = new Service();
            $habemusTaxis = $tmpService->requestService(false, $servicio->from_lat, $servicio->from_lng);
            /* if ($habemusTaxis) {
              return Response::eloquent($habemusTaxis);
              } else {
              dd($tmpService);
              } */
            //Disponibilidad para cancelar
            $tmpService = new Service();
            $habemusTaxis = $tmpService->requestService(FALSE, $servicio->from_lat, $servicio->from_lng);
            if (isset($habemusTaxis)) {
                $startMin = microtime();
                $getService = false;
                $taxistasDisponibles = true;
                $minDiff = 0;
                while ($minDiff < 5 && $getService == false && $taxistasDisponibles == TRUE) {
                    $mtime = microtime();
                    $mtime = explode(' ', $mtime);
                    $mtime = $mtime[1] + $mtime[0];

                    $smtime = $startMin;
                    $smtime = explode(' ', $smtime);
                    $smtime = $smtime[1] + $smtime[0];

                    $diff = $mtime - $smtime;

                    $minsDiff = floor($diff / 60);
                    $diff -= $minsDiff * 60;

                    if ($tmpService->requestService(false, $servicio->from_lat, $servicio->from_lng)) {
                        $taxistasDisponibles = TRUE;
                    } else {
                        $taxistasDisponibles = FALSE;
                    }
                    $tmpObj = Service::find($servicio->id);
                    if ($tmpObj->driver_id != NULL) {
                        $getService = true;
                    }
                }
                if ($getService == false) {
                    $id = $servicio->id;
                    //Si hay conductor, notificar
                    Service::update($id, array(
                        'status_id' => '6'
                    ));
                    //Notificar a usuario!!
                    $pushMessage = 'En el momento no hay taxis disponibles';

                    $servicio = Service::find($id);
                    $push = Push::make();
                    if ($servicio->user->type == '1') {//iPhone
                        $preventEcho = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav');
                    } else {
                        $preventEcho = $push->android($servicio->user->uuid, $pushMessage);
                    }
                }
            } else {
                $id = $servicio->id;
                //Si hay conductor, notificar
                Service::update($id, array(
                    'status_id' => '6'
                ));
                //Notificar a usuario!!
                $pushMessage = 'En el momento no hay taxis disponibles';

                $servicio = Service::find($id);
                $push = Push::make();
                if ($servicio->user->type == '1') {//iPhone
                    $preventEcho = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav');
                } else {
                    $preventEcho = $push->android($servicio->user->uuid, $pushMessage);
                }
            }
        });
