<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author IngJohnGuerrero
 */
class User extends Eloquent {

    public static $timestamps = true;
    public static $table = 'users';
    public static $hidden = array('pwd');
    public static $rules = array(
        'name' => 'required|min:2',
        'lastname' => 'required|min:2',
        'email' => 'required|min:2',
        'login' => 'required|min:2',
        'pwd' => 'required|min:2',
        'uuid' => 'required|min:2'
    );

    /* public static function login($login, $pwd, $uuid, $App = false, $token = FALSE) {
      // $loginData = DB::query("select uuid,id from users where login='{$login}' and '{md5($pwd)}'");
      $loginData = DB::table('users')->where_email_and_pwd($login, $pwd)->first(array('id', 'uuid'));
      //dd($pwd);
      //dd($loginData);
      //return json_encode($loginData);
      if ($loginData) {
      if ($loginData->uuid == $uuid) {
      return $loginData->id;
      } else {
      if ($App == false) {
      DB::table('users')
      ->where('id', '=', $loginData->id)
      ->update(array('uuid' => $uuid));
      if ($token != FALSE) {
      DB::table('users')
      ->where('id', '=', $loginData->id)
      ->update(array('token' => $token));
      }
      return $loginData->id;
      } else {
      return false;
      }
      }
      } else {
      return null;
      }
      } */

    public static function login($login, $pwd, $uuid, $type, $diageo = 0, $App = false) {
        // $loginData = DB::query("select uuid,id from users where login='{$login}' and '{md5($pwd)}'");
        $loginData = DB::table('users')->where_email_and_pwd(trim($login), strtoupper(trim($pwd)))->first(array('id', 'uuid'));
        //$type = Input::get('type');
        //dd($loginData);
        //return json_encode($loginData);
        if (!$loginData){
           $loginData = DB::table('users')->where_email_and_pwd(trim($login), strtolower(trim($pwd)))->first(array('id', 'uuid')); 
        }
		 if ($loginData) {
				if ($loginData->uuid == $uuid) {
					//return $loginData->id; //Desde el mismo equipo
					return array('error' => '0', 'id' => $loginData->id);
				} else {//Desde otro equipo
					//if ($App == false) {
						 //print
						 if(Notifier::userclose($loginData->id)==true)
						 {
						 //if($result <> 0){
							 DB::table('users')
										->where('id', '=', $loginData->id)
										->update(
											array(
												'token' => $uuid,
												'uuid' => $uuid,
												'diageo' => ($diageo == 1)?1:0,
												'type' => $type,
												)
											);
						}
						//}
							//return $loginData->id;
							return array('error' => '0', 'id' => $loginData->id);
							//return array('error' => '2', 'id' => '0');
						//}
					/*}else {
					//return Response::json(array('error' => '2'));
					return array('error' => '2', 'id' => '0');
					}*/
                }

        }else {
            //return Response::json(array('error' => '1')); //Contraseña incorrecta
            return array('error' => '1', 'id' => '0');
        }
    }



    public static function logOut($login, $pwd) {
        $loginData = DB::table('users')->where_email_and_pwd($login, $pwd)->first(array('id', 'uuid'));
        if ($loginData) {
            DB::table('users')
                    ->where('id', '=', $loginData->id)
                    ->update(array('uuid' => ''));
            return Response::json(array('error' => '0'));
        } else {
            return Response::json(array('error' => '1'));
        }
    }

