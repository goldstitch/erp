<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class exportvr extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxVrno($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrno) vrno FROM exportmain WHERE etype = '" . $etype . "' and company_id=$company_id AND DATE(vrdate) = DATE(NOW())");
        $row = $result->row_array();
        $maxId = $row['vrno'];
        return $maxId;
    }
    public function fetchParty_vendor() {
        $result = $this->db->query("SELECT p.name,i.item_id,i.item_des,i.uom,m.workorder, IFNULL(SUM(d.qty),0) AS qty, IFNULL(SUM(d.weight),0) AS weight
                                	FROM stockdetail d
                                	INNER JOIN stockmain m ON m.stid = d.stid
                                	INNER JOIN party p ON p.pid= m.party_id
                                	INNER JOIN item i ON i.item_id= d.item_id
                                	WHERE m.etype IN ('issuetovenders','receivefromvenders','tr_consume','tr_produce','rejection','settelment')
                                	GROUP BY p.name,i.item_id,i.item_des,i.uom,m.workorder");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchItemStocks_vendor($crit, $etype, $company_id, $vrdate) {
        $result = $this->db->query("SELECT m.workorder, if(i.uom='dozen', -round(IFNULL(SUM(d.qty)/12,0),0),-round(IFNULL(SUM(d.qty),0),0)) AS stock, -IFNULL(SUM(d.weight),0) AS weight
										FROM stockdetail d
										INNER JOIN stockmain m ON m.stid = d.stid
										left JOIN department g ON g.did= d.godown_id
										INNER JOIN item i ON d.item_id= i.item_id
										WHERE  m.company_id = $company_id and m.vrdate<='" . $vrdate . "' and m.etype in ('issuetovenders','receivefromvenders','tr_consume','tr_produce','rejection','settelment') $crit
										group by m.workorder having IFNULL(SUM(d.qty),0)<>0 ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchPurchaseReturnReportData($startDate, $endDate, $what, $type) {
        if ($what === 'voucher') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT exportmain.VRDATE, exportmain.REMARKS, exportmain.VRNOA, exportmain.REMARKS, party.NAME, exportdetail.QTY, exportdetail.RATE, exportdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id ORDER BY exportmain.VRNOA");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, date(exportmain.VRDATE) VRDATE, exportmain.VRNOA, round(SUM(exportdetail.QTY)) QTY, round(SUM(exportdetail.RATE)) RATE, round(sum(exportdetail.NETAMOUNT)) NETAMOUNT, exportmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id Group by exportmain.VRNOA ORDER BY exportmain.VRNOA");
                return $query->result_array();
            }
        } else if ($what == 'account') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT exportmain.VRDATE, exportmain.REMARKS, exportmain.VRNOA, exportmain.REMARKS, party.NAME, exportdetail.QTY, exportdetail.RATE, exportdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id ORDER BY exportmain.party_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, date(exportmain.VRDATE) VRDATE, exportmain.VRNOA, round(SUM(exportdetail.QTY)) QTY, round(SUM(exportdetail.RATE)) RATE, round(sum(exportdetail.NETAMOUNT)) NETAMOUNT, exportmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id Group by exportmain.party_id ORDER BY exportmain.party_id");
                return $query->result_array();
            }
        } else if ($what == 'godown') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT exportmain.VRDATE, exportmain.REMARKS, exportmain.VRNOA, exportmain.REMARKS, dept.name AS NAME, exportdetail.QTY, exportdetail.RATE, exportdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id INNER JOIN department dept ON exportdetail.godown_id = dept.did WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id ORDER BY exportdetail.godown_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT dept.NAME, ROUND(SUM(exportdetail.QTY)) QTY, ROUND(SUM(exportdetail.RATE)) RATE, ROUND(SUM(exportdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id INNER JOIN department dept ON dept.did = exportdetail.godown_id WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id GROUP BY exportdetail.godown_id ORDER BY exportdetail.godown_id");
                return $query->result_array();
            }
        } else if ($what == 'item') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT exportmain.VRDATE, exportmain.REMARKS, exportmain.VRNOA, exportmain.REMARKS, party.NAME, exportdetail.QTY, exportdetail.RATE, exportdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY exportdetail.item_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT item.item_des as NAME, ROUND(SUM(exportdetail.QTY)) QTY, ROUND(SUM(exportdetail.RATE)) RATE, ROUND(SUM(exportdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY exportdetail.item_id ORDER BY exportdetail.item_id");
                return $query->result_array();
            }
        } else if ($what == 'date') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT exportmain.VRDATE, exportmain.REMARKS, exportmain.VRNOA, exportmain.REMARKS, party.NAME, exportdetail.QTY, exportdetail.RATE, exportdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY exportmain.vrdate");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT date(exportmain.vrdate) as DATE, ROUND(SUM(exportdetail.QTY)) QTY, ROUND(SUM(exportdetail.RATE)) RATE, ROUND(SUM(exportdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid INNER JOIN item item ON exportdetail.item_id = item.item_id WHERE exportmain.ETYPE='purchase return' AND exportmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY exportmain.vrdate ORDER BY exportmain.vrdate");
                return $query->result_array();
            }
        }
    }
    public function Validate_Order($etype, $company_id, $order_no, $status) {
        $result = $this->db->query("SELECT vrnoa FROM exportmain WHERE etype = '" . $etype . "' and company_id=$company_id AND vrnoa =$order_no  and status='" . $status . "' and vrnoa not in (select ordno from exportmain where ordno=$order_no and etype='order_parts') ");
        $row = $result->row_array();
        if ($result->num_rows() > 0) {
            $chk_flag = $row['vrnoa'];
            return $chk_flag;
        } else {
            return false;
        }
    }
    public function fetchVoucher($vrnoa, $etype, $company_id) {
        $query = $this->db->query("SELECT sp.name as phase_name,d.gstp,d.gst,d.fedp,d.fed,d.dozen,d.bag,t.name AS transporter_name,dp.name dept_name, p.name AS party_name,m.vrno,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.ordno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, d.qty, ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight
                            FROM exportmain AS m
                            INNER JOIN exportdetail AS d ON m.oid = d.oid
                            INNER JOIN item AS i ON i.item_id = d.item_id
                            INNER JOIN party AS p ON p.pid=m.party_id
                            INNER JOIN department AS dp ON dp.did=d.godown_id
                            left JOIN transporter AS t ON t.transporter_id=m.transporter_id
                            LEFT JOIN subphase  AS sp ON sp.id=d.phase_id
                            WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "' ");
        return $query->result_array();
    }
    public function Validate_Order_Loading($etype, $company_id, $order_no, $status) {
        $result = $this->db->query("SELECT vrnoa FROM exportmain WHERE etype = 'order_parts' and company_id=$company_id AND ordno =$order_no  ");
        $row = $result->row_array();
        if ($result->num_rows() > 0) {
            $chk_flag = $row['vrnoa'];
            return $chk_flag;
        } else {
            return false;
        }
    }
    public function fetchByCol($col) {
        $result = $this->db->query("SELECT DISTINCT $col FROM exportmain");
        return $result->result_array();
    }
    public function fetchOrderReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT $field AS voucher,$name,exportdetail.bag,exportdetail.gstrate,exportdetail.gstamount,exportdetail.ctn_qty,exportdetail.dzn_qty,exportdetail.frate,item.artcile_no,ic.artcile_no as artcile_no_cus
