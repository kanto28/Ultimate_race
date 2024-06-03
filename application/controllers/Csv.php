<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csv extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Csv_model');
    }

   
    //import des points
    public function import_point() {

		if($_FILES['point_csv']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['point_csv']['tmp_name']))
        {
            $point_csv = $_FILES['point_csv']['tmp_name'];
            if(($handle = fopen($point_csv, "r")) !== FALSE)
            {
                while(($data = fgetcsv($handle ,1000, "," )) !== FALSE )
                {
					foreach ($data as &$value) {
						$value = str_replace(',', '.', $value);
                        $value = str_replace('/', '-', $value);
					}
                    $this->Csv_model->insert_point($data);
                }
                fclose($handle);
            }
        }
		
		$this->Csv_model->insert_all_data_point();
        redirect('Admin/dashboard');
	}


    //import des etape et participation
    public function import_resultat() {

		if($_FILES['etape_csv']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['etape_csv']['tmp_name']))
        {
            $etape_csv = $_FILES['etape_csv']['tmp_name'];
            if(($handle = fopen($etape_csv, "r")) !== FALSE)
            {
                while(($data = fgetcsv($handle ,1000, "," )) !== FALSE )
                {
					foreach ($data as &$value) {
						$value = str_replace(',', '.', $value);
					}
                    $this->Csv_model->insert_etape($data);
                }
                fclose($handle);
            }
        }

		if($_FILES['participation_csv']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['participation_csv']['tmp_name']))
        {
            $participation_csv = $_FILES['participation_csv']['tmp_name'];
            if(($handle = fopen($participation_csv, "r")) !== FALSE)
            {
                while(($data = fgetcsv($handle ,1000, "," )) !== FALSE )
                {
					foreach ($data as &$value) {
						$value = str_replace(',', '.', $value);
						$value = str_replace('%', '', $value);
                        $value = str_replace('/', '-', $value);
					}
                    
                    $this->Csv_model->insert_Participation($id_coureur, $id_etape, $heure_depart, $penalite = 0);
					
                }
                fclose($handle);
            }
        }

		$this->Csv_model->insert_all_data_etape();
		$this->Csv_model->insert_all_data_participation();
        redirect('Admin/dashboard');
	}

	

	

}
