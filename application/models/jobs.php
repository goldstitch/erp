<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Jobs extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxVrno($etype) {
        $result = $this->db->query("SELECT MAX(vrno) vrno FROM job_order WHERE etype = '" . $etype . "' AND DATE(vrdate) = DATE(NOW())");
        $row = $result->row_array();
        $maxId = $row['vrno'];
        return $maxId;
    }
    public function getMaxVrnoa($etype) {
        $result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM job_order WHERE etype = '" . $etype . "'");
        $row = $result->row_array();
        $maxId = $row['vrnoa'];
        return $maxId;
    }
    public function save($job) {
        $this->db->where(array('vrnoa' => $job['vrnoa'], 'etype' => $job['etype']));
        $result = $this->db->delete('job_order');
        $result = $this->db->insert('job_order', $job);
        $affect = $this->db->affected_rows();
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetch($vrnoa, $etype) {
        $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
        $result = $this->db->get('job_order');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchAllJobs($etype) {
        $result = $this->db->query("SELECT j.*, ROUND(SUM(c.debit), 2) AS 'job_cost' FROM job_order j INNER JOIN costing_exp c ON j.vrnoa = c.qty WHERE j.etype = '" . $etype . "' GROUP BY j.vrnoa ");
        return $result->result_array();
    }
}