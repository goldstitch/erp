
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Department extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('departments');
}
public function index() {
redirect('department/add');
}
public function add() {
$data['modules'] = array('setup/adddepartment');
$data['departments'] = $this->departments->fetchAllDepartments();
$this->load->view('template/header');
$this->load->view('setup/adddepartment',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxDepartmentId() {
$result = $this->departments->getMaxDepartmentId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function saveDepartment() {
if (isset($_POST)) {
$department = $_POST['department'];
$result = $this->departments->saveDepartment( $department );
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
public function fetchDepartment() {
if (isset( $_POST )) {
$did = $_POST['did'];
$result = $this->departments->fetchDepartment($did);
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
public function fetchAllDepartments() {
$result = $this->departments->fetchAllDepartments();
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

?>