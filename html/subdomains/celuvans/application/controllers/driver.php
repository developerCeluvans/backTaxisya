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
class Driver_Controller extends Base_Controller {

    public $restful = true;

    public function get_index() {

        //return View::make('driver.index');
        return View::make('driver.index')
                        ->with('title', 'Conductores actuales')
                        ->with('conductores', Driver::order_by('name')->get());
        //        $view = View::make('driver.index', array('name' => 'John'))->with('age', '28');
        //        $view->location = 'California'; //dont work
        //        $view['specialty'] = 'PHP'; //dont work
        //        return Response::json($usuario->to_array());
    }

    public function get_view($id) {

        //dd(Driver::find($id)->car);
        return View::make('driver.view')
                        ->with('title', 'Conductor')
                        ->with('driver', Driver::find($id));
    }

    public function post_view() {

        if (Input::has('driver_id')) {
            $driverData = Driver::find(Input::get('driver_id'));
            //dd($driverData);
            $placa = (isset($driverData->car_id)) ? $driverData->car->placa : '';
            //$driverData = array('driver' => $driverData->to_array(), 'placa' => $placa);
            $driverData = $driverData->to_array();
            $driverData['placa'] = $placa;
            return Response::json($driverData);
        } else {
            return Response::json(array('error' => '1', 'msg' => 'Id no recibido'));
        }
        //return Response::eloquent();
    }

    public function get_new() {
        return View::make('driver.new')
                        ->with('title', 'nuevo Conductor');
    }

