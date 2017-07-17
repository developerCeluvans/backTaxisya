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
		if ($success) 
		{
			$driver->fill(array(
				'available' => '1', 
				'uuid' 		=> Input::get('uuid'),
				'crt_lat' 		=> Input::get('lat'),
				'crt_lng' 		=> Input::get('lng')
	        ));
	        $driver->save();
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
			        );
		        }
				return JSONResponse::success($payload);	        	
	        }
			return JSONResponse::success();	        	

		}

        return ($success) ?  : JSONResponse::error(404);
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
	       	 	if (!$driver->active_service[0]->user->has_iPhone())
	       	 	{
	       	 		Notifier::user($driver->active_service[0]->user, PushType::DRIVER_POSITION, $payload);
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
		if ($driver) 
		{			
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
		if ($success) 
		{
        	if ($achieved) 
        	{
	 	    	$service = Service::with('user')->find($service_id);
	 	    	if ($service->user->has_iPhone())
	 	    	{
	 	    		$payload = array();
	 	    		$payload['driver'] = array(
	 	    			'id'		=> $driver_id
	 	    		);
	 	    	}
	 	    	else
	 	    	{
    				$payload = $driver->get_payload();	    	
	 	    	}
    			$payload['kind_id'] = $service->kind_id;
				$payload['service_id'] = $service->id;
	       	 	Notifier::user($service->user, PushType::CONFIRMED_SERVICE, $payload);
	 	    	$payload = array();	    	
	       	 	$payload['service_id'] = $service_id;
	       	 	Notifier::available_drivers(PushType::REMOVE_SERVICE, $payload);
        		return JSONResponse::success();
        	}
        	else
        	{
        		return JSONResponse::error(500);	
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
