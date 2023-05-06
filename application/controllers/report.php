

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('exportregisters');
$this->load->model('accounts');
$this->load->model('items');
$this->load->model('companies');
$this->load->model('sales');
$this->load->model('staffs');
$this->load->model('stocks');
$this->load->model('payments');
$this->load->model('purchases');
$this->load->model('orders');
$this->load->model('departments');
$this->load->model('users');
$this->load->model('levels');
}
public function PendingInwardSummary() {
unauth_secure();
CheckReportRights("pendinggatepassreport");
$data['modules'] = array('reports/purchase/PendingInwardSummary');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "inward";
$data['currdate'] = date("Y/m/d");
$data['title'] = 'Pending Inward Summary';
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/PendingInwardSummary',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchPendingInward()
{
$endDate = $_POST['to'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$etype2 = $_POST['etype2'];
$report_type = $_POST['report_type'];
$sreportData = $this->purchases->fetchPendingInward($endDate,$company_id,$crit,$etype,$etype2,$report_type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function StockRequired() {
unauth_secure();
$data['etype'] = 'withoutValue';
$data['title'] = 'Stock Required Report';
$data['modules'] = array('reports/inventory/stockOrder');
$data['title'] = 'Stock Required Report';
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/stockOrder',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchStockOrderReport()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$etype = $_POST['etype'];
$sreportData = $this->stocks->fetchStockOrderReport($startDate,$endDate,$what,$company_id,$crit,$etype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function PlsOrder()
{
unauth_secure();
CheckReportRights('plsorder');
$data['modules'] = array('reports/accounts/PlsOrderWise');
$data['Orders'] = $this->orders->FetchOrderNoParty();
$data['title'] = "Order Wise Profit/Loss";
$this->load->view('template/header',$data);
$this->load->view('reports/accounts/PlsOrderWise',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function PlsOrderWise()
{
$wo=$_POST['wo'];
$result = $this->accounts->PlsOrderWise($wo);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchPurchaseReportData_export()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$sreportData = $this->exportregisters->fetchPurchaseReportData_export($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchDisPayRecvCount()
{
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$payrecvreportData = $this->accounts->fetchDisPayRecvCount($company_id,$etype);
$json = json_encode($payrecvreportData);
echo $json;
}
public function ExportRegister() {
$data['modules'] = array('reports/sale/ExportRegisterReport');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Export";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header');
$this->load->view('reports/sale/ExportRegisterReport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function detailedprofitloss()
{
unauth_secure();
$data['wrapper_class'] = "profitloss";
$data['page'] = "profitloss";
$data['currdate'] = date("Y/m/d");
$data['modules'] = array('reports/accounts/detailed_profitloss_report');
$data['parties'] = $this->accounts->fetchAll();
$data['items'] = $this->items->fetchAll();
$data['companies'] = $this->companies->getAll();
$this->load->view('template/header',$data);
$this->load->view('template/mainnav',$data);
$this->load->view('reports/accounts/detailedprofitloss',$data);
$this->load->view('template/footer');
}
public function fetchNetSum_Etype()
{
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$from = $_POST['from'];
$to = $_POST['to'];
$sum = $this->accounts->fetchNetSum_Etype($from,$to,$company_id ,$etype);
$json = json_encode($sum);
echo $json;
}
public function fetchNetWPPF()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$data = $this->accounts->fetchNetWPPF($from,$to,$company_id);
$json = json_encode($data);
echo $json;
}
public function fetchNetPFT()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$data = $this->accounts->fetchNetPFT($from,$to,$company_id);
$json = json_encode($data);
echo $json;
}
public function fetchNetOperatingExpenses()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$data = $this->accounts->fetchNetOperatingExpenses($from,$to,$company_id);
$json = json_encode($data);
echo $json;
}
public function fetchNetExpense()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$data = $this->accounts->fetchNetExpense($from,$to,$company_id);
$json = json_encode($data);
echo $json;
}
public function fetchOtherIncomeSum()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$data = $this->accounts->fetchOtherIncomeSum($from,$to,$company_id);
$json = json_encode($data);
echo $json;
}
public function getIncomeReportData()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$data = $this->accounts->getIncomeReportData($from,$to,$company_id);
$json = json_encode($data);
echo $json;
}
public function getExpenseReportData()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$data = $this->accounts->getExpenseReportData($from,$to,$company_id);
$json = json_encode($data);
echo $json;
}
public function fetchNetFinanceCost()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$data = $this->accounts->fetchNetFinanceCost($from,$to,$company_id);
$json = json_encode($data);
echo $json;
}
public function fetchOpeningStockReportData() 
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$stockRows = $this->accounts->fetchOpeningStockReportData( $from,$to,$company_id );
$json = json_encode($stockRows);
echo $json;
}
public function fetchClosingStockReportData() 
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$stockRows = $this->accounts->fetchClosingStockReportData( $from,$to,$company_id );
$json = json_encode($stockRows);
echo $json;
}
public function fetchBalanceSheet()
{
unauth_secure();
if (isset($_POST)) {
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$company_id = $_POST['company_id'];
$type = $_POST['type'];
$tb_data = $this->accounts->fetchBalanceSheet($startDate,$endDate,$company_id,$type);
$json = json_encode($tb_data);
echo $json;
}
}
public function getAllCheques()
{
$from = $_POST['from'];
$to = $_POST['to'];
$type = $_POST['type'];
$reportData = $this->accounts->getAllCheques($from,$to,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($reportData));
}
public function fetchAgingSheetData()
{
unauth_secure();
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$party_id = $_POST['party_id'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$type = $_POST['type'];
$crit = $_POST['crit'];
$Typee = $_POST['Typee'];
$having_crit = $_POST['having_crit'];
if($Typee=='date'){
$sheetData = $this->accounts->fetchAgingSheetData( $party_id,$company_id,$startDate,$endDate,$type,$crit,$having_crit );
}else{
$sheetData = $this->accounts->fetchAgingSheetData_Balance( $party_id,$company_id,$startDate,$endDate,$type,$crit,$having_crit );
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($sheetData));
}
}
public function fetchOrderSummary()
{
unauth_secure();
if (isset($_POST)) {
$company_id = $_POST['company_id'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$po = $_POST['po'];
$sheetData = $this->accounts->fetchOrderSummary( $company_id,$startDate,$endDate,$po );
$this->output
->set_content_type('application/json')
->set_output(json_encode($sheetData));
}
}
public function agingSheet()
{
unauth_secure();
CheckReportRights('agingSheetReport');
$data['modules'] = array('reports/accounts/agingsheet');
$data['parties'] = $this->accounts->fetchAll(1);
$data['currdate'] = date("Y/m/d");
$data['l3sDebitors'] = $this->levels->fetchAllLevel3_crit('DEBTORS');
$data['l3sCreditors'] = $this->levels->fetchAllLevel3_crit('CREDITORS');
$data['wrapper_class'] = "account_ledger";
$data['page'] = "accountledger";
$data['title'] = "Aging Sheet";
$data['companies'] = $this->companies->getAll();
$this->load->view('template/header',$data);
$this->load->view('reports/accounts/agingsheet',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function OrderSummary()
{
unauth_secure();
$data['modules'] = array('reports/accounts/OrderSummary');
$data['parties'] = $this->accounts->fetchAll(1);
$data['currdate'] = date("Y/m/d");
$data['l3sDebitors'] = $this->levels->fetchAllLevel3_crit('DEBTORS');
$data['l3sCreditors'] = $this->levels->fetchAllLevel3_crit('CREDITORS');
$data['worder'] 	= $this->orders->fetchAllSaleOrder();
$data['wrapper_class'] = "account_ledger";
$data['page'] = "accountledger";
$data['companies'] = $this->companies->getAll();
$data['title'] = "Order Summary Report";
$this->load->view('template/header',$data);
$this->load->view('reports/accounts/OrderSummary',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function OrderStock()
{
unauth_secure();
$data['modules'] = array('reports/inventory/OrderStock');
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['companies'] = $this->companies->getAll();
$data['title'] = "Pending Orders Stock";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/OrderStock',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchVendorBillData()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$reptType = $_POST['reportType'];
$party_id = $_POST['party_id'];
$company_id = $_POST['company_id'];
$crit ='';
if(isset($_POST['crit']))
$crit = $_POST['crit'];
$reportData = $this->purchases->fetchVendorBillData( $from,$to,$reptType,$party_id,$company_id,$crit);
$json = json_encode( $reportData );
echo $json;
}
public function fetchInvoiceAgingData()
{
unauth_secure();
$from = $_POST['from'];
$to = $_POST['to'];
$reptType = $_POST['reportType'];
$party_id = $_POST['party_id'];
$company_id = $_POST['company_id'];
$crit ='';
if(isset($_POST['crit']))
$crit = $_POST['crit'];
$reportData = $this->accounts->fetchInvoiceAgingData( $from,$to,$reptType,$party_id,$company_id,$crit);
$json = json_encode( $reportData );
echo $json;
}
public function invoiceAging()
{
unauth_secure();
$data['modules'] = array('reports/accounts/invoiceaging');
$data['parties'] = $this->accounts->fetchAll(1);
$data['currdate'] = date("Y/m/d");
$data['l3sDebitors'] = $this->levels->fetchAllLevel3_crit('DEBTORS');
$data['l3sCreditors'] = $this->levels->fetchAllLevel3_crit('CREDITORS');
$data['wrapper_class'] = "invoiceAgingSheet";
$data['page'] = "invoiceAgingSheet";
$data['companies'] = $this->companies->getAll();
$data['title'] = "Invoice Aging";
$this->load->view('template/header',$data);
$this->load->view('reports/accounts/invoiceaging',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function issueRecieve() {
unauth_secure();
$data['modules'] = array('reports/inventory/issuereceive');
$data['title'] = "Vendor Stock Report";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/issuereceive',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function issuetoVendor() {
unauth_secure();
$data['modules'] = array('reports/inventory/issuetoVendor');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "itv";
$data['title'] = "Issue To Vendors";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/issuetoVendor',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function receivefromVendor() {
unauth_secure();
$data['modules'] = array('reports/inventory/issuetoVendor');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "rfv";
$data['title'] = "Receive From Vendors";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/issuetoVendor',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function rejectionvendors() {
unauth_secure();
$data['modules'] = array('reports/inventory/issuetoVendor');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "rejection";
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['brands'] = $this->items->fetchAllBrands();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header');
$this->load->view('reports/inventory/issuetoVendor',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function settelmentvendors() {
unauth_secure();
$data['modules'] = array('reports/inventory/issuetoVendor');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "settelment";
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['brands'] = $this->items->fetchAllBrands();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header');
$this->load->view('reports/inventory/issuetoVendor',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function tr_consume() {
unauth_secure();
$data['modules'] = array('reports/inventory/issuetoVendor');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "tr_consume";
$data['title'] = "Vendor Stock Consume";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/issuetoVendor',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function tr_produce() {
unauth_secure();
$data['modules'] = array('reports/inventory/issuetoVendor');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "tr_produce";
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['brands'] = $this->items->fetchAllBrands();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header');
$this->load->view('reports/inventory/issuetoVendor',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function issuereceivefromVendor() {
unauth_secure();
$data['modules'] = array('reports/inventory/issuetoVendor');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "issue_receive";
$data['currdate'] = date("Y/m/d");
$data['title'] = "Vendor Ledger";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/issuetoVendor',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function YarnIssueReport() {
unauth_secure();
$data['modules'] = array('reports/purchase/YarnIssueReport');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "yarnissue";
$data['title'] = "Yarn Issue Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/YarnIssueReport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function YarnReturnReport() {
unauth_secure();
$data['modules'] = array('reports/purchase/YarnIssueReport');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "yarnreturn";
$data['title'] = "Yarn Return Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/YarnIssueReport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function FabricReceiveReport() {
unauth_secure();
$data['modules'] = array('reports/purchase/YarnIssueReport');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "frv";
$data['title'] = "Fabric Receive Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/YarnIssueReport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function purchase() {
unauth_secure();
$data['modules'] = array('reports/purchase/purchase');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "purchase";
$data['title'] = "Purchase Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/purchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function purchaseorder() {
unauth_secure();
$data['modules'] = array('reports/purchase/purchase');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Purchase Order";
$data['title'] = "Purchase Order Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/purchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function yarnpurchase() {
unauth_secure();
$data['modules'] = array('reports/purchase/purchase');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "yarnPurchase";
$data['title'] = "Yarn Purchase Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/purchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fabricpurchase() {
unauth_secure();
$data['modules'] = array('reports/purchase/purchase');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "fabricPurchase";
$data['title'] = "Fabric Purchase Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/purchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fabricpurchasecontract() {
unauth_secure();
$data['modules'] = array('reports/purchase/fabricpurchase');
$data['wrapper_class'] = "yarnpurchasecontract_report";
$data['page'] = "yarnpurchasecontract_report";
$data['etype'] = "Fabric PurchaseContract";
$data['currdate'] = date("Y/m/d");
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('reports/purchase/fabricpurchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function yarnpurchasecontract() {
unauth_secure();
$data['modules'] = array('reports/purchase/fabricpurchase');
$data['wrapper_class'] = "yarnpurchasecontract_report";
$data['page'] = "yarnpurchasecontract_report";
$data['etype'] = "Yarn PurchaseContract";
$data['currdate'] = date("Y/m/d");
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('reports/purchase/fabricpurchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function requisition() {
unauth_secure();
$data['modules'] = array('reports/purchase/requisition');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Requisition";
$data['currdate'] = date("Y/m/d");
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('reports/purchase/requisition',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function workorder() {
unauth_secure();
$data['modules'] = array('reports/purchase/workorder');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Work Order";
$data['currdate'] = date("Y/m/d");
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('reports/purchase/workorder',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function saleorder() {
unauth_secure();
$data['modules'] = array('reports/purchase/purchase');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Sale Order";
$data['title'] = "Sale Order Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/purchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function orderParts() {
unauth_secure();
$data['modules'] = array('reports/purchase/orders');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Order Parts";
$data['currdate'] = date("Y/m/d");
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('reports/purchase/orders',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function orderLoading() {
unauth_secure();
$data['modules'] = array('reports/purchase/orders');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Order Loading";
$data['currdate'] = date("Y/m/d");
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('reports/purchase/orders',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function purchaseReturn() {
unauth_secure();
$data['modules'] = array('reports/purchase/purchase');
$data['wrapper_class'] = "purchase__report";
$data['page'] = "purchase_report";
$data['etype'] = "Purchase Return";
$data['currdate'] = date("Y/m/d");
$data['title'] = "Sale Order Report";
$this->load->view('template/header');
$this->load->view('reports/purchase/purchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function sale() {
unauth_secure();
$data['modules'] = array('reports/purchase/purchase');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Sale";
$data['title'] = "Sale Order Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header');
$this->load->view('reports/purchase/purchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function ExportSaleRegister() {
unauth_secure();
$data['modules'] = array('reports/purchase/ExportSaleRegister');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Sale";
$data['title'] = "Export Sale Register";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/ExportSaleRegister',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function saleReturn() {
unauth_secure();
$data['modules'] = array('reports/purchase/purchase');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Sale Return";
$data['title'] = "Sale Order Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/purchase/purchase',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function saleOrderWise() {
unauth_secure();
$data['modules'] = array('reports/sale/saleorderwise');
$this->load->view('template/header');
$this->load->view('reports/sale/saleorderwise');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function waiterCashPending() {
unauth_secure();
$data['modules'] = array('reports/sale/waitercashpending');
$this->load->view('template/header');
$this->load->view('reports/sale/waitercashpending');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchSaleReportData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$sreportData = $this->sales->fetchSaleReportData($startDate,$endDate,$what,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchStockReport()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$sreportData = $this->stocks->fetchStockReport($startDate,$endDate,$what,$company_id,$crit);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchOrderStockReport()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$etype = $_POST['etype'];
$sreportData = $this->stocks->fetchOrderStockReport($startDate,$endDate,$what,$company_id,$crit,$etype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchOrderStatusReport()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$sreportData = $this->stocks->fetchOrderStatusReport($startDate,$endDate,$what,$company_id,$crit);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchOrderRequiredStockStatusReport()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$wo = $_POST['wo'];
$sreportData = $this->stocks->fetchOrderRequiredStockStatusReport($startDate,$endDate,$what,$company_id,$crit,$wo);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchissueReceiveReport()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$sreportData = $this->stocks->fetchissueReceiveReport($startDate,$endDate,$what,$company_id,$crit);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchDailyVoucherReport()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$sreportData = $this->stocks->fetchDailyVoucherReport($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchSaleProductionData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$sreportData = $this->orders->fetchPurchaseReportData($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchMaterialReturnData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$sreportData = $this->purchases->fetchMaterialReturnData($startDate,$endDate,$what,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchConsumptionData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$sreportData = $this->purchases->fetchConsumptionData($startDate,$endDate,$what,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchStockNavigationData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$crit = $_POST['crit'];
$ptype = $_POST['ptype'];
$sreportData = $this->purchases->fetchStockNavigationData($startDate,$endDate,$what,$type,$crit,$ptype);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchSaleReturnReportData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$sreportData = $this->sales->fetchSaleReturnReportData($startDate,$endDate,$what,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function saleReportOrderWise()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$sreportData = $this->sales->saleReportOrderWise($startDate,$endDate,$type);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function waiterCashPendingReport()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$sreportData = $this->sales->waiterCashPendingReport($startDate,$endDate);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function itemLedger() {
unauth_secure();
CheckReportRights("itemledger");
$data['modules'] = array('reports/inventory/itemlegderreport');
$data['title'] = "Item Ledger Report";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/itemlegderreport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function VendoritemLedger() {
unauth_secure();
CheckReportRights("vendorledgerreport");
$data['modules'] = array('reports/inventory/VendorItemLegderReport');
$data['title'] = "Vendor Ledger Report";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/VendorItemLegderReport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchVendorLedgerReport() {
if (isset( $_POST )) {
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$result = $this->purchases->fetchVendorLedgerReport($from,$to,$company_id,$crit);
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
public function fetchVendorLedgerOpening()
{
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$crit = $_POST['crit'];
$openingStock = $this->purchases->fetchVendorLedgerOpening($from,$to,$company_id,$crit);
$json = json_encode($openingStock);
echo $json;
}
public function fetchPurchaseReportData_production()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$sreportData = $this->purchases->fetchPurchaseReportData_production($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchOverTimeReportData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$sreportData = $this->staffs->fetchOverTimeReportData($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchAttendanceReportData()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$sreportData = $this->staffs->fetchAttendanceReportData($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchSalarySheetReport()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$sreportData = $this->staffs->fetchSalarySheetReport($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function fetchPurchaseReportData_inward()
{
$what = $_POST['what'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$type = $_POST['type'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$sreportData = $this->purchases->fetchPurchaseReportData_inward($startDate,$endDate,$what,$type,$company_id,$etype,$field,$crit,$orderBy,$groupBy,$name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($sreportData));
}
public function production() {
$data['modules'] = array('reports/inventory/production');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Production";
$data['currdate'] = date("Y/m/d");
$data['parties'] = $this->accounts->fetchAll(1);
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['userone'] = $this->users->fetchAll();
$data['staffs'] = $this->staffs->fetchAll();
$data['stafftypes'] = $this->staffs->getAllTypes();
$data['phase'] 		= $this->items->fetchAllSubPhase();
$data['brands'] = $this->items->fetchAllBrands();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['uoms'] = $this->items->fetchByCol('uom');
$data['cities'] = $this->accounts->getDistinctFields('city');
$data['cityareas'] = $this->accounts->getDistinctFields('cityarea');
$data['l1s'] = $this->levels->fetchAllLevel1();
$data['l2s'] = $this->levels->fetchAllLevel2();
$data['l3s'] = $this->levels->fetchAllLevel3();
$this->load->view('template/header');
$this->load->view('reports/inventory/production',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function inward() {
unauth_secure();
CheckReportRights('inwardreport');
$data['modules'] = array('reports/inventory/inwardreport');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Inward";
$data['title'] = "Inward Report";
$data['currdate'] = date("Y/m/d");
$name = $this->session->userdata('uname'); 	
if($name=='admin')
{}
else{
$data['did']=$this->users->getdepart_id($name);}
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/inwardreport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function outward() {
unauth_secure();
CheckReportRights('outwardreport');
$data['modules'] = array('reports/inventory/inwardreport');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Outward";
$data['title'] = "Outward Report";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/inwardreport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function consumption() {
unauth_secure();
CheckReportRights('consumptionreport');
$data['modules'] = array('reports/inventory/inwardreport');
$data['wrapper_class'] = "purchase_report";
$data['page'] = "purchase_report";
$data['etype'] = "Consumption";
$data['currdate'] = date("Y/m/d");
$this->load->view('template/header');
$this->load->view('reports/inventory/inwardreport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function departmentListings() {
unauth_secure();
$data['modules'] = array('reports/other/departmentlisting');
$data['departments'] = $this->departments->fetchAllDepartments();
$this->load->view('template/header');
$this->load->view('reports/other/departmentlisting.php',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function staffAtndncStatusWise() {
unauth_secure();
$data['modules'] = array('attendance/reports/staffattendancestatuswise');
$data['departments'] = $this->departments->fetchAllDepartments();
$data['staffs'] = $this->staffs->fetchAll();
$this->load->view('template/header');
$this->load->view('attendance/reports/staffattendancestatuswise',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function staffMonthlyAttendanceReport() {
unauth_secure();
$data['modules'] = array('attendance/reports/staffmonthlyatndncreport');
$data['departments'] = $this->departments->fetchAllDepartments();
$this->load->view('template/header');
$this->load->view('attendance/reports/staffmonthlyatndncreport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function staffAttendanceSheet() {
unauth_secure();
$data['modules'] = array('attendance/reports/staffattendancesheet');
$data['departments'] = $this->departments->fetchAllDepartments();
$data['title'] ='Leave Register';
$this->load->view('template/header',$data);
$this->load->view('attendance/reports/staffattendancesheet',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function staffStatus() {
unauth_secure();
$data['modules'] = array('reports/staff/staffstatus');
$data['departments'] = $this->departments->fetchAllDepartments();
$this->load->view('template/header');
$this->load->view('reports/staff/staffstatus',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function penalty() {
unauth_secure();
$data['modules'] = array('reports/accounts/penalty');
$data['staffs'] = $this->staffs->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$this->load->view('template/header');
$this->load->view('reports/accounts/penalty',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function loan() {
unauth_secure();
$data['modules'] = array('reports/accounts/loan');
$data['staffs'] = $this->staffs->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$this->load->view('template/header');
$this->load->view('reports/accounts/loan',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function OverTime() {
unauth_secure();
$data['modules'] = array('reports/other/OverTimeReport');
$data['staffs'] = $this->staffs->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['userone'] = $this->users->fetchAll();
$data['stafftypes'] = $this->staffs->getAllTypes();
$this->load->view('template/header');
$this->load->view('reports/other/OverTimeReport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function AttendanceReport() {
unauth_secure();
$data['modules'] = array('reports/other/AttendanceReport');
$data['staffs'] = $this->staffs->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['userone'] = $this->users->fetchAll();
$data['stafftypes'] = $this->staffs->getAllTypes();
$this->load->view('template/header');
$this->load->view('reports/other/AttendanceReport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function SalaryReport() {
unauth_secure();
$data['modules'] = array('reports/other/SalaryReport');
$data['staffs'] = $this->staffs->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['userone'] = $this->users->fetchAll();
$data['etype'] = 'salary';
$data['stafftypes'] = $this->staffs->getAllTypes();
$this->load->view('template/header');
$this->load->view('reports/other/SalaryReport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function WagesReport() {
unauth_secure();
$data['modules'] = array('reports/other/SalaryReport');
$data['staffs'] = $this->staffs->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$data['userone'] = $this->users->fetchAll();
$data['etype'] = 'wages';
$data['stafftypes'] = $this->staffs->getAllTypes();
$this->load->view('template/header');
$this->load->view('reports/other/SalaryReport',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function advance() {
unauth_secure();
$data['modules'] = array('reports/accounts/advance');
$data['staffs'] = $this->staffs->fetchAll();
$this->load->view('template/header');
$this->load->view('reports/accounts/advance',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function incentive() {
unauth_secure();
$data['modules'] = array('reports/accounts/incentive');
$data['staffs'] = $this->staffs->fetchAll();
$this->load->view('template/header');
$this->load->view('reports/accounts/incentive',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function eobiContribution() {
unauth_secure();
$data['modules'] = array('reports/accounts/eobi');
$data['departments'] = $this->departments->fetchAllDepartments();
$data['staffs'] = $this->staffs->fetchAll();
$this->load->view('template/header');
$this->load->view('reports/accounts/eobi',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function socialSecurityContribution() {
unauth_secure();
$data['modules'] = array('reports/accounts/socialsec');
$data['staffs'] = $this->staffs->fetchAll();
$data['departments'] = $this->departments->fetchAllDepartments();
$this->load->view('template/header');
$this->load->view('reports/accounts/socialsec',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function privillagesAssigned() {
unauth_secure();
$data['modules'] = array('reports/user/privillagesAssigned');
$this->load->view('template/header');
$this->load->view('reports/user/privillagesassigned',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function stockNavigation() {
unauth_secure();
$data['modules'] = array('reports/inventory/stocknavigation');
$data['title'] ="Stock Transfer Report";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/stocknavigation');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function dailyVoucher() {
unauth_secure();
$data['modules'] = array('reports/inventory/dailyvoucher');
$data['title'] = "Daily Vouchers";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/dailyvoucher',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function stock() {
unauth_secure();
$data['modules'] = array('reports/inventory/stock');
$data['companies'] = $this->companies->getAll();
$data['title'] ="Stock Report";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/stock',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function OrderStockStatus() {
unauth_secure();
$data['modules'] = array('reports/inventory/OrderRequiredStockStatus');
$data['wOrder'] = $this->orders->fetchAllSaleOrder();
$data['title'] ="Order Stock Status";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/OrderRequiredStockStatus',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function OrderStatus() {
unauth_secure();
$data['modules'] = array('reports/inventory/OrderStatus');
$data['departments'] = $this->departments->fetchAllDepartments();
$data['title'] ="Order Status";
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/OrderStatus',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function stock_returnable() {
unauth_secure();
$data['modules'] = array('reports/inventory/stock');
$data['departments'] = $this->departments->fetchAllDepartments();
$data['items'] = $this->items->fetchAll(1);
$data['categories'] = $this->items->fetchAllCategories();
$data['subcategories'] = $this->items->fetchAllSubCategories();
$data['brands'] = $this->items->fetchAllBrands();
$data['uoms'] = $this->items->fetchByCol('uom');
$this->load->view('template/header');
$this->load->view('reports/inventory/stock',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function materialReturn() {
unauth_secure();
$data['modules'] = array('reports/inventory/materialreturn');
$this->load->view('template/header');
$this->load->view('reports/inventory/materialreturn');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function accountLedger() {
unauth_secure();
$data['modules'] = array('reports/accounts/accountledger');
$data['parties'] = $this->accounts->fetchAll();
$data['title'] = 'Account Ledger';
$this->load->view('template/header',$data);
$this->load->view('reports/accounts/accountledger',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function chartOfAccounts()
{
unauth_secure();
$data['modules'] = array('reports/accounts/chartofaccounts');
$this->load->view('template/header');
$this->load->view('reports/accounts/chartofaccounts');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getChartOfAccounts()
{
unauth_secure();
$crit  = $_POST['crit'];
$groupby  = $_POST['groupby'];
$coas = $this->accounts->getChartOfAccounts($crit,$groupby);
$json = json_encode($coas);
echo $json;
}
public function cheques()
{
unauth_secure();
$data['modules'] = array('reports/accounts/chequesReport');
$data['title'] = 'Cheque Report';
$this->load->view('template/header',$data);
$this->load->view('reports/accounts/cheques');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getChequeReportData()
{
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$type = $_POST['type'];
$company_id= $_POST['company_id'];
$crit= $_POST['crit'];
$what = $_POST['what'];
$reportData = $this->accounts->getChequeReportData($startDate,$endDate,$type,$company_id,$crit,$what);
$json = json_encode($reportData);
echo $json;
}
public function getProfitLossReportData()
{
$what = $_POST['what'];
$filterCrit = $_POST['filterCrit'];
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$sreportData = $this->sales->fetchProfitLossReportData($what,$startDate,$endDate,$filterCrit);
$json = json_encode($sreportData);
echo $json;
}
public function profitloss()
{
$data['modules'] = array('reports/accounts/profitloss_report');
$this->load->view('template/header');
$this->load->view('reports/accounts/profitloss');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function accounts()
{
$data['modules'] = array('reports/accounts/accounts_reports');
$data['title'] ='Accounts Reports';
$this->load->view('template/header',$data);
$this->load->view('reports/accounts/accounts',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function fetchPayRecvReportData()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$payrecvreportData = $this->accounts->fetchPayRecvReportData($startDate,$endDate,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name);
$json = json_encode($payrecvreportData);
echo $json;
}
public function fetchDayBoookReportData()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$what = $_POST['what'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$dbreportData = $this->accounts->fetchDayBookReportData($startDate,$endDate,$what,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name);
$json = json_encode($dbreportData);
echo $json;
}
public function fetchExpenseReportData()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$what = $_POST['what'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$ereportData = $this->accounts->fetchExpenseReportData($startDate,$endDate,$what,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name);
$json = json_encode($ereportData);
echo $json;
}
public function fetchJVReportData()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$what = $_POST['what'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$jvreportData = $this->payments->fetchJVReportData($startDate,$endDate,$what,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name);
$json = json_encode($jvreportData);
echo $json;
}
public function fetchBPVReportData()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$what = $_POST['what'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$jvreportData = $this->payments->fetchBPVReportData($startDate,$endDate,$what,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name);
$json = json_encode($jvreportData);
echo $json;
}
public function fetchCashReportData()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$what = $_POST['what'];
$etype = $_POST['etype'];
$company_id = $_POST['company_id'];
$field = $_POST['field'];
$crit = $_POST['crit'];
$orderBy = $_POST['orderBy'];
$groupBy = $_POST['groupBy'];
$name = $_POST['name'];
$creportData = $this->payments->fetchCashReportData($startDate,$endDate,$what,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name);
$json = json_encode($creportData);
echo $json;
}
public function payables()
{
unauth_secure();
$data['wrapper_class'] = "accounts_reports";
$data['page'] = "accounts_reports";
$data['currdate'] = date("Y/m/d");
$data['companies'] = $this->companies->getAll();
$data['company_id'] = $this->session->userdata('company_id');
$startDate = '2010-01-01';
$endDate = date("Y/m/d");
$company_id = $this->session->userdata('company_id');
$field = '';
$crit = '';
$orderBy = "";
$groupBy = "";
$name = "";
$etype = 'payable';
$data['payables'] = $this->accounts->fetchPayRecvReportData($startDate,$endDate,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name);
$etype = 'receiveable';
$data['receiveables'] = $this->accounts->fetchPayRecvReportData($startDate,$endDate,$etype,$company_id,$field,$crit,$orderBy,$groupBy,$name);
$this->load->view('template/header',$data);
$this->load->view('template/mainnav',$data);
$this->load->view('reports/payables',$data);
$this->load->view('template/footer');
}
public function fetchPayRecvCount()
{
$startDate = $_POST['from'];
$endDate = $_POST['to'];
$company_id = $_POST['company_id'];
$etype = $_POST['etype'];
$payrecvreportData = $this->accounts->fetchPayRecvCount($startDate,$endDate,$company_id,$etype);
$json = json_encode($payrecvreportData);
echo $json;
}
}

?>