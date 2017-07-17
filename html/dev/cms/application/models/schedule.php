<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of schedule
 *
 * @author ingJohnguerrero
 */
class Schedule extends Eloquent {

    public static $timestamps = true;

    //public static $table = 'schedules';
    public function user() {
        return $this->belongs_to('User');
    }

    public function driver() {
        return $this->belongs_to('Driver');
    }

    public function type() {
        return $this->belongs_to('Type', 'schedule_type');
    }

    public function score() {
        return $this->belongs_to('Score', 'qualification');
    }
	
	
    
    /*
     public function state() {
        return $this->belongs_to('Score', 'qualification');
    }
     */

}

?>
