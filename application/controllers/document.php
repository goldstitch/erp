

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class document extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('documents');
}

public function getMaxIddocument() {
    $maxId = $this->documents->getMaxIddocument() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }


public function save_document() {
    if (isset($_POST)) {
    $id = $this->documents->getMaxIddocument() +1;
    $name = $_POST['name'];
    $company = $_POST['company'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $by = $_POST['by'];
    $result =$this->documents->save_document($id,$name,$date,$company,$amount,$by,$status);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }


public function delete_document() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->documents->delete_document($id);
$response = "";
if ( $result === true ) {
$response = 'true';
}else {
$response = $result;
}
$this->output->set_content_type('application/json')->set_output(json_encode($response));
}
}


public function fetch_document() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->documents->fetch_document($id);
    $response = "";
    if ( $result === true ) {
    $response = 'true';
    }else {
    $response = $result;
    }
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($response));
    }
    }


    public function update_document() {
        if (isset($_POST)) {
        $id = $_POST['id'];;
        $name = $_POST['name'];
        $company = $_POST['company'];
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        $by = $_POST['by'];
        $result =$this->documents->update_document($id,$name,$date,$company,$amount,$by,$status);
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }
    }



    public function update_return() {
        if (isset($_POST)) {
        $id = $_POST['id'];;
        $date = $_POST['date'];
        $result =$this->documents->update_return($id,$date);
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }
    }

    }

?>