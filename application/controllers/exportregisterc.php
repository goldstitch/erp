
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class ExportRegisterc extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('exportregisters');
$this->load->model('currenceys');
$this->load->model('companies');
}
public function index() {
unauth_secure();
$data['modules'] = array('sale/addexportregister');
$data['categories'] = $this->exportregisters->fetchAllCategories('catagory');
$data['subcategories'] = $this->exportregisters->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->exportregisters->fetchAllBrands();
$data['uoms'] = $this->exportregisters->fetchByCol('uom');
$data['types'] = $this->exportregisters->fetchByCol('barcode');
$data['item_codes'] = $this->exportregisters->fetchByCol('item_code');
$data['parties'] = $this->accounts->fetchAll();
$data['exports'] = $this->exportregisters->fetchAll();
$data['currenceys'] = $this->currenceys->fetchAllCurrencey();
$data['title'] = 'Export Register';
$this->load->view('template/header',$data);
$this->load->view('sale/addexportregister',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function ChartOfItems()
{
$data['modules'] = array('reports/inventory/ChartOfItems');
$this->load->view('template/header');
$this->load->view('reports/inventory/ChartOfItemsv');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function recipeCosting() {
unauth_secure();
$data['modules'] = array('setup/addrecipe');
$data['items'] = $this->items->fetchAll();
$this->load->view('template/header');
$this->load->view('setup/addrecipe',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function getMaxId() {
$company_id  = $_POST['company_id'];
$result = $this->exportregisters->getMaxId($company_id) +1;
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxCatId() {
$result = $this->items->getMaxCatId() +1;
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxSubCatId() {
$result = $this->items->getMaxSubCatId() +1;
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxBrandId() {
$result = $this->items->getMaxBrandId() +1;
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxRecipeId() {
$result = $this->items->getMaxRecipeId() +1;
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function category() {
$data['modules'] = array('setup/category');
$data['categories'] = $this->items->fetchAllCategories();
$this->load->view('template/header');
$this->load->view('setup/addcategory',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function subcategory() {
$data['modules'] = array('setup/subcategory');
$data['subcategories'] = $this->items->fetchAllSubCategories();
$data['categories'] = $this->items->fetchAllCategories();
$this->load->view('template/header');
$this->load->view('setup/addsubcategory',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function brand() {
$data['modules'] = array('setup/brand');
$data['brands'] = $this->items->fetchAllBrands();
$this->load->view('template/header');
$this->load->view('setup/addbrand',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function save() {
if (isset($_POST)) {
$object  = $_POST['item'];
$result = $this->exportregisters->save($object);
$response = array();
if ($result == false) {
$response['error'] = true;
}else {
$response = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode('true'));
}
}
public function saveCategory() {
if (isset($_POST)) {
$category = $_POST['category'];
$error = $this->items->isCategoryAlreadySaved($category);
if (!$error) {
$result = $this->items->saveCategory($category);
$this->output
->set_content_type('application/json')
->set_output(json_encode('true'));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function saveSubCategory() {
if (isset($_POST)) {
$category = $_POST['category'];
$error = $this->items->isSubCategoryAlreadySaved($category);
if (!$error) {
$result = $this->items->saveSubCategory($category);
$this->output
->set_content_type('application/json')
->set_output(json_encode('true'));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function saveBrand() {
if (isset($_POST)) {
$brand = $_POST['brand'];
$error = $this->items->isBrandAlreadySaved($brand);
if (!$error) {
$result = $this->items->saveBrand($brand);
$this->output
->set_content_type('application/json')
->set_output(json_encode('true'));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function saveRecipe() {
if (isset($_POST)) {
$recipe = $_POST['recipe'];
$recipedetail = $_POST['recipedetail'];
$rid = $_POST['rid'];
if ($this->items->recipeExists($rid,$recipe['item_id'])) {
$response['error'] = 'duplicate';
}else {
$result = $this->items->saveRecipe($recipe,$recipedetail,$rid);
$response = array();
if ( $result === false ) {
$response['error'] = 'true';
}else {
$response = $result;
}
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}
}
public function fetch() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->exportregisters->fetchs($vrnoa,$company_id);
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
public function fetchInv() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->exportregisters->fetchInv($vrnoa,$company_id);
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
$result = $this->exportregisters->fetchAll();
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchAll_Items() {
if (isset( $_POST )) {
$from = $_POST['from'];
$to = $_POST['to'];
$orderby = $_POST['orderby'];
$status = $_POST['status'];
$result = $this->items->fetchAll_report($from,$to,$orderby,$status);
$response = "";
if ( $result === false ) {
$response = 'false';
}else {
$response = $result;
}
$json = json_encode($response);
echo $json;
}
}
public function fetchCategory() {
if (isset( $_POST )) {
$catid = $_POST['catid'];
$result = $this->items->fetchCategory($catid);
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
public function fetchSubCategory() {
if (isset( $_POST )) {
$subcatid = $_POST['subcatid'];
$result = $this->items->fetchSubCategory($subcatid);
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
public function fetchBrand() {
if (isset( $_POST )) {
$bid = $_POST['bid'];
$result = $this->items->fetchBrand($bid);
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
public function fetchItemOpeningStock()
{
$to = $_POST['to'];
$item_id = $_POST['item_id'];
$company_id = $_POST['company_id'];
$pid = $_POST['pid'];
$openingStock = $this->items->fetchItemOpeningStock($to,$item_id,$company_id,$pid);
$json = json_encode($openingStock);
echo $json;
}
public function fetchItemLedgerReport() {
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$from = $_POST['from'];
$to = $_POST['to'];
$company_id = $_POST['company_id'];
$pid = $_POST['pid'];
$result = $this->items->fetchItemLedgerReport($from,$to,$item_id ,$company_id,$pid);
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
public function fetchRecipe() {
if (isset( $_POST )) {
$rid = $_POST['rid'];
$result = $this->items->fetchRecipe($rid);
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
public function delete() {
if (isset( $_POST )) {
$vrnoa = $_POST['vrnoa'];
$company_id = $_POST['company_id'];
$result = $this->exportregisters->delete($vrnoa,$company_id);
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
public function deleteRecipe() {
if (isset( $_POST )) {
$rid = $_POST['rid'];
$result = $this->items->deleteRecipe($rid);
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
public function stockNotifications()
{
unauth_secure();
$data['wrapper_class'] = "stock_notifs";
$data['page'] = "stock_notifs";
$data['currdate'] = date("Y/m/d");
$data['companies'] = $this->companies->getAll();
$data['notifications'] = $this->items->getMinStockNotifs( $this->session->userdata('company_id') );
$data['company_id'] = $this->session->userdata('company_id');
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/stocknotifications',$data);
$this->load->view('template/mainnav',$data);
$this->load->view('template/footer');
}
public function fetchStockOrderCount()
{
unauth_secure();
$company_id = $_POST['company_id'];
$stockOrderCount = $this->items->fetchStockOrderCount( $company_id );
echo $stockOrderCount;
}
}

?>