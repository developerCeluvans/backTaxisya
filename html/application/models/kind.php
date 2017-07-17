<?php

class Kind extends Eloquent {

    public static $timestamps = false;
    public static $table = 'kinds';

    public function service() {
        return $this->has_one('Service', 'kind_id');
    }

}

?>
