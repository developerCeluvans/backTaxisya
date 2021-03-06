<?php

class Department_Controller extends Base_Controller {

    public $restful = true;

    public function post_departments() {

        $data = Department::get();
        //dd($data);

        if (count($data) > 0) {
            $defData['error'] = '0';
            $i = 1;
            foreach ($data as $key => $value) {
                $defData['departments'][] = $value->to_array();
                $i++;
            }
        } else {
            $defData['error'] = '1';
        }
        return Response::json($defData);
    }

}
