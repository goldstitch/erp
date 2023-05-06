
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Inward extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('salesmen');
$this->load->model('companies');
$this->load->model('transporters');
$this->load->model('items');
$this->load->model('ledgers');
$this->load->model('departments');
$this->load->model('sales');
$this->load->model('purchases');
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
public function  outward(){
unauth_secure();
$data['modules'] = array('sale/outward');
$data['parties'] = $this->accounts->fetchAll(1,'all');
$data['vehicles'] = $this->purchases->fetchByCol_inward('prepared_by');
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['uoms'] = $this->items->fetchByCol('uom');
$data['title'] = 'Outward Voucher';
$this->load->view('template/header',$data);
$this->load->view('sale/outward',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function index() {
unauth_secure();
$data['modules'] = array('sale/inward');
$data['parties'] = $this->accounts->fetchAll(1,'all');
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['vehicles'] = $this->purchases->fetchByCol_inward('prepared_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['companies'] = $this->companies->getAll();
$data['uoms'] = $this->items->fetchByCol('uom');
$data['short_codes'] = $this->items->fetchAllArticles(1);
$data['title'] = 'Inward Voucher';
$this->load->view('template/header',$data);
$this->load->view('sale/inward',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchLfiveRates() {
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$crit = $_POST['crit'];
$result = $this->purchases->last_5_srate($item_id,$etype,$company_id,$crit);
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
public function CheckDuplicateVoucher() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$vrnoa = $_POST['vrnoa'];
$gp = $_POST['gp'];
$result = $this->purchases->CheckDuplicateVoucher($vrnoa,$etype,$company_id,$gp);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$stockmain = $_POST['stockmain'];
$stockdetail = $_POST['stockdetail'];
$vrnoa = $_POST['vrnoa'];
$etype = $_POST['etype'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->purchases->getMaxVrnoa($etype,$stockmain['company_id']) +1;
}
$result = false;
if($etype == "issuetovenders")
{
$result = $this->purchases->CheckDuplicateVoucher($vrnoa,$etype,$stockmain['company_id'],$stockmain['bilty_no']);
}
if($result == false)
{
$result = $this->purchases->save($stockmain,$stockdetail,$vrnoa,$etype);
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
else
{
$this->output->set_content_type('application/json')->set_output(json_encode('duplicategp'));
}
}
}
public function fetch() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->purchases->fetch($vrnoa,$etype ,$company_id);
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
public function fetchOgp() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$company_id2 = $_POST['company_id2'];
$etype = $_POST['etype'];
$result = $this->purchases->fetchOgp($vrnoa,$etype ,$company_id,$company_id2);
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
public function fetchIgp() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$etype2 = $_POST['etype2'];
$result = $this->purchases->fetchIgp($vrnoa,$etype ,$company_id,$etype2);
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