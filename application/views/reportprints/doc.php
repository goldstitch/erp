

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Doc extends CI_Controller 
{
function __construct()
{
parent::__construct();
$this->load->library('pdf');
$this->pdf->fontpath = 'font';
$this->load->model('accounts');
$this->load->model('ledgers');
$this->load->model('payments');
$this->load->model('purchases');
$this->load->model('stocks');
$this->load->model('items');
$this->load->model('orders');
$this->load->model('workorders');
$this->load->model('itemmaterials');
$this->load->model('orderitemmaterials');
$this->load->model('exportvr');
}
public function convert_number_to_words($number) {
$hyphen      = '-';
$conjunction = ' and ';
$separator   = ', ';
$negative    = 'negative ';
$decimal     = ' point ';
$dictionary  = array(
0                   =>'zero',
1                   =>'one',
2                   =>'two',
3                   =>'three',
4                   =>'four',
5                   =>'five',
6                   =>'six',
7                   =>'seven',
8                   =>'eight',
9                   =>'nine',
10                  =>'ten',
11                  =>'eleven',
12                  =>'twelve',
13                  =>'thirteen',
14                  =>'fourteen',
15                  =>'fifteen',
16                  =>'sixteen',
17                  =>'seventeen',
18                  =>'eighteen',
19                  =>'nineteen',
20                  =>'twenty',
30                  =>'thirty',
40                  =>'fourty',
50                  =>'fifty',
60                  =>'sixty',
70                  =>'seventy',
80                  =>'eighty',
90                  =>'ninety',
100                 =>'hundred',
1000                =>'thousand',
1000000             =>'million',
1000000000          =>'billion',
1000000000000       =>'trillion',
1000000000000000    =>'quadrillion',
1000000000000000000 =>'quintillion'
);
if (!is_numeric($number)) {
return false;
}
if (($number >= 0 &&(int) $number <0) ||(int) $number <0 -PHP_INT_MAX) {
trigger_error(
'convert_number_to_words only accepts numbers between -'.PHP_INT_MAX .' and '.PHP_INT_MAX,
E_USER_WARNING
);
return false;
}
if ($number <0) {
return $negative .convert_number_to_words(abs($number));
}
$string = $fraction = null;
if (strpos($number,'.') !== false) {
list($number,$fraction) = explode('.',$number);
}
switch (true) {
case $number <21:
$string = $dictionary[$number];
break;
case $number <100:
$tens   = ((int) ($number / 10)) * 10;
$units  = $number %10;
$string = $dictionary[$tens];
if ($units) {
$string .= $hyphen .$dictionary[$units];
}
break;
case $number <1000:
$hundreds  = $number / 100;
$remainder = $number %100;
$string = $dictionary[$hundreds] .' '.$dictionary[100];
if ($remainder) {
$string .= $conjunction .$this->convert_number_to_words($remainder);
}
break;
default:
$baseUnit = pow(1000,floor(log($number,1000)));
$numBaseUnits = (int) ($number / $baseUnit);
$remainder = $number %$baseUnit;
$string = $this->convert_number_to_words($numBaseUnits) .' '.$dictionary[$baseUnit];
if ($remainder) {
$string .= $remainder <100 ?$conjunction : $separator;
$string .= $this->convert_number_to_words($remainder);
}
break;
}
if (null !== $fraction &&is_numeric($fraction)) {
$string .= $decimal;
$words = array();
foreach (str_split((string) $fraction) as $number) {
$words[] = $dictionary[$number];
}
$string .= implode(' ',$words);
}
return $string;
}
public function pdf_doublecheque( $etype,$vrnoa,$company_id )
{
$this->load->library( 'wkhtmltopdf');
$data = array();
if ( !$etype ) {
redirect('user/dashboard');
}
$vr = $this->accounts->fetchChequeVoucher( $vrnoa,$etype,$company_id );
$data['vrdetail'] = $vr[0];
$data['title'] = ( $etype === 'pd_issue') ?'Cheque Issue': 'Cheque Received';
if ( empty($data['vrdetail']) ) {
redirect('user/dashboard');
}
$data['header_img'] = base_url('application/assets/uploads/header_imgs/'.$this->session->userdata('header_img'));
$this->wkhtmltopdf->addPage($this->load->view('reportPrints/doublecheque_pdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'landscape'
));
$this->wkhtmltopdf->send();
}
public function send_mail( $filePath,$subject,$message )
{
$configs = array(
'protocol'=>'smtp',
'smtp_host'=>'server1.alnaharsolutions.co.uk',
'smtp_user'=>'info@afaqtraders.com',
'smtp_pass'=>"info@afaqtraders",
'smtp_port'=>'465'
);
$this->load->library("email",$configs);
$this->email->set_newline("\r\n");
$this->email->to("arshadfarouq@hotmail.com");
$this->email->from("info@afaqtraders.com","Afaq Traders");
$this->email->subject( $subject );
$this->email->message( $message );
$this->email->attach( $filePath );
if($this->email->send())
{
}
else
{
}
}
public function Account_Flow( $dt1 ,$dt2,$party_id ,$company_id,$email_pdf = -1,$user_print )
{
$this->load->library('wkhtmltopdf');
$data = array();
$balData = $this->accounts->fetchOpeningBalance_Accounts($dt1,$party_id,$company_id );
$data['previousBalance'] = $balData[0]['OPENING_BALANCE'];
$pledger_1=$this->accounts->Account_Flow($dt1,$dt2,$party_id ,$company_id);
$data['pledger'] = $pledger_1;
$data['title'] = 'Account Flow Statement';
$data['user'] = $user_print;
$date_between= (string)$dt1 .' To '.(string)$dt2;
$data['date_between']=$date_between;
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
$this->wkhtmltopdf->addPage($this->load->view('reportprints/AccountFlowPdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function pdf_TrialBalance6( $dt1 ,$dt2 ,$company_id,$email_pdf = -1,$user_print,$l1,$l2,$l3 )
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['pledger'] = $this->accounts->fetchTrialBalanceData6($dt1,$dt2,$company_id,$l1,$l2,$l3);
$data['title'] = 'Trial Balance';
$data['user'] = $user_print;
$date_between= (string)$dt1 .' To '.(string)$dt2;
$data['date_between']=$date_between;
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
$this->wkhtmltopdf->addPage($this->load->view('reportprints/TrialBalancePdf6',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait',
'margin-left'=>'5',
'margin-right'=>'5'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function pdf_TrialBalance( $dt1 ,$dt2 ,$company_id,$email_pdf = -1,$user_print,$l1,$l2,$l3 )
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['pledger'] = $this->accounts->fetchTrialBalanceData6($dt1,$dt2,$company_id,$l1,$l2,$l3);
$data['title'] = 'Trial Balance';
$data['user'] = $user_print;
$date_between= (string)$dt1 .' To '.(string)$dt2;
$data['date_between']=$date_between;
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
$this->wkhtmltopdf->addPage($this->load->view('reportprints/TrailBalance2Col',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait',
'margin-left'=>'5',
'margin-right'=>'5'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function Stock_Pdf( $dt1 ,$dt2 ,$what ,$company_id,$email_pdf = -1,$user_print,$hd )
{
$this->load->library('wkhtmltopdf');
$data = array();
$bdate =$this->stocks->fetchStockReport($dt1,$dt2,$what,$company_id);
$data['vrdetail'] = $bdate;
$data['what']=$what;
$data['title'] = 'Stock Report';
$data['user'] = $user_print;
$date_between= (string)$dt1 .' To '.(string)$dt2;
$data['date_between']=$date_between;
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = '';
}
$this->wkhtmltopdf->addPage($this->load->view('reportprints/Stock_Pdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function vouchers_reports_pdf( $dt1 ,$dt2 ,$etype,$company_id,$email_pdf = -1,$user_print )
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['vrdetail'] = $this->purchases->fetchPurchaseReportData($dt1,$dt2,'voucher','detailed',$company_id ,$etype);
if ($etype=='purchase'){
$data['title'] = 'Purchase Report';
}elseif ($etype=='purchasereturn') {
$data['title'] = 'Purchase Return Report';
}elseif ($etype=='sale') {
$data['title'] = 'Sale Report';
}elseif ($etype=='salereturn') {
$data['title'] = 'Sale Return Report';
}
$data['user'] = $user_print;
$date_between= (string)$dt1 .' To '.(string)$dt2;
$data['date_between']=$date_between;
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
$this->wkhtmltopdf->addPage($this->load->view('reportprints/vouchers_reports_pdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function Item_Ledger_Pdf( $dt1 ,$dt2 ,$item_id,$company_id,$email_pdf = -1,$user_print,$pid )
{
$this->load->library('wkhtmltopdf');
$data = array();
$company_id= str_replace('-',',',$company_id);
if($company_id==0){
$crit ='';
}else{
$crit ="AND m.company_id in (".$company_id .") ";
}
$data['vrdetail'] = $this->items->fetchItemLedgerReport($dt1,$dt2,$item_id ,$crit,$pid);
$data['title'] = 'Item Ledger Report';
$data['user'] = $user_print;
$date_between= (string)$dt1 .' To '.(string)$dt2;
$data['date_between']=$date_between;
$data['date_start']=(string)$dt1;
$openingStock = $this->items->fetchItemOpeningStock($dt1,$item_id,$crit,$pid);
$data['OpeningQty']=$openingStock[0]['OPENING_QTY'];
$data['OpeningWeight']=$openingStock[0]['OPENING_WEIGHT'];
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
$this->wkhtmltopdf->addPage($this->load->view('reportprints/ItemLedgerPdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function pdf_ledger( $dt1 ,$dt2 ,$party_id,$company_id,$email_pdf = -1,$user_print )
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['pledger'] = $this->ledgers->getAccLedgerReport22($dt1 ,$dt2 ,$party_id ,$company_id);
$data['title'] = 'Account Ledger';
$data['user'] = $user_print;
$date_between= (string)$dt1 .' To '.(string)$dt2;
$data['date_between']=$date_between;
$balData = $this->accounts->fetchOpeningBalance_Accounts($dt1,$party_id,$company_id );
$data['previousBalance'] = $balData[0]['OPENING_BALANCE'];
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
$this->wkhtmltopdf->addPage($this->load->view('reportprints/acc_ledger',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function pdf_singlecheque( $etype,$vrnoa,$company_id,$email_pdf,$user_print,$hd=0 )
{
$this->load->library( 'wkhtmltopdf');
$data = array();
$vr=$this->accounts->fetchChequeVoucher( $vrnoa,$etype,$company_id );
$data['pos_pd_cheque'] = $vr[0];
$data['title'] = ( $etype === 'pd_issue') ?'Cheque Issue': 'Cheque Received';
$data['user'] = $user_print;
$data['amtInWords'] = $this->convert_number_to_words( intval($data['pos_pd_cheque']['amount']) );
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = base_url('assets/img/blank.png/'.$this->session->userdata('header_img'));
}
$this->wkhtmltopdf->addPage($this->load->view('reportprints/ChequePdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
$this->wkhtmltopdf->send();
}
public function genVoucherPdf( $etype,$vrnoa,$company_id,$email_pdf = -1 )
{
$filename =  "Voucher-".date("Y-m-d_H-i-s") .".pdf";
$save_path = $_SERVER['DOCUMENT_ROOT'] .'/application/assets/documents/'.$filename;
$generator = base_url("index.php/doc/$etype/$vrnoa/$company_id/$email_pdf");
exec("wkhtmltopdf64 $generator $save_path");
$pdf = file_get_contents($save_path);
header('Content-Type: application/pdf');
header('Cache-Control: public, must-revalidate, max-age=0');
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Length: '.strlen($pdf));
header('Content-Disposition: inline; filename="'.basename($save_path).'";');
ob_clean();
}
public function Print_Order_Voucher( $etype,$vrnoa,$company_id,$email_pdf = -1,$user,$pre_bal_print ,$hd=1 ,$prnt='lg',$wrate='',$account)
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['vrdetail'] = $this->orders->fetch($vrnoa,$etype,$company_id);
if ($etype=='pur_order'){
$data['title'] = 'Purchase Order';
}elseif ($etype=='purchase') {
$data['title'] = 'Purchase Invoice';
}elseif ($etype=='venderscontract') {
$data['title'] = 'Stitcher Contract';
}elseif ($etype=='stitchingcontract') {
$data['title'] = 'Stitching Contract';
}elseif ($etype=='purchasereturn') {
$data['title'] = 'Purchase Return';
}elseif ($etype=='sale_order') {
$data['title'] = 'Sale Order';
}elseif ($etype=='sale') {
$data['title'] = 'Sale Invoice';
}elseif ($etype=='order_parts') {
$data['title'] = 'Parts Detail';
}elseif ($etype=='order_loading') {
$data['title'] = 'Gate Pass';
}elseif ($etype=='yarnPurchase') {
$data['title'] = 'Yarn Purchase Voucher';
}elseif ($etype=='fabricPurchase') {
$data['title'] = 'Fabric Purchase Voucher';
}elseif ($etype=='yarnPurchaseContract') {
$data['title'] = 'Yarn Purchase Contract';
}elseif ($etype=='fabricPurchaseContract') {
$data['title'] = 'Fabric Purchase Contract';
}elseif ($etype=='order_loading') {
$data['title'] = 'Inward Voucher';
}elseif ($etype=='inward') {
$data['title'] = 'Inward Gate Pass';
}elseif ($etype=='outward') {
$data['title'] = 'Outward Gate Pass';
}elseif ($etype=='glovescontract') {
$data['title'] = 'Glove Contract';
}
$data['pre_bal_print']=$pre_bal_print;
$data['user']=$user;
$data['hd']=$hd;
$data['prnt']=$prnt;
$data['etype']=$etype;
$data['check']=1;
$balData = $this->accounts->fetchOpeningBalance_Accounts($data['vrdetail'][0]['vrdate'],intval($data['vrdetail'][0]['party_id']),$company_id );
$data['previousBalance'] = $balData[0]['OPENING_BALANCE'];
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = base_url('assets/img/blank.png/'.$this->session->userdata('header_img'));;
}
if($etype == 'order_parts'||$etype == 'order_loading'||$etype == 'outward'||$etype == 'inward'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucher_ordergp_pdf',$data,true));
}elseif($etype=='purchase'||$etype=='purchasereturn') {
if ($account == 'account') {
$data['vrdetail'] = '';
$data['vrdetail'] = $this->orders->fetchYarnPurchaseAccount($vrnoa,$etype,$company_id);
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseAccountPrint',$data,true));
}else{
if($prnt=='sm'){
if($wrate=='wrate'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucherpurchase_pdfwr_sm',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucherpurchase_pdf_sm',$data,true));
}
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucherpurchase_pdf',$data,true));
}
}
}else{
if($prnt=='sm'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucher_order_pdf_sm',$data,true));
}elseif($prnt=='gst'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/rptSaleInvoiceGst',$data,true));
}elseif($prnt=='comercial'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/rptComercialInvoice',$data,true));
}else{
if($etype=='fabricPurchase'){
if ($account == 'account') {
$data['vrdetail'] = '';
$data['vrdetail'] = $this->orders->fetchYarnPurchaseAccount($vrnoa,$etype,$company_id);
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseAccountPrint',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/fabricPurchaseContract',$data,true));
}
}elseif($etype=='yarnPurchase'){
if ($account == 'account') {
$data['vrdetail'] = '';
$data['vrdetail'] = $this->orders->fetchYarnPurchaseAccount($vrnoa,$etype,$company_id);
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseAccountPrint',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseContract',$data,true));
}
}elseif($etype=='yarnPurchaseContract'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseContract',$data,true));
}elseif ($etype=='fabricPurchaseContract') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/fabricPurchaseContract',$data,true));
}elseif ($etype=='venderscontract') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/vendorscontractvoucher',$data,true));
}elseif ($etype=='stitchingcontract') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/StitchingContractVoucher',$data,true));
}elseif ($etype=='pur_order') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/PurchaseOrderPrint',$data,true));
}elseif ($etype=='glovescontract') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/GlovesContractPrint',$data,true));
}else{
if ($account == 'account') {
$data['vrdetail'] = '';
$data['vrdetail'] = $this->orders->fetchYarnPurchaseAccount($vrnoa,$etype,$company_id);
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseAccountPrint',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucher_order_pdf',$data,true));
}
}
}
}
if($prnt=='comercial'){
$this->load->model('pdffooter');
$footerFileName = $this->pdffooter->generateHtmlFile('',$data['vrdetail'][0]['foot_note'],"without_signature");
$headerFileName = $this->pdffooter->generateHtmlFileHeader();
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'Portrait',
'page-size'=>'Letter',
'footer-spacing'=>'5.0',
'header-spacing'=>'5.0',
'footer-html'=>base_url () .'assets/temppdffooter/'.$footerFileName,
'header-html'=>base_url () .'assets/temppdffooter/'.$headerFileName,
'margin-left'=>'3',
'margin-right'=>'3'
));
}else if($etype=='glovescontract'){
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'landscape',
'margin-left'=>'5',
'margin-right'=>'5'
));
}else{
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
}
if($prnt=='comercial'){
$this->load->model('pdffooter');
$footerFileName = $this->pdffooter->generateHtmlFile('',$data['vrdetail'][0]['foot_note']);
$headerFileName = $this->pdffooter->generateHtmlFileHeader();
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'Portrait',
'page-size'=>'Letter',
'footer-spacing'=>'5.0',
'header-spacing'=>'5.0',
'footer-html'=>base_url () .'assets/temppdffooter/'.$footerFileName,
'header-html'=>base_url () .'assets/temppdffooter/'.$headerFileName,
'margin-left'=>'3',
'margin-right'=>'3'
));
}else{
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
}
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
$this->pdffooter->deleteTempFile($footerFileName);
$this->pdffooter->deleteTempFile($headerFileName);
}
public function Item_Required_Material_Print( $etype,$vrnoa,$company_id,$email_pdf = -1,$user,$pre_bal_print ,$hd=1 ,$prnt='lg',$wrate='')
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['vrdetail'] =$this->orderitemmaterials->fetch($vrnoa,$etype,$company_id);
if ($etype=='item_required'){
$data['title'] = 'Order Required Material';
}
$data['pre_bal_print']=$pre_bal_print;
$data['user']=$user;
$data['hd']=$hd;
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = base_url('assets/img/blank.png/'.$this->session->userdata('header_img'));
}
$this->wkhtmltopdf->addPage($this->load->view('reportprints/item_required_material_pdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function Print_Order_VoucherPerforma( $etype,$vrnoa,$company_id,$email_pdf = -1,$user,$pre_bal_print ,$hd=1 ,$header)
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['vrdetail'] = $this->orders->fetch($vrnoa,$etype,$company_id);
if($etype=='sale_order') {
$data['title'] = 'Sale Order';
}
$data['pre_bal_print']=$pre_bal_print;
$data['user']=$user;
$data['hd']=$hd;
$data['header']=$header;
$balData = $this->accounts->fetchOpeningBalance_Accounts($data['vrdetail'][0]['vrdate'],intval($data['vrdetail'][0]['party_id']),$company_id );
$data['previousBalance'] = $balData[0]['OPENING_BALANCE'];
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = base_url('assets/img/blank.png/'.$this->session->userdata('header_img'));
}
$this->load->model('pdffooter');
$footerFileName = $this->pdffooter->generateHtmlFile($data['vrdetail'][0]['party_name'],$data['vrdetail'][0]['foot_note']);
$headerFileName = $this->pdffooter->generateHtmlFileHeader();
if ($header === 'header'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucher_orderPerforma_pdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'Portrait',
'page-size'=>'Letter',
'footer-spacing'=>'5.0',
'header-spacing'=>'5.0',
'footer-html'=>base_url () .'assets/temppdffooter/'.$footerFileName,
'header-html'=>base_url () .'assets/temppdffooter/'.$headerFileName,
'margin-left'=>'3',
'margin-right'=>'3'
));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/ProductionPlan',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'landscape'
));
}
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
$this->pdffooter->deleteTempFile($footerFileName);
$this->pdffooter->deleteTempFile($headerFileName);
}
public function Print_OrderPurchase_Voucher( $etype,$vrnoa,$company_id,$email_pdf = -1,$user,$pre_bal_print ,$hd=1 )
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['vrdetail'] = $this->orders->fetch($vrnoa,$etype,$company_id);
if ($etype=='purchase') {
$data['title'] = 'Requisition ';
}elseif ($etype=='requisition') {
$data['title'] = 'Requisition ';
}
$data['pre_bal_print']=$pre_bal_print;
$data['user']=$user;
$data['hd']=$hd;
$balData = $this->accounts->fetchOpeningBalance_Accounts($data['vrdetail'][0]['vrdate'],intval($data['vrdetail'][0]['party_id']),$company_id );
$data['previousBalance'] = $balData[0]['OPENING_BALANCE'];
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = '';
}
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucher_orderPurchase_pdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function Print_WorkOrder( $etype,$vrnoa,$company_id,$email_pdf = -1,$user,$pre_bal_print ,$hd=1 )
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['vrdetail'] = $this->workorders->fetch($vrnoa,$etype,$company_id);
if ($etype =='work_order') {
$data['title'] = 'Work Order ';
}
$data['pre_bal_print']=$pre_bal_print;
$data['user']=$user;
$data['hd']=$hd;
$balData = $this->accounts->fetchOpeningBalance_Accounts($data['vrdetail'][0]['vrdate'],intval($data['vrdetail'][0]['party_id']),$company_id );
$data['previousBalance'] = $balData[0]['OPENING_BALANCE'];
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = '';
}
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucher_WorkOrder_pdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function Print_Voucher( $etype,$vrnoa,$company_id,$email_pdf = -1,$user,$pre_bal_print ,$hd=1,$prnt='lg',$wrate='1',$account )
{
$this->load->library('wkhtmltopdf');
$data = array();
if ($etype=='purchase'){
$data['title'] = 'Purchase Invoice';
}elseif ($etype=='purchasereturn') {
$data['title'] = 'Purchase Return Invoice';
}elseif ($etype=='venderscontract') {
$data['title'] = 'Stitcher Contract';
}elseif ($etype=='sale') {
$data['title'] = 'Sale Invoice';
}elseif ($etype=='salereturn') {
$data['title'] = 'Sale Return Invoice';
}elseif ($etype=='moulding') {
$data['title'] = 'Moulding Sheet';
}elseif ($etype=='navigation') {
$data['title'] = 'Stock Navigation';
}elseif ($etype=='production') {
$data['title'] = 'Production Voucher';
}elseif ($etype=='stocktransfer') {
$data['title'] = 'Stock Transfer';
}elseif ($etype=='issuetovenders') {
$data['title'] = 'Issue To Stitcher';
}elseif ($etype=='issuetovenders') {
$data['title'] = 'Issue To Stitcher';
}elseif ($etype=='settelment') {
$data['title'] = 'Settelment Stitcher';
}elseif ($etype=='receivefromvenders') {
$data['title'] = 'Receive From Stitcher';
}elseif ($etype=='rejection') {
$data['title'] = 'Rejection Stitcher';
}elseif ($etype=='inward') {
$data['title'] = 'Inward Gate Pass';
}elseif ($etype=='outward') {
$data['title'] = 'Outward Gate Pass';
}
$data['pre_bal_print']=$pre_bal_print;
$data['user']=$user;
$data['hd']=$hd;
$data['etype']=$etype;
$data['check']= 1;
if($etype=='navigation'){
$data['vrdetail'] = $this->purchases->fetchNavigation($vrnoa,$etype,$company_id);
$balData = 0;
$data['previousBalance'] = 0;
$data['amtInWords'] = '';
}elseif($etype=='production'){
$data['vrdetail'] = $this->purchases->fetchByProductionVoucher($vrnoa,'production',$company_id);
$balData = 0;
$data['previousBalance'] = 0;
$data['amtInWords'] = '';
}elseif($etype=='stocktransfer'){
$data['vrdetail'] = $this->purchases->fetchNavigation($vrnoa,$etype,$company_id);
$balData = 0;
$data['previousBalance'] = 0;
$data['amtInWords'] = '';
}elseif($etype=='issuetovenders'||$etype=='receivefromvenders'||$etype=='rejection'){
$data['vrdetail'] = $this->purchases->fetchVoucher($vrnoa,$etype,$company_id);
$balData = 0;
$data['previousBalance'] = 0;
$data['amtInWords'] = '';
}elseif( $etype=='settelment'){
$data['vrdetail'] = $this->purchases->fetchVoucher($vrnoa,$etype,$company_id);
$data['main'] = $this->purchases->fetch_stichmain($vrnoa,$etype ,$company_id);
$balData = 0;
$data['previousBalance'] = 0;
$data['amtInWords'] = '';
}elseif($etype=='inward'||$etype=='outward'){
$data['vrdetail'] = $this->purchases->fetchVoucher( $vrnoa,$etype,$company_id);
$balData = $this->accounts->fetchOpeningBalance_Accounts($data['vrdetail'][0]['vrdate'],intval($data['vrdetail'][0]['party_id']),$company_id );
$data['previousBalance'] = $balData[0]['OPENING_BALANCE'];
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
}else{
$data['vrdetail'] = $this->orders->fetchVoucher( $vrnoa,$etype,$company_id);
$balData = $this->accounts->fetchOpeningBalance_Accounts($data['vrdetail'][0]['vrdate'],intval($data['vrdetail'][0]['party_id']),$company_id );
$data['previousBalance'] = $balData[0]['OPENING_BALANCE'];
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
}
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = base_url('assets/img/blank.png/'.$this->session->userdata('header_img'));;
}
if ($etype=='moulding') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/moulding_sheet_pdf',$data,true));
}elseif($etype=='navigation') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/StockNavigation',$data,true));
}elseif($etype=='production') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/ProductionVoucher',$data,true));
}elseif($etype=='stocktransfer') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/StockTransferVoucher',$data,true));
}elseif($etype=='issuetovenders'||$etype=='receivefromvenders'||$etype=='rejection') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/IssueToVender',$data,true));
}elseif( $etype=='settelment') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/SettelmentVender',$data,true));
}elseif($etype=='outward'||$etype=='inward') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/vocher_pdf_sm2',$data,true));
}elseif($etype=='venderscontract') {
$this->wkhtmltopdf->addPage($this->load->view('reportprints/vocher_pdf_sm2',$data,true));
}else {
if($prnt=='sm'){
if($wrate=='wrate'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/vocher_pdf_sm2',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/vocher_pdf_sm',$data,true));
}
}else{
if ($account == 'account') {
$data['vrdetail'] = '';
$data['vrdetail'] = $this->orders->fetchYarnPurchaseAccount($vrnoa,$etype,$company_id);
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseAccountPrint',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/voucher_pdf',$data,true));
}
}
}
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function Item_Material_Print( $etype,$vrnoa,$company_id,$email_pdf = -1,$user,$pre_bal_print ,$hd=1,$prnt='lg',$wrate='')
{
$this->load->library('wkhtmltopdf');
$data = array();
if ($etype=='item_material'){
$data['title'] = 'Item Material';
}
$data['pre_bal_print']=$pre_bal_print;
$data['user']=$user;
$data['hd']=$hd;
$data['vrdetail'] = $this->itemmaterials->fetch($vrnoa,$etype ,$company_id);
$data['previousBalance'] = '';
$data['amtInWords'] = '';
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = '';
}
$this->wkhtmltopdf->addPage($this->load->view('reportprints/item_material_pdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function print_pro_voucher( $etype,$vrnoa,$company_id,$email_pdf = -1,$user,$pre_bal_print ,$hd=1 )
{
$this->load->library('wkhtmltopdf');
$data = array();
if ($etype=='production'){
$data['title'] = 'Production Voucher';
}elseif ($etype=='consumption') {
$data['title'] = 'Issuance Voucher';
}elseif ($etype=='materialreturn') {
$data['title'] = 'Material Return Voucher';
}
$data['pre_bal_print']=$pre_bal_print;
$data['user']=$user;
$data['hd']=$hd;
$data['vrdetail'] = $this->purchases->fetch($vrnoa,$etype,$company_id);
$balData = 0;
$data['previousBalance'] = 0;
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );;
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = base_url('assets/img/blank.png/'.$this->session->userdata('header_img'));;
}
$this->wkhtmltopdf->addPage($this->load->view('reportprints/print_pro_voucher',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function pdf_singlevoucher( $etype,$vrnoa,$company_id,$email_pdf = -1 )
{
$this->load->library('wkhtmltopdf');
$data = array();
if ( !$etype ) {
redirect('user/dashboard');
}else if ( $etype == 'sale') {
$data['vrdetail'] = $this->purchases->fetch( $vrnoa,$company_id );
$data['title'] = 'Sale';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'purchase') {
$data['vrdetail'] = $this->purchases->fetchVoucher( $vrnoa,$company_id );
$data['title'] = 'Purchase';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'purchasereturn') {
$data['vrdetail'] = $this->purchasereturns->fetchVoucher( $vrnoa,$company_id );
$data['title'] = 'Purchase Return';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'purchaseorder') {
$data['vrdetail'] = $this->purchases->fetchOrderVoucher( $vrnoa,$company_id );
$data['title'] = 'Purchase Order';
$etype = 'quotation';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'salereturn') {
$data['vrdetail'] = $this->salereturns->fetchVoucher( $vrnoa,$company_id );
$data['title'] = 'Sale Return';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'saleorder') {
$data['vrdetail'] = $this->sales->fetchOrderVoucher( $vrnoa,$company_id );
$data['title'] = 'Sale Quotation';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}
$data['header_img'] = base_url('application/assets/uploads/header_imgs/'.$this->session->userdata('header_img'));
$this->wkhtmltopdf->addPage($this->load->view('reportPrints/voucher_pdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function JvVocuherPrintPdf( $etype,$vrnoa,$company_id,$email_pdf = -1,$user_print,$pr=0,$account )
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['pledger'] = $this->ledgers->fetch($vrnoa,$etype,$company_id );
$tot = $this->ledgers->fetch_total($vrnoa,$etype,$company_id );
if ($etype == 'brv') {
$data['title'] = 'Bank Receive Voucher';
}else if( $etype == 'bpv'){
$data['title'] = 'Bank Payment Voucher';
}else if( $etype == 'jv'){
$data['title'] = 'Journal Voucher';
}
$data['etype'] = $etype;
$data['user'] = $user_print;
$data['pre_bal_print']= 0;
$data['check']= 0;
$data['amtInWords'] = $this->convert_number_to_words(intval($tot[0]['debit']) );
if ($pr==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = base_url('assets/img/blank.png/'.$this->session->userdata('header_img'));
}
if ($etype == 'bpv'||$etype == 'brv') {
if ($account == 'account') {
$data['vrdetail'] = '';
$data['vrdetail'] = $this->orders->fetchYarnPurchaseAccount($vrnoa,$etype,$company_id);
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseAccountPrint',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/BpvVoucherPrintPdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
}
}else{
if ($account == 'account') {
$data['vrdetail'] = '';
$data['vrdetail'] = $this->orders->fetchYarnPurchaseAccount($vrnoa,$etype,$company_id);
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseAccountPrint',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/JvVoucherPrintPdf',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
}
}
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function CashVocuherPrintPdf( $etype,$vrnoa,$company_id,$email_pdf = -1,$user_print,$pr=1  ,$prnt='lg',$account)
{
$this->load->library('wkhtmltopdf');
$data = array();
$data['pledger'] = $this->ledgers->fetch($vrnoa,$etype,$company_id );
if ($etype =='cpv'){
$data['title'] = 'Cash Payment Voucher';
}
else
{
$data['title'] = 'Cash Receipt Voucher';
}
$data['etype'] = $etype;
$data['user'] = $user_print;
$data['pre_bal_print']= 0;
$data['check']= 0;
if ($pr==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = base_url('assets/img/blank.png/'.$this->session->userdata('header_img'));
}
if ($account == 'account') {
$data['vrdetail'] = '';
$data['vrdetail'] = $this->orders->fetchYarnPurchaseAccount($vrnoa,$etype,$company_id);
$this->wkhtmltopdf->addPage($this->load->view('reportprints/yarnPurchaseAccountPrint',$data,true));
}else{
if ($prnt=='sm'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/paymentsm',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/CashVoucherPrintPdf',$data,true));
}
}
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
}
public function pdf_doublevoucher( $etype,$vrnoa,$company_id )
{
$this->load->library('wkhtmltopdf');
$data = array();
if ( !$etype ) {
redirect('user/dashboard');
}else if ( $etype == 'sale') {
$data['vrdetail'] = $this->sales->fetchVoucher( $vrnoa,$company_id );
$data['title'] = 'Sale';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'purchase') {
$data['vrdetail'] = $this->purchases->fetchVoucher( $vrnoa,$company_id );
$data['title'] = 'Purchase';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'purchasereturn') {
$data['vrdetail'] = $this->purchasereturns->fetchVoucher( $vrnoa,$company_id );
$data['title'] = 'Purchase Return';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'purchaseorder') {
$data['vrdetail'] = $this->purchases->fetchOrderVoucher( $vrnoa,$company_id );
$data['title'] = 'Purchase Quotation';
$etype = 'quotation';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'salereturn') {
$data['vrdetail'] = $this->salereturns->fetchVoucher( $vrnoa,$company_id );
$data['title'] = 'Sale Return';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}else if ( $etype == 'saleorder') {
$data['vrdetail'] = $this->sales->fetchOrderVoucher( $vrnoa,$company_id );
$data['title'] = 'Quotation';
if (empty($data['vrdetail'])) {
redirect('user/dashboard');
}
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
$balData = $this->accounts->fetchPreviousBalance($data['vrdetail'][0]['vrdate'],$data['vrdetail'][0]['smainpid'],$data['vrdetail'][0]['vrnoa'],$company_id,$etype);
$data['previousBalance'] = $balData[0]['RTotal'];
}
$data['header_img'] = base_url('application/assets/uploads/header_imgs/'.$this->session->userdata('header_img'));
$this->wkhtmltopdf->addPage($this->load->view('reportPrints/doublevoucher_pdf2',$data,true));
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'landscape'
));
$this->wkhtmltopdf->send();
}
public function tcpdf()
{
$this->load->helper('pdf_helper');
$this->load->view('pdfvr');
}
public function mpdf()
{
$filename = 'first_file';
$pdfFilePath = FCPATH."/downloads/reports/$filename.pdf";
$data['page_title'] = 'Hello world';
if (file_exists($pdfFilePath) == FALSE)
{
ini_set('memory_limit','32M');
$html = $this->load->view('reportPrints/pdfvoucher.php',$data,true);
$this->load->library('my_mpdf');
$pdf = $this->my_mpdf->load();
$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
$pdf->WriteHTML($html);
$pdf->Output($pdfFilePath,'I');
}
}
public function voucher($etype,$vrnoa)
{
$company_id = $this->session->userdata('company_id');
$vrDetail = $this->sales->fetchVoucher( $vrnoa,$company_id );
$this->pdf->AddPage('P','A4');
$this->pdf->SetFont('Arial','B',16);
$this->pdf->Image(base_url('application/assets/img/logos/logo1.png'),150,10,50);
$this->pdf->ln();
$this->pdf->SetFont('Arial','B',11);
$this->pdf->Cell(25,10,'Inv#');
$this->pdf->SetFont('Arial','',11);
$this->pdf->Cell(25,10,$vrDetail[0]['vrnoa']);
$this->pdf->ln(6);
$this->pdf->SetFont('Arial','B',11);
$this->pdf->Cell(25,10,'Date');
$this->pdf->SetFont('Arial','',11);
$this->pdf->Cell(25,10,$vrDetail[0]['vrdate']);
$this->pdf->ln(6);
$this->pdf->SetFont('Arial','B',11);
$this->pdf->Cell(25,10,'Customer');
$this->pdf->SetFont('Arial','',11);
$this->pdf->Cell(25,10,$vrDetail[0]['custparty'] .' / '.$vrDetail[0]['custname']);
$this->pdf->ln(6);
$this->pdf->SetFont('Arial','B',11);
$this->pdf->Cell(25,10,'Mobile');
$this->pdf->SetFont('Arial','',11);
$this->pdf->Cell(25,10,$vrDetail[0]['custmobile']);
$this->pdf->SetFont('Arial','B',20);
$this->pdf->Cell(0,10,'Sale',0,0,'R');
$this->pdf->ln(15);
$this->pdf->SetFont('Arial','B',9);
$this->pdf->Cell(7,7,'#',1,0,'C');
$this->pdf->Cell(122,7,'Item',1,0,'C');
$this->pdf->Cell(15,7,'Qty',1,0,'C');
$this->pdf->Cell(15,7,'Rate',1,0,'C');
$this->pdf->Cell(30,7,'Amount',1,0,'C');
$this->pdf->ln(7);
foreach ($vrDetail as $row) {
$this->pdf->SetFont('Arial','',9);
$this->pdf->Cell(7,20,'1',1,0,'L');
$this->pdf->Cell(122,7,trim($row['description']),1,0,'L');
$this->pdf->Cell(15,20,trim($row['qty']),1,0,'R');
$this->pdf->Cell(15,20,trim($row['rate']),1,0,'R');
$this->pdf->Cell(30,20,trim($row['amount']),1,0,'R');
$this->pdf->ln(7);
$this->pdf->setX(17);
$this->pdf->Cell(122,7,trim($row['specs']),1,0,'L');
$this->pdf->ln(7);
$this->pdf->setX(17);
$this->pdf->Cell(122,6,trim($row['serial']),1,0,'L');
$this->pdf->ln(7);
}
$this->pdf->ln(7);
$this->pdf->SetFont('Arial','B',9);
$this->pdf->Cell(30,7,'In words: ');
$this->pdf->SetFont('Arial','',9);
$this->pdf->Cell(100,7,'Seven thousand seven hundred point zero zero only.');
$this->pdf->Cell(0,7,'|||||||',0,0,'R');
$this->pdf->ln(5);
$this->pdf->SetFont('Arial','B',9);
$this->pdf->Cell(30,7,'Prev Balance: ');
$this->pdf->SetFont('Arial','',9);
$this->pdf->Cell(100,7,'12,122,122/=');
$this->pdf->ln(15);
$this->pdf->Cell(47,7,'Prepared By','T',0,'C');
$this->pdf->Cell(20,7,' ',0,0,'C');
$this->pdf->Cell(48,7,'Accountant','T',0,'C');
$this->pdf->Cell(20,7,' ',0,0,'C');
$this->pdf->Cell(47,7,'Received By','T',0,'C');
$this->pdf->Output();
}
public function sample()
{
$this->pdf->AddPage('P','A4');
$this->pdf->SetFont('Arial','B',16);
$this->pdf->Image(base_url('application/assets/img/logos/logo1.png'),150,10,50);
$this->pdf->ln();
$this->pdf->SetFont('Arial','B',11);
$this->pdf->Cell(25,10,'Inv#');
$this->pdf->SetFont('Arial','',11);
$this->pdf->Cell(25,10,'12');
$this->pdf->ln(6);
$this->pdf->SetFont('Arial','B',11);
$this->pdf->Cell(25,10,'Date');
$this->pdf->SetFont('Arial','',11);
$this->pdf->Cell(25,10,'Apr 16, 2014');
$this->pdf->ln(6);
$this->pdf->SetFont('Arial','B',11);
$this->pdf->Cell(25,10,'Customer');
$this->pdf->SetFont('Arial','',11);
$this->pdf->Cell(25,10,'AA Traders/Asim');
$this->pdf->ln(6);
$this->pdf->SetFont('Arial','B',11);
$this->pdf->Cell(25,10,'Mobile');
$this->pdf->SetFont('Arial','',11);
$this->pdf->Cell(25,10,'0321-1019291');
$this->pdf->SetFont('Arial','B',20);
$this->pdf->Cell(0,10,'Sale',0,0,'R');
$this->pdf->ln(15);
$this->pdf->SetFont('Arial','B',9);
$this->pdf->Cell(7,7,'#',1,0,'C');
$this->pdf->Cell(122,7,'Item',1,0,'C');
$this->pdf->Cell(15,7,'Qty',1,0,'C');
$this->pdf->Cell(15,7,'Rate',1,0,'C');
$this->pdf->Cell(30,7,'Amount',1,0,'C');
$this->pdf->ln(7);
$this->pdf->SetFont('Arial','',9);
$this->pdf->Cell(7,20,'1',1,0,'L');
$this->pdf->Cell(122,7,'Some large item name to go here.',1,0,'L');
$this->pdf->Cell(15,20,'12',1,0,'R');
$this->pdf->Cell(15,20,'120',1,0,'R');
$this->pdf->Cell(30,20,'12,000',1,0,'R');
$this->pdf->ln(7);
$this->pdf->setX(17);
$this->pdf->Cell(122,7,'Specs to go here.',1,0,'L');
$this->pdf->ln(7);
$this->pdf->setX(17);
$this->pdf->Cell(122,6,'Serial to go here.',1,0,'L');
$this->pdf->ln(7);
$this->pdf->SetFont('Arial','B',9);
$this->pdf->Cell(30,7,'In words: ');
$this->pdf->SetFont('Arial','',9);
$this->pdf->Cell(100,7,'Seven thousand seven hundred point zero zero only.');
$this->pdf->Cell(0,7,'|||||||',0,0,'R');
$this->pdf->ln(5);
$this->pdf->SetFont('Arial','B',9);
$this->pdf->Cell(30,7,'Prev Balance: ');
$this->pdf->SetFont('Arial','',9);
$this->pdf->Cell(100,7,'12,122,122/=');
$this->pdf->ln(15);
$this->pdf->Cell(47,7,'Prepared By','T',0,'C');
$this->pdf->Cell(20,7,' ',0,0,'C');
$this->pdf->Cell(48,7,'Accountant','T',0,'C');
$this->pdf->Cell(20,7,' ',0,0,'C');
$this->pdf->Cell(47,7,'Received By','T',0,'C');
$this->pdf->Output();
}
public function Print_Export_Voucher( $etype,$vrnoa,$company_id,$email_pdf = -1,$user,$pre_bal_print ,$hd=1 ,$prnt='lg',$wrate='',$account)
{
$this->load->library('wkhtmltopdf');
$data = array();
if ($etype=='export') {
$data['title'] = 'Export Voucher';
$data['vrdetail'] = $this->exportvr->fetchs($vrnoa,$etype,$company_id);
}
$data['pre_bal_print']=$pre_bal_print;
$data['user']=$user;
$data['hd']=$hd;
$data['prnt']=$prnt;
$data['etype']=$etype;
$data['check']=1;
$footerType = "";
$balData = $this->accounts->fetchOpeningBalance_Accounts($data['vrdetail'][0]['vrdate'],intval($data['vrdetail'][0]['party_id']),$company_id );
$data['previousBalance'] = $balData[0]['OPENING_BALANCE'];
$data['amtInWords'] = $this->convert_number_to_words( intval($data['vrdetail'][0]['namount']) );
if ($hd==1){
$data['header_img'] = base_url('assets/img/pic1.png/'.$this->session->userdata('header_img'));
}else{
$data['header_img'] = base_url('assets/img/blank.png/'.$this->session->userdata('header_img'));;
}
if($prnt=='Packing'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/vouchers_reports_packing',$data,true));
$footerType = "without_signature";
}elseif($prnt=='Commercial'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/vouchers_reports_comercial',$data,true));
$footerType = "without_signature";
}
elseif($prnt=='BL')
{
$data['companyinfo'] = $this->exportvr->getCompanyInfo($company_id);
$this->wkhtmltopdf->addPage($this->load->view('reportprints/vouchers_reports_bl',$data,true));
$footerType = "without_signature";
}
if($prnt=='Commercial'||$prnt=='Packing'||$prnt=='BL'){
$this->load->model('pdffooter');
$footerFileName = $this->pdffooter->generateHtmlFile('',$data['vrdetail'][0]['foot_note'],$footerType);
$headerFileName = $this->pdffooter->generateHtmlFileHeader();
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'Portrait',
'page-size'=>'Letter',
'footer-spacing'=>'5.0',
'header-spacing'=>'5.0',
'footer-html'=>base_url () .'assets/temppdffooter/'.$footerFileName,
'header-html'=>base_url () .'assets/temppdffooter/'.$headerFileName,
'margin-left'=>'3',
'margin-right'=>'3'
));
}
else{
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'portrait'
));
}
if ( $email_pdf == 1 ) {
$save_path = ($_SERVER['DOCUMENT_ROOT'] .'/AfaqTraders/application/assets/documents/'.microtime() .'Voucher.pdf');
$this->wkhtmltopdf->saveAs( $save_path );
sleep(5);
$this->send_mail( $save_path );
}else {
$this->wkhtmltopdf->send();
}
$this->pdffooter->deleteTempFile($footerFileName);
$this->pdffooter->deleteTempFile($headerFileName);
}
public function pdf_salarySheet( $vrno,$etype,$company_id  )
{
$this->load->library('wkhtmltopdf');
$this->load->model('staffs');
$data = array();
$data['vrdetail'] = $this->staffs->fetchSalarySheet( $vrno,$etype,$company_id );
$data['company_name'] = $this->session->userdata['company_name'];
if (empty($data['vrdetail']))
{
redirect('user/dashboard');
}
if($etype=='wages'){
$this->wkhtmltopdf->addPage($this->load->view('reportprints/wagesSheetpdf',$data,true));
}else{
$this->wkhtmltopdf->addPage($this->load->view('reportprints/salarySheetpdf',$data,true));
}
$this->wkhtmltopdf->setOptions(array(
'orientation'=>'landscape',
'footer-center'=>'[page]/[toPage]'
));
$this->wkhtmltopdf->send();
}
}

?>