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
class Driver extends Eloquent {

    public static $timestamps = true;
    public static $table = 'drivers';
    public static $hidden = array('pwd');

    public function car() {
        return $this->belongs_to('Car');
    }

    public static function available()
    {
        return self::where('available', '=', '1')->distinct('uuid');
    }

    public function active_service()
    {
        return $this->has_many('Service')->where('status_id', '=', '2')->or_where('status_id','=','4')->order_by('id', 'desc');
    }

	public function active_service2()
    {
        return $this->has_many('Service')->where('status_id', '=', '2')->order_by('id', 'desc');
    }

    public function cancel_service()
    {
        $service = $this->active_service()->with('user')->first();
        $sucess = false;
        if ($service)
        {
            $service->status_id = '8';
            $sucess = $service->save();
            $this->available = '1';
            $this->save();
            Notifier::user($service->user, PushType::DRIVER_CANCELED_SERVICE);
        }
        return $sucess;
    }

    public function get_payload()
    {
        $payload = array();
        $payload['driver'] = array(
            'id'                => $this->id,
            'name'              => $this->name .' '.  $this->lastname,
            'telephone'         => $this->telephone,
            'cellphone'         => $this->cellphone,
            'lat'               => $this->crt_lat,
            'lng'               => $this->crt_lng,
            'picture'           => $this->picture,
            'car'               => array(
                'plate'     => $this->car->placa,
                'brand'     => $this->car->car_brand,
                'car_brand' => $this->car->car_brand,
                'city_id' => $this->car->city_id,
                'empresa' => $this->car->empresa,
                'id' => $this->car->id,
                'model' => $this->car->model,
                'movil' => $this->car->movil,
                'pay_date' => $this->car->pay_date,
                'placa' => $this->car->placa,
                'year' => $this->car->year,
            )
        );
        return $payload;
    }

    public function notifyArrival()
    {
        $service = $this->active_service()->with('user')->first();
        $sucess = false;
        if ($service)
        {
            $service->status_id = '4';
            $sucess = $service->save();
            $this->available = '0';
            $this->save();
            $payload = array();
            $payload['kind_id'] = $service->kind_id;
            $payload['service_id'] = $service->id;
            $payload['status_id'] = $service->status_id;
            // Notifier::user($service->user, PushType::DRIVER_ARRIVED);
            Notifier::user($service->user, PushType::DRIVER_ARRIVED,$payload);

        }
        return $sucess;
    }

    public static $rules = array(
        'name' => 'required|min:2',
        'lastname' => 'required|min:2',
        'email' => 'required|min:2',
        'login' => 'required|min:2',
        'pwd' => 'required|min:2'
    );

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

