

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class YarnPurchaseContract extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('transporters');
$this->load->model('items');
$this->load->model('ledgers');
$this->load->model('salesmen');
$this->load->model('orders');
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
$data['modules'] 	= array('contract/addYarnPurchaseContract');
$data['parties'] 	= $this->accounts->fetchAll(1);
$data['receivers'] 	= $this->purchases->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['colors'] 	= $this->orders->fetchByColDetail('colors');
$data['items'] 		= $this->items->fetchAll(1,'yarn');
$data['userone'] 	= $this->users->fetchAll();
$data['l3s'] 		= $this->levels->fetchAllLevel3();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brandss'] 		= $this->orders->fetchByColDetail('brand');
$data['brands'] 	= $this->items->fetchAllBrands();
$data['types'] 		= $this->items->fetchByCol('barcode');
$data['approvedby'] = $this->orders->fetchAllApprovedBy();
$data['preparedby'] = $this->orders->fetchAllPreparedBy();
$data['brokers'] 	= $this->salesmen->fetchAll();
$data['worder'] 	= $this->orders->fetchAllSaleOrder();
$data['qltys'] = $this->orders->fetchAllDistinct('qlty');
$data['counts'] = $this->orders->fetchAllDistinct('count');
$data['dispatch_addresss'] = $this->orders->fetchAllDistinctMain('dispatch_address');
$data['delivery_terms'] = $this->orders->fetchAllDistinctMain('delivery_term');
$data['payment_terms'] = $this->orders->fetchAllDistinctMain('payment_term');
$this->load->view('template/header');
$this->load->view('contract/addYarnPurchaseContract',$data);
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
$result = $this->orders->getMaxVrno('yarnPurchaseContract',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$result = $this->orders->getMaxVrnoa('yarnPurchaseContract',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$stockmain = $_POST['stockmain'];
$stockdetail = $_POST['stockdetail'];
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->orders->getMaxVrnoa('yarnPurchaseContract',$stockmain['company_id']) +1;
}
$result = $this->orders->save($stockmain,$stockdetail,$vrnoa,'yarnPurchaseContract');
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
$result = $this->orders->fetch($vrnoa,'yarnPurchaseContract',$company_id);
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
$sreportData = $this->purchases->fetchPurchaseReportData($startDate,$endDate,$what,$type);
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