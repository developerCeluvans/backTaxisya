<?php

/**
 * Description of Service Controller
 *
 * @author IngJohnGuerrero
 */
class Complain_Controller extends Base_Controller {

    public $restful = true;

    public function post_index() {
        // get customer id
        $customer_id = Auth::user()->customer_id;
        $query = "select * from cities_customers  where customer_id = ".$customer_id. ";";
        $result2 = DB::query($query);
        $city_id = $result2[0]->city_id;
        // TODO: modificar la consulta paa aplicar el filtro (solo reclamos de la ciudad del cliente)
        $complainedServices = DB::query('SELECT
                            serv.id
                            FROM
                            services serv
                            inner join complains comp on comp.service_id=serv.id
                            group by (serv.id)
                            ORDER BY comp.answered ASC, serv.updated_at ASC'); //ORDER BY comp.answered ASC, serv.updated_at ASC');
        $complainedServicesDef = Array();
	foreach ($complainedServices as $key => $complainedService) {
            $complainedServicesDef[] = Service::find($complainedService->id);
        }
        $titleArray = array("N°" => "id",
            "Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
            "Tel. Usuario" => array("user", "telephone"),
            "Cel. Usuario" => array("user", "cellphone"),
            //"Apell. Usuario" => array("user", "lastname"),
            "Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
            "Vehículo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
            //"latitud" => "from_lat",
            //"longitud" => "from_lng",
            //"Estado" => "status_id",
            "Estado" => array("state", "descrip"),
            "Solicitud" => "created_at",
            "Finalización" => "updated_at",
            "Calificación" => array("score", "descrip"), //"qualification",
            "comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs"
                /* "Prefijo" => "index_id",
                  "Num1" => "comp1",
                  "Num2" => "comp2",
                  "No." => "no",
                  "Barrio" => "barrio",
                  "Obs." => "obs" */
        );
        return View::make('complain.list')
                        ->with('title', 'Servicios actuales')
                        ->with('titles', $titleArray)
                        ->with('tablesorting', '"aaSorting": [[11,"desc"],[8,"desc"]],')//[9,"asc"],[12,"desc"]//[10,"desc"],[7,"asc"]
                        ->with('items', $complainedServicesDef);
    }

    public function action_create() {
        $id = Input::get('service_id');
        $descript = Input::get('descript');

        $result = Complain::create(
                        array(
                            'service_id' => $id,
                            'descript' => $descript
                        )
        );
        if (isset($result)) {
            return Response::json(array('error' => '0'));
        } else {
            return Response::json(array('error' => '1'));
        }
    }

