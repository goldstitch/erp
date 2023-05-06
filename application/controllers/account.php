

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Account extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('ledgers');
$this->load->model('levels');
}
public function index() {
redirect('account/add');
}
public function add() {
unauth_secure();
$data['modules'] = array('setup/account');
$data['names'] = $this->accounts->getDistinctFields('name');
$data['countries'] = $this->accounts->getDistinctFields('country');
$data['typess'] = $this->accounts->getDistinctFields('etype');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['accounts'] = $this->accounts->fetchAll();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['title'] = "Add New Account";
$this->load->view('template/header',$data);
$this->load->view('setup/addaccount',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$maxId = $this->accounts->getMaxId() +1;
$this->output
->set_content_type('application/json')
->set_output(json_encode($maxId));
}
public function searchAccount()
{
$search = $_POST['search'];
$type = $_POST['type'];;
$result = $this->accounts->searchAccount($search,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function searchAccountAll()
{
$search = $_POST['search'];
$type = $_POST['type'];;
$result = $this->accounts->searchAccountAll($search,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function getAccountinfobyid()
{
$pid = $_POST['pid'];
$result = $this->accounts->getAccountinfobyid($pid);
$response = "";
if($result === false) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
public function getMaxChequeId() {
if (isset($_POST)) {
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$maxId = $this->accounts->getMaxChequeId($etype,$company_id) +1;
$this->output
->set_content_type('application/json')
->set_output(json_encode($maxId));
}
}
public function save() {
if (isset($_POST)) {
$accountDetail = $_POST['accountDetail'];
$accountDetail['account_id'] = $this->levels->genAccStr($accountDetail['level3']);
$result = $this->accounts->save( $accountDetail );
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response['error'] = false;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function delete() {
if (isset( $_POST )) {
$pid = $_POST['pid'];
$result = $this->accounts->delete($pid);
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
public function fetchAccount() {
if (isset( $_POST )) {
$pid = $_POST['pid'];
$result = $this->accounts->fetchAccount($pid);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchAccountByName() {
if (isset( $_POST )) {
$name = $_POST['name'];
$result = $this->accounts->fetchAccountByName($name);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetchAll(){
$activee=(isset($_POST['active'])?$_POST['active']:-1);
$typee=(isset($_POST['typee'])?$_POST['typee']:'all');
$result = $this->accounts->fetchAll($activee,$typee);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function getAllParties() {
$etype = '';
if (isset($_POST) &&!empty($_POST)) {
$etype = $_POST['etype'];
}
$result = $this->accounts->getAllParties($etype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchPartyOpeningBalance()
{
if (isset($_POST)) {
$to = $_POST['to'];
$party_id = $_POST['pid'];
$ptype = $_POST['ptype'];
$result = $this->accounts->fetchPartyOpeningBalance( $to,$party_id,$ptype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function fetchRunningTotal()
{
if (isset($_POST)) {
$endDate = $_POST['to'];
$party_id = $_POST['pid'];
$ptype = $_POST['ptype'];
$result = $this->accounts->fetchRunningTotal($endDate,$party_id,$ptype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
}
public function getAccLedgerReport() {
if (isset( $_POST )) {
$ptype = $_POST['ptype'];
$from = $_POST['from'];
$to = $_POST['to'];
$pid = $_POST['pid'];
$result = $this->ledgers->getAccLedgerReport($from,$to,$pid,$ptype);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}

public function AccLedgerReport() {
if (isset( $_POST )) {
$from = $_POST['from'];
$to = $_POST['to'];
$pid = $_POST['pid'];
$result = $this->ledgers->AccLedgerReport($from,$to,$pid);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function getChartOfAccounts()
{
$coas = $this->accounts->getChartOfAccounts();
$json = json_encode($coas);
echo $json;
}
public function fetchClosingBalance()
{
$to = $_POST['to'];
$result = $this->accounts->fetchClosingBalance( $to );
$json = json_encode($result);
echo $json;
}
public function fetchOpeningBalance()
{
$to = $_POST['to'];
$result = $this->accounts->fetchOpeningBalance( $to );
$json = json_encode($result);
echo $json;
}
public function fetchCity()
{
$result = $this->accounts->fetchCity($_POST);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchCityArea()
{
$result = $this->accounts->fetchCityArea($_POST);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchAllLevel1(){
$result = $this->levels->fetchAllLevel1();
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchAllLevel2(){
$result = $this->levels->fetchAllLevel2();
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}


public function fetchAllLevel3(){
$result = $this->levels->fetchAllLevel3();
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}



public function getMaxIdcut() {
    $maxId = $this->accounts->getMaxIdcut() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }



public function getMaxIdemployee() {
    $maxId = $this->accounts->getMaxIdemployee() +1;
    $this->output->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }


public function getMaxIdaccessories() {
    $maxId = $this->accounts->getMaxIdaccessories() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxIddocument() {
    $maxId = $this->accounts->getMaxIddocument() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxIdstonework() {
    $maxId = $this->accounts->getMaxIdstonework() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }
    
    
public function getMaxIdaddawork() {
    $maxId = $this->accounts->getMaxIdaddawork() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }
    

public function getMaxId_article() {
    $maxId = $this->accounts->getMaxId_article() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxId_color() {
    $maxId = $this->accounts->getMaxId_color() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxId_category() {
    $maxId = $this->accounts->getMaxId_category() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxIdthd() {
    $maxId = $this->accounts->getMaxIdthd() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxIdpack() {
    $maxId = $this->accounts->getMaxIdpack() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxIdemb() {
    $maxId = $this->accounts->getMaxIdemb() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxIdfabric() {
    $maxId = $this->accounts->getMaxIdfabric() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxIddye() {
    $maxId = $this->accounts->getMaxIddye() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function getMaxIdemblish() {
    $maxId = $this->accounts->getMaxIdemblish() +1;
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($maxId));
    }

public function save_dyeing() {
    if (isset($_POST)) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $rate = $_POST['rate'];
    $unit = $_POST['unit'];
    $result =$this->accounts->save_dyeing($id,$name,$code,$rate,$unit);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }

public function save_emb() {
    if (isset($_POST)) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $unit = $_POST['unit'];
    $result =$this->accounts->save_emb($id,$name,$cost,$unit);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }


public function save_thread() {
    if (isset($_POST)) {
        $id = $this->accounts->getMaxIdthd() +1;
        $name = $_POST['name'];
        $unit = $_POST['unit'];
        $rate = $_POST['rate'];
        $code = $_POST['code'];
        $per_unit_rate = $_POST['perunit'];
        $qty = $_POST['qty'];
        $result =$this->accounts->save_thread($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }

public function save_category() {
if (isset($_POST)) {
$id = $_POST['id'];
$name = $_POST['name'];
$result =$this->accounts->save_category($id,$name);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}

public function save_color() {
if (isset($_POST)) {
$id = $_POST['id'];
$name = $_POST['name'];
$result =$this->accounts->save_color($id,$name);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}

public function save_article() {
if (isset($_POST)) {
$id = $_POST['id'];
$name = $_POST['name'];
$result =$this->accounts->save_article($id,$name);
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
}

public function save_cutting() {
    if (isset($_POST)) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $name = $_POST['name'];
    $part = $_POST['part'];
    $rate = $_POST['rate'];
    $result =$this->accounts->save_cutting($id,$type,$name,$part,$rate);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }

public function save_employee() {
    if (isset($_POST)) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $dept = $_POST['dept'];
    $result =$this->accounts->save_employee($id,$name,$type,$dept);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }

public function save_accessories() {
    if (isset($_POST)) {
    $id = $this->accounts->getMaxIdaccessories() +1;
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $rate = $_POST['rate'];
    $code = $_POST['code'];
    $per_unit_rate = $_POST['perunit'];
    $qty = $_POST['qty'];
    $result =$this->accounts->save_accessories($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }

public function save_document() {
    if (isset($_POST)) {
    $id = $this->accounts->getMaxIddocument() +1;
    $name = $_POST['name'];
    $company = $_POST['company'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $by = $_POST['by'];
    $result =$this->accounts->save_document($id,$name,$date,$company,$amount,$by,$status);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }

public function save_addawork() {
    if (isset($_POST)) {
    $id = $this->accounts->getMaxIdaddawork() +1;
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $rate = $_POST['rate'];
    $code = $_POST['code'];
    $per_unit_rate = $_POST['perunit'];
    $qty = $_POST['qty'];
    $result =$this->accounts->save_addawork($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }

public function save_stonework() {
    if (isset($_POST)) {
    $id = $this->accounts->getMaxIdstonework() +1;
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $rate = $_POST['rate'];
    $code = $_POST['code'];
    $per_unit_rate = $_POST['perunit'];
    $qty = $_POST['qty'];
    $result =$this->accounts->save_stonework($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }



public function save_embt() {
    if (isset($_POST)) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $result =$this->accounts->save_embt($id,$name,$code);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }


public function save_pack() {
    if (isset($_POST)) {
    $id =  $this->accounts->getMaxIdpack() +1;
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $rate = $_POST['rate'];
    $code = $_POST['code'];
    $per_unit_rate = $_POST['perunit'];
    $qty = $_POST['qty'];
    $result =$this->accounts->save_pack($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }


    public function save_fabric() {
    if (isset($_POST)) {
    $id =  $this->accounts->getMaxIdfabric() +1; 
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $rate = $_POST['rate'];
    $code = $_POST['code'];
    $per_unit_rate = $_POST['perunit'];
    $qty = $_POST['qty'];
    $dye_unit = $_POST['dye_unit'];
    $dye_rate = $_POST['dye_rate'];
    $result =$this->accounts->save_fabric($id,$name,$code,$unit,$rate,$per_unit_rate,$qty,$dye_unit,$dye_rate);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }
    }


public function deletecut() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->accounts->deletecut($id);
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


public function delete_employee() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->accounts->delete_employee($id);
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

public function delete_category() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->accounts->delete_category($id);
$response = "";
if ( $result === true ) {
$response = 'true';
}else {
$response = $result;
}
$this->output->set_content_type('application/json')->set_output(json_encode($response));
}
}

public function delete_color() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->accounts->delete_color($id);
$response = "";
if ( $result === true ) {
$response = 'true';
}else {
$response = $result;
}
$this->output->set_content_type('application/json')->set_output(json_encode($response));
}
}


public function delete_accessories() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->accounts->delete_accessories($id);
$response = "";
if ( $result === true ) {
$response = 'true';
}else {
$response = $result;
}
$this->output->set_content_type('application/json')->set_output(json_encode($response));
}
}

public function delete_document() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->accounts->delete_document($id);
$response = "";
if ( $result === true ) {
$response = 'true';
}else {
$response = $result;
}
$this->output->set_content_type('application/json')->set_output(json_encode($response));
}
}


public function delete_addawork() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->accounts->delete_addawork($id);
$response = "";
if ( $result === true ) {
$response = 'true';
}else {
$response = $result;
}
$this->output->set_content_type('application/json')->set_output(json_encode($response));
}
}


public function delete_stonework() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->accounts->delete_stonework($id);
$response = "";
if ( $result === true ) {
$response = 'true';
}else {
$response = $result;
}
$this->output->set_content_type('application/json')->set_output(json_encode($response));
}
}

public function delete_article() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->accounts->delete_article($id);
$response = "";
if ( $result === true ) {
$response = 'true';
}else {
$response = $result;
}
$this->output->set_content_type('application/json')->set_output(json_encode($response));
}
}

public function deletethd() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->accounts->deletethd($id);
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

public function deletedye() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->accounts->deletedye($id);
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

public function deleteemb() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->accounts->deleteemb($id);
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

public function deleteemblish() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->accounts->deleteemblish($id);
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

public function deletepack() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->accounts->deletepack($id);
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


public function deletefabric() {
    if (isset( $_POST )) {
    $id = $_POST['id'];
    $result = $this->accounts->deletefabric($id);
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

    public function fetch_cut() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_cut($id);
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

    public function fetch_pack() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_pack($id);
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


    public function fetch_employee() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_employee($id);
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

    public function fetch_sample() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_sample($id);
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
    
    
    public function fetch_accessories() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_accessories($id);
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


public function fetch_documnet() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_documnet($id);
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

    public function fetch_addawork() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_addawork($id);
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

     public function fetch_stonework() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_stonework($id);
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

    public function fetch_article() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_article($id);
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

    public function fetch_color() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_color($id);
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

    public function fetch_category() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_category($id);
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
    
    public function fetch_ebh() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_ebh($id);
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
    
    public function fetch_dye() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_dye($id);
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
    
    public function fetch_thd() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_thd($id);
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
    
    public function fetch_emb() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_emb($id);
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


    public function fetch_fabric() {
        if (isset( $_POST )) {
        $id = $_POST['id'];
        $result = $this->accounts->fetch_fabric($id);
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

        public function update_dyeing() {
            if (isset($_POST)) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $code = $_POST['code'];
            $rate = $_POST['rate'];
            $unit = $_POST['unit'];
            $result =$this->accounts->update_dyeing($id,$name,$code,$rate,$unit);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }
        
        public function update_emb() {
            if (isset($_POST)) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $cost = $_POST['cost'];
            $unit = $_POST['unit'];
            $result =$this->accounts->update_emb($id,$name,$cost,$unit);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }


        public function update_fabric() {
            if (isset($_POST)) {
                $id = $_POST['id'];;
                $name = $_POST['name'];
                $unit = $_POST['unit'];
                $rate = $_POST['rate'];
                $code = $_POST['code'];
                $per_unit_rate = $_POST['perunit'];
                $qty = $_POST['qty'];
                $dye_unit = $_POST['dye_unit'];
                $dye_rate = $_POST['dye_rate'];
                $result =$this->accounts->update_fabric($id,$name,$code,$unit,$rate,$per_unit_rate,$qty,$dye_unit,$dye_rate);
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
                }
                }
        
        
        public function update_thread() {
            if (isset($_POST)) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $unit = $_POST['unit'];
            $rate = $_POST['rate'];
            $code = $_POST['code'];
            $per_unit_rate = $_POST['perunit'];
            $qty = $_POST['qty'];
            $result =$this->accounts->update_thread($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }
        
        public function update_cutting() {
            if (isset($_POST)) {
            $id = $_POST['id'];  
            $type = $_POST['type'];
            $name = $_POST['name'];
            $part = $_POST['part'];
            $rate = $_POST['rate'];
            $result =$this->accounts->update_cutting($id,$type,$name,$part,$rate);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }
    

        public function update_employee() {
            if (isset($_POST)) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $type = $_POST['type'];
            $dept = $_POST['dept'];
            $result =$this->accounts->update_employee($id,$name,$type,$dept);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }
    

    
        public function update_accessories() {
            if (isset($_POST)) {
            $id = $_POST['id'];;
            $name = $_POST['name'];
            $unit = $_POST['unit'];
            $rate = $_POST['rate'];
            $code = $_POST['code'];
            $per_unit_rate = $_POST['perunit'];
            $qty = $_POST['qty'];
            $result =$this->accounts->update_accessories($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
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
            $result =$this->accounts->update_document($id,$name,$date,$company,$amount,$by,$status);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }




        public function update_stonework() {
            if (isset($_POST)) {
            $id = $_POST['id'];;
            $name = $_POST['name'];
            $unit = $_POST['unit'];
            $rate = $_POST['rate'];
            $code = $_POST['code'];
            $per_unit_rate = $_POST['perunit'];
            $qty = $_POST['qty'];
            $result =$this->accounts->update_stonework($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }


        public function update_addawork() {
            if (isset($_POST)) {
            $id = $_POST['id'];;
            $name = $_POST['name'];
            $unit = $_POST['unit'];
            $rate = $_POST['rate'];
            $code = $_POST['code'];
            $per_unit_rate = $_POST['perunit'];
            $qty = $_POST['qty'];
            $result =$this->accounts->update_addawork($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }


       public function update_color() {
            if (isset($_POST)) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $result =$this->accounts->update_color($id,$name);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }

       public function update_article() {
            if (isset($_POST)) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $result =$this->accounts->update_article($id,$name);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }

       public function update_category() {
            if (isset($_POST)) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $result =$this->accounts->update_category($id,$name);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }
        
        public function update_embt() {
            if (isset($_POST)) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $code = $_POST['code'];
            $result =$this->accounts->update_embt($id,$name,$code);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }

        public function update_pack() {
            if (isset($_POST)) {
            $id = $_POST['id'];;
            $name = $_POST['name'];
            $unit = $_POST['unit'];
            $rate = $_POST['rate'];
            $code = $_POST['code'];
            $per_unit_rate = $_POST['perunit'];
            $qty = $_POST['qty'];
            $result =$this->accounts->update_pack($id,$name,$code,$unit,$rate,$per_unit_rate,$qty);
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
            }
            }



    }

?>