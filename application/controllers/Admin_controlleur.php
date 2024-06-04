<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_controlleur extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
		$this->load->model('DAO_model'); 
		if ( empty($this->session->userdata("id_admin")) ) {
            redirect('login/index');
        }
    }

	
	public function coureur_affectation_temps() {
		$this->load->model("participation_model");
		$data["pages"] = "affectation-coureur-temps";
		$data["etapes"] = $this->DAO_model->find_all("etape");
		$data["erreur"] = "aucun";

		$id_etape = $this->input->post("id_etape");
        $id_coureur = $this->input->post("id_coureur");
		$temps = $this->input->post("temps");
		
		if(!empty($id_etape) && !empty($id_coureur) ) {
			try {
				$this->participation_model->affecter_temps_coureur($id_coureur, $id_etape ,$temps);
				redirect('admin_controlleur/coureur_affectation_temps');
			} catch (Exception $e) {
				$data["erreur"] = $e->getMessage();
			}
		}

		$this->load->view('dynamic-admin-page', $data);
	}

	public function coureur_etape($id_etape) {	
		$this->load->model('participation_model');
        error_reporting(E_ERROR | E_PARSE);
        $coureur = $this->participation_model->get_courreur_en_cours($id_etape);
        header('Content-Type: application/json');
        echo json_encode($coureur);
	}

	public function recategoriser() {
		$this->load->model('categorie_model'); 
		$this->categorie_model->recategoriser();
		redirect('Admin/dashboard');
	}

	public function gestion_penalite() {
		$this->load->model("penalite_model");
		$data["pages"] = "gestion-penalite";
		$data["etapes"] = $this->DAO_model->find_all("etape");
		$data["equipes"] = $this->DAO_model->find_all("equipe");
		$data["penalites"] = $this->DAO_model->find_all("v_penalite");
		$data["erreur"] = "aucun";

		$id_etape = $this->input->post("id_etape");
        $id_equipe = $this->input->post("id_equipe");
		$temps = $this->input->post("temps");
		
		if(!empty($id_etape) && !empty($id_equipe) && !empty($temps) ) {
			try {
				// echo $temps;
				$this->penalite_model->ajout_penalite($id_etape, $id_equipe, $temps);
				redirect('admin_controlleur/gestion_penalite');
			} catch (Exception $e) {
				$data["erreur"] = $e->getMessage();
			}
		}

		$this->load->view('dynamic-admin-page', $data);
	}

	public function supprimer_penalite($id_penalite = null ) {
		if(!empty($id_penalite)) {
			$this->load->model("penalite_model");
			$this->penalite_model->supprimer_penalite ($id_penalite);		
		}
		
	}

	

   
}
