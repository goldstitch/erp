

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Currency extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('currenceys');
$this->load->model('users');
}
public function index() {
redirect('currency/add');
}
public function add() {
$data['modules'] = array('setup/addcurrencey');
$data['currenceys'] = $this->currenceys->fetchAllCurrencey();
$data['userone'] = $this->users->fetchAll();
$this->load->view('template/header');
$this->load->view('setup/addcurrencey',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxCurrenceyId() {
$result = $this->currenceys->getMaxCurrenceyId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function saveCurrencey() {
if (isset($_POST)) {
$color = $_POST['color'];
$result = $this->currenceys->saveCurrencey( $color );
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
public function fetchCurrencey() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->currenceys->fetchCurrencey($id);
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
public function fetchAllCurrencey() {
$result = $this->currenceys->fetchAllCurrencey();
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