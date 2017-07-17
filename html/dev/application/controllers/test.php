<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Driver
 *
 * @author IngJohnGuerrero
 */
class Test_Controller extends Base_Controller {

    public $restful = true;

    public function get_expired() {
        $dayAmount = DB::query("select " . DB::raw('DATEDIFF(NOW(),`pay_date`) as days') . " from cars where id=? ", array('1')); //SELECT DATEDIFF(NOW(),`pay_date`) FROM `cars` WHERE id='1'
        dd(intval($dayAmount[0]->days) < 40);
    }

    public function get_datecond() {
        $whereDate = date('Y') . "-" . date('m') . "-05";
        $whereDateMin = date('Y') . "-" . date('m') . "-01";

        $payDate = '2013-08-05 10:30:00';
        $today = '2013-09-05 10:30:00';
        $intervalo = date_diff(date_create($today), date_create($payDate));
        $out = $intervalo->format("Years:%Y,Months:%M,Days:%d,Hours:%H,Minutes:%i,Seconds:%s");
        //dd($intervalo);

        /*
          SELECT DATEDIFF(NOW(),`pay_date`)as days FROM `cars` WHERE id='1'
         */

        /* if() {
          return array('error' => '3', 'id' => '0');
          } */
        if (date_create($today) <= date_create($whereDate)) {
            //dd('aun vigentes');
            $items = Car::where('pay_date', '<=', DB::RAW("DATE('" . date('Y') . "-" . (date('m') - 1) . "-01" . "')"))
                    ->get();
        } else {
            //dd('vencidos');
            $items = Car::where('pay_date', '<=', DB::RAW("DATE('" . $whereDate . "')"))
                    ->where_not_between('pay_date', $whereDateMin, $whereDate)
                    ->get();
        }
    }

    public function post_pusher() {
        //$push = Push::make();
        $push = Push::make(Config::get('push::push.local'));
        if(Input::has('user_id')){
            $user = User::find(Input::get('user_id'));
            if ($user->has_iPhone())
            {
                if($user->isDiageoUser())
                {
		    //dd($user);
                    $result = $push->diageo_ios($user->uuid, Input::get('msg'), 1, 'honk.wav', 'Open');
                }else{
                    $result = $push->ios($user->uuid, Input::get('msg'), 1, 'honk.wav', 'Open');
                }
            }
            else
            {
                $result = $push->users($user->uuid, Input::get('msg'), 1, 'honk.wav', 'Open');
            }
            return $result;
        }else{
            if (Input::get('type') == '1') {//iPhone
                $result = $push->ios(Input::get('uuid'), Input::get('msg'), 1, 'honk.wav');
            } elseif (Input::get('type') == '2') {
                $result = $push->android2(Input::get('uuid'), Input::get('msg'));
            } elseif(Input::has('diageo'))
            {
                $result = $push->diageo_ios(Input::get('uuid'), Input::get('msg'));
    
                }else {
                    $result = $push->android(Input::get('uuid'), Input::get('msg'));
                }
    
            return $result;
        }
    }
    
}

?>
