
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Inwardgatepass extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('items');
$this->load->model('departments');
$this->load->model('orders');
}
public function index() {
$data['modules'] = array('purchase/inwardgatepass');
$data['parties'] = $this->accounts->fetchAll();
$data['notedbys'] = $this->orders->fetchAllNotedBy();
$data['approveds'] = $this->orders->fetchAllApprovedBy();
$data['refersby'] = $this->orders->fetchAllreferBy();
$data['payments'] = $this->orders->fetchAllPayment();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll();
$this->load->view('template/header');
$this->load->view('purchase/inwardgatepass',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxVrno() {
$result = $this->orders->getMaxVrno('gp_in') +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxVrnoa() {
$result = $this->orders->getMaxVrnoa('gp_in') +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function save() {
if (isset($_POST)) {
$ordermain = $_POST['ordermain'];
$orderdetail = $_POST['orderdetail'];
$vrnoa = $_POST['vrnoa'];
$result = $this->orders->save($ordermain,$orderdetail,$vrnoa,'gp_in');
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
$result = $this->orders->fetchInwardGatePass($vrnoa,'gp_in');
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
$result = $this->orders->delete($vrnoa,'gp_in');
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