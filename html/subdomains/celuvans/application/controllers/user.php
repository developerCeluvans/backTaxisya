<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author IngJohnGuerrero
 */
class User_Controller extends Base_Controller {

    public $restful = true;

    public function get_index() {
        //return View::make('user.index');
        return View::make('user.index')
                        ->with('title', 'Usuarios actuales')
                        ->with('usuarios', User::order_by('name')->get());
        //        $view = View::make('user.index', array('name' => 'John'))->with('age', '28');
        //        $view->location = 'California'; //dont work
        //        $view['specialty'] = 'PHP'; //dont work
        //        return Response::json($usuario->to_array());
    }

    public function get_view($id) {
        return View::make('user.view')
                        ->with('title', 'Usuario')
                        ->with('user', User::find($id));
    }

    public function get_new() {
        return View::make('user.new')
                        ->with('title', 'nuevo Usuario');
    }

    public function post_create() {
        $validation = User::validate(Input::all());
        if ($validation->fails()) {
            return Redirect::to_route('new_user')->with_errors($validation)->with_input();
        } else {
            User::create(array(
                'name' => Input::get('name'),
                'lastname' => Input::get('lastname'),
                'email' => Input::get('email'),
                'login' => Input::get('login'),
                'pwd' => md5(Input::get('pwd')),
                'uuid' => Input::get('uuid')
            ));
            return Redirect::to_route('user')->with('message', 'Usuario ' . input::get('name') . ' creado!');
        }
    }

    public function post_register() {
        //dd(Input::all());
        $loginData = DB::table('users')->where_email(Input::get('login'))->first(array('id', 'uuid'));
        if (!$loginData) {
            //User::login(Input::get('login'),Input::get('pwd'),Input::get('uuid'))
            if(Input::has('diageo'))
            {
                if(Input::get('diageo') == 1){
                    $diageo = 1;
                }else{
                    $diageo = 0;
                }
            }else
            {
                $diageo = 0;
            }

            User::create(array(
                'name' => Input::get('name'),
                'lastname' => Input::get('lastname'),
                'email' => Input::get('email'),
                'cellphone' => Input::get('cellphone'),
                'login' => Input::get('login'),
                'pwd' => md5(Input::get('pwd')),
                'uuid' => Input::get('uuid'),
                'token' => Input::get('token'),
                'type' => Input::get('type'),
                'diageo' => $diageo,

            ));
            $id = User::login(Input::get('login'), md5(Input::get('pwd')), Input::get('uuid'), Input::get('type'), $diageo);
            //dd($id);
            $userData = (User::find($id['id'])->to_array());
            $userData['error'] = '0';
            return Response::json($userData);
        } else {
			return json_encode(array('error' => '1')); //Usuario existente
    }
	}

    public function post_update(){
		$diageo = 0;
		$loginData = DB::table('users')->where_email_and_uuid(trim(Input::get('login')), trim(Input::get('uuid')))->first(array('id','pwd'));
		//$id = $loginData->id;
		if($loginData){
				User::update($loginData->id, array(
				'name' => Input::get('name'),
				'cellphone' => Input::get('cellphone'),
				'pwd' => Input::get('pwd')
				));

			$id = User::login(Input::get('login'), Input::get('pwd'), Input::get('uuid'), Input::get('type'), $diageo);
			$userData = (User::find($id['id'])->to_array());
			$userData['error'] = '0';
			return Response::json($userData);
		}else{
			return json_encode(array('error' => '1')); //Usuario no existente
		}
    }

	public function post_phoneregister() {
        //dd(Input::all());
        $data = Input::json();
        $loginData = DB::table('users')->where_telephone($data->telephone)->first(array('id', 'telephone'));
        if (!$loginData) {
            //User::login(Input::get('login'),Input::get('pwd'),Input::get('uuid'))
            $userDataEloquent = User::create(array(
                        'name' => $data->name,
                        'lastname' => $data->lastname,
                        'telephone' => $data->telephone
            ));
            $userDataEloquent = User::find($userDataEloquent->id);
            $userData = $userDataEloquent->to_array();
            $userData['error'] = '0';
            return Response::json($userData);
        } else {
            return json_encode(array('error' => '1')); //Usuario existente
        }
    }

