
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Jv extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('ledgers');
$this->load->model('users');
$this->load->model('levels');
}
public function index() {
unauth_secure();
$data['modules'] = array('accounts/addjv');
$data['accounts'] = $this->accounts->fetchAll();
$data['userone'] = $this->users->fetchAll();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['title'] = 'Journal Voucher';
$data['no_1'] =$this->users->count_unpostjv();
$this->load->view('template/header',$data);
$this->load->view('accounts/addjv',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function CheckDuplicateCheck() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$vrnoa = $_POST['vrnoa'];
$chk_no = $_POST['chk_no'];
$result = $this->accounts->CheckDuplicateCheck($vrnoa,$etype,$company_id,$chk_no);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function bpv() {
unauth_secure();
$data['modules'] = array('accounts/addbpv');
$data['accounts'] = $this->accounts->fetchAll();
$data['userone'] = $this->users->fetchAll();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['etype'] = 'bpv';
$data['title'] = 'Bank Payment Voucher';
$data['no_1'] =$this->users->count_unpostbpv();
$this->load->view('template/header',$data);
$this->load->view('accounts/addbpv',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function brv() {
unauth_secure();
$data['modules'] = array('accounts/addbpv');
$data['accounts'] = $this->accounts->fetchAll();
$data['userone'] = $this->users->fetchAll();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['etype'] = 'brv';
$data['title'] = 'Bank Receipt Voucher';
$data['no'] =$this->users->count_unpostbrv();
$this->load->view('template/header',$data);
$this->load->view('accounts/addbpv',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function add() {
}
public function getMaxId() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$maxId = $this->ledgers->getMaxId('jv',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($maxId));
}
}
public function getMaxIdbpv() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$maxId = $this->ledgers->getMaxId($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($maxId));
}
}
public function save() {
if (isset($_POST)) {
$saveObj = json_decode($_POST['saveObj'],true);
$saveObj = (array)$saveObj;
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
if ($voucher_type_hidden=='new'){
$dcno = $this->ledgers->getMaxId($etype,$saveObj[0]['company_id']) +1;
}
$result = $this->ledgers->save($saveObj,$dcno,$etype,$voucher_type_hidden);
$response = array();
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response['error'] = 'false';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch() {
if (isset($_POST)) {
$dcno = $_POST['dcno'];
$company_id=$_POST['company_id'];
$result = $this->ledgers->fetch($dcno,'jv',$company_id);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchbpv() {
if (isset($_POST)) {
$dcno = $_POST['dcno'];
$company_id=$_POST['company_id'];
$etype=$_POST['etype'];
$result = $this->ledgers->fetch($dcno,$etype,$company_id);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function deleteVoucher() {
if (isset($_POST)) {
$dcno = $_POST['dcno'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->ledgers->deleteVoucher($dcno,$etype ,$company_id);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = 'true';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchVoucherRange() {
if (isset($_POST)) {
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$result = $this->ledgers->fetchVoucherRange($from,$to,'jv',$company_id);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchVoucherRangebpv() {
if (isset($_POST)) {
$from = $_POST['from'];
$to = $_POST['to'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->ledgers->fetchVoucherRange($from,$to,$etype,$company_id);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}


}

?>