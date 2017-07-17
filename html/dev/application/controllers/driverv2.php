<?php


class DriverV2_Controller extends Base_Controller {

	public function action_enable($driver_id)
	{
		/*$whereDate = date('Y') . "-" . date('m') . "-05";
        $whereDateMin = date('Y') . "-" . date('m') . "-01";

		if (date_create() <= date_create($whereDate)) {
            //dd('aun vigentes');
            $items = Car::where('pay_date', '<=', DB::RAW("DATE('" . date('Y') . "-" . (date('m') - 1) . "-01" . "')"))
                    ->get();
        } else {
            //dd('vencidos');
            $items = Car::where('pay_date', '<=', DB::RAW("DATE('" . $whereDate . "')"))
                    ->where_not_between('pay_date', $whereDateMin, $whereDate)
                    ->get();
        }

		$drivers;
        if ($items) {
            foreach ($items as $item) {
                //dd($item->drivers);
                if ($item->drivers) {
                    foreach ($item->drivers as $driver) {
                        $drivers[] = $driver->id;
                    }
                }
            }
        }

		$drivers = (isset($drivers)) ? $drivers : FALSE;
		*/
		$success = $driver = Driver::find($driver_id);
        //dd($driver->car_id);

        // SELECT * FROM `drivers` WHERE car_id = 1 and available = 1 ORDER BY `id`

        // ver si el conductor actual tiene algun servicio en curso
        // $query = "SELECT id,driver_id,car_id FROM `services` WHERE status_id in (2,4) and driver_id = ".$driver_id.";";
        // $service = DB::query($query);
        // if ($service) {

        // }






        // verificar si el vehículo esta en uso en algun conductor con servicio distinto al conductor actual



       //$query = "SELECT id,name,login,cellphone,available,updated_at FROM drivers WHERE available = 1 AND car_id = 1 ORDER BY updated_at DESC;";


        //$query = "SELECT COUNT(*) AS tot FROM drivers WHERE available = 1 AND car_id =  ".$driver->car_id." AND id <> ".$driver_id.";";

        $query = "SELECT id,name,login,cellphone,updated_at FROM drivers WHERE available = 1 AND car_id =  ".$driver->car_id." AND id <> ".$driver_id.";";


        //$query = "SELECT COUNT(*) AS tot FROM drivers WHERE available = 1 AND car_id = 1111;";
        $cars = DB::query($query);
        //dd($cars[0]->name);
//        dd($cars[0]->tot);
        //if (strcmp ($cars[0]->tot, "0") == 0) {
        //if (!strcmp ($cars[0]->tot, "0")) {
//        if (!strcmp ($cars[0]->tot, "0")) {
        if (!$cars) {
            //dd("no esta en uso");
            $error = 404;
        }
        else {
            //dd("esta en uso");
            $error = 1;
            $success = null;
            $payload = array();
            $payload['driver'] = array();

            //$payload['driver'][] = array(
            $payload['driver'] = array(
                    // 'id'            => $driver->id,
                    // 'name'          => $driver->name,
                    // 'cellphone'     => $driver->cellphone,
                    'id'            => $cars[0]->id,
                    'name'          => $cars[0]->name,
                    'cellphone'     => $cars[0]->cellphone,
            );
            //dd($payload);
            return JSONResponse::error($error,$payload);
        }
        //dd($cars[0]->tot);

		if ($success)
		{
			$driver->fill(array(
				'available' => '1',
				'uuid' 		=> Input::get('uuid'),
				'crt_lat' 		=> Input::get('lat'),
				'crt_lng' 		=> Input::get('lng')
	        ));
	        $driver->save();

            // verificar si tiene un servicio en curso antes de enviar los servicios
            $statuses = array(2,4);
            $result = Service::where_in('status_id',$statuses)->where_driver_id($driver_id)->first();
/*
            if ($result) {
                $payload = array();
                $payload['service'] = $result;

                $payload['service'] = array(
                        'service_id'        => $result->id,
                        'status_id'        => $result->status_id,
                        'index_id'          => $result->index_id,
                        'comp1'             => $result->comp1,
                        'comp2'             => $result->comp2,
                        'no'                => $result->no,
                        'barrio'            => $result->barrio,
                        'obs'               => $result->obs,
                        'from_lat'          => $result->from_lat,
                        'from_lng'          => $result->from_lng,
                        'kind_id'           => $result->kind_id,
                        'schedule_type'     => $result->schedule_type,
                        'service_date_time' => $result->service_date_time,
                        'destination'       => $result->destination,
                        'username'          => $result->username,
                        'address'           => $result->address,
                );
                return JSONResponse::success($payload);
            }
*/
	        $waitingservices = $driver->get_close_services();
	        if ($waitingservices)
	        {
	            $payload = array();
	            $payload['services'] = array();
		        foreach ($waitingservices as $service)
		        {
			        $payload['services'][] = array(
			            'service_id'        => $service->id,
			            'index_id'          => $service->index_id,
			            'comp1'             => $service->comp1,
			            'comp2'             => $service->comp2,
			            'no'                => $service->no,
			            'barrio'            => $service->barrio,
			            'obs'               => $service->obs,
			            'lat'               => $service->from_lat,
			            'lng'               => $service->from_lng,
			            'kind_id'           => $service->kind_id,
			            'schedule_type'     => $service->schedule_type,
                        'service_date_time' => $service->service_date_time,
			            'destination'       => $service->destination,
			            'username'          => $service->username,
                        'address'           => $service->address,
                        'pay_type'          => $service->pay_type,
                        'pay_reference'     => $service->pay_reference,
                        'user_id'           => $service->user_id,
                        'user_email'        => $service->user_email,                        
                        'user_card_reference'    => $service->user_card_reference,
                        'units'             => $service->units,
                        'charge1'           => $service->charge1,
                        'charge2'           => $service->charge2,
                        'charge3'           => $service->charge3,
                        'charge4'           => $service->charge4,
                        'value'             => $service->value,


			        );
		        }
				return JSONResponse::success($payload);
	        }
			return JSONResponse::success();

		}

        //return ($success) ?  : JSONResponse::error(404);
        return ($success) ?  : JSONResponse::error($error);
    }

