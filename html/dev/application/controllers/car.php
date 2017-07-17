<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Car Controller
 *
 * @author IngJohnGuerrero
 */
class Car_Controller extends Base_Controller {

    
    public $restful = true;

    public function get_index() {
        //return View::make('car.index');
        return View::make('car.index')
                        ->with('title', 'Vehiculos actuales')
                        ->with('carros', Car::order_by('id')->get());
        //        $view = View::make('car.index', array('name' => 'John'))->with('age', '28');
        //        $view->location = 'California'; //dont work
        //        $view['specialty'] = 'PHP'; //dont work
        //        return Response::json($usuario->to_array());
    }

    public function get_view($id) {
        return View::make('car.view')
                        ->with('title', 'Carro')
                        ->with('car', Car::find($id));
    }

    public function get_new() {
        return View::make('car.new')
                        ->with('title', 'nuevo Vehiculo');
    }

    public function post_create() {
        $validation = Car::validate(Input::all());
        if ($validation->fails()) {
            return Redirect::to_route('new_car')->with_errors($validation)->with_input();
        } else {
            Car::create(array(
                'placa' => Input::get('placa'),
                'car_brand' => Input::get('car_brand')
            ));
            return Redirect::to_route('car')->with('message', 'Vehiculo ' . input::get('placa') . ' creado!');
        }
    }

    public function post_register() {
        Car::create(array(
            'placa' => Input::get('placa'),
            'car_brand' => Input::get('car_brand')
        ));
    }

    public function get_edit($id) {
        return View::make('car.edit')
                        ->with('title', 'Edit car')
                        ->with('car', Car::find($id));
    }

    public function put_update() {
        $id = Input::get('id');
        //$validation = Car::validate(Input::all());
        //        $validation = Car::validate(Input::get('name'));
        //        $validation1 = Car::validate(Input::get('lastname'));
        //        $validation2 = Car::validate(Input::get('email'));
        //        $validation3 = Car::validate(Input::get('login'));
        //        if ($validation->fails() || $validation1->fails() || $validation2->fails() || $validation3->fails()) {
        //            return Redirect::to_route('edit_car', $id)->with_errors($validation);
        //        } else {
        Car::update($id, array(
            'placa' => Input::get('placa'),
            'car_brand' => Input::get('car_brand')
        ));
        return Redirect::to_route('car', $id)->with('message', 'Vehiculo actualizado');
        //        }
    }

}

?>
