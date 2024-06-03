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
	
	public function renitialiser()
	{
		$this->load->view('header/header_admin');
		$this->load->view('page_admin/renitialiser');
		$this->load->view('footer/footer');
	}
	
	public function inscription()
	{
		$this->load->view('page/inscription');
	}

	public function dashboard()
	{
		$this->load->view('header/header_admin');
		$this->load->view('page_admin/dashboard');
		$this->load->view('footer/footer');
	}



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

	public function reinitialiserDonnees() {
		if ($this->input->post('reinitialiser') == 1) {
		 
			$sql = "
			DO $$ 
			DECLARE 
				r RECORD; 
			BEGIN 
				FOR r IN (SELECT tablename FROM pg_tables WHERE schemaname='public') LOOP 
					IF r.tablename != 'admin' THEN
						EXECUTE 'TRUNCATE TABLE ' || quote_ident(r.tablename) || ' CASCADE'; 
					END IF;
				END LOOP; 
			END $$;
			";
	
		   
			$this->db->query($sql);
		   
			$this->session->set_flashdata('success_message', 'Les données ont été réinitialisées avec succès.');
	
	
		  
			redirect('Admin/dashboard');
		}
	}

	public function import_etape_resultat()
	{
		$data["pages"] = "import_etape_resultat";
		$data['erreur'] = "aucun";
	
		if (!empty($_FILES['etape_csv']['tmp_name']) && !empty( $_FILES['participation_csv']['tmp_name'] ) ) {
            // Load CSV reader library
            $this->load->library('CSVReader'); 
			$this->load->model('csv_donne'); 
            
            // Chemin de téléchargement du fichier CSV
            $csv_file_etape = $_FILES['etape_csv']['tmp_name'];
			$csv_file_participation = $_FILES['participation_csv']['tmp_name'];
			
            // Parse data from CSV file
            $csvDataEtape = $this->csvreader->parse_csv_delimiter($csv_file_etape, ',');
			$csvDataParticipation = $this->csvreader->parse_csv_delimiter($csv_file_participation, ',');

            // Afficher les données du fichier CSV
            // print_r( $csvDataEtape );
			// print_r( $csvDataParticipation );
            try {
				$this->csv_donne->import_csv_donne( $csvDataEtape, $csvDataParticipation );
                redirect('Admin/import_etape_resultat');
            } catch (Exception $e) {
                $data['erreur'] = $e->getMessage();
            }
        }

		$this->load->view('dynamic-admin-page', $data);

		
	}
	
	public function import_points()
	{
		$data["pages"] = "import_point";
		$data['erreur'] = "aucun";
		if (!empty($_FILES['point_csv']['tmp_name']) ) {
            // Load CSV reader library
            $this->load->library('CSVReader'); 
			$this->load->model('csv_point'); 
            
            // Chemin de téléchargement du fichier CSV
            $csv_file = $_FILES['point_csv']['tmp_name'];
			
            // Parse data from CSV file
            $csvData = $this->csvreader->parse_csv_delimiter($csv_file, ',');

            // Afficher les données du fichier CSV
            // print_r( $csvData);
            try {
                $this->csv_point->insert_point_csv($csvData);
                redirect('Admin/import_points');
            } catch (Exception $e) {
                $data['erreur'] = $e->getMessage();
            }
        }

		$this->load->view('dynamic-admin-page', $data);
	}
	
}
