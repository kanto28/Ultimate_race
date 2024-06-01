<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etape extends CI_Controller {

    public function __construct() {
        parent::__construct();       
        $this->load->model('Etape_model'); 
    }

    public function liste_etape() {	
        $idutilisateur = $this->session->idutilisateur;
        $data['listeEtape'] = $this->Etape_model->getEtapes();
        $this->load->view('header/header');
		$this->load->view('page/liste_etape',$data);
		$this->load->view('footer/footer');
	}
	

   
}
