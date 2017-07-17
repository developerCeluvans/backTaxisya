<?php

class Service_Controller extends Base_Controller {

    public $restful = true;

    public function post_index() {
        $pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        $section = strtolower($pieces[0]); //'section';
        //return View::make('service.index');
        $titleArray = array("NO" => "id",
            //"Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
            "Nomb. Usuario" => "user_name",
			//"Apell. Usuario" => array("user", "lastname"),
            "Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
            "Vehiculo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
            //"latitud" => "from_lat",
            //"longitud" => "from_lng",
            //"Estado" => "status_id",
            "Estado" => array("state", "descrip"),
            "Solicitud" => "created_at",
            "Finalización" => "updated_at",
            "Calificacion" => array("score", "descrip"), //"qualification",
            "comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs"
            //"comb_Dirección" =>  "address.index_id.comp1.comp2.no.barrio.obs"
                /* "Prefijo" => "index_id",
                  "Num1" => "comp1",
                  "Num2" => "comp2",
                  "No." => "no",
                  "Barrio" => "barrio",
                  "Obs." => "obs" */
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => FALSE,
            'del' => FALSE,
            //'export' => TRUE,
            'total' => TRUE,
            'custom' => array(
                array("Cancelar servicio",
                    "cancel",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea cancelar este servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
            'tabs' => array("options" => array(
                    array("id" => "1",
                        "description" => "Pendiente"
                    ),
                    array(
                        "id" => "2",
                        "description" => "Asignado"
                    ),
                    array(
                        "id" => "5",
                        "description" => "Finalizados"
                    ),
                    /*array(
                        "id" => "6",
                        "description" => "Cancelados"
                    ),*/
                    array(
                        "id" => "7",
                        "description" => "Cancelado por sistema"
                    ),
                    array(
                        "id" => "8",
                        "description" => "Cancelado por conductor"
                    ),
                    array(
                        "id" => "9",
                        "description" => "Cancelado por operadora"
                    )
                ),
                "tabber" => "status_id"
            )
        );
        return View::make('cms.index')
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
                        ->with('items', $objName::order_by('updated_at', 'DESC')->get());
        /* return View::make('service.index')
          ->with('title', 'Servicios actuales')
          ->with('titles', $titleArray)
          ->with('items', Service::order_by('updated_at', 'DESC')
          ->get()); */
        /*
          with('state')
          ->with('complains')
          ->with('user')

         */
        //        $view = View::make('service.index', array('name' => 'John'))->with('age', '28');
        //        $view->location = 'California'; //dont work
        //        $view['specialty'] = 'PHP'; //dont work
        //        return Response::json($usuario->to_array());
    }

    public function post_cancel() {
        //dd(Input::all());
        $id = Input::get('id');
        //Si hay conductor, notificar
        Service::update($id, array(
            'status_id' => '6'
                //,'pwd' => md5(Input::get('pwd'))
        ));
        $actService = Service::find($id);
        if (isset($actService->driver_id)) {
            $push = Push::make();
            $msg = "El servicio ha sido cancelado";
            $push->android($actService->driver->uuid, $msg);
        }

        //Notificar a usuario!!
        $pushMessage = 'En el momento no hay taxis disponibles intente más tarde';

        $servicio = Service::find($id);
        $push = Push::make();
        if ($servicio->user->type == '1') {//iPhone
            $preventEcho = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav');
        } else {
            $preventEcho = $push->android2($servicio->user->uuid, $pushMessage);
        }
        $pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        $section = strtolower($pieces[0]); //'section';
        //return View::make('service.index');
        $titleArray = array("NO" => "id",
            "Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
            //"Apell. Usuario" => array("user", "lastname"),
            "Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
            "Vehiculo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
            //"latitud" => "from_lat",
            //"longitud" => "from_lng",
            //"Estado" => "status_id",
            "Estado" => array("state", "descrip"),
            "Solicitud" => "created_at",
            "Finalización" => "updated_at",
            "Calificacion" => array("score", "descrip"), //"qualification",
            "comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs"
                /* "Prefijo" => "index_id",
                  "Num1" => "comp1",
                  "Num2" => "comp2",
                  "No." => "no",
                  "Barrio" => "barrio",
                  "Obs." => "obs" */
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => FALSE,
            'del' => FALSE,
            //'export' => TRUE,
            'total' => TRUE,
            'custom' => array(
                array("Cancelar servicio",
                    "cancel",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea cancelar este servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
            'tabs' => array("options" => array(
                    array("id" => "1",
                        "description" => "Pendiente"
                    ),
                    array(
                        "id" => "2",
                        "description" => "Asignado"
                    ),
                    array(
                        "id" => "5",
                        "description" => "Finalizados"
                    ),
                    /*array(
                        "id" => "6",
                        "description" => "Cancelados"
                    ),*/
                    array(
                        "id" => "7",
                        "description" => "Cancelado por sistema"
                    ),
                    array(
                        "id" => "8",
                        "description" => "Cancelado por conductor"
                    ),
                    array(
                        "id" => "9",
                        "description" => "Cancelado por operadora"
                    )
                ),
                "tabber" => "status_id"
            )
        );
        return View::make('cms.index')
                        ->with('title', 'Agendamientos: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
                        ->with('items', $objName::order_by('updated_at', 'DESC')->get());
    }

	public function post_requested(){
		
        $pieces = explode("_", get_class($this));
        $section = strtolower($pieces[0]);
        $titleArray = array(
			"Código Servicio" => "id",
            //"Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
			"Nomb. Usuario" => "user_name",
			"Comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs",
//            "comb_Dirección" => "address.index_id.comp1.comp2.no.barrio.obs",
			//"Teléfono" => array("user", "cellphone"),
			"Teléfono" => array("user", "telephone"),
			"Estado" => array("state", "descrip"),
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE,
            'total' => TRUE,
            'custom' => array(
                array("Cancelar servicio",
                    "cancel2",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea cancelar este servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
        );
		$Usercms = DB::table('cms_users')->where('email', '=', Auth::user()->email)->first('id');
		$day = date('d');
		$month = date('n');
		$year = date('Y');
		$Servicios = Service::where('cms_users_id','=',$Usercms->id)
					->where('status_id','<>','7')
					->where(DB::RAW('MONTH(updated_at)'), '=', $month)
					->where(DB::RAW('YEAR(updated_at)'), '=', $year)
					->where(DB::RAW('DAY(updated_at)'),'>=',$day-1)
					->order_by('id', 'DESC')->get();
		$Itemsdir = DB::table('dir_indexes')->get();
        return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios);
	}

	public function post_search(){
		$phone = Input::get('phone');
		$pieces = explode("_", get_class($this));
        $section = strtolower($pieces[0]);
        $titleArray = array(
			"Código Servicio" => "id",
            //"Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
			"Nomb. Usuario" => "user_name",
			"comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs",
//            "comb_Dirección" => "address.index_id.comp1.comp2.no.barrio.obs",
			//"Teléfono" => array("user", "cellphone"),
			"Teléfono" => array("user", "telephone"),
			"Estado" => array("state", "descrip"),
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE,
            'total' => TRUE,
            'custom' => array(
                array("Cancelar servicio",
                    "cancel2",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea cancelar este servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
        );
		$Usercms = DB::table('cms_users')->where('email', '=', Auth::user()->email)->first('id');
		$day = date('d');
		$month = date('n');
		$year = date('Y');
		$Servicios = Service::where('cms_users_id','=',$Usercms->id)
					->where('status_id','<>','9')
					->where(DB::RAW('MONTH(updated_at)'), '=', $month)
					->where(DB::RAW('YEAR(updated_at)'), '=', $year)
					->where(DB::RAW('DAY(updated_at)'),'>=',$day-1)
					->order_by('id', 'DESC')->get();

		$Itemsdir = DB::table('dir_indexes')->get();
		$usersearch = DB::table('users')->where('telephone','=',$phone)->first();
		//echo print_r($usersearch,true);
		if($usersearch)
		{
			$address = DB::table('users_dirs')->where('user_id','=',$usersearch->id)->get();
			return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('adresses',$address)
						->with('phone',$phone)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios)
						->with('user',$usersearch);
		}else{
			return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('phone',$phone)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios)
						->with('user',$usersearch);
		}

	}

	public function post_add(){
		$phone = Input::get('phone');
		$name = Input::get('name');
		$pieces = explode("_", get_class($this));
        $section = strtolower($pieces[0]);
        $titleArray = array(
			"Código Servicio" => "id",
            //"Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
			"Nomb. Usuario" => "user_name",
			"comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs",
//            "comb_Dirección" => "address.index_id.comp1.comp2.no.barrio.obs",
			//"Teléfono" => array("user", "cellphone"),
			"Teléfono" => array("user", "telephone"),
			"Estado" => array("state", "descrip"),
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE,
            'total' => TRUE,
            'custom' => array(
                array("Cancelar servicio",
                    "cancel2",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea cancelar este servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
        );
		$Usercms = DB::table('cms_users')->where('email', '=', Auth::user()->email)->first('id');
		$day = date('d');
		$month = date('n');
		$year = date('Y');
		$Servicios = Service::where('cms_users_id','=',$Usercms->id)
					->where('status_id','<>','9')
					->where(DB::RAW('MONTH(updated_at)'), '=', $month)
					->where(DB::RAW('YEAR(updated_at)'), '=', $year)
					->where(DB::RAW('DAY(updated_at)'),'>=',$day-1)
					->order_by('id', 'DESC')->get();
		$Itemsdir = DB::table('dir_indexes')->get();
		//$usersearch = DB::table('users')->where('cellphone','=',$phone)->or_where('telephone','=',$phone)->first();

		$usersearch = User::create(array(
					'name' => $name,
                    'telephone' => $phone,
        ));
		//echo print_r($usersearch,true);
		if($usersearch)
		{
			$address = DB::table('users_dirs')->where('user_id','=',$usersearch->id)->get();
			return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('adresses',$address)
						->with('phone',$phone)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios)
						->with('user',$usersearch);
		}else{
			return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('phone',$phone)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios)
						->with('user',$usersearch);
		}

	}

	public function post_filladdress(){
		$phone = Input::get('phone');
		$addresid = Input::get('adressid');
		//echo print_r($addresid,true);
		//echo print_r("fasdasd");
		$pieces = explode("_", get_class($this));
        $section = strtolower($pieces[0]);
        $titleArray = array(
			"Código Servicio" => "id",
            //"Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
			"Nomb. Usuario" => "user_name",
			"comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs",
//            "comb_Dirección" => "address.index_id.comp1.comp2.no.barrio.obs",
			//"Teléfono" => array("user", "cellphone"),
			"Teléfono" => array("user", "telephone"),
			"Estado" => array("state", "descrip"),
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE,
            'total' => TRUE,
            'custom' => array(
                array("Cancelar servicio",
                    "cancel2",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea cancelar este servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
        );
		$Usercms = DB::table('cms_users')->where('email', '=', Auth::user()->email)->first('id');
		$day = date('d');
		$month = date('n');
		$year = date('Y');
		$Servicios = Service::where('cms_users_id','=',$Usercms->id)
					->where('status_id','<>','5')
					->where(DB::RAW('MONTH(updated_at)'), '=', $month)
					->where(DB::RAW('YEAR(updated_at)'), '=', $year)
					->where(DB::RAW('DAY(updated_at)'),'>=',$day-1)
					->order_by('id', 'DESC')->get();
		$Itemsdir = DB::table('dir_indexes')->get();
		$usersearch = DB::table('users')->where('cellphone','=',$phone)->or_where('telephone','=',$phone)->first();


		$selectaddress = DB::table('users_dirs')->where('id','=',$addresid)->first();


		//echo print_r($selectaddress,true);
		if($selectaddress)
		{
			return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('phone',$phone)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios)
						->with('selectaddress',$selectaddress)
						->with('user',$usersearch);
		}else{
			return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('phone',$phone)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios)
						->with('user',$usersearch);
		}
		}

	 public function post_request() {
        
        $id = Input::get('user_id');
        $lat = Input::get('crt_lat');
        $lng = Input::get('crt_lng');
		$idopr = Auth::user()->id;
		//echo print_r(Input::get('name'));
        //dd('Hey!');
        //crear el servicio en la base de datos y regresar el id del servicio
        //Se puede desde el usuario con la relacion de hasmany
        $index_id = Input::get('index_id');
        $comp1 =  Input::get('comp1');
        $comp2 = Input::get('comp2');
        $no = Input::get('no');

        // remove spaces in $comp1
        $comp1 = str_replace(' ', '', $comp1);

/*
        $index_id=trim($index_id);
        $comp1=trim($comp1);
        $comp2=trim($comp2);
        $no=trim($no);
*/

/*
        $index_id = "Calle";
        $comp1 = "72A";
        $comp2 = "30";
        $no = "53";
        // obtiene la coordenada
        $address = $index_id . "%20" . $comp1 . "%20#" . $comp2 . "-" . $no . "%20Bogotá,%20Colombia";
        //dd($address);
*/
         $city = DB::table('cities_customers')->where('customer_id','=',Auth::user()->customer_id)->first();

        $ciudad_pais = City::where('id','=',$city->city_id)->first();

        $address = $index_id . " " . $comp1 . " " . $comp2 . " " . $no .' ' .$ciudad_pais->name.' '.$ciudad_pais->department->name.' '.$ciudad_pais->country->name;

//        $address = "\"" . $index_id . " " . $comp1 . " #" . $comp2 . "-" . $no . " Bogotá, Colombia". "\"";
///        $address = $index_id . "%20" . $comp1 . "%20#" . $comp2 . "-" . $no . "%20Bogotá,%20Colombia";
        //$address = $index_id . "%20" . $comp1 . "%20" . $comp2 . "%20-" . $no . "%20Bogotá,%20Colombia";
/*
        $address_encode = urlencode($address);
        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address_encode . "&sensor=false";
        //dd($details_url);

        $address_encode = str_replace("+", "", $address_encode);
        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address_encode . "&sensor=false";
    //$details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false";
  */

        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" .  urlencode($address) . "&sensor=false";


        //dd($details_url);
        //exit();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);
        //dd($geoloc);

        //exit();

        $step1 = $geoloc['results'][0];
        $step2 = $step1['geometry'];
        $coords = $step2['location'];


        $address1 = $index_id." ".$comp1." #".$comp2."-".$no;

        /*dd(array(
                    'user_id' => $id,
                    'status_id' => '1',
                    // 'from_lng' => '0',
                    // 'from_lat' => '0',
                    'from_lng' => $coords["lng"],
                    'from_lat' => $coords["lat"],
                    'index_id' => Input::get('index_id'),
                    'comp1' => Input::get('comp1'),
                    'comp2' => Input::get('comp2'),
                    'no' => Input::get('no'),
                    'barrio' => Input::get('barrio'),
                    'obs' => Input::get('obs'),
                    'kind_id' => '3',
                    'cms_users_id' => $idopr,
                    'user_name' => Input::get('name'),
                    //'address' => Input::get('address'),
                    'address' => $address1,
        ));*/
        //exit();

        $servicio = Service::create(array(
                    'user_id' => $id,
                    'status_id' => '1',
					// 'from_lng' => '0',
					// 'from_lat' => '0',
                    'from_lng' => $coords["lng"],
                    'from_lat' => $coords["lat"],
                    'index_id' => Input::get('index_id'),
                    'comp1' => Input::get('comp1'),
                    'comp2' => Input::get('comp2'),
                    'no' => Input::get('no'),
                    'barrio' => Input::get('barrio'),
                    'obs' => Input::get('obs'),
                    'kind_id' => '3',
					'cms_users_id' => $idopr,
					'user_name' => Input::get('name'),
                    //'address' => Input::get('address'),
                    'address' => $address1,
        ));
        //agregar direccion a favoritos
        $addressData = DB::table('users_dirs')
                ->where_index_id_and_comp1_and_comp2_and_no_and_barrio_and_user_id(Input::get('index_id'), Input::get('comp1'), Input::get('comp2'), Input::get('no'), Input::get('barrio'), Input::get('user_id'))
                ->first();
        if ($addressData) {
            //return json_encode(array('error' => '1')); //Direccion existente
            //$addressObj=  Address::find($addressData->id);
            Address::update($addressData->id, array(
                'user_pref_order' => $addressData->user_pref_order + 1
            ));
        } else {
            $actAdrsRecord = DB::table('users_dirs')->where_user_id(Input::get('user_id'))->count();
            if ($actAdrsRecord >= 4) {
                $adrsMin = DB::table('users_dirs')->where_user_id(Input::get('user_id'))->min('user_pref_order');
                //dd($adrsMin);
                $adrsMinId = DB::table('users_dirs')->where_user_id(Input::get('user_id'))->where_user_pref_order($adrsMin)->first('id');
                Address::update($adrsMinId->id, array(
                    'index_id' => Input::get('index_id'),
                    'comp1' => Input::get('comp1'),
                    'comp2' => Input::get('comp2'),
                    'no' => Input::get('no'),
                    'barrio' => Input::get('barrio'),
                    'obs' => Input::get('obs'),
                    'user_id' => Input::get('user_id'),
                    'user_pref_order' => '0'
                ));
                //return json_encode(array('error' => '2')); //Lista llena
            } else {
                Address::create(array(
                    'index_id' => Input::get('index_id'),
                    'comp1' => Input::get('comp1'),
                    'comp2' => Input::get('comp2'),
                    'no' => Input::get('no'),
                    'barrio' => Input::get('barrio'),
                    'obs' => Input::get('obs'),
                    'user_id' => Input::get('user_id'),
                    'user_pref_order' => '0'
                ));
                //return direcciones de Direccion
                //return Address::getUsrAddresses(Input::get('user_id'));
            }
        }
        $tmpService = new Service();

		 //!!!!! API V2!!!!!!
		$user = new User;
		$user->name = Input::get('name');
		$user->notify_service2($servicio, DB::query("SELECT * FROM drivers WHERE available =  '1' group by uuid;"));
		//!!!!! FIN API V2!!!!!!

       // $habemusTaxis = $tmpService->requestService(false, $servicio->from_lat, $servicio->from_lng);
        //$habemusTaxis = true;
        /*if ($habemusTaxis) {
            $user = User::find(Input::get('user_id'));
            $user->notify_service($servicio);
        } else {
            $id = $servicio->id;
            //Si hay conductor, notificar
            Service::update($id, array(
                'status_id' => '6'
            ));
            //Notificar a usuario!!
            $pushMessage = 'En el momento no hay taxis disponibles';

            $servicio = Service::find($id);
            $push = Push::make();
            if ($servicio->user->type == '1') {//iPhone
                $preventEcho = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav');
            } else {
                $preventEcho = $push->android2($servicio->user->uuid, $pushMessage);
            }
        }*/

        //return Response::eloquent($servicio);
		$defService = Service::find($servicio->id);

		$pieces = explode("_", get_class($this));
        $section = strtolower($pieces[0]);
        $titleArray = array(
			"Código servicio" => "id",
            //"Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
			"Nomb. usuario" => "user_name",
			"comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs",
//            "comb_Dirección" => "address.index_id.comp1.comp2.no.barrio.obs",
			//"Teléfono" => array("user", "cellphone"),
			"Teléfono" => array("user", "telephone"),
			"Estado" => array("state", "descrip"),
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE,
            'total' => TRUE,
            'custom' => array(
                array("Cancelar servicio",
                    "cancel2",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea cancelar este servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
        );
		$Usercms = DB::table('cms_users')->where('email', '=', Auth::user()->email)->first('id');
		$day = date('d');
		$month = date('n');
		$year = date('Y');
		$Servicios = Service::where('cms_users_id','=',$Usercms->id)
					->where('status_id','<>','5')
					->where(DB::RAW('MONTH(updated_at)'), '=', $month)
					->where(DB::RAW('YEAR(updated_at)'), '=', $year)
					->where(DB::RAW('DAY(updated_at)'),'>=',$day-1)
					->order_by('id', 'DESC')->get();
		$Itemsdir = DB::table('dir_indexes')->get();

        return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios);

    }

	public function post_cancel2(){
		//dd(Input::all());
        $id = Input::get('id');
		$pieces = explode("_", get_class($this));
		$section = strtolower($pieces[0]);
        //Si hay conductor, notificar
        Service::update($id, array(
            'status_id' => '6'
                //,'pwd' => md5(Input::get('pwd'))
        ));
        $actService = Service::find($id);
        /*if (isset($actService->driver_id)) {
            $push = Push::make();
            $msg = "El servicio ha sido cancelado";
            $push->android($actService->driver->uuid, $msg);
        }*/

        //Notificar a usuario!!
        /*$pushMessage = 'En el momento no hay taxis disponibles intente más tarde';

        $servicio = Service::find($id);
        $push = Push::make();
        if ($servicio->user->type == '1') {//iPhone
            $preventEcho = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav');
        } else {
            $preventEcho = $push->android2($servicio->user->uuid, $pushMessage);
        }
        $pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        $section = strtolower($pieces[0]); //'section';*/
        //return View::make('service.index');

		//Notificar al taxista
		//echo print_r($actService->driver_id,true);
		if (!is_null($actService->driver_id)) {
				//echo print_r('entro',true);
                $driver = Driver::find($actService->driver_id);
                Notifier::driver($driver, PushType::OPERATOR_CANCELED_SERVICE, array('service_id' => $id));
                $driver->available = '1';
                $driver->save();
		} else {
			//echo print_r('else',true);
			$payload = array();
			$payload['service_id'] = $actService->id;
			Notifier::available_drivers(PushType::REMOVE_SERVICE, $payload);
		}

		$titleArray = array(
			"Código Servicio" => "id",
            //"Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
			"Nomb. Usuario" => "user_name",
			"comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs",
			//"Teléfono" => array("user", "cellphone"),
			"Teléfono" => array("user", "telephone"),
			"Estado" => array("state", "descrip"),
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE,
            'total' => TRUE,
            'custom' => array(
                array("Cancelar servicio",
                    "cancel2",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea cancelar este servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
        );
		$Usercms = DB::table('cms_users')->where('email', '=', Auth::user()->email)->first('id');
		$day = date('d');
		$month = date('n');
		$year = date('Y');
		$Servicios = Service::where('cms_users_id','=',$Usercms->id)
					->where('status_id','<>','5')
					->where(DB::RAW('MONTH(updated_at)'), '=', $month)
					->where(DB::RAW('YEAR(updated_at)'), '=', $year)
					->where(DB::RAW('DAY(updated_at)'),'>=',$day-1)
					->order_by('id', 'DESC')->get();
		$Itemsdir = DB::table('dir_indexes')->get();

        return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios);

	}

	public function post_edit(){
		$serviceid = Input::get('id');
		$phone = Input::get('phone');
		$addresid = Input::get('adressid');
		//echo print_r($addresid,true);
		//echo print_r("fasdasd");
		$pieces = explode("_", get_class($this));
        $section = strtolower($pieces[0]);
        $titleArray = array(
			"Código Servicio" => "id",
            //"Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
			"Nomb. Usuario" => "user_name",
			"comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs",
			"Teléfono" => array("user", "cellphone"),
			//"Teléfono" => array("user", "telephone"),
			"Estado" => array("state", "descrip"),
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE,
            'total' => TRUE,
            'custom' => array(
                array("Cancelar servicio",
                    "cancel2",
                    $section,
                    "images/icon/color_18/cancel.png",
                    "(function(id){if(confirm(\"Desea cancelar este servicio?\")){dataPoster(id);}})(this.id)",
                    "1"),
            ),
        );
		$Usercms = DB::table('cms_users')->where('email', '=', Auth::user()->email)->first('id');
		$day = date('d');
		$month = date('n');
		$year = date('Y');
		$Servicios = Service::where('cms_users_id','=',$Usercms->id)
					->where('status_id','<>','5')
					->where(DB::RAW('MONTH(updated_at)'), '=', $month)
					->where(DB::RAW('YEAR(updated_at)'), '=', $year)
					->where(DB::RAW('DAY(updated_at)'),'>=',$day-1)
					->order_by('id', 'DESC')->get();
		$Itemsdir = DB::table('dir_indexes')->get();
		$ServiceSelected = DB::table('services')->where('id','=',$serviceid)->first();

		$usersearch = DB::table('users')->where('id','=',$ServiceSelected->user_id)->first();
		$driverserch = DB::table('drivers')->where('id','=',$ServiceSelected->driver_id)->first();
		$carsearch = DB::table('cars')->where('id','=',$ServiceSelected->car_id)->first();

		$conductor = '';
		$placa = '';
		$celldriver ='';
		$movil = '';
		if($driverserch)
		{
			$conductor = $driverserch->name.$driverserch->lastname;
			//$celldriver = $driverserch->telephone;
			$celldriver = $driverserch->cellphone;
		}
		if($carsearch)
		{
			$placa = $carsearch->placa;
			$movil = $carsearch->movil;
		}

		//echo print_r($selectaddress,true);
		if($ServiceSelected)
		{
			return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('phone',$usersearch->telephone)
						->with('conductor',$conductor)
						->with('placa',$placa)
						->with('celldriver',$celldriver)
						->with('movil',$movil)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios)
						->with('selectaddress',$ServiceSelected)
						->with('user',$usersearch);
		}else{
			return View::make('service.request')
						->with('itemsdir', $Itemsdir)
                        ->with('title', 'Servicios: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
						->with('phone',$phone)
						->with('tablesorting', '"aaSorting": [[ 0, "desc" ]],')
                        ->with('items', $Servicios)
						->with('user',$usersearch);
		}
	}
}
