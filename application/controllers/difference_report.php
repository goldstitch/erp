<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

if ( !defined('BASEPATH')) exit('No direct script access allowed');
class difference_report extends CI_Controller {
public function __construct(){
parent::__construct();
$this->load->model('differences');
        
}
public function index()
{
$data['item'] =$this->differences->load_difference();
$this->load->view('template/header');
$this->load->view('difference_report',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer');

}

public function difference()
{
    if (isset($_POST)) {
        $todate = $_POST['todate'];
        $fromdate = $_POST['fromdate'];
        $sum=$this->differences->difference($todate,$fromdate);
        $json = json_encode($sum);
        echo $json;
    }
}


public function report($todate,$fromdate)
{
    $data['item']=$this->differences->difference($todate,$fromdate);
    $this->load->view('reports/difference_report.php',$data);
}


}
?>