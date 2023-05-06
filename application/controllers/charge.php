


<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Charge extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('charges');
$this->load->model('ledgers');
$this->load->model('accounts');
}
public function index() {
unauth_secure();
}
public function add() {
unauth_secure();
$data['modules'] = array('setup/charge');
$data['chargeTypes'] = $this->charges->getChargeTypes();
$data['charges'] = $this->charges->fetchAll();
$data['parties'] = $this->accounts->getAllParties('account');
$this->load->view('template/header.php');
$this->load->view('setup/addcharges.php',$data);
$this->load->view('template/mainnav.php');
$this->load->view('template/footer.php',$data);
}
public function penalty() {
unauth_secure();
$data['modules'] = array('accounts/penalty');
$data['accounts'] = $this->accounts->fetchAll();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$this->load->view('template/header');
$this->load->view('accounts/penalty',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$maxId = $this->charges->getMaxId() +1;
$this->output
->set_content_type('application/json')
->set_output(json_encode($maxId));
}
public function getMaxPenaltyId() {
if (isset($_POST)) {
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$maxId = $this->ledgers->getMaxId($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($maxId));
}
}
public function getChargeTypes() {
$result = $this->charges->getChargeTypes();
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function save() {
if (isset($_POST)) {
$chargeDetail = $_POST['chargeDetail'];
$result = $this->charges->save( $chargeDetail );
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response['error'] = false;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function savePenalty() {
if (isset($_POST)) {
$saveObj = $_POST['saveObj'];
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
$result = $this->ledgers->savePenalty($saveObj,$dcno,$etype,$voucher_type_hidden);
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
public function fetchCharge() {
if (isset( $_POST )) {
$chid = $_POST['chid'];
$result = $this->charges->fetchCharge($chid);
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
public function fetchPenalty() {
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
public function fetchChargeByName() {
if (isset( $_POST )) {
$description = $_POST['description'];
$result = $this->charges->fetchChargeByName($description);
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
public function fetchAll() {
$result = $this->charges->fetchAll();
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function chargesDefinitionReport() {
$result = $this->charges->chargesDefinitionReport();
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function deletePenaltyVoucher() {
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
public function fetchPenaltyReport() {
if (isset($_POST)) {
$pid = $_POST['pid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->charges->fetchPenaltyReport($from,$to,$pid,$did);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
}

?>