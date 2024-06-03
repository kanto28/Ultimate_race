
<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');

class Csv_model extends CI_Model{
   
    
    public function insert_point($data) {
        $data_insert = array(
            'rang' => $data[0],
            'points' => $data[1]
        );
        $this->db->insert('table_point_ref', $data_insert);
    }

    public function insert_all_data_point() {
        $query = $this->db->get('table_point_ref');
        $donnee = $query->result();

        foreach ($donnee as $key => $value) {
            $data = array(
                'rang' => $value->rang,
                'points' => $value->points
            );
        }
    }



 
}