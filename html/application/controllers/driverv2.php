<?php


class DriverV2_Controller extends Base_Controller {

	public function action_enable($driver_id){

		$success = $driver = Driver::find($driver_id);

        $query = "SELECT id,name,login,cellphone,updated_at FROM drivers WHERE available = 1 AND car_id =  ".$driver->car_id." AND id <> ".$driver_id.";";

        $cars = DB::query($query);
        if (!$cars) {
            //dd("no esta en uso");
            $error = 404;
        }
        else {

            $error = 1;
            $success = null;
            $payload = array();
            $payload['driver'] = array();
            $payload['driver'] = array(
            'id'            => $cars[0]->id,
            'name'          => $cars[0]->name,
            'cellphone'     => $cars[0]->cellphone,
            );
            //dd($payload);
            return JSONResponse::error($error,$payload);
        }
        //dd($cars[0]->tot);

		if ($success){

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

	        $waitingservices = $driver->get_close_services();
	        if ($waitingservices){

	            $payload = array();
	            $payload['services'] = array();
		        foreach ($waitingservices as $service){

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
                        'code'             => $service->code,
			        );
		        }
				return JSONResponse::success($payload);
	        }
			return JSONResponse::success();

		}
        return ($success) ?  : JSONResponse::error($error);
    }

    /*public  function post_status(){

    if (Input::get('driver_id','') != '') {
            $user_id = Input::get('user_id');

            if (Input::get('service_id','') != '') {
                $result = Service::where('id','=',Input::get('service_id'))->where_user_id($user_id)->first();
                //$result = Service::find(Input::get('service_id'));
            } else {    
                $statuses = array(2,4,8);
                $result = Service::where_in('status_id',$statuses)->where_user_id($user_id)->first();
            }

        } else {
            //if (Input::has('service_id')) {
            if (Input::get('service_id','') != '') {
                $id = Input::get('service_id');
                $result = Service::find($id);
            } 
            else{
                //if (Input::has('driver_id')){
                if (Input::get('user_id','') != ''){
                    $user_id = Input::get('user_id');
                    //$duser_id = Input::get('user_id');
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
                    else 
                    {
                        $data = Input::json();
                        if(!property_exists($data, 'service_id')){

                            if(property_exists($data, 'user_id')){
                                   $statuses = array(2,5,4,1);
                                   $result = Service::where_in('status_id',$statuses)->where_user_id($data->user_id)->where('kind_id','<>','3')->where_null('qualification')->order_by('status_id')->order_by('created_at')->first();
                                   //$result = Service::where_in('status_id',$statuses)->where_driver_id($data->driver_id)->where_null('qualification')->order_by('created_at', 'DESC')->first();
                                //$result = Service::where_status_id(2)->where_driver_id($data->driver_id)->first();
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
            return Response::json(array('error' => 'test'));
        }

    }*/

	public function action_disable($driver_id){

		$success = Driver::update($driver_id, array(
			'available' => '0'
        ));
        return ($success) ? JSONResponse::success() : JSONResponse::error(404);
    }

	public function action_update_position($driver_id){

		$success = $driver = Driver::with('active_service.user')->find($driver_id);
        if ($success){

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
                    //}
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
