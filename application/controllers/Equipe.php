<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipe extends CI_Controller  {

    public function __construct() {
        parent::__construct();       
        $this->load->model('Equipe_model'); 
		if ( empty($this->session->userdata("id_admin")) && empty ( ($this->session->userdata("id_equipe")  )) ) {
			redirect('login/index');
        }
    }
	

    public function classement_equipe() {	
        $data['listeEquipe'] = $this->Equipe_model->getClassement_Equipe();
		$data['pages'] = "classement_equipe";
		if( !empty($this->session->userdata("id_admin")) ) {
			$this->load->view('dynamic-admin-page',$data);
		}
		else {
			$this->load->view('dynamic-page',$data);
		}

	}

	
}