    public function post_create() {

        $validation = Driver::validate(Input::all());
        if ($validation->fails()) {
            return Redirect::to_route('new_driver')->with_errors($validation)->with_input();
        } else {
            Driver::create(array(
                'name' => Input::get('name'),
                'lastname' => Input::get('lastname'),
                'email' => Input::get('email'),
                'login' => Input::get('login'),
                'pwd' => md5(Input::get('pwd'))
            ));
            return Redirect::to_route('driver')->with('message', 'Conductor ' . input::get('name') . ' creado!');
        }
    }

// register driver +
    public function post_register_driver() {
        //$loginData = DB::table('drivers')->where('email','=',Input::get('login'))->or_where('cedula','=',Input::get('cedula'))->first(array('id', 'uuid'));
        $loginData = DB::table('drivers')->where('email','=',Input::get('login'))->first(array('id', 'uuid','cedula'));
        //$afiliacion = new DateTime("" . $year . "-" . $month . "-" . $day . "");
        $afiliacion = "0000-00-00 00:00:00";

        $newDriver = true;

        if ($loginData) {

            if ($loginData->cedula == Input::get('cedula')){
                // grabar cambio en 'status' -> 'modificado'
                $newDriver = false;

                //dd($loginData);
                //dd($loginData->id);
                // update images +
                $driver_image = Input::get('image');
                $decodedImage = base64_decode("$driver_image");

                // Check if writable, if not chmod and set if successful
                $filename = "cms/public/img/drivers/" . $loginData->id. ".jpg";
                if (file_exists($filename)) {
                    $writable = ( is_writable($filename) ) ? TRUE : chmod($filename, 0755);
                    if ( $writable ) {
                        file_put_contents($filename, $decodedImage);
                    }
                }
                else {
                    file_put_contents($filename, $decodedImage);
                }
                //file_put_contents("cms/public/img/drivers/" . $result->id . ".jpg", $decodedImage);

                // doc1
                $driver_document = Input::get('document');
                if ($driver_document) {
                    $decodedDocument = base64_decode("$driver_document");
                    $filename = "cms/public/uploads/docs/doc1_" . $loginData->id . ".jpg";
                    if (file_exists($filename)) {
                        $writable = ( is_writable($filename) ) ? TRUE : chmod($filename, 0755);
                        if ( $writable ) {
                            file_put_contents($filename, $decodedDocument);
                        }
                    }
                    else {
                        file_put_contents($filename, $decodedDocument);
                    }
                    $document1 = 'cms/public/uploads/docs/doc1_'. $loginData->id . '.jpg';
                }
                else {
                    $document1 = '';
                }

                // doc2
                $driver_document2 = Input::get('document2');
                if ($driver_document2) {
                    $decodedDocument2 = base64_decode("$driver_document2");
                    $filename = "cms/public/uploads/docs/doc2_" . $loginData->id . ".jpg";
                    if (file_exists($filename)) {
                        $writable = ( is_writable($filename) ) ? TRUE : chmod($filename, 0755);
                        if ( $writable ) {
                            file_put_contents($filename, $decodedDocument2);
                        }
                    }
                    else {
                        file_put_contents($filename, $decodedDocument2);
                    }
                    $document2 = 'cms/public/uploads/docs/doc2_'. $loginData->id . '.jpg';
                }
                else {
                    $document2 = '';
                }

                // doc3
                $driver_document3 = Input::get('document3');
                if ($driver_document3) {
                    $decodedDocument3 = base64_decode("$driver_document3");
                    $filename = "cms/public/uploads/docs/doc3_" . $loginData->id . ".jpg";
                    if (file_exists($filename)) {
                        $writable = ( is_writable($filename) ) ? TRUE : chmod($filename, 0755);
                        if ( $writable ) {
                            file_put_contents($filename, $decodedDocument3);
                        }
                    }
                    else {
                        file_put_contents($filename, $decodedDocument3);
                    }
                    $document3 = 'cms/public/uploads/docs/doc3_'. $loginData->id . '.jpg';
                }
                else {
                    $document3 = '';
                }

                // doc4
                $driver_document4 = Input::get('document4');
                if ($driver_document4) {
                    $decodedDocument4 = base64_decode("$driver_document4");

                    $filename = "cms/public/uploads/docs/doc4_" . $loginData->id . ".jpg";
                    if (file_exists($filename)) {
                       $writable = ( is_writable($filename) ) ? TRUE : chmod($filename, 0755);
                       if ( $writable ) {
                           file_put_contents($filename, $decodedDocument4);
                       }
                    }
                    else {
                        file_put_contents($filename, $decodedDocument4);
                    }
                    $document4 = 'cms/public/uploads/docs/doc4_'. $loginData->id . '.jpg';
                }
                else {
                    $document4 = '';

                }

                // validate if cms_documents exist

                $query = "SELECT * FROM cms_documents WHERE driver_id = ". $loginData->id . ";";
                $result3 = DB::query($query);
                //dd($result3);
                if (!$result3) {
                    $result2 = Document::create(array(
                        'documento1' => $document1,
                        'documento2' => $document2,
                        'documento3' => $document3,
                        'documento4' => $document4,
                        'driver_id' => $loginData->id
                    ));
                }  else{
                    $query = "update cms_documents SET documento1  = '".$document1."',documento2 = '". $document2."',documento3 = '". $document3."',documento4 = '".$document4."', updated_at = '".date("d-m-Y H:i:s")."' WHERE driver_id = ". $loginData->id . ";";
                    
                    $result3 = DB::query($query);
                }

                

                // update images -

                $carData = DB::table('cars')->where('placa','=',Input::get('car_tag'))->first(array('id', 'city_id'));
                if ($carData) {
                    $query = "Update drivers set picture='cms/public/img/drivers/".$loginData->id.".jpg' , status = 'nuevo' where id='".$loginData->id."'";
                    $result2 = DB::query($query);
                    $this->update_cars($loginData->id, $carData->id);

                    $result = Driver::update($loginData->id,array(
                    'name' => Input::get('name'),
                    'lastname' => Input::get('lastname'),
                    'cellphone' => Input::get('cellphone'),
                    'email' => Input::get('login'),
                    'login' => Input::get('login'),
                    //'car_id' => 1577, // valor por  defecto para poder ver el listado de "Conductores"
                    'car_id' => $carData->id,
                    'pwd' => md5(Input::get('pwd')),
                    'cedula' => Input::get('cedula'),
                    'dir' => Input::get('dir'),
                    'telephone' => Input::get('telephone'),
                    'license' => Input::get('license'),
                    'movil' => Input::get('car_movil'),
                    'uuid' => '',
                    'city_id' => Input::get('city_id'),
                    'status' => 'nuevo',
                    ));

                    return Response::json(array('error' => 0, 'msg' => '¡Se Actualizaron los datos!' ));
                } else {
                    $newCar = Car::create(array(
                                    "placa" => Input::get('car_tag'),
                                    "car_brand" => Input::get('car_brand'),
                                    "model" => Input::get('car_line'),
                                    "movil" => Input::get('car_movil'),
                                    "year" => Input::get('car_year'),
                                    "empresa" => Input::get('car_company'),
                                    'city_id' => Input::get('city_id'),
                                    "pay_date" => $afiliacion
                    ));
                    $car_id = $newCar->id;

                    $query = "Update drivers set picture='cms/public/img/drivers/".$loginData->id.".jpg', car_id = ".$car_id.", status = 'nuevo'    where id='".$loginData->id."'";
                    $result2 = DB::query($query);
                    $this->update_cars($loginData->id, $car_id);

                    $result = Driver::update($loginData->id,array(
                    'name' => Input::get('name'),
                    'lastname' => Input::get('lastname'),
                    'cellphone' => Input::get('cellphone'),
                    'email' => Input::get('login'),
                    'login' => Input::get('login'),
                    //'car_id' => 1577, // valor por  defecto para poder ver el listado de "Conductores"
                    'car_id' => $car_id,
                    'pwd' => md5(Input::get('pwd')),
                    'cedula' => Input::get('cedula'),
                    'dir' => Input::get('dir'),
                    'telephone' => Input::get('telephone'),
                    'license' => Input::get('license'),
                    'movil' => Input::get('car_movil'),
                    'uuid' => '',
                    'city_id' => Input::get('city_id'),
                    'status' => 'nuevo',
                    ));

                    return Response::json(array('error' => 0, 'msg' => '¡Se actualizaron los datos!' ));
                }

               //return Response::json(array('error' => 5, 'msg' => '¡Ya esta registrado este correo electrónico!' ));
                //return Response::json(array('msg' => '¡Ya esta registrado este correo electrónico!' ));
                //return Response::json($result);
            } else {
                return Response::json(array('error' => 5, 'msg' => '¡Por favor acerquese a la oficina Administrativa'));
            }    
        }

        // register vehicle
        //dd(Input::all());
        //dd( Input::get('car_tag') );

        // detect si car existe, buscar por placa

        $carData = DB::table('cars')->where('placa','=',Input::get('car_tag'))->first(array('id', 'city_id'));
        if ($carData) {
           $car_id = $carData->id;
            //return Response::json(array('error' => 5, 'msg' => '¡Ya existe esta placa registrada!' ));
            //if (!$newDriver)
                
                //return Response::json(array('error' => 5,'msg' => '¡Ya existe esta placa registrada!' ));
        }
        else {
            $newCar = Car::create(array(
                            "placa" => Input::get('car_tag'),
                            "car_brand" => Input::get('car_brand'),
                            "model" => Input::get('car_line'),
                            "movil" => Input::get('car_movil'),
                            "year" => Input::get('car_year'),
                            "empresa" => Input::get('car_company'),
                            'city_id' => Input::get('city_id'),
                            "pay_date" => $afiliacion
            ));
            $car_id = $newCar->id;
        }

        $driver_name  = Input::get('cedula');
        //dd( Input::get('car_tag') );
        //dd( Input::get('car_taq') );
        //dd($newCar);

        // prueba -
        $result = Driver::create(array(
                'name' => Input::get('name'),
                'lastname' => Input::get('lastname'),
                'cellphone' => Input::get('cellphone'),
                'email' => Input::get('login'),
                'login' => Input::get('login'),
                //'car_id' => 1577, // valor por  defecto para poder ver el listado de "Conductores"
                'car_id' => $car_id,
                'pwd' => md5(Input::get('pwd')),
                'cedula' => Input::get('cedula'),
                'dir' => Input::get('dir'),
                'telephone' => Input::get('telephone'),
                'license' => Input::get('license'),
                'movil' => Input::get('car_movil'),
                'uuid' => '',
                'city_id' => Input::get('city_id'),
                'status' => 'nuevo',
                ));
        // save documents

        // set documents +

        // $document1 = 'cms/public/uploads/docs/doc1_'.  $result->id. '.jpg';
        // $document2 = 'cms/public/uploads/docs/doc2_'.  $result->id. '.jpg';
        // $document3 = 'cms/public/uploads/docs/doc3_'.  $result->id. '.jpg';


        // set documents -
        // $result2 = Document::create(array(
        //     'documento1' => $document1,
        //     'documento2' => $document2,
        //     'documento3' => $document3,
        //     'driver_id' => $result->id
        // ));

        $driver_image = Input::get('image');
        $decodedImage = base64_decode("$driver_image");
        file_put_contents("cms/public/img/drivers/" . $result->id . ".jpg", $decodedImage);

        // doc1
        $driver_document = Input::get('document');
        if ($driver_document) {
            $decodedDocument = base64_decode("$driver_document");
            file_put_contents("cms/public/uploads/docs/doc1_" . $result->id . ".jpg", $decodedDocument);
            $document1 = 'cms/public/uploads/docs/doc1_'.  $result->id. '.jpg';
        }
        else {
            $document1 = '';
        }

        // doc2
        $driver_document2 = Input::get('document2');
        if ($driver_document2) {
            $decodedDocument2 = base64_decode("$driver_document2");
            file_put_contents("cms/public/uploads/docs/doc2_" . $result->id . ".jpg", $decodedDocument2);
            $document2 = 'cms/public/uploads/docs/doc2_'.  $result->id. '.jpg';
        }
        else {
            $document2 = '';
        }

        // doc3
        $driver_document3 = Input::get('document3');
        if ($driver_document3) {
            $decodedDocument3 = base64_decode("$driver_document3");
            file_put_contents("cms/public/uploads/docs/doc3_" . $result->id . ".jpg", $decodedDocument3);
            $document3 = 'cms/public/uploads/docs/doc3_'.  $result->id. '.jpg';
        }
        else {
            $document3 = '';
        }

        // doc4
        $driver_document4 = Input::get('document4');
        if ($driver_document4) {
            $decodedDocument4 = base64_decode("$driver_document4");
            file_put_contents("cms/public/uploads/docs/doc4_" . $result->id . ".jpg", $decodedDocument4);
            $document4 = 'cms/public/uploads/docs/doc4_'.  $result->id. '.jpg';
        }
        else {
            $document4 = '';

        }

        $result2 = Document::create(array(
            'documento1' => $document1,
            'documento2' => $document2,
            'documento3' => $document3,
            'documento4' => $document4,
            'driver_id' => $result->id
        ));

        $query = "Update drivers set picture='cms/public/img/drivers/".$result->id.".jpg' where id='".$result->id."'";
        $result2 = DB::query($query);
        //if(Input::get('car_id')<>0) {
        if ($car_id <> 0) {
            //$query = "Insert into drivers_cars values('".$result->id."','".Input::get('car_id')."');";
            $query = "Insert into drivers_cars values('".$result->id."','". $car_id ."');";

            $result2 = DB::query($query);
        }

        $name = Input::get('name');
        $email = Input::get('login');

        //send_email_confirmation($name, $email);
            //send1();
            // +
        //$msg = "Recibimos su solicitud de registro";
        $msg = "<h1>Solicitud recibida</h1>
        <p>Muchas gracias por su interés en ser parte de la comunidad TaxisYa</p><br>
        <p>Una vez que se valide la información se enviará la confirmación para que puedas ingresar</p><br>
        <br>
        <p>Atentamente,</p><br>
        <p>TaxisYa</p><br>
        ";

        $mailer = IoC::resolve('phpmailer');

        $SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $SMTPAuth = true;  // authentication enabled
        $SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $Host = 'smtp.gmail.com';
        $Port = 465;
        $Username = "taxisya.cms@gmail.com";
        $Password = "t4x1sy42015";
        $entidad = $from = "taxisYa";
        $from_name = "Soporte " . $entidad;

        $mailer->IsSMTP();
        $mailer->SMTPDebug = 1;
        //$mailer->SMTPAuth = true;
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = $SMTPSecure;
        $mailer->Host = $Host;
        $mailer->Port = $Port;
        $mailer->CharSet = 'UTF-8';
        $mailer->Username = $Username;
        $mailer->Password = $Password;
        $mailer->From = $from;
        $mailer->FromName = $from_name;

        try {
            $mailer->AddAddress($email, $name);
            $subject = "taxisYa, solicitud de registro recibida";
            $mailer->Subject = "=?UTF-8?B?".base64_encode($subject)."?=";
            $mailer->Body = $msg;
            $mailer->IsHTML(true);
            $mailer->Send();
        } catch (Exception $e) {
            return Response::json(array('error' => 3, 'msg' => $e->getMessage() ));
        }
        // -
        return Response::json(array('error' => 0,$result));

    }

