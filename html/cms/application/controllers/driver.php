<?php

class Driver_Controller extends Base_Controller {

    public $restful = true;

    public function post_expired() {
        $drivers = Driver::where(DB::RAW('TIMESTAMPDIFF(DAY,join_Date,NOW())'), '>=', '25')->get();
        $titleArray = array(
            "Carro" => array("car", "placa"),
            "Celular" => "cellphone",
            "Nombre" => "name",
            "Apellido" => "lastname",
            "E-mail" => "email",
            "Móvil" => "movil",
            "Fecha de afiliciación" => "join_date"
        );
        $section = 'driver';
        $manageBtns = array(
            'add' => FALSE,
            'edit' => FALSE,
            'del' => FALSE
        );
        return View::make($section . '.expired')
        ->with('title', 'Conductores con afiliaciones vencidas')
        ->with('titles', $titleArray)
        ->with('section', $section)
        ->with('manageBtns', $manageBtns)
        ->with('items', $drivers);
    }

    public function post_index() {
        $pieces = explode("_", get_class($this));
        //dd($pieces);
        exit();
        $objName = $pieces[0];
        $section = strtolower($pieces[0]);
        $titleArray = array(
            "Disponible" => "available",
            "Cel." => "cellphone",
			"comb_Nombre" => "name.lastname",
            "e-mail" => "email",
            "Registrado" => "created_at",
            "Modificado" => "updated_at",
        );
        $manageBtns = array(
            'add' => TRUE,
            'edit' => TRUE,
            'del' => TRUE,
            //'export' => TRUE,
            'total' => TRUE,
            'custom' => array(
                array("Reiniciar conductor",
                    "reset",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea reiniciar la cuenta del conductor?\")){dataPoster(id);}})(this.id)",
                    "0"),
            ),
        );
//        $items = Driver::all();
        //$items = DB::table('drivers')->paginate('50',array('id','available','cellphone','name','lastname','email','created_at','updated_at'));
        //echo print_r($items,true);
        //$items = DB::table('drivers')->get(array('id','available','cellphone','name','lastname','email','created_at','updated_at'));

        $avaiables = DB::table('drivers')->where('available','=','1')->count();
//        $avaiables = DB::table('drivers')->where('available','=','1')->where('cms_user_id','=','43')->count();
        $notavaiables = DB::table('drivers')->where('available','=','0')->count();
        //echo print_r($items,true);
        $result = $objName::order_by('updated_at', 'DESC')->paginate(50);
        //$result = $objName::order_by('updated_at', 'DESC')->get();
        return View::make('driver.index')
            ->with('title', 'Conductores actuales: ')
            ->with('titles', $titleArray)
            ->with('result', '0')
            ->with('manageBtns', $manageBtns)
            ->with('section', $section)
            ->with('avaiables',$avaiables)
            ->with('notavaiables',$notavaiables)
            //->with('items', $items);
            //->with('items', $objName::order_by('updated_at', 'DESC')->get());
            //->with('items', $objName::order_by('updated_at', 'DESC')->get());
            ->with('items', $result );
            //->with('items', $objName::order_by('updated_at', 'ASC')->get());

    }

    public function post_reset() {
        $driver_id = Input::get('id');
        DB::table('drivers')->where('id', '=', $driver_id)->update(array('uuid' => '', 'available' => '0'));
        $pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        $section = strtolower($pieces[0]);
        $titleArray = array(
            "Carro" => array("car", "placa"),
            "Cel." => "cellphone",
            "comb_Nombre" => "name.lastname",
            "e-mail" => "email",
            "Móvil" => "movil",
            "Registrado" => "created_at",
            "Modificado" => "updated_at",
        );
        $manageBtns = array(
            'add' => TRUE,
            'edit' => TRUE,
            'del' => TRUE,
            'total' => TRUE,
            'custom' => array(
                array("Reiniciar conductor",
                    "reset",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea reiniciar la cuenta del conductor?\")){dataPoster(id);}})(this.id)",
                    "1"),
                ),
            'tabs' => array("options" => array(
                array("id" => "1",
                    "description" => "Disponible"
                    ),
                array(
                    "id" => "0",
                    "description" => "No disponibles"
                    )
                ),
            "tabber" => "available"
            )
        );
        $items = $objName::all();
        $avaiables = DB::table('drivers')->where('available','=','1')->count();

        $notavaiables = DB::table('drivers')->where('available','=','0')->count();
        return View::make('driver.index')
            ->with('title', 'Conductores actuales: ')
            ->with('titles', $titleArray)
            ->with('message', 'Conductor actualizado')
            ->with('result', '1')
            ->with('manageBtns', $manageBtns)
            ->with('section', $section)
            ->with('avaiables',$avaiables)
            ->with('notavaiables',$notavaiables)
            ->with('items', $items);
    }

