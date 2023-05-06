
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('settings');
}
public function index() {
redirect('setting/add');
}
public function add() {
unauth_secure();
$data['modules'] = array('setup/settings');
$data['sal_calc'] = $this->settings->getSalaryPlane();
$this->load->view('template/header');
$this->load->view('setup/addsetting',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function save() {
if (isset($_POST)){
$sal_calc = $_POST['sal_calc'];
$this->settings->save($sal_calc);
echo json_encode("true");
}
}
}

?>