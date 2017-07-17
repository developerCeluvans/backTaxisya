<?php

/**
 * Description of Service Controller
 *
 * @author IngJohnGuerrero
 */
class Service_Controller extends Base_Controller {

    public $restful = true;

    public function get_index() {

        //return View::make('service.index');
        //dd(Service::order_by('id')->get());
        return View::make('service.index')
                        ->with('title', 'Servicios actuales')
                        ->with('servicios', Service::order_by('id')->get());
        //        $view = View::make('service.index', array('name' => 'John'))->with('age', '28');
        //        $view->location = 'California'; //dont work
        //        $view['specialty'] = 'PHP'; //dont work
        //        return Response::json($usuario->to_array());
    }

    public function get_view($id) {
        return View::make('service.view')
                        ->with('title', 'Usuario')
                        ->with('service', Service::find($id));
    }

    public function get_new() {
        return View::make('service.new')
                        ->with('title', 'nuevo Usuario');
    }

    public function post_create() {
        $validation = Service::validate(Input::all());
        if ($validation->fails()) {
            return Redirect::to_route('new_service')->with_errors($validation)->with_input();
        } else {
            Service::create(array(
                'name' => Input::get('name'),
                'lastname' => Input::get('lastname'),
                'email' => Input::get('email'),
                'login' => Input::get('login'),
                'pwd' => md5(Input::get('pwd'))
            ));
            return Redirect::to_route('service')->with('message', 'Usuario ' . input::get('name') . ' creado!');
        }
    }

    public function post_register() {
        dd(Input::all());
        Service::create(array(
            'user_id' => Input::get('user_id'),
            'status_id' => Input::get('status_id'),
            'from_lng' => Input::get('crt_lng'),
            'from_lat' => Input::get('crt_lat'),
            'index_id' => Input::get('index'),
            'comp1' => Input::get('comp1'),
            'conp2' => Input::get('comp2'),
            'no' => Input::get('no'),
            'barrio' => Input::get('barrio'),
            'obs' => Input::get('obs')
        ));
    }

    public function post_confirm() {
        $id = Input::get('service_id');
        $servicio = Service::find($id);
        //dd($servicio);
        usleep(400);
        if ($servicio != NULL) {
            if ($servicio->status_id == '6') {
                return Response::json(array('error' => '2'));
            }
            if ($servicio->driver_id == NULL && $servicio->status_id == '1') {
                $servicio = Service::update($id, array(
                            'driver_id' => Input::get('driver_id'),
                            'status_id' => '2'
                                //Up Carro
                                //,'pwd' => md5(Input::get('pwd'))
                ));
                Driver::update(Input::get('driver_id'), array(
                    "available" => '0'
                ));
                $driverTmp = Driver::find(Input::get('driver_id'));
                Service::update($id, array(
                    'car_id' => $driverTmp->car_id
                        //Up Carro
                        //,'pwd' => md5(Input::get('pwd'))
                ));
                //Notificar a usuario!!
                $pushMessage = 'Tu servicio ha sido confirmado!';
                /* $servicio = Service::find($id);
                  $push = Push::make();
                  if ($servicio->user->type == '1') {//iPhone
                  $pushAns = $push->ios($servicio->user->uuid, $pushMessage);
                  } else {
                  $pushAns = $push->android($servicio->user->uuid, $pushMessage);
                  } */
                $servicio = Service::find($id);
                $push = Push::make();
                if ($servicio->user->uuid == '') {
                    return Response::json(array('error' => '0'));
                }
                if ($servicio->user->type == '1') {//iPhone
                    $result = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav', 'Open', array('serviceId' => $servicio->id));
                } else {
                    $result = $push->android2($servicio->user->uuid, $pushMessage, 1, 'default', 'Open', array('serviceId' => $servicio->id));
                }
                return Response::json(array('error' => '0'));
            } else {
                return Response::json(array('error' => '1'));
            }
        } else {
            return Response::json(array('error' => '3'));
        }
    }

