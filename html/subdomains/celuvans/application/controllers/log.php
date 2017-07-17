<?php

class Log_Controller extends Base_Controller {

    public $restful = true;

    public function post_save() {
        Log::create(array(
            'service_id' => Input::get('service_id'),
            'crt_lat' => Input::get('crt_lat'),
            'crt_lng' => Input::get('crt_lng')
        ));
        return Response::json(array('status'=>'ok'));
    }
    public function post_get(){
        
    }
}