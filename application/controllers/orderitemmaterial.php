
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Orderitemmaterial extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('orders');
$this->load->model('accounts');
$this->load->model('itemmaterials');
$this->load->model('orderitemmaterials');
$this->load->model('salesmen');
$this->load->model('transporters');
$this->load->model('subphases');
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
$data['modules'] = array('sale/addorderitemmaterial');
$data['parties'] = $this->accounts->fetchAll(1);
$data['short_codes'] = $this->items->fetchAllArticles(1);
$data['items'] = [];
$data['PreparedBys'] = $this->orderitemmaterials->fetchPrepareBy();
$data['ApprovedBys'] = $this->orderitemmaterials->fetchApproveBy();
$data['subPhases'] = $this->subphases->fetchAllSubPhase();
$data['subPhases22'] = $data['subPhases'];
$data['wOrder'] = $this->orders->fetchAllSaleOrder();
$data['labels'] = $this->orderitemmaterials->fetchByCols('label');
$data['pbpaperslips'] = $this->orderitemmaterials->fetchByCols('polybag_paperslip');
$data['pbstickers'] = $this->orderitemmaterials->fetchByCols('polybag_sticker');
$data['ctnpaperslips'] = $this->orderitemmaterials->fetchByCols('carton_paperslip');
$data['ctnstickers'] = $this->orderitemmaterials->fetchByCols('carton_sticker');
$data['pbpackings'] = $this->orderitemmaterials->fetchByCols('polybag_packing');
$data['ctnpackings'] = $this->orderitemmaterials->fetchByCols('carton_packing');
$data['ctnmarkings'] = $this->orderitemmaterials->fetchByCols('carton_marking');
$data['title'] = 'Order Required Material';
$this->load->view('template/header',$data);
$this->load->view('sale/addorderitemmaterial',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchByCols()
{
$col_name = $_POST['col_name'];
$result = $this->orderitemmaterials->fetchByCols($col_name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
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
$result = $this->orderitemmaterials->getMaxVrno('item_required',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$result = $this->orderitemmaterials->getMaxVrnoa('item_required',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function checkWorkOrder() {
if (isset($_POST)) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->orderitemmaterials->checkWorkOrder($vrnoa,'item_required',$company_id);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$stockmain = $_POST['stockmain'];
$stockdetail = json_decode($_POST['stockdetail'],true);
$vrnoa = $_POST['vrnoa'];
$result = $this->orderitemmaterials->save($stockmain,$stockdetail,$vrnoa,'item_required');
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
$result['all'] = $this->orderitemmaterials->fetch($vrnoa,'item_required',$company_id);
$response = "";
if ( $result['all'] === false ) {
$response = 'false';
}else {
$result['labour'] = $this->orderitemmaterials->fetchLabour($vrnoa,'item_required',$company_id,'labour');
$result['embelishment'] = $this->orderitemmaterials->fetchLabour($vrnoa,'item_required',$company_id,'embelishment');
$result['fabrication'] = $this->orderitemmaterials->fetchLabour($vrnoa,'item_required',$company_id,'fabrication');
$result['order_items'] = $this->orders->fetch($result['all'][0]['worder'],'sale_order',$company_id);
$result['ArticleSummary'] =$this->orders->fetchArticleSummaryOrder($result['all'][0]['worder'],'sale_order',$company_id);
$result['ArticleSummaryColor'] =$this->orders->fetchArticleSummaryColorOrder($result['all'][0]['worder'],'sale_order',$company_id);
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchOrder() {
if (isset( $_POST )) {
$crit = '';
if(isset($_POST['crit']))
$crit = $_POST['crit'];
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->orderitemmaterials->fetchOrder($vrnoa,'item_required',$company_id,$crit);
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
public function FetchBulkItemsRequired() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$data = array();
$data['categories'] = $this->orderitemmaterials->FetchCatagoriesRequired($vrnoa,$company_id);
$data['subcategories'] = $this->orderitemmaterials->FetchSubCatagoriesRequired($vrnoa,$company_id);
$data['brands'] = $this->orderitemmaterials->FetchBrandsRequired($vrnoa,$company_id);
$data['articles'] = $this->orderitemmaterials->FetchArticlesRequired($vrnoa,$company_id);
$this->output
->set_content_type('application/json')
->set_output(json_encode($data));
}
}
public function delete() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->orderitemmaterials->delete($vrnoa,$etype,$company_id);
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
public function fetchPartsOrder() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result_vrnoa   = $this->orders->fetch($vrnoa,$etype,$company_id);
$result_parts   = $this->orders->fetchPartsOrders($vrnoa,$etype,$company_id,'parts','material');
$result2_spare  = $this->orders->fetchPartsOrders($vrnoa,$etype,$company_id,'spare_parts','');
$result_packing = $this->orders->fetchPartsOrders($vrnoa,$etype,$company_id,'parts','packing');
$result_labour  = $this->orders->fetchPartsOrderaLabour($vrnoa,$etype,$company_id,'labour');
$result_ArticleSummary =$this->orders->fetchArticleSummaryOrder($vrnoa,'sale_order',$company_id);
$ArticleSummaryColor =$this->orders->fetchArticleSummaryColorOrder($vrnoa,'sale_order',$company_id);
if ( $result_vrnoa === false ) {
$response['vrnoa'] = 'false';
}else {
$response['vrnoa'] = $result_vrnoa;
}
if ( $result_parts === false ) {
$response['parts'] = 'false';
}else {
$response['parts'] = $result_parts;
}
if ( $result2_spare === false ) {
$response['spare'] = 'false';
}else {
$response['spare'] = $result2_spare;
}
if ( $result_packing === false ) {
$response['packing'] = 'false';
}else {
$response['packing'] = $result_packing;
}
if ( $result_labour === false ) {
$response['labour'] = 'false';
}else {
$response['labour'] = $result_labour;
}
if ( $result_ArticleSummary === false ) {
$response['ArticleSummary'] = 'false';
}else {
$response['ArticleSummary'] = $result_ArticleSummary;
}
if ( $ArticleSummaryColor === false ) {
$response['ArticleSummaryColor'] = 'false';
}else {
$response['ArticleSummaryColor'] = $ArticleSummaryColor;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchproductionplan()
{
if (isset( $_POST ))
{
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->orderitemmaterials->fetchProductionPlan($vrnoa,'productionplan',$company_id);
$response = "";
if ( $result === false )
{
$response = 'false';
}
else
{
$response = $result;
}
$this->output->set_content_type('application/json')->set_output(json_encode($response));
}
}
}

?>