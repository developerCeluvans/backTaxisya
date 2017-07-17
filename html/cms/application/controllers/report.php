<?php

class Report_Controller extends Base_Controller {

    public $restful = true;

    public function post_index() {
        //dd(Input::all());
        /*
          array(6) {
          ["csrf_token"]=>
          string(40) "DUF61SU0kT3LVVQIN9rkMhylNGlosvMjJnrYAyWL"
          ["report_type"]=>
          string(1) "1"
          ["report_filter"]=>
          string(28) "report-0-selector-formHelper"
          ["report_since"]=>
          string(10) "08/20/2013"
          ["report_until"]=>
          string(10) "08/20/2013"
          ["id"]=>
          string(1) "0"
          }
         */
        $sinceDate = explode('/', Input::get("report_since"));
        $untilDate = explode('/', Input::get("report_until"));
        $reportFilterPieces = explode('-', Input::get('report_filter'));
        $serviceType = Input::get('service_type');
        $reportFilter = $reportFilterPieces['1'];
        //dd($reportFilter);

        $whereDate = $untilDate[2] . "-" . $untilDate[0] . "-" . $untilDate[1] . " 23:59:59";
        $whereDateMin = $sinceDate[2] . "-" . $sinceDate[0] . "-" . $sinceDate[1] . " 00:00:00";
        
        //dd(Input::all());
        //dd(array($whereDateMin,$whereDate));
        if (Input::has('report_type')) {
            $report_type = Input::get('report_type');
            if ($report_type == 1) { // Reporte de servicios
                switch ($reportFilter) {
                    case '0'://
                        if (Input::has('service_type') && Input::get('service_type')!= 0) {
                            $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_kind_id($serviceType)
                                    ->get();
                        } else {
                            $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->get();
                        }
                        break;
                    case '1'://
                        if (Input::has('service_type') && Input::get('service_type')!= 0) {
                            if (Input::has('specific_filter_id')) {
                                $items = Service::where('driver_id', '=', Input::get('specific_filter_id'))
                                        ->where_between('created_at', $whereDateMin, $whereDate)
                                        ->where_kind_id($serviceType)
                                        ->get();
                            } else {
                                $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                        ->where_kind_id($serviceType)
                                        ->get();
                            }
                        } else {
                            if (Input::has('specific_filter_id')) {
                                $items = Service::where('driver_id', '=', Input::get('specific_filter_id'))
                                        ->where_between('created_at', $whereDateMin, $whereDate)
                                        ->get();
                            } else {
                                $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                        ->get();
                            }
                        }
                        break;
                    case '2':
                        if (Input::has('service_type') && Input::get('service_type')!= 0) {
                            if (Input::has('specific_filter_id')) {
                                $items = Service::where('user_id', '=', Input::get('specific_filter_id'))
                                        ->where_between('created_at', $whereDateMin, $whereDate)
                                        ->where_kind_id($serviceType)
                                        ->get();
                            } else {
                                $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                        ->where_kind_id($serviceType)
                                        ->get();
                            }
                        } else {
                            if (Input::has('specific_filter_id')) {
                                $items = Service::where('user_id', '=', Input::get('specific_filter_id'))
                                        ->where_between('created_at', $whereDateMin, $whereDate)
                                        ->get();
                            } else {
                                $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                        ->get();
                            }
                        }
                        break;
                    case '3':
                        if (Input::has('service_type') && Input::get('service_type')!= 0) {
                            $items = Service::where('car_id', '=', Input::get('specific_filter_id'))
                                    ->where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_kind_id($serviceType)
                                    ->get();
                        } else {
                           /* $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->get();*/
                           if(Input::has('specific_filter_id')){
                           		$items = Service::where('car_id', '=', Input::get('specific_filter_id'))
                                    ->where_between('created_at', $whereDateMin, $whereDate)
                                    ->get();
                           }else {
                           		 $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->get();
                           }
                        }
                        break;
                    default:
                        break;
                }
                //dd($items);
                $objName = "service";
                $section = "report"; //'section';
                //return View::make('service.index');
                $titleArray = array("NO" => "id",
                    "Nomb. Usuario" => array("user", "name"),
                    //"Apell. Usuario" => array("user", "lastname"),
                    "Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
                    "Vehiculo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
                    "Móvil" => array("car", "movil"), //"car_id",
                    //"latitud" => "from_lat",
                    //"longitud" => "from_lng",
                    //"Estado" => "status_id",
                    "Estado" => array("state", "descrip"),
                    "Solicitud" => "created_at",
                    "Finalización" => "updated_at",
                    "Calificacion" => array("score", "descrip"), //"qualification",
                    "comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs",
                    "Tipo de servicio" => array("kind", "description")
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
                    'export' => TRUE,
                    'exportData' => array('reportType' => $report_type, 'reportFilter' => $reportFilter, 'reportSince' => $whereDateMin, 'reportUntil' => $whereDate, 'serviceType' => $serviceType, 'specificFilter' => Input::get('specific_filter_id')),
                    'total' => TRUE,
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
                            array(
                                "id" => "6",
                                "description" => "Canc."
                            ),
                            array(
                                "id" => "7",
                                "description" => "Canc. Sistema"
                            ),
                            array(
                                "id" => "8",
                                "description" => "Canc. Conductor"
                            ),
                            array(
                                "id" => "9",
                                "description" => "Canc. Operadora"
                            )
                        ),
                        "tabber" => "status_id"
                    )
                );
                return View::make('report.index')
                                ->with('title', 'Reporte: ')
                                ->with('titles', $titleArray)
                                ->with('message', false)
                                ->with('result', false)
                                ->with('tablesorting', '"aaSorting": [[6,"desc"]],')
                                ->with('manageBtns', $manageBtns)
                                ->with('section', $section)
                                ->with('items', $items);
            } elseif ($report_type == 2) {
                $items = Schedules::all();
            }
        }
    }

    public function post_driverdetails() {
        //dd(Input::all());
        if (Input::has('id') && !Input::has('specific_filter_id')) {
            $specificFilter = Input::get('id');
            $reportFilter = 1;
        } else {
            $reportFilterPieces = explode('-', Input::get('report_filter'));
            $specificFilter = Input::get('specific_filter_id');
            $reportFilter = $reportFilterPieces['1'];
        }

        $section = "report";

        if ($reportFilter == 1) {
            //dd("Placa");
            /*
              $items = Driver::where('car_id', '=', $specificFilter)->get();
              $titleArray = array(//"NO" => "id",
              //"Apell. Usuario" => array("user", "lastname"),
              "comb_Conductor" => "name.lastname", //array("driver", "name"), //"driver_id",
              "imgp_Foto" => "picture",
              "Vehiculo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
              "Móvil" => array("car", "movil"),
              //"latitud" => "from_lat",
              //"longitud" => "from_lng",
              //"Estado" => "status_id",
              );
              $manageBtns = array(
              'add' => FALSE,
              'edit' => FALSE,
              'del' => FALSE,
              'total' => TRUE,
              'custom' => array(
              array("Servicios",
              "services",
              $section,
              "images/icon/color_18/list.png",
              "(function(id){dataPoster(id);})(this.id)",
              "1"),
              ),
              ); */
            //dd("movil");
            $items = Service::where('car_id', '=', $specificFilter)->take(10)->order_by('created_at', 'desc')->get();

            //dd($items);
            $objName = "service";
            $section = "report"; //'section';
            //return View::make('service.index');
            $titleArray = array(//"NO" => "id",
                "Nomb. Usuario" => array("user", "name"),
                //"Apell. Usuario" => array("user", "lastname"),
                "Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
                "Correo" => array("user", "email"), //array("driver", "name"), //"driver_id",
                'Teléfono Usuario' => array('user', 'telephone'),
                'Celular Usuario' => array('user', 'cellphone'),
                "Vehiculo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
                "Móvil" => array("car", "movil"),
                //"latitud" => "from_lat",
                //"longitud" => "from_lng",
                //"Estado" => "status_id",
                "Estado" => array("state", "descrip"),
                "Solicitud" => "created_at",
                "Finalización" => "updated_at",
                "Calificacion" => array("score", "descrip"), //"qualification",
                "comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs"
            );
            $manageBtns = array(
                'add' => FALSE,
                'edit' => FALSE,
                'del' => FALSE,
                'total' => TRUE,
            );
            return View::make('report.index')
                            ->with('title', 'Reporte: ')
                            ->with('titles', $titleArray)
                            ->with('tablesorting', '"aaSorting": [[4,"desc"]],')
                            ->with('message', false)
                            ->with('result', false)
                            ->with('manageBtns', $manageBtns)
                            ->with('section', $section)
                            ->with('items', $items);
        } else {
            //dd("movil");
            $items = Service::where('driver_id', '=', $specificFilter)->take(10)->order_by('created_at', 'desc')->get();

            //dd($items);
            $objName = "service";
            $section = "report"; //'section';
            //return View::make('service.index');
            $titleArray = array(//"NO" => "id",
                "Nomb. Usuario" => array("user", "name"),
                //"Apell. Usuario" => array("user", "lastname"),
                "Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
                "Correo" => array("user", "email"), //array("driver", "name"), //"driver_id",
                'Teléfono Usuario' => array('user', 'telephone'),
                'Celular Usuario' => array('user', 'cellphone'),
                "Vehiculo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
                "Móvil" => array("car", "movil"),
                //"latitud" => "from_lat",
                //"longitud" => "from_lng",
                //"Estado" => "status_id",
                "Estado" => array("state", "descrip"),
                "Solicitud" => "created_at",
                "Finalización" => "updated_at",
                "Calificacion" => array("score", "descrip"), //"qualification",
                "comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs"
            );
            $manageBtns = array(
                'add' => FALSE,
                'edit' => FALSE,
                'del' => FALSE,
                'total' => TRUE,
            );
            return View::make('report.index')
                            ->with('title', 'Reporte: ')
                            ->with('titles', $titleArray)
                            ->with('tablesorting', '"aaSorting": [[4,"desc"]],')
                            ->with('message', false)
                            ->with('result', false)
                            ->with('manageBtns', $manageBtns)
                            ->with('section', $section)
                            ->with('items', $items);
        }

        //dd($items);

        if (Input::has('specific_filter_id') || isset($specificFilter)) {

            //dd($items);
            //'section';
            //return View::make('service.index');

            return View::make('report.indexcardetails')
                            ->with('title', 'Reporte: ')
                            ->with('titles', $titleArray)
                            ->with('message', false)
                            ->with('result', false)
                            ->with('manageBtns', $manageBtns)
                            ->with('section', $section)
                            ->with('items', $items);
        }
    }

    public function post_services() {
        //dd(Input::all());
        //dd($items);

        if (Input::has('id')) {
            $items = Service::where('driver_id', '=', Input::get('id'))->take(10)->order_by('created_at', 'desc')->get();
            $driverData = Driver::find(Input::get('id'));

            //dd($items);
            $objName = "service";
            $section = "report"; //'section';
            //return View::make('service.index');
            $titleArray = array(//"NO" => "id",
                "Nomb. Usuario" => array("user", "name"),
                //"Apell. Usuario" => array("user", "lastname"),
                "Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
                "Vehiculo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
                "Móvil" => array("car", "movil"),
                //"latitud" => "from_lat",
                //"longitud" => "from_lng",
                //"Estado" => "status_id",
                "Estado" => array("state", "descrip"),
                "Solicitud" => "created_at",
                "Finalización" => "updated_at",
                "Calificacion" => array("score", "descrip"), //"qualification",
                "comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs"
            );
            $manageBtns = array(
                'add' => FALSE,
                'edit' => FALSE,
                'del' => FALSE,
                'total' => TRUE,
                'back' => array(
                    'section' => 'report',
                    'id' => $driverData->car_id,
                    'action' => 'driverdetails'
                ),
                'custom' => array(
                    array("Servicios",
                        "services",
                        $section,
                        "images/icon/color_18/list.png",
                        "(function(id){if(confirm(\"Desea cambiar estado a completado?\")){dataPoster(id);}})(this.id)",
                        "1"),
                ),
            );
            return View::make('report.index')
                            ->with('title', 'Reporte: ')
                            ->with('titles', $titleArray)
                            ->with('tablesorting', '"aaSorting": [[4,"desc"]],')
                            ->with('message', false)
                            ->with('result', false)
                            ->with('manageBtns', $manageBtns)
                            ->with('section', $section)
                            ->with('items', $items);
        }
    }

    public function post_selector() {
        $type = Input::get('id');
        switch ($type) {
            case 1:
                $drivers = Driver::get();
                foreach ($drivers as $key => $value) {
                    $options[$value->id] = $value->name . " " . $value->lastname;
                }
//$options = Driver::lists('name lastname', 'id'); //to list
//dd($options);
                $Selector = Form::select('specific_filter_id', $options, '', array("class" => "chzn-select"));
                $response = "
          <script type=\"text/javascript\">
          $(\"#specific_filter\").empty().html('{$Selector}');
          $(\".chzn-select\").chosen();
          </script>
          ";
                break;
            case 2:
                $Users = User::get();
                foreach ($Users as $key => $value) {
                    $options[$value->id] = $value->name . " " . $value->lastname;
                }
//$options = User::lists('name', 'id'); //to list
                $Selector = Form::select('specific_filter_id', $options, '', array("class" => "chzn-select"));
                $response = "
          <script type=\"text/javascript\">
          $(\"#specific_filter\").empty().html('{$Selector}');
              $(\".chzn-select\").chosen();
          </script>
          ";
                break;
            case 3:
                $options = Car::lists('placa', 'id'); //to list
                $Selector = Form::select('specific_filter_id', $options, '', array("class" => "chzn-select"));
                $response = "
          <script type=\"text/javascript\">
          $(\"#specific_filter\").empty().html('{$Selector}');
              $(\".chzn-select\").chosen();
          </script>
          ";
                break;
            default:
                $response = "
            <script type=\"text/javascript\">
            $(\"#specific_filter\").empty();
            </script>
            ";
                break;
        }
//return Response::eloquent($complain);
        /* $response = "
          <script type=\"text/javascript\">
          $(\"#specific_filter\").html(\"Hi\");
          </script>
          "; */
        return $response;
    }

    public function post_carselector() {
        $type = Input::get('id');
        switch ($type) {
            case 1:
                $items = Car::get();
                foreach ($items as $key => $value) {
                    $options[$value->id] = $value->placa;
                }
                //$options = Driver::lists('name lastname', 'id'); //to list
                //dd($options);
                $Selector = Form::select('specific_filter_id', $options, '', array("class" => "chzn-select"));
                $response = "
          <script type=\"text/javascript\">
          $(\"#specific_filter\").empty().html('{$Selector}');
          $(\".chzn-select\").chosen();
          </script>
          ";
                break;
            case 2:
                $items = Driver::get();
                foreach ($items as $key => $value) {
                    if ($value->movil) {
                        $options[$value->id] = $value->movil;
                    }
                }
                //$options = User::lists('name', 'id'); //to list
                if (!isset($options)) {
                    $Selector = "No hay móviles registrados!";
                } else {
                    $Selector = Form::select('specific_filter_id', $options, '', array("class" => "chzn-select"));
                }
                $response = "
          <script type=\"text/javascript\">
          $(\"#specific_filter\").empty().html('{$Selector}');
              $(\".chzn-select\").chosen();
          </script>
          ";
                break;
            case 3:
                $options = Car::lists('placa', 'id'); //to list
                $Selector = Form::select('specific_filter_id', $options, '', array("class" => "chzn-select"));
                $response = "
          <script type=\"text/javascript\">
          $(\"#specific_filter\").empty().html('{$Selector}');
              $(\".chzn-select\").chosen();
          </script>
          ";
                break;
            default:
                $response = "
            <script type=\"text/javascript\">
            $(\"#specific_filter\").empty();
            </script>
            ";
                break;
        }
//return Response::eloquent($complain);
        /* $response = "
          <script type=\"text/javascript\">
          $(\"#specific_filter\").html(\"Hi\");
          </script>
          "; */
        return $response;
    }

    public function post_new() {
// code here..
//return View::make('user.index');
//Form::select('subject_id[]',$customSelector,'',array('class'=>'chzn-select','multiple'))
        /*
          'name' => Input::get('user_name'),
          'email' => Input::get('user_email'),
          'role_id' => Input::get('role_id'),
          'pwd' => Hash::make(Input::get('pwd')),
          'cedula' => Input::get('user_doc')
         */
        $reportType = array("1" => "Servicios", "2" => "Agendamientos");
        $serviceType = Kind::lists('description', 'id');
        $serviceType[0] = "Todos";
        $reportFilter = array(); //, "Conductor", "Usuario", "Vehículo");
//'complain-' . $complain->id . "-description-formHelper"
        $reportFilter['report-0-selector-formHelper'] = "Todos";
        $reportFilter['report-1-selector-formHelper'] = "Conductor";
        $reportFilter['report-2-selector-formHelper'] = "Usuario";
        $reportFilter['report-3-selector-formHelper'] = "Vehículo";
        $formTemplate = array(
            array(
                "title" => array(
                    "Filtrar",
                    "reporte"),
                "name" => "report_filter",
                "value" => null,
                "selected" => '',
                "options" => $reportFilter,
                "type" => "select",
                "attributes" => array("class" => "chzn-select", "onchange" => "selectorPoster($(this).val())")
            ),
            array(
                "title" => array(
                    "Filtro",
                    "específico"),
                "type" => "blank_div",
                "attributes" => array("id" => "specific_filter")
//<input type = "text" class = "validate[required] large" value = "" name = "pay_date" id = "pay_date" tabindex = "1">
            ),
            array(
                "title" => array(
                    "Tipo de servicio",
                    ""),
                "name" => "service_type",
                "value" => null,
                "selected" => '',
                "options" => $serviceType,
                "type" => "select",
                "attributes" => array("class" => "chzn-select", "onchange" => "selectorPoster($(this).val())")
            ),
            array(
                "title" => array(
                    "Desde",
                    ""),
                "name" => "report_since",
                "value" => date("Y-m-d H:i:s"),
                "type" => "datePicker",
                "attributes" => array("id" => "report_since", "tabindex" => "1", "class" => "validate[required] large")
//<input type = "text" class = "validate[required] large" value = "" name = "pay_date" id = "pay_date" tabindex = "1">
            ),
            array(
                "title" => array(
                    "Hasta",
                    ""),
                "name" => "report_until",
                "value" => date("Y-m-d H:i:s"),
                "type" => "datePicker",
                "attributes" => array("id" => "report_until", "tabindex" => "1", "class" => "validate[required] large")
//<input type = "text" class = "validate[required] large" value = "" name = "pay_date" id = "pay_date" tabindex = "1">
            ),
            array(
                "title" => array(
                    "",
                    ""),
                "name" => "report_type",
                "value" => 1, //null,
                "selected" => '',
                "options" => $reportType,
                "type" => "hidden", //"select",
                "attributes" => array()//array("class" => "chzn-select")
            ),
        );
        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );
        $action = 'index';
        $section = 'report';
        $manageBtns = array(
            'add' => FALSE,
            'edit' => FALSE,
            'del' => FALSE
        );
        return View::make('report.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('idToEdit', '0')
                        ->with('section', $section)
                        ->with('title', 'Reportes');
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

    public function get_export($id) {
        $exportType = $id; //Input::get('id');tabData
        $defItems;
        /*
          ["reportType"]=>
          string(1) "1"
          ["reportFilter"]=>
          string(1) "1"
          ["reportSince"]=>
          string(19) "2013-08-20 00:00:00"
          ["reportUntil"]=>
          string(19) "2013-08-22 23:59:59"
          ["specFilter"]=>
          string(1) "5"
         */

        $report_type = Input::get('reportType');
        $reportFilter = Input::get('reportFilter');
        $whereDateMin = $reportSince = Input::get('reportSince');
        $whereDate = $reportUntil = Input::get('reportUntil');
        $serviceType = Input::get('serviceType');
        $specFilter = Input::get('specFilter');
        if ($report_type == 1) {
            $titleArray = array("NO" => "id",
                "Nomb. Usuario" => array("user", "name"),
                //"Apell. Usuario" => array("user", "lastname"),
                "Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
                "Vehiculo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
                "Móvil" => array("car", "movil"),
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
            switch ($reportFilter) {
                case '0'://
                    if (Input::has('service_type') && Input::get('service_type')!= 0) {
                        $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                ->where_status_id($exportType)
                                ->where_kind_id($serviceType)
                                ->get();
                    } else {
                        $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                ->where_status_id($exportType)
                                ->get();
                    }
                    break;
                case '1'://
                    if (Input::has('service_type') && Input::get('service_type')!= 0) {
                        if (Input::has('specFilter')) {
                            $items = Service::where('driver_id', '=', Input::get('specFilter'))
                                    ->where_status_id($exportType)
                                    ->where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_kind_id($serviceType)
                                    ->get();
                        } else {
                            $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_status_id($exportType)
                                    ->where_kind_id($serviceType)
                                    ->get();
                        }
                    } else {
                        if (Input::has('specFilter')) {
                            $items = Service::where('driver_id', '=', Input::get('specFilter'))
                                    ->where_status_id($exportType)
                                    ->where_between('created_at', $whereDateMin, $whereDate)
                                    ->get();
                        } else {
                            $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_status_id($exportType)
                                    ->get();
                        }
                    }
                    break;
                case '2':
                    if (Input::has('service_type') && Input::get('service_type')!= 0) {
                        if (Input::has('specFilter')) {
                            $items = Service::where('user_id', '=', Input::get('specFilter'))
                                    ->where_status_id($exportType)
                                    ->where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_kind_id($serviceType)
                                    ->get();
                        } else {
                            $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_status_id($exportType)
                                    ->where_kind_id($serviceType)
                                    ->get();
                        }
                    } else {
                        if (Input::has('specFilter')) {
                            $items = Service::where('user_id', '=', Input::get('specFilter'))
                                    ->where_status_id($exportType)
                                    ->where_between('created_at', $whereDateMin, $whereDate)
                                    ->get();
                        } else {
                            $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_status_id($exportType)
                                    ->get();
                        }
                    }
                    break;
                case '3':
                    if (Input::has('service_type') && Input::get('service_type')!= 0) {
                        if (Input::has('specFilter')) {
                            $items = Service::where('car_id', '=', Input::get('specFilter'))
                                    ->where_status_id($exportType)
                                    ->where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_kind_id($serviceType)
                                    ->get();
                        } else {
                            $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_status_id($exportType)
                                    ->where_kind_id($serviceType)
                                    ->get();
                        }
                    } else {
                        if (Input::has('specFilter')) {
                            $items = Service::where('car_id', '=', Input::get('specFilter'))
                                    ->where_status_id($exportType)
                                    ->where_between('created_at', $whereDateMin, $whereDate)
                                    ->get();
                        } else {
                            $items = Service::where_between('created_at', $whereDateMin, $whereDate)
                                    ->where_status_id($exportType)
                                    ->get();
                        }
                    }
                    break;
                default:
                    break;
            }
        }
//Títulos para exportar
        $defTitle;
        foreach ($titleArray as $colNum => $colTitle) {
            if (substr($colNum, 0, 5) == 'comb_') {
                $defTitle[] = substr($colNum, 5);
            } else {
                $defTitle[] = $colNum;
            }
        }
        if (isset($roleMetaDataTitles)) {
            if ($exportType == $roleMetaData['role']) {
                foreach ($roleMetaDataTitles as $roleMetaDataTitle) {
                    $defTitle[] = $roleMetaDataTitle->descript;
                }
            }
        }
//Contenido a exportar
        $tableContent;
        if (isset($items) && $items != null) {
            foreach ($items as $key => $item) {
                foreach ($titleArray as $colNum => $colTitle) {
                    if (is_array($colTitle)) {
                        if (is_array($colTitle[0])) {
                            $tmpObj = '';
                            foreach ($colTitle as $colKey => $part) {
                                //dd($item->$part[0]);
                                if ($item->$part[0] != NULL) {
                                    $tmpObj .= " " . $item->$part[0]->$part[1];
                                }
                            }
                            $tableContent[$key][] = $tmpObj;
                        } else {
                            $tmpObj = ($item->$colTitle[0] != NULL) ? $item->$colTitle[0]->$colTitle[1] : '';
                            $tableContent[$key][] = $tmpObj;
                        }
                    } else {
                        if (substr($colNum, 0, 5) == 'comb_') {
                            $dataToComb = explode(".", $colTitle);
                            //dd($dataToComb);
                            $combResult = '';
                            foreach ($dataToComb as $keyComb => $valueComb) {
                                if ($item->$valueComb == NULL) {
                                    $combResult .= " ";
                                } else {
                                    $combResult .= " " . $item->$valueComb;
                                }
                            }
                            //dd($combResult);
                            $tableContent[$key][] = $combResult;
                        } else {
                            if ($item->$colTitle == NULL) {
                                $tableContent[$key][] = '';
                            } else {
                                $tableContent[$key][] = $item->$colTitle;
                            }
                        }
                    }
                }
                /*
                  if (isset($roleMetaDataTitles)) {
                  if ($roleMetaData['role'] == $exportType) {
                  foreach ($roleMetaDataTitles as $roleMetaDataTitle) {
                  if (isset($item->$roleMetaData['metaData'])) {
                  foreach ($item->$roleMetaData['metaData'] as $itemMetaData) {
                  $metaNotFound = true;
                  if ($roleMetaDataTitle->id == $itemMetaData->id) {
                  if ($itemMetaData->id != '6') {
                  $tableContent[$key][] = '1';
                  } else {
                  $tableContent[$key][] = $itemMetaData->pivot->others;
                  }
                  $metaNotFound = false;
                  break;
                  } else {
                  $metaNotFound = true;
                  }
                  }
                  if ($metaNotFound == true) {
                  $tableContent[$key][] = '';
                  }
                  } else {
                  $tableContent[$key][] = '';
                  }
                  }
                  }
                  } */
            }
//dd($tableContent);
        }

        $path = path('public') . "export" . DS;

        if (!is_dir($path))
            mkdir($path);

        $filename = $path . ((isset($defName)) ? $defName : 'model') . date('d_m_Y') . '.xls';


        $excel = new \Export\ExportDataExcel('file');
        $excel->filename = $filename;

        $excel->initialize();

        $row = array(
            "id",
            "name",
        );
//$excel->addRow($row);
        $excel->addRow($defTitle);

        /* $data[0] = array("1", "Test");
          $data[1] = array("2", "Test2"); */


        /* foreach ($data as $value) {
          $row = array(
          $value[0],
          $value[1],
          );
          $excel->addRow($row);
          } */
        foreach ($tableContent as $tableRow) {
            $row = $tableRow;
            $excel->addRow($row);
        }

        $excel->finalize();

        return Response::download($filename);
    }

    public function post_driver() {
        $reportFilter['report-0-selector-formHelper'] = "Seleccione una opción para continuar";
        $reportFilter['report-1-carselector-formHelper'] = "Placa";
        $reportFilter['report-2-carselector-formHelper'] = "Móvil de conductor";

        $formTemplate = array(
            array(
                "title" => array(
                    "Buscar por ",
                    "placa o móvil"),
                "name" => "report_filter",
                "value" => null,
                "selected" => '',
                "options" => $reportFilter,
                "type" => "select",
                "attributes" => array("class" => "chzn-select", "onchange" => "selectorPoster($(this).val())")
            ),
            array(
                "title" => array(
                    "",
                    ""),
                "type" => "blank_div",
                "attributes" => array("id" => "specific_filter")
//<input type = "text" class = "validate[required] large" value = "" name = "pay_date" id = "pay_date" tabindex = "1">
            )
        );

        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );
        $action = 'driverdetails';
        $section = 'report';

        return View::make('report.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('idToEdit', '0')
                        ->with('section', $section)
                        ->with('title', 'Reportes');
    }

    public function post_lastservices($type) {
        /*
          $reportFilter['report-0-selector-formHelper'] = "Seleccione una opción para continuar";
          $reportFilter['report-1-carselector-formHelper'] = "Placa";
          $reportFilter['report-2-carselector-formHelper'] = "Móvil de conductor";
         */
        if ($type == 1) {
            $items = Car::get();
            foreach ($items as $key => $value) {
                $options[$value->id] = $value->placa;
            }
            //$options = Driver::lists('name lastname', 'id'); //to list
            //dd($options);
            //$Selector = Form::select('specific_filter_id', $options, '', array("class" => "chzn-select"));
            $formTemplate = array(
                array(
                    "title" => array(
                        "Buscar por ",
                        "placa"),
                    "name" => "specific_filter_id",
                    "value" => null,
                    "selected" => '',
                    "options" => $options,
                    "type" => "select",
                    "attributes" => array("class" => "chzn-select")
                ),
                array(
                    "title" => array(
                        "",
                        ""),
                    "name" => "report_filter",
                    "value" => "report-1-carselector-formHelper",
                    "type" => "hidden",
                    "attributes" => array()
                )
            );
        } elseif ($type == 2) {
            $items = Car::get();
            foreach ($items as $key => $value) {
                $options[$value->id] = $value->movil;
            }
            //$options = Driver::lists('name lastname', 'id'); //to list
            //dd($options);
            //$Selector = Form::select('specific_filter_id', $options, '', array("class" => "chzn-select"));
            $formTemplate = array(
                array(
                    "title" => array(
                        "Buscar por ",
                        "Móvil"),
                    "name" => "specific_filter_id",
                    "value" => null,
                    "selected" => '',
                    "options" => $options,
                    "type" => "select",
                    "attributes" => array("class" => "chzn-select")
                ),
                array(
                    "title" => array(
                        "",
                        ""),
                    "name" => "report_filter",
                    "value" => "report-1-carselector-formHelper",
                    "type" => "hidden",
                    "attributes" => array()
                )
            );
        } else {
            $items = Driver::get();
            foreach ($items as $key => $value) {
                if ($value->movil) {
                    $options[$value->id] = "{$value->movil} {$value->name} {$value->lastname}";
                }
            }
            //$options = Driver::lists('name lastname', 'id'); //to list
            //dd($options);
            //$Selector = Form::select('specific_filter_id', $options, '', array("class" => "chzn-select"));
            $formTemplate = array(
                array(
                    "title" => array(
                        "Buscar por ",
                        "móvil de conductor"),
                    "name" => "specific_filter_id",
                    "value" => null,
                    "selected" => '',
                    "options" => $options,
                    "type" => "select",
                    "attributes" => array("class" => "chzn-select")
                ),
                array(
                    "title" => array(
                        "",
                        ""),
                    "name" => "report_filter",
                    "value" => "report-2-carselector-formHelper",
                    "type" => "hidden",
                    "attributes" => array()
                )
            );
        }


        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );
        $action = 'driverdetails';
        $section = 'report';

        return View::make('report.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('idToEdit', '0')
                        ->with('section', $section)
                        ->with('title', 'Reportes');
    }

}

