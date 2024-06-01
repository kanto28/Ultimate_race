<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	 
    public function __construct() {
        parent::__construct();      
    }

	public function home() {	
        $this->load->view('header/header');
		$this->load->view('page/index');
		$this->load->view('footer/footer');
	}

	



	public function formulaire_page()
	{
		$this->load->view('header/header');
		$this->load->view('page_template/formulaire');
		$this->load->view('footer/footer');
	}

    public function liste_page()
	{
		$this->load->view('header/header');
		$this->load->view('page_template/liste');
		$this->load->view('footer/footer');
	}

    public function modification_page()
	{
		$this->load->view('header/header');
		$this->load->view('page_template/modifier');
		$this->load->view('footer/footer');
	}

    public function suppression_page()
	{
		$this->load->view('header/header');
		$this->load->view('page_template/suppression');
		$this->load->view('footer/footer');
	}

    public function detail_page()
	{
		$this->load->view('header/header');
		$this->load->view('page_template/detail');
		$this->load->view('footer/footer');
	}

	
	public function profil()
	{
		$this->load->view('header/header');
		$this->load->view('page_template/profil');
		$this->load->view('footer/footer');
	}
	
}
