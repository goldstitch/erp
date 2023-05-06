

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Loan extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('ledgers');
$this->load->model('loans');
}
public function index() {
unauth_secure();
$data['modules'] = array('accounts/loan');
$data['accounts'] = $this->accounts->fetchAll(1,'asset employeed');
$data['accountCashs'] = $this->accounts->fetchAll_CashAccount();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$this->load->view('template/header');
$this->load->view('accounts/loan',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
if (isset($_POST)) {
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$maxId = $this->ledgers->getMaxId($etype,$company_id) +1;
$this->output->set_content_type('<ap></ap>plication/json')->set_output(json_encode($maxId));
}
}
public function save() {
if (isset($_POST)) {
$saveObj = $_POST['saveObj'];
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
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
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->ledgers->fetchpenalty($dcno,$etype,$company_id);
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
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->ledgers->deleteVoucher($dcno,$etype,$company_id);
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
$etype = $_POST['etype'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->ledgers->fetchVoucherRange($from,$to,$etype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchReport() {
if (isset($_POST)) {
$pid = $_POST['pid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->loans->fetchReport($from,$to,$pid,$did);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
}

?>