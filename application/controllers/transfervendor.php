

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Transfervendor extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('salesmen');
$this->load->model('transporters');
$this->load->model('orders');
$this->load->model('items');
$this->load->model('ledgers');
$this->load->model('departments');
$this->load->model('sales');
$this->load->model('purchases');
$this->load->model('users');
$this->load->model('levels');
}
public function fetchChartData()
{
$period = $_POST['period'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$data = $this->purchases->fetchChartData($period,$company_id,$etype);
$json = json_encode($data);
echo $json;
}
public function index() {
$data['modules'] = array('inventory/addtransfervendor');
$data['parties'] = $this->accounts->fetchAll(1,'creditor');
$data['salesmans'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['partyvendors'] = $this->orders->fetchParty_vendor();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['phase'] = $this->items->fetchAllSubPhase();
$data['title'] = 'Vendor Transfer Voucher';
$this->load->view('template/header',$data);
$this->load->view('inventory/addtransfervendor',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchNetSum()
{
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$sum = $this->purchases->fetchNetSum( $company_id ,$etype);
$json = json_encode($sum);
echo $json;
}
public function getMaxVrno() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrno('tr_produce',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrnoa('tr_produce',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$ledger = $_POST['ledger'];
$stockmain = $_POST['stockmain'];
$stockmain_produce = $_POST['stockmain_produce'];
if (isset($_POST['stockdetail'])){
$stockdetail = $_POST['stockdetail'];
}else{
$stockdetail = '';
}
if(isset($_POST['stockdetail_produce'])){
$stockdetail_produce = $_POST['stockdetail_produce'];
}else{
$stockdetail_produce = '';
}
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->purchases->getMaxVrnoa('tr_produce',$stockmain_produce['company_id']) +1;
}
$result = $this->ledgers->save($ledger,$vrnoa,'tr_produce',$voucher_type_hidden);
$result = $this->purchases->save($stockmain,$stockdetail,$vrnoa,'tr_consume');
$result_produce = $this->purchases->save($stockmain_produce,$stockdetail_produce,$vrnoa,'tr_produce');
$response = array();
if ( $result === false &&$result_produce === false) {
$response['error'] = 'true';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->purchases->fetch($vrnoa,'tr_produce',$company_id);
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
public function fetchVendorReportData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$orderBy = $_POST['orderBy'];
$name = $_POST['name'];
$crit = $_POST['crit'];
$sreportData = $this->purchases->fetchVendorReportData($startDate,$endDate,$what,$etype,$company_id,$orderBy,$name,$crit);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function delete() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->purchases->delete($vrnoa,"tr_consume",$company_id);
$result_produce = $this->purchases->delete($vrnoa,"tr_produce",$company_id);
$response = "";
if ( $result === false &&$result_produce===false ) {
$response = 'false';
}else {
$response = true;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchPurchaseReportData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$sreportData = $this->purchases->fetchPurchaseReportData($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchImportRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->purchases->fetchImportRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}
public function fetchRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->purchases->fetchRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}
}

?>