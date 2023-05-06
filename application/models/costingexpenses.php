<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Costingexpenses extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxId($etype) {
        $result = $this->db->query("SELECT MAX(dcno) dcno FROM costing_exp WHERE etype = '" . $etype . "'");
        $row = $result->row_array();
        $maxId = $row['dcno'];
        return $maxId;
    }
    public function saveJobExpense($costingExps, $dcno, $etype) {
        $this->db->where(array('dcno' => $dcno, 'etype' => $etype));
        $this->db->delete('costing_exp');
        $affect = 0;
        foreach ($costingExps as $ce) {
            $this->db->insert('costing_exp', $ce);
            $affect = $this->db->affected_rows();
        }
        if ($affect == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchJobExpense($dcno, $etype) {
        $result = $this->db->query("SELECT c.*, j.cost_id, p.name FROM costing_exp c INNER JOIN job_order j ON j.vrnoa = c.qty INNER JOIN party p ON p.pid = c.party_id WHERE c.dcno = $dcno AND c.etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function deleteJobExpense($dcno, $etype) {
        $this->db->where(array('etype' => $etype, 'dcno' => $dcno));
        $result = $this->db->get('costing_exp');
        if ($result->num_rows() == 0) {
            return false;
        } else {
            $this->db->where(array('etype' => $etype, 'dcno' => $dcno));
            $this->db->delete('costing_exp');
            return true;
        }
    }
}