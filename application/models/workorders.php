<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Workorders extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxVrno($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrno) vrno FROM workordermain WHERE etype = '" . $etype . "' and company_id=$company_id AND DATE(vrdate) = DATE(NOW())");
        $row = $result->row_array();
        $maxId = $row['vrno'];
        return $maxId;
    }
    public function Validate_Order($etype, $company_id, $order_no, $status) {
        $result = $this->db->query("SELECT vrnoa FROM workordermain WHERE etype = '" . $etype . "' and company_id=$company_id AND vrnoa =$order_no  and status='" . $status . "' and vrnoa not in (select ordno from workordermain where ordno=$order_no and etype='order_parts') ");
        $row = $result->row_array();
        if ($result->num_rows() > 0) {
            $chk_flag = $row['vrnoa'];
            return $chk_flag;
        } else {
            return false;
        }
    }
    public function Validate_Order_Loading($etype, $company_id, $order_no, $status) {
        $result = $this->db->query("SELECT vrnoa FROM workordermain WHERE etype = 'order_parts' and company_id=$company_id AND ordno =$order_no  ");
        $row = $result->row_array();
        if ($result->num_rows() > 0) {
            $chk_flag = $row['vrnoa'];
            return $chk_flag;
        } else {
            return false;
        }
    }
    public function fetchOrderReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT  $field as voucher,$name,dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,orderdetail.amount,ordermain.vrdate, ordermain.remarks, ordermain.vrnoa, ordermain.remarks,  abs(orderdetail.qty) qty, orderdetail.weight, orderdetail.rate, orderdetail.netamount, item.item_des as 'item_des',item.uom FROM workordermain ordermain INNER JOIN workorderdetail orderdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN department dept  ON orderdetail.godown_id = dept.did  INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN user user ON user.uid = ordermain.uid WHERE  ordermain.vrdate between '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id AND ordermain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT  $field as voucher,$name,dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,date(ordermain.vrdate) as DATE, orderdetail.amount, date(ordermain.VRDATE) VRDATE, ordermain.vrnoa, ABS(round(SUM(orderdetail.qty))) qty, round(SUM(orderdetail.weight)) weight, round(SUM(orderdetail.rate)) rate, round(sum(orderdetail.netamount)) netamount, ordermain.remarks FROM workordermain ordermain INNER JOIN workorderdetail orderdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN department dept  ON orderdetail.godown_id = dept.did  INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN user user ON user.uid = ordermain.uid WHERE  ordermain.vrdate between '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id=$company_id AND ordermain.etype='$etype' $crit group by $groupBy order by $orderBy");
            return $query->result_array();
        }
    }
    public function fetchOrderReportDataParts($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT  $field as voucher,$name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,ordermain.vrdate,date(ordermain.vrdate) as date, ordermain.remarks, ordermain.vrnoa, ordermain.remarks, abs(orderdetail.qty) qty, orderdetail.weight, orderdetail.netamount, item.item_des as 'item_des',item.uom FROM workordermain ordermain INNER JOIN workorderdetail orderdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN department dept  ON orderdetail.godown_id = dept.did INNER JOIN user user ON user.uid = ordermain.uid  WHERE  ordermain.vrdate between '" . $startDate . "' and '" . $endDate . "' and ordermain.company_id=$company_id and ordermain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT  $field as voucher,$name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,date(ordermain.vrdate) as date, date(ordermain.vrdate) vrdate, ordermain.vrnoa, ABS(round(SUM(orderdetail.qty))) qty, round(SUM(orderdetail.weight)) weight, round(SUM(orderdetail.RATE)) RATE, round(sum(orderdetail.netamount)) netamount, ordermain.remarks FROM workordermain ordermain INNER JOIN workorderdetail orderdetail ON ordermain.oid = orderdetail.oid INNER JOIN party party ON ordermain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON orderdetail.item_id = item.item_id INNER JOIN user user ON user.uid = ordermain.uid  INNER JOIN department dept  ON orderdetail.godown_id = dept.did WHERE  ordermain.VRDATE between '" . $startDate . "' and '" . $endDate . "' and ordermain.company_id=$company_id and ordermain.etype='$etype' $crit group by $groupBy order by $orderBy");
            return $query->result_array();
        }
    }
    public function getMaxVrnoa($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM workordermain WHERE etype = '" . $etype . "' and company_id=$company_id");
        $row = $result->row_array();
        $maxId = $row['vrnoa'];
        return $maxId;
    }
    public function save($ordermain, $orderdetail, $vrnoa, $etype) {
        $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
        $result = $this->db->get('workordermain');
        $oid = "";
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $oid = $result['oid'];
            $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
            $this->db->update('workordermain', $ordermain);
            $this->db->where(array('oid' => $oid));
            $this->db->delete('workorderdetail');
        } else {
            $this->db->insert('workordermain', $ordermain);
            $oid = $this->db->insert_id();
        }
        foreach ($orderdetail as $detail) {
            $detail['oid'] = $oid;
            $this->db->insert('workorderdetail', $detail);
        }
        return true;
    }
    public function fetchWorkOrderReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT  $field as voucher,$name,col.name as color_name,workorderdetail.lstock, workorderdetail.rate,workorderdetail.amount , dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,workordermain.vrdate,date(workordermain.vrdate) as date, workordermain.remarks, workordermain.vrnoa, workordermain.remarks, abs(workorderdetail.qty) qty, workorderdetail.weight, workorderdetail.netamount, item.item_des as 'item_des',item.uom FROM workordermain workordermain INNER JOIN workorderdetail workorderdetail ON workordermain.oid = workorderdetail.oid  INNER JOIN party party ON workordermain.party_id = party.pid    INNER JOIN color col ON col.id =  workorderdetail.color_id           INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON workorderdetail.item_id = item.item_id LEFT JOIN department dept  ON workorderdetail.godown_id = dept.did INNER JOIN user user ON user.uid = workordermain.uid  WHERE  workordermain.vrdate between '" . $startDate . "' and '" . $endDate . "' and workordermain.company_id=$company_id and workordermain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT  $field as voucher,$name,col.name as color_name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,date(workordermain.vrdate) as date, date(workordermain.vrdate) vrdate, workordermain.vrnoa, ABS(round(SUM(workorderdetail.qty))) qty,round(SUM(workorderdetail.rate)) rate,round(SUM(workorderdetail.amount)) amount,round(SUM(workorderdetail.weight)) weight,round(SUM(workorderdetail.lstock)) lstock,workorderdetail.lstock round(SUM(workorderdetail.RATE)) RATE, round(sum(workorderdetail.netamount)) netamount, workordermain.remarks FROM workordermain workordermain INNER JOIN workorderdetail workorderdetail ON workordermain.oid = workorderdetail.oid INNER JOIN color col ON col.id =  workorderdetail.color_id  INNER JOIN party party ON workordermain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3 INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON workorderdetail.item_id = item.item_id INNER JOIN user user ON user.uid = workordermain.uid  LEFT JOIN department dept  ON workorderdetail.godown_id = dept.did WHERE  workordermain.VRDATE between '" . $startDate . "' and '" . $endDate . "' and workordermain.company_id=$company_id and workordermain.etype='$etype' $crit group by $groupBy order by $orderBy");
            return $query->result_array();
        }
    }
    public function fetchAllNotedBy() {
        $result = $this->db->query("SELECT DISTINCT noted_by FROM workordermain WHERE noted_by <> ''");
        return $result->result_array();
    }
    public function fetchAllApprovedBy() {
        $result = $this->db->query("SELECT DISTINCT approved_by FROM workordermain WHERE approved_by <> ''");
        return $result->result_array();
    }
    public function fetchAllreferBy() {
        $result = $this->db->query("SELECT DISTINCT order_by FROM workordermain WHERE order_by <> ''");
        return $result->result_array();
    }
    public function fetchAllPayment() {
        $result = $this->db->query("SELECT DISTINCT payment FROM workordermain WHERE payment <> ''");
        return $result->result_array();
    }
    public function fetch($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa,m.workorderNo, m.ordno, m.transporter_id,m.deliveryCharges,m.discount,m.discp,m.tax,m.taxpercent,m.expense, m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id,  d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.lprate,d.lvendor,d.lstock, d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom,d.color_id , rcp.item_id AS finish_item, IFNULL(rcp.rid,0) recipeid,color_tbl.name as color_name FROM workordermain AS m INNER JOIN workorderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN color color_tbl on color_tbl.id = d.color_id LEFT JOIN party party ON party.pid=m.party_id LEFT JOIN recipemain rcp ON rcp.item_id=d.item_id WHERE m.vrnoa = $vrnoa AND m.etype = 'work_order' AND m.company_id= $company_id ORDER BY d.type,d.odid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchItemStocks($item_id) {
        $result = $this->db->query("SELECT ifnull(sum(qty),0) as stock,ifnull(sum(weight),0) as weight from stockdetail where item_id = $item_id");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchItemlpRate($item_id) {
        $result = $this->db->query("SELECT  rate as lprate from workorderdetail where item_id = $item_id and oid in (select oid from workordermain where etype='purchase') order by oid desc limit 1");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchLfiveStocks($item_id) {
        $result = $this->db->query("SELECT d.qty as stock,d.weight as weight,g.name as name from stockdetail d INNER JOIN department g on d.godown_id = g.did   where item_id = $item_id");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchLfiveRates($item_id) {
        $result = $this->db->query("SELECT  rate as lprate from workorderdetail where item_id = $item_id and oid in (select oid from workordermain where etype='work_order') order by oid desc limit 5");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function last_5_srate($pid, $item_id, $company_id) {
        $result = $this->db->query("SELECT  m.vrnoa, DATE(m.vrdate) vrdate, ROUND(d.qty, 2) qty,d.rate, ROUND(d.weight, 2) as weight
									FROM workordermain AS m
									INNER JOIN workorderdetail AS d ON m.oid = d.oid
									INNER JOIN item i ON i.item_id = d.item_id
									INNER JOIN department dep ON dep.did = d.godown_id
									INNER JOIN party party ON party.pid=m.party_id
									WHERE m.party_id = $pid AND m.etype = 'sale' AND m.company_id=$company_id and i.item_id=$item_id
									ORDER BY m.vrdate  desc
									limit 5");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_order_stock($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.ordno, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) tot_qty, ROUND(d.weight, 2) tot_weight, ROUND(stk.qty, 2) qty, ROUND(stk.weight, 2) weight,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid FROM workordermain AS m INNER JOIN workorderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id left join recipemain rcp on rcp.item_id=d.item_id
		inner join(SELECT ifnull(sum(d.qty),0) as qty,ifnull(sum(d.weight),0) as weight,i.item_id,i.item_des,d.type  FROM workordermain AS m INNER JOIN workorderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id left join recipemain rcp on rcp.item_id=d.item_id WHERE m.ordno =$vrnoa and  m.etype in('sale','sale_order') and m.company_id=$company_id  group by i.item_id,d.`type`) as stk on stk.item_id=d.item_id and stk.`type`=d.`type`
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
            $result = $this->db->query("SELECT i.item_id,rcpd.qty rqty ,rcp.fqty,d.qty dqty, d.qty *(rcpd.qty/ifnull(rcp.fqty,1)) as qty, d.weight *(rcpd.weight/ifnull(rcp.fweight,1)) as weight, i.item_des AS item_name, i.uom, rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid FROM workordermain AS m
			INNER JOIN workorderdetail AS d ON m.oid = d.oid  
			inner join recipemain rcp on rcp.item_id=d.item_id 
			inner join recipedetail rcpd on rcpd.rid=rcp.rid 
			INNER JOIN item i ON i.item_id = rcpd.item_id 
			WHERE m.vrnoa =$vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id and d.`type`='add'   
			");
        } else if ($type == 'spare_parts') {
            $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name , rcp.item_id as finish_item,ifnull(rcp.rid,0) recipeid FROM workordermain AS m INNER JOIN workorderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id left join recipemain rcp on rcp.item_id=d.item_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id and i.item_id not in (select item_id from recipemain)  and d.`type`='add'  order by d.type,d.odid");
        } else {
            $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name  FROM workordermain AS m INNER JOIN workorderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id   and d.`type`='less'  order by d.type,d.odid");
        }
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_loading_Stock($order_no, $company_id) {
        $result = $this->db->query("select d.type,i.item_id,i.item_des item_name,ifnull(sum(d.qty),0) qty,ifnull(sum(d.weight),0) weight, ifnull(sd.stqty,0) stqty,ifnull(sd.stweight,0) stweight from workorderdetail d
			inner join item i on i.item_id=d.item_id
			inner join workordermain m on m.oid=d.oid 
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
        $result = $this->db->query("SELECT party.name party_name,m.vrno, m.vrnoa, m.transporter_id,m.discount,m.discp,m.tax,m.taxpercent,m.expense,m.exppercent,m.paid, m.uid, m.party_id, DATE(m.vrdate) vrdate, m.remarks, m.etype, m.noted_by, m.namount, m.pub_add, d.item_id, d.godown_id, ROUND(d.qty, 2) qty,d.rate,d.amount, ROUND(d.bundle, 2) bundle, ROUND(d.weight, 2) weight, d.type, i.item_des AS item_name, i.uom, dep.name AS dept_name FROM workordermain AS m INNER JOIN workorderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN party party on party.pid=m.party_id WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' and m.company_id=$company_id  order by d.type,d.odid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchPurchaseOrder($vrnoa, $etype) {
        $result = $this->db->query("SELECT m.vrno, m.vrnoa, m.vrdate, m.party_id, m.remarks, m.payment, m.order_by, m.noted_by, m.shade_card, m.approved_by, m.etype, ROUND(m.amount, 2) amount, ROUND(m.discountp, 2) discountp, ROUND(m.discount, 2) discount, ROUND(m.namount, 2) namount, d.item_id, d.godown_id, ROUND(d.qty, 2) item_qty, ROUND(d.rate, 2) item_rate, ROUND(d.amount, 2) item_amount, ROUND(d.gstrate, 2) item_gstrate, ROUND(d.gstamount, 2) item_gstamount, ROUND(d.netamount, 2) item_netamount, i.item_des item_name, ROUND(d.weight, 2) weight, d.type status FROM workordermain AS m INNER JOIN workorderdetail AS d ON m.oid = d.oid INNER JOIN item i ON i.item_id = d.item_id WHERE m.vrnoa = $vrnoa AND etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchInwardGatePass($vrnoa, $etype) {
        $result = $this->db->query("SELECT m.vrno, m.vrnoa, m.vrdate, m.party_id, m.remarks, m.payment, m.order_by, m.noted_by, m.approved_by, m.etype, m.party_id_co, d.item_id, d.godown_id, ROUND(d.qty) qty, d.uom, dep.name AS 'dept_name', i.description AS 'item_name' FROM workordermain m INNER JOIN workorderdetail d ON m.oid = d.oid LEFT JOIN department dep ON dep.did = d.godown_id INNER JOIN item i ON i.item_id = d.item_id WHERE m.vrnoa = $vrnoa AND etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function delete($vrnoa, $etype, $company_id) {
        if ($etype == 'sale') {
            $this->db->where(array('etype' => $etype, 'dcno' => $vrnoa, 'company_id' => $company_id));
            $result = $this->db->delete('pledger');
        }
        $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa, 'company_id' => $company_id));
        $result = $this->db->get('workordermain');
        if ($result->num_rows() == 0) {
            return false;
        } else {
            $result = $result->row_array();
            $oid = $result['oid'];
            $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa));
            $this->db->delete('workordermain');
            $this->db->where(array('oid' => $oid));
            $this->db->delete('workorderdetail');
            return true;
        }
    }
    public function fetchOrders($from, $to, $type) {
        if ($type == 'new') {
            $result = $this->db->query("SELECT oid,workordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, workordermain.remarks FROM workordermain INNER JOIN party ON party.pid = workordermain.party_id WHERE STATUS = 'new' AND workordermain.etype = 'sale_order'");
            return $result->result_array();
        } else if ($type == 'running') {
            $result = $this->db->query("SELECT oid,workordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, workordermain.remarks FROM workordermain INNER JOIN party ON party.pid = workordermain.party_id WHERE STATUS = 'running' AND vrnoa not in (select ordno from workordermain where etype='order_parts' ) AND workordermain.etype = 'sale_order' order by workordermain.vrnoa");
            return $result->result_array();
        } else if ($type == 'running_loading') {
            $result = $this->db->query("SELECT oid,workordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, workordermain.remarks FROM workordermain INNER JOIN party ON party.pid = workordermain.party_id WHERE STATUS = 'running' AND vrnoa  in (select ordno from workordermain where etype='order_parts' ) AND workordermain.etype = 'sale_order' order by workordermain.vrnoa");
            return $result->result_array();
        } else if ($type == 'sale') {
            $result = $this->db->query("SELECT oid,workordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, workordermain.remarks FROM workordermain INNER JOIN party ON party.pid = workordermain.party_id WHERE vrnoa not in (select ordno from workordermain where etype='sale' ) AND workordermain.etype = 'sale_order' order by workordermain.vrnoa");
            return $result->result_array();
        } else {
            $result = $this->db->query("SELECT oid,workordermain.status, vrnoa, date(vrdate) vrdate, party.name, city, party.cityarea, workordermain.remarks FROM workordermain INNER JOIN party ON party.pid = workordermain.party_id WHERE workordermain.etype = 'sale_order' order by workordermain.vrnoa");
            return $result->result_array();
        }
    }
    public function Loading_Stock($company_id, $order_no) {
        $result = $this->db->query("select type,item_id,ifnull(sum(qty),0) qty,ifnull(sum(weight),0) weight from workorderdetail where oid in (select oid from workordermain where etype in('order_parts','order_loading') and ordno=$order_no ) group by type,item_id");
        return $result->result_array();
    }
    public function updateOrderStatus($oids) {
        foreach ($oids as $oid) {
            $this->db->query("UPDATE workordermain SET status = 'running' WHERE etype = 'sale_order' AND oid = $oid");
        }
        return true;
    }
}