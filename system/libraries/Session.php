
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class CI_Session {
public $sess_encrypt_cookie		= FALSE;
public $sess_use_database		= FALSE;
public $sess_table_name			= '';
public $sess_expiration			= 7200;
public $sess_expire_on_close		= FALSE;
public $sess_match_ip			= FALSE;
public $sess_match_useragent		= TRUE;
public $sess_cookie_name		= 'ci_session';
public $cookie_prefix			= '';
public $cookie_path			= '';
public $cookie_domain			= '';
public $cookie_secure			= FALSE;
public $sess_time_to_update		= 300;
public $encryption_key			= '';
public $flashdata_key			= 'flash';
public $time_reference			= 'time';
public $gc_probability			= 5;
public $userdata			= array();
public $CI;
public $now;
public function __construct($params = array())
{
log_message('debug','Session Class Initialized');
$this->CI =&get_instance();
foreach (array('sess_encrypt_cookie','sess_use_database','sess_table_name','sess_expiration','sess_expire_on_close','sess_match_ip','sess_match_useragent','sess_cookie_name','cookie_path','cookie_domain','cookie_secure','sess_time_to_update','time_reference','cookie_prefix','encryption_key') as $key)
{
$this->$key = (isset($params[$key])) ?$params[$key] : $this->CI->config->item($key);
}
if ($this->encryption_key == '')
{
show_error('In order to use the Session class you are required to set an encryption key in your config file.');
}
$this->CI->load->helper('string');
if ($this->sess_encrypt_cookie == TRUE)
{
$this->CI->load->library('encrypt');
}
if ($this->sess_use_database === TRUE &&$this->sess_table_name != '')
{
$this->CI->load->database();
}
$this->now = $this->_get_time();
if ($this->sess_expiration == 0)
{
$this->sess_expiration = (60*60*24*365*2);
}
$this->sess_cookie_name = $this->cookie_prefix.$this->sess_cookie_name;
if ( !$this->sess_read())
{
$this->sess_create();
}
else
{
$this->sess_update();
}
$this->_flashdata_sweep();
$this->_flashdata_mark();
$this->_sess_gc();
log_message('debug','Session routines successfully run');
}
public function sess_read()
{
$session = $this->CI->input->cookie($this->sess_cookie_name);
if ($session === FALSE)
{
log_message('debug','A session cookie was not found.');
return FALSE;
}
if ($this->sess_encrypt_cookie == TRUE)
{
$session = $this->CI->encrypt->decode($session);
}
else
{
$hash	 = substr($session,strlen($session)-32);
$session = substr($session,0,strlen($session)-32);
if ($hash !==  md5($session.$this->encryption_key))
{
log_message('error','The session cookie data did not match what was expected. This could be a possible hacking attempt.');
$this->sess_destroy();
return FALSE;
}
}
$session = $this->_unserialize($session);
if ( !is_array($session) OR !isset($session['session_id'],$session['ip_address'],$session['user_agent'],$session['last_activity']))
{
$this->sess_destroy();
return FALSE;
}
if (($session['last_activity'] +$this->sess_expiration) <$this->now)
{
$this->sess_destroy();
return FALSE;
}
if ($this->sess_match_ip == TRUE &&$session['ip_address'] !== $this->CI->input->ip_address())
{
$this->sess_destroy();
return FALSE;
}
if ($this->sess_match_useragent == TRUE &&trim($session['user_agent']) !== trim(substr($this->CI->input->user_agent(),0,120)))
{
$this->sess_destroy();
return FALSE;
}
if ($this->sess_use_database === TRUE)
{
$this->CI->db->where('session_id',$session['session_id']);
if ($this->sess_match_ip == TRUE)
{
$this->CI->db->where('ip_address',$session['ip_address']);
}
if ($this->sess_match_useragent == TRUE)
{
$this->CI->db->where('user_agent',$session['user_agent']);
}
$query = $this->CI->db->get($this->sess_table_name);
if ($query->num_rows() === 0)
{
$this->sess_destroy();
return FALSE;
}
$row = $query->row();
if (isset($row->user_data) &&$row->user_data != '')
{
$custom_data = $this->_unserialize($row->user_data);
if (is_array($custom_data))
{
foreach ($custom_data as $key =>$val)
{
$session[$key] = $val;
}
}
}
}
$this->userdata = $session;
unset($session);
return TRUE;
}
public function sess_write()
{
if ($this->sess_use_database === FALSE)
{
$this->_set_cookie();
return;
}
$custom_userdata = $this->userdata;
$cookie_userdata = array();
foreach (array('session_id','ip_address','user_agent','last_activity') as $val)
{
unset($custom_userdata[$val]);
$cookie_userdata[$val] = $this->userdata[$val];
}
if (count($custom_userdata) === 0)
{
$custom_userdata = '';
}
else
{
$custom_userdata = $this->_serialize($custom_userdata);
}
$this->CI->db->where('session_id',$this->userdata['session_id']);
$this->CI->db->update($this->sess_table_name,array('last_activity'=>$this->userdata['last_activity'],'user_data'=>$custom_userdata));
$this->_set_cookie($cookie_userdata);
}
public function sess_create()
{
$sessid = '';
do
{
$sessid .= mt_rand(0,mt_getrandmax());
}
while (strlen($sessid) <32);
$sessid .= $this->CI->input->ip_address();
$this->userdata = array(
'session_id'=>md5(uniqid($sessid,TRUE)),
'ip_address'=>$this->CI->input->ip_address(),
'user_agent'=>substr($this->CI->input->user_agent(),0,120),
'last_activity'=>$this->now,
'user_data'=>''
);
if ($this->sess_use_database === TRUE)
{
$this->CI->db->query($this->CI->db->insert_string($this->sess_table_name,$this->userdata));
}
$this->_set_cookie();
}
public function sess_update()
{
if (($this->userdata['last_activity'] +$this->sess_time_to_update) >= $this->now)
{
return;
}
$cookie_data = NULL;
if ($this->CI->input->is_ajax_request())
{
$this->userdata['last_activity'] = $this->now;
if ($this->sess_use_database === TRUE)
{
$cookie_data = array();
foreach (array('session_id','ip_address','user_agent','last_activity') as $val)
{
$cookie_data[$val] = $this->userdata[$val];
}
$this->CI->db->query($this->CI->db->update_string($this->sess_table_name,
array('last_activity'=>$this->userdata['last_activity']),
array('session_id'=>$this->userdata['session_id'])));
}
return $this->_set_cookie($cookie_data);
}
$old_sessid = $this->userdata['session_id'];
$new_sessid = '';
do
{
$new_sessid .= mt_rand(0,mt_getrandmax());
}
while (strlen($new_sessid) <32);
$new_sessid .= $this->CI->input->ip_address();
$this->userdata['session_id'] = $new_sessid = md5(uniqid($new_sessid,TRUE));
$this->userdata['last_activity'] = $this->now;
if ($this->sess_use_database === TRUE)
{
$cookie_data = array();
foreach (array('session_id','ip_address','user_agent','last_activity') as $val)
{
$cookie_data[$val] = $this->userdata[$val];
}
$this->CI->db->query($this->CI->db->update_string($this->sess_table_name,array('last_activity'=>$this->now,'session_id'=>$new_sessid),array('session_id'=>$old_sessid)));
}
$this->_set_cookie($cookie_data);
}
public function sess_destroy()
{
if ($this->sess_use_database === TRUE &&isset($this->userdata['session_id']))
{
$this->CI->db->where('session_id',$this->userdata['session_id']);
$this->CI->db->delete($this->sess_table_name);
}
setcookie(
$this->sess_cookie_name,
addslashes(serialize(array())),
($this->now -31500000),
$this->cookie_path,
$this->cookie_domain,
0
);
}
public function userdata($item)
{
return ( !isset($this->userdata[$item])) ?FALSE : $this->userdata[$item];
}
public function all_userdata()
{
return $this->userdata;
}
public function set_userdata($newdata = array(),$newval = '')
{
if (is_string($newdata))
{
$newdata = array($newdata =>$newval);
}
if (count($newdata) >0)
{
foreach ($newdata as $key =>$val)
{
$this->userdata[$key] = $val;
}
}
$this->sess_write();
}
public function unset_userdata($newdata = array())
{
if (is_string($newdata))
{
$newdata = array($newdata =>'');
}
if (count($newdata) >0)
{
foreach ($newdata as $key =>$val)
{
unset($this->userdata[$key]);
}
}
$this->sess_write();
}
public function set_flashdata($newdata = array(),$newval = '')
{
if (is_string($newdata))
{
$newdata = array($newdata =>$newval);
}
if (count($newdata) >0)
{
foreach ($newdata as $key =>$val)
{
$this->set_userdata($this->flashdata_key.':new:'.$key,$val);
}
}
}
public function keep_flashdata($key)
{
$value = $this->userdata($this->flashdata_key.':old:'.$key);
$this->set_userdata($this->flashdata_key.':new:'.$key,$value);
}
public function flashdata($key)
{
return $this->userdata($this->flashdata_key.':old:'.$key);
}
protected function _flashdata_mark()
{
$userdata = $this->all_userdata();
foreach ($userdata as $name =>$value)
{
$parts = explode(':new:',$name);
if (is_array($parts) &&count($parts) === 2)
{
$this->set_userdata($this->flashdata_key.':old:'.$parts[1],$value);
$this->unset_userdata($name);
}
}
}
protected function _flashdata_sweep()
{
$userdata = $this->all_userdata();
foreach ($userdata as $key =>$value)
{
if (strpos($key,':old:'))
{
$this->unset_userdata($key);
}
}
}
protected function _get_time()
{
return (strtolower($this->time_reference) === 'gmt')
?mktime(gmdate('H'),gmdate('i'),gmdate('s'),gmdate('m'),gmdate('d'),gmdate('Y'))
: time();
}
protected function _set_cookie($cookie_data = NULL)
{
if (is_null($cookie_data))
{
$cookie_data = $this->userdata;
}
$cookie_data = $this->_serialize($cookie_data);
if ($this->sess_encrypt_cookie == TRUE)
{
$cookie_data = $this->CI->encrypt->encode($cookie_data);
}
else
{
$cookie_data = $cookie_data.md5($cookie_data.$this->encryption_key);
}
$expire = ($this->sess_expire_on_close === TRUE) ?0 : $this->sess_expiration +time();
setcookie(
$this->sess_cookie_name,
$cookie_data,
$expire,
$this->cookie_path,
$this->cookie_domain,
$this->cookie_secure
);
}
protected function _serialize($data)
{
if (is_array($data))
{
array_walk_recursive($data,array(&$this,'_escape_slashes'));
}
elseif (is_string($data))
{
$data = str_replace('\\','{{slash}}',$data);
}
return serialize($data);
}
protected function _escape_slashes(&$val,$key)
{
if (is_string($val))
{
$val = str_replace('\\','{{slash}}',$val);
}
}
protected function _unserialize($data)
{
$data = @unserialize(strip_slashes($data));
if (is_array($data))
{
array_walk_recursive($data,array(&$this,'_unescape_slashes'));
return $data;
}
return (is_string($data)) ?str_replace('{{slash}}','\\',$data) : $data;
}
protected function _unescape_slashes(&$val,$key)
{
if (is_string($val))
{
$val= str_replace('{{slash}}','\\',$val);
}
}
protected function _sess_gc()
{
if ($this->sess_use_database != TRUE)
{
return;
}
srand(time());
if ((rand() %100) <$this->gc_probability)
{
$expire = $this->now -$this->sess_expiration;
$this->CI->db->where("last_activity < {$expire}");
$this->CI->db->delete($this->sess_table_name);
log_message('debug','Session garbage collection performed.');
}
}
}

?>