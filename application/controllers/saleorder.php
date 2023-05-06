
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class saleorder extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('salesmen');
$this->load->model('transporters');
$this->load->model('currenceys');
$this->load->model('items');
$this->load->model('ledgers');
$this->load->model('purchases');
$this->load->model('departments');
$this->load->model('sales');
$this->load->model('orders');
$this->load->model('users');
$this->load->model('levels');
}
public function fetchChartData()
{
$period = $_POST['period'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$data = $this->orders->fetchChartData($period,$company_id,$etype);
$json = json_encode($data);
echo $json;
}


public function fetch_sale()
{
$id = $_POST['id'];
$data = $this->orders->fetch_sale($id);
$json = json_encode($data);
echo $json;
}


public function index() {
unauth_secure();
$data['modules'] = array('sale/addsaleorder');
$data['parties'] = $this->accounts->fetchAll();
$data['salesmen'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->orders->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['userone'] = $this->users->fetchAll();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['types'] = $this->items->fetchByCol('barcode');
$data['uoms'] = $this->items->fetchByCol('uom');
$data['shippmentFroms'] = $this->orders->fetchByCol('shippment_from');
$data['shippmentTos'] = $this->orders->fetchByCol('shippment_to');
$data['expregs'] = $this->orders->fetchByCol('export_register_no');
$data['DeliveryTerms'] = $this->orders->fetchDeliveryTerms();
$data['PaymentTerms'] = $this->orders->fetchPaymentTerms();
$data['tax_statuss'] = $this->orders->fetchByCol('tax_status');
$data['typess'] = $this->accounts->getDistinctFields('etype');
$data['salesmen'] = $this->salesmen->fetchAll();
$data['currenceys'] = $this->currenceys->fetchAllCurrencey();
$data['title'] = 'Sale Order Voucher';
$name = $this->session->userdata('uname'); 	
if($name=='admin')
{}
else{
$data['did']=$this->users->getdepart_id($name);}
$this->load->view('template/header',$data);
$this->load->view('sale/addsaleorder',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function Sale_Invoice() {
unauth_secure();
$data['modules'] = array('sale/addsaleorderInvoice');
$data['salesmen'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->orders->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = [];
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['orders_running'] = $this->orders->fetchOrders(date("Y/m/d"),date("Y/m/d"),'sale');
$data['typess'] = $this->accounts->getDistinctFields('etype');
$data['currenceys'] = $this->currenceys->fetchAllCurrencey();
$data['shippmentFroms'] = $this->orders->fetchByCol('shippment_from');
$data['shippmentTos'] = $this->orders->fetchByCol('shippment_to');
$data['expregs'] = $this->orders->fetchByCol('export_register_no');
$data['DeliveryTerms'] = $this->orders->fetchDeliveryTerms();
$data['PaymentTerms'] = $this->orders->fetchPaymentTerms();
$name = $this->session->userdata('uname'); 	
if($name=='admin')
{}
else{
$data['did']=$this->users->getdepart_id($name);}
$data['title'] = 'Sale Invoice';
$this->load->view('template/header',$data);
$this->load->view('sale/addsaleorderInovoice',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function Sale_Invoices() {
    unauth_secure();
    $data['modules'] = array('sale/addsaleorderInvoices');
    $data['salesmen'] = $this->salesmen->fetchAll();
    $data['receivers'] = $this->orders->fetchByCol('received_by');
    $data['transporters'] = $this->transporters->fetchAll();
    $data['departments'] = $this->departments->fetchAllDepartments();
    $data['items'] = [];
    $data['setting_configur'] = $this->accounts->getsetting_configur();
    $data['orders_running'] = $this->orders->fetchOrders(date("Y/m/d"),date("Y/m/d"),'sale');
    $data['typess'] = $this->accounts->getDistinctFields('etype');
    $data['currenceys'] = $this->currenceys->fetchAllCurrencey();
    $data['shippmentFroms'] = $this->orders->fetchByCol('shippment_from');
    $data['shippmentTos'] = $this->orders->fetchByCol('shippment_to');
    $data['expregs'] = $this->orders->fetchByCol('export_register_no');
    $data['DeliveryTerms'] = $this->orders->fetchDeliveryTerms();
    $data['PaymentTerms'] = $this->orders->fetchPaymentTerms();
    $name = $this->session->userdata('uname'); 	
    if($name=='admin')
{}
else{
$data['did']=$this->users->getdepart_id($name);}
    $data['title'] = 'Sale Invoice';
    $this->load->view('template/header',$data);
    $this->load->view('sale/addsaleorderInovoices',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
    }
public function partsdetail() {
unauth_secure();
$data['modules'] = array('sale/orderpartsdetail');
$data['parties'] = $this->accounts->fetchAll(1,'purchase');
$data['salesmen'] = $this->salesmen->fetchAll();
$data['receivers'] = $this->orders->fetchByCol('received_by');
$data['transporters'] = $this->transporters->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['types'] = $this->items->fetchByCol('barcode');
$data['orders_running'] = $this->orders->fetchOrders(date("Y/m/d"),date("Y/m/d"),'running');
$this->load->view('template/header');
$this->load->view('sale/orderpartsdetail',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchNetSum()
{
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$sum = $this->orders->fetchNetSum( $company_id ,$etype);
$json = json_encode($sum);
echo $json;
}
public function Loading_Stock()
{
$order_no = $_POST['order_no'];
$company_id = $_POST['company_id'];
$sum = $this->orders->Loading_Stock( $company_id ,$order_no);
$json = json_encode($sum);
echo $json;
}
public function getMaxVrno() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
if( isset($_POST['etype2']) ){
$etype2 = $_POST['etype2'];
$result = $this->orders->getMaxVrnoEtype2($etype ,$company_id,$etype2) +1;
}else{
$etype2 = '';
$result = $this->orders->getMaxVrno($etype ,$company_id) +1;
}
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function getMaxVrnoa() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->orders->getMaxVrnoa($etype ,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}

public function getmaxidMR() {
if (isset($_POST)) {
$result = $this->orders->getMaxVrnoaMR() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}


public function getmaxid() {
    if (isset($_POST)) {
    $result = $this->orders->getmaxid()+1;
    $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

public function getmaxidjob() {
    if (isset($_POST)) {
    $result = $this->orders->getmaxidjob()+1;
    $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

public function getmaxidsample_card() {
    if (isset($_POST)) {
    $result = $this->orders->getmaxidsample_card()+1;
    $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

public function getid() {
    if (isset($_POST)) {
    $result = $this->orders->getid()+1;
    $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

public function getmaxids() {
    if (isset($_POST)) {
    $result = $this->orders->getmaxids()+1;
    $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

public function getmax_id() {
    if (isset($_POST)) {
    $result = $this->orders->getmax_id()+1;
    $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

public function getmaxid_() {
    if (isset($_POST)) {
    $result = $this->orders->getmaxid_()+1;
    $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}



public function Validate_Order() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$order_no = $_POST['order_no'];
$status = $_POST['status'];
$result = $this->orders->Validate_Order($etype ,$company_id,$order_no,$status );
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function Validate_Order_Loading() {
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$order_no = $_POST['order_no'];
$status = $_POST['status'];
$result = $this->orders->Validate_Order_Loading($etype ,$company_id,$order_no,$status );
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$ordermain = $_POST['ordermain'];
$orderdetail = json_decode($_POST['orderdetail'],true);
$vrnoa = $_POST['vrnoa'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
$etype = $_POST['etype'];
if ($voucher_type_hidden=='new'){
$vrnoa = $this->orders->getMaxVrnoa($etype,$ordermain['company_id']) +1;
}
if(isset($_POST['ledger'])){
$ledger = json_decode($_POST['ledger'],true);
$result = $this->ledgers->save($ledger,$vrnoa,$etype ,$voucher_type_hidden);
}
$result = $this->orders->save($ordermain,$orderdetail,$vrnoa,$etype);
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

public function save_sample_production() {
    
    if (isset($_POST)) {
    $production_ = $_POST['production'];
    $embroidory_ = $_POST['embroidory'];
    $cut_stitch_ = $_POST['cutstitch'];
    $fabric_dye_ = $_POST['fabricdye'];
    $stitch_accesseries_ = $_POST['stitchaccesseries'];
    $embelishment_ = $_POST['embelishment'];
    $press_pack_ = $_POST['presspack'];
    $summary_ = $_POST['summary'];
    $material_ = $_POST['material'];
    $digital_ = $_POST['digital'];
    }

    $result = $this->orders->save_sample_production($production_,$embroidory_,$fabric_dye_,$cut_stitch_,$stitch_accesseries_,$embelishment_,$press_pack_,$summary_,$material_,$digital_);
    $json = json_encode($result);
    echo $json;
}


public function save_job() {
    
    if (isset($_POST)) {
    $job = $_POST['job'];
    $result = $this->orders->save_job($job);
    $json = json_encode($result);
    echo $json;
}
}

public function save_req_material() {
    
    if (isset($_POST)) {
    $require_material = $_POST['require_material'];
    $result = $this->orders->save_req_material($require_material);
    $json = json_encode($result);
    echo $json;
}
}

public function save_sample_card() {
    
    if (isset($_POST)) {
    $sample_card = $_POST['sample_card'];
    $sample_card_detail = $_POST['sample_card_detail'];
    $result = $this->orders->save_sample_card($sample_card,$sample_card_detail);
    $json = json_encode($result);
    echo $json;
}
}

public function job_report($todate,$fromdate)
{
    $data['item']=$this->orders->fetch_detail($todate,$fromdate);
    $this->load->view('reports/job_report.php',$data);
}


public function save_approve_production() {
    if (isset($_POST)) {
    $production_ = $_POST['production'];
    $embroidory_ = $_POST['embroidory'];
    $cut_stitch_ = $_POST['cutstitch'];
    $fabric_dye_ = $_POST['fabricdye'];
    $stitch_accesseries_ = $_POST['stitchaccesseries'];
    $embelishment_ = $_POST['embelishment'];
    $press_pack_ = $_POST['presspack'];
    $summary_ = $_POST['summary'];
    $material_ = $_POST['material'];
    }

    $result = $this->orders->save_approve_production($production_,$embroidory_,$fabric_dye_,$cut_stitch_,$stitch_accesseries_,$embelishment_,$press_pack_,$summary_,$material_);
    $json = json_encode($result);
    echo $json;
}

public function save_production_calculation() {
    if (isset($_POST)) {
    $production_ = $_POST['production_calculation'];
    }
    $result = $this->orders->save_production_calculation($production_);
    $json = json_encode($result);
    echo $json;
}


public function fetch_detail()
{
    if (isset($_POST)) {
        $todate = $_POST['todate'];
        $fromdate = $_POST['fromdate'];
        $sum=$this->orders->fetch_detail($todate,$fromdate);
        $json = json_encode($sum);
        echo $json;
    }
}



public function fetch_req_material()
{
    if (isset($_POST)) {
        $id = $_POST['id'];
        $sum=$this->orders->fetch_req_material($id);
        $json = json_encode($sum);
        echo $json;
    }
}

public function delete_req_material()
{
    if (isset($_POST)) {
        $id = $_POST['id'];
        $sum=$this->orders->delete_req_material($id);
        $json = json_encode($sum);
        echo $json;
    }
}



public function fetch_samplecard()
{
    if (isset($_POST)) {
        $todate = $_POST['todate'];
        $fromdate = $_POST['fromdate'];
        $sum=$this->orders->fetch_samplecard($todate,$fromdate);
        $json = json_encode($sum);
        echo $json;
    }
}



public function save_material_demand() {
    if (isset($_POST)) {
    $material_demand = $_POST['material_demand'];
    }
    $result = $this->orders->save_material_demand($material_demand);
    $json = json_encode($result);
    echo $json;
}

public function save_final_productions() {
    if (isset($_POST)) {
    $production_ = $_POST['productions'];
    }
    $result = $this->orders->save_final_productions($production_);
    $json = json_encode($result);
    echo $json;
}



public function fetch_cut() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_cut($id,$code);
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

public function fetch_digital() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_digital($id,$code);
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

public function fetch_pack_material() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $type = $_POST['type'];
    $result = $this->orders->fetch_pack_material($id,$code,$type);
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

public function fetch_embell_material() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $type = $_POST['type'];
    $result = $this->orders->fetch_embell_material($id,$code,$type);
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


    public function fetch_digital_() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_digital_($id,$code);
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

public function fetch_pack_material_() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $type = $_POST['type'];
    $result = $this->orders->fetch_pack_material_($id,$code,$type);
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

public function fetch_embell_material_() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $type = $_POST['type'];
    $result = $this->orders->fetch_embell_material_($id,$code,$type);
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

    public function final_production() {
    if (isset( $_POST )) {
    $code = $_POST['code'];
    $result = $this->orders->final_production($code);
    $response = "";
    if ( $result === false ) {
    $response = 'false';
    }else {
    $response = $result;
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    }

    public function final_production_detail() {
    if (isset( $_POST )) {
    $code = $_POST['code'];
    $result = $this->orders->final_production_detail($code);
    $response = "";
    if ( $result === false ) {
    $response = 'false';
    }else {
    $response = $result;
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    }

    

    public function fetch_press() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_press($id,$code);
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


    public function fetch_approve_cut() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_approve_cut($id,$code);
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

    public function productions_detail() {
    if (isset( $_POST )) {
    $code = $_POST['code'];
    $result = $this->orders->productions_detail($code);
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

    public function sample() {
    if (isset( $_POST )) {
    $code = $_POST['code'];
    $result = $this->orders->sample($code);
    $response = "";
    if ( $result === false ) {
    $response = 'false';
    }else {
    $response = $result;
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    }

    public function fetch_approve_press() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_approve_press($id,$code);
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

    public function fetch_dept() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->users->getdepart_id($id);
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

    public function fetch_approve_cut_() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_approve_cut_($id,$code);
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

    public function fetch_approve_press_() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_approve_press_($id,$code);
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

    public function fetch_approve_production() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_approve_production($id,$code);
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

    public function fetch_approve_production_() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_approve_production_($id,$code);
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


    public function fetch_sample_production() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_sample_production($id,$code);
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

    public function fetch_job() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->fetch_job($id);
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

public function fetch_sample_card() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->fetch_sample_card($id);
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

public function fetch_sample_card_detail() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->fetch_sample_card_detail($id);
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

public function fetch_sample_material() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->fetch_sample_material($id);
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

public function sample_issue_material() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->sample_issue_material($id);
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

public function fetchjob() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->fetchjob($id);
    $json = json_encode($result);
    echo $json;
    }
    }
    
    public function material() {
        if (isset( $_POST )) {
        $code = $_POST['code'];
        $result = $this->orders->material($code);
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

        public function production_calculation() {
        if (isset( $_POST )) {
        $code = $_POST['code'];
        $result = $this->orders->production_calculation($code);
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

        public function production_calculation_detail() {
        if (isset( $_POST )) {
        $code = $_POST['code'];
        $result = $this->orders->production_calculation_detail($code);
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


    public function fetch_stitch() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $result = $this->orders->fetch_stitch($id,$code);
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

    public function fetch_embl() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $result = $this->orders->fetch_embl($id,$code);
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

    
    public function fetch_emb() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $result = $this->orders->fetch_emb($id,$code);
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


    public function fetch_fab() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_fab($id,$code);
    $response = "";
    if ( $result === false ) {
    $response = 'false';
    }else {
    $response = $result;
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    }



    public function fetch_approve_stitch() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $result = $this->orders->fetch_approve_stitch($id,$code);
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

    public function fetch_approve_embl() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $result = $this->orders->fetch_approve_embl($id,$code);
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

    
    public function fetch_approve_emb() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $result = $this->orders->fetch_approve_emb($id,$code);
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


    public function fetch_approve_fab() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_approve_fab($id,$code);
    $response = "";
    if ( $result === false ) {
    $response = 'false';
    }else {
    $response = $result;
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    }



    public function fetch_approve_stitch_() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $result = $this->orders->fetch_approve_stitch_($id,$code);
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

    public function fetch_approve_embl_() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $result = $this->orders->fetch_approve_embl_($id,$code);
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

    
    public function fetch_approve_emb_() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $result = $this->orders->fetch_approve_emb_($id,$code);
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


    public function fetch_approve_fab_() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->fetch_approve_fab_($id,$code);
    $response = "";
    if ( $result === false ) {
    $response = 'false';
    }else {
    $response = $result;
    }
    $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    }



public function fetch() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
if( isset($_POST['etype2']) ){
$etype2 = $_POST['etype2'];
$result = $this->orders->fetch($vrnoa,$etype,$company_id,$etype2);
}else{
$etype2 = '';
$result = $this->orders->getMaxVrno($etype ,$company_id) +1;
$result = $this->orders->fetch($vrnoa,$etype,$company_id);
}
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

public function fetch_() {
    if (isset( $_POST )) {
    $vrnoa = $_POST['vrnoa'];
    $company_id = $_POST['company_id'];
    $etype = $_POST['etype'];
    if( isset($_POST['etype2']) ){
    $etype2 = $_POST['etype2'];
    $result = $this->orders->fetch_($vrnoa,$etype,$company_id,$etype2);
    }else{
    $etype2 = '';
    $result = $this->orders->getMaxVrno($etype ,$company_id) +1;
    $result = $this->orders->fetch_($vrnoa,$etype,$company_id);
    }
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
public function fetch_vrno() {
if (isset( $_POST )) {
$vrno = $_POST['vrno'];
$company_id = $_POST['company_id'];
$etype2 = $_POST['etype2'];
$etype = $_POST['etype'];
$result = $this->orders->fetch_vrno($vrno,$etype,$company_id,$etype2);
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
public function fetchLfiveStocks() {
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$vrdate = $_POST['vrdate'];
$result = $this->orders->fetchItemStocks($item_id,$etype,$company_id,$vrdate);
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

public function fetchStoreStocks() {
    if (isset( $_POST )) {
    $item_id = $_POST['item_id'];
    $company_id = $_POST['company_id'];
    $etype = $_POST['etype'];
    $vrdate = $_POST['vrdate'];
    $result = $this->orders->fetchStoreStocks($item_id,$etype,$company_id,$vrdate);
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

public function fetch_Stocks() {
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$result = $this->orders->fetch_Stocks($item_id,'sale',1);
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

public function fetchItemStocks_vendor() {
if (isset( $_POST )) {
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$crit = $_POST['crit'];
$vrdate = $_POST['vrdate'];
$result = $this->orders->fetchItemStocks_vendor($crit,$etype,$company_id,$vrdate);
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
public function fetchLfiveRates() {
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$crit = $_POST['crit'];
$result = $this->orders->last_5_srate($item_id,$etype,$company_id,$crit);
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
public function fetchTypeParty() {
if (isset( $_POST )) {
$etype = $_POST['type'];
$company_id = $_POST['company_id'];
$result = $this->accounts->fetchTypeParty($etype);
$response = "";
if ( $result === false ||$result === null ) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function last_5_srate() {
if (isset( $_POST )) {
$party_id = $_POST['party_id'];
$company_id = $_POST['company_id'];
$item_id = $_POST['item_id'];
$result = $this->orders->last_5_srate($party_id,$item_id,$company_id);
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
public function fetch_order_stock() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result = $this->orders->fetch_order_stock($vrnoa,$etype,$company_id);
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
public function fetchPartsOrder() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result_vrnoa = $this->orders->fetch($vrnoa,$etype,$company_id);
$result_parts = $this->orders->fetchPartsOrder($vrnoa,$etype,$company_id,'parts');
$result2_spare = $this->orders->fetchPartsOrder($vrnoa,$etype,$company_id,'spare_parts');
$result3_less= $this->orders->fetchPartsOrder($vrnoa,$etype,$company_id,'less');
if ( $result_vrnoa === false ) {
$response['vrnoa'] = 'false';
}else {
$response['vrnoa'] = $result_vrnoa;
}
if ( $result_parts === false ) {
$response['parts'] = 'false';
}else {
$response['parts'] = $result_parts;
}
if ( $result2_spare === false ) {
$response['spare'] = 'false';
}else {
$response['spare'] = $result2_spare;
}
if ( $result3_less === false ) {
$response['less'] = 'false';
}else {
$response['less'] = $result3_less;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch_loading_Stock() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$result_vrnoa = $this->orders->fetch($vrnoa,$etype,$company_id);
$result_parts = $this->orders->fetch_loading_Stock($vrnoa,$company_id);
if ( $result_vrnoa === false ) {
$response['vrnoa'] = 'false';
}else {
$response['vrnoa'] = $result_vrnoa;
}
if ( $result_parts === false ) {
$response['parts'] = 'false';
}else {
$response['parts'] = $result_parts;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchOrderReportData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$sreportData = $this->orders->fetchOrderReportData($startDate,$endDate,$what,$type,$company_id,$etype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function delete() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->orders->delete($vrnoa,$etype,$company_id);
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

public function delete_approve_production() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->delete_approve_production($id,$code);
    $json = json_encode($result);
    echo $json;
    }
    }

public function delete_sample_production() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $result = $this->orders->delete_sample_production($id,$code);
    $json = json_encode($result);
    echo $json;
    }
    }

public function delete_job() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->delete_job($id);
    $json = json_encode($result);
    echo $json;
    }
    }

public function delete_sample_card() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->delete_sample_card($id);
    $json = json_encode($result);
    echo $json;
    }
    }

    public function update() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $receive = $_POST['receive'];
    $balance = $_POST['balance'];
    $status = $_POST['status'];
    $date = $_POST['date'];
    $result = $this->orders->update_job($id,$receive,$balance,$status,$date);
    $json = json_encode($result);
    echo $json;
    }
    }


    public function delete_production_calculation() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->delete_production_calculation($id);
    $json = json_encode($result);
    echo $json;
    }
    }

    public function delete_material_demand() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->delete_material_demand($id);
    $json = json_encode($result);
    echo $json;
    }
    }

    public function fetch_material_demand() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->fetch_material_demand($id);
    $json = json_encode($result);
    echo $json;
    }
    }

    public function delete_final_production() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->orders->delete_final_production($id);
    $json = json_encode($result);
    echo $json;
    }
    }




public function fetchPurchaseReportData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$sreportData = $this->orders->fetchPurchaseReportData($startDate,$endDate,$what,$type,$company_id,$etype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchImportRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->orders->fetchImportRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}
public function fetchRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->orders->fetchRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}

public function fetchdiscount()
{
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$date = $_POST['date'];
$godown_id = $_POST['godown_id'];
$sum = $this->orders->fetchdiscount($item_id,$date,$godown_id);
$json = json_encode($sum);
echo $json;
}
}
public function fetchsaleorder() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->orders->fetch($vrnoa,'sale_order',$company_id);
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

public function chkexchange() {
    if (isset( $_POST )) {
        $vrnoa = $_POST['vrnoa'];
        $sum = $this->orders->chkexchange($vrnoa);
        $json = json_encode($sum);
        echo $json;
    }
}

}
?>