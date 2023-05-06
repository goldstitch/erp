<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Orderitemmaterials extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxVrno($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrno) vrno FROM itemrequired_main WHERE etype = '" . $etype . "' AND company_id=" . $company_id . "  AND DATE(vrdate) = DATE(NOW())");
        $row = $result->row_array();
        $maxId = $row['vrno'];
        return $maxId;
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
            $query = $this->db->query("SELECT $field as voucher,$name, dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.remarks,  stockdetail.qty, stockdetail.weight, stockdetail.rate, stockdetail.amount, stockdetail.netamount, item.item_des as 'item_des',item.uom FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.stid INNER JOIN party party ON stockmain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3  INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON stockdetail.item_id = item.item_id INNER JOIN user user ON user.uid = stockmain.uid  INNER JOIN department dept  ON  stockdetail.godown_id = dept.did WHERE  stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT $field as voucher,$name,date(stockmain.vrdate) as DATE,dayname(vrdate) as weekdate, month(vrdate) as monthdate,year(vrdate) as yeardate,user.uname as username, date(stockmain.VRDATE) VRDATE, stockmain.vrnoa, round(SUM(stockdetail.qty)) qty, round(SUM(stockdetail.weight)) weight, round(SUM(stockdetail.rate)) rate, round(SUM(stockdetail.amount)) amount, round(sum(stockdetail.netamount)) netamount, stockmain.remarks FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.stid = stockdetail.stid INNER JOIN party party ON stockmain.party_id = party.pid              INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3  INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 INNER JOIN item item ON stockdetail.item_id = item.item_id INNER JOIN user user ON user.uid = stockmain.uid  INNER JOIN department dept  ON  stockdetail.godown_id = dept.did WHERE  stockmain.vrdate between '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit group by $groupBy order by $orderBy");
            return $query->result_array();
        }
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
    public function fetchcalulationMethods() {
        $result = $this->db->query("SELECT DISTINCT calculationmethod FROM itemdetail");
        return $result->result_array();
    }
    public function fetchPrepareBy() {
        $result = $this->db->query("SELECT DISTINCT prepareBy FROM itemrequired_main");
        return $result->result_array();
    }
    public function fetchApproveBy() {
        $result = $this->db->query("SELECT DISTINCT approveBy FROM itemrequired_main");
        return $result->result_array();
    }
    public function fetchNetSum($company_id, $etype) {
        if ($etype == 'sale') {
            $query = "SELECT IFNULL(SUM(NAMOUNT),0) as 'PRETURNS_TOTAL' FROM ordermain WHERE ordermain.etype='$etype' AND ordermain.company_id=$company_id";
        } else {
            $query = "SELECT IFNULL(SUM(NAMOUNT),0) as 'PRETURNS_TOTAL' FROM stockmain WHERE stockmain.etype='$etype' AND stockmain.company_id=$company_id";
        }
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getMaxVrnoa($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM itemrequired_main WHERE etype = '" . $etype . "' and company_id=" . $company_id . " ");
        $row = $result->row_array();
        $maxId = $row['vrnoa'];
        return $maxId;
    }
    public function checkWorkOrder($worder, $etype, $company_id) {
        $this->db->where(array('etype' => $etype, 'company_id' => $company_id, 'worder' => $worder));
        $result = $this->db->get('itemrequired_main');
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $worder = $result['worder'];
            return $worder;
        } else {
            return false;
        }
    }
    public function save($stockmain, $stockdetail, $vrnoa, $etype) {
        $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype, 'company_id' => $stockmain['company_id']));
        $result = $this->db->get('itemrequired_main');
        $stid = "";
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $stid = $result['stid'];
            $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype, 'company_id' => $stockmain['company_id']));
            $this->db->update('itemrequired_main', $stockmain);
            $this->db->where(array('stid' => $stid));
            $this->db->delete('itemrequired_detail');
        } else {
            $this->db->insert('itemrequired_main', $stockmain);
            $stid = $this->db->insert_id();
        }
        foreach ($stockdetail as $detail) {
            $detail['stid'] = $stid;
            $this->db->insert('itemrequired_detail', $detail);
        }
        return true;
    }
    public function fetch($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT  m.bilty_date,fi.item_des as finisheditem,m.fqty,m.fweight,d.qty,d.amount,
			d.rate,subp.id as subpahase_id ,subp.name as subphase_name,m.finishedItem_id,
			d.etype AS detype,d.calculationmethod, m.party_id_co,m.currency_id,
			d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid,
			m.vrnoa,m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id,
			m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id,
			m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight,
			p.name partyname, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount,
			ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id,
			ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty',
			ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount',
			ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount',
			ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',m.prepareBy,m.approveBy ,
			d.weight,ifnull(m.worder,0)worder,d.styleno,d.size,d.label,d.polybag_paperslip,d.polybag_sticker,
			d.carton_paperslip,d.carton_sticker,d.polybag_packing,d.carton_packing,d.total_dozen,
			d.total_carton,d.carton_marking, i.artcile_no, ifnull(ar.short_code,'') item_name_article,
			ifnull(d.qtyf,0) qtyf,ifnull(d.rate2,0)rate2,ifnull(d.job_id,0) job_id,ifnull(i.uom,'') uom,ifnull(used.name,'') used_for,ifnull(d.godown_id2,0)godown_id2,u.uname user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(i.short_code,'') short_code
			,ifnull(fab.item_des,'') fabric_name,ifnull(d.weight,0)weight,ifnull(d.size,'')size
			,ifnull(d.gsm,'')gsm,ifnull(d.width,'')width,ifnull(d.qtyfabric,0)qtyfabric,ifnull(d.fabric_color,'')fabric_color,ifnull(color.name,'')ar_color_name,ifnull(d.color_id,0)ar_color_id,ifnull(d.bundle,0)bundle,m.stid
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN item AS i ON i.item_id = d.item_id
			LEFT JOIN item AS fi ON fi.item_id = m.finisheditem_id
			
			LEFT JOIN used ON used.used_id = d.job_id
			LEFT join user u on u.uid=m.uid

			LEFT join color  on color.color_id=d.color_id




			LEFT JOIN department AS g ON g.did = d.godown_id
			LEFT JOIN subphase AS subp ON subp.id = d.subphase_id
			LEFT JOIN item AS fab ON fab.item_id = d.size

			INNER JOIN party as p on p.pid = m.party_id

			left join(
			select distinct short_code,vrnoa 
			from item 
			where ifnull(short_code,'')<>''
			order by short_code 
			) as ar ON ar.vrnoa = d.godown_id2

			WHERE m.vrnoa = " . $vrnoa . " AND m.company_id = $company_id AND m.etype = '" . $etype . "' and d.etype<>'labour' order by ar.short_code   ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
            die(print_r($result->result_array()));
        } else {
            return false;
        }
    }
    public function fetchFabricDemand($vrnoa, $etype, $company_id, $item_id_article) {
        $crit = "";
        if ($item_id_article != 0) {
            $crit = " and d.godown_id2=$item_id_article ";
        }
        $result = $this->db->query("SELECT m.worder,m.remarks,p.name partyname, m.vrnoa,m.vrdate,ar.short_code item_name_article,ifnull(d.rate2,0)rate2,ifnull(fab.item_des,'') fabric_name,ROUND(d.qtyf, 2) AS qtyf,ifnull(d.gsm,'')gsm,ifnull(d.width,'')width,ifnull(sum(d.qtyfabric),0)qtyfabric,ifnull(used.name,'') used_for,d.etype AS detype


			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN item AS i ON i.item_id = d.item_id
			LEFT JOIN item AS fi ON fi.item_id = m.finisheditem_id
			
			LEFT JOIN used ON used.used_id = d.job_id
			LEFT join user u on u.uid=m.uid



			LEFT JOIN department AS g ON g.did = d.godown_id
			LEFT JOIN subphase AS subp ON subp.id = d.subphase_id
			LEFT JOIN item AS fab ON fab.item_id = d.size

			INNER JOIN party as p on p.pid = m.party_id

			left join(
			select distinct short_code,vrnoa 
			from item 
			where ifnull(short_code,'')<>''
			order by short_code 
			) as ar ON ar.vrnoa = d.godown_id2

			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "' and d.etype ='fabric' $crit
			group by fab.item_id,d.gsm,d.width,d.qtyf,d.rate2
			order by ar.short_code   ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
            die(print_r($result->result_array()));
        } else {
            return false;
        }
    }
    public function fetchVoucherSummary($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT i.item_id,i.item_des item_name, ar.short_code item_name_article, IFNULL(SUM(d.qty),0) qty, IFNULL(SUM(d.amount),0)amount, IFNULL(i.uom,'') uom, IFNULL(i.short_code,'') short_code
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN item AS i ON i.item_id = d.item_id
			LEFT JOIN item AS fi ON fi.item_id = m.finisheditem_id
			LEFT JOIN used ON used.used_id = d.job_id
			LEFT JOIN user u ON u.uid=m.uid
			LEFT JOIN department AS g ON g.did = d.godown_id
			LEFT JOIN subphase AS subp ON subp.id = d.subphase_id
			INNER JOIN party AS p ON p.pid = m.party_id
			LEFT JOIN(
			SELECT DISTINCT short_code,vrnoa
			FROM item
			WHERE IFNULL(short_code,'')<>''
			ORDER BY short_code 
			) AS ar ON ar.vrnoa = d.godown_id2
			WHERE d.etype IN ('material','fabric','packing') AND m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "'
			GROUP BY ar.short_code,i.item_id ");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return [];
        }
    }
    public function fetchFabricYarnSummary($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT   fabric.item_des fabric_name,GROUP_CONCAT(i.item_des,' - ',round(ifnull(d.weight,0),0),'% =',ifnull(d.qty,0),' ,' )  yarn_name, ifnull(sum(d.qty),0)qty
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN item AS i ON i.item_id = d.item_id
			LEFT JOIN item AS fabric ON fabric.item_id = d.size
			
			LEFT JOIN subphase AS subp ON subp.id = d.subphase_id
			INNER JOIN party AS p ON p.pid = m.party_id
			
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '$etype' AND d.etype='fabric'
			group by fabric.item_des,i.item_des,d.weight");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return [];
        }
    }
    public function fetchLabour($vrnoa, $etype, $company_id, $type) {
        $result = $this->db->query("SELECT  m.bilty_date,fi.item_des as finisheditem,m.fqty,m.fweight,d.qty,d.amount,
			d.rate,subp.id as subpahase_id ,subp.name as subphase_name,m.finishedItem_id,
			d.etype AS detype,d.calculationmethod, m.party_id_co,m.currency_id,
			d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid,
			m.vrnoa,m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id,
			m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id,
			m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight,
			p.name partyname, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount,
			ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id,
			ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty',
			ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount',
			ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount',
			ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',m.prepareBy,m.approveBy ,
			d.weight,m.worder,d.styleno,d.size,d.label,d.polybag_paperslip,d.polybag_sticker,
			d.carton_paperslip,d.carton_sticker,d.polybag_packing,d.carton_packing,d.total_dozen,
			d.total_carton,d.carton_marking, i.artcile_no, ar.short_code item_name_article,
			ifnull(d.qtyf,0) qtyf,ifnull(d.rate2,0)rate2,ifnull(d.job_id,0) job_id,ifnull(i.uom,'') uom,ifnull(used.name,'') used_for,ifnull(d.godown_id2,0)godown_id2,u.uname user_name, CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,ifnull(i.short_code,'') short_code,ifnull(d.prate,0)prate
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN item AS i ON i.item_id = d.item_id
			LEFT JOIN item AS fi ON fi.item_id = m.finisheditem_id
			
			LEFT JOIN used ON used.used_id = d.job_id
			LEFT join user u on u.uid=m.uid



			LEFT JOIN department AS g ON g.did = d.godown_id
			LEFT JOIN subphase AS subp ON subp.id = d.subphase_id
			INNER JOIN party as p on p.pid = m.party_id

			left join(
			select distinct short_code,vrnoa 
			from item 
			where ifnull(short_code,'')<>''
			order by short_code 
			) as ar ON ar.vrnoa = d.godown_id2

			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "' and d.etype='$type' order by ar.short_code  ");
        return $result->result_array();
    }
    public function fetchArticleSummary($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT i.short_code, IFNULL(SUM(d.amount),0) sale_amount, IFNULL(SUM(d.qty),0) sale_qty, IFNULL(lab.amount,0) labour_amount, IFNULL(fabric.amount,0) fabric_amount, IFNULL(packing.amount,0) packing_amount, IFNULL(material.amount,0) material_amount, IFNULL(emb.amount,0) embelishment_amount,IFNULL(fabrication.amount,0) fabrication_amount
			, IFNULL(SUM(d.amount),0) - IFNULL(lab.amount,0) - IFNULL(fabric.amount,0) - IFNULL(packing.amount,0) - IFNULL(material.amount,0) - IFNULL(emb.amount,0)- IFNULL(fabrication.amount,0) profit, IFNULL(lab.qty,0) labour_qty, IFNULL(fabric.qty,0) fabric_qty, IFNULL(packing.qty,0) packing_qty, IFNULL(material.qty,0) material_qty, IFNULL(emb.qty,0) embelishment_qty,IFNULL(fabrication.qty,0) fabrication_qty
			, IFNULL(SUM(d.qty),0) - IFNULL(lab.qty,0) - IFNULL(fabric.qty,0) - IFNULL(packing.qty,0) - IFNULL(material.qty,0) - IFNULL(emb.qty,0)- IFNULL(fabrication.qty,0) profit_qty
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			INNER JOIN item i ON i.item_id=d.item_id
			LEFT JOIN(
			SELECT ar.short_code, IFNULL(SUM(d.amount),0) amount, IFNULL(SUM(d.qty),0) qty
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN(
			SELECT DISTINCT short_code,vrnoa
			FROM item
			WHERE IFNULL(short_code,'')<>''
			ORDER BY short_code 
			) AS ar ON ar.vrnoa = d.godown_id2
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '$etype' AND d.etype='material'
			GROUP BY ar.short_code
			) AS material ON material.short_code=i.short_code
			LEFT JOIN(
			SELECT ar.short_code, IFNULL(SUM(d.amount),0) amount, IFNULL(SUM(d.qty),0) qty
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN(
			SELECT DISTINCT short_code,vrnoa
			FROM item
			WHERE IFNULL(short_code,'')<>''
			ORDER BY short_code 
			) AS ar ON ar.vrnoa = d.godown_id2
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '$etype' AND d.etype='packing'
			GROUP BY ar.short_code
			) AS packing ON packing.short_code=i.short_code
			LEFT JOIN(
			SELECT ar.short_code, IFNULL(SUM(d.amount),0) amount, IFNULL(SUM(d.qty),0) qty
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN(
			SELECT DISTINCT short_code,vrnoa
			FROM item
			WHERE IFNULL(short_code,'')<>''
			ORDER BY short_code 
			) AS ar ON ar.vrnoa = d.godown_id2
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '$etype' AND d.etype='labour'
			GROUP BY ar.short_code
			) AS lab ON lab.short_code=i.short_code
			LEFT JOIN(
			SELECT ar.short_code, IFNULL(SUM(d.amount),0) amount, IFNULL(SUM(d.qty),0) qty
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN(
			SELECT DISTINCT short_code,vrnoa
			FROM item
			WHERE IFNULL(short_code,'')<>''
			ORDER BY short_code 
			) AS ar ON ar.vrnoa = d.godown_id2
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '$etype' AND d.etype='embelishment'
			GROUP BY ar.short_code
			) AS emb ON emb.short_code=i.short_code

			LEFT JOIN(
			SELECT ar.short_code, IFNULL(SUM(d.amount),0) amount, IFNULL(SUM(d.qty),0) qty
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN(
			SELECT DISTINCT short_code,vrnoa
			FROM item
			WHERE IFNULL(short_code,'')<>''
			ORDER BY short_code 
			) AS ar ON ar.vrnoa = d.godown_id2
			WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '$etype' AND d.etype='fabrication'
			GROUP BY ar.short_code
			) AS fabrication ON fabrication.short_code=i.short_code

			LEFT JOIN(
			SELECT ar.short_code, IFNULL(SUM(d.amount),0) amount, IFNULL(SUM(d.qty),0) qty
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			LEFT JOIN(
			SELECT DISTINCT short_code,vrnoa
			FROM item
			WHERE IFNULL(short_code,'')<>''
			ORDER BY short_code 
		) AS ar ON ar.vrnoa = d.godown_id2
		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '$etype' AND d.etype='fabric'
		GROUP BY ar.short_code
	) AS fabric ON fabric.short_code=i.short_code
	WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '$etype' AND d.etype='item'
	GROUP BY i.short_code");
        if ($result->num_rows() > 0) {
            return $result->result_array();
            die(print_r($result->result_array()));
        } else {
            return false;
        }
    }
    public function fetchOrder($vrnoa, $etype, $company_id, $crit) {
        $result = $this->db->query("SELECT m.bilty_date,fi.item_des AS finisheditem,m.fqty,m.fweight,ifnull(sum(d.qty),0)qty,d.amount,d.rate,subp.id AS subpahase_id,subp.name AS subphase_name,m.finishedItem_id,d.rate2,d.etype AS detype,d.calculationmethod,d.uom, m.party_id_co,m.currency_id, d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa,m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, p.name partyname, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',m.prepareBy,m.approveBy,ifnull(sum(d.weight),0) weight,m.worder,ifnull(lp.rate,0) as lp_rate,ifnull(lp.lvendor,'') as lvendor,ifnull(stk.st_qty,0) as st_qty,ifnull(stk.st_weight,0) as st_weight,ifnull(d.gsm,'')gsm,ifnull(d.width,'')width,ifnull(d.qtyfabric,0)qtyfabric
		, ifnull(ar.short_code,'') item_name_article, ifnull(d.godown_id2,0) godown_id2
		,ifnull(i.avg_rate,0) as item_avg_rate,ifnull(i.uom,'')uom,ifnull(i.inventory_id,0)item_inventory_id ,ifnull(d.bundle,0)bundle
		FROM itemrequired_main AS m
		INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
		LEFT JOIN item AS i ON i.item_id = d.item_id
		LEFT JOIN item AS fi ON fi.item_id = m.finisheditem_id
		LEFT JOIN department AS g ON g.did = d.godown_id
		LEFT JOIN subphase AS subp ON subp.id = d.subphase_id
		INNER JOIN party AS p ON p.pid = m.party_id

		left join(
		SELECT d.item_id,d.rate AS rate,p.name lvendor
		FROM orderdetail d
		inner join ordermain m on m.oid=d.oid
		inner join party p on p.pid=m.party_id
		WHERE m.etype in ('purchase','yarnPurchase','fabricPurchase') and m.company_id=$company_id and d.qty>0 AND d.oid=(
		SELECT `oid`
		FROM orderdetail
		WHERE item_id=d.item_id
		ORDER BY oid DESC
		LIMIT 1)
		GROUP BY d.item_id
		) as lp on lp.item_id=i.item_id

		left join (
		SELECT i.item_id, IF(i.uom='dozen', ROUND(IFNULL(SUM(d.qty)/12,0),0), ROUND(IFNULL(SUM(d.qty),0),0)) AS st_qty, ROUND(IFNULL(SUM(d.weight),0),2) AS st_weight
		FROM stockdetail d
		INNER JOIN stockmain m ON m.stid = d.stid
		INNER JOIN item i ON d.item_id= i.item_id
		WHERE m.company_id = $company_id
		GROUP BY i.item_id
		) as stk on stk.item_id=i.item_id

		left join(
		select distinct short_code,vrnoa 
		from item 
		where ifnull(short_code,'')<>''
		order by short_code 
		) as ar ON ar.vrnoa = d.godown_id2

		WHERE m.worder = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "' $crit 
		group by  d.godown_id2, i.item_id");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function FetchCatagoriesRequired($vrnoa, $company_id) {
        $crit = '';
        if (intval($vrnoa) != 0) $crit = ' and m.worder =' . $vrnoa;
        $result = $this->db->query("SELECT distinct category.*  
		from category 
		inner join item on item.catid=category.catid and item.item_id
		inner join itemrequired_detail d on d.item_id=item.item_id
		inner join itemrequired_main m on m.stid=d.stid
		WHERE  d.etype IN ('fabric','material','packing') $crit
		and m.company_id=$company_id ");
        return $result->result_array();
    }
    public function FetchSubCatagoriesRequired($vrnoa, $company_id) {
        $crit = '';
        if (intval($vrnoa) != 0) $crit = ' and m.worder =' . $vrnoa;
        $result = $this->db->query("SELECT distinct subcategory.*  
		from subcategory 
		inner join item on item.subcatid=subcategory.subcatid and item.item_id
		inner join itemrequired_detail d on d.item_id=item.item_id
		inner join itemrequired_main m on m.stid=d.stid
		WHERE  d.etype IN ('fabric','material','packing') $crit
		and m.company_id=$company_id ");
        return $result->result_array();
    }
    public function FetchBrandsRequired($vrnoa, $company_id) {
        $crit = '';
        if (intval($vrnoa) != 0) $crit = ' and m.worder =' . $vrnoa;
        $result = $this->db->query("SELECT distinct brand.*  
		from brand 
		inner join item on item.bid=brand.bid and item.item_id
		inner join itemrequired_detail d on d.item_id=item.item_id
		inner join itemrequired_main m on m.stid=d.stid
		WHERE  d.etype IN ('fabric','material','packing') $crit
		and m.company_id=$company_id ");
        return $result->result_array();
    }
    public function FetchArticlesRequired($vrnoa, $company_id) {
        $crit = '';
        if (intval($vrnoa) != 0) $crit = ' and m.worder =' . $vrnoa;
        $result = $this->db->query("SELECT distinct ifnull(ar.short_code,'') short_code,ar.vrnoa  
		from itemrequired_main m
		inner join itemrequired_detail d on d.stid=m.stid
		inner join item on item.item_id and d.item_id
		
		left join(
		select distinct short_code,vrnoa 
		from item 
		where ifnull(short_code,'')<>''
		order by short_code 
		) as ar ON ar.vrnoa = d.godown_id2

		WHERE  d.etype IN ('fabric','material','packing') $crit
		and m.company_id=$company_id ");
        return $result->result_array();
    }
    public function fetchOrder1($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT m.bilty_date,fi.item_des AS finisheditem,m.fqty,m.fweight,d.qty,d.amount,d.rate,subp.id AS subpahase_id,subp.name AS subphase_name,m.finishedItem_id,d.rate2,d.etype AS detype,d.calculationmethod,d.uom, m.party_id_co,m.currency_id, d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa,m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, p.name partyname, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',m.prepareBy,m.approveBy,d.weight,m.worder,ifnull(lp.rate,0) as lp_rate,ifnull(lp.lvendor,'') as lvendor,ifnull(stk.st_qty,0) as st_qty,ifnull(stk.st_weight,0) as st_weight
		FROM itemrequired_main AS m
		INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
		LEFT JOIN item AS i ON i.item_id = d.item_id
		LEFT JOIN item AS fi ON fi.item_id = m.finisheditem_id
		LEFT JOIN department AS g ON g.did = d.godown_id
		LEFT JOIN subphase AS subp ON subp.id = d.subphase_id
		INNER JOIN party AS p ON p.pid = m.party_id
		left join(
		SELECT d.item_id,d.rate AS rate,p.name lvendor
		FROM orderdetail d
		inner join ordermain m on m.oid=d.oid
		inner join party p on p.pid=m.party_id
		WHERE m.etype in ('purchase','yarnPurchase','fabricPurchase') and m.company_id=$company_id and d.qty>0 AND d.oid=(
		SELECT `oid`
		FROM orderdetail
		WHERE item_id=d.item_id
		ORDER BY oid DESC
		LIMIT 1)
		GROUP BY d.item_id
		) as lp on lp.item_id=i.item_id
		left join (
		SELECT i.item_id, IF(i.uom='dozen', ROUND(IFNULL(SUM(d.qty)/12,0),0), ROUND(IFNULL(SUM(d.qty),0),0)) AS st_qty, ROUND(IFNULL(SUM(d.weight),0),2) AS st_weight
		FROM stockdetail d
		INNER JOIN stockmain m ON m.stid = d.stid
		INNER JOIN item i ON d.item_id= i.item_id
		WHERE m.company_id = $company_id										
		GROUP BY i.item_id
		) as stk on stk.item_id=i.item_id
		WHERE m.worder = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchVoucher($vrnoa, $etype, $company_id) {
        $query = $this->db->query("SELECT p.name as party_name ,m.vrno,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp,m.discount, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.discount, 2) discount, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, d.qty, ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.discount, 2) AS 's_discount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight  FROM stockmain AS m INNER JOIN stockdetail AS d ON m.stid = d.stid INNER JOIN item AS i ON i.item_id = d.item_id INNER JOIN party as p on p.pid=m.party_id WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND m.etype = '" . $etype . "' ");
        return $query->result_array();
    }
    public function fetchNavigation($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT m.uid,m.vrno, m.vrnoa, DATE(m.vrdate) vrdate, m.received_by, m.remarks, m.etype, d.item_id, d.godown_id, d.godown_id2, ROUND(d.qty, 2) qty, ROUND(d.weight, 2) weight, d.uom, dep.name AS 'dept_to', i.item_des AS 'item_name', dep2.name AS 'dept_from' FROM stockmain m INNER JOIN stockdetail d ON m.stid = d.stid INNER JOIN item i ON i.item_id = d.item_id INNER JOIN department dep ON dep.did = d.godown_id INNER JOIN department dep2 ON dep2.did = d.godown_id2 WHERE m.vrnoa = $vrnoa AND m.etype = '" . $etype . "' AND m.company_id = " . $company_id . " AND qty > 0");
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
    public function fetchByColFromStkDetail($col) {
        $result = $this->db->query("SELECT DISTINCT $col FROM stockdetail");
        return $result->result_array();
    }
    public function delete($vrnoa, $etype, $company_id) {
        $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa, 'company_id' => $company_id));
        $result = $this->db->get('itemrequired_main');
        if ($result->num_rows() == 0) {
            return false;
        } else {
            $result = $result->row_array();
            $stid = $result['stid'];
            $this->db->where(array('etype' => $etype, 'vrnoa' => $vrnoa));
            $this->db->delete('itemrequired_main');
            $this->db->where(array('stid' => $stid));
            $this->db->delete('itemrequired_detail');
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
    public function fetchStockNavigationData($startDate, $endDate, $what, $type) {
        if ($what === 'voucher') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockdetail.UOM, stockdetail.QTY, item.item_des, frm.name 'from_dept', _to.name 'to_dept' FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department frm ON stockdetail.godown_id = frm.did INNER JOIN department _to ON stockdetail.godown_id2 = _to.did WHERE stockmain.ETYPE='navigation' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockdetail.QTY > 0 ORDER BY stockmain.VRNOA");
                return $query->result_array();
            }
        } else if ($what == 'location') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockdetail.UOM, stockdetail.QTY, item.item_des, frm.name 'from_dept', _to.name 'to_dept' FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department frm ON stockdetail.godown_id = frm.did INNER JOIN department _to ON stockdetail.godown_id2 = _to.did WHERE stockmain.ETYPE='navigation' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockdetail.QTY > 0 ORDER BY frm.name");
                return $query->result_array();
            }
        } else if ($what == 'item') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockdetail.UOM, stockdetail.QTY, item.item_des, frm.name 'from_dept', _to.name 'to_dept' FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department frm ON stockdetail.godown_id = frm.did INNER JOIN department _to ON stockdetail.godown_id2 = _to.did WHERE stockmain.ETYPE='navigation' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockdetail.QTY > 0 ORDER BY item.item_des");
                return $query->result_array();
            }
        } else if ($what == 'date') {
            if ($type == 'detailed') {
                $query = $this->db->query("SELECT stockmain.VRDATE, stockmain.VRNOA, stockdetail.UOM, stockdetail.QTY, item.item_des, frm.name 'from_dept', _to.name 'to_dept' FROM stockmain stockmain INNER JOIN stockdetail stockdetail ON stockmain.STID = stockdetail.STID INNER JOIN item item ON stockdetail.ITEM_ID = item.ITEM_ID INNER JOIN department frm ON stockdetail.godown_id = frm.did INNER JOIN department _to ON stockdetail.godown_id2 = _to.did WHERE stockmain.ETYPE='navigation' AND stockmain.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockdetail.QTY > 0 ORDER BY stockmain.VRDATE");
                return $query->result_array();
            }
        }
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
    public function fetchRangeSum($from, $to) {
        $query = "SELECT IFNULL(SUM(DEBIT), 0)- IFNULL(SUM(CREDIT),0) AS 'PURCHASES_TOTAL' FROM pledger pledger WHERE pid IN ( SELECT pid FROM party party WHERE NAME='purchase') AND date BETWEEN '{$from}' AND '{$to}'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchProductionPlan($vrnoa, $etype, $company_id) {
        $result = $this->db->query("SELECT d.etype AS detype,m.vrnoa,m.vrdate,d.item_id,i.item_des as item_name,
		d.styleno,d.size,d.label,d.polybag_paperslip,d.polybag_sticker,d.carton_paperslip,d.carton_sticker,
		d.polybag_packing,d.carton_packing,d.total_carton,d.carton_marking,d.total_dozen,d.weight
		FROM itemrequired_main AS m
		INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
		LEFT JOIN item AS i ON i.item_id = d.item_id
		LEFT JOIN item AS fi ON fi.item_id = m.finisheditem_id
		LEFT JOIN department AS g ON g.did = d.godown_id
		LEFT JOIN subphase AS subp ON subp.id = d.subphase_id
		INNER JOIN party as p on p.pid = m.party_id
		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id AND d.etype = '" . $etype . "'");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchByCols($col) {
        $result = $this->db->query("SELECT DISTINCT $col FROM itemrequired_detail where $col!=''");
        return $result->result_array();
    }
}