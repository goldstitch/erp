<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Levels extends CI_Controller {
    public function __consruct() {
        parent::__consruct();
    }
    public function index() {
    }
    public function getLevel1() {
        $row = $this->db->get('level1');
        return $row->result_array();
    }
    public function getLevel2() {
        $this->db->order_by('name');
        $row = $this->db->get('level2');
        return $row->result_array();
    }
    public function getLevel3() {
        $query = "SELECT level1.name as l1name,level1.l1 as l1, level2.name as l2name, level2.l2 as l2, level3.name as name, level3.l3 FROM level3 INNER JOIN level2 ON level3.l2 = level2.l2 INNER JOIN level1 ON level2.l1 = level1.l1";
        $row = $this->db->query($query);
        return $row->result_array();
    }
    public function getMaxId($col, $table) {
        $this->db->select_max($col);
        $result = $this->db->get($table);
        $row = $result->row_array();
        $maxId = $row[$col];
        return $maxId;
    }
    public function simpleNameCheck($name, $table) {
        $this->db->where(array('name' => $name));
        $result = $this->db->get($table);
        if ($result->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function updateNameCheck($txtnameHidden, $name, $table) {
        $result = $this->db->query("SELECT * FROM " . $table . " WHERE name <> '" . $txtnameHidden . "' AND name = '" . $name . "'");
        if ($result->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function save($levelDetail, $table, $col) {
        $this->db->where(array($col => $levelDetail[$col]));
        $result = $this->db->get($table);
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where($col, $levelDetail[$col]);
            $affect = $this->db->update($table, $levelDetail);
        } else {
            unset($levelDetail[$col]);
            $this->db->insert($table, $levelDetail);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchAllLevel1() {
        $result = $this->db->get('level1');
        return $result->result_array();
    }
    public function fetchAllLevel2() {
        $result = $this->db->query("SELECT l2.l2, l2.name AS level2_name, l1.name AS level1_name FROM level1 AS l1 INNER JOIN level2 AS l2 ON l2.l1 = l1.l1");
        return $result->result_array();
    }
    public function fetchAllLevel3() {
        $result = $this->db->query("SELECT l3.l3, l3.name AS level3_name, l2.name AS level2_name, l1.name AS level1_name FROM level3 AS l3 INNER JOIN level2 AS l2 ON l3.l2 = l2.l2 INNER JOIN level1 AS l1 ON l2.l1 = l1.l1");
        return $result->result_array();
    }
    public function fetchAllLevel3_crit($typee) {
        $result = $this->db->query("SELECT l3.l3, l3.name AS level3_name, l2.name AS level2_name, l1.name AS level1_name FROM level3 AS l3 INNER JOIN level2 AS l2 ON l3.l2 = l2.l2 INNER JOIN level1 AS l1 ON l2.l1 = l1.l1 where l3.name like '%$typee%' ");
        return $result->result_array();
    }
    public function fetchl1($l1) {
        $this->db->where(array('l1' => $l1));
        $result = $this->db->get('level1');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchl2($l2) {
        $this->db->where(array('l2' => $l2));
        $result = $this->db->get('level2');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchl3($l3) {
        $this->db->where(array('l3' => $l3));
        $result = $this->db->get('level3');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function getLevel3ByName($name) {
        $this->db->where(array('name' => $name));
        $result = $this->db->get('level3');
        return $result->row_array();
    }
    public function genAccStr($level3) {
        $query = $this->db->query("SELECT level3.l3, level2.l2, level1.l1 FROM level3 level3 INNER JOIN level2 level2 ON level3.l2 = level2.l2 INNER JOIN level1 level1 ON level1.l1 = level2.l1 WHERE level3.l3=$level3");
        if ($query) {
            $result = $query->result_array();
            $l1 = str_pad($result[0]['l1'], 2, '0', STR_PAD_LEFT);
            $l2 = str_pad($result[0]['l2'], 2, '0', STR_PAD_LEFT);
            $l3 = str_pad($result[0]['l3'], 2, '0', STR_PAD_LEFT);
            $party_count = $this->count_parties($l3);
            $l4 = $party_count + 1;
            $l4 = str_pad($l4, 4, '0', STR_PAD_LEFT);
            return $l1 . '-' . $l2 . '-' . $l3 . '-' . $l4;
        }
    }
    public function count_parties($level3) {
        $query = $this->db->get_where('party', array('level3' => $level3));
        return $query->num_rows();
    }
}