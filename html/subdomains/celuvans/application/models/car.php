<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Car
 *
 * @author IngJohnGuerrero
 */
class Car extends Eloquent {

    public $includes = array('drivers');
    public static $timestamps = false;
    public static $table = 'cars';

    public function drivers() {
        return $this->has_many('Driver');
    }

    public static $rules = array(
        'placa' => 'required|min:2',
        'car_brand' => 'required|min:2'
    );

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

}

?>
