

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Issuetovender extends CI_Controller {
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
$data['modules'] = array('inventory/addissuetovender');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['phase'] = $this->items->fetchAllSubPhase();
$data['title'] = "Stock Issue To Vendor";
$this->load->view('template/header',$data);
$this->load->view('inventory/addissuetovender',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function rejection_vendor() {
$data['modules'] = array('inventory/addissuetovender');
$data['parties'] = $this->accounts->fetchAll();
$data['salesmans'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['partyvendors'] = $this->orders->fetchParty_vendor();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['types'] = $this->items->fetchByCol('barcode');
$data['typess'] = $this->accounts->getDistinctFields('etype');
$data['phase'] = $this->items->fetchAllSubPhase();
$this->load->view('template/header');
$this->load->view('inventory/addissuetovender',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function vendortransfer() {
$data['modules'] = array('inventory/addtransfervendor');
$data['parties'] = $this->accounts->fetchAll();
$data['salesmans'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['partyvendors'] = $this->orders->fetchParty_vendor();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['types'] = $this->items->fetchByCol('barcode');
$data['typess'] = $this->accounts->getDistinctFields('etype');
$data['phase'] = $this->items->fetchAllSubPhase();
$this->load->view('template/header');
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
$result = $this->purchases->getMaxVrno('issuetovenders',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrnoa('issuetovenders',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$stockmain = json_decode($_POST['stockmain'],true);
$stockmain = (array)$stockmain;
$stockdetail = json_decode($_POST['stockdetail'],true);
$stockdetail = (array)$stockdetail;
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
$ogpStatus = $this->purchases->ogpStatus($vrnoa,$stockmain['bilty_no'],'issuetovenders',$stockmain['company_id'],$voucher_type_hidden);
if($ogpStatus == false) {
if ($voucher_type_hidden == 'new') {
$vrnoa = $this->purchases->getMaxVrnoa('issuetovenders',$stockmain['company_id']) +1;
}
$result = $this->purchases->save($stockmain,$stockdetail,$vrnoa,'issuetovenders');
$response = array();
if ($result === false) {
$response['error'] = 'true';
}else {
$response = $result;
}
}
else
{
$response['error'] = "OGP# already exist";
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
$result = $this->purchases->fetch($vrnoa,'issuetovenders',$company_id);
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
public function fetchVendorReportData_settelement()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$orderBy = $_POST['orderBy'];
$name = $_POST['name'];
$crit = $_POST['crit'];
$sreportData = $this->purchases->fetchVendorReportData_settelement($startDate,$endDate,$what,$etype,$company_id,$orderBy,$name,$crit);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
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