<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 
 */

/**
 * Description of schedule
 *
 * @author john
 */
class Schedule_Controller extends Base_Controller {

    public $restful = true;

    public function post_create() {
          //dd(Input::all());
          $address = Input::get('address');
          $barrio = Input::get('barrio');
          //dd($address);
          // get coordinate from service
         //$address = $scheduleData->address_index . "%20" . $scheduleData->comp1 . "%20" . $scheduleData->comp2 . "%20-" . $scheduleData->no . "%20Bogotá,%20Colombia";

         // $address = $address . "%20," . $barrio . ",%20Bogotá,%20Colombia";
         // //dd($address);
         // //$details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false";
         // $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=9548+Carrera+49+La%20Castellana+Bogotá,+Colombia&sensor=false";
         // //dd($details_url);

         // $ch = curl_init();
         // curl_setopt($ch, CURLOPT_URL, $details_url);
         // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         // $geoloc = json_decode(curl_exec($ch), true);
         // //dd($geoloc);

         // $step1 = $geoloc['results'][0];
         // $step2 = $step1['geometry'];
         // $coords = $step2['location'];
         // //dd($coords);
         //  // ver +
         //  $bound = "5";
         //  $lat = $coords["lat"];
         //  $lng = $coords["lng"];

          $lat = Input::get('city_lat');
          $lng = Input::get('city_lng');
          // determine cms_user_id
          // determina ciudad
          $bound = "5";
          $query = "SELECT *,((ACOS(SIN(".$lat."* PI() / 180) * SIN(center_lat * PI() / 180) + COS(".$lat. " * PI() / 180) * COS(center_lat * PI() / 180) * COS((".$lng." - center_lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
FROM cms_cities WHERE ( center_lat BETWEEN (".$lat." - ".$bound.") AND (".$lat." + ".$bound.") AND center_lng BETWEEN (".$lng." - ".$bound.") AND (".$lng." + ".$bound.") ) ORDER BY distance ASC";
          //dd($query);
          $result = DB::query($query);
          //dd($result);
          (count($result) > 0) ? ($city_id = $result[0]->id) : ($city_id = 0);
          // determine country id
          $query = "SELECT * from cities_customers WHERE city_id = ".$city_id;
          $result = DB::query($query);
          $cms_user_id = $result[0]->customer_id;
          //dd($cms_user_id);
         //if (Input::get('adddress')) {
         if ($address) {
             // get city
             $agendamiento = Schedule::create(array(
                    'user_id' => Input::get('user_id'),
                    'service_date_time' => Input::get('service_date_time'),
                    'schedule_type' => Input::get('schedule_type'),
                    'address_index' => Input::get('address_index'),
                    'comp1' => '',
                    'comp2' => '',
                    'no' => '',
                    'barrio' => Input::get('barrio'),
                    'obs' => Input::get('obs'),
                    'destination' => Input::get('destination'),
                    'status' => '1',
                    'cms_users_id' => $cms_user_id,
                    'address' => Input::get('address'),
                    'city_lat' => Input::get('city_lat'),
                    'city_lng' => Input::get('city_lng')
            ));

         }
         else {
             $agendamiento = Schedule::create(array(
                    'user_id' => Input::get('user_id'),
                    'service_date_time' => Input::get('service_date_time'),
                    'schedule_type' => Input::get('schedule_type'),
                    'address_index' => Input::get('address_index'),
                    'comp1' => Input::get('comp1'),
                    'comp2' => Input::get('comp2'),
                    'no' => Input::get('no'),
                    'barrio' => Input::get('barrio'),
                    'obs' => Input::get('obs'),
                    'destination' => Input::get('destination'),
                    'status' => '1',
                    'cms_users_id' => $cms_user_id,
                    'address' => Input::get('address')
            ));
        }

        if ($agendamiento == NULL) {
            return Response::json(array('error' => '1'));
        } else {
            $schedule = Schedule::with(array('user', 'type', 'service', 'service.state'))->find($agendamiento->id);
            return Response::json(array('error' => '0', "schedule" => $schedule->to_array()));
        }
        //return Response::eloquent($agendamiento);
    }

