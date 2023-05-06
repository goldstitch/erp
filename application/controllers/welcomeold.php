

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
function index() {redirect('welcome/login');}
public function login()
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
$this->users->login_user($_POST);
redirect('user/dashboard');
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
$this->form_validation->set_message('has_match','Invalid Username/password entered or your account has been suspended!');
return false;
}
}
}
?>