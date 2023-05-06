
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Storetransfer extends CI_Controller {
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


public function job_material_issue() {
$data['modules'] = array('setup/job');
$data['title'] = 'Job_Material_Issued';
$this->load->view('template/header',$data);
$this->load->view('job_material_issue',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);    
}

public function job_material_received() {
$data['modules'] = array('setup/job');
$data['title'] = 'Job_Material_Received';
$this->load->view('template/header',$data);
$this->load->view('job_material_receive',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);    
}

public function index() {

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

public function fetch_issue_detail() {
  if (isset( $_POST )) {
  $vrnoa = $_POST['vrnoa'];
  $company_id = $_POST['company_id'];
  $result = $this->purchases->fetch_issue_detail($vrnoa,'issue',$company_id);
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

public function fetch_receive_detail() {
  if (isset( $_POST )) {
  $vrnoa = $_POST['vrnoa'];
  $company_id = $_POST['company_id'];
  $result = $this->purchases->fetch_receive_detail($vrnoa,'receive',$company_id);
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

public function fetch_consume() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->purchases->fetch_consume($vrnoa,'receive',$company_id);
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


public function delete_issue() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->purchases->delete($vrnoa,'issue',$company_id);
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


public function delete_receive() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->purchases->delete($vrnoa,'receive',$company_id);
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