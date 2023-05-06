<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Currenceys extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxCurrenceyId() {
        $this->db->select_max('id');
        $result = $this->db->get('currencey');
        $row = $result->row_array();
        $maxId = $row['id'];
        return $maxId;
    }
    public function saveCurrencey($color) {
        $this->db->where(array('id' => $color['id']));
        $result = $this->db->get('currencey');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('id' => $color['id']));
            $result = $this->db->update('currencey', $color);
            $affect = $this->db->affected_rows();
        } else {
            unset($color['id']);
            $result = $this->db->insert('currencey', $color);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchCurrencey($id) {
        $this->db->where(array('id' => $id));
        $result = $this->db->get('currencey');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllCurrencey() {
        $result = $this->db->get('currencey');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}