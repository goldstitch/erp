
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 defined('BASEPATH') OR exit('No direct script access allowed');
class Wall extends CI_Controller
{
public function __construct()
{
parent::__construct();
$this->load->model('companies');
$this->load->model('payments');
$this->load->model('items');
$this->load->model('accounts');
$this->load->model('sales');
$this->load->model('purchases');
$this->load->model('walls');
}
public function index()
{
unauth_secure();
$data['modules'] = array('company_feed','general1');
$data['wrapper_class'] = 'company_feed';
$data['body_class'] = 'company_feed';
$company_id = $this->session->userdata('company_id');
$data['feed'] = $this->walls->getFeed($this->session->userdata('company_id'),0);
$data['company_info'] = $this->companies->fetchCompany($company_id);
$data['netsale'] = $this->walls->fetchNetSum($company_id);
$data['netpurchase'] = $this->walls->fetchNetSumPurchase($company_id);
$data['cashinhand'] = $this->walls->fetchNetCashInHand($company_id);
$this->load->view('template/header',$data);
$this->load->view('template/mainnav',$data);
$this->load->view('companyfeed',$data);
$this->load->view('template/footer');
}
public function getFeedMessage($feedItem)
{
$message = '';
if ($feedItem['etype'] === 'purchase'):
$message = '<strong class="feeditem_amount">'.$feedItem['namount'] .'</strong> has been paid to <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif ($feedItem['etype'] === 'sale'):
$message = '<strong class="feeditem_amount">'.$feedItem['namount'] .'</strong> has been received from <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif ($feedItem['etype'] === 'salereturn'):
$message = '<strong class="feeditem_amount">'.$feedItem['namount'] .'</strong> has been paid to <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif ($feedItem['etype'] === 'purchasereturn'):
$message = '<strong class="feeditem_amount">'.$feedItem['namount'] .'</strong> has been received from <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif ($feedItem['etype'] === 'purchaseorder'):
$message = 'Order of <strong class="feeditem_amount">'.$feedItem['namount'] .'</strong> has been received from <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif ($feedItem['etype'] === 'saleorder'):
$message = 'Order of <strong class="feeditem_amount">'.$feedItem['namount'] .'</strong> has been made to <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif ($feedItem['etype'] === 'saleq'):
$message = 'Quotation of <strong class="feeditem_amount">'.$feedItem['namount'] .'</strong> has been made to <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif (($feedItem['etype'] === 'cpv') &&($feedItem['debit'] != 0)):
$message = '<strong class="feeditem_amount">'.$feedItem['debit'] .'</strong> has been paid to <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif (($feedItem['etype'] === 'cpv') &&($feedItem['credit'] != 0)):
$message = '<strong class="feeditem_amount">'.$feedItem['credit'] .'</strong> has been received from <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif (($feedItem['etype'] === 'crv') &&($feedItem['credit'] != 0)):
$message = '<strong class="feeditem_amount">'.$feedItem['credit'] .'</strong> has been received from <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif (($feedItem['etype'] === 'crv') &&($feedItem['debit'] != 0)):
$message = '<strong class="feeditem_amount">'.$feedItem['debit'] .'</strong> has been paid to <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif (($feedItem['etype'] === 'jv') &&($feedItem['debit'] != 0)):
$message = '<strong class="feeditem_amount">'.$feedItem['debit'] .'</strong> has been paid to <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif (($feedItem['etype'] === 'jv') &&($feedItem['credit'] != 0)):
$message = '<strong class="feeditem_amount">'.$feedItem['credit'] .'</strong> has been received from <strong class="feeditem_party1">'.$feedItem['name'] .'</strong>!';
elseif ($feedItem['etype'] === 'pd_receive'):
$message = 'Cheque of <strong class="feeditem_amount">'.$feedItem['namount'] .'</strong> has been received from <strong class="feeditem_party1">'.$feedItem['name'] .'</strong> into <strong>'.$feedItem['party2'] .'</strong>!';
elseif ($feedItem['etype'] === 'pd_issue'):
$message = 'Cheque of <strong class="feeditem_amount">'.$feedItem['namount'] .'</strong> has been paid to <strong class="feeditem_party1">'.$feedItem['name'] .'</strong> from <strong>'.$feedItem['party2'] .'</strong>!';
endif;
return $message;
}
public function getVrnoaLink($feedItem)
{
$link = '<a href="@vrlink@">'.$feedItem['vrnoa'] .'</a>';
$vrlink = '#';
if ($feedItem['etype'] === 'purchase'):
$vrlink = base_url('index.php/purchase?vrnoa='.$feedItem['vrnoa']);
elseif ($feedItem['etype'] === 'sale'):
$vrlink = base_url('index.php/sale?vrnoa='.$feedItem['vrnoa']);
elseif ($feedItem['etype'] === 'salereturn'):
$vrlink = base_url('index.php/salereturn?vrnoa='.$feedItem['vrnoa']);
elseif ($feedItem['etype'] === 'purchasereturn'):
$vrlink = base_url('index.php/purchasereturn?vrnoa='.$feedItem['vrnoa']);
elseif ($feedItem['etype'] === 'purchaseorder'):
$vrlink = base_url('index.php/purchase/order?vrnoa='.$feedItem['vrnoa']);
elseif ($feedItem['etype'] === 'saleorder'):
$vrlink = base_url('index.php/sale/order?vrnoa='.$feedItem['vrnoa']);
elseif ($feedItem['etype'] === 'saleq'):
$vrlink = base_url('index.php/sale/quotation?vrnoa='.$feedItem['vrnoa']);
elseif (($feedItem['etype'] === 'cpv') &&($feedItem['debit'] != 0)):
$vrlink = base_url('index.php/payment?etype=cpv&vrnoa='.$feedItem['vrnoa']);
elseif (($feedItem['etype'] === 'cpv') &&($feedItem['credit'] != 0)):
$vrlink = base_url('index.php/payment?etype=cpv&vrnoa='.$feedItem['vrnoa']);
elseif (($feedItem['etype'] === 'crv') &&($feedItem['credit'] != 0)):
$vrlink = base_url('index.php/payment?etype=crv&vrnoa='.$feedItem['vrnoa']);
elseif (($feedItem['etype'] === 'crv') &&($feedItem['debit'] != 0)):
$vrlink = base_url('index.php/payment?etype=crv&vrnoa='.$feedItem['vrnoa']);
elseif (($feedItem['etype'] === 'jv') &&($feedItem['debit'] != 0)):
$vrlink = base_url('index.php/journal?etype=jv&vrnoa='.$feedItem['vrnoa']);
elseif (($feedItem['etype'] === 'jv') &&($feedItem['credit'] != 0)):
$vrlink = base_url('index.php/journal?etype=jv&vrnoa='.$feedItem['vrnoa']);
elseif ($feedItem['etype'] === 'pd_receive'):
$vrlink = base_url('index.php/payment/chequeReceive?vrnoa='.$feedItem['vrnoa']);
elseif ($feedItem['etype'] === 'pd_issue'):
$vrlink = base_url('index.php/payment/chequeIssue?vrnoa='.$feedItem['vrnoa']);
endif;
$link = str_replace('@vrlink@',$vrlink,$link);
return $link;
}
public function fetchPartyBalances()
{
$to = $_POST['to'];
$party_id = $_POST['party_id'];
$company_id = $_POST['company_id'];
$result = array();
$result['closing'] = $this->walls->fetchPartyClosingBalance($to,$party_id,$company_id);
$json = json_encode($result);
echo $json;
}
public function getFeed()
{
$company_id = $_POST['company_id'];
$page = $_POST['page'];
$feed = $this->walls->getFeed($company_id,$page);
$json = json_encode($feed);
echo $json;
}
public function fetchItemStockValues()
{
unauth_secure();
$to = $_POST['to'];
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$result = array();
$result['closing'] = $this->walls->fetchItemClosingStock($to,$item_id,$company_id);
$json = json_encode($result);
echo $json;
}


}
?>