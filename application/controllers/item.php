

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
class Item extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model('accounts');
$this->load->model('items');
$this->load->model('currenceys');
$this->load->model('companies');
}
public function index() {
unauth_secure();
$data['modules'] = array('setup/additem');
$data['setting_configur'] = $this->items->fetchAccountEffects();
$data['Colors'] = $this->items->fetchAllColors();
$data['Sizes'] = $this->items->fetchAllSizes();
$data['title'] = "Add New Item";
$this->load->view('template/header',$data);
$this->load->view('setup/additem',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function FetchBulkItemsSearch()
{
$data = array();
$data['categories'] = $this->items->fetchAllCategories('catagory');
$data['subcategories'] = $this->items->fetchAllSubCategories('sub_catagory');
$data['brands'] = $this->items->fetchAllBrands();
$data['sizes'] = $this->items->fetchByCol('size');
$data['colors'] = $this->items->fetchByCol('model');
$data['articles'] =$this->items->fetchAllArticles(1);
$this->output
->set_content_type('application/json')
->set_output(json_encode($data));
}
public function ChartOfItems()
{
$data['modules'] = array('reports/inventory/ChartOfItems');
$data['title'] ='Chart Of Items';
$this->load->view('template/header',$data);
$this->load->view('reports/inventory/ChartOfItemsv');
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}


public function search_item(){
    if (isset($_POST)) {
    $barcode = $_POST['barcode'];}
    $result = $this->items->search_item($barcode);
    $this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($result));
    }

    
public function fetchAllArticles(){
$result = $this->items->fetchAllArticles();
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchAllBrands(){
$result = $this->items->fetchAllBrands();
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchAllCategories(){
$result = $this->items->fetchAllCategories('catagory');
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchAllSubCategories(){
$result = $this->items->fetchAllSubCategories('sub_catagory');
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchByCol()
{
$col_name = $_POST['col_name'];
$result = $this->items->fetchByCol($col_name);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function searchitem(){
$search = $_POST['search'];
$pid=0;
if(isset($_POST['pid']))
$pid = $_POST['pid'];
$result = $this->items->searchitem($search,$pid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function getiteminfobyid(){
$item_id = $_POST['item_id'];
$pid=0;
if(isset($_POST['pid']))
$pid = $_POST['pid'];
$result = $this->items->getiteminfobyid($item_id,$pid);
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
public function fetchModels()
{
$catid = $_POST['catid'];
$subcatid = $_POST['subcatid'];
$result = $this->items->fetchModels($catid,$subcatid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchBrands()
{
$result = $this->items->fetchAllBrands($_POST);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchAllMades()
{
$result = $this->items->fetchAllMades($_POST);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function fetchAllUsed()
{
$result = $this->items->fetchAllUsed($_POST);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function saveMade() {
if (isset($_POST)) {
$made = $_POST['made'];
$error = $this->items->isMadeAlreadySaved($made);
if (!$error) {
$result = $this->items->saveMade($made);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function saveUsed() {
if (isset($_POST)) {
$used = $_POST['used'];
$error = $this->items->isUsedAlreadySaved($used);
if (!$error) {
$result = $this->items->saveUsed($used);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function fetchMade() {
if (isset( $_POST )) {
$made_id = $_POST['made_id'];
$result = $this->items->fetchMade($made_id);
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

public function fetch_demand() {
if (isset( $_POST )) {
$id = $_POST['id'];
$result = $this->items->fetch_demand($id);
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


public function fetch_demand_qty() {
if (isset( $_POST )) {
$id = $_POST['id'];
$code = $_POST['code'];
$result = $this->items->fetch_demand_qty($id,$code);
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

public function fetchSubCatWithCatid()
{
$catid = $_POST['catid'];
$result = $this->items->fetchSubCatWithCatid($catid);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
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
$result = $this->items->getMaxId() +1;
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
$data['title'] = "Add New Catagory";
$this->load->view('template/header',$data);
$this->load->view('setup/addcategory',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function subcategory() {
$data['modules'] = array('setup/subcategory');
$data['subcategories'] = $this->items->fetchAllSubCategories();
$data['categories'] = $this->items->fetchAllCategories();
$data['title'] = "Add New Sub Catagory";
$this->load->view('template/header',$data);
$this->load->view('setup/addsubcategory',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function brand() {
$data['modules'] = array('setup/brand');
$data['brands'] = $this->items->fetchAllBrands();
$data['title'] = "Add New Brand";
$this->load->view('template/header',$data);
$this->load->view('setup/addbrand',$data);
$this->load->view('template/mainnav');
$this->load->view('template/footer',$data);
}
public function save() {
if (isset($_POST)) {
$result = $this->items->save($_POST);
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
public function saveUpdateCost() {
if (isset($_POST)) {
$item_id = $_POST['item_id'];
$qty = $_POST['qty'];
$avg_rate = $_POST['avg_rate'];
$result = $this->items->saveUpdateCost($item_id,$qty,$avg_rate);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
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
public function savelist() {
$error = $this->items->isItemAlreadySaved($_POST);
if (!$error) {
$error1 = $this->items->isShortCodeAlreadySaved($_POST);
if (!$error1) {
$result = $this->items->savelist($_POST);
$response = array();
if ($result === false) {
$response['error'] = true;
}else {
$response['error'] = $result;
}
$this->output
->set_content_type('application/json')
->set_output(json_encode($response));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicateshortcode'));
}
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicateitem'));
}
}
public function saveColor() {
if (isset($_POST)) {
$color = $_POST['color'];
$error = $this->items->isColorAlreadySaved($color);
if (!$error) {
$result = $this->items->saveColor($color);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function getMaxColorId() {
$result = $this->items->getMaxColorId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function getMaxSizeId() {
$result = $this->items->getMaxSizeId() +1;
$this->output->set_content_type('application/json')->set_output(json_encode($result));
}
public function saveSize() {
if (isset($_POST)) {
$size = $_POST['size'];
$error = $this->items->isSizeAlreadySaved($size);
if (!$error) {
$result = $this->items->saveSize($size);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function saveSuplier() {
if (isset($_POST)) {
$suplier = $_POST['suplier'];
$error = $this->items->isSuplierAlreadySaved($suplier);
if (!$error) {
$result = $this->items->saveSuplier($suplier);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}else {
$this->output
->set_content_type('application/json')
->set_output(json_encode('duplicate'));
}
}
}
public function getMaxMade_Id() {
$result = $this->items->getMaxMade_Id() +1;
return $this->output->set_content_type('application/json')->set_output(json_encode($result));
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
$item_id = $_POST['item_id'];
$result = $this->items->fetch($item_id);
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
$result = $this->items->fetchAll();
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
$crit = '';
if(isset($_POST['crit']))
$crit = $_POST['crit'];
$result = $this->items->fetchAll_report($from,$to,$orderby,$status,$crit);
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
$data['title'] = "Stock Required Report";
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
public function delete() {
if (isset( $_POST )) {
$item_id = $_POST['item_id'];
$result = $this->items->delete($item_id);
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
public function deleteBrand() {
if (isset( $_POST )) {
$bid = $_POST['bid'];
$result = $this->items->deleteBrand($bid);
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
public function deleteColor() {
if (isset( $_POST )) {
$color_id = $_POST['color_id'];
$result = $this->items->deleteColor($color_id);
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
public function deleteSize() {
if (isset( $_POST )) {
$size_id = $_POST['size_id'];
$result = $this->items->deleteSize($size_id);
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
public function deleteSuplier() {
if (isset( $_POST )) {
$supid = $_POST['supid'];
$result = $this->items->deleteSuplier($supid);
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
public function deleteMade() {
if (isset( $_POST )) {
$made_id = $_POST['made_id'];
$result = $this->items->deleteMade($made_id);
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
public function deleteSubCatagory() {
if (isset( $_POST )) {
$subcatid = $_POST['subcatid'];
$result = $this->items->deleteSubCatagory($subcatid);
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
public function fetchUOM()
{
$result = $this->items->fetchUOM($_POST);
$this->output
->set_content_type('application/json')
->set_output(json_encode($result));
}
public function deleteCatagory() {
if (isset( $_POST )) {
$catid = $_POST['catid'];
$result = $this->items->deleteCatagory($catid);
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
}

?>