<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Charges extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxId() {
        $this->db->select_max('chid');
        $result = $this->db->get('clg_charges_tbl');
        $row = $result->row_array();
        $maxId = $row['chid'];
        return $maxId;
    }
    public function getChargeTypes() {
        $result = $this->db->query('SELECT DISTINCT type FROM clg_charges_tbl');
        return $result->result_array();
    }
    public function save($chargeDetail) {
        $this->db->where(array('chid' => $chargeDetail['chid']));
        $result = $this->db->get('clg_charges_tbl');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('chid' => $chargeDetail['chid']));
            $result = $this->db->update('clg_charges_tbl', $chargeDetail);
            $affect = $this->db->affected_rows();
        } else {
            unset($chargeDetail['chid']);
            $result = $this->db->insert('clg_charges_tbl', $chargeDetail);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchCharge($chid) {
        $this->db->where(array('chid' => $chid));
        $result = $this->db->get('clg_charges_tbl');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchChargeByName($description) {
        $this->db->where(array('description' => $description));
        $result = $this->db->get('clg_charges_tbl');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchAll() {
        $result = $this->db->query("SELECT chid, description, charges, type, pid FROM `clg_charges_tbl`");
        return $result->result_array();
    }
    public function chargesDefinitionReport() {
        $result = $this->db->query("SELECT m.name AS 'course_name', d.amount, d.`type`, c.description FROM clg_coursemain_tbl m INNER JOIN clg_coursedetail_tbl d ON m.cmid = d.cmid INNER JOIN clg_charges_tbl c ON d.chid = c.chid ORDER BY m.name");
        return $result->result_array();
    }
    public function fetchPenaltyReport($from, $to, $pid, $did) {
        $query = "SELECT round(SUM(debit)) AS 'penalty',s.staid, s.name, d.name AS 'dept_name', DATE(p.date) AS date, p.dcno, p.description FROM pledger AS p INNER JOIN staff AS s ON p.pid = s.pid INNER JOIN department AS d ON s.did = d.did WHERE etype = 'penalty' AND p.date >= '" . $from . "' AND p.date <= '" . $to . "'";
        if ($pid != '-1') {
            $query.= " AND p.pid = $pid";
        }
        if ($did != '-1') {
            $query.= " AND d.did = $did";
        }
        $query.= " GROUP BY p.pid";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}