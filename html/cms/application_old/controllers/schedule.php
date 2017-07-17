<?php

class Schedule_Controller extends Base_Controller {

    public $restful = true;

    public function post_index()
    {
		/*$Schedules = DB::query('SELECT * FROM appsuser_taxisya.schedules s order by service_date_time desc'); //ORDER BY comp.answered ASC, serv.updated_at ASC');
        $SchedulesDef = Array();
		foreach ($Schedules as $key => $Schedule) {
            $SchedulesDef[] = Schedule::find($Schedule->id);
			//$SchedulesDef[] = $Schedule;
        }*/

		//$SchedulesDef = Schedule::order_by('service_date_time', 'DESC')->get();
		//where('status','=','1')->
		//echo print_r($SchedulesDef,true);


        $customer_id = Auth::user()->customer_id;
        //dd($customer_id);

        $pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        //$schedules = Schedule::order_by('service_date_time', 'DESC')->order_by('status', 'ASC')->get();
        $schedules = Schedule::order_by('service_date_time', 'DESC')->where('cms_users_id','=',$customer_id)->order_by('status', 'ASC')->get();
        $section = strtolower($pieces[0]); //'section';
        //dd('WTF!!');
        $titleArray = array(//'No.' => 'id',
            'Fecha de agendamiento' => 'service_date_time',
            "Nombre usuario" => array(array("user", "name"), array("user", "lastname")),
            "Email usuario" => array("user", "email"),
            //'Usuario' => 'user_id',
            //'Conductor' => 'driver_id',
            //"Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
            'Tipo de agendamiento' => array("type", "descrip"), //'schedule_type',
            'Destino' => 'destination',
            /* 'Indicacion' => 'address_index',
              'comp1' => 'comp1',
              'comp2' => 'comp2',
              'no' => 'no',
              'Barrio' => 'barrio',
              'Fecha de solicitud' => 'created_at', */
            "comb_Dirección" => "address_index.comp1.comp2.no.barrio.obs",
                //'Estado' => 'status',
                //'Calificación' => 'score'
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => FALSE,
            'del' => FALSE,
            //'export' => TRUE,
            'total' => TRUE,
            /*'custom' => array(
                array("Generar servicio",
                    "edit",
                    $section,
                    "images/icon/color_18/checkmark2.png",
                    "(function(id){if(confirm(\"Desea generar servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),*/
            'tabs' => array("options" => array(
                    array("id" => "1",
                        "description" => "Pendientes"
                    ),
                    array(
                        "id" => "5",
                        "description" => "Finalizados"
                    )
                ),
                "tabber" => "status"
            )
        );
        return View::make('schedule.list')
                        ->with('title', 'Agendamientos: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
						//->with('items', $SchedulesDef);
                        //->with('items', $objName::order_by('service_date_time', 'DESC')->order_by('status', 'ASC')->get());
                        ->with('items', $schedules );

    }

    public function post_edit()
    {
        $id = Input::get('id');
        $pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        $section = strtolower($pieces[0]); //'section';
        //dd('WTF!!');
        $titleArray = array(//'No.' => 'id',
            'Fecha de agendamientoo' => 'service_date_time',
            "Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
            "email Usuario" => array("user", "email"),
            //'Usuario' => 'user_id',
            //'Conductor' => 'driver_id',
            //"Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
            'Tipo de agendamiento' => array("type", "descrip"), //'schedule_type',
            'Destino' => 'destination',
            /* 'Indicacion' => 'address_index',
              'comp1' => 'comp1',
              'comp2' => 'comp2',
              'no' => 'no',
              'Barrio' => 'barrio',
              'Fecha de solicitud' => 'created_at', */
            "comb_Dirección" => "address_index.comp1.comp2.no.barrio.obs",
                //'Estado' => 'status',
                //'Calificación' => 'score'
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => FALSE,
            'del' => FALSE,
            //'export' => TRUE,
            'total' => TRUE,
            'custom' => array(
                array("Generar servicio",
                    "edit",
                    $section,
                    "images/icon/color_18/checkmark2.png",
                    "(function(id){if(confirm(\"Desea generar servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
            'tabs' => array("options" => array(
                    array("id" => "1",
                        "description" => "Pendientes"
                    ),
                    array(
                        "id" => "5",
                        "description" => "Finalizados"
                    )
                ),
                "tabber" => "status"
            )
        );

        $scheduleData = Schedule::find($id);
        $address = $scheduleData->address_index . "%20" . $scheduleData->comp1 . "%20" . $scheduleData->comp2 . "%20-" . $scheduleData->no . "%20Bogotá,%20Colombia";
        //dd($address);
        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);
        //dd($geoloc);

        $step1 = $geoloc['results'][0];
        $step2 = $step1['geometry'];
        $coords = $step2['location'];

        //dd($coords);
        /*
          array(2) {
          ["lat"]=>
          float(4.6199634)
          ["lng"]=>
          float(-74.0783654)
          }
         */
        $servicio = Service::create(array(
                    'user_id' => $scheduleData->user_id,
                    'status_id' => '1',
                    'from_lng' => $coords["lng"],
                    'from_lat' => $coords["lat"],
                    'index_id' => $scheduleData->address_index, // . "%20Bogotá,%20Colombia";
                    'comp1' => $scheduleData->comp1,
                    'comp2' => $scheduleData->comp2,
                    'no' => $scheduleData->no,
                    'barrio' => $scheduleData->barrio,
                    'address' => $scheduleData->address,
                    'kind_id' => '2',
                    'obs' => $scheduleData->obs,
                    'schedule_id' => $scheduleData->id
        ));

        if ($servicio)
        {
            $pushMessage = 'Agendamiento pendiente en progreso'; //, pos:lat=' . $servicio->from_lat . 'lng=' . $servicio->from_lng;
            //dd($servicio->user->type);
            $servicio = Service::find($servicio->id);

            $push = Push::make();

            $deviceType = $servicio->user->type;

            if ($deviceType == '1') {//iPhone
                $preventEcho = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav');
            } else {
                $preventEcho = $push->android2($servicio->user->uuid, $pushMessage, 1, 'default', 'Open', array('service_id' => $servicio->id));
            }

        }

        $tmpService = new Service();

        $user = User::find($scheduleData->user_id);

        $habemusTaxis = $user->notify_service($servicio);

        //$habemusTaxis = $tmpService->requestService(false, $servicio->from_lat, $servicio->from_lng);

        //$habemusTaxis = true;

        if ($habemusTaxis)
        {
            //return Response::eloquent($habemusTaxis);
            $finishSchedule = Schedule::update($id, array('status' => '5'));

        } else
        {
            $id = $servicio->id;
            //Si hay conductor, notificar
            Service::update($id, array(
                'status_id' => '7'
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


        if ($habemusTaxis)
        {
            $msg = 'Servicio generado!';
            $type = 'success';
        } else {
            $msg = 'Error al generar servicio!, no hay vehículos disponibles';
            $type = 'error';
        }
        return View::make('cms.index')
                        ->with('title', 'Agendamientos: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
                        ->with('items', $objName::order_by('status', 'ASC')->order_by('service_date_time', 'ASC')->get());
        /* return View::make('schedule.index')
          ->with('title', 'Agendamientos')
          ->with('titles', $titleArray)
          ->with('message', $msg)
          ->with('result', $type)
          ->with('items', Schedule::order_by('status', 'ASC')->order_by('service_date_time', 'ASC')->get()); */
        /* Schedule::order_by('service_date_time', 'desc')
          ->order_by('status', 'desc')
          ->get()); */
    }

    public function post_editX() {
        $id = Input::get('id');
        //dd('WTF!!');
        /* $titleArray = array('No.' => 'id',
          array("Carro" => array("car", "placa"), 'type' => 'txt', 'locked' => 'FALSE'),
          array("Cel." => "cellphone", 'type' => 'txt', 'locked' => 'FALSE'),
          array("Nombre" => "name", 'type' => 'txt', 'locked' => 'FALSE'),
          array("Apellido" => "lastname", 'type' => 'txt', 'locked' => 'FALSE'),
          array("e-mail" => "email", 'type' => 'txt', 'locked' => 'FALSE'),
          array("Registrado" => "created_at", 'type' => 'txt', 'locked' => 'FALSE'),
          array("Modificado" => "updated_at", 'type' => 'txt', 'locked' => 'FALSE'),
          array("Disponible" => "available", 'type' => 'txt', 'locked' => 'FALSE'),
          array("Estado cuenta" => "account_status", 'type' => 'txt', 'locked' => 'FALSE')
          );
          return View::make('driver.edit')
          ->with('title', 'Conductor')
          ->with('titles', $titleArray)
          ->with('item', Driver::find($id)); */
        $drivers = Driver::all();
        //dd($cars);
        $driverArray[0] = 'Seleccione un vehiculo existente';
        foreach ($drivers as $value) {
            $driverArray[$value->id] = $value->name . "," . $value->lastname;
        }
        return View::make('schedule.edit')
                        ->with('title', 'Agendamiento')
                        ->with('drivers', $driverArray)
                        ->with('item', Schedule::find($id));
    }

    public function post_update() {
        $id = Input::get('id');
        Schedule::update($id, array(
            'driver_id' => Input::get('driver_id'),
            'status' => '2'
        ));
        $pushMessage = 'Agendado asignado!';
        $agendamiento = Schedule::find($id);
        $push = Push::make();
        if ($agendamiento->user->type == '1') {//iPhone
            $push->ios($agendamiento->user->uuid, $pushMessage, 1, 'honk.wav');
        } else {
            $push->android($agendamiento->user->uuid, $pushMessage);
        }
        $drivers = Driver::all();
        //dd($cars);
        $driverArray[0] = 'Seleccione un vehiculo existente';
        foreach ($drivers as $value) {
            $driverArray[$value->id] = $value->name . "," . $value->lastname;
        }
        return View::make('schedule.edit')
                        ->with('title', 'Agendamiento')
                        ->with('drivers', $driverArray)
                        ->with('result', 'Guardado')
                        ->with('item', Schedule::find($id));

        //return Redirect::to_route('dashboard');
        //echo HTML::entities('<script>alert(\'hi\');</script>');
        //        }
    }

}
