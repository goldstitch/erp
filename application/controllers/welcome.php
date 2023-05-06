
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 
class Welcome extends CI_Controller
{
function __construct()
{
parent::__construct();
$this->load->model('users');
}
function index() {redirect('welcome/login');
$data['no']=$this->users->me();}
public function login()
{
auth_secure();
$this->load->library('form_validation');
$this->form_validation->set_rules('uname','Username','required');
$this->form_validation->set_rules('pass','Password','required|callback_has_match');
$this->form_validation->set_rules('mob_code','MobileCode','required|callback_has_match');
if ($this->form_validation->run() == false) {
$data['errors'] = isset($_POST['submit']) ?true : false;
$data['wrapper_class'] = 'login';
$this->load->view('template/loginheader',$data);
$this->load->view('user/login',$data);
$this->load->view('template/loginfooter');
}
else{
$this->users->login_user($_POST);
redirect('user/dashboard');
}
}
public function loginCode()
{
auth_secure();
$this->load->library('form_validation');
$this->form_validation->set_rules('uname','Username','required');
$this->form_validation->set_rules('pass','Password','required|callback_has_match');
if ($this->form_validation->run() == false) {
$data['errors'] = isset($_POST['submit']) ?true : false;
$data['wrapper_class'] = 'login';
$this->load->view('template/loginheader',$data);
$this->load->view('user/login',$data);
$this->load->view('template/loginfooter');
}
else{
$uname= $_POST['uname'];
$password= $_POST['pass'];
$sendCode = $this->random_numbers();
$USR= $this->users->fetch_mobile($uname);
$sendMobile = $USR['mobile'];
$msgResult = '';
if ($sendMobile) {
$msgResult = $this->users->login_user_code( $uname,$password,$sendCode );
$msgResult = $this->users->sendMessage( $sendMobile,$sendCode );
echo "true";
}else{
echo "false";
}
}
}
function random_numbers() {
$digits=4;
$min = pow(10,$digits -1);
$max = pow(10,$digits) -1;
return mt_rand($min,$max);
}
public function sendCode()
{
if (isset($_POST)) {
$sendCode = $_POST['sendCode'];
$sendMobile = $_POST['sendMobile'];
$msgResult = '';
$message = "Login Code:".$sendMessage .\n ."! Software By: DIIGITALSOFTS PVT LTD.";
if ($sendMobile) {
$msgResult = $this->parties->sendMessage( $custMobile,$message );
}
echo "true";
}
}
public function has_match()
{
$username = $this->input->post('uname');
$password = $this->input->post('pass');
if ($this->users->has_match($username,$password) === true) {
return true;
}
else {
$this->form_validation->set_message('has_match','Invalid Username/password entered');
return false;
}
}
public function has_matchMobile()
{
if (file_get_contents('php://input')) {
$json = file_get_contents('php://input');
$data = json_decode($json,true);
$id = $this->users->login_userMobile($data);
$returnData = array();
$returnData['id_message'] = $id;
$result = json_encode($returnData);
echo $result;
}
}
public function Get_Mobile_No($uname)
{
$id = $this->users->login_userMobile($data);
$returnData = array();
$returnData['id_message'] = $id;
$result = json_encode($returnData);
echo $result;
}
}
?>