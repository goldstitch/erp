
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Transporter extends CI_Controller {
public function __construct()
{
parent::__construct();
$this->load->model('transporters');
}
public function index() {
$data['modules'] = array('setup/addtransporter');
$data['transporters'] = $this->transporters->fetchAll();
$data['title'] = 'Add New Transporter';
$this->load->view('template/header',$data);
$this->load->view('setup/addtransporter',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$result = $this->transporters->getMaxId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function save() {
if (isset($_POST)) {
$transporter = $_POST['transporter'];
$error = $this->transporters->isTransporterAlreadySaved($transporter);
if (!$error) {
$result = $this->transporters->save( $transporter );
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function fetch() {
if (isset( $_POST )) {
$transporter_id = $_POST['transporter_id'];
$result = $this->transporters->fetch($transporter_id);
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
public function delete()
{
if (isset($_POST)) {
$result = $this->transporters->delete($_POST['transporter_id']);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
}

?>