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
class Cmsuser extends Eloquent {
    public static $timestamps = true;
    public static $table = 'cms_users';
    public static $hidden = array('pwd');
    public static $rules = array(
        'name' => 'required|min:2'
    );
    public static function login($login,$pwd,$uuid,$App=false){
        // $loginData = DB::query("select uuid,id from users where login='{$login}' and '{md5($pwd)}'");
        $loginData= DB::table('users')->where_email_and_pwd($login,$pwd)->first(array('id', 'uuid'));
        //dd($loginData);
        //return json_encode($loginData);
        if($loginData){
            if($loginData->uuid==$uuid){
                return $loginData->id;
            }else{
                if($App==false){
                    DB::table('users')
                        ->where('id', '=', $loginData->id)
                        ->update(array('uuid' => $uuid));
                    return $loginData->id;
                }else{
                    return false;
                }
            }
        }else{
            return null;
        }
    }
    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }
    
    public function has_iPhone()
    {
        return ($this->type == '1');
    }


    public function notify_service($service)
    {
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
            );
            $payload['user_name'] = $this->name;
            $nigth = ((int)date('G')) >= 22;
            $distance = $nigth ? 10 : 6;
            $drivers = $service->requestService(false, $service->from_lat, $service->from_lng, $distance);
            if (empty($drivers))
            {
                if ($nigth) 
                {
                    $success = 1;//no hay taxis
                }
                else
                {
                    $drivers = $service->requestService(false, $service->from_lat, $service->from_lng, 10);
                    if (empty($drivers)) 
                    {
                        $success = 1;//no hay taxis
                    }
                }
            }
            if (!empty($drivers))
            {
                Notifier::drivers($drivers, PushType::NEW_SERVICE, $payload);
            }
         }
        return $success;
    }
	
	 public function notify_service2($service, $drivers = array())
    {
        //echo print_r($service,true);
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
                'schedule_type'     => is_null($service->schedule_type)?0:$service->schedule_type,
                'service_date_time' => $service->service_date_time,
                'destination'  	    => $service->destination
            );
            $payload['user_name'] = $this->name;

            if (empty($drivers))
            {
                //Se notifica a todos los conductores, pero solo los cercanos muestran la notificación en el dispositivo
                $drivers = $this->get_all_drivers();
            }
            if ($drivers) {
		//$payload = array();

		//$payload["service_id"] = $service->id;

		//file_put_contents("/tmp/notify.txt", print_r($service, 1));

        	//Notifier::available_drivers(PushType::NEW_SERVICE, $payload);

               Notifier::drivers($drivers, PushType::NEW_SERVICE, $payload);
            }
            else
            {
                return false;
            }
         }
         return $success;
    }
	
	public function get_all_drivers()
    {
        return Driver::where('available', '=', '1')->group_by('uuid')->get();
    }
    
}

?>
