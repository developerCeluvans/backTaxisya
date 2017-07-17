<?php

class Score extends Eloquent {

    public static $timestamps = false;
    public static $table = 'score';

    public function service() {
        return $this->has_one('Service', 'qualification');
    }

}

?>
