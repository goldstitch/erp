<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class stockadjustreports extends CI_Model {
public function __construct() {
parent::__construct();

}

public function loaddata()
{
    $result = $this->db->query("SELECT g.name,i.item_des ,i.item_id, DATE(m.vrdate) vrdate,d.qty,d.atype, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time , round((i.srate*d.qty),0) AS trate ,round((i.srate),0)  AS rate
     FROM stockdetail d
     INNER JOIN stockmain m ON m.stid = d.stid
     INNER JOIN department g ON g.did= d.godown_id
     INNER JOIN item i ON d.item_id= i.item_id
     WHERE m.vrdate<='2091-05-06' AND m.etype ='stockadjust'");
     return $result->result_array();
}

}