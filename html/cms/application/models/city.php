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
class City extends Eloquent {

    public static $timestamps = false;
    public static $table = 'cms_cities';

    public static $rules = array(
        'name' => 'required|min:2',
    );

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

    public function department() {
        return $this->belongs_to('Department');
    }

    public function country() {
        return $this->belongs_to('Country');
    }

}

?>
