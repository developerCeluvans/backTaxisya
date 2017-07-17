<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');

        $this->load->library('grocery_CRUD');

    }

    public function _service_output($output = null){

        $this->load->view('payment.php', (array)$output);

    }

    public function index(){

        $this->_service_output((object)array('output' => '', 'js_files' => array(), 'css_files' => array()));
        //$this->manager_model->filtrar();
    }

    public function tickets_management(){

        $crud = new grocery_CRUD();

        $cost_center_id = $this->session->userdata('cost_center_id');
        $query = $this->db->query('SELECT * FROM ticket_cost_centers WHERE id = ' . $cost_center_id);
        $row = $query->row();
        //$prefix = $row->prefix;

        $crud->set_table('services');
        $crud->columns( 'user_card_reference',  'created_at', 'updated_at', 'car_id', 'driver_id', 'state_payment', 'units' ,'value', 'charge1','charge2','charge3','charge4');
        $crud->where('pay_reference', 'VALE');
        $crud->where('status_id', '5');
        $crud->unset_add();
        $crud->edit_fields('charge1', 'charge2', 'charge3','state_payment');
        $crud->get_js_files('charge1');
        $crud->set_relation('car_id', 'cars', 'placa');
        $crud->set_relation('driver_id','drivers','{name} {lastname} {cedula}');
        $crud->set_relation('status_id', 'status', 'descrip');
        $crud->set_relation('cedula', 'drivers', 'cedula');

        $crud->callback_column('state_payment',array($this,'_callback_do_checkbox'));
        //$crud->callback_field('units',array($this,'my_sum_function'));

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
        $crud->where('pay_type', 3);
        $crud ->like('user_card_reference');

        $output = $crud->render();
        $this->_service_output($output);

    }

    public function _callback_do_checkbox($value, $row){

        $checked = ($value === '1') ? ' checked' : '';
        return '<input type="checkbox" class="inline_checkbox" data-id="' . $row->id . '"' . $checked . '>';
    }

    public function filtrar_tickets(){

        $crud = new grocery_CRUD();

        $cost_center_id = $this->session->userdata('cost_center_id');
        $query = $this->db->query('SELECT * FROM ticket_cost_centers WHERE id = ' . $cost_center_id);
        $row = $query->row();
        //$prefix = $row->prefix;

        $crud->set_table('services');
        $crud->columns('state_payment');

        $crud   ->display_as('state_payment', 'Estado vale');
        $crud->where('pay_type', 3);
        $crud ->like('user_card_reference');

        $output = $crud->render();
        $this->_service_output($output);

    }

    public function sumar_ticket(){


    }

}
