
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if (!defined('BASEPATH')) exit('No direct script access allowed');
class export extends CI_Controller
{
public function __construct()
{
parent::__construct();
$this->load->model('accounts');
$this->load->model('salesmen');
$this->load->model('transporters');
$this->load->model('currenceys');
$this->load->model('items');
$this->load->model('ledgers');
$this->load->model('purchases');
$this->load->model('departments');
$this->load->model('sales');
$this->load->model('orders');
$this->load->model('users');
$this->load->model('levels');
$this->load->model('exportvr',true);
}
public function fetchChartData()
{
$period = $_POST['period'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$data = $this->exportvr->fetchChartData($period,$company_id,$etype);
$json = json_encode($data);
echo $json;
}
public function index()
{
unauth_secure();
$data['modules'] = array('sale/export');
$data['parties'] = $this->accounts->fetchAll();
$data['salesmen'] = $this->salesmen->fetchAll();
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['userone'] = $this->users->fetchAll();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['orders_running'] = $this->exportvr->fetchOrders(date("Y/m/d"),date("Y/m/d"),'sale');
$data['currenceys'] = $this->currenceys->fetchAllCurrencey();
$data['shippmentFroms'] = $this->exportvr->fetchByCol('shippment_from');
$data['shippmentTos'] = $this->exportvr->fetchByCol('shippment_to');
$data['expregs'] = $this->exportvr->fetchByCol('export_register_no');
$data['DeliveryTerms'] = $this->exportvr->fetchDeliveryTerms();
$data['PaymentTerms'] = $this->exportvr->fetchPaymentTerms();
$data['Portofdischarge'] = $this->exportvr->fetchPortofdischarge();
$data['companyInfo'] = $this->exportvr->getCompanyInfo('1');
$data['title'] = "Export Voucher";
$this->load->view('template/header',$data);
$this->load->view('sale/export',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function partsdetail()
{
unauth_secure();
$data['modules'] = array('sale/orderpartsdetail');
$data['parties'] = $this->accounts->fetchAll(1,'purchase');
$data['salesmen'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->exportvr->fetchByCol('received_by');
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
$data['orders_running'] = $this->exportvr->fetchOrders(date("Y/m/d"),date("Y/m/d"),'running');
$this->load->view('template/header');
$this->load->view('sale/orderpartsdetail',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchNetSum()
{
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$sum = $this->exportvr->fetchNetSum($company_id,$etype);
$json = json_encode($sum);
echo $json;
}
public function Loading_Stock()
{
$order_no = $_POST['order_no'];
$company_id = $_POST['company_id'];
$sum = $this->exportvr->Loading_Stock($company_id,$order_no);
$json = json_encode($sum);
echo $json;
}
public function getMaxVrno()
{
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->exportvr->getMaxVrno($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa()
{
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->exportvr->getMaxVrnoa($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function Validate_Order()
{
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$order_no = $_POST['order_no'];
$status = $_POST['status'];
$result = $this->exportvr->Validate_Order($etype,$company_id,$order_no,$status);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function Validate_Order_Loading()
{
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$order_no = $_POST['order_no'];
$status = $_POST['status'];
$result = $this->exportvr->Validate_Order_Loading($etype,$company_id,$order_no,$status);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save()
{
if (isset($_POST))
{
$ordermain = $_POST['ordermain'];
$orderdetail = $_POST['orderdetail'];
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
$etype = $_POST['etype'];
$result = $this->exportvr->save($ordermain,$orderdetail,$vrnoa,$etype);
$response = array();
if ($result === false) {
$response['error'] = 'true';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch()
{
if (isset($_POST))
{
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
if (isset($_POST['etype2'])) {
$etype2 = $_POST['etype2'];
$result = $this->exportvr->fetch($vrnoa,$etype,$company_id,$etype2);
}else {
$etype2 = '';
$result = $this->exportvr->getMaxVrno($etype,$company_id) +1;
$result = $this->exportvr->fetch($vrnoa,$etype,$company_id);
}
$response = "";
if ($result === false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch_vrno()
{
if (isset($_POST))
{
$vrno = $_POST['vrno'];
$company_id = $_POST['company_id'];
$etype2 = $_POST['etype2'];
$etype = $_POST['etype'];
$result = $this->exportvr->fetch_vrno($vrno,$etype,$company_id,$etype2);
$response = "";
if ($result === false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchLfiveStocks()
{
if (isset($_POST))
{
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$vrdate = $_POST['vrdate'];
$result = $this->exportvr->fetchItemStocks($item_id,$etype,$company_id,$vrdate);
if ($result === false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchItemStocks_vendor()
{
if (isset($_POST))
{
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$crit = $_POST['crit'];
$vrdate = $_POST['vrdate'];
$result = $this->exportvr->fetchItemStocks_vendor($crit,$etype,$company_id,$vrdate);
if ($result === false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchLfiveRates()
{
if (isset($_POST))
{
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$crit = $_POST['crit'];
$result = $this->exportvr->last_5_srate($item_id,$etype,$company_id,$crit);
if ($result === false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchTypeParty()
{
if (isset($_POST))
{
$etype = $_POST['type'];
$company_id = $_POST['company_id'];
$result = $this->accounts->fetchTypeParty($etype);
$response = "";
if ($result === false ||$result === null) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function last_5_srate()
{
if (isset($_POST))
{
$party_id = $_POST['party_id'];
$company_id = $_POST['company_id'];
$item_id = $_POST['item_id'];
$result = $this->exportvr->last_5_srate($party_id,$item_id,$company_id);
$response = "";
if ($result === false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch_order_stock()
{
if (isset($_POST))
{
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->exportvr->fetch_order_stock($vrnoa,$etype,$company_id);
$response = "";
if ($result === false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchPartsOrder()
{
if (isset($_POST))
{
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result_vrnoa = $this->exportvr->fetch($vrnoa,$etype,$company_id);
$result_parts = $this->exportvr->fetchPartsOrder($vrnoa,$etype,$company_id,'parts');
$result2_spare = $this->exportvr->fetchPartsOrder($vrnoa,$etype,$company_id,'spare_parts');
$result3_less = $this->exportvr->fetchPartsOrder($vrnoa,$etype,$company_id,'less');
if ($result_vrnoa === false) {
$response['vrnoa'] = 'false';
}else {
$response['vrnoa'] = $result_vrnoa;
}
if ($result_parts === false) {
$response['parts'] = 'false';
}else {
$response['parts'] = $result_parts;
}
if ($result2_spare === false) {
$response['spare'] = 'false';
}else {
$response['spare'] = $result2_spare;
}
if ($result3_less === false) {
$response['less'] = 'false';
}else {
$response['less'] = $result3_less;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch_loading_Stock()
{
if (isset($_POST)) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result_vrnoa = $this->exportvr->fetch($vrnoa,$etype,$company_id);
$result_parts = $this->exportvr->fetch_loading_Stock($vrnoa,$company_id);
if ($result_vrnoa === false) {
$response['vrnoa'] = 'false';
}else {
$response['vrnoa'] = $result_vrnoa;
}
if ($result_parts === false) {
$response['parts'] = 'false';
}else {
$response['parts'] = $result_parts;
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
$sreportData = $this->exportvr->fetchOrderReportData($startDate,$endDate,$what,$type,$company_id,$etype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function delete()
{
if (isset($_POST)) {
$vrnoa = $_POST['vrnoa'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->exportvr->delete($vrnoa,$etype,$company_id);
$response = "";
if ($result === false) {
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
$sreportData = $this->exportvr->fetchPurchaseReportData($startDate,$endDate,$what,$type,$company_id,$etype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchImportRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->exportvr->fetchImportRangeSum($from,$to);
$json = json_encode($sum);
echo $json;
}
public function fetchRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->exportvr->fetchRangeSum($from,$to);
$json = json_encode($sum);
echo $json;
}
public function fetchsaleorder()
{
if (isset($_POST)) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->exportvr->fetch($vrnoa,'sale_order',$company_id);
$response = "";
if ($result === false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
}
?>