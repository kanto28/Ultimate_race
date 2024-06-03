
<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');

class Csv_donne extends CI_Model{
   
    public function __construct() {
        parent::__construct();
		$this->load->model('DAO_model');
		$this->load->model('Etape_model');
    }

	// format date exemple 01/03/2024 10:30:00 => 2024-03-01 10:30:00
	public function transform_timestamp($timestamp_str) {
		$date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $timestamp_str);
		$timestamp_formatted = $date_obj->format('Y-m-d H:i:s');
		return $timestamp_formatted;
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

	public function transform_data_etape($csvData) {
        $val = array();
        $error = false;
        $error_message = "";
        $li = 1;
        foreach($csvData as $row) {
            //echo $row['Film'];
            //$this->transform_date(trim($row['Date'])),
            if( $this->transform_number( trim($row['nb coureur']) )  < 0) {
                $error = true;
                $error_message =  $error_message."ERREUR : ligne ".$li." message : Invalide nb coureur <br><br>";
            }
            if( $this->transform_number( trim($row['rang']) ) < 0) {
                $error = true;
                $error_message =  $error_message."ERREUR : ligne ".$li." message : Invalide rang <br><br>";
            }
			if( $this->transform_number( trim($row['longueur']) ) < 0) {
                $error = true;
                $error_message =  $error_message."ERREUR : ligne ".$li." message : Invalide longueur <br><br>";
            }
			$date_debut = $this->transform_date( trim($row['date départ'])  );
			$date_debut = $date_debut." ".trim($row['heure départ']);
            array_push( $val,
                [
                    'nom' =>  trim($row['etape']) ,
                    'distance_km' => $this->transform_number( trim($row['longueur']) ) ,
					"nb_coureur_equipe" => $this->transform_number( trim($row['nb coureur']) ) ,
					"rang_etape" => $this->transform_number( trim($row['rang']) ) ,
					"date_debut" => $date_debut
                ]
            );
            $li = $li + 1;
        }

        if($error) {
            throw new Exception($error_message);
        }

        return $val;
    }

	public function insert_etape_csv($csvData) {
		try {
			$data = $this->transform_data_etape($csvData);
			foreach($data as $d) {
				$this->Etape_model->inert_etape($d);
			} 
		} catch (\Exception $e) {
			throw $e;
		}
	}


	public function transform_data_resultat($csvData) {
        $val = array();
        $error = false;
        $error_message = "";
        $li = 1;
        foreach($csvData as $row) {
            //echo $row['Film'];
            //$this->transform_date(trim($row['Date'])),
            if( $this->transform_number( trim($row['etape_rang']) )  < 0) {
                $error = true;
                $error_message =  $error_message."ERREUR : ligne ".$li." message : Invalide etape_rang <br><br>";
            }
            if( $this->transform_number( trim($row['numero dossard']) ) < 0) {
                $error = true;
                $error_message =  $error_message."ERREUR : ligne ".$li." message : Invalide numero dossard <br><br>";
            }
            array_push( $val,
                [
                    'etape_rang' => $this->transform_number( trim($row['etape_rang']) ) ,
					"numero_dossard" => $this->transform_number( trim($row['numero dossard']) ) ,
					"nom" =>  trim($row['nom']) ,
					"genre" => trim($row['genre']) ,
					"dtn" => $this->transform_date( trim( $row["date naissance"] ) ),
					"equipe" => trim( $row["equipe"] ) ,
					"arrivee" => $this->transform_timestamp( trim( $row["arrivée"] ) )
				]
            );
            $li = $li + 1;
        }

        if($error) {
            throw new Exception($error_message);
        }

        return $val;
    }

	public function insert_resultat_temp( $csvData ) {
		try {
			$data = $this->transform_data_resultat($csvData);
			foreach($data as $d) {
				$this->db->insert( "resultat_temp", $d );
			} 
		} catch (\Exception $e) {
			throw $e;
		}
	}

	public function execute_script_csv () {
        $script_path = base_url("sql/script-csv-resultat.sql");
		$script_file_content = file_get_contents($script_path);
        $this->db->query($script_file_content);
    }


	public function import_csv_donne($data_etape, $data_resultat) {
        try {
            $this->db->trans_begin();
            $this->insert_etape_csv($data_etape);
			$this->insert_resultat_temp($data_resultat);
            $this->execute_script_csv();
            $this->db->trans_commit();
        } catch (\Exception $e) {
            // echo "ERREUR ";
            // echo $e->getMessage();
            $this->db->trans_rollback();
            throw $e;
        }
    }


	

	

}
