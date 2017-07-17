<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Cliente extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
    }

    public function index()
    {

        if ($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'cliente') {
            redirect(base_url() . 'login');
        }
        $this->load->model('cliente_model');
        $this->load->model('admin_model');


        $data = array('titulo' => 'Bienvenido de nuevo ' . $this->session->userdata('perfil'),
            'costs' => $this->cliente_model->get_center_costs(),
            'users' => $this->cliente_model->get_users_gerente());


        $this->load->view('cliente_view', $data);
    }

    public function crear_servicio()
    {

        $servicio = array(
            "direccion" => $this->input->post('direccion'),
            "tipo" => $this->input->post('tipo'),
            "cliente_id" => $this->input->post('cliente'),
            "comentario" => $this->input->post('comentario')
        );

        $this->load->model('cliente_model');
        $this->cliente_model->servicio_add($servicio);

        redirect('cliente/');
    }


    public function crear_cost_center() {
           $cost = array(
            'name' => $this->input->post('cost_name'),
            'last_range' => $this->input->post('cost_last'),
            'prefix' => $_POST['ticket'][0] ,
            'budget_total' => $this->input->post('cost_budg'),
            'budget_available' => $this->input->post('cost_avail'),
            'company_id' => $this->input->post('id_cliente')
        );
        $this->load->model('cliente_model');
        $this->cliente_model->center_cost_add($cost);
        redirect('cliente/');
    }

    public function crear_ticket()
    {
        $this->load->model('cliente_model');
        $cont = count($_POST['ticket']);


        $last = 2;
        $prefix = "YM";

        $tot = $this->input->post('tot_tickets');
        
        $cost_id = $this->input->post('cost_id');

        $query = $this->db->query('SELECT * FROM cost_centers WHERE id = ' . $cost_id);
   //     $query = $this->db->query('SELECT * FROM cost_centers WHERE id = 3');
        $row = $query->row();
        $prefix = $row->prefix;

        $ultimo_id = $row->last_range;
    
        for ($i = 0; $i < $tot; $i++) {

                $id_tick = str_pad($ultimo_id, 5, "0", STR_PAD_LEFT);

                $tk = $prefix . $id_tick;

                $ticket = array(
                    "company_id" => $this->input->post('cliente_id'),
                    "ticket" => $tk,
                    "cost_center_id" => $cost_id,
                    "status" => 0
                );
                $this->cliente_model->ticket_add($ticket);
                $ultimo_id++;

        }

        // actualiza rango
        $query = $this->db->query('UPDATE cost_centers SET last_range = '. $ultimo_id.' WHERE id = ' . $cost_id);


        

/*
        for ($i = 0; $i <= $cont; $i++) {
            if (isset($_POST['ticket'][$i])) {
                echo $_POST['ticket'][$i];

                $ticket = array(
                    "company_id" => $this->input->post('cliente_id'),
                    "ticket" => $_POST['ticket'][$i],
                    "status" => 0
                );

                $this->cliente_model->ticket_add($ticket);
                $ultimo_id = $this->db->insert_id();
                $id_tick = str_pad($ultimo_id, 5, "0", STR_PAD_LEFT);
                if ($ultimo_id == 0) {
                    $tick = $_POST['ticket'][$i] . "0001";
                } else {
                    $tick = $_POST['ticket'][$i] . $id_tick;
                }
                $ticket = array("ticket" => $tick);
                $this->cliente_model->ticket_update($ultimo_id, $ticket);
            }
        }
*/

        redirect('cliente/');
    }

    public function crear_user()
    {
        $cliente = array(
            'username' => $this->input->post('usuario'),
            'perfil' => $this->input->post('perfil'),
            'password' => sha1($this->input->post('pass')),
            'descripcion' => $this->input->post('descripcion'),
            'id_cliente' => $this->input->post('id_cliente')
        );
        $this->load->model('cliente_model');
        $this->cliente_model->user_add($cliente);
        redirect('cliente/');
    }

    public function buscar_ticket()
    {
        header("Content-Type: application/json");
        $this->load->model('cliente_model');
        $data = $this->cliente_model->get_ticketFull();
        $ticket = $this->input->post('ticket');
        foreach ($data as $d) {
            $doslet = substr($d->ticket_id, 0, 2);
            if ($ticket == $doslet || $ticket == strtolower($doslet)) {
                echo json_encode("Este prefijo ya existe");
            }
        }
    }
}
