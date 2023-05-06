<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Accounts extends CI_Model {
public function __construct() {
parent::__construct();
}
public function getMaxId() {
$this->db->select_max('pid');
$result = $this->db->get('party');
$row = $result->row_array();
$maxId = $row['pid'];
return $maxId;
}


public function fetchDisPayRecvCount($company_id,$etype)
{
if ($etype == 'payable') {
$query = "select count(*) as NET_COUNT from(
			SELECT *, invoice_amount-paid AS balance
			FROM (
			SELECT a.dcno, a.date, party.name AS account, IFNULL(a.date, '-') AS due_date, IFNULL(DATEDIFF(a.date, CURDATE()), '-') AS days_passed, SUM(a.credit) invoice_amount, (
			SELECT IFNULL(SUM(b.debit),0)
			FROM pledger b
			WHERE b.invoice = a.dcno AND b.pid =a.pid AND b.etype in ('distributionpayment','pd_issue','jv') AND b.company_id = $company_id) paid
			FROM pledger a
			INNER JOIN party ON a.pid = party.pid
			WHERE a.etype='distributionsale' AND a.date = CURDATE() AND a.company_id = $company_id and a.debit = 0.00
			GROUP BY a.dcno,a.date
			ORDER BY a.dcno
			) AS aging
			having invoice_amount > paid
		) as payable";
$query = $this->db->query($query);
$result = $query->row_array();
return $result['NET_COUNT'];
}else{
$query = "select count(*) as NET_COUNT from(
		SELECT *, invoice_amount-paid AS balance
		FROM (
		SELECT a.dcno, a.date, party.name AS account, IFNULL(a.date, '-') AS due_date, IFNULL(DATEDIFF(a.date, CURDATE()), '-') AS days_passed, SUM(a.debit) invoice_amount, (
		SELECT IFNULL(SUM(b.credit),0)
		FROM pledger b
		WHERE b.invoice = a.dcno AND b.pid =a.pid AND b.etype in ('distributionreceive','jv','pd_receive') AND b.company_id = $company_id) paid
		FROM pledger a
		INNER JOIN party ON a.pid = party.pid
		WHERE a.etype='distributionsale' AND a.date = CURDATE() AND a.company_id = $company_id and a.credit = 0.00
		GROUP BY a.dcno,a.date
		ORDER BY a.dcno
		) AS aging
		having invoice_amount > paid
	) as receivable";
$query = $this->db->query($query);
$result = $query->row_array();
return $result['NET_COUNT'];
}
}
public function CheckDuplicateCheck($vrnoa,$etype,$company_id,$chk_no) {
$result = $this->db->query("SELECT dcno FROM pledger WHERE etype = '".$etype ."' and company_id=".$company_id ." and chq_no='".$chk_no ."' and dcno<>".$vrnoa ."  ");
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function PlsOrderWise($wo)
{
$crit="";
if((int)$wo!==0 ){
$crit=" and l.wo=$wo ";
}
$total_expenses=0;
$result2 = $this->db->query("SELECT IFNULL(SUM(debit),0) - IFNULL(SUM(credit),0) total_expenses
		FROM pledger l
		INNER JOIN party p ON p.pid=l.pid
		INNER JOIN level3 l3 ON l3.l3=p.level3
		INNER JOIN level2 l2 ON l2.l2=l3.l2
		INNER JOIN level1 l1 ON l1.l1=l2.l1
		WHERE  l1.bslevel IN ('EXPENSES') $crit
		");
$row = $result2->row_array();
$total_expenses = $row['total_expenses'];
$qry="SELECT $total_expenses total_expenses,l3.name level3_name,p.name account_name,IFNULL(SUM(debit),0) debit,IFNULL(SUM(credit),0)credit
	FROM pledger l
	INNER JOIN party p ON p.pid=l.pid
	INNER JOIN level3 l3 ON l3.l3=p.level3
	INNER JOIN level2 l2 ON l2.l2=l3.l2
	INNER JOIN level1 l1 ON l1.l1=l2.l1
	WHERE  l1.bslevel IN ('EXPENSES','INCOME') $crit
	GROUP BY l3.name,p.name
	ORDER BY l1.bslevel DESC,p.name ASC;";
$query= $this->db->query($qry);
$result = $query->result_array();
return $result;
}
public function searchAccount($search,$type)
{
$crit = "";
$activee = 1;
$qry="SELECT IFNULL(pl.balance,0) AS balance, IFNULL(party.city,'') AS city, IFNULL(party.address,'') AS address,
	IFNULL(party.cityarea,'') AS cityarea,  IFNULL(party.mobile,'') AS mobile,
	`party`.pid, `party`.pid AS party_id,`party`.name, ROUND(IFNULL(`party`.limit,0),0) AS `limit`, `party`.account_id, 
	`party`.level3, level3.name AS level3_name
	FROM `party`
	INNER JOIN `level3` ON `level3`.`l3` = `party`.`level3`
	LEFT JOIN (
	SELECT IFNULL(SUM(debit),0)- IFNULL(SUM(credit),0) AS balance,pid
	FROM pledger
	GROUP BY pid) AS pl ON pl.pid= `party`.`pid`
	WHERE party.active = 1 AND (party.name LIKE '%$search%' OR party.mobile LIKE '%$search%' OR party.pid LIKE '%$search%' OR party.address LIKE '%$search%' OR party.city LIKE '%$search%' OR party.cityarea LIKE '%$search%' OR  level3.name LIKE '%$search%')
	LIMIT 0, 20";
$query= $this->db->query($qry);
$result = $query->result_array();
return $result;
}
public function searchAccountAll($search,$type)
{
$crit = "";
$activee = 1;
$qry="SELECT ifnull(pl.balance,0) as balance,party.city,party.address,party.cityarea
	,`party`.uname,party.mobile,`party`.pid,
	`party`.pid AS party_id,`party`.name,`party`.uname, `party`.limit, 
	`party`.account_id, `party`.mobile, `party`.address, `party`.level3, 
	level3.name AS level3_name
	FROM `party`
	INNER JOIN `level3` ON `level3`.`l3` = `party`.`level3`
	LEFT JOIN (
	SELECT IFNULL(SUM(debit),0)- IFNULL(SUM(credit),0) AS balance,pid
	FROM pledger
	GROUP BY pid) AS pl ON pl.pid= `party`.`pid`
	WHERE party.active = 1 AND (party.name LIKE '%".$search ."%' 
	OR party.mobile LIKE '%".$search ."%'
	OR party.pid LIKE '%".$search ."%'
	OR party.address LIKE '%".$search ."%'
	OR party.city LIKE '%".$search ."%'
	OR party.cityarea LIKE '%".$search ."%'
	OR party.uname LIKE '%".$search ."%'
	OR level3.name LIKE '%".$search ."%' ) ;";
$query= $this->db->query($qry);
$result = $query->result_array();
return $result;
}
public function getAccountinfobyid($pid)
{
$qry="SELECT ifnull(pl.balance,0) as balance,party.city,party.address,party.cityarea
	,`party`.name,party.mobile,`party`.pid,
	`party`.pid AS party_id,`party`.name,`party`.name, round(ifnull(`party`.limit,0),0) as `limit`, 
	`party`.account_id, `party`.mobile, `party`.address, `party`.level3, 
	level3.name AS level3_name
	FROM `party`
	INNER JOIN `level3` ON `level3`.`l3` = `party`.`level3`
	LEFT JOIN (
	SELECT IFNULL(SUM(debit),0)- IFNULL(SUM(credit),0) AS balance,pid
	FROM pledger
	GROUP BY pid) AS pl ON pl.pid= `party`.`pid`
	WHERE party.active = 1 and party.pid=$pid
	LIMIT 0, 20;";
$query= $this->db->query($qry);
$result = $query->result_array();
return $result;
}
public function getIncomeAccounts()
{
$query = "select party_id, party.name from party inner join level3 on party.level3 = level3.l3 INNER join level2 on level2.l2 = level3.l2 WHERE level2.name='other income'";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchNetOperatingExpenses($from,$to,$company_id) 
{
$query = "SELECT SUM(DEBIT) as 'AMOUNT'FROM pledger INNER JOIN party ON pledger.pid = party.pid INNER JOIN level3 ON party.level3 = level3.l3 INNER JOIN level2 ON level2.l2 = level3.l2 INNER JOIN level1 ON level1.l1 = level2.l1 WHERE level2.name in('OPERATING EXPENSES','OPPERATING EXP') $company_id AND pledger.DATE BETWEEN '{$from}' AND '{$to}'GROUP BY level2.name";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchNetExpense( $from,$to,$company_id)
{
$query = "SELECT ifnull(SUM(debit),0) as 'EXPENSE_TOTAL' 
	FROM pledger 
	INNER JOIN party ON pledger.pid = party.pid 
	INNER JOIN level3 ON party.level3 = level3.l3 
	INNER JOIN level2 ON level2.l2 = level3.l2 
	INNER JOIN level1 ON level1.l1 = level2.l1 
	WHERE level1.bslevel='EXPENSES' AND level1.name <> 'COST OF GOODS SOLD' $company_id AND pledger.date BETWEEN '{$from}' AND '{$to}' GROUP BY level1.name";
$result =  $this->db->query($query);
return $result->result_array();
}
public function fetchClosingStockReportData( $from,$to,$company_id )
{
$query = "SELECT cat.name AS DESCRIPTION,i.artcile_no AS ARTICLE,i.uom AS UOM,i.item_des NAME,i.item_id, dep.NAME AS dept_name, IF(i.uom='dozen', ROUND(IFNULL(SUM(d.qty)/12,0),0), ROUND(IFNULL(SUM(d.qty),0),0)) AS qty, ROUND(IFNULL(lp.rate,0),2) AS cost, ROUND(IFNULL(SUM(d.qty),0)* IFNULL(lp.rate,0),2) AS value
	FROM stockdetail d
	INNER JOIN item i ON i.item_id=d.item_id
	INNER JOIN brand b ON b.bid=i.bid
	INNER JOIN category cat ON cat.catid=i.catid
	INNER JOIN subcategory subcat ON subcat.subcatid=i.subcatid
	INNER JOIN stockmain m ON m.stid = d.stid
	INNER JOIN company ON company.company_id = m.company_id
	LEFT JOIN department dep ON dep.did = d.godown_id
	LEFT JOIN subphase AS sp ON sp.id=d.phase_id
	LEFT JOIN (
	SELECT d.item_id,d.rate AS rate
	FROM orderdetail d
	WHERE d.qty>0 AND d.oid=(
	SELECT `oid`
	FROM orderdetail
	WHERE item_id=d.item_id
	ORDER BY oid DESC
	LIMIT 1)
	GROUP BY d.item_id
	ORDER BY d.item_id) AS lp ON lp.item_id=d.item_id
	WHERE m.VRDATE <= '".$to ."' AND m.company_id<>0 $company_id
	GROUP BY cat.name,i.item_des";
$result = $this->db->query( $query );
return $result->result_array();
}
public function fetchOpeningStockReportData( $from,$to,$company_id )
{
$query = "SELECT cat.name AS DESCRIPTION,i.artcile_no AS ARTICLE,i.uom AS UOM,i.item_des NAME,i.item_id, dep.NAME AS dept_name, IF(i.uom='dozen', ROUND(IFNULL(SUM(d.qty)/12,0),0), ROUND(IFNULL(SUM(d.qty),0),0)) AS qty, ROUND(IFNULL(lp.rate,0),2) AS cost, ROUND(IFNULL(SUM(d.qty),0)* IFNULL(lp.rate,0),2) AS value
	FROM stockdetail d
	INNER JOIN item i ON i.item_id=d.item_id
	INNER JOIN brand b ON b.bid=i.bid
	INNER JOIN category cat ON cat.catid=i.catid
	INNER JOIN subcategory subcat ON subcat.subcatid=i.subcatid
	INNER JOIN stockmain m ON m.stid = d.stid
	INNER JOIN company ON company.company_id = m.company_id
	LEFT JOIN department dep ON dep.did = d.godown_id
	LEFT JOIN subphase AS sp ON sp.id=d.phase_id
	LEFT JOIN (
	SELECT d.item_id,d.rate AS rate
	FROM orderdetail d
	WHERE d.qty>0 AND d.oid=(
	SELECT `oid`
	FROM orderdetail
	WHERE item_id=d.item_id
	ORDER BY oid DESC
	LIMIT 1)
	GROUP BY d.item_id
	ORDER BY d.item_id) AS lp ON lp.item_id=d.item_id
	WHERE m.VRDATE < '".$from ."'  AND m.company_id<>0 $company_id
	GROUP BY cat.name,i.item_des";
$result = $this->db->query( $query );
return $result->result_array();
}
public function fetchOtherIncomeSum( $from,$to,$company_id )
{
$query = "SELECT IFNULL(SUM(pledger.credit), 0)-IFNULL(SUM(pledger.debit), 0) as 'INCOME_TOTAL' FROM pledger INNER JOIN party ON pledger.pid = party.pid INNER JOIN level3 ON party.level3 = level3.l3 INNER JOIN level2 ON level3.l2 = level2.l2 WHERE level2.name = 'other income' AND pledger.date BETWEEN '{$from}' AND '{$to}' $company_id GROUP BY level2.name";
$result =  $this->db->query($query);
return $result->result_array();
}
public function getIncomeReportData( $from,$to,$company_id )
{
$query = "SELECT party.NAME, ifnull(SUM(credit),0)-ifnull(SUM(debit),0) as 'AMOUNT' FROM pledger INNER JOIN party ON pledger.pid = party.pid INNER JOIN level3 ON party.level3 = level3.l3 INNER JOIN level2 ON level2.l2 = level3.l2  WHERE level2.name='other income' $company_id AND pledger.DATE BETWEEN '{$from}' AND '{$to}' GROUP BY party.name HAVING IFNULL(SUM(pledger.credit),0)-IFNULL(SUM(pledger.debit),0)<>0;";
$result = $this->db->query($query);
return $result->result_array();
}
public function getExpenseReportData( $from,$to,$company_id )
{
$query = "SELECT party.NAME, SUM(DEBIT) as 'AMOUNT' FROM pledger INNER JOIN party ON pledger.pid = party.pid INNER JOIN level3 ON party.level3 = level3.l3 INNER JOIN level2 ON level2.l2 = level3.l2 INNER JOIN level1 ON level1.l1 = level2.l1 WHERE level1.bslevel ='EXPENSES' AND level2.name <> 'COST OF GOODS SOLD' $company_id AND pledger.DATE BETWEEN '{$from}' AND '{$to}' GROUP BY pledger.pid HAVING IFNULL(SUM(DEBIT),0)<>0;";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchBalanceSheet( $startDate,$endDate,$company_id,$type )
{
$query = '';
if ($type === 'ASSETS') {
$query = "SELECT level1.bslevel,round(SUM(DEBIT)-SUM(CREDIT),0) AS 'AMOUNT', party.NAME AS 'PARTY_NAME', party.ACCOUNT_ID, level1.name AS 'L1NAME', level2.name AS 'L2NAME', level3.name AS 'L3NAME' FROM pledger INNER JOIN party ON pledger.pid = party. pid INNER JOIN level3 ON party.level3 = level3.l3 INNER JOIN level2 ON level2.l2 = level3.l2 INNER JOIN level1 ON level2.l1 = level1.l1 WHERE level1.bslevel = 'ASSETS' AND pledger.date BETWEEN '{$startDate}' AND '{$endDate}' $company_id GROUP BY party.name ORDER BY level1.bslevel,account_id";
}else if ($type === 'LIABILITIES') {
$query = "SELECT level1.bslevel,round(SUM(CREDIT)-SUM(DEBIT),0) AS 'AMOUNT', party.NAME AS 'PARTY_NAME', party.ACCOUNT_ID, level1.name AS 'L1NAME', level2.name AS 'L2NAME', level3.name AS 'L3NAME' FROM pledger INNER JOIN party ON pledger.pid = party. pid INNER JOIN level3 ON party.level3 = level3.l3 INNER JOIN level2 ON level2.l2 = level3.l2 INNER JOIN level1 ON level2.l1 = level1.l1 WHERE level1.bslevel = 'LIABILITES' AND pledger.date BETWEEN '{$startDate}' AND '{$endDate}' $company_id GROUP BY party.name ORDER BY level1.bslevel,account_id";
}
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchNetFinanceCost($from,$to,$company_id) 
{
$query = "SELECT SUM(DEBIT) as 'AMOUNT' FROM pledger INNER JOIN party ON pledger.pid = party.pid INNER JOIN level3 ON party.level3 = level3.l3 INNER JOIN level2 ON level2.l2 = level3.l2 INNER JOIN level1 ON level1.l1 = level2.l1 WHERE level2.name='finance cost' $company_id AND pledger.DATE BETWEEN '{$from}' AND '{$to}'GROUP BY level2.name";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchNetPFT($from,$to,$company_id) 
{
$query = "SELECT SUM(DEBIT) as 'AMOUNT' FROM pledger INNER JOIN party ON pledger.pid = party.pid INNER JOIN level3 ON party.level3 = level3.l3 INNER JOIN level2 ON level2.l2 = level3.l2 INNER JOIN level1 ON level1.l1 = level2.l1 WHERE level2.name='provision for taxation' $company_id AND pledger.DATE BETWEEN '{$from}' AND '{$to}'GROUP BY level2.name";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchNetWPPF($from,$to,$company_id) 
{
$query = "SELECT SUM(DEBIT) as 'AMOUNT' FROM pledger INNER JOIN party ON pledger.pid = party.pid INNER JOIN level3 ON party.level3 = level3.l3 INNER JOIN level2 ON level2.l2 = level3.l2 INNER JOIN level1 ON level1.l1 = level2.l1 WHERE level2.name='worker profit participation fund' $company_id AND pledger.DATE BETWEEN '{$from}' AND '{$to}'GROUP BY level2.name";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchAgingSheetData_Balance( $party_id,$company_id,$startDate,$endDate,$type,$crit,$having_crit )
{
$query = "";
$company_id2="";
if($company_id!=''){
$company_id2=str_replace("l.","pledger.",$company_id);
}
$crit_having ='';
if($having_crit=='withoutzero')
$crit_having =' having IFNULL(SUM(DEBIT),0)-IFNULL(SUM(CREDIT), 0) <> 0 ';
if($type=='creditors'){
$query =" SELECT p.name AS 'ACCOUNT',p.pid AS 'PID', IFNULL(SUM(DEBIT),0) AS DEBIT,IFNULL(SUM(CREDIT),0) AS CREDIT, IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT), 0) AS 'CURRENT_BALANCE', (
	SELECT IFNULL(SUM(CREDIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 15 DAY) AND pledger.date <= '{$endDate}' $company_id2 ) AS '15_DAYS', (
	SELECT IFNULL(SUM(CREDIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 30 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 15 DAY) $company_id2) AS '30_DAYS', (
	SELECT IFNULL(SUM(CREDIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 45 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 30 DAY) $company_id2) AS '45_DAYS', (
	SELECT IFNULL(SUM(CREDIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 60 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 45 DAY) $company_id2) AS '60_DAYS', (
	SELECT IFNULL(SUM(CREDIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 75 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 60 DAY) $company_id2) AS '75_DAYS', (
	SELECT IFNULL(SUM(CREDIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 90 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 75 DAY) $company_id2) AS '90_DAYS', (
	SELECT IFNULL(SUM(CREDIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 105 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 90 DAY) $company_id2) AS '105_DAYS', (
	SELECT IFNULL(SUM(CREDIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 120 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 105 DAY) $company_id2) AS '120_DAYS', (
	SELECT IFNULL(SUM(CREDIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 120 DAY) $company_id2) AS 'LESSTHAN_120_DAYS'
	FROM pledger AS l
	INNER JOIN party AS p ON l.pid=p.pid
	WHERE p.level3 IN (
	SELECT l3
	FROM level3
	WHERE name LIKE '%$type%') AND l.date <= '{$endDate}' {$company_id} $crit

	GROUP BY l.pid $crit_having;";
}else{
$query =" SELECT p.name AS 'ACCOUNT',p.pid AS 'PID',IFNULL(SUM(CREDIT),0) AS CREDIT, IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT), 0) AS 'CURRENT_BALANCE', (
	SELECT IFNULL(SUM(DEBIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 15 DAY) AND pledger.date <= '{$endDate}' $company_id2 ) AS '15_DAYS', (
	SELECT IFNULL(SUM(DEBIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 30 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 15 DAY) $company_id2) AS '30_DAYS', (
	SELECT IFNULL(SUM(DEBIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 45 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 30 DAY) $company_id2) AS '45_DAYS', (
	SELECT IFNULL(SUM(DEBIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 60 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 45 DAY) $company_id2) AS '60_DAYS', (
	SELECT IFNULL(SUM(DEBIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 75 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 60 DAY) $company_id2) AS '75_DAYS', (
	SELECT IFNULL(SUM(DEBIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 90 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 75 DAY) $company_id2) AS '90_DAYS', (
	SELECT IFNULL(SUM(DEBIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 105 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 90 DAY) $company_id2) AS '105_DAYS', (
	SELECT IFNULL(SUM(DEBIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 120 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 105 DAY) $company_id2) AS '120_DAYS', (
	SELECT IFNULL(SUM(DEBIT), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 120 DAY) $company_id2) AS 'LESSTHAN_120_DAYS'
	FROM pledger AS l
	INNER JOIN party AS p ON l.pid=p.pid
	WHERE p.level3 IN (
	SELECT l3
	FROM level3
	WHERE name LIKE '%$type%') AND l.date <= '{$endDate}' {$company_id} $crit

	GROUP BY l.pid $crit_having;";
}
$result = $this->db->query( $query );
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function fetchAgingSheetData( $party_id,$company_id,$startDate,$endDate,$type,$crit,$having_crit )
{
$query = "";
$company_id2="";
if($company_id!=''){
$company_id2=str_replace("l.","pledger.",$company_id);
}
$crit_having ='';
if($having_crit=='withoutzero')
$crit_having =' having IFNULL(SUM(DEBIT),0)-IFNULL(SUM(CREDIT), 0) <> 0 ';
$query ="SELECT p.name AS 'ACCOUNT',p.pid AS 'PID', IFNULL(SUM(DEBIT),0)-IFNULL(SUM(CREDIT), 0) AS 'CURRENT_BALANCE', (
	SELECT IFNULL((SUM(DEBIT)-SUM(CREDIT)), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 15 DAY) AND pledger.date <= '{$endDate}' $company_id2) AS '15_DAYS', (
	SELECT IFNULL((SUM(DEBIT)-SUM(CREDIT)), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 30 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 15 DAY) $company_id2) AS '30_DAYS', (
	SELECT IFNULL((SUM(DEBIT)-SUM(CREDIT)), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 45 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 30 DAY) $company_id2) AS '45_DAYS', (
	SELECT IFNULL((SUM(DEBIT)-SUM(CREDIT)), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 60 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 45 DAY) $company_id2) AS '60_DAYS', (
	SELECT IFNULL((SUM(DEBIT)-SUM(CREDIT)), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 75 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 60 DAY) $company_id2) AS '75_DAYS', (
	SELECT IFNULL((SUM(DEBIT)-SUM(CREDIT)), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 90 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 75 DAY) $company_id2) AS '90_DAYS', (
	SELECT IFNULL((SUM(DEBIT)-SUM(CREDIT)), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 105 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 90 DAY) $company_id2) AS '105_DAYS', (
	SELECT IFNULL((SUM(DEBIT)-SUM(CREDIT)), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date > DATE_SUB('{$endDate}', INTERVAL 120 DAY) AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 105 DAY) $company_id2) AS '120_DAYS', (
	SELECT IFNULL((SUM(DEBIT)-SUM(CREDIT)), 0)
	FROM pledger
	WHERE pledger.pid = p.pid AND pledger.date <= DATE_SUB('{$endDate}', INTERVAL 120 DAY) $company_id2) AS 'LESSTHAN_120_DAYS'
	FROM pledger AS l
	INNER JOIN party AS p ON l.pid=p.pid
	WHERE p.level3 IN (
	SELECT l3
	FROM level3
	WHERE name LIKE '%$type%') AND l.date <= '{$endDate}' {$company_id} $crit
	GROUP BY l.pid $crit_having ";
$result = $this->db->query( $query );
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function fetchOrderSummary($company_id,$startDate,$endDate,$po )
{
$query = "";
$query = $this->db->query("call spw_OrderSummary('$startDate', '$endDate', $company_id ,$po)");
return $query->result_array();
}
public function fetchByCol($col) {
$result = $this->db->query("SELECT DISTINCT $col FROM party");
return $result->result_array();
}
public function fetchNetChequeSum( $etype,$company_id )
{
$query= $this->db->query("SELECT IFNULL(SUM(amount), 0) as NETTOTAL FROM pd_cheque WHERE etype='$etype' AND post='unpost' AND company_id={$company_id}");
$result = $query->result_array();
return $result;
}
public function fetchNetSum_Etype( $from,$to,$company_id,$etype )
{
if ($etype=='purchase'){
$query = "select ifnull(purchase,0)+ifnull(yarnpurchase,0)+ifnull(fabricpurchase,0) as 'SALES_TOTAL'  from
		(select 
		(
		SELECT IFNULL(SUM(debit),0)-IFNULL(SUM(credit),0) AS 'purchaseS_TOTAL' FROM pledger where pid in (select purchase from setting_configuration) $company_id and date BETWEEN '".$from ."' AND '".$to ."'
		) as purchase
		,(
		SELECT IFNULL(SUM(debit),0)-IFNULL(SUM(credit),0) AS 'purchaseS_TOTAL' FROM pledger where pid in (select fabricpurchase from setting_configuration) $company_id and date BETWEEN '".$from ."' AND '".$to ."'
		) as fabricpurchase
		,(
		SELECT IFNULL(SUM(debit),0)-IFNULL(SUM(credit),0) AS 'purchaseS_TOTAL' FROM pledger where pid in (select yarnpurchase from setting_configuration) $company_id and date BETWEEN '".$from ."' AND '".$to ."'
		) as yarnpurchase
	) as purchase";
}else if($etype=='salereturn'){
$query = "SELECT IFNULL(SUM(debit),0)-IFNULL(SUM(credit),0) AS 'SALES_TOTAL'
	FROM pledger
	where pid = (select $etype from setting_configuration) $company_id and date BETWEEN '".$from ."' AND '".$to ."' ";
}else if($etype=='sale'){
$query = "select ifnull(sale,0)+ifnull(salegst,0)+ifnull(salewogst,0) as 'SALES_TOTAL'  from
	(select 
	(
	SELECT IFNULL(SUM(credit),0)-IFNULL(SUM(debit),0) AS 'SALES_TOTAL' FROM pledger where pid in (select sale from setting_configuration) $company_id and date BETWEEN '".$from ."' AND '".$to ."'
	) as sale
	,(
	SELECT IFNULL(SUM(credit),0)-IFNULL(SUM(debit),0) AS 'SALES_TOTAL' FROM pledger where pid in (select salewogst from setting_configuration) $company_id and date BETWEEN '".$from ."' AND '".$to ."'
	) as salewogst
	,(
	SELECT IFNULL(SUM(credit),0)-IFNULL(SUM(debit),0) AS 'SALES_TOTAL' FROM pledger where pid in (select salegst from setting_configuration) $company_id and date BETWEEN '".$from ."' AND '".$to ."'
	) as salegst
) as sale";
}else if($etype=='purchasereturn'){
$query = "SELECT IFNULL(SUM(credit),0)-IFNULL(SUM(debit),0) AS 'SALES_TOTAL'
	FROM pledger
	where pid = (select $etype from setting_configuration) $company_id and date BETWEEN '".$from ."' AND '".$to ."' ";
}
$result = $this->db->query($query);
return $result->result_array();
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
public function getsetting_configur()
{
$query = "SELECT * FROM setting_configuration";
$result = $this->db->query($query);
return $result->result_array();
}
public function getMaxChequeId( $etype,$company_id )
{
$this->db->select_max('dcno');
$query = $this->db->get_where('pd_cheque',array('etype'=>$etype,'company_id'=>$company_id));
$result = $query->row_array();
return $result['dcno'];
}
public function getDistinctFields($field) {
$result = $this->db->query("SELECT DISTINCT $field FROM `party`");
return $result->result_array();
}
public function save( $accountDetail ) {
$this->db->where(array(
'pid'=>$accountDetail['pid']
));
$result = $this->db->get('party');
$affect = 0;
$pid = "";
if ($result->num_rows() >0) {
$this->db->where(array(
'pid'=>$accountDetail['pid']
));
$result = $this->db->update('party',$accountDetail);
$affect = $this->db->affected_rows();
$pid = $accountDetail['pid'];
}else {
unset($accountDetail['pid']);
$result = $this->db->insert('party',$accountDetail);
$affect = $this->db->affected_rows();
$pid = $this->db->insert_id();
}
if ($affect === 0 &&$pid == "") {
return false;
}else {
return $pid;
}
}
public function fetchAccount($pid) {
$this->db->where(array(
'pid'=>$pid
));
$result = $this->db->get('party');
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function fetchAccountByName($name) {
$this->db->where(array(
'name'=>$name
));
$result = $this->db->get('party');
if ( $result->num_rows() >0 ) {
return $result->row_array();
}else {
return false;
}
}
public function fetchAll($activee=-1,$typee="all") {
$crit="";
if ($typee!="all"){
$crit =" and level3.name like '%$typee%' ";
}
if ($activee==-1){
$qry="SELECT `party`.pid, `party`.name, `party`.limit, `party`.account_id, `party`.mobile, `party`.address, `party`.level3, level3.name AS level3_name
			FROM `party`
			INNER JOIN `level3` ON `level3`.`l3` = `party`.`level3`
			WHERE party.name <>'' $crit ";
}else{
$qry = "SELECT `party`.pid, `party`.name, `party`.limit, `party`.account_id, `party`.mobile, `party`.address, `party`.level3, level3.name AS level3_name
			FROM `party`
			INNER JOIN `level3` ON `level3`.`l3` = `party`.`level3`
			WHERE `party`.`active`=$activee $crit";
}
$result = $this->db->query($qry);
return $result->result_array();
}
public function fetchCity()
{
$qry="SELECT distinct ifnull(party.city,'') as city
		FROM `party`
		WHERE party.active = 1 ";
$query= $this->db->query($qry);
$result = $query->result_array();
return $result;
}
public function fetchCityArea()
{
$qry="SELECT distinct ifnull(party.cityarea,'') as cityarea
		FROM `party`

		WHERE party.active = 1 ";
$query= $this->db->query($qry);
$result = $query->result_array();
return $result;
}
public function fetchAllLevel1() {
$result = $this->db->get('level1');
return $result->result_array();
}
public function fetchAllLevel2() {
$result = $this->db->query("SELECT l2.l2, l2.name AS level2_name, l1.name AS level1_name FROM level1 AS l1 INNER JOIN level2 AS l2 ON l2.l1 = l1.l1");
return $result->result_array();
}
public function fetchAllLevel3() {
$result = $this->db->query("SELECT l3.l3, l3.name AS level3_name, l2.name AS level2_name, l1.name AS level1_name FROM level3 AS l3 INNER JOIN level2 AS l2 ON l3.l2 = l2.l2 INNER JOIN level1 AS l1 ON l2.l1 = l1.l1");
return $result->result_array();
}
public function fetchTypeParty($etype) {
$result = $this->db->query('SELECT pid,name from party where etype = "'.$etype.'" ');
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function fetchAll_Users() {
$result = $this->db->query("select * from user");
return $result->result_array();
}
public function fetchAll_CashAccount() {
$result = $this->db->query("SELECT ifnull(bal.bal,0) as balance,`party`.pid, `party`.name, `party`.limit, `party`.account_id, `party`.mobile, `party`.address, `party`.level3, level3.name AS level3_name
			FROM `party`
			INNER JOIN `level3` ON `level3`.`l3` = `party`.`level3`
			left join(
			select ifnull(sum(debit),0)-ifnull(sum(credit),0) as bal,pid
			from pledger
			group by pid
			) as bal on bal.pid=party.pid
			WHERE `level3`.name LIKE '%CASH IN HAND%' OR `level3`.name LIKE '%CASH AT BANK%'");
return $result->result_array();
}
public function fetchAll_ExpAccount() {
$result = $this->db->query("SELECT `party`.pid, `party`.name, `party`.limit, `party`.account_id, `party`.mobile, `party`.address, `party`.level3, level3.name AS level3_name FROM `party` INNER JOIN `level3` ON `level3`.`l3` = `party`.`level3` WHERE `level3`.name like '%expense%' ");
return $result->result_array();
}
public function fetchAll_EmployeeAccount() {
$result = $this->db->query("SELECT `party`.pid, `party`.name, `party`.limit, `party`.account_id, `party`.mobile, `party`.address, `party`.level3, level3.name AS level3_name FROM `party` INNER JOIN `level3` ON `level3`.`l3` = `party`.`level3` WHERE `level3`.name like '%employee%' ");
return $result->result_array();
}
public function getAllParties($etype) {
if ($etype === '') {
$result = $this->db->query("SELECT `name`, `pid` FROM `party`");
return $result->result_array();
}else {
$this->db->where(array(
'etype'=>$etype
));
$result = $this->db->get('party');
return $result->result_array();
}
}
public function fetchBanks() {
$query = 'SELECT DISTINCT bank_name FROM pd_cheque ORDER BY bank_name';
$result = $this->db->query( $query );
return $result->result_array();
}
public function saveCheque( $data )
{
$this->db->where(array(
'dcno'=>$data['dcno'],
'etype'=>$data['etype']
));
$q = $this->db->get('pd_cheque');
if ( $q->num_rows() >0 ) {
$this->db->where(array(
'dcno'=>$data['dcno'],
'etype'=>$data['etype']
));
$this->db->update('pd_cheque',$data);
$rowCount = $this->db->affected_rows();
if ( $rowCount !== 0 ) {
return true;
}
else {
return false;
}
}
else {
$this->db->insert('pd_cheque',$data);
$rowCount = $this->db->affected_rows();
if ( $rowCount !== 0 ) {
return true;
}
else {
return false;
}
}
}
public function fetchCheques($etype,$date,$company_id)
{
$query = "SELECT pd_cheque.DCNO, pd_cheque.VRDATE, pd_cheque.CHEQUE_NO, pd_cheque.MATURE_DATE, party.NAME 'PARTY', pd_cheque.BANK_NAME 'BANK', pd_cheque.AMOUNT FROM pd_cheque INNER JOIN party on pd_cheque.party_id_cr = party.pid WHERE pd_cheque.etype='{$etype}' AND pd_cheque.vrdate <= '{$date}' AND pd_cheque.post='unpost' AND pd_cheque.company_id={$company_id} ORDER BY pd_cheque.DCNO, pd_cheque.VRDATE";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchChequeVoucher( $dcno,$etype,$company_id )
{
$query = $this->db->query("select pd_cheque.*, DATE(pd_cheque.cheque_date) as cheque_date, DATE(pd_cheque.vrdate) as vrdate, DATE(pd_cheque.mature_date) as mature_date,  p1.name as partyName, p2.name as partyName2, u.uname as user_name,c.company_name from pd_cheque INNER JOIN party as p1 ON pd_cheque.party_id = p1.pid INNER JOIN party as p2 ON pd_cheque.party_id_cr = p2.pid inner join user as u on pd_cheque.uid=u.uid inner join company c on c.company_id=pd_cheque.company_id where pd_cheque.etype='{$etype}' AND pd_cheque.company_id ={$company_id} AND pd_cheque.dcno={$dcno}");
return $query->result_array();
}
public function delete($pid)
{
$this->db->where(array('party_id'=>$pid));
$result = $this->db->get('stockmain');
if ($result->num_rows() >0) {
return 'used';
}
$this->db->where(array('pid'=>$pid));
$result = $this->db->get('pledger');
if ($result->num_rows() >0) {
return 'used';
}
$this->db->where(array('party_id'=>$pid));
$result = $this->db->get('ordermain');
if ($result->num_rows() >0) {
return 'used';
}
$this->db->where(array('pid'=>$pid));
$this->db->delete('party');
return true;
}
public function removeChequeVoucher( $dcno,$etype ,$company_id )
{
$this->db->where(array(
'etype'=>$etype,
'dcno'=>$dcno,
'company_id'=>$company_id
));
$this->db->delete('pd_cheque');
if ($this->db->affected_rows() >0) {
return true;
}else {
return false;
}
}
public function getAllCheques($startDate,$endDate,$etype)
{
$query = "SELECT pd_cheque.DCNO, pcr.name 'ACCOUNT', p.name 'PARTY_NAME', BANK_NAME, CHEQUE_NO, CHEQUE_DATE, AMOUNT, STATUS, POST, VRDATE FROM pd_cheque INNER JOIN party AS pcr ON pd_cheque.party_id_cr = pcr.pid LEFT JOIN party AS p ON pd_cheque.party_id = p.pid WHERE pd_cheque.etype='{$etype}' AND VRDATE BETWEEN '{$startDate}' AND '{$endDate}'";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchPartyOpeningBalance( $to,$party_id,$ptype )
{
$query = "SELECT IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) AS 'OPENING_BALANCE' FROM pledger WHERE pledger.pid={$party_id} AND date < '{$to}'";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchRunningTotal($endDate,$party_id,$ptype)
{
$query = "SELECT SUM(DEBIT) - SUM(CREDIT) 'RTotal' FROM pledger WHERE DATE(DATE) <= '$endDate' AND pid =$party_id";
$result = $this->db->query($query);
return $result->result_array();
}
function fetchTrialBalanceData($startDate,$endDate,$company_id,$l1 ,$l2 ,$l3) 
{
$query = $this->db->query("call Trial_Balance('$startDate', '$endDate', $company_id, $l1, $l2, $l3)");
return $query->result_array();
}
function fetchTrialBalanceData6($startDate,$endDate,$company_id ,$l1,$l2,$l3,$with_zero) 
{
$query = $this->db->query("call spw_trial_six('$startDate', '$endDate', $company_id,$l1,$l2,$l3, $with_zero)");
return $query->result_array();
}
function Account_Flow($startDate,$endDate,$party_id ,$company_id) 
{
$query = $this->db->query("call spw_account_flow('$startDate', '$endDate', $party_id, $company_id)");
return $query->result_array();
}
public function getChartOfAccounts($crit,$groupby)
{
$qry = "SELECT $groupby AS VOUCHER ,party.ACCOUNT_ID, party.name AS 'PARTY_NAME', party.level3, level1.l1, level1.name AS 'L1NAME', level2.l2, level2.name AS 'L2NAME', level3.l3, level3.name AS 'L3NAME',party.ACTIVE,party.PID,party.MOBILE,party.CITY,party.CITYAREA,round(IFNULL(party.LIMIT,0),0) `LIMIT`
		FROM party party
		INNER JOIN level3 level3 ON party.level3 = level3.l3
		INNER JOIN level2 level2 ON level3.l2 = level2.l2
		INNER JOIN level1 level1 ON level1.l1 = level2.l1

		LEFT JOIN  user ON user.uid = party.uid

		where 1=1 $crit
		ORDER BY $groupby";
$query = $this->db->query($qry);
return $query->result_array();
}
public function fetchDayBookReportData ($startDate,$endDate,$what,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name)
{
$ord='';
if ($what == 'date') {
$ord="DATE_FORMAT(pledger.date , '%d %b %y')";
}else if ($what == 'invoice') {
$ord='pledger.etype';
}else if ($what == 'wo') {
$ord='pledger.wo';
}else if ($what == 'party') {
$ord='party.name';
}else if ($what == 'user') {
$ord='user.uname';
}else if ($what == 'month') {
$ord='month(pledger.date)';
}else if ( $what == 'weekday') {
$ord='dayname(pledger.date)';
}else if ( $what == 'year') {
$ord='year(pledger.date)';
}
$query = "SELECT $ord AS group_sort, DAYNAME(pledger.date) AS weekdate, MONTH(pledger.date) AS monthdate, YEAR(pledger.date) AS yeardate,pledger.ETYPE, pledger.DCNO AS VRNOA,party.NAME AS PARTY,pledger.DEBIT AS DEBIT,pledger.credit AS 'CREDIT',pledger.DESCRIPTION AS REMARKS, DATE_FORMAT(pledger.date, '%d %b %y') AS 'DATE', user.uname, company.company_name,ifnull(pledger.wo,'')wo,ifnull(pledger.invoice,'')invoice
		,ifnull(party2.NAME,'') AS PARTY2
		FROM pledger pledger
		INNER JOIN party party ON pledger.pid = party.pid
		INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
		INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
		INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
		INNER JOIN user AS user ON user.uid=pledger.uid
		left JOIN party party2 ON pledger.pid_key = party2.pid

		INNER JOIN company ON company.company_id=pledger.company_id $crit
		WHERE pledger.etype not in('consumption','production') and pledger.date BETWEEN '$startDate' AND '$endDate' AND pledger.company_id=$company_id
		ORDER BY $ord,pledger.date,pledger.etype,pledger.dcno";
$result = $this->db->query($query);
return $result->result_array();
}
public function getChequeReportData ($startDate,$endDate,$etype,$company_id,$crit,$what)
{
$ord='';
if ($what == 'date') {
$ord="DATE_FORMAT(pd_cheque.vrdate , '%d/%m/%y')";
}else if ($what == 'invoice') {
$ord='pd_cheque.etype';
}else if ($what == 'wo') {
$ord='pd_cheque.wo';
}else if ($what == 'bank') {
$ord='party2.name';
}else if ($what == 'postinledger') {
$ord='pd_cheque.statu';
}else if ($what == 'party') {
$ord='party.name';
}else if ($what == 'user') {
$ord='user.uname';
}else if ($what == 'month') {
$ord='month(pd_cheque.date)';
}else if ( $what == 'weekday') {
$ord='dayname(pd_cheque.date)';
}else if ( $what == 'year') {
$ord='year(pd_cheque.date)';
}
$query = "SELECT $ord as group_sort,pd_cheque.SLIP_NO,pd_cheque.WO, pd_cheque.DCNO, party.name 'ACCOUNT', party2.name 'PARTY_NAME', BANK_NAME, pd_cheque.CHEQUE_NO, date_format(pd_cheque.CHEQUE_DATE, '%d/%m/%y')CHEQUE_DATE, pd_cheque.AMOUNT, pd_cheque.STATUS,pd_cheque.POST,date_format(pd_cheque.VRDATE, '%d/%m/%y') VRDATE,ifnull(pd_cheque.tax,0) TAX
		from pd_cheque 
		inner join party ON party.pid =pd_cheque.party_id
		INNER JOIN party as party2 ON party2.pid=pd_cheque.party_id_cr
		where pd_cheque.etype='{$etype}' AND pd_cheque.company_id=$company_id $crit
		ORDER BY vrdate";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchPayRecvReportData($startDate,$endDate,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name)
{
if ($etype === 'payable') {
$query = "SELECT dayname(pledger.date) as weekdate, month(pledger.date) as monthdate,year(pledger.date) as yeardate,IFNULL(SUM(pledger.DEBIT),0)- IFNULL(SUM(pledger.CREDIT),0) 'BALANCE', party.NAME 'ACCOUNT_NAME', party.MOBILE, party.PHONE AS PHONE_OFF, party.ADDRESS, party.EMAIL 
			FROM pledger pledger 
			INNER JOIN party party ON pledger.pid = party.pid 
			INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 
			INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 
			INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 
			WHERE pledger.DATE BETWEEN '$startDate' AND '$endDate' AND leveltbl3.name LIKE '%CREDITORS%' AND pledger.company_id=$company_id $crit GROUP BY party.NAME HAVING IFNULL(SUM(pledger.DEBIT),0)- IFNULL(SUM(pledger.CREDIT),0)<>0";
}else if ( $etype === 'receiveable') {
$query = "SELECT dayname(pledger.date) as weekdate, month(pledger.date) as monthdate,year(pledger.date) as yeardate,IFNULL(SUM(pledger.DEBIT),0)- IFNULL(SUM(pledger.CREDIT),0) 'BALANCE', party.NAME 'ACCOUNT_NAME', party.MOBILE, party.PHONE AS PHONE_OFF, party.ADDRESS, party.EMAIL FROM pledger pledger INNER JOIN party party ON pledger.pid = party.pid INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 WHERE pledger.DATE BETWEEN '$startDate' AND '$endDate' AND ( leveltbl3.name LIKE '%DEBTORS%' or leveltbl3.name like '%DEBITORS%') AND pledger.company_id=$company_id $crit GROUP BY  party.NAME HAVING IFNULL(SUM(pledger.DEBIT),0)-IFNULL(SUM(pledger.CREDIT),0)<>0";
}
$query = $this->db->query($query);
return $query->result_array();
}
public function fetchClosingBalance( $to )
{
$query = "SELECT IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT), 0) as 'CLOSING_BALANCE' FROM pledger pledger WHERE pledger.pid=(SELECT setting_configuration.cash FROM setting_configuration) AND date <= '{$to}'";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchOpeningBalance( $to )
{
$query = "SELECT IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT),0) as 'OPENING_BALANCE' FROM pledger pledger WHERE pledger.pid=(SELECT setting_configuration.cash FROM setting_configuration) AND date < '{$to}'";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchOpeningBalance_Accounts( $from,$pid,$company_id )
{
$query = "SELECT IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT),0) as 'OPENING_BALANCE' FROM pledger pledger WHERE pledger.pid=$pid AND date < '{$from}' ";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchExpenseReportData ($startDate,$endDate,$what,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name)
{
$ord='';
if ($what == 'date') {
$ord="DATE_FORMAT(pledger.date , '%d %b %y')";
}else if ($what == 'invoice') {
$ord='pledger.dcno';
}else if ($what == 'wo') {
$ord='pledger.wo';
}else if ($what == 'party') {
$ord='party.name';
}else if ($what == 'user') {
$ord='user.uname';
}else if ($what == 'month') {
$ord='month(pledger.date)';
}else if ( $what == 'weekday') {
$ord='dayname(pledger.date)';
}else if ( $what == 'year') {
$ord='year(pledger.date)';
}
$query = "SELECT $ord as group_sort,dayname(pledger.date) as weekdate, month(pledger.date) as monthdate,year(pledger.date) as yeardate,pledger.ETYPE, pledger.DCNO AS VRNOA,party.NAME AS PARTY,pledger.DEBIT as DEBIT ,pledger.credit  as 'CREDIT' ,pledger.DESCRIPTION AS REMARKS, pledger.DATE, user.uname, company.company_name  
		FROM pledger pledger 
		INNER JOIN party party ON pledger.pid = party.pid 
		INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 
		INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 
		INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 
		INNER JOIN user as user on user.uid=pledger.uid 
		INNER JOIN company on company.company_id=pledger.company_id   
		WHERE  leveltbl1.bslevel IN ('expense', 'expenses') AND party.name NOT IN ('sale return', 'purchase', 'purchase import') AND pledger.date BETWEEN '$startDate' AND '$endDate'  and pledger.company_id=$company_id  $crit
		ORDER BY  $ord  ,pledger.date";
$result = $this->db->query($query);
return $result->result_array();
}
public function fetchInvoiceAgingData( $from,$to,$reptType,$party_id,$company_id,$crit)
{
if ($party_id!==""){
$party_id=" and a.pid=".$party_id ."";
}
$company_id= (string)$company_id;
$acompany_id="";
$acompany_id= (string)$company_id;
if($company_id!==""){
$company_id = " and b.company_id= ".$company_id ;
$acompany_id = " and a.company_id= ".$acompany_id;
}
$query = "";
if ( $reptType === 'payables') {
$query = "SELECT *, invoice_amount-paid AS balance, aging.address, aging.email, aging.mobile, CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') <= 30 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS '0_30', CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') BETWEEN 31 AND 60 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS '31_60', CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') BETWEEN 61 AND 90 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS '61_90', CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') BETWEEN 91 AND 120 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS '91_120', CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') >120 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS 'abov_120' FROM (SELECT  concat( a.dcno ,'-',a.etype)as dcno,a.date as vrdate, a.dcno dcno1, DATE_FORMAT(a.date,'%d/%m/%y') date, party.address, party.email, party.mobile, party.name AS account, DATE_FORMAT(IFNULL(a.date, '-'),'%d/%m/%y') AS due_date, IFNULL(DATEDIFF(CURDATE(),a.date), '-') AS days_passed, round(SUM(a.credit),0) invoice_amount,(SELECT IFNULL(SUM(b.debit),0) 
			FROM pledger b 
			WHERE b.invoice = a.dcno AND b.pid =a.pid AND b.date BETWEEN '$from' AND '$to'   $company_id ) paid ,ifnull(a.wo,'')wo,ifnull(a.pid,0)pid
			FROM pledger a 
			INNER JOIN party ON a.pid = party.pid 
			WHERE a.etype in ('purchase','fabricPurchase','yarnPurchase') and a.credit<>0 AND a.date BETWEEN '$from' AND '$to'  $acompany_id $party_id $crit GROUP BY a.etype,a.dcno,a.date ORDER BY a.etype,a.dcno
		) AS aging";
}else if ( $reptType === 'receiveables') {
$query = "SELECT *, invoice_amount-paid AS balance, aging.address, aging.email, aging.mobile, CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') <= 30 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS '0_30', CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') BETWEEN 31 AND 60 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS '31_60', CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') BETWEEN 61 AND 90 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS '61_90', CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') BETWEEN 91 AND 120 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS '91_120', CASE WHEN IFNULL(DATEDIFF(CURDATE(),vrdate), '-') >120 THEN ROUND(ifnull(invoice_amount,0)-ifnull(paid,0),0) ELSE  0 END AS 'abov_120' FROM (SELECT a.dcno, a.dcno dcno1,a.date as vrdate, DATE_FORMAT(a.date,'%d/%m/%y') date, party.address, party.email, party.mobile, party.name AS account, DATE_FORMAT(IFNULL(a.date, '-'),'%d/%m/%y') AS due_date, IFNULL(DATEDIFF(CURDATE(),a.date), '-') AS days_passed, round(SUM(a.debit),0) invoice_amount, (SELECT IFNULL(SUM(b.credit),0) 
			FROM pledger b 
			WHERE b.invoice = a.dcno AND b.pid =a.pid AND a.date BETWEEN '$from' AND '$to'   $company_id) paid ,ifnull(a.wo,'')wo,ifnull(a.pid,0)pid
			FROM pledger a 
			INNER JOIN party ON a.pid = party.pid 
			WHERE a.etype='SALE' and a.debit<>0 AND a.date BETWEEN '$from' AND '$to'  $acompany_id $party_id $crit GROUP BY a.dcno,a.date ORDER BY a.dcno
		) AS aging";
}
$result = $this->db->query( $query );
if ( $result->num_rows() >0 ) {
return $result->result_array();
}else {
return false;
}
}
public function fetchPayRecvCount( $startDate,$endDate,$company_id,$etype)
{
if ($etype == 'payable') {
$query = "SELECT COUNT(*) as NET_COUNT FROM (SELECT a.dcno, a.date, party.name as account, IFNULL(a.date, '-') as due_date, IFNULL(DATEDIFF(a.date, CURDATE()), '-') as days_passed, sum(a.credit) invoice_amount, (SELECT IFNULL(SUM(b.debit),0) FROM pledger  b WHERE b.invoice = a.dcno and b.pid =a.pid and a.date = CURDATE() AND b.etype='CPV' AND b.company_id = $company_id ) paid FROM pledger  a INNER JOIN party ON a.pid = party.pid WHERE a.etype='PURCHASE' AND a.date = CURDATE() AND a.company_id = $company_id GROUP BY a.dcno,a.date ORDER BY a.dcno ) as aging";
$query = $this->db->query($query);
$result = $query->row_array();
return $result['NET_COUNT'];
}else if ( $etype === 'receiveable') {
$query = "SELECT COUNT(*) as NET_COUNT FROM (SELECT a.dcno, a.date, party.name as account, IFNULL(a.date, '-') as due_date, IFNULL(DATEDIFF(a.date, CURDATE()), '-') as days_passed, sum(a.debit) invoice_amount, (SELECT IFNULL(SUM(b.credit),0) FROM pledger  b WHERE b.invoice = a.dcno and b.pid =a.pid and a.date = CURDATE() AND b.etype='CPV' AND b.company_id = $company_id ) paid FROM pledger  a INNER JOIN party ON a.pid = party.pid WHERE a.etype='SALE' AND a.date = CURDATE() AND a.company_id = $company_id GROUP BY a.dcno,a.date ORDER BY a.dcno ) as aging";
$query = $this->db->query($query);
$result = $query->row_array();
return $result['NET_COUNT'];
}
}

public function save_dyeing($id,$name,$code,$rate,$unit)
{
	$result = $this->db->query("insert into dyeing (id,name,code,rate,unit) values ('$id','$name','$code','$rate','$unit') ");
	return true;
}

public function save_thread($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("insert into thread (id,name,code,unit,rate,qty,per_unit_rate) values ('$id','$name','$code','$unit','$rate','$qty','$per_unit_rate') ");
	return true;
}

public function save_emb($id,$name,$cost,$unit)
{
	$result = $this->db->query("insert into add_embroidory (id,name,cost,unit) values ('$id','$name','$cost','$unit') ");
	return true;
}

public function save_fabric($id,$name,$code,$unit,$rate,$per_unit_rate,$qty,$dye_unit,$dye_rate)
{
	$result = $this->db->query("insert into fabric (id,name,code,unit,rate,qty,per_unit_rate,dye_unit,dye_rate) values ('$id','$name','$code','$unit','$rate','$qty','$per_unit_rate','$dye_unit','$dye_rate') ");
	return true;
}

public function save_cutting($id,$type,$name,$part,$rate)
{
	$result = $this->db->query("insert into add_cutting (id,type,name,part,rate) values ('$id','$type','$name','$part','$rate') ");
	return true;
}

public function save_employee($id,$name,$type,$dept)
{
	$result = $this->db->query("insert into add_employee (id,name,type,location) values ('$id','$name','$type','$dept') ");
	return true;
}


public function save_accessories($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("insert into accessories (id,name,code,unit,rate,qty,per_unit_rate) values ('$id','$name','$code','$unit','$rate','$qty','$per_unit_rate') ");
	return true;
}

public function save_document($id,$name,$date,$company,$amount,$by,$status)
{
	$result = $this->db->query("insert into document (id,name,date,company,amount,sender,status) values ('$id','$name','$date','$company','$amount','$by','$status') ");
	return true;
}

public function save_addawork($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("insert into adda_work (id,name,code,unit,rate,qty,per_unit_rate) values ('$id','$name','$code','$unit','$rate','$qty','$per_unit_rate') ");
	return true;
}

public function save_stonework($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("insert into stone_work (id,name,code,unit,rate,qty,per_unit_rate) values ('$id','$name','$code','$unit','$rate','$qty','$per_unit_rate') ");
	return true;
}

public function save_color($id,$name)
{
	$result = $this->db->query("insert into sample_color (id,name) values ('$id','$name') ");
	return true;
}

public function save_article($id,$name)
{
	$result = $this->db->query("insert into sample_article (id,name) values ('$id','$name') ");
	return true;
}

public function save_category($id,$name)
{
	$result = $this->db->query("insert into sample_category (id,name) values ('$id','$name') ");
	return true;
}

public function save_embt($id,$name,$code)
{
	$result = $this->db->query("insert into add_embellishment (id,name,code) values ('$id','$name','$code') ");
	return true;
}

public function save_pack($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("insert into add_pack (id,name,code,unit,rate,qty,per_unit_rate) values ('$id','$name','$code','$unit','$rate','$qty','$per_unit_rate') ");
	return true;
}
public function update_dyeing($id,$name,$code,$rate,$unit)
{
	$result = $this->db->query("update dyeing set name ='$name' ,code ='$code' ,rate ='$rate',unit='$unit' where id ='$id' ");
	return true;
}


public function update_thread($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("update thread set unit ='$unit',rate ='$rate' , qty='$qty', per_unit_rate ='$per_unit_rate' where id ='$id' ");
	$result = $this->db->query("update item set cost_price ='$rate',unit ='$unit', per_unit_rate ='$per_unit_rate',unit_qty='$qty' where item_barcode ='$code' ");
	return true;
}

public function update_emb($id,$name,$cost,$unit)
{
	$result = $this->db->query("update add_embroidory set name ='$name' ,cost ='$cost' ,unit ='$unit' where id ='$id' ");
	return true;
}

public function update_fabric($id,$name,$code,$unit,$rate,$per_unit_rate,$qty,$dye_unit,$dye_rate)
{
	$result = $this->db->query("update fabric set unit ='$unit',rate ='$rate' , qty='$qty', per_unit_rate ='$per_unit_rate',dye_unit ='$dye_unit',unit ='$unit',dye_rate ='$dye_rate' where id ='$id' ");
	$result = $this->db->query("update item set cost_price ='$rate',unit ='$unit', per_unit_rate ='$per_unit_rate', per_unit_rate ='$per_unit_rate',unit_qty='$qty' where item_barcode ='$code' ");
	return true;
}

public function update_cutting($id,$type,$name,$part,$rate)
{
	$result = $this->db->query("update add_cutting set name ='$name',type='$type' ,part ='$part',rate='$rate'  where id ='$id' ");
	return true;
}

public function update_employee($id,$name,$type,$dept)
{
	$result = $this->db->query("update add_employee set name ='$name' ,type ='$type' ,location = '$dept' where id ='$id' ");
	return true;
}

public function update_accessories($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("update accessories set unit ='$unit',rate ='$rate' , qty='$qty', per_unit_rate ='$per_unit_rate',unit ='$unit' where id ='$id' ");
	$result = $this->db->query("update item set cost_price ='$rate',unit ='$unit', per_unit_rate ='$per_unit_rate',unit_qty='$qty' where item_barcode ='$code' ");
	return true;
}

public function update_document($id,$name,$date,$company,$amount,$by,$status)
{
	$result = $this->db->query("update document set name='$name' amount ='$amount' , company='$company', sender ='$by' where id ='$id' ");
	return true;
}


public function update_stonework($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("update stone_work set rate ='$rate' , qty='$qty', per_unit_rate ='$per_unit_rate' where id ='$id' ");
	return true;
}


public function update_addawork($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("update adda_work set unit ='$unit',rate ='$rate' , qty='$qty', per_unit_rate ='$per_unit_rate' where id ='$id' ");
	$result = $this->db->query("update item set cost_price ='$rate',unit ='$unit', per_unit_rate ='$per_unit_rate',unit_qty='$qty' where item_barcode ='$code' ");
	return true;
}

public function update_color($id,$name)
{
	$result = $this->db->query("update sample_color set name ='$name' where id ='$id' ");
	return true;
}

public function update_article($id,$name)
{
	$result = $this->db->query("update sample_article set name ='$name'  where id ='$id' ");
	return true;
}

public function update_category($id,$name)
{
	$result = $this->db->query("update sample_category set name ='$name'  where id ='$id' ");
	return true;
}

public function update_embt($id,$name,$code)
{
	$result = $this->db->query("update add_embellishment set name ='$name' ,code ='$code'  where id ='$id' ");
	return true;
}

public function update_pack($id,$name,$code,$unit,$rate,$per_unit_rate,$qty)
{
	$result = $this->db->query("update add_pack set unit ='$unit',rate ='$rate' , qty='$qty', per_unit_rate ='$per_unit_rate' where id ='$id' ");
	$result = $this->db->query("update item set cost_price ='$rate', per_unit_rate ='$per_unit_rate',unit_qty='$qty' where item_barcode ='$code' ");
	return true;
}

public function deletecut($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('add_cutting');
return true;
}

public function delete_employee($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('add_employee');
return true;
}


public function deletedye($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('dyeing');
return true;
}

public function deleteemb($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('add_embroidory');
return true;
}

public function deletefabric($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('fabric');
return true;
}

public function deletethd($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('thread');
return true;
}

public function deleteemblish($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('add_embellishment');
return true;
}


public function deletepack($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('add_pack');
return true;
}



public function delete_category($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('sample_category');
return true;
}

public function delete_article($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('sample_article');
return true;
}

public function delete_accessories($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('accessories');
return true;
}

public function delete_document($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('document');
return true;
}


public function delete_stonework($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('stone_work');
return true;
}

public function delete_addawork($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('adda_work');
return true;
}


public function delete_color($id)
{
$this->db->where(array('id'=>$id));
$this->db->delete('sample_color');
return true;
}


public function getMaxIddye() {
	$this->db->select_max('id');
	$result = $this->db->get('dyeing');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}

public function getMaxIdaccessories() {
	$this->db->select_max('id');
	$result = $this->db->get('accessories');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
}

public function getMaxIddocument() {
	$this->db->select_max('id');
	$result = $this->db->get('document');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
}

public function getMaxIdstonework() {
	$this->db->select_max('id');
	$result = $this->db->get('stone_work');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
}

public function getMaxIdaddawork() {
	$this->db->select_max('id');
	$result = $this->db->get('adda_work');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
}

public function getMaxIdcut() {
	$this->db->select_max('id');
	$result = $this->db->get('add_cutting');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}

	public function getMaxIdemployee() {
	$this->db->select_max('id');
	$result = $this->db->get('add_employee');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}


public function getMaxIdthd() {
	$this->db->select_max('id');
	$result = $this->db->get('thread');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}


public function getMaxIdemb() {
	$this->db->select_max('id');
	$result = $this->db->get('add_embroidory');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}

public function getMaxIdpack() {
	$this->db->select_max('id');
	$result = $this->db->get('add_pack');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}

public function getMaxIdemblish() {
	$this->db->select_max('id');
	$result = $this->db->get('add_embellishment');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}

public function getMaxIdemp() {
	$this->db->select_max('id');
	$result = $this->db->get('employee');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}

public function getMaxIdfabric() {
	$this->db->select_max('id');
	$result = $this->db->get('fabric');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}

public function getMaxId_color() {
	$this->db->select_max('id');
	$result = $this->db->get('sample_color');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}

public function getMaxId_category() {
	$this->db->select_max('id');
	$result = $this->db->get('sample_category');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}

public function getMaxId_article() {
	$this->db->select_max('id');
	$result = $this->db->get('sample_article');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
	}


	public function fetch_cut($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('add_cutting');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}


	public function fetch_pack($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('add_pack');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}

	public function fetch_employee($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('add_employee');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}


	public function fetch_sample($id) {
		$this->db->where(array(
		'id'=>$id));
		$result = $this->db->get('sample_card');
		if ( $result->num_rows() >0 ) {
		return $result->result_array();
		}else {
		return false;
		}
		}


	public function fetch_category($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('sample_category');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}

	public function fetch_color($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('sample_color');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}


	public function fetch_article($id) {
		$this->db->where(array(
		'id'=>$id));
		$result = $this->db->get('sample_article');
		if ( $result->num_rows() >0 ) {
		return $result->result_array();
		}else {
		return false;
		}
		}

	public function fetch_accessories($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('accessories');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}

public function fetch_document($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('document');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}

	public function fetch_stonework($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('stone_work');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}

	public function fetch_addawork($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('adda_work');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}

	public function fetch_ebh($id) {
		$this->db->where(array(
		'id'=>$id));
		$result = $this->db->get('add_embellishment');
		if ( $result->num_rows() >0 ) {
		return $result->result_array();
		}else {
		return false;
		}
		}
	
	
	public function fetch_emb($id) {
		$this->db->where(array(
		'id'=>$id));
		$result = $this->db->get('add_embroidory');
		if ( $result->num_rows() >0 ) {
		return $result->result_array();
		}else {
		return false;
		}
		}
	
	
	public function fetch_dye($id) {
		$this->db->where(array(
		'id'=>$id));
		$result = $this->db->get('dyeing');
		if ( $result->num_rows() >0 ) {
		return $result->result_array();
		}else {
		return false;
		}
		}
	
	
	public function fetch_thd($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('thread');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}

	public function fetch_fabric($id) {
	$this->db->where(array(
	'id'=>$id));
	$result = $this->db->get('fabric');
	if ( $result->num_rows() >0 ) {
	return $result->result_array();
	}else {
	return false;
	}
	}

	public function cuttings()
	{
		$result = $this->db->query("select * from add_cutting");
		return $result->result_array();
	}

	public function packings()
	{
		$result = $this->db->query("select * from add_pack");
		return $result->result_array();
	}

	public function employee()
	{
		$result = $this->db->query("select * from add_employee");
		return $result->result_array();
	}

	public function dye_name()
	{
		$result = $this->db->query("select * from add_employee where type='Dying'");
		return $result->result_array();
	}


	public function pack_name()
	{
		$result = $this->db->query("select * from add_employee where type='Cutting_&_Stitching'");
		return $result->result_array();
	}

	public function emb_name()
	{
		$result = $this->db->query("select * from add_employee where type='Embroidory'");
		return $result->result_array();
	}

	public function adda_name()
	{
		$result = $this->db->query("select * from adda_work where id>0");
		return $result->result_array();
	}

	public function stone_name()
	{
		$result = $this->db->query("select * from stone_work where id>0");
		return $result->result_array();
	}



	public function cut_name()
	{
		$result = $this->db->query("select distinct name from add_cutting where id>0 ");
		return $result->result_array();
	}

	public function cut_detail()
	{
		$result = $this->db->query("select * from add_cutting where id>0 ");
		return $result->result_array();
	}

	public function dig_name()
	{
		$result = $this->db->query("select * from add_employee where type='Digital_printing'");
		return $result->result_array();
	}


	public function embell_name()
	{
		$result = $this->db->query("select distinct name from add_employee where type='Adda_work/stone_work' ");
		return $result->result_array();
	}


	public function accessories()
	{
		$result = $this->db->query("select * from accessories");
		return $result->result_array();
	}

	public function document()
	{
		$result = $this->db->query("select * from document ");
		return $result->result_array();
	}

	public function stone_work()
	{
		$result = $this->db->query("select * from stone_work");
		return $result->result_array();
	}

	public function adda_work()
	{
		$result = $this->db->query("select * from adda_work");
		return $result->result_array();
	}

	public function categorys()
	{
		$result = $this->db->query("select * from sample_category");
		return $result->result_array();
	}

	public function colors()
	{
		$result = $this->db->query("select * from sample_color");
		return $result->result_array();
	}

	public function articles()
	{
		$result = $this->db->query("select * from sample_article");
		return $result->result_array();
	}

	
	public function threads()
	{
		$result = $this->db->query("select * from thread");
		return $result->result_array();
	}

	
	public function dyeings()
	{
		$result = $this->db->query("select * from dyeing");
		return $result->result_array();
	}

	
	public function embroidrys()
	{
		$result = $this->db->query("select * from add_embroidory");
		return $result->result_array();
	}

	public function fabrics()
	{
		$result = $this->db->query("select * from fabric");
		return $result->result_array();
	}

	
	public function embellishments()
	{
		$result = $this->db->query("select * from add_embellishment");
		return $result->result_array();
	}


}