    public function post_arrived() {
        $data = array();
        $id = Input::get('service_id');
        $driverData = Driver::find(Input::get('driver_id'));
        $servicio = Service::find($id);
        if ($servicio && ($servicio->status_id == '2' || $servicio->status_id == 2)){
            $servicio_status = Service::update($id, array(
                        //'driver_id' => Input::get('driver_id'),
                       // 'from_lat' => $driverData->crt_lat,
                        //'from_lng' => $driverData->crt_lng,
                        'status_id' => '4' //Terminado
                            //'status_id' => '3' //En progreso
                            //Up Carro
                            //,'pwd' => md5(Input::get('pwd'))
            ));
            //Notificar a usuario!!
            if ($servicio_status) {
                $pushMessage = 'Llego el taxi!';

                $service = Service::find($id);
                $payload = array();
                $payload['kind_id'] = $service->kind_id;
                $payload['service_id'] = $service->id;
                $payload['status_id'] = $service->status_id;
                // Notifier::user($service->user, PushType::DRIVER_ARRIVED);
                Notifier::user($service->user, PushType::DRIVER_ARRIVED,$payload);
            }
            return ($servicio_status) ? JSONResponse::success() : JSONResponse::error(404);
        } else {
            $servicio_status = 404;
            if ($servicio){
                $servicio_status = $servicio->status_id;
            }
           return JSONResponse::error($servicio_status); 
        }

        /* DESDE ACA
        if ($servicio->user->uuid == '') {
            return Response::json(array('error' => '0'));
        }
        $push = Push::make();
        $data['push_type'] = 5;
        if ($servicio->user->type == '1') {//iPhone
            $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav','Open',$data);
        } else {
            $push->android2($servicio->user->uuid, $pushMessage,1, 'honk.wav','Open',$data);
        }
        return Response::json(array('error' => '0'));
        HASTA ACA
        */
    }

    public function post_ride() {
        $id = Input::get('service_id');
        $servicio = Service::update($id, array(
                    'driver_id' => Input::get('driver_id'),
                    'status_id' => '4'
                        //Up Carro
                        //,'pwd' => md5(Input::get('pwd'))
        ));
        //Notificar a usuario!!
        //$pushMessage = 'Llego el taxi!';
        //$servicio = Service::find($id);

        /* $push = Push::make();
         * id(Android or iPhone)
          $push->ios($servicio->user->uuid, $pushMessage); */
        return Response::json(array('error' => '0'));
    }

    public function post_ticket() {
        $ticket = Input::get('ticket');
        $query = "SELECT * FROM ticket_tickets WHERE ticket = '".$ticket."' AND status = 0";
        $result = DB::query($query);
        if ($result) {
            return Response::json(array('status' => 'ok', 'error' => '0', 'message' => 'Vale correcto'));
        } else {

            //return Response::json(array('status' => 'error', 'error' => '1', 'message' => 'Vale incorrecto o ya utilizado' ));
            return Response::json(array('status' => 'error', 'error' => '1', 'message' => 'Vale incorrecto o ya utilizado '.$ticket ));

        }
    } 

    public function post_score() {
        $id = Input::get('service_id');
        $score = Input::get('qualification');

        // $servicio = Service::update($id, array('qualification' => Input::get('qualification'),
        //                 //'status_id' => '5' Terminado
        //                 //Up Carro
        //                 //,'pwd' => md5(Input::get('pwd'))
        // ));
        $query = "UPDATE services SET qualification = ".$score." WHERE id = ".$id.";";
        $result = DB::query($query);
        //$servicio = Service::find($id);
//return Response::json(array('Response' => 'ok')); Original
        if ($result) {
        //if ($servicio) {
            return Response::json(array('Response' => 'ok', 'error' => '0'));
        } else {
            return Response::json(array('Response' => 'error', 'error' => '1'));
        }
    }

    public function post_cancelservice() {
        $id = Input::get('service_id');
        $actService = Service::find($id);
        if ($actService->status_id == '5') {
            return Response::json(array('error' => '0'));
        } else {
            //Si hay conductor, notificar
            $user = User::find(Input::get('user_id'));
            $user->cancel_service();

            if (isset($actService->driver_id)) {
               
               // Notifier::driver($actService->driver, $push_type, $data = array());

                $push = Push::make();
                $msg = "El servicio ha sido cancelado por el usuario";
                //$push->android($actService->driver->uuid, $msg);

                if (strlen($service->driver->uuid) > 64) { // android
                    //dd("driver android");
                    $androidDevices[] = $$actService->driver->uuid;
                    $result = $push->drivers($androidDevices, PushType::message($push_type), 1, 'default', 'Open', $data);
                   //   $result = $push->drivers($androidDevices, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
                }
                else { // ios
                    //dd("driver iOS");
                    $result = $push->taxistas_ios($actService->driver->uuid, PushType::USER_CANCELED_SERVICE, 1, 'honk.wav', 'Open', $data);
                }
            }
        }
        return Response::json(array('error' => '0'));
    }

    public function post_cmscancelservice() {
        if (Input::json()) {
            $data = Input::json();
            $id = $data->serviceId;
        } else {
            $id = Input::get('serviceId');
        }
        $actService = Service::with('user')->find($id);
        if ($actService->status_id == '5') {
            //return Response::json(array('error' => '0'));
        } else {
            //Si hay conductor, notificar
            Service::update($id, array(
                'status_id' => '9'
            ));

            Notifier::user($actService->user, PushType::OPERATOR_CANCELED_SERVICE);

            if (!is_null($actService->driver_id)) {
                $driver = Driver::find($actService->driver_id);
                Notifier::driver($driver, PushType::OPERATOR_CANCELED_SERVICE, array('service_id' => $id));
                $driver->available = '1';
                $driver->save();
            } else {
                $payload = array();
                $payload['service_id'] = $actService->id;
                Notifier::available_drivers(PushType::REMOVE_SERVICE, $payload);
            }

            /* if (isset($actService->driver_id)) {
              $push = Push::make();
              $msg = "El servicio ha sido cancelado por la operadora";
              $push->android($actService->driver->uuid, $msg);
              } */
        }
        //return Response::json(array('error' => '0'));
        return Response::eloquent(Service::find($id));
    }

