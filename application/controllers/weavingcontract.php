

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Weavingcontract extends CI_Controller {
public function __construct()
{
parent::__construct();
$this->load->model('weavingcontracts');
}
public function index() {
unauth_secure();
$data['modules'] = array('setup/addWeavingContract');
$data['weavingcontracts'] = $this->weavingcontracts->fetchAll();
$data['title'] = 'Weaving Contract';
$this->load->view('template/header',$data);
$this->load->view('setup/addWeavingContract',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$result = $this->weavingcontracts->getMaxId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function searchAccount()
{
$search = $_POST['search'];
$type = $_POST['type'];;
$result = $this->products->searchAccounts($search,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function searchBrokers()
{
$search = $_POST['search'];
$type = $_POST['type'];;
$result = $this->products->searchBrokers($search,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function searchitem(){
$search = $_POST['search'];
$result = $this->products->searchitem($search);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function delete() {
if (isset( $_POST )) {
$contract_id = $_POST['contract_id'];
$result = $this->weavingcontracts->delete($contract_id);
$response = "";
if ( $result === true ) {
$response = 'true';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function save() {
if (isset($_POST)) {
$weaving_contract = $_POST['weaving_contract'];
$error = $this->weavingcontracts->isContractAlreadySaved($weaving_contract);
if (!$error) {
$weaving_contract = $_POST['weaving_contract'];
$result = $this->weavingcontracts->save( $weaving_contract );
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response['error'] = false;
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
$contract_id = $_POST['contract_id'];
$result = $this->weavingcontracts->fetch($contract_id);
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
public function fetchAll(){
$activee=(isset($_POST['active'])?$_POST['active']:-1);
$result = $this->weavingcontracts->fetchAll($activee);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}

?>