	public function post_edit() {

        //dd(Input::all());

        $id = Input::get('id');
        $cars = Car::all();
        $carArray[0] = 'Seleccione un vehiculo existente';
        foreach ($cars as $value) {
            $carArray[$value->id] = $value->placa . "," . $value->car_brand;
		}
		$query = "Select cars_id from drivers_cars where drivers_id = '".$id."' limit 5;";
		$drivercars = DB::query($query);
		$count = 1;
		$car_id = array(1=>0,2=>0,3=>0,4=>0,5=>0);
		foreach ($drivercars as $drivercar) {
            $car_id[$count] = $drivercar->cars_id;
            $count = $count+1;
		}
        $statusArray['true'] = 'Activo';
        $statusArray['false'] = 'Desactivo';
        $statusArray['rechazado'] = 'Rechazado';
        $statusArray['nuevo'] = 'Nuevo';

        return View::make('driver.edit')
            ->with('car_id1',$car_id[1])
            ->with('car_id2',$car_id[2])
            ->with('car_id3',$car_id[3])
            ->with('car_id4',$car_id[4])
            ->with('car_id5',$car_id[5])
            ->with('title', 'Conductor')
            ->with('cars', $carArray)
            ->with('status',$statusArray)
            ->with('item', Driver::find($id));
    }

    public function post_new() {
        $cars = Car::all();
        $carArray[0] = 'Seleccione un vehículo existente';
        foreach ($cars as $value) {
            $carArray[$value->id] = $value->placa . "," . $value->car_brand;
        }
        return View::make('driver.new')
        ->with('cars', $carArray)
        ->with('title', 'Nuevo Conductor');
    }

