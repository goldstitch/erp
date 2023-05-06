<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Datecloses extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxDateCloseId() {
        $result = $this->db->select("SELECT MAX(id) id FROM dateclose");
        $row = $result->result_array();
        $maxId = $row[0]['id'];
        return $maxId;
    }
    public function saveDateClose($dateclose) {
        $this->session->set_userdata('date_close_message', "123");
        $this->db->where(array('date_cl' => $dateclose['date_cl']));
        $result = $this->db->get('dateclose');
        $affect = 0;
        if ($result->num_rows() > 0) {
            return "Already Save";
        } else {
            $this->db->insert('dateclose', $dateclose);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return "false";
        } else {
            return "true";
        }
    }
    public function openDateClose($dateclose) {
        $this->db->where(array('date_cl' => $dateclose['date_cl']));
        $result = $this->db->get('dateclose');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('date_cl' => $dateclose['date_cl']));
            $this->db->delete('dateclose');
            $this->db->insert('dateopen', $dateclose);
            $affect = $this->db->affected_rows();
        } else {
            return "Already Open";
        }
        if ($affect === 0) {
            return "false";
        } else {
            return "true";
        }
    }
    public function fetchDateClose($id) {
        $this->db->where(array('id' => $id));
        $result = $this->db->get('dateclose');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function validateDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') == $date;
    }
    public function CheckDateClose($vrdate) {
        return false;
        $test = $this->validateDate($vrdate);
        if ($this->validateDate($vrdate) == true) {
            $this->db->where(array('date_cl' => $vrdate));
            $result = $this->db->get('dateclose');
            if ($result->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    public function fetchAllDateClose() {
        $result = $this->db->query(" select d.id, date_format(d.date_cl, '%d %b %y') as date_cl,d.remarks,d.date_time,u.uname as user_name 
				from dateclose d 
				inner join user u on u.uid=d.uid
				order by d.date_cl desc");
        return $result->result_array();
    }
}