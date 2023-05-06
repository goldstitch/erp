<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class stockadjusts extends CI_Model {
public function __construct() {
parent::__construct();

}

public function loaddata()
{
          $what='location';
          $get_crit = '';
          $crit ='AND+m.stid+%3C%3E0+';
          if ($what == 'location') {
              $get_crit = 'dep.name';
          } else if ($what == 'item') {
              $get_crit = 'i.item_des,dep.name';
          } else if ($what == 'category') {
              $get_crit = 'cat.name';
          } else if ($what == 'unit') {
              $get_crit = 'company.company_name';
          }
     
          $query = $this->db->query("SELECT i.artcile_no as ARTICLE,i.uom as UOM,i.item_des NAME,i.item_id, dep.NAME as dept_name ,if(i.uom='', round(IFNULL(SUM(d.qty)/12,0),0),IFNULL(SUM(d.qty),0)) AS qty, ROUND(IFNULL(i.avg_rate,0),2) AS cost, ROUND(IFNULL(SUM(d.qty),2)* IFNULL(i.avg_rate,0),2) AS value ,dep.did ,d.stid
          FROM stockdetail d
          INNER JOIN item i ON i.item_id=d.item_id
          INNER JOIN stockmain m on m.stid = d.stid
          LEFT JOIN department dep ON dep.did = d.godown_id

          WHERE m.VRDATE BETWEEN ' 2010-05-06 ' AND ' 2091-05-06 ' AND m.company_id<>0 
		GROUP BY $get_crit,i.item_des 
		having IFNULL(SUM(d.qty),0)<>0 ");

         if ($query->num_rows() > 0) {
          return $query->result_array();
         } else {
          return false;
      }
 
}

}



