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

     //$idcusto =  Auth::user()->customer_id;
     //dd($idcusto);

    public function post_index() {
        //return View::make('user.index');

         //dd('post_index');


         $idcusto =  Auth::user()->customer_id;

         //dd('test');
/*
         $data = User::order_by('name')
                                ->where('uuid','<>','NULL')
                                ->where('uuid','<>','')
                                //->join('services', 'services.user_id', '=', 'users.id')
                                //->join('services', 'services.cms_users_id', '=', $idcusto )
                                //->group_by("users.id")
                                ->get()
         dd($data);
*/
         //SELECT users.id,users.name FROM `users` join services where services.cms_users_id = 42 and
         //services.user_id = users.id group by users.id

         // SELECT users.id,users.name FROM `users`  join services where services.cms_users_id = 42 and
         //services.user_id = users.id and users.uuid <> '' group by users.id

         // validar
         $usuarios = User::order_by('name')
                                ->where('uuid','<>','NULL')
                                ->where('uuid','<>','')
                                ->join('services', 'services.user_id', '=', 'users.id')
                                ->where('services.cms_users_id', '=', $idcusto )
                                ->group_by("users.id")
                                ->get();

         //dd($usuarios);

        return View::make('user.index')
                        ->with('title', 'Usuarios actuales')
                        ->with('titles', array('Nombre' => 'name',
                            //'Apellido' => 'lastname',
                            //'token' => 'token',
                            'Teléfono' => 'telephone',
                            'Celular' => 'cellphone',
                            'Correo electrónico' => 'email',
                            'Actualizado' => 'updated_at'))
                        ->with('usuarios',$usuarios);

/*
                            User::order_by('name')
                                ->where('uuid','<>','NULL')
                                ->where('uuid','<>','')
                                //->join('services', 'services.user_id', '=', 'users.id')
                                //->join('services', 'services.cms_users_id', '=', $idcusto )
                                //->group_by("users.id")
                                ->get());
*/



        //        $view = View::make('user.index', array('name' => 'John'))->with('age', '28');
        //        $view->location = 'California'; //dont work
        //        $view['specialty'] = 'PHP'; //dont work
        //        return Response::json($usuario->to_array());
    }

    public function post_edit() {
        $id = Input::get('id');
        return View::make('user.edit')
                        ->with('title', 'Usuario')
                        ->with('item', User::find($id));
    }

    public function post_del() {
        $id = Input::get('id');
        $data = User::find($id);
        if ($data->delete()) {
            $msg = 'Registro ' . ' eliminado!';
            $type = 'success';
        } else {
            $msg = 'Error al eliminar registro!';
            $type = 'error';
        }
        return View::make('user.index')
                        ->with('title', 'Usuarios actuales')
                        ->with('titles', array('Nombre' => 'name',
                            'Apellido' => 'lastname',
                            //'token' => 'token',
                            'Celular' => 'cellphone',
                            'e-mail' => 'email',
                            'Actualizado' => 'updated_at'))
                        ->with('usuarios', User::order_by('name')->where('uuid','<>','NULL')->where('uuid','<>','')->get());
    }

}

?>
