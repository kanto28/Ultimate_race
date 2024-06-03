
<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');

class Csv_model extends CI_Model{
   
    public function __construct() {
        parent::__construct();
        $this->load->model('Point_model');
    }

    public function insert_point($data) {
        $data_insert = array(
            'rang' => $data[0],
            'points' => $data[1]
        );
        //var_dump($data_insert);
        $this->db->insert('table_point_ref', $data_insert);
        $this->db->insert_id();
    }
    

    public function insert_all_data_point() {
        $query = $this->db->get('table_point_ref');
        $donnee = $query->result();

        foreach ($donnee as $key => $value)
        {
            
            $data = array(
                'rang' => $value->rang,
                'points' => $value->points

            );

            $this->Point_model->insert_point($data);

        }
    }


}