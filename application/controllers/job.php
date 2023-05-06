

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Job extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('jobs');
}
public function index() {
redirect('job/add');
}
public function add() {
$data['modules'] = array('job/addjob');
$data['parties'] = $this->accounts->fetchAll();
$this->load->view('template/header');
$this->load->view('job/addjob',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxVrno() {
$result = $this->jobs->getMaxVrno('job_order') +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxVrnoa() {
$result = $this->jobs->getMaxVrnoa('job_order') +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function save() {
if (isset($_POST)) {
$job = $_POST['job'];
$result = $this->jobs->save( $job );
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
$vrnoa = $_POST['vrnoa'];
$result = $this->jobs->fetch($vrnoa,'job_order');
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