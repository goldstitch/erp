

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


class User extends CI_Controller
{
public function __construct(){
parent::__construct();
$this->load->model('users');
$this->load->model('ledgers');
$this->load->model('purchases');
$this->load->model('sales');
$this->load->model('accounts');
$this->load->model('companies');
$this->load->model('payments');
$this->load->model('stocktransferins');
}
public function index(){
redirect('user/dashboard');

}
public function dashboard()
{
unauth_secure();
$data['no'] =$this->users->count_unpost();
$data['no_1'] =$this->users->count_unpostjv();
$data['wrapper_class'] = 'dashboard';
$data['currDate'] = date("Y/m/d");
$data['currDay'] = date("l");
$login_uid = $this->session->userdata('uid');
$to = date("Y/m/d");
if($login_uid=='1'){
$data['purchases']       = $this->purchases->fetchAllPurchases(1,'purchase');
$data['Yarnpurchases']   = $this->purchases->fetchAllPurchases(1,'yarnPurchase');
$data['FabricPurchases'] = $this->purchases->fetchAllPurchases(1,'fabricPurchase');
$data['sales']           = $this->sales->fetchAllSales(1,'sale');
$data['saleOrders']      = $this->sales->fetchAllSales(1,'sale_order');
$data['paymentss']       = $this->ledgers->fetchAllLedgersPayments(1,'cpv');
$data['receiptss']       = $this->ledgers->fetchAllLedgersPayments(1,'crv');
$data['cheqIssues']      = $this->ledgers->fetchAllLedgersPayments(1,'pd_issue');
$data['chequeReceives']  = $this->ledgers->fetchAllLedgersPayments(1,'pd_receive');
$data['bpvs']  = $this->ledgers->fetchAllLedgersPayments('bpv');
$data['brvs']  = $this->ledgers->fetchAllLedgersPayments('brv');
$data['expensess']       = $this->accounts->getExpenseReportData($to,$to,'');
}else{
$data['purchases']       = [];
$data['Yarnpurchases']   = [];
$data['FabricPurchases'] = [];
$data['purchasereturns']   = [];
$data['salereturns'] = [];
$data['sales']           = [];
$data['saleOrders']      = [];
$data['paymentss']       = [];
$data['receiptss']       = [];
$data['cheqIssues']      = [];
$data['chequeReceives']  = [];
$data['expensess']  = [];
$data['bpvs']  = [];
$data['brvs']  = [];
}
$data['to']  = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('template/mainnav',$data);
$this->load->view('user/dashboard',$data);
$this->load->view('template/footer');
}
public function savePriviligeGroup()
{
unauth_secure();
$privData = $_POST;
$this->users->savePriviligeGroup($privData);
}
public function saveRoleGroup() {
if (isset($_POST)) {
$rolegroup = $_POST['data'];
$result = $this->users->saveRoleGroup( $rolegroup );
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
public function privillagesAssigned() {
$result = $this->users->privillagesAssigned();
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function monitorActiveTime()
{
$login_time = $this->session->userdata('login_time');
$current_time = microtime(true);
$activeTime = $current_time -$login_time;
$formattedTime = gmdate("H:i:s",$activeTime);
$parts = explode(':',$formattedTime);
$finalTimeString = $parts[0] .' hours and '.$parts[1] .' minutes';
$json = json_encode($finalTimeString);
echo $json;
}
public function priviligeGroup()
{
unauth_secure();
if ($this->session->userdata('priviligeGroupAll') === 'false'){
return;
}
$data['wrapper_class'] = 'priviligegroup';
$data['modules'] = array('user/adduser');
$this->load->view('template/header',$data);
$this->load->view('template/mainnav',$data);
$this->load->view('user/privillagesgroup',$data);
$this->load->view('template/footer');
}
public function getMaxRoleGroupId() {
$result = $this->users->getMaxRoleGroupId() +1;
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function privillages()
{
unauth_secure();
$data['modules'] = array('user/privillagesgroup');
$data['title'] = "User Priviliges";
$this->load->view('template/header',$data);
$this->load->view('user/privillagesgroup');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchRoleGroup()
{
$pgroup_id = $_POST['rgid'];
$pdata = $this->users->fetchRoleGroup( $pgroup_id );
$json = json_encode($pdata);
echo $json;
}
public function fetchUser()
{
$user_id = $_POST['uid'];
$user_data = $this->users->fetch($user_id);
$json = json_encode($user_data);
echo $json;
}
public function valid_username($username){
if(preg_match("/\\s/",$username)) {
$this->form_validation->set_message('valid_username','Username cannot contain any spaces');
return false;
}
else {
return true;
}
}
public function _is_unique_curr_user()
{
if ($this->session->userdata('uname') === $_POST['uname']) {
return true;
}else {
$username = $_POST['uname'];
$user_id = $_POST['uid'];
if( $this->users->alreadyExists($username,$user_id) ) {
$this->form_validation->set_message('_is_unique_curr_user','Username already taken, please chose another one.');
return false;
}
else {
return true;
}
}
}
public function _is_unique()
{
$username = $_POST['uname'];
$user_id = $_POST['uid'];
if( $this->users->alreadyExists($username,$user_id) ) {
$this->form_validation->set_message('_is_unique','Username already taken, please chose another one.');
return false;
}
else {
return true;
}
}
public function _is_correct_pass()
{
$uid = $_POST['uid'];
$pass = $_POST['pass'];
if( $this->users->idPassMatch($uid,$pass) ) {
return true;
}else {
$this->form_validation->set_message('_is_correct_pass','Invalid old password entered.');
return false;
}
}
public function addnew()
{
unauth_secure();
if ($this->session->userdata('userAll') === 'false'){
return;
}
$data['wrapper_class'] = 'adduser';
$data['maxid'] = $this->users->getMaxId() +1;
$data['currDate'] = date("F j, Y");
$data['currDay'] = date("l");
$data['pgroups'] = $this->users->fetchAllRoleGroup();
$this->load->library('form_validation');
$this->form_validation->set_rules('uid','User id','required');
$this->form_validation->set_rules('user_type','User type','required');
$this->form_validation->set_rules('uname','User Name','required|callback_valid_username|callback__is_unique');
$this->form_validation->set_rules('pass','Password','required');
$this->form_validation->set_rules('company_id','Company name','required');
$this->form_validation->set_rules('full_name','Full name','required');
$this->form_validation->set_rules('user_email','Email','required');
$this->form_validation->set_rules('user_mobile','Mobile','required');
$this->form_validation->set_rules('pgroup_id','User role','required');
if ($this->form_validation->run() == false) {
$data['wrapper_class'] = 'adduser';
$data['maxid'] = $this->users->getMaxId() +1;
$data['currDate'] = date("F j, Y");
$data['currDay'] = date("l");
$data['companies'] = $this->companies->getAll();
$data['userone'] = $this->users->fetchAll();
$data['modules'] = array('user/adduser');
$this->load->view('template/header',$data);
$this->load->view('template/mainnav',$data);
$this->load->view('user/adduser',$data);
$this->load->view('template/footer');
}else {
$this->users->updateUser($_POST);
redirect('user/addnew');
}
}
public function getMaxId() {
if (isset($_POST)) {
$result = $this->users->getMaxId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function save() {
if (isset($_POST)) {
$user = $_POST['user'];
$result = $this->users->save($user);
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
public function updatecode()
{
unauth_secure();
if ($this->session->userdata('userAll') === 'false'){
return;
}
$data['modules'] = array('user/updatecode');
$data['title'] = 'Update Code';
$this->load->view('template/header',$data);
$this->load->view('user/updatecode',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function savelogincode() {
if (isset($_POST)) {
$user = $_POST['user'];
$result = $this->users->savelogincode($user);
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
public function updateProfile()
{
unauth_secure();
$data['uid'] =  $this->session->userdata('uid');
$data['uname'] =  $this->session->userdata('uname');
$data['full_name'] = $this->session->userdata('full_name');
$data['user_mobile'] = $this->session->userdata('user_mobile');
$data['user_email'] = $this->session->userdata('user_email');
$data['wrapper_class'] = 'updateProfile';
$data['currDate'] = date("F j, Y");
$data['currDay'] = date("l");
$this->load->library('form_validation');
$this->form_validation->set_rules('uid','User id','required');
$this->form_validation->set_rules('uname','User Name','required|callback_valid_username|callback__is_unique_curr_user');
$this->form_validation->set_rules('pass','Password','required|callback__is_correct_pass');
$this->form_validation->set_rules('full_name','Full name','required');
$this->form_validation->set_rules('user_email','Email','required');
$this->form_validation->set_rules('user_mobile','Mobile','required');
if ($this->form_validation->run() == false) {
$data['wrapper_class'] = 'updateUserProfile';
$data['currDate'] = date("F j, Y");
$data['currDay'] = date("l");
$this->load->view('template/head',$data);
$this->load->view('template/navigation',$data);
$this->load->view('updateProfile',$data);
$this->load->view('template/foot');
}else {
if (trim($_POST['newpass']) !== '') {
$_POST['pass'] = $_POST['newpass'];
unset($_POST['newpass']);
}else {
unset( $_POST['newpass'] );
}
$this->users->updateUser($_POST);
redirect('user/updateProfile');
}
}
public function logout()
{
unauth_secure();
$uname= $this->session->userdata('uname');
$this->session->sess_destroy();
redirect('welcome');
}
public function db_backup()
{
if ( $this->session->userdata('db_backup') === 'false') {
return;
}
unauth_secure();
$DBUSER=$this->db->username;
$DBPASSWD=$this->db->password;
$DATABASE=$this->db->database;
$filename = $DATABASE ."-".date("Y-m-d_H-i-s") .".sql.gz";
$mime = "application/x-gzip";
header( "Content-Type: ".$mime );
header( 'Content-Disposition: attachment; filename="'.$filename .'"');
$cmd = "mysqldump -u $DBUSER --password=$DBPASSWD --no-create-info --complete-insert $DATABASE | gzip --best";
passthru( $cmd );
exit(0);
}
public function send_mail( $filePath,$subject,$message )
{
$configs = array(
'protocol'=>'smtp',
'smtp_host'=>'mail.afaqtraders.com',
'smtp_user'=>'info@afaqtraders.com',
'smtp_pass'=>"info@afaqtraders",
'smtp_port'=>'25'
);
$this->load->library("email",$configs);
$this->email->set_newline("\r\n");
$this->email->to(array(
'arshadfarouq@hotmail.com',
'info@alnaharsolutions.com'
));
$this->email->from("info@afaqtraders.com","Afaq Traders");
$this->email->subject( $subject );
$this->email->message( $message );
$this->email->attach( $filePath );
if($this->email->send())
{
}
else
{
echo $this->email->print_debugger();
}
}
public function fetchAllUser()
{
$result = $this->users->fetchAll($_POST);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function logoutAllUsers()
{
unauth_secure();
CheckReportRights('logoutall');
$this->users->logoutAllUsers();
redirect('welcome');
}
public function getNotifications() {
if (isset( $_POST )) {
$company_id = $_POST['company_id'];
$result = $this->users->getNotifications($company_id);
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

public function setpost()
{
    if (isset($_POST)) {
        $dcno = $_POST['dcno'];
        $sum =$this->users->setpost($dcno);
        $json = json_encode($sum);
        echo $json;}
}

public function setpostbpv()
{
    if (isset($_POST)) {
        $dcno = $_POST['dcno'];
        $sum =$this->users->setpostbpv($dcno);
        $json = json_encode($sum);
        echo $json;}
}


public function setpostbrv()
{
    if (isset($_POST)) {
        $dcno = $_POST['dcno'];
        $sum =$this->users->setpostbpv($dcno);
        $json = json_encode($sum);
        echo $json;}
}

public function checkjv()
{
if (isset($_POST)) {
    $dcno = $_POST['dcno'];
    $sum=$this->users->post_chkjv($dcno);
    $json = json_encode($sum);
    echo $json;
}
}
public function checkbpv()
{
if (isset($_POST)) {
    $dcno = $_POST['dcno'];
    $sum=$this->users->post_chkbpv($dcno);
    $json = json_encode($sum);
    echo $json;
}
}
public function checkbrv()
{
if (isset($_POST)) {
    $dcno = $_POST['dcno'];
    $sum=$this->users->post_chkbrv($dcno);
    $json = json_encode($sum);
    echo $json;
}
}



}