,ic.item_des as item_desc_cus,cur.name as currencey_name,
			DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username,exportdetail.amount,exportmain.vrdate, exportmain.remarks, exportmain.vrnoa, exportmain.remarks, ABS(exportdetail.qty) qty, exportdetail.weight, exportdetail.rate, exportdetail.netamount, item.item_des AS 'item_des',item.uom
			FROM exportmain exportmain
			INNER JOIN exportdetail exportdetail ON exportmain.oid = exportdetail.oid
			INNER JOIN party party ON exportmain.party_id = party.pid
			INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
			INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
			INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
			left JOIN department dept ON exportdetail.godown_id = dept.did
			INNER JOIN item item ON exportdetail.item_id = item.item_id
			INNER JOIN user user ON user.uid = exportmain.uid
			left join currencey cur on cur.id=exportmain.currencey_id 
			left JOIN item ic ON ic.item_id = exportdetail.item_id_cus 
			WHERE exportmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id AND exportmain.etype='$etype' $crit
			ORDER BY $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT $field AS voucher,$name, DAYNAME(vrdate) AS weekdate,
			 ROUND(SUM(exportdetail.dzn_qty)) dzn_qty, ROUND(SUM(exportdetail.ctn_qty)) ctn_qty, 
			ROUND(SUM(exportdetail.gstrate)) gstrate,ROUND(SUM(exportdetail.gstamount)) gstamount,
			ROUND(SUM(exportdetail.frate)) frate,cur.name as currencey_name,
			MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username, 
			DATE(exportmain.vrdate) AS DATE, ROUND(SUM(exportdetail.amount)) amount, DATE(exportmain.VRDATE) VRDATE, 
			exportmain.vrnoa, ABS(ROUND(SUM(exportdetail.qty))) qty,ROUND(SUM(exportdetail.weight)) weight, 
			ROUND(SUM(exportdetail.rate)) rate, ROUND(SUM(exportdetail.netamount)) netamount, 
			exportmain.remarks
