<?php
class Equipe_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
		$this->load->model('DAO_model'); 
    }

  
    public function login($username, $password) {
        $hashed_password = $this->getPassword($username);
        echo $hashed_password;
        echo $password;
        if ($password== $hashed_password) {
            echo $username;
            return true;
        }
        return false; 
    }
    

    private function getPassword($username) {
        $query = $this->db->get_where('equipe', array('nom' => $username));
        $user = $query->row_array();
        if (!empty($user)) {
            return $user['password'];
        }
        return false;
    }

    public function getUserByUsername($username) {
        $query = $this->db->get_where('equipe', array('nom' => $username));
        return $query->row_array();
    }

	public function get_coureurs($id_equipe) {
        $query = $this->db->get_where('coureur', array('id_equipe' => $id_equipe));
        return $query->result_array();
    }


    public function getClassement_Equipe() {
        return $this->db->get('v_classement_general_equipe')->result_array();
    }

	

	public function getClassement($categ) {
		if($categ == "Tous") {
			return $this->DAO_model->find_all("v_classement_general_equipe");
		}
		else {
			$sql = "SELECT
						t.id_equipe, t.nom_equipe, points_total,
						RANK() OVER (ORDER BY points_total DESC) AS rang
					from
						v_classement_general_equipe_point_total t
						where nom_categorie = '$categ'
					ORDER by rang";
			return $this->DAO_model->find_by_request($sql);
		}
	}

	public function chart_classement($classement) {
        $stat = $classement;
        $labels = "";
        $datasets_point = "";
        for($i = 0; $i < count($stat); $i++) {
            if($i == 0){
                $labels = "'".$stat[$i]["nom_equipe"]."'";
                $datasets_point = $stat[$i]["points_total"];
            }
            else {
                $labels = $labels.","."'".$stat[$i]["nom_equipe"]."'";
                $datasets_point = $datasets_point.",".$stat[$i]["points_total"];
            }
            
        } 
        $data = [
            "labels" => $labels,
            "points" => $datasets_point
        ];
        return $data;
    }
    

    public function getDetailEquipe($id) {
        $this->db->where('id_equipe', $id);
        $query = $this->db->get('v_classement_general_equipe');
		return $query->result_array();
       
    }
    
    
}
?>
