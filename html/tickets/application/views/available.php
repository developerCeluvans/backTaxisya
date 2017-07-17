<?php
/**
 * Created by PhpStorm.
 * User: developer_celuvans
 * Date: 6/13/17
 * Time: 14:36
 */

$this->load->database();

$query = $this->db->query('SELECT id, company_id, available FROM ticket_cost_centers');



$row = $query->row();

echo $row->available;

?>