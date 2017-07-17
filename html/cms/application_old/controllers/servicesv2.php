<?php


class ServicesV2_Controller extends Base_Controller {

	public function action_get_services_JSON($status)
	{
		$skip = Input::get('iDisplayStart');
		$take = Input::get('iDisplayLength');
		$search = Input::get('sSearch');
		$sEcho = Input::get('sEcho');

		$results =  Service::order_by('id', 'desc')
					->where('status_id', '=', $status)
					->skip($skip)
					->take($take)->get();

		$count = Service::where('status_id', '=', $status)->count();

		$aaData = array();
		foreach ($results as $service)
		{
			$current = $service->to_array();
			$driver = !is_null($current['driver']) ? $current['driver']['name'] . $current['driver']['lastname'] : null;
			$car = !is_null($current['car']) ? $current['car']['placa']  .' '. $current['car']['car_brand'].' '. $current['car']['model'] : null;
			$mapped = array(
				$current['id'],
				$current['user']['name'],
				$driver,
				$car,
				$current['state']['descrip'],
				$current['created_at'],
				$current['updated_at'],
				$current['score']['descrip'],
				$current['index_id'] .' '. $current['comp1'] .' '. $current['comp2'] .' '. $current['no'] .' '. $current['obs']
			);
			$aaData[] = $mapped;
		}

		return Response::json(array(
			'iTotalRecords'				=> $count,
			'iTotalDisplayRecords'		=> $count,
			'aaData'					=> $aaData	,
			'sEcho'						=> $sEcho,
		));
	}

	public function action_get_service()
	{
		$waiting_services = Service::where('status_id', '=', 1)->get();
		//dd($waiting_services);
		return View::make('v2.services', compact('waiting_services'));
	}


    public function action_get_drivers_JSON($status)
    {
        $skip = Input::get('iDisplayStart');
        $take = Input::get('iDisplayLength');
        $search = Input::get('sSearch');
        $sEcho = Input::get('sEcho');

		$results =  Driver::where('available', '=', $status)
					->skip($skip)
					->take($take)->get();

        $count = Driver::where('available', '=', $status)->count();

        $aaData = array();
        foreach ($results as $drivers)
        {
            $current = $drivers->to_array();
            $placa = Car::find($current['car_id']);

            $mapped = array(
                $current['available'],
                $current['cellphone'],
                $current['name'],
                $placa->placa,
                //$current['car']['placa'],
                $current['email'],
                $current['created_at'],
                $current['updated_at'],
                $current['id']
            );
            $aaData[] = $mapped;
        }
        return Response::json(array(
            'iTotalRecords'             => $count,
            'iTotalDisplayRecords'      => $count,
            'aaData'                    => $aaData,
            'sEcho'                     => $sEcho
        ));
    }

	public function action_get_driver()
	{
		//$waiting_services = Service::where('status_id', '=', 4)->get();
		//$waiting_drivers = Driver::where('available', '=', 1)->get();
        $waiting_drivers = Driver::get();

		//dd($waiting_drivers);
        $avaiables = DB::table('drivers')->where('available','=','1')->count();
        $notavaiables = DB::table('drivers')->where('available','=','0')->count();
        $total1 = $avaiables + $notavaiables;

         // mirar para filtor\
        //$cms_user_id = Auth::user()->id;
        //dd($cms_user_id);


//        $waiting_drivers = Driver::where('cms_user_id','=','42')->get();
//        $waiting_drivers = Driver::where('cms_user_id','=',$cms_user_id)->get();
//        $avaiables = DB::table('drivers')->where('available','=','1')->where('cms_user_id','=','42')->count();
//        $notavaiables = DB::table('drivers')->where('available','=','0')->where('cms_user_id','=','42')->count();

		//return View::make('v2.drivers', compact('waiting_drivers'));
		return View::make('v2.drivers', compact('waiting_drivers'))
		->with('total1',$total1)
		->with('avaiables',$avaiables)
		->with('notavaiables',$notavaiables);

	}

    #driver placa

    public function action_get_cars_JSON($placa)
    {
        $skip = Input::get('iDisplayStart');
        $take = Input::get('iDisplayLength');
        $search = Input::get('sSearch');
        $sEcho = Input::get('sEcho');


        // $results =  Driver::where('available', '=', $placa)
        //             ->skip($skip)
        //             ->take($take)->get();
        $query = "select drivers.* from drivers,drivers_cars where drivers_cars.cars_id = ".$placa." and drivers.id = drivers_cars.drivers_id; ";
        $results =  DB::query($query)
                    ->skip($skip)
                    ->take($take)->get();
        $count = DB::query($query)->count();

        $aaData = array();
        foreach ($results as $drivers)
        {
            $current = $drivers->to_array();

            $mapped = array(
                $current['available'],
                $current['cellphone'],
                $current['name'],
                $current['email'],
                $current['created_at'],
                $current['updated_at'],
                $current['id']
            );
            $aaData[] = $mapped;
        }
        return Response::json(array(
            'iTotalRecords'             => $count,
            'iTotalDisplayRecords'      => $count,
            'aaData'                    => $aaData,
            'sEcho'                     => $sEcho
        ));
    }

    public function action_get_car()
    {

        $waiting_drivers = DB::query($query);

        return View::make('v2.drivers', compact('waiting_drivers'))
        ->with('total1',$total1)
        ->with('avaiables',$avaiables)
        ->with('notavaiables',$notavaiables);
    }


}
