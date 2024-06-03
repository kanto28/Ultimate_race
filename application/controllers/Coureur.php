<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coureur extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
		$this->load->model('DAO_model'); 
		if ( empty($this->session->userdata("id_equipe")) ) {
            redirect('login/index');
        }
    }

	public function coureur_affectation()
	{

		$this->load->model("equipe_model");
		$this->load->model("participation_model");
		$this->load->model("etape_model");
		$id_equipe = $this->session->userdata('id_equipe');
		$data["pages"] = "affectation_coureur";
		$data["etapes_coureurs"] = $this->etape_model->getCoureur_chrono_etape($id_equipe);
		$data["erreur"] = "aucun";
		$this->load->view('dynamic-page', $data);
	}

	public function coureur_affectation_modal($id_etape = null) {
		$this->load->model("equipe_model");
		$this->load->model("participation_model");

		$etape = $this->DAO_model->find_by_id("etape", $id_etape);

		if(empty($etape) && empty($id_etape) ) {
			redirect('coureur/coureur_affectation');
		}
		
		$data["coureurs"] = $this->equipe_model->get_coureurs($this->session->userdata('id_equipe') );
		$data["erreur"] = "aucun";
		$data["etape"] = $etape;
		$data["pages"] = "affectation-coureur-modal";
		$id_coureur = $this->input->post("id_coureur");
		
		if( !empty($id_coureur) ) {
			try {
				$this->participation_model->affecter_coureur($id_coureur, $id_etape);
				redirect('coureur/coureur_affectation');
			} catch (Exception $e) {
				$data["erreur"] = $e->getMessage();
			}
		}

		$this->load->view('dynamic-page', $data);

	}

   
}