    public static function login($login, $pwd, $uuid, $App = false, $morosos = FALSE) {
        // $loginData = DB::query("select uuid,id from users where login='{$login}' and '{md5($pwd)}'");
        //$loginData = DB::table('drivers')->where_email_and_pwd($login, $pwd)->first(array('id', 'uuid'));
        // por email
        //$loginData = DB::table('drivers')->where('email', '=', $login)->where('pwd', '=', $pwd)->first(array('id', 'uuid'));
        // por cédula
        //$loginData = DB::table('drivers')->where('cedula', '=', $login)->where('pwd', '=', $pwd)->first(array('id', 'uuid'));
        $value = intval($login);
        if ($value > 0 ) {
            $loginData = DB::table('drivers')->where('cedula', '=', $login)->where('pwd', '=', $pwd)->first(array('id', 'uuid'));
        }
        else {
            $loginData = DB::table('drivers')->where('email', '=', $login)->where('pwd', '=', $pwd)->first(array('id', 'uuid'));
        }
        //dd($loginData);
        //return json_encode($loginData);
        if (isset($loginData)) {
            $dayAmount = DB::query("select " . DB::raw('DATEDIFF(NOW(),`pay_date`) as days') . " from cars where id=? ", array($loginData->id)); //SELECT DATEDIFF(NOW(),`pay_date`) FROM `cars` WHERE id='1'
            //dd(intval($dayAmount[0]->days)<40);
            if ($dayAmount) {
                if (intval($dayAmount[0]->days) > 40) {
                    //return array('error' => '3', 'id' => '0');
					return array('error' => '0', 'id' => $loginData->id);
                }
            }
            if ($morosos) {
                if (in_array($loginData->id, $morosos)) {
                    //return array('error' => '3', 'id' => '0');
					return array('error' => '0', 'id' => $loginData->id);
                }
            }
            if ($loginData->uuid == $uuid) {
                //return $loginData->id; //Desde el mismo equipo
                $driverId = $loginData->id;
                return array('error' => '0', 'id' => $driverId);
            } else {//Desde otro equipo
			
                if(Notifier::driverclose($loginData->id)==true){
                         //if($result <> 0){
                     DB::table('drivers')
                                ->where('id', '=', $loginData->id)
                                ->update(
                                    array(
                                        'token' => $uuid,
                                        'uuid' => $uuid,)
                                );
                }
                return array('error' => '0', 'id' => $loginData->id);


             /*	
                // COMIENZO LOGICA ANTERIOR AL 14-03-2016
             Notifier::driverclose($loginData->id);
                if ($App == false) {
                    if ($loginData->uuid == NULL || $loginData->uuid == '') {// || isset($loginData->uuid)) { //Without Active Session
                        DB::table('drivers')
                                ->where('id', '=', $loginData->id)
                                ->update(array('token' => $uuid,
												'uuid' => $uuid,)
										);
                        //return $loginData->id;
                        $driverId = $loginData->id;
                        return array('error' => '0', 'id' => $driverId);
                    } else { //With Active Session
                        //return Response::json(array('error' => '2'));
                        //return array('error' => '2', 'id' => '0');
                        DB::table('drivers')
                                ->where('id', '=', $loginData->id)
                                ->update(array('token' => $uuid,
												'uuid' => $uuid,)
										);
                        $driverId = $loginData->id;
                        return array('error' => '0', 'id' => $driverId);
                    }
                } else {
                    //return Response::json(array('error' => '2'));
                    return array('error' => '2', 'id' => '0');
                } 
                // LOGICA ANTERIOR AL 14-03-2016    
                */
            }
        } else {
            //return Response::json(array('error' => '1')); //Contraseña incorrecta
            return array('error' => '1', 'id' => '0');
        }
    }

    public static function logOut($login, $uuid) {
        // por email
        //$loginData = DB::table('drivers')->where_email_and_uuid($login, $uuid)->first(array('id', 'uuid'));
        // por cédula
        //$loginData = DB::table('drivers')->where_cedula_and_uuid($login, $uuid)->first(array('id', 'uuid'));

        $value = intval($login);
        if ($value > 0 ) {
            $loginData = DB::table('drivers')->where_cedula_and_uuid($login, $uuid)->first(array('id', 'uuid'));
        }
        else {
            $loginData = DB::table('drivers')->where_email_and_uuid($login, $uuid)->first(array('id', 'uuid'));
        }

        if ($loginData) {
            DB::table('drivers')
                    ->where('id', '=', $loginData->id)
                    ->update(array('uuid' => '', 'available' => '0'));
            return Response::json(array('error' => '0'));
        } else {
            return Response::json(array('error' => '1'));
        }
    }

    public static function checkDevice($id, $uuid) {
        $loginData = DB::table('drivers')->where_id_and_uuid($id, $uuid)->first(array('id', 'uuid'));
        //dd($loginData);
        if ($loginData != NULL) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_close_services()
    {
        $nigth = ((int)date('G')) >= 22;
        //$distance = $nigth ? 10 : 6;
        $distance = $nigth ? 5 : 2;
        return DB::query("SELECT services.*, users.name AS username,
                                        (6371 * ACOS( COS( RADIANS( ? ) ) *
                                        COS( RADIANS( from_lat ) ) * COS( RADIANS( from_lng ) -
                                        RADIANS( ? ) ) + SIN ( RADIANS( ? ) ) * SIN( RADIANS( from_lat ) ) )) AS distance
                                      FROM services, users
                                      WHERE status_id =  1 AND services.user_id = users.id
                                      HAVING distance < ?
									  
                                      ORDER BY distance ",array($this->crt_lat, $this->crt_lng, $this->crt_lat,$distance));

        /*

        UNION (SELECT services.*, user_name AS username, 0 AS distance FROM services, users WHERE status_id= 1 AND services.user_id = users.id AND kind_id = 3)
                                      UNION (SELECT services.*, users.name AS username, 0 AS distance FROM services, users WHERE status_id= 1 AND services.user_id = users.id AND kind_id = 2)
                                      */
    }

}

?>
