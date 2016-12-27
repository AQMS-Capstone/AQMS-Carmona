<?php
/**
 * Created by PhpStorm.
 * User: Nostos
 * Date: 27/12/2016
 * Time: 2:45 PM
 */

class Map_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_values($date_first, $date_second, $area){
        $value = "%".$date_first."%";
        $value2 = "%".$date_second."%";

        $value=$this->db->escape($value);
        $value2=$this->db->escape($value2);
        $value3=$this->db->escape($area);

        $this->db->select('*');
        $this->db->from('MASTER');
        $this->db->join('ELEMENTS', 'MASTER.e_id = ELEMENTS.e_id');
        $this->db->where("(TIMESTAMP LIKE $value OR TIMESTAMP = $value2)");
        $this->db->where("AREA_NAME = $value3");
        $this->db->order_by('TIMESTAMP', 'ASC');

        $query = $this->db->get();
        return $query->row_array();
    }
}