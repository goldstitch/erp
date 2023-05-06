

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Stocktransferunit extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('items');
$this->load->model('jobs');
$this->load->model('departments');
$this->load->model('purchases');
$this->load->model('users');
}
public function index() {
redirect('stocktransfer/add');
}
public function add() {
$data['modules'] = array('inventory/addstocktransferunit');
$data['parties'] = $this->accounts->fetchAll();
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['approvedby'] = $this->purchases->fetchByCol('approved_by');
$data['preparedby'] = $this->purchases->fetchByCol('prepared_by');
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll();
$data['jobs'] = $this->jobs->fetchAllJobs('job_order');
$data['userone'] = $this->users->fetchAll();
$this->load->view('template/header');
$this->load->view('inventory/addstocktransferunit',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxVrno() {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrno('transferunit',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxVrnoa() {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrnoa('transferunit',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function save() {
if (isset($_POST)) {
$stockmain = $_POST['stockmain'];
$stockdetail = $_POST['stockdetail'];
$vrnoa = $_POST['vrnoa'];
$result = $this->purchases->save($stockmain,$stockdetail,$vrnoa,'transferunit');
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
$result = $this->purchases->fetchNavigation($vrnoa,'transferunit',$company_id);
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
$company_id = $_POST['company_id'];
$result = $this->purchases->delete($vrnoa,'transferunit',$company_id);
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