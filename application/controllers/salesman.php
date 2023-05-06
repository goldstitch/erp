

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class SalesMan extends CI_Controller {
public function __construct()
{
parent::__construct();
$this->load->model('salesmen');
}
public function index() {
$data['modules'] = array('setup/addsalesman');
$data['salesmen'] = $this->salesmen->fetchAll();
$this->load->view('template/header');
$this->load->view('setup/addsalesman',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$result = $this->salesmen->getMaxId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function save() {
if (isset($_POST)) {
$salesman = $_POST['salesman'];
$result = $this->salesmen->save( $salesman );
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
$officer_id = $_POST['officer_id'];
$result = $this->salesmen->fetch($officer_id);
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