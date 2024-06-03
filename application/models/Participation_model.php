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

		$sql_verif = "SELECT * from participation where id_coureur = $id_coureur and id_etape = $id_etape";
		$verif = $this->DAO_model->find_by_request_one_row($sql_verif);

		if( !empty($verif) ) {
			throw new Exception("Coureur deja affecte");
		}


		$etape = $this->DAO_model->find_by_id("etape", $id_etape);
		$heure_depart = $etape["date_debut"];
		$nb_coureur_equipe = $etape["nb_coureur_equipe"];

		$coureur = $this->DAO_model->find_by_id("coureur", $id_coureur);
		$id_equipe = $coureur["id_equipe"];

		$sql = "SELECT count(*) as aff from v_participation_equipe where id_etape = $id_etape and id_equipe = $id_equipe ";
		$affecte = $this->DAO_model->find_by_request_one_row($sql);
		$affecte = $affecte["aff"];

		if($nb_coureur_equipe == $affecte) {
			throw new Exception("Nombre maximum d'affectation atteint ");
		}

		$this->insert_Participation($id_coureur, $id_etape, $heure_depart);
	}

    public function get_coureurs_by_equipe($id_equipe) {
        $query = $this->db->get_where('coureur', array('id_equipe' => $id_equipe));
        return $query->result_array();
    }

	public function get_courreur_en_cours($id_etape) {
		$sql = "SELECT * from v_coureur_en_course where id_etape = $id_etape";
		$val = $this->DAO_model->find_by_request($sql);
		return $val;
	}

	public function affecter_temps_coureur($id_coureur, $id_etape, $temps) {
		$sql = "UPDATE participation 
				set heure_arrivee = heure_depart + '$temps' 
				where id_etape = $id_etape 
				and id_coureur = $id_coureur";
		echo $sql;
		$this->db->query($sql);
	}
   

   
}
?>
