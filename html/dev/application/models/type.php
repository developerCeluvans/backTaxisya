<?php

class Type extends Eloquent {

    public static $timestamps = false;
    public static $table = 'schedule_types';

    public function schedule() {
        return $this->has_one('Schedule', 'schedule_type');
    }

}
?>