    public function post_drivercancel() {
        $id = Input::get('service_id');
        //Si hay conductor, notificar


        // TODO: status restablecido


        $result = Service::update($id, array(
                    'status_id' => '8'
                        //,'pwd' => md5(Input::get('pwd'))
        ));


        $actService = Service::find($id);
        if (isset($actService->user_id)) {
            $push = Push::make();
            $pushMessage = "El servicio ha sido cancelado por el conductor";
            if ($actService->user->type == '1') {//iPhone
                $preventEcho = $push->ios($actService->user->uuid, $pushMessage, 1, 'honk.wav');
            } else {
                $preventEcho = $push->android2($actService->user->uuid, $pushMessage);
            }
        }
        if ($result) {
            return Response::json(array('error' => '0'));
        } else {
            return Response::json(array('error' => '1'));
        }
    }

    public function post_systemcancel() {
        if (Input::json()) {
            $data = Input::json();
            $id = $data->service_id;
        } else {
            $id = Input::get('service_id');
        }
        //Si hay conductor, notificar
        /* $result = Service::update($id, array(
          'status_id' => '7'
          //,'pwd' => md5(Input::get('pwd'))
          )); */
        $actService = $service = Service::find($id);
        /*
          if (isset($actService->user_id)) {
          $push = Push::make();
          $pushMessage = "En el momento no hay taxistas disponibles";
          if ($actService->user->type == '1') {//iPhone
          $preventEcho = $push->ios($actService->user->uuid, $pushMessage, 1, 'honk.wav');
          } else {
          $preventEcho = $push->android2($actService->user->uuid, $pushMessage);
          }
          } */

        //$service = $this->active_service()->with('user')->first();
        if (!is_null($actService->driver_id)) {
            $driver = Driver::find($actService->driver_id);
            Notifier::driver($driver, PushType::OPERATOR_CANCELED_SERVICE, array('service_id' => $id));
            $driver->available = '1';
            $driver->save();
        } else {
            $payload = array();
            $payload['service_id'] = $actService->id;
            Notifier::available_drivers(PushType::REMOVE_SERVICE, $payload);
        }

        $sucess = false;
        if ($service) {
            $service->status_id = '7';
            $sucess = $service->save();
            Notifier::user($service->user, PushType::SYSTEM_CANCELED_SERVICE);
        }

        if ($sucess) {
            return Response::json(array('error' => '0'));
        } else {
            return Response::json(array('error' => '1'));
        }
    }

    public function post_driverlate() {
        $id = Input::get('service_id');

        $actService = Service::find($id);
        if (isset($actService->user_id)) {
            $push = Push::make();
            $msg = "Se presento algo, me demoro 5 minutos";

            if ($servicio->user->type == '1') {//iPhone
                $preventEcho = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav');
            } else {
                $preventEcho = $push->android2($servicio->user->uuid, $pushMessage);
            }
        }
        return Response::json(array('error' => '0'));
    }

