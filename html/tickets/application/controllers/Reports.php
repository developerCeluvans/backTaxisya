<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller{
    
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

        $this->load->view('report.php', (array)$output);
    }

    public function index(){

        $this->_service_output((object)array('output' => '', 'js_files' => array(), 'css_files' => array()));
    }

    public function service_management(){

        $crud = new grocery_CRUD();

        $cost_center_id = $this->session->userdata('cost_center_id');
        $query = $this->db->query('SELECT * FROM ticket_cost_centers WHERE id = ' . $cost_center_id);
        $row = $query->row();
        $prefix = $row->prefix;


        $crud->set_table('services');
        $crud->columns( 'user_card_reference', 'created_at', 'status_id', 'user_email', 'address', 'car_id', 'driver_id', 'units' ,'qualification', 'charge1','charge2','charge3','charge4', 'value');
        $crud->set_relation('car_id', 'cars', 'placa');
        $crud->set_relation('driver_id','drivers','{name} {lastname}');
        $crud->set_relation('status_id', 'status', 'descrip');

        $crud
            ->display_as('user_email', 'Correo')
            ->display_as('created_at', 'Fecha')
            ->display_as('status_id', 'Estado')
            ->display_as('address', 'Dirección')
            ->display_as('car_id', 'Placa')
            ->display_as('qualification', 'Calificación')
            ->display_as('driver_id', 'Nombre conductor')
            ->display_as('value', 'Valor')
            ->display_as('address', 'Dirección')
            ->display_as('user_card_reference', 'Vale')
            ->display_as('charge1', 'Aeropuerto')
            ->display_as('charge2', 'Nocturno/festivo')
            ->display_as('charge3', 'Mensajería')
            ->display_as('charge4', 'Puerta a Puerta')
            ->display_as('units', 'Unidades');
        $crud->where('pay_type', 3);
        $crud ->like('user_card_reference',$prefix);
        //$crud->where('cost_center_id', $this->session->userdata('cost_center_id'));

        $crud->unset_add();
        $crud->unset_edit();

        $output = $crud->render();

        $this->_service_output($output);
    }


}