    public function post_asignar() {

        Schedule::update(Input::get('schedule_id'), array(
            'driver_id' => Input::get('driver_id'),
            'status' => '2'
        ));
        $pushMessage = 'Agendado asignado!';
        $agendamiento = Schedule::find(Input::get('schedule_id'));
        $push = Push::make();
        if ($agendamiento->user->type == '1') {//iPhone
            $push->ios($agendamiento->user->uuid, $pushMessage);
        } else {
            $push->android($agendamiento->user->uuid, $pushMessage);
        }
        return Response::json(array('status' => 'ok'));
    }

    public function post_progress() {
        Schedule::update(Input::get('schedule_id'), array(
            'status' => '3'
        ));
        return Response::json(array('status' => 'ok'));
    }

    public function post_cancel() {
        Schedule::update(Input::get('schedule_id'), array(
            'status' => '4'
        ));
        $schedule = Schedule::find(Input::get('schedule_id'));
        $objArray = $schedule->to_array();
        $objArray['status'] = 'ok';
        return Response::json($objArray);
    }

    public function post_cancelcms() {
        Schedule::update(Input::get('schedule_id'), array(
            'status' => '4'
        ));
        $schedule = Schedule::find(Input::get('schedule_id'));
        return Response::eloquent($schedule);
    }

    public function post_finish() {
        Schedule::update(Input::get('schedule_id'), array(
            'score' => Input::get('score'),
            'status' => '5'
        ));
        return Response::json(array('status' => 'ok'));
    }

    public function post_daily() {
        header('Access-Control-Allow-Origin: *');
        //dd(Input::all());
        //exit();
        $schedule = Schedule::with(array('user', 'type', 'service', 'service.state'))
	//		->where(DB::RAW("DATE(service_date_time)"), '=', DB::RAW("DATE(NOW())"))
      // ->where('id','=','627')
			->where_status('1')
      ->where('cms_users_id','=',Input::get('customer_id'))
			->order_by('status', 'ASC')
			->order_by('service_date_time', 'ASC')
			->get();
	//where(DB::RAW("DATE(service_date_time)"), '=', DB::RAW("DATE(NOW())"))->get(); //Schedule::find($schedule_id);
        //$schedule = Schedule::with(array('user', 'type'))->where_status('1')->order_by('status', 'ASC')->order_by('service_date_time', 'ASC')->get();
        return Response::eloquent($schedule);
    }

    public function post_details() {
        header('Access-Control-Allow-Origin: *');
        //dd(Input::all());
        //$schedule = json_decode(Input::json());
        $data = Input::json();
        //$data->schedule_id;
        if ($data->schedule_id) {
            $schedule_id = $data->schedule_id; //Input::get('schedule_id');
            $schedule = Schedule::find($schedule_id); //with('service', 'service.state')->
            return Response::eloquent($schedule);
        } else {
            return Response::json(array('error' => 'Bad access')); //, 'sent' => Input::json()));
        }
        /* $data = Input::json();
          if ($data->schedule_id) {
          $schedule_id = $data->schedule_id;
          $schedule = Schedule::find($schedule_id);
          return Response::eloquent($schedule);
          } else {
          return Response::json(Input::all()); //array("status"=>"ok"));//Input::all());
          } */
    }

    public function post_user() {
        $usrSchedules = Schedule::with(array('driver', 'driver.car'))->where('user_id', '=', Input::get('user_id'))->order_by('id', 'DESC')->get();
        foreach ($usrSchedules as $key => $schedule) {
            $defSchedules[] = $schedule->to_array();
        }
        return Response::json(array('schedules' => $defSchedules, 'error' => '0'));
    }

    public function post_driver() {
        $drvSchedules = Schedule::with('user')
                ->where('driver_id', '=', Input::get('driver_id'))
                ->where('status', '=', '2')
                ->get();
        return Response::eloquent($drvSchedules);
    }

