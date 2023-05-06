
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Jobexpense extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('costingexpenses');
$this->load->model('ledgers');
$this->load->model('jobs');
}
public function index() {
redirect('jobexpense/add');
}
public function add() {
$data['modules'] = array('job/addjobexpenses');
$data['parties'] = $this->accounts->fetchAll();
$data['jobs'] = $this->jobs->fetchAllJobs('job_order');
$this->load->view('template/header');
$this->load->view('job/addjobexpenses',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$result = $this->costingexpenses->getMaxId('job_exp') +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function saveJobExpense() {
if (isset($_POST)) {
$ledgers = $_POST['ledgers'];
$costingExps = $_POST['costingExps'];
$dcno = $_POST['id'];
$result = $this->ledgers->save($ledgers,$dcno,'job_exp');
$result = $this->costingexpenses->saveJobExpense($costingExps,$dcno,'job_exp');
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
public function fetchJobExpense() {
if (isset( $_POST )) {
$dcno = $_POST['dcno'];
$result = $this->costingexpenses->fetchJobExpense($dcno,'job_exp');
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
public function deleteJobExpense() {
if (isset( $_POST )) {
$dcno = $_POST['dcno'];
$this->ledgers->deleteVoucher($dcno,'job_exp');
$result = $this->costingexpenses->deleteJobExpense($dcno,'job_exp');
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