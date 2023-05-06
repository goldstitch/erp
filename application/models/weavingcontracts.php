<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Weavingcontracts extends CI_Model {
    public function getMaxId() {
        $this->db->select_max('contract_id');
        $result = $this->db->get('weaving_contract');
        $row = $result->row_array();
        $maxId = $row['contract_id'];
        return $maxId;
    }
    public function searchBrokers($search, $type) {
        $crit = "";
        $activee = 1;
        $qry = "SELECT IFNULL(pl.balance,0) AS balance, IFNULL(party.city,'') AS city, IFNULL(party.address,'') AS address,
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
        $query = $this->db->query($qry);
        $result = $query->result_array();
        return $result;
    }
    public function searchAccounts($search, $type) {
        $crit = "";
        $activee = 1;
        $qry = "SELECT IFNULL(pl.balance,0) AS balance, IFNULL(party.city,'') AS city, IFNULL(party.address,'') AS address,
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
        $query = $this->db->query($qry);
        $result = $query->result_array();
        return $result;
    }
    public function searchitem($search) {
        $qry = "";
        $qry = "SELECT ifnull(lp.rate,0) as item_last_prate,ifnull(avg_rate.avg_rate,0) as item_avg_rate,item.*,item.size, category.name AS 'category_name',
		subcategory.name AS 'subcategory_name', brand.name AS 'brand_name', made.name AS 'made_name', IFNULL(sd.stqty,0) AS stqty, IFNULL(sd.stweight,0) AS stweight, item.item_barcode
		FROM item
		left JOIN category ON item.catid = category.catid
		LEFT JOIN subcategory ON item.subcatid = subcategory.subcatid
		LEFT JOIN brand ON item.bid = brand.bid
		LEFT JOIN made ON item.made_id = made.made_id
        -- LEFT JOIN department_table ON department_table.department_id = item.department_id
        LEFT JOIN (
        SELECT item_id, IFNULL(SUM(qty),0) stqty, IFNULL(SUM(weight),0) stweight
        FROM stockdetail where godown_id in (select did from department where name like '%store%')
        GROUP BY item_id) sd ON sd.item_id=item.item_id
        left join(
        SELECT ifnull(SUM(d.netamount),0)/ ifnull(SUM(d.qty),0) AS avg_rate,d.item_id
        FROM orderdetail d
        INNER JOIN ordermain m ON m.oid = d.oid
        WHERE m.etype='PURCHASE'
        GROUP BY d.item_id
        HAVING IFNULL(SUM(d.qty),0)<>0
        ) as avg_rate on avg_rate.item_id=item.item_id
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
    ) as lp on lp.item_id=item.item_id
    WHERE item.active=1 AND(
    item.item_des LIKE '%" . $search . "%' 
    OR item.item_code LIKE '%" . $search . "%' 
    OR item.uom LIKE '%" . $search . "%' 
    OR item.uname LIKE '%" . $search . "%' 
    OR item.short_code LIKE '%" . $search . "%' 
    OR category.name LIKE '%" . $search . "%' 
    OR subcategory.name LIKE '%" . $search . "%' 
    OR item.item_barcode LIKE '%" . $search . "%' 
    OR brand.name LIKE '" . $search . "%') 
    LIMIT 0, 20;";
        $result = $this->db->query($qry);
        return $result->result_array();
    }
    public function save($weaving_contract) {
        $this->db->where(array('contract_id' => $weaving_contract['contract_id']));
        $result = $this->db->get('weaving_contract');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('contract_id' => $weaving_contract['contract_id']));
            $result = $this->db->update('weaving_contract', $weaving_contract);
            $affect = $this->db->affected_rows();
        } else {
            unset($weaving_contract['contract_id']);
            $result = $this->db->insert('weaving_contract', $weaving_contract);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function isContractAlreadySaved($weaving_contract) {
        $result = $this->db->query("SELECT * FROM weaving_contract WHERE contract_id <> " . $weaving_contract['contract_id'] . " and contract_no = '" . $weaving_contract['contract_no'] . "'  ");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function delete($contract_id) {
        $this->db->where(array('contract_id' => $contract_id));
        $this->db->delete('weaving_contract');
        return true;
    }
    public function fetch($contract_id) {
        $result = $this->db->query("SELECT w.*,ifnull(item.item_des,'')item_des,ifnull(yarnwarp.item_des,'')warp_des,ifnull(yarnweft.item_des,'')weft_des,ifnull(party.name,'')party_name,ifnull(broker.name,'')broker_name,ifnull(w.bagwarp,0) - ifnull(yarn_issue.qty,0) bagwarp_bal,ifnull(w.bagwept,0)-ifnull(yarn_issue_weft.qty,0) bagweft_bal,ifnull(yarnwarp.inventory_id,0)warp_inventory_id
		,ifnull(yarnweft.inventory_id,0)weft_inventory_id,ifnull(yarn_issue.qty,0) bagwarp_issue,ifnull(yarn_issue_weft.qty,0) bagweft_issue ,ifnull(yarnweft.grweight,0)item_grweight_weft ,ifnull(yarnwarp.grweight,0)item_grweight_warp
		,ifnull(fabric_rcv.qty,0) fabric_rcvqty ,ifnull(w.qty,0) - ifnull(fabric_rcv.qty,0) fabric_balqty 
		,ifnull(avg_rate.rate,0) yarn_bag_avg_rate 
		FROM weaving_contract w
		left join item on item.item_id=w.item_id
		left join item as yarnwarp on yarnwarp.item_id=w.yarnwarpid
		left join item as yarnweft on yarnweft.item_id=w.yarnweptid
		left join party on party.pid=w.party_id
		left join party as broker on broker.pid=w.broker_id

		left join(
			SELECT abs(IFNULL(SUM(d.bag),0)) qty,m.order_vrno
			FROM stockdetail d
			INNER JOIN stockmain m ON m.stid=d.stid
			WHERE m.etype='yarnissue' AND d.type='warp'
			GROUP BY m.order_vrno
		) as yarn_issue on yarn_issue.order_vrno = w.contract_id

		left join(
			SELECT abs(IFNULL(SUM(d.bag),0)) qty,m.order_vrno
			FROM stockdetail d
			INNER JOIN stockmain m ON m.stid=d.stid
			WHERE m.etype='yarnissue' AND d.type='weft'
			GROUP BY m.order_vrno
		) as yarn_issue_weft on yarn_issue_weft.order_vrno = w.contract_id


		left join(
			SELECT abs(IFNULL(SUM(d.qty),0)) qty,m.order_vrno
			FROM stockdetail d
			INNER JOIN stockmain m ON m.stid=d.stid
			WHERE m.etype='frv'
			GROUP BY m.order_vrno
		) as fabric_rcv on fabric_rcv.order_vrno = w.contract_id


		left join(
			SELECT m.order_vrno, IFNULL(SUM(d.bag),0)bag,IFNULL(SUM(d.amount),0)amount , round(IFNULL(SUM(d.amount),0) / IFNULL(SUM(d.bag),0),2) rate
			FROM stockdetail d
			INNER JOIN stockmain m ON m.stid=d.stid
			WHERE m.etype  ='yarnissue'
			GROUP BY m.order_vrno
		) as avg_rate on avg_rate.order_vrno = w.contract_id




		where  w.contract_id = " . $contract_id . " ");
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchAll() {
        $result = $this->db->get('weaving_contract');
        return $result->result_array();
    }
}