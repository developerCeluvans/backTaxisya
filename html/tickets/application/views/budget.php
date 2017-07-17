<?php

$this->load->database();

$query = $this->db->query('SELECT id, company_id, budget FROM ticket_cost_centers');



$row = $query->row();

echo $row->budget;

?>