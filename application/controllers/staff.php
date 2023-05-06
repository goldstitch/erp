
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Staff extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('settings');
$this->load->model('accounts');
$this->load->model('departments');
$this->load->model('shifts');
$this->load->model('staffs');
$this->load->model('ledgers');
$this->load->model('levels');
}
public function index() {
unauth_secure();
}
public function add() {
unauth_secure();
$data['modules'] = array('setup/staff');
$data['types'] = $this->staffs->getAllTypes();
$data['agreements'] = $this->staffs->getAllAgreements();
$data['religions'] = $this->staffs->getAllReligions();
$data['banks'] = $this->staffs->getAllBankNames();
$data['desigs'] = $this->staffs->distincts_fields('designation');
$data['title'] = 'Add New Staff';
$data['departments'] = $this->departments->fetchAllDepartments();
$data['shiftGroups'] = $this->shifts->fetchAllShiftGroups();
$data['staffs'] = $this->staffs->fetchAll();
$this->load->view('template/header.php',$data);
$this->load->view('setup/addstaff.php',$data);
$this->load->view('template/mainnav.php');
$this->load->view('template/footer.php',$data);
}
public function fetchAllStaff(){
$crit=(isset($_POST['crit'])?$_POST['crit']:'');
$result = $this->staffs->fetchAllStaff($crit);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function salarySheet() {
unauth_secure();
$data['modules'] = array('salary/preparesalary');
$data['accounts'] = $this->accounts->fetchAll();
$data['salaryPlane'] = $this->settings->getSalaryPlane();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$this->load->view('template/header.php');
$this->load->view('salary/preparesalary.php',$data);
$this->load->view('template/mainnav.php');
$this->load->view('template/footer.php',$data);
}
public function WagesSheet() {
unauth_secure();
$data['modules'] = array('salary/preparewages');
$data['accounts'] = $this->accounts->fetchAll();
$data['salaryPlane'] = $this->settings->getSalaryPlane();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$this->load->view('template/header.php');
$this->load->view('salary/preparewages.php',$data);
$this->load->view('template/mainnav.php');
$this->load->view('template/footer.php',$data);
}
public function overtime() {
unauth_secure();
$data['modules'] = array('overtime/overtime');
$data['staffs'] = $this->staffs->fetchAll();
$data['overtimes'] = $this->staffs->fetchAllOvertime();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$this->load->view('template/header.php');
$this->load->view('overtime/overtime.php',$data);
$this->load->view('template/mainnav.php');
$this->load->view('template/footer.php',$data);
}
public function OverTimeMultiple() {
unauth_secure();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['staffs'] = $this->staffs->fetchAll();
$data['modules'] = array('overtime/OvertimeMultiple');
$this->load->view('template/header');
$this->load->view('overtime/OvertimeMultiple',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$result = $this->staffs->getMaxId() +1;
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function getMaxOvertimeId() {
$result = $this->staffs->getMaxOvertimeId() +1;
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function getMaxSalaryId() {
if (isset($_POST)) {
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->staffs->getMaxSalaryId($etype,$company_id) +1;
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$partyDetail = json_decode(html_entity_decode($_POST['acc'],true));
$partyDetail = (array)$partyDetail;
$ldetail = $this->levels->getLevel3ByName('ASSETS EMPLOYED');
$partyDetail['level3'] = 'null';
$pid = $this->accounts->save($partyDetail);
$staid = $this->staffs->save($_POST,$pid);
$salary = (array)(json_decode(html_entity_decode($_POST['salary'],true)));
$this->staffs->saveSalary($salary);
$qualifications = (array)(json_decode(html_entity_decode($_POST['quali'],true)));
$this->staffs->saveQualification($qualifications,$staid);
$experiences = (array)(json_decode(html_entity_decode($_POST['exp'],true)));
$this->staffs->saveExperience($experiences,$staid);
$this->output
->set_content_type('application/json')
->set_output(json_encode('true'));
}
}
public function saveOvertime() {
if (isset($_POST)) {
$overtime = $_POST['overtime'];
$result = $this->staffs->saveOvertime($overtime);
$response = array();
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response['error'] = 'false';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function saveOvertimeMultiple() {
if (isset($_POST)) {
$overtime = $_POST['overtime'];
$result = $this->staffs->saveOvertimeMultiple($overtime);
$response = array();
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response['error'] = 'false';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function saveSalarySheet() {
if (isset($_POST)) {
$pledgers = $this->input->post('pledgers');
$pledgers= json_decode($pledgers,true);
$salarysheet = $this->input->post('salarysheet');
$dcno = $this->input->post('dcno');
$etype = $this->input->post('etype');
$voucher_type_hidden = $this->input->post('voucher_type_hidden');
$result = $this->staffs->saveSalarySheet($salarysheet,$dcno);
$response = array();
if ( $result == "false") {
$response['error'] = 'true';
}else if ($result=="Duplicate"){
$response['error'] = 'Duplicate';
}else {
$result = $this->ledgers->save($pledgers,$dcno,$etype,$voucher_type_hidden);
$response['error'] = 'false';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchBloodGroups()
{
$result = $this->staffs->fetchBloodGroups($_POST);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchStaff() {
if (isset( $_POST )) {
$staid = $_POST['staid'];
$staff = $this->staffs->fetchStaff($staid);
$salary = $this->staffs->fetchStaffSalary($staid);
$quali = $this->staffs->fetchStaffQualification($staid);
$exp = $this->staffs->fetchStaffExperience($staid);
$response = array();
if ( $staff === false ) {
$response = 'false';
}else {
$response['staff'] = $staff;
$response['salary'] = $salary;
$response['quali'] = $quali;
$response['exp'] = $exp;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchOvertime() {
if (isset( $_POST )) {
$dcno = $_POST['dcno'];
$result = $this->staffs->fetchOvertime($dcno);
$response = array();
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
public function fetchSalarySheet() {
if (isset( $_POST )) {
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->staffs->fetchSalarySheet($dcno,$etype,$company_id);
$response = array();
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
public function fetchStaffReportByStatus() {
if (isset( $_POST )) {
$status = $_POST['status'];
$did = $_POST['did'];
$typee = 'all';
$company_id =1;
$results = $this->staffs->fetchStaffReportByStatus($status,$did,$typee,$company_id);
$response = array();
if ( $results === false ) {
$response = 'false';
}else {
$response = $results;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchByDepartment() {
if (isset( $_POST )) {
$did = $_POST['did'];
$results = $this->staffs->fetchByDepartment($did);
$response = array();
if ( $results === false ) {
$response = 'false';
}else {
$response = $results;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function getSalary() {
if (isset( $_POST )) {
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$results = $this->staffs->getSalary($from,$to,$company_id);
$response = array();
if ( $results === false ) {
$response = 'false';
}else {
$response = $results;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function getWages() {
if (isset( $_POST )) {
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$results = $this->staffs->getWages($from,$to,$company_id);
$response = array();
if ( $results === false ) {
$response = 'false';
}else {
$response = $results;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function deleteOvertime() {
if (isset($_POST)) {
$result = $this->staffs->deleteOvertime($_POST['dcno']);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = 'true';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function deleteSalarySheet() {
if (isset($_POST)) {
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->ledgers->deleteVoucher($dcno,$etype,$company_id);
$result = $this->staffs->deleteSalarySheet($dcno,$etype,$company_id);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = 'true';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
}
?>