    public function post_forgotten() {

        if (Input::has('email')) {
            $userMail = strtolower(Input::get('email'));
             if (Input::has('isDriver')) {
                $user = Driver::where(DB::raw('LOWER(email)'), '=', $userMail)->first();
             } else {
                $user = User::where(DB::raw('LOWER(email)'), '=', $userMail)->first();
             }
            if ($user) {
                $pwd_token = rand(10000, 32767);
                $msg = "<h1>Procedimiento para restablecer contrase&ntilde;a</h1>
        <p>Para restablecer su contrase&ntilde;a</p><br>
        <p>Utilice el c&oacute;digo: " . $pwd_token . "</p><br>
        <p>al interior de la aplicaci&oacute;n</p><br>
        <p>Atentamente,</p><br>
        <p>TaxisYa</p><br>
        ";

                $mailer = IoC::resolve('phpmailer');

                $SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
                //$SMTPAuth = true;  // authentication enabled
                //$SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                $SMTPAuth = true;  // authentication enabled
                $SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                $Host = 'smtp.gmail.com';
                $Port = 465;
                //$Host = 'mail.taxisya.com.co';
                //$Port = 587;
                //$Username = "aplicativo@taxisya.com.co";
                //$Password = "tax1sy4";
                //$Username = "taxisya.soporte@gmail.com";
                //$Password = "Airedale1019.";
                //$Username = "apptitude.devs@gmail.com";
                //$Password = "jmnfgt117";
                $Username = "taxisya.cms@gmail.com";
                $Password = "t4x1sy42015";
                $entidad = $from = "taxisYa";
                $from_name = "Soporte " . $entidad;

                $mailer->IsSMTP();
                $mailer->SMTPDebug = 1;
                //$mailer->SMTPAuth = true;
                $mailer->SMTPAuth = true;
                $mailer->SMTPSecure = $SMTPSecure;
                $mailer->Host = $Host;
                $mailer->Port = $Port;
				$mailer->CharSet = 'UTF-8';

                $mailer->Username = $Username;
                $mailer->Password = $Password;

                $mailer->From = $from;
                $mailer->FromName = $from_name;

                try {
                    $mailer->AddAddress($user->email, $user->name);
					$subject = "taxisYa, restablecer contraseña";
                    $mailer->Subject = "=?UTF-8?B?".base64_encode($subject)."?=";
                    $mailer->Body = $msg;
                    $mailer->IsHTML(true);
                    $mailer->Send();
                } catch (Exception $e) {
                    /* echo 'Message was not sent.';
                      echo 'Mailer error: ' . $e->getMessage(); */
                    //return Response::json(array('error' => 3, 'msg' => 'Error en envio de correo'));
                    //return Response::json(array('error' => 3, 'msg' => '1 Error en envio de correo'));
                    return Response::json(array('error' => 3, 'msg' => $e->getMessage() ));
                }
                $user->pwd_token = $pwd_token;
                $user->save();
                //return Response::eloquent($user);
                return Response::json(array('error' => 0, 'msg' => 'Petición enviada con éxito'));
            } else {
                return Response::json(array('error' => 2, 'msg' => 'Usuario incorrecto'));
            }
        } else {
            return Response::json(array('error' => 1, 'msg' => 'Acceso erroneo'));
        }
    }

    public function post_pwdconfirm() {
        if (Input::has('token') && Input::has('password') && Input::has('email')) {
            $userToken = Input::get('token');
            $userMail = trim(strtolower(Input::get('email')));
            //$user = User::where(DB::raw('LOWER(email)'), '=', $userMail)->first();
            if (Input::has('isDriver')) {
                $user = Driver::where(DB::raw('LOWER(email)'), '=', $userMail)->first();
             } else {
                $user = User::where(DB::raw('LOWER(email)'), '=', $userMail)->first();
             }
            if(!$user){
                return Response::json(array('error' => 4, 'msg' => 'El email ingresado no es correcto'));
            }
            if ($userToken === $user->pwd_token) {
                $user->pwd = Input::get('password');
                $user->pwd_token = '';
                $user->save();

                $msg = "<h1>contrase&ntilde;a restablecida satisfactoriamente</h1>
        <p>Gracias por utilizar nuestro servicio</p><br>
        <p></p><br>
        <p></p><br>
        <p>Atentamente,</p><br>
        <p>TaxisYa</p><br>
        ";

                $mailer = IoC::resolve('phpmailer');

                $SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
                $SMTPAuth = true;  // authentication enabled
                $SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                $Host = 'smtp.gmail.com';
                $Port = 465;
                //$Username = "taxisya.soporte@gmail.com";
                //$Password = "Airedale1019.";
                // $Username = "apptitude.devs@gmail.com";
                // $Password = "jmnfgt117";
                // $entidad = $from = "taxisYa";

                $Username = "taxisya.cms@gmail.com";
                $Password = "t4x1sy42015";
                $entidad = $from = "taxisYa";


                $from_name = "Soporte " . $entidad;

                $mailer->IsSMTP();
                $mailer->SMTPDebug = 1;
                $mailer->SMTPAuth = true;
                $mailer->SMTPSecure = $SMTPSecure;
                $mailer->Host = $Host;
                $mailer->Port = $Port;

                $mailer->Username = $Username;
                $mailer->Password = $Password;

                $mailer->From = $from;
                $mailer->FromName = $from_name;

/*
                try {
                    $mailer->AddAddress($user->email, $user->name);
                    $mailer->Subject = "taxisYa, contraseña restablecida";
                    $mailer->Body = $msg;
                    $mailer->IsHTML(true);
                    $mailer->Send();
                } catch (Exception $e) {
                    // echo 'Message was not sent.';
                    //  echo 'Mailer error: ' . $e->getMessage();
                    return Response::json(array('error' => 3, 'msg' => 'Error en envio de correo'));
                }
                */
                return Response::json(array('error' => 0, 'msg' => 'Contraseña restablecida con éxito'));
            } else {
                return Response::json(array('error' => 2, 'msg' => 'Token erroneo'));
            }
        } else {
            return Response::json(array('error' => 1, 'msg' => 'Acceso erroneo'));
        }
    }

