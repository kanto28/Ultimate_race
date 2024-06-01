<?php

if ( ! defined('BASEPATH')) exit('No direct script acces allowed');


class DAO_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


	public function find_all($nom_table, $numero_page = null, $element_par_page = null){
        if ($numero_page === null || $element_par_page === null) {
            $query = $this->db->get($nom_table);
            return $query->result_array();
        }

        $decalage = ($numero_page - 1) * $element_par_page;

        $this->db->limit($element_par_page, $decalage);
        $query = $this->db->get($nom_table);

    return $query->result_array();
    }

    public function find_by_request($sql, $numero_page = null, $element_par_page = null) {
        $request = $sql;
    
        if ($numero_page === null || $element_par_page === null) {
            $query = $this->db->query($request);
            return $query->result_array();
        }
    
        $decalage = ($numero_page - 1) * $element_par_page;
        $request .= " LIMIT $element_par_page OFFSET $decalage";
        $query = $this->db->query($request);

        return $query->result_array();
    }

	public function find_by_request_one_row($sql){
        $request = $sql;
        $query = $this->db->query($request);
        return $query->row_array();
    }

    
    public function find_by_id($nom_table,$id){
        $this->db->where("id_$nom_table", $id);
        $query = $this->db->get($nom_table);
        return $query->row_array();
    }

    public function find_by($nom_table, $column, $value){
        $this->db->where($column, $value);
        $query = $this->db->get($nom_table);
        return $query->row_array();
    }

    public function count_total_rows($table) {
        $sql = "SELECT COUNT(*) as total_rows FROM $table";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        $total_rows = isset($result['total_rows']) ? $result['total_rows'] : 0;
        return $total_rows;
    }

    public function count_total_rows_sql($sql) {
        $sql = "SELECT COUNT(*) as total_rows from ( $sql ) as t ";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        $total_rows = isset($result['total_rows']) ? $result['total_rows'] : 0;
        return $total_rows;
    }

    public function get_nb_pages($count, $nb_element_par_page) {
        // Calculer le nombre total de pages nécessaires
        $nb_pages = ceil($count / $nb_element_par_page);
        
        // Retourner le nombre total de pages
        return $nb_pages;
    }

    public function get_links_with_count( $count ,$per_page, $url) {
        $config['base_url'] = $url;
        $config['total_rows'] = $count; 
        $config['per_page'] = $per_page; 
        $config['use_page_numbers'] = TRUE;
        // ampina justify-content-center raha tiana centrena
        $config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active" aria-current="page"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="visually-hidden">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $links =  $this->pagination->create_links();
        $links = str_replace('<a ', '<a class="page-link" ', $links);
        return $links;
    }

    public function get_links( $table ,$per_page, $url) {
        $count = $this->count_total_rows($table);
        return $this->get_links_with_count($count, $per_page, $url);
    }

    public function get_links_sql( $sql ,$per_page, $url) {
        $count = $this->count_total_rows_sql($sql);
        return $this->get_links_with_count($count, $per_page, $url);
    }


    

   
}
?>
