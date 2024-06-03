<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class Categorie_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		$this->load->model('DAO_model'); 
    }


	public function recategoriser() {
		$recateg_path = base_url("sql/script-recategorisation.sql");
        $recateg_file_content = file_get_contents($recateg_path);
        $this->db->query($recateg_file_content);
	}


  


    

   
}
?>
