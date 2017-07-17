<?php

class Notifier {

    public static function available_drivers($push_type, $data = array()) {
            $data['push_type'] = $push_type;
            $drivers =  Driver::available()->select(array('uuid'))->get();
            $push = Push::make();
            $uuids = array_map(function($driver){
            return $driver->uuid;
            }, $drivers);
            return $push->drivers($uuids, PushType::message($push_type), 1, 'default', 'Open', $data);
    }

    public static function drivers($drivers, $push_type, $data = array()) {
            $data['push_type'] = $push_type;

            $push = Push::make();


            /*$uuids = array_map(function($driver) {
                return $driver->uuid;
            }, $drivers);

            return $push->drivers($uuids, PushType::message($push_type), 1, 'default', 'Open', $data);*/

            foreach ($drivers as $userKey => $driver) {
                    $androidDevices[] = $driver->uuid;
            }
            //echo print_r($androidDevices,true);
            return $push->drivers($androidDevices, PushType::message($push_type), 1, 'default', 'Open', $data);
    }

    public static function user($user, $push_type, $data =  array()) {
            $data['push_type'] = $push_type;

            $push = Push::make();

        if ($user->has_iPhone()) {
            if($user->isDiageoUser()) {
                $result = $push->diageo_ios($user->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
            }else{
                $result = $push->ios($user->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
            }
        } else {
            $result = $push->users($user->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
        }
        return $result;
    }

    public static function userclose($id, $push_type = 58, $data = array()) {
        $data['push_type'] = $push_type;
        $push = Push::make();
        $pushMessage = PushType::message($push_type);

        $user = DB::table('users')->where('id','=',$id)->first(); //P.S.A.
        /*if ($user->type==1) {
            $iosDevices = $user->uuid;
            //$resultIOS[] = $push->ios($user->uuid, $pushMessage, 1, 'honk.wav', 'Open', $data);
        } else {
            $androidDevices[] = $user->uuid;
        }
        $resultAndroid = (isset($androidDevices)) ?
        $resultIOS = (isset($iosDevices)) ? $push->ios($iosDevices, $pushMessage, 1, 'honk.wav', 'Open', $data) : 0;
        return array("android" => $resultAndroid, "ios" => $resultIOS);*/
        //dd($user);
        if ($user->type==1) {
            //dd("type = 1");
            $result = $push->ios($user->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
        } else {
            $androidDevices[] = $user->uuid;
            $result = $push->users($androidDevices, $pushMessage, 1, 'honk.wav', 'Open', $data);
        }
        return true;
    }

    public static function driverclose($id, $push_type = 59, $data = array()) {
        $data['push_type'] = $push_type;
        $push = Push::make();
        $pushMessage = PushType::message($push_type);

        $driver = DB::table('drivers')->where('id','=',$id)->first();


        // uuid ios
        // 806dd607a4 9c16d00cee 88dd3fed59 06f48b79ab e461905563 df658844b7 5375
        // uuid Android
        // APA91bGK_A7sbrJ9fVKNEHfQ3xXs_ywY2l6Ym-c-fg7933rN545kV8OqnXNAEnl7mE81WnU-ogN4If26LPSVQK1DMQZpc-qo2by4cm-KjQI0gMyuB66jKrWEhYMfonR1MXIAnfft0mTfRleiklmCGW9ArqMeCwAdpA
        //dd($driver->uuid);

        if (strlen($driver->uuid) > 64) { // android
            //dd("driver android");
            $androidDevices[] = $driver->uuid;
            $result = $push->drivers($androidDevices, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
        }
        else { // ios
            //dd("driver iOS");
            $result = $push->taxistas_ios($driver->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
        }

        //$result = $push->drivers($driver->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
        return true;
//      //$resultAndroid = $push->drivers($uuids, PushType::message($push_type), 1, 'default', 'Open', $data);
//      $resultAndroid = $push->drivers($driver->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
//      return $resultAndroid;

    }

    public static function driver($driver, $push_type, $data = array()) {
            $data['push_type'] = $push_type;
            $push = Push::make();
        $result = $push->drivers($driver->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
        return $result;
    }

    public static function massive($message = false, $userKind = true, $push_type = 38,$data = array()) {
        $data['push_type'] = $push_type;
        $push = Push::make();
        $pushMessage = (isset($message)) ? $message : PushType::message($push_type);
        
        if ($userKind === true) {
            
           //$users = User::all();
            $users = DB::table('users')->distinct('token')->where('token','<>','')->get();
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
            //dd('Usuario');
            //    exit();
            return array("android" => $resultAndroid, "ios" => $resultIOS);
        } else {
           //$drivers = Driver::all();

            
            $drivers = DB::table('drivers')->distinct('token')->where('token','<>','')->get();
            /*$uuids = array_map(function($driver) {
                        return $driver->token;
                    }, $drivers);
            $result = $push->drivers($uuids, $pushMessage, 1, 'honk.wav', 'Open', $data);*/
            $resultIOS =array();
            foreach ($drivers as $driverKey => $driver) {
                if (strlen($driver->uuid) > 64) { 
                   $androidDevices[] = $driver->uuid; 
                } else {
                    $resultIOS[] = $push->taxistas_ios($driver->uuid, $pushMessage, 1, 'honk.wav', 'Open', $data);
                }
            }
            $resultAndroid = (isset($androidDevices)) ? $push->drivers($androidDevices, $pushMessage, 1, 'honk.wav', 'Open', $data) : 0;
               
               /* if (strlen($driver->uuid) > 64) { // android
                    //dd("driver android");
                    $androidDevices[] = $driver->uuid;
                    $result = $push->drivers($androidDevices, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
                }
                else { // ios
                    //dd("driver iOS");
                    $result = $push->taxistas_ios($driver->uuid, PushType::message($push_type), 1, 'honk.wav', 'Open', $data);
                }*/
               // dd('Taxista');
                //exit();
            return array("android" => $resultAndroid, "ios" => $resultIOS);
        }
    }
}       

final class PushType {

const NEW_SERVICE = 1;
const REMOVE_SERVICE = 2;
const USER_CANCELED_SERVICE = 30;
const DRIVER_CANCELED_SERVICE = 31;
const APP_CANCELED_SERVICE = 32;
const OPERATOR_CANCELED_SERVICE = 33;
const SYSTEM_CANCELED_SERVICE = 34;
const CONFIRMED_SERVICE = 4;
const DRIVER_ARRIVED = 5;
const DRIVER_POSITION = 6;
const USER_CLOSE = 58;
const DRIVER_CLOSE = 59;
const FINISHED_SERVICE = 7;
const MASSIVE_NOTIFICATION = 38;

public static function message($type)
{
    switch ($type) {
        case self::NEW_SERVICE:
            return '¡Tenemos un nuevo servicio!';
        case self::REMOVE_SERVICE:
            return 'Se ha cancelado un servicio';
        case self::USER_CANCELED_SERVICE:
            return 'Servicio cancelado por usuario';
        case self::DRIVER_CANCELED_SERVICE:
            return 'Servicio cancelado por conductor';
        case self::SYSTEM_CANCELED_SERVICE:
            return 'No hay conductores disponibles, intente en 10 minutos';
        case self::OPERATOR_CANCELED_SERVICE:
            return 'Servicio cancelado por operadora';
        case self::CONFIRMED_SERVICE:
            return 'Un conductor está en camino';
        case self::DRIVER_ARRIVED:
            return 'Nuestro conductor ha llegado';
        case self::DRIVER_POSITION:
            return 'Nuestro conductor se está acercando';
        case self::USER_CLOSE:
            return 'Sesion cerrada, usuario logueado en otro dispositivo';
        case self::DRIVER_CLOSE:
            return 'Sesion cerrada, conductor logueado en otro dispositio';
        case self::MASSIVE_NOTIFICATION:
                return 'Notificacion masiva';
        case FINISHED_SERVICE:
                return 'Gracias por utilizar TaxisYa, lo invitamos a calificar nuestro servicio';
    }
    }
}
