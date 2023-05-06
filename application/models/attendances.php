<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Attendances extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxId() {
        $this->db->select_max('dcno');
        $result = $this->db->get('clg_atndetail_tbl');
        $row = $result->row_array();
        $maxId = $row['dcno'];
        return $maxId;
    }
    public function getMaxStaffAtndId() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select_max('dcno');
        $this->db->where(array('etype' => 'vr_atnd', 'company_id' => $company_id));
        $result = $this->db->get('staffatndetail');
        $row = $result->row_array();
        $maxId = $row['dcno'];
        return $maxId;
    }
    public function save($atndcs, $dcno) {
        $this->db->where(array('dcno' => $dcno));
        $this->db->delete('clg_atndetail_tbl');
        $affect = 0;
        foreach ($atndcs as $result) {
            $result['dcno'] = $dcno;
            $this->db->insert('clg_atndetail_tbl', $result);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function updateAttendance($attendance) {
        $this->db->where(array('date' => $attendance['date'], 'staid' => $attendance['staid']));
        $this->db->update('staffatndetail', $attendance);
        $affect = $this->db->affected_rows();
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function updateAttendanceMultiple($attendance) {
        foreach ($attendance as $oid) {
            $this->db->query("UPDATE staffatndetail SET status = '" . $oid['status'] . "', description='" . $oid['description'] . "' WHERE atid =" . $oid['atid'] . " ");
        }
        return true;
    }
    public function post($vouchers) {
        $errors = array();
        foreach ($vouchers as $voucher) {
            $dcno = $this->getMaxStaffAtndId();
            $dcno++;
            foreach ($voucher as $atnd) {
                $saved = $this->isAtndAlreadySaved($atnd['date'], $atnd['did'], $atnd['staid']);
                if ($saved === false) {
                    $atnd['dcno'] = $dcno;
                    $this->db->insert('staffatndetail', $atnd);
                } else {
                    array_push($errors, $saved);
                }
            }
        }
        return $errors;
    }
    public function isAtndAlreadySaved($date, $did, $staid) {
        $saved = array();
        $query = "SELECT d.name AS 'dept_name' FROM staffatndetail AS stf INNER JOIN department AS d ON stf.did = d.did where stf.date = '" . $date . "' AND stf.did = $did AND stf.staid = $staid AND stf.etype='vr_atnd'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $result = $result->row_array();
            $saved['dept_name'] = $result['dept_name'];
            $saved['date'] = $date;
            $saved['did'] = $did;
            return $saved;
        } else {
            return false;
        }
    }
    public function saveStaff($atndcs, $dcno) {
        $atndcs = json_decode($atndcs, true);
        $this->db->where(array('dcno' => $dcno, 'etype' => 'vr_atnd'));
        $this->db->delete('staffatndetail');
        $affect = 0;
        foreach ($atndcs as $result) {
            $result['dcno'] = $dcno;
            $this->db->insert('staffatndetail', $result);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetch($dcno) {
        $result = $this->db->query("SELECT dcno, ad.cmid, ad.stdid, status, ad.date, description, stu.name, stu.fname FROM clg_atndetail_tbl AS ad INNER JOIN clg_student_tbl AS stu ON ad.stdid = stu.stdid WHERE ad.dcno = $dcno");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchStaff($dcno, $company_id) {
        $result = $this->db->query("SELECT sl.designation, atn.atid, atn.staid, stf.type, atn.did, atn.shid, atn.date, atn.dcno, atn.description, atn.status, atn.postdate, d.name AS 'dept_name', stf.name AS 'staff_name', sh.name AS 'shift_name'
			,TIME_FORMAT(ifnull(atn.tin,'0:0'),'%H:%i') as tin,TIME_FORMAT(ifnull(atn.tout,'00:00'),'%H:%i') tout,IFNULL(round(atn.late,2),0) late,IFNULL(round(atn.wh,2),0) wh
									FROM staffatndetail atn
									INNER JOIN staff stf ON stf.staid = atn.staid
									INNER JOIN salary sl ON stf.staid = sl.staid
									INNER JOIN shift sh ON sh.shid = atn.shid
									INNER JOIN department d ON d.did = atn.did
									WHERE atn.dcno = $dcno AND atn.etype = 'vr_atnd' and atn.company_id=$company_id");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function studentAttendanceStatusWiseReport($from, $to, $cmid, $stdid, $status) {
        $query = "";
        if ($stdid == '') {
            $query = "SELECT cm.name AS 'course_name', ad.status, DATE_FORMAT(DATE(ad.date), '%d-%m-%Y') AS date, stu.name AS 'student_name'FROM (clg_atndetail_tbl AS ad INNER JOIN clg_student_tbl AS stu ON ad.stdid=stu.stdid) INNER JOIN clg_coursemain_tbl AS cm ON cm.cmid=stu.cmid WHERE ad.cmid = $cmid AND DATE(ad.date) >= '" . $from . "' AND DATE(ad.date) <= '" . $to . "'";
        } else {
            $query = "SELECT cm.name AS 'course_name', ad.status, DATE_FORMAT(DATE(ad.date), '%d-%m-%Y') AS date, stu.name AS 'student_name'FROM (clg_atndetail_tbl AS ad INNER JOIN clg_student_tbl AS stu ON ad.stdid=stu.stdid) INNER JOIN clg_coursemain_tbl AS cm ON cm.cmid=stu.cmid WHERE ad.cmid = $cmid AND ad.stdid = $stdid AND DATE(ad.date) >= '" . $from . "' AND DATE(ad.date) <= '" . $to . "'";
        }
        if ($status != '-1') {
            $query.= " AND ad.status = '" . $status . "'";
            $query.= " ORDER BY cm.name, stu.name, ad.date";
        }
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function staffAttendanceStatusWiseReport($from, $to, $did, $staid, $status) {
        $query = "";
        if ($staid == '') {
            $query = "SELECT ad.dcno, d.name AS 'dept_name', s.name AS 'shift_name', ad.status, DATE_FORMAT(DATE(ad.date), '%d-%m-%Y') AS date, stf.name AS 'staff_name'FROM (staffatndetail AS ad INNER JOIN staff AS stf ON stf.staid=ad.staid) INNER JOIN department AS d ON d.did=ad.did INNER JOIN shift AS s ON s.shid=ad.shid WHERE DATE(ad.date) >= '" . $from . "' AND DATE(ad.date) <= '" . $to . "' AND ad.etype='vr_atnd'";
        } else {
            $query = "SELECT ad.dcno, d.name AS 'dept_name', s.name AS 'shift_name', ad.status, DATE_FORMAT(DATE(ad.date), '%d-%m-%Y') AS date, stf.name AS 'staff_name'FROM (staffatndetail AS ad INNER JOIN staff AS stf ON stf.staid=ad.staid) INNER JOIN department AS d ON d.did=ad.did INNER JOIN shift AS s ON s.shid=ad.shid WHERE ad.staid = $staid AND DATE(ad.date) >= '" . $from . "' AND DATE(ad.date) <= '" . $to . "' AND ad.etype='vr_atnd'";
        }
        if ($status != '-1') {
            $query.= " AND ad.status = '" . $status . "'";
        }
        if ($did != '-1') {
            $query.= " AND ad.did = $did";
        }
        $query.= " ORDER BY d.name, stf.staid, ad.date";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function studentAttendanceMonthWiseReport($from, $to, $cmid, $stdid) {
        $query = "";
        if ($stdid == '') {
            $query = "SELECT ad.stdid, YEAR(ad.date) AS 'year', MONTHNAME(ad.date) AS 'month', stu.name AS 'student_name', stu.fname AS 'father_name', cm.name AS 'course_name', COUNT(CASE WHEN ad.status='absent' THEN ad.stdid END) AS 'absent', COUNT(CASE WHEN ad.status='present' THEN ad.stdid END) AS 'present', COUNT(CASE WHEN ad.status='leave' THEN ad.stdid END) AS 'leave'FROM clg_atndetail_tbl AS ad INNER JOIN clg_student_tbl AS stu ON ad.stdid=stu.stdid INNER JOIN clg_coursemain_tbl AS cm ON cm.cmid=stu.cmid WHERE ad.cmid = $cmid AND DATE(ad.date) >= '" . $from . "' AND DATE(ad.date) <= '" . $to . "'GROUP BY MONTHNAME(ad.date), YEAR(ad.date), ad.stdid ORDER BY YEAR(ad.date) DESC, MONTHNAME(ad.date), cm.name, stu.name";
        } else {
            $query = "SELECT ad.stdid, YEAR(ad.date) AS 'year', MONTHNAME(ad.date) AS 'month', stu.name AS 'student_name', stu.fname AS 'father_name', cm.name AS 'course_name', COUNT(CASE WHEN ad.status='absent' THEN ad.stdid END) AS 'absent', COUNT(CASE WHEN ad.status='present' THEN ad.stdid END) AS 'present', COUNT(CASE WHEN ad.status='leave' THEN ad.stdid END) AS 'leave'FROM clg_atndetail_tbl AS ad INNER JOIN clg_student_tbl AS stu ON ad.stdid=stu.stdid INNER JOIN clg_coursemain_tbl AS cm ON cm.cmid=stu.cmid WHERE ad.cmid = $cmid AND DATE(ad.date) >= '" . $from . "' AND DATE(ad.date) <= '" . $to . "' AND ad.stdid = $stdid GROUP BY MONTHNAME(ad.date), YEAR(ad.date), ad.stdid ORDER BY YEAR(ad.date) DESC, MONTHNAME(ad.date), cm.name, stu.name";
        }
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function monthlyAttendanceReport($month, $year, $cmid) {
        $result = $this->db->query("SELECT ad.stdid, YEAR(ad.date) AS 'year', MONTHNAME(ad.date) AS 'month', DAY(ad.date) AS day, stu.name AS 'student_name', stu.fname AS 'father_name', cm.name AS 'course_name', ad.status FROM clg_atndetail_tbl AS ad INNER JOIN clg_student_tbl AS stu ON ad.stdid=stu.stdid INNER JOIN clg_coursemain_tbl AS cm ON cm.cmid=stu.cmid WHERE MONTHNAME(ad.date) = '" . $month . "' AND YEAR(ad.date) = $year AND ad.cmid = $cmid GROUP BY ad.stdid, ad.date ORDER BY stu.name");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function staffMonthlyAttendanceReport($month, $year, $did) {
        $query = "SELECT ad.staid, YEAR(ad.date) AS 'year', MONTHNAME(ad.date) AS 'month', DAY(ad.date) AS day, stf.name AS 'staff_name', stf.fname AS 'father_name', d.name AS 'dept_name', ad.status FROM staffatndetail AS ad INNER JOIN staff AS stf ON ad.staid=stf.staid INNER JOIN department AS d ON d.did=stf.did WHERE MONTHNAME(ad.date) = '" . $month . "' AND YEAR(ad.date) = $year";
        if ($did != '-1') {
            $query.= " AND ad.did = $did";
        }
        $query.= " AND ad.etype = 'vr_atnd' GROUP BY d.name,ad.staid, ad.date ORDER BY d.name,stf.name,YEAR(ad.date), MONTHNAME(ad.date) , DAY(ad.date)";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function staffAttendanceSheet($from, $to, $did, $staid) {
        $query = "";
        if ($staid !== "") {
            $query = " and stf.staid=" . $staid . " ";
        }
        if ($did !== "") {
            $query = " and stf.did=" . $did . " ";
        }
        $query = "SELECT stf.staid, stf.name, dp.name AS 'department_name', sl.designation, ifnull(stf.paidleave,0) + ifnull(stf.medleave,0) AS pa, (COUNT(CASE WHEN d.STATUS = 'Paid Leave' THEN d.staid END)) as avail, COUNT(CASE WHEN d.STATUS = 'Paid Leave' THEN d.staid END) AS paidleave,  COUNT(CASE WHEN d.STATUS = 'Gusted Holiday' THEN d.staid END) gustedholiday,  ifnull(stf.paidleave,0) + ifnull(stf.medleave,0) - ((COUNT(CASE WHEN d.STATUS = 'Paid Leave' THEN d.staid END))) as rem 
			FROM staff stf 
			INNER JOIN salary sl ON stf.staid = sl.staid 
			INNER JOIN staffatndetail d ON stf.staid = d.staid 
			INNER JOIN department dp ON stf.did = dp.did 
			WHERE DATE(d.date) >= '" . $from . "' AND DATE(d.date) <= '" . $to . "' AND d.etype = 'vr_atnd' $query 
				GROUP BY stf.staid ORDER BY d.did, stf.staid, d.date";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function isVoucherAlreadySaved($date, $dids, $dcno, $typee) {
        $_dids = array();
        $type_chk = "'a'";
        foreach ($typee as $type_1) {
            $type_chk.= ",'$type_1'";
        }
        foreach ($dids as $did) {
            $query = "select did from staffatndetail where date = '" . $date . "' AND did = $did AND etype ='vr_atnd' and staid in (select staid from staff where type in ($type_chk) )";
            if ($dcno != "") {
                $query.= " AND dcno <> $dcno";
            }
            $result = $this->db->query($query);
            if ($result->num_rows() > 0) {
                $result = $result->row_array();
                array_push($_dids, $result['did']);
            }
        }
        if (count($_dids) > 0) {
            return $_dids;
        } else {
            return false;
        }
    }
    public function fetchStaffForTimeInOut($staid) {
        $result = $this->db->query("SELECT * FROM staff WHERE staid = $staid");
        if ($result->num_rows() == 0) {
            return false;
        } else {
            $result = $this->db->query("SELECT * FROM staffatndetail WHERE etype='man_atnd' AND date(DATE) = DATE(NOW()) AND staid = $staid ORDER BY TIME(postdate)");
            $data = $result->row_array();
            if ($result->num_rows() == 0) {
                $this->db->query("INSERT INTO staffatndetail(`staid`, `did`, `shid`, `date`, `dcno`, `description`, `status`, `postdate`, `tin`, `tout`, `etype`) (SELECT stf.staid, d.did, s.shid, NOW() AS DATE, (SELECT IFNULL(MAX(dcno), 0)+1 AS dcno FROM staffatndetail WHERE etype = 'man_atnd') AS dcno, '' AS description, 'Present', NOW() AS postdate, CONCAT('0000-00-00 ', TIME(NOW())) AS tin, '' AS tout, 'man_atnd' AS etype FROM department AS d INNER JOIN staff AS stf ON d.did=stf.did INNER JOIN (allot_shift AS `as` INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid WHERE stf.staid = $staid)");
            } elseif (($result->num_rows() % 2) == 0) {
                $this->db->query("INSERT INTO staffatndetail(`staid`, `did`, `shid`, `date`, `dcno`, `description`, `status`, `postdate`, `tin`, `tout`, `etype`) (SELECT stf.staid, d.did, s.shid, NOW() AS DATE, (SELECT IFNULL(MAX(dcno), 0)+1 AS dcno FROM staffatndetail WHERE etype = 'man_atnd') AS dcno, '' AS description, 'Present', NOW() AS postdate, CONCAT('0000-00-00 ', TIME(NOW())) AS tin, '' AS tout, 'man_atnd' AS etype FROM department AS d INNER JOIN staff AS stf ON d.did=stf.did INNER JOIN (allot_shift AS `as` INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid WHERE stf.staid = $staid)");
            } else {
                $this->db->query("INSERT INTO staffatndetail(`staid`, `did`, `shid`, `date`, `dcno`, `description`, `status`, `postdate`, `tin`, `tout`, `etype`) (SELECT stf.staid, d.did, s.shid, NOW() AS DATE, (SELECT IFNULL(MAX(dcno), 0)+1 AS dcno FROM staffatndetail WHERE etype = 'man_atnd') AS dcno, '' AS description, 'Present', NOW() AS postdate, '' AS tin, CONCAT('0000-00-00 ', TIME(NOW())) AS tout, 'man_atnd' AS etype FROM department AS d INNER JOIN staff AS stf ON d.did=stf.did INNER JOIN (allot_shift AS `as` INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid WHERE stf.staid = $staid)");
            }
            $result = $this->db->query("SELECT stf.staid, d.did, s.shid, d.name AS 'dept_name', stf.name, stf.cnic, sal.designation, s.name AS 'shift_name', stf.photo, (CASE WHEN stfa.tin = '0000-00-00 00:00:00' THEN '00:00:00' ELSE DATE_FORMAT(stfa.tin, '%h:%i %p') END) AS tin, (CASE WHEN stfa.tout = '0000-00-00 00:00:00' THEN '00:00:00' ELSE DATE_FORMAT(stfa.tout, '%h:%i %p') END) AS tout FROM department AS d INNER JOIN staff AS stf ON d.did=stf.did INNER JOIN salary AS sal ON stf.staid=sal.staid INNER JOIN (allot_shift AS `as` INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid INNER JOIN staffatndetail AS stfa ON stfa.staid = stf.staid WHERE DATE(stfa.DATE) = DATE(NOW()) AND stfa.staid = $staid AND stfa.etype = 'man_atnd' ORDER BY postdate DESC LIMIT 2");
            return $result->result_array();
        }
    }
    public function deleteAttendance($dcno, $etype, $company_id) {
        $this->db->where(array('dcno' => $dcno, 'etype' => $etype, 'company_id' => $company_id));
        $result = $this->db->get('staffatndetail');
        if ($result->num_rows() > 0) {
            $this->db->where(array('dcno' => $dcno, 'etype' => $etype));
            $result = $this->db->delete('staffatndetail');
        } else {
            return false;
        }
    }
    public function fetchAllAttendance($staid) {
        $result = $this->db->query("SELECT DATE_FORMAT(date,'%d/%m/%y') as date2, staffatndetail.* FROM staffatndetail WHERE staid = $staid ORDER BY DATE DESC");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}