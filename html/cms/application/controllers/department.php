<?php

class Department_Controller extends Base_Controller {

    public $restful = true;

    public function post_index() {

        //dd('department');
        //dd(Department::all());
        $idcusto =  Auth::user()->customer_id;
//        $titleArray = array("id" => "id", "Name" => "name", "Country" => "country_id" );
        $titleArray = array("ID" => "id", "Nombre" => "name", "País" => array("country","name") );

        $section = 'department';
        $manageBtns = array( 'add' => true, 'edit' => true, 'del' => true );
        return View::make($section . '.index')
                        ->with('title', 'Departamentos:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                         ->with('items', Department::all());
    }


    public function post_new() {
        $initialYear = date('Y') + 1;
        for ($index = 0; $index < 70; $index++) {
            $selected = "";
            $yearList[$initialYear] = $initialYear;
            $initialYear = $initialYear - 1;
        }
        $title_countries = Country::lists('name', 'id');
        $formTemplate = array(
            array(
                "title" => array("Nombre","del Departamento"),
                "name" => "name",
                "value" => null,
                "type" => "text",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "País","del departamento"),
                    "name" => "country_id","options" => $title_countries,
                    "selected" => null,
                    "type" => "select",
                    "attributes" => array()
            )

        );
        $titleArray = array();
        $action = 'create';
        $section = 'department';
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
                        ->with('title', 'Nuevo departamento');

    }

    public function post_create() {
        //$titleArray = array("NO" => "id", "Nombre" => "name" );
        //$titleArray = array("id" => "id", "Name" => "name", "País" => "country_id" );
        $titleArray = array("id" => "id", "Name" => "name", "País" => array("country","name") );


        $section = 'department';
        $manageBtns = array(
                'add' => true,
                'edit' => true,
                'del' => true
        );
        $newItem = Department::create(array(
                "name" => Input::get('name'),
                "country_id" => Input::get('country_id')
        ));
        if ($newItem) {
                $msg = 'Registro creado!';
                $type = 'success';
        } else {
                $msg = 'Error al crear registro!';
                $type = 'error';
        }
        return View::make($section . '.index')
                        ->with('title', 'Departamentos:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                         ->with('items', Department::all());

    }

    public function post_edit() {
        $id = Input::get('id');
        $country=Department::find($id);
        //dd($country->name);
        $action = 'update';
        $section = 'department';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        $title_countries = Country::lists('name', 'id');
        //$titleArray = array("NO" => "id", "Nombre" => "name" , "Country" => "country_id" );
        $titleArray = array("id" => "id", "Name" => "name", "País" => array("country","name") );

        $formTemplate = array(
                array(
                    "title" => array("Nombre","del país"),
                    "name" => "name",
                    "value" => $country->name,
                    "type" => "text",
                    "attributes" => array()
                ),
                array(
                    "title" => array("País","del departamento"),
                    "name" => "country_id",
                    "options" => $title_countries,
                    "selected" => null,
                    "type" => "select",
                    "attributes" => array()
                )
        );
        //return View::make( 'country.edit')->with('items', $country);
//         dd($country->name);
        return View::make('department.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('section', $section)
                        ->with('idToEdit', $id)
                        ->with('title', 'Editar Departamento');


    }

    public function post_update() {
        // +
        $itemId = Input::get('id');

        //dd(Input::all());

        //dd(multiexplode(array('/', '-'), Input::get('pay_date')));
        //dd(Input::all());
        $itemAction = Department::update($itemId, array(
                    "name" => Input::get('name'),
                    "country_id" => Input::get('country_id')
        ));



        if ($itemAction) {
            $msg = 'Registro actualizado!';
            $type = 'success';
        } else {
            $msg = 'Error al actualizar registro!';
            $type = 'error';
        }

        $section = 'department';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );

        // code here..
        //$titleArray = array("id" => "id", "Name" => "name", "País" => "country_id" );
        $titleArray = array("id" => "id", "Name" => "name", "País" => array("country","name") );

        $section = 'department';
        $manageBtns = array( 'add' => true, 'edit' => true, 'del' => true );

        return View::make($section . '.index')
                        ->with('title', 'Departmentos')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('items', Department::all());
        // -
    }

    public function post_del() {
        $id = Input::get('id');
        $data = Department::find($id);

        if ($data->delete()) {
            $msg = 'Registro' . ' eliminado!';
            $type = 'success';
        } else {
            $msg = 'Error al eliminar registro!';
            $type = 'error';
        }


        //$titleArray = array("id" => "id", "Name" => "name", "País" => "country_id" );
        $titleArray = array("id" => "id", "Name" => "name", "País" => array("country","name") );

        $section = 'department';

        $manageBtns = array( 'add' => true, 'edit' => true, 'del' => true );
        return View::make($section . '.index')
                        ->with('title', 'Departmentos')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('items', Department::all());

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
