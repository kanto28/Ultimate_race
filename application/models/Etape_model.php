<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class Etape_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function getEtapes() {
        return $this->db->get('etape')->result_array();
    }


    public function getClassement_Etapes() {
        return $this->db->get('v_classement_etape_complet')->result_array();
    }
   
    
    public function getClassement_coureur() {
        return $this->db->get('classement_general_coureur')->result_array();
    }
   
   
}
?>
