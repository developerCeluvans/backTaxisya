<?php

/**
 * Description of Service Controller
 *
 * @author IngJohnGuerrero
 */
class Complain_Controller extends Base_Controller {

    public $restful = true;

    public function post_create() {
        $id = Input::get('service_id');
        $descript = trim(Input::get('descript'));

        $result = Complain::create(
                        array(
                            'service_id' => $id,
                            'descript' => $descript
                        )
        );
        if (isset($result)) {
            return Response::json(array('error' => '0'));
        } else {
            return Response::json(array('error' => '1'));
        }
    }

}

?>
