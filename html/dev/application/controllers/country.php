<?php

class Country_Controller extends Base_Controller {

    public $restful = true;

    public function post_countries() {

        $countries = Country::get();
        if (count($countries) > 0) {
            $defCountries['error'] = '0';
            $i = 1;
            foreach ($countries as $key => $value) {
                $defCountries['countries'][] = $value->to_array();
                $i++;
            }
        } else {
            $defCountries['error'] = '1';
        }
        return Response::json($defCountries);
    }

}
