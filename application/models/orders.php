<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    
    public function getMaxVrno($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrno) vrno FROM ordermain WHERE etype = '" . $etype . "' and company_id=$company_id AND DATE(vrdate) = DATE(NOW())");
        $row = $result->row_array();
        $maxId = $row['vrno'];
        return $maxId;
    }

        
    public function getMaxVrnoaMR() {
        $result = $this->db->query("SELECT MAX(id) id FROM require_material ");
        $row = $result->row_array();
        $maxId = $row['id'];
        return $maxId;
    }

    public function FetchOrderNoParty() {
        $result = $this->db->query("SELECT m.vrnoa,concat(p.name ,' , Wo:' , m.vrnoa , ' , Date:' , date_format(m.vrdate,'%d/%m/%y'))  party_name 
			FROM ordermain m
			inner join party p on p.pid=m.party_id
			WHERE m.etype = 'sale_order' order by p.name");
        return $result->result_array();
    }
    public function getMaxVrnoEtype2($etype, $company_id, $etype2) {
        $result = $this->db->query("SELECT MAX(vrno) vrno FROM ordermain WHERE etype = '" . $etype . "' and etype2 = '" . $etype2 . "' and company_id=$company_id ");
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
			WHERE d.type<>'less' and m.etype IN ('issuetovenders','receivefromvenders','tr_consume','tr_produce','rejection','settelment')
			GROUP BY p.name,i.item_id,i.item_des,i.uom,m.workorder");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    

    public function sample_issue_material($vrnoa) {
        $result = $this->db->query("SELECT i.item_des description,d.item_id,d.qty 
			FROM stockmain m 
			INNER JOIN stockdetail d ON m.stid = d.stid 
			INNER JOIN item i ON i.item_id = d.item_id 
			INNER JOIN department dep ON dep.did = d.godown_id 
			INNER JOIN department dep2 ON dep2.did = d.godown_id2 
			INNER JOIN user ON user.uid = m.uid 

			WHERE m.vrnoa = $vrnoa AND m.etype = 'sample_issue' AND m.company_id = 1 AND d.qty > 0 group by i.item_des");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchItemStocks_vendor($crit, $etype, $company_id, $vrdate) {
        $sql = "SELECT concat( m.workorder , '/' , i.item_des) workorder,, round(IFNULL(SUM(d.qty),0),2) AS stock, IFNULL(SUM(d.weight),0) AS weight
		FROM vendorstock d
		INNER JOIN stockmain m ON m.stid = d.stid
		left JOIN department g ON g.did= d.godown_id
		INNER JOIN item i ON d.item_id= i.item_id
		WHERE  m.company_id = $company_id and m.vrdate<='$vrdate'  $crit 
		group by m.workorder,i.item_des
		having IFNULL(SUM(d.qty),0)<>0 ";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchPurchaseReturnReportData($startDate, $endDate, $what, $type) {
        if ($what === 'voucher') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT ordermain.VRDATE, ordermain.REMARKS, ordermain.VRNOA, ordermain.REMARKS, party.NAME, orderdetail.QTY, orderdetail.RATE, orderdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id ORDER BY ordermain.VRNOA");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, date(ordermain.VRDATE) VRDATE, ordermain.VRNOA, round(SUM(orderdetail.QTY)) QTY, round(SUM(orderdetail.RATE)) RATE, round(sum(orderdetail.NETAMOUNT)) NETAMOUNT, ordermain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id Group by ordermain.VRNOA ORDER BY ordermain.VRNOA");
                return $query->result_array();
            }
        } else if ($what == 'account') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT ordermain.VRDATE, ordermain.REMARKS, ordermain.VRNOA, ordermain.REMARKS, party.NAME, orderdetail.QTY, orderdetail.RATE, orderdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id ORDER BY ordermain.party_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, date(ordermain.VRDATE) VRDATE, ordermain.VRNOA, round(SUM(orderdetail.QTY)) QTY, round(SUM(orderdetail.RATE)) RATE, round(sum(orderdetail.NETAMOUNT)) NETAMOUNT, ordermain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id Group by ordermain.party_id ORDER BY ordermain.party_id");
                return $query->result_array();
            }
        } else if ($what == 'godown') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT ordermain.VRDATE, ordermain.REMARKS, ordermain.VRNOA, ordermain.REMARKS, dept.name AS NAME, orderdetail.QTY, orderdetail.RATE, orderdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN department dept ON orderdetail.godown_id = dept.did WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id ORDER BY orderdetail.godown_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT dept.NAME, ROUND(SUM(orderdetail.QTY)) QTY, ROUND(SUM(orderdetail.RATE)) RATE, ROUND(SUM(orderdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN department dept ON dept.did = orderdetail.godown_id WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id GROUP BY orderdetail.godown_id ORDER BY orderdetail.godown_id");
                return $query->result_array();
            }
        } else if ($what == 'item') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT ordermain.VRDATE, ordermain.REMARKS, ordermain.VRNOA, ordermain.REMARKS, party.NAME, orderdetail.QTY, orderdetail.RATE, orderdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY orderdetail.item_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT item.item_des as NAME, ROUND(SUM(orderdetail.QTY)) QTY, ROUND(SUM(orderdetail.RATE)) RATE, ROUND(SUM(orderdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY orderdetail.item_id ORDER BY orderdetail.item_id");
                return $query->result_array();
            }
        } else if ($what == 'date') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT ordermain.VRDATE, ordermain.REMARKS, ordermain.VRNOA, ordermain.REMARKS, party.NAME, orderdetail.QTY, orderdetail.RATE, orderdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY ordermain.vrdate");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT date(ordermain.vrdate) as DATE, ROUND(SUM(orderdetail.QTY)) QTY, ROUND(SUM(orderdetail.RATE)) RATE, ROUND(SUM(orderdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid INNER JOIN item item ON orderdetail.item_id = item.item_id WHERE ordermain.ETYPE='purchase return' AND ordermain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY ordermain.vrdate ORDER BY ordermain.vrdate");
                return $query->result_array();
            }
        }
    }
    public function Validate_Order($etype, $company_id, $order_no, $status) {
        $result = $this->db->query("SELECT vrnoa FROM ordermain WHERE etype = '" . $etype . "' and company_id=$company_id AND vrnoa =$order_no  and status='" . $status . "' and vrnoa not in (select ordno from ordermain where ordno=$order_no and etype='order_parts') ");
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
			FROM ordermain AS m
			INNER JOIN orderdetail AS d ON m.oid = d.oid
			INNER JOIN item AS i ON i.item_id = d.item_id
			INNER JOIN party AS p ON p.pid=m.party_id
			INNER JOIN department AS dp ON dp.did=d.godown_id
			left JOIN transporter AS t ON t.transporter_id=m.transporter_id
			LEFT JOIN subphase  AS sp ON sp.id=d.phase_id
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "' ");
        return $query->result_array();
    }
    public function Validate_Order_Loading($etype, $company_id, $order_no, $status) {
        $result = $this->db->query("SELECT vrnoa FROM ordermain WHERE etype = 'order_parts' and company_id=$company_id AND ordno =$order_no  ");
        $row = $result->row_array();
        if ($result->num_rows() > 0) {
            $chk_flag = $row['vrnoa'];
            return $chk_flag;
        } else {
            return false;
        }
    }
    public function fetchByCol($col) {
        $result = $this->db->query("SELECT DISTINCT $col FROM ordermain");
        return $result->result_array();
    }
    public function fetchOrderReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed' || $type = 'summary') {
            $query = $this->db->query("SELECT $field AS voucher,$name,orderdetail.bag,orderdetail.gstrate,orderdetail.gstamount,orderdetail.ctn_qty,orderdetail.dzn_qty,orderdetail.frate,item.artcile_no,ic.artcile_no as artcile_no_cus ,orderdetail.dozen
				,ic.item_des as item_desc_cus,cur.name as currencey_name,
				DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username,orderdetail.amount,ordermain.vrdate, ordermain.remarks, ordermain.vrnoa, ordermain.remarks, ABS(orderdetail.qty) qty, orderdetail.weight, orderdetail.rate, orderdetail.netamount, item.item_des AS 'item_des',item.uom
				FROM ordermain ordermain
				INNER JOIN orderdetail orderdetail ON ordermain.oid = orderdetail.oid
				INNER JOIN party party ON ordermain.party_id = party.pid
				INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
				INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
				INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
				left JOIN department dept ON orderdetail.godown_id = dept.did
				INNER JOIN item item ON orderdetail.item_id = item.item_id

				left JOIN brand  ON brand.bid=item.bid
				left JOIN category ON category.catid=item.catid
				left JOIN subcategory  ON subcategory.subcatid=item.subcatid 
				left JOIN made  ON made.made_id=item.made_id

				INNER JOIN user user ON user.uid = ordermain.uid
				left join currencey cur on cur.id=ordermain.currencey_id 
				left JOIN item ic ON ic.item_id = orderdetail.item_id_cus 
				WHERE ordermain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id AND ordermain.etype='$etype' $crit
				ORDER BY $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT $field AS voucher,$name, DAYNAME(vrdate) AS weekdate, 
				ROUND(SUM(orderdetail.dzn_qty)) dzn_qty, ROUND(SUM(orderdetail.ctn_qty)) ctn_qty, 
				ROUND(SUM(orderdetail.gstrate)) gstrate,ROUND(SUM(orderdetail.gstamount)) gstamount,
				ROUND(SUM(orderdetail.frate)) frate,cur.name as currencey_name,
				MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username, 
				DATE(ordermain.vrdate) AS DATE, ROUND(SUM(orderdetail.amount)) amount, DATE(ordermain.VRDATE) VRDATE, 
				ordermain.vrnoa, ABS(ROUND(SUM(orderdetail.qty))) qty,ROUND(SUM(orderdetail.weight)) weight, 
				ROUND(SUM(orderdetail.rate)) rate, ROUND(SUM(orderdetail.netamount)) netamount, 
				ordermain.remarks
				FROM ordermain ordermain
				INNER JOIN orderdetail orderdetail ON ordermain.oid = orderdetail.oid
				INNER JOIN party party ON ordermain.party_id = party.pid
				INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
				INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
				INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
				left JOIN department dept ON orderdetail.godown_id = dept.did
				INNER JOIN item item ON orderdetail.item_id = item.item_id

				left JOIN brand  ON brand.bid=item.bid
				left JOIN category ON category.catid=item.catid
				left JOIN subcategory  ON subcategory.subcatid=item.subcatid 
				left JOIN made  ON made.made_id=item.made_id

				INNER JOIN user user ON user.uid = ordermain.uid
				left join currencey cur on cur.id=ordermain.currencey_id 
				left JOIN item ic ON ic.item_id = orderdetail.item_id_cus 
				WHERE ordermain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id AND ordermain.etype='$etype' $crit
				GROUP BY $groupBy
				ORDER BY $orderBy");
            return $query->result_array();
        }
    }
    public function fetchSaleReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        $query = $this->db->query("SELECT $field AS voucher,$name,ordermain.lprate,ordermain.namount as nett_amount,ordermain.due_date,party.country,orderdetail.bag,orderdetail.gstrate,orderdetail.gstamount,orderdetail.ctn_qty,orderdetail.dzn_qty,orderdetail.frate,item.artcile_no,ic.artcile_no as artcile_no_cus
			,ic.item_des as item_desc_cus,cur.name as currencey_name,
			DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username,orderdetail.amount,ordermain.vrdate, ordermain.remarks, ordermain.vrnoa, ordermain.remarks, ABS(orderdetail.qty) qty, orderdetail.weight, orderdetail.rate, orderdetail.netamount, item.item_des AS 'item_des',item.uom,ifnull(rcv.rcv_amount,0) as rcv_amount,rcv.rcv_date
			FROM ordermain ordermain
			INNER JOIN orderdetail orderdetail ON ordermain.oid = orderdetail.oid
			INNER JOIN party party ON ordermain.party_id = party.pid
			INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
			INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
			INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
			left JOIN department dept ON orderdetail.godown_id = dept.did
			INNER JOIN item item ON orderdetail.item_id = item.item_id
			INNER JOIN user user ON user.uid = ordermain.uid
			left join currencey cur on cur.id=ordermain.currencey_id 
			left JOIN item ic ON ic.item_id = orderdetail.item_id_cus 
			left join
			(select pid,invoice,ifnull(sum(credit),0) as rcv_amount,date as rcv_date from pledger 
			where invoice<>'' and credit<>0
			group by pid,invoice) as rcv on rcv.invoice=ordermain.vrnoa and rcv.pid=ordermain.party_id

			WHERE ordermain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id AND ordermain.etype='sale' AND ordermain.etype2='export'  $crit
			ORDER BY $orderBy");
        return $query->result_array();
    }
    public function fetchRequisitionReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT  $field as voucher,$name,orderdetail.lvendor,orderdetail.lstock,dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,orderdetail.amount,ordermain.vrdate, ordermain.remarks, ordermain.vrnoa, ordermain.remarks,  abs(orderdetail.qty) qty, orderdetail.weight, orderdetail.rate, orderdetail.netamount, item.item_des as 'item_des',item.uom FROM ordermain ordermain INNER JOIN orderdetail orderdetail ON ordermain.oid = orderdetail.oid LEFT JOIN party party ON ordermain.party_id = party.pid              LEFT JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 LEFT JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 LEFT JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN department dept  ON orderdetail.godown_id = dept.did  INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN user user ON user.uid = ordermain.uid WHERE  ordermain.vrdate between '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id AND ordermain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT  $field as voucher,$name,dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,date(ordermain.vrdate) as DATE, orderdetail.amount,round(SUM(orderdetail.lvendor)) lvendor,round(SUM(orderdetail.lstock)) lstock, date(ordermain.VRDATE) VRDATE, ordermain.vrnoa, ABS(round(SUM(orderdetail.qty))) qty, round(SUM(orderdetail.weight)) weight, round(SUM(orderdetail.rate)) rate, round(sum(orderdetail.netamount)) netamount, ordermain.remarks FROM ordermain ordermain INNER JOIN orderdetail orderdetail ON ordermain.oid = orderdetail.oid LEFT JOIN party party ON ordermain.party_id = party.pid              LEFT JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 LEFT JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 LEFT JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN department dept  ON orderdetail.godown_id = dept.did  INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN user user ON user.uid = ordermain.uid WHERE  ordermain.vrdate between '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id AND ordermain.etype='$etype' $crit group by $groupBy order by $orderBy");
            return $query->result_array();
        }
    }


    public function fetchdiscount($item_id,$date,$godown_id) {
  
        $result = $this->db->query("SELECT limited_discount from stockdetail WHERE item_id ='$item_id' AND godown_id='$godown_id' AND from_date <= '{$date}'
        AND to_date >= '{$date}'");
        if ($result->num_rows() > 0) {
            $row = $result->row_array();
            $discount = $row['limited_discount'];
           return $discount;
        }
        else
        {   
            $result = $this->db->query("SELECT limited_discount from stockdetail WHERE item_id ='$item_id' AND godown_id='$godown_id' AND to_date <'{$date}' and to_date != '0000-00-00'");
            if ($result->num_rows() > 0) {
                $query = $this->db->query("UPDATE stockdetail set item_discount='0' ,to_date='0000-00-00' WHERE item_id ='$item_id' AND godown_id='$godown_id'");
            }
            $result = $this->db->query("SELECT DISTINCT item_discount from stockdetail where item_id ='$item_id' AND godown_id='$godown_id'");
            $row = $result->row_array();
            $disc = $row['item_discount'];
            return $disc;
        }
    }
    public function fetchOrderReportDataParts($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT  $field as voucher,$name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,ordermain.vrdate,date(ordermain.vrdate) as date, ordermain.remarks, ordermain.vrnoa, ordermain.remarks, abs(orderdetail.qty) qty, orderdetail.weight, orderdetail.netamount, item.item_des as 'item_des',item.uom FROM ordermain ordermain INNER JOIN orderdetail orderdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN department dept  ON orderdetail.godown_id = dept.did INNER JOIN user user ON user.uid = ordermain.uid  WHERE  ordermain.vrdate between '" . $startDate . "' and '" . $endDate . "' and ordermain.company_id=$company_id and ordermain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT  $field as voucher,$name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,date(ordermain.vrdate) as date, date(ordermain.vrdate) vrdate, ordermain.vrnoa, ABS(round(SUM(orderdetail.qty))) qty, round(SUM(orderdetail.weight)) weight, round(SUM(orderdetail.RATE)) RATE, round(sum(orderdetail.netamount)) netamount, ordermain.remarks FROM ordermain ordermain INNER JOIN orderdetail orderdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN user user ON user.uid = ordermain.uid  INNER JOIN department dept  ON orderdetail.godown_id = dept.did WHERE  ordermain.VRDATE between '" . $startDate . "' and '" . $endDate . "' and ordermain.company_id=$company_id and ordermain.etype='$etype' $crit group by $groupBy order by $orderBy");
            return $query->result_array();
        }
    }
    public function getMaxVrnoa($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM ordermain WHERE etype = '" . $etype . "' and company_id=$company_id");
        $row = $result->row_array();
        $maxId = $row['vrnoa'];
        return $maxId;
    }

    public function getmaxid() {
        $this->db->select_max('id');
	    $result = $this->db->get('sample_production');
	    $row = $result->row_array();
	    $maxId = $row['id'];
	    return $maxId;
    }

    public function getmaxidjob() {
        $this->db->select_max('id');
	    $result = $this->db->get('job');
	    $row = $result->row_array();
	    $maxId = $row['id'];
	    return $maxId;
    }

    public function getmaxidsample_card() {
        $this->db->select_max('id');
	    $result = $this->db->get('sample_card');
	    $row = $result->row_array();
	    $maxId = $row['id'];
	    return $maxId;
    }


    public function getmax_id() {
        $this->db->select_max('id');
	    $result = $this->db->get('approve_production');
	    $row = $result->row_array();
	    $maxId = $row['id'];
	    return $maxId;
    }

    public function getmaxid_() {
        $this->db->select_max('id');
	    $result = $this->db->get('final_production_material');
	    $row = $result->row_array();
	    $maxId = $row['id'];
	    return $maxId;
    }

    public function getmaxids() {
        $this->db->select_max('sr');
	    $result = $this->db->get('production_calculation');
	    $row = $result->row_array();
	    $maxId = $row['sr'];
	    return $maxId;
    }

    public function getid() {
        $this->db->select_max('id');
	    $result = $this->db->get('material_demand');
	    $row = $result->row_array();
	    $maxId = $row['id'];
	    return $maxId;
    }

    public function delete_sample_production ($id,$code) {

        $this->db->where(array('id'=>$id));
        $this->db->delete('sample_production');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('embroidory');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('summary');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('press_pack');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('embelishment');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('stitch_accesseries');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('cut_stitch');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('fabric_dye');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('material');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('digital_printing');

        return true;
        
    }

    public function delete_job ($id) {

        $this->db->where(array('id'=>$id));
        $this->db->delete('job');
        return true;

    }

    public function delete_req_material($id) {

        $this->db->where(array('id'=>$id));
        $this->db->delete('require_material');
        return true;
        
    }

    public function delete_sample_card ($id) {

        $this->db->where(array('id'=>$id));
        $this->db->delete('sample_card');

        $this->db->where(array('id'=>$id));
        $this->db->delete('sample_card_detail');

        return true;
        
    }


    public function delete_approve_production($id,$code) {

        $this->db->where(array('id'=>$id));
        $this->db->delete('approve_production');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('approve_embroidory');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('approve_summary');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('approve_press_pack');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('approve_embelishment');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('approve_stitch_accesseries');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('approve_cut_stitch');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('approve_fabric_dye');

        $this->db->where(array('design_id'=>$code));
        $this->db->delete('approve_material');

        return true;
        
    }

    public function delete_production_calculation($id) {

        $this->db->where(array('sr'=>$id));
        $this->db->delete('production_calculation');

        return true;
    }

    public function delete_material_demand($id) {

        $this->db->where(array('id'=>$id));
        $this->db->delete('material_demand');

        return true;
    }

    public function delete_final_production($id) {

        $this->db->where(array('id'=>$id));
        $this->db->delete('final_production_material');

        return true;
    }

    public function save_sample_production($production,$embroidory,$fabric_dye,$cut_stitch,$stitch_accesseries,$embelishment,$press_pack,$summary,$material,$digital) {
        
        foreach ($production as $detail) {
            $this->db->insert('sample_production', $detail);
        }

        foreach ($embroidory as $detail1) {
            $this->db->insert('embroidory', $detail1);
        }

        foreach ($fabric_dye as $detail2) {
            $this->db->insert('fabric_dye', $detail2);
        }

        foreach ($cut_stitch as $detail3) {
            $this->db->insert('cut_stitch', $detail3);
        }

        foreach ($stitch_accesseries as $detail4) {
            $this->db->insert('stitch_accesseries', $detail4);
        }

        foreach ($embelishment as $detail5) {
            $this->db->insert('embelishment', $detail5);
        }

        foreach ($press_pack as $detail6) {
            $this->db->insert('press_pack', $detail6);
        }

        foreach ($summary as $detail7) {
            $this->db->insert('summary', $detail7);
        }

        foreach ($material as $detail8) {
            $this->db->insert('material', $detail8);
        }

        foreach ($digital as $detail9) {
            $this->db->insert('digital_printing', $detail9);
        }
       
        return true;
    }

    public function save_job($job) {
        
        foreach ($job as $job) {
            $this->db->insert('job', $job);
        }

        return true;
    }


    public function save_req_material($require_material) {
        
        foreach ($require_material as $require_materials) {
            $this->db->insert('require_material',$require_materials);
        }
        return true;
    }


    public function save_sample_card($sample_card,$sample_card_detail) {
        
        foreach ($sample_card as $sample_card) {
            $this->db->insert('sample_card', $sample_card);
        }

        foreach ($sample_card_detail as $sample_card_detail) {
            $this->db->insert('sample_card_detail', $sample_card_detail);
        }

        return true;
    }


    public function save_approve_production($production,$embroidory,$fabric_dye,$cut_stitch,$stitch_accesseries,$embelishment,$press_pack,$summary,$material) {
        
        foreach ($production as $detail) {
            $this->db->insert('approve_production', $detail);
        }

        foreach ($embroidory as $detail1) {
            $this->db->insert('approve_embroidory', $detail1);
        }

        foreach ($fabric_dye as $detail2) {
            $this->db->insert('approve_fabric_dye', $detail2);
        }

        foreach ($cut_stitch as $detail3) {
            $this->db->insert('approve_cut_stitch', $detail3);
        }

        foreach ($stitch_accesseries as $detail4) {
            $this->db->insert('approve_stitch_accesseries', $detail4);
        }

        foreach ($embelishment as $detail5) {
            $this->db->insert('approve_embelishment', $detail5);
        }

        foreach ($press_pack as $detail6) {
            $this->db->insert('approve_press_pack', $detail6);
        }

        foreach ($summary as $detail7) {
            $this->db->insert('approve_summary', $detail7);
        }

        foreach ($material as $detail8) {
            $this->db->insert('approve_material', $detail8);
        }
       
        return true;
    }

    public function save_production_calculation($production) {
        
        foreach ($production as $detail) {
            $this->db->insert('production_calculation', $detail);
        }
        return true;
    }

    public function save_material_demand($material_demand) {
        
        foreach ($material_demand as $detail) {
            $this->db->insert('material_demand', $detail);
        }
        return true;
    }

    

    public function save_final_productions($production) {
        
        foreach ($production as $detail) {
            $this->db->insert('final_production_material', $detail);
        }
        return true;
    }


    public function fetch_sample_production($id,$code) {
        $result = $this->db->query("SELECT * FROM sample_production as p
		INNER JOIN summary AS s ON p.design_id = s.design_id
        INNER JOIN material AS m ON p.design_id = m.design_id  
        WHERE id ='$id' ");
        return $result->result_array();
    }

    

    public function fetch_req_material($id) {
        $result = $this->db->query("SELECT * FROM require_material 
        WHERE id ='$id' ");
        return $result->result_array();
      
    }

    public function fetch_req_material_($id) {
        $result = $this->db->query("SELECT sample_id,item_id,item_desc,qty ,unit,IFNULL(SUM(req_qty),2) req_qty  FROM require_material 
        WHERE id ='$id' group by sample_id,item_desc ");
        return $result->result_array();
    }


    public function fetch_req_material_total($id) {
        $result = $this->db->query("SELECT sample_id,IFNULL(SUM(req_qty),2) total  FROM require_material 
        WHERE id ='$id' group by sample_id ");
        return $result->result_array();
    }

    public function fetch_req_material_item($id) {
        $result = $this->db->query("SELECT distinct item_id,item_desc,unit,IFNULL(SUM(req_qty),2) as req_qty  FROM require_material 
        WHERE id ='$id' group by item_id");
        return $result->result_array();
    }


    public function fetch_sample_material($id) {      
        $result1 = $this->db->query("SELECT description,item_id,IFNULL(SUM(qty),2) qty 
			FROM sample_card_detail WHERE id= '$id' GROUP by description");
        if ($result1->num_rows() > 0) {
            return $result1->result_array();
        } else {
            return false;
        }
    }

    public function fetch_job($id) {
        $result = $this->db->query("SELECT * FROM job
        WHERE id ='$id' ");
        return $result->result_array();
    }

    public function fetch_sample_card($id) {
        $result = $this->db->query("SELECT * FROM sample_card
        WHERE id ='$id' ");
        return $result->result_array();
    }


    public function fetch_sample_card_detail($id) {
        $result = $this->db->query("SELECT * FROM sample_card_detail
        WHERE id ='$id' ");
        return $result->result_array();
    }

    public function fetchjob($id) {

        $result2 = $this->db->query("SELECT MAX(total) total FROM job WHERE id ='$id'");
        $row = $result2->row_array();
        $total = $row['total'];
        

        $result = $this->db->query("SELECT * FROM job
        WHERE id ='$id' and total = '$total' ");
        return $result->result_array();
    }

    public function final_production($code) {
        $result = $this->db->query("SELECT * FROM final_production_material as p
        WHERE id ='$code' ");
        return $result->result_array();
    }

    public function fetch_detail($todate,$fromdate)
    {
    $result = $this->db->query("select * from job where start_date  BETWEEN '{$fromdate}' AND '{$todate}'");
    return $result->result_array();
    }

    public function fetch_samplecard($todate,$fromdate)
    {
    $result = $this->db->query("select * from sample_card where start_date  BETWEEN '{$fromdate}' AND '{$todate}'");
    return $result->result_array();
    }

    public function job_detail($todate,$fromdate)
    {
        $result = $this->db->query("select * from sample_card as s
        INNER JOIN sample_card_detail AS d ON s.id = d.id
        where start_date  BETWEEN '{$fromdate}' AND '{$todate}'");
        return $result->result_array();
    }

    public function job_detail_($todate,$fromdate)
    {
        $result = $this->db->query("select * from sample_card as s
        INNER JOIN sample_card_detail AS d ON s.id = d.id
        where s.id='$todate'");
        return $result->result_array();
    }

    

    public function final_production_detail($code) {
        $result = $this->db->query("SELECT * FROM final_production_material as p
        WHERE design_name ='$code' ");
        return $result->result_array();
    }

    public function fetch_material_demand($code) {
        $result = $this->db->query("SELECT * FROM material_demand as p
        WHERE id ='$code' ");
        return $result->result_array();
    }

    
    public function fetch_approve_production($id,$code) {
        $result = $this->db->query("SELECT * FROM sample_production as p
		INNER JOIN summary AS s ON p.design_name = s.design_name
        WHERE p.design_name ='$code' ");
        return $result->result_array();
    }


    public function fetch_approve_production_($id,$code) {
        $result = $this->db->query("SELECT * FROM approve_production as p
		INNER JOIN approve_summary AS s ON p.design_id = s.design_id
        INNER JOIN approve_material AS m ON p.design_id = m.design_id
        WHERE id ='$id'  ");
        return $result->result_array();
    }

    public function material($code) {
        $result = $this->db->query("SELECT * FROM approve_material as m
        INNER JOIN approve_production AS p ON p.design_name = m.design_name 
        INNER JOIN approve_summary AS sa ON sa.design_name = m.design_name
        WHERE m.design_name ='$code' ");
        return $result->result_array();
    }

    public function sample($code) {
        $result = $this->db->query("SELECT m.material_total,sa.Total FROM approve_material as m
        INNER JOIN approve_summary AS sa ON sa.design_name = m.design_name
        WHERE m.design_name ='$code' ");
        return $result->result_array();
    }



    public function production_calculation($code) {
        $result = $this->db->query("SELECT * FROM approve_material as m
        INNER JOIN approve_production AS p ON p.design_name = m.design_name 
        INNER JOIN approve_summary AS sa ON sa.design_name = m.design_name
        WHERE m.design_name ='$code' ");
        return $result->result_array();
    }

    public function production_calculation_detail($code) {
        $result = $this->db->query("SELECT * FROM production_calculation as m
        WHERE m.sr ='$code' ");
        return $result->result_array();
    }

    public function productions_detail($code) {
        $result = $this->db->query("SELECT * FROM production_calculation as m
        WHERE m.design_name ='$code' ");
        return $result->result_array();
    }


    public function fetch_emb($id,$code) {
        $result = $this->db->query("SELECT * FROM embroidory WHERE design_id ='$code' ");
        return $result->result_array();
    }

    public function fetch_cut($id,$code) {
        $result = $this->db->query("SELECT * FROM cut_stitch WHERE design_id ='$code' ");
        return $result->result_array();
    }

    public function fetch_digital($id,$code) {
        $result = $this->db->query("SELECT * FROM digital_printing WHERE design_id ='$code' ");
        return $result->result_array();
    }

    public function fetch_embl($id,$code) {
        $result = $this->db->query("SELECT * FROM embelishment WHERE design_id ='$code' ");
        return $result->result_array();
    }


    public function fetch_digital_($id,$code) {
        $result = $this->db->query("SELECT * FROM approve_digital_printing WHERE design_id ='$code' ");
        return $result->result_array();
    }

    public function fetch_embl_($id,$code) {
        $result = $this->db->query("SELECT * FROM approve_embelishment WHERE design_id ='$code' ");
        return $result->result_array();
    }

    public function fetch_fab($id,$code) {
        $result = $this->db->query("SELECT * FROM fabric_dye WHERE design_id ='$code' ");
        return $result->result_array();
    }

    public function fetch_embell_material($id,$code,$type) {
        $result = $this->db->query("SELECT * FROM material WHERE design_id ='$code' and type ='$type' ");
        return $result->result_array();
    }

    public function fetch_embell_material_($id,$code,$type) {
        $result = $this->db->query("SELECT * FROM material WHERE design_id ='$code' and type ='$type' ");
        return $result->result_array();
    }

    public function fetch_pack_material($id,$code,$type) {
        $result = $this->db->query("SELECT * FROM material WHERE design_id ='$code' and type ='$type' ");
        return $result->result_array();
    }

    public function fetch_pack_material_($id,$code,$type) {
        $result = $this->db->query("SELECT * FROM approve_material WHERE design_id ='$code' and type ='$type' ");
        return $result->result_array();
    }

    public function fetch_press($id,$code) {
        $result = $this->db->query("SELECT * FROM press_pack WHERE design_id ='$code' ");
        return $result->result_array();
    }

    public function fetch_stitch($id,$code) {
        $result = $this->db->query("SELECT * FROM stitch_accesseries WHERE design_id ='$code' ");
        return $result->result_array();
    }

    public function fetch_approve_emb($id,$code) {
        $result = $this->db->query("SELECT * FROM embroidory WHERE design_name ='$code' ");
        return $result->result_array();
    }

    public function fetch_approve_cut($id,$code) {
        $result = $this->db->query("SELECT * FROM cut_stitch WHERE design_name ='$code' ");
        return $result->result_array();
    }

    public function fetch_approve_embl($id,$code) {
        $result = $this->db->query("SELECT * FROM embelishment WHERE design_name ='$code' ");
        return $result->result_array();
    }

    public function fetch_approve_fab($id,$code) {
        $result = $this->db->query("SELECT * FROM fabric_dye WHERE design_name ='$code' ");
        return $result->result_array();
    }

    public function fetch_approve_press($id,$code) {
        $result = $this->db->query("SELECT * FROM press_pack WHERE design_name ='$code' ");
        return $result->result_array();
    }

    public function fetch_approve_stitch($id,$code) {
        $result = $this->db->query("SELECT * FROM stitch_accesseries WHERE design_name ='$code' ");
        return $result->result_array();
    }


    
    public function fetch_approve_emb_($id,$code) {
        $result = $this->db->query("SELECT * FROM approve_embroidory WHERE design_id ='$id' ");
        return $result->result_array();
    }

    public function fetch_approve_cut_($id,$code) {
        $result = $this->db->query("SELECT * FROM approve_cut_stitch WHERE design_id ='$id' ");
        return $result->result_array();
    }

    public function fetch_approve_embl_($id,$code) {
        $result = $this->db->query("SELECT * FROM approve_embelishment WHERE design_id ='$id' ");
        return $result->result_array();
    }

    public function fetch_approve_fab_($id,$code) {
        $result = $this->db->query("SELECT * FROM approve_fabric_dye WHERE design_id ='$id' ");
        return $result->result_array();
    }

    public function fetch_approve_press_($id,$code) {
        $result = $this->db->query("SELECT * FROM approve_press_pack WHERE design_id ='$id' ");
        return $result->result_array();
    }

    public function fetch_approve_stitch_($id,$code) {
        $result = $this->db->query("SELECT * FROM approve_stitch_accesseries WHERE design_id ='$id' ");
        return $result->result_array();
    }

    


    
    public function save($ordermain, $orderdetail, $vrnoa, $etype) {
        $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
        $result = $this->db->get('ordermain');
        $oid = "";
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $oid = $result['oid'];
            $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
            $this->db->update('ordermain', $ordermain);
            $this->db->where(array('oid' => $oid));
            $this->db->delete('orderdetail');
        } else {
            $ordermain['vrnoa'] = $vrnoa;
            $this->db->insert('ordermain', $ordermain);
            $oid = $this->db->insert_id();
        }
        foreach ($orderdetail as $detail) {
            $detail['oid'] = $oid;
            $this->db->insert('orderdetail', $detail);
        }
        return true;
    }
    public function fetchAllNotedBy() {
        $result = $this->db->query("SELECT DISTINCT noted_by FROM ordermain WHERE noted_by <> ''");
        return $result->result_array();
    }
    public function fetchDeliveryTerms() {
        $result = $this->db->query("SELECT DISTINCT delivery_term FROM ordermain order by delivery_term ");
        return $result->result_array();
    }
    public function fetchPaymentTerms() {
        $result = $this->db->query("SELECT DISTINCT payment_term FROM ordermain order by payment_term ");
        return $result->result_array();
    }
    public function fetchAllApprovedBy() {
        $result = $this->db->query("SELECT DISTINCT approved_by FROM ordermain WHERE approved_by <> ''");
        return $result->result_array();
    }
    public function fetchAllreferBy() {
        $result = $this->db->query("SELECT DISTINCT order_by FROM ordermain WHERE order_by <> ''");
        return $result->result_array();
    }
    public function fetchAllPayment() {
        $result = $this->db->query("SELECT DISTINCT payment FROM ordermain WHERE payment <> ''");
        return $result->result_array();
    }
    public function fetchAllDistinct($field) {
        $result = $this->db->query("SELECT DISTINCT $field FROM orderdetail WHERE $field <> '' ");
        return $result->result_array();
    }
    public function fetchAllDistinctMain($field) {
        $result = $this->db->query("SELECT DISTINCT $field FROM ordermain WHERE $field <> '' ");
        return $result->result_array();
    }
    public function fetchAllPreparedBy() {
        $result = $this->db->query("SELECT DISTINCT prepared_by FROM ordermain WHERE prepared_by <> ''");
        return $result->result_array();
    }
    public function fetchByColDetail($col) {
        $result = $this->db->query("SELECT DISTINCT $col FROM orderdetail where $col <>'';");
        return $result->result_array();
    }
    public function fetchArticleSummaryOrder($vrnoa, $etype, $company_id) {
        $sql = "SELECT  ifnull(i.short_code,'-')short_code,ifnull(sum(d.qty),0)qty
		FROM ordermain AS m 
		INNER JOIN orderdetail AS d ON m.oid = d.oid 
		
		INNER JOIN item i ON i.item_id = d.item_id 

		WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id  
		group by i.short_code";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchArticleSummaryColorOrder($vrnoa, $etype, $company_id) {
        $sql = "SELECT  ifnull(i.short_code,'-')short_code,IFNULL(c.name,'-')color_name,ifnull(sum(d.qty),0)qty
		FROM ordermain AS m 
		INNER JOIN orderdetail AS d ON m.oid = d.oid 
		
		INNER JOIN item i ON i.item_id = d.item_id 
		INNER JOIN color c ON c.color_id = i.color_id 
		WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id  
		group by i.short_code,c.name";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchRequisition($vrnoa, $etype, $company_id, $crit) {
        $sql = "SELECT  m.active,m.order_vrno,m.approved_by,m.freight,m.seal_no,m.eform_no,m.edate,d.qtyf,m.lc_no,m.lc_date,m.container_no,m.gross_weight,m.net_weight, sp.id as phase_id, sp.name as phase_name, sp2.id as phase_id2, sp2.name as phaseTo,comp.company_name,d.work_orderno as dwork_orderno,m.bilty_date, cur.cur_symbol, m.ordno as pono,m.workorderno as wono,m.inv_no, comp.company_name,comp.address comp_address,comp.contact as comp_contact,comp.strn as comp_strn,comp.ntn as comp_ntn,
		party.name as party_name,party.address as party_address,party.phone as party_phone,party.cnic as party_strn,party.ntn as party_ntn,
		m.etype2, d.netamount as netamount_d,d.gstrate,d.gstamount, ic.artcile_no as artcile_no_cus,ic.item_id as item_id_cus,ic.item_des as item_desc_cus,d.frate, m.currencey_id,cur.name as currencey_name,m.lprate as lprate_m, m.workorderno,d.gstp,d.gst,d.fedp,d.fed,d.dozen,d.bag,m.due_date,m.bilty_no,i.artcile_no,m.officer_id,m.received_by,m.currencey_id, comp.bank as bank_detail, comp.foot_note as foot_note,trans.name as transporter_name,i.artcile_no,d.label2,d.parchi,m.export_register_no,d.ctn_qty,d.dzn_qty, m.shippment_from,m.shippment_to,m.tax_status,m.cpono,m.delivery_term,m.dispatch_address,m.payment_term,m.approved_by,m.prepared_by,party.name party_name,party.address party_address,m.vrno, m.vrnoa,m.workorderno, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.lprate,d.lvendor,d.lstock, d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type,d.pick,d.reed,d.width,d.count,d.colors,d.brand,d.qlty,i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid, d.grossweight,ifnull(i.inventory_id,0)inventory_id,ifnull(i.cost_id,0)cost_id,ifnull(i.income_id,0)income_id,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time, ifnull(ar.short_code,'') item_name_article
		FROM ordermain AS m 
		INNER JOIN orderdetail AS d ON m.oid = d.oid 
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

		left join(
		select distinct short_code,vrnoa 
		from item 
		where ifnull(short_code,'')<>''
		order by short_code 
		) as ar ON ar.vrnoa = d.item_id_cus


		
		left join user  on user.uid=m.uid


		WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' $crit and m.company_id=$company_id  order by d.type,d.odid";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch($vrnoa, $etype, $company_id) {
        $sql = "SELECT  m.active,m.order_vrno,m.approved_by,m.freight,m.seal_no,m.eform_no,m.edate,d.qtyf,m.lc_no,m.lc_date,m.container_no,m.gross_weight,m.net_weight, sp.id as phase_id, sp.name as phase_name, sp2.id as phase_id2, sp2.name as phaseTo,comp.company_name,d.work_orderno as dwork_orderno,m.bilty_date, cur.cur_symbol, m.ordno as pono,m.workorderno as wono,m.inv_no, comp.company_name,comp.address comp_address,comp.contact as comp_contact,comp.strn as comp_strn,comp.ntn as comp_ntn,
		party.name as party_name,party.address as party_address,party.phone as party_phone,party.cnic as party_strn,party.ntn as party_ntn,
		m.etype2, d.netamount as netamount_d,d.gstrate,d.gstamount, ic.artcile_no as artcile_no_cus,ic.item_id as item_id_cus,ic.item_des as item_desc_cus,d.frate, m.currencey_id,cur.name as currencey_name,m.lprate as lprate_m, m.workorderno,d.gstp,d.gst,d.fedp,d.fed,d.dozen,d.bag,m.due_date,m.bilty_no,i.artcile_no,m.officer_id,m.received_by,m.currencey_id, comp.bank as bank_detail, comp.foot_note as foot_note,trans.name as transporter_name,i.artcile_no,d.label2,d.parchi,m.export_register_no,d.ctn_qty,d.dzn_qty, m.shippment_from,m.shippment_to,m.tax_status,m.cpono,m.delivery_term,m.dispatch_address,m.payment_term,m.approved_by,m.prepared_by,party.name party_name,party.address party_address,m.vrno, m.vrnoa,m.workorderno, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.lprate,d.lvendor,d.lstock, d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, ifnull(d.type,'')type,d.pick,d.reed,d.width,d.count,d.colors,d.brand,d.qlty,i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid, d.grossweight,ifnull(i.inventory_id,0)inventory_id,ifnull(i.cost_id,0)cost_id,ifnull(i.income_id,0)income_id,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time, ifnull(ar.short_code,'') item_name_article,ifnull(lp.rate,0) as item_last_prate  ,ifnull(d.parchi,'')parchi,ifnull(d.label,'')label,d.exchange_id
		FROM ordermain AS m 
		INNER JOIN orderdetail AS d ON m.oid = d.oid 
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

		left join(
		select distinct short_code,vrnoa 
		from item 
		where ifnull(short_code,'')<>''
		order by short_code 
		) as ar ON ar.vrnoa = d.item_id_cus

		left join(
		SELECT t1.item_id, t1.rate,t1.oid
		FROM orderdetail t1
		JOIN (
		SELECT item_id, MAX(odid) odid
		FROM orderdetail
		WHERE oid IN (
		SELECT oid
		FROM ordermain
		WHERE ETYPE='purchase')
		GROUP BY item_id) t2 ON t1.item_id = t2.item_id AND t1.odid = t2.odid
		GROUP BY t1.item_id,t1.rate,t1.oid
		) as lp on lp.item_id=i.item_id


		
		left join user  on user.uid=m.uid


		WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id  order by d.type,d.odid";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_($vrnoa, $etype, $company_id) {
        $sql = "SELECT  m.active,m.order_vrno,m.approved_by,m.freight,m.seal_no,m.eform_no,m.edate,d.qtyf,m.lc_no,m.lc_date,m.container_no,m.gross_weight,m.net_weight, sp.id as phase_id, sp.name as phase_name, sp2.id as phase_id2, sp2.name as phaseTo,comp.company_name,d.work_orderno as dwork_orderno,m.bilty_date, cur.cur_symbol, m.ordno as pono,m.workorderno as wono,m.inv_no, comp.company_name,comp.address comp_address,comp.contact as comp_contact,comp.strn as comp_strn,comp.ntn as comp_ntn,
		party.name as party_name,party.address as party_address,party.phone as party_phone,party.cnic as party_strn,party.ntn as party_ntn,
		m.etype2, d.netamount as netamount_d,d.gstrate,d.gstamount, ic.artcile_no as artcile_no_cus,ic.item_id as item_id_cus,ic.item_des as item_desc_cus,d.frate, m.currencey_id,cur.name as currencey_name,m.lprate as lprate_m, m.workorderno,d.gstp,d.gst,d.fedp,d.fed,d.dozen,d.bag,m.due_date,m.bilty_no,i.artcile_no,m.officer_id,m.received_by,m.currencey_id, comp.bank as bank_detail, comp.foot_note as foot_note,trans.name as transporter_name,i.artcile_no,d.label2,d.parchi,m.export_register_no,d.ctn_qty,d.dzn_qty, m.shippment_from,m.shippment_to,m.tax_status,m.cpono,m.delivery_term,m.dispatch_address,m.payment_term,m.approved_by,m.prepared_by,party.name party_name,party.address party_address,m.vrno, m.vrnoa,m.workorderno, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.lprate,d.lvendor,d.lstock, d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, ifnull(d.type,'')type,d.pick,d.reed,d.width,d.count,d.colors,d.brand,d.qlty,i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid, d.grossweight,ifnull(i.inventory_id,0)inventory_id,ifnull(i.cost_id,0)cost_id,ifnull(i.income_id,0)income_id,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time, ifnull(ar.short_code,'') item_name_article,ifnull(lp.rate,0) as item_last_prate  ,ifnull(d.parchi,'')parchi,ifnull(d.label,'')label
		FROM ordermain AS m 
		INNER JOIN orderdetail AS d ON m.oid = d.oid 
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

		left join(
		select distinct short_code,vrnoa 
		from item 
		where ifnull(short_code,'')<>''
		order by short_code 
		) as ar ON ar.vrnoa = d.item_id_cus

		left join(
		SELECT t1.item_id, t1.rate,t1.oid
		FROM orderdetail t1
		JOIN (
		SELECT item_id, MAX(odid) odid
		FROM orderdetail
		WHERE oid IN (
		SELECT oid
		FROM ordermain
		WHERE ETYPE='purchase')
		GROUP BY item_id) t2 ON t1.item_id = t2.item_id AND t1.odid = t2.odid
		GROUP BY t1.item_id,t1.rate,t1.oid
		) as lp on lp.item_id=i.item_id


		
		left join user  on user.uid=m.uid


		WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id  order by d.type,d.odid";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            $row = $result->row_array();
            $disc = $row['netamount_d'];
            return $disc;
        } else {
            return false;
        }
    }
    public function fetchContract($vrnoa, $etype, $company_id, $item_id) {
        if ($item_id != 0) {
            $item_id = " and i.item_id=$item_id ";
        } else {
            $item_id = "";
        }
        $sql = "SELECT round(ifnull(d.rate,0),2) as rate,if(i.uom='dozen', round(abs(d.qty)/12,2),round(abs(d.qty),2)) as qty ,round(ifnull(d.qtyf,0),3) as wastage,round(ifnull(d.rate,0),3) as rate ,round(ifnull(d.frate,0),3) as req_weight,d.item_id,m.party_id,m.workorderno,d.phase_id,sp2.id as phase_id2,ic.item_id as item_id_cus,d.bag,sp2.name as phase_name2,ic.item_des as item_desc_cus, i.item_des,ic.uom as uom_cus,i.uom
		FROM ordermain AS m 
		INNER JOIN orderdetail AS d ON m.oid = d.oid 
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
		WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id $item_id  order by d.type,d.odid";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchContractIssue($vrnoa, $etype, $company_id, $item_id) {
        if ($item_id != 0) {
            if ($etype = 'stitchingcontract') {
                $item_id = " and i.item_id=$item_id ";
            } else {
                $item_id = " and ic.item_id=$item_id ";
            }
        } else {
            $item_id = "";
        }
        $sql = "SELECT round(ifnull(d.rate,0),2) as rate,if(i.uom='dozen', round(abs(d.qty)/12,2),round(abs(d.qty),2)) as qty ,round(ifnull(d.qtyf,0),3) as wastage,round(ifnull(d.frate,0),3) as req_weight,ic.item_id as item_id_cus,i.item_id,m.party_id,m.workorderno,d.phase_id,d.phase_id2,d.bag,d.bundle
		FROM ordermain AS m 
		INNER JOIN orderdetail AS d ON m.oid = d.oid 
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
		WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id $item_id  order by d.type,d.odid";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchRemaining($vrnoa, $etype, $company_id) {
        $sql = "SELECT m.workorderno, d.type,m.freight,m.party_id_co,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no, m.bilty_date , m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.inv_no AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.officer_id, d.item_id, d.godown_id, ROUND(ifnull(sum(d.qty),0), 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight,ifnull(d.weight,0)-ifnull(stk.st_weight,0) as st_weight,ifnull(sum(d.qty),0)-ifnull(stk.st_qty,0) as st_qty,ifnull(stk.st_weight,0) as st_weight1,ifnull(stk.st_qty,0) as st_qty1,d.item_id_cus, ifnull(ar.short_code,'') item_name_article
		FROM ordermain AS m
		INNER JOIN orderdetail AS d ON m.oid = d.oid
		INNER JOIN item AS i ON i.item_id = d.item_id
		left JOIN department AS g ON g.did = d.godown_id
		
		left join (
		SELECT m.inv_no,d.job_id,d.item_id, ifnull(sum(d.weight),0) as st_weight, ifnull(sum(d.qty),0) as st_qty
		FROM stockmain AS m
		INNER JOIN stockdetail AS d ON m.stid = d.stid
		INNER JOIN item AS i ON i.item_id = d.item_id
		where m.etype='inward' and m.inv_no=$vrnoa and m.approved_by='$etype' and  m.company_id=$company_id
		group by  m.inv_no,d.job_id,d.item_id
		) as stk on stk.inv_no=m.vrnoa and stk.item_id=d.item_id and stk.job_id = d.item_id_cus

		left join(
		select distinct short_code,vrnoa 
		from item 
		where ifnull(short_code,'')<>''
		order by short_code 
		) as ar ON ar.vrnoa = d.item_id_cus

		WHERE  m.company_id = $company_id AND m.etype = '$etype' 
		and m.vrnoa=$vrnoa 
		group by d.item_id_cus,d.item_id,stk.st_qty
		having ifnull(sum(d.qty),0)-ifnull(stk.st_qty,0)>0 ";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchYarnPurchaseAccount($vrnoa, $etype, $company_id) {
        $sql = "SELECT p.pid,m.ordno,m.workorderno,p.date_time as datetime,Date(p.date) as date, p.dcno,party.account_id,party.name,p.description,p.debit,p.credit  from pledger p INNER JOIN party party on party.pid = p.pid LEFT JOIN ordermain m on m.vrnoa = p.dcno and m.etype = p.etype where p.etype = '" . $etype . "'  and p.dcno = $vrnoa and  p.company_id = $company_id";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_vrno($vrno, $etype, $company_id, $etype2) {
        $sql = "SELECT m.etype2, d.netamount as netamount_d,d.gstrate,d.gstamount, ic.artcile_no as artcile_no_cus,ic.item_id as item_id_cus,ic.item_des as item_desc_cus,d.frate, m.currencey_id,cur.name as currencey_name,m.lprate as lprate_m, m.workorderno,d.gstp,d.gst,d.fedp,d.fed,d.dozen,d.bag,m.due_date,m.bilty_no,i.artcile_no,m.officer_id,m.received_by,m.currencey_id, comp.bank as bank_detail, comp.foot_note as foot_note,trans.name as transporter_name,i.artcile_no,d.label2,d.parchi,m.export_register_no,d.ctn_qty,d.dzn_qty, m.shippment_from,m.shippment_to,m.tax_status,m.cpono,m.delivery_term,m.dispatch_address,m.payment_term,m.approved_by,m.prepared_by,party.name party_name,party.address party_address,m.vrno, m.vrnoa,m.workorderno, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.lprate,d.lvendor,d.lstock, d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type,d.pick,d.reed,d.width,d.count,d.colors,d.brand,d.qlty,i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid 
		FROM ordermain AS m 
		INNER JOIN orderdetail AS d ON m.oid = d.oid 
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
        $result = $this->db->query("select vrnoa from ordermain where etype = 'sale_order';");
        return $result->result_array();
    }
    
    public function chkexchange($vrnoa) {
        $result = $this->db->query("select oid from orderdetail where exchange_id = '$vrnoa'");
        if ($result->num_rows() > 0) {
            return 1;
        } else {
            return '';
        }
    }

    public function fetchPartsOrders($vrnoa, $etype, $company_id, $type, $etype2) {
        if ($type == 'spare_parts') {
            $result = $this->db->query("SELECT i.cost_price,party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,i.cost_price, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name, rcp.finisheditem_id AS finish_item, IFNULL(rcp.stid,0) recipeid
				FROM ordermain AS m
				INNER JOIN orderdetail AS d ON m.oid = d.oid
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
				FROM ordermain AS m
				INNER JOIN orderdetail AS d ON m.oid = d.oid
				INNER JOIN itemmain rcp ON rcp.finisheditem_id=d.item_id
				INNER JOIN itemdetail rcpd ON rcpd.stid=rcp.stid
				INNER JOIN item i ON i.item_id = rcpd.item_id
				WHERE m.vrnoa =$vrnoa AND m.etype = '" . $etype . "' AND m.company_id=$company_id AND rcpd.`etype`='" . $etype2 . "'
				group by i.item_id
				order by i.item_id");
        } else {
            $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name  FROM ordermain AS m INNER JOIN orderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id   and d.`type`='less'  order by d.type,d.odid");
        }
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchPartsOrderaLabour($vrnoa, $etype, $company_id, $etype2) {
        $result = $this->db->query("SELECT  d.qty*(rcpd.rate/ IFNULL(rcp.fqty,1)) as lrate,i.item_id,rcpd.qty rqty,rcp.fqty,d.qty dqty, d.qty *(rcpd.qty/ IFNULL(rcp.fqty,1)) AS qty, d.weight *(rcpd.weight/ IFNULL(rcp.fweight,1)) AS weight, i.item_des AS item_name, i.uom, rcp.finisheditem_id AS finish_item, IFNULL(rcp.stid,0) recipeid,sum(rcpd.rate) rate,rcpd.amount,rcpd.subphase_id,sb.name AS phase_name,rcpd.calculationmethod,sum(rcpd.rate2) rate2
			FROM ordermain AS m
			INNER JOIN orderdetail AS d ON m.oid = d.oid
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
        $result = $this->db->query("SELECT g.name, if(i.uom='dozen', round(IFNULL(SUM(d.qty)/12,0),0),round(IFNULL(SUM(d.qty),0),2)) AS stock, round(IFNULL(SUM(d.weight),0),2) AS weight ,i.item_des
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

    

    public function fetchStoreStocks($item_id, $etype, $company_id, $vrdate) {
        $result = $this->db->query("SELECT g.name, if(i.uom='dozen', round(IFNULL(SUM(d.qty)/12,0),0),round(IFNULL(SUM(d.qty),0),2)) AS stock, round(IFNULL(SUM(d.weight),0),2) AS weight ,i.item_des
			FROM stockdetail d
			INNER JOIN stockmain m ON m.stid = d.stid
			INNER JOIN department g ON g.did= d.godown_id
			INNER JOIN item i ON d.item_id= i.item_id
			WHERE d.item_id = $item_id AND m.company_id = $company_id and m.vrdate<='" . $vrdate . "' AND  g.did =1
			group by g.name ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function fetchItemlpRate($item_id, $etype, $company_id) {
        $result = $this->db->query("SELECT  rate as lprate from orderdetail where item_id = 
			$item_id and oid in (select oid from ordermain where etype='" . $etype . "' and company_id = $company_id) order by oid desc limit 1");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchLfiveStocks($item_id, $etype, $company_id) {
        $result = $this->db->query("SELECT round(d.qty,2) as stock,d.weight as weight,g.name as name 
			from orderdetail d 
			INNER JOIN ordermain m on m.oid = d.oid  INNER JOIN department g on d.godown_id = g.did   where item_id = $item_id and etype='" . $etype . "' and m.company_id=$company_id");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function fetch_Stocks($item_id, $etype, $company_id) {      
        
        $result = $this->db->query("SELECT item_id FROM item where item_des like '%$item_id' ");
        $row = $result->row_array();
        $itemId = $row['item_id'];

        $result1 = $this->db->query("SELECT g.name, if(i.uom='dozen', round(IFNULL(SUM(d.qty)/12,0),0),round(IFNULL(SUM(d.qty),0),0)) AS stock
			FROM stockdetail d
			INNER JOIN stockmain m ON m.stid = d.stid
			INNER JOIN department g ON g.did= d.godown_id
			INNER JOIN item i ON d.item_id= i.item_id
			WHERE d.item_id = $itemId AND m.company_id = $company_id and m.vrdate<='2099-09-09 00:00:00' 
			group by g.name ");
        if ($result1->num_rows() > 0) {
            return $result1->result_array();
        } else {
            return false;
        }
    }

    
    public function chkqty($item_id,$deptfrom_id,$etype,$company_id,$vrdate){
        $result = $this->db->query("SELECT g.name, if(i.uom='dozen', round(IFNULL(SUM(d.qty)/12,0),0),round(IFNULL(SUM(d.qty),0),2)) AS stock
        FROM stockdetail d
        INNER JOIN stockmain m ON m.stid = d.stid
        INNER JOIN department g ON g.did= d.godown_id
        INNER JOIN item i ON d.item_id= i.item_id
        WHERE d.item_id = $item_id AND m.company_id = $company_id and m.vrdate<='" . $vrdate . "' and g.did='$deptfrom_id' 
        group by g.name ");
    if ($result->num_rows() > 0) {
        $row = $result->row_array();
        $stock = $row['stock'];
       return $stock;
    } else {
        return 0;
    }
    }
    public function fetchLfiveRates($item_id, $etype, $company_id) {
        $result = $this->db->query("SELECT qty,rate as lprate from orderdetail where item_id = $item_id
			and oid in (select vrdate,vrnoa,oid from ordermain m where etype='" . $etype . "' and company_id=$company_id ) order by oid desc limit 5");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function last_5_srate($item_id, $etype, $company_id, $crit) {
        $result = $this->db->query("SELECT party.name as party_name, m.vrnoa, date_format(m.vrdate,'%d/%m/%y') vrdate, ROUND(d.qty, 2) qty,d.rate as lprate, ROUND(d.weight, 2) as weight
			FROM ordermain AS m
			INNER JOIN orderdetail AS d ON m.oid = d.oid
			INNER JOIN item i ON i.item_id = d.item_id
			INNER JOIN department dep ON dep.did = d.godown_id
			left JOIN party ON party.pid=m.party_id
			WHERE   m.etype in('" . $etype . "') and m.company_id=$company_id and d.item_id=$item_id $crit
			ORDER BY m.vrdate  desc
			limit 5");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_order_stock($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) tot_qty, ROUND(d.weight, 2) tot_weight, ROUND(stk.qty, 2) qty, ROUND(stk.weight, 2) weight,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid FROM ordermain AS m INNER JOIN orderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id left join recipemain rcp on rcp.item_id=d.item_id
			inner join(SELECT ifnull(sum(d.qty),0) as qty,ifnull(sum(d.weight),0) as weight,i.item_id,i.item_des,d.type  FROM ordermain AS m INNER JOIN orderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id left join recipemain rcp on rcp.item_id=d.item_id WHERE m.ordno =$vrnoa and  m.etype in('sale','sale_order') and m.company_id=$company_id  group by i.item_id,d.`type`) as stk on stk.item_id=d.item_id and stk.`type`=d.`type`
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
            $result = $this->db->query("SELECT i.item_id,rcpd.qty rqty ,rcp.fqty,d.qty dqty, d.qty *(rcpd.qty/ifnull(rcp.fqty,1)) as qty, d.weight *(rcpd.weight/ifnull(rcp.fweight,1)) as weight, i.item_des AS item_name, i.uom, rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid FROM ordermain AS m
				INNER JOIN orderdetail AS d ON m.oid = d.oid  
				inner join recipemain rcp on rcp.item_id=d.item_id 
				inner join recipedetail rcpd on rcpd.rid=rcp.rid 
				INNER JOIN item i ON i.item_id = rcpd.item_id 
				WHERE m.vrnoa =$vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id and d.`type`='add' 
				");
        } else if ($type == 'spare_parts') {
            $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid FROM ordermain AS m INNER JOIN orderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id left join recipemain rcp on rcp.item_id=d.item_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id and i.item_id not in (select item_id from recipemain)  and d.`type`='add'  order by d.type,d.odid");
        } else {
            $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name  FROM ordermain AS m INNER JOIN orderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id   and d.`type`='less'  order by d.type,d.odid");
        }
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_loading_Stock($order_no, $company_id) {
        $result = $this->db->query("select d.type,i.item_id,i.item_des item_name,ifnull(sum(d.qty),0) qty,ifnull(sum(d.weight),0) weight, ifnull(sd.stqty,0) stqty,ifnull(sd.stweight,0) stweight from orderdetail d
			inner join item i on i.item_id=d.item_id
			inner join ordermain m on m.oid=d.oid 
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
        $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name FROM ordermain AS m INNER JOIN orderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id  order by d.type,d.odid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchPurchaseOrder($vrnoa, $etype) {
        $result = $this->db->query("SELECT m.vrno, m.vrnoa, m.vrdate, m.party_id, m.remarks, m.payment, m.order_by, m.noted_by, m.shade_card, m.approved_by, m.etype, ROUND(m.amount, 2) amount, ROUND(m.discountp, 2) discountp, ROUND(m.discount, 2) discount, ROUND(m.namount, 2) namount, d.item_id, d.godown_id, ROUND(d.qty, 2) item_qty, ROUND(d.rate, 2) item_rate, ROUND(d.amount, 2) item_amount, ROUND(d.gstrate, 2) item_gstrate, ROUND(d.gstamount, 2) item_gstamount, ROUND(d.netamount, 2) item_netamount, i.item_des item_name, ROUND(d.weight, 2) weight, d.type status FROM ordermain AS m INNER JOIN orderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id WHERE m.vrnoa = $vrnoa AND etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchInwardGatePass($vrnoa, $etype) {
        $result = $this->db->query("SELECT m.vrno, m.vrnoa, m.vrdate, m.party_id, m.remarks, m.payment, m.order_by, m.noted_by, m.approved_by, m.etype, m.party_id_co, d.item_id, d.godown_id, ROUND(d.qty) qty, d.uom, dep.name AS 'dept_name', i.description AS 'item_name' FROM ordermain m INNER JOIN orderdetail d ON m.oid = d.oid LEFT JOIN department dep ON dep.did = d.godown_id INNER JOIN item i ON i.item_id = d.item_id WHERE m.vrnoa = $vrnoa AND etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function delete($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT stid from stockmain WHERE vrnoa = '$vrnoa'");
        $row = $result->row_array();
        $stid = $row['stid'];
        
        $result = $this->db->query("delete from stockdetail WHERE stid = $stid");
        $this->db->where(array('etype' => $etype, 'dcno' => $vrnoa, 'company_id' => $company_id));
        $this->db->delete('pledger');
        $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa, 'company_id' => $company_id));
        $result = $this->db->get('ordermain');
       

        if ($result->num_rows() == 0) {
            return false;
        } else {
            $result = $result->row_array();
            $oid = $result['oid'];
            $this->db->where(array('oid' => $oid));
            $this->db->delete('orderdetail');
            $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa));
            $this->db->delete('ordermain');
            return true;
        }
    }
    public function fetchOrders($from, $to, $type) {
        if ($type == 'new') {
            $result = $this->db->query("SELECT oid,ordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, ordermain.remarks FROM ordermain INNER JOIN party ON party.pid = ordermain.party_id WHERE STATUS = 'new' AND ordermain.etype = 'sale_order'");
            return $result->result_array();
        } else if ($type == 'running') {
            $result = $this->db->query("SELECT oid,ordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, ordermain.remarks FROM ordermain INNER JOIN party ON party.pid = ordermain.party_id WHERE STATUS = 'running' AND vrnoa not in (select ordno from ordermain where etype='order_parts' ) AND ordermain.etype = 'sale_order' order by ordermain.vrnoa");
            return $result->result_array();
        } else if ($type == 'running_loading') {
            $result = $this->db->query("SELECT oid,ordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, ordermain.remarks FROM ordermain INNER JOIN party ON party.pid = ordermain.party_id WHERE STATUS = 'running' AND vrnoa  in (select ordno from ordermain where etype='order_parts' ) AND ordermain.etype = 'sale_order' order by ordermain.vrnoa");
            return $result->result_array();
        } else if ($type == 'sale') {
            $result = $this->db->query("SELECT oid,ordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, ordermain.remarks FROM ordermain INNER JOIN party ON party.pid = ordermain.party_id WHERE vrnoa not in (select ordno from ordermain where etype='sale' ) AND ordermain.etype = 'sale_order' order by ordermain.vrnoa");
            return $result->result_array();
        } else {
            $result = $this->db->query("SELECT oid,ordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, ordermain.remarks FROM ordermain INNER JOIN party ON party.pid = ordermain.party_id WHERE ordermain.etype = 'sale_order' order by ordermain.vrnoa");
            return $result->result_array();
        }
    }
    public function Loading_Stock($company_id, $order_no) {
        $result = $this->db->query("select type,item_id,ifnull(sum(qty),0) qty,ifnull(sum(weight),0) weight from orderdetail where oid in (select oid from ordermain where etype in('order_parts','order_loading') and ordno=$order_no ) group by type,item_id");
        return $result->result_array();
    }
    public function updateOrderStatus($oids) {
        foreach ($oids as $oid) {
            $this->db->query("UPDATE ordermain SET status = 'running' WHERE etype = 'sale_order' AND oid = $oid");
        }
        return true;
    }

    public function update_job($id,$receive,$balance,$status,$date) {

        $this->db->query("UPDATE job SET finish_date = '$date',status='$status',receive='$receive',balance='$balance' WHERE id = '$id' ");
        return true;
    }


    public function igpStatus($vrnoa, $biltyNo, $etype, $companyId, $voucherTypeHidden) {
        $query = "SELECT * FROM ordermain
		WHERE etype = '" . $etype . "' and vrnoa <> '" . $vrnoa . "' and order_vrno = '" . $biltyNo . "' and company_id = " . $companyId . " ";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function igpStatusOnNew($vrnoa, $biltyNo, $etype, $companyId, $voucherTypeHidden) {
        $query = "SELECT * FROM ordermain
		WHERE etype = '" . $etype . "' and order_vrno = '" . $biltyNo . "' and company_id = " . $companyId . " ";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}