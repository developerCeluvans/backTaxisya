<?php

class AppVersion extends Eloquent {

    public static $timestamps = true;
    public static $table = 'app_versions';
    public static $hidden = array('created_at', 'updated_at');
}