    public function post_update_register_driver() {
        //$loginData = DB::table('drivers')->where('email','=',Input::get('login'))->or_where('cedula','=',Input::get('cedula'))->first(array('id', 'uuid'));
        $loginData = DB::table('drivers')->where('email','=',Input::get('login'))->first(array('id', 'uuid', 'car_id'));
        //$afiliacion = new DateTime("" . $year . "-" . $month . "-" . $day . "");
        $afiliacion = "0000-00-00 00:00:00";

        $driver_id = $loginData->id;
        $car_id = $loginData->car_id;

        //dd($driver_id);
        // register vehicle
        //dd(Input::all());
        //dd( Input::get('car_tag') );
        $newCar = Car::update($car_id, array(
                        "placa" => Input::get('car_tag'),
                        "car_brand" => Input::get('car_brand'),
                        "model" => Input::get('car_line'),
                        "movil" => Input::get('car_movil'),
                        "year" => Input::get('car_year'),
                        "empresa" => Input::get('car_company'),
                        'city_id' => Input::get('city_id')
        ));
        $driver_name  = Input::get('cedula');

        // prueba -
        $result = Driver::Update($driver_id, array(
                'name' => Input::get('name'),
                'lastname' => Input::get('lastname'),
                'cellphone' => Input::get('cellphone'),
                'email' => Input::get('login'),
                'login' => Input::get('login'),
                'car_id' => $car_id,
                'pwd' => md5(Input::get('pwd')),
                'cedula' => Input::get('cedula'),
                'dir' => Input::get('dir'),
                'telephone' => Input::get('telephone'),
                'license' => Input::get('license'),
                'movil' => Input::get('car_movil'),
                'uuid' => '',
                'city_id' => Input::get('city_id'),
                ));
        // save documents
        // set documents +
        $driver_image = Input::get('image');
        $decodedImage = base64_decode("$driver_image");
        file_put_contents("cms/public/img/drivers/" . $driver_id . ".jpg", $decodedImage);

        // doc1
        $driver_document = Input::get('document');
        if ($driver_document) {
            $decodedDocument = base64_decode("$driver_document");
            file_put_contents("cms/public/uploads/docs/doc1_" . $driver_id . ".jpg", $decodedDocument);
            $document1 = 'cms/public/uploads/docs/doc1_'.  $driver_id. '.jpg';
        }
        else {
            $document1 = '';
        }

        // doc2
        $driver_document2 = Input::get('document2');
        if ($driver_document2) {
            $decodedDocument2 = base64_decode("$driver_document2");
            file_put_contents("cms/public/uploads/docs/doc2_" . $driver_id . ".jpg", $decodedDocument2);
            $document2 = 'cms/public/uploads/docs/doc2_'.  $driver_id. '.jpg';
        }
        else {
            $document2 = '';
        }

        // doc3
        $driver_document3 = Input::get('document3');
        if ($driver_document3) {
            $decodedDocument3 = base64_decode("$driver_document3");
            file_put_contents("cms/public/uploads/docs/doc3_" . $driver_id . ".jpg", $decodedDocument3);
            $document3 = 'cms/public/uploads/docs/doc3_'.  $driver_id. '.jpg';
        }
        else {
            $document3 = '';
        }

        // doc4
        $driver_document4 = Input::get('document4');
        if ($driver_document4) {
            $decodedDocument4 = base64_decode("$driver_document4");
            file_put_contents("cms/public/uploads/docs/doc4_" . $driver_id . ".jpg", $decodedDocument4);
            $document4 = 'cms/public/uploads/docs/doc4_'.  $driver_id. '.jpg';
        }
        else {
            $document4 = '';
        }

/*
        $result2 = Document::update(array(
            'documento1' => $document1,
            'documento2' => $document2,
            'documento3' => $document3,
            'documento4' => $document4,
            'driver_id' => $result->id
        ));
*/



        // $query = "Update drivers set picture='cms/public/img/drivers/".$result->id.".jpg' where id='".$result->id."'";
        // $result2 = DB::query($query);
        // //if(Input::get('car_id')<>0) {
        // if ($newCar->id <> 0) {
        //     $query = "Insert into drivers_cars values('".$result->id."','". $newCar->id ."');";
        //     $result2 = DB::query($query);
        // }

        $name = Input::get('name');
        $email = Input::get('login');

        //send_email_confirmation($name, $email);
            //send1();
            // +
        //$msg = "Recibimos su solicitud de registro";
        $msg = "<h1>Se recibio la la información actualizada</h1>
        <p>Muchas gracias, hemos recibido la información actualizada para el proceso de registro</p><br>
        <p>Una vez se valida la información solicitada, se enviará la confirmación para que puedas ingresar</p><br>
        <br>
        <p>Atentamente,</p><br>
        <p>TaxisYa</p><br>
        ";

        $mailer = IoC::resolve('phpmailer');

        $SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $SMTPAuth = true;  // authentication enabled
        $SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $Host = 'smtp.gmail.com';
        $Port = 465;
        $Username = "taxisya.cms@gmail.com";
        $Password = "t4x1sy42015";
        $entidad = $from = "taxisYa";
        $from_name = "Soporte " . $entidad;

        $mailer->IsSMTP();
        $mailer->SMTPDebug = 1;
        //$mailer->SMTPAuth = true;
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = $SMTPSecure;
        $mailer->Host = $Host;
        $mailer->Port = $Port;
        $mailer->CharSet = 'UTF-8';
        $mailer->Username = $Username;
        $mailer->Password = $Password;
        $mailer->From = $from;
        $mailer->FromName = $from_name;

        try {
            $mailer->AddAddress($email, $name);
            $subject = "taxisYa, actualización de registro recibida";
            $mailer->Subject = "=?UTF-8?B?".base64_encode($subject)."?=";
            $mailer->Body = $msg;
            $mailer->IsHTML(true);
            $mailer->Send();
        } catch (Exception $e) {
            return Response::json(array('error' => 3, 'msg' => $e->getMessage() ));
        }
        // -
        //return Response::json($result);
        return Response::json(array('error' => 0, 'msg' => 'La información se actualizó con éxito' ));

    }

