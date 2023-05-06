

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Receivefromvender extends CI_Controller {
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
unauth_secure();
CheckVoucherRights('reveivefromvendor');
$data['modules'] = array('inventory/addreceivefromvender');
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['phase'] = $this->items->fetchAllSubPhase();
$data['title'] = "Receive From Vendors";
$this->load->view('template/header',$data);
$this->load->view('inventory/addreceivefromvender',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function VenderStockTransfer() {
unauth_secure();
CheckVoucherRights('transfervendor');
$data['modules'] = array('inventory/addVenderStockTransfer');
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['phase'] = $this->items->fetchAllSubPhase();
$data['title'] = "Vendors Stock Transfer";
$this->load->view('template/header',$data);
$this->load->view('inventory/addVenderStockTransfer',$data);
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
$etype = $_POST['etype'];
$result = $this->purchases->getMaxVrno($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->purchases->getMaxVrnoa($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
if(isset($_POST['vendordetail'])){
$vendordetail = json_decode($_POST['vendordetail'],true);
}else{
$vendordetail = "";
}
if(isset($_POST['ledger'])){
$ledger = $_POST['ledger'];
}else{
$ledger = "";
}
if(isset($_POST['stockdetail'])){
$stockdetail = $_POST['stockdetail'];
}else{
$stockdetail = "";
}
$stockmain = $_POST['stockmain'];
$vrnoa = $_POST['vrnoa'];
$etype = $stockmain['etype'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->purchases->getMaxVrnoa($etype,$stockmain['company_id']) +1;
}
if($ledger!='')
$result = $this->ledgers->save($ledger,$vrnoa,$etype,$voucher_type_hidden);
$result = $this->purchases->save($stockmain,$stockdetail,$vrnoa,$etype,$vendordetail);
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
$result = $this->purchases->fetch($vrnoa,$etype,$company_id);
$result2 = $this->purchases->fetchrfv($vrnoa,$etype,$company_id);
$response = array();
if ( $result === false ) {
$response = 'false';
}else {
$response['main'] = $result;
$response['less'] = $result2;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchContract() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$item_id = $_POST['item_id'];
$result = $this->orders->fetchContract($vrnoa,$etype ,$company_id,$item_id);
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
public function fetchContractIssue() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$item_id = $_POST['item_id'];
$result = $this->orders->fetchContractIssue($vrnoa,$etype ,$company_id,$item_id);
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
$result = $this->purchases->delete($vrnoa,$etype,$company_id);
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
$sum = $this->purchases->fetchRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}
}

?>