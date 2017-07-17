<?php

class Notifier_Controller extends Base_Controller {

    public $restful = true;

    public function post_index() {
        $formTemplate = array(
            array(
                "title" => array(
                    "Mensaje",
                    ""),
                "name" => "push_msg",
                "value" => null,
                "type" => "textarea",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "Tipo",
                    "de usuario"),
                "name" => "whom_id",
                "options" => array('1' => 'Usuarios', '2' => 'Taxistas'),
                "selected" => null,
                "type" => "select",
                "attributes" => array()
            )
        );
        $titleArray = array();
        $action = 'send';
        $section = 'notifier';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        return View::make($section . '.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('idToEdit', '0')
                        ->with('message', NULL)
                        ->with('result', NULL)
                        ->with('section', $section)
                        ->with('title', 'Nuevo mensaje');
    }

    public function post_send() {
        $msg = Input::get('push_msg');
        $whom_id = Input::get('whom_id');
        $pushMessage = $msg;

        if ($whom_id == 2) {//conductor
            $result = Notifier::massive($msg, false);
        } else {//usuario
            $result = Notifier::massive($msg, true);

        }

        //dd($result);
        //exit();

        /*
          if ($whom_id == 1) {//usuario
          $receivers = User::all();
          } else {//conductor
          $receivers = Driver::all();
          }

          foreach ($receivers as $key => $receiver) {
          $push = Push::make();
          if ($whom_id == 1) {
          if ($receiver->type == '1') {//iPhone
          $push->ios($receiver->uuid, $pushMessage, 1, 'honk.wav');
          } else {
          $push->android2($receiver->uuid, $pushMessage);
          }
          } else {
          $push->android($receiver->uuid, $pushMessage);
          }
          } */

        $formTemplate = array(
            array(
                "title" => array(
                    "Mensaje",
                    ""),
                "name" => "push_msg",
                "value" => null,
                "type" => "textarea",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "Tipo",
                    "de usuario"),
                "name" => "role_id",
                "options" => array('1' => 'Usuarios', '2' => 'Taxistas'),
                "selected" => null,
                "type" => "select",
                "attributes" => array()
            )
        );
        $titleArray = array();
        $action = 'send';
        $section = 'notifier';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        $msg = 'Mensaje enviado!';
        $type = 'success';
        return View::make($section . '.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('idToEdit', '0')
                        ->with('section', $section)
                        ->with('title', 'Nuevo mensaje');
    }

    public function post_expired() {
        //SELECT id from drivers where (TIMESTAMPDIFF(DAY,created_at,NOW()))>=25
        $whereDate = date('Y') . "-" . date('m') . "-05";
        $whereDateMin = date('Y') . "-" . date('m') . "-01";
        $items = Car::with('drivers')->where('pay_date', '<', DB::RAW("DATE('" . $whereDate . "')"))
                ->where_not_between('pay_date', $whereDateMin, $whereDate)
                ->get();
        //dd($items->drivers);
        $drivers;
        if (isset($items)) {
            foreach ($items as $item) {
                foreach ($item->drivers as $driver) {
                    $drivers[] = $driver;
                }
            }
        }
        //dd($drivers);
        //dd($items);
		//where(DB::RAW('TIMESTAMPDIFF(DAY,pay_Date,NOW())'), 
		//'>=', 
		//'25')->get();
        /*
          from
          cars
          where
          pay_date <= DATE('2013-06-05')
          and pay_date NOT between ('2013-06-01') and ('2013-06-05')
         */
        $pushMessage = "Se acerca el vencimiento del pago de la afilicación, cancele lo antes posible. Si ya lo realizó haga caso omiso de este mensaje";
        foreach ($drivers as $key => $driver) {
            $push = Push::make();
            $result = $push->android($driver->uuid, $pushMessage);
        }
        $titleArray = array("NO" => "id",
            "Placa" => "placa",
            "Marca" => "car_brand",
            "Línea" => "model",
            "empresa" => "empresa",
            "Último pago" => "pay_date"
        );
        $section = 'car';
        $manageBtns = array(
            'add' => FALSE,
            'edit' => true,
            'del' => FALSE
        );
        $msg = 'Mensaje enviado a taxistas!';
        $type = 'success';
        return View::make($section . '.expired')
                        ->with('title', 'Vehículos con afiliaciones vencidas')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('manageBtns', $manageBtns)
                        ->with('items', $items);
        /* $drivers = Driver::where(DB::RAW('TIMESTAMPDIFF(DAY,join_Date,NOW())'), '>=', '25')->get();
          $titleArray = array('No.' => 'id',
          "Carro" => array("car", "placa"),
          "Cel." => "cellphone",
          "Nombre" => "name",
          "Apellido" => "lastname",
          "e-mail" => "email",
          "Fecha de afiliciación" => "join_date"
          //"uuid" => "uuid",
          //"Registrado" => "created_at",
          //"Modificado" => "updated_at",
          //"Disponible" => "available",
          //"Estado cuenta" => "account_status"
          );
          $pushMessage = "Se acerca el vencimiento del pago de la afilicación, cancele lo antes posible. Si ya lo realizó haga caso omiso de este mensaje";
          foreach ($drivers as $key => $driver) {
          $push = Push::make();
          $push->android($driver->uuid, $pushMessage);
          }
          $section = 'driver';
          $manageBtns = array(
          'add' => FALSE,
          'edit' => FALSE,
          'del' => FALSE
          );
          $msg = 'Mensaje enviado a taxistas!';
          $type = 'success';
          return View::make($section . '.expired')
          ->with('title', 'Conductores con afiliaciones vencidas')
          ->with('titles', $titleArray)
          ->with('section', $section)
          ->with('message', $msg)
          ->with('result', $type)
          ->with('manageBtns', $manageBtns)
          ->with('items', $drivers); */
    }

}