    public static function checkDevice($user_id, $uuid) {
        $loginData = DB::table('users')->where_id_and_uuid($user_id, $uuid)->first(array('id', 'uuid'));
        if ($loginData != NULL) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

	public static function is_logued($login, $uuid){
			$loginData = DB::table('users')->where_email(trim($login))->first(array('id', 'uuid'));
			if ($loginData) {
				if ($loginData->uuid == $uuid) {
					return Response::json(array('active' => 'true'));
				}
				else{
					return Response::json(array('active' => 'false'));
				}
			}
			else {
				return Response::json(array('active' => 'false'));
			}
	}

    public function wating_service()
    {
        //return $this->has_many('Service')->where('status_id', '=', '1');
        return $this->has_many('Service')
        ->where_in('status_id',array(1,2,4));
    }

    public function cancel_service($by_system = false)
    {
        $service = $this->has_many('Service')->where('status_id', '=', '1')->first();
        $success = false;
        if ($service)
        {
            $service->status_id = $by_system ? '7': '6';
            $success = $service->save();
            $payload = array();
            $payload['service_id'] = $service->id;
            Notifier::available_drivers(PushType::REMOVE_SERVICE, $payload);
        }
        $service = $this->has_many('Service')->with('driver')->where('status_id', '=', '2')->first();
        if ($service)
        {
            $service->status_id = '6';
            $success = $service->save();
            $service->driver->available = '1';
            $service->save();
            $payload = array();
            $payload['service_id'] = $service->id;
            Notifier::driver($service->driver, PushType::USER_CANCELED_SERVICE, $payload);
        }
        return $success;
    }

    public function get_wating_service()
    {
        return $this->wating_service()->first();
    }

    public function addresses()
    {
        return $this->has_many('Address');
    }

    public function has_iPhone()
    {
        return ($this->type == '1');
    }

    public function isDiageoUser()
    {
        return ($this->diageo == '1');
    }

    public function updateAddressPreference($addr_data)
    {
        $address = Address::where_index_id_and_comp1_and_comp2_and_no_and_barrio_and_user_id($addr_data['index_id'], $addr_data['comp1'], $addr_data['comp2'], $addr_data['no'], $addr_data['barrio'], $this->id)
                ->first();
        if ($address)
        {
            $address->user_pref_order++;
            $address->save();
            return true;
        }
        return false;
    }

    public function addAddress($addr_data)
    {
        $addr_data['user_pref_order'] = 0;
        return $this->addresses()->insert(Address::create($addr_data));
    }

    public function request_service($addr_data, $lat, $lng)
    {
        //Se notifica a todos los conductores, pero solo los cercanos muestran la notificación en el dispositivo
        $success = $drivers = $this->get_all_drivers();

        if ($success)
        {

            // determina ciudad
            $bound = "5";
            $query = "SELECT *,((ACOS(SIN(".$lat."* PI() / 180) * SIN(center_lat * PI() / 180) + COS(".$lat. " * PI() / 180) * COS(center_lat * PI() / 180) * COS((".$lng." - center_lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance
FROM cms_cities WHERE ( center_lat BETWEEN (".$lat." - ".$bound.") AND (".$lat." + ".$bound.") AND center_lng BETWEEN (".$lng." - ".$bound.") AND (".$lng." + ".$bound.") ) ORDER BY distance ASC";
            $result = DB::query($query);
             (count($result) > 0) ? ($city_id = $result[0]->id) : ($city_id = 0);

            // determine country id
            $query = "SELECT * from cities_customers WHERE city_id = ".$city_id;

            $result = DB::query($query);

            $cms_user_id = $result[0]->customer_id;
            //dd($cms_user_id);


            $success = $service = Service::create(array(
                'user_id' => $this->id,
                'status_id' => '1',
                'from_lng'  => $lng,
                'from_lat'  => $lat,
                'index_id'  => $addr_data['index_id'],
                'comp1'     => $addr_data['comp1'],
                'comp2'     => $addr_data['comp2'],
                'no'        => $addr_data['no'],
                'barrio'    => $addr_data['barrio'],
                'obs'       => $addr_data['obs'],
                'address'   => $addr_data['address'],
                'pay_type'       => $addr_data['pay_type'],
                'pay_reference' => $addr_data['pay_reference'],
                'user_email' => $addr_data['user_email'],                
                'user_card_reference' => $addr_data['user_card_reference'],
                'from_lat'  => $lat,
                'from_lng'  => $lng,
                'cms_users_id' => $cms_user_id,
                'kind_id'   => '1'
            ));
            if ($success) {
                $this->notify_service($service, $drivers);
                return $service;
            }
        }
        return false;
    }

    public function get_all_drivers()
    {
        return Driver::where('available', '=', '1')->distinct('uuid')->get();
    }

    public function get_near_drivers($lat, $lng)
    {
        $drivers = false;
        $nigth = ((int)date('G')) >= 22;
        $distance = $nigth ? 2.5 : 5;
        $tmp_service = new Service();

        $drivers = $tmp_service->requestServiceEsteban(false, $lat, $lng, $distance);

        if (empty($drivers) && !$nigth)
        {
            $drivers = $tmp_service->requestServiceEsteban(false, $lat, $lng, 5);
            $drivers = empty($drivers) ? false : true;
        }
        return $drivers;
    }

    public function notify_service($service, $drivers = array())
    {
		//echo print_r($drivers,true);
        $success = $service;
        if ($success)
        {
            $payload = array();
            $payload['service'] = array(
                'service_id'        => $service->id,
                'index_id'          => $service->index_id,
                'comp1'             => $service->comp1,
                'comp2'             => $service->comp2,
                'no'                => $service->no,
                'barrio'            => $service->barrio,
                'obs'               => $service->obs,
                'lat'               => $service->from_lat,
                'lng'               => $service->from_lng,
                'kind_id'           => $service->kind_id,
                'address'           => $service->address,
                'schedule_type'     => is_null($service->schedule_type)?0:$service->schedule_type,
                'service_date_time' => $service->service_date_time,
                'destination'  	    => $service->destination
            );
            $payload['user_name'] = $this->name;

            /*if (empty($drivers))
            {
                //Se notifica a todos los conductores, pero solo los cercanos muestran la notificación en el dispositivo
                $drivers = $this->get_all_drivers();
            }*/
            if ($drivers) {
		//$payload = array();

		//$payload["service_id"] = $service->id;

		//file_put_contents("/tmp/notify.txt", print_r($service, 1));

        	//Notifier::available_drivers(PushType::NEW_SERVICE, $payload);
				//echo print_r($drivers,true);
                Notifier::drivers($drivers, PushType::NEW_SERVICE, $payload);
            }
            else
            {
                return false;
            }
         }
         return $success;
    }
}