	public function action_disable($driver_id)
	{
		$success = Driver::update($driver_id, array(
			'available' => '0'
        ));
        return ($success) ? JSONResponse::success() : JSONResponse::error(404);
    }


	public function action_update_position($driver_id)
	{
		$success = $driver = Driver::with('active_service.user')->find($driver_id);
        if ($success)
        {
			/*if($driver->available=='0')
			{
				Driver::where('id', '=', $driver_id)->update(array('available'	=>	'1'));
			}*/
        	$driver->crt_lat = Input::get('lat');
        	$driver->crt_lng = Input::get('lng');
        	$success = $driver->save();
        	if ($success && $driver->active_service)
        	{
	 	    	$payload = array();
	 	    	$payload['service'] = array(
	 				'lat' 				=> $driver->crt_lat,
	 				'lng' 				=> $driver->crt_lng,
	 	    	);
                // REVISAR ESTA PUSH
	       	 	if (!$driver->active_service[0]->user->has_iPhone()) {
	       	 		Notifier::user($driver->active_service2[0]->user, PushType::DRIVER_POSITION, $payload);
	       	 	}
        	}
        }
        return ($success) ? JSONResponse::success() : JSONResponse::error(404);
	}

	public function action_cancel_service($driver_id)
	{
		$success = $driver = Driver::with('active_service')->find($driver_id);
		if ($driver)
		{
			$success = $driver->cancel_service();
		}
        return ($success) ? JSONResponse::success() : JSONResponse::error(404);
	}

