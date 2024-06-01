<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class Etape_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function getEtapes() {
        return $this->db->get('etape')->result_array();
    }


   
   
}
?>
