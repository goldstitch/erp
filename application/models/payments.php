<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Payments extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function fetchCashandBank($from, $to) {
        $query = "SELECT p.NAME AS account_name, IFNULL(op.balance, 0) opening, IFNULL(cl.balance,0) AS balance, IFNULL(dp.debit, 0) debit, IFNULL(dp.credit,0) AS credit
		FROM party p
		LEFT JOIN(
		SELECT pid, IFNULL(SUM(DEBIT), 0)debit, IFNULL(SUM(CREDIT),0) credit, IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) balance
		FROM pledger
		where  date < '{$from}'
		GROUP BY pid
		) AS op ON op.pid=p.pid

		LEFT JOIN(
		SELECT pid, IFNULL(SUM(DEBIT), 0)debit, IFNULL(SUM(CREDIT),0) credit, IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) balance
		FROM pledger
		where  date BETWEEN '{$from}' AND '{$to}'
		GROUP BY pid
		) AS dp ON dp.pid=p.pid

		LEFT JOIN(
		SELECT pid, IFNULL(SUM(DEBIT), 0)debit, IFNULL(SUM(CREDIT),0) credit, IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) balance
		FROM pledger
		where  date <= '{$to}'
		GROUP BY pid
		) AS cl ON cl.pid=p.pid

		WHERE p.LEVEL3 IN (
		SELECT setting_configuration.cash_banks
		FROM setting_configuration) and  abs(IFNULL(op.balance, 0))+ abs(IFNULL(cl.balance,0))+ abs(IFNULL(dp.debit, 0))+abs(IFNULL(dp.credit,0)) <>0 ";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchAdvanceReport($from, $to, $did, $pid) {
        $query = "SELECT round(SUM(debit)) AS 'advance', s.name, d.name AS 'dept_name', DATE(p.date) AS date, p.dcno, p.description FROM pledger AS p INNER JOIN staff AS s ON p.pid = s.pid INNER JOIN department AS d ON s.did = d.did WHERE etype = 'advance' AND p.date >= '" . $from . "' AND p.date <= '" . $to . "'";
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
    public function fetchChartData($period, $type, $company_id) {
        $query = '';
        if (strtolower($period) === 'daily') {
            if ($type === 'cpv') {
                $query = "SELECT party.NAME 'ACCOUNT', pledger.DCNO as 'VRNOA', IFNULL(pledger.DEBIT,0) AS NAMOUNT FROM pledger INNER JOIN party ON pledger.pid = party.pid WHERE pledger.etype='cpv' AND party.NAME <> 'CASH' AND pledger.date = CURDATE() AND pledger.company_id={$company_id}";
            } else if ($type === 'crv') {
                $query = "SELECT party.NAME 'ACCOUNT', pledger.DCNO as 'VRNOA', IFNULL(pledger.CREDIT,0) AS NAMOUNT FROM pledger INNER JOIN party ON pledger.pid = party.pid WHERE pledger.etype='crv' AND party.NAME <> 'CASH' AND pledger.date = CURDATE() AND pledger.company_id={$company_id}";
            }
        } else if (strtolower($period) === 'weekly') {
            $query = "SELECT sum(case when date_format(pledger.date, '%W') = 'Monday' then pledger.CREDIT else 0 end) as 'Monday', sum(case when date_format(pledger.date, '%W') = 'Tuesday' then pledger.CREDIT else 0 end) as 'Tuesday', sum(case when date_format(pledger.date, '%W') = 'Wednesday' then pledger.CREDIT else 0 end) as 'Wednesday', sum(case when date_format(pledger.date, '%W') = 'Thursday' then pledger.CREDIT else 0 end) as 'Thursday', sum(case when date_format(pledger.date, '%W') = 'Friday' then pledger.CREDIT else 0 end) as 'Friday', sum(case when date_format(pledger.date, '%W') = 'Saturday' then pledger.CREDIT else 0 end) as 'Saturday', sum(case when date_format(pledger.date, '%W') = 'Sunday' then pledger.CREDIT else 0 end) as 'Sunday' from pledger INNER JOIN party ON pledger.pid = party.pid where pledger.etype = '$type' and pledger.date between DATE_SUB(pledger.date, INTERVAL 7 DAY) and CURDATE() and pledger.company_id=$company_id group by WEEK(pledger.date) order by WEEK(pledger.date) desc LIMIT 1";
        } else if (strtolower($period) === 'monthly') {
            $query = "SELECT sum(case when date_format(pledger.date, '%W') = 'Monday' then pledger.CREDIT else 0 end) as 'Monday', sum(case when date_format(pledger.date, '%W') = 'Tuesday' then pledger.CREDIT else 0 end) as 'Tuesday', sum(case when date_format(pledger.date, '%W') = 'Wednesday' then pledger.CREDIT else 0 end) as 'Wednesday', sum(case when date_format(pledger.date, '%W') = 'Thursday' then pledger.CREDIT else 0 end) as 'Thursday', sum(case when date_format(pledger.date, '%W') = 'Friday' then pledger.CREDIT else 0 end) as 'Friday', sum(case when date_format(pledger.date, '%W') = 'Saturday' then pledger.CREDIT else 0 end) as 'Saturday', sum(case when date_format(pledger.date, '%W') = 'Sunday' then pledger.CREDIT else 0 end) as 'Sunday'from pledger INNER JOIN party ON pledger.pid = party.pid where pledger.etype = '$type' and MONTH(pledger.date) = MONTH(CURDATE()) and pledger.company_id=$company_id group by WEEK(pledger.date) order by WEEK(pledger.date) desc LIMIT 4";
        } else if (strtolower($period) === 'yearly') {
            $query = "SELECT YEAR(pledger.date) as 'Year', MONTHNAME(STR_TO_DATE(MONTH(pledger.date), '%m')) as Month, sum(pledger.CREDIT) AS TotalAmount FROM pledger INNER JOIN party ON pledger.pid = party.pid where pledger.etype = '$type' and YEAR(pledger.date) = YEAR(CURDATE()) and pledger.company_id = $company_id GROUP BY YEAR(pledger.date), MONTH(pledger.date) ORDER BY YEAR(pledger.date), MONTH(pledger.date)";
        }
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchIncentiveReport($from, $to, $pid, $did) {
        $query = "SELECT round(SUM(credit)) AS 'incentive', s.name, d.name AS 'dept_name', DATE(p.date) AS date, p.dcno, p.description FROM pledger AS p INNER JOIN staff AS s ON p.pid = s.pid INNER JOIN department AS d ON s.did = d.did WHERE etype = 'incentive' AND p.date >= '" . $from . "' AND p.date <= '" . $to . "'";
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
    public function fetchEobiReport($from, $to, $did, $staid) {
        $query = "SELECT stf.staid, stf.name, stf.fname, sal.designation, d.name as 'dept_name', ss.date, round(ss.gross_salary) as gross_salary, round(ss.net_salary) as net_salary, round(ss.eobi) as eobi FROM salarysheet AS ss INNER JOIN staff AS stf ON stf.staid = ss.staid INNER JOIN salary AS sal ON stf.staid = sal.staid INNER JOIN department AS d ON ss.did = d.did";
        if ($did != "-1") {
            $query.= " Where ss.did = $did";
        }
        if ($staid != "-1") {
            $query.= " AND ss.staid = $staid";
        }
        $query.= " ORDER BY ss.staid, d.did";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchSocialSecReport($from, $to, $did, $staid) {
        $query = "SELECT stf.staid, stf.name, stf.fname, sal.designation, d.name as 'dept_name', ss.date, round(ss.gross_salary) as gross_salary, round(ss.net_salary) as net_salary, round(ss.socialsec) as socialsec FROM salarysheet AS ss INNER JOIN staff AS stf ON stf.staid = ss.staid INNER JOIN salary AS sal ON stf.staid = sal.staid INNER JOIN department AS d ON ss.did = d.did";
        if ($did != "-1") {
            $query.= " Where ss.did = $did";
        }
        if ($staid != "-1") {
            $query.= " AND ss.staid = $staid";
        }
        $query.= " ORDER BY ss.staid, d.did";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchReceiptRangeSum($from, $to) {
        $query = "SELECT SUM(DEBIT) as 'RECEIPT_TOTAL' FROM pledger pledger WHERE etype='crv' AND date BETWEEN '{$from}' AND '{$to}'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchPaymentRangeSum($from, $to) {
        $query = "SELECT SUM(CREDIT) as 'PAYMENT_TOTAL' FROM pledger pledger WHERE etype='cpv' AND date BETWEEN '{$from}' AND '{$to}'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchBPVReportData($startDate, $endDate, $what, $etype, $company_id, $field, $crit, $orderBy, $groupBy, $name) {
        $ord = '';
        if ($what == 'date') {
            $ord = "DATE_FORMAT(pledger.date , '%d/%m/%y')";
        } else if ($what == 'invoice') {
            $ord = 'pledger.dcno';
        } else if ($what == 'wo') {
            $ord = 'pledger.wo';
        } else if ($what == 'party') {
            $ord = 'party.name';
        } else if ($what == 'user') {
            $ord = 'user.uname';
        } else if ($what == 'month') {
            $ord = 'month(pledger.date)';
        } else if ($what == 'weekday') {
            $ord = 'dayname(pledger.date)';
        } else if ($what == 'year') {
            $ord = 'year(pledger.date)';
        }
        $query = "SELECT $ord as group_sort,dayname(pledger.date) as weekdate, month(pledger.date) as monthdate,year(pledger.date) as yeardate,pledger.chq_no,date(pledger.chq_date) as chq_date,pledger.ETYPE, pledger.DCNO AS VRNOA,party.NAME AS PARTY,pledger.DEBIT AS DEBIT,pledger.credit AS 'CREDIT',pledger.DESCRIPTION AS REMARKS, DATE_FORMAT(pledger.date , '%d/%m/%y') as 'DATE', user.uname, company.company_name
		FROM pledger pledger
		INNER JOIN party party ON pledger.pid = party.pid
		INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
		INNER JOIN user AS user ON user.uid=pledger.uid
		INNER JOIN company ON company.company_id=pledger.company_id
		WHERE pledger.ETYPE= '" . $etype . "' AND pledger.date BETWEEN '$startDate' AND '$endDate' AND pledger.company_id=$company_id $crit
		ORDER BY  $ord ,pledger.date";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchJVReportData($startDate, $endDate, $what, $etype, $company_id, $field, $crit, $orderBy, $groupBy, $name) {
        $ord = '';
        if ($what == 'date') {
            $ord = 'pledger.date';
        } else if ($what == 'invoice') {
            $ord = 'pledger.dcno';
        } else if ($what == 'wo') {
            $ord = 'pledger.wo';
        } else if ($what == 'party') {
            $ord = 'party.name';
        } else {
            $ord = 'user.uname';
        }
        $query = "SELECT $ord group_sort, pledger.ETYPE, pledger.DCNO AS VRNOA,party.NAME AS PARTY,pledger.DEBIT AS DEBIT,pledger.credit AS 'CREDIT',pledger.DESCRIPTION AS REMARKS, pledger.DATE, user.uname, company.company_name,pledger.wo
		FROM pledger pledger
		INNER JOIN party party ON pledger.pid = party.pid
		INNER JOIN user ON user.uid=pledger.uid
		INNER JOIN company ON company.company_id=pledger.company_id
		WHERE pledger.ETYPE='$etype' AND pledger.date BETWEEN '$startDate' AND '$endDate' AND pledger.company_id=$company_id $crit
		ORDER BY $ord,pledger.date";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchCashReportData($startDate, $endDate, $what, $etype, $company_id, $field, $crit, $orderBy, $groupBy, $name) {
        $ord = '';
        if ($what == 'date') {
            $ord = 'pledger.date';
        } else if ($what == 'invoice') {
            $ord = 'pledger.dcno';
        } else if ($what == 'party') {
            $ord = 'party.name';
        } else if ($what == 'wo') {
            $ord = 'pledger.wo';
        } else {
            $ord = 'user.uname';
        }
        $query = "SELECT $ord as group_sort, pledger.ETYPE, pledger.DCNO AS VRNOA,party.NAME AS PARTY,(CASE WHEN (pledger.etype='cpv') THEN pledger.DEBIT ELSE pledger.credit END) AS 'AMOUNT',pledger.DESCRIPTION AS REMARKS, date_format(pledger.DATE,'%d/%m/%y') as DATE, user.uname, company.company_name,pledger.wo
		FROM pledger
		INNER JOIN party  ON pledger.pid = party.pid
		INNER JOIN user ON user.uid=pledger.uid
		INNER JOIN company ON company.company_id=pledger.company_id
		WHERE (CASE WHEN (pledger.etype='cpv') THEN pledger.DEBIT<>0 ELSE pledger.credit<>0 END) AND pledger.ETYPE='$etype' AND pledger.date BETWEEN '$startDate' AND '$endDate' AND pledger.company_id=$company_id $crit
		ORDER BY $ord,pledger.date";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function set_post($dcno)
    {
        $query = $this->db->query("update pledger set ptype = 'posted' where dcno = $dcno ");
    }

    
    public function post_chk($dcno)
    {
        $query = $this->db->query("SELECT DISTINCT ptype from pledger where dcno = '$dcno' and ptype = 'posted'");
        if ($demo = $query->num_rows)
        {
           if($demo = 1)
           {
               return "posted";
           }

        }
        $query = $this->db->query("SELECT DISTINCT ptype from pledger where dcno = '$dcno' and ptype = 'unpost'");
        if ($demo = $query->num_rows)
        {
           if($demo = 1)
           {
               return "unposted";
           }

        }
        else
        {
            return "";
        }
    }

    public function fetchAllColors() {
        $result = $this->db->get("color");
        return $result->result_array();
    }
    public function fetchAllSizes() {
        $result = $this->db->get("size");
        return $result->result_array();
    }

}
?>