	public function action_confirm_service($driver_id)
	{
		$success = $driver = Driver::with('car')->find($driver_id);
		$service_id = Input::get('service_id');
		$achieved = NULL;

        // checkear estado servicio
        // si status_id == 1  continua
        //sleep(5);
        //dd($driver);
        $req_srv = Service::find($service_id);
        //$query = "SELECT * from services WHERE id = ".$service_id.";";
        //$query = "SELECT * FROM services WHERE id = ".$service_id." AND driver_id IS NULL;";
        //$req_srv = DB::query($query);
        //if ($req_srv[0]->status_id == 1) {
        if ($req_srv->status_id == 1) {

    		if ($driver) {
                // verificar primero si el conductor tiene un servicio en 2 o 4
                $statuses = array(2,4);
                //sleep(10);
                $result = Service::where_in('status_id',$statuses)->where_driver_id($driver_id)->first();
                //$query = "SELECT * FROM services WHERE driver_id = ".$driver_id." AND status_id IN (2,4) LIMIT 1;";
                //$result = DB::query($query);
                //dd($result);
                if ($result) { // hay un servicio tomado por este conductor
                    //$payload = array();
                    // mejorar la respuesta correctamente
                    return JSONResponse::error(1);
                }
                else {


                    //
                    //$query = "UPDATE services SET status_id = 2, driver_id = ". $driver->id." , car_id =".$driver->car_id." WHERE id = ". $service_id." AND status_id = 1;";
                    // $result = DB::query($query);


        			DB::transaction(function() use ($service_id, $driver, &$achieved)
        			{
        				$achieved = Service::where('id', '=', $service_id)
        					->where('status_id', '=', '1')
        					->update(array(
        						'status_id'	=>	'2',
        						'driver_id'	=>	$driver->id,
        						'car_id'	=>	$driver->car->id
        					));
        				if($achieved)
        				{
        					$driver->available = '0';
        					$driver->save();
        				}
        			});
                }
    		}

    		if ($success)
    		{
            	if ($achieved)
            	{
    	 	    	$service = Service::with('user')->find($service_id);
    	 	    	/*if ($service->user->has_iPhone())
    	 	    	{
    	 	    		$payload = array();
    	 	    		$payload['driver'] = array(
    	 	    			'id'		=> $driver_id
    	 	    		);
    	 	    	}
    	 	    	else
    	 	    	{*/
        				$payload = $driver->get_payload();
    	 	    	//}
        			$payload['kind_id'] = $service->kind_id;
    				$payload['service_id'] = $service->id;
                    $payload['service_id2'] = $service_id;
                    $payload['status_id'] = $service->status_id;
    	       	 	Notifier::user($service->user, PushType::CONFIRMED_SERVICE, $payload);
    	 	    	$payload = array();
    	       	 	$payload['service_id'] = $service_id;
    	       	 	Notifier::available_drivers(PushType::REMOVE_SERVICE, $payload);

                    $payload['kind_id'] = $service->kind_id;
                    $payload['service_id'] = $service->id;
                    $payload['service_id2'] = $service_id;
                    $payload['status_id'] = $service->status_id;
            		//return JSONResponse::success();
                    return JSONResponse::success($payload);
            	}
            	else {
            		//return JSONResponse::error(500);

                    // si el estado es cancelado aviso al usuario
                    $service = Service::with('user')->find($service_id);
                    /*if ($service->user->has_iPhone())
                    {
                        $payload = array();
                        $payload['driver'] = array(
                            'id'        => $driver_id
                        );
                    }
                    else
                    {*/
                        $payload = $driver->get_payload();
                   // }
                    $payload['kind_id'] = $service->kind_id;
                    $payload['service_id'] = $service->id;
                    $payload['service_id2'] = $service_id;
                    $payload['status_id'] = $service->status_id;
                    //$payload = array();
                    $payload['service_id'] = $service_id;
                    Notifier::available_drivers(PushType::REMOVE_SERVICE, $payload);
                    return JSONResponse::success($payload);
               }
    		}
        }

		return JSONResponse::error(404);
	}

	public function action_arrive($driver_id)
	{
		$success = $driver = Driver::find($driver_id);
		if ($driver)
		{
			$success = $driver->notifyArrival();
		}
        return ($success) ? JSONResponse::success() : JSONResponse::error(404);
	}

	public function action_details($driver_id)
	{
		$success = $driver = Driver::find($driver_id);
		if ($driver)
		{
    		$payload = $driver->get_payload();
    		return JSONResponse::success($payload);
		}
        return JSONResponse::error(404);
	}


}
