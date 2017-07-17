<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Admin_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
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
 

		//$query = $this->db->get('tickets_users');
		//$query = $this->db->get_where('tickets_users', array('perfil' => 'cliente')));
	    $query = $this->db->query("SELECT * FROM tickets_users WHERE perfil = 'cliente' ");
		if($query->num_rows() > 0)
		{
 
			return $query->result();
 
		}
		return array();
 
	}
}
