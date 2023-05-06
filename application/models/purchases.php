<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchases extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function fetchVendorBillData($from, $to, $reptType, $party_id, $company_id, $crit) {
        $query = "";
        $query = "SELECT m.vrnoa,m.workorder,m.etype,date_format(m.vrdate,'%d/%m/%y')vrdate,d.godown_id,d.item_id,i.item_des,IFNULL(d.weight,0) - IFNULL(bill.weight,0) weight,IFNULL(d.qty,0)-IFNULL(bill.qty,0)qty ,IFNULL(d.rate,0)rate,ROUND((IFNULL(d.qty,0)-IFNULL(bill.qty,0))*IFNULL(d.rate,0),0) amount,ifnull(i.uom,'')uom,ifnull(i.inventory_id,0)inventory_id
		FROM stockmain m 
		INNER JOIN stockdetail d ON m.stid=d.stid
		INNER JOIN item i ON i.item_id=d.item_id
		LEFT JOIN(
		SELECT d.type,d.parchi,d.godown_id,d.item_id, IFNULL(SUM(d.qty),0)qty,IFNULL(SUM(d.weight),0)weight
		FROM ordermain m 
		INNER JOIN orderdetail d ON d.oid=m.oid
		WHERE m.etype='vb' and m.party_id=$party_id
		GROUP BY d.type,d.parchi,d.item_id
		) bill ON bill.type=m.etype AND bill.parchi=m.vrnoa  AND bill.item_id=d.item_id
		WHERE m.etype IN ('vst','rfv') AND m.vrdate BETWEEN '$from' AND '$to' and m.party_id=$party_id $crit
		and IFNULL(d.qty,0)-IFNULL(bill.qty,0)>0
		GROUP BY m.vrnoa,d.item_id ";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function receive($vrnoa,$receive,$qty,$balance)
    {
        $result = $this->db->query("SELECT  stid from stockmain where vrnoa ='$vrnoa' AND etype ='stocktransfer'");
        $row = $result->row_array();
        $stid = $row['stid'];
        $query = $this->db->query("update stockdetail set qty = $receive where stid = $stid and receive =$qty");
        $query = $this->db->query("update stockdetail set ptype ='posted' where stid = $stid and receive =$qty");
        $query = $this->db->query("update stockdetail set balance ='$balance' where stid = $stid and receive =$qty");
        $query = $this->db->query("update stockdetail set bag ='$receive' where stid = $stid and receive =$qty");
    }


    public function fetchVendorLedgerOpening($from, $to, $company_id, $crit) {
        $q = "SELECT  IFNULL(sum(d.qty),0) AS qty, ifnull(sum(d.weight),0)weight,d.item_id,d.godown_id2
		FROM stockmain m
		INNER JOIN vendorstock d ON m.stid = d.stid
		INNER JOIN item i ON i.item_id = d.item_id
		LEFT JOIN department dep ON dep.did = d.godown_id
		LEFT JOIN party AS party ON party.pid=d.godown_id2

		WHERE  DATE(m.vrdate) < '$from' $crit
		";
        $query = $this->db->query($q);
        return $query->result_array();
    }


    public function fetchVendorLedgerReport($from, $to, $company_id, $crit) {
        $result = $this->db->query("SELECT IFNULL(d.rate,0)rate,IFNULL(m.workorder,'')workorder,i.uom,i.item_des,d.rate,party.name AS party_name, m.vrnoa, m.etype, DATE(m.vrdate) date, i.description, m.remarks, dep.name,  IFNULL(d.qty,0) AS qty, ifnull(d.weight,0)weight,ifnull(d.amount,0)netamount

			FROM stockmain m
			INNER JOIN vendorstock d ON m.stid = d.stid
			INNER JOIN item i ON i.item_id = d.item_id
			LEFT JOIN department dep ON dep.did = d.godown_id
			LEFT JOIN party AS party ON party.pid=d.godown_id2



			WHERE  DATE(m.vrdate) >= '$from' AND DATE(m.vrdate) <= '$to' $crit
			ORDER BY m.vrdate, d.id");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }


    public function fetchPendingInward($endDate, $company_id, $crit, $etype, $etype2, $report_type) {
        $having_crit = "";
        if ($report_type == 'pending') {
            $having_crit = "having ifnull(sum(d.qty),0)-ifnull(pur.purqty,0)>0";
        } elseif ($report_type == 'completed') {
            $having_crit = "having ifnull(sum(d.qty),0)-ifnull(pur.purqty,0)<=0";
        }
        $approved_by = "";
        $etype3 = '';
        if ($etype2 == 'fabricPurchaseContract') {
            $etype3 = 'fabricPurchase';
            $approved_by = " and ifnull(m.approved_by,'') in('fabricPurchaseContract') ";
        } else if ($etype2 == 'yarnPurchaseContract') {
            $etype3 = 'yarnPurchase';
            $approved_by = " and ifnull(m.approved_by,'') in('yarnPurchaseContract') ";
        } else if ($etype2 == 'pur_order') {
            $etype3 = 'purchase';
            $approved_by = " and ifnull(m.approved_by,'') in('pur_order','') ";
        } else {
            $etype3 = 'sale';
            $approved_by = '';
        }
        $qry = "SELECT p.name party_name,m.vrnoa as orderno,date_format( m.vrdate,'%d/%m/%y')vrdate, i.item_id,i.short_code,i.item_des,i.uom,i.model,ifnull(sum(d.qty),0) as orderqty,ifnull(pur.purqty,0) as purqty ,ifnull(sum(d.qty),0)-ifnull(pur.purqty,0) as balqty,ifnull(d.rate,0) as rate,
		ifnull(d.discount,0) as discount,
		round(((ifnull(sum(d.qty),0)-ifnull(pur.purqty,0))*ifnull(d.rate,0)),0)-round(((ifnull(sum(d.qty),0)-ifnull(pur.purqty,0))*ifnull(d.rate,0)) * ifnull(d.discount,0)/100  ,0) as amount
		,ifnull(pur.vrnoa,0)rec_vrnoa,ifnull(pur.vrdate,'')rec_date
		from stockmain m
		inner join stockdetail d on m.stid=d.stid
		inner join item i on i.item_id=d.item_id
		left join party p on p.pid=m.party_id
		left join user on user.uid= m.uid

		left JOIN level3  ON level3.l3 = p.level3
		left JOIN level2  ON level2.l2 = level3.l2
		left JOIN level1  ON level1.l1 = level2.l1

		left join(
		select m.order_vrno, d.item_id,abs(ifnull(sum(d.qty),0)) as purqty,date_format( m.vrdate,'%d/%m/%y')vrdate,m.vrnoa
		from ordermain m
		inner join orderdetail d on m.oid=d.oid
		where m.etype='$etype3'  and m.company_id=$company_id
		group by m.order_vrno,d.item_id
		) as pur on pur.order_vrno=m.vrnoa and pur.item_id=i.item_id

		where m.etype='$etype' and m.vrdate<='$endDate' $approved_by and m.company_id=$company_id $crit
		group by m.vrnoa,i.item_id,pur.purqty,d.rate
		$having_crit ";
        $query = $this->db->query($qry);
        return $query->result_array();
    }
    public function fetchAllPurchases($company_id, $etype) {
        $result = $this->db->query("SELECT round(ordermain.discount,0) as discount,round(ordermain.expense,0) as expense,round(ordermain.tax,0) as tax,ordermain.vrnoa, DATE_FORMAT(ordermain.vrdate,'%d %b %y') AS DATE,p.name AS party_name,ordermain.remarks,round(ordermain.taxpercent,1) as taxpercent,round(ordermain.exppercent,1) as exppercent,round(ordermain.discp,1)as discp,ordermain.paid,round(ordermain.namount,0) as namount,user.uname as user_name,TIME(ordermain.date_time) as date_time,ordermain.vrnoa
			FROM ordermain ordermain
			INNER JOIN party p ON p.pid = ordermain.party_id
			INNER JOIN user ON user.uid = ordermain.uid
			INNER JOIN company c ON c.company_id = ordermain.company_id
			WHERE ordermain.company_id= '" . $company_id . "' AND ordermain.etype= '" . $etype . "' AND ordermain.vrdate = CURDATE()
			ORDER BY ordermain.vrnoa DESC
			LIMIT 10");
        return $result->result_array();
    }
    public function last_5_srate($item_id, $etype, $company_id, $crit) {
        $result = $this->db->query("SELECT party.name as party_name, m.vrnoa, DATE(m.vrdate) vrdate, ROUND(d.qty, 2) qty,d.rate as lprate, ROUND(d.weight, 2) as weight
			FROM stockmain AS m
			INNER JOIN stockdetail AS d ON m.stid = d.stid
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
    public function getMaxVrno($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrno) vrno FROM stockmain WHERE etype = '" . $etype . "' AND company_id=" . $company_id . "  AND DATE(vrdate) = DATE(NOW())");
        $row = $result->row_array();
        $maxId = $row['vrno'];
        return $maxId;
    }
    public function fetchByProductionVoucher($vrnoa, $etype, $company_id) {
        $sql = "SELECT st.name as empname,d.job_id,d.dozen,m.received_by,m.vrno,m.uid,m.vrnoa, m.vrdate,m.remarks,m.approved_by,m.prepared_by, ROUND(m.namount, 2) namount,m.workorder, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.lamount, 2) AS 's_lamount',  ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom , d.weight,p.name as 'phase_name',d.`type`,d.phase_id,d.emp_id,d.lrate,d.no_of_machines,d.cost,d.lamount,d.item_id
		FROM stockmain AS m 
		INNER JOIN stockdetail AS d ON m.stid = d.stid 
		INNER JOIN item AS i ON i.item_id = d.item_id   
		left JOIN subphase AS p ON p.id = d.phase_id 
		Left JOIN party AS ac ON ac.pid = d.emp_id 
		LEFT JOIN staff st on st.staid = d.emp_id
		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "' ";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchReportDataMain($startDate, $endDate, $company_id, $etype, $uid) {
        if ($etype == 'itv' || $etype == 'rfv') {
            $query = $this->db->query("SELECT stockmain.discount,stockmain.expense,stockmain.tax,stockmain.vrnoa,stockmain.vrdate,p.name AS party_name,stockmain.remarks,stockmain.taxpercent,stockmain.exppercent,stockmain.discp,stockmain.paid,stockmain.namount FROM stockmain stockmain INNER JOIN party p ON p.pid = stockmain.party_id INNER JOIN user ON user.uid = stockmain.uid INNER JOIN company c ON c.company_id = stockmain.company_id WHERE stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id= $company_id AND stockmain.etype= '" . $etype . "' AND stockmain.uid = $uid ORDER BY stockmain.vrnoa");
            return $query->result_array();
        } elseif ($etype == 'inward' || $etype == 'outward' || $etype == 'consumption' || $etype == 'materialreturn') {
            $query = $this->db->query("SELECT i.item_des,d.amount,d.dozen,d.bag,d.qty,d.weight,stockmain.discount,stockmain.expense,stockmain.tax,stockmain.vrnoa,stockmain.vrdate,p.name AS party_name,stockmain.remarks,stockmain.taxpercent,stockmain.exppercent,stockmain.discp,stockmain.paid,stockmain.namount FROM stockmain stockmain LEFT JOIN party p ON p.pid = stockmain.party_id  INNER JOIN stockdetail d on d.stid  = stockmain.stid INNER JOIN item i on i.item_id = d.item_id INNER JOIN user ON user.uid = stockmain.uid INNER JOIN company c ON c.company_id = stockmain.company_id WHERE stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' and stockmain.company_id= $company_id AND stockmain.etype= '" . $etype . "' and stockmain.uid = $uid  ORDER BY stockmain.vrnoa");
            return $query->result_array();
        } elseif ($etype == 'stocktransfer') {
            $query = $this->db->query("SELECT m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' FROM stockmain m INNER JOIN stockdetail d ON m.stid = d.stid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN department dep2 ON dep2.did = d.godown_id2 WHERE m.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "'  AND m.etype = 'stocktransfer' AND m.company_id = " . $company_id . " AND qty > 0");
            return $query->result_array();
        } elseif ($etype == 'requisition') {
            $query = $this->db->query("SELECT ordermain.remarks,orderdetail.lvendor,orderdetail.lstock,orderdetail.amount,ordermain.vrdate, ordermain.remarks, ordermain.vrnoa,
				ordermain.remarks, ABS(orderdetail.qty) qty, orderdetail.weight, orderdetail.rate, orderdetail.netamount,
				item.item_des AS 'item_des',item.uom
				FROM ordermain ordermain
				INNER JOIN orderdetail orderdetail ON ordermain.oid = orderdetail.oid
				LEFT JOIN party party ON ordermain.party_id = party.pid
				INNER JOIN item item ON orderdetail.item_id = item.item_id
				INNER JOIN user ON user.uid = ordermain.uid
				WHERE ordermain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' and ordermain.company_id=$company_id AND ordermain.etype='" . $etype . "' 
				ORDER BY ordermain.vrnoa");
            return $query->result_array();
        } else if ($etype == 'export') {
            $query = $this->db->query("SELECT ordermain.discount,ordermain.expense,ordermain.tax,ordermain.vrnoa,date_format(ordermain.vrdate, '%d %b %y') as vrdate,p.name as party_name,ordermain.remarks,ordermain.taxpercent,ordermain.exppercent,ordermain.discp,ordermain.paid,ordermain.namount from ordermain ordermain INNER JOIN party p ON p.pid = ordermain.party_id INNER JOIN user ON user.uid = ordermain.uid INNER JOIN company c ON c.company_id = ordermain.company_id WHERE ordermain.vrdate BETWEEN  '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id= $company_id AND ordermain.etype= 'sale' and ordermain.etype2='export'  order by ordermain.vrnoa");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT ordermain.discount,ordermain.expense,ordermain.tax,ordermain.vrnoa,date_format(ordermain.vrdate, '%d %b %y') as vrdate,p.name as party_name,ordermain.remarks,ordermain.taxpercent,ordermain.exppercent,ordermain.discp,ordermain.paid,ordermain.namount from ordermain ordermain INNER JOIN party p ON p.pid = ordermain.party_id INNER JOIN user ON user.uid = ordermain.uid INNER JOIN company c ON c.company_id = ordermain.company_id WHERE ordermain.vrdate BETWEEN  '" . $startDate . "' AND '" . $endDate . "' AND ordermain.company_id= $company_id AND ordermain.etype= '" . $etype . "'  order by ordermain.vrnoa");
            return $query->result_array();
        }
    }
    public function fetchReportDataProduction($startDate, $endDate, $company_id, $etype, $uid, $type) {
        $query = $this->db->query("SELECT  dep.name as dept_name,st.name empname,st.type emp_type,st.agreement,st.name as empname,d.dozen,m.received_by,m.vrno,m.uid,m.vrnoa, m.vrdate,m.remarks,m.approved_by,m.prepared_by, ROUND(m.namount, 2) namount,m.workorder,d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.lamount, 2) AS 's_lamount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight,p.name AS 'phase_name',d.`type`,d.phase_id,d.emp_id,d.lrate,d.no_of_machines,d.cost,d.lamount,d.item_id
			FROM stockmain AS m
			INNER JOIN stockdetail AS d ON m.stid = d.stid
			INNER JOIN item AS i ON i.item_id = d.item_id
			INNER JOIN subphase AS p ON p.id = d.phase_id
			LEFT JOIN party AS ac ON ac.pid = d.emp_id
			LEFT JOIN staff st on st.staid = d.emp_id
			LEFT JOIN department dep on dep.did = st.did
			WHERE  m.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' and d.type = '" . $type . "' AND  m.company_id = $company_id AND m.etype = '" . $etype . "'  and m.uid = $uid  ");
        return $query->result_array();
    }
    public function sendMessage($mobile, $message) {
        $ptn = "/^[0-9]/";
        $rpltxt = "92";
        $mobile = preg_replace($ptn, $rpltxt, $mobile);
        $url = ZONG_API_SERVICE_URL;
        $post_string = '<?xml version="1.0" encoding="utf-8"?>' . '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' . '<soap:Body>' . '<SendSingleSMS xmlns="http://tempuri.org/">' . '<Src_nbr>' . ZONG_API_MOB . '</Src_nbr>' . '<Password>' . ZONG_API_PASS . '</Password>' . '<Dst_nbr>' . $mobile . '</Dst_nbr>' . '<Mask>' . ZONG_API_MASK . '</Mask>' . '<Message>' . $message . '</Message>' . '</SendSingleSMS>' . '</soap:Body>' . '</soap:Envelope>';
        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, $url);
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', 'Content-Length: ' . strlen($post_string)));
        $result = curl_exec($soap_do);
        $err = curl_error($soap_do);
        return $result;
    }
    public function fetchPurchaseReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT $field as voucher,$name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.remarks,  stockdetail.qty, stockdetail.weight, stockdetail.rate, stockdetail.amount, stockdetail.netamount, item.item_des as 'item_des',item.uom 
				FROM stockmain stockmain 
				INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid 
				INNER JOIN party party ON stockmain.party_id = party.pid              
				INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3  
				INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 
				INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 
				INNER JOIN item item ON stockdetail.item_id = item.item_id

				left JOIN brand  ON brand.bid=item.bid
				left JOIN category ON category.catid=item.catid
				left JOIN subcategory  ON subcategory.subcatid=item.subcatid 
				left JOIN made  ON made.made_id=item.made_id 


				INNER JOIN user ON user.uid = stockmain.uid  
				INNER JOIN department dept  ON  stockdetail.godown_id = dept.did 
				WHERE  stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT $field as voucher,$name,date(stockmain.vrdate) as DATE,dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username, date(stockmain.VRDATE) VRDATE, stockmain.vrnoa, round(SUM(stockdetail.qty)) qty, round(SUM(stockdetail.weight)) weight, round(SUM(stockdetail.rate)) rate, round(SUM(stockdetail.amount)) amount, round(sum(stockdetail.netamount)) netamount, stockmain.remarks 
				FROM stockmain stockmain 
				INNER JOIN stockdetail stockdetail ON stockmain.stid = stockdetail.stid 
				INNER JOIN party party ON stockmain.party_id = party.pid              
				INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3  
				INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 
				INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 
				INNER JOIN item item ON stockdetail.item_id = item.item_id 

				left JOIN brand  ON brand.bid=item.bid
				left JOIN category ON category.catid=item.catid
				left JOIN subcategory  ON subcategory.subcatid=item.subcatid 
				left JOIN made  ON made.made_id=item.made_id 

				INNER JOIN user ON user.uid = stockmain.uid  
				INNER JOIN department dept  ON  stockdetail.godown_id = dept.did 
				WHERE  stockmain.vrdate between '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit group by $groupBy order by $orderBy");
            return $query->result_array();
        }
    }
    public function fetchPurchaseReportData_production($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed' || $type == 'summary') {
            $query = $this->db->query("SELECT $field as voucher,$name,staff.name as staff_name,stockdetail.lamount,staff.salary as staff_salary, DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.workorder, shift.name as shift_name,dept.name as dept_name, stockmain.remarks,item.artcile_no as article, if(item.uom='dozen', round(IFNULL(stockdetail.qty/12,0),0),round(IFNULL(stockdetail.qty,0),0)) as qty, stockdetail.weight, stockdetail.lrate as rate, stockdetail.lamount as amount, stockdetail.netamount, item.item_des AS 'item_des',item.uom
				FROM stockmain stockmain
				INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid
				left JOIN staff  ON stockdetail.emp_id = staff.staid
				left JOIN allot_shift  ON allot_shift.gid = staff.gid
				left JOIN shift  ON shift.shid = stockdetail.job_id
				left JOIN subphase AS subphase ON subphase.id = stockdetail.phase_id 
				INNER JOIN item item ON stockdetail.item_id = item.item_id
				INNER JOIN user ON user.uid = stockmain.uid
				INNER JOIN department dept ON stockdetail.godown_id = dept.did

				WHERE stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit
				$crit  order by $orderBy , stockmain.vrdate ");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT $field AS voucher,$name, DATE(stockmain.vrdate) AS DATE, DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username, DATE(stockmain.VRDATE) VRDATE, stockmain.vrnoa, ROUND(SUM(stockdetail.qty)) qty, ROUND(SUM(stockdetail.weight)) weight, ROUND(SUM(stockdetail.rate)) rate, ROUND(SUM(stockdetail.amount)) amount, ROUND(SUM(stockdetail.netamount)) netamount, stockmain.remarks
				FROM stockmain stockmain
				INNER JOIN stockdetail stockdetail ON stockmain.stid = stockdetail.stid
				left JOIN staff  ON stockdetail.emp_id = staff.staid
				INNER JOIN item item ON stockdetail.item_id = item.item_id
				INNER JOIN user ON user.uid = stockmain.uid
				INNER JOIN department dept ON stockdetail.godown_id = dept.did
				WHERE stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit
				GROUP BY $groupBy
				ORDER BY $orderBy, stockmain.vrdate");
            return $query->result_array();
        }
    }
    public function fetchPurchaseReportData_inward($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        $query = $this->db->query("SELECT $field as voucher,$name,stockmain.bilty_no,item.artcile_no,dept.name dept_name,stockmain.workorder,party.name as party_name,staff.name as staff_name, DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username,stockmain.workorder,date_format(stockmain.vrdate,'%d/%m/%y') vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.remarks, if(item.uom='dozen', round(IFNULL(stockdetail.qty/12,0),0),round(IFNULL(stockdetail.qty,0),0)) AS qty, stockdetail.weight, stockdetail.lrate as rate, stockdetail.lamount as amount, stockdetail.netamount, item.item_des AS 'item_des',item.uom,stockmain.etype
			FROM stockmain stockmain
			INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid
			left JOIN staff  ON stockdetail.emp_id = staff.staid
			left JOIN party party ON stockmain.party_id = party.pid
			INNER JOIN item item ON stockdetail.item_id = item.item_id
			INNER JOIN user ON user.uid = stockmain.uid
			INNER JOIN department dept ON stockdetail.godown_id = dept.did
			WHERE stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit
			order by $orderBy ,stockmain.vrdate ");
        return $query->result_array();
    }
    public function fetchVendorReportData($startDate, $endDate, $what, $etype, $company_id, $orderBy, $name, $crit) {
        if ($etype == 'issue_receive') {
            $etype = " and ifnull(stockdetail.type,'')<>'less' and stockmain.etype in ('itv','rfv','tr_consume','tr_produce','rejection','settelment')  ";
        } else if ($etype == 'rfv') {
            $etype = " and stockdetail.type<>'less' and stockmain.etype = '" . $etype . "'";
            $etype2 = $etype;
        } else {
            $etype2 = $etype;
            $etype = " and stockmain.etype = '" . $etype . "'";
        }
        if ($what == 'none') {
            $qry = "SELECT $field as voucher,$name, dayname(vrdate) as weekdate,stockmain.etype, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.remarks,  stockdetail.qty, stockdetail.weight, stockdetail.rate, stockdetail.amount, stockdetail.netamount, item.item_des as 'item_des',item.uom FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid INNER JOIN party party ON stockmain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3  INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON stockdetail.item_id = item.item_id INNER JOIN user ON user.uid = stockmain.uid  INNER JOIN department dept  ON  stockdetail.godown_id = dept.did WHERE  stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id $etype $crit  order by $orderBy";
        } else if ($etype2 == 'tr_consume') {
            $qry = "
			SELECT $name name , $orderBy voucher,vendorstock.id stdid,dayname(vrdate) as weekdate,party.name as party_name,stockmain.etype,stockmain.bilty_no, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,sp.name as subphae_name,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa,0 dozen,0 bag, vendorstock.qty, vendorstock.weight, vendorstock.rate, vendorstock.amount, vendorstock.netamount, item.item_des AS 'item_des',item.uom,0 as op_stockqty,0 as op_stockweight,vendorstock.rate lrate,item_cus.item_id as item_id_cus,item_cus.item_des as item_desc_cus,item_cus.uom as uom_cus,sp2.id as phase_id2,sp2.name phase_name2
			FROM stockmain stockmain
			INNER JOIN vendorstock vendorstock ON stockmain.stid = vendorstock.stid
			INNER JOIN party party ON stockmain.party_id = party.pid
			left JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
			left JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
			left JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
			left join subphase as sp on sp.id= vendorstock.job_id
			left join subphase as sp2 on sp2.id= vendorstock.godown_id2
			INNER JOIN item item ON vendorstock.item_id = item.item_id
			left JOIN item item_cus ON vendorstock.job_id = item_cus.item_id
			left JOIN brand b ON b.bid = item.bid
			left JOIN category  cat ON cat.catid = item.catid
			left JOIN subcategory  subcat ON subcat.subcatid = item.subcatid
			INNER JOIN user ON user.uid = stockmain.uid
			INNER JOIN department dept ON vendorstock.godown_id = dept.did
			
			WHERE stockmain.etype='rfv' and stockmain.vrdate BETWEEN '$startDate' AND '$endDate' AND stockmain.company_id=$company_id  $crit ";
        } else {
            $qry = " SELECT * from (
			SELECT $name name , $orderBy voucher,stockdetail.stdid,dayname(vrdate) as weekdate,party.name as party_name,stockmain.etype,stockmain.bilty_no, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,sp.name as subphae_name,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa,stockdetail.dozen,stockdetail.bag, stockdetail.qty, stockdetail.weight, stockdetail.rate, stockdetail.amount, stockdetail.netamount, item.item_des AS 'item_des',item.uom,ifnull(op.op_stockqty,0) as op_stockqty,ifnull(op.op_stockweight,0) as op_stockweight,stockdetail.lrate,item_cus.item_id as item_id_cus,item_cus.item_des as item_desc_cus,item_cus.uom as uom_cus,sp2.id as phase_id2,sp2.name phase_name2
			FROM stockmain stockmain
			INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid
			INNER JOIN party party ON stockmain.party_id = party.pid
			left JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
			left JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
			left JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
			left join subphase as sp on sp.id= stockdetail.phase_id
			left join subphase as sp2 on sp2.id= stockdetail.godown_id2
			INNER JOIN item item ON stockdetail.item_id = item.item_id
			left JOIN item item_cus ON stockdetail.job_id = item_cus.item_id
			left JOIN brand b ON b.bid = item.bid
			left JOIN category  cat ON cat.catid = item.catid
			left JOIN subcategory  subcat ON subcat.subcatid = item.subcatid
			INNER JOIN user ON user.uid = stockmain.uid
			INNER JOIN department dept ON stockdetail.godown_id = dept.did
			left join (SELECT item.item_id, if(item.uom='dozen', round(IFNULL(SUM(stockdetail.qty)/12,0),0),round(IFNULL(SUM(stockdetail.qty),0),0)) AS op_stockqty, IFNULL(SUM(stockdetail.weight),0) AS op_stockweight
			FROM stockdetail
			INNER JOIN stockmain  ON stockmain.stid = stockdetail.stid
			INNER JOIN item  ON stockdetail.item_id= item.item_id
			left JOIN department dept ON dept.did= stockdetail.godown_id
			WHERE  stockmain.vrdate < '$startDate' AND stockmain.company_id=$company_id  $etype  $crit 
			group by item.item_id having IFNULL(SUM(stockdetail.qty),0)<>0) as op on op.item_id=item.item_id
			WHERE stockmain.vrdate BETWEEN '$startDate' AND '$endDate' AND stockmain.company_id=$company_id $etype $crit

			union

			SELECT $name, $orderBy voucher,stockdetail.stdid,dayname(vrdate) as weekdate,party.name as party_name,stockmain.etype,stockmain.bilty_no, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,sp.name as subphae_name,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa,stockdetail.dozen,stockdetail.bag, stockdetail.qty, stockdetail.weight, stockdetail.rate, stockdetail.amount, stockdetail.netamount, item.item_des AS 'item_des',item.uom,ifnull(op.op_stockqty,0) as op_stockqty,ifnull(op.op_stockweight,0) as op_stockweight,stockdetail.lrate,item_cus.item_id as item_id_cus,item_cus.item_des as item_desc_cus,item_cus.uom as uom_cus,sp2.id as phase_id2,sp2.name phase_name2
			FROM stockmain stockmain
			INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid
			INNER JOIN party party ON stockmain.party_id = party.pid
			left JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
			left JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
			left JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
			left join subphase as sp on sp.id= stockdetail.phase_id
			left join subphase as sp2 on sp2.id= stockdetail.godown_id2
			INNER JOIN item item ON stockdetail.job_id = item.item_id
			left JOIN item item_cus ON stockdetail.job_id = item_cus.item_id
			left JOIN brand b ON b.bid = item.bid
			left JOIN category  cat ON cat.catid = item.catid
			left JOIN subcategory  subcat ON subcat.subcatid = item.subcatid
			INNER JOIN user ON user.uid = stockmain.uid
			INNER JOIN department dept ON stockdetail.godown_id = dept.did
			left join (SELECT item.item_id, if(item.uom='dozen', round(IFNULL(SUM(stockdetail.qty)/12,0),0),round(IFNULL(SUM(stockdetail.qty),0),0)) AS op_stockqty, IFNULL(SUM(stockdetail.weight),0) AS op_stockweight
			FROM stockdetail
			INNER JOIN stockmain  ON stockmain.stid = stockdetail.stid
			INNER JOIN item  ON stockdetail.item_id= item.item_id
			left JOIN department dept ON dept.did= stockdetail.godown_id
			WHERE  stockmain.vrdate < '$startDate' AND stockmain.company_id=$company_id  $etype  $crit 
			group by item.item_id having IFNULL(SUM(stockdetail.qty),0)<>0) as op on op.item_id=item.item_id
			WHERE stockmain.vrdate BETWEEN '$startDate' AND '$endDate' AND stockmain.company_id=$company_id $etype $crit
			) tbl

			ORDER BY voucher,vrdate,stdid ";
        }
        $query = $this->db->query($qry);
        return $query->result_array();
    }
    public function fetchVendorReportData_settelement($startDate, $endDate, $what, $etype, $company_id, $orderBy, $name, $crit) {
        $query = $this->db->query("SELECT  $name as group_sort,stockmain.vrnoa,DATE_FORMAT(stockmain.vrdate,'%d %b %y') as vrdate,party.name as party_name,stockmain.workorder as wo,DATE_FORMAT(stockmain.ddate,'%d %b %y') as start_date,DATE_FORMAT(stockmain.bilty_date,'%d %b %y') as end_date,stockmain.bilty_no as opening,stockmain.order_vrno as inqty,stockmain.freight as outqty,stockmain.salebillno as balance,stockmain.weight as st_amount,stockmain.discp as tanka_percent,stockmain.discount as tanka_dozen,stockmain.exppercent as tanka_rate,stockmain.expense as tanka_amount,stockmain.taxpercent as tax,stockmain.tax as tax_amount,stockmain.namount as namount,ifnull(stockmain.namount,0)- ifnull(stockmain.weight,0) as amount, DAYNAME(vrdate) AS weekdate,party.name AS party_name,stockmain.etype,stockmain.bilty_no, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username, stockmain.remarks
			FROM stockmain stockmain
			INNER JOIN party party ON stockmain.party_id = party.pid
			INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
			INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
			INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
			INNER JOIN USER ON user.uid = stockmain.uid

			where stockmain.etype='settelment' and stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id $crit
			ORDER BY $orderBy,stockmain.vrdate,stockmain.vrnoa");
        return $query->result_array();
    }
    public function fetchChartData($period, $company_id, $etype) {
        $period = strtolower($period);
        $query = '';
        if ($period === 'daily') {
            $query = "SELECT VRNOA, party.name AS ACCOUNT, NAMOUNT  FROM stockmain as stockmain INNER JOIN party as party  ON party.pid = stockmain.party_id  WHERE stockmain.etype='$etype' AND stockmain.vrdate = CURDATE() AND stockmain.company_id=$company_id order by stockmain.vrdate desc LIMIT 10";
        } else if ($period === 'weekly') {
            $query = "SELECT sum(case when date_format(vrdate, '%W') = 'Monday' then namount else 0 end) as 'Monday', sum(case when date_format(vrdate, '%W') = 'Tuesday' then namount else 0 end) as 'Tuesday', sum(case when date_format(vrdate, '%W') = 'Wednesday' then namount else 0 end) as 'Wednesday', sum(case when date_format(vrdate, '%W') = 'Thursday' then namount else 0 end) as 'Thursday', sum(case when date_format(vrdate, '%W') = 'Friday' then namount else 0 end) as 'Friday', sum(case when date_format(vrdate, '%W') = 'Saturday' then namount else 0 end) as 'Saturday', sum(case when date_format(vrdate, '%W') = 'Sunday' then namount else 0 end) as 'Sunday' from stockmain where    etype = '$etype' and vrdate between DATE_SUB(VRDATE, INTERVAL 7 DAY) and CURDATE() AND stockmain.company_id=$company_id group by WEEK(VRDATE) order by WEEK(VRDATE) desc LIMIT 1 ";
        } else if ($period === 'monthly') {
            $query = "SELECT   sum(case when date_format(vrdate, '%b') = 'Jan' then namount else 0 end) as 'Jan', sum(case when date_format(vrdate, '%b') = 'Feb' then namount else 0 end) as 'Feb', sum(case when date_format(vrdate, '%b') = 'Mar' then namount else 0 end) as 'Mar', sum(case when date_format(vrdate, '%b') = 'Apr' then namount else 0 end) as 'Apr',sum(case when date_format(vrdate, '%b') = 'May' then namount else 0 end) as 'May', sum(case when date_format(vrdate, '%b') = 'Jun' then namount else 0 end) as 'Jun',sum(case when date_format(vrdate, '%b') = 'Jul' then namount else 0 end) as 'Jul', sum(case when date_format(vrdate, '%b') = 'Aug' then namount else 0 end) as 'Aug', sum(case when date_format(vrdate, '%b') = 'Sep' then namount else 0 end) as 'Sep', sum(case when date_format(vrdate, '%b') = 'Oct' then namount else 0 end) as 'Oct' , sum(case when date_format(vrdate, '%b') = 'Nov' then namount else 0 end) as 'Nov' , sum(case when date_format(vrdate, '%b') = 'Dec' then namount else 0 end) as 'Dec' from stockmain where    etype = 'purchase' and MONTH(VRDATE) = MONTH(CURDATE()) AND stockmain.company_id=$company_id group by month(VRDATE) order by month(VRDATE)";
        } else if ($period === 'yearly') {
            $query = "SELECT YEAR(vrdate) as 'Year', MONTHNAME(STR_TO_DATE(MONTH(VRDATE), '%m')) as Month, sum(namount) AS TotalAmount FROM stockmain where  etype = 'purchase' and YEAR(VRDATE) = YEAR(CURDATE()) and stockmain.company_id=$company_id GROUP BY YEAR(vrdate), MONTH(vrdate) ORDER BY YEAR(vrdate), MONTH(vrdate)";
        }
        $query = $this->db->query($query);
        return $query->result_array();
    }
    public function fetchNetSum($company_id, $etype) {
        if ($etype == 'sale' || $etype == 'salereturn' || $etype == 'purchase' || $etype == 'purchasereturn') {
            $query = "SELECT IFNULL(SUM(NAMOUNT),0) as 'PRETURNS_TOTAL' FROM ordermain WHERE ordermain.etype='$etype' AND ordermain.company_id=$company_id";
        } else {
            $query = "SELECT IFNULL(SUM(NAMOUNT),0) as 'PRETURNS_TOTAL' FROM stockmain WHERE stockmain.etype='$etype' AND stockmain.company_id=$company_id";
        }
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getMaxVrnoa($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM stockmain WHERE etype = '" . $etype . "' and company_id=" . $company_id . " ");
        $row = $result->row_array();
        $maxId = $row['vrnoa'];
        return $maxId;
    }
    public function CheckDuplicateVoucher($vrnoa, $etype, $company_id, $gp) {
        $result = $this->db->query("SELECT vrnoa FROM stockmain WHERE etype = '" . $etype . "' and company_id=" . $company_id . " and bilty_no=" . $gp . " and vrnoa<>" . $vrnoa . "  ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function save($stockmain, $stockdetail, $vrnoa, $etype, $vendordetail = '') {
        $this->db->trans_begin();
        $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype, 'company_id' => $stockmain['company_id']));
        $result = $this->db->get('stockmain');
        $stid = "";
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $stid = $result['stid'];
            $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype, 'company_id' => $stockmain['company_id']));
            $this->db->update('stockmain', $stockmain);
            $this->db->where(array('stid' => $stid));
            $this->db->delete('stockdetail');
        } else {
            $stockmain['vrnoa'] = $vrnoa;
            $this->db->insert('stockmain', $stockmain);
            $stid = $this->db->insert_id();
        }
        if (is_array($stockdetail)) {
            foreach ($stockdetail as $detail) {
                $detail['stid'] = $stid;
                $this->db->insert('stockdetail', $detail);
            }
        }
        if ($etype == 'rfv' || $etype == 'itv' || $etype == 'vst') {
            $this->db->where(array('stid' => $stid));
            $this->db->delete('vendorstock');
            foreach ($vendordetail as $detail) {
                $detail['stid'] = $stid;
                $this->db->insert('vendorstock', $detail);
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }


    public function fetchrfv($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT i.item_id,i.item_des,ifnull(i.uom,'')uom,ifnull(d.qty,0)qty,ifnull(d.rate,0) rate,ifnull(d.amount,0)amount,ifnull(d.netamount,0)netamount,ifnull(d.carton,0)carton
			,ifnull(i.uom,'')pur_uom,ifnull(d.bundle,0)bundle,ifnull(d.netamount,0)netamount,ifnull(d.weight,0)weight,sp.id as phase_id, ifnull(sp.name,'') as phase_name,ifnull(d.workdetail,'')workdetail
			,ifnull(d.type,0)type,ifnull(d.prate,0)prate
			FROM stockmain AS m
			INNER JOIN vendorstock AS d ON m.stid = d.stid
			INNER JOIN item AS i ON i.item_id = d.item_id
			LEFT JOIN brand b ON b.bid = i.bid
			LEFT JOIN category c ON c.catid = i.catid
			left join subphase as sp on sp.id=d.job_id


			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "' order by i.item_des ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch($vrnoa, $etype, $company_id) {
        if ($etype == 'tr_produce') {
            $etype = " and m.etype in ('tr_produce','tr_consume')";
        } else {
            $etype = " and m.etype='" . $etype . "'";
        }
        $qry = "SELECT d.lrate,d.cost, ic.item_id as item_id_cus,ic.uom as uom_cus,ic.item_des as item_desc_cus,sp2.id as phase_id2,sp2.name as phase_name2, p.name party_name,pr.name as party_name_consume, d.type, m.approved_by,m.inv_no as inv_no_2,m.etype2,m.etype,m.prepared_by,m.bilty_date,sp.id as phase_id, ifnull(sp.name,'') as phase_name, d.dozen,d.bag,m.workorder,m.bilty_no, m.party_id_co,m.currency_id, d.received_by AS 'received',ifnull(d.workdetail,'')workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ifnull(d.qtyf, 0) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight,ifnull(exp.name,'') as expense_name,ifnull(exp.pid,0)expense_id,ifnull(i.inventory_id,0) item_inventory_id,ifnull(i.cost_id,0) item_cost_id,ifnull(i.income_id,0) item_income_id,ifnull(d.job_id,0)job_id
		,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time , ifnull(ar.short_code,'') item_name_article

		,ifnull(d.bundle,0)bundle,ifnull(d.frate,0)frate

		FROM stockmain AS m
		left JOIN stockdetail AS d ON m.stid = d.stid
		left JOIN item AS i ON i.item_id = d.item_id
		left JOIN item AS ic ON ic.item_id = d.job_id
		left JOIN department AS g ON g.did = d.godown_id

		left join subphase as sp on sp.id=d.phase_id
		left join subphase as sp2 on sp2.id=d.godown_id2

		left join party p  on p.pid=m.party_id
		left join party pr on pr.pid=m.party_id_co
		left join party exp on exp.pid=m.vehicle_id

		left join user on user.uid=m.uid


		left join(
		select distinct short_code,vrnoa 
		from item 
		where ifnull(short_code,'')<>''
		order by short_code 
		) as ar ON ar.vrnoa = d.job_id




		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id  $etype order by d.stdid";
        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_stichmain($vrnoa, $etype, $company_id) {
        if ($etype == 'tr_produce') {
            $etype = " and m.etype in ('tr_produce','tr_consume')";
        } else {
            $etype = " and m.etype='" . $etype . "'";
        }
        $result = $this->db->query("SELECT p.name as party_name,m.approved_by,m.inv_no as inv_no_2,m.etype2,m.etype,m.prepared_by,m.bilty_date,m.workorder,m.bilty_no, m.party_id_co,m.currency_id,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.ddate AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days',m.weight,m.salebillno
			FROM stockmain AS m
			inner join party p on m.party_id=p.pid
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id  $etype ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetch_settellement($pid, $startDate, $endDate, $company_id) {
        $result = $this->db->query("select vrnoa as duplicate_vrno,bilty_date  from stockmain where etype='settelment' and bilty_date > '" . $startDate . "' and party_id=$pid and company_id=$company_id order by vrnoa desc");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            $result = $this->db->query("select '00' as duplicate_vrno,p.pid,ifnull(op.qty,0) as opqty,ifnull(cl.in,0) as inqty,ifnull(cl.out,0) as outqty,ifnull(op.qty,0)+ifnull(cl.in,0) + ifnull(cl.out,0) as balqty,ifnull(cl.amount,0) as amount   from 
				party p
				left join 
				(
				select m.party_id,ifnull(sum(d.qty)/12,0) as qty from 
				stockdetail d 
				inner join stockmain m on m.stid=d.stid 
				where m.party_id=$pid and m.company_id=$company_id and d.type<>'less' and m.etype in ('itv','rfv','tr_consume','tr_produce','rejection','settelment') and m.vrdate <'" . $startDate . "'
				group by m.party_id
				) as op on op.party_id= p.pid

				left join 
				(
				select m.party_id,SUM(IF(d.qty <0,d.qty,0)/12) AS 'out', SUM(IF(d.qty>0,d.qty,0)/12) AS 'in',sum(if (m.etype='rfv' or m.etype='tr_produce' ,d.amount,0)) - (sum(if (m.etype='rejection' ,d.amount,0))) as amount from 
				stockdetail d 
				inner join stockmain m on m.stid=d.stid 
				where m.party_id=$pid and m.company_id=$company_id and d.type<>'less' and m.etype in ('itv','rfv','tr_consume','tr_produce','rejection','settelment')  and m.vrdate  between '" . $startDate . "' AND '" . $endDate . "'
				group by m.party_id
				) as cl on cl.party_id= p.pid
				where pid=$pid ");
            if ($result->num_rows() > 0) {
                return $result->result_array();
            } else {
                return false;
            }
        }
    }
    public function fetchOgp($vrnoa, $etype, $company_id, $company_id2) {
        if ($etype == 'tr_produce') {
            $etype = " and m.etype in ('tr_produce','tr_consume')";
        } else {
            $etype = " and m.etype='" . $etype . "'";
        }
        $result = $this->db->query("SELECT '00' as duplicate_vrnoa, m.approved_by,m.inv_no as inv_no_2,m.etype2,m.etype,m.prepared_by,m.bilty_date,sp.id as phase_id, sp.name as phase_name, d.dozen,d.bag,m.workorder,m.bilty_no, m.party_id_co,m.currency_id, d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight
			FROM stockmain AS m
			left JOIN stockdetail AS d ON m.stid = d.stid
			INNER JOIN item AS i ON i.item_id = d.item_id
			INNER JOIN department AS g ON g.did = d.godown_id
			left join subphase as sp on sp.id=d.phase_id
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id  $etype and m.vrnoa not in (select order_vrno from stockmain where etype='inward' and company_id = $company_id2 ) order by d.stdid ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            $result = $this->db->query("select vrnoa as duplicate_vrnoa,order_vrno from stockmain where etype='inward' and company_id = $company_id2 and order_vrno=$vrnoa ");
            if ($result->num_rows() > 0) {
                return $result->result_array();
            } else {
                return false;
            }
        }
    }
    public function fetchIgp($vrnoa, $etype, $company_id, $etype2) {
        if ($etype == 'tr_produce') {
            $etype = " and m.etype in ('tr_produce','tr_consume')";
        } else {
            $etype = " and m.etype='" . $etype . "'";
        }
        $crit = "";
        if ($etype2 == 'pur_order') {
            $crit = "purchase";
        } else if ($etype2 == 'fabricPurchaseContract') {
            $crit = "fabricPurchase";
        } else if ($etype2 == 'yarnPurchaseContract') {
            $crit = "yarnPurchase";
        } else if ($etype2 == 'purchasereturn') {
            $crit = "purchasereturn";
        }
        $approved_by = "'" . $etype2 . "'";
        if ($etype2 == 'pur_order') $approved_by = "'" . $etype2 . "',''";
        if ($etype2 == 'purchasereturn') {
            $approved_by = "'purchasereturn'";
            $etype2 = "pur_order";
        }
        $qry = "SELECT '00' as duplicate_vrnoa,ifnull(po.rate,0) as cost_price,m.approved_by,m.inv_no as inv_no_2,m.etype2,m.etype,m.prepared_by,m.bilty_date,sp.id as phase_id, sp.name as phase_name, d.dozen,d.bag,m.workorder,m.bilty_no, m.party_id_co,m.currency_id, d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight,ifnull(i.inventory_id,0)inventory_id,ifnull(i.cost_id,0)cost_id,ifnull(i.income_id,0)income_id,ifnull(party.name,'')party_name
		FROM stockmain AS m
		left JOIN stockdetail AS d ON m.stid = d.stid
		INNER JOIN item AS i ON i.item_id = d.item_id
		INNER JOIN department AS g ON g.did = d.godown_id
		left join subphase as sp on sp.id=d.phase_id
		left join party on party.pid=m.party_id
		
		left join(
		SELECT d.item_id, d.rate 
		FROM orderdetail d
		INNER JOIN ordermain m ON m.oid = d.oid
		WHERE m.vrnoa=(select inv_no  from stockmain m where   m.company_id=$company_id and m.vrnoa=$vrnoa $etype) and m.etype='$etype2' and m.company_id=$company_id
		group BY d.item_id
		) as po on po.item_id=i.item_id

		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id and ifnull(m.approved_by,'') in($approved_by)  $etype and m.vrnoa not in (select order_vrno from ordermain where etype='$crit' and company_id=$company_id )  
		order by d.stdid";
        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            $result = $this->db->query("select vrnoa as duplicate_vrnoa,order_vrno from ordermain where etype='$crit' and company_id = $company_id and order_vrno=$vrnoa ");
            if ($result->num_rows() > 0) {
                return $result->result_array();
            } else {
                return false;
            }
        }
    }
    public function fetchVoucher($vrnoa, $etype, $company_id) {
        $query = $this->db->query("SELECT d.type,m.approved_by,m.inv_no, m.bilty_no, m.prepared_by,m.etype2, sp.name as phase_name,m.workorder,d.dozen,d.bag,t.name AS transporter_name,dp.name dept_name, p.name AS party_name,m.vrno,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, d.qty, ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight,m.bilty_date
			FROM stockmain AS m
			INNER JOIN stockdetail AS d ON m.stid = d.stid
			INNER JOIN item AS i ON i.item_id = d.item_id
			INNER JOIN party AS p ON p.pid=m.party_id
			INNER JOIN department AS dp ON dp.did=d.godown_id
			left JOIN transporter AS t ON t.transporter_id=m.transporter_id
			LEFT JOIN subphase  AS sp ON sp.id=d.phase_id
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "' ");
        return $query->result_array();
    }
    public function fetchNavigation($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT d.receive, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.receive, 2) receive, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' ,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
			FROM stockmain m 
			INNER JOIN stockdetail d ON m.stid = d.stid 
			INNER JOIN item i ON i.item_id = d.item_id 
			INNER JOIN department dep ON dep.did = d.godown_id 
			INNER JOIN department dep2 ON dep2.did = d.godown_id2 
			INNER JOIN user ON user.uid = m.uid 

			WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' AND m.company_id = " . $company_id . " AND d.receive > 0");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function fetchNavigation_issue($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT d.dozen,d.job_id,d.receive_id,issue_id, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' ,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
			FROM stockmain m 
			INNER JOIN stockdetail d ON m.stid = d.stid 
			INNER JOIN item i ON i.item_id = d.item_id 
			INNER JOIN department dep ON dep.did = d.godown_id 
			INNER JOIN department dep2 ON dep2.did = d.godown_id2 
			INNER JOIN user ON user.uid = m.uid 

			WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' AND m.company_id = " . $company_id . " AND d.qty > 0");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function fetch_issue_detail($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT  r.name as receive, e.name as issue,d.dozen,d.job_id,d.receive_id,issue_id, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' ,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
			FROM stockmain m 
			INNER JOIN stockdetail d ON m.stid = d.stid 
            INNER JOIN add_employee e ON d.issue_id = e.id
            INNER JOIN add_employee r ON d.receive_id = r.id
			INNER JOIN item i ON i.item_id = d.item_id 
			INNER JOIN department dep ON dep.did = d.godown_id 
			INNER JOIN department dep2 ON dep2.did = d.godown_id2 
			INNER JOIN user ON user.uid = m.uid 

			WHERE d.job_id = $vrnoa AND m.etype = '" . $etype . "' AND m.company_id = " . $company_id . " AND d.qty > 0");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function fetch_receive_detail($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT  r.name as receive, e.name as issue,d.dozen,d.job_id,d.receive_id,issue_id, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name' ,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
			FROM stockmain m 
			INNER JOIN stockdetail d ON m.stid = d.stid 
            INNER JOIN add_employee e ON d.issue_id = e.id
            INNER JOIN add_employee r ON d.receive_id = r.id
			INNER JOIN item i ON i.item_id = d.item_id 
			INNER JOIN department dep ON dep.did = d.godown_id 
			INNER JOIN user ON user.uid = m.uid 

			WHERE d.job_id = $vrnoa AND m.etype = '" . $etype . "' AND m.company_id = " . $company_id . " AND d.qty > 0");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function fetchNavigation_receive($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT d.dozen,d.job_id,d.receive_id,issue_id, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name' ,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
			FROM stockmain m 
			INNER JOIN stockdetail d ON m.stid = d.stid 
			INNER JOIN item i ON i.item_id = d.item_id 
			INNER JOIN department dep ON dep.did = d.godown_id 
			INNER JOIN user ON user.uid = m.uid 

			WHERE m.vrnoa = $vrnoa AND m.etype ='" . $etype . "' AND m.company_id = " . $company_id . " AND  d.qty>0");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function fetchNavigation_receive_all($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT d.dozen,d.job_id,d.receive_id,issue_id, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name' ,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
			FROM stockmain m 
			INNER JOIN stockdetail d ON m.stid = d.stid 
			INNER JOIN item i ON i.item_id = d.item_id 
			INNER JOIN department dep ON dep.did = d.godown_id 
			INNER JOIN user ON user.uid = m.uid 

			WHERE m.vrnoa = $vrnoa AND m.etype ='" . $etype . "' AND m.company_id = " . $company_id . "");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function fetch_consume($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT d.dozen,d.job_id,d.receive_id,issue_id, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name' ,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
			FROM stockmain m 
			INNER JOIN stockdetail d ON m.stid = d.stid 
			INNER JOIN item i ON i.item_id = d.item_id 
			INNER JOIN department dep ON dep.did = d.godown_id 
			INNER JOIN user ON user.uid = m.uid 
			WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' AND m.company_id = " . $company_id . " AND  d.qty < 0 AND d.weight=0 ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function fetch_consumes($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT d.dozen,d.job_id,d.receive_id,issue_id, m.approved_by,m.prepared_by, m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name' ,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(m.workorder,'')workorder
			FROM stockmain m 
			INNER JOIN stockdetail d ON m.stid = d.stid 
			INNER JOIN item i ON i.item_id = d.item_id 
			INNER JOIN department dep ON dep.did = d.godown_id 
			INNER JOIN user ON user.uid = m.uid 
			WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' AND m.company_id = " . $company_id . " AND  d.weight!=0");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
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
    public function delete($vrnoa, $etype, $company_id) {
        $this->db->where(array('etype' => $etype, 'dcno' => $vrnoa, 'company_id' => $company_id));
        $result = $this->db->delete('pledger');
        $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa, 'company_id' => $company_id));
        $result = $this->db->get('stockmain');
        if ($result->num_rows() == 0) {
            return false;
        } else {
            $result = $result->row_array();
            $stid = $result['stid'];
            $this->db->where(array('stid' => $stid));
            $this->db->delete('stockdetail');
            $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa));
            $this->db->delete('stockmain');
            $this->db->where(array('stid' => $stid));
            $this->db->delete('vendorstock');
            return true;
        }
    }
    public function fetchPurchaseReturnReportData($startDate, $endDate, $what, $type) {
        if ($what === 'voucher') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id ORDER BY stockmain.VRNOA");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id Group by stockmain.VRNOA ORDER BY stockmain.VRNOA");
                return $query->result_array();
            }
        } else if ($what == 'account') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id ORDER BY stockmain.party_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT party.NAME, date(stockmain.VRDATE) VRDATE, stockmain.VRNOA, round(SUM(stockdetail.QTY)) QTY, round(SUM(stockdetail.RATE)) RATE, round(sum(stockdetail.NETAMOUNT)) NETAMOUNT, stockmain.REMARKS FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id Group by stockmain.party_id ORDER BY stockmain.party_id");
                return $query->result_array();
            }
        } else if ($what == 'godown') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, dept.name AS NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON stockdetail.godown_id = dept.did WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id ORDER BY stockdetail.godown_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT dept.NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON dept.did = stockdetail.godown_id WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
                return $query->result_array();
            }
        } else if ($what == 'item') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockdetail.item_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT item.item_des as NAME, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
                return $query->result_array();
            }
        } else if ($what == 'date') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.REMARKS, stockmain.VRNOA, stockmain.REMARKS, party.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.NETAMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.vrdate");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT date(stockmain.vrdate) as DATE, ROUND(SUM(stockdetail.QTY)) QTY, ROUND(SUM(stockdetail.RATE)) RATE, ROUND(SUM(stockdetail.NETAMOUNT)) NETAMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN party party ON stockmain.PARTY_ID = party.pid INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='purchase return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.vrdate ORDER BY stockmain.vrdate");
                return $query->result_array();
            }
        }
    }
    public function fetchStockNavigationData($startDate, $endDate, $what, $type, $crit,$ptype) {
        $group_by = 'stockmain.VRNOA';
        if ($what == 'from location') {
            $group_by = 'frm.name';
        } else if ($what == 'to location') {
            $group_by = '_to.name';
        } else if ($what == 'item') {
            $group_by = 'item.item_des';
        } else if ($what == 'category') {
            $group_by = 'category.name';
        } else if ($what == 'subcategory') {
            $group_by = 'subcategory.name';
        } else if ($what == 'brand') {
            $group_by = 'brand.name';
        } else if ($what == 'made') {
            $group_by = 'made.name';
        } else if ($what == 'date') {
            $group_by = 'date(stockmain.vrdate)';
        } else if ($what == 'workorder') {
            $group_by = 'stockmain.workorder';
        } else if ($what == 'user') {
            $group_by = 'user.uname';
        } else if ($what == 'year') {
            $group_by = 'year(stockmain.vrdate)';
        } else if ($what == 'month') {
            $group_by = 'month(stockmain.vrdate)';
        } else if ($what == 'weekday') {
            $group_by = 'DAYNAME(stockmain.vrdate)';
        }

        if($ptype =='1')
        {
            $query = $this->db->query("SELECT  $group_by VOUCHER,DATE_FORMAT(stockmain.VRDATE,'%d/%m/%y')VRDATE, stockmain.VRNOA, stockdetail.ptype, stockdetail.receive, item.item_des, frm.name 'from_dept', _to.name 'to_dept' ,ifnull(stockmain.workorder,'')workorder
			FROM stockmain  
			INNER JOIN stockdetail  ON stockmain.STID = stockdetail.STID 
			INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID 
			INNER JOIN department frm ON stockdetail.godown_id2 = frm.did 
			INNER JOIN department _to ON stockdetail.godown_id = _to.did

			left JOIN brand  ON brand.bid=item.bid
			left JOIN category ON category.catid=item.catid
			left JOIN subcategory  ON subcategory.subcatid=item.subcatid 
			left JOIN made  ON made.made_id=item.made_id 

			left JOIN user  ON user.uid=item.uid 

			WHERE stockmain.ETYPE='stocktransfer' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockdetail.Receive > 0 $crit ORDER BY $group_by,stockmain.vrdate");
            
        return $query->result_array();
        }
        $query = $this->db->query("SELECT  $group_by VOUCHER,DATE_FORMAT(stockmain.VRDATE,'%d/%m/%y')VRDATE, stockmain.VRNOA, stockdetail.ptype, stockdetail.receive, item.item_des, frm.name 'from_dept', _to.name 'to_dept' ,ifnull(stockmain.workorder,'')workorder
			FROM stockmain  
			INNER JOIN stockdetail  ON stockmain.STID = stockdetail.STID 
			INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID 
			INNER JOIN department frm ON stockdetail.godown_id2 = frm.did 
			INNER JOIN department _to ON stockdetail.godown_id = _to.did

			left JOIN brand  ON brand.bid=item.bid
			left JOIN category ON category.catid=item.catid
			left JOIN subcategory  ON subcategory.subcatid=item.subcatid 
			left JOIN made  ON made.made_id=item.made_id 

			left JOIN user  ON user.uid=item.uid 

			WHERE stockmain.ETYPE='stocktransfer' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockdetail.ptype='$ptype'And stockdetail.Receive > 0 $crit ORDER BY $group_by,stockmain.vrdate");
            
        return $query->result_array();
    }

    public function fetchMaterialReturnData($startDate, $endDate, $what, $type) {
        if ($what === 'voucher') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.VRNOA");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, sum(stockdetail.QTY) QTY, sum(stockdetail.RATE) RATE, sum(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.VRNOA ORDER BY stockmain.VRNOA");
                return $query->result_array();
            }
        } else if ($what == 'person') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.received_by");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT stockmain.received_by NAME, SUM(stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.received_by ORDER BY stockmain.received_by");
                return $query->result_array();
            }
        } else if ($what == 'location') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, dept.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON stockdetail.godown_id = dept.did WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockdetail.godown_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT dept.NAME, SUM(stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON dept.did = stockdetail.godown_id WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
                return $query->result_array();
            }
        } else if ($what == 'item') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockdetail.item_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT item.item_des NAME, (stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
                return $query->result_array();
            }
        } else if ($what == 'date') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.vrdate desc");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT stockmain.VRDATE NAME, (stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption_return' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.VRDATE ORDER BY stockmain.VRDATE");
                return $query->result_array();
            }
        }
    }
    public function fetchConsumptionData($startDate, $endDate, $what, $type) {
        if ($what === 'voucher') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.VRNOA");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, sum(stockdetail.QTY) QTY, sum(stockdetail.RATE) RATE, sum(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.VRNOA ORDER BY stockmain.VRNOA");
                return $query->result_array();
            }
        } else if ($what == 'person') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.received_by");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT stockmain.received_by NAME, SUM(stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.received_by ORDER BY stockmain.received_by");
                return $query->result_array();
            }
        } else if ($what == 'location') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, dept.NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON stockdetail.godown_id = dept.did WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockdetail.godown_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT dept.NAME, SUM(stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department dept ON dept.did = stockdetail.godown_id WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockdetail.godown_id ORDER BY stockdetail.godown_id");
                return $query->result_array();
            }
        } else if ($what == 'item') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockdetail.item_id");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT item.item_des NAME, (stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockdetail.item_id ORDER BY stockdetail.item_id");
                return $query->result_array();
            }
        } else if ($what == 'date') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRNOA, stockmain.VRDATE, stockmain.received_by NAME, stockdetail.QTY, stockdetail.RATE, stockdetail.AMOUNT, item.item_des FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' ORDER BY stockmain.vrdate desc");
                return $query->result_array();
            } else {
                $query = $this->db->query("SELECT stockmain.VRDATE NAME, (stockdetail.QTY) QTY, SUM(stockdetail.RATE) RATE, SUM(stockdetail.AMOUNT) AMOUNT FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID WHERE stockmain.ETYPE='consumption' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' GROUP BY stockmain.VRDATE ORDER BY stockmain.VRDATE");
                return $query->result_array();
            }
        }
    }
    public function fetchPRRangeSum($from, $to) {
        $query = "SELECT IFNULL(SUM(CREDIT), 0)-IFNULL(SUM(DEBIT),0) as 'PRETURNS_TOTAL' FROM pledger pledger WHERE pid IN (SELECT pid FROM party party WHERE NAME='purchase return') AND date between '{$from}' AND '{$to}'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchImportRangeSum($from, $to) {
        $query = "SELECT IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) AS 'PIMPORTS_TOTAL' FROM pledger pledger WHERE pid IN ( SELECT pid FROM party party WHERE NAME='purchase import') AND date BETWEEN '{$from}' AND '{$to}'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchRangeSum($from, $to, $etype = 'purchase') {
        $query = "SELECT IFNULL(SUM(namount),0) AS 'PURCHASES_TOTAL' FROM ordermain WHERE etype='$etype' and vrdate BETWEEN '{$from}' AND '{$to}' ";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function ogpStatus($vrnoa, $biltyNo, $etype, $companyId, $voucherTypeHidden) {
        if ($voucherTypeHidden == "new") {
            $status = $this->ogpStatusOnNew($vrnoa, $biltyNo, $etype, $companyId, $voucherTypeHidden);
            return $status;
        } else {
            $query = "SELECT * FROM stockmain
			WHERE etype = '" . $etype . "' and vrnoa = '" . $vrnoa . "' and bilty_no = '" . $biltyNo . "' and company_id = " . $companyId . " ";
            echo $query;
            $result = $this->db->query($query);
            if ($result->num_rows() > 0) {
                echo "ddd";
                return false;
            } else {
                $status = $this->ogpStatusOnNew($vrnoa, $biltyNo, $etype, $companyId, $voucherTypeHidden);
                return $status;
            }
        }
    }
    public function ogpStatusOnNew($vrnoa, $biltyNo, $etype, $companyId, $voucherTypeHidden) {
        $query = "SELECT * FROM stockmain
	WHERE etype = '" . $etype . "' and bilty_no = '" . $biltyNo . "' and company_id = " . $companyId . " ";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

public function postchktransfer($vrnoa)
{
    $result = $this->db->query("SELECT  stid from stockmain where vrnoa ='$vrnoa'");
    $row = $result->row_array();
    $stid = $row['stid'];
	$query = $this->db->query("SELECT DISTINCT ptype from stockdetail where stid = '$stid' and ptype = 'posted'");
	if ($demo = $query->num_rows)
	{
	   if($demo = 1)
	   {
		   return "posted";
	   }
	}
	$query = $this->db->query("SELECT DISTINCT ptype from stockdetail where stid = '$stid' and ptype = 'unpost'");
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


}
?>