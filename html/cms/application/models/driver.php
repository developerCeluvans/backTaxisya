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
class Driver extends Eloquent {

    public static $timestamps = true;
    public static $table = 'drivers';
    public static $hidden = array('pwd');
    //public static $hidden = array('pwd','cms_user_id');

    public function car() {
        return $this->belongs_to('Car');
    }

    public function documents(){
      return $this->hasOne('Docu', 'driver_id');
    }

	public static function available()
    {
        return self::where('available', '=', '1');
    }

    public static $rules = array(
        'name' => 'required|min:2',
        'lastname' => 'required|min:2',
        'email' => 'required|min:2',
        'login' => 'required|min:2',
        'pwd' => 'required|min:2'
    );

    public static function validate($data) {
        return Validator::make($data, static::$rules);
    }

    /* public static function login($login, $pwd, $uuid, $App = false) {
      // $loginData = DB::query("select uuid,id from users where login='{$login}' and '{md5($pwd)}'");

      $loginData = DB::table('drivers')->where('email', '=', $login)->where('pwd', '=', $pwd)->first(array('id', 'uuid'));
      //dd($loginData);
      //return json_encode($loginData);
      if (isset($loginData)) {
      if ($loginData->uuid == $uuid) {
      return $loginData->id;
      } else {
      if ($App == false) {
      DB::table('drivers')
      ->where('id', '=', $loginData->id)
      ->update(array('uuid' => $uuid));
      return $loginData->id;
      } else {
      return false;
      }
      }
      } else {
      return null;
      }
      } */
}

?>
