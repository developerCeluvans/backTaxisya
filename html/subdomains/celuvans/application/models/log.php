<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of log
 *
 * @author IngJohnGuerrero
 */
class Log extends Eloquent{
    public static $timestamps = true;
    public static $table = 'drivers';
    public function service()
     {
          return $this->belongs_to('Service');
     }
}
?>
