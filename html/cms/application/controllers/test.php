<?php

class Test_Controller extends Base_Controller {

    public $restful = true;

    public function get_massivenotifiertest() {

        $whom_id = 1;

        /*
          if ($whom_id == 1) {//usuario
          $receivers = User::all();
          } else {//conductor
          $receivers = Driver::all();
          } */

        Notifier::massive("HelloWorld", true);

        $users = User::where_in('id', array('43', '321', '587', '456'))->get(); //'43','321','587','456'
        //dd($users);
        dd(Notifier::users($users, 34, array(), "Prueba masiva"));
    }

}

