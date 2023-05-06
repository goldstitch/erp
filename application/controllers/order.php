
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Order extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('orders');
}
public function index() {
redirect('order/selection');
}
public function selection() {
$data['modules'] = array('sale/orderselection');
$this->load->view('template/header');
$this->load->view('sale/saleorderselection',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchOrders() {
if($this->input->is_ajax_request()) {
$from = $this->input->post('from');
$to = $this->input->post('to');
$type = $this->input->post('type');
$result = $this->orders->fetchOrders($from,$to,$type);
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
public function updateOrderStatus() {
if($this->input->is_ajax_request()) {
$oids = $this->input->post('oids');
$result = $this->orders->updateOrderStatus($oids);
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}
}

?>