    // register driver -
/*
    public function post_drivers_near($lat,$lng) {

        $query = "SELECT id, login, cellphone, crt_lat, crt_lng, updated_at, (3959 * ACOS( COS( RADIANS(".$lat.") ) * COS( RADIANS( crt_lat ) ) * COS( RADIANS( crt_lng ) - RADIANS(".$lng.") ) + SIN ( RADIANS(".$lat.") ) * SIN( RADIANS( crt_lat ) ) )) AS distance FROM drivers WHERE available = '1' AND (TIMESTAMPDIFF ( MINUTE , `updated_at`, NOW() ) <= 5) HAVING distance <= 2 ORDER BY updated_at,distance;";
        $result = DB::query($query);

        return Response::json($result);

    }
*/

   public function send1() {
       dd("send1");
   }

   public function update_cars($idUser, $idCar){

        try{
            $drivers_cars = DB::table('drivers_cars')->where('drivers_id','=',$idUser)->get();
            if (sizeof($drivers_cars) >= 5){
                $query = "UPDATE drivers_cars set cars_id = ". $idCar ." where drivers_id = ".$idUser." and cars_id = ". $drivers_cars[0]->cars_id .";";
                $result2 = DB::query($query);
            } else {
                $query = "Insert into drivers_cars values('".$idUser."','". $idCar ."');";
                $result2 = DB::query($query);
            }
        } catch(Exception $e){

        }    
        return true;
   }

