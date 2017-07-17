<?php

class Document_Controller extends Base_Controller {

  public $restful = true;

    public function post_create() {
        if (true {

            $result = Document::create(array(
                'name' => Input::get('name'),
                'image' => Input::get('image'),
                'cellphone' => Input::get('cellphone'),
                'email' => Input::get('email'),
                'login' => Input::get('email'),
                'car_id' => Input::get('car_id'),
                'pwd' => md5(Input::get('pwd')),
                'cedula' => Input::get('cedula'),
                'dir' => Input::get('dir'),
                'telephone' => Input::get('telephone'),
                        //'join_date' => $afiliacion,
                'license' => Input::get('license'),
                'movil' => Input::get('movil'),
                'uuid' => Input::get('uuid')
                ));
            $query = "Update drivers set picture='cms/public/img/drivers/".$result->id.".jpg' where id='".$result->id."'";
            $result2 = DB::query($query);
            if(Input::get('car_id')<>0)
            {
                $query = "Insert into drivers_cars values('".$result->id."','".Input::get('car_id')."');";
                $result2 = DB::query($query);
                //echo print_r($query,true);
            }
            if(Input::get('car_id2')<>0)
            {
                $query = "Insert into drivers_cars values('".$result->id."','".Input::get('car_id2')."');";
                $result2 = DB::query($query);
                //echo print_r($query,true);
            }
            if(Input::get('car_id3')<>0)
            {
                $query = "Insert into drivers_cars values('".$result->id."','".Input::get('car_id3')."');";
                $result2 = DB::query($query);
                //echo print_r($query,true);
            }
            if(Input::get('car_id4')<>0)
            {
                $query = "Insert into drivers_cars values('".$result->id."','".Input::get('car_id4')."');";
                $result2 = DB::query($query);
                //echo print_r($query,true);
            }
            if(Input::get('car_id5')<>0)
            {
                $query = "Insert into drivers_cars values('".$result->id."','".Input::get('car_id5')."');";
                $result2 = DB::query($query);
                //echo print_r($query,true);
            }


            $msg = "<h1>Bienvenid@ a la comunidad taxisya</h1>
            <p>Para ingresar a la aplicación:</p><br>
            <p>Utilice el correo: " . Input::get('email') . "</p><br>
            <p>Su contraseña es:" . Input::get('pwd') . "</p><br>
            <p>Atentamente,</p><br>
            <p>TaxisYa</p><br>
            ";

            $mailer = IoC::resolve('phpmailer');

            $SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
            $SMTPAuth = true;  // authentication enabled
            $SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
            $Host = 'smtp.gmail.com';
            $Port = 465;
            $Username = "taxisya.soporte@gmail.com";
            $Password = "Airedale1019.";
            $entidad = $from = "taxisYa";
            $from_name = "Soporte " . $entidad;

            $mailer->IsSMTP();
            $mailer->SMTPDebug = 1;
            $mailer->SMTPAuth = true;
            $mailer->SMTPSecure = $SMTPSecure;
            $mailer->Host = $Host;
            $mailer->Port = $Port;

            $mailer->Username = $Username;
            $mailer->Password = $Password;

            $mailer->From = $from;
            $mailer->FromName = $from_name;

            try {
                $mailer->AddAddress(Input::get('email'), Input::get('name'));
                $mailer->Subject = "Bienvenid@ a taxisYa";
                $mailer->Body = $msg;
                $mailer->IsHTML(true);
                $mailer->Send();
            } catch (Exception $e) {
                echo 'Message was not sent.';
                echo 'Mailer error: ' . $e->getMessage();
            }
          } else {
            //return Redirect::to_route('driver/new')->with('message', 'Conductor ' . input::get('name') . ' creado!');
            $avaiables = DB::table('drivers')->where('available','=','1')->count();
            $notavaiables = DB::table('drivers')->where('available','=','0')->count();
             return View::make('driver.index')//Post CREATE
              ->with('title', 'Conductores')
              ->with('message', 'Conductor ' . Input::get('name') . ' ' . Input::get('lastname') . 'EL USUARIO NO HA SIDO CREADO PORQUE YA EXISTE EN EL SISTEMA')
              ->with('result', '0')
              ->with('titles', $titleArray)
              ->with('avaiables',$avaiables)
              ->with('notavaiables',$notavaiables)
              ->with('items', Driver::all());
          }
        $id = $result->id;
        $cars = Car::all();
        //dd($cars);
        $carArray[0] = 'Seleccione un vehiculo existente';
        foreach ($cars as $value) {
            $carArray[$value->id] = $value->placa . "," . $value->car_brand;
        }
        return View::make('driver.edit')
        ->with('car_id2',Input::get('car_id2'))
        ->with('car_id3',Input::get('car_id3'))
        ->with('car_id4',Input::get('car_id4'))
        ->with('car_id5',Input::get('car_id5'))
        ->with('title', 'Conductor')
        ->with('cars', $carArray)
        ->with('item', Driver::find($id));
    }

}

?>

