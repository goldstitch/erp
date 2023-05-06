<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Stocks extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxVrno($etype) {
        $result = $this->db->query("SELECT MAX(vrno) vrno FROM stockmain WHERE etype = '" . $etype . "' AND DATE(vrdate) = DATE(NOW())");
        $row = $result->row_array();
        $maxId = $row['vrno'];
        return $maxId;
    }
    public function getMaxVrnoa($etype) {
        $result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM stockmain WHERE etype = '" . $etype . "'");
        $row = $result->row_array();
        $maxId = $row['vrnoa'];
        return $maxId;
    }
    public function fetchStockOrderReport($startDate, $endDate, $what, $company_id, $crit, $etype) {
        $get_crit = '';
        if ($what == 'location') {
            $get_crit = 'dep.name';
        } else if ($what == 'item') {
            $get_crit = 'i.item_des';
        } else if ($what == 'category') {
            $get_crit = 'cat.name';
        } else if ($what == 'subcategory') {
            $get_crit = 'subcat.name';
        } else if ($what == 'brand') {
            $get_crit = 'b.name';
        } else if ($what == 'uom') {
            $get_crit = 'i.uom';
        } else if ($what == 'type') {
            $get_crit = 'i.barcode';
        } else if ($what == 'color') {
            $get_crit = 'i.model';
        } else if ($what == 'size') {
            $get_crit = 'i.size';
        }
        $query = $this->db->query("SELECT $get_crit as CATEGORY,i.item_des DESCRIPTION , i.MIN_LEVEL, SUM(d.qty) AS 'AVAILABLE_STOCK', CAST(i.min_level AS UNSIGNED) - SUM(d.qty) AS 'ORDER'
			FROM stockdetail d
			INNER JOIN stockmain m ON m.stid = d.stid
			INNER JOIN item i ON d.item_id = i.item_id
			LEFT JOIN category cat ON cat.catid = i.catid
			LEFT JOIN subcategory subcat ON subcat.subcatid = i.subcatid
			LEFT JOIN brand b ON b.bid = i.bid
			LEFT JOIN department dep ON dep.did = d.godown_id
			WHERE m.company_id=$company_id AND m.vrdate <= '" . $endDate . "' $crit 
			GROUP BY i.item_id
			HAVING `order` > 0");
        return $query->result_array();
    }
    public function save($stockmain, $stockdetail, $vrnoa, $etype) {
        $this->db->where(array('salebillno' => $vrnoa, 'etype' => $etype));
        $result = $this->db->get('stockmain');
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $stid = $result['stid'];
            $this->db->where(array('salebillno' => $vrnoa, 'etype' => $etype));
            $result = $this->db->delete('stockmain');
            $this->db->where(array('stid' => $stid));
            $result = $this->db->delete('stockdetail');
        }
        $this->db->insert('stockmain', $stockmain);
        $stid = $this->db->insert_id();
        $affect = 0;
        foreach ($stockdetail as $detail) {
            $detail['stid'] = $stid;
            $this->db->insert('stockdetail', $detail);
            $affect = $this->db->affected_rows();
        }
        if ($affect == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function delete($vrnoa, $etype) {
        $this->db->where(array('salebillno' => $vrnoa, 'etype' => $etype));
        $result = $this->db->get('stockmain');
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $stid = $result['stid'];
            $this->db->where(array('salebillno' => $vrnoa, 'etype' => $etype));
            $result = $this->db->delete('stockmain');
            $this->db->where(array('stid' => $stid));
            $result = $this->db->delete('stockdetail');
        }
        return true;
    }
    public function fetchDailyVoucherReport($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        $get_crit = "
		(SELECT $field as VOUCHER,item.ITEM_ID, m.ETYPE,date_format(m.VRDATE,'%d/%m/%y') AS VRDATE,dept.name DEPT_NAME,m.DATE_TIME ,m.VRNOA, party.NAME, m.REMARKS, abs(ROUND(if(item.uom='dozen', d.QTY/12,d.QTY), 2)) QTY, ROUND(d.NETAMOUNT, 0) NETAMOUNT,item.ITEM_DES,item.UOM,d.RATE,round(ifnull(d.amount,0),0) AMOUNT,ifnull(abs(d.weight),0)WEIGHT,ifnull(m.workorder,'')WORKORDER
		FROM stockmain m
		INNER JOIN stockdetail d ON m.stid = d.stid
		INNER JOIN party party ON party.pid = m.party_id
		INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
		INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
		INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
		INNER JOIN user ON user.uid = m.uid
		INNER JOIN company ON company.company_id = m.company_id
		left JOIN department dept ON d.godown_id = dept.did
		INNER JOIN item item ON d.item_id = item.item_id
		WHERE m.VRDATE BETWEEN '$startDate' AND '$endDate' $crit
		ORDER BY $orderBy, m.VRDATE)

		union
		(
		SELECT $field as VOUCHER,item.ITEM_ID,m.ETYPE,date_format(m.VRDATE,'%d/%m/%y') as VRDATE,dept.name DEPT_NAME,m.DATE_TIME ,m.VRNOA, party.NAME, m.REMARKS, abs(ROUND(if(item.uom='dozen', d.QTY/12,d.QTY), 2)) QTY, ROUND(d.NETAMOUNT, 0) NETAMOUNT,item.ITEM_DES,item.UOM,d.RATE,round(ifnull(d.amount,0),0) AMOUNT, IFNULL(abs(d.weight),0)WEIGHT,ifnull(m.workorder,'')WORKORDER
		FROM stockmain m
		INNER JOIN vendorstock d ON m.stid = d.stid
		INNER JOIN party party ON party.pid = d.godown_id2
		INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
		INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
		INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1
		INNER JOIN user ON user.uid = m.uid
		INNER JOIN company ON company.company_id = m.company_id
		left JOIN department dept ON d.godown_id = dept.did
		INNER JOIN item item ON d.item_id = item.item_id
		WHERE m.etype <>'itv' and m.VRDATE BETWEEN '$startDate' AND '$endDate' $crit
		ORDER BY $orderBy, m.VRDATE)";
        $query = $this->db->query($get_crit);
        return $query->result_array();
    }
    public function fetchStockReport($startDate, $endDate, $what, $company_id, $crit) {
        if ($what == 'summary') {
            $query = $this->db->query("call spw_Inventory_Summary('$startDate', '$endDate', $crit, $company_id)");
        } else if ($what == 'outhouse') {
            $query = $this->db->query("call spw_Inventory_Summary3('$startDate', '$endDate', $crit, $company_id)");
        } else {
            $get_crit = '';
            if ($what == 'location') {
                $get_crit = 'dep.name';
            } else if ($what == 'item') {
                $get_crit = 'i.item_des,dep.name';
            } else if ($what == 'category') {
                $get_crit = 'cat.name';
            } else if ($what == 'subcategory') {
                $get_crit = 'subcat.name';
            } else if ($what == 'brand') {
                $get_crit = 'b.name';
            } else if ($what == 'uom') {
                $get_crit = 'i.uom';
            } else if ($what == 'type') {
                $get_crit = 'i.barcode';
            } else if ($what == 'order') {
                $get_crit = 'm.workorder';
            } else if ($what == 'phase') {
                $get_crit = 'i.item_des,sp.name';
            } else if ($what == 'article') {
                $get_crit = 'i.artcile_no';
            } else if ($what == 'unit') {
                $get_crit = 'company.company_name';
            }
            $query = $this->db->query("SELECT  $get_crit as DESCRIPTION,i.artcile_no as ARTICLE,i.uom as UOM,i.item_des NAME,i.item_id, dep.NAME as dept_name ,if(i.uom='', round(IFNULL(SUM(d.qty)/12,0),0),IFNULL(SUM(d.qty),0)) AS qty, ROUND(IFNULL(i.avg_rate,0),2) AS cost, ROUND(IFNULL(SUM(d.qty),2)* IFNULL(i.avg_rate,0),2) AS value
				FROM stockdetail d
				INNER JOIN item i ON i.item_id=d.item_id
				left JOIN brand b ON b.bid=i.bid
				left JOIN category cat ON cat.catid=i.catid
				left JOIN subcategory subcat ON subcat.subcatid=i.subcatid
				INNER JOIN stockmain m on m.stid = d.stid
				INNER JOIN company on company.company_id = m.company_id
				LEFT JOIN department dep ON dep.did = d.godown_id
				LEFT JOIN subphase  AS sp ON sp.id=d.phase_id



				WHERE m.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND m.company_id<>0 $crit
				GROUP BY $get_crit,i.item_des 
				having IFNULL(SUM(d.qty),0)<>0 ");
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function fetchOrderStockReport($startDate, $endDate, $what, $company_id, $crit, $etype) {
        $ord_etypee = '';
        $stk_etypee = '';
        if ($etype == 'all') {
            $ord_etypee = " and m.etype in('pur_order','fabricPurchaseContract','yarnPurchaseContract')";
            $stk_etypee = " and m.approved_by in('pur_order','fabricPurchaseContract','yarnPurchaseContract')";
        } else {
            $ord_etypee = " and m.etype='$etype' ";
            $stk_etypee = " and m.approved_by ='$etype' ";
        }
        $get_crit = '';
        $get_crit_ord = '';
        $get_fd = '';
        if ($what == 'location') {
            $get_crit_ord = 'dep.name';
            $get_crit = 'dep.name';
            $get_fd = 'name';
        } else if ($what == 'item') {
            $get_crit_ord = 'i.item_des';
            $get_crit = 'i.item_des';
            $get_fd = 'item_des';
        } else if ($what == 'category') {
            $get_crit_ord = 'c.name';
            $get_crit = 'c.name';
            $get_fd = 'name';
        } else if ($what == 'subcategory') {
            $get_crit_ord = 'subcat.name';
            $get_crit = 'subcat.name';
            $get_fd = 'name';
        } else if ($what == 'brand') {
            $get_crit_ord = 'b.name';
            $get_crit = 'b.name';
            $get_fd = 'name';
        } else if ($what == 'uom') {
            $get_crit_ord = 'i.uom';
            $get_crit = 'i.uom';
            $get_fd = 'uom';
        } else if ($what == 'type') {
            $get_crit_ord = 'i.barcode';
            $get_crit = 'i.barcode';
            $get_fd = 'barcode';
        } else if ($what == 'order') {
            $get_crit_ord = 'm.vrnoa';
            $get_crit = 'm.inv_no';
            $get_fd = 'inv_no';
        } else if ($what == 'workorder') {
            $get_crit_ord = 'm.workorderno';
            $get_crit = 'm.workorder';
            $get_fd = 'workorder';
        } else if ($what == 'phase') {
            $get_crit_ord = 'sp.name';
            $get_crit = 'sp.name';
            $get_fd = 'name';
        } else if ($what == 'article') {
            $get_crit_ord = 'i.artcile_no';
            $get_crit = 'i.artcile_no';
            $get_fd = 'artcile_no';
        } else if ($what == 'unit') {
            $get_crit_ord = 'company.company_name';
            $get_crit = 'company.company_name';
            $get_fd = 'company_name';
        } else if ($what == 'party') {
            $get_crit_ord = 'p.name';
            $get_crit = 'p.name';
            $get_fd = 'name';
        } else if ($what == 'contract') {
            $get_crit_ord = 'm.etype';
            $get_crit = 'm.approved_by';
            $get_fd = 'approved_by';
        }
        $query = $this->db->query("SELECT $get_crit_ord AS NAME,i.item_id AS ITEM_ID,i.item_des as DESCRIPTION,i.uom as UOM, ROUND(IFNULL(SUM(d.qty),0), 2)- ROUND(IFNULL(SUM(stk.qty),0), 2) QTY,ROUND(IFNULL(SUM(d.qty),0), 2) as ORDER_QTY, ROUND(IFNULL(SUM(stk.qty),0), 2) IN_QTY
			FROM ordermain m
			INNER JOIN orderdetail d ON m.oid = d.oid
			INNER JOIN item i ON i.item_id = d.item_id
			LEFT JOIN department dep ON dep.did = d.godown_id
			INNER JOIN category c ON c.catid = i.catid
			left JOIN brand b ON b.bid=i.bid
			INNER JOIN subcategory subcat ON subcat.subcatid=i.subcatid
			INNER JOIN company on company.company_id = m.company_id
			LEFT JOIN subphase  AS sp ON sp.id=d.phase_id
			LEFT JOIN party  AS p ON p.pid=m.party_id

			LEFT JOIN (
			SELECT $get_crit,i.item_id, ROUND(SUM(d.qty), 2) QTY
			FROM stockdetail d
			INNER JOIN item i ON i.item_id=d.item_id
			left JOIN brand b ON b.bid=i.bid
			INNER JOIN category c ON c.catid=i.catid
			INNER JOIN subcategory subcat ON subcat.subcatid=i.subcatid
			INNER JOIN stockmain m on m.stid = d.stid
			INNER JOIN company on company.company_id = m.company_id
			LEFT JOIN department dep ON dep.did = d.godown_id
			LEFT JOIN subphase  AS sp ON sp.id=d.phase_id
			LEFT JOIN party  AS p ON p.pid=m.party_id

			WHERE  m.etype='inward' $crit $stk_etypee AND m.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "'  AND m.company_id=$company_id 
			GROUP BY $get_crit,i.item_id
			) AS stk ON stk.$get_fd=$get_crit_ord AND stk.item_id=i.item_id
			WHERE  m.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' $crit $ord_etypee  AND m.company_id=$company_id 
			GROUP BY $get_crit_ord,i.item_id
			HAVING ROUND(IFNULL(SUM(d.qty),0), 2)- ROUND(IFNULL(SUM(stk.qty),0), 2)>0
			ORDER BY $get_crit_ord,i.item_id;");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function fetchOrderRequiredStockStatusReport($startDate, $endDate, $what, $company_id, $crit, $wo) {
        $get_crit = '';
        if ($what == 'location') {
            $get_crit = 'dep.name';
        } else if ($what == 'item') {
            $get_crit = 'i.item_des,dep.name';
        } else if ($what == 'category') {
            $get_crit = 'cat.name';
        } else if ($what == 'subcategory') {
            $get_crit = 'subcat.name';
        } else if ($what == 'brand') {
            $get_crit = 'b.name';
        } else if ($what == 'uom') {
            $get_crit = 'i.uom';
        } else if ($what == 'type') {
            $get_crit = 'i.barcode';
        } else if ($what == 'order') {
            $get_crit = 'm.workorder';
        } else if ($what == 'phase') {
            $get_crit = 'i.item_des,sp.name';
        } else if ($what == 'article') {
            $get_crit = 'i.artcile_no';
        } else if ($what == 'unit') {
            $get_crit = 'company.company_name';
        } else if ($what == 'party') {
            $get_crit = 'party.name';
        }
        $query = $this->db->query("SELECT cat.name as DESCRIPTION , ifnull(ar.short_code,'') article ,i.item_id,m.vrnoa as order_no,i.uom, i.item_des AS 'item_name', ifnull(sum(d.qty),0) AS req_qty, round(IFNULL(stk.st_qty,0),0) AS stock_qty, round( IFNULL(d.qty,0)- IFNULL(stk.st_qty,0),0) AS bal_qty
			,IFNULL(ordered.qty,0)order_qty,IFNULL(ordered.rec_qty,0)order_rec_qty,IFNULL(sum(d.qty),0) - IFNULL(ordered.rec_qty,0)order_bal_qty
			,ifnull(sum(d.weight),0) AS req_weight, round(IFNULL(stk.st_weight,0),2) AS stock_weight, round(IFNULL(d.weight,0)- IFNULL(stk.st_weight,0),2) AS bal_weight
			,IFNULL(ordered.weight,0)order_weight,IFNULL(ordered.rec_weight,0)order_rec_weight,IFNULL(ordered.weight,0) - IFNULL(ordered.rec_weight,0)order_bal_weight,ifnull(d.etype,'')detype
			FROM itemrequired_main AS m
			INNER JOIN itemrequired_detail AS d ON m.stid = d.stid
			INNER JOIN item AS i ON i.item_id = d.item_id
			left JOIN brand b ON b.bid=i.bid
			left JOIN category cat ON cat.catid=i.catid
			left JOIN subcategory subcat ON subcat.subcatid=i.subcatid
			left JOIN company on company.company_id = m.company_id
			left JOIN department AS dep ON dep.did = d.godown_id
			LEFT JOIN subphase  AS sp ON sp.id=d.subphase_id
			INNER JOIN party party ON m.party_id = party.pid
			INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
			INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
			INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1

			left join (
			SELECT d.item_id, ifnull(sum(d.weight),0) as st_weight, ifnull(sum(d.qty),0) as st_qty
			FROM stockmain AS m
			INNER JOIN stockdetail AS d ON m.stid = d.stid
			INNER JOIN item AS i ON i.item_id = d.item_id
			where  m.VRDATE <= '$endDate' 
			group by d.item_id
			) as stk on  stk.item_id=d.item_id 

			left join (

			SELECT d.item_id_cus,d.item_id, ifnull(abs(sum(d.weight)),0) as weight, ifnull(abs(sum(d.qty)),0) as qty
			, ifnull(SUM(inward.weight),0) as rec_weight, ifnull(sum(inward.qty),0) as rec_qty, ifnull(sum(d.weight),0) - ifnull(sum(inward.weight),0) as bal_weight
			, ifnull(SUM(d.qty),0) - ifnull(sum(inward.qty),0) as bal_qty
			
			FROM ordermain AS m
			INNER JOIN orderdetail AS d ON m.oid = d.oid
			INNER JOIN item AS i ON i.item_id = d.item_id

			LEFT JOIN(
			SELECT ifnull(m.approved_by,'')approved_by, m.inv_no,d.job_id,d.item_id, ifnull(sum(d.weight),0) as weight, ifnull(sum(d.qty),0) as qty
			
			FROM stockmain AS m
			INNER JOIN stockdetail AS d ON m.stid = d.stid
			INNER JOIN item AS i ON i.item_id = d.item_id
			WHERE ifnull(m.approved_by,'') <>'' and m.etype='inward' and m.VRDATE <= '$endDate' 
			group by m.approved_by, m.inv_no,d.job_id,d.item_id

			) as inward ON inward.approved_by=m.etype AND inward.inv_no=m.vrnoa AND inward.job_id=d.item_id_cus AND inward.item_id=d.item_id
			WHERE d.work_orderno=$wo  and m.etype IN('pur_order','yarnPurchaseContract','fabricPurchaseContract') and m.VRDATE <= '$endDate' 
			group by d.item_id_cus,d.item_id

			) as ordered on  ordered.item_id=d.item_id and ordered.item_id_cus=d.godown_id2


			left join(
			select distinct short_code,vrnoa 
			from item 
			where ifnull(short_code,'')<>''
			order by short_code 
			) as ar ON ar.vrnoa = d.godown_id2


			where m.worder=$wo  and m.VRDATE BETWEEN '$startDate' AND '$endDate' AND m.company_id<>0 and  m.etype='item_required'  $crit
			group by cat.name,d.godown_id2,i.item_des ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function fetchOrderStatusReport($startDate, $endDate, $what, $company_id, $crit) {
        $get_crit = '';
        if ($what == 'location') {
            $get_crit = 'dep.name';
        } else if ($what == 'item') {
            $get_crit = 'i.item_des,dep.name';
        } else if ($what == 'category') {
            $get_crit = 'cat.name';
        } else if ($what == 'subcategory') {
            $get_crit = 'subcat.name';
        } else if ($what == 'brand') {
            $get_crit = 'b.name';
        } else if ($what == 'uom') {
            $get_crit = 'i.uom';
        } else if ($what == 'type') {
            $get_crit = 'i.barcode';
        } else if ($what == 'order') {
            $get_crit = 'm.workorder';
        } else if ($what == 'phase') {
            $get_crit = 'i.item_des,sp.name';
        } else if ($what == 'article') {
            $get_crit = 'i.artcile_no';
        } else if ($what == 'unit') {
            $get_crit = 'company.company_name';
        } else if ($what == 'party') {
            $get_crit = 'party.name';
        }
        $query = $this->db->query("SELECT $get_crit as DESCRIPTION,i.artcile_no as article,i.item_id,m.vrnoa as order_no,i.uom, i.item_des AS 'item_name',d.ctn_qty as order_ctn, round(IF(i.uom='dozen',d.qty/12,d.qty),0) AS order_qty,round(d.weight,2) AS order_weight, round(IFNULL(stk.st_weight,0),2) AS dis_weight, round(IF(i.uom='dozen', IFNULL(stk.st_qty,0)/12, IFNULL(stk.st_qty,0)),0) AS dis_qty, round(IFNULL(d.weight,0)- IFNULL(stk.st_weight,0),2) AS bal_weight, round(IF(i.uom='dozen',(IFNULL(d.qty,0)- IFNULL(stk.st_qty,0))/12, IFNULL(d.qty,0)- IFNULL(stk.st_qty,0)),0) AS bal_qty
			FROM ordermain AS m
			INNER JOIN orderdetail AS d ON m.oid = d.oid
			INNER JOIN item AS i ON i.item_id = d.item_id
			left JOIN brand b ON b.bid=i.bid
			INNER JOIN category cat ON cat.catid=i.catid
			INNER JOIN subcategory subcat ON subcat.subcatid=i.subcatid
			INNER JOIN company on company.company_id = m.company_id
			left JOIN department AS dep ON dep.did = d.godown_id
			LEFT JOIN subphase  AS sp ON sp.id=d.phase_id
			INNER JOIN party party ON m.party_id = party.pid
			INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3
			INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2
			INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1

			left join (
			SELECT m.ordno,d.item_id, ifnull(abs(sum(d.weight)),0) as st_weight, ifnull(abs(sum(d.qty)),0) as st_qty
			FROM ordermain AS m
			INNER JOIN orderdetail AS d ON m.oid = d.oid
			INNER JOIN item AS i ON i.item_id = d.item_id
			where m.etype='sale' and m.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' $company_id
			group by m.ordno,d.item_id
			) as stk on stk.ordno=m.vrnoa and stk.item_id=d.item_id
			where m.VRDATE BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND m.company_id<>0 and  m.etype='sale_order'  and if(i.uom='kg' || i.uom='kgs',ifnull(d.weight,0)-ifnull(stk.st_weight,0)>0, ifnull(d.qty,0)-ifnull(stk.st_qty,0)>0) $crit
			group by $get_crit,m.vrnoa,i.item_des order by m.vrnoa ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function fetchissueReceiveReport($startDate, $endDate, $what, $company_id, $crit) {
        if ($what == 'summary') {
            $query = $this->db->query("call spw_Inventory_Summary2('$startDate', '$endDate', '', $company_id)");
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        } else {
            $sort_order = 'p.name';
            if ($what == 'party') {
                $sort_order = 'p.name';
            } else if ($what == 'item') {
                $sort_order = 'i.item_des';
            } else if ($what == 'category') {
                $sort_order = 'cat.name';
            } else if ($what == 'subcategory') {
                $sort_order = 'subcat.name';
            } else if ($what == 'brand') {
                $sort_order = 'b.name';
            } else if ($what == 'uom') {
                $sort_order = 'i.uom';
            } else if ($what == 'type') {
                $sort_order = 'i.barcode';
            } else if ($what == 'workorder') {
                $sort_order = 'm.workorder';
            }
            $query = $this->db->query("
				SELECT $sort_order DESCRIPTION,p.name PARTY_NAME,i.item_id,i.item_des NAME,i.uom,m.workorder, if(i.uom='dozen', round(IFNULL(SUM(d.qty)/12,0),0),round(IFNULL(SUM(d.qty),0),2)) AS qty, round(IFNULL(SUM(d.weight),0),2) AS weight 
				FROM vendorstock d 
				INNER JOIN stockmain m ON m.stid = d.stid 
				INNER JOIN party p ON p.pid= d.godown_id2 
				INNER JOIN item i ON i.item_id= d.item_id
				left JOIN category  cat ON cat.catid = i.catid
				left JOIN subcategory  subcat ON subcat.subcatid = i.subcatid
				left JOIN brand b ON b.bid = i.bid

				WHERE  m.VRDATE BETWEEN '$startDate' AND '$endDate' and m.company_id=$company_id  $crit  
				GROUP BY $sort_order,p.name,i.item_id,i.item_des,i.uom 

				having IFNULL(SUM(d.qty),0)<>0 ");
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }
    }
}