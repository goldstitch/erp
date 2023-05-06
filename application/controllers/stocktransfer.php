
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Stocktransfer extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('items');
$this->load->model('jobs');
$this->load->model('departments');
$this->load->model('purchases');
$this->load->model('users');
$this->load->model('orders');
}




public function material_issuance() {

$data['modules'] = array('inventory/material_issuance');
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['approvedby'] = $this->purchases->fetchByCol('approved_by');
$data['preparedby'] = $this->purchases->fetchByCol('prepared_by');
$data['departments'] = $this->departments->fetchAllDepartments();
$name = $this->session->userdata('uname'); 	
if($name=='admin')
{}
else{
$data['did']=$this->users->getdepart_id($name);}
$data['title'] = "Material Issuance Note";
$this->load->view('template/header',$data);
$this->load->view('material_issuance',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}


public function index() {
unauth_secure();
CheckVoucherRights('navigationvoucher');
$data['no'] =$this->users->unposttransfer();
$data['modules'] = array('inventory/addstocktransfer');
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['approvedby'] = $this->purchases->fetchByCol('approved_by');
$data['preparedby'] = $this->purchases->fetchByCol('prepared_by');
$data['departments'] = $this->departments->fetchAllDepartments();
$name = $this->session->userdata('uname'); 	
if($name=='admin')
{}
else{
$data['did']=$this->users->getdepart_id($name);}
$data['title'] = "Stock Transfer Voucher";
$this->load->view('template/header',$data);
$this->load->view('inventory/addstocktransfer',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}

public function storetransfer() {

$data['no'] =$this->users->unposttransfer();
$data['modules'] = array('inventory/storetransfer');
$data['receivers'] = $this->purchases->fetchByCol('received_by');
$data['approvedby'] = $this->purchases->fetchByCol('approved_by');
$data['preparedby'] = $this->purchases->fetchByCol('prepared_by');
$data['departments'] = $this->departments->fetchAllDepartments();
$name = $this->session->userdata('uname'); 	
if($name=='admin')
{}
else{
$data['did']=$this->users->getdepart_id($name);}
$data['title'] = "Stock Transfer Voucher";
$this->load->view('template/header',$data);
$this->load->view('inventory/storetransfer',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}

public function storereceive() {

    $data['no'] =$this->users->unposttransfer();
    $data['modules'] = array('inventory/storereceive');
    $data['receivers'] = $this->purchases->fetchByCol('received_by');
    $data['approvedby'] = $this->purchases->fetchByCol('approved_by');
    $data['preparedby'] = $this->purchases->fetchByCol('prepared_by');
    $data['departments'] = $this->departments->fetchAllDepartments();
    $name = $this->session->userdata('uname'); 	
    if($name=='admin')
    {}
    else{
    $data['did']=$this->users->getdepart_id($name);}
    $data['title'] = "Stock Receive Voucher";
    $this->load->view('template/header',$data);
    $this->load->view('inventory/storereceive',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
    }


public function getMaxVrno() {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrno('stocktransfer',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}

public function getMaxVrnoa() {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrnoa('stocktransfer',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}

public function getMaxVrno_issue() {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrno('issue',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxVrnoa_issue() {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrnoa('issue',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}

public function getMaxVrno_receive() {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrno('receive',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}

public function getMaxVrnoa_receive() {
$company_id = $_POST['company_id'];
$result = $this->purchases->getMaxVrnoa('receive',$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}

public function save() {
if (isset($_POST)) {
$stockmain = $_POST['stockmain'];
$stockdetail = $_POST['stockdetail'];
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->purchases->getMaxVrnoa('stocktransfer',$stockmain['company_id']) +1;
}
$result = $this->purchases->save($stockmain,$stockdetail,$vrnoa,'stocktransfer');
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

public function save_issue() {
if (isset($_POST)) {
$stockmain = $_POST['stockmain'];
$stockdetail = $_POST['stockdetail'];
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->purchases->getMaxVrnoa('issue',$stockmain['company_id']) +1;
}
$result = $this->purchases->save($stockmain,$stockdetail,$vrnoa,'issue');
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

public function save_receive() {
if (isset($_POST)) {
$stockmain = $_POST['stockmain'];
$stockdetail = $_POST['stockdetail'];
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->purchases->getMaxVrnoa('receive',$stockmain['company_id']) +1;
}
$result = $this->purchases->save($stockmain,$stockdetail,$vrnoa,'receive');
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
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->purchases->fetchNavigation($vrnoa,'stocktransfer',$company_id);
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

public function fetch_issue() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->purchases->fetchNavigation_issue($vrnoa,'issue',$company_id);
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

public function fetch_receive() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->purchases->fetchNavigation_receive($vrnoa,'receive',$company_id);
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
public function delete() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->purchases->delete($vrnoa,'stocktransfer',$company_id);
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

public function postchktransfer(){
if (isset($_POST)) {
    $vrnoa = $_POST['vrnoa'];
    $sum=$this->purchases->postchktransfer($vrnoa);
    $json = json_encode($sum);
    echo $json;
}
}
public function chkqty(){
    if (isset($_POST)) {
        $item_id = $_POST['item_id'];
        $deptfrom_id=$_POST['deptfrom_id'];
        $company_id = $_POST['company_id'];
        $etype = $_POST['etype'];
        $vrdate = $_POST['vrdate'];
        $sum=$this->orders->chkqty($item_id,$deptfrom_id,$etype,$company_id,$vrdate);
        $json = json_encode($sum);
        echo $json;
    }
}
public function setposttransfer(){
if (isset($_POST)) {
    $vrnoa = $_POST['vrnoa'];
    $sum=$this->users->setposttransfer($vrnoa);
    $json = json_encode($sum);
    echo $json;
}
}

public function receive(){
    if (isset($_POST)) {
        $vrnoa = $_POST['vrnoa'];
        $receive = $_POST['receive'];
        $qty = $_POST['qty'];
        $balance = $_POST['balance'];
        $sum=$this->purchases->receive($vrnoa,$receive,$qty,$balance);
        $json = json_encode($sum);
        echo $json;
    }
    }

public function postdata(){
    if (isset($_POST)) {
        $vrnoa = $_POST['vrnoa'];
        $sum=$this->users->postdata($vrnoa);
        $json = json_encode($sum);
        echo $json;
    }
    }


}

?>