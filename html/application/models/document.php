<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Driver
 *
 * @author IngJohnGuerrero
 */
class Document extends Eloquent {

    public static $timestamps = true;
    public static $table = 'cms_documents';
    public static $hidden = array('id');

    public function driver() {
        return $this->belongs_to('Driver');
    }

    public function get_payload()
    {
        $payload = array();
        $payload['driver'] = array(
            'id'                => $this->id,
            'name'              => $this->name,
            'image'             => $this->image,
            'driver'            => array(
                'name'          => $this->driver->name,
            )
        );
        return $payload;
    }

    public static $rules = array(
        'name' => 'required|min:2',
        'name' => 'required|min:2',
        'image' => 'required|min:2',
        'driver_id' => 'required|min:2'
    );

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

}

?>