    public function post_finish() {
        $data = array();
        $id = Input::get('service_id');
        $driverid = Input::get('driver_id');

        $respuesta = Service::update($id, array(
            'status_id' => '5',
            'to_lat' => Input::get('to_lat'),
            'to_lng' => Input::get('to_lng'),

                'units'   => Input::get('units'),
                'charge1' => Input::get('charge1'),
                'charge2' => Input::get('charge2'),
                'charge3' => Input::get('charge3'),
                'charge4' => Input::get('charge4'),
                'value'   => Input::get('value'),
                'pay_reference'   => Input::get('transaction_id'),

                //'finish_datetime' => Input::get('finish_datetime'),
                //'qualification' => Input::get('qualification')
                //,'pwd' => md5(Input::get('pwd'))
        ));
        //if($driverid<>'')
        if ($respuesta == true || $respuesta == 0)
        {
            $pushMessage = 'Gracias por utilizar TaxisYa, lo invitamos a calificar nuestro servicio';

            $servicio = Service::find($id);

            if($servicio->user->uuid != '') {

                if ($servicio->pay_type == '3') {
                    $ticket = $servicio->user_card_reference;

                    //dd($ticket);
                    //$query_service = "SELECT * FROM tickets WHERE ticket = '". $ticket . "';";
                    $query_service = "UPDATE ticket_tickets SET status = 1 WHERE ticket = '". $ticket . "';";
                    $resp_service = DB::query($query_service);    
                    //$ticket2 = $resp_service[0]->ticket;
                    //dd($ticket2);
                }
                /*
                // TODO: si el servicio es de vale obtener la empresa del vale
                $query_service = "SELECT * FROM tickets WHERE ticket = ". $ticket . ";";
                $resp_service = DB::query($query_service);
                if (!$resp_service) {

                }
                else {
                    $ticket = $resp_service[0]->ticket;

                }
                */
            }
            

            // marcar el vale como utilizado

            // actualizar la empresa en el servicio


            if ($servicio->user->uuid == '') {
                return Response::json(array('error' => '0'));
            }
            $push = Push::make();
            $data['push_type'] = 7;
            $data['service_id'] = $servicio->id;
            $data['user_id'] = $servicio->user_id;
            $data['status_id'] = $servicio->status_id;
            $data['qualification'] = $servicio->qualification;

            $data['units'] = $servicio->units;
            $data['charge1'] = $servicio->charge1;
            $data['charge2'] = $servicio->charge2;
            $data['charge3'] = $servicio->charge3;
            $data['charge4'] = $servicio->charge4;
            $data['value'] = $servicio->value;
            $data['pay_reference'] = $servicio->pay_reference;



            if ($servicio->user->type == '1') {//iPhone
                $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav','Open',$data);
            } else {
                $push->android2($servicio->user->uuid, $pushMessage,1, 'honk.wav','Open',$data);
            }
            return Response::json(array('error' => '0'));
        } else {
            return Response::json(array('error' => '1'));
        }
    }

    public function get_edit($id) {
        return View::make('service.edit')
                        ->with('title', 'Edit service')
                        ->with('service', Service::find($id));
    }

    public function put_update() {
        $id = Input::get('id');
        //$validation = Service::validate(Input::all());
        //        $validation = Service::validate(Input::get('name'));
        //        $validation1 = Service::validate(Input::get('lastname'));
        //        $validation2 = Service::validate(Input::get('email'));
        //        $validation3 = Service::validate(Input::get('login'));
        //        if ($validation->fails() || $validation1->fails() || $validation2->fails() || $validation3->fails()) {
        //            return Redirect::to_route('edit_service', $id)->with_errors($validation);
        //        } else {
        Service::update($id, array(
            'name' => Input::get('name'),
            'lastname' => Input::get('lastname'),
            'cellphone' => Input::get('cellphone'),
            'login' => Input::get('login')
                //,'pwd' => md5(Input::get('pwd'))
        ));
        return Redirect::to_route('service', $id)->with('message', 'Usuario actualizado');
        //        }
    }

    /*    public function post_position() {
      $id = Input::get('id');
      Service::update($id, array(
      'crt_lat' => Input::get('lat'),
      'crt_lng' => Input::get('lng')
      ));
      } */

    public function get_gettaxi($id) {
        return View::make('service.solicitud')
                        ->with('title', 'Usuario solicita taxi')
                        ->with('user', User::find($id));
    }

