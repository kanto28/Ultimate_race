
<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');

class Csv_model_kanto extends CI_Model{
   
    public function __construct() {
        parent::__construct();
        $this->load->model('Point_model');
        $this->load->model('Participation_model');
    }

    //point
    public function insert_point($data) {
        $data_insert = array(
            'rang' => $data[0],
            'points' => $data[1]
        );
        // var_dump($data_insert);
		print_r($data_insert);
        $this->db->insert('table_point_ref', $data_insert);
        $this->db->insert_id();
    }
    

    public function insert_all_data_point() {
        $query = $this->db->get('table_point_ref');
        $donnee = $query->result();

        foreach ($donnee as $key => $value)
        {
            $data = array(
                'rang' => $value->rang,
                'points' => $value->points
            );
            $this->Point_model->insert_point($data);
        }
    }

    //etape
    public function insert_etape($data) {
        $data_insert = array(
            'nom'=>$data[0],
            'distance_km'=>$data[1],
            'nb_coureur_equipe'=>$data[2],
            'rang_etape'=>$data[3],
            'date_debut'=>$data[4],
            'date_fin'=>$data[5]
        );
        $this->db->insert('etape_ref', $data_insert);
        $this->db->insert_id();
    }


    public function insert_all_data_etape() {
        $query = $this->db->get('etape_ref');
        $donnee = $query->result();

        foreach ($donnee as $key => $value)
        { 
            $data = array(
                'nom' => $value->nom,
                'distance_km' => $value->distance_km,
                'nb_coureur_equipe' => $value->nb_coureur_equipe,
                'rang_etape' => $value->rang_etape,
                'date_debut' => $value->date_debut,
                'date_fin' => $value->date_fin,
                
            );

            $this->Etape_model->insert_etape($data);

        }
    }

    
    //participation
   
    // Méthode pour insérer une participation
    public function insert_Participation($id_coureur, $id_etape, $heure_depart, $heure_arrivee, $penalite = 0) {
        $data = [
            "id_coureur" => $id_coureur,
            "id_etape" => $id_etape,
            "heure_depart" => $heure_depart,
            "heure_arrivee" => $heure_arrivee,
            "penalite_secondes" => $penalite
        ];
        return $this->db->insert('participation_ref', $data);
    }
    

    // Méthode pour insérer toutes les données des participations
    public function insert_all_data_participation() {
        $query = $this->db->get('participation_ref'); 
        $donnee = $query->result();  

        foreach ($donnee as $value) { 
            $id_coureur = $value->id_coureur;
            $id_etape = $value->id_etape;
            $heure_depart = $value->heure_depart;
            $penalite = isset($value->penalite_secondes) ? $value->penalite_secondes : 0;
            
            $this->Participation_model->insert_Participation($id_coureur, $id_etape, $heure_depart, $penalite);
        }
    }
    
   

  
}