    public function post_update() {
        $id = Input::get('id');

        //dd(Input::all());
        //exit();

        $statusArray['true'] = 'Activo';
        $statusArray['false'] = 'Desactivo';
        $statusArray['rechazado'] = 'Rechazado';
        $statusArray['nuevo'] = 'Nuevo';

        Input::upload('picture', 'img/drivers', $id . '.png');
        //$afiliacion = new DateTime(Input::get('join_date'));
		$query = "delete from drivers_cars where drivers_id='".$id."';";
		$result = DB::query($query);

		if(Input::get('car_id')<>0) {
			$query = "Insert into drivers_cars values('".$id."','".Input::get('car_id')."');";
			$result2 = DB::query($query);
		}
		if(Input::get('car_id2')<>0) {
			$query = "Insert into drivers_cars values('".$id."','".Input::get('car_id2')."');";
			$result2 = DB::query($query);
		}
		if(Input::get('car_id3')<>0) {
			$query = "Insert into drivers_cars values('".$id."','".Input::get('car_id3')."');";
			$result2 = DB::query($query);
		}
		if(Input::get('car_id4')<>0) {
			$query = "Insert into drivers_cars values('".$id."','".Input::get('car_id4')."');";
			$result2 = DB::query($query);
		}
		if(Input::get('car_id5')<>0) {
			$query = "Insert into drivers_cars values('".$id."','".Input::get('car_id5')."');";
			$result2 = DB::query($query);
		}

        $toUpdate = array(
            'name' => Input::get('name'),
            'lastname' => Input::get('lastname'),
            'cellphone' => Input::get('cellphone'),
            'login' => Input::get('email'),
            'email' => Input::get('email'),
            'car_id' => Input::get('car_id'),
            'license' => Input::get('license'),
            //'movil' => Input::get('movil'),
            'cedula' => Input::get('cedula'),
            'dir' => Input::get('dir'),
            'telephone' => Input::get('telephone'),
            'status' => Input::get('status'),

            //'join_date' => $afiliacion,
            //'uuid' => Input::get('uuid')
            );
        if (Input::has('pwd')) {
            $tmpPwd = Input::get('pwd');
        }
        if (isset($tmpPwd)) {
            $toUpdate['pwd'] = md5(Input::get('pwd'));
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
            //$Username = "taxisya.soporte@gmail.com";
            //$Password = "Airedale1019.";
            $Username = "taxisya.cms@gmail.com";
            $Password = "t4x1sy42015";
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

            // try {
            //     //dd('try');
            //     $mailer->AddAddress(Input::get('email'), Input::get('name'));
            //     //$mailer->Subject = "Bienvenid@ a taxisYa";
            //     $subject = "Bienvenid@ a taxisYa";
            //     $mailer->Subject = "=?UTF-8?B?".base64_encode($subject)."?=";

            //     $mailer->Body = $msg;
            //     $mailer->IsHTML(true);
            //     $mailer->Send();
            // } catch (Exception $e) {
            //     dd('catch');
            //     echo 'Message was not sent.';
            //     echo 'Mailer error: ' . $e->getMessage();
            // }

        }
        //dd($toUpdate);
        //exit();

        Driver::update($id, $toUpdate);

        $cars = Car::all();
        //dd($cars);
        $carArray[0] = 'Seleccione un vehiculo existente';
        foreach ($cars as $value) {
            $carArray[$value->id] = $value->car_brand . "," . $value->placa;
        }
        return View::make('driver.edit')
		->with('car_id2',Input::get('car_id2'))
		->with('car_id3',Input::get('car_id3'))
		->with('car_id4',Input::get('car_id4'))
		->with('car_id5',Input::get('car_id5'))
        ->with('title', 'Conductor')
        ->with('cars', $carArray)
        ->with('result', 'Guardado')
        ->with('status',$statusArray)
        ->with('item', Driver::find($id));


         /*
         // new +
        $pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        $section = strtolower($pieces[0]);
        $titleArray = array(
            "Disponible" => "available",
            "Cel." => "cellphone",
            "comb_Nombre" => "name.lastname",
            "e-mail" => "email",
            "Registrado" => "created_at",
            "Modificado" => "updated_at",
        );
        $manageBtns = array(
            'add' => TRUE,
            'edit' => TRUE,
            'del' => TRUE,
            //'export' => TRUE,
            'total' => TRUE,
            'custom' => array(
                array("Reiniciar conductor",
                    "reset",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea reiniciar la cuenta del conductor?\")){dataPoster(id);}})(this.id)",
                    "0"),
            ),
        );

        $avaiables = DB::table('drivers')->where('available','=','1')->count();
        $notavaiables = DB::table('drivers')->where('available','=','0')->count();
        $result = $objName::order_by('updated_at', 'DESC')->paginate(50);
        return View::make('driver.index')
            ->with('title', 'Conductores actuales: ')
            ->with('titles', $titleArray)
            ->with('result', '0')
            ->with('manageBtns', $manageBtns)
            ->with('section', $section)
            ->with('avaiables',$avaiables)
            ->with('notavaiables',$notavaiables)
            ->with('items', $result );
        // new -
        */

    }

    public function post_create() {
        
        $statusArray['true'] = 'Activo';
        $statusArray['false'] = 'Desactivo';
        $statusArray['rechazado'] = 'Rechazado';
        $statusArray['nuevo'] = 'Nuevo';

        $loginData = DB::table('drivers')->where('email','=',Input::get('email'))->or_where('cedula','=',Input::get('cedula'))->first(array('id', 'uuid'));
		$titleArray = array(
            "Carro" => array("car", "placa"),
            "Cel." => "cellphone",
            "Nombre" => "name",
            "Apellido" => "lastname",
            "e-mail" => "email",
            "Registrado" => "created_at",
            "Modificado" => "updated_at",
            "Disponible" => "available",
            "Estado cuenta" => "account_status"
            );
        if (!isset($loginData)) {
             $city = DB::table('cities_customers')->where('customer_id','=',Auth::user()->customer_id)->first();
            $result = Driver::create(array(
                'name' => Input::get('name'),
                'lastname' => Input::get('lastname'),
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
                'uuid' => Input::get('uuid'),
                'status' => 'true',
                'city_id' => $city->city_id,
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
            $Username = "taxisya.cms@gmail.com";
            $Password = "t4x1sy42015";
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
            //return Redirect::to_route('driver/new')->with('message', 'Conductor ' . input::get('name') . ' creado!');
            /* return View::make('driver.index')
              ->with('title', 'Conductores')
              ->with('message', 'Conductor ' . Input::get('name') . ' ' . Input::get('lastname') . ' creado!')
              ->with('result', '1')
              ->with('titles', $titleArray)
              ->with('items', Driver::all()); */
          } else {
            
            $waiting_drivers = Driver::get();
            $avaiables = DB::table('drivers')->where('available','=','1')->count();
            $notavaiables = DB::table('drivers')->where('available','=','0')->count();
            $total1 = $avaiables + $notavaiables;
            return View::make('v2.drivers', compact('waiting_drivers'))
            ->with('total1',$total1)
            ->with('avaiables',$avaiables)
            ->with('message', 'Conductor ' . Input::get('name') . ' ' . Input::get('lastname') . 'EL USUARIO NO HA SIDO CREADO PORQUE YA EXISTE EN EL SISTEMA')
              ->with('result', '0')
            ->with('notavaiables',$notavaiables);


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
        ->with('status', $statusArray )
		->with('item', Driver::find($id));
    }

     public function post_del() {
                        $id = Input::get('id');
                        $data = Driver::find($id);
                        
			try{
				$query = "delete from drivers_cars where drivers_id='".$id."'";
				DB::query($query);
                $query = "delete from cms_documents where driver_id='".$id."'";
                DB::query($query);
				$data->delete();
				$msg = 'Registro ' . ' eliminado!';
                            	$type = '1';
			}catch(Exception $e){
                dd($e);
                exit();
				$msg = 'Error al eliminar registro!';
                            	$type = '0';
			}
/*
		$waiting_drivers = Driver::get();

        //dd($waiting_drivers);
        $avaiables = DB::table('drivers')->where('available','=','1')->count();
        $notavaiables = DB::table('drivers')->where('available','=','0')->count();
        $total1 = $avaiables + $notavaiables;

         // mirar para filtor\
        //$cms_user_id = Auth::user()->id;
        //dd($cms_user_id);


//        $waiting_drivers = Driver::where('cms_user_id','=','42')->get();
//        $waiting_drivers = Driver::where('cms_user_id','=',$cms_user_id)->get();
//        $avaiables = DB::table('drivers')->where('available','=','1')->where('cms_user_id','=','42')->count();
//        $notavaiables = DB::table('drivers')->where('available','=','0')->where('cms_user_id','=','42')->count();

        //return View::make('v2.drivers', compact('waiting_drivers'));
        return View::make('v2.drivers', compact('waiting_drivers'))
        ->with('total1',$total1)
        ->with('avaiables',$avaiables)
        ->with('notavaiables',$notavaiables);*/

        //Redirect::route('drivers');
        //Redirect::action('ServicesV2@get_driver');
        
        return "";
    }

    public function post_wcuploader() {
        $id = Input::get('id');
        //dd($id);
        //$id = Input::get('id');
        //$filename = "img/drivers/" . date('YmdHis') . '.jpg';
        /* $filename = "img/drivers/" . $id . '.jpg';
          //dd($_REQUEST);
        Input::upload('picture', 'img/drivers', $id . '.jpg'); */
        //$result = file_put_contents($filename, file_get_contents('php://input'));
        Driver::update($id, array('picture' => "cms/public/img/drivers/$id.jpg"));
        $cars = Car::all();
        //dd($cars);
        $carArray[0] = 'Seleccione un vehiculo existente';
        foreach ($cars as $value) {
            $carArray[$value->id] = $value->car_brand . "," . $value->placa;
        }
        return View::make('driver.edit')
        ->with('title', 'Conductor')
        ->with('cars', $carArray)
        ->with('result', 'Guardado')
        ->with('item', Driver::find($id));
    }

	public function post_sendwarning(){
		$msg = "Hoy es el último plazo para el vencimiento del pago de la afilicación, cancele lo antes posible. Si ya lo realizó haga caso omiso de este mensaje";
		$result = Notifier::massive($msg,false);
		return $result;
	}
	public function post_actualizarImagen(){
		$pathImg = $_POST['pathImg'];

		$respuesta = '{"exito":1}';
	      
		$filename = dirname(__FILE__).'/../../'.$pathImg;

		//file_put_contents($filename, $_FILES['file-0']);}
		try {
		    move_uploaded_file($_FILES['file-0']['tmp_name'], $filename);
		} catch(Exception $e){
		    $respuesta = '{"exito":0}';      
		}

		//dd(print_r($_FILES['file-0'],true).' uuu '.$pathImg);

		return $respuesta;

    	}
}
