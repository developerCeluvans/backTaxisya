<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Address
 *
 * @author IngJohnGuerrero
 */
class Address extends Eloquent {

    public static $timestamps = false;
    public static $table = 'users_dirs';

    public function index() {
        return $this->has_one('dir_indexes', 'index_id');
    }
    // en Mysql se altero la tabla de forma manual pues no se mantuvo la table de migracion de laravel
    // ALTER TABLE users_dirs ADD name VARCHAR(30);

    public static $rules = array(
        'id' => 'required|min:2',
        'index_id' => 'required|min:2',
        'comp1' => 'required|min:2',
        'comp2' => 'required|min:2',
        'no' => 'required|min:2',
        'barrio' => 'required|min:2',
        'obs' => 'required|min:2',
        'user_id' => 'required|min:2',
        'user_pref_order' => 'required|min:2',
        'nombre' => 'required|min:2'
    );

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

    public static function getUsrAddresses($id) {
       //$usrAddress = Address::where('user_id', '=', $id);
       return Response::eloquent(Address::where('user_id', '=', $id)->get());
    }

}

?>
