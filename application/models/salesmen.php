<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class SalesMen extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxId() {
        $this->db->select_max('officer_id');
        $result = $this->db->get('area_officer');
        $row = $result->row_array();
        $maxId = $row['officer_id'];
        return $maxId;
    }
    public function save($saleman) {
        $this->db->where(array('officer_id' => $saleman['officer_id']));
        $result = $this->db->get('area_officer');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('officer_id' => $saleman['officer_id']));
            $result = $this->db->update('area_officer', $saleman);
            $affect = $this->db->affected_rows();
        } else {
            unset($saleman['officer_id']);
            $result = $this->db->insert('area_officer', $saleman);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetch($officer_id) {
        $this->db->where(array('officer_id' => $officer_id));
        $result = $this->db->get('area_officer');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchAll() {
        $result = $this->db->get('area_officer');
        return $result->result_array();
    }
}