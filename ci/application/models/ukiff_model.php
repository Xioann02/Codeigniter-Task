<?php
class ukiff_model extends CI_Model {
 
    function __construct()
    {
        parent::__construct();
    }

    function insert($data){
        $this->db->insert('ukiff.content',$data);
    }

    function search($term){
        if(empty($term)) return array();
        $result = $this->db->like('name', $term)->get('ukiff.content');
        return $result->result();
    }
}
?>