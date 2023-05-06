
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('datecloses');
$this->load->model('accounts');
$this->load->model('ledgers');
$this->load->model('payments');
$this->load->model('departments');
$this->load->model('users');
$this->load->model('levels');
$this->load->model('items');
}

public function index() {
unauth_secure();
$data['no_1'] =$this->users->count_unpost();
$data['modules'] = array('accounts/payment');
$data['accountCashs'] = $this->accounts->fetchAll_CashAccount();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['title'] = 'Cash Voucher';
$this->load->view('template/header',$data);
$this->load->view('accounts/cashpayment',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}

public function cutting() {
    $data['modules'] = array('cutting');
    $data['title'] = 'Cutting';
    $data['departments'] = $this->accounts->cuttings();
    $this->load->view('template/header',$data);
    $this->load->view('cutting',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}

public function packing() {
    $data['modules'] = array('packing');
    $data['title'] = 'packing';
    $data['departments'] = $this->accounts->packings();
    $this->load->view('template/header',$data);
    $this->load->view('packing',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}

public function employee() {
    $data['modules'] = array('employee');
    $data['title'] = 'Employee';
    $data['departments'] = $this->accounts->employee();
	$data['departmentss'] = $this->departments->fetchAllDepartments();
    $this->load->view('template/header',$data);
    $this->load->view('employee',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}

public function accessories() {
    $data['modules'] = array('accessories');
    $data['title'] = 'accessories';
    $data['departments'] = $this->accounts->accessories();
    $this->load->view('template/header',$data);
    $this->load->view('accessories',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}

public function document() {
    $data['modules'] = array('document');
    $data['title'] = 'Document Receipt Form';
    $data['departments'] = $this->accounts->document();
    $this->load->view('template/header',$data);
    $this->load->view('document',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}

public function return_document() {
    $data['modules'] = array('document');
    $data['title'] = 'Return Document Receipt Form';
    $data['departments'] = $this->accounts->document();
    $this->load->view('template/header',$data);
    $this->load->view('return_document',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}


public function adda_work() {
    $data['modules'] = array('adda_work');
    $data['title'] = 'Adda_work Material';
    $data['departments'] = $this->accounts->adda_work();
    $this->load->view('template/header',$data);
    $this->load->view('adda_work',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}

public function stone_work() {
    $data['modules'] = array('stone_work');
    $data['title'] = 'Stone_work Material';
    $data['departments'] = $this->accounts->stone_work();
    $this->load->view('template/header',$data);
    $this->load->view('stone_work',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}

public function article() {
    $data['modules'] = array('article');
    $data['title'] = 'article';
    $data['departments'] = $this->accounts->articles();
    $this->load->view('template/header',$data);
    $this->load->view('article',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}

public function color() {
    $data['modules'] = array('color');
    $data['title'] = 'color';
     $data['departments'] = $this->accounts->colors();
    $this->load->view('template/header',$data);
    $this->load->view('color',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}

public function category() {
    $data['modules'] = array('category');
    $data['title'] = 'category';
    $data['departments'] = $this->accounts->categorys();
    $this->load->view('template/header',$data);
    $this->load->view('category',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);
}


public function dyeing() {
    $data['modules'] = array('dyeing');
    $data['title'] = 'Dyeing';
    $data['departments'] = $this->accounts->dyeings();
    $this->load->view('template/header',$data);
    $this->load->view('dyeing',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function thread() {
    $data['modules'] = array('thread');
    $data['title'] = 'Thread';
    $data['departments'] = $this->accounts->threads();
    $this->load->view('template/header',$data);
    $this->load->view('thread',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function Embroidry() {
    $data['modules'] = array('embroidry');
    $data['title'] = 'Embroidry';
    $data['departments'] = $this->accounts->embroidrys();
    $this->load->view('template/header',$data);
    $this->load->view('embroidry',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}


public function fabric() {
    $data['modules'] = array('fabric');
    $data['title'] = 'fabric';
    $data['departments'] = $this->accounts->fabrics();
    $this->load->view('template/header',$data);
    $this->load->view('fabric',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function embellishment() {
    $data['modules'] = array('embellishment');
    $data['title'] = 'Embellishment';
    $data['departments'] = $this->accounts->embellishments();
    $this->load->view('template/header',$data);
    $this->load->view('embellishment',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}


public function job() {
    $data['modules'] = array('setup/job');
    $data['title'] = 'Job Card';
    $this->load->view('template/header',$data);
    $this->load->view('job',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function sample_card() {
    $data['modules'] = array('setup/sample_card');
    $data['title'] = 'Sample_Card';
    $this->load->view('template/header',$data);
    $this->load->view('sample_card',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}


public function job_finish() {
    $data['modules'] = array('setup/job');
    $data['title'] = 'Job Card';
    $this->load->view('template/header',$data);
    $this->load->view('job_finish',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function job_report() {
    $data['modules'] = array('setup/job');
    $data['title'] = 'Job Card';
    $this->load->view('template/header',$data);
    $this->load->view('job_report',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}


public function material_require() {
    $data['modules'] = array('setup/materialrequire');
    $data['title'] = 'Material Required';
    $this->load->view('template/header',$data);
    $this->load->view('material_required_report',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}


public function card_report() {
    $data['modules'] = array('setup/sample_card');
    $data['title'] = 'card_report';
    $this->load->view('template/header',$data);
    $this->load->view('card_report',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function sample_production() {
    
    $data['modules'] = array('setup/sample_production');
    $data['title'] = 'sample_production';
    $data['threads'] = $this->accounts->threads();
    $data['cuts'] = $this->accounts->cuttings();
    $data['accessories'] = $this->accounts->accessories();
    $data['material'] = $this->accounts->accessories();
    $data['dyes'] = $this->accounts->dyeings();
    $data['embells'] = $this->accounts->embellishments();
    $data['embs'] = $this->accounts->embroidrys();
    $data['emb_name'] = $this->accounts->emb_name();
    $data['dye_name'] = $this->accounts->dye_name();
    $data['dyer_name'] = $this->accounts->dye_name();
    $data['pack_name'] = $this->accounts->pack_name();
    $data['packing'] = $this->accounts->packings();
    $data['adda'] = $this->accounts->adda_name();
    $data['stone'] = $this->accounts->stone_name();
    $data['cut_detail'] = $this->accounts->cut_detail();
    $data['cut_name'] = $this->accounts->cut_name();
    $data['embell_name'] = $this->accounts->embell_name();
    $data['dig_name'] = $this->accounts->dig_name();
    $data['arts'] = $this->accounts->articles();
    $data['items'] = $this->accounts->colors();
    $data['cats'] = $this->accounts->categorys();
    $data['fabrics'] = $this->accounts->fabrics();
    $this->load->view('template/header',$data);
    $this->load->view('sample_production',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function approve_production() {
    
    $data['modules'] = array('setup/approve_production');
    $data['title'] = 'approve_production';
    $data['threads'] = $this->accounts->threads();
    $data['cuts'] = $this->accounts->cuttings();
    $data['accessories'] = $this->accounts->accessories();
    $data['material'] = $this->accounts->accessories();
    $data['dyes'] = $this->accounts->dyeings();
    $data['embells'] = $this->accounts->embellishments();
    $data['embs'] = $this->accounts->embroidrys();
    $data['emb_name'] = $this->accounts->emb_name();
    $data['dye_name'] = $this->accounts->dye_name();
    $data['dyer_name'] = $this->accounts->dye_name();
    $data['pack_name'] = $this->accounts->pack_name();
    $data['packing'] = $this->accounts->packings();
    $data['adda'] = $this->accounts->adda_name();
    $data['stone'] = $this->accounts->stone_name();
    $data['cut_detail'] = $this->accounts->cut_detail();
    $data['cut_name'] = $this->accounts->cut_name();
    $data['embell_name'] = $this->accounts->embell_name();
    $data['dig_name'] = $this->accounts->dig_name();
    $data['arts'] = $this->accounts->articles();
    $data['items'] = $this->accounts->colors();
    $data['cats'] = $this->accounts->categorys();
    $data['fabrics'] = $this->accounts->fabrics();
    $this->load->view('template/header',$data);
    $this->load->view('approve_production',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function production_calculate() {
    
    $data['modules'] = array('setup/production_calculate');
    $data['title'] = 'Production';
    $data['arts'] = $this->accounts->articles();
    $data['items'] = $this->accounts->colors();
    $data['cats'] = $this->accounts->categorys();
    $this->load->view('template/header',$data);
    $this->load->view('production_calculate',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}


public function final_production() {
    
    $data['modules'] = array('setup/final_production');
    $data['title'] = 'Production';
    $data['arts'] = $this->accounts->articles();
    $data['items'] = $this->accounts->colors();
    $data['cats'] = $this->accounts->categorys();
    $this->load->view('template/header',$data);
    $this->load->view('final_production',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function material_demand() {
    
    $data['modules'] = array('setup/material_demand');
    $data['title'] = 'Material_demand';
    $this->load->view('template/header',$data);
    $this->load->view('material_demand',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}

public function material_issuance() {
    
    $data['modules'] = array('setup/material_issuance');
    $data['title'] = 'Material_issuance';
    $this->load->view('template/header',$data);
    $this->load->view('material_issuance',$data);
    $this->load->view('template/mainnav');
    $this->load->view('template/footer',$data);    
}


public function fetchCashandBank()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->payments->fetchCashandBank( $from,$to );
$json = json_encode($sum);
echo $json;
}
public function advance() {
$data['modules'] = array('accounts/advance');
$data['accounts'] = $this->accounts->fetchAll();
$data['accountCashs'] = $this->accounts->fetchAll_CashAccount();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['title'] = 'Employee Advance Voucher';
$this->load->view('template/header',$data);
$this->load->view('accounts/advance',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function incentive() {
$data['modules'] = array('accounts/incentive');
$data['accounts'] = $this->accounts->fetchAll();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['title'] = 'Employee Incentive Voucher';
$this->load->view('template/header',$data);
$this->load->view('accounts/incentive',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
if (isset($_POST)) {
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$maxId = $this->ledgers->getMaxId($etype,$company_id) +1;
$this->output->set_content_type('application/json')->set_output(json_encode($maxId));
}
}
public function save() {
if (isset($_POST)) {
$saveObj = $_POST['saveObj'];
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
$response = array();
$response['error']='';
$chk_date =$_POST['chk_date'];
$vrdate = "2016-01-01";
$vrdate = $saveObj[0]['date'];
$DateCloseStatus=false;
if($chk_date!=$vrdate &&$voucher_type_hidden=='edit'){
$DateCloseStatus = $this->datecloses->CheckDateClose($chk_date);
}
if($DateCloseStatus==true){
$response['error'] = 'date close';
}
$DateCloseStatus = $this->datecloses->CheckDateClose($vrdate);
if($DateCloseStatus==true){
$response['error'] = 'date close';
}
if($response['error']!=='date close'){
if ($voucher_type_hidden == 'new'){
$dcno = $this->ledgers->getMaxId($etype,$saveObj[0]["company_id"]) +1;
$saveObj[0]["dcno"] = $dcno;
}
$result = $this->ledgers->save($saveObj,$dcno,$etype,$voucher_type_hidden);
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response['error'] = 'false';
}
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch() {
if (isset($_POST)) {
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->ledgers->fetch($dcno,$etype,$company_id);
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
public function deleteVoucher() {
if (isset($_POST)) {
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->ledgers->deleteVoucher($dcno,$etype,$company_id);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = 'true';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchVoucherRange() {
if (isset($_POST)) {
$etype = $_POST['etype'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->ledgers->fetchVoucherRange($from,$to,$etype,1);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchAdvanceReport() {
if (isset($_POST)) {
$pid = $_POST['pid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->payments->fetchAdvanceReport($from,$to,$did,$pid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchIncentiveReport() {
if (isset($_POST)) {
$pid = $_POST['pid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->payments->fetchIncentiveReport($from,$to,$pid,$did);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchEobiReport() {
if (isset($_POST)) {
$staid = $_POST['staid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->payments->fetchEobiReport($from,$to,$did,$staid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchSocialSecReport() {
if (isset($_POST)) {
$pid = $_POST['pid'];
$did = $_POST['did'];
$from = $_POST['from'];
$to = $_POST['to'];
$result = $this->payments->fetchSocialSecReport($from,$to,$did,$pid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function chequeIssue()
{
unauth_secure();
$data['modules'] = array('accounts/chequevoucher');
$data['banks'] = $this->accounts->fetchBanks();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['title'] = 'Cheque Issue';
$this->load->view('template/header',$data);
$this->load->view('accounts/issue_cheque_voucher',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function chequeReceive()
{
unauth_secure();
$data['modules'] = array('accounts/rcvchequevoucher');
$data['banks'] = $this->accounts->fetchBanks();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['setting_configur'] = $this->accounts->getsetting_configur();
$data['title'] = 'Cheque Receive';
$this->load->view('template/header',$data);
$this->load->view('accounts/receive_cheque_voucher',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchNetChequeSum()
{
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$pd_cheque_arr = $this->accounts->fetchNetChequeSum( $etype,$company_id );
$json = json_encode( $pd_cheque_arr );
echo $json;
}
public function fetchChartData()
{
$period = $_POST['period'];
$type = $_POST['etype'];
$company_id = $_POST['company_id'];
$data = $this->payments->fetchChartData($period,$type,$company_id);
$json = json_encode($data);
echo $json;
}
public function fetchTopTenCheques()
{
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$date = strtotime("+10 day");
$dateAfterTenDays = date('Y-m-d',$date);
$cheques = $this->accounts->fetchCheques($etype,$dateAfterTenDays,$company_id);
$json = json_encode($cheques);
echo $json;
}
public function saveUnpostPdCheque()
{
if (isset($_POST)) {
$this->ledgers->deleteVoucher($_POST['dcno'],$_POST['etype'],$_POST['company_id']);
$result = $this->accounts->saveCheque($_POST);
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
public function savePostPdCheque()
{
$response = array();
$response['error']='';
$chk_date =$_POST['chk_date'];
$vrdate = "2016-01-01";
$vrdate = $_POST['pd_cheque']['mature_date'];
$voucher_type_hidden = $_POST['voucher_type_hidden'];
$DateCloseStatus=false;
if($chk_date!=$vrdate &&$voucher_type_hidden=='edit'){
$DateCloseStatus = $this->datecloses->CheckDateClose($chk_date);
}
if($DateCloseStatus==true){
$response['error'] = 'date close';
}
$DateCloseStatus = $this->datecloses->CheckDateClose($vrdate);
if($DateCloseStatus==true){
$response['error'] = 'date close';
}
if($response['error']!=='date close'){
$this->ledgers->deleteVoucher($_POST['pd_cheque']['dcno'],$_POST['pd_cheque']['etype'],$_POST['pd_cheque']['company_id']);
$effected = $this->ledgers->save($_POST['pledger'],$_POST['pd_cheque']['dcno'],$_POST['pd_cheque']['etype'],$_POST['voucher_type_hidden']);
$result = $this->accounts->saveCheque($_POST['pd_cheque']);
$response = array();
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response['error'] = 'false';
}
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
public function fetchChequeVoucher()
{
$dcno = $_POST['dcno'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->accounts->fetchChequeVoucher( $dcno,$etype,$company_id );
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
public function removeChequeVoucher()
{
$dcno = $_POST['dcno'];

$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$result = $this->ledgers->deleteVoucher($dcno,$etype,$company_id);
$result = $this->accounts->removeChequeVoucher( $dcno,$etype,$company_id );
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = 'true';
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
public function fetchReceiptRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->payments->fetchReceiptRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}
public function fetchPaymentRangeSum()
{
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->payments->fetchPaymentRangeSum( $from,$to );
$json = json_encode($sum);
echo $json;
}


public function set_post()
{
    if (isset($_POST)) {
    $dcno = $_POST['dcno'];
    $sum =$this->payments->set_post($dcno);
    $json = json_encode($sum);
    echo $json;
}
}
public function check()
{
if (isset($_POST)) {
    $dcno = $_POST['dcno'];
    $sum=$this->payments->post_chk($dcno);
    $json = json_encode($sum);
    echo $json;
}

}
}

