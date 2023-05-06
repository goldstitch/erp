<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class differences extends CI_Model {
public function __construct() {
parent::__construct();

}


public function load_difference()
{
    $result = $this->db->query("SELECT d.receive, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id,abs(d.balance) balance, d.godown_id2, ROUND(d.receive, 2) receive, ROUND(d.qty, 2) qty, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' , CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder 
    FROM stockmain m 
    INNER JOIN stockdetail d ON m.stid = d.stid 
    INNER JOIN item i ON i.item_id = d.item_id 
    INNER JOIN department dep ON dep.did = d.godown_id 
    INNER JOIN department dep2 ON dep2.did = d.godown_id2 
    INNER JOIN user ON user.uid = m.uid 

    WHERE m.etype ='stocktransfer' AND d.ptype ='posted' And d.qty != d.receive");
if ($result->num_rows() > 0) {
    return $result->result_array();
} else {
    return false;
}

} 


public function difference($fromdate,$todate)
{
    $result = $this->db->query("SELECT d.receive, m.approved_by,m.prepared_by,d.bag,m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id,abs(d.balance) balance, d.godown_id2, ROUND(d.receive, 2) receive, ROUND(d.qty, 2) qty, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' , CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder 
    FROM stockmain m 
    INNER JOIN stockdetail d ON m.stid = d.stid 
    INNER JOIN item i ON i.item_id = d.item_id 
    INNER JOIN department dep ON dep.did = d.godown_id 
    INNER JOIN department dep2 ON dep2.did = d.godown_id2 
    INNER JOIN user ON user.uid = m.uid 

    WHERE m.vrdate BETWEEN '{$fromdate}' AND '{$todate}' and  m.etype ='stocktransfer' AND d.ptype ='posted' And d.qty != d.receive");
if ($result->num_rows() > 0) {
    return $result->result_array();
} else {
    return false;
}

} 



public function loaddata()
{
    $name = $this->session->userdata('uname'); 	
    if($name=='admin')
    {
    $result = $this->db->query("SELECT d.receive, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id,abs(d.balance) balance, d.godown_id2, ROUND(d.receive, 2) receive, ROUND(d.qty, 2) qty, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' , CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder 
    FROM stockmain m 
    INNER JOIN stockdetail d ON m.stid = d.stid 
    INNER JOIN item i ON i.item_id = d.item_id 
    INNER JOIN department dep ON dep.did = d.godown_id 
    INNER JOIN department dep2 ON dep2.did = d.godown_id2 
    INNER JOIN user ON user.uid = m.uid 

    WHERE m.etype ='stocktransfer' AND d.ptype ='posted' And d.balance != 0");
if ($result->num_rows() > 0) {
    return $result->result_array();
} else {
    return false;
}

} 
else{

    $result = $this->db->query("SELECT d.receive, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id,d.balance, d.godown_id2, ROUND(d.receive, 2) receive, ROUND(d.qty, 2) qty, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' , CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
    FROM stockmain m 
    INNER JOIN stockdetail d ON m.stid = d.stid 
    INNER JOIN item i ON i.item_id = d.item_id 
    INNER JOIN department dep ON dep.did = d.godown_id 
    INNER JOIN department dep2 ON dep2.did = d.godown_id2 
    INNER JOIN user ON user.uid = m.uid 

    WHERE m.etype ='stocktransfer' AND d.ptype ='posted' And d.balance != 0");
if ($result->num_rows() > 0) {
    return $result->result_array();
} else {
    return false;
}
}
    
}

public function balance($vrnoa,$snd_qty,$rec_qty,$type)
{
    if ($type =="less")
    {
        $result = $this->db->query("SELECT  stid from stockmain where vrnoa ='$vrnoa' AND etype ='stocktransfer'");
        $row = $result->row_array();
        $stid = $row['stid'];

        $result = $this->db->query("SELECT  qty from stockdetail where stid ='$stid 'and qty>0");
        $row = $result->row_array();
        $qty = $row['qty'];
        $qty = $qty + $rec_qty;
        $query = $this->db->query("update stockdetail set  qty ='$qty' where stid = $stid and qty>0");
        
        $result = $this->db->query("SELECT  qty from stockdetail where stid ='$stid 'and qty<0");
        $row = $result->row_array();
        $qty = $row['qty'];
        $qty = $qty + $snd_qty;
        $query = $this->db->query("update stockdetail set  qty ='$qty' where stid = $stid and qty<0");

        $query = $this->db->query("update stockdetail set balance ='0' where stid = $stid");
        return true;
    }

    else
    {
        $result = $this->db->query("SELECT  stid from stockmain where vrnoa ='$vrnoa' AND etype ='stocktransfer'");
        $row = $result->row_array();
        $stid = $row['stid'];

        $result = $this->db->query("SELECT  qty from stockdetail where stid ='$stid 'and qty>0");
        $row = $result->row_array();
        $qty = $row['qty'];
        $qty = $qty -  $rec_qty;
        $query = $this->db->query("update stockdetail set  qty ='$qty' where stid = $stid and qty>0");
        
        $result = $this->db->query("SELECT  qty from stockdetail where stid ='$stid 'and qty<0");
        $row = $result->row_array();
        $qty = $row['qty'];
        $qty = $qty - $snd_qty;
        $query = $this->db->query("update stockdetail set  qty ='$qty' where stid = $stid and qty<0");

        $query = $this->db->query("update stockdetail set balance ='0' where stid = $stid");
        return true;
    }
  
}



    
}






