

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if (!defined('BASEPATH')) exit('No direct script access allowed');
class my_mpdf {
function __construct()
{
$CI = &get_instance();
log_message('Debug','mPDF class is loaded.');
}
function load($param=NULL)
{
include_once APPPATH.'/third_party/mpdf/mpdf.php';
if ($params == NULL)
{
$param = '"en-GB-x","A4","","",10,10,10,10,6,3,"L"';
}
return new mPDF($param);
}
}
?>