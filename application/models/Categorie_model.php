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


  
    public function insert_categorie(){
        $query = "
        INSERT INTO categorie (nom_categorie)
        VALUES 
            ('Homme'),
            ('Femme'),
            ('Junior'),
            ('Senior')
    ";

    // Exécution de la requête
    $this->db->query($query);

    // Retourner le nombre de lignes affectées par l'insertion
    return $this->db->affected_rows();
      }


    

   
}
?>
