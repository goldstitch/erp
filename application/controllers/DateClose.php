

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class DateClose extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('DateCloses');
$this->load->model('users');
}
public function index() {
redirect('DateClose/add');
}
public function add() {
$data['modules'] = array('setup/addDateClose');
$data['DateCloses'] = $this->DateCloses->fetchAllDateClose();
$data['userone'] = $this->users->fetchAll();
$this->load->view('template/header');
$this->load->view('setup/addDateClose',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxDateCloseId() {
$result = $this->DateCloses->getMaxDateCloseId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function saveDateClose() {
if (isset($_POST)) {
$dateclose = $_POST['dateclose'];
$result = $this->DateCloses->saveDateClose( $dateclose );
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function OpenDateClose() {
if (isset($_POST)) {
$dateclose = $_POST['dateclose'];
$result = $this->DateCloses->openDateClose( $dateclose );
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchDateClose() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->DateCloses->fetchDateClose($id);
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
public function fetchAllDateClose() {
$result = $this->DateCloses->fetchAllDateClose();
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