
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/
if ( !defined('BASEPATH')) exit('No direct script access allowed');
class price extends CI_Controller {
public function __construct(){
parent::__construct();
$this->load->model('discounts');
$this->load->model('departments');
        
}
public function index()
{
$data['item'] =$this->discounts->loaddata();
$this->load->view('template/header');
$this->load->view('price',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer');

}

public function report()
{
$data['item'] =$this->discounts->loaddata();
$this->load->view('reports/pricereport.php',$data);
}

public function update_price()
{
    if (isset($_POST)) {
        $item_id = $_POST['item_id'];
        $item_barcode = $_POST['item_barcode'];
        $w_price = $_POST['w_price'];
        $r_price = $_POST['r_price'];
        $sum=$this->discounts->update_price($item_id,$item_barcode,$w_price,$r_price);
        $json = json_encode( $sum);
        echo $json;
    }   
}
public function save_price()
{
    if (isset($_POST)) {
        $item_id = $_POST['item_id'];
        $w_price = $_POST['w_price'];
        $cost = $_POST['cost'];
        $price = $_POST['price'];
        $item_des = $_POST['item_des'];
        $date = $_POST['date'];
        $r_price = $_POST['r_price'];
        $name = $_POST['name'];
        $sum=$this->discounts->save_price($item_id,$name,$w_price,$r_price, $item_des ,$date ,$cost,$price);
        $json = json_encode( $sum);
        echo $json;
    }   
}






}
?>