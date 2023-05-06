

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Trial_Balance extends CI_Controller {
public function __construct()
{
parent::__construct();
$this->load->model('accounts');
$this->load->model('levels');
}
public function fetchTrialBalance()
{
if (isset($_POST)) {
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$l1 = $_POST['l1'];
$l2 = $_POST['l2'];
$l3 = $_POST['l3'];
$with_zero = $_POST['with_zero'];
$tb_data = $this->accounts->fetchTrialBalanceData6($from,$to,$company_id,$l1,$l2,$l3,$with_zero);
$this->output
->set_content_type('application/json')
->set_output(json_encode($tb_data));
}
}
public function index()
{
unauth_secure();
$data['modules'] = array('reports/accounts/trial_balance');
$data['level1s'] = $this->levels->getLevel1();
$data['level2s'] = $this->levels->getLevel2();
$data['level3s'] = $this->levels->getLevel3();
$data['title'] = "Trial Balance";
$this->load->view('template/header',$data);
$this->load->view('reports/accounts/trial_balance',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
}

?>