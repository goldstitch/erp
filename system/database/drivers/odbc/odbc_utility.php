

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class CI_DB_odbc_utility extends CI_DB_utility {
function _list_databases()
{
if ($this->db->db_debug)
{
return $this->db->display_error('db_unsuported_feature');
}
return FALSE;
}
function _optimize_table($table)
{
if ($this->db->db_debug)
{
return $this->db->display_error('db_unsuported_feature');
}
return FALSE;
}
function _repair_table($table)
{
if ($this->db->db_debug)
{
return $this->db->display_error('db_unsuported_feature');
}
return FALSE;
}
function _backup($params = array())
{
return $this->db->display_error('db_unsuported_feature');
}
}

?>