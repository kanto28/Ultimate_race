<?php
class Admin_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
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
        $query = $this->db->get_where('admin', array('nom' => $username));
        $user = $query->row_array();
        if (!empty($user)) {
            return $user['password'];
        }
        return false;
    }

    public function getUserByUsername($username) {
        $query = $this->db->get_where('admin', array('nom' => $username));
        return $query->row_array();
    }
    

    //insert

    // public function insertUsers($username, $email, $birth, $password) {        
    //     $sql="insert into users values(default, '%s', '%s', '%s', '%s',0 )";
    //     $sql=sprintf($sql, $username, $password, $email, $birth);
    //     $this -> db -> query($sql);
    // }

    
    //select

    // public function getusersbyID($iduser) {
    //     $sql = $this->db->query("select * from users where iduser = '%s'");
    //     $sql = sprintf($sql,$iduser);
    //     $tab = array();
    //     $i=0;
    //     foreach($sql->result_array() as $row){
    //         $tab[$i]['iduser'] = $row['iduser'];
    //         $tab[$i]['nom'] = $row['nom'];
    //         $tab[$i]['password'] = $row['password'];
    //         $tab[$i]['email'] = $row['email'];
    //         $tab[$i]['dtn'] = $row['dtn'];            
    //         $tab[$i]['isadmin'] = $row['isadmin'];
    //         $i++;
    //     }
    //     return $tab;
    // }    

    //delete

    // public function deleteUsers($iduser) {
    //     $this->db->where('iduser', $iduser);
    //     $this->db->delete('users');
    // }
    
    // //update

    // public function updateUsers($iduser, $data) {
    //     $this->db->where('iduser', $iduser);
    //     $this->db->update('users', $data);
    // }
    
    // public function update_user($iduser) {
    //     // Données à mettre à jour
    //     $data = array(
    //         'nom' => 'Nouveau Nom',
    //         'email' => 'nouveau@example.com'
    //     );
    
    //     // Appel de la fonction updateUsers du modèle
    //     $this->user_model->updateUsers($iduser, $data);
    // }
    
    
}
?>
