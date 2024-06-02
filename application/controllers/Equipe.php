<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipe extends CI_Controller  {

    public function __construct() {
        parent::__construct();       
        $this->load->model('Equipe_model'); 
		if ( empty($this->session->userdata("id_admin")) && empty ( ($this->session->userdata("id_equipe")  )) ) {
            redirect('controlleur_user/index');
        }
    }
	

    public function classement_equipe() {	
        $idutilisateur = $this->session->idutilisateur;
        $data['listeEquipe'] = $this->Equipe_model->getClassement_Equipe();
        $this->load->view('header/header');
		$this->load->view('page/classement_equipe',$data);
		$this->load->view('footer/footer');
	}

	
}
