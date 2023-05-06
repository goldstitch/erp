

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


class Setting_configuration extends CI_Controller
{
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('setting_configurations');
$this->load->model('levels');
}
public function index(){
$data['modules'] = array( 'setup/addSettingCongiguration');
$data['party']   = $this->accounts->fetchAll();
$data['level3'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('setup/addsettingConfiguration',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function save() {
if (isset($_POST)) {
$obj = $_POST['obj'];
$result = $this->setting_configurations->save($obj);
$response = array();
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch() {
if (isset( $_POST )) {
$result = $this->setting_configurations->fetch();
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