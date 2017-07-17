<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Central extends CI_Controller{

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

    public function _central_output($output = null){

        $this->load->view('central.php', (array)$output);

    }

    public function index(){

        $this->_central_output((object)array('output' => '', 'js_files' => array(), 'css_files' => array()));
        //$this->manager_model->filtrar();
    }

    public function tickets_management(){

        $crud = new grocery_CRUD();

        $cost_center_id = $this->session->userdata('cost_center_id');
        $query = $this->db->query('SELECT * FROM ticket_cost_centers WHERE id = ' . $cost_center_id);
        $row = $query->row();
        $vale = 'VALE';
        //$prefix = $row->prefix;

        $crud->set_table('services');
        $crud->columns('user_card_reference', 'created_at','car_id', 'driver_id', 'state_payment', 'units','pay_reference', 'value', 'charge1','charge2','charge3','charge4');

        $crud->add_fields('user_id', 'user_card_reference','address', 'pay_reference', 'barrio', 'units', 'created_at', 'driver_id', 'car_id', 'value', 'charge1', 'charge2', 'charge3');
        //$crud->add_field_default_value('pay_reference', 'VALE');

        $crud->edit_fields('charge1', 'charge2', 'charge3', 'state_payment', 'units', 'user_card_reference', 'pay_reference');
        $crud->set_relation('car_id', 'cars', 'placa');
        $crud->set_relation('driver_id','drivers','{name} {lastname} {cedula}');
        $crud->set_relation('user_id','users','{name} {lastname}');
        $crud->set_relation('status_id', 'status', 'descrip');
        $crud->callback_column('state_payment',array($this,'_callback_do_checkbox'));

        $crud ->display_as('state_payment', 'Estado vale')
              ->display_as('created_at', 'Fecha')
              ->display_as('user_id', 'Nombre usuario')
              ->display_as('address', 'Dirección')
              ->display_as('car_id', 'Placa')
              ->display_as('driver_id', 'Nombre  y cédula conductor')
              ->display_as('cedula', 'Cédula conductor')
              ->display_as('value', 'Valor')
              ->display_as('pay_reference', 'Tipo de pago')
              ->display_as('user_card_reference', 'Vale')
              ->display_as('charge1', 'Aeropuerto')
              ->display_as('charge2', 'Nocturno/festivo')
              ->display_as('charge3', 'Mensajería')
              ->display_as('charge4', 'Puerta a Puerta')
              ->display_as('units', 'Unidades');
        //$crud->where('pay_type', 3);
        $crud ->like('user_card_reference');

        $output = $crud->render();
        $this->_central_output($output);
    }

    public function _callback_do_checkbox($value, $row){

        $checked = ($value === '1') ? ' checked' : '';
        return '<input type="checkbox" class="inline_checkbox" data-id="' . $row->id . '"' . $checked . '>';
    }

}