    public function get_login() {
        return View::make('user.login')
                        ->with('title', 'User login');
    }

	public function post_islogued(){
		$data = Input::json();
		if(isset($data))
		{
		$id = User::is_logued($data->login, $data->uuid);
		}else{
		$id = User::is_logued(Input::get('login'), Input::get('uuid'));
		}
		if ($id) {
            return $id;
        } else {
            return $id;
        }
	}

    public function post_login() {
        if(Input::has('diageo'))
            {
                if(Input::get('diageo') == 1){
                    $diageo = 1;
                }else{
                    $diageo = 0;
                }
            }else
            {
                $diageo = 0;
            }
            //dd(Input::all());
        $id = User::login(Input::get('login'), Input::get('pwd'), Input::get('uuid'), Input::get('type'), $diageo);
        if ($id['error'] === '0') {
            //$userData = User::find($id)->to_array();
            $userData = (User::find($id['id'])->to_array());
            $userData['error'] = '0';
            return Response::json($userData);
            //return Response::json(array('user' => $userData, 'error' => '0'));
        } else {
            return json_encode(array('error' => $id['error']));
        }
        /* $id = User::login(Input::get('login'), Input::get('pwd'), Input::get('uuid'), FALSE, Input::get('token'));
          if ($id != false && $id != null) {
          $userData = (User::find($id)->to_array());
          $userData['error'] = '0';
          return Response::json($userData);
          } else {
          return json_encode(array('error' => '1'));
          } */
    }

    public function post_logout() {
		$data = Input::json();
		if(isset($data))
		{
		return User::logOut($data->login, $data->pwd);
		}else{
        return User::logOut(Input::get('login'), Input::get('pwd'));
		}
    }

    public function get_edit($id) {
        return View::make('user.edit')
                        ->with('title', 'Edit user')
                        ->with('user', User::find($id));
    }

    public function get_locate($id) {
        return View::make('user.locate')
                        ->with('title', 'Force locate user')
                        ->with('user', User::find($id));
    }

    public function put_update() {
        $id = Input::get('id');
        //$validation = User::validate(Input::all());
        //        $validation = User::validate(Input::get('name'));
        //        $validation1 = User::validate(Input::get('lastname'));
        //        $validation2 = User::validate(Input::get('email'));
        //        $validation3 = User::validate(Input::get('login'));
        //        if ($validation->fails() || $validation1->fails() || $validation2->fails() || $validation3->fails()) {
        //            return Redirect::to_route('edit_user', $id)->with_errors($validation);
        //        } else {
        User::update($id, array(
            'name' => Input::get('name'),
            'lastname' => Input::get('lastname'),
            'cellphone' => Input::get('cellphone'),
            'login' => Input::get('login')
                //,'pwd' => md5(Input::get('pwd'))
        ));
        return Redirect::to_route('user', $id)->with('message', 'Usuario actualizado');
        //        }
    }

    public function post_lookfor() {
        header('Access-Control-Allow-Origin: *');
        if (Input::has('user_telephone')) {
            $userTelephone = Input::get('user_telephone');
        } else {
            $data = Input::json();
            $userTelephone = trim($data->user_telephone);
        }
        if ($userTelephone) {
            $tmpUser = User::where('telephone', 'like', $userTelephone)->or_where('cellphone', 'like', $userTelephone)->first();
        } else {
            $tmpUser = null;
        }

        if (count($tmpUser) > 0) {
            return Response::eloquent($tmpUser);
        } else {
            return Response::json(array('error' => '1'));
        }
    }

    public function post_position() {
        $id = Input::get('id');
        User::update($id, array(
            'crt_lat' => Input::get('lat'),
            'crt_lng' => Input::get('lng')
        ));
        //return Redirect::to_route('user', $id)->with('message', 'Usuario actualizado');
        return json_encode(array('response' => '1'));
    }

}

?>
