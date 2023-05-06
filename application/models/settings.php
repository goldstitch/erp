<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function save($sal_calc) {
        $this->db->query('truncate table setting');
        $this->db->insert('setting', array('sal_cal' => $sal_calc));
        return true;
    }
    public function getSalaryPlane() {
        $result = $this->db->get('setting');
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            return $result['sal_cal'];
        }
    }
}