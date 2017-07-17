<?php

/**
 * Description of Service Controller
 *
 * @author Jesica
 */
class Payment_Controller extends Base_Controller {
   
    public $restful = true;

    public function post_confirm() {
        if (!Input::has('json')) {
        	$data = Input::json();
        	//dd($data);

        	$result = $data;

       
        }
        if (isset($result)) {
            return Response::json(array('error' => '0'));
        } else {
            return Response::json(array('error' => '1'));
        }

    }
}
