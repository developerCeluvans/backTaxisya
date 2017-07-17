<?php

class City_Controller extends Base_Controller {

    public $restful = true;

    public function post_index() {

        //dd('department');
        //dd(Department::all());
        $idcusto =  Auth::user()->customer_id;
//        $titleArray = array("id" => "id", "Name" => "name", "País" => "country_id", "Departmanto" => "department_id" );
        $titleArray = array("ID" => "id", "Nombre" => "name", "País" => array("country","name"), "Departamento" => array("department","name") );

        $section = 'city';
        $manageBtns = array( 'add' => true, 'edit' => true, 'del' => true );
        return View::make($section . '.index')
                        ->with('title', 'Ciudades:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                         ->with('items', City::all());

    }


    public function post_new() {
        $initialYear = date('Y') + 1;
        for ($index = 0; $index < 70; $index++) {
            $selected = "";
            $yearList[$initialYear] = $initialYear;
            $initialYear = $initialYear - 1;
        }
        $title_departments = Department::lists('name', 'id', 'country_id');

        $formTemplate = array(
            array(
                "title" => array("Nombre","de la ciudad"),
                "name" => "name",
                "value" => null,
                "type" => "text",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "Departamento","de la ciudad"),
                    "name" => "country_id","options" => $title_departments,
                    "selected" => null,
                    "type" => "select",
                    "attributes" => array()
            )

        );
        $titleArray = array();
        $action = 'create';
        $section = 'city';
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
                        ->with('title', 'Nueva ciudad');

    }

    public function post_create() {
        //$titleArray = array("NO" => "id", "Nombre" => "name" );
        //$titleArray = array("id" => "id", "Name" => "name", "País" => "country_id", "Departmanto" => "department_id" );
        $titleArray = array("id" => "id", "Name" => "name", "País" => array("country","name"), "Departmanto" => array("department","name") );

        $section = 'city';
        $manageBtns = array(
                'add' => true,
                'edit' => true,
                'del' => true
        );
        //dd(Input::all());
        $department =Department::find(Input::get('country_id'));
        $country_id = $department->country_id;

        $newItem = City::create(array(
                "name" => Input::get('name'),
                "department_id" => Input::get('country_id'),
                "country_id" => $country_id,
                "center_lat" => Input::get('latitude'),
                "center_lng" => Input::get('longitude')
        ));
        if ($newItem) {
                $msg = 'Registro creado!';
                $type = 'success';
        } else {
                $msg = 'Error al crear registro!';
                $type = 'error';
        }
        return View::make($section . '.index')
                        ->with('title', 'Ciudades:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                         ->with('items', City::all());

    }

    public function post_edit() {
        $id = Input::get('id');
        $city = City::find($id);
        //dd($country->name);
        $action = 'update';
        $section = 'city';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        //$title_countries = Country::lists('name', 'id');
        $title_departments = Department::lists('name', 'id', 'country_id');

//        $titleArray = array("id" => "id", "Name" => "name", "País" => "country_id", "Departmanto" => "department_id" );
        $titleArray = array("id" => "id", "Name" => "name", "País" => array("country","name"), "Departmanto" => array("department","name") );

        $formTemplate = array(
                array(
                    "title" => array("Nombre","de la ciudad"),
                    "name" => "name",
                    "value" => $city->name,
                    "type" => "text",
                    "attributes" => array()
                ),
                array(
                    "title" => array("Departamento","de la ciudad"),
                    "name" => "country_id",
                    "options" => $title_departments,
                    "selected" => null,
                    "type" => "select",
                    "attributes" => array()
                )
        );
        //return View::make( 'country.edit')->with('items', $country);
//         dd($country->name);
        return View::make('city.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('section', $section)
                        ->with('idToEdit', $id)
                        ->with('lat1', $city->latitude )
                        ->with('lng1', $city->longitude)
                        ->with('title', 'Editar Ciudad');


    }

    public function post_update() {
        // +
        $itemId = Input::get('id');

        //dd(Input::all());

        $department = Department::find(Input::get('country_id'));
        $country_id = $department->country_id;

        //dd(multiexplode(array('/', '-'), Input::get('pay_date')));
        $itemAction = City::update($itemId, array(
                    "name" => Input::get('name'),
                    "country_id" => $country_id,
                    "center_lat" => Input::get('latitude'),
                    "center_lng" => Input::get('longitude')

        ));

        //dd(Input::all());


        if ($itemAction) {
            $msg = 'Registro actualizado!';
            $type = 'success';
        } else {
            $msg = 'Error al actualizar registro!';
            $type = 'error';
        }

        $section = 'city';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );

        $idcusto =  Auth::user()->customer_id;
        $titleArray = array("id" => "id", "Name" => "name", "País" => array("country","name"), "Departmanto" => array("department","name") );

        $section = 'city';
        $manageBtns = array( 'add' => true, 'edit' => true, 'del' => true );
        return View::make($section . '.index')
                        ->with('title', 'Ciudades:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                         ->with('items', City::all());

    }

    public function post_del() {

        $id = Input::get('id');
        $data = City::find($id);

        if ($data->delete()) {
            $msg = 'Registro' . ' eliminado!';
            $type = 'success';
        } else {
            $msg = 'Error al eliminar registro!';
            $type = 'error';
        }

        dd(Input::all());

        //$titleArray = array("id" => "id", "Name" => "name", "País" => "country_id" );
        $titleArray = array("id" => "id", "Name" => "name", "País" => array("country","name"), "Departmanto" => array("department","name") );
        $section = 'city';

        $manageBtns = array( 'add' => true, 'edit' => true, 'del' => true );
        return View::make($section . '.index')
                        ->with('title', 'Ciudades')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('items', City::all());

    }

    public function post_expired() {
        $whereDate = date('Y') . "-" . date('m') . "-05";
        $whereDateMin = date('Y') . "-" . date('m') . "-01";
        $items = Car::where('pay_date', '<=', DB::RAW("DATE('" . $whereDate . "')"))
                ->where_not_between('pay_date', $whereDateMin, $whereDate)
                ->get();
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

}
