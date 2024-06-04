<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class Penalite_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		$this->load->model("participation_model");
		$this->load->model("DAO_model");
    }

	public function insert_penalite($id_etape, $id_equipe, $penalite) {
		$sql = "SELECT * from penalite where id_etape = $id_etape and id_equipe = $id_equipe";
		$penalite_obj = $this->DAO_model->find_by_request_one_row($sql);
		if(!empty($penalite_obj)) {
			throw new Exception("Equipe deja penalise sur cet etape");
		}

        $data = array(
            'id_etape' => $id_etape,
            'id_equipe' => $id_equipe,
            'penalite' => $penalite
        );
        return $this->db->insert('penalite', $data);
    }

	public function delete_penalite($id_penalite) {
        $this->db->where('id_penalite', $id_penalite);
        return $this->db->delete('penalite');
    }

	public function ajout_penalite($id_etape, $id_equipe, $penalite) {
		$this->db->trans_start();
		$this->insert_penalite( $id_etape, $id_equipe, $penalite );
		$this->participation_model->update_penalite( $id_etape ,$id_equipe );
		$this->db->trans_complete();
	}

	public function supprimer_penalite ( $id_penalite ) {
		$penalite = $this->DAO_model->find_by_id("penalite", $id_penalite);
		$id_equipe = $penalite["id_equipe"];
		$id_etape = $penalite["id_etape"];
		$this->db->trans_start();
		$this->participation_model->delete_penalite( $id_etape ,$id_equipe );
		$this->delete_penalite($id_penalite);
		$this->db->trans_complete();
	}



   
}
?>


