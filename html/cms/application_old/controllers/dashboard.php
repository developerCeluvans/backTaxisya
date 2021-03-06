<?php

class Dashboard_Controller extends Base_Controller {

    public $restful = true;
    public $test = FALSE;

    public function __construct() {
        if ($this->test != TRUE) {
            $this->filter('before', 'auth');
        }
    }

    public function get_index() {
        //dd(Auth::user());
        /*
          ["id"]=>
          string(2) "27"
          ["name"]=>
          string(5) "admin"
          ["facebook_id"]=>
          NULL
          ["email"]=>
          string(18) "cms@imaginamos.com"
          ["role_id"]=>
          string(1) "1"
          ["pwd"]=>
          string(60) "$2a$08$BhRXfpYkKzmhHw6IiEQ9S.Rqn/tWcxZjftEr4NZSgvOlqrwkdjht6"
          ["updated_at"]=>
          string(19) "2013-06-05 15:22:23"
          ["created_at"]=>
          string(19) "2013-06-05 15:22:23"
          ["cedula"]=>
          string(10) "1234567890"
         */
        /* if (Auth::user()->role_id == 1) {
          $menu = Menu::all();
          } else {
          $userData = User::find(Auth::user()->id);
          //dd($userData->role->menu);
          $menu = $userData->role->menu;
          } */
        return View::make('dashboard.index')
                        ->with('test', $this->test)
                        ->with('title', 'Administración TaxisYa');
        //->with('menuBtns', $menu);
        //->with('username', 'John Doe');
    }

}