    public function post_toservice() {
        header('Access-Control-Allow-Origin: *');
        //dd(Input::all());
        //$schedule = json_decode(Input::json());
        $data = Input::json();
        //return Response::json(array('mmm' => 'mmmm'));
        //$id = json_decode(Input::json();
        $testObs = false;
        if ($testObs) {
            $user_id = '43';
            $pushMessage = "Test " . $data->schedule_id;
            $testUser = User::find($user_id);

            $push = Push::make();
            if ($testUser->type == '1') {//iPhone
                $preventEcho = $push->ios($testUser->uuid, $pushMessage, 1, 'honk.wav');
            } else {
                $preventEcho = $push->android2($testUser->uuid, $pushMessage);
            }
        }
        $id = $data->schedule_id;
        //$id = Input::get('schedule_id');
        //return Response::json(array('wtf' => $id));
        if ($id) {
            $scheduleData = Schedule::find($id);
            
            $city = DB::table('cities_customers')->where('customer_id','=',$scheduleData->cms_users_id)->first();

            $ciudad_pais = City::where('id','=',$city->city_id)->first();

            /*$address = $scheduleData->address_index . "%20" . $scheduleData->comp1 . "%20" . $scheduleData->comp2 . "%20" . $scheduleData->no .' ' .$ciudad_pais->name.' '.$ciudad_pais->department->name.' '.$ciudad_pais->country->name;*/
            $address = $scheduleData->address.' ' .$ciudad_pais->name.' '.$ciudad_pais->department->name.' '.$ciudad_pais->country->name;
            //dd($address);
            //exit();
            $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" .  urlencode($address) . "&sensor=false";



            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $details_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $geoloc = json_decode(curl_exec($ch), true);


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


            // ver +
            $bound = "5";
            $lat = $coords["lat"];
            $lng = $coords["lng"];

            $query = "SELECT *,((ACOS(SIN(".$lat."* PI() / 180) * SIN(center_lat * PI() / 180) + COS(".$lat. " * PI() / 180) * COS(center_lat * PI() / 180) * COS((".$lng." - center_lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
FROM cms_cities WHERE ( center_lat BETWEEN (".$lat." - ".$bound.") AND (".$lat." + ".$bound.") AND center_lng BETWEEN (".$lng." - ".$bound.") AND (".$lng." + ".$bound.") ) ORDER BY distance ASC";


            $result = DB::query($query);
             (count($result) > 0) ? ($city_id = $result[0]->id) : ($city_id = 0);
            // determine country id
            $query = "SELECT * from cities_customers WHERE city_id = ".$city_id;
            $result = DB::query($query);
            $cms_user_id = $result[0]->customer_id;
            //dd($cms_user_id);
            // ver -


	        $schedule_type = "2".$scheduleData->schedule_type;
            $address = $scheduleData->address_index . " " . $scheduleData->comp1 . " # aqui" . $scheduleData->comp2 . "-" . $scheduleData->no;

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
                        'obs' => $scheduleData->obs,
                        'address' =>  $scheduleData->address,
                        'kind_id' =>  '2',
                        'cms_users_id' => $cms_user_id,
                        'schedule_id' => $scheduleData->id,
                        'schedule_type' => $scheduleData->schedule_type,
                        'service_date_time' => $scheduleData->service_date_time,
                        'destination' => $scheduleData->destination
            ));

            if ($servicio) {
                //!!!!! API V2!!!!!!
                $user = User::find($scheduleData->user_id);
		//Notificar a todos los conductores del agendamiento
		$drivers = DB::query("SELECT * from drivers where available='1' and uuid<>'' and uuid is not null group by uuid;");
		//echo print_r ($drivers,true);
                $user->notify_service($servicio,$drivers);
                //!!!!! FIN API V2!!!!!!
                //return Response::eloquent($habemusTaxis);
                $finishSchedule = Schedule::update($id, array(
                            'status' => '5'
                ));
            }

            $tmpService = new Service();
            //$habemusTaxis = $tmpService->requestService(false, $servicio->from_lat, $servicio->from_lng);
            $habemusTaxis = true;
            if ($habemusTaxis) {
                //return Response::eloquent($habemusTaxis);

                $finishSchedule = Schedule::update($id, array(
                            'status' => '5'
                ));
                return Response::eloquent($servicio);
            } else {
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
                return Response::json(array('error' => '1', 'msg' => 'No hay taxis disponibles'));
            }
        } else {
            return Response::json(array('mmm' => 'mmmm'));
        }
    }

}

?>
