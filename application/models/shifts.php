<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Shifts extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxShiftId() {
        $this->db->select_max('shid');
        $result = $this->db->get('shift');
        $row = $result->row_array();
        $maxId = $row['shid'];
        return $maxId;
    }
    public function isShiftGroupAlreadySaved($shiftgroup) {
        $result = $this->db->query("SELECT * FROM shift_group WHERE gid <> " . $shiftgroup['gid'] . " AND name = '" . $shiftgroup['name'] . "'");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getMaxShiftGroupId() {
        $this->db->select_max('gid');
        $result = $this->db->get('shift_group');
        $row = $result->row_array();
        $maxId = $row['gid'];
        return $maxId;
    }
    public function getMaxAllotShiftGroupId() {
        $this->db->select_max('id');
        $result = $this->db->get('allot_shift');
        $row = $result->row_array();
        $maxId = $row['id'];
        return $maxId;
    }
    public function saveShift($shift) {
        $this->db->where(array('shid' => $shift['shid']));
        $result = $this->db->get('shift');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('shid' => $shift['shid']));
            $result = $this->db->update('shift', $shift);
            $affect = $this->db->affected_rows();
        } else {
            unset($shift['shid']);
            $result = $this->db->insert('shift', $shift);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }

    }
    public function saveShiftGroup($shiftgroup) {
        $this->db->where(array('gid' => $shiftgroup['gid']));
        $result = $this->db->get('shift_group');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('gid' => $shiftgroup['gid']));
            $result = $this->db->update('shift_group', $shiftgroup);
            $affect = $this->db->affected_rows();
        } else {
            unset($shiftgroup['gid']);
            $result = $this->db->insert('shift_group', $shiftgroup);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function saveAllotShift($allotshift) {
        $this->db->where(array('id' => $allotshift['id']));
        $result = $this->db->get('allot_shift');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('id' => $allotshift['id']));
            $result = $this->db->update('allot_shift', $allotshift);
            $affect = $this->db->affected_rows();
        } else {
            unset($allotshift['id']);
            $result = $this->db->insert('allot_shift', $allotshift);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchShift($shid) {
        $result = $this->db->query("SELECT shift_hour,shid, name, TIME_FORMAT(tin, '%h: %i %p') AS tin, TIME_FORMAT(tout, '%h: %i %p') AS tout, TIME_FORMAT(resin, '%h: %i %p') AS resin, TIME_FORMAT(resout, '%h: %i %p') AS resout, restallowed FROM shift WHERE shid = $shid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchShiftGroup($gid) {
        $result = $this->db->query("SELECT gid, name, DATE(DATE) AS date FROM shift_group WHERE gid = $gid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllotShift($id) {
        $result = $this->db->query("SELECT id, DATE(date) AS date, shid, gid FROM allot_shift WHERE id = $id");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllShifts() {
        $result = $this->db->query("SELECT shid, name, TIME_FORMAT(tin, '%h: %i %p') AS tin, TIME_FORMAT(tout, '%h: %i %p') AS tout, TIME_FORMAT(resin, '%h: %i %p') AS resin, TIME_FORMAT(resout, '%h: %i %p') AS resout FROM shift");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllShiftGroups() {
        $result = $this->db->get("shift_group");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchAllAllotShiftGroups() {
        $result = $this->db->query("SELECT id, DATE(_as.DATE) AS date, s.name AS 'shift_name', sg.name AS 'shiftgroup_name', TIME_FORMAT(tin, '%h: %i %p') AS tin, TIME_FORMAT(tout, '%h: %i %p') AS tout, TIME_FORMAT(resin, '%h: %i %p') AS resin, TIME_FORMAT(resout, '%h: %i %p') AS resout FROM allot_shift AS _as INNER JOIN shift AS s ON _as.shid = s.shid INNER JOIN shift_group AS sg ON _as.gid = sg.gid");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function saveGroupAssignedCheck($gid) {
        $this->db->where(array('gid' => $gid));
        $result = $this->db->get('allot_shift');
        if ($result->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function updateGroupAssignedCheck($hiddengid, $gid) {
        $result = $this->db->query("SELECT * FROM allot_shift WHERE gid <> '" . $hiddengid . "' AND gid = '" . $gid . "'");
        if ($result->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
}