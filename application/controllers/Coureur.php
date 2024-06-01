<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coureur extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
		$this->load->model('DAO_model'); 
		if ( empty($this->session->userdata("id_equipe")) ) {
            redirect('controlleur_user/index');
        }
    }

	public function coureur_affectation()
	{

		$this->load->model("equipe_model");
		$this->load->model("participation_model");
		$data["pages"] = "affectation_coureur";
		$data["etapes"] = $this->DAO_model->find_all("etape");
		$data["coureurs"] = $this->equipe_model->get_coureurs($this->session->userdata('id_equipe') );
		$data["erreur"] = "aucun";

		$id_etape = $this->input->post("id_etape");
        $id_coureur = $this->input->post("id_coureur");
		
		if(!empty($id_etape) && !empty($id_coureur) ) {
			try {
				$this->participation_model->affecter_coureur($id_coureur, $id_etape);
			} catch (Exception $e) {
				$data["erreur"] = $e->getMessage();
			}
		}

		$this->load->view('dynamic-page', $data);
	}

   
}
