<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Gerente_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
	}
	
	public function servicio_add($servicio)
	{
	
		if( $this->db->insert('services',$servicio)){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function get_servicios()
	{
 
		$query = $this->db->get('services');
		if($query->num_rows() > 0)
		{
 
			return $query->result();
 
		}
 
	}
	
	public function get_ticket()
	{
 
		//$query = $this->db->get('tickets');
		$query = $this->db->get_where('tickets', array('company_id' => $this->session->userdata('id_cliente')));
		if($query->num_rows() > 0)
		{
 
			return $query->result();
 
		}
		return array();

 
	}
	
	public function get_ticketFull()
	{
 		$query = $this->db->query('SELECT * FROM tickets WHERE company_id != '.$this->session->userdata('id_usuario'));
		
		
		if($query->num_rows() > 0)
		{
 
			return $query->result();
 
		}
 
	}
	
	public function ticket_add($ticket)
	{
	
		if( $this->db->insert('tickets',$ticket)){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function ticket_update($id,$ticket)
	{
	
		$this->db->where('id', $id);
		$this->db->update('tickets', $ticket); 
		
	}
	
		public function user_add($cliente)
	{
	
		if( $this->db->insert('tickets_users',$cliente)){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function get_users()
	{
        $query = $this->db->get_where('tickets_users', array('id_cliente' => $this->session->userdata('id_cliente')));
	

		if($query->num_rows() > 0)
		{
 
			return $query->result();
 
		}
		return array();
		
 
	}

	public function get_center_costs()
    {
    	$query = $this->db->query('SELECT * FROM cost_centers WHERE company_id = ' . $this->session->userdata('id_cliente'));
        if ($query->num_rows() > 0) {
            foreach($query->result_array() as $row) {
                 $return[$row['id']] = $row['name'];
            }

            //return $query->result();
            return $return;


        }
        return array();
    }
	

}