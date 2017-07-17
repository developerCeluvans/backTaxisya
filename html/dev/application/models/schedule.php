<?php

/**
 * Description of schedule
 *
 * @author ingJohnguerrero
 */
class Schedule extends Eloquent {

    public static $timestamps = true;
    public static $table = 'schedules';
    public $includes = array('service','service.state', 'service.driver', 'service.driver.car');

    public function user() {
        return $this->belongs_to('User');
    }

    public function driver() {
        return $this->belongs_to('Driver');
    }

    public function type() {
        return $this->belongs_to('Type', 'schedule_type');
    }

    public function service() {
        return $this->has_many('Service');
    }

}

?>
