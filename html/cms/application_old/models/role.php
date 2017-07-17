<?php

class Role extends Eloquent {

    public static $timestamps = true;
    public static $table = 'cms_roles';

    public function menu() {
        return $this->has_many_and_belongs_to('Menu', 'cms_menu_role', 'role_id', 'menu_id');
    }

}
