<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tickets extends CI_Controller {
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
		$this->load->view('ticket.php',(array)$output);
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




	public function offices_management()
	{
		try{
			$crud = new grocery_CRUD();

            $crud->set_language('spanish');
			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');
			//$crud->display_as('customerName','Name')->display_as('contactLastName','Last Name');



			$output = $crud->render();

			$this->_ticket_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
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
			//$crud->set_subject('Customer');

            $crud->change_field_type('password', 'password');

//			$crud->set_relation('company_id','companies','name');

			$crud->set_relation('company_id','companies','name');
			$crud->where('company_id',2);
			if ($crud->getState() == 'edit') {
			     $crud->where('company_id',2);

                 $crud->field_type('parent_id', 'hidden');
                 $crud->field_type('cost_center_id', 'hidden');                 
            }


			//CALLBACKS
            //$crud->callback_insert(array($this, 'create_user_callback'));

            $crud->callback_before_insert(function ($post_array)  {
                  $post_array['password'] = sha1($post_array['password']);
                 return $post_array;
             });

			$output = $crud->render();

			$this->_ticket_output($output);
	}


}
