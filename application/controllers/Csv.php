<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csv extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Csv_model');
    }

   
    public function import_point() {
        if ($_FILES['point_csv']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['point_csv']['tmp_name'])) {
            $point_csv = $_FILES['point_csv']['tmp_name'];
            if (($handle = fopen($point_csv, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    foreach ($data as &$value) {
                        $value = str_replace(',', '.', $value);
                    }
                    $this->Csv_model->insert_point($data);
                }
                fclose($handle);
            }
        }
        $this->Csv_model->insert_all_data_point();
        redirect('Admin/dashboard'); /
    }

	

	

}
