<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Reporte extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->database('default');
	}
	
	public function index()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'reporte')
		{
			redirect(base_url().'login');
		}
		$this->load->model('admin_model');
		$this->load->model('reporte_model');
		$data = array('titulo' => 'Bienvenido Usuario Reporte',
					  'servicios' => $this->reporte_model->get_servicios());
					  
		$this->load->view('reporte_view',$data);
	}
}
