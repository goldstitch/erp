<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Yarnissues extends CI_Model {
    public function getMaxId($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(vrnoa) vrnoa FROM stockmain WHERE etype = '" . $etype . "' and company_id=" . $company_id . " ");
        $row = $result->row_array();
        $maxId = $row['vrnoa'];
        return $maxId;
    }
    public function fetchYarnReportData($startDate, $endDate, $what, $type, $company_id, $etype, $crit) {
        $orderBy = "";
        if ($what == 'voucher') {
            $orderBy = "stockmain.vrnoa";
        } else if ($what == 'account') {
            $orderBy = "party.name";
        } else if ($what == 'city') {
            $orderBy = "party.city";
        } else if ($what == 'date') {
            $orderBy = "stockmain.vrdate";
        } else if ($what == 'area') {
            $orderBy = "party.cityarea";
        } else if ($what == 'contract') {
            $orderBy = "weaving_contract.contract_id";
        } else {
            $orderBy = "item.item_des";
        }
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT $orderBy as voucher,party.name, dayname(stockmain.vrdate) as weekdate, month(stockmain.vrdate) as monthdate,year(stockmain.vrdate) as yeardate,user.uname as username,stockmain.vrdate, stockmain.remarks, stockmain.vrnoa, stockmain.remarks,  stockdetail.qty, stockdetail.weight, stockdetail.rate, stockdetail.amount, stockdetail.netamount, item.item_des as 'item_des',item.uom 
				,ifnull(stockdetail.bag,0)bag
				FROM stockmain stockmain 
	
				INNER JOIN stockdetail stockdetail ON stockmain.stid = stockdetail.stid 
				INNER JOIN party party ON stockmain.party_id = party.pid              
				INNER JOIN level3 leveltbl3 ON leveltbl3.l3 = party.level3  
				INNER JOIN level2 leveltbl2 ON leveltbl2.l2 = leveltbl3.l2 
				INNER JOIN level1 leveltbl1 ON leveltbl1.l1 = leveltbl2.l1 
				INNER JOIN item item ON stockdetail.item_id = item.item_id
				left JOIN item AS ic ON ic.item_id = stockmain.currency_id

				left JOIN brand  ON brand.bid=item.bid
				left JOIN category ON category.catid=item.catid
				left JOIN subcategory  ON subcategory.subcatid=item.subcatid 
				left JOIN made  ON made.made_id=item.made_id 

				left join party broker  on broker.pid=stockmain.officer_id

		LEFT join weaving_contract on weaving_contract.contract_id=stockmain.order_vrno


				INNER JOIN user ON user.uid = stockmain.uid  
				INNER JOIN department dept  ON  stockdetail.godown_id = dept.did 
				WHERE  stockmain.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT $orderBy as voucher,date(stockmain.vrdate) as DATE,dayname(stockmain.vrdate) as weekdate, month(stockmain.vrdate) as monthdate,year(stockmain.vrdate) as yeardate,user.uname as username, date(stockmain.VRDATE) VRDATE, stockmain.vrnoa, round(abs(SUM(stockdetail.qty))) qty, round(abs(SUM(stockdetail.weight))) weight, round(SUM(stockdetail.rate)) rate, round(SUM(stockdetail.amount)) amount, round(sum(stockdetail.netamount)) netamount, stockmain.remarks ,ifnull(abs(sum(stockdetail.bag)),0)bag
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
				WHERE  stockmain.vrdate between '" . $startDate . "' AND '" . $endDate . "' AND stockmain.company_id=$company_id AND stockmain.etype='$etype' $crit group by $orderBy order by $orderBy");
            return $query->result_array();
        }
    }
    public function save($stockmain, $stockdetail, $vrnoa, $etype, $ledgers) {
        $this->db->trans_begin();
        $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
        $result = $this->db->get('stockmain');
        $stid = "";
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $stid = $result['stid'];
            $this->db->where(array('vrnoa' => $vrnoa, 'etype' => $etype));
            $this->db->update('stockmain', $stockmain);
            $this->db->where(array('stid' => $stid));
            $this->db->delete('stockdetail');
        } else {
            $stockmain['vrnoa'] = $vrnoa;
            $this->db->insert('stockmain', $stockmain);
            $stid = $this->db->insert_id();
        }
        foreach ($stockdetail as $detail) {
            $detail['stid'] = $stid;
            $this->db->insert('stockdetail', $detail);
        }
        $this->db->where(array('dcno' => $vrnoa, 'etype' => $etype,));
        $affect = $this->db->delete('pledger');
        if ($ledgers != "") {
            $affect = 0;
            foreach ($ledgers as $ledger) {
                $ledger["dcno"] = $vrnoa;
                $this->db->insert('pledger', $ledger);
                $affect = $this->db->affected_rows();
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
            return true;
        }
    }
    public function fetch($vrnoa, $etype, $company_id) {
        $qry = "SELECT d.cost, ic.item_id as item_id_cus,ic.uom as uom_cus,ic.item_des as item_desc_cus,sp2.id as phase_id2,sp2.name as phase_name2, p.name party_name,pr.name as party_name_consume, d.type,d.job_id, m.approved_by,m.inv_no as inv_no_2,m.etype2,m.etype,m.prepared_by,m.bilty_date,sp.id as phase_id, sp.name as phase_name, d.dozen,ifnull(d.bag,0)bag,m.workorder,m.bilty_no, m.party_id_co,m.currency_id, d.received_by AS 'received',d.workdetail,g.name AS dept_name,m.vrno,m.uid,m.paid, m.vrnoa, m.vrdate,m.taxpercent,m.exppercent,m.tax,m.discp, m.party_id, m.bilty_no AS 'inv_no', m.bilty_date AS 'due_date', m.received_by, m.transporter_id, m.remarks, ROUND(m.namount, 2) namount, m.order_vrno AS 'order_no', ROUND(m.freight, 2) freight, ROUND(m.discp, 2) discp, ROUND(m.expense, 2) expense, m.vehicle_id AS 'amnt_paid', m.officer_id, ROUND(m.ddays) AS 'due_days', d.item_id, d.godown_id, ROUND(d.qty, 2) AS 's_qty', ROUND(d.qtyf, 2) AS s_qtyf, ROUND(d.rate, 2) AS 's_rate', ROUND(d.amount, 2) AS 's_amount', ROUND(d.damount, 2) AS 's_damount', ROUND(d.netamount, 2) AS 's_net', i.item_des AS 'item_name',i.uom, d.weight,ifnull(exp.name,'') as expense_name,ifnull(exp.pid,0)expense_id,ifnull(i.inventory_id,0) item_inventory_id,ifnull(i.cost_id,0) item_cost_id,ifnull(i.income_id,0) item_income_id,ifnull(broker.name,'')broker_name,m.ddate,CAST(DATE_FORMAT(DATE_ADD(m.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time,u.uname user_name,ifnull(yarn_issue.qty,0) bagwarp_issue,ifnull(yarn_issue_weft.qty,0) bagweft_issue,ifnull(w.bagwarp,0) - ifnull(yarn_issue.qty,0) bagwarp_bal,ifnull(w.bagwept,0)-ifnull(yarn_issue_weft.qty,0) bagweft_bal,ifnull(w.bagwarp,0) bagwarp,ifnull(w.bagwept,0) bagwept  ,ifnull(i.grweight,0)item_grweight ,ifnull(d.prate,0)prate
		,ifnull(d.lrate,0)lrate ,ifnull(d.no_of_machines,0)no_of_machines,ifnull(d.discount,0)discount ,ifnull(d.bundle,0)bundle
		FROM stockmain AS m
		left JOIN stockdetail AS d ON m.stid = d.stid
		INNER JOIN item AS i ON i.item_id = d.item_id
		left JOIN item AS ic ON ic.item_id = m.currency_id
		INNER JOIN department AS g ON g.did = d.godown_id

		left join subphase as sp on sp.id=d.phase_id
		left join subphase as sp2 on sp2.id=d.godown_id2
		left join party broker  on broker.pid=m.officer_id

		left join party p  on p.pid=m.party_id
		left join party pr on pr.pid=m.party_id_co
		left join party exp on exp.pid=m.vehicle_id

		LEFT join user u on u.uid=m.uid

		LEFT join weaving_contract w on w.contract_id=m.order_vrno



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

		


		WHERE m.vrnoa = $vrnoa AND m.company_id = $company_id and m.etype='$etype' order by d.stdid";
        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAll() {
        $result = $this->db->get('yarn_issue');
        return $result->result_array();
    }
}