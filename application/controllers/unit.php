

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class unit extends CI_Controller {
public function __construct()
{
parent::__construct();
$this->load->model('units');
}
public function index() {
$data['modules'] = array('setup/addcompany');
$data['units'] = $this->units->fetchAll();
$this->load->view('template/header');
$this->load->view('setup/addcompany',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$result = $this->units->getMaxId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function save() {
if (isset($_POST)) {
$unit = $_POST['unit'];
$result = $this->units->save( $unit );
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
$company_id = $_POST['company_id'];
$result = $this->units->fetch($company_id);
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
$result = $this->units->delete($_POST['company_id']);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
}

?>