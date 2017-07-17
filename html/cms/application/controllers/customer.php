<?php

class Customer_Controller extends Base_Controller {

    public $restful = true;

    public function post_index() {
        // code here..


        //dd('test data 2');

        $title_roles = Role::where('id', '=', '5')->get();
        $array_users = Administrator::with('role')->where('role_id','=','5')->get();

        //dd($title_roles);

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
        return View::make('customer.index')
                        ->with('title', 'Clientes actuales')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        //->with('roles', ((Auth::user()->role_id == 5) ? Role::where('id', '==', '5')->get() : Role::where('id', '==', '5')->get()  ))
                        //->with('items', Administrator::with('role')->where('id', '==', '5')->get() );
                        ->with('roles', $title_roles)
//                        ->with('roles', ((Auth::user()->role_id == 5) ? Role::all() : Role::where('id', '=', '5')->get()))
//                        ->with('items', Administrator::with('role')->all());
                        ->with('items', $array_users );
//                        ->with('items', Administrator::with('role')->where('id', '!=', '5')->get()    );



    }

    public function post_login() {
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

    public function post_new() {
        // code here..
        //return View::make('user.index');
        //Form::select('subject_id[]',$customSelector,'',array('class'=>'chzn-select','multiple'))
        /*
          'name' => Input::get('user_name'),
          'email' => Input::get('user_email'),
          'role_id' => Input::get('role_id'),
          'pwd' => Hash::make(Input::get('pwd')),
          'cedula' => Input::get('user_doc')
         */
        $formTemplate = array(
            array(
                "title" => array(
                    "Nombre",
                    "de cliente"),
                "name" => "user_name",
                "value" => null,
                "type" => "text",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "Documento",
                    "de cliente"),
                "name" => "user_doc",
                "value" => null,
                "type" => "text",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "email",
                    "de cliente"),
                "name" => "user_email",
                "value" => null,
                "type" => "email",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "Tipo",
                    "de cliente"),
                "name" => "role_id",
//                "options" => ((Auth::user()->role_id == 1) ? Role::lists('type', 'id') : Role::where('id', '!=', '1')->lists('type', 'id')),
                "options" => ((Auth::user()->role_id == 5) ? Role::all() : Role::where('id', '=', '5')->get()),
                "selected" => null,
                "type" => "select",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "Contraseña",
                    "de cliente"),
                "name" => "user_pwd",
                "value" => null,
                "type" => "password",
                "attributes" => array()
            )
        );
        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email"
        );
        $action = 'create';
        $section = 'administrator';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        return View::make('customer.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('idToEdit', '0')
                        ->with('section', $section)
                        ->with('title', 'Nuevo cliente');

    }

    public function post_create() {
        $user = Administrator::create(array(
                    'name' => Input::get('user_name'),
                    'email' => Input::get('user_email'),
                    'role_id' => Input::get('role_id'),
                    'pwd' => Hash::make(Input::get('user_pwd')),
                    'cedula' => Input::get('user_doc')
        ));
        if ($user) {
            $msg = '¡Registro creado!';
            $type = 'success';
        } else {
            $msg = 'Error al crear registro!';
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
        return View::make('customer.index')
                        ->with('title', 'Clientes actuales')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('idToEdit', '0')

                        ->with('roles', ((Auth::user()->role_id == 1) ? Role::all() : Role::where('id', '!=', '1')->get()))//Role::all())
                        ->with('items', Administrator::with('role')->all());
    }

    public function post_edit() {
        $id = Input::get('id');
        $user = Administrator::find($id);
        //dd(Input::all());
        $formTemplate = array(
            array(
                "title" => array(
                    "Nombre",
                    "de cliente"),
                "name" => "user_name",
                "value" => $user->name,
                "type" => "text",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "Documento",
                    "de cliente"),
                "name" => "user_doc",
                "value" => $user->cedula,
                "type" => "text",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "email",
                    "de cliente"),
                "name" => "user_email",
                "value" => $user->email,
                "type" => "email",
                "attributes" => array()
            ),
            array(
                "title" => array(
                    "Contraseña",
                    "de cliente"),
                "name" => "user_pwd",
                "value" => null,
                "type" => "password",
                "attributes" => array()
            )
        );
        if (Auth::user()->role_id == 1) {
            //if (1) {
            $formTemplate[] = array(
                "title" => array(
                    "Tipo",
                    "de cliente"),
                "name" => "role_id",
                "options" => Role::lists('type', 'id'),
                "selected" => $user->role_id,
                "type" => "select",
                "attributes" => array()
            );
        } elseif (Auth::user()->role_id == 2) {
            $formTemplate[] = array(
                "title" => array(
                    "Tipo",
                    "de cliente"),
                "name" => "role_id",
                "options" => Role::where('id', '!=', '1')->lists('type', 'id'),
                "selected" => $user->role_id,
                "type" => "select",
                "attributes" => array()
            );
        }else{
            $formTemplate[] = array(
                "title" => array(
                    "Tipo",
                    "de cliente"),
                "name" => "role_id",
                "options" => Role::where('id', '=', '3')->lists('type', 'id'),
                "selected" => $user->role_id,
                "type" => "select",
                "attributes" => array()
            );
        }
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
        return View::make('customer.form')
                        ->with('titles', $titleArray)
                        ->with('action', $action)
                        ->with('formTemplate', $formTemplate)
                        ->with('section', $section)
                        ->with('idToEdit', $id)
                        ->with('title', 'Editar cliente');
    }

    public function post_update() {
        $userId = Input::get('id');
        //dd(Input::all());
        if (true) { // Auth::user()->role_id == 1) {
            //if (1) {
            $dataToEdit = array(
                'name' => Input::get('user_name'),
                'email' => Input::get('user_email'),
                'role_id' => Input::get('role_id'),
                'cedula' => Input::get('user_doc')
            );
            if (Input::has('user_pwd')) {
                $dataToEdit['pwd'] = Hash::make(Input::get('user_pwd')); //'pwd' => Hash::make(Input::get('user_pwd')),
            }
            $userUpdate = Administrator::update($userId, $dataToEdit);
        } else {
            $dataToEdit = array(
                'name' => Input::get('user_name'),
                'email' => Input::get('user_email'),
                'role_id' => '2',
                'cedula' => Input::get('user_doc')
            );
            if (Input::has('user_pwd')) {
                $dataToEdit['pwd'] = Hash::make(Input::get('user_pwd')); //'pwd' => Hash::make(Input::get('user_pwd')),
            }
            $userUpdate = Administrator::update($userId, $dataToEdit);
        }
        if ($userUpdate) {
            $msg = 'Registro actualizado!';
            $type = 'success';
        } else {
            $msg = 'Error al actualizar, registro!';
            $type = 'error';
        }
        // code here..
        //return View::make('user.index');
        $titleArray = array("NO" => "id",
            "Nombre" => "name",
            "Correo electrónico" => "email",
            "Id de Facebook" => "facebook_id"
        );
        $section = 'administrator';
        $manageBtns = array(
            'add' => true,
            'edit' => true,
            'del' => true
        );
        return View::make('customer.index')
                        ->with('title', 'Clientes actuales')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('roles', ((Auth::user()->role_id == 1) ? Role::all() : Role::where('id', '!=', '1')->get()))//Role::all())
                        ->with('items', Administrator::with('role')->all());
    }

    public function post_del() {
        $id = Input::get('id');
        $data = Administrator::find($id);

        //dd($data);


        $title_roles = Role::where('id', '=', '5')->get();
        $array_users = Administrator::with('role')->where('role_id','=','5')->get();

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
        return View::make('customer.index')
                        ->with('title', 'Clientes actuales')
                        ->with('titles', $titleArray)
                        ->with('section', $section)
                        ->with('manageBtns', $manageBtns)
                        ->with('message', $msg)
                        ->with('result', $type)
                        ->with('roles', $title_roles )
                        ->with('items', $array_users );


                        // ->with('roles', ((Auth::user()->role_id == 5) ? Role::all() : Role::where('id', '=', '5')->get()))
                        // ->with('items', Administrator::with('role')->all());
    }



}
