


<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Attendance extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('departments');
$this->load->model('staffs');
$this->load->model('departments');
$this->load->model('attendances');
}
public function index(){
unauth_secure();
}
public function update() {
unauth_secure();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['staffs'] = $this->staffs->fetchAll();
$data['modules'] = array('attendance/updateattendancestatus');
$this->load->view('template/header');
$this->load->view('attendance/updateattendancestatus',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function updateMultiple() {
unauth_secure();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['staffs'] = $this->staffs->fetchAll();
$data['modules'] = array('attendance/updateStatusMultiple');
$this->load->view('template/header');
$this->load->view('attendance/updateStatusMultiple',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function staff() {
unauth_secure();
$data['modules'] = array('attendance/staffattendance');
$data['types'] = $this->staffs->getAllTypes();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['title'] = 'Staff Attendance Voucher';
$this->load->view('template/header',$data);
$this->load->view('attendance/staffattendance',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$result = $this->attendances->getMaxId() +1;
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function getMaxStaffAtndId() {
$result = $this->attendances->getMaxStaffAtndId() +1;
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function save() {
if (isset($_POST)) {
$atndcs = $_POST['atndcs'];
$dcno = $_POST['dcno'];
$result = $this->attendances->save( $atndcs,$dcno );
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response['error'] = false;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function updateAttendance() {
if (isset($_POST)) {
$attendance = $_POST['attendance'];
$result = $this->attendances->updateAttendance( $attendance);
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response['error'] = false;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function updateAttendanceMultiple() {
if (isset($_POST)) {
$attendance = json_decode($_POST['attendance'],true);
$result = $this->attendances->updateAttendanceMultiple( $attendance);
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response['error'] = false;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function postStaff() {
if (isset($_POST)) {
$data = objectToArray(json_decode($_POST['postData']));
$vouchers = $data['vouchers'];
$result = $this->attendances->post( $vouchers );
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function saveStaff() {
if (isset($_POST)) {
$atndcs = $_POST['atndcs'];
$dcno = $this->input->post('dcno');
$result = $this->attendances->saveStaff( $atndcs,$dcno );
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response['error'] = false;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch() {
if (isset( $_POST )) {
$dcno = $_POST['dcno'];
$results = $this->attendances->fetch($dcno);
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
public function fetchStaff() {
if (isset( $_POST )) {
$dcno = $_POST['dcno'];
$company_id = $this->session->userdata['company_id'];
$results = $this->attendances->fetchStaff($dcno,$company_id);
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
public function studentAttendanceStatusWiseReport() {
if (isset($_POST)) {
$from = $_POST['from'];
$to = $_POST['to'];
$cmid = $_POST['cmid'];
$stdid = $_POST['stdid'];
$status = $_POST['status'];
$result = $this->attendances->studentAttendanceStatusWiseReport($from,$to,$cmid,$stdid,$status);
$response = "";
if ($result == false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function staffAttendanceStatusWiseReport() {
if (isset($_POST)) {
$from = $_POST['from'];
$to = $_POST['to'];
$did = $_POST['did'];
$staid = $_POST['staid'];
$status = $_POST['status'];
$result = $this->attendances->staffAttendanceStatusWiseReport($from,$to,$did,$staid,$status);
$response = "";
if ($result == false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function staffAttendanceSheet() {
if (isset($_POST)) {
$to = $_POST['to'];
$from = $_POST['from'];
$did = $_POST['did'];
$staid = $_POST['staid'];
$result = $this->attendances->staffAttendanceSheet($from,$to,$did,$staid);
$response = "";
if ($result == false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function studentAttendanceMonthWiseReport() {
if (isset($_POST)) {
$from = $_POST['from'];
$to = $_POST['to'];
$cmid = $_POST['cmid'];
$stdid = $_POST['stdid'];
$result = $this->attendances->studentAttendanceMonthWiseReport($from,$to,$cmid,$stdid);
$response = "";
if ($result == false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function monthlyAttendanceReport() {
if (isset($_POST)) {
$month = $_POST['month'];
$year = $_POST['year'];
$cmid = $_POST['cmid'];
$result = $this->attendances->monthlyAttendanceReport($month,$year,$cmid);
$response = "";
if ($result == false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function staffMonthlyAttendanceReport() {
if (isset($_POST)) {
$month = $_POST['month'];
$year = $_POST['year'];
$did = $_POST['did'];
$result = $this->attendances->staffMonthlyAttendanceReport($month,$year,$did);
$response = "";
if ($result == false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function isVoucherAlreadySaved() {
if (isset( $_POST )) {
$date = $_POST['date'];
$dids = $_POST['dids'];
$dcno = $_POST['dcno'];
$typee = $_POST['typee'];
$result = $this->attendances->isVoucherAlreadySaved($date,$dids,$dcno,$typee);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchStaffForTimeInOut() {
if (isset( $_POST )) {
$staid = $_POST['staid'];
$result = $this->attendances->fetchStaffForTimeInOut($staid);
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
public function deleteAttendance() {
if (isset($_POST)) {
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$company_id=$this->session->userdata['company_id'];
$result = $this->attendances->deleteAttendance($dcno,$etype,$company_id);
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
public function fetchAllAttendance() {
if (isset($_POST)) {
$staid = $_POST['staid'];
$result = $this->attendances->fetchAllAttendance($staid);
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
}

?>