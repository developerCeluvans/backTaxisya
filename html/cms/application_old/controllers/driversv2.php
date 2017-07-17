<?php

class DriversV2_Controller extends Base_Controller {

    public $restful = true;
    public function action_get_drivers_JSON($status)
    {
        $skip = Input::get('iDisplayStart');
        $take = Input::get('iDisplayLength');
        $search = Input::get('sSearch');
        $sEcho = Input::get('sEcho');

        //echo print_r("ingreso Drivers",true);
        //echo print_r($status,true);
        ///dd($status);

        $results =  Driver::order_by('id', 'updated_at')
                    ->where('available', '=', $status)
                    ->skip($skip)
                    ->take($take)->get();

        $count = Driver::where('available', '=', 1)->count();
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
                $current['updated_at']
            );
            $aaData[] = $mapped;
        }
        return Response::json(array(
            'iTotalRecords'             => $count,
            'iTotalDisplayRecords'      => $count,
            'aaData'                    => $aaData,
            'sEcho'                     => $sEcho,
        ));
    }

    public function action_get_driver()
    {
        //$waiting_services = Service::where('status_id', '=', 4)->get();
        $waiting_drivers = Driver::where('available', '=', 1)->get();
    //  $waiting_drivers = Driver::get();
        //dd($waiting_drivers);
        return View::make('v2.drivers', compact('waiting_drivers'));
    }

}
