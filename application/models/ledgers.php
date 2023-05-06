<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ledgers extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxId($etype, $company_id) {
        $this->db->where(array('etype' => $etype, 'company_id' => $company_id));
        $this->db->select_max('dcno');
        $result = $this->db->get('pledger');
        $row = $result->row_array();
        $maxId = $row['dcno'];
        return $maxId;
    }
    public function fetchAccountVoucher($vrnoa, $etype, $company_id) {
        $sql = "SELECT p.pid,p.date_time AS datetime, DATE(p.date) AS date, p.dcno,party.account_id,party.name,p.description,p.debit,p.credit,ifnull(l3.name,'')level3_name
		FROM pledger p
		INNER JOIN party party ON party.pid = p.pid
		LEFT JOIN ordermain m ON m.vrnoa = p.dcno AND m.etype = p.etype
		INNER JOIN level3 l3 ON party.level3 = l3.l3

		WHERE p.etype = '" . $etype . "' AND p.dcno = $vrnoa AND p.company_id = $company_id";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    
    public function fetchAllLedgersPayments($etype) {
        $result = $this->db->query("SELECT p.name AS party_name,pledger.description,pledger.debit,pledger.ptype,pledger.credit,pledger.deduction,pledger.wo,pledger.invoice,pledger.date_time,pledger.chq_no,pledger.chq_date,pledger.dcno
			FROM pledger 
			INNER JOIN party p ON p.pid = pledger.pid
			INNER JOIN user ON user.uid = pledger.uid
			INNER JOIN company c ON c.company_id = pledger.company_id
			WHERE pledger.etype= '" . $etype . "'  AND pledger.ptype = 'unpost'
			ORDER BY pledger.pledid desc limit 10;");
        return $result->result_array();
    }
    public function save($ledgers, $dcno, $etype, $voucher_type_hidden) {
        $this->db->where(array('dcno' => $dcno, 'etype' => $etype, 'company_id' => 1));
        $affect = $this->db->delete('pledger');
        $affect = 0;
        foreach ($ledgers as $ledger) {
            $ledger['dcno'] = $dcno;
            $this->db->insert('pledger', $ledger);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function savePenalty($ledgers, $dcno, $etype) {
        $this->db->where(array('dcno' => $dcno, 'etype' => $etype,));
        $affect = $this->db->delete('pledger');
        $affect = 0;
        foreach ($ledgers as $ledger) {
            $this->db->insert('pledger', $ledger);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function deleteVoucher($dcno, $etype, $company_id) {
        $this->db->where(array('dcno' => $dcno, 'etype' => $etype, 'company_id' => $company_id));
        $result = $this->db->get('pledger');
        if ($result->num_rows() > 0) {
            $this->db->where(array('dcno' => $dcno, 'etype' => $etype));
            $result = $this->db->delete('pledger');
        } else {
            return false;
        }
    }
    public function fetch($dcno, $etype, $company_id) {
        $result = $this->db->query("SELECT ldgr.wo,ldgr.chq_no,date(ldgr.chq_date) as chq_date,DATE_FORMAT(ldgr.date_time,'%d %b %y')AS date_time,ldgr.pledid,ldgr.uid, ldgr.pid, ldgr.description, ldgr.deduction, ldgr.date, ldgr.debit, ldgr.credit, ldgr.invoice, ldgr.dcno, ldgr.etype, cid, chid, rose, secid, pid_key, p.name AS 'party_name',u.uname as user_name FROM pledger AS ldgr LEFT OUTER JOIN party AS p ON ldgr.pid = p.pid inner join user as u on u.uid=ldgr.uid WHERE ldgr.etype = '" . $etype . "' AND ldgr.dcno = $dcno AND ldgr.company_id = $company_id");
        if ($result->num_rows() === 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetchpenalty($dcno, $etype, $company_id) {
        $result = $this->db->query("SELECT pledid, ldgr.pid, description, deduction, date(ldgr.DATE) DATE, debit, credit, invoice, ldgr.dcno, ldgr.etype, cid, chid, rose, secid, pid_key, p.name AS 'party_name'
			FROM pledger AS ldgr
			LEFT OUTER
			JOIN party AS p ON ldgr.pid = p.pid
			INNER JOIN user AS u ON u.uid=ldgr.uid
			WHERE ldgr.etype = '" . $etype . "' AND ldgr.dcno = $dcno AND ldgr.company_id = $company_id;

			");
        if ($result->num_rows() === 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }
    public function fetch_total($dcno, $etype, $company_id) {
        $result = $this->db->query("SELECT ifnull(sum(ldgr.debit),0) as debit FROM pledger AS ldgr WHERE ldgr.etype = '" . $etype . "' AND ldgr.dcno = $dcno AND ldgr.company_id = $company_id");
        return $result->result_array();
    }
    public function fetchVoucherRange($from, $to, $etype, $company_id) {
        $query = $this->db->query("SELECT pledid,ldgr.chq_no, DATE(ldgr.chq_date) AS chq_date, ldgr.pid, description, date, (debit+credit) AS amount, invoice, ldgr.dcno, ldgr.etype, cid, chid, rose, secid, pid_key, p.name AS 'party_name', round(ldgr.debit, 2) debit, round(ldgr.credit, 2) credit 
			FROM pledger AS ldgr 
			LEFT OUTER JOIN party AS p ON ldgr.pid = p.pid 
			WHERE ldgr.date BETWEEN '" . $from . "' AND '" . $to . "' AND ldgr.etype = '" . $etype . "' and ldgr.company_id=$company_id");
        return $query->result_array();
    }
    public function getAccLedgerReport($from,$to,$pid, $ptype) {
        $result = $this->db->query("CALL acc_ledger('" . $from . "', '" . $to . "', $pid, '".$ptype."')");
        if ($result->num_rows > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function AccLedgerReport($from,$to,$pid) {
        $result = $this->db->query("CALL acc_l('" . $from . "', '" . $to . "', $pid)");
        if ($result->num_rows > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }


    public function getAccLedgerReport22($from, $to, $pid, $company_id) {
        $result = $this->db->query("SELECT ldgr.company_id, ldgr.pledid,ldgr.chq_no,ldgr.etype,ldgr.uid, ldgr.pid, ldgr.description, ldgr.deduction, ldgr.date, ldgr.debit, ldgr.credit, ldgr.invoice, ldgr.dcno, ldgr.etype, ldgr.cid, ldgr.chid, ldgr.rose, ldgr.secid, ldgr.pid_key, p.name AS 'party_name', p.mobile + '. ' + p.phone AS 'contact', p.address AS 'address',p.account_id as 'acc_id',u.uname as user_name ,ifnull(ldgr.wo,'')wo
			FROM pledger AS ldgr 
			LEFT OUTER JOIN party AS p ON ldgr.pid = p.pid 
			inner join user as u on u.uid=ldgr.uid 
			WHERE ldgr.pid = $pid and ldgr.date between '" . $from . "' and '" . $to . "' order by ldgr.date,ldgr.pledid ");
        if ($result->num_rows() === 0) {
            return false;
        } else {
            return $result->result_array();
        }
    }

    
}
