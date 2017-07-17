<?php

class Administrator_Controller extends Base_Controller
{

    public $restful = true;

    public function post_index()
    {

        // code here..
        //return View::make('user.index');
        $titleArray = array("N°" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );
        $section = 'administrator';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );

        // test +;
        //dd( Auth::user()->role_id );
        // dd( Auth::user()->id );
        //dd( Auth::user()->customer_id );
        $array_cities = null;
        $title = 'Administradores actuales';
        $parrafo = '';
        if (Auth::user()->role_id == 5) {
            $title = 'Administrador de clientes actuales';
            $parrafo = 'Podrá agregar, eliminar, editar y buscar administradores y operadores';
            $title_roles1 = Role::where('id', '=', '2')->get();
            $title_roles2 = Role::where('id', '=', '3')->get();
            //$title_roles = Role::where('id', '=', '2')->get();
            $title_roles = array_merge($title_roles1, $title_roles2);
            $title_add = array('Agregar administrador','Agregar operadora');
            $title_find = array('Buscar administrador','Buscar operadora');
            //$array_users = Administrator::with('role')->all();
            $array_users = Administrator::with('role')->where('customer_id', '=', Auth::user()->id)->get();
        } else if (Auth::user()->role_id == 4) {
            $title = 'Clientes actuales';
            $parrafo = ' Podrá eliminar o editar clientes actuales y agregar nuevos clientes a la base de datos.';
            $title_roles = Role::where('id', '=', '5')->get();
            //$array_users = Administrator::with('role')->all();
            $array_users = Administrator::with('role')->where('role_id', '=', '5')->get();
            $title_add = array('Agregar cliente');
            $title_find = array('Buscar cliente');
            //$array_cities = City::all();
            //dd($array_cities);
        } else if (Auth::user()->role_id == 2) {
            $title = 'Operadores del Cliente';
            $parrafo = ' Podrá buscar, agregar, modificar y eliminar los operadores.';
            $title_roles = Role::where('id', '=', '3')->get();
            $title_add = array('Agregar operadora');
            $title_find = array('Buscar operadora');
            //$array_users = Administrator::with('role')->all();
            $array_users = Administrator::with('role')->where('role_id', '=', '3')->where('customer_id', '=', Auth::user()->customer_id)->get();

            //dd($array_users);

        } else if (Auth::user()->role_id == 1) {
            $title = 'Clientes actuales';
            $title_roles = Role::all();
            $array_users = Administrator::with('role')->all();
            $title_add = array('Agregar cliente');
            $title_find = array('Buscar cliente');

        } else {
            $title_roles = Role::all();
            $title_add = array('Agregar cliente');
            $title_find = array('Buscar cliente');
        }
        //dd(sizeof($title_add));
        //exit();
        // test city
        return View::make('administrator.index')
            ->with('title', $title)
            ->with('titles', $titleArray)
            ->with('section', $section)
            ->with('manageBtns', $manageBtns)
            ->with('roles', $title_roles)
            ->with('items', $array_users)
            ->with('findArray', $title_find)
            ->with('addArray', $title_add)
            ->with('parrafo',$parrafo)
            ->with('cities', $array_cities);
        // test -
    }

    public function post_login()
    {
        // get POST data

        $userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );
        if (Auth::attempt($userdata)) {
// we are now logged in, go to home
            return Redirect::to('dashboard');
        } else {
// auth failure! lets go back to the login
            return Redirect::to('/')
                ->with('login_errors', true);
// pass any error notification you want
// i like to do it this way :)
        }
    }

    public function post_new()
    {
        // code here..
        // determine role
        $array_cities = array();
        if (Auth::user()->role_id == 5) {
            $array_cities = City::all();
            $title_roles1 = Role::where('id', '=', '2')->lists('type', 'id');
            $title_roles2 = Role::where('id', '=', '3')->lists('type', 'id');
            //$title_roles = array_merge($title_roles1, $title_roles2);
            $title_roles = $title_roles1 + $title_roles2;

            $title_cities = City::lists('name', 'id', 'country_id');
            //dd($title_roles);
        } else if (Auth::user()->role_id == 4) {
            $title_roles = Role::where('id', '=', '5')->lists('type', 'id');
            $array_cities = City::all();
            $title_cities = City::lists('name', 'id', 'country_id');

        } else if (Auth::user()->role_id == 2) {
            $title_roles = Role::where('id', '=', '3')->lists('type', 'id');
        } else if (Auth::user()->role_id == 1) {
            $title_roles = Role::lists('type', 'id');
        } else {
            $title_roles = Role::lists('type', 'id');
        }

        //dd($title_roles);
        //dd($title_cities);
        //dd(Auth::user()->role_id);

        if (Auth::user()->role_id == 4) {
            $formTemplate = array(
                array(
                    "title" => array("Nombre", "de usuario"), "name" => "user_name", "value" => null, "type" => "text", "attributes" => array()
                ),
                array(
                    "title" => array("Documento", "de usuario"), "name" => "user_doc", "value" => null, "type" => "text", "attributes" => array()
                ),
                array(
                    "title" => array("email", "de usuario"), "name" => "user_email", "value" => null, "type" => "email", "attributes" => array()
                ),
                array(
                    "title" => array("Ciudad", "del cliente"), "name" => "city_id", "options" => $title_cities, "selected" => null, "type" => "select", "attributes" => array()
                ),
                array(
                    "title" => array("Tipo", "de usuario"), "name" => "role_id", "options" => $title_roles, "selected" => null, "type" => "select", "attributes" => array()
                ),
                array(
                    "title" => array("Contraseña", "de usuario"), "name" => "user_pwd", "value" => null, "type" => "password", "attributes" => array()
                )
            );
            //dd($formTemplate);

        } else {
            $formTemplate = array(
                array("title" => array("Nombre", "de usuario"), "name" => "user_name", "value" => null, "type" => "text", "attributes" => array()
                ),
                array("title" => array("Documento", "de usuario"), "name" => "user_doc", "value" => null, "type" => "text", "attributes" => array()
                ),
                array("title" => array("email", "de usuario"), "name" => "user_email", "value" => null, "type" => "email", "attributes" => array()
                ),
                array("title" => array("Tipo", "de usuario"),
                    "name" => "role_id",
                    "options" => $title_roles,
                    "selected" => null,
                    "type" => "select",
                    "attributes" => array()
                ),
                array("title" => array("Contraseña", "de usuario"), "name" => "user_pwd", "value" => null, "type" => "password", "attributes" => array()
                )
            );
        }


        if (Auth::user()->role_id == 4) {
            $titleArray = array("NO" => "id", "Nombre" => "name", "Correo electrónico" => "email", "Ciudad" => "city");
        } else {
            $titleArray = array("NO" => "id", "Nombre" => "name", "Correo electrónico" => "email");
        }

        $action = 'create';
        $section = 'administrator';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );

        return View::make($section . '.form')
            ->with('titles', $titleArray)
            ->with('action', $action)
            ->with('formTemplate', $formTemplate)
            ->with('idToEdit', '0')
            ->with('section', $section)
            ->with('title', 'Nuevo administrador')
            ->with('roles', $title_roles)
            ->with('cities', $array_cities);
    }

    public function post_create()
    {
        // verifica que el correo no este asignado
        $create_user = true;
        if (Input::get('user_email')) {
            $found = Administrator::where('email', '=', Input::get('user_email'))->get();
            if ($found) {
                $create_user = false;
            }
        }



        $array_cities = null;
        if (Auth::user()->role_id == 5) {
            $customer_id = Auth::user()->id;
            //dd($customer_id);

            $array_cities = City::all();

        } else if (Auth::user()->role_id == 4) {
            $customer_id = Auth::user()->id;
            $array_cities = City::all();
            //dd($array_cities);
            //dd($customer_id);
            // grabar ciudad para el cliente
        } else {
            $customer_id = Auth::user()->customer_id;
        }
        //dd(Input::all());
        //dd($customer_id);

        if ($create_user) {
        $user = Administrator::create(array(
            'name' => Input::get('user_name'),
            'email' => Input::get('user_email'),
            'role_id' => Input::get('role_id'),
            'pwd' => Hash::make(Input::get('user_pwd')),
            'customer_id' => $customer_id,
            'cedula' => Input::get('user_doc')
        ));
        }
        else {
            $user = "";
        }
        //dd('creado 1');
        //dd($user);

         if ($create_user) {
            if (Auth::user()->role_id == 4) {
                $customer_id = $user->id;
                //dd($customer_id);
                //dd(Input::all());
                // graba tabla customer cities
                $query = "Insert into cities_customers values('".Input::get('city_id')."','".$customer_id."');";
                $result2 = DB::query($query);
            }
        }
        //dd('test111');

        if ($user) {
            $msg = 'Registro creado!';
            $type = 'success';
        } else {
            if ($create_user)
                $msg = 'Error al  crear registro!';
            else
                $msg = 'El correo ingresado ya esta en uso!';


            $type = 'error';
        }

        //dd($msg);
        // code here..
        //return View::make('user.index');
        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );
        $section = 'administrator';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        $array_cities = null;
        $title = 'Administradores actuales';
        if (Auth::user()->role_id == 5) {
            $title = 'Administradores del Cliente actuales';
            $title_roles1 = Role::where('id', '=', '2')->get();
            $title_roles2 = Role::where('id', '=', '3')->get();
            $title_roles = array_merge($title_roles1, $title_roles2);
            $array_users = Administrator::with('role')->where('customer_id', '=', Auth::user()->id)->get();
        } else if (Auth::user()->role_id == 4) {
            $title = 'Clientes actuales';
            $title_roles = Role::where('id', '=', '5')->get();
            $array_users = Administrator::with('role')->where('role_id', '=', '5')->get();
        } else if (Auth::user()->role_id == 2) {
            $title = 'Operadores';
            $title_roles = Role::where('id', '=', '3')->get();
            $array_users = Administrator::with('role')->all();
        } else if (Auth::user()->role_id == 1) {
            $title = 'Clientes actuales';
            $title_roles = Role::all();
            $array_users = Administrator::with('role')->all();
        } else {
            $title_roles = Role::all();
        }

        return View::make($section . '.index')
            ->with('title', 'Administradores actuales')
            ->with('titles', $titleArray)
            ->with('section', $section)
            ->with('manageBtns', $manageBtns)
            ->with('message', $msg)
            ->with('result', $type)
            ->with('idToEdit', '0')
            //->with('roles', ((Auth::user()->role_id == 1) ? Role::all() : Role::where('id', '!=', '1')->get()))
            ->with('roles', $title_roles)
            ->with('items', $array_users);
        //->with('items', Administrator::with('role')->all());
    }

    public function post_edit()
    {
        $id = Input::get('id');
        $user = Administrator::find($id);
//        dd(Input::all());
        // determine counrty id +
        //dd(Auth::user()->role_id );
        $title_cities = null;
        if (Auth::user()->role_id == 5) {
            $customer_id = Auth::user()->id;

            // $array_cities = City::all();
            // $title_cities = City::lists('name', 'id');
            // $title_roles1 = Role::where('id', '=', '2')->lists('type', 'id');
            // $title_roles2 = Role::where('id', '=', '3')->lists('type', 'id');
            // $title_roles = $title_roles1 + $title_roles2;

            $array_cities = City::all();
            $title_roles1 = Role::where('id', '=', '2')->lists('type', 'id');
            $title_roles2 = Role::where('id', '=', '3')->lists('type', 'id');
            $title_roles = $title_roles1 + $title_roles2;
            $title_cities = City::lists('name', 'id', 'country_id');


        } else if (Auth::user()->role_id == 4) {
            $customer_id = Auth::user()->id;
            $array_cities = City::all();
            //dd($array_cities);
            //$title_cities = City::where('country_id','=','1')->lists('name', 'id');
            $title_cities = City::lists('name', 'id');
        } else {
            $customer_id = Auth::user()->customer_id;
            $array_cities = City::all();
            $title_cities = City::lists('name', 'id');
        }
        //dd(Input::all());
        //dd($user);

        // determina ciudad de customer
        //dd($user->id);
        $query = "select * from cities_customers  where customer_id = ".$user->id. ";";
        $result2 = DB::query($query);
        //dd($result2[0]->city_id);

        if (Auth::user()->role_id == 4) {
            $formTemplate = array(
                array("title" => array("Nombre", "de usuario"), "name" => "user_name", "value" => $user->name, "type" => "text", "attributes" => array()
                ),
                array("title" => array("Documento", "de usuario"), "name" => "user_doc", "value" => $user->cedula, "type" => "text", "attributes" => array()
                ),
                array("title" => array("email", "de usuario"), "name" => "user_email", "value" => $user->email, "type" => "email", "attributes" => array()
                ),
                array(
                    "title" => array("Contraseña", "de usuario"), "name" => "user_pwd", "value" => null, "type" => "password", "attributes" => array()
                ),
                array(
                    "title" => array("Ciudad", "del cliente"),
                    "name" => "city_id",
                    "options" => $title_cities,
                    "selected" => $result2[0]->city_id,
                    "type" => "select",
                    "attributes" => array()
                )
            );
        } else {
            $formTemplate = array(
                array("title" => array("Nombre", "de usuario"), "name" => "user_name", "value" => $user->name, "type" => "text", "attributes" => array()
                ),
                array("title" => array("Documento", "de usuario"), "name" => "user_doc", "value" => $user->cedula, "type" => "text", "attributes" => array()
                ),
                array("title" => array("email", "de usuario"), "name" => "user_email", "value" => $user->email, "type" => "email", "attributes" => array()
                ),
                array("title" => array("Contraseña", "de usuario"), "name" => "user_pwd", "value" => null, "type" => "password", "attributes" => array()
                )
            );
        }

        if (Auth::user()->role_id == 1) {
            //if (1) {
            $formTemplate[] = array(
                "title" => array("Tipo", "de usuario"), "name" => "role_id", "options" => Role::lists('type', 'id'), "selected" => $user->role_id, "type" => "select", "attributes" => array());

        } elseif (Auth::user()->role_id == 2) {
            $formTemplate[] = array(
                "title" => array("Tipo", "de usuario"), "name" => "role_id", "options" => Role::where('id', '!=', '1')->lists('type', 'id'), "selected" => $user->role_id, "type" => "select", "attributes" => array()
            );
        }
        elseif (Auth::user()->role_id == 5) {
            $formTemplate[] = array(
                "title" => array("Tipo", "de usuario"),
                "name" => "role_id",
                "options" => $title_roles,
                "selected" => $user->role_id,
                "type" => "select",
                "attributes" => array()
            );
        }
        elseif (Auth::user()->role_id == 4) {
            $formTemplate[] = array(
                "title" => array("Tipo", "de usuario"), "name" => "role_id", "options" => Role::where('id', '=', '5')->lists('type', 'id'), "selected" => $user->role_id, "type" => "select", "attributes" => array()
            );
        } else {

            $formTemplate[] = array(
                "title" => array("Tipo", "de usuario"), "name" => "role_id", "options" => Role::where('id', '=', '3')->lists('type', 'id'), "selected" => $user->role_id, "type" => "select", "attributes" => array());
        }


        //dd(Auth::user()->role_id);
        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );
        $action = 'update';
        $section = 'administrator';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        return View::make($section . '.form')
            ->with('titles', $titleArray)
            ->with('action', $action)
            ->with('formTemplate', $formTemplate)
            ->with('section', $section)
            ->with('idToEdit', $id)
            ->with('title', 'Editar usuario');
    }

    public function post_update()
    {
        $userId = Input::get('id');
        //dd(Input::all());
        //dd(Auth::user()->role_id);
        $array_cities = null;
        $array_users = null;

        if (Auth::user()->role_id == 5) {
            //$title_roles = Role::where('id', '=', '5')->lists('type', 'id');
/*
            $array_cities = City::all();
            $title_roles1 = Role::where('id', '=', '2')->lists('type', 'id');
            $title_roles2 = Role::where('id', '=', '3')->lists('type', 'id');
            //$title_roles = array_merge($title_roles1, $title_roles2);
            $title_roles = $title_roles1 + $title_roles2;
            $array_users = Administrator::with('role')->where('customer_id', '=', Auth::user()->id)->get();
*/

            $title = 'Administradores del Cliente actuales';
            $title_roles1 = Role::where('id', '=', '2')->get();
            $title_roles2 = Role::where('id', '=', '3')->get();
            $title_roles = array_merge($title_roles1, $title_roles2);
            $array_users = Administrator::with('role')->where('customer_id', '=', Auth::user()->id)->get();


        } else if (Auth::user()->role_id == 4) {
            $title = 'Clientes actuales';
            $title_roles = Role::where('id', '=', '5')->get();
            $array_users = Administrator::with('role')->where('role_id', '=', '5')->get();

        } else if (Auth::user()->role_id == 2) {
            $title_roles = Role::where('id', '=', '3')->lists('type', 'id');
        } else if (Auth::user()->role_id == 1) {
            $title_roles = Role::lists('type', 'id');
        } else {
            $title_roles = Role::lists('type', 'id');
        }

        $title = 'Administradores actuales';

        $dataToEdit = array(
            'name' => Input::get('user_name'),
            'email' => Input::get('user_email'),
            'role_id' => Input::get('role_id'),
            'cedula' => Input::get('user_doc')
        );
        //dd(Input::all());

        if (Input::has('user_pwd')) {
            $dataToEdit['pwd'] = Hash::make(Input::get('user_pwd')); //'pwd' => Hash::make(Input::get('user_pwd')),
        }
        $userUpdate = Administrator::update($userId, $dataToEdit);
        if ($userUpdate) {
            $msg = 'Registro actualizado!';
            $type = 'success';
        } else {
            $msg = 'Error al actualizar, registro!';
            $type = 'error';
        }
        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );

        $section = 'administrator';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        //dd($msg);
        //dd($array_cities);
        return View::make('administrator.index')
            ->with('title', $title)
            ->with('titles', $titleArray)
            ->with('section', $section)
            ->with('manageBtns', $manageBtns)
            ->with('roles', $title_roles)
            ->with('items', $array_users)
            ->with('cities', $array_cities);
    }

    public function post_del()
    {
        $id = Input::get('id');
        $data = Administrator::find($id);
        //dd($data);
        if ($data->delete()) {
            $msg = 'Registro' . ' eliminado!';
            $type = 'success';
        } else {
            $msg = 'Error al eliminar registro!';
            $type = 'error';
        }
        // code here..
        //return View::make('user.index');
        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );
        $section = 'administrator';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        $array_cities = null;
        $title = 'Administradores actuales';
        if (Auth::user()->role_id == 5) {
            $title = 'Administradores del Cliente actuales';
            $title_roles1 = Role::where('id', '=', '2')->get();
            $title_roles2 = Role::where('id', '=', '3')->get();
            $title_roles = array_merge($title_roles1, $title_roles2);
            $array_users = Administrator::with('role')->where('customer_id', '=', Auth::user()->id)->get();
            //dd($array_users);
        } else if (Auth::user()->role_id == 4) {
            $title = 'Clientes actuales';
            $title_roles = Role::where('id', '=', '5')->get();
            $array_users = Administrator::with('role')->where('role_id', '=', '5')->get();
        } else if (Auth::user()->role_id == 2) {
            $title = 'Operadores';
            $title_roles = Role::where('id', '=', '3')->get();
            $array_users = Administrator::with('role')->all();
        } else if (Auth::user()->role_id == 1) {
            $title = 'Clientes actuales';
            $title_roles = Role::all();
            $array_users = Administrator::with('role')->all();
        } else {
            $title_roles = Role::all();
        }
        //dd('delete');
        return View::make('administrator.index')
            ->with('title', $title)
            ->with('titles', $titleArray)
            ->with('section', $section)
            ->with('manageBtns', $manageBtns)
            ->with('roles', $title_roles)
            ->with('items', $array_users)
            ->with('cities', $array_cities);

        // return View::make($section . '.index')
        //                 ->with('title', 'Administradores actuales')
        //                 ->with('titles', $titleArray)
        //                 ->with('section', $section)
        //                 ->with('manageBtns', $manageBtns)
        //                 ->with('message', $msg)
        //                 ->with('result', $type)
        //                 ->with('roles', ((Auth::user()->role_id == 1) ? Role::all() : Role::where('id', '!=', '1')->get()))//Role::all())
        //                 ->with('items', Administrator::with('role')->all());
    }

}

