<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sales extends CI_Model {
    public function getMaxVrno($etype) {
        $result = $this->db->query("SELECT MAX(vrno) vrno FROM salemain WHERE etype = '" . $etype . "' AND DATE(vrdate) = DATE(NOW())");
        $row = $result->row_array();
        $maxId = $row['vrno'];
        return $maxId;
    }
    public function getMaxVrnoa($etype) {
        $result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM salemain WHERE etype = '" . $etype . "'");
        $row = $result->row_array();
        $maxId = $row['vrnoa'];
        return $maxId;
    }
    public function fetchAllSales($company_id, $etype) {
        $result = $this->db->query("SELECT round(ordermain.discount,0) as discount,round(ordermain.expense,0) as expense,round(ordermain.tax,0) as tax,ordermain.vrnoa, DATE_FORMAT(ordermain.vrdate,'%d %b %y') AS DATE,p.name AS party_name,ordermain.remarks,round(ordermain.taxpercent,1) as taxpercent,round(ordermain.exppercent,1) as exppercent,round(ordermain.discp,1) as discp,round(ordermain.paid,0) as paid,round(ordermain.namount,0) AS namount,user.uname as user_name,time(ordermain.date_time) as date_time
									FROM ordermain ordermain
									INNER JOIN party p ON p.pid = ordermain.party_id
									INNER JOIN user ON user.uid = ordermain.uid
									INNER JOIN company c ON c.company_id = ordermain.company_id 
									WHERE ordermain.company_id= '" . $company_id . "' AND ordermain.etype= '" . $etype . "' AND ordermain.vrdate = CURDATE()
									ORDER BY ordermain.vrnoa DESC
									LIMIT 10");
        return $result->result_array();
    }
    public function fetchChartData($period, $company_id) {
        $period = strtolower($period);
        $query = '';
        if ($period === 'daily') {
            $query = "SELECT VRNOA, party.name AS ACCOUNT, NAMOUNT  FROM stockmain INNER JOIN party ON party.party_id = stockmain.party_id  WHERE stockmain.etype='sale' AND vrdate = CURDATE() AND stockmain.company_id=$company_id order by stockmain.vrdate desc LIMIT 10";
        } else if ($period === 'weekly') {
            $query = "SELECT sum(case when date_format(vrdate, '%W') = 'Monday' then namount else 0 end) as 'Monday', sum(case when date_format(vrdate, '%W') = 'Tuesday' then namount else 0 end) as 'Tuesday', sum(case when date_format(vrdate, '%W') = 'Wednesday' then namount else 0 end) as 'Wednesday', sum(case when date_format(vrdate, '%W') = 'Thursday' then namount else 0 end) as 'Thursday', sum(case when date_format(vrdate, '%W') = 'Friday' then namount else 0 end) as 'Friday', sum(case when date_format(vrdate, '%W') = 'Saturday' then namount else 0 end) as 'Saturday', sum(case when date_format(vrdate, '%W') = 'Sunday' then namount else 0 end) as 'Sunday' from stockmain where    etype = 'sale' and vrdate between DATE_SUB(VRDATE, INTERVAL 7 DAY) and CURDATE() AND stockmain.company_id = $company_id group by WEEK(VRDATE) order by WEEK(VRDATE) desc LIMIT 1 ";
        } else if ($period === 'monthly') {
            $query = "SELECT sum(case when date_format(vrdate, '%W') = 'Monday' then namount else 0 end) as 'Monday', sum(case when date_format(vrdate, '%W') = 'Tuesday' then namount else 0 end) as 'Tuesday', sum(case when date_format(vrdate, '%W') = 'Wednesday' then namount else 0 end) as 'Wednesday', sum(case when date_format(vrdate, '%W') = 'Thursday' then namount else 0 end) as 'Thursday', sum(case when date_format(vrdate, '%W') = 'Friday' then namount else 0 end) as 'Friday', sum(case when date_format(vrdate, '%W') = 'Saturday' then namount else 0 end) as 'Saturday', sum(case when date_format(vrdate, '%W') = 'Sunday' then namount else 0 end) as 'Sunday' from stockmain where    etype = 'sale' and MONTH(VRDATE) = MONTH(CURDATE()) AND stockmain.company_id=$company_id group by WEEK(VRDATE) order by WEEK(VRDATE) desc LIMIT 4";
        } else if ($period === 'yearly') {
            $query = "SELECT YEAR(vrdate) as 'Year', MONTHNAME(STR_TO_DATE(MONTH(VRDATE), '%m')) as Month, sum(namount) AS TotalAmount FROM stockmain where  etype = 'Sale' and YEAR(VRDATE) = YEAR(CURDATE()) AND stockmain.company_id = $company_id GROUP BY YEAR(vrdate), MONTH(vrdate) ORDER BY YEAR(vrdate), MONTH(vrdate)";
        }
        $query = $this->db->query($query);
        return $query->result_array();
    }
    public function save($stockmain, $stockdetail, $vrnoa, $etype) {
        $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
        $this->db->delete('salemain');
        $this->db->insert('salemain', $stockmain);
        $slid = $this->db->insert_id();
        $affect = 0;
        foreach ($stockdetail as $detail) {
            $detail['slid'] = $slid;
            $this->db->insert('saledetail', $detail);
            $affect = $this->db->affected_rows();
        }
        if ($affect == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetch($vrnoa, $etype) {
        $result = $this->db->query("SELECT m.vrno, m.vrnoa, m.vrdate, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, m.salebillno AS 'order_no', ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', m.ddate AS 'due_date', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name', dep.name AS 'dept_name' FROM salemain AS m INNER JOIN saledetail AS d ON m.slid = d.slid INNER JOIN item AS i ON i.item_id = d.item_id INNER JOIN department AS dep ON dep.did = d.godown_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchByCol($col) {
        $result = $this->db->query("SELECT DISTINCT $col FROM salemain");
        return $result->result_array();
    }
    public function delete($vrnoa, $etype) {
        $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa));
        $result = $this->db->get('salemain');
        if ($result->num_rows() == 0) {
            return false;
        } else {
            $result = $result->row_array();
            $slid = $result['slid'];
            $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa));
            $this->db->delete('salemain');
            $this->db->where(array('slid' => $slid));
            $this->db->delete('saledetail');
            return true;
        }
    }
    public function fetchSaleReportData($startDate, $endDate, $what, $type) {
        if ($what === 'voucher') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.VRNOA");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, DATE(stockmain.VRDATE) VRDATE, stockmain.VRNOA, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.VRNOA ORDER BY stockmain.VRNOA");
                return $query->result_array();
            }
        } else if ($what == 'account') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.party_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' Group by stockmain.party_id ORDER BY stockmain.party_id");
                return $query->result_array();
            }
        } else if ($what == 'location') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, dept.name AS NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON stockdetail.godown_id = dept.did WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockdetail.godown_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT dept.NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON dept.did = stockdetail.godown_id WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
                return $query->result_array();
            }
        } else if ($what == 'item') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockdetail.item_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT item.description as NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
                return $query->result_array();
            }
        } else if ($what == 'date') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.vrdate");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT date(stockmain.vrdate) as DATE, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.vrdate ORDER BY stockmain.vrdate");
                return $query->result_array();
            }
        }
    }
    public function fetchSaleReturnReportData($startDate, $endDate, $what, $type) {
        if ($what === 'voucher') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.VRNOA");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' Group by stockmain.VRNOA ORDER BY stockmain.VRNOA");
                return $query->result_array();
            }
        } else if ($what == 'account') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.party_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' Group by stockmain.party_id ORDER BY stockmain.party_id");
                return $query->result_array();
            }
        } else if ($what == 'location') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, godown.name AS NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department godown ON stockdetail.godown_id = godown.did WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockdetail.godown_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT godown.NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department godown ON godown.did = stockdetail.godown_id WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
                return $query->result_array();
            }
        } else if ($what == 'item') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockdetail.item_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT item.description as NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
                return $query->result_array();
            }
        } else if ($what == 'date') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.vrdate");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT date(stockmain.vrdate) as DATE, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='sale return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.vrdate ORDER BY stockmain.vrdate");
                return $query->result_array();
            }
        }
    }
    public function fetchProfitLossReportData($what, $startDate, $endDate, $filterCrit) {
        if ($what === 'voucher') {
            $query = $this->db->query("SELECT stockmain.VRDATE, IFNULL(party.NAME, '') NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.amount NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price PRATE, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.stid = stockdetail.stid LEFT JOIN party party ON stockmain.party_id = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' ORDER BY stockmain.VRNOA");
            return $query->result_array();
        } else if ($what == 'party') {
            if ($filterCrit == 'all') {
                $query = $this->db->query("SELECT stockmain.VRDATE, IFNULL(party.NAME, '') NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.amount NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price PRATE, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.stid = stockdetail.stid LEFT JOIN party party ON stockmain.party_id = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' ORDER BY stockmain.PARTY_ID");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT stockmain.VRDATE, party.NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price cost_price, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM pos_stockmain_tbl stockmain INNER JOIN pos_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.party_id = party.pid INNER JOIN pos_item_tbl item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' AND stockmain.party_id=$filterCrit ORDER BY stockmain.PARTY_ID");
                return $query->result_array();
            }
        } else if ($what == 'item') {
            if ($filterCrit == 'all') {
                $query = $this->db->query("SELECT stockmain.VRDATE, IFNULL(party.NAME, '') NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.amount NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price PRATE, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.stid = stockdetail.stid LEFT JOIN party party ON stockmain.party_id = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' ORDER BY stockdetail.ITEM_ID");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT stockmain.VRDATE, party.NAME, stockmain.ETYPE, stockmain.REMARKS, stockmain.VRNOA, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.DESCRIPTION, stockmain.etype, item.cost_price cost_price, CASE stockmain.etype WHEN 'sale' THEN (ABS(qty)*(rate-cost_price)) WHEN 'salereturn' THEN -(ABS(qty)*(rate-cost_price)) END AS PLS FROM pos_stockmain_tbl stockmain INNER JOIN pos_stockdetail_tbl stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.party_id = party.pid INNER JOIN pos_item_tbl item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE (stockmain.ETYPE='sale' OR stockmain.ETYPE='salereturn') AND stockmain.VRDATE BETWEEN '$startDate' AND '$endDate' AND  stockdetail.ITEM_ID=$filterCrit ORDER BY stockdetail.ITEM_ID");
                return $query->result_array();
            }
        }
    }
    public function fetchRangeSum($from, $to) {
        $query = "SELECT IFNULL(SUM(CREDIT), 0)-IFNULL(SUM(DEBIT),0) as 'SALES_TOTAL' FROM pledger pledger WHERE pid IN (SELECT pid FROM party party WHERE NAME='sale') AND date between '{$from}' AND '{$to}'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchSRRangeSum($from, $to) {
        $query = "SELECT IFNULL(SUM(DEBIT), 0)-IFNULL(SUM(CREDIT),0) as 'SRETURNS_TOTAL' FROM pledger pledger WHERE pid IN (SELECT pid FROM party party WHERE NAME='sale return') AND date between '{$from}' AND '{$to}'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
}