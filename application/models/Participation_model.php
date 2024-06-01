<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class Participation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function insert_Participation($data) {
        return $this->db->insert('participation', $data);
    }

    public function get_coureurs_by_equipe($id_equipe) {
        $query = $this->db->get_where('coureur', array('id_equipe' => $id_equipe));
        return $query->result_array();
    }
   

   
}
?>
