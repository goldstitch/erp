<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Companies extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function getMaxId() {
        $this->db->select_max('company_id');
        $query = $this->db->get('company');
        $result = $query->result_array();
        return ($result[0]['company_id'] === null) ? 0 : $result[0]['company_id'];
    }
    public function getAll() {
        $query = $this->db->get('company');
        return $query->result_array();
    }
    public function updateCompany($company_data) {
        $this->db->where('company_id', $company_data['company_id']);
        $q = $this->db->get('company');
        unset($company_data['img']);
        if ($q->num_rows() > 0) {
            $this->db->where('company_id', $company_data['company_id']);
            $this->db->update('company', $company_data);
            $rowCount = $this->db->affected_rows();
            if ($rowCount !== 0) {
                $this->session->set_flashdata('update_success', 'true');
                return true;
            } else {
                $this->session->set_flashdata('update_success', 'false');
                return false;
            }
        } else {
            $this->db->insert('company', $company_data);
            $rowCount = $this->db->affected_rows();
            if ($rowCount !== 0) {
                $this->session->set_flashdata('insert_success', 'true');
                return true;
            } else {
                $this->session->set_flashdata('insert_success', 'false');
                return false;
            }
        }
    }
    public function fetchCompany($company_id) {
        $company_id = $this->db->escape_str($company_id);
        $result = $this->db->get_where('company', array('company_id' => $company_id));
        return $result->result_array();
    }
}