    public function post_description() {
        $id = Input::get('id');
        $complain = Complain::find($id);
        //return Response::eloquent($complain);
        $response = "
            <script type=\"text/javascript\">
            $(\"#complain_descript\").val(\"" . $complain->descript . "\");
            </script>
            ";
        return $response;
    }

    //{{$section}}-{{$idToEdit}}-{{$action}}-formHelper
    public function post_answer() {
        $id = Input::get('id');
        $item = Service::find($id);
        if (!$item->complains) {
            //return View::make('service.index');
            $titleArray = array("NO" => "id",
                "Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
                "Tel. Usuario" => array("user", "telephone"),
                "Cel. Usuario" => array("user", "cellphone"),
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
                      "Obs." => "obs" */                    );
            return View::make('service.index')
                            ->with('title', 'Servicios actuales')
                            ->with('titles', $titleArray)
                            ->with('items', Service::with('state')->with('complains')->with('user')->all());
        }
        foreach ($item->complains as $key => $complain) {
            if ($complain->answered === '0') {
                $defOptions['complain-' . $complain->id . "-description-formHelper"] = $complain->created_at;
            }
        }
        $formTemplate = array(
            array(
                "title" => array(
                    "Fecha",
                    "del servicio"),
                "name" => "serv_date",
                "value" => $item->updated_at,
                "type" => "text",
                "attributes" => array("readonly")
            ),
            array(
                "title" => array(
                    "Dirección",
                    "de usuario"),
                "name" => "user_dir",
                "value" => $item->index_id . " " . $item->comp1 . " " . $item->comp2 . " " . $item->no,
                "type" => "text",
                "attributes" => array("readonly")
            ),
            array(
                "title" => array(
                    "Barrio",
                    "de servicio"),
                "name" => "address_neig",
                "value" => $item->barrio,
                "type" => "email",
                "attributes" => array("readonly")
            ),
            array(
                "title" => array(
                    "Observación",
                    "de servicio"),
                "name" => "address_obs",
                "value" => $item->obs,
                "type" => "email",
                "attributes" => array("readonly")
            ),
            array(
                "title" => array(
                    "Fecha de queja",
                    "sobre servicio"),
                "name" => "complain_id",
                "options" => $defOptions,
                "selected" => current($defOptions),
                "type" => "select",
                "attributes" => array("onchange" => "selectorPoster($(this).val())")
            ),
            array(
                "title" => array(
                    "Descripción",
                    "de la queja"),
                "name" => "complain_descript",
                "value" => null,
                "type" => "textarea",
                "attributes" => array("id" => "complain_descript", 'readonly')
            ),
            array(
                "title" => array(
                    "Respuesta",
                    "a la queja"),
                "name" => "complain_answer",
                "value" => null,
                "type" => "textarea",
                "attributes" => array("id" => "complain_answer")
            )
        );
        $onStart = "selectorPoster($('select[name=\"complain_id\"]').val());";
        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );
        $action = 'answered';
        $section = 'complain';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        return View::make($section . '.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('onStart', $onStart)
                        ->with('formTemplate', $formTemplate)
                        ->with('idToEdit', $id)
                        ->with('section', $section)
                        ->with('title', 'Responder queja');
    }

    public function post_answered() {
        $itemId = Input::get('id');
        $item = Service::find($itemId);
        $complainAjaxData = explode("-", Input::get('complain_id'));
        $complainId = $complainAjaxData[1];
        //complain-2-description-formHelper
        //dd($complainAjaxData);
        $itemAction = Complain::update($complainId, array(
                    "answered" => '1',
                    "answer" => Input::get('complain_answer')
        ));
        if ($itemAction) {
            $msg = 'Registro actualizado!';
            $type = 'success';
            /*
            * Se agrega para el envio de correo. 
            */ 
            try{ 
                $complain = Complain::find($complainId)->with('service');
                //dd($complain->service->user);
                //exit();
                /*$msg = "<h1>Bienvenid@ a la comunidad taxisya</h1>
                <p>Para ingresar a la aplicación:</p><br>
                <p>Utilice el correo: " . Input::get('email') . "</p><br>
                <p>Su contraseña es:" . Input::get('pwd') . "</p><br>
                <p>Atentamente,</p><br>
                <p>TaxisYa</p><br>
                ";*/
                $msg = Input::get('complain_answer');

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
                    $mailer->AddAddress($complain->service->user->email, $complain->service->user->name . ' ' .$complain->service->user->lastname);
                    $mailer->Subject = "Queja o reclamo a taxisYa respondido";
                    $mailer->Body = $msg;
                    $mailer->IsHTML(true);
                    $mailer->Send();
                } catch (Exception $e) {
                    echo 'Message was not sent.';
                    echo 'Mailer error: ' . $e->getMessage();
                    sleep(60);
                }
            }catch(Exception $e){
                dd($e);
                sleep(60);
            } 


            


        } else {
            $msg = 'Error al actualizar registro!';
            $type = 'error';
        }
        $itemId = Input::get('id');
        $item = Service::find($itemId);
        //dd($item->complains);
        $pendingComplains = false;
        if ($item->complains) {
            foreach ($item->complains as $complain) {
                if ($complain->answered === 0) {
                    $pendingComplains = TRUE;
                    break;
                }
            }
        }
        if ($pendingComplains === false) {
            //return View::make('service.index');
            /*
            $titleArray = array("NO" => "id",
                "Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
                "Tel. Usuario" => array("user", "telephone"),
                "Cel. Usuario" => array("user", "cellphone"),
                //"Apell. Usuario" => array("user", "lastname"),
                "Conductor" => array(array("driver", "name"), array("driver", "lastname")), //array("driver", "name"), //"driver_id",
                "Vehiculo" => array(array("car", "placa"), array("car", "car_brand"), array("car", "model")), //"car_id",
                "latitud" => "from_lat",
                "longitud" => "from_lng",
                //"Estado" => "status_id",
                "Estado" => array("state", "descrip"),
                "Solicitud" => "created_at",
                "Finalización" => "updated_at",
                "Calificacion" => array("score", "descrip"), //"qualification",
                "comb_Dirección" => "index_id.comp1.comp2.no.barrio.obs"
                      //"Prefijo" => "index_id",
                      //"Num1" => "comp1",
                      //"Num2" => "comp2",
                      //"No." => "no",
                      //"Barrio" => "barrio",
                      //"Obs." => "obs"
                      );*/
            /*
            return View::make('service.index')
                            ->with('title', 'Servicios actuales')
                            ->with('titles', $titleArray)
                            ->with('items', Service::with('state')->with('complains')->with('user')->all());
                            */
            $complainedServices = DB::query('SELECT
                            serv.id
                            FROM
                            services serv
                            inner join complains comp on comp.service_id=serv.id
                            group by (serv.id)
                            ORDER BY comp.answered ASC, serv.updated_at ASC'); //ORDER BY comp.answered ASC, serv.updated_at ASC');
            $complainedServicesDef = Array();
                foreach ($complainedServices as $key => $complainedService) {
                        $complainedServicesDef[] = Service::find($complainedService->id);
                    }
                    $titleArray = array("NO" => "id",
                        "Nomb. Usuario" => array(array("user", "name"), array("user", "lastname")),
                        "Tel. Usuario" => array("user", "telephone"),
                        "Cel. Usuario" => array("user", "cellphone"),
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
                    return View::make('complain.list')
                                    ->with('title', 'Servicios actuales')
                                    ->with('titles', $titleArray)
                                    ->with('tablesorting', '"aaSorting": [[11,"desc"],[8,"desc"]],')//[9,"asc"],[12,"desc"]//[10,"desc"],[7,"asc"]
                                    ->with('items', $complainedServicesDef);
        } else {
            //dd($item->complains);
            $id = Input::get('id');
            $item = Service::find($id);
            foreach ($item->complains as $key => $complain) {
                if ($complain->answered === '0') {
                    $defOptions['complain-' . $complain->id . "-description-formHelper"] = $complain->created_at;
                }
            }
            $formTemplate = array(
                array(
                    "title" => array(
                        "Fecha",
                        "del servicio"),
                    "name" => "serv_date",
                    "value" => $item->updated_at,
                    "type" => "text",
                    "attributes" => array("readonly")
                ),
                array(
                    "title" => array(
                        "Dirección",
                        "de usuario"),
                    "name" => "user_dir",
                    "value" => $item->index_id . " " . $item->comp1 . " " . $item->comp2 . " " . $item->no,
                    "type" => "text",
                    "attributes" => array("readonly")
                ),
                array(
                    "title" => array(
                        "Barrio",
                        "de servicio"),
                    "name" => "address_neig",
                    "value" => $item->barrio,
                    "type" => "email",
                    "attributes" => array("readonly")
                ),
                array(
                    "title" => array(
                        "Observación",
                        "de servicio"),
                    "name" => "address_obs",
                    "value" => $item->obs,
                    "type" => "email",
                    "attributes" => array("readonly")
                ),
                array(
                    "title" => array(
                        "Fecha de queja",
                        "sobre servicio"),
                    "name" => "complain_id",
                    "options" => $defOptions,
                    "selected" => current($defOptions),
                    "type" => "select",
                    "attributes" => array("onchange" => "selectorPoster($(this).val())")
                ),
                array(
                    "title" => array(
                        "Descripción",
                        "de la queja"),
                    "name" => "complain_descript",
                    "value" => $item->complains[0]->descript,
                    "type" => "textarea",
                    "attributes" => array("id" => "complain_descript", 'readonly')
                ),
                array(
                    "title" => array(
                        "Respuesta",
                        "a la queja"),
                    "name" => "complain_answer",
                    "value" => null,
                    "type" => "textarea",
                    "attributes" => array("id" => "complain_answer")
                )
            );
            $titleArray = array("NO" => "id",
                "Nombre" => "name",
                "Correo electrónico" => "email"
            );
            $onStart = "selectorPoster($('select[name=\"complain_id\"]').val());";
            $action = 'answered';
            $section = 'complain';
            $manageBtns = array(
                'add' => true,
                'edit' => true,
                'del' => true
            );
            return View::make($section . '.form')
                            ->with('titles', $titleArray)
                            ->with('action', $action)
                            ->with('formTemplate', $formTemplate)
                            ->with('message', $msg)
                            ->with('result', $type)
                            ->with('onStart', $onStart)
                            ->with('idToEdit', $id)
                            ->with('section', $section)
                            ->with('title', 'Responder queja');
        }
    }

    public function post_log() {
        $id = Input::get('id');
        // code here..
        //return View::make('user.index');
        $titleArray = array(//"NO" => "id",
            "Descripción" => "descript",
            //"answered" => "answered",
            "answer" => "answer",
            "Fecha de respuesta" => "updated_at"
        );
        $section = 'car';
        $manageBtns = array(
            'add' => false,
            'edit' => false,
            'del' => false
        );
        $headerContent = Service::find($id);

        return View::make($section . '.index')
                        ->with('title', 'Respuestas enviadas')
                        ->with('titles', $titleArray)
                        ->with('headerContent', $headerContent)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('items', Complain::where('service_id', '=', $id)->where('answered', '=', '1')->get());
    }

}

?>
