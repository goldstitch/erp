
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/
if ( !defined('BASEPATH')) exit('No direct script access allowed');
class stocktransferin extends CI_Controller {
public function __construct(){
parent::__construct();
$this->load->model('stocktransferins');
        
}
public function index()
{
$data['count'] =$this->stocktransferins->chkunpost();
$data['item'] =$this->stocktransferins->loaddata();
$this->load->view('template/header');
$this->load->view('stocktransferin',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer');

}

}
?>