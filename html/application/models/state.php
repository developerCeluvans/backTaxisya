<?php

class State extends Eloquent {

    public static $timestamps = false;
    public static $table = 'status';

    public function service() {
        return $this->has_one('Service', 'status_id');
    }

}

?>
