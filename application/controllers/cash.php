


<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Cash extends CI_Controller {
public function __construct()
{
parent::__construct();
$this->load->model('cashes');
}
public function fetchNetSum()
{
$company_id = $_POST['company_id'];
$sum = $this->cashes->fetchNetSum( $company_id );
$json = json_encode($sum);
echo $json;
}
public function fetchNetExpense()
{
$company_id = $_POST['company_id'];
$sum = $this->cashes->fetchNetExpenses( $company_id );
$json = json_encode($sum);
echo $json;
}
}

?>