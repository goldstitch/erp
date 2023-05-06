

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Storeinspectionreceipt extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('transporters');
$this->load->model('items');
$this->load->model('departments');
$this->load->model('purchases');
}
public function index() {
redirect('storeinspectionreceipt/add');
}
public function add() {
$data['modules'] = array('purchase/storeinspectionreceipt');
$data['parties'] = $this->accounts->fetchAll();
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['items'] = $this->items->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$this->load->view('template/header');
$this->load->view('purchase/storeinspectionreceipt',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxVrno() {
$result = $this->purchases->getMaxVrno('sir') +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxVrnoa() {
$result = $this->purchases->getMaxVrnoa('sir') +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function save() {
if (isset($_POST)) {
$stockmain = $_POST['stockmain'];
$stockdetail = $_POST['stockdetail'];
$vrnoa = $_POST['vrnoa'];
$result = $this->purchases->save($stockmain,$stockdetail,$vrnoa,'sir');
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
$result = $this->purchases->fetchStoreInspectionReceipt($vrnoa,'sir');
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
$result = $this->purchases->delete($vrnoa,'sir');
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