<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Managers extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('manager_model');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->load->library('grocery_CRUD');

    }

    public function _manager_output($output = null){

        $this->load->view('manager.php', (array)$output);

    }


    public function index(){

        $this->_manager_output((object)array('output' => '', 'js_files' => array(), 'css_files' => array()));
        //$this->manager_model->filtrar();
    }


    public function users_manager_management(){

        $crud = new grocery_CRUD();

        $crud->set_table('ticket_users');
        $crud->columns('id', 'name', 'cellphone', 'email', 'password');
        $crud->required_fields('name', 'cellphone', 'email', 'password');
        $crud->set_rules('password', 'Contraseña', array('required', 'min_length[6]'));

        $crud->display_as('id', 'Id')
            ->display_as('name', 'Nombre')
            ->display_as('cellphone', 'Celular')
            ->display_as('company_id', 'Empresa')
            ->display_as('email', 'Email');
        $crud->required_fields('name', 'cellphone', 'email', 'password');

        $crud->change_field_type('password', 'password');
        $company_id = $this->session->userdata('company_id');
        // solo muestra los centro de costos de la empresa actual
        //$crud->set_relation('cost_center_id','cost_centers','name', 'id IN (SELECT id FROM cost_centers WHERE company_id='.$company_id.' )');
        $crud->where('cost_center_id', $this->session->userdata('cost_center_id'));
        $crud->where('role', 'report');


        if ($crud->getState() == 'add') {
            $crud->field_type('cost_center_id', 'hidden');
            $crud->field_type('company_id', 'hidden');
            $crud->field_type('parent_id', 'hidden');
            $crud->field_type('role', 'hidden');
        }

        if ($crud->getState() == 'edit') {
            $crud->field_type('cost_center_id', 'hidden');
            $crud->field_type('company_id', 'hidden');
            $crud->field_type('role', 'hidden');
            $crud->field_type('parent_id', 'hidden');
        }

        //CALLBACKS
        $crud->callback_before_insert(function ($post_array) {
            $post_array['password'] = sha1($post_array['password']);
            $post_array['company_id'] = $this->session->userdata('company_id');
            $post_array['parent_id'] = $this->session->userdata('user_id');
            $post_array['cost_center_id'] = $this->session->userdata('cost_center_id');
            $post_array['role'] = 'report';
            return $post_array;
        });

        $output = $crud->render();

        $this->_manager_output($output);

    }


    public function tickets_management(){

        $crud = new grocery_CRUD();

        $crud->set_table('ticket_tickets');
        $crud->columns('company_id', 'ticket', 'status', 'created_at', 'cost_center_id', 'commit');
        $crud->where('ticket_user_id', $this->session->userdata('cost_center_id'));
        $crud//->display_as('id', 'Id')
        ->display_as('company_id', 'Empresa')
            ->display_as('cost_center_id', 'Gerente')
            ->display_as('ticket', 'Vale')
            ->display_as('status', 'Estado')
            ->display_as('commit', 'Dependencia')
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

    public function service_management(){

        $crud = new grocery_CRUD();

        $ticket_cost_centers_id = $this->session->userdata('cost_center_id');
        $query = $this->db->query('SELECT * FROM ticket_cost_centers WHERE id = ' . $ticket_cost_centers_id);
        $row = $query->row();
        $prefix = $row->prefix;

        $qualification = 1;
        $qualy = $this->db->query('SELECT * FROM services WHERE qualification = '.$qualification );

        if($qualy == "1"){

            $qualy== "MUY BUENO";
        }

        $crud->set_table('services');
        $crud->columns('user_card_reference', 'created_at', 'status_id',  'address', 'car_id', 'driver_id', 'user_id', 'qualification','units', 'charge1', 'charge2', 'charge3', 'charge4', 'value');
        $crud->set_relation('car_id', 'cars', 'placa');
        $crud->set_relation('driver_id', 'drivers', '{name} {lastname}');
        $crud->set_relation('user_id','users','name');
        $crud->set_relation('status_id', 'status', 'descrip');

        $crud
            ->display_as('user_email', 'Correo')
            ->display_as('created_at', 'Fecha')
            ->display_as('status_id', 'Estado')
            ->display_as('address', 'Dirección')
            ->display_as('car_id', 'Placa')
            ->display_as('qualification', 'Calificación')
            ->display_as('user_id', 'Nombre usuario')
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
        $crud->like('user_card_reference', $prefix);
        //$crud->where('cost_center_id', $this->session->userdata('cost_center_id'));

        $crud->unset_add();
        $crud->unset_edit();

        $output = $crud->render();

        $this->_manager_output($output);
    }


    public function crear_ticket(){

            //$last = 2;
            //$prefix = "YM";
        $tot = $this->input->post('tot_tickets');
        $hours = $this->input->post('tot_hours');
        $tot_commit = $this->input->post('tot_commit');
        $name = $this->session->userdata('name');
        $end_at = $this->session->userdata('end_at');
        $cost_id = $this->session->userdata('cost_center_id');
        $company_id = $this->session->userdata('company_id');

        $query = $this->db->query('SELECT * FROM ticket_cost_centers WHERE id = ' . $cost_id);
        $row = $query->row();
        $prefix = $row->prefix;

        $ultimo_id = $row->numerator;

        $now = new DateTime(); //current date/time
        $current = $now->format('Y-m-d H:i:s');

        // adiciono x horas a la fecha de creación
        $now->add(new DateInterval("PT{$hours}H"));
        $new_time = $now->format('Y-m-d H:i:s');

        for ($i = 0; $i < $tot; $i++) {

            $id_tick = str_pad($ultimo_id, 5, "0", STR_PAD_LEFT);

            $tk = $prefix . $id_tick;

            $ticket = array(
                "company_id" => $company_id,
                "ticket" => $tk,
                "ticket_user_id" => $cost_id,
                "created_at" => $current,
                "end_at" => $new_time,
                "cost_center_id" => $name,
                "commit" => $tot_commit,
                "time_expired" => $hours,
                "status" => 0
            );
            $this->manager_model->ticket_add($ticket);
            $ultimo_id++;
        }

        // actualiza rango
        $query = $this->db->query('UPDATE ticket_cost_centers SET numerator = ' . $ultimo_id . ' WHERE id = ' . $cost_id);


        redirect('managers/');
    }

    function update_status(){

        $new_time = $this->input->post('end_at');

        if ($new_time > date("Y/m/d H:i:s")){

            $status = $this->input->post('3');
            $this->manager_model->ticket_add($status);
        }
    }

}
