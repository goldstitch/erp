<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Phases extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxPhaseId() {
        $this->db->select_max('id');
        $result = $this->db->get('phase');
        $row = $result->row_array();
        $maxId = $row['id'];
        return $maxId;
    }
    public function savePhase($phase) {
        $this->db->where(array('id' => $phase['id']));
        $result = $this->db->get('phase');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('id' => $phase['id']));
            $result = $this->db->update('phase', $phase);
            $affect = $this->db->affected_rows();
        } else {
            unset($phase['id']);
            $result = $this->db->insert('phase', $phase);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchPhase($id) {
        $this->db->where(array('id' => $id));
        $result = $this->db->get('phase');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchAllPhase() {
        $result = $this->db->query('SELECT * FROM phase ');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}