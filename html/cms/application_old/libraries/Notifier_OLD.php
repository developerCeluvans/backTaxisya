<?php

class Notifier {

    public static function available_drivers($push_type, $data = array()) {
        $data['push_type'] = $push_type;
        $drivers = Driver::available()->select(array('uuid'))->get();
        $push = Push::make();
        $uuids = array_map(function($driver) {
                    return $driver->uuid;
                }, $drivers);
        return $push->drivers($uuids, PushType::message($push_type), 1, 'default', 'Open', $data);
    }

    public static function drivers($drivers, $push_type, $data = array()) {
        $data['push_type'] = $push_type;
        $push = Push::make();
        $uuids = array_map(function($driver) {
                    return $driver->uuid;
                }, $drivers);
        return $push->drivers($uuids, PushType::message($push_type), 1, 'default', 'Open', $data);
    }

    public static function massive($message = false, $userKind = true, $push_type = 38, $data = array()) {
        $data['push_type'] = $push_type;
        $push = Push::make();
        $pushMessage = (isset($message)) ? $message : PushType::message($push_type);

        if ($userKind === true) {
           //$users = User::all();
			$users = DB::table('users')->group_by('token')->where('token','<>','')->get();
			$resultIOS =array();
            foreach ($users as $userKey => $user) {
                if ($user->type==1) {
                    //$iosDevices = $user->uuid;
                    $resultIOS[] = $push->ios($user->token, $pushMessage, 1, 'honk.wav', 'Open', $data);
                } else {
                    $androidDevices[] = $user->token;
                }
            }
			//$androidDevices[0]='APA91bG83tBbX6OD-JUrTpn53p5YOEOutkERogmpaTWvZNK32GEeABD7EHsh6oyxR78f-QV8iA-jdppjbwRCcD0P_nSTaku-cWfC2ihXr6UI78gdZvvSDaq1B8A8fzapXb9VDRG77XTHEoWO1Lqev2U5X-Ruq44UPzT_BW7oHCHAHLPzDx9FHnA';
			//$androidDevices[1]='APA91bGhHCvt9XqdyabGqyg2YOS9sBZnume5Fb5IEqqRyS3MOCIcDj3nf3wFBVn1AtAVGF_KC1jJg02h6-vviZxeLeQ8GknkBG9-xVP2CaYrSyQEP6UIsQItDKYVSaYbTZb_uK7o4BK1XRBUky9s78spk44hteQKy5Y5JzV8FK3NF-5CBnHLGSk';
			//$androidDevices[2]='APA91bHmBy1jQp3nrRpbPiERTKYF9VwfddIV2hQ85VXuv9O0Bnk_IeeM-BrTT5ei94bgx2PClfXbDKrhXRB9EUsaH95p6oep6RaVqtYl83UclDvUI9rhX55_oIZoD0FhwmxeCL5jncjIRTEBQkNJ429RkDrrmUn5Rfq979Quzc1iXtGOQLOrGRg';
            $resultAndroid = (isset($androidDevices)) ? $push->users($androidDevices, $pushMessage, 1, 'honk.wav', 'Open', $data) : 0;
            //$resultIOS = (isset($iosDevices)) ? $push->ios($iosDevices, $pushMessage, 1, 'honk.wav', 'Open', $data) : 0;
            return array("android" => $resultAndroid, "ios" => $resultIOS);
        } else {
           //$drivers = Driver::all();
			$drivers = DB::table('drivers')->group_by('token')->where('token','<>','')->get();
            $uuids = array_map(function($driver) {
                        return $driver->token;
                    }, $drivers);
            return $push->drivers($uuids, $pushMessage, 1, 'default', 'Open', $data);
        }
    }

    public static function update_available_user($isIPhone = true, $message = "Actualización disponible", $data = array(),$push_type = 35) {
        $data['push_type'] = $push_type;
        $push = Push::make();
        $pushMessage = (isset($message)) ? $message : PushType::message($push_type);

        if ($isIPhone === true) {
            $users = User::where('type', '=', 1)->get();
        }else{
            $users = User::where('type', '=', 2)->get();
        }
        //$users = User::where('id', '=', 43)->get();
            foreach ($users as $userKey => $user) {
                if ($user->has_iPhone()) {
                    //$iosDevices = $user->uuid;
                    try{
                        $resultIOS[] = $push->ios($user->uuid, $pushMessage, 1, 'honk.wav', 'Open', $data);
                    }catch(Exception $e){

                    }
                } else {
                    $androidDevices[] = $user->uuid;
                }
            }
            $resultAndroid = (isset($androidDevices)) ? $push->users($androidDevices, $pushMessage, 1, 'honk.wav', 'Open', $data) : 0;
            //$resultIOS = (isset($iosDevices)) ? $push->ios($iosDevices, $pushMessage, 1, 'honk.wav', 'Open', $data) : 0;
            return array("android" => $resultAndroid, "ios" => $resultIOS); 
    }

    public static function update_available_driver($message = "Actualización disponible", $data = array(),$push_type = 35) {
        $data['push_type'] = $push_type;
        $push = Push::make();
        $pushMessage = (isset($message)) ? $message : PushType::message($push_type);

            $drivers = Driver::all();
            $uuids = array_map(function($driver) {
                        return $driver->uuid;
                    }, $drivers);
            return $push->drivers($uuids, $pushMessage, 1, 'default', 'Open', $data);

    }

    public static function user($user, $push_type, $data = array()) {
        $data['push_type'] = $push_type;
        $push = Push::make();
        if ($user->has_iPhone()) {
            $result = $push->ios($user->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
        } else {
            $result = $push->users($user->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
        }
        return $result;
    }

    public static function driver($driver, $push_type, $data = array()) {
        $data['push_type'] = $push_type;
        $push = Push::make();
        $result = $push->drivers($driver->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
        return $result;
    }

}

final class PushType {

    const NEW_SERVICE = 1;
    const REMOVE_SERVICE = 2;
    const USER_CANCELED_SERVICE = 30;
    const DRIVER_CANCELED_SERVICE = 31;
    const APP_CANCELED_SERVICE = 32; //nadie llama aun
    const OPERATOR_CANCELED_SERVICE = 33;
    const MASSIVE_NOTIFICATION = 38;
    const UPDATE_NOTIFICATION = 35;
    const CONFIRMED_SERVICE = 4;
    const DRIVER_ARRIVED = 5;
    const DRIVER_POSITION = 6;

    public static function message($type) {
        switch ($type) {
            case self::NEW_SERVICE:
                return 'Un usuario ha pedido un servicio';
            case self::REMOVE_SERVICE:
                return 'Se ha cancelado un servicio';
            case self::USER_CANCELED_SERVICE:
                return 'El usuario ha cancelado el servicio';
            case self::DRIVER_CANCELED_SERVICE:
                return 'El conductor ha cancelado el servicio';
            case self::OPERATOR_CANCELED_SERVICE:
                return 'La operadora ha cancelado el servicio';
            case self::MASSIVE_NOTIFICATION:
                return 'Notificacion masiva';
            case self::UPDATE_NOTIFICATION:
                return 'Actualización disponible';
            case self::CONFIRMED_SERVICE:
                return 'Un taxista va en camino';
            case self::DRIVER_ARRIVED:
                return 'El taxista ha llegado';
            case self::DRIVER_POSITION:
                return 'El taxista se esta acercando';
        }
    }

}