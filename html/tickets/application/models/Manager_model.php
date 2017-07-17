<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Manager_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function login_user($username,$password){

		$this->db->where('email',$username);
		$this->db->where('password',$password);
		$query = $this->db->get('ticket_users');
		if($query->num_rows() == 1) {

			return $query->row();
		}else{
			$this->session->set_flashdata('usuario_incorrecto','Los datos introducidos son incorrectos');
			redirect(base_url().'login','refresh');
		}
	}

	public function ticket_add($ticket){

        if ($this->db->insert('ticket_tickets', $ticket)) {
            return true;
        } else {
            return false;
        }

    }

    public function ticket_update($id, $ticket){

        $this->db->where('id', $id);
        $this->db->update('tickets', $ticket);

	}

    public function update_status($id, $status){

        $status = array(
            'status' => $status
        );

        $this->db->where('id', $id);
        return $this->db->update('ticket_cost_centers', $status);
    }

}
