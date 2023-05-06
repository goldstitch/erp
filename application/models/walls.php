<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Walls extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getFeed($company_id, $page) {
        $query = "SELECT uname, company_name, company.address, company.contact_person, company.contact, vrnoa,
                      transaction_log.etype, party.name, namount, DATE_FORMAT(vrdate,'%M %e @ %h:%i %p') as vrdate,
                      debit, credit
                      FROM transaction_log
                      INNER JOIN party ON transaction_log.party_id = party.pid
                      INNER JOIN user on user.uid = transaction_log.uid
                      INNER JOIN company ON transaction_log.company_id = company.company_id
                      WHERE transaction_log.company_id = {$company_id}
                      ORDER BY transaction_log.vrdate DESC LIMIT " . ($page * 10) . ", 10";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchNetSum($company_id) {
        $query = "SELECT IFNULL(SUM(CREDIT), 0)-IFNULL(SUM(DEBIT),0) as 'SALES_TOTAL' FROM pledger WHERE pid IN (SELECT pid FROM party WHERE NAME='SALE') AND company_id = " . $company_id;
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchNetCashInHand($company_id) {
        $query = "SELECT IFNULL(SUM(DEBIT), 0) - IFNULL(SUM(CREDIT), 0) as 'NET_CASH_IN_HAND'FROM pledger WHERE pid = (SELECT pid FROM party WHERE name='cash') AND company_id={$company_id}";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchNetSumPurchase($company_id) {
        $query = "SELECT IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT),0) as 'PURCHASES_TOTAL' FROM pledger WHERE pid IN (SELECT pid FROM party WHERE NAME='PURCHASE') AND company_id = " . $company_id;
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchPartyClosingBalance($to, $party_id, $company_id) {
        $query = "SELECT (
                SELECT IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) AS 'CLOSING_BALANCE'
                FROM pledger
                WHERE pledger.pid={$party_id} AND DATE(date) <= '{$to}'
                ) AS 'CLOSING_BALANCE'
                ,(
                SELECT IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) AS 'CLOSING_BALANCE'
                FROM pledger
                WHERE pledger.pid={$party_id} AND DATE(date) < '{$to}'
                ) 'OPENING_BALANCE'
                ,(
                SELECT IFNULL(SUM(DEBIT), 0) AS 'NET_DEBIT'
                FROM pledger
                WHERE pledger.pid={$party_id} AND DATE(date) = '{$to}'

                ) 'NET_DEBIT'
                ,(
                SELECT IFNULL(SUM(CREDIT),0) AS 'NET_CREDIT'
                FROM pledger
                WHERE pledger.pid={$party_id} AND DATE(date) = '{$to}'
                ) 'NET_CREDIT' ";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchPartyNetCredit($to, $party_id, $company_id) {
        $query = "SELECT SUM(CREDIT) as NET_CREDIT FROM pledger WHERE pid = $party_id AND company_id = $company_id AND `date` <= '$to'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchPartyNetDebit($to, $party_id, $company_id) {
        $query = "SELECT SUM(DEBIT) as NET_DEBIT FROM pledger WHERE pid = $party_id AND company_id = $company_id AND `date` <= '$to'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchPartyOpeningBalance($to, $party_id, $company_id) {
        $query = "SELECT IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT),0) as 'OPENING_BALANCE' FROM pledger WHERE pledger.pid={$party_id} AND `date` < '{$to}' AND company_id = {$company_id}";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchItemClosingStock($to, $item_id, $company_id) {
        $q = "SELECT (
            SELECT IFNULL(IF(i.uom='dozen', ROUND(SUM(qty)/12, 2), ROUND(SUM(QTY), 2)),0) 'OP_STOCK'
            FROM stockmain m
            INNER JOIN stockdetail d ON m.stid = d.stid
            INNER JOIN item i ON i.item_id = d.item_id
            WHERE DATE(m.vrdate) <'{$to}' AND m.company_id={$company_id} AND i.item_id={$item_id}
            ) AS OPENING_STOCK
            ,(
            SELECT IFNULL(IF(i.uom='dozen', ROUND(SUM(IF(d.qty>0,d.qty,0))/12, 2), ROUND(SUM(IF(d.qty>0, d.qty,0)), 2)),0) 'IN_STOCK'
            FROM stockmain m
            INNER JOIN stockdetail d ON m.stid = d.stid
            INNER JOIN item i ON i.item_id = d.item_id
            WHERE DATE(m.vrdate) ='{$to}' AND m.company_id={$company_id} AND i.item_id={$item_id}
            ) AS IN_STOCK
            ,(
            SELECT IFNULL(IF(i.uom='dozen', ROUND(SUM(IF(d.qty<0,d.qty,0))/12, 2), ROUND(SUM(IF(d.qty<0, d.qty,0)), 2)),0) 'OUT_STOCK'
            FROM stockmain m
            INNER JOIN stockdetail d ON m.stid = d.stid
            INNER JOIN item i ON i.item_id = d.item_id
            WHERE DATE(m.vrdate) ='{$to}' AND m.company_id={$company_id} AND i.item_id={$item_id}
            ) AS OUT_STOCK
            ,(
            SELECT IFNULL(IF(i.uom='dozen', ROUND(SUM(qty)/12, 2), ROUND(SUM(QTY), 2)),0) 'OP_STOCK'
            FROM stockmain m
            INNER JOIN stockdetail d ON m.stid = d.stid
            INNER JOIN item i ON i.item_id = d.item_id
            WHERE DATE(m.vrdate) <='{$to}' AND m.company_id={$company_id} AND i.item_id={$item_id}
            ) AS CLOSING_STOCK";
        $query = $this->db->query($q);
        return $query->result_array();
    }
    public function fetchItemInStock($to, $item_id, $company_id) {
        $query = "SELECT SUM(QTY) as IN_STOCK FROM stockmain INNER JOIN stockdetail ON stockmain.stid = stockdetail.stid WHERE item_id = $item_id AND company_id = $company_id AND vrdate <= '$to' AND qty > 0 GROUP BY stockdetail.item_id";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchItemOutStock($to, $item_id, $company_id) {
        $query = "SELECT SUM(QTY) as OUT_STOCK FROM stockmain INNER JOIN stockdetail ON stockmain.stid = stockdetail.stid WHERE item_id = $item_id AND company_id = $company_id AND vrdate <= '$to' AND qty < 0 GROUP BY stockdetail.item_id";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchItemOpeningStock($to, $item_id, $company_id) {
        $q = "SELECT IFNULL(SUM(qty), 0) as 'OPENING_STOCK' FROM stockmain INNER JOIN stockdetail ON stockmain.stid = stockdetail.stid WHERE item_id = {$item_id} AND DATE(VRDATE) < '{$to}' AND stockmain.company_id={$company_id}";
        $query = $this->db->query($q);
        return $query->result_array();
    }

    
}