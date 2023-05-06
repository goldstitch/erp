<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class yarnPurchases extends CI_Model {
public function getMaxVrno($etype,$company_id) {
$result = $this->db->query("SELECT MAX(vrno) vrno FROM pcontractmain WHERE etype = '".$etype ."' AND company_id=1  AND DATE(vrdate) = DATE(NOW())");
$row = $result->row_array();
$maxId = $row['vrno'];
return $maxId;
}
public function getMaxVrnoa($etype,$company_id) {
$result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM pcontractmain WHERE etype = '".$etype ."' and company_id= 1 ");
$row = $result->row_array();
$maxId = $row['vrnoa'];
return $maxId;
}
public function fetchChartData($period,$company_id)
{
$period = strtolower($period);
$query = '';
if ($period === 'daily') {
$query = "SELECT VRNOA, party.name AS ACCOUNT, NAMOUNT  FROM stockmain INNER JOIN party ON party.party_id = stockmain.party_id  WHERE stockmain.etype='sale' AND vrdate = CURDATE() AND stockmain.company_id=$company_id order by stockmain.vrdate desc LIMIT 10";
}
else if ( $period === 'weekly') {
$query = "SELECT sum(case when date_format(vrdate, '%W') = 'Monday' then namount else 0 end) as 'Monday', sum(case when date_format(vrdate, '%W') = 'Tuesday' then namount else 0 end) as 'Tuesday', sum(case when date_format(vrdate, '%W') = 'Wednesday' then namount else 0 end) as 'Wednesday', sum(case when date_format(vrdate, '%W') = 'Thursday' then namount else 0 end) as 'Thursday', sum(case when date_format(vrdate, '%W') = 'Friday' then namount else 0 end) as 'Friday', sum(case when date_format(vrdate, '%W') = 'Saturday' then namount else 0 end) as 'Saturday', sum(case when date_format(vrdate, '%W') = 'Sunday' then namount else 0 end) as 'Sunday' from stockmain where    etype = 'sale' and vrdate between DATE_SUB(VRDATE, INTERVAL 7 DAY) and CURDATE() AND stockmain.company_id = $company_id group by WEEK(VRDATE) order by WEEK(VRDATE) desc LIMIT 1 ";
}
else if( $period === 'monthly') {
$query = "SELECT sum(case when date_format(vrdate, '%W') = 'Monday' then namount else 0 end) as 'Monday', sum(case when date_format(vrdate, '%W') = 'Tuesday' then namount else 0 end) as 'Tuesday', sum(case when date_format(vrdate, '%W') = 'Wednesday' then namount else 0 end) as 'Wednesday', sum(case when date_format(vrdate, '%W') = 'Thursday' then namount else 0 end) as 'Thursday', sum(case when date_format(vrdate, '%W') = 'Friday' then namount else 0 end) as 'Friday', sum(case when date_format(vrdate, '%W') = 'Saturday' then namount else 0 end) as 'Saturday', sum(case when date_format(vrdate, '%W') = 'Sunday' then namount else 0 end) as 'Sunday' from stockmain where    etype = 'sale' and MONTH(VRDATE) = MONTH(CURDATE()) AND stockmain.company_id=$company_id group by WEEK(VRDATE) order by WEEK(VRDATE) desc LIMIT 4";
}
else if ( $period === 'yearly') {
$query = "SELECT YEAR(vrdate) as 'Year', MONTHNAME(STR_TO_DATE(MONTH(VRDATE), '%m')) as Month, sum(namount) AS TotalAmount FROM stockmain where  etype = 'Sale' and YEAR(VRDATE) = YEAR(CURDATE()) AND stockmain.company_id = $company_id GROUP BY YEAR(vrdate), MONTH(vrdate) ORDER BY YEAR(vrdate), MONTH(vrdate)";
}
$query = $this->db->query($query);
return $query->result_array();
}
public function save( $stockmain,$stockdetail,$vrnoa,$etype ) {
$this->db->where(array('vrnoa'=>$vrnoa,'etype'=>$etype,'company_id'=>$stockmain['company_id'] ));
$result = $this->db->get('pcontractmain');
$pconid = "";
if ($result->num_rows() >0) {
$result = $result->row_array();
$pconid = $result['pconid'];
$this->db->where(array('vrnoa'=>$vrnoa,'etype'=>$etype ,'company_id'=>$stockmain['company_id']));
$this->db->update('pcontractmain',$stockmain);
$this->db->where(array('pconid'=>$pconid ));
$this->db->delete('pcontractdetail');
}else {
$this->db->insert('pcontractmain',$stockmain);
$pconid = $this->db->insert_id();
}
foreach ($stockdetail as $detail) {
$detail['pconid'] = $pconid;
$this->db->insert('pcontractdetail',$detail);
}
return true;
}
public function fetch( $vrnoa,$etype,$company_id ) {
$sql = "select m.vrnoa,m.vrno,m.wono,m.vrdate,m.approvedby,m.preparedby,m.broker_id,m.party_id,m.totweight,m.totqty,m.totamount,m.paid,m.discp,m.discount,m.comp,m.commision,m.gstp,m.gst,m.namount,m.disAddress,m.delSchedule,m.payTerms,m.uid,m.company_id,d.item_id,i.item_des,d.uom,d.color_id,c.name as colors ,d.brand,d.qty,d.qlty,d.count,d.weight,d.rate,d.amount
				from pcontractmain as m
				INNER JOIN pcontractdetail as d ON m.pconid = d.pconid
				INNER JOIN color as c on c.id = d.color_id
				INNER JOIN item as i on i.item_id = d.item_id where m.vrnoa = $vrnoa AND m.company_id =1 AND m.etype = '".$etype ."';";
$result = $this->db->query($sql);
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function fetchByCol($col) {
$result = $this->db->query("SELECT DISTINCT $col FROM pcontractmain");
return $result->result_array();
}
public function fetchByCols($col) {
$result = $this->db->query("SELECT DISTINCT $col FROM pcontractdetail");
return $result->result_array();
}
public function delete( $vrnoa,$etype ,$company_id) {
$this->db->where(array('etype'=>$etype,'vrnoa'=>$vrnoa ,'company_id'=>1 ));
$result = $this->db->get('pcontractmain');
if ($result->num_rows() == 0) {
return false;
}else {
$result = $result->row_array();
$pconid = $result['pconid'];
$this->db->where(array('etype'=>$etype,'vrnoa'=>$vrnoa ));
$this->db->delete('pcontractmain');
$this->db->where(array('pconid'=>$pconid ));
$this->db->delete('pcontractdetail');
return true;
}
}
public function fetchSaleReportData($startDate,$endDate,$what,$type)
{
if ($what === 'voucher') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.VRNOA");
return $query->result_array();
}else {
$query = $this->db->query("SELECT party.NAME, DATE(stockmain.VRDATE) VRDATE, stockmain.VRNOA, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.VRNOA ORDER BY stockmain.VRNOA");
return $query->result_array();
}
}
else if ($what == 'account') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.party_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' Group by stockmain.party_id ORDER BY stockmain.party_id");
return $query->result_array();
}
}
else if ($what == 'location') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, dept.name AS NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN psm_department_tbl dept ON stockdetail.godown_id = dept.did WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.godown_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT dept.NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN psm_department_tbl dept ON dept.did = stockdetail.godown_id WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
return $query->result_array();
}
}
else if ($what == 'item') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.item_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT item.description as NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
return $query->result_array();
}
}
else if ($what == 'date') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.vrdate");
return $query->result_array();
}else {
$query = $this->db->query("SELECT date(stockmain.vrdate) as DATE, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.vrdate ORDER BY stockmain.vrdate");
return $query->result_array();
}
}
}
public function fetchSaleReturnReportData($startDate,$endDate,$what,$type)
{
if ($what === 'voucher') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.VRNOA");
return $query->result_array();
}else {
$query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' Group by stockmain.VRNOA ORDER BY stockmain.VRNOA");
return $query->result_array();
}
}
else if ($what == 'account') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.party_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' Group by stockmain.party_id ORDER BY stockmain.party_id");
return $query->result_array();
}
}
else if ($what == 'location') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, godown.name AS NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN psm_department_tbl godown ON stockdetail.godown_id = godown.did WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.godown_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT godown.NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN psm_department_tbl godown ON godown.did = stockdetail.godown_id WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
return $query->result_array();
}
}
else if ($what == 'item') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.item_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT item.description as NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
return $query->result_array();
}
}
else if ($what == 'date') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.vrdate");
return $query->result_array();
}else {
$query = $this->db->query("SELECT date(stockmain.vrdate) as DATE, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.PARTY_ID = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.vrdate ORDER BY stockmain.vrdate");
return $query->result_array();
}
}
}
public function fetchSaleProductionData($startDate,$endDate,$what,$type)
{
if ($what === 'voucher') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.received_by NAME, stockdetail.uom, stockmain.VRNOA, stockmain.REMARKS, stockdetail.QTY, stockdetail.amount RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.VRNOA");
return $query->result_array();
}else {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.received_by NAME, stockmain.VRNOA, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.amount)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT, stockdetail.uom FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.VRNOA ORDER BY stockmain.VRNOA");
return $query->result_array();
}
}
else if ($what == 'person') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE,  stockmain.received_by NAME, stockdetail.uom, stockmain.VRNOA, stockmain.REMARKS, stockdetail.QTY, stockdetail.amount RATE, stockdetail.NETAMOUNT, item.DESCRIPTION, stockmain.received_by FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.received_by");
return $query->result_array();
}else {
$query = $this->db->query("SELECT stockmain.received_by NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.amount)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.received_by ORDER BY stockmain.received_by");
return $query->result_array();
}
}
else if ($what == 'location') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockdetail.uom, stockmain.VRNOA, stockmain.REMARKS, dept.name AS NAME, stockdetail.QTY, stockdetail.amount RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN psm_department_tbl dept ON stockdetail.godown_id = dept.did WHERE  stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.godown_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT dept.NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.amount)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN psm_department_tbl dept ON dept.did = stockdetail.godown_id WHERE stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
return $query->result_array();
}
}
else if ($what == 'item') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockdetail.uom, stockdetail.QTY, stockdetail.amount RATE, stockdetail.NETAMOUNT, item.DESCRIPTION, stockmain.received_by NAME FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.item_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT item.description AS NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.amount)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
return $query->result_array();
}
}
else if ($what == 'date') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockmain.received_by NAME, stockdetail.UOM, stockdetail.QTY, stockdetail.amount RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.vrdate");
return $query->result_array();
}else {
$query = $this->db->query("SELECT DATE(stockmain.vrdate) AS NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.amount)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='production' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.vrdate ORDER BY stockmain.vrdate");
return $query->result_array();
}
}
}
public function fetchProfitLossReportData($what,$startDate,$endDate,$filterCrit)
{
if ($what === 'voucher') {
$query = $this->db->query("SELECT stockmain.VRDATE, IFNULL(party.NAME, '') NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.amount NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price PRATE, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.stid = stockdetail.stid LEFT JOIN pos_party_tbl party ON stockmain.party_id = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' ORDER BY stockmain.VRNOA");
return $query->result_array();
}
else if ($what == 'party') {
if ($filterCrit == 'all') {
$query = $this->db->query("SELECT stockmain.VRDATE, IFNULL(party.NAME, '') NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.amount NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price PRATE, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.stid = stockdetail.stid LEFT JOIN pos_party_tbl party ON stockmain.party_id = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' ORDER BY stockmain.PARTY_ID");
return $query->result_array();
}
else {
$query = $this->db->query("SELECT stockmain.VRDATE, party.NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price cost_price, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM pos_stockmain_tbl stockmain INNER JOIN pos_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.party_id = party.pid INNER JOIN pos_item_tbl item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' AND stockmain.party_id=$filterCrit ORDER BY stockmain.PARTY_ID");
return $query->result_array();
}
}
else if ($what == 'item') {
if ($filterCrit == 'all') {
$query = $this->db->query("SELECT stockmain.VRDATE, IFNULL(party.NAME, '') NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.amount NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price PRATE, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM psm_stockmain_tbl stockmain INNER JOIN psm_stockdetail_tbl stockdetail ON stockmain.stid = stockdetail.stid LEFT JOIN pos_party_tbl party ON stockmain.party_id = party.pid INNER JOIN itemitem ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' ORDER BY stockdetail.ITEM_ID");
return $query->result_array();
}
else {
$query = $this->db->query("SELECT stockmain.VRDATE, party.NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price cost_price, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM pos_stockmain_tbl stockmain INNER JOIN pos_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN pos_party_tbl party ON stockmain.party_id = party.pid INNER JOIN pos_item_tbl item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' AND  stockdetail.ITEM_ID=$filterCrit ORDER BY stockdetail.ITEM_ID");
return $query->result_array();
}
}
}
public function fetchRangeSum( $from ,$to )
{
$query = "SELECT IFNULL(SUM(CREDIT), 0)-IFNULL(SUM(DEBIT),0) as 'SALES_TOTAL' FROM psm_pledger_tbl pledger WHERE pid IN (SELECT pid FROM pos_party_tbl party WHERE NAME='sale') AND date between '{$from}' AND '{$to}'";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchSRRangeSum( $from ,$to )
{
$query = "SELECT IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT),0) as 'SRETURNS_TOTAL' FROM psm_pledger_tbl pledger WHERE pid IN (SELECT pid FROM pos_party_tbl party WHERE NAME='sale return') AND date between '{$from}' AND '{$to}'";
$result = $this->db->query($query);
return $result->result_array();
}
}