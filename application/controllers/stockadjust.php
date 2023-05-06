
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class stockadjust extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('stockadjusts');

}
public function index() {

$data['item'] = $this->stockadjusts->loaddata();
$this->load->view('template/header');
$this->load->view('inventory/stockadjust',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer');
}


}
?>