    public function post_request() {
        $id = Input::get('user_id');
        //$userData = User::find($id);
        $login = Input::get('login');
        $pwd = Input::get('pwd');
        $lat = Input::get('crt_lat');
        $lng = Input::get('crt_lng');
        //dd('Hey!');
        //crear el servicio en la base de datos y regresar el id del servicio
        //Se puede desde el usuario con la relacion de hasmany
        $servicio = Service::create(array(
                    'user_id' => $id,
                    'status_id' => '1',
                    'from_lng' => Input::get('crt_lng'),
                    'from_lat' => Input::get('crt_lat'),
                    'index_id' => Input::get('index_id'),
                    'comp1' => Input::get('comp1'),
                    'comp2' => Input::get('comp2'),
                    'no' => Input::get('no'),
                    'barrio' => Input::get('barrio'),
                    'obs' => Input::get('obs'),
                    'kind_id' => '1',
        ));
        //agregar direccion a favoritos
        $addressData = DB::table('users_dirs')
                ->where_index_id_and_comp1_and_comp2_and_no_and_barrio_and_user_id(Input::get('index_id'), Input::get('comp1'), Input::get('comp2'), Input::get('no'), Input::get('barrio'), Input::get('user_id'))
                ->first();
        if ($addressData) {
            //return json_encode(array('error' => '1')); //Direccion existente
            //$addressObj=  Address::find($addressData->id);
            Address::update($addressData->id, array(
                'user_pref_order' => $addressData->user_pref_order + 1
            ));
        } else {
            $actAdrsRecord = DB::table('users_dirs')->where_user_id(Input::get('user_id'))->count();
            if ($actAdrsRecord >= 4) {
                $adrsMin = DB::table('users_dirs')->where_user_id(Input::get('user_id'))->min('user_pref_order');
                //dd($adrsMin);
                $adrsMinId = DB::table('users_dirs')->where_user_id(Input::get('user_id'))->where_user_pref_order($adrsMin)->first('id');
                Address::update($adrsMinId->id, array(
                    'index_id' => Input::get('index_id'),
                    'comp1' => Input::get('comp1'),
                    'comp2' => Input::get('comp2'),
                    'no' => Input::get('no'),
                    'barrio' => Input::get('barrio'),
                    'obs' => Input::get('obs'),
                    'user_id' => Input::get('user_id'),
                    'user_pref_order' => '0'
                ));
                //return json_encode(array('error' => '2')); //Lista llena
            } else {
                Address::create(array(
                    'index_id' => Input::get('index_id'),
                    'comp1' => Input::get('comp1'),
                    'comp2' => Input::get('comp2'),
                    'no' => Input::get('no'),
                    'barrio' => Input::get('barrio'),
                    'obs' => Input::get('obs'),
                    'user_id' => Input::get('user_id'),
                    'user_pref_order' => '0'
                ));
                //return direcciones de Direccion
                //return Address::getUsrAddresses(Input::get('user_id'));
            }
        }
        $tmpService = new Service();
        $habemusTaxis = $tmpService->requestService(false, $servicio->from_lat, $servicio->from_lng);
        //$habemusTaxis = true;
        if ($habemusTaxis) {
            $user = User::find(Input::get('user_id'));
            $user->notify_service($servicio);
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
                $preventEcho = $push->android2($servicio->user->uuid, $pushMessage);
            }
        }
        //$objAux = new Service();
        //Busqueda de conductores en el area!!!!!
        //$objAux->requestService($id, $lat, $lng, $servicio->id);
        //dd($servicio);
        //Controller::call('service@request_timed', array($servicio->id));
        //$this->filter('after', 'timer_cond', array($servicio));
        //$command = $_SERVER['DOCUMENT_ROOT'] . "/colombia_digital/controllers/request_control.php?id=" . $servicio->id;
        //exec($command);
        //echo $_SERVER['DOCUMENT_ROOT'];
        return Response::eloquent($servicio);
    }

    public function post_cmsrequest() {
        if (Input::json()) {
            $data = Input::json();
            $user_id = $id = $data->usr_id;
            $index_id = $data->dir_index_id;
            $comp1 = $data->dir_comp1;
            $comp2 = $data->dir_comp2;
            $no = $data->dir_no;
            $obs = $data->dir_obs;
            $barrio = $data->dir_barrio;
            $crt_lat = $data->lat;
            $crt_lng = $data->lng;


            //dd('Hey!');
            //crear el servicio en la base de datos y regresar el id del servicio
            //Se puede desde el usuario con la relacion de hasmany
            $servicio = Service::create(array(
                        'user_id' => $user_id,
                        'status_id' => '1',
                        'from_lng' => $crt_lng,
                        'from_lat' => $crt_lat,
                        'index_id' => $index_id,
                        'comp1' => $comp1,
                        'comp2' => $comp2,
                        'no' => $no,
                        'barrio' => $barrio,
                        'obs' => $obs,
                        'kind_id' => '3'
            ));
            //agregar direccion a favoritos
            $addressData = DB::table('users_dirs')
                    ->where_index_id_and_comp1_and_comp2_and_no_and_barrio_and_user_id($index_id, $comp1, $comp2, $no, $barrio, $id)
                    ->first();
            if ($addressData) {
                //return json_encode(array('error' => '1')); //Direccion existente
                //$addressObj=  Address::find($addressData->id);
                Address::update($addressData->id, array(
                    'user_pref_order' => $addressData->user_pref_order + 1
                ));
            } else {
                $actAdrsRecord = DB::table('users_dirs')->where_user_id($id)->count();
                if ($actAdrsRecord >= 4) {
                    $adrsMin = DB::table('users_dirs')->where_user_id($id)->min('user_pref_order');
                    //dd($adrsMin);
                    $adrsMinId = DB::table('users_dirs')->where_user_id($id)->where_user_pref_order($adrsMin)->first('id');
                    Address::update($adrsMinId->id, array(
                        'index_id' => $index_id,
                        'comp1' => $comp1,
                        'comp2' => $comp2,
                        'no' => $no,
                        'barrio' => $barrio,
                        'obs' => $obs,
                        'user_id' => $id,
                        'user_pref_order' => '0'
                    ));
                    //return json_encode(array('error' => '2')); //Lista llena
                } else {
                    Address::create(array(
                        'index_id' => $index_id,
                        'comp1' => $comp1,
                        'comp2' => $comp2,
                        'no' => $no,
                        'barrio' => $barrio,
                        'obs' => $obs,
                        'user_id' => $id,
                        'user_pref_order' => '0'
                    ));
                    //return direcciones de Direccion
                    //return Address::getUsrAddresses(Input::get('user_id'));
                }
            }
            $tmpService = new Service();
            // $habemusTaxis = $tmpService->requestServiceEsteban(false, $servicio->from_lat, $servicio->from_lng);

            //!!!!! API V2!!!!!!
            $user = new User;
            $user->name = $data->usr_name;
            $user->notify_service($servicio, DB::query("SELECT * FROM drivers WHERE available =  '1';"));
            //!!!!! FIN API V2!!!!!!
            //$habemusTaxis = true;
            /*if ($habemusTaxis) {
                /* if ($servicio->user->type == '2') {
                  //return Response::eloquent($habemusTaxis);
                  $curl = New Curl;
                  // Simple call to CI URI
                  $curl->simple_post('service/time', array('service_id' => $servicio->id));
                  } */
            /*} else {
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
                  $preventEcho = $push->android2($servicio->user->uuid, $pushMessage);
                  }

            }*/
            //$objAux = new Service();
            //Busqueda de conductores en el area!!!!!
            //$objAux->requestService($id, $lat, $lng, $servicio->id);
            //dd($servicio);
            //Controller::call('service@request_timed', array($servicio->id));
            //$this->filter('after', 'timer_cond', array($servicio));
            //$command = $_SERVER['DOCUMENT_ROOT'] . "/colombia_digital/controllers/request_control.php?id=" . $servicio->id;
            //exec($command);
            //echo $_SERVER['DOCUMENT_ROOT'];
            $defService = Service::find($servicio->id);
            return Response::eloquent($defService); //$servicio);
        } else {
            return Response::json(array('error' => '1', 'msg' => 'Bad access'));
        }
    }

    public function post_test() {
        $curl = New Curl;
        // Simple call to CI URI
        $curl->simple_post('service/time', array('foo' => 'bar'));
        //dd($curl);
        return Response::json(array('worked' => 'ok'));
    }

    public function post_time() {
        $testObs = false;
        if ($testObs) {
            $user_id = '43';
            $pushMessage = "Comienza la cuenta, servicio:" . Input::get('service_id');
            $testUser = User::find($user_id);


            $push = Push::make();
            if ($testUser->type == '1') {//iPhone
                $preventEcho = $push->ios($testUser->uuid, $pushMessage, 1, 'honk.wav');
            } else {
                $preventEcho = $push->android2($testUser->uuid, $pushMessage);
            }
        }
        $service_id = Input::get('service_id');
        $servicio = Service::find($service_id);
        $tmpService = new Service();
        list($usec, $sec) = explode(" ", microtime());

        $startSecs = $sec;
        /* sleep(60); */
        list($newUsec, $newSecs) = explode(" ", microtime());
        //echo $newSecs-$startSecs;
        $oldSecs = 0;
        $timeLimit = 60;
        while (($newSecs - $startSecs) <= $timeLimit) {
            $habemusTaxis = $tmpService->requestService(false, $servicio->from_lat, $servicio->from_lng);
            //$habemusTaxis=true;
            if ($habemusTaxis) {
                $servicio = Service::find($service_id);
                if ($servicio->status_id > 1) {
                    return true;
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
                    $preventEcho = $push->android2($servicio->user->uuid, $pushMessage);
                }
                return false;
            }
            list($usec, $newSecs) = explode(" ", microtime());
            if (($newSecs - $startSecs) != $oldSecs) {
                echo "Seg. transcurridos: " . $oldSecs . "<br>";
            }

            $oldSecs = $newSecs - $startSecs;
        }
        if ($oldSecs >= $timeLimit) {
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
                $preventEcho = $push->android2($servicio->user->uuid, $pushMessage);
            }
            if ($user_id) {
                $pushMessage = "El tiempo transcurrido es $oldSecs segundos,servicio:" . Input::get('service_id');
                $push = Push::make();
                if ($testUser->type == '1') {//iPhone
                    $preventEcho = $push->ios($testUser->uuid, $pushMessage, 1, 'honk.wav');
                } else {
                    $preventEcho = $push->android2($testUser->uuid, $pushMessage);
                }
            }
            return Response::json(array("summary" => 'we\'re done'));
        }
        return Response::json(array("summary" => 'Houston!!!'));
    }

    public function post_status() {
        if (Input::get('driver_id','') != '') {
            $driver_id = Input::get('driver_id');
            if (Input::get('service_id','') != '') {
                $result = Service::where('id','=',Input::get('service_id'))->where_driver_id($driver_id)->first();
                //$result = Service::find(Input::get('service_id'));
            } else {    
               
                $statuses = array(2,4,8);
                $result = Service::where_in('status_id',$statuses)->where_driver_id($driver_id)->first();
            }    
        } else {    
            //if (Input::has('service_id')) {
            if (Input::get('service_id','') != '') {
                $id = Input::get('service_id');
                $result = Service::find($id);
            } else{
                //if (Input::has('user_id')){
                if (Input::get('user_id','') != ''){
                    $user_id = Input::get('user_id');
                    $statuses = array(2,5,4,1);
                    $result = Service::where_in('status_id',$statuses)->where_user_id($user_id)->where('kind_id','<>','3')->where_null('qualification')->order_by('status_id')->order_by('created_at')->first();
                }else {
                    if (!Input::has('json')) {
                        // se asume que json = false
                        // y viene el driver_id
                        $driver_id = Input::get('driver_id');
                        $statuses = array(2,4);
                        $result = Service::where_in('status_id',$statuses)->where_driver_id($driver_id)->first();
                    }
                    else {
                        $data = Input::json();
                        if(!property_exists($data, 'service_id')){
                            if(property_exists($data, 'user_id')){
                                   $statuses = array(2,5,4,1);
                                   $result = Service::where_in('status_id',$statuses)->where_user_id($data->user_id)->where('kind_id','<>','3')->where_null('qualification')->order_by('status_id')->order_by('created_at')->first();
                                   //$result = Service::where_in('status_id',$statuses)->where_user_id($data->user_id)->where_null('qualification')->order_by('created_at', 'DESC')->first();
                                //$result = Service::where_status_id(2)->where_user_id($data->user_id)->first();
                            }else{
                                $statuses = array(2,4);
                                $result = Service::where_in('status_id',$statuses)->where_driver_id($data->driver_id)->first();
                            }
                        }else{
                                $id = $data->service_id;
                                $result = Service::find($id);
                        }
                    }
                }
            }
        }    
        if (isset($result)) {
            return Response::eloquent($result);
        } else {
            return Response::json(array('error' => '100'));
        }
    }

    public function post_pusher() {
        $push = Push::make();
        if (Input::get('type') == '1') {//iPhone
            return $push->ios(Input::get('uuid'), Input::get('msg'));
        } elseif (Input::get('type') == '2') {
            return $push->android2(Input::get('uuid'), Input::get('msg'), 1, 'default', 'Open', array('service_id' => Input::get('service_id')));
        } else {
            return $push->android(Input::get('uuid'), Input::get('msg'));
        }
    }

    public function post_user() {
        $id = Input::get('user_id');
        $month = Input::get('month');
        $day = Input::get('day');
        $year = Input::get('year');;
        $fecha;
        $nuevafecha;
        if (!isset($year)) {
            $year = date('Y');
        }
        if (!isset($month)) {
            $month = date('n');
        }
        if(!isset($day)){
            $day = date('d');
            $fecha = DateTime::createFromFormat("d/m/Y H:i:s", $day."/".$month."/".$year. " 23:59:59");
            print_r($fecha,true);
            $nuevafecha = date('Y-m-d H:i:s', strtotime ( '-1 month' , strtotime (''.$fecha->date.''))) ;
        } else {
            $fecha = DateTime::createFromFormat("d/m/Y H:i:s", $day."/".$month."/".$year. " 23:59:59");
            print_r($fecha,true);
            $fecha2 = DateTime::createFromFormat("d/m/Y H:i:s", $day."/".$month."/".$year. " 00:00:00");
            print_r($fecha2,true);
            $nuevafecha = $fecha2->date;
            print_r($nuevafecha,true);
        }

       // $fecha = DateTime::createFromFormat("d/m/Y H:i:s", $day."/".$month."/".$year. " 23:59:59");
        //print_r($fecha,true);

        //$nuevafecha = date('Y-m-d H:i:s', strtotime ( '-1 month' , strtotime (''.$fecha->date.''))) ;

        $daysOfServices = DB::table('services')->where('user_id', '=', $id)
                    //->where(DB::RAW('MONTH(updated_at)'), '=', $month)
                    //->where(DB::RAW('YEAR(updated_at)'), '=', $year)
                    //->where(DB::RAW('DAY(updated_at)'),'>=',$day2-7)
                    ->where_between('updated_at', $nuevafecha, $fecha->date)
                    ->where_status_id('5')
                    ->order_by('updated_at','DESC')
                    ->group_by(DB::RAW('DAY(updated_at)'))
                    ->get(array(DB::RAW('DAY(updated_at) as day'), DB::RAW('MONTH(updated_at) as month'), DB::RAW('YEAR(updated_at) as year')));
        
        /*
        $currentDay = date('j');
        if($currentDay < 5){
            $month = (($month-1) == 0)? 1 : $month-1;
        }

        
        if (isset($day2) && $day2 > 7) {
            $daysOfServices = DB::table('services')->where('user_id', '=', $id)
                    ->where(DB::RAW('MONTH(updated_at)'), '=', $month)
                    ->where(DB::RAW('YEAR(updated_at)'), '=', $year)
                    ->where(DB::RAW('DAY(updated_at)'),'>=',$day2-7)
                    ->where_status_id('5')
                    ->group_by(DB::RAW('DAY(updated_at)'))
                    ->get(array(DB::RAW('DAY(updated_at) as day')));
        }
        else{
            $daysOfServices = DB::table('services')->where('user_id', '=', $id)
                    ->where(DB::RAW('MONTH(updated_at)'), '=', $month)
                    ->where(DB::RAW('YEAR(updated_at)'), '=', $year)
                    ->where_status_id('5')
                    ->group_by(DB::RAW('DAY(updated_at)'))
                    ->get(array(DB::RAW('DAY(updated_at) as day')));
        }*/
        /* $logArray = Service::where('user_id', '=', $id)
          ->where(DB::RAW('MONTH(updated_at)'), '=', $month)
          ->get(); */
        /* foreach ($logArray as $key => $value) {
          $logDefArray[]=$value->to_array();
          } */
        //return Response::json($logDefArray);
        //dd($daysOfServices['0']->day);
        if (!count($daysOfServices) > 0) {
            return Response::json(array('error' => '2'));
        }

        if ($daysOfServices != NULL) {
            if (!isset($day)) {
                $day = $daysOfServices['0']->day;
            }
            //Service::where('user_id','=',$id)->get()->to_array();
            /*
              select
              MONTH(updated_at),
              DAY(updated_at)
              from services
              where user_id=1
              and MONTH(updated_at)=5
              group by DAY(updated_at)
             */
            /*
              select
             *
              from
              services
              where
              MONTH(updated_at)=5
              AND DAY(updated_at)=2
             */

            $dayServices = Service::with(array('driver', 'car'))->where('user_id', '=', $id)
                            //->where(DB::RAW('MONTH(updated_at)'), '=', $month)
                            //->where(DB::RAW('YEAR(updated_at)'), '=', $year)
                            //->where_status_id('5')
                            ->where_between('updated_at', $nuevafecha, $fecha->date)
                            ->where_status_id('5')->get();
                            //->where(DB::RAW('DAY(updated_at)'), '=', $day)->get();
            $logDefArray = array();
            foreach ($dayServices as $key => $value) {
                $logDefArray[] = $value->to_array();
            }
            foreach ($daysOfServices as $key => $value) {
                //$dayDefArray[] = $value->day.'/'.$value->month.'/'.$value->year;

                $dayAux = $value->day;
                $monthAux = $value->month;
                $yearAux = $value->year;

                if ($dayAux < 10) {
                    $dayAux = '0'.$dayAux;

                }

                if ($monthAux < 10) {
                    $monthAux = '0'.$monthAux;

                }
                
                $dayDefArray[] = $yearAux.'-'.$monthAux.'-'.$dayAux;
               //$dayDefArray[] = print_r($value,true); 
            }
            return Response::json(array('dayList' => ($dayDefArray), 'services' => ($logDefArray)));
        } else {
            return Response::json(array('error' => '1'));
        }
    }

    public function post_driver() {
        $id = Input::get('driver_id');
        $month = Input::get('month');
        $day = Input::get('day');
        if (!isset($month)) {
            $month = date('n');
        }
        $daysOfServices = DB::table('services')->where('driver_id', '=', $id)
                ->where(DB::RAW('MONTH(updated_at)'), '=', $month)
                ->where_status_id('5')
                ->group_by(DB::RAW('DAY(updated_at)'))
                ->get(array(DB::RAW('DAY(updated_at) as day')));

        if (!count($daysOfServices) > 0) {
            return Response::json(array('error' => '2'));
        }

        if ($daysOfServices != NULL) {
            if (!isset($day)) {
                $day = $daysOfServices['0']->day;
            }
            //Service::where('user_id','=',$id)->get()->to_array();
            /*
              select
              MONTH(updated_at),
              DAY(updated_at)
              from services
              where user_id=1
              and MONTH(updated_at)=5
              group by DAY(updated_at)
             */
            /*
              select
             *
              from
              services
              where
              MONTH(updated_at)=5
              AND DAY(updated_at)=2
             */

            $dayServices = Service::with(array('user'))->where(DB::RAW('MONTH(updated_at)'), '=', $month)
                            ->where('driver_id', '=', $id)
                            ->where_status_id('5')
                            ->order_by('id', 'ASC')->get();
            //->where(DB::RAW('DAY(updated_at)'), '=', $day)->get();
            foreach ($dayServices as $key => $value) {
                $logDefArray[] = $value->to_array();
            }
            foreach ($daysOfServices as $key => $value) {
                $dayDefArray[] = $value->day;
            }
            //return Response::json(array('dayList' => ($dayDefArray), 'services' => ($logDefArray)));
            return Response::json(array('services' => ($logDefArray)));
        } else {
            return Response::json(array('error' => '1'));
        }
    }

}

?>
