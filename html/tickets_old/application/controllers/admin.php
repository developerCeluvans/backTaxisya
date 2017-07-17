<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
    }

    public function index()
    {
        if ($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
        $this->load->model('admin_model');
        $data = array('titulo' => 'Bienvenido Administrador',
            'users' => $this->admin_model->get_users());

        $this->load->view('admin_view', $data);
    }

    public function crear_user()
    {

        $cliente = array(
            'company_name' => $this->input->post('company_name'),
            'company_nit' => $this->input->post('company_nit'),
            'company_phone' => $this->input->post('company_phone'),
            'company_contract' => $this->input->post('company_contract'),
            'contract_date' => $this->input->post('contract_date'),
            'company_address' => $this->input->post('company_address'),
            'descripcion' => $this->input->post('descripcion'),
            'responsable' => $this->input->post('responsable'),
            'cellphone' => $this->input->post('cellphone'),
            'descripcion' => $this->input->post('descripcion'),
            'username' => $this->input->post('usuario'),
            'perfil' => $this->input->post('perfil'),
            'password' => sha1($this->input->post('pass'))
        );

        $this->load->model('admin_model');
        $this->admin_model->user_add($cliente);

        redirect('admin/');

    }
}
