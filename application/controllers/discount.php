
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/
if ( !defined('BASEPATH')) exit('No direct script access allowed');
class discount extends CI_Controller {
public function __construct(){
parent::__construct();
$this->load->model('discounts');
$this->load->model('departments');
        
}
public function index()
{
//$data['departments'] = $this->departments->fetchAllDepartments();
$data['item'] =$this->discounts->loaddata();
$this->load->view('template/header');
$this->load->view('discount',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer');

}
public function disc()
{
    if (isset($_POST)) {
        $item_id = $_POST['item_id'];
        $godown_id = $_POST['godown_id'];
        $item_discount = $_POST['item_discount'];
        $sum=$this->discounts->disc($item_id,$godown_id,$item_discount);
        $json = json_encode( $sum);
        echo $json;
    }   
}

public function limitdisc()
{
    if (isset($_POST)) {
        $item_id = $_POST['item_id'];
        $godown_id = $_POST['godown_id'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $limit_discount = $_POST['limit_discount'];
        $sum=$this->discounts->limitdisc($item_id,$godown_id,$from_date,$to_date,$limit_discount);
        $json = json_encode($sum);
        echo $json;
    }   
}

public function save_discount()
{
    if (isset($_POST)) {
        $item_id = $_POST['item_id'];
        $name = $_POST['name'];
        $item_des = $_POST['item_des'];
        $discount = $_POST['discount'];
        $item_discount = $_POST['item_discount'];
        $limit_discount = $_POST['limit_discount'];
        $date = $_POST['date'];
        $sum=$this->discounts->save_discount($item_id,$item_des,$name,$item_discount,$limit_discount,$discount,$date);
        $json = json_encode($sum);
        echo $json;
    }   

}
public function getdata()
{ 
    $this->load->model('discounts');
    if (isset($_POST)) 
        $did = $_POST['did'];
  
        $data['item'] =$this->discounts->getdata($did);
        $this->load->view('discount',$data);

}




}
?>