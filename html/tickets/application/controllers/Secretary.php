<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: developer_celuvans
 * Date: 7/6/17
 * Time: 09:31
 */
class Secretary extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('secretary_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->load->library('grocery_CRUD');

    }

    public function _manager_output($output = null){

        $this->load->view('secretary.php', (array)$output);

    }


    public function index(){

        $this->_manager_output((object)array('output' => '', 'js_files' => array(), 'css_files' => array()));
        //$this->manager_model->filtrar();
    }


    public function service_management(){

        $crud = new grocery_CRUD();

        $ticket_cost_centers_id = $this->session->userdata('cost_center_id');
        $query = $this->db->query('SELECT * FROM ticket_cost_centers WHERE id = ' . $ticket_cost_centers_id);
        $row = $query->row();
        $prefix = $row->prefix;

        $crud->set_table('services');
        $crud->columns( 'user_card_reference',  'created_at', 'updated_at', 'car_id', 'driver_id', 'state_payment', 'units' ,'value', 'charge1','charge2','charge3','charge4');
        $crud->where('pay_reference', '3');
        $crud->edit_fields('charge1', 'charge2', 'charge3','state_payment');
        $crud->unset_export();
        $crud->unset_print();

        $crud   ->display_as('state_payment', 'Estado pago')
            ->display_as('created_at', 'Fecha inicio servicio')
            ->display_as('updated_at', 'Fecha final servicio')
            ->display_as('address', 'Dirección')
            ->display_as('car_id', 'Placa')
            ->display_as('driver_id', 'Nombre y cédula conductor')
            ->display_as('cedula', 'Cédula conductor')
            ->display_as('value', 'Valor')
            ->display_as('user_card_reference', 'Vale')
            ->display_as('charge1', 'Aeropuerto')
            ->display_as('charge2', 'Nocturno/festivo')
            ->display_as('charge3', 'Mensajería')
            ->display_as('charge4', 'Puerta a Puerta')
            ->display_as('units', 'Unidades');

        $crud->like('user_card_reference', $prefix);

        $output = $crud->render();
        $this->_manager_output($output);
    }

    public function tickets_management(){

        $crud = new grocery_CRUD();

        $crud->set_table('ticket_tickets');
        $crud->columns('company_id', 'ticket', 'status', 'created_at', 'cost_center_id', 'commit');
        $crud->where('ticket_user_id', $this->session->userdata('cost_center_id'));

        $crud->display_as('company_id', 'Empresa')
            ->display_as('cost_center_id', 'Gerente')
            ->display_as('ticket', 'Vale')
            ->display_as('status', 'Estado')
            ->display_as('commit', 'Motivo vale')
            ->display_as('created_at', 'Fecha de creación');
        //$crud->where('company_id','company_id');
        //$crud->where('ticket_user_id', $this->session->userdata('parent_id'));

        $company_id = $this->session->userdata('company_id');
        // solo muestra los centro de costos de la empresa actual
        $crud->set_relation('company_id', 'ticket_companies', 'name', 'id IN (SELECT id FROM companies WHERE id=' . $company_id . ')');

        $crud->set_relation('ticket_user_id', 'ticket_users', 'name', 'id IN (SELECT id FROM ticket_users WHERE company_id=' . $company_id . ')');
        $crud->set_relation('status', 'ticket_status', 'name');

        if ($crud->getState() == 'add') {
            $crud->field_type('company_id', 'hidden');
        }

        if ($crud->getState() == 'edit') {
            $crud->field_type('ticket_user_id', 'hidden');
            $crud->field_type('company_id', 'hidden');
        }

        $crud->callback_before_insert(function ($post_array) {
            $post_array['company_id'] = $this->session->userdata('company_id');
            $post_array['ticket_user_id'] = $this->session->userdata('parent_id');

            return $post_array;
        });
        $crud->unset_add();
        $crud->unset_edit();

        $output = $crud->render();

        $this->_manager_output($output);

    }

}
