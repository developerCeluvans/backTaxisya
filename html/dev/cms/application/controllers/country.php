<?php

class Country_Controller extends Base_Controller {

    public $restful = true;

    public function post_index() {
        $idcusto =  Auth::user()->customer_id;
        $titleArray = array("ID" => "id", "Nombre" => "name", );
        $section = 'country';
        $manageBtns = array( 'add' => true, 'edit' => true, 'del' => true );
        return View::make($section . '.index')
                        ->with('title', 'Paises:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                         ->with('items', Country::all());
    }



    public function post_new() {
        $initialYear = date('Y') + 1;
        for ($index = 0; $index < 70; $index++) {
            $selected = "";
            $yearList[$initialYear] = $initialYear;
            $initialYear = $initialYear - 1;
        }
        $formTemplate = array(
            array(
                "title" => array("Nombre",""),
                "name" => "name",
                "value" => null,
                "type" => "text",
                "attributes" => array()
            )
        );
        $titleArray = array();
        $action = 'create';
        $section = 'country';
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
                        ->with('title', 'Nuevo país');

    }

    public function post_create() {
        $titleArray = array("NO" => "id",
            "Nombre" => "name"
        );

        $section = 'country';
            $manageBtns = array(
                'add' => true,
                'edit' => true,
                'del' => true
            );
            $newItem = Country::create(array( "name" => Input::get('name') ));
            if ($newItem) {
                $msg = 'Registro creado!';
                $type = 'success';
            } else {
                $msg = 'Error al crear registro!';
                $type = 'error';
            }
            return View::make($section . '.index')
                        ->with('title', 'Paises:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                         ->with('items', Country::all());
    }

    public function post_edit() {
        $id = Input::get('id');
        $country=Country::find($id);
        //dd($country->name);
        $action = 'update';
        $section = 'country';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        $titleArray = array("NO" => "id", "Nombre" => "name" );
        $formTemplate = array(
                array(
                    "title" => array("Nombre","del país"),
                    "name" => "name",
                    "value" => $country->name,
                    "type" => "text",
                    "attributes" => array()
                )
        );
        //return View::make( 'country.edit')->with('items', $country);
//         dd($country->name);
        return View::make('country.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('section', $section)
                        ->with('idToEdit', $id)
                        ->with('title', 'Editar País');
    }

    public function post_update() {
        $itemId = Input::get('id');

        //dd(Input::all());

        //dd(multiexplode(array('/', '-'), Input::get('pay_date')));
        //dd(Input::all());



        $itemAction = Country::update($itemId, array(
                    "name" => Input::get('name')
        ));


        if ($itemAction) {
            $msg = 'Registro actualizado!';
            $type = 'success';
        } else {
            $msg = 'Error al actualizar registro!';
            $type = 'error';
        }

        $section = 'country';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );

        // code here..
        $titleArray = array("id" => "id", "Name" => "name", );
        $section = 'country';
        $manageBtns = array( 'add' => true, 'edit' => true, 'del' => true );

        return View::make($section . '.index')
                        ->with('title', 'Paises')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('items', Country::all());

    }

    public function post_del() {
        $id = Input::get('id');
        $data = Country::find($id);

        if ($data->delete()) {
            $msg = 'Registro' . ' eliminado!';
            $type = 'success';
        } else {
            $msg = 'Error al eliminar registro!';
            $type = 'error';
        }


        $titleArray = array("id" => "id", "Name" => "name", );
        $section = 'country';
        $manageBtns = array( 'add' => true, 'edit' => true, 'del' => true );
        return View::make($section . '.index')
                        ->with('title', 'Paises:')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                         ->with('items', Country::all());

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
