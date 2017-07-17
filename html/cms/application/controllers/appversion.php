<?php

class AppVersion_Controller extends Base_Controller {

	public $restful = true;

	public function post_index() {

		$pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        $section = strtolower($pieces[0]);
        /*$section = "service";
        $objName = "Service";*/
        //return View::make('service.index');
        $titleArray = array("N°" => "id",
            "Versión" => "version",
            "Tipo" => "device_type",
            //"Creada" => "created_at",
            "Fecha Modificación" => "updated_at",
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE,
            //'export' => TRUE,
            'total' => TRUE,
            'custom' => array(
            ),
            'tabs' => array("options" => array(
                    array("id" => "1",
                        "description" => "Usuarios"
                    ),
                    array(
                        "id" => "2",
                        "description" => "Taxistas"
                    )
                ),
                "tabber" => "version_type_id"
            )
        );
        return View::make('cms.index')
                        ->with('title', 'Versiones: ')
                        ->with('titles', $titleArray)
                        ->with('message', false)
                        ->with('result', false)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
                        ->with('items', $objName::order_by('updated_at', 'DESC')->get());
	}

	public function post_edit() {
        $id = Input::get('id');
        $item = AppVersion::find($id);
        
        $formTemplate = array(
            array(
                "title" => array(
                    "Versión",
                    "aplicación"),
                "name" => "version",
                "value" => $item->version,
                "type" => "text",
                "attributes" => array()
            )
        );
        $titleArray = array();
        $action = 'update';
        $pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        $section = strtolower($pieces[0]);

        return View::make('cms.form')//($section . '.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('idToEdit', $id)
                        ->with('section', $section)
                        ->with('title', 'Editar vehículo');
    }

    public function post_update() {
    	$itemId = Input::get('id');
        
        $itemAction = AppVersion::update($itemId, array(
                    "version" => Input::get('version')
        ));
        if ($itemAction) {
            $msg = 'Registro actualizado!';
            $type = 'success';
            //dd(Notifier::update_available_user(true, "Actualización disponible", array('version' => Input::get('version'))));
            /*
            switch ($itemId) {
                case 1:
                    try{
                        Notifier::update_available_user(true, "Actualización disponible");
                    }catch(Exception $e){
        
                    }
                    break;
                case 2:
                    try{
                        Notifier::update_available_user(false, "Actualización disponible");
                    }catch(Exception $e){
        
                    }
                    break;
                case 3:
                    try{
                        Notifier::update_available_driver("Actualización disponible");
                    }catch(Exception $e){
        
                    }
                    break;
                
                default:
                    # code...
                    break;
            }*/
            
        } else {
            $msg = 'Error al actualizar registro!';
            $type = 'error';
        }

        $pieces = explode("_", get_class($this));
        $objName = $pieces[0];
        $section = strtolower($pieces[0]);
        /*$section = "service";
        $objName = "Service";*/
        //return View::make('service.index');
        $titleArray = array("NO" => "id",
            "Versión" => "version",
            "Tipo" => "device_type",
            //"Creada" => "created_at",
            "F.Modificación" => "updated_at",
        );
        $manageBtns = array(
            'add' => FALSE,
            'edit' => TRUE,
            'del' => FALSE,
            //'export' => TRUE,
            'total' => TRUE,
            'custom' => array(
            ),
            'tabs' => array("options" => array(
                    array("id" => "1",
                        "description" => "Usuarios"
                    ),
                    array(
                        "id" => "2",
                        "description" => "Taxistas"
                    )
                ),
                "tabber" => "version_type_id"
            )
        );
        return View::make('cms.index')
                        ->with('title', 'Versiones: ')
                        ->with('titles', $titleArray)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('manageBtns', $manageBtns)
                        ->with('section', $section)
                        ->with('items', $objName::order_by('updated_at', 'DESC')->get());
        
    }

}