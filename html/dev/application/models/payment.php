<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author Jesica
 */
class Payment extends Eloquent {
    public static $timestamps = true;
    public static $table = 'payments';
    public static $hidden = array('pwd');
    public static $rules = array(
        'buyer_city' => 'required|min:2',
        'buyer_last_name' => 'required|min:2'
    );

    public static function debit($buyer_city, $payment_method = 0, $buyer_last_name) {
    
    
    }
}

