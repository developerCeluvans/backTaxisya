<?php

class Customer extends Eloquent {

    public static $timestamps = true;
    public static $table = 'cms_users';

    public function role() {
        return $this->belongs_to('Role');
    }

}
