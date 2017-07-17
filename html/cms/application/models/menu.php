<?php

class Menu extends Eloquent {

    public static $timestamps = false;
    public static $table = 'cms_menu';

    public function role() {
        return $this->has_many_and_belongs_to('Role', 'cms_menu_role','menu_id','role_id');
    }

}
