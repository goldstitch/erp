
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Shift extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('shifts');
}
public function index() {
unauth_secure();
}
public function add() {
unauth_secure();
$data['modules'] = array('setup/shift/addshift');
$data['shifts'] = $this->shifts->fetchAllShifts();
$this->load->view('template/header');
$this->load->view('setup/shift/addshift',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function addGroup() {
unauth_secure();
$data['modules'] = array('setup/shift/addshiftgroup');
$data['shiftGroups'] = $this->shifts->fetchAllShiftGroups();
$this->load->view('template/header');
$this->load->view('setup/shift/addshiftgroup',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function allotGroup() {
unauth_secure();
$data['modules'] = array('setup/shift/allotshiftgroup');
$data['shifts'] = $this->shifts->fetchAllShifts();
$data['shiftGroups'] = $this->shifts->fetchAllShiftGroups();
$data['allotShiftGroups'] = $this->shifts->fetchAllAllotShiftGroups();
$this->load->view('template/header');
$this->load->view('setup/shift/allotshiftgroup',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxShiftId() {
$result = $this->shifts->getMaxShiftId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxShiftGroupId() {
$result = $this->shifts->getMaxShiftGroupId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxAllotShiftGroupId() {
$result = $this->shifts->getMaxAllotShiftGroupId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function saveShift() {
if (isset($_POST)) {
$shift = $_POST['shift'];
$result = $this->shifts->saveShift( $shift );
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
public function saveShiftGroup() {
if (isset($_POST)) {
$shiftgroup = $_POST['shiftgroup'];
$error = $this->shifts->isShiftGroupAlreadySaved($shiftgroup);
if (!$error) {
$result = $this->shifts->saveShiftGroup( $shiftgroup );
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response['error'] = false;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function saveAllotShift() {
if (isset($_POST)) {
$allotshift = $_POST['allotshift'];
$result = $this->shifts->saveAllotShift( $allotshift );
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
public function fetchShift() {
if (isset( $_POST )) {
$shid = $_POST['shid'];
$result = $this->shifts->fetchShift($shid);
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
public function fetchShiftGroup() {
if (isset( $_POST )) {
$gid = $_POST['gid'];
$result = $this->shifts->fetchShiftGroup($gid);
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
public function fetchAllotShift() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->shifts->fetchAllotShift($id);
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
public function fetchAllShifts() {
$result = $this->shifts->fetchAllShifts();
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
public function fetchAllShiftGroups() {
$result = $this->shifts->fetchAllShiftGroups();
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
public function fetchAllAllotShiftGroups() {
$result = $this->shifts->fetchAllAllotShiftGroups();
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
public function saveGroupAssignedCheck() {
if (isset($_POST)) {
$gid = $_POST['gid'];
$result = $this->shifts->saveGroupAssignedCheck($gid);
$response = array();
if ($result) {
$response['error'] = 'false';
}else {
$response['error'] = 'true';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function updateGroupAssignedCheck() {
if (isset($_POST)) {
$hiddengid = $_POST['hiddengid'];
$gid = $_POST['gid'];
$result = $this->shifts->updateGroupAssignedCheck($hiddengid,$gid);
$response = array();
if ($result) {
$response['error'] = 'false';
}else {
$response['error'] = 'true';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
}

?>