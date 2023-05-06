

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('ledgers');
$this->load->model('payments');
$this->load->model('users');
$this->load->model('levels');
}
public function index() {
unauth_secure();
$data['modules'] = array('accounts/payment');
$data['accounts'] = $this->accounts->fetchAll(1);
$data['accountCashs'] = $this->accounts->fetchAll_CashAccount();
$data['userone'] = $this->users->fetchAll();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('accounts/cashpayment',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function advance() {
$data['modules'] = array('accounts/advance');
$data['accounts'] = $this->accounts->fetchAll(1,'asset employeed');
$data['accountCashs'] = $this->accounts->fetchAll_CashAccount();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$this->load->view('template/header');
$this->load->view('accounts/advance',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function incentive() {
$data['modules'] = array('accounts/incentive');
$data['accounts'] = $this->accounts->fetchAll(1,'asset employeed');
$data['setting_configur'] = $this->accounts->getsetting_configur();
$this->load->view('template/header');
$this->load->view('accounts/incentive',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
if (isset($_POST)) {
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$maxId = $this->ledgers->getMaxId($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($maxId));
}
}
public function save() {
if (isset($_POST)) {
$saveObj = $_POST['saveObj'];
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
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
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
public function fetchAdvanceReport() {
if (isset($_POST)) {
$pid = $_POST['pid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->payments->fetchAdvanceReport($from,$to,$did,$pid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchIncentiveReport() {
if (isset($_POST)) {
$pid = $_POST['pid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->payments->fetchIncentiveReport($from,$to,$pid,$did);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchEobiReport() {
if (isset($_POST)) {
$staid = $_POST['staid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->payments->fetchEobiReport($from,$to,$did,$staid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchSocialSecReport() {
if (isset($_POST)) {
$pid = $_POST['pid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->payments->fetchSocialSecReport($from,$to,$did,$pid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function chequeIssue()
{
unauth_secure();
$data['modules'] = array('accounts/chequevoucher');
$data['banks'] = $this->accounts->fetchBanks();
$data['parties'] = $this->accounts->fetchAll();
$data['userone'] = $this->users->fetchAll();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('accounts/issue_cheque_voucher',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function chequeReceive()
{
unauth_secure();
$data['modules'] = array('accounts/rcvchequevoucher');
$data['banks'] = $this->accounts->fetchBanks();
$data['parties'] = $this->accounts->fetchAll();
$data['userone'] = $this->users->fetchAll();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('accounts/receive_cheque_voucher',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchNetChequeSum()
{
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$pd_cheque_arr = $this->accounts->fetchNetChequeSum( $etype,$company_id );
$json = json_encode( $pd_cheque_arr );
echo $json;
}
public function fetchChartData()
{
$period = $_POST['period'];
$type = $_POST['etype'];
$company_id = $_POST['company_id'];
$data = $this->payments->fetchChartData($period,$type,$company_id);
$json = json_encode($data);
echo $json;
}
public function fetchTopTenCheques()
{
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$date = strtotime("+10 day");
$dateAfterTenDays = date('Y-m-d',$date);
$cheques = $this->accounts->fetchCheques($etype,$dateAfterTenDays,$company_id);
$json = json_encode($cheques);
echo $json;
}
public function saveUnpostPdCheque()
{
if (isset($_POST)) {
$this->ledgers->deleteVoucher($_POST['dcno'],$_POST['etype'],$_POST['company_id']);
$result = $this->accounts->saveCheque($_POST);
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
public function savePostPdCheque()
{
$this->ledgers->deleteVoucher($_POST['pd_cheque']['dcno'],$_POST['pd_cheque']['etype'],$_POST['pd_cheque']['company_id']);
$effected = $this->ledgers->save($_POST['pledger'],$_POST['pd_cheque']['dcno'],$_POST['pd_cheque']['etype'],$_POST['voucher_type_hidden']);
$result = $this->accounts->saveCheque($_POST['pd_cheque']);
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
public function fetchChequeVoucher()
{
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->accounts->fetchChequeVoucher( $dcno,$etype,$company_id );
$response = array();
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
public function removeChequeVoucher()
{
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->ledgers->deleteVoucher($dcno,$etype,$company_id);
$result = $this->accounts->removeChequeVoucher( $dcno,$etype,$company_id );
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
public function fetchReceiptRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->payments->fetchReceiptRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}
public function fetchPaymentRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->payments->fetchPaymentRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}
}

?>