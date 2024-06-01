<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }

	public function index()
	{
		$this->load->view('page_admin/login_admin');
	}

	public function inscription()
	{
		$this->load->view('page/inscription');
	}

	public function dashboard()
	{
		$this->load->view('header/header');
		$this->load->view('page_admin/dashboard');
		$this->load->view('footer/footer');
	}



	// public function connecter_user(){
	// 	$username = trim($this->input->post('username'));
	// 	$password = trim($this->input->post('password'));
	// 	echo $username;
	// 	echo $password;
	// 	$user = $this->User_model->getUserByUsername($username);
	// 	if ($this->User_model->login($username, $password)) {
	// 		$this->session->set_userdata('user',$user);			
	// 		redirect('Login/dashboard');
	// 	} else {				
	// 		redirect('login/error_login/'.$username);
	// 	}
	// }	

	// public function connecter_user() {
	// 	$username = trim($this->input->post('username'));
	// 	$password = trim($this->input->post('password'));
		
	// 	// Déboguer les valeurs d'entrée
	// 	echo 'Username: ' . $username . '<br>';
	// 	echo 'Password: ' . $password . '<br>';

	// 	$user = $this->User_model->getUserByUsername($username);
	// 	if ($this->User_model->login($username, $password)) {
	// 		// Stockez uniquement l'ID utilisateur dans la session
	// 		$this->session->set_userdata('id_admin', $user['id_admin']);
	// 		var_dump($user['idutilisateur']);
	// 		redirect('Login/dashboard');
	// 	} else {
	// 		redirect('login/error_login/'.$username);
	// 	}
	// }

	public function connecter_admin() {
		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));
		
		// Déboguer les valeurs d'entrée
		echo 'Username: ' . $username . '<br>';
		echo 'Password: ' . $password . '<br>';
		
		$user = $this->Admin_model->getUserByUsername($username);
		//var_dump($user['idutilisateur']);
		// Vérifiez si la connexion réussit
		if ($this->Admin_model->login($username, $password)) {
			// Stockez uniquement l'ID utilisateur dans la session
			$this->session->set_userdata('id_admin', $user['id_admin']);
			
			// Déboguez la session utilisateur
			log_message('debug', 'Utilisateur connecté, ID utilisateur: ' . $user['id_admin']);
			echo 'Utilisateur connecté, ID utilisateur: ' . $user['id_admin'];
			var_dump($user['id_admin']);
			redirect('Admin/dashboard');
		} else {
			log_message('error', 'Échec de la connexion pour l\'utilisateur: ' . $username);
			echo 'Échec de la connexion pour l\'utilisateur: ' . $username;
			redirect('login/error_login/'.$username);
		}
	}
	



	public function error_login($username) {
		$data['error'] = 'Your Account is Invalid';
		if (isset($username)) {
			$data['username'] = $username;
		}
		$this->load->view('page/login', $data);
	}


    public function logout() {
        $this->session->sess_destroy();
        session_destroy();
        ob_clean();
        redirect('login');
    }
	
}
