
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Phase extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('phases');
$this->load->model('phasetypes');
}
public function index() {
redirect('phase/add');
}
public function add() {
$data['modules'] = array('setup/addphases');
$data['phases'] = $this->phases->fetchAllPhase();
$data['types'] = $this->phasetypes->fetchAllPhaseType();
$this->load->view('template/header');
$this->load->view('setup/addphase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxPhaseId() {
$result = $this->phases->getMaxPhaseId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function savePhase() {
if (isset($_POST)) {
$phase = $_POST['phase'];
$result = $this->phases->savePhase( $phase );
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
public function fetchPhase() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->phases->fetchPhase($id);
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
public function fetchAllPhase() {
$result = $this->phases->fetchAllPhase();
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