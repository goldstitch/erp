<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cashes extends CI_Model {
    public function fetchNetSum($company_id) {
        $query = "SELECT IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT),0) as 'CASH_TOTAL' FROM pledger WHERE PID IN (SELECT PID FROM party WHERE NAME='CASH') AND pledger.company_id=$company_id";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchNetExpenses($company_id) {
        $query = "SELECT IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT),0) as 'EXP_TOTAL' FROM pledger WHERE PID IN (SELECT PID FROM party WHERE level3 IN ( SELECT l3 FROM level3 WHERE l2 IN (SELECT l2 FROM level2 WHERE name LIKE '%EXPENSE%'))) AND pledger.company_id=$company_id";
        $result = $this->db->query($query);
        return $result->result_array();
    }
}