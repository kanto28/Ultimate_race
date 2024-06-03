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
		$data['pages'] = "classement_equipe";

		$categ = $this->input->get("categ");
		if(empty($categ)) {
			$categ = "Tous";
		}
		$data['categ'] = $categ;
		$data['listeEquipe'] = $this->Equipe_model->getClassement($categ);

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
