
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Level extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('levels');
}
public function index() {
}
public function add() {
$data['modules'] = array('setup/level');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('setup/addlevel',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$maxIdL1 = $this->levels->getMaxId('l1','level1') +1;
$maxIdL2 = $this->levels->getMaxId('l2','level2') +1;
$maxIdL3 = $this->levels->getMaxId('l3','level3') +1;
$response = array();
$response['l1'] = $maxIdL1;
$response['l2'] = $maxIdL2;
$response['l3'] = $maxIdL3;
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
public function save() {
if (isset($_POST)) {
$levelDetail = $_POST['levelDetail'];
$level = $_POST['level'];
$table = '';
$col = '';
if ($level === 'level1') {
$table = 'level1';
$col ='l1';
}else if ($level === 'level2') {
$table = 'level2';
$col ='l2';
}else if ($level === 'level3') {
$table = 'level3';
$col ='l3';
}
$result = $this->levels->save($levelDetail,$table,$col);
$response = array();
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response['error'] = 'false';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchl1() {
if (isset($_POST)) {
$l1 = $_POST['l1'];
$result = $this->levels->fetchl1($l1);
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
public function fetchl2() {
if (isset($_POST)) {
$l2 = $_POST['l2'];
$result = $this->levels->fetchl2($l2);
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
public function fetchl3() {
if (isset($_POST)) {
$l3 = $_POST['l3'];
$result = $this->levels->fetchl3($l3);
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
public function updateNameCheck() {
if (isset($_POST)) {
$txtnameHidden = $_POST['txtnameHidden'];
$name = $_POST['name'];
$level = $_POST['level'];
$table = '';
if ($level === 'level1') {
$table = 'level1';
}else if ($level === 'level2') {
$table = 'level2';
}else if ($level === 'level3') {
$table = 'level3';
}
$result = $this->levels->updateNameCheck($txtnameHidden,$name,$table);
$response = array();
if ($result) {
$response['error'] = 'false';
}else {
$response['error'] = 'true';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function simpleNameCheck() {
if (isset($_POST)) {
$name = $_POST['name'];
$level = $_POST['level'];
$table = '';
if ($level === 'level1') {
$table = 'level1';
}else if ($level === 'level2') {
$table = 'level2';
}else if ($level === 'level3') {
$table = 'level3';
}
$result = $this->levels->simpleNameCheck($name,$table);
$response = array();
if ($result) {
$response['error'] = 'false';
}else {
$response['error'] = 'true';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
}

?>