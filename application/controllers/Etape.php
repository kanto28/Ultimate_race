<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etape extends CI_Controller {

    public function __construct() {
        parent::__construct();       
        $this->load->model('Etape_model'); 
		if ( empty($this->session->userdata("id_admin")) && empty ( ($this->session->userdata("id_equipe")  )) ) {
            redirect('login/index');
        }
    }

    public function liste_etape() {	
        $data['listeEtape'] = $this->Etape_model->getEtapes();
		$data['pages'] = "liste_etape";
		$this->load->view('dynamic-page',$data);
	}

	public function liste_etape_admin() {	
		$this->load->model("Etape_model");
        $data['listeEtape'] = $this->Etape_model->getEtapes();
		$data['pages'] = "liste_etape";
		if( !empty($this->session->userdata("id_admin")) ) {
			$pages = $data['pages'];
			$this->load->view('header/header_admin');
			$this->load->view("page/$pages", $data);
			$this->load->view('footer/footer');
		}
		else {
			$this->load->view('dynamic-page',$data);
		}
	}
	

    public function classement_etape() {	
		$this->load->model("Etape_model");
        $data['listeClassement'] = $this->Etape_model->getClassement_Etapes();
		$data['pages'] = "classement_etape";
		if( !empty($this->session->userdata("id_admin")) ) {
			$pages = $data['pages'];
			$this->load->view('header/header_admin');
			$this->load->view("page/$pages", $data);
			$this->load->view('footer/footer');
		}
		else {
			$this->load->view('dynamic-page',$data);
		}
	}

    public function classement_coureur() {	
		$this->load->model("Etape_model");
        $data['listeCoureur'] = $this->Etape_model->getClassement_coureur();
		$data['pages'] = "classement_coureur";
		if( !empty($this->session->userdata("id_admin")) ) {
			$pages = $data['pages'];
			$this->load->view('header/header_admin');
			$this->load->view("page/$pages", $data);
			$this->load->view('footer/footer');
		}
		else {
			$this->load->view('dynamic-page',$data);
		}
		
	}
	
   
}
