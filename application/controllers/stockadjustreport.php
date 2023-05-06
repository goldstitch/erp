
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/
if ( !defined('BASEPATH')) exit('No direct script access allowed');
class stockadjustreport extends CI_Controller {
public function __construct(){
parent::__construct();
$this->load->model('stockadjustreports');
        
}
public function index()
{
$data['item'] =$this->stockadjustreports->loaddata();
$this->load->view('template/header');
$this->load->view('stockadjustreport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer');

}

public function report()
{
$data['item'] =$this->stockadjustreports->loaddata();
$this->load->view('reports/Stockadjustreport.php',$data);
}

}
?>