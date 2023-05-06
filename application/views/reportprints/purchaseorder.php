

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class PurchaseOrder extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('salesmen');
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
$data = $this->orders->fetchChartData($period,$company_id,$etype);
$json = json_encode($data);
echo $json;
}
public function index() {
unauth_secure();
$data['modules'] = array('purchase/purchaseorder');
$data['parties'] = $this->accounts->fetchAll(1,'all');
$data['salesmen'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->orders->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['types'] = $this->items->fetchByCol('barcode');
$data['uoms'] = $this->items->fetchByCol('uom');
$data['typess'] = $this->accounts->getDistinctFields('etype');
$data['dispatch_addresss'] = $this->orders->fetchAllDistinctMain('dispatch_address');
$data['delivery_terms'] = $this->orders->fetchAllDistinctMain('delivery_term');
$data['payment_terms'] = $this->orders->fetchAllDistinctMain('payment_term');
$this->load->view('template/header');
$this->load->view('purchase/purchaseorder',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchNetSum()
{
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$sum = $this->orders->fetchNetSum( $company_id ,$etype);
$json = json_encode($sum);
echo $json;
}
public function getMaxVrno() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$result = $this->orders->getMaxVrno('pur_order',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$result = $this->orders->getMaxVrnoa('pur_order',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$ordermain = $_POST['ordermain'];
$orderdetail = $_POST['orderdetail'];
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
$result = $this->orders->save($ordermain,$orderdetail,$vrnoa,'pur_order');
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
$result = $this->orders->fetch($vrnoa,'pur_order',$company_id);
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
public function fetchRemaining() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->orders->fetchRemaining($vrnoa,$etype,$company_id);
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
public function fetchOrderReportData()
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
$sreportData = $this->orders->fetchOrderReportData($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchOrderReportDataPartsts()
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
$sreportData = $this->orders->fetchOrderReportDataParts($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
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
$sreportData = $this->orders->fetchPurchaseReportData($startDate,$endDate,$what,$type,$company_id,$etype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchImportRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->orders->fetchImportRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}
public function fetchRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->orders->fetchRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}
}

?>