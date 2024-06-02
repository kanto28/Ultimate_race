<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class Participation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		$this->load->model('DAO_model'); 
    }


    public function insert_Participation($id_coureur, $id_etape, $heure_depart, $penalite = 0) {
		$data = [
			"id_coureur" => $id_coureur,
			"id_etape" => $id_etape,
			"heure_depart" => $heure_depart,
			"penalite_secondes" => $penalite
		];
        return $this->db->insert('participation', $data);
    }

	public function affecter_coureur($id_coureur, $id_etape) {
		$etape = $this->DAO_model->find_by_id("etape", $id_etape);
		$heure_depart = $etape["date_debut"];
		$nb_coureur_equipe = $etape["nb_coureur_equipe"];

		$coureur = $this->DAO_model->find_by_id("coureur", $id_coureur);
		$id_equipe = $coureur["id_equipe"];

		$sql = "SELECT count(*) as aff from v_participation_equipe where id_etape = $id_etape and id_equipe = $id_equipe ";
		$affecte = $this->DAO_model->find_by_request_one_row($sql);
		$affecte = $affecte["aff"];

		if($nb_coureur_equipe == $affecte) {
			throw new Exception("Efa feno");
		}

		$this->insert_Participation($id_coureur, $id_etape, $heure_depart);


	}

    public function get_coureurs_by_equipe($id_equipe) {
        $query = $this->db->get_where('coureur', array('id_equipe' => $id_equipe));
        return $query->result_array();
    }
   

   
}
?>