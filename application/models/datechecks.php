<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Datechecks extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function dateChecking($vrDate) {
        return true;
        $userId = $this->session->userdata('usertype');
        if ($userId != 'Super Admin') {
            date_default_timezone_get('Asia/Karachi');
            $currentDate = date("Y/m/d");
            $previousDate = date('Y-m-d', strtotime($currentDate . ' -3 day'));
            if ($vrDate <= $currentDate && $vrDate >= $previousDate) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}