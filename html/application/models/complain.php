<?php

/**
 * Modelo de Quejas y reclamos
 *
 * @author IngJohnGuerrero
 */
class Complain extends Eloquent {

    //public static $timestamps = false;
    public static $table = 'complains';

    public function service() {
        return $this->belongs_to('Service');
    }

}

?>
