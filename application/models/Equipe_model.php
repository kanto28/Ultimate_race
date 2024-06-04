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
		if($categ == "Homme") {
			return $this->DAO_model->find_all("v_classement_general_equipe_homme");
		}
		if($categ == "Femme") {
			return $this->DAO_model->find_all("v_classement_general_equipe_femme");
		}
		if($categ == "Junior") {
			return $this->DAO_model->find_all("v_classement_general_equipe_junior");
		}
		else {
			return $this->DAO_model->find_all("v_classement_general_equipe");
		}
	}
    

    public function getDetailEquipe($id) {
        $this->db->where('id_equipe', $id);
        $query = $this->db->get('v_classement_general_equipe');
		return $query->result_array();
       
    }
    
    
}
?>
