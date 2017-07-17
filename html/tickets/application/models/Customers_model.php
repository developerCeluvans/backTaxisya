<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: developer_celuvans
 * Date: 6/15/17
 * Time: 10:45
 */
class Customers_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function restBudget($bugdet, $available, $used){

        $this->db->set('bugdet', '$budget - $used' ,false);
        $this->db->where('bugdet',$bugdet);
        $this->db->where('available',$available);
        $this->db->where('used',$used);

        $this->db->update($available);

    }

}