   public function send_email_confirmation($name,$email) {
        //         $msg = "<h1>Recibimos tu solicitud de registro, una vez verificada la informacion se te enviara la confirmacion</h1>
        // <p>Datos recibidos;a</p><br>
        // <p>Utilice el c&oacute;digo</p><br>
        // <p>al interior de la aplicaci&oacute;n</p><br>
        // <p>Atentamente,</p><br>
        // <p>TaxisYa</p><br>
        // ";

        $msg = "Recibimos su solicitud de registro";

        $mailer = IoC::resolve('phpmailer');

        $SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $SMTPAuth = true;  // authentication enabled
        $SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $Host = 'smtp.gmail.com';
        $Port = 465;
        $Username = "taxisya.cms@gmail.com";
        $Password = "t4x1sy42015";
        $entidad = $from = "taxisYa";
        $from_name = "Soporte " . $entidad;

        $mailer->IsSMTP();
        $mailer->SMTPDebug = 1;
        //$mailer->SMTPAuth = true;
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = $SMTPSecure;
        $mailer->Host = $Host;
        $mailer->Port = $Port;
        $mailer->CharSet = 'UTF-8';
        $mailer->Username = $Username;
        $mailer->Password = $Password;
        $mailer->From = $from;
        $mailer->FromName = $from_name;

        try {
            $mailer->AddAddress($email, $name);
            $subject = "taxisYa, restablecer contraseña";
            $mailer->Subject = "=?UTF-8?B?".base64_encode($subject)."?=";
            $mailer->Body = $msg;
            $mailer->IsHTML(true);
            $mailer->Send();
        } catch (Exception $e) {
            return Response::json(array('error' => 3, 'msg' => $e->getMessage() ));
        }
        $user->pwd_token = $pwd_token;
        $user->save();

   }


