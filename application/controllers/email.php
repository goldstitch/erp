

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Email extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('send_email');
}
public function index() {
if(isset($_POST)) {
$table = $_POST['table'];
$type = $_POST['type'];
$accTitle = $_POST['accTitle'];
$accCode = $_POST['accCode'];
$contactNo = $_POST['contactNo'];
$address = $_POST['address'];
$from = $_POST['from'];
$to = $_POST['to'];
$email = $_POST['email'];
$headers  = 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$message = "";
if ($type == "Account Ledger Report‏"||$type == "Aging Sheet - Creditors"||$type == "Aging Sheet - Debitors") {
$message = "<div>".
"<p style='margin-bottom: 2px'><span style='font-weight: bold;display: inline-block;width: 80px;'>A/C Title</span><span style='font-family: tahoma;'>".$accTitle ."</span></p>".
"<p style='margin-bottom: 2px'><span style='font-weight: bold;display: inline-block;width: 80px;'>A/C Code</span><span style='font-family: tahoma;'>".$accCode ."</span></p>".
"<p style='margin-bottom: 2px'><span style='font-weight: bold;display: inline-block;width: 80px;'>Address</span><span style='font-family: tahoma;'>".$contactNo ."</span></p>".
"<p style='margin-bottom: 2px'><span style='font-weight: bold;display: inline-block;width: 80px;'>Contact #</span><span style='font-family: tahoma;'>".$contactNo ."</span></p>".
"</div>";
}else if ($type == "Cash Flow Statement"||$type == "Invoice Aging Report - Payables"||$type == "Invoice Aging Report - Receiveables") {
$message = "<div>".
"<p style='margin-bottom: 2px'><span style='font-weight: bold;display: inline-block;width: 80px;'>A/C Title</span><span style='font-family: tahoma;'>".$accTitle ."</span></p>".
"</div>";
}
$message .= "<div style='text-align:center;'>".
"<h3 style='text-align:center;border-bottom: 1px solid black;font-size: 24.5px;line-height: 40px;margin: 10px 0;font-family: inherit;font-weight: bold;padding-bottom: 5px;color: inherit;text-rendering: optimizelegibility;'>".$type ."</h3>".
"<p style='text-align:center;'><span><strong>From:-</strong><span>".$from ."</span></span> To <span><strong>To:-</strong><span>".$to ."</span></span></p>".
"</div>";
$message .= $table;
echo $this->send_email->send($email,$type,$message);
}
}
}

?>