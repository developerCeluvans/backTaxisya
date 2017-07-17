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
class Department extends Eloquent {

    public static $timestamps = false;
    public static $table = 'cms_departments';

    public static $rules = array(
        'name' => 'required|min:2',
    );

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

    public function country() {
        return $this->belongs_to('Country');
    }
}

?>
