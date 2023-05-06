
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

if ( !defined('BASEPATH')) exit('No direct script access allowed');
class difference extends CI_Controller {
public function __construct(){
parent::__construct();
$this->load->model('differences');
        
}
public function index()
{
$data['item'] =$this->differences->loaddata();
$this->load->view('template/header');
$this->load->view('difference',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer');

}

public function balance(){
    if (isset($_POST)) {
        $vrnoa = $_POST['vrnoa'];
        $snd_qty = $_POST['snd_qty'];
        $rec_qty = $_POST['rec_qty'];
        $type = $_POST['type'];
        $sum=$this->differences->balance($vrnoa,$snd_qty,$rec_qty,$type);
        $json = json_encode($sum);
        echo $json;
    }
    }






}
?>