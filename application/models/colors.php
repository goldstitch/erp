<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Colors extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxColorId() {
        $this->db->select_max('color_id');
        $result = $this->db->get('color');
        $row = $result->row_array();
        $maxId = $row['color_id'];
        return $maxId;
    }
    public function saveColor($color) {
        $this->db->where(array('color_id' => $color['color_id']));
        $result = $this->db->get('color');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('color_id' => $color['color_id']));
            $result = $this->db->update('color', $color);
            $affect = $this->db->affected_rows();
        } else {
            unset($color['color_id']);
            $result = $this->db->insert('color', $color);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchColor($id) {
        $this->db->where(array('color_id' => $id));
        $result = $this->db->get('color');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllColors() {
        $result = $this->db->get('color');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllcolorsOrderWise($vrnoa) {
        $result = $this->db->query("SELECT distinct color.color_id,color.name from color 
			inner join item on item.color_id=color.color_id
			where item.vrnoa = " . $vrnoa . " 
			order by color.name  ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}