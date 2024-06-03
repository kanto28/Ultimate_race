<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class Point_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_point_data($data) {
        return $this->db->insert('table_point', $data);
    }

	public function insert_point($rang, $points) {
		$data = [
			"rang" => $rang,
			"points" => $points
		];
        return $this->db->insert('table_point', $data);
    }

   
}
?>


