<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class Etape_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		$this->load->model('DAO_model'); 
    }


    public function getEtapes() {
        return $this->db->get('etape')->result_array();
    }

	public function getCoureur_chrono_par_etape($id_etape, $id_equipe) {
		$sql = "SELECT * from coureur_temps_corrige_lib where id_etape = $id_etape and id_equipe = $id_equipe";
		return $this->DAO_model->find_by_request($sql);
	}

	public function getCoureur_chrono_etape($id_equipe) {
		$val = array();
		$etapes = $this->DAO_model->find_all("etape");
		foreach($etapes as $e) {
			array_push($val,
				[
					"etape" => $e,
					"coureurs" => $this->getCoureur_chrono_par_etape($e['id_etape'], $id_equipe)
				]
			);
		}
		return $val;
	}


    public function getClassement_Etapes() {
        return $this->db->get('v_classement_etape_complet')->result_array();
    }
   
    
    public function getClassement_coureur() {
        return $this->db->get('classement_general_coureur')->result_array();
    }
   
   
}
?>