    public function post_register() {
        $loginData = DB::table('users')->where_login(Input::get('login'))->first(array('id', 'uuid'));
        if ($loginData) {
            //User::login(Input::get('login'),Input::get('pwd'),Input::get('uuid'))
            User::create(array(
                'name' => Input::get('name'),
                'lastname' => Input::get('lastname'),
                'email' => Input::get('email'),
                'cellphone' => Input::get('cellphone'),
                'login' => Input::get('login'),
                'pwd' => Input::get('pwd'),
                'token' => Input::get('token'),
                'uuid' => Input::get('uuid'),
                'type' => Input::get('type')
            ));
            $id = Driver::login(Input::get('login'), Input::get('pwd'), Input::get('uuid'));
            return Response::eloquent(User::find($id));
        } else {
            return json_encode(array('error' => '1')); //Usuario existente
        }
    }

    public function post_login() {

        $whereDate = date('Y') . "-" . date('m') . "-05";
        $whereDateMin = date('Y') . "-" . date('m') . "-01";


        /* $items = Car::where('pay_date', '<=', DB::RAW("DATE('" . $whereDate . "')"))
          ->where_not_between('pay_date', $whereDateMin, $whereDate)
          ->get(); */

        if (date_create() <= date_create($whereDate)) {
            //dd('aun vigentes');
            $items = Car::where('pay_date', '<=', DB::RAW("DATE('" . date('Y') . "-" . (date('m') - 1) . "-01" . "')"))
                    ->get();
        } else {
            //dd('vencidos');
            $items = Car::where('pay_date', '<=', DB::RAW("DATE('" . $whereDate . "')"))
                    ->where_not_between('pay_date', $whereDateMin, $whereDate)
                    ->get();
        }

        //dd($items->drivers);
        //dd($items);
        $drivers;
        if ($items) {
            foreach ($items as $item) {
                //dd($item->drivers);
                if ($item->drivers) {
                    foreach ($item->drivers as $driver) {
                        $drivers[] = $driver->id;
                    }
                }
            }
        }

        $drivers = (isset($drivers)) ? $drivers : FALSE;
        $id = Driver::login(Input::get('login'), Input::get('pwd'), Input::get('uuid'), FALSE, $drivers);
        //dd($id);
        if ($id['error'] === '0') {
            /* $driverData = Driver::find($id)->to_array();
              return Response::json(array('driver' => $driverData, 'error' => '0')); */
            /* $userData = (User::find($id)->to_array());
              $userData['error'] = '0'; */
            $driverData = Driver::find($id['id'])->to_array();

            //$driverData['error'] = '0';

			$query = "SELECT cars_id FROM drivers_cars WHERE drivers_id =  ".$id['id'].";";
			$cars = DB::query($query);
			$query = "SELECT * FROM cars WHERE id in ('";
			foreach ($cars as $key => $car) {
			$query = $query.$car->cars_id."','";
			}
			$query = $query."0') ";
			$query = $query."and (pay_date > DATE('".date('Y')."-".date('m')."-05') ";
			$query = $query."or pay_date between DATE('".date('Y')."-".date('m')."-01') ";
			$query = $query."and DATE('".date('Y')."-".date('m')."-05'));";
			//echo print_r($query, true);
			$cars_from_driver = DB::query($query);
			if(count($cars_from_driver)==0)
			{
				return json_encode(array('error' => '3'));
			}

            if (!strcmp($driverData['status'],"true")) {
                //dd("esta autorizado");
                $driverData['error'] = '0';
            }
            else {
                //dd("no esta autorizado");
                $driverData['error'] = '5'; // no autorizado
                return json_encode(array('error' => '5'));
            }
			$driverData['cars'] = $cars_from_driver;
            //dd($driverData);
            return Response::json($driverData);

        } else {
            //return json_encode(array('error' => $id['error']));
            return Response::json(array('error' => $id['error']));

        }
        /* if ($id != false && $id != null) {
          $driverData = Driver::find($id)->to_array();
          return Response::json(array('driver' => $driverData, 'error' => '0'));
          } else {
          return json_encode(array('error' => '1'));
          } */
    }

