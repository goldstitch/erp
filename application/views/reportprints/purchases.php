

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Purchases extends CI_Model {
public function __construct() {
parent::__construct();
}
public function last_5_srate( $item_id,$etype,$company_id,$crit) {
$result = $this->db->query("SELECT party.name as party_name, m.vrnoa, DATE(m.vrdate) vrdate, ROUND(d.qty, 2) qty,d.rate as lprate, ROUND(d.weight, 2) as weight
									FROM stockmain AS m
									INNER JOIN stockdetail AS d ON m.stid = d.stid
									INNER JOIN item i ON i.item_id = d.item_id
									INNER JOIN department dep ON dep.did = d.godown_id
									left JOIN party ON party.pid=m.party_id
									WHERE   m.etype ='".$etype ."' and m.company_id=$company_id and d.item_id=$item_id $crit
									ORDER BY m.vrdate  desc
									limit 5");
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function getMaxVrno($etype,$company_id) {
$result = $this->db->query("SELECT MAX(vrno) vrno FROM stockmain WHERE etype = '".$etype ."' AND company_id=".$company_id ."  AND DATE(vrdate) = DATE(NOW())");
$row = $result->row_array();
$maxId = $row['vrno'];
return $maxId;
}
public function fetchByProductionVoucher( $vrnoa,$etype,$company_id ) {
$sql = "SELECT st.name as empname,d.job_id,d.dozen,m.received_by,m.vrno,m.uid,m.vrnoa, m.vrdate,m.remarks,m.approved_by,m.prepared_by, ROUND(m.namount, 2) namount,m.workorder, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.lamount, 2) AS 's_lamount',  ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom , d.weight,p.name as 'phase_name',d.`type`,d.phase_id,d.emp_id,d.lrate,d.no_of_machines,d.cost,d.lamount,d.item_id
				FROM stockmain AS m 
				INNER JOIN stockdetail AS d ON m.stid = d.stid 
				INNER JOIN item AS i ON i.item_id = d.item_id   
				left JOIN subphase AS p ON p.id = d.phase_id 
				Left JOIN party AS ac ON ac.pid = d.emp_id 
				LEFT JOIN staff st on st.staid = d.emp_id
				WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '".$etype ."' ";
$result = $this->db->query($sql);
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function fetchReportDataMain($startDate,$endDate,$company_id,$etype,$uid)
{
if ($etype == 'issuetovenders'||$etype == 'receivefromvenders') {
$query = $this->db->query("SELECT stockmain.discount,stockmain.expense,stockmain.tax,stockmain.vrnoa,stockmain.vrdate,p.name AS party_name,stockmain.remarks,stockmain.taxpercent,stockmain.exppercent,stockmain.discp,stockmain.paid,stockmain.namount FROM stockmain stockmain INNER JOIN party p ON p.pid = stockmain.party_id INNER JOIN user ON user.uid = stockmain.uid INNER JOIN company c ON c.company_id = stockmain.company_id WHERE stockmain.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id= $company_id AND stockmain.etype= '".$etype."' AND stockmain.uid = $uid ORDER BY stockmain.vrnoa");
return $query->result_array();
}elseif ($etype == 'inward'||$etype == 'outward'||$etype == 'consumption'||$etype == 'materialreturn') {
$query = $this->db->query("SELECT i.item_des,d.amount,d.dozen,d.bag,d.qty,d.weight,stockmain.discount,stockmain.expense,stockmain.tax,stockmain.vrnoa,stockmain.vrdate,p.name AS party_name,stockmain.remarks,stockmain.taxpercent,stockmain.exppercent,stockmain.discp,stockmain.paid,stockmain.namount FROM stockmain stockmain LEFT JOIN party p ON p.pid = stockmain.party_id  INNER JOIN stockdetail d on d.stid  = stockmain.stid INNER JOIN item i on i.item_id = d.item_id INNER JOIN user ON user.uid = stockmain.uid INNER JOIN company c ON c.company_id = stockmain.company_id WHERE stockmain.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' and stockmain.company_id= $company_id AND stockmain.etype= '".$etype."' and stockmain.uid = $uid  ORDER BY stockmain.vrnoa");
return $query->result_array();
}elseif ($etype == 'stocktransfer') {
$query = $this->db->query("SELECT m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' FROM stockmain m INNER JOIN stockdetail d ON m.stid = d.stid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN department dep2 ON dep2.did = d.godown_id2 WHERE m.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."'  AND m.etype = 'stocktransfer' AND m.company_id = ".$company_id ." AND qty > 0");
return $query->result_array();
}elseif($etype == 'requisition'){
$query = $this->db->query("SELECT ordermain.remarks,orderdetail.lvendor,orderdetail.lstock,orderdetail.amount,ordermain.vrdate, ordermain.remarks, ordermain.vrnoa,
 										   ordermain.remarks, ABS(orderdetail.qty) qty, orderdetail.weight, orderdetail.rate, orderdetail.netamount,
 										   item.item_des AS 'item_des',item.uom
										   FROM ordermain ordermain
										   INNER JOIN orderdetail orderdetail ON ordermain.oid = orderdetail.oid
										   LEFT JOIN party party ON ordermain.party_id = party.pid
										   INNER JOIN item item ON orderdetail.item_id = item.item_id
										   INNER JOIN user ON user.uid = ordermain.uid
										   WHERE ordermain.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' and ordermain.company_id=$company_id AND ordermain.etype='".$etype."' 
										   ORDER BY ordermain.vrnoa");
return $query->result_array();
}else{
$query = $this->db->query("SELECT ordermain.discount,ordermain.expense,ordermain.tax,ordermain.vrnoa,ordermain.vrdate,p.name as party_name,ordermain.remarks,ordermain.taxpercent,ordermain.exppercent,ordermain.discp,ordermain.paid,ordermain.namount from ordermain ordermain INNER JOIN party p ON p.pid = ordermain.party_id INNER JOIN user ON user.uid = ordermain.uid INNER JOIN company c ON c.company_id = ordermain.company_id WHERE ordermain.vrdate BETWEEN  '".$startDate ."' AND '".$endDate ."' AND ordermain.company_id= $company_id AND ordermain.etype= '".$etype."'  order by ordermain.vrnoa");
return $query->result_array();
}
}
public function fetchReportDataProduction($startDate,$endDate,$company_id,$etype,$uid,$type)
{
$query = $this->db->query("SELECT  dep.name as dept_name,st.name empname,st.type emp_type,st.agreement,st.name as empname,d.dozen,m.received_by,m.vrno,m.uid,m.vrnoa, m.vrdate,m.remarks,m.approved_by,m.prepared_by, ROUND(m.namount, 2) namount,m.workorder,d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.lamount, 2) AS 's_lamount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight,p.name AS 'phase_name',d.`type`,d.phase_id,d.emp_id,d.lrate,d.no_of_machines,d.cost,d.lamount,d.item_id
												FROM stockmain AS m
												INNER JOIN stockdetail AS d ON m.stid = d.stid
												INNER JOIN item AS i ON i.item_id = d.item_id
												INNER JOIN subphase AS p ON p.id = d.phase_id
												LEFT JOIN party AS ac ON ac.pid = d.emp_id
												LEFT JOIN staff st on st.staid = d.emp_id
												LEFT JOIN department dep on dep.did = st.did
												WHERE  m.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' and d.type = '".$type ."' AND  m.company_id = $company_id AND m.etype = '".$etype."'  and m.uid = $uid  ");
return $query->result_array();
}
public function sendMessage( $mobile,$message )
{
$ptn = "/^[0-9]/";
$rpltxt = "92";
$mobile = preg_replace($ptn,$rpltxt,$mobile);
$url = ZONG_API_SERVICE_URL;
$post_string = '<?xml version="1.0" encoding="utf-8"?>'.
'<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">'.
'<soap:Body>'.
'<SendSingleSMS xmlns="http://tempuri.org/">'.
'<Src_nbr>'.ZONG_API_MOB .'</Src_nbr>'.
'<Password>'.ZONG_API_PASS .'</Password>'.
'<Dst_nbr>'.$mobile .'</Dst_nbr>'.
'<Mask>'.ZONG_API_MASK .'</Mask>'.
'<Message>'.$message .'</Message>'.
'</SendSingleSMS>'.
'</soap:Body>'.
'</soap:Envelope>';
$soap_do = curl_init();
curl_setopt($soap_do,CURLOPT_URL,$url );
curl_setopt($soap_do,CURLOPT_CONNECTTIMEOUT,10);
curl_setopt($soap_do,CURLOPT_TIMEOUT,10);
curl_setopt($soap_do,CURLOPT_RETURNTRANSFER,true );
curl_setopt($soap_do,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($soap_do,CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($soap_do,CURLOPT_POST,true );
curl_setopt($soap_do,CURLOPT_POSTFIELDS,$post_string);
curl_setopt($soap_do,CURLOPT_HTTPHEADER,array('Content-Type: text/xml; charset=utf-8','Content-Length: '.strlen($post_string) ));
$result = curl_exec($soap_do);
$err = curl_error($soap_do);
return $result;
}
public function fetchPurchaseReportData($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name)
{
if ($type == 'detailed') {
$query = $this->db->query("SELECT $field as voucher,$name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.remarks,  stockdetail.qty, stockdetail.weight, stockdetail.rate, stockdetail.amount, stockdetail.netamount, item.item_des as 'item_des',item.uom FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid INNER JOIN party party ON stockmain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3  INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON stockdetail.item_id = item.item_id INNER JOIN user ON user.uid = stockmain.uid  INNER JOIN department dept  ON  stockdetail.godown_id = dept.did WHERE  stockmain.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit  order by $orderBy");
return $query->result_array();
}else {
$query = $this->db->query("SELECT $field as voucher,$name,date(stockmain.vrdate) as DATE,dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username, date(stockmain.VRDATE) VRDATE, stockmain.vrnoa, round(SUM(stockdetail.qty)) qty, round(SUM(stockdetail.weight)) weight, round(SUM(stockdetail.rate)) rate, round(SUM(stockdetail.amount)) amount, round(sum(stockdetail.netamount)) netamount, stockmain.remarks FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.stid = stockdetail.stid INNER JOIN party party ON stockmain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3  INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON stockdetail.item_id = item.item_id INNER JOIN user ON user.uid = stockmain.uid  INNER JOIN department dept  ON  stockdetail.godown_id = dept.did WHERE  stockmain.vrdate between '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit group by $groupBy order by $orderBy");
return $query->result_array();
}
}
public function fetchPurchaseReportData_production($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name)
{
if ($type == 'detailed') {
$query = $this->db->query("SELECT $field as voucher,$name,staff.name as staff_name,staff.salary as staff_salary, DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.workorder, shift.name as shift_name,dept.name as dept_name, stockmain.remarks,item.artcile_no as article, if(item.uom='dozen', round(IFNULL(stockdetail.qty/12,0),0),round(IFNULL(stockdetail.qty,0),0)) as qty, stockdetail.weight, stockdetail.lrate as rate, stockdetail.lamount as amount, stockdetail.netamount, item.item_des AS 'item_des',item.uom
				FROM stockmain stockmain
				INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid
				left JOIN staff  ON stockdetail.emp_id = staff.staid
				left JOIN allot_shift  ON allot_shift.gid = staff.gid
				left JOIN shift  ON shift.shid = stockdetail.job_id
				INNER JOIN item item ON stockdetail.item_id = item.item_id
				INNER JOIN user ON user.uid = stockmain.uid
				INNER JOIN department dept ON stockdetail.godown_id = dept.did

				WHERE stockmain.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit
				$crit  order by $orderBy , stockmain.vrdate ");
return $query->result_array();
}else {
$query = $this->db->query("SELECT $field AS voucher,$name, DATE(stockmain.vrdate) AS DATE, DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username, DATE(stockmain.VRDATE) VRDATE, stockmain.vrnoa, ROUND(SUM(stockdetail.qty)) qty, ROUND(SUM(stockdetail.weight)) weight, ROUND(SUM(stockdetail.rate)) rate, ROUND(SUM(stockdetail.amount)) amount, ROUND(SUM(stockdetail.netamount)) netamount, stockmain.remarks
				FROM stockmain stockmain
				INNER JOIN stockdetail stockdetail ON stockmain.stid = stockdetail.stid
				left JOIN staff  ON stockdetail.emp_id = staff.staid
				INNER JOIN item item ON stockdetail.item_id = item.item_id
				INNER JOIN user ON user.uid = stockmain.uid
				INNER JOIN department dept ON stockdetail.godown_id = dept.did
				WHERE stockmain.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit
				GROUP BY $groupBy
				ORDER BY $orderBy, stockmain.vrdate");
return $query->result_array();
}
}
public function fetchPurchaseReportData_inward($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name)
{
$query = $this->db->query("SELECT $field as voucher,$name,stockmain.bilty_no,item.artcile_no,dept.name dept_name,stockmain.workorder,party.name as party_name,staff.name as staff_name, DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username,stockmain.workorder,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.remarks, if(item.uom='dozen', round(IFNULL(stockdetail.qty/12,0),0),round(IFNULL(stockdetail.qty,0),0)) AS qty, stockdetail.weight, stockdetail.lrate as rate, stockdetail.lamount as amount, stockdetail.netamount, item.item_des AS 'item_des',item.uom
				FROM stockmain stockmain
				INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid
				left JOIN staff  ON stockdetail.emp_id = staff.staid
				left JOIN party party ON stockmain.party_id = party.pid
				INNER JOIN item item ON stockdetail.item_id = item.item_id
				INNER JOIN user ON user.uid = stockmain.uid
				INNER JOIN department dept ON stockdetail.godown_id = dept.did
				WHERE stockmain.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit
				  order by $orderBy ,stockmain.vrdate ");
return $query->result_array();
}
public function fetchVendorReportData($startDate,$endDate,$what,$etype,$company_id,$orderBy,$name,$crit)
{
if ($etype == 'issue_receive') {
$etype=" and stockdetail.type<>'less' and stockmain.etype in ('issuetovenders','receivefromvenders','tr_consume','tr_produce','rejection','settelment')  ";
}else{
$etype=" and stockmain.etype = '".$etype ."'";
}
if ($what == 'none') {
$query = $this->db->query("SELECT $field as voucher,$name, dayname(vrdate) as weekdate,stockmain.etype, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.remarks,  stockdetail.qty, stockdetail.weight, stockdetail.rate, stockdetail.amount, stockdetail.netamount, item.item_des as 'item_des',item.uom FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid INNER JOIN party party ON stockmain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3  INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON stockdetail.item_id = item.item_id INNER JOIN user ON user.uid = stockmain.uid  INNER JOIN department dept  ON  stockdetail.godown_id = dept.did WHERE  stockmain.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id $etype $crit  order by $orderBy");
return $query->result_array();
}else {
$query = $this->db->query("SELECT $name,dayname(vrdate) as weekdate,party.name as party_name,stockmain.etype,stockmain.bilty_no, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,sp.name as subphae_name,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.remarks,stockdetail.dozen,stockdetail.bag, stockdetail.qty, stockdetail.weight, stockdetail.rate, stockdetail.amount, stockdetail.netamount, item.item_des AS 'item_des',item.uom,ifnull(op.op_stockqty,0) as op_stockqty,ifnull(op.op_stockweight,0) as op_stockweight
												FROM stockmain stockmain
												INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid
												INNER JOIN party party ON stockmain.party_id = party.pid
												INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
												INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
												INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
												left join subphase as sp on sp.id= stockdetail.phase_id
												INNER JOIN item item ON stockdetail.item_id = item.item_id
												INNER JOIN brand b ON b.bid = item.bid
												INNER JOIN category  cat ON cat.catid = item.catid
												INNER JOIN subcategory  subcat ON subcat.subcatid = item.subcatid
												INNER JOIN user ON user.uid = stockmain.uid
												INNER JOIN department dept ON stockdetail.godown_id = dept.did
												left join (SELECT item.item_id, if(item.uom='dozen', round(IFNULL(SUM(stockdetail.qty)/12,0),0),round(IFNULL(SUM(stockdetail.qty),0),0)) AS op_stockqty, IFNULL(SUM(stockdetail.weight),0) AS op_stockweight
										FROM stockdetail
										INNER JOIN stockmain  ON stockmain.stid = stockdetail.stid
										INNER JOIN item  ON stockdetail.item_id= item.item_id
										left JOIN department dept ON dept.did= stockdetail.godown_id
										WHERE  stockmain.vrdate < '".$startDate ."' AND stockmain.company_id=$company_id  ".$etype ." $crit 
										group by item.item_id having IFNULL(SUM(stockdetail.qty),0)<>0) as op on op.item_id=item.item_id
												WHERE stockmain.vrdate BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id  ".$etype ." $crit
												ORDER BY $orderBy,stockmain.vrdate,stockdetail.stdid");
return $query->result_array();
}
}
public function fetchChartData($period,$company_id,$etype)
{
$period = strtolower($period);
$query = '';
if ($period === 'daily') {
$query = "SELECT VRNOA, party.name AS ACCOUNT, NAMOUNT  FROM stockmain as stockmain INNER JOIN party as party  ON party.pid = stockmain.party_id  WHERE stockmain.etype='$etype' AND stockmain.vrdate = CURDATE() AND stockmain.company_id=$company_id order by stockmain.vrdate desc LIMIT 10";
}
else if ( $period === 'weekly') {
$query = "SELECT sum(case when date_format(vrdate, '%W') = 'Monday' then namount else 0 end) as 'Monday', sum(case when date_format(vrdate, '%W') = 'Tuesday' then namount else 0 end) as 'Tuesday', sum(case when date_format(vrdate, '%W') = 'Wednesday' then namount else 0 end) as 'Wednesday', sum(case when date_format(vrdate, '%W') = 'Thursday' then namount else 0 end) as 'Thursday', sum(case when date_format(vrdate, '%W') = 'Friday' then namount else 0 end) as 'Friday', sum(case when date_format(vrdate, '%W') = 'Saturday' then namount else 0 end) as 'Saturday', sum(case when date_format(vrdate, '%W') = 'Sunday' then namount else 0 end) as 'Sunday' from stockmain where    etype = '$etype' and vrdate between DATE_SUB(VRDATE, INTERVAL 7 DAY) and CURDATE() AND stockmain.company_id=$company_id group by WEEK(VRDATE) order by WEEK(VRDATE) desc LIMIT 1 ";
}
else if( $period === 'monthly') {
$query = "SELECT   sum(case when date_format(vrdate, '%b') = 'Jan' then namount else 0 end) as 'Jan', sum(case when date_format(vrdate, '%b') = 'Feb' then namount else 0 end) as 'Feb', sum(case when date_format(vrdate, '%b') = 'Mar' then namount else 0 end) as 'Mar', sum(case when date_format(vrdate, '%b') = 'Apr' then namount else 0 end) as 'Apr',sum(case when date_format(vrdate, '%b') = 'May' then namount else 0 end) as 'May', sum(case when date_format(vrdate, '%b') = 'Jun' then namount else 0 end) as 'Jun',sum(case when date_format(vrdate, '%b') = 'Jul' then namount else 0 end) as 'Jul', sum(case when date_format(vrdate, '%b') = 'Aug' then namount else 0 end) as 'Aug', sum(case when date_format(vrdate, '%b') = 'Sep' then namount else 0 end) as 'Sep', sum(case when date_format(vrdate, '%b') = 'Oct' then namount else 0 end) as 'Oct' , sum(case when date_format(vrdate, '%b') = 'Nov' then namount else 0 end) as 'Nov' , sum(case when date_format(vrdate, '%b') = 'Dec' then namount else 0 end) as 'Dec' from stockmain where    etype = 'purchase' and MONTH(VRDATE) = MONTH(CURDATE()) AND stockmain.company_id=$company_id group by month(VRDATE) order by month(VRDATE)";
}
else if ( $period === 'yearly') {
$query = "SELECT YEAR(vrdate) as 'Year', MONTHNAME(STR_TO_DATE(MONTH(VRDATE), '%m')) as Month, sum(namount) AS TotalAmount FROM stockmain where  etype = 'purchase' and YEAR(VRDATE) = YEAR(CURDATE()) and stockmain.company_id=$company_id GROUP BY YEAR(vrdate), MONTH(vrdate) ORDER BY YEAR(vrdate), MONTH(vrdate)";
}
$query = $this->db->query($query);
return $query->result_array();
}
public function fetchNetSum( $company_id,$etype )
{
if($etype=='sale'||$etype=='salereturn'||$etype=='purchase'||$etype=='purchasereturn'){
$query="SELECT IFNULL(SUM(NAMOUNT),0) as 'PRETURNS_TOTAL' FROM ordermain WHERE ordermain.etype='$etype' AND ordermain.company_id=$company_id";
}else{
$query="SELECT IFNULL(SUM(NAMOUNT),0) as 'PRETURNS_TOTAL' FROM stockmain WHERE stockmain.etype='$etype' AND stockmain.company_id=$company_id";
}
$result = $this->db->query($query);
return $result->result_array();
}
public function getMaxVrnoa($etype,$company_id) {
$result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM stockmain WHERE etype = '".$etype ."' and company_id=".$company_id ." ");
$row = $result->row_array();
$maxId = $row['vrnoa'];
return $maxId;
}
public function CheckDuplicateVoucher($vrnoa,$etype,$company_id,$gp) {
$result = $this->db->query("SELECT vrnoa FROM stockmain WHERE etype = '".$etype ."' and company_id=".$company_id ." and bilty_no=".$gp ." and vrnoa<>".$vrnoa ."  ");
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function save( $stockmain,$stockdetail,$vrnoa,$etype ) {
$this->db->where(array('vrnoa'=>$vrnoa,'etype'=>$etype,'company_id'=>$stockmain['company_id'] ));
$result = $this->db->get('stockmain');
$stid = "";
if ($result->num_rows() >0) {
$result = $result->row_array();
$stid = $result['stid'];
$this->db->where(array('vrnoa'=>$vrnoa,'etype'=>$etype ,'company_id'=>$stockmain['company_id']));
$this->db->update('stockmain',$stockmain);
$this->db->where(array('stid'=>$stid ));
$this->db->delete('stockdetail');
}else {
$this->db->insert('stockmain',$stockmain);
$stid = $this->db->insert_id();
}
if(is_array($stockdetail)){
foreach ($stockdetail as $detail) {
$detail['stid'] = $stid;
$this->db->insert('stockdetail',$detail);
}
}
return true;
}
public function fetch( $vrnoa,$etype,$company_id ) {
if($etype=='tr_produce'){
$etype=" and m.etype in ('tr_produce','tr_consume')";
}else{
$etype=" and m.etype='".$etype ."'";
}
$result = $this->db->query("SELECT d.type,d.job_id, m.approved_by,m.inv_no as inv_no_2,m.etype2,m.etype,m.prepared_by,m.bilty_date,sp.id as phase_id, sp.name as phase_name, d.dozen,d.bag,m.workorder,m.bilty_no, m.party_id_co,m.currency_id, d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight
		FROM stockmain AS m
		left JOIN stockdetail AS d ON m.stid = d.stid
		INNER JOIN item AS i ON i.item_id = d.item_id
		INNER JOIN department AS g ON g.did = d.godown_id
		left join subphase as sp on sp.id=d.phase_id
		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id  $etype order by d.stdid");
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function fetchOgp( $vrnoa,$etype,$company_id ,$company_id2) {
if($etype=='tr_produce'){
$etype=" and m.etype in ('tr_produce','tr_consume')";
}else{
$etype=" and m.etype='".$etype ."'";
}
$result = $this->db->query("SELECT '00' as duplicate_vrnoa, m.approved_by,m.inv_no as inv_no_2,m.etype2,m.etype,m.prepared_by,m.bilty_date,sp.id as phase_id, sp.name as phase_name, d.dozen,d.bag,m.workorder,m.bilty_no, m.party_id_co,m.currency_id, d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight
		FROM stockmain AS m
		left JOIN stockdetail AS d ON m.stid = d.stid
		INNER JOIN item AS i ON i.item_id = d.item_id
		INNER JOIN department AS g ON g.did = d.godown_id
		left join subphase as sp on sp.id=d.phase_id
		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id  $etype and m.vrnoa not in (select order_vrno from stockmain where etype='inward' and company_id = $company_id2 ) order by d.stdid ");
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
$result = $this->db->query("select vrnoa as duplicate_vrnoa,order_vrno from stockmain where etype='inward' and company_id = $company_id2 and order_vrno=$vrnoa ");
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else{
return false;
}
}
}
public function fetchIgp( $vrnoa,$etype,$company_id ,$etype2) {
if($etype=='tr_produce'){
$etype=" and m.etype in ('tr_produce','tr_consume')";
}else{
$etype=" and m.etype='".$etype ."'";
}
$crit="";
if($etype2=='pur_order'){
$crit="purchase";
}else if($etype2=='fabricPurchaseContract'){
$crit="fabricPurchase";
}else if($etype2=='yarnPurchaseContract'){
$crit="yarnPurchase";
}
$result = $this->db->query("SELECT '00' as duplicate_vrnoa,ifnull(po.rate,0) as cost_price,m.approved_by,m.inv_no as inv_no_2,m.etype2,m.etype,m.prepared_by,m.bilty_date,sp.id as phase_id, sp.name as phase_name, d.dozen,d.bag,m.workorder,m.bilty_no, m.party_id_co,m.currency_id, d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight
		FROM stockmain AS m
		left JOIN stockdetail AS d ON m.stid = d.stid
		INNER JOIN item AS i ON i.item_id = d.item_id
		INNER JOIN department AS g ON g.did = d.godown_id
		left join subphase as sp on sp.id=d.phase_id
			left join(
			SELECT d.item_id, d.rate 
			FROM orderdetail d
			INNER JOIN ordermain m ON m.oid = d.oid
			WHERE m.vrnoa=(select inv_no  from stockmain m where   m.company_id=$company_id and m.vrnoa=$vrnoa $etype) and m.etype='$etype2' and m.company_id=$company_id
			group BY d.item_id
			) as po on po.item_id=i.item_id

		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id and m.approved_by='$etype2'  $etype and m.vrnoa not in (select order_vrno from ordermain where etype='$crit' and company_id=$company_id )  order by d.stdid");
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
$result = $this->db->query("select vrnoa as duplicate_vrnoa,order_vrno from ordermain where etype='$crit' and company_id = $company_id and order_vrno=$vrnoa ");
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else{
return false;
}
}
}
public function fetchVoucher($vrnoa,$etype,$company_id)
{
$query = $this->db->query("SELECT m.approved_by,m.inv_no, m.bilty_no, m.prepared_by,m.etype2, sp.name as phase_name,m.workorder,d.dozen,d.bag,t.name AS transporter_name,dp.name dept_name, p.name AS party_name,m.vrno,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, d.qty, ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight
		FROM stockmain AS m
		INNER JOIN stockdetail AS d ON m.stid = d.stid
		INNER JOIN item AS i ON i.item_id = d.item_id
		INNER JOIN party AS p ON p.pid=m.party_id
		INNER JOIN department AS dp ON dp.did=d.godown_id
		left JOIN transporter AS t ON t.transporter_id=m.transporter_id
		LEFT JOIN subphase  AS sp ON sp.id=d.phase_id
		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '".$etype ."' ");
return $query->result_array();
}
public function fetchNavigation( $vrnoa,$etype,$company_id ) {
$result = $this->db->query("SELECT m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' FROM stockmain m INNER JOIN stockdetail d ON m.stid = d.stid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN department dep2 ON dep2.did = d.godown_id2 WHERE m.vrnoa = $vrnoa AND m.etype = '".$etype ."' AND m.company_id = ".$company_id ." AND qty > 0");
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function fetchByCol($col) {
$result = $this->db->query("SELECT DISTINCT $col FROM stockmain");
return $result->result_array();
}
public function fetchByCol_inward($col) {
$result = $this->db->query("SELECT DISTINCT $col FROM stockmain where etype in ('inward','outward') ");
return $result->result_array();
}
public function fetchByColFromStkDetail($col) {
$result = $this->db->query("SELECT DISTINCT $col FROM stockdetail");
return $result->result_array();
}
public function delete( $vrnoa,$etype ,$company_id) {
$this->db->where(array('etype'=>$etype,'dcno'=>$vrnoa ,'company_id'=>$company_id ));
$result = $this->db->delete('pledger');
$this->db->where(array('etype'=>$etype,'vrnoa'=>$vrnoa ,'company_id'=>$company_id ));
$result = $this->db->get('stockmain');
if ($result->num_rows() == 0) {
return false;
}else {
$result = $result->row_array();
$stid = $result['stid'];
$this->db->where(array('etype'=>$etype,'vrnoa'=>$vrnoa ));
$this->db->delete('stockmain');
$this->db->where(array('stid'=>$stid ));
$this->db->delete('stockdetail');
return true;
}
}
public function fetchPurchaseReturnReportData($startDate,$endDate,$what,$type)
{
if ($what === 'voucher') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id ORDER BY stockmain.VRNOA");
return $query->result_array();
}else {
$query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id Group by stockmain.VRNOA ORDER BY stockmain.VRNOA");
return $query->result_array();
}
}
else if ($what == 'account') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id ORDER BY stockmain.party_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id Group by stockmain.party_id ORDER BY stockmain.party_id");
return $query->result_array();
}
}
else if ($what == 'godown') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, dept.name AS NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON stockdetail.godown_id = dept.did WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id ORDER BY stockdetail.godown_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT dept.NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON dept.did = stockdetail.godown_id WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockmain.company_id=$company_id GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
return $query->result_array();
}
}
else if ($what == 'item') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.item_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT item.item_des as NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
return $query->result_array();
}
}
else if ($what == 'date') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.vrdate");
return $query->result_array();
}else {
$query = $this->db->query("SELECT date(stockmain.vrdate) as DATE, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.vrdate ORDER BY stockmain.vrdate");
return $query->result_array();
}
}
}
public function fetchStockNavigationData($startDate,$endDate,$what,$type)
{
if ($what === 'voucher') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockdetail.UOM, stockdetail.QTY, item.item_des, frm.name 'from_dept', _to.name 'to_dept' FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department frm ON stockdetail.godown_id = frm.did INNER JOIN department _to ON stockdetail.godown_id2 = _to.did WHERE stockmain.ETYPE='stocktransfer' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockdetail.QTY > 0 ORDER BY stockmain.VRNOA");
return $query->result_array();
}
}
else if ($what == 'location') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockdetail.UOM, stockdetail.QTY, item.item_des, frm.name 'from_dept', _to.name 'to_dept' FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department frm ON stockdetail.godown_id = frm.did INNER JOIN department _to ON stockdetail.godown_id2 = _to.did WHERE stockmain.ETYPE='stocktransfer' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockdetail.QTY > 0 ORDER BY frm.name");
return $query->result_array();
}
}
else if ($what == 'item') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockdetail.UOM, stockdetail.QTY, item.item_des, frm.name 'from_dept', _to.name 'to_dept' FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department frm ON stockdetail.godown_id = frm.did INNER JOIN department _to ON stockdetail.godown_id2 = _to.did WHERE stockmain.ETYPE='stocktransfer' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockdetail.QTY > 0 ORDER BY item.item_des");
return $query->result_array();
}
}
else if ($what == 'date') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockdetail.UOM, stockdetail.QTY, item.item_des, frm.name 'from_dept', _to.name 'to_dept' FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department frm ON stockdetail.godown_id = frm.did INNER JOIN department _to ON stockdetail.godown_id2 = _to.did WHERE stockmain.ETYPE='stocktransfer' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' AND stockdetail.QTY > 0 ORDER BY stockmain.VRDATE");
return $query->result_array();
}
}
}
public function fetchMaterialReturnData($startDate,$endDate,$what,$type)
{
if ($what === 'voucher') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.VRNOA");
return $query->result_array();
}else {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, sum(stockdetail.QTY) QTY, sum(stockdetail.RATE) RATE, sum(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.VRNOA ORDER BY stockmain.VRNOA");
return $query->result_array();
}
}
else if ($what == 'person') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.received_by");
return $query->result_array();
}else {
$query = $this->db->query("SELECT stockmain.received_by NAME, SUM(stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.received_by ORDER BY stockmain.received_by");
return $query->result_array();
}
}
else if ($what == 'location') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, dept.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON stockdetail.godown_id = dept.did WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.godown_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT dept.NAME, SUM(stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON dept.did = stockdetail.godown_id WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
return $query->result_array();
}
}
else if ($what == 'item') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.item_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT item.item_des NAME, (stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
return $query->result_array();
}
}
else if ($what == 'date') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.vrdate desc");
return $query->result_array();
}else {
$query = $this->db->query("SELECT stockmain.VRDATE NAME, (stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.VRDATE ORDER BY stockmain.VRDATE");
return $query->result_array();
}
}
}
public function fetchConsumptionData($startDate,$endDate,$what,$type)
{
if ($what === 'voucher') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.VRNOA");
return $query->result_array();
}else {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, sum(stockdetail.QTY) QTY, sum(stockdetail.RATE) RATE, sum(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.VRNOA ORDER BY stockmain.VRNOA");
return $query->result_array();
}
}
else if ($what == 'person') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.received_by");
return $query->result_array();
}else {
$query = $this->db->query("SELECT stockmain.received_by NAME, SUM(stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.received_by ORDER BY stockmain.received_by");
return $query->result_array();
}
}
else if ($what == 'location') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, dept.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON stockdetail.godown_id = dept.did WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.godown_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT dept.NAME, SUM(stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON dept.did = stockdetail.godown_id WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
return $query->result_array();
}
}
else if ($what == 'item') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockdetail.item_id");
return $query->result_array();
}else {
$query = $this->db->query("SELECT item.item_des NAME, (stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
return $query->result_array();
}
}
else if ($what == 'date') {
if ($type == 'detailed') {
$query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' ORDER BY stockmain.vrdate desc");
return $query->result_array();
}else {
$query = $this->db->query("SELECT stockmain.VRDATE NAME, (stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '".$startDate ."' AND '".$endDate ."' GROUP BY stockmain.VRDATE ORDER BY stockmain.VRDATE");
return $query->result_array();
}
}
}
public function fetchPRRangeSum( $from ,$to )
{
$query = "SELECT IFNULL(SUM(CREDIT), 0)-IFNULL(SUM(DEBIT),0) as 'PRETURNS_TOTAL' FROM pledger pledger WHERE pid IN (SELECT pid FROM party party WHERE NAME='purchase return') AND date between '{$from}' AND '{$to}'";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchImportRangeSum( $from ,$to )
{
$query = "SELECT IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) AS 'PIMPORTS_TOTAL' FROM pledger pledger WHERE pid IN ( SELECT pid FROM party party WHERE NAME='purchase import') AND date BETWEEN '{$from}' AND '{$to}'";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchRangeSum( $from ,$to )
{
$query = "SELECT IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) AS 'PURCHASES_TOTAL' FROM pledger pledger WHERE pid IN ( SELECT pid FROM party party WHERE NAME='purchase') AND date BETWEEN '{$from}' AND '{$to}'";
$result = $this->db->query($query);
return $result->result_array();
}




}

?>