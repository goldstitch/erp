<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Loans extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function fetchReport($from, $to, $pid, $did) {
        $query = "SELECT round(SUM(debit)) AS 'loan',s.staid, s.name, d.name AS 'dept_name', DATE(p.date) AS date, p.dcno, p.description FROM pledger AS p INNER JOIN staff AS s ON p.pid = s.pid INNER JOIN department AS d ON s.did = d.did WHERE etype = 'loan' AND p.date >= '" . $from . "' AND p.date <= '" . $to . "'";
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