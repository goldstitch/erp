<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Items extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function fetchUOM() {
        $qry = "SELECT distinct ifnull(item.uom,'') as uom
		FROM `item`

		WHERE item.active = 1 ";
        $query = $this->db->query($qry);
        $result = $query->result_array();
        return $result;
    }
    public function saveUpdateCost($item_id, $qty, $avg_rate) {
        $this->db->where(array('item_id' => $item_id));
        $result = $this->db->get('item');
        if ($result->num_rows() > 0) {
            $q = "UPDATE item set avg_rate=$avg_rate,qty=$qty where item_id =$item_id ";
            $query = $this->db->query($q);
        } else {
            return false;
        }
        return true;
    }

    public function fetch_demand($code) {      
        $result1 = $this->db->query("SELECT name,IFNULL(SUM(issue_qty),0) size 
			FROM material_demand WHERE design_name = '$code' GROUP by name");
        if ($result1->num_rows() > 0) {
            return $result1->result_array();
        } else {
            return false;
        }
    }

    public function fetch_demand_qty($id,$code) {      
        $result1 = $this->db->query("SELECT name,IFNULL(SUM(issue_qty),0) size 
			FROM material_demand WHERE design_name ='$code' and name LIKE '%$id' ");
        if ($result1->num_rows() > 0) {
            return $result1->result_array();
        } else {
            return false;
        }
    }
    public function search_item($barcode) {
        $qry = "";
        $qry = "SELECT ifnull(lp.rate,0) as item_last_prate,ifnull(item.avg_rate,0) as item_avg_rate,item.*,item.size, category.name AS 'category_name',
		subcategory.name AS 'subcategory_name', brand.name AS 'brand_name', IFNULL(sd.stqty,0) AS stqty, IFNULL(sd.stweight,0) AS stweight
		FROM item
		left JOIN category ON item.catid = category.catid
		LEFT JOIN subcategory ON item.subcatid = subcategory.subcatid
		LEFT JOIN brand ON item.bid = brand.bid
		
		LEFT JOIN (
		SELECT item_id, IFNULL(SUM(qty),0) stqty, IFNULL(SUM(weight),0) stweight
		FROM orderdetail
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

        WHERE item.item_barcode='$barcode';";
        $result = $this->db->query($qry);
        return $result->result_array();
    }


    public function fetchAccountEffects() {
        $sql = "SELECT ss.inventory_id,ss.income_id,ss.cost_id, IFNULL(inv.name,'') AS inventory_name, IFNULL(inc.name,'') AS income_name, IFNULL(cost.name,'') AS cost_name
		FROM setting_configuration ss
		LEFT JOIN party inv ON ss.inventory_id = inv.pid
		LEFT JOIN party inc ON ss.income_id = inc.pid
		LEFT JOIN party cost ON ss.cost_id = cost.pid";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    public function getMaxId() {
        $this->db->select_max('vrnoa');
        $result = $this->db->get('item');
        $result = $result->row_array();
        return $result['vrnoa'];
    }
    public function fetchAllColors() {
        $result = $this->db->get("color");
        return $result->result_array();
    }
    public function fetchAllSizes() {
        $result = $this->db->get("size");
        return $result->result_array();
    }
    public function isColorAlreadySaved($color) {
        $result = $this->db->query("SELECT * FROM color WHERE color_id <> " . $color['color_id'] . " AND name = '" . $color['name'] . "'");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function saveColor($color) {
        $this->db->where(array('color_id' => $color['color_id']));
        $result = $this->db->get('color');
        if ($result->num_rows() > 0) {
            $this->db->where(array('color_id' => $color['color_id']));
            $this->db->update('color', $color);
            return true;
        } else {
            unset($color['color_id']);
            $this->db->insert('color', $color);
            $id = $this->db->insert_id();
            $this->db->where(array('color_id' => $id));
            $result = $this->db->get('color');
            return $result->row_array();
        }
        return true;
    }
    public function isSizeAlreadySaved($size) {
        $result = $this->db->query("SELECT * FROM size WHERE size_id <> " . $size['size_id'] . " AND name = '" . $size['name'] . "'");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function saveSize($size) {
        $this->db->where(array('size_id' => $size['size_id']));
        $result = $this->db->get('size');
        if ($result->num_rows() > 0) {
            $this->db->where(array('size_id' => $size['size_id']));
            $this->db->update('size', $size);
            return true;
        } else {
            unset($size['size_id']);
            $this->db->insert('size', $size);
            $id = $this->db->insert_id();
            $this->db->where(array('size_id' => $id));
            $result = $this->db->get('size');
            return $result->row_array();
        }
        return true;
    }
    public function getMaxColorId() {
        $this->db->select_max('color_id');
        $result = $this->db->get('color');
        $row = $result->row_array();
        $maxId = $row['color_id'];
        return $maxId;
    }
    public function getMaxSizeId() {
        $this->db->select_max('size_id');
        $result = $this->db->get('size');
        $row = $result->row_array();
        $maxId = $row['size_id'];
        return $maxId;
    }
    public function getMaxMade_Id() {
        $this->db->select_max('made_id');
        $result = $this->db->get('made');
        $result = $result->row_array();
        return $result['made_id'];
    }
    public function searchitem($search, $pid) {
        $qry = "";
        $qry = "SELECT ifnull(lp.rate,0) as item_last_prate,ifnull(item.avg_rate,0) as item_avg_rate,item.*,item.size, category.name AS 'category_name',
		subcategory.name AS 'subcategory_name', brand.name AS 'brand_name', IFNULL(sd.stqty,0) AS stqty, IFNULL(sd.stweight,0) AS stweight
		FROM item
		left JOIN category ON item.catid = category.catid
		LEFT JOIN subcategory ON item.subcatid = subcategory.subcatid
		LEFT JOIN brand ON item.bid = brand.bid
		
		LEFT JOIN (
		SELECT item_id, IFNULL(SUM(qty),0) stqty, IFNULL(SUM(weight),0) stweight
		FROM orderdetail
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
		OR item.artcile_no LIKE '%" . $search . "%' 
		OR category.name LIKE '%" . $search . "%' 
		OR subcategory.name LIKE '%" . $search . "%' 
		OR item.barcode LIKE '%" . $search . "%' 
		OR brand.name LIKE '" . $search . "%') 
		LIMIT 0, 20;";
        $result = $this->db->query($qry);
        return $result->result_array();
    }
    public function getiteminfobyid($item_id, $pid) {
        $qry = "";
        $qry = "SELECT ifnull(lp.rate,0) as item_last_prate,ifnull(avg_rate.avg_rate,0) as item_avg_rate,item.*,ifnull(item.cost_price,0) as cost_price,ifnull(item.cost_price,0) as prate1,ifnull(item.srate,0) as srate1,item.size, category.name AS 'category_name',
		subcategory.name AS 'subcategory_name', brand.name AS 'brand_name', IFNULL(sd.stqty,0) AS stqty, IFNULL(sd.stweight,0) AS stweight
		FROM item
		left JOIN category ON item.catid = category.catid
		LEFT JOIN subcategory ON item.subcatid = subcategory.subcatid
		LEFT JOIN brand ON item.bid = brand.bid

		LEFT JOIN (
		SELECT item_id, IFNULL(SUM(qty),0) stqty, IFNULL(SUM(weight),0) stweight
		FROM orderdetail
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



		WHERE item.active=1 AND  item.item_id=$item_id
		;";
        $result = $this->db->query($qry);
        return $result->result_array();
    }
    public function delete($vrnoa) {
        $result = $this->db->query("select item_id from  stockdetail where item_id in (select item_id from item where vrnoa=" . $vrnoa . ")");
        if ($result->num_rows() > 0) {
            return 'used';
        }
        $result = $this->db->query("select item_id from  orderdetail where item_id in (select item_id from item where vrnoa=" . $vrnoa . ")");
        if ($result->num_rows() > 0) {
            return 'used';
        }
        $this->db->where(array('vrnoa' => $vrnoa));
        $this->db->delete('item');
        return true;
    }
    public function deleteCatagory($catid) {
        $this->db->where(array('catid' => $catid));
        $result = $this->db->get('item');
        if ($result->num_rows() > 0) {
            return 'used';
        }
        $this->db->where(array('catid' => $catid));
        $this->db->delete('category');
        return true;
    }
    public function deleteSubCatagory($subcatid) {
        $this->db->where(array('subcatid' => $subcatid));
        $result = $this->db->get('item');
        if ($result->num_rows() > 0) {
            return 'used';
        }
        $this->db->where(array('subcatid' => $subcatid));
        $this->db->delete('subcategory');
        return true;
    }
    public function deleteBrand($bid) {
        $this->db->where(array('bid' => $bid));
        $result = $this->db->get('item');
        if ($result->num_rows() > 0) {
            return 'used';
        }
        $this->db->where(array('bid' => $bid));
        $this->db->delete('brand');
        return true;
    }
    public function deleteColor($id) {
        $this->db->where(array('id' => $id));
        $result = $this->db->get('item');
        if ($result->num_rows() > 0) {
            return 'used';
        }
        $this->db->where(array('id' => $id));
        $this->db->delete('made');
        return true;
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
        if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
            $item['photo'] = $this->upload_photo($item);
        } else {
            unset($item['photo']);
        }
        $item['item_code'] = $this->genItemStr($item['subcatid']);
        $this->db->where(array('item_id' => $item['item_id']));
        $result = $this->db->get('item');
        $affect = 0;
        $item_id = "";
        if ($result->num_rows() > 0) {
            $this->db->where('item_id', $item['item_id']);
            $affect = $this->db->update('item', $item);
            $item_id = $item['item_id'];
        } else {
            unset($item['item_id']);
            $this->db->insert('item', $item);
            $affect = $this->db->affected_rows();
            $item_id = $this->db->insert_id();
        }
        if ($affect === 0) {
            return false;
        } else {
            return $item_id;
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
        $sql = "SELECT item.*,grp.sizes_all,grp.color_all,att.photo1,att.photo2,att.photo3,att.photo4,att.photo5,att.photo6 ,party.name as supplier_name,ifnull(inv.name,'') as inventory_name,ifnull(inc.name,'') as income_name,ifnull(cost.name,'') as cost_name,ifnull(user.uname,'')user_name, CAST(DATE_FORMAT(DATE_ADD(item.date_time, INTERVAL 0 hour),'%d/%m/%y %h:%i %p') AS CHAR) AS date_time
		from item
		LEFT JOIN attachimage as att on att.etype=item.etype 
		left join(
		select vrnoa, GROUP_CONCAT(DISTINCT item.size_id) sizes_all,GROUP_CONCAT( DISTINCT item.color_id) color_all
		from item
		group by vrnoa
		) as grp on grp.vrnoa=item.vrnoa
		left join party on party.pid=item.supplier_id
		
		LEFT JOIN party inv ON item.inventory_id = inv.pid
		LEFT JOIN party inc ON item.income_id = inc.pid
		LEFT JOIN party cost ON item.cost_id = cost.pid

		LEFT JOIN user  ON user.uid = item.uid


		where item.vrnoa=$item_id";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
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
        $result = $this->db->query("SELECT * from item ");
        return $result->result_array();
    }
    public function fetchAllArticles() {
        $result = $this->db->query("SELECT distinct short_code,vrnoa 
			from item 
			where ifnull(short_code,'')<>''
			order by short_code ");
        return $result->result_array();
    }
    public function fetchAllItems() {
        $result = $this->db->query("SELECT * from item");
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
    public function genItemStringUpdate($catid, $subcatid, $item_id) {
        $query = $this->db->query("SELECT item_code FROM item WHERE catid=$catid and subcatid = $subcatid and item_id= $item_id ");
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $item_code = $result[0]['item_code'];
            if (strlen($item_code) < 5) $item_code = $this->genItemString($catid, $subcatid);
            return $item_code;
        } else {
            $item_code = $this->genItemString($catid, $subcatid);
            return $item_code;
        }
    }
    public function genItemString($catid, $subcatid, $size_id, $color_id) {
        $catid = str_pad($catid, 2, '0', STR_PAD_LEFT);
        $subcatid = str_pad($subcatid, 2, '0', STR_PAD_LEFT);
        $size_id = str_pad($size_id, 2, '0', STR_PAD_LEFT);
        $color_id = str_pad($color_id, 2, '0', STR_PAD_LEFT);
        return $catid . $subcatid . $size_id . $color_id;
    }
    public function count_items($subcatid) {
        $query = $this->db->get_where('item', array('subcatid' => $subcatid));
        return $query->num_rows();
    }
    public function isItemAlreadySaved($item) {
        $item = json_decode($_POST['items'], true);
        $itembarcode = $item[0]['item_barcode'];
        $vrnoa = $item[0]['vrnoa'];
        $qry = "SELECT * FROM item WHERE vrnoa <> " . $vrnoa . " AND item_des = '" . $item[0]['item_des'] . "'";
        $result = $this->db->query($qry);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            if ($item['item_barcode'] = !'') {
                $qry = "SELECT * FROM item WHERE vrnoa <> " . $vrnoa . " AND item_barcode = '" . $itembarcode . "'";
                $result = $this->db->query($qry);
                if ($result->num_rows() > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
    public function isShortCodeAlreadySaved($item) {
        $item = json_decode($_POST['items'], true);
        $result = $this->db->query("SELECT * FROM item WHERE vrnoa <> " . $item[0]['vrnoa'] . " AND short_code = '" . $item[0]['short_code'] . "' and short_code <> ''  ");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function fetchAll($activee = - 1, $category = '') {
        $sts = " where item.item_des<>'' ";
        if ($activee == 1) {
            $sts = $sts . " and item.active=1  ";
        }
        if ($category !== '') {
            $sts = $sts . "  and category.name='" . $category . "' ";
        }
        $result = $this->db->query("SELECT item.*,item.srate,item.cost_price, category.name AS 'category_name',item.size as size, subcategory.name AS 'subcategory_name', brand.name AS 'brand_name', ifnull(sd.stqty,0) as stqty, ifnull(sd.stweight,0) as stweight,IFNULL(lp.rate,0) last_prate 
			FROM item
			left JOIN category ON item.catid = category.catid 
			left JOIN subcategory ON item.subcatid = subcategory.subcatid 
			left JOIN brand ON item.bid = brand.bid
			LEFT JOIN(
			SELECT d.item_id,(d.rate) AS rate FROM orderdetail d WHERE d.qty>0 AND d.oid=(
			SELECT oid FROM orderdetail WHERE item_id=d.item_id ORDER BY oid DESC LIMIT 1) 
			GROUP BY d.item_id
			ORDER BY d.item_id 
			) AS lp ON lp.item_id=item.item_id

			left join (
			select item_id,ifnull(sum(qty),0) stqty,ifnull(sum(weight),0) stweight 
			from stockdetail 
			group by item_id ) sd on sd.item_id=item.item_id 

			$sts

			");
        return $result->result_array();
    }
    public function fetchAll_report($from, $to, $orderby, $status, $crit) {
        $sql = "SELECT item.item_id,item.vrnoa,item.item_code,item.item_des,item.uom,item.srate,item.artcile_no,item.netweight, category.name AS 'category_name', subcategory.name AS 'subcategory_name', brand.name AS 'brand_name',ifnull(item.qty,0)qty,ifnull(item.avg_rate,0)avg_rate
		FROM item
		left JOIN category ON item.catid = category.catid
		left JOIN subcategory ON item.subcatid = subcategory.subcatid
		left JOIN brand ON item.bid = brand.bid
		WHERE 1=1 $crit
		ORDER BY $orderby";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    public function fetchItemsByStock() {
        $result = $this->db->query("SELECT i.item_id, i.description, round(SUM(d.qty)) stock, round(d.prate) prate FROM stockmain m INNER JOIN stockdetail d ON m.stid = d.stid INNER JOIN item i on d.item_id = i.item_id GROUP BY d.item_id");
        return $result->result_array();
    }
    public function fetchItemLedgerReport($from, $to, $item_id, $company_id, $pid) {
        $crit = "";
        if ($item_id != 0) {
            $crit = " d.item_id=" . $item_id . " and ";
        }
        if ($pid != 0) {
            $crit = $crit . " m.party_id=" . $pid . " and ";
        }
        $result = $this->db->query("SELECT IFNULL(d.rate,0)rate,IFNULL(m.workorder,'')workorder,i.uom,i.item_des,d.rate,party.name AS party_name, m.vrnoa, m.etype, DATE(m.vrdate) date, i.description, m.remarks, dep.name, if(i.uom='dozen', ROUND(IFNULL(d.qty/12,0),0), IFNULL(d.qty,0)) AS qty, d.weight,ifnull(d.amount,0)netamount
			FROM stockmain m
			INNER JOIN stockdetail d ON m.stid = d.stid
			INNER JOIN item i ON i.item_id = d.item_id
			LEFT JOIN department dep ON dep.did = d.godown_id
			LEFT JOIN party AS party ON party.pid=m.party_id
			WHERE $crit DATE(m.vrdate) >= '" . $from . "' AND DATE(m.vrdate) <= '" . $to . "' $company_id
			ORDER BY m.vrdate, d.stdid");
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
    public function fetchSubCatWithCatid($catid) {
        $result = $this->db->query("SELECT subcategory.*, category.name AS 'category_name' FROM subcategory INNER JOIN category ON subcategory.catid = category.catid where category.catid=$catid");
        return $result->result_array();
    }
    public function fetchModels($catid, $subcatid) {
        $result = $this->db->query("SELECT distinct model  FROM item INNER JOIN category ON item.catid = category.catid INNER JOIN subcategory ON subcategory.subcatid = item.subcatid where item.catid=$catid and item.subcatid=$subcatid");
        return $result->result_array();
    }
    public function saveMade($made) {
        $this->db->where(array('made_id' => $made['made_id']));
        $result = $this->db->get('made');
        if ($result->num_rows() > 0) {
            $this->db->where(array('made_id' => $made['made_id']));
            $this->db->update('made', $made);
            return true;
        } else {
            unset($made['made_id']);
            $this->db->insert('made', $made);
            $id = $this->db->insert_id();
            $this->db->where(array('made_id' => $id));
            $result = $this->db->get('made');
            return $result->row_array();
        }
    }
    public function saveUsed($used) {
        $this->db->where(array('used_id' => $used['used_id']));
        $result = $this->db->get('used');
        if ($result->num_rows() > 0) {
            $this->db->where(array('used_id' => $used['used_id']));
            $this->db->update('used', $used);
            return true;
        } else {
            unset($used['used_id']);
            $this->db->insert('used', $used);
            $id = $this->db->insert_id();
            $this->db->where(array('used_id' => $id));
            $result = $this->db->get('used');
            return $result->row_array();
        }
    }
    public function fetchMade($made_id) {
        $this->db->where(array('made_id' => $made_id));
        $result = $this->db->get('made');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchUsed($used_id) {
        $this->db->where(array('used_id' => $used_id));
        $result = $this->db->get('used');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function isUsedAlreadySaved($used) {
        $result = $this->db->query("SELECT * FROM used WHERE used_id <> " . $used['used_id'] . " AND name = '" . $used['name'] . "'");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function isMadeAlreadySaved($made) {
        $result = $this->db->query("SELECT * FROM made WHERE made_id <> " . $made['made_id'] . " AND name = '" . $made['name'] . "'");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function savelist($item) {
        $item = json_decode($_POST['items'], true);
        $vrnoa = $item[0]['vrnoa'];
        $affect = 0;
        foreach ($item as $detail) {
            $this->db->where(array('vrnoa' => $vrnoa, 'color_id' => $detail['color_id'], 'size_id' => $detail['size_id']));
            $result = $this->db->get('item');
            if ($result->num_rows() > 0) {
                $result = $result->row_array();
                $detail['item_id'] = $result['item_id'];
                $detail['item_code'] = $this->genItemString($detail['catid'], $detail['subcatid'], $detail['item_id'], $detail['size_id'], $detail['color_id']);
                $this->db->where(array('item_id' => $detail['item_id']));
                $affect = $this->db->update('item', $detail);
            } else {
                $detail['item_code'] = $this->genItemString($detail['catid'], $detail['subcatid'], $detail['size_id'], $detail['color_id']);
                $this->db->insert('item', $detail);
                $affect = $this->db->affected_rows();
            }
        }
        return true;
    }
    public function fetchAllBrands() {
        $result = $this->db->get("brand");
        return $result->result_array();
    }
    public function fetchAllMades() {
        $result = $this->db->get("made");
        return $result->result_array();
    }
    public function fetchAllUsed() {
        $result = $this->db->get("used");
        return $result->result_array();
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
        $sql = "SELECT i.item_des description, i.MIN_LEVEL min_level, SUM(d.qty) AS 'curr_stock', CAST(i.min_level AS UNSIGNED) - SUM(d.qty) AS 'order_value', IFNULL(lp.rate,0) prate, IFNULL(lp.party_name,'') supplier
		FROM stockdetail d
		INNER JOIN stockmain m ON m.stid = d.stid
		INNER JOIN item i ON d.item_id = i.item_id
		LEFT JOIN category cat ON cat.catid = i.catid
		LEFT JOIN subcategory subcat ON subcat.subcatid = i.subcatid
		LEFT JOIN brand b ON b.bid = i.bid
		LEFT JOIN department dep ON dep.did = d.godown_id
		LEFT JOIN(
		SELECT t1.item_id, t1.rate,t1.oid,party.name party_name
		FROM orderdetail t1
		INNER JOIN ordermain ON ordermain.oid=t1.oid
		INNER JOIN party ON ordermain.party_id=party.pid
		JOIN (
		SELECT item_id, MAX(odid) odid
		FROM orderdetail
		WHERE oid IN (
		SELECT oid
		FROM ordermain
		WHERE ETYPE='purchase')
		GROUP BY item_id) t2 ON t1.item_id = t2.item_id AND t1.odid = t2.odid
		GROUP BY t1.item_id,t1.rate,t1.oid
		) AS lp ON lp.item_id=i.item_id
		where ifnull(i.min_level,0)>0
		GROUP BY i.item_id

		HAVING `order_value` > 0";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    public function fetchStockOrderCount($company_id) {
        $query = "SELECT COUNT(*) as ORDERCOUNT FROM stock_notifs WHERE company_id = $company_id";
        $result = $this->db->query($query);
        $row = $result->row_array();
        return $row['ORDERCOUNT'];
    }
}