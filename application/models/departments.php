<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Departments extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxDepartmentId() {
        $this->db->select_max('did');
        $result = $this->db->get('department');
        $row = $result->row_array();
        $maxId = $row['did'];
        return $maxId;
    }
    public function saveDepartment($department) {
        $this->db->where(array('did' => $department['did']));
        $result = $this->db->get('department');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('did' => $department['did']));
            $result = $this->db->update('department', $department);
            $affect = $this->db->affected_rows();
        } else {
            unset($department['did']);
            $result = $this->db->insert('department', $department);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchDepartment($did) {
        $this->db->where(array('did' => $did));
        $result = $this->db->get('department');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllDepartments() {
        $result = $this->db->get('department');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}