    public function post_logout() {
        return Driver::logOut(Input::get('login'), Input::get('uuid'));
    }

    public function get_edit($id) {
        $cars = Car::all();
        foreach ($cars as $value) {
            $carArray[$value->id] = $value->placa;
        }
        return View::make('driver.edit')
                        ->with('title', 'Edit driver')
                        ->with('cars', $carArray)
                        ->with('driver', Driver::find($id));
    }

    public function put_update() {
        $id = Input::get('id');
        //$validation = Driver::validate(Input::all());
        //        $validation = Driver::validate(Input::get('name'));
        //        $validation1 = Driver::validate(Input::get('lastname'));
        //        $validation2 = Driver::validate(Input::get('email'));
        //        $validation3 = Driver::validate(Input::get('login'));
        //        if ($validation->fails() || $validation1->fails() || $validation2->fails() || $validation3->fails()) {
        //            return Redirect::to_route('edit_driver', $id)->with_errors($validation);
        //        } else {
        Driver::update($id, array(
            'name' => Input::get('name'),
            'lastname' => Input::get('lastname'),
            'cellphone' => Input::get('cellphone'),
            'login' => Input::get('login'),
            'car_id' => Input::get('car_id')
                //,'pwd' => md5(Input::get('pwd'))
        ));
        return Redirect::to_route('driver', $id)->with('message', 'Conductor actualizado');
        //        }
    }

    public function get_locate($id) {
        return View::make('driver.locate')
                        ->with('title', 'Force locate driver')
                        ->with('driver', Driver::find($id));
    }

    public function post_position() {
        $id = Input::get('driver_id');
        $result = Driver::update($id, array(
                    'crt_lat' => Input::get('crt_lat'),
                    'crt_lng' => Input::get('crt_lng')
        ));
        $serviceData = DB::table('services')->where('driver_id', '=', $id)->max('id');
        $tmpService = Service::find($serviceData);
        //return Redirect::to_route('driver', $id)->with('message', 'Conductor actualizado');
        if (Input::has('app_login')) {
            if ($result != NULL) {
                return json_encode(array('error' => '0'));
            } else {
                return json_encode(array('error' => '1'));
            }
        } else {
            if ($result != NULL) {
                return json_encode(array('error' => '0', 'service_state' => $tmpService->status_id));
            } else {
                return json_encode(array('error' => '1', 'service_state' => '0'));
            }
        }
    }

    public function post_available() {
        $id = Input::get('driver_id');
        $result = Driver::update($id, array(
                    'available' => '0'
        ));
        $result = Driver::update($id, array(
                    'available' => '1'
        ));
        if ($result != NULL) {
            return json_encode(array('error' => '0'));
        } else {
            return json_encode(array('error' => '1'));
        }
    }

    public function post_unavailable() {
        $id = Input::get('driver_id');
        $result = Driver::update($id, array(
                    'available' => '1'
        ));
        $result = Driver::update($id, array(
                    'available' => '0'
        ));
        if ($result != NULL) {
            return json_encode(array('error' => '0'));
        } else {
            return json_encode(array('error' => '1'));
        }
    }

    public function post_services() {
        $objService = new Service();
        if (Input::has('no_limit')) {
            $limit = false;
        } else {
            $limit = true;
        }
        //$limit = false;
        $nearByServices = $objService->getNearServices(Input::get('crt_lat'), Input::get('crt_lng'), $limit);
        $id = Input::get('driver_id');
        $result = Driver::update($id, array(
                    'crt_lat' => Input::get('crt_lat'),
                    'crt_lng' => Input::get('crt_lng')
        ));
        if ($nearByServices == NULL) {
            $defNearByServices = Array('error' => '1');
        } else {
            foreach ($nearByServices as $key => $value) {
                $defNearByServices[$key] = $value->to_array();
                $defNearByServices[$key]['userName'] = $value->user->name;
                $defNearByServices[$key]['lastName'] = $value->user->lastname;
                $defNearByServices[$key]['error'] = '0';
            }
        }
        return Response::json(array('services' => $defNearByServices));
    }

	public function post_updatecar(){
		$id = Input::get('driver_id');
		$car_id = Input::get('car_id');
		Driver::update($id, array(
            'car_id' => Input::get('car_id'),
        ));
        //return json_encode(array('error' => '0'));
        return Response::json(array('error' => '0'));

	}

	public function post_sendwarning(){
		$msg = "Hoy es el ?ltimo plazo para el vencimiento del pago de la afilicaci?, cancele lo antes posible. Si ya lo realiz?haga caso omiso de este mensaje";
		$result = Notifier::massive($msg,false);
		return $result;
	}

	public function post_islogued(){
		$data = Input::json();
		$login = $data->login;
		$uuid =  $data->uuid;
		$loginData = DB::table('drivers')->where_email(trim($login))->first(array('id', 'uuid'));
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
}

?>
