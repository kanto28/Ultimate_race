
<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');

class Csv_point extends CI_Model{
   
    public function __construct() {
        parent::__construct();
        $this->load->model('Point_model');
        $this->load->model('Participation_model');
		$this->load->model('DAO_model');
    }

	// format date exemple 01/03/2024 => 2024-03-01
    public function transform_date($date_str) {
        $date_obj = DateTime::createFromFormat('d/m/Y', $date_str);
        $date_formatted = $date_obj->format('Y-m-d');
        return $date_formatted;
    }

    // format nombre 18,5 => 18.5
    public function transform_number($nombre) {
        $nombre = str_replace("," ,"." ,$nombre);
        return $nombre;
    }

    public function transform_pourcentage($nombre) {
        $nombre = $this->transform_number($nombre);
        $nombre = str_replace("%", "", $nombre);
        return $nombre;
    }

	public function transform_data_point($csvData) {
        $val = array();
        $error = false;
        $error_message = "";
        $li = 1;
        foreach($csvData as $row) {
            //echo $row['Film'];
            //$this->transform_date(trim($row['Date'])),
            if( $this->transform_number( trim($row['classement']) )  < 0) {
                $error = true;
                $error_message =  $error_message."ERREUR : ligne ".$li." message : Invalide Classement <br><br>";
            }
            if( $this->transform_number( trim($row['points']) ) < 0) {
                $error = true;
                $error_message =  $error_message."ERREUR : ligne ".$li." message : Invalide points <br><br>";
            }
            array_push( $val,
                [
                    'rang' => $this->transform_number( trim($row['classement']) ) ,
                    'points' => $this->transform_number( trim($row['points']) ) ,
                ]
            );
            $li = $li + 1;
        }

        if($error) {
            throw new Exception($error_message);
        }

        return $val;
    }

	public function insert_point_csv( $csvdata ) {
		try {
			$data = $this->transform_data_point($csvdata);
			foreach($data as $d) {
				$this->Point_model->insert_point($d["rang"], $d["points"]);
			} 
		} catch (\Exception $e) {
			throw $e;
		}
		
	}

	

}
