<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Address controller
 *
 * @author IngJohnGuerrero
 */
class Address_Controller extends Base_Controller {

    public $restful = true;

    public function get_index() {
        //return View::make('address.index');
        return View::make('address.index')
                        ->with('title', 'Direcciones actuales')
                        ->with('direcciones', Address::order_by('id')->get());
//        $view = View::make('address.index', array('name' => 'John'))->with('age', '28');
//        $view->location = 'California'; //dont work
//        $view['specialty'] = 'PHP'; //dont work
//        return Response::json($Direccion->to_array());
    }

    public function get_view($id) {
        return View::make('address.view')
                        ->with('title', 'Direccion')
                        ->with('address', Address::find($id));
    }

    public function get_new($usrId) {
        return View::make('address.new')
                        ->with('title', 'nueva Direccion')
                        ->with('user', User::find($usrId));
    }

    public function post_create() {
        // $validation = Address::validate(Input::all());
        // dd($validation);
        // if ($validation->fails()) {
        //     return Redirect::to_route('new_address')->with_errors($validation)->with_input();
        // } else {
            $new_address = Address::create(array(
                'index_id' => NULL,
                'comp1' => NULL,
                'comp2' => NULL,
                'no' => NULL,
                'barrio' => Input::get('barrio'),
                'obs' => Input::get('obs'),
                'user_id' => Input::get('user_id'),
                'user_pref_order' => Input::get('user_pref_order'),
                'name' => Input::get('nombre'),
                'address' => Input::get('address'),
                'lat' => Input::get('lat'),
                'lng' => Input::get('lng')
            ));
            //return Redirect::to_route('address')->with('message', 'Direccion ' . input::get('name') . ' creado!');
            //dd($new_address);
            if ($new_address) {
                $defUsrAddress['error'] = '1';
            } else {
                $defUsrAddress['error'] = '0';
            }
            return Response::json($defUsrAddress);

        // }
    }

    public function post_register() {
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
                    'user_pref_order' => '0',
                    'name' => '',
                    'address' => '',
                    'lat' => 0,
                    'lng' => 0

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
                    'user_pref_order' => '0',
                    'name' => '',
                    'address' => '',
                    'lat' => 0,
                    'lng' => 0
                ));
                //return direcciones de Direccion
                //return Address::getUsrAddresses(Input::get('user_id'));
            }
        }
        return Response::eloquent(Address::where('user_id', '=', Input::get('user_id'))->get());
    }

    public function get_edit($id) {
        return View::make('address.edit')
                        ->with('title', 'Edit address')
                        ->with('address', Address::find($id));
    }

    public function put_update() {
        $id = Input::get('id');
        Address::update($id, array(
        ));
        return Redirect::to_route('address', $id)->with('message', 'Direccion actualizado');
    }

    public function post_byuser() {
        //dd(Input::get('user_id'));
        //return json_encode(Address::getUsrAddresses(Input::get('user_id')));
        if (Input::has('user_id')) {
            $usrAddress = Address::where('user_id', '=', Input::get('user_id'))->get();
        } else {
            $data = Input::json();
            $user_id = $data->user_id;
            $usrAddress = Address::where('user_id', '=', $user_id)->get();
        }
        //dd($usrAddress);
        if (count($usrAddress) > 0) {
            $defUsrAddress['error'] = '0';
            $i = 1;
            foreach ($usrAddress as $key => $value) {
                $defUsrAddress['address'][] = $value->to_array();
                $i++;
            }
        } else {
            $defUsrAddress['error'] = '1';
        }
        //dd($defUsrAddress);
        return Response::json($defUsrAddress);
        //return Response::eloquent(Address::where('user_id', '=', Input::get('user_id'))->get());
    }

    public function post_delete() {
        // delete direccion especifi
        $id = Input::get('address_id');
        $data = Address::find($id);
        if ($data->delete()) {
            $defUsrAddress['error'] = '1';
        } else {
            $defUsrAddress['error'] = '0';
        }
        return Response::json($defUsrAddress);
    }

}

?>