FROM exportmain exportmain
INNER JOIN exportdetail exportdetail ON exportmain.oid = exportdetail.oid
INNER JOIN party party ON exportmain.party_id = party.pid
INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
left JOIN department dept ON exportdetail.godown_id = dept.did
INNER JOIN item item ON exportdetail.item_id = item.item_id
INNER JOIN user user ON user.uid = exportmain.uid
left join currencey cur on cur.id=exportmain.currencey_id 
left JOIN item ic ON ic.item_id = exportdetail.item_id_cus 
WHERE exportmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id AND exportmain.etype='$etype' $crit
GROUP BY $groupBy
ORDER BY $orderBy");
            return $query->result_array();
        }
    }
    public function fetchRequisitionReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT  $field as voucher,$name,exportdetail.lvendor,exportdetail.lstock,dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,exportdetail.amount,exportmain.vrdate, exportmain.remarks, exportmain.vrnoa, exportmain.remarks,  abs(exportdetail.qty) qty, exportdetail.weight, exportdetail.rate, exportdetail.netamount, item.item_des as 'item_des',item.uom FROM exportmain exportmain INNER JOIN exportdetail exportdetail ON exportmain.oid = exportdetail.oid LEFT JOIN party party ON exportmain.party_id = party.pid              LEFT JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 LEFT JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 LEFT JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN department dept  ON exportdetail.godown_id = dept.did  INNER JOIN item item ON exportdetail.item_id = item.item_id INNER JOIN user user ON user.uid = exportmain.uid WHERE  exportmain.vrdate between '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id AND exportmain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT  $field as voucher,$name,dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,date(exportmain.vrdate) as DATE, exportdetail.amount,round(SUM(exportdetail.lvendor)) lvendor,round(SUM(exportdetail.lstock)) lstock, date(exportmain.VRDATE) VRDATE, exportmain.vrnoa, ABS(round(SUM(exportdetail.qty))) qty, round(SUM(exportdetail.weight)) weight, round(SUM(exportdetail.rate)) rate, round(sum(exportdetail.netamount)) netamount, exportmain.remarks FROM exportmain exportmain INNER JOIN exportdetail exportdetail ON exportmain.oid = exportdetail.oid LEFT JOIN party party ON exportmain.party_id = party.pid              LEFT JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 LEFT JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 LEFT JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN department dept  ON exportdetail.godown_id = dept.did  INNER JOIN item item ON exportdetail.item_id = item.item_id INNER JOIN user user ON user.uid = exportmain.uid WHERE  exportmain.vrdate between '" . $startDate . "' AND '" . $endDate . "' AND exportmain.company_id=$company_id AND exportmain.etype='$etype' $crit group by $groupBy order by $orderBy");
            return $query->result_array();
        }
    }
    public function fetchOrderReportDataParts($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT  $field as voucher,$name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,exportmain.vrdate,date(exportmain.vrdate) as date, exportmain.remarks, exportmain.vrnoa, exportmain.remarks, abs(exportdetail.qty) qty, exportdetail.weight, exportdetail.netamount, item.item_des as 'item_des',item.uom FROM exportmain exportmain INNER JOIN exportdetail exportdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON exportdetail.item_id = item.item_id INNER JOIN department dept  ON exportdetail.godown_id = dept.did INNER JOIN user user ON user.uid = exportmain.uid  WHERE  exportmain.vrdate between '" . $startDate . "' and '" . $endDate . "' and exportmain.company_id=$company_id and exportmain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT  $field as voucher,$name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,date(exportmain.vrdate) as date, date(exportmain.vrdate) vrdate, exportmain.vrnoa, ABS(round(SUM(exportdetail.qty))) qty, round(SUM(exportdetail.weight)) weight, round(SUM(exportdetail.RATE)) RATE, round(sum(exportdetail.netamount)) netamount, exportmain.remarks FROM exportmain exportmain INNER JOIN exportdetail exportdetail ON exportmain.oid = exportdetail.oid INNER JOIN party party ON exportmain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON exportdetail.item_id = item.item_id INNER JOIN user user ON user.uid = exportmain.uid  INNER JOIN department dept  ON exportdetail.godown_id = dept.did WHERE  exportmain.VRDATE between '" . $startDate . "' and '" . $endDate . "' and exportmain.company_id=$company_id and exportmain.etype='$etype' $crit group by $groupBy order by $orderBy");
            return $query->result_array();
        }
    }
    public function getMaxVrnoa($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM exportmain WHERE etype = '" . $etype . "' and company_id=$company_id");
        $row = $result->row_array();
        $maxId = $row['vrnoa'];
        return $maxId;
    }
    public function save($exportmain, $exportdetail, $vrnoa, $etype) {
        $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
        $result = $this->db->get('exportmain');
        $oid = "";
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $oid = $result['oid'];
            $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
            $this->db->update('exportmain', $exportmain);
            $this->db->where(array('oid' => $oid));
            $this->db->delete('exportdetail');
        } else {
            $this->db->insert('exportmain', $exportmain);
            $oid = $this->db->insert_id();
        }
        foreach ($exportdetail as $detail) {
            $detail['oid'] = $oid;
            $this->db->insert('exportdetail', $detail);
        }
        return true;
    }
    public function fetchAllNotedBy() {
        $result = $this->db->query("SELECT DISTINCT noted_by FROM exportmain WHERE noted_by <> ''");
        return $result->result_array();
    }
    public function fetchDeliveryTerms() {
        $result = $this->db->query("SELECT DISTINCT delivery_term FROM exportmain order by delivery_term ");
        return $result->result_array();
    }
    public function fetchPaymentTerms() {
        $result = $this->db->query("SELECT DISTINCT payment_term FROM exportmain order by payment_term ");
        return $result->result_array();
    }
    public function fetchPortofdischarge() {
        $result = $this->db->query("SELECT DISTINCT port_of_discharge FROM exportmain WHERE port_of_discharge <> '' order by port_of_discharge ");
        return $result->result_array();
    }
    public function fetchAllApprovedBy() {
        $result = $this->db->query("SELECT DISTINCT approved_by FROM exportmain WHERE approved_by <> ''");
        return $result->result_array();
    }
    public function fetchAllreferBy() {
        $result = $this->db->query("SELECT DISTINCT order_by FROM exportmain WHERE order_by <> ''");
        return $result->result_array();
    }
    public function fetchAllPayment() {
        $result = $this->db->query("SELECT DISTINCT payment FROM exportmain WHERE payment <> ''");
        return $result->result_array();
    }
    public function fetchAllDistinct($field) {
        $result = $this->db->query("SELECT DISTINCT $field FROM exportdetail WHERE $field <> '' ");
        return $result->result_array();
    }
    public function fetchAllDistinctMain($field) {
        $result = $this->db->query("SELECT DISTINCT $field FROM exportmain WHERE $field <> '' ");
        return $result->result_array();
    }
    public function fetchAllPreparedBy() {
        $result = $this->db->query("SELECT DISTINCT prepared_by FROM exportmain WHERE prepared_by <> ''");
        return $result->result_array();
    }
    public function fetchByColDetail($col) {
        $result = $this->db->query("SELECT DISTINCT $col FROM exportdetail where $col <>'';");
        return $result->result_array();
    }
    public function fetch($vrnoa, $etype, $company_id) {
        $results = array();
        $sql = "SELECT  m.hscode,m.cif,m.remarksbl,m.blqty,m.remarkspacking,m.active,m.order_vrno,m.approved_by,m.freight,m.made_in,m.port_of_discharge,m.seal_no,m.eform_no,m.edate,d.qtyf,m.lc_no,m.lc_date,m.container_no,m.gross_weight,m.net_weight, sp.id as phase_id, sp.name as phase_name, sp2.id as phase_id2, sp2.name as phaseTo,comp.company_name,d.work_orderno as dwork_orderno,m.bilty_date, cur.cur_symbol, m.ordno as pono,m.workorderno as wono,m.inv_no, comp.company_name,comp.address comp_address,comp.contact as comp_contact,comp.strn as comp_strn,comp.ntn as comp_ntn,
		 		party.name as party_name,party.address as party_address,party.phone as party_phone,party.cnic as party_strn,party.ntn as party_ntn,
				m.etype2, d.netamount as netamount_d,d.gstrate,d.gstamount, ic.artcile_no as artcile_no_cus,ic.item_id as item_id_cus,ic.item_des as item_desc_cus,d.frate, m.currencey_id,cur.name as currencey_name,m.lprate as lprate_m, m.workorderno,d.gstp,d.gst,d.fedp,d.fed,d.dozen,d.bag,m.due_date,m.bilty_no,i.artcile_no,m.officer_id,m.received_by,m.currencey_id, comp.bank as bank_detail, comp.foot_note as foot_note,trans.name as transporter_name,i.artcile_no,d.label2,d.parchi,m.export_register_no,d.ctn_qty,d.dzn_qty, m.shippment_from,m.shippment_to,m.tax_status,m.cpono,m.delivery_term,m.dispatch_address,m.payment_term,m.approved_by,m.prepared_by,party.name party_name,party.address party_address,m.vrno, m.vrnoa,m.workorderno, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.lprate,d.lvendor,d.lstock, d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type,d.pick,d.reed,d.width,d.count,d.colors,d.brand,d.qlty,i.item_des AS item_name, i.uom, m.godown_id, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid, d.grossweight,
				d.ctnmarking, d.size, d.color, d.origin_criterion, d.noofctn, m.cosignee_the_order_of, m.sale_invoice_no, comp.company_name, comp.address, comp.contact, m.vessel, m.voyage, m.bl_no, m.bl_date,ifnull(m.notify_party,'')notify_party
				FROM exportmain AS m 
				INNER JOIN exportdetail AS d ON m.oid = d.oid 
				LEFT JOIN transporter trans on trans.transporter_id =m.transporter_id 
				inner JOIN company comp on comp.company_id = m.company_id 
				INNER JOIN item i ON i.item_id = d.item_id 
				left JOIN item ic ON ic.item_id = d.item_id_cus 
				left JOIN department dep ON dep.did = d.godown_id 
				LEFT JOIN party  on party.pid=m.party_id 
				left join recipemain rcp on rcp.item_id=d.item_id 
				left join currencey cur on cur.id=m.currencey_id 
				left join subphase as sp on sp.id=d.phase_id
				left join subphase as sp2 on sp2.id=d.phase_id2
				WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id  order by d.type,d.odid";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            $results['main'] = $result->result_array();
            return $results;
        } else {
            return false;
        }
    }
    public function fetchRemaining($vrnoa, $etype, $company_id) {
        $sql = "SELECT d.type,m.freight,m.party_id_co,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no, m.bilty_date , m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.inv_no AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.officer_id, d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight,ifnull(d.weight,0)-ifnull(stk.st_weight,0) as st_weight,ifnull(d.qty,0)-ifnull(stk.st_qty,0) as st_qty,ifnull(stk.st_weight,0) as st_weight1,ifnull(stk.st_qty,0) as st_qty1
		FROM exportmain AS m
		INNER JOIN exportdetail AS d ON m.oid = d.oid
		INNER JOIN item AS i ON i.item_id = d.item_id
		left JOIN department AS g ON g.did = d.godown_id
		left join (
		SELECT m.inv_no,d.item_id, ifnull(sum(d.weight),0) as st_weight, ifnull(sum(d.qty),0) as st_qty
		FROM stockmain AS m
		INNER JOIN stockdetail AS d ON m.stid = d.stid
		INNER JOIN item AS i ON i.item_id = d.item_id
		where m.etype='inward' and m.inv_no=$vrnoa and m.approved_by='$etype' and  m.company_id=$company_id
		group by m.inv_no,d.item_id
		) as stk on stk.inv_no=m.vrnoa and stk.item_id=d.item_id
		WHERE  m.company_id = $company_id AND m.etype = '$etype' and vrnoa=$vrnoa and if(i.uom='kg' || i.uom='kgs',ifnull(d.weight,0)-ifnull(stk.st_weight,0)>0, ifnull(d.qty,0)-ifnull(stk.st_qty,0)>0)";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchYarnPurchaseAccount($vrnoa, $etype, $company_id) {
        $sql = "SELECT p.pid,m.ordno,m.workorderno,p.date datetime,Date(p.date) as date, p.dcno,party.account_id,party.name,p.description,p.debit,p.credit  from pledger p INNER JOIN party party on party.pid = p.pid LEFT JOIN exportmain m on m.vrnoa = p.dcno and m.etype = p.etype where p.etype = '" . $etype . "'  and p.dcno = $vrnoa and  p.company_id = $company_id";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_vrno($vrno, $etype, $company_id, $etype2) {
        $sql = "SELECT m.etype2, d.netamount as netamount_d,d.gstrate,d.gstamount, ic.artcile_no as artcile_no_cus,ic.item_id as item_id_cus,ic.item_des as item_desc_cus,d.frate, m.currencey_id,cur.name as currencey_name,m.lprate as lprate_m, m.workorderno,d.gstp,d.gst,d.fedp,d.fed,d.dozen,d.bag,m.due_date,m.bilty_no,i.artcile_no,m.officer_id,m.received_by,m.currencey_id, comp.bank as bank_detail, comp.foot_note as foot_note,trans.name as transporter_name,i.artcile_no,d.label2,d.parchi,m.export_register_no,d.ctn_qty,d.dzn_qty, m.shippment_from,m.shippment_to,m.tax_status,m.cpono,m.delivery_term,m.dispatch_address,m.payment_term,m.approved_by,m.prepared_by,party.name party_name,party.address party_address,m.vrno, m.vrnoa,m.workorderno, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.lprate,d.lvendor,d.lstock, d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type,d.pick,d.reed,d.width,d.count,d.colors,d.brand,d.qlty,i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid
				FROM exportmain AS m 
				INNER JOIN exportdetail AS d ON m.oid = d.oid 
				LEFT JOIN transporter trans on trans.transporter_id =m.transporter_id 
				inner JOIN company comp on comp.company_id = m.company_id 
				INNER JOIN item i ON i.item_id = d.item_id 
				left JOIN item ic ON ic.item_id = d.item_id_cus 
				left JOIN department dep ON dep.did = d.godown_id 
				LEFT JOIN party  on party.pid=m.party_id 
				left join recipemain rcp on rcp.item_id=d.item_id 
				left join currencey cur on cur.id=m.currencey_id 
				WHERE m.vrno = $vrno AND m.etype = '" . $etype . "' AND m.etype2 = '" . $etype2 . "' and m.company_id=$company_id  order by d.type,d.odid";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllSaleOrder() {
        $result = $this->db->query("select vrnoa from exportmain where etype = 'sale_order';");
        return $result->result_array();
    }
    public function fetchPartsOrders($vrnoa, $etype, $company_id, $type, $etype2) {
        if ($type == 'spare_parts') {
            $result = $this->db->query("SELECT i.cost_price,party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,i.cost_price, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name, rcp.finisheditem_id AS finish_item, IFNULL(rcp.stid,0) recipeid
										FROM exportmain AS m
										INNER JOIN exportdetail AS d ON m.oid = d.oid
										INNER JOIN item i ON i.item_id = d.item_id
										INNER JOIN department dep ON dep.did = d.godown_id
										INNER JOIN party party ON party.pid=m.party_id
										LEFT JOIN itemmain rcp ON rcp.finisheditem_id=d.item_id
										WHERE m.vrnoa = $vrnoa AND m.etype ='" . $etype . "' AND m.company_id=$company_id AND i.item_id NOT IN (
										SELECT finisheditem_id
										FROM itemmain)
										group by i.item_id
										ORDER BY d.type,d.odid;
			");
        } else if ($type == 'parts') {
            $result = $this->db->query("SELECT i.item_id,rcpd.qty rqty,rcp.fqty,d.qty dqty, sum(d.qty *(rcpd.qty/ IFNULL(rcp.fqty,1))) AS qty, d.weight *(rcpd.weight/ IFNULL(rcp.fweight,1)) AS weight, i.item_des AS item_name, i.uom, rcp.finisheditem_id AS finish_item, IFNULL(rcp.stid,0) recipeid,i.cost_price,d.rate
										FROM exportmain AS m
										INNER JOIN exportdetail AS d ON m.oid = d.oid
										INNER JOIN itemmain rcp ON rcp.finisheditem_id=d.item_id
										INNER JOIN itemdetail rcpd ON rcpd.stid=rcp.stid
										INNER JOIN item i ON i.item_id = rcpd.item_id
										WHERE m.vrnoa =$vrnoa AND m.etype = '" . $etype . "' AND m.company_id=$company_id AND rcpd.`etype`='" . $etype2 . "'
										group by i.item_id
										order by i.item_id");
        } else {
            $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name  FROM exportmain AS m INNER JOIN exportdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id   and d.`type`='less'  order by d.type,d.odid");
        }
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchPartsOrderaLabour($vrnoa, $etype, $company_id, $etype2) {
        $result = $this->db->query("SELECT  d.qty*(rcpd.rate/ IFNULL(rcp.fqty,1)) as lrate,i.item_id,rcpd.qty rqty,rcp.fqty,d.qty dqty, d.qty *(rcpd.qty/ IFNULL(rcp.fqty,1)) AS qty, d.weight *(rcpd.weight/ IFNULL(rcp.fweight,1)) AS weight, i.item_des AS item_name, i.uom, rcp.finisheditem_id AS finish_item, IFNULL(rcp.stid,0) recipeid,sum(rcpd.rate) rate,rcpd.amount,rcpd.subphase_id,sb.name AS phase_name,rcpd.calculationmethod,sum(rcpd.rate2) rate2
										FROM exportmain AS m
										INNER JOIN exportdetail AS d ON m.oid = d.oid
										INNER JOIN itemmain rcp ON rcp.finisheditem_id=d.item_id
										INNER JOIN itemdetail rcpd ON rcpd.stid=rcp.stid
										LEFT JOIN item i ON i.item_id = rcpd.item_id
										INNER JOIN subphase sb ON sb.id=rcpd.subphase_id
										WHERE m.vrnoa =$vrnoa AND m.etype = '" . $etype . "' AND m.company_id=$company_id AND rcpd.`etype`='" . $etype2 . "'
										group by rcpd.subphase_id
										order by rcpd.subphase_id	
									");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchItemStocks($item_id, $etype, $company_id, $vrdate) {
        $result = $this->db->query("SELECT g.name, if(i.uom='dozen', round(IFNULL(SUM(d.qty)/12,0),0),round(IFNULL(SUM(d.qty),0),0)) AS stock, round(IFNULL(SUM(d.weight),0),2) AS weight
										FROM stockdetail d
										INNER JOIN stockmain m ON m.stid = d.stid
										INNER JOIN department g ON g.did= d.godown_id
										INNER JOIN item i ON d.item_id= i.item_id
										WHERE d.item_id = $item_id AND m.company_id = $company_id and m.vrdate<='" . $vrdate . "'
										group by g.name ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchItemlpRate($item_id, $etype, $company_id) {
        $result = $this->db->query("SELECT  rate as lprate from exportdetail where item_id =
	$item_id and oid in (select oid from exportmain where etype='" . $etype . "' and company_id = $company_id) order by oid desc limit 1");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchLfiveStocks($item_id, $etype, $company_id) {
        $result = $this->db->query("SELECT d.qty as stock,d.weight as weight,g.name as name from exportdetail d INNER JOIN exportmain m on m.oid = d.oid  INNER JOIN department g on d.godown_id = g.did   where item_id = $item_id and etype='" . $etype . "' and m.company_id=$company_id");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchLfiveRates($item_id, $etype, $company_id) {
        $result = $this->db->query("SELECT qty,rate as lprate from exportdetail where item_id = $item_id
			 and oid in (select vrdate,vrnoa,oid from exportmain m where etype='" . $etype . "' and company_id=$company_id ) order by oid desc limit 5");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function last_5_srate($item_id, $etype, $company_id, $crit) {
        $result = $this->db->query("SELECT party.name as party_name, m.vrnoa, DATE(m.vrdate) vrdate, ROUND(d.qty, 2) qty,d.rate as lprate, ROUND(d.weight, 2) as weight
									FROM exportmain AS m
									INNER JOIN exportdetail AS d ON m.oid = d.oid
									INNER JOIN item i ON i.item_id = d.item_id
									INNER JOIN department dep ON dep.did = d.godown_id
									left JOIN party ON party.pid=m.party_id
									WHERE   m.etype ='" . $etype . "' and m.company_id=$company_id and d.item_id=$item_id $crit
									ORDER BY m.vrdate  desc
									limit 5");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_order_stock($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) tot_qty, ROUND(d.weight, 2) tot_weight, ROUND(stk.qty, 2) qty, ROUND(stk.weight, 2) weight,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid FROM exportmain AS m INNER JOIN exportdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id left join recipemain rcp on rcp.item_id=d.item_id
		inner join(SELECT ifnull(sum(d.qty),0) as qty,ifnull(sum(d.weight),0) as weight,i.item_id,i.item_des,d.type  FROM exportmain AS m INNER JOIN exportdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id left join recipemain rcp on rcp.item_id=d.item_id WHERE m.ordno =$vrnoa and  m.etype in('sale','sale_order') and m.company_id=$company_id  group by i.item_id,d.`type`) as stk on stk.item_id=d.item_id and stk.`type`=d.`type`
		WHERE m.vrnoa =$vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id
		order by d.type,d.odid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchPartsOrder($vrnoa, $etype, $company_id, $type) {
        if ($type == 'parts') {
            $result = $this->db->query("SELECT i.item_id,rcpd.qty rqty ,rcp.fqty,d.qty dqty, d.qty *(rcpd.qty/ifnull(rcp.fqty,1)) as qty, d.weight *(rcpd.weight/ifnull(rcp.fweight,1)) as weight, i.item_des AS item_name, i.uom, rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid FROM exportmain AS m
			INNER JOIN exportdetail AS d ON m.oid = d.oid  
			inner join recipemain rcp on rcp.item_id=d.item_id 
			inner join recipedetail rcpd on rcpd.rid=rcp.rid 
			INNER JOIN item i ON i.item_id = rcpd.item_id 
			WHERE m.vrnoa =$vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id and d.`type`='add'
			");
        } else if ($type == 'spare_parts') {
            $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid FROM exportmain AS m INNER JOIN exportdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id left join recipemain rcp on rcp.item_id=d.item_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id and i.item_id not in (select item_id from recipemain)  and d.`type`='add'  order by d.type,d.odid");
        } else {
            $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name  FROM exportmain AS m INNER JOIN exportdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id   and d.`type`='less'  order by d.type,d.odid");
        }
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_loading_Stock($order_no, $company_id) {
        $result = $this->db->query("select d.type,i.item_id,i.item_des item_name,ifnull(sum(d.qty),0) qty,ifnull(sum(d.weight),0) weight, ifnull(sd.stqty,0) stqty,ifnull(sd.stweight,0) stweight from exportdetail d
			inner join item i on i.item_id=d.item_id
			inner join exportmain m on m.oid=d.oid 
			left join  (select item_id,ifnull(sum(qty),0) stqty,ifnull(sum(weight),0) stweight from stockdetail group by item_id) sd on sd.item_id=i.item_id
			where m.ordno=$order_no and m.company_id=$company_id and m.etype in('order_parts','order_loading') and d.type<>'less'
			group by d.type,i.item_id,i.item_des having ifnull(sum(d.qty),0)<>0");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_parts($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name FROM exportmain AS m INNER JOIN exportdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id  order by d.type,d.odid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchPurchaseOrder($vrnoa, $etype) {
        $result = $this->db->query("SELECT m.vrno, m.vrnoa, m.vrdate, m.party_id, m.remarks, m.payment, m.order_by, m.noted_by, m.shade_card, m.approved_by, m.etype, ROUND(m.amount, 2) amount, ROUND(m.discountp, 2) discountp, ROUND(m.discount, 2) discount, ROUND(m.namount, 2) namount, d.item_id, d.godown_id, ROUND(d.qty, 2) item_qty, ROUND(d.rate, 2) item_rate, ROUND(d.amount, 2) item_amount, ROUND(d.gstrate, 2) item_gstrate, ROUND(d.gstamount, 2) item_gstamount, ROUND(d.netamount, 2) item_netamount, i.item_des item_name, ROUND(d.weight, 2) weight, d.type status FROM exportmain AS m INNER JOIN exportdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id WHERE m.vrnoa = $vrnoa AND etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchInwardGatePass($vrnoa, $etype) {
        $result = $this->db->query("SELECT m.vrno, m.vrnoa, m.vrdate, m.party_id, m.remarks, m.payment, m.order_by, m.noted_by, m.approved_by, m.etype, m.party_id_co, d.item_id, d.godown_id, ROUND(d.qty) qty, d.uom, dep.name AS 'dept_name', i.description AS 'item_name' FROM exportmain m INNER JOIN exportdetail d ON m.oid = d.oid LEFT JOIN department dep ON dep.did = d.godown_id INNER JOIN item i ON i.item_id = d.item_id WHERE m.vrnoa = $vrnoa AND etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function delete($vrnoa, $etype, $company_id) {
        $this->db->where(array('etype' => $etype, 'dcno' => $vrnoa, 'company_id' => $company_id));
        $result = $this->db->delete('pledger');
        $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa, 'company_id' => $company_id));
        $result = $this->db->get('exportmain');
        if ($result->num_rows() == 0) {
            return false;
        } else {
            $result = $result->row_array();
            $oid = $result['oid'];
            $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa));
            $this->db->delete('exportmain');
            $this->db->where(array('oid' => $oid));
            $this->db->delete('exportdetail');
            return true;
        }
    }
    public function fetchOrders($from, $to, $type) {
        if ($type == 'new') {
            $result = $this->db->query("SELECT oid,exportmain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, exportmain.remarks FROM exportmain INNER JOIN party ON party.pid = exportmain.party_id WHERE STATUS = 'new' AND exportmain.etype = 'sale_order'");
            return $result->result_array();
        } else if ($type == 'running') {
            $result = $this->db->query("SELECT oid,exportmain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, exportmain.remarks FROM exportmain INNER JOIN party ON party.pid = exportmain.party_id WHERE STATUS = 'running' AND vrnoa not in (select ordno from exportmain where etype='order_parts' ) AND exportmain.etype = 'sale_order' order by exportmain.vrnoa");
            return $result->result_array();
        } else if ($type == 'running_loading') {
            $result = $this->db->query("SELECT oid,exportmain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, exportmain.remarks FROM exportmain INNER JOIN party ON party.pid = exportmain.party_id WHERE STATUS = 'running' AND vrnoa  in (select ordno from exportmain where etype='order_parts' ) AND exportmain.etype = 'sale_order' order by exportmain.vrnoa");
            return $result->result_array();
        } else if ($type == 'sale') {
            $result = $this->db->query("SELECT oid,exportmain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, exportmain.remarks FROM exportmain INNER JOIN party ON party.pid = exportmain.party_id WHERE vrnoa not in (select ordno from exportmain where etype='sale' ) AND exportmain.etype = 'sale_order' order by exportmain.vrnoa");
            return $result->result_array();
        } else {
            $result = $this->db->query("SELECT oid,exportmain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, exportmain.remarks FROM exportmain INNER JOIN party ON party.pid = exportmain.party_id WHERE exportmain.etype = 'sale_order' order by exportmain.vrnoa");
            return $result->result_array();
        }
    }
    public function Loading_Stock($company_id, $order_no) {
        $result = $this->db->query("select type,item_id,ifnull(sum(qty),0) qty,ifnull(sum(weight),0) weight from exportdetail where oid in (select oid from exportmain where etype in('order_parts','order_loading') and ordno=$order_no ) group by type,item_id");
        return $result->result_array();
    }
    public function updateOrderStatus($oids) {
        foreach ($oids as $oid) {
            $this->db->query("UPDATE exportmain SET status = 'running' WHERE etype = 'sale_order' AND oid = $oid");
        }
        return true;
    }
    public function getCompanyInfo($companyId) {
        $result = $this->db->query("select * from company where company_id = '" . $companyId . "' ");
        return $result->result_array();
    }
    public function fetchs($vrnoa, $etype, $company_id) {
        $sql = "SELECT m.hscode,m.cif,m.remarksbl,m.blqty,m.remarkspacking, m.active,m.sale_invoice_no,m.order_vrno,m.approved_by,m.freight,m.made_in,m.port_of_discharge,m.seal_no,m.eform_no,m.edate,d.qtyf,m.lc_no,m.lc_date,m.container_no,m.gross_weight,m.net_weight, sp.id as phase_id, sp.name as phase_name, sp2.id as phase_id2, sp2.name as phaseTo,comp.company_name,d.work_orderno as dwork_orderno,m.bilty_date, cur.cur_symbol, m.ordno as pono,m.workorderno as wono,m.inv_no, comp.company_name,comp.address comp_address,comp.contact as comp_contact,comp.strn as comp_strn,comp.ntn as comp_ntn,
                party.name as party_name,party.address as party_address,party.phone as party_phone,party.cnic as party_strn,party.ntn as party_ntn,
                m.etype2, d.netamount as netamount_d,d.gstrate,d.gstamount, ic.artcile_no as artcile_no_cus,ic.item_id as item_id_cus,ic.item_des as item_desc_cus,d.frate, m.currencey_id,cur.name as currencey_name,m.lprate as lprate_m, m.workorderno,d.gstp,d.gst,d.fedp,d.fed,d.dozen,d.bag,m.due_date,m.bilty_no,i.artcile_no,m.officer_id,m.received_by,m.currencey_id, comp.bank as bank_detail, comp.foot_note as foot_note,trans.name as transporter_name,i.artcile_no,d.label2,d.parchi,m.export_register_no,d.ctn_qty,d.dzn_qty, m.shippment_from,m.shippment_to,m.tax_status,m.cpono,m.delivery_term,m.dispatch_address,m.payment_term,m.approved_by,m.prepared_by,party.name party_name,party.address party_address,m.vrno, m.vrnoa,m.workorderno, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.lprate,d.lvendor,d.lstock, d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type,d.pick,d.reed,d.width,d.count,d.colors,d.brand,d.qlty,i.item_des AS item_name, i.uom, m.godown_id, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid, d.grossweight,
                d.ctnmarking, d.size, d.color, d.origin_criterion, d.noofctn, m.cosignee_the_order_of, m.vessel, m.voyage, m.bl_no, m.bl_date
                FROM exportmain AS m
                INNER JOIN exportdetail AS d ON m.oid = d.oid
                LEFT JOIN transporter trans on trans.transporter_id =m.transporter_id
                inner JOIN company comp on comp.company_id = m.company_id
                INNER JOIN item i ON i.item_id = d.item_id
                left JOIN item ic ON ic.item_id = d.item_id_cus
                left JOIN department dep ON dep.did = d.godown_id
                LEFT JOIN party  on party.pid=m.party_id
                left join recipemain rcp on rcp.item_id=d.item_id
                left join currencey cur on cur.id=m.currencey_id
                left join subphase as sp on sp.id=d.phase_id
                left join subphase as sp2 on sp2.id=d.phase_id2
                WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id  order by d.type,d.odid";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}