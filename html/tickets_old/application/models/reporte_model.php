<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Reporte_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
	}

	


	public function get_servicios()
	{
 
       //$query = $this->db->query('SELECT * FROM `tickets_users` us INNER JOIN services ser ON us.id_cliente = ser.company_id WHERE us.id ='.$this
       $query = $this->db->query('SELECT * FROM services WHERE company_id = 2');
       //$query = $this->db->query('SELECT * FROM services WHERE company_id ='.$this->session->userdata('id_usuario'));
		//$query = $this->db->get_where('servicios', array('cliente_id' => $this->session->userdata('id_usuario')));

		if($query->num_rows() > 0)
		{
 
			return $query->result();
 
		}
 
	}
	
	
	

}
