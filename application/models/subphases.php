<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Subphases extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxsubPhaseId() {
        $this->db->select_max('id');
        $result = $this->db->get('subphase');
        $row = $result->row_array();
        $maxId = $row['id'];
        return $maxId;
    }
    public function savesubPhase($subphase) {
        $this->db->where(array('id' => $subphase['id']));
        $result = $this->db->get('subphase');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('id' => $subphase['id']));
            $result = $this->db->update('subphase', $subphase);
            $affect = $this->db->affected_rows();
        } else {
            unset($subphase['id']);
            $result = $this->db->insert('subphase', $subphase);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchSubPhase($id) {
        $this->db->where(array('id' => $id));
        $result = $this->db->get('subphase');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchAllSubPhase() {
        $result = $this->db->query('SELECT subphase.*, subphase.name as subphase_name,phase.name AS phase_name FROM subphase INNER JOIN phase ON phase.id = subphase.phaseid ');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllPhase() {
        $result = $this->db->query('SELECT phase.*, phasetype.name AS phasetype_name FROM phase INNER JOIN phasetype ON phase.ptypeid = phasetype.id');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}