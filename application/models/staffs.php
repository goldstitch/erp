<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Staffs extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxId() {
        $this->db->select_max('staid');
        $result = $this->db->get('staff');
        $row = $result->row_array();
        $maxId = $row['staid'];
        return $maxId;
    }
    public function getMaxOvertimeId() {
        $this->db->select_max('dcno');
        $result = $this->db->get('overtime');
        $row = $result->row_array();
        $maxId = $row['dcno'];
        return $maxId;
    }
    public function getMaxSalaryId($etype, $company_id) {
        $result = $this->db->query("SELECT MAX(dcno) dcno FROM salarysheet WHERE etype = '" . $etype . "' and company_id=" . $company_id . " ");
        $row = $result->row_array();
        $maxId = $row['dcno'];
        return $maxId;
    }
    public function getAllTypes() {
        $types = $this->db->query("SELECT DISTINCT type FROM staff WHERE type <> '' ORDER BY type DESC");
        return $types->result_array();
    }
    public function getAllAgreements() {
        $agreements = $this->db->query("SELECT DISTINCT agreement FROM staff WHERE agreement <> '' ORDER BY agreement DESC");
        return $agreements->result_array();
    }
    public function getAllReligions() {
        $religions = $this->db->query("SELECT DISTINCT religion FROM staff WHERE religion <> '' ORDER BY religion DESC");
        return $religions->result_array();
    }
    public function getAllBankNames() {
        $banks = $this->db->query("SELECT DISTINCT bankname FROM salary WHERE bankname <> '' ORDER BY bankname DESC");
        return $banks->result_array();
    }
    public function distincts_fields($fd) {
        $banks = $this->db->query("SELECT DISTINCT $fd FROM salary WHERE $fd <> '' ORDER BY $fd ");
        return $banks->result_array();
    }
    public function save($staff, $pid) {
        $staff = json_decode(html_entity_decode($staff['staff'], true));
        $staff = (array)$staff;
        $staff['pid'] = $pid;
        if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
            $staff['photo'] = $this->upload_photo($staff);
        } else {
            unset($staff['photo']);
        }
        $this->db->where(array('staid' => $staff['staid']));
        $result = $this->db->get('staff');
        $affect = 0;
        $staid = "";
        if ($result->num_rows() > 0) {
            $this->db->where('staid', $staff['staid']);
            $affect = $this->db->update('staff', $staff);
            $staid = $staff['staid'];
        } else {
            unset($staff['staid']);
            $this->db->insert('staff', $staff);
            $affect = $this->db->affected_rows();
            $staid = $this->db->insert_id();
        }
        if ($affect === 0) {
            return false;
        } else {
            return $staid;
        }
    }
    public function saveOvertime($overtime) {
        $this->db->where(array('dcno' => $overtime['dcno']));
        $result = $this->db->get('overtime');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('dcno' => $overtime['dcno']));
            $affect = $this->db->update('overtime', $overtime);
        } else {
            $this->db->insert('overtime', $overtime);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function saveOvertimeMultiple($overtime) {
        $this->db->where(array('dcno' => $overtime[0]['dcno']));
        $this->db->delete('overtime');
        if (is_array($overtime)) {
            foreach ($overtime as $detail) {
                $this->db->insert('overtime', $detail);
            }
        }
        return true;
    }
    public function Check_Duplicate_SalarySheet($dcno, $dt1, $dt2, $etype) {
        $result = $this->db->query("select * from salarysheet where etype='$etype' AND (dts BETWEEN '$dt1' AND '$dt2'  OR dte BETWEEN '$dt1' AND '$dt2') AND dcno<>$dcno");
        if ($result->num_rows() > 0) {
            return "Duplicate";
        } else {
            return "false";
        }
    }
    public function saveSalarySheet($salarysheet, $dcno) {
        $sts = "";
        $salarysheet = json_decode($salarysheet, true);
        $sts = $this->Check_Duplicate_SalarySheet($dcno, $salarysheet[0]['dts'], $salarysheet[0]['dte'], $salarysheet[0]['etype']);
        if ($sts == "false") {
            $this->db->where(array('dcno' => $dcno, 'etype' => $salarysheet[0]['etype'], 'company_id' => $salarysheet[0]['company_id']));
            $affect = $this->db->delete('salarysheet');
            $affect = 0;
            foreach ($salarysheet as $ss) {
                $this->db->insert('salarysheet', $ss);
                $affect = $this->db->affected_rows();
            }
            if ($affect == 0) {
                return "false";
            } else {
                return "true";
            }
        } else {
            return $sts;
        }
    }
    public function upload_photo($photo) {
        $uploadsDirectory = ($_SERVER['DOCUMENT_ROOT'] . '/erp/assets/uploads/staff/');
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
    public function saveSalary($salary) {
        $this->db->where(array('staid' => $salary['staid']));
        $result = $this->db->delete('salary');
        $this->db->insert('salary', $salary);
    }
    public function saveQualification($qualifications, $staid) {
        $this->db->where(array('staid' => $staid));
        $result = $this->db->delete('qualification');
        foreach ($qualifications as $qualification) {
            $qualification = (array)$qualification;
            $this->db->insert('qualification', $qualification);
        }
    }
    public function saveExperience($experiences, $staid) {
        $this->db->where(array('staid' => $staid));
        $result = $this->db->delete('experience');
        foreach ($experiences as $experience) {
            $experience = (array)$experience;
            $this->db->insert('experience', $experience);
        }
    }
    public function fetchStaff($staid) {
        $this->db->where(array('staid' => $staid));
        $result = $this->db->get('staff');
        if ($result->num_rows() > 0) {
            $result = $this->db->query("SELECT restday,blood_group, uid,mid,staid, name, fname, religion, photo, address, phone, birthdate, jdate, type, salary, date, mobile, agreement, gender, mstatus, active, cnic, pid, did, gid, gdate, otallowed, otrate, paidleave, unpaidleave, medleave from staff where staid = $staid");
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchBloodGroups() {
        $qry = "SELECT distinct ifnull(staff.blood_group,'') as blood_group
		FROM `staff` ";
        $query = $this->db->query($qry);
        $result = $query->result_array();
        return $result;
    }
    public function fetchByDepartment($did) {
        $result = "";
        if ($did == '-1') {
            $this->db->where(array('active' => '1'));
            $result = $this->db->get('staff');
        } else {
            $this->db->where(array('did' => $did, 'active' => '1'));
            $result = $this->db->get('staff');
        }
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetchSalarySheet($dcno, $etype, $company_id) {
        $this->db->where(array('dcno' => $dcno));
        $result = $this->db->get('salarysheet');
        if ($result->num_rows() > 0) {
            $result = $this->db->query("SELECT s.fname,ss.dcno, ss.etype, ss.dts, ss.dte, ss.staid,
				ss.did, ss.pid, ss.shid, ROUND(ss.bsalary) bsalary,
				ss.absent, ss.leave_wp, ss.leave_wop, ss.rest_days,
				ss.work_days,
				ss.leave_gholiday as 'gusted_holiday',
				ss.leave_outdoor as 'outdoor',
				ss.leave_sleave  as 'short_leave',
				ss.paid_days ,

				ROUND(ss.gross_salary) gross_salary,
				ROUND(ss.otrate,2) otrate, ss.othour, ss.overtime overtime,
				ROUND(ss.advance) advance, ROUND(ss.loan_deduction) loan_deduction,
				ROUND(ss.balance) balance, ROUND(ss.incentive) incentive,
				ROUND(ss.penalty) penalty, ROUND(ss.eobi) eobi,
				ROUND(ss.insurance) insurance, ROUND(ss.socialsec) socialsec,
				ROUND(ss.net_salary) net_salary, d.name AS 'department_name',
				s.name, s.type AS 'type',sal.designation
				FROM salarysheet AS ss
				INNER JOIN department AS d ON ss.did = d.did
				INNER JOIN staff AS s ON ss.staid = s.staid
				left JOIN salary AS sal ON sal.staid = s.staid

				WHERE ss.dcno =$dcno and ss.etype='$etype' and ss.company_id=$company_id
				group by ss.pid
				order by d.name
				");
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function fetchOvertime($dcno) {
        $result = $this->db->query("SELECT 	overtime.dcno,overtime.date,overtime.remarks,overtime.othour, stf.staid, d.name AS 'dept_name', stf.name, stf.fname, stf.mobile, stf.phone, d.did, stf.pid, stf.address, stf.type, stf.active, stf.type, s.name AS 'shift_name', s.shid,overtime.approved_by,overtime.reason
			FROM overtime
			INNER JOIN department AS d ON d.did=overtime.did
			INNER JOIN staff AS stf ON overtime.staid=stf.staid
			INNER JOIN user ON user.uid=overtime.uid
			INNER JOIN shift AS s ON s.shid = overtime.shid
			WHERE overtime.dcno=$dcno
			ORDER BY overtime.otid");
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetchStaffSalary($staid) {
        $result = $this->db->query("select bs, designation, bpay, inipay, hrent, convallow, medallow, entertain, charge, bankname, acno, netpay, househ, scall, publicsall, saall, dearness, adhoc1, adhoc2, arrears, pfund, income, hostel, pessi, scont, recovery, totalpay, tdeduc, loan, eobi, socialsec, insurance from salary where staid = $staid");
        return $result->result_array();
    }
    public function fetchStaffQualification($staid) {
        $result = $this->db->query("select quali, grade, year, subject, institute from qualification where staid = $staid");
        return $result->result_array();
    }
    public function fetchStaffExperience($staid) {
        $result = $this->db->query("select `job`, `from`, `to`, `pd1` from `experience` where staid = $staid");
        return $result->result_array();
    }
    public function fetchAllTeachers() {
        $result = $this->db->query("select `staid`, `name` from `staff` where type = 'teacher' and active = 1");
        return $result->result_array();
    }
    public function fetchStaffReportByStatus($status, $did, $typee, $company_id) {
        if ($typee != 'all') {
            $typee = " and stf.type='$typee'";
        } else {
            $typee = "";
        }
        if ($did != 'all') {
            $did = " and stf.did='$did'";
        } else {
            $did = "";
        }
        $query = "";
        if ($status == '1' || $status == '0') {
            $query = "SELECT stf.staid, d.name AS 'dept_name', stf.name, stf.mobile, stf.phone, d.did, stf.address, stf.type, stf.active, stf.type, s.name AS 'shift_name', s.shid, d.name as 'dept_name', sal.designation, round(sal.totalpay, 2) totalpay FROM department AS d INNER JOIN staff AS stf ON d.did=stf.did INNER JOIN salary AS sal ON stf.staid=sal.staid INNER JOIN (allot_shift AS `as` INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid WHERE stf.active = $status and stf.company_id=$company_id  $typee $did ORDER BY d.name, stf.type, stf.name";
        } else {
            $query = "SELECT sal.designation,stf.staid, d.name AS 'dept_name', stf.name, stf.mobile, stf.phone, d.did, stf.address, stf.type, stf.active, stf.type, s.name AS 'shift_name', s.shid FROM department AS d INNER JOIN staff AS stf ON d.did=stf.did INNER JOIN salary AS sal ON stf.staid=sal.staid INNER JOIN (allot_shift AS `as` INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid WHERE stf.company_id=$company_id  $status $typee $did ORDER BY d.name, stf.type, stf.name";
        }
        $result = $this->db->query($query);
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetchAllStaff($crit) {
        $result = $this->db->query("SELECT stf.staid, d.name AS 'dept_name', stf.name, stf.fname, stf.mobile, stf.phone, d.did, stf.pid, stf.address, stf.type, stf.active, stf.type, s.name AS 'shift_name', s.shid, sal.designation, ROUND(sal.bpay) bpay
			FROM department AS d
			INNER JOIN staff AS stf ON d.did=stf.did
			INNER JOIN salary AS sal ON stf.staid=sal.staid
			INNER JOIN (allot_shift AS `as`
			INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid
			where 1=1 $crit
			ORDER BY stf.name");
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetchAll() {
        $result = $this->db->query("SELECT stf.staid, d.name AS 'dept_name', stf.name, stf.fname, stf.mobile, stf.phone, d.did, stf.pid, stf.address, stf.type, stf.active, stf.type, s.name AS 'shift_name', s.shid, sal.designation, ROUND(sal.bpay) bpay
			FROM department AS d
			INNER JOIN staff AS stf ON d.did=stf.did
			INNER JOIN salary AS sal ON stf.staid=sal.staid
			INNER JOIN (allot_shift AS `as`
			INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid
			ORDER BY stf.name");
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetchOverTimeReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        $result = $this->db->query("SELECT $field as voucher,overtime.dcno,overtime.date,overtime.remarks,overtime.othour, stf.staid, d.name AS 'dept_name', stf.name, stf.fname, stf.mobile, stf.phone, d.did, stf.pid, stf.address, stf.type, stf.active, stf.type, s.name AS 'shift_name', s.shid, sal.designation, ROUND(sal.bpay) bpay
			FROM overtime
			INNER JOIN department AS d on d.did=overtime.did
			INNER JOIN staff AS stf ON overtime.staid=stf.staid
			INNER JOIN salary AS sal ON stf.staid=sal.staid
			INNER JOIN user on user.uid=overtime.uid
			INNER JOIN (allot_shift AS `as`
			INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid
			where overtime.date BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND overtime.company_id=$company_id  $crit
			ORDER BY $orderBy ,overtime.date");
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetchAttendanceReportData($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        $result = $this->db->query("SELECT $field as voucher,staffatndetail.tout,staffatndetail.tin,staffatndetail.status,staffatndetail.dcno,staffatndetail.date,staffatndetail.description, stf.staid, d.name AS 'dept_name', stf.name, stf.fname, stf.mobile, stf.phone, d.did, stf.pid, stf.address, stf.type, stf.active, stf.type, s.name AS 'shift_name', s.shid, sal.designation, ROUND(sal.bpay) bpay,round(IFNULL(staffatndetail.late,0),2) late
			FROM staffatndetail
			INNER JOIN department AS d ON d.did=staffatndetail.did
			INNER JOIN staff AS stf ON staffatndetail.staid=stf.staid
			INNER JOIN salary AS sal ON stf.staid=sal.staid
			INNER JOIN user ON user.uid=staffatndetail.uid
			INNER JOIN (allot_shift AS `as`
			INNER JOIN shift AS s ON s.shid = as.shid) ON stf.gid = as.gid
			WHERE staffatndetail.date BETWEEN '" . $startDate . "' AND '" . $endDate . "' AND staffatndetail.company_id=$company_id $crit
			ORDER BY $orderBy ,staffatndetail.date");
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetchSalarySheetReport($startDate, $endDate, $what, $type, $company_id, $etype, $field, $crit, $orderBy, $groupBy, $name) {
        if ($type == 'summary') {
            $result = $this->db->query("SELECT $field as VOUCHER,dep.did DID, ROUND(COUNT(DISTINCT sal.staid)) AS NOE, ROUND(IFNULL(SUM(sal.bsalary),0)) AS BSALARY, ROUND(IFNULL(SUM(sal.overtime),0)) AS OVERTIME, ROUND(IFNULL(SUM(sal.bsalary),0) + IFNULL(SUM(sal.overtime),0)) AS GSALARY, ROUND(IFNULL(SUM(sal.advance),0)) AS ADVANCE, ROUND(IFNULL(SUM(sal.loan_deduction),0)) AS LOAN, ROUND(IFNULL(SUM(sal.incentive),0)) AS INCENTIVE, ROUND(IFNULL(SUM(sal.net_salary),0)) AS NET_SALARY
				FROM salarysheet sal
				INNER JOIN department dep ON dep.did=sal.did
				INNER JOIN staff AS stf ON sal.staid=stf.staid
				INNER JOIN salary AS sa ON stf.staid=sa.staid
				INNER JOIN user ON user.uid=sal.uid
				INNER JOIN shift as s ON sal.shid = s.shid
				WHERE sal.etype='$etype' AND sal.company_id=$company_id and sal.dte BETWEEN '" . $startDate . "' AND '" . $endDate . "' $crit
				GROUP BY $orderBy
				ORDER BY $orderBy ");
        } else {
            $result = $this->db->query("SELECT $field as VOUCHER,date_format(sal.date , '%d %b %y') as 'DATE',fname FNAME,sal.dcno DCNO, sal.etype ETYPE, sal.dts DTS , sal.dte DTE, sal.staid STAID,
				sal.did DID, sal.pid PID, sal.shid SHID, ROUND(sal.bsalary) BSALARY,
				sal.absent ABSENT, sal.leave_wp LEAVE_WP, sal.leave_wop LEAVE_WOP, sal.rest_days REST_DAYS,
				sal.work_days WORK_DAYS,
				sal.leave_gholiday AS 'GUSTED_HOLYDAY',
				sal.leave_outdoor AS 'OUTDOOR',
				sal.leave_sleave AS 'SHORT_LEAVE', ROUND(sal.bsalary+sal.overtime+sal.incentive) GSALARY2,
				if(sal.paid_days%1=0,round(sal.paid_days),sal.paid_days) PAID_DAYS, ROUND(sal.gross_salary) GSALARY1, ROUND(sal.otrate,2) OTRATE, sal.othour OTHOUR, sal.overtime OVERTIME, ROUND(sal.advance) ADVANCE, ROUND(sal.loan_deduction) LOAN, ROUND(sal.balance) BALANCE, ROUND(sal.incentive) INCENTIVE, ROUND(sal.penalty) PENALTY, ROUND(sal.eobi) EOBI, ROUND(sal.insurance) INSURANCE, ROUND(sal.socialsec) SOCIALSEC, ROUND(sal.net_salary) NET_SALARY, dep.name AS 'DEPT_NAME',
				stf.name STAFF_NAME, stf.type AS 'STAFF_TYPE',sa.designation AS STAFF_DESIGNATION
				FROM salarysheet AS sal
				INNER JOIN department AS dep ON sal.did = dep.did
				INNER JOIN staff AS stf ON sal.staid = stf.staid
				LEFT JOIN salary AS sa ON sa.staid = stf.staid
				INNER JOIN user ON user.uid=sal.uid
				INNER JOIN shift as s ON sal.shid = s.shid
				WHERE sal.etype='$etype' AND sal.company_id=$company_id and sal.dte BETWEEN '" . $startDate . "' AND '" . $endDate . "' $crit
				ORDER BY  $orderBy,sal.dte");
        }
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetchAllOvertime() {
        $result = $this->db->query("SELECT dcno, DATE(o.date) AS date, s.name, s.fname, o.approved_by, o.reason, o.remarks, o.othour FROM overtime AS o INNER JOIN staff AS s ON o.staid = s.staid");
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function getWages($from, $to, $company_id) {
        $query = $this->db->query("call wagessheet('" . $from . "', '" . $to . "', " . $company_id . ") ");
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function getSalary($from, $to, $company_id) {
        $query = $this->db->query("call salarysheet('" . $from . "', '" . $to . "', " . $company_id . ") ");
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }
    public function getLoanDeduction($pid) {
        $res = $this->db->query("select deduction from pledger WHERE pid = '" . $pid . "' AND etype = 'loan' order by pledid desc limit 0, 1 ");
        $res = $res->result_array();
        mysqli_next_result($this->db->conn_id);
        if (isset($res[0]['deduction'])) {
            return ($res[0]['deduction'] != '') ? $res[0]['deduction'] : '0.00';
        } else {
            return "0.00";
        }
    }
    public function getLoanBalance($from, $to, $pid) {
        $result = $this->db->query("SELECT SUM(debit) - (SELECT IFNULL(SUM(deduction), 0) FROM pledger WHERE etype = 'salary'
			AND pid = '" . $pid . "' AND date <= '" . str_replace('/', '-', $to) . "') as deduction
			FROM pledger
			WHERE pid = '" . $pid . "' AND etype = 'loan' AND date <= '" . str_replace('/', '-', $to) . "' ");
        $result = $result->result_array();
        $amout = ($result[0]['deduction'] != '') ? $result[0]['deduction'] : '0.00';
        $deduction = $this->getLoanDeduction($pid);
        $totalRemaining = "";
        if ($amout < $deduction) {
            $totalRemaining = $amout;
        } else {
            $totalRemaining = $amout - $this->getLoanDeduction($pid);
        }
        return $totalRemaining;
    }
    public function deleteOvertime($dcno) {
        $this->db->where(array('dcno' => $dcno));
        $result = $this->db->get('overtime');
        if ($result->num_rows() > 0) {
            $this->db->where(array('dcno' => $dcno));
            $result = $this->db->delete('overtime');
        } else {
            return false;
        }
    }
    public function deleteSalarySheet($dcno, $etype, $company_id) {
        $this->db->where(array('etype' => $etype, 'dcno' => $dcno, 'company_id' => $company_id));
        $result = $this->db->get('salarysheet');
        if ($result->num_rows() > 0) {
            $this->db->where(array('etype' => $etype, 'dcno' => $dcno, 'company_id' => $company_id));
            $result = $this->db->delete('salarysheet');
        } else {
            return false;
        }
    }
}