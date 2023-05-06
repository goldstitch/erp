

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Color extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('colors');
}
public function index() {
redirect('color/add');
}
public function add() {
$data['modules'] = array('setup/addcolor');
$data['colors'] = $this->colors->fetchAllColors();
$this->load->view('template/header');
$this->load->view('setup/addcolor',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxColorId() {
$result = $this->colors->getMaxColorId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function saveColor() {
if (isset($_POST)) {
$color = $_POST['color'];
$result = $this->colors->saveColor( $color );
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
public function fetchColor() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->colors->fetchColor($id);
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
public function fetchAllcolors() {
$result = $this->colors->fetchAllColors();
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
public function fetchAllcolorsOrderWise() {
$vrnoa = $_POST['vrnoa'];
$result = $this->colors->fetchAllcolorsOrderWise($vrnoa);
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