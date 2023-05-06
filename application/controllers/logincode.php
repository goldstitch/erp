

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


class LoginCode extends CI_Controller
{
public function __construct(){
parent::__construct();
$this->load->model('users');
}
public function index($uname){
auth_secure();
$data['errors'] = isset($_POST['submit']) ?true : false;
$data['wrapper_class'] = 'login';
$data['uname'] = $uname;
$this->load->view('template/loginheader',$data);
$this->load->view('user/logincodev',$data);
$this->load->view('template/loginfooter');
}
public function savePriviligeGroup()
{
unauth_secure();
$privData = $_POST;
$this->users->savePriviligeGroup($privData);
}
public function fetchUser()
{
$user_id = $_POST['user_id'];
$user_data = $this->users->fetchUser($user_id);
$json = json_encode($user_data);
echo $json;
}
}

?>