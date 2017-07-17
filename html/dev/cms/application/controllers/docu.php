<?php

class Docu_Controller extends Base_Controller {

    public $restful = true;

    public function post_index() {

        $idcusto =  Auth::user()->customer_id;
        // code here..
        //return View::make('user.index');
        $titleArray = array("ID" => "driver_id",
          "Nombre" => "name",
          "Apellido" => "lastname",
          "Celular" => "cellphone",
          "Correo electrónico" => "email",
        );
        $section = 'docu';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        return View::make($section . '.index')
                        ->with('title', 'Vehículos registrados:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('items', Cmsuser::join('cities_customers', 'cms_users.customer_id', '=', 'cities_customers.customer_id')
                                         ->join('drivers', 'cities_customers.city_id', '=', 'drivers.city_id')
                                         ->join('cms_documents', 'drivers.id', '=', 'cms_documents.driver_id')
                        ->group_by("cms_documents.driver_id")
                        // ->where('cms_users.customer_id','=',$idcusto)->get());
                        ->where('drivers.status','=','nuevo')
                        ->where('cms_users.customer_id','=',$idcusto)
                        ->order_by('drivers.updated_at','DESC')->get()
                        );
                        //->with('items', Docu::join('drivers', 'cms_documents.driver_id', '=', 'drivers.id')->get())



    }
    public function post_estado() {
         $itemId = $_POST['id'];

        $itemAction = Driver::update($itemId, array(
                    "status" => $_POST['status'],
        ));
    }
    public function post_new() {
        // code here..
        //return View::make('user.index');
        //Form::select('subject_id[]',$customSelector,'',array('class'=>'chzn-select','multiple'))
        /*
          "Placa" => "placa",
          "Marca" => "car_brand",
          "Línea" => "model"
          "Placa" => Input::get('car_taq'),
          "Marca" => Input::get('car_brand'),
          "Línea" => Input::get('car_line')
         */
        /* <select name = "year" class="chzn-select">
          <?php
          $initialYear = date('Y');
          for ($index = 0; $index < 70; $index++) {
          $selected = "";
          ?>
          <option {{$selected}} value="{{$initialYear}}">{{$initialYear}}</option>
          <?php
          $initialYear = $initialYear - 1;
          }
          ?>
          </select> */
        $initialYear = date('Y') + 1;
        for ($index = 0; $index < 70; $index++) {
            $selected = "";
            $yearList[$initialYear] = $initialYear;
            $initialYear = $initialYear - 1;
        }
        $formTemplate = array(
            array(
                "title" => array(
                 "Placa","del vehículo"),
                "name" => "car_taq",
                "value" => null,
                "type" => "text",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "Fecha de último","pago",
					"mm/dd/aaaa"),
                "name" => "pay_date",
                "value" => date("d-m-Y H:i:s"),
                "type" => "datePicker",
                "attributes" => array("id" => "pay_date", "tabindex" => "1", "class" => "validate[required] large")
            //<input type = "text" class = "validate[required] large" value = "" name = "pay_date" id = "pay_date" tabindex = "1">
            )
        );
        $titleArray = array();
        $action = 'create';
        $section = 'docu';
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
                        ->with('section', $section)
                        ->with('title', 'Nuevo vehículo');
        /*
          case 'select':
          //public static function select($name, $options = array(), $selected = null, $attributes = array())
          echo Form::select($row['name'], $row['options'], $row['selected'], $row['attributes']);
          break;
          case 'password':
          //public static function password($name, $attributes = array())
          echo Form::password($row['name'], $row['attributes']);
          break;
          case 'file':
          //public static function file($name, $attributes = array())
          echo Form::file($row['name'], $row['attributes']);
          break;
          case 'checkbox':
          //public static function checkbox($name, $value = 1, $checked = false, $attributes = array())
          echo Form::checkbox($row['name'], $row['value'], $row['checked'], $row['attributes']);
          break;
          case 'radio':
          //public static function radio($name, $value = null, $checked = false, $attributes = array())
          echo Form::radio($row['name'], $row['value'], $row['checked'], $row['attributes']);
          break;
          case 'image':
          //public static function image($url, $name = null, $attributes = array())
          echo Form::image($row['url'], $row['name'], $row['attributes']);
          break;
          case 'reset':
          //public static function reset($value = null, $attributes = array())
          echo Form::reset($row['value'], $row['attributes']);
          break;
          case 'button':
          //public static function button($value = null, $attributes = array())
          echo Form::button($row['value'], $row['attributes']);
          break;
          case 'submit':
          //public static function submit($value = null, $attributes = array())
          echo Form::submit($row['value'], $row['attributes']);
          break;
          case 'video':

          <video width="320" height="240" controls>
          <source src="movie.mp4" type="video/mp4">
          <source src="movie.ogg" type="video/ogg">
          Your browser does not support the video tag.
          </video>

          ?>
          <video width="320" height="240" controls>
          <source src="movie.mp4" type="video/mp4">
          <source src="movie.ogg" type="video/ogg">
          Your browser does not support the video tag.
          </video>
          <?php
          break;
          default:

          public static function text($name, $value = null, $attributes = array())
          public static function hidden($name, $value = null, $attributes = array())
          public static function search($name, $value = null, $attributes = array())
          public static function email($name, $value = null, $attributes = array())
          public static function telephone($name, $value = null, $attributes = array())
          public static function url($name, $value = null, $attributes = array())
          public static function number($name, $value = null, $attributes = array())
          public static function date($name, $value = null, $attributes = array())
          public static function textarea($name, $value = '', $attributes = array())

          echo Form::$row['type']($row['name'], $row['value'], $row['attributes']);
          break;
         */
    }

    public function post_create() {
		$loginData = DB::table('cars')->where('placa','=',Input::get('car_taq'))->first();
        if (Input::has('pay_date')) {
            list($month, $day, $year) = explode('/', Input::get('pay_date'));
            $afiliacion = new DateTime("" . $year . "-" . $month . "-" . $day . "");
        }
		$titleArray = array("NO" => "id",
            "Placa" => "placa",
            "Móvil" => "movil",
            "Marca" => "car_brand",
            "Línea" => "model",
            "Modelo" => "year",
            "empresa" => "empresa"
        );
		$section = 'docu';
			$manageBtns = array(
				'add' => true,
				'edit' => true,
				'del' => true
			);
		if (!isset($loginData)) {
			$newItem = Car::create(array(
						"placa" => Input::get('car_taq'),
						"car_brand" => Input::get('car_brand'),
						"model" => Input::get('car_line'),
						"movil" => Input::get('car_movil'),
						"year" => Input::get('car_year'),
						"empresa" => Input::get('car_empresa'),
						"pay_date" => $afiliacion
			));
			if ($newItem) {
				$msg = 'Registro creado!';
				$type = 'success';
			} else {
				$msg = 'Error al crear registro!';
				$type = 'error';
			}
			// code here..
			//return View::make('user.index');


			return View::make($section . '.index')
							->with('title', 'Vehículos registrados:')
							->with('titles', $titleArray)
							->with('section', $section)
							->with('manageBtns', $manageBtns)
							->with('message', $msg)
							->with('result', $type)
							->with('items', Car::all());
		}else{
			return View::make($section . '.index')
              ->with('title', 'Vehículos registrados:')
			  ->with('titles', $titleArray)
			  ->with('section', $section)
			  ->with('manageBtns', $manageBtns)
              ->with('message', 'Vahiculo ' . Input::get('car_taq') . ' NO HA SIDO CREADO PORQUE YA EXISTE EN EL SISTEMA')
              ->with('result', 'error')
              ->with('items', Car::all());
		}
    }

    public function post_edit() {
        $id = Input::get('id');



		$resultfe=Docu::join('drivers', 'cms_documents.driver_id', '=', 'drivers.id')->where('driver_id', '=', $id)->get();

        return View::make( 'docu.edit')
                        ->with('items', $resultfe);

    }

    public function post_update() {
        $itemId = Input::get('id');
        //dd(Input::all());
        //dd(multiexplode(array('/', '-'), Input::get('pay_date')));
        $delimiters = array('/', '-');
        $ready = str_replace($delimiters, $delimiters[0], Input::get('pay_date'));
        $launch = explode($delimiters[0], $ready);

        list($month, $day, $year) = $launch;//explode('/-', Input::get('pay_date'));
        $afiliacion = new DateTime("" . $year . "-" . $month . "-" . $day . "");
        //dd(Input::all());
        $itemAction = Car::update($itemId, array(
                    "placa" => Input::get('car_taq'),
                    "car_brand" => Input::get('car_brand'),
                    "model" => Input::get('car_line'),
                    "movil" => Input::get('car_movil'),
                    "year" => Input::get('car_year'),
                    "empresa" => Input::get('car_empresa'),
                    "pay_date" => $afiliacion
        ));
        if ($itemAction) {
            $msg = 'Registro actualizado!';
            $type = 'success';
        } else {
            $msg = 'Error al actualizar registro!';
            $type = 'error';
        }
        // code here..
        //return View::make('user.index');
        $titleArray = array("NO" => "id",
            "Placa" => "placa",
            "Móvil" => "movil",
            "Marca" => "car_brand",
            "Línea" => "model",
            "Modelo" => "year",
            "empresa" => "empresa"
        );
        $section = 'docu';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        return View::make($section . '.index')
                        ->with('title', 'Vehículos registrados:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('items', Car::all());
    }

    public function post_del() {
        $id = Input::get('id');
        $data = Car::find($id);

		try{
				$query = "delete from drivers_cars where cars_id='".$id."'";
				DB::query($query);
				$data->delete();
				$msg = 'Registro ' . ' eliminado!';
                            	$type = 'success';
		}catch(Exception $e){
			$msg = 'Error al eliminar registro!';
							$type = 'error';
		}

        /*if ($data->delete()) {
            $msg = 'Registro ' . ' eliminado!';
            $type = 'success';
        } else {
            $msg = 'Error al eliminar registro!';
            $type = 'error';
        } */
        // code here..
        //return View::make('user.index');
        $titleArray = array("NO" => "id",
            "Placa" => "placa",
            "Móvil" => "movil",
            "Marca" => "car_brand",
            "Línea" => "model",
            "Empresa" => "empresa"
        );
        $section = 'docu';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        return View::make($section . '.index')
                        ->with('title', 'Vehículos registrados')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('items', Car::all());
    }

    public function post_expired() {
        //SELECT id from drivers where (TIMESTAMPDIFF(DAY,created_at,NOW()))>=25
        $whereDate = date('Y') . "-" . date('m') . "-05";
        $whereDateMin = date('Y') . "-" . date('m') . "-01";
        $items = Car::where('pay_date', '<=', DB::RAW("DATE('" . $whereDate . "')"))
                ->where_not_between('pay_date', $whereDateMin, $whereDate)
                ->get();
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
        $titleArray = array("NO" => "id",
            "Placa" => "placa",
            "Móvil" => "movil",
            "Marca" => "car_brand",
            "Línea" => "model",
            "empresa" => "empresa",
            "Último pago" => "pay_date"
        );
        $section = 'docu';
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE
        );
        return View::make($section . '.expired')
                        ->with('title', 'Vehículos con afiliaciones vencidas')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('items', $items);
    }

	/*public function post_alert(){
		$afftovercome = DB::query("SELECT uuid from FROM cars where  DATE_ADD(CURRENT_DATE(), INTERVAL 1 DAY)= DATE_ADD(pay_date,INTERVAL 1 MONTH)");
		$afftovercome = Array();
		foreach ($afftovercome as $driver){
			$push = Push::make();
            $msg = "Sr usuario recuerde que debe realizar el pago de su afiliación a más tardar mañana";
            $push->android($driver->uuid, $msg);
			$preventEcho = $push->android2($driver->uuid, $msg);
		}
		//return Response::json(array('error' => '1', 'msg' => 'No hay taxis disponibles'));
	}*/
}

