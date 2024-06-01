<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coureur extends CI_Controller {

    public function __construct() {
        parent::__construct(); 
    }

	public function coureur_affectation()
	{
		$this->load->view('header/header');
		$this->load->view('page/affectation_coureur');
		$this->load->view('footer/footer');
	}

   
}
