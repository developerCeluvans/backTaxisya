<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
 
class Main extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');

		$this->load->library('grocery_CRUD');
	}

	public function _ticket_output($output = null)
	{
		$this->load->view('main.php',(array)$output);
	}


	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_ticket_output($output);
	}

	public function index()
	{
		$this->_ticket_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function companies_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('ticket_companies');
			$crud->columns('id', 'name', 'identity', 'phone', 'address', 'contract', 'contractDate', 'description');
			$crud->required_fields('name','identity','phone', 'address', 'contract', 'contractDate', 'description' );
			$crud->display_as('id','Id')
				 ->display_as('name','Nombre Empresa')
				 ->display_as('identity','NIT')
				 ->display_as('phone','Teléfono')
				 ->display_as('address','Dirección')
				 ->display_as('contract','Contrato')
				 ->display_as('contractDate','Fecha contrato')
				 ->display_as('description','Descripción');

			$output = $crud->render();

			$this->_ticket_output($output);
	}

	public function users_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('ticket_users');
			$crud->columns('id', 'company_id','name','cellphone', 'email', 'password');
			$crud->display_as('id','Id')
				 ->display_as('name','Nombre')
				 ->display_as('cellphone','Celular')				 
				 ->display_as('company_id','Empresa')
				 ->display_as('email','Email');
			$crud->required_fields('name','cellphone','company_id', 'email' );

			//$crud->set_subject('Customer');
            $crud->set_rules('password','Contraseña', array('required', 'min_length[6]'));

            $crud->change_field_type('password', 'password');

//			$crud->set_relation('company_id','companies','name');

			$crud->set_relation('company_id','ticket_companies','name');
//			$crud->where('company_id',2);
			$crud->where('role', 'admin');

			if ($crud->getState() == 'add') {
			     //$crud->where('company_id',2);

                 $crud->field_type('parent_id', 'hidden');
                 $crud->field_type('role', 'hidden');
                 $crud->field_type('cost_center_id', 'hidden');                 
            }



			if ($crud->getState() == 'edit') {
			     //$crud->where('company_id',2);
                 $crud->field_type('role', 'hidden');
                 $crud->field_type('parent_id', 'hidden');
                 $crud->field_type('cost_center_id', 'hidden');                 
            }



			//CALLBACKS
            //$crud->callback_insert(array($this, 'create_user_callback'));

            $crud->callback_before_insert(function ($post_array)  {
                  $post_array['password'] = sha1($post_array['password']);
                  $post_array['role'] = 'admin';
                 return $post_array;
             });

			$output = $crud->render();

			$this->_ticket_output($output);
	}

}
