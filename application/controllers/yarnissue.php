
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Yarnissue extends CI_Controller {
public function __construct()
{
parent::__construct();
$this->load->model('yarnissues');
$this->load->model('departments');
$this->load->model('accounts');
$this->load->model('weavingcontracts');
}
public function index() {
unauth_secure();
$data['modules'] = array('setup/addYarnIssueVoucher');
$data['contracts'] = $this->weavingcontracts->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['title'] = 'Yarn Issue Voucher';
$this->load->view('template/header',$data);
$this->load->view('setup/addYarnIssueVoucher',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchYarnReportData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$sreportData = $this->yarnissues->fetchYarnReportData($startDate,$endDate,$what,$type,$company_id,$etype,$crit);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function YarnReturn() {
unauth_secure();
$data['modules'] = array('setup/addYarnReturnVoucher');
$data['contracts'] = $this->weavingcontracts->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['title'] = 'Yarn Return Voucher';
$this->load->view('template/header',$data);
$this->load->view('setup/addYarnReturnVoucher',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function FabricReceive() {
unauth_secure();
$data['modules'] = array('setup/addFabricReceiveVoucher');
$data['contracts'] = $this->weavingcontracts->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['title'] = 'Fabric Receive Voucher';
$this->load->view('template/header',$data);
$this->load->view('setup/addFabricReceiveVoucher',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->yarnissues->getMaxId($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function searchAccount()
{
$search = $_POST['search'];
$type = $_POST['type'];;
$result = $this->products->searchAccounts($search,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function searchBrokers()
{
$search = $_POST['search'];
$type = $_POST['type'];;
$result = $this->products->searchBrokers($search,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function searchitem(){
$search = $_POST['search'];
$result = $this->products->searchitem($search);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function delete() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->yarnissues->delete($vrnoa,$etype,$company_id);
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
$etype = $_POST['etype'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->yarnissues->getMaxId($etype,$stockmain['company_id']) +1;
}
$result = $this->yarnissues->save($stockmain,$stockdetail,$vrnoa,$etype,$ledger);
$response = array();
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response = $vrnoa;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->yarnissues->fetch($vrnoa,$etype,$company_id);
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
public function fetchAll(){
$activee=(isset($_POST['active'])?$_POST['active']:-1);
$result = $this->yarnissues->fetchAll($activee);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}

?>