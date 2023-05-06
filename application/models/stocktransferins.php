<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class stocktransferins extends CI_Model {
public function __construct() {
parent::__construct();

}

public function loaddata()
{
    
    $name = $this->session->userdata('uname'); 	
    if($name=='admin')
    {
    $result = $this->db->query("SELECT d.receive,i.item_id as design_name, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.receive, 2) receive, ROUND(d.qty, 2) qty, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' , CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
    FROM stockmain m 
    INNER JOIN stockdetail d ON m.stid = d.stid 
    INNER JOIN item i ON i.item_id = d.item_id 
    INNER JOIN department dep ON dep.did = d.godown_id 
    INNER JOIN department dep2 ON dep2.did = d.godown_id2 
    INNER JOIN user ON user.uid = m.uid 

    WHERE m.etype ='stocktransfer' AND d.ptype ='unpost' And d.receive >0");
if ($result->num_rows() > 0) {
    return $result->result_array();
} else {
    return false;
}

}
else{

    $result = $this->db->query("SELECT d.receive,i.item_id as design_name, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.receive, 2) receive, ROUND(d.qty, 2) qty, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' , CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
    FROM stockmain m 
    INNER JOIN stockdetail d ON m.stid = d.stid 
    INNER JOIN item i ON i.item_id = d.item_id 
    INNER JOIN department dep ON dep.did = d.godown_id 
    INNER JOIN department dep2 ON dep2.did = d.godown_id2 
    INNER JOIN user ON user.uid = m.uid 

    WHERE m.etype ='stocktransfer' AND d.ptype ='unpost' And d.receive >0 And dep.name = '$name'");
if ($result->num_rows() > 0) {
    return $result->result_array();
} else {
    return false;
}
}
    
}

public function chkunpost()
{
    
    $name = $this->session->userdata('uname'); 	
    if($name=='admin')
    {
    $query = $this->db->query("SELECT d.receive, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.receive, 2) receive, ROUND(d.qty, 2) qty, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' , CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
    FROM stockmain m 
    INNER JOIN stockdetail d ON m.stid = d.stid 
    INNER JOIN item i ON i.item_id = d.item_id 
    INNER JOIN department dep ON dep.did = d.godown_id 
    INNER JOIN department dep2 ON dep2.did = d.godown_id2 
    INNER JOIN user ON user.uid = m.uid 

    WHERE m.etype ='stocktransfer' AND d.ptype ='unpost' And d.receive >0");
      if ($count = $query->num_rows)
      {
         return $count;
      }
 else {
    return false;
}

}
else{

    $query = $this->db->query("SELECT d.receive, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.receive, 2) receive, ROUND(d.qty, 2) qty, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' , CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
    FROM stockmain m 
    INNER JOIN stockdetail d ON m.stid = d.stid 
    INNER JOIN item i ON i.item_id = d.item_id 
    INNER JOIN department dep ON dep.did = d.godown_id 
    INNER JOIN department dep2 ON dep2.did = d.godown_id2 
    INNER JOIN user ON user.uid = m.uid 

    WHERE m.etype ='stocktransfer' AND d.ptype ='unpost' And d.receive > 0 And dep.name = '$name'");
     if ($count = $query->num_rows)
     {
        return $count;
     }

 else {
    return false;
}
}
    
}







}
