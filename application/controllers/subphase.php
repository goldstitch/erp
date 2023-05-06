
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Subphase extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('phases');
$this->load->model('subphases');
}
public function index() {
redirect('subphase/add');
}
public function add() {
$data['modules'] = array('setup/addsubphase');
$data['phases'] = $this->phases->fetchAllPhase();
$data['subPhases'] = $this->subphases->fetchAllSubPhase();
$this->load->view('template/header');
$this->load->view('setup/addsubphase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxsubPhaseId() {
$result = $this->subphases->getMaxsubPhaseId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function savesubPhase() {
if (isset($_POST)) {
$subphase = $_POST['subphase'];
$result = $this->subphases->savesubPhase( $subphase );
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
public function fetchSubPhase() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->subphases->fetchSubPhase($id);
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
$result = $this->subphases->fetchAllPhase();
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