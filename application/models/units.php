<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class units extends CI_Model {
    public function getMaxId() {
        $this->db->select_max('company_id');
        $result = $this->db->get('company');
        $row = $result->row_array();
        $maxId = $row['company_id'];
        return $maxId;
    }
    public function save($unit) {
        $this->db->where(array('company_id' => $unit['company_id']));
        $result = $this->db->get('company');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('company_id' => $unit['company_id']));
            $result = $this->db->update('company', $unit);
            $affect = $this->db->affected_rows();
        } else {
            unset($unit['company_id']);
            $result = $this->db->insert('company', $unit);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetch($company_id) {
        $this->db->where(array('company_id' => $company_id));
        $result = $this->db->get('company');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchAll() {
        $result = $this->db->get('company');
        return $result->result_array();
    }
    public function delete($company_id) {
        $this->db->where(array('company_id' => $company_id));
        $result = $this->db->get('company');
        if ($result->num_rows() > 0) {
            $this->db->where(array('company_id' => $company_id));
            $this->db->delete('company');
            return true;
        } else {
            return false;
        }
    }
}