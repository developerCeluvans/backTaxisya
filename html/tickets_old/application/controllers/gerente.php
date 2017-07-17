<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Gerente extends CI_Controller
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

        if ($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'gerente') {
            redirect(base_url() . 'login');
        }
        $this->load->model('gerente_model');
        $this->load->model('admin_model');

        $data = array('titulo' => 'Bienvenido de nuevo ' . $this->session->userdata('perfil'),
            'tickets' => $this->gerente_model->get_ticket(),
            'cost_centers' => $this->gerente_model->get_center_costs(),
            'users' => $this->gerente_model->get_users());

        $this->load->view('gerente_view', $data);
    }

    public function crear_ticket()
    {

        $this->load->model('gerente_model');

        $cont = count($_POST['ticket']);

        for ($i = 0; $i <= $cont; $i++) {
            if (isset($_POST['ticket'][$i])) {
                echo $_POST['ticket'][$i];
                $ticket = array(
                    "company_id" => $this->input->post('cliente_id'),
                    "ticket" => $_POST['ticket'][$i],
                    "status" => 0
                );

                $this->gerente_model->ticket_add($ticket);
                $ultimo_id = $this->db->insert_id();

                $id_tick = str_pad($ultimo_id, 5, "0", STR_PAD_LEFT);
                if ($ultimo_id == 0) {
                    $tick = $_POST['ticket'][$i] . "0001";
                } else {
                    $tick = $_POST['ticket'][$i] . $id_tick;
                }
                $ticket = array(
                    "ticket" => $tick
                );
                $this->gerente_model->ticket_update($ultimo_id, $ticket);

            }
        }
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

        $this->load->model('gerente_model');
        $this->cliente_model->user_add($cliente);

        redirect('cliente/');

    }

    public function buscar_ticket()
    {

        header("Content-Type: application/json");

        $this->load->model('gerente_model');
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
