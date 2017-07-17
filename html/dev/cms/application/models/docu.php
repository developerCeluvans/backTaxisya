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
class Docu extends Eloquent {

    public static $timestamps = false;
    public static $table = 'cms_documents';

    public function drivers() {
        return $this->has_many('Driver');
    }

    public static $rules = array(
        'name' => 'required|min:2',
        'image' => 'required|min:2'
    );

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

}

?>
