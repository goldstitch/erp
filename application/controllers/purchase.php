
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Purchase extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('salesmen');
$this->load->model('purchases');
$this->load->model('transporters');
$this->load->model('items');
$this->load->model('ledgers');
$this->load->model('departments');
$this->load->model('sales');
$this->load->model('orders');
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
unauth_secure();
CheckVoucherRights('purchasevoucher');
$data['modules'] = array('purchase/addpurchase');
$data['salesmen'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->orders->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['title'] ='Purchase Voucher';
$this->load->view('template/header',$data);
$this->load->view('purchase/addpurchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function VendorBill() {
unauth_secure();
CheckVoucherRights('vendorbillvoucher');
$data['modules'] = array('purchase/addVendorBill');
$data['salesmen'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->orders->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['title'] ='Vendor Bill';
$this->load->view('template/header',$data);
$this->load->view('purchase/addVendorBill',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchReportDataMain()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$uid = $_POST['uid'];
$sreportData = $this->purchases->fetchReportDataMain($startDate,$endDate,$company_id,$etype,$uid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchReportDataProduction()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$uid = $_POST['uid'];
$type = $_POST['type'];
$sreportData = $this->purchases->fetchReportDataProduction($startDate,$endDate,$company_id,$etype,$uid,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
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
$etype = $_POST['etype'];
$result = $this->orders->getMaxVrno($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->orders->getMaxVrnoa($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
if(isset($_POST['ledger'])){
$ledger = json_decode($_POST['ledger'],true);
}else{
$ledger = "";
}
$stockmain = $_POST['stockmain'];
$stockdetail = $_POST['stockdetail'];
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
$etype = $_POST['etype'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->orders->getMaxVrnoa($etype,$stockmain['company_id']) +1;
}
$result = $this->ledgers->save($ledger,$vrnoa,$etype,$voucher_type_hidden);
$result = $this->orders->save($stockmain,$stockdetail,$vrnoa,$etype);
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
}
public function fetch() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->orders->fetch($vrnoa,$etype,$company_id);
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
public function delete() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->orders->delete($vrnoa,$etype,$company_id);
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
$etype = "purchase";
if(isset($_POST['etype']))
$etype = $_POST['etype'];
$sum = $this->purchases->fetchRangeSum( $from,$to,$etype );
$json = json_encode($sum);
echo $json;
}
}

?>