

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class requisition extends CI_Controller {
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
$data['modules'] = array('purchase/addrequisition');
$data['departments'] = $this->departments->fetchAllDepartments();
$data['types'] = $this->items->fetchByCol('barcode');
$data['short_codes'] = $this->items->fetchAllArticles(1);
$data['title'] = 'Requisition Voucher';
$name = $this->session->userdata('uname'); 
if($name=='admin')
{

}
else{
$data['did']=$this->users->getdepart_id($name);
}
$this->load->view('template/header',$data);
$this->load->view('purchase/requisition',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function FetchBulkSearchForOrder()
{
$data = array();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['sizes'] = $this->items->fetchByCol('size');
$data['colors'] = $this->items->fetchByCol('model');
$this->output
->set_content_type('application/json')
->set_output(json_encode($data));
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
$result = $this->orders->getMaxVrno('requisition',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$result = $this->orders->getMaxVrnoa('requisition',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$ordermain = $_POST['ordermain'];
$orderdetail = json_decode($_POST['orderdetail'],true);
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
$result = $this->datechecks->dateChecking($ordermain['vrdate']);
if($result == true)
{
if ($voucher_type_hidden=='new'){
$vrnoa = $this->orders->getMaxVrnoa('requisition',$ordermain['company_id']) +1;
}
$result = $this->orders->save($ordermain,$orderdetail,$vrnoa,'requisition');
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
else
{
$this->output->set_content_type('application/json')->set_output(json_encode('dateclose'));
}
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
$sreportData = $this->orders->fetchPurchaseReportData($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetch() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->orders->fetch($vrnoa,'requisition',$company_id);
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
public function fetchRequisition() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$result = $this->orders->fetchRequisition($vrnoa,'requisition',$company_id,$crit);
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
public function fetchItemStocks() {
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = array();
$result['stock'] = $this->orders->fetchItemStocks($item_id,$etype,$company_id);
$result['lprate'] = $this->orders->fetchItemlpRate($item_id,$etype,$company_id);
$response = [];
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
public function fetchLfiveStocks() {
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->orders->fetchLfiveStocks($item_id,$etype,$company_id);
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
public function fetchLfiveRates() {
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$crit = $_POST['crit'];
$result = $this->orders->last_5_srate($item_id,$etype,$company_id,$crit);
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
public function fetchRequisitionReportData()
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
$sreportData = $this->orders->fetchRequisitionReportData($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
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