<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Exportregisters extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxId($company_id) {
        $this->db->select_max('vrnoa');
        $this->db->where(array('company_id' => $company_id));
        $result = $this->db->get('export_register');
        $result = $result->row_array();
        return $result['vrnoa'];
    }
    public function delete($vrnoa, $company_id) {
        $this->db->where(array('vrnoa' => $vrnoa, 'company_id' => $company_id));
        $result = $this->db->get('export_register');
        if ($result->num_rows() == 0) {
            return false;
        } else {
            $this->db->where(array('company_id' => $company_id, 'vrnoa' => $vrnoa));
            $this->db->delete('export_register');
            return true;
        }
    }
    public function getMaxCatId() {
        $this->db->select_max('catid');
        $result = $this->db->get('category');
        $result = $result->row_array();
        return $result['catid'];
    }
    public function fetchAllSubPhase() {
        $result = $this->db->query('SELECT subphase.*, subphase.name as subphase_name,phase.name AS phase_name FROM subphase INNER JOIN phase ON phase.id = subphase.phaseid ');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function getMaxSubCatId() {
        $this->db->select_max('subcatid');
        $result = $this->db->get('subcategory');
        $result = $result->row_array();
        return $result['subcatid'];
    }
    public function getMaxBrandId() {
        $this->db->select_max('bid');
        $result = $this->db->get('brand');
        $result = $result->row_array();
        return $result['bid'];
    }
    public function getMaxRecipeId() {
        $this->db->select_max('rid');
        $result = $this->db->get('recipemain');
        $result = $result->row_array();
        return $result['rid'];
    }
    public function fetchByCol($col) {
        $result = $this->db->query("SELECT DISTINCT $col FROM item");
        return $result->result_array();
    }
    public function save($item) {
        $this->db->where(array('vrnoa' => $item['vrnoa'], 'company_id' => $item['company_id']));
        $result = $this->db->get('export_register');
        $affect = 0;
        $vrnoa = "";
        if ($result->num_rows() > 0) {
            $this->db->where(array('vrnoa' => $item['vrnoa'], 'company_id' => $item['company_id']));
            $affect = $this->db->update('export_register', $item);
        } else {
            $this->db->insert('export_register', $item);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function upload_photo($photo) {
        $uploadsDirectory = ($_SERVER['DOCUMENT_ROOT'] . '/cf/assets/uploads/items/');
        $errors = array(1 => 'php.ini max file size exceeded', 2 => 'html form max file size exceeded', 3 => 'file upload was only partial', 4 => 'no file was attached');
        ($_FILES['photo']['error'] == 0) or die($errors[$_FILES['photo']['error']]);
        @is_uploaded_file($_FILES['photo']['tmp_name']) or die('Not an HTTP upload');
        @getimagesize($_FILES['photo']['tmp_name']) or die('Only image uploads are allowed');
        $now = time();
        while (file_exists($uploadFilename = $uploadsDirectory . $now . '-' . $_FILES['photo']['name'])) {
            $now++;
        }
        move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilename) or die('Error uploading file');
        $path_parts = explode('/', $uploadFilename);
        $uploadFilename = $path_parts[count($path_parts) - 1];
        return $uploadFilename;
    }
    public function fetch($item_id) {
        $this->db->where(array('item_id' => $item_id));
        $result = $this->db->get('export_register');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchCategory($catid) {
        $this->db->where(array('catid' => $catid));
        $result = $this->db->get('category');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchPurchaseReportData_export($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'detailed') {
            $query = $this->db->query("SELECT $field as voucher,$name,rcv_date,export_register.vrnoa,export_register.pi,export_register.inv_no,export_register.bl_no,export_register.rcv_date,export_register.transport,export_register.vrdate,export_register.inv_date,export_register.advance,export_register.eform,export_register.ctn,export_register.value_amount,export_register.container_no,export_register.delivery_date,export_register.routing_bank,export_register.payment_doc,export_register.dhl_no,export_register.gd_date,export_register.received_payment,export_register.transport,export_register.transport_status,export_register.forwader,export_register.forwader_status,export_register.clrearing_agent,export_register.clearing_status,export_register.rebate_doc,export_register.sea_freight,export_register.sea_status,export_register.saletax_doc,export_register.yarn  
				,DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username
				FROM export_register
				INNER JOIN USER ON user.uid = export_register.uid
				WHERE  export_register.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND export_register.company_id=$company_id  
				$crit  order by $orderBy");
            return $query->result_array();
        } else {
            $query = $this->db->query("SELECT $field as voucher,$name,rcv_date,export_register.vrnoa,export_register.pi,export_register.inv_no,export_register.bl_no,export_register.rcv_date,export_register.transport,export_register.vrdate,export_register.inv_date,export_register.eform,export_register.ctn,export_register.value_amount,export_register.container_no,export_register.delivery_date,export_register.routing_bank,export_register.payment_doc,export_register.dhl_no,export_register.gd_date,export_register.received_payment,export_register.transport,export_register.transport_status,export_register.forwader,export_register.forwader_status,export_register.clrearing_agent,export_register.clearing_status,export_register.rebate_doc,export_register.sea_freight,export_register.sea_status,export_register.saletax_doc,export_register.yarn  
				,DAYNAME(vrdate) AS weekdate, MONTH(vrdate) AS monthdate, YEAR(vrdate) AS yeardate,user.uname AS username
				FROM export_register
				INNER JOIN USER ON user.uid = export_register.uid
				WHERE  export_register.vrdate BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND export_register.company_id=#company_id ' 
				$crit GROUP BY $groupBy order by $orderBy");
            return $query->result_array();
        }
    }
    public function fetchSubCategory($subcatid) {
        $this->db->where(array('subcatid' => $subcatid));
        $result = $this->db->get('subcategory');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchBrand($bid) {
        $this->db->where(array('bid' => $bid));
        $result = $this->db->get('brand');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchFinishedItems() {
        $result = $this->db->query("SELECT * from export_register where barcode = 'finished'");
        return $result->result_array();
    }
    public function fetchAllItems() {
        $result = $this->db->query("SELECT * from export_register");
        return $result->result_array();
    }
    public function fetchAll() {
        $result = $this->db->query("SELECT id,vrdate,inv_date,pi,advance,inv_no,eform,ctn,value_amount,
			container_no,delivery_date,bl_no,routing_bank,payment_doc,dhl_no,gd_date,received_payment,transport,transport_status,forwader,forwader_status,clrearing_agent,clearing_status,rebate_doc,sea_freight,sea_status,saletax_doc,yarn FROM export_register");
        return $result->result_array();
    }
    public function fetchs($vrnoa, $company_id) {
        $result = $this->db->query("SELECT rcv_date,vrnoa,vrdate,inv_date, PI,advance,inv_no,eform,ctn,value_amount,
			container_no,delivery_date,bl_no,routing_bank,payment_doc,dhl_no,gd_date,received_payment,transport,transport_status,forwader,forwader_status,clrearing_agent,clearing_status,rebate_doc,sea_freight,sea_status,saletax_doc,yarn,IFNULL(lcl,'')lcl
			FROM export_register
			WHERE vrnoa =$vrnoa AND company_id=$company_id");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchInv($vrnoa, $company_id) {
        $result = $this->db->query("SELECT  '00' as duplicate_vrnoa,m.ordno, m.eform_no,m.edate,m.container_no, cur.cur_symbol, m.ordno as pono,m.workorderno as wono,m.inv_no
			,m.etype2,d.frate, m.currencey_id,cur.name as currencey_name,m.lprate as lprate_m, m.workorderno,m.due_date,m.currencey_id,ifnull(sum(d.ctn_qty),0) as ctn_qty, m.shippment_from,m.shippment_to,m.cpono,m.vrnoa,m.paid, DATE(m.vrdate) vrdate, m.namount,ifnull(payment.credit,0) as rcv_payment ,payment.date as rcv_date
			FROM ordermain AS m 
			INNER JOIN orderdetail AS d ON m.oid = d.oid
			left join currencey cur on cur.id=m.currencey_id
			left join(
			select pid,invoice,date,ifnull(sum(credit),0) as credit from pledger where invoice<>'' group by pid,invoice
			) as payment on payment.pid=m.party_id and payment.invoice=m.vrnoa

			WHERE m.vrnoa = $vrnoa AND m.etype = 'sale' and m.etype2='export' and m.company_id=$company_id and m.vrnoa not in (select inv_no from export_register where company_id=$company_id and inv_no=$vrnoa)
			group by m.vrnoa
			order by m.vrnoa");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            $result = $this->db->query("select vrnoa as duplicate_vrnoa from export_register where company_id = $company_id and inv_no=$vrnoa ");
            if ($result->num_rows() > 0) {
                return $result->result_array();
            } else {
                return false;
            }
        }
    }
    public function fetchAll_report($from, $to, $orderby, $status) {
        if ($status == 'all_item') {
            $result = $this->db->query("SELECT item.*, category.name AS 'category_name', subcategory.name AS 'subcategory_name', brand.name AS 'brand_name' FROM item INNER JOIN category ON item.catid = category.catid INNER JOIN subcategory ON item.subcatid = subcategory.subcatid INNER JOIN brand ON item.bid = brand.bid order by $orderby ");
        } else {
            $result = $this->db->query("SELECT item.*, category.name AS 'category_name', subcategory.name AS 'subcategory_name', brand.name AS 'brand_name' FROM item INNER JOIN category ON item.catid = category.catid INNER JOIN subcategory ON item.subcatid = subcategory.subcatid INNER JOIN brand ON item.bid = brand.bid where item.active=$status order by $orderby ");
        }
        return $result->result_array();
    }
    public function fetchItemsByStock() {
        $result = $this->db->query("SELECT i.item_id, i.description, round(SUM(d.qty)) stock, round(d.prate) prate FROM stockmain m INNER JOIN stockdetail d ON m.stid = d.stid INNER JOIN item i on d.item_id = i.item_id GROUP BY d.item_id");
        return $result->result_array();
    }
    public function fetchItemLedgerReport($from, $to, $item_id, $company_id, $pid) {
        $crit = "";
        if ($item_id != 0) {
            $crit = "d.item_id=" . $item_id . " and ";
        }
        if ($pid != 0) {
            $crit = $crit . " m.party_id=" . $pid . " and ";
        }
        $result = $this->db->query("SELECT  i.item_des,d.rate,party.name as party_name, m.vrnoa, m.etype, DATE(m.vrdate) date, i.description, m.remarks, dep.name, if(i.uom='dozen', round(IFNULL(d.qty/12,0),0), round(IFNULL(d.qty,0),0)) as qty, d.weight FROM stockmain m INNER JOIN stockdetail d ON m.stid = d.stid INNER JOIN item i ON i.item_id = d.item_id left JOIN department dep ON dep.did = d.godown_id LEFT JOIN party as party on party.pid=m.party_id WHERE $crit  DATE(m.vrdate) >= '" . $from . "' AND DATE(m.vrdate) <= '" . $to . "' $company_id ORDER BY m.vrdate, d.stdid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchItemOpeningStock($to, $item_id, $company_id, $pid) {
        $crit = "";
        if ($item_id != 0) {
            $crit = "d.item_id=" . $item_id . " and ";
        }
        if ($pid != 0) {
            $crit = $crit . " m.party_id=" . $pid . " and ";
        }
        $q = "SELECT if(item.uom='dozen', round(IFNULL(sum(d.qty)/12,0),0), round(IFNULL(sum(d.qty),0),0))  as 'OPENING_QTY' ,IFNULL(SUM(d.weight), 0) as 'OPENING_WEIGHT' FROM stockmain as m INNER JOIN stockdetail as d ON m.stid = d.stid  inner join item on item.item_id=d.item_id WHERE  $crit  DATE(m.VRDATE) < '{$to}' $company_id";
        $query = $this->db->query($q);
        return $query->result_array();
    }
    public function saveCategory($category) {
        $this->db->where(array('catid' => $category['catid']));
        $result = $this->db->get('category');
        if ($result->num_rows() > 0) {
            $this->db->where(array('catid' => $category['catid']));
            $this->db->update('category', $category);
        } else {
            unset($category['catid']);
            $this->db->insert('category', $category);
        }
        return true;
    }
    public function saveRout($rout) {
        $this->db->where(array('routid' => $rout['routid']));
        $result = $this->db->get('rout');
        if ($result->num_rows() > 0) {
            $this->db->where(array('routid' => $rout['routid']));
            $this->db->update('rout', $rout);
        } else {
            unset($rout['routid']);
            $this->db->insert('rout', $rout);
        }
        return true;
    }
    public function saveSubCategory($category) {
        $this->db->where(array('subcatid' => $category['subcatid']));
        $result = $this->db->get('subcategory');
        if ($result->num_rows() > 0) {
            $this->db->where(array('subcatid' => $category['subcatid']));
            $this->db->update('subcategory', $category);
        } else {
            unset($category['subcatid']);
            $this->db->insert('subcategory', $category);
        }
        return true;
    }
    public function saveRecipe($recipe, $recipedetail, $rid) {
        $this->db->where(array('rid' => $rid));
        $result = $this->db->get('recipemain');
        $rid = "";
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $rid = $result['rid'];
            $this->db->where(array('rid' => $rid));
            $this->db->update('recipemain', $recipe);
            $this->db->where(array('rid' => $rid));
            $this->db->delete('recipedetail');
        } else {
            $this->db->insert('recipemain', $recipe);
            $rid = $this->db->insert_id();
        }
        foreach ($recipedetail as $detail) {
            $detail['rid'] = $rid;
            $this->db->insert('recipedetail', $detail);
        }
        return true;
    }
    public function saveBrand($brand) {
        $this->db->where(array('bid' => $brand['bid']));
        $result = $this->db->get('brand');
        if ($result->num_rows() > 0) {
            $this->db->where(array('bid' => $brand['bid']));
            $this->db->update('brand', $brand);
        } else {
            unset($brand['bid']);
            $this->db->insert('brand', $brand);
        }
        return true;
    }
    public function isCategoryAlreadySaved($category) {
        $result = $this->db->query("SELECT * FROM category WHERE catid <> " . $category['catid'] . " AND name = '" . $category['name'] . "'");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function isSubCategoryAlreadySaved($subcategory) {
        $result = $this->db->query("SELECT * FROM subcategory WHERE subcatid <> " . $subcategory['subcatid'] . " AND name = '" . $subcategory['name'] . "'");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function isBrandAlreadySaved($brand) {
        $result = $this->db->query("SELECT * FROM brand WHERE bid <> " . $brand['bid'] . " AND name = '" . $brand['name'] . "'");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function fetchAllCategories() {
        $result = $this->db->get("category");
        return $result->result_array();
    }
    public function fetchAllRoutes() {
        $result = $this->db->get("rout");
        return $result->result_array();
    }
    public function fetchAllSubCategories() {
        $result = $this->db->query("SELECT subcategory.*, category.name AS 'category_name' FROM subcategory INNER JOIN category ON subcategory.catid = category.catid");
        return $result->result_array();
    }
    public function fetchAllBrands() {
        $result = $this->db->get("brand");
        return $result->result_array();
    }
    public function genItemStr($subcatid) {
        $query = $this->db->query("SELECT category.catid, subcatid FROM category INNER JOIN subcategory ON category.catid = subcategory.catid WHERE subcategory.subcatid = $subcatid");
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $catid = str_pad($result[0]['catid'], 2, '0', STR_PAD_LEFT);
            $subcatid = str_pad($result[0]['subcatid'], 2, '0', STR_PAD_LEFT);
            $items_count = $this->count_items($subcatid);
            $code = $items_count + 1;
            $code = str_pad($code, 3, '0', STR_PAD_LEFT);
            return $catid . '-' . $subcatid . '-' . $code;
        }
    }
    public function count_items($subcatid) {
        $query = $this->db->get_where('item', array('subcatid' => $subcatid));
        return $query->num_rows();
    }
    public function recipeExists($rid, $item_id) {
        $result = $this->db->query("SELECT * FROM recipemain WHERE item_id = $item_id AND rid <> $rid");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function fetchRecipe($rid) {
        $result = $this->db->query("SELECT recipemain.*, recipedetail.uom, ROUND(recipedetail.qty, 2) qty, ROUND(recipedetail.weight, 2) weight, recipedetail.item_id AS 'ditem_id', item.item_des FROM recipemain INNER JOIN recipedetail ON recipemain.rid = recipedetail.rid INNER JOIN item item ON item.item_id = recipedetail.item_id WHERE recipemain.rid = $rid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function deleteRecipe($rid) {
        $this->db->where(array('rid' => $rid));
        $result = $this->db->get('recipemain');
        if ($result->num_rows() == 0) {
            return false;
        } else {
            $this->db->where(array('rid' => $rid));
            $result = $this->db->delete('recipemain');
            $this->db->where(array('rid' => $rid));
            $result = $this->db->delete('recipedetail');
            return true;
        }
    }
    public function getMinStockNotifs($company_id) {
        $query = "SELECT item.description, curr_stock, stock_notifs.min_level, order_value, ( SELECT prate FROM stockmain INNER JOIN stockdetail ON stockmain.stid = stockdetail.stid WHERE item_id = item.item_id AND stockmain.company_id = $company_id ORDER BY stockmain.stid DESC LIMIT 1) AS prate, order_value, ( SELECT party.name
		FROM stockmain
		INNER JOIN stockdetail ON stockmain.stid = stockdetail.stid
		INNER JOIN party ON stockmain.party_id = party.pid
		WHERE item_id = item.item_id AND stockmain.company_id = $company_id
		ORDER BY stockmain.stid DESC
		LIMIT 1) AS supplier
		FROM stock_notifs
		INNER JOIN item ON stock_notifs.item_id = item.item_id
		WHERE stock_notifs.company_id = $company_id
		";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function fetchStockOrderCount($company_id) {
        $query = "SELECT COUNT(*) as ORDERCOUNT FROM stock_notifs WHERE company_id = $company_id";
        $result = $this->db->query($query);
        $row = $result->row_array();
        return $row['ORDERCOUNT'];
    }
}