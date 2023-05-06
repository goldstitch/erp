
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Phasetype extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('phasetypes');
}
public function index() {
redirect('phasetype/add');
}
public function add() {
$data['modules'] = array('setup/addphasetype');
$data['types'] = $this->phasetypes->fetchAllPhaseType();
$this->load->view('template/header');
$this->load->view('setup/addphasetype',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxPhaseTypeId() {
$result = $this->phasetypes->getMaxPhaseTypeId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function savePhaseType() {
if (isset($_POST)) {
$phasetype = $_POST['phasetype'];
$result = $this->phasetypes->savePhaseType( $phasetype );
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
public function fetchPhaseType() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->phasetypes->fetchPhaseType($id);
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
public function fetchAllPhaseType() {
$result = $this->phasetypes->fetchAllPhaseType();
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