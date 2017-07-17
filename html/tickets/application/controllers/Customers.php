<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('customers_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');

        $this->load->library('grocery_CRUD');
    }

    public function _ticket_output($output = null)
    {
        $this->load->view('customer.php', (array)$output);
    }


    public function offices()
    {
        $output = $this->grocery_crud->render();

        $this->_ticket_output($output);
    }

    public function index(){

        $this->_ticket_output((object)array('output' => '', 'js_files' => array(), 'css_files' => array()));

    }

    public function users_admin_management(){

        $crud = new grocery_CRUD();

        $crud->set_table('ticket_users');
        $crud->columns('name', 'cellphone', 'email', 'password');
        
        $crud->display_as('name', 'Nombre')
            ->display_as('cellphone', 'Celular')
            ->display_as('cost_center_id', 'Centro de costo')
            //->display_as('company_id', 'Empresa')
            ->display_as('email', 'Email');
        $crud->required_fields('name','cellphone','cost_center_id', 'email' );

        $crud->set_rules('password','Contraseña', array('required', 'min_length[6]'));

        $crud->change_field_type('password', 'password');
        $company_id = $this->session->userdata('company_id');
        // solo muestra los centro de costos de la empresa actual
//        $crud->set_relation('company_id', 'ticket_companies', 'name', 'id IN (SELECT id FROM ticket_companies WHERE id=' . $company_id . ')');

 //       $crud->set_relation('cost_center_id', 'ticket_cost_centers', 'name', 'cost_center_id IN (SELECT id FROM ticket_cost_centers WHERE company_id=' . $company_id . ')');

       // $crud->set_relation('cost_center_id', 'ticket_cost_centers', 'name');
        $crud->where('role', 'manager');
      $crud->where('company_id',  $this->session->userdata('company_id'));
        //$crud->set_relation('cost_center_id', 'cost_centers', 'name', 'id IN (SELECT id FROM ticket_cost_centers WHERE company_id=' . $company_id . ')');


        if ($crud->getState() == 'add') {
            $crud->set_relation('cost_center_id', 'ticket_cost_centers', 'name', 'id IN (SELECT id FROM ticket_cost_centers WHERE company_id=' . $company_id . ')');
            $crud->field_type('company_id', 'hidden');
            $crud->field_type('parent_id', 'hidden');
            $crud->field_type('role', 'hidden');
        }

        if ($crud->getState() == 'edit') {
            $crud->set_relation('cost_center_id', 'ticket_cost_centers', 'name', 'id IN (SELECT id FROM ticket_cost_centers WHERE company_id=' . $company_id . ')');
            $crud->field_type('company_id', 'hidden');
            $crud->field_type('role', 'hidden');
            $crud->field_type('parent_id', 'hidden');
        }

        //CALLBACKS
        $crud->callback_before_insert(function ($post_array) {
            $post_array['password'] = sha1($post_array['password']);
            $post_array['company_id'] = $this->session->userdata('company_id');
            $post_array['parent_id'] = $this->session->userdata('user_id');
            $post_array['role'] = 'manager';
            return $post_array;
        });

        $output = $crud->render();

        $this->_ticket_output($output);

    }

    public function cost_centers_admin_management(){

        $crud = new grocery_CRUD();

        $crud->set_table('ticket_cost_centers');
        $crud->columns('name', 'prefix', 'budget', 'available','used');

        $crud->display_as('name', 'Nombre')
            ->display_as('prefix', 'Prefijo')
            ->display_as('budget', 'Presupuesto')
            ->display_as('available', 'Disponible')
            ->display_as('used', 'Utilizado');

        $crud->where('company_id', $this->session->userdata('company_id'));
        $crud->required_fields('name','prefix','numerator','budget', 'available' );
        $crud->set_rules('prefix','Prefijo', array('alpha', 'max_length[2]'));

        if ($crud->getState() == 'add') {
            $crud->field_type('company_id', 'hidden');
        }

        if ($crud->getState() == 'edit') {
            $crud->field_type('company_id', 'hidden');
        }

        $crud->callback_before_insert(function ($post_array) {
            $post_array['company_id'] = $this->session->userdata('company_id');
            return $post_array;
        });

        $output = $crud->render();

        $this->_ticket_output($output);


    }

        public function service_management(){

        $cost_center_id = $this->session->userdata('cost_center_id');
        $query = $this->db->query('SELECT * FROM ticket_cost_centers WHERE id = ' . $cost_center_id);
        $row = $query->row();
        $test= '';

        $crud = new grocery_CRUD();

        $crud->set_table('services');
        $crud->columns('user_card_reference', 'created_at', 'car_id', 'barrio' ,'address',  'units', 'charge1','charge2','charge4', 'value');
        $crud->set_relation('car_id', 'cars', 'placa');
        $crud->set_relation('status_id', 'status', 'descrip');

        $crud->where('pay_reference','VALE');
        $crud->where('user_card_reference !=', $test);
        $crud->where('status_id','5');
        $crud->where('company_id','9');

        $crud->display_as('created_at', 'Fecha inicio servicio')
            ->display_as('address', 'Dirección')
            ->display_as('car_id', 'Placa')
            ->display_as('value', 'Valor')
            ->display_as('user_card_reference', 'Vale')
            ->display_as('address', 'Dirección')
            ->display_as('barrio', 'Barrio')
            ->display_as('charge1', 'Aeropuerto')
            ->display_as('charge2', 'Nocturno/festivo')
            ->display_as('charge4', 'Puerta a Puerta')
            ->display_as('units', 'Unidades');

            $crud->where('pay_type', 3);
        $crud->like('user_card_reference');
        //$crud->where('cost_center_id', $this->session->userdata('cost_center_id'));

        $crud->unset_add();
        $crud->unset_edit();

        $output = $crud->render();
        $this->_ticket_output($output);
        //$this->_service_output($output);

    }

    public function restBugdet(){

        $this->customers_model->restBudget();
    }

}

