<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class Test_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function insert_Test($data) {
        return $this->db->insert('nom_table', $data);
    }
   
    public function get_Test_detail($id_table) {
        $query = $this->db->get_where('nom_table', array('id_table' => $id_table));
        return $query->row_array();
	}
    
    public function getTest() {
        return $this->db->get('nom_table')->result_array();
    }

    public function getRows(){
        $this->db->select('COUNT(id_table) as num_rows');
        $query = $this->db->get('nom_table');
        return $query->row()->num_rows;
    }


    

   
}
?>
