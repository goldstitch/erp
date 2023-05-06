

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


function unauth_secure() {
$CI =&get_instance();
$user = $CI->session->userdata('uid');
if ($user == false) {
redirect('welcome/login');
}
}
function auth_secure() {
$CI =&get_instance();
$user = $CI->session->userdata('uid');
if ($user != false) {
redirect('user/dashboard');
}
}
function CheckVoucherRights($voucher_name) {
$CI =&get_instance();
$desc = $CI->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$vouchers = $desc['vouchers'];
if (!isset($vouchers[$voucher_name][$voucher_name])){
redirect('user/dashboard');
}
if ($vouchers[$voucher_name][$voucher_name] == 0){
redirect('user/dashboard');
}
}
function CheckReportRights($report_name) {
$CI =&get_instance();
$desc = $CI->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$reports = $desc['reports'];
if (!isset($reports[$report_name])){
redirect('user/dashboard');
}
if ($reports[$report_name] == 0){
redirect('user/dashboard');
}
}
function CheckVoucherRights_Nav($voucher_name) {
$CI =&get_instance();
$desc = $CI->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$vouchers = $desc['vouchers'];
if (!isset($vouchers[$voucher_name][$voucher_name])){
return false;
}
if ($vouchers[$voucher_name][$voucher_name] == 0){
return false;
}
return true;
}
function CheckReportRights_Nav($report_name) {
$CI =&get_instance();
$desc = $CI->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$reports = $desc['reports'];
if (!isset($reports[$report_name])){
return false;
}
if ($reports[$report_name] == 0){
return false;
}
return true;
}

?>