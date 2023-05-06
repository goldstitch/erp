<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getMaxRoleGroupId() {
        $this->db->select_max('rgid');
        $result = $this->db->get('rolegroup');
        $result = $result->row_array();
        return $result['rgid'];
    }
    public function logoutAllUsers($uname, $pass) {
        $this->db->query('delete from ci_sessions');
        return true;
    }
    public function savelogincode($user) {
        $q = "UPDATE user set mob_code='" . $user['mob_code'] . "' ";
        $query = $this->db->query($q);
        return true;
    }
    public function sendMessage($mobile, $message) {
        $ptn = "/^[0-9]/";
        $rpltxt = "92";
        $mobile = preg_replace($ptn, $rpltxt, $mobile);
        $url = ZONG_API_SERVICE_URL;
        $post_string = '<?xml version="1.0" encoding="utf-8"?>' . '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">' . '<soap:Body>' . '<SendSingleSMS xmlns="http://tempuri.org/">' . '<Src_nbr>' . ZONG_API_MOB . '</Src_nbr>' . '<Password>' . ZONG_API_PASS . '</Password>' . '<Dst_nbr>' . $mobile . '</Dst_nbr>' . '<Mask>' . ZONG_API_MASK . '</Mask>' . '<Message>' . $message . '</Message>' . '</SendSingleSMS>' . '</soap:Body>' . '</soap:Envelope>';
        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, $url);
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=utf-8', 'Content-Length: ' . strlen($post_string)));
        $result = curl_exec($soap_do);
        $err = curl_error($soap_do);
        return $result;
    }
    public function getMaxId() {
        $this->db->select_max('uid');
        $result = $this->db->get('user');
        $result = $result->row_array();
        return $result['uid'];
    }
    public function saveRoleGroup($rolegroup) {
        $this->db->where(array('rgid' => $rolegroup['rgid']));
        $result = $this->db->get('rolegroup');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('rgid' => $rolegroup['rgid']));
            $result = $this->db->update('rolegroup', $rolegroup);
            $affect = $this->db->affected_rows();
        } else {
            unset($rolegroup['rgid']);
            $result = $this->db->insert('rolegroup', $rolegroup);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function save($user) {
        $this->db->where(array('uid' => $user['uid']));
        $result = $this->db->get('user');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('uid' => $user['uid']));
            $affect = $this->db->update('user', $user);
        } else {
            unset($user['uid']);
            $user['date'] = date('Y-m-d H:i:s');
            $result = $this->db->insert('user', $user);
            $affect = $this->db->affected_rows();
        }
        if ($affect == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetchRoleGroup($rgid) {
        $this->db->where(array('rgid' => $rgid));
        $result = $this->db->get('rolegroup');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetch($uid) {
        $this->db->where(array('uid' => $uid));
        $result = $this->db->get('user');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetch_mobile($uname) {
        $this->db->where(array('uname' => $uname));
        $result = $this->db->get('user');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchAll() {
        $result = $this->db->get('user');
        return $result->result_array();
    }
    public function fetchAllRoleGroup() {
        $result = $this->db->get('rolegroup');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    public function privillagesAssigned() {
        $result = $this->db->query("SELECT u.uid, u.fullname, r.name, r.desc, DATE(u.date) AS date FROM user AS u INNER JOIN rolegroup AS r ON u.rgid = r.rgid");
        return $result->result_array();
    }
    public function login($uname, $pass) {
        $result = $this->db->query("SELECT u.uid, u.fullname, r.rgid,u.company_id, r.name AS 'rolegroup_name', r.desc FROM user AS u INNER JOIN rolegroup AS r ON r.rgid = u.rgid WHERE u.uname = '" . $uname . "' AND u.pass = '" . $pass . "'");
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->row_array();
        }
    }
    public function has_match($username, $password) {
        $query = $this->db->query("SELECT * FROM user WHERE BINARY uname='{$username}' AND BINARY pass='{$password}'");
        return ($query->num_rows() > 0);
    }
    public function login_user($data) {
        unset($data['submit']);
        $username = $this->db->escape_str($data['uname']);
        $password = $this->db->escape_str($data['pass']);
        $mob_code = $this->db->escape_str($data['mob_code']);
        if ($this->has_match($username, $password)) {
            $q = "SELECT company.company_id, company.company_name, company.foot_note, user.uid, user.uname,
				user.pass, user.email, user.company_id, user.user_type,
				user.rgid, user.fullname,
				user.mobile, user.rgid, user.mob_code,rolegroup.desc,rolegroup.name as usertype FROM user INNER JOIN rolegroup ON user.rgid = rolegroup.rgid INNER JOIN company ON user.company_id = company.company_id WHERE BINARY uname =  '{$username}' AND BINARY pass =  '{$password}' ";
            $query = $this->db->query($q);
            $result = $query->result_array();
            $this->session->set_userdata($result[0]);
            $this->session->set_userdata('user_time', microtime(true));
            $todayDate = date("Y-m-d", strtotime("-3 days"));
            $uid = $this->session->userdata('uid');
            $dateclose = '{"uid":"' . $uid . '","remarks": "auto close","date_cl":"' . $todayDate . '"}';
            $dateclose = json_decode($dateclose, true);
            $result = $this->saveDateClose($dateclose);
            if ($result == "true") {
                $this->session->set_userdata('date_close', $todayDate);
            } else {
                $this->session->set_userdata('date_close', '');
            }
            return true;
        } else {
            return false;
        }
    }
    public function saveDateClose($dateclose) {
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
    public function dateChecking($vrDate) {
        $userId = $this->session->userdata('usertype');
        date_default_timezone_get('Asia/Karachi');
        $currentDate = date("Y/m/d");
        $previousDate = date('Y-m-d', strtotime($currentDate . ' -3 day'));
        $this->db->where(array('date_cl' => $previousDate));
        $result = $this->db->get('dateclose');
        $affect = 0;
        if ($result->num_rows() > 0) {
            return "Already Save";
        } else {
            $result = $this->db->query("select date_time from dateopen where date_cl='$previousDate' order by date_time desc limit 1");
            if ($result->num_rows() > 0) {
                $result = $query->result_array();
                $dDiff = $$result[0]->diff($previousDate);
                if ($dDiff->days >= 3) {
                    $data = array('date_cl' => $previousDate, 'remarks' => 'Auto Close', 'date' => $this);
                    $this->db->insert('mytable', $data);
                }
            } else {
            }
        }
    }
    public function login_user_code($uname, $password, $mob_code) {
        if ($this->has_match($uname, $password)) {
            $data = array('mob_code' => $mob_code);
            $this->db->where('uname', $uname);
            $this->db->update('user', $data);
            unset($password);
            unset($uname);
            unset($mob_code);
        } else {
            return false;
        }
    }
    public function login_user_code_logout($uname) {
        $data = array('mob_code' => 'SOUT');
        $this->db->where('uname', $uname);
        $this->db->update('user', $data);
        unset($password);
        unset($uname);
        unset($mob_code);
    }
    public function getNotifications($company_id) {
        $result = $this->db->query("SELECT log.log_id,log.vrnoa,log.vrdate,log.etype,log.party_id,log.namount,log.is_seen from transaction_log log INNER JOIN user u on u.uid = log.uid INNER JOIN company c on c.company_id = log.company_id where c.company_id = 1 and u.uid = 1 and is_seen = 1");
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    public function count_unpost()
    {
        $query = $this->db->query("SELECT DISTINCT dcno from pledger where ptype = 'unpost' AND etype ='cpv'");
        if ($demo = $query->num_rows)
        {
           return $demo;
        }
    }

    public function unposttransfer()
    {
        $query = $this->db->query("SELECT DISTINCT qty from stockdetail where ptype = 'unpost' and qty =''");
        if ($demo = $query->num_rows)
        {
           return $demo;
        }
    }

    
    public function count_unpostjv()
    {
        $query = $this->db->query("SELECT DISTINCT dcno from pledger where ptype = 'unpost' AND etype = 'jv'");
        if ($demo = $query->num_rows)
        {
           return $demo;
        }
    }
    public function count_unpostbpv()
    {
        $query = $this->db->query("SELECT DISTINCT dcno from pledger where ptype = 'unpost' AND etype = 'bpv'");
        if ($demo = $query->num_rows)
        {
           return $demo;
        }
    }
    public function count_unpostbrv()
    {
        $query = $this->db->query("SELECT DISTINCT dcno from pledger where ptype = 'unpost' AND etype = 'brv'");
        if ($demo = $query->num_rows)
        {
           return $demo;
        }
    }

    public function setpost($dcno)
    {
        $query = $this->db->query("update pledger set ptype = 'posted' where dcno = $dcno AND etype ='jv'");
    }

    public function setpostbpv($dcno)
    {
        $query = $this->db->query("update pledger set ptype = 'posted' where dcno = $dcno AND etype ='bpv'");
    }

    public function setpostbrv($dcno)
    {
        $query = $this->db->query("update pledger set ptype = 'posted' where dcno = $dcno AND etype ='brv'");
    }
    public function setposttransfer($vrnoa)
    {
        $query = $this->db->query("UPDATE post  SET ptype = 'posted' WHERE  vrnoa = $vrnoa");
    }


    public function post_chkjv($dcno)
    {
        $query = $this->db->query("SELECT DISTINCT ptype from pledger where dcno = '$dcno' and ptype = 'posted' AND etype='jv'");
        if ($demo = $query->num_rows)
        {
           if($demo = 1)
           {
               return "posted";
           }
        }
        $query = $this->db->query("SELECT DISTINCT ptype from pledger where dcno = '$dcno' and ptype = 'unpost' AND etype='jv'");
        if ($demo = $query->num_rows)
        {
           if($demo = 1)
           {
               return "unposted";
           }
        }
        else
        {
            return "";
        }
    }

    public function post_chkbpv($dcno)
    {
        $query = $this->db->query("SELECT DISTINCT ptype from pledger where dcno = '$dcno' and ptype = 'posted' AND etype='bpv'");
        if ($demo = $query->num_rows)
        {
           if($demo = 1)
           {
               return "posted";
           }
        }
        $query = $this->db->query("SELECT DISTINCT ptype from pledger where dcno = '$dcno' and ptype = 'unpost' AND etype='bpv'");
        if ($demo = $query->num_rows)
        {
           if($demo = 1)
           {
               return "unposted";
           }
        }
        else
        {
            return "";
        }
    }

    

    public function post_chkbrv($dcno)
    {
        $query = $this->db->query("SELECT DISTINCT ptype from pledger where dcno = '$dcno' and ptype = 'posted' AND etype='brv'");
        if ($demo = $query->num_rows)
        {
           if($demo = 1)
           {
               return "posted";
           }
        }
        $query = $this->db->query("SELECT DISTINCT ptype from pledger where dcno = '$dcno' and ptype = 'unpost' AND etype='brv'");
        if ($demo = $query->num_rows)
        {
           if($demo = 1)
           {
               return "unposted";
           }
        }
        else
        {
            return "";
        }
    }
    
    public function getdepart_id($name)
    {
        $result = $this->db->query("SELECT did from department where name ='$name'");
        $row = $result->row_array();
        return $row['did'];
        return $did;
    }

    public function postdata($vrnoa)
    {
        $post='unpost';
        $result = $this->db->query("insert into post (vrnoa,ptype) values ('$vrnoa','$post') ");
      
    }


}
