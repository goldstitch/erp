<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Phasetypes extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxPhaseTypeId() {
        $this->db->select_max('id');
        $result = $this->db->get('phasetype');
        $row = $result->row_array();
        $maxId = $row['id'];
        return $maxId;
    }
    public function savePhaseType($phasetype) {
        $this->db->where(array('id' => $phasetype['id']));
        $result = $this->db->get('phasetype');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('id' => $phasetype['id']));
            $result = $this->db->update('phasetype', $phasetype);
            $affect = $this->db->affected_rows();
        } else {
            unset($phasetype['id']);
            $result = $this->db->insert('phasetype', $phasetype);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchPhaseType($id) {
        $this->db->where(array('id' => $id));
        $result = $this->db->get('phasetype');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllPhaseType() {
        $result = $this->db->get('phasetype');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}