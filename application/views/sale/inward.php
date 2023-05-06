

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="voucher-item-template" type="text/x-handlebars-template">
  <tr>
   <td>{{{VRNOA}}}</td>
   <td>{{VRDATE}}</td>
   <td>{{PARTYNAME}}</td>
   <td>{{REMARKS}}</td>
   <td class="text-right">{{DOZEN}}</td>
   <td class="text-right">{{BAG}}</td>
   <td class="text-right">{{QTY}}</td>
   <td class="text-right">{{WEIGHT}}</td>
 </tr>
</script>
<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">

   <td class="tblInvoice"></td>
   <td class="tblInvoice"></td>
   <td class="tblInvoice"></td>
   <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_DOZEN_SUM }}</td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_BAG_SUM }}</td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_QTY_SUM }}</td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_WEIGHT_SUM }}</td>
 </tr>
</script>
';
$desc = $this->session->userdata('desc');
$desc = json_decode($desc);
$name = $this->session->userdata('uname'); 	
$desc = objectToArray($desc);
$vouchers = $desc['vouchers'];
;echo '
<!-- main content -->
<div id="main_wrapper">
  <div id="AccountAddModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="AccountAddModelLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header" style="background:#76c143;color:white;padding-bottom:20px;">
        <button type="button" class="modal-button cellRight modal-close pull-right btn-close" data-dismiss="modal"><span class="fa fa-times" style="font-size:26px; "></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="AccountAddModelLabel">Add New Account</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="col-lg-9 col-lg-offset-1">
              <form role="form">
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Name</label>
                      <input type="text" id="txtAccountName" class="form-control" placeholder="Account Name" maxlength="50" tabindex="1">
                    </div>
                    <div class="col-lg-6">
                      <label>Acc Type3</label>
                      <select class="form-control input-sm "  id="txtLevel3" tabindex="2">
                      <!--   <option value="" disabled="" selected="">Choose Account Type</option>
                        ';foreach ($l3s as $l3): ;echo '                          <option value="';echo $l3['l3'];;echo '" data-level2="';echo $l3['level2_name'];;echo '" data-level1="';echo $l3['level1_name'];;echo '">';echo $l3['level3_name'] ;echo '</option>
                          ';endforeach ;echo ' -->
                        </select>
                      </div>
                      <div class="col-lg-12">
                        <span><b>Type 2 &rarr; </b><span id="txtselectedLevel2"> </span></span> <span><b>Type 1 &rarr; </b><span id="txtselectedLevel1"> </span></span>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>       
        </div>
        <div class="modal-footer">
          <div class="pull-right">
            <a class="btn btn-success btnSaveM btn-sm" data-insertbtn="1"><i class="fa fa-save"></i> Save</a>
            <a class="btn btn-warning btnResetM btn-sm"><i class="fa fa-refresh"></i> Reset</a>
            <a class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="ItemAddModel" class="modal hide fade" role="dialog" aria-labelledby="ItemAddModelLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header" style="background:#76c143;color:white;padding-bottom:20px;">
        <button type="button" class="modal-button cellRight modal-close pull-right btn-close" data-dismiss="modal"><span class="fa fa-times" style="font-size:26px; "></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="ItemAddModelLabel">Add New Item</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="col-lg-9 col-lg-offset-1">
              <form role="form">
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-12">
                      <label for="exampleInputEmail1">Description</label>
                      <input type="text" id="txtItemName" class="form-control" placeholder="Account Name" maxlength="50" tabindex="1">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <label>Category</label>
                      <select class="form-control input-sm select2" id="category_dropdown" tabindex="2">
                        <option value="" disabled="" selected="">Choose Category</option>
                        ';foreach ($categories as $category): ;echo '                          <option value="';echo $category['catid'];;echo '">';echo $category['name'];;echo '</option>
                        ';endforeach ;echo '                      </select>
                    </div>
                    <div class="col-lg-6">
                      <label>Sub Catgeory</label>
                      <select class="form-control input-sm select2" id="subcategory_dropdown" tabindex="3">
                        <option value="" disabled="" selected="">Choose sub category</option>
                        ';foreach ($subcategories as $subcategory): ;echo '                          <option value="';echo $subcategory['subcatid'];;echo '">';echo $subcategory['name'];;echo '</option>
                        ';endforeach ;echo '                      </select>
                    </div>
                  </div>    
                  <div class="row">
                    <div class="col-lg-6">
                      <label>Brand</label>
                      <select class="form-control input-sm select2" id="brand_dropdown" tabindex="4">
                        <option value="" disabled="" selected="">Choose brand</option>
                        ';foreach ($brands as $brand): ;echo '                          <option value="';echo $brand['bid'];;echo '">';echo $brand['name'];;echo '</option>
                        ';endforeach ;echo '                      </select>
                    </div>
                    <div class="col-lg-6">
                      <label>Type</label>
                      <input type="text" list=\'type\' class="form-control input-sm" id="txtBarcode" tabindex="5" />
                      <datalist id=\'type\'>
                        ';foreach ($types as $type): ;echo '                          <option value="';echo $type['barcode'];;echo '">
                          ';endforeach ;echo '                        </datalist>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3">
                        <label>Sale Price</label>
                        <input class="form-control input-sm num" type="text" id="txtSalePrice" tabindex="6">
                      </div>
                      <div class="col-lg-3">
                        <label>Pur Price</label>
                        <input class="form-control input-sm num" type="text" id="txtPurPrice" tabindex="7">
                      </div>
                      <div class="col-lg-6">
                        <label>UOM</label>
                        <input type="text" class=\'form-control input-sm\' tabindex="8" placeholder="Uom" id="uom_dropdown" list=\'uoms\'>
                        <datalist id="uoms">
                          ';foreach ($uoms as $uom): ;echo '                            ';if ($uom['uom'] !== ''): ;echo '                              <option value="';echo $uom['uom'];;echo '">
                              ';endif ;echo '                            ';endforeach ;echo '                          </datalist>
                        </div>
                      </div>

                    </div>
                  </form>
                </div>
              </div>
            </div>       
          </div>
          <div class="modal-footer">
            <div class="pull-right">
              <a class="btn btn-success btnSaveMItem btn-sm" data-insertbtn="1" tabindex="8"><i class="fa fa-save"></i> Save</a>
              <a class="btn btn-warning btnResetMItem btn-sm" tabindex="9"><i class="fa fa-refresh"></i> Reset</a>
              <a class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="party-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h3 id="myModalLabel">Party Lookup</h3>
          </div>

          <div class="modal-body">
            <table class="table table-striped modal-table">
              <!-- <table class="table table-bordered table-striped modal-table"> -->
                <thead>
                  <tr style="font-size:16px;">
                    <th>Id</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th style=\'width:3px;\'>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  ';foreach ($parties as $party): ;echo '                    <tr>
                      <td width="14%;">
                        ';echo $party['account_id'];;echo '                        <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                      </td>
                      <td>';echo $party['name'];;echo '</td>
                      <td>';echo $party['level3_name'];;echo '</td>
                      <td>';echo $party['mobile'];;echo '</td>
                      <td>';echo $party['address'];;echo '</td>
                      <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class=" ion-compose"></i></a></td>
                    </tr>
                  ';endforeach ;echo '                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
              <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <div id="orderloading-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h3 id="myModalLabel">Pending Order Parts Lookup</h3>
            </div>
            <div class="row">

              <div class="col-lg-3">                                                
                <div class="input-group">
                  <span class="input-group-addon id-addon">Order#</span>
                  <select class="form-control select2" id="OrderRunning_dropdown">
                    <option value="" selected="" disabled="">select</option>
                    ';foreach ($orders_running as $order): ;echo '                      <option value="';echo $order['vrnoa'];;echo '">';echo $order['vrnoa'];;echo '</option>
                    ';endforeach ;echo '                  </select>                            
                </div>
              </div>
              <div class="col-lg-6">
                <a class="btn btn-sm btn-default btnShowLoading" ><i class="fa fa-search"></i> Show</a>
                <a class="btn btn-sm btn-default btnAddLoading"><i class="fa fa-download"></i> Add</a>
                <a class="btn btn-sm btn-default btnResetLoading"><i class="fa fa-refresh"></i>Reset</a>
              </div>


            </div>
            <div class="modal-body">
              <div id="no-more-tables">
                <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="loading_table">
                  <!-- <table class="table table-bordered table-striped modal-table"> -->
                    <thead class="cf">
                      <tr >
                        <!-- <th class="numeric">Sr#</th> -->
                        <th><input type="checkbox" id="selectall">Sr#</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Weight</th>
                        <th>Type</th>
                        <th>St Qty</th>
                        <th>St Weight</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="modal-footer">
                <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>

        <div id="order-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 id="myModalLabel">Order Lookup</h3>
              </div>
              <div class="col-lg-3">                                                
                <div class="input-group">
                  <span class="input-group-addon id-addon">Order#</span>
                  <select class="form-control select2" id="OrderRunning_dropdown">
                    <option value="" selected="" disabled="">Choose Order#</option>
                    ';foreach ($orders_running as $order): ;echo '                      <option value="';echo $order['vrnoa'];;echo '">';echo $order['vrnoa'];;echo '</option>
                    ';endforeach ;echo '                  </select>                            
                </div>
              </div>
              <div class="modal-body">
                <div id="no-more-tables">
                  <table class="col-lg-12 table-bordered table-striped table-condensed cf">
                    <!-- <table class="table table-bordered table-striped modal-table"> -->
                      <thead class="cf">
                        <tr >
                          <th class="numeric">Order#</th>
                          <th>Date</th>
                          <th>Party</th>
                          <th>City</th>
                          <th>Area</th>
                          <th>Remarks</th>
                          <th>Chooose</th>
                        </tr>
                      </thead>
                      <tbody>
                        ';foreach ($orders_running as $runningorder): ;echo '                          <tr>
                            <td width="14%;" data-title=\'Order\'>
                              ';echo $runningorder['vrnoa'];;echo '                              <input type="hidden" name="orderid" value="';echo $runningorder['vrnoa'];;echo '">
                            </td>
                            <td data-title=\'Date\'>';echo $runningorder['vrdate'];;echo '</td>
                            <td data-title=\'Party\'>';echo $runningorder['name'];;echo '</td>
                            <td data-title=\'City\'>';echo $runningorder['city'];;echo '</td>
                            <td data-title=\'Area\'>';echo $runningorder['cityarea'];;echo '</td>
                            <td data-title=\'Remarks\'>';echo $runningorder['remarks'];;echo '</td>
                            <td><a href="#" data-dismiss="modal" class="btn btn-primary populateOrder"><i class=" ion-search"></i></a></td>
                          </tr>
                        ';endforeach ;echo '                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                  <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>


          <div id="item-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h3 id="myModalLabel">item Lookup</h3>
                </div>

                <div class="modal-body">
                  <table class="table table-striped modal-table">
                    <!-- <table class="table table-bordered table-striped modal-table"> -->
                      <thead>
                        <tr style="font-size:16px;">
                          <th>Id</th>
                          <th>Article#</th>
                          <th>Description</th>
                          <th>Code</th>
                          <th>Uom</th>
                          <th style=\'width:3px;\'>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       <!--  ';foreach ($items as $item): ;echo '                          <tr>
                            <td width="14%;">
                              ';echo $item['item_id'];;echo '                              <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                            </td>
                            <td>';echo $item['artcile_no'];;echo '</td>
                            <td>';echo $item['item_des'];;echo '</td>
                            <td>';echo $item['item_code'];;echo '</td>
                            <td>';echo $item['uom'];;echo '</td>
                            <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class=" ion-compose"></i></a></td>
                          </tr>
                          ';endforeach ;echo ' -->
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                      <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="page_bar">
                <div class="row">
                  <div class="col-md-4">
                    <h1 class="page_title">Inward Gate Pass</h1>
                  </div>
                  <div class="col-lg-8">
                    <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                    <a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-savetransporterbtn=\'';echo $vouchers['transporter']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['orderpartsvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['inwardvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['inwardvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['inwardvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                    <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>

                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                      <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <!-- <li ><a href="#" class="btnprintHeader"> Print with header</li> -->
                          <!-- <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li> -->
                          </ul>
                        </div>
                        <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
                        <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
                      </div>
                    </div>
                  </div>
                  <div class="page_content">
                    <div class="container-fluid">
                      <div class="row ">
                        <div class="col-lg-12">
                          <ul class="nav nav-pills">
                            <li class="active"><a href="#Main" data-toggle="tab">Main</a></li>
                            <li><a href="#Search" data-toggle="tab">Search</a></li>
                          </ul>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-10">
                          <div class="tab-content">
                            <div class="tab-pane active fade in" id="Main">  
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="panel panel-default">
                                    <div class="panel-body">

                                      <form action="">

                                        <div class="row">
                                          <div class="col-lg-2">
                                            <!-- <div class="input-group"> -->
                                              <label class="">Sr#</label>
                                              <input type="number" class="form-control input-sm " id="txtVrnoa" >
                                              <input type="hidden" id="txtMaxVrnoaHidden">
                                              <input type="hidden" id="txtVrnoaHidden">
                                              <input type="hidden" id="voucher_type_hidden">

                                              <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                              <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                              <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                                              <input type="hidden" id="purchaseid" value="';echo $setting_configur[0]['purchase'];;echo '">
                                              <input type="hidden" id="discountid" value="';echo $setting_configur[0]['discount'];;echo '">
                                              <input type="hidden" id="expenseid" value="';echo $setting_configur[0]['expenses'];;echo '">
                                              <input type="hidden" id="taxid" value="';echo $setting_configur[0]['tax'];;echo '">
                                              <input type="hidden" id="cashid" value="';echo $setting_configur[0]['cash'];;echo '">

                                              <!-- </div> -->
                                            </div>
                                            <div class="col-lg-2">
                                              <!-- <div class="input-group"> -->
                                                <label class="">Vr#</label>
                                                <input type="text" class="form-control input-sm " id="txtVrno" readonly=\'true\'>
                                                <input type="hidden" id="txtMaxVrnoHidden">
                                                <input type="hidden" id="txtVrnoHidden">
                                                <!-- </div> -->
                                              </div>                                               
                                              <div class="col-lg-2">
                                                <!-- <div class="input-group"> -->
                                                  <label class="">Date</label>
                                                  ';if ($vouchers['date_close']['insert'] == 1){;echo '                                                    <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                                                  ';}else{;echo '                                                    <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" readonly="">
                                                  ';};echo '                                                  <!-- </div> -->
                                                </div>
                                                <div class="col-lg-2">
                                                  <label>Unit</label>
                                                  <select class="form-control select2" id="unit_dropdown" >
                                                    <option value="" disabled="" selected="">Choose Unit</option>
                                                    ';foreach ($companies as $comp): ;echo '                                                      ';if ($this->session->userdata('company_id') !== $comp['company_id']){;echo ' 
                                                        <option value="';echo $comp['company_id'];;echo '">';echo $comp['company_name'];;echo '</option>
                                                      ';};echo '                                                    ';endforeach ;echo '                                                  </select>
                                                </div>
                                                <div class="col-lg-1">                                                
                                                  <label>OGP#</label>
                                                  <input type="text" class="form-control input-sm  num" id="txtOgp">                                                
                                                </div>
                                                <div class="col-lg-2">
                                                  <label>Order Type</label>
                                                  <select class="form-control" id="orderType_dropdown" >
                                                    <option value="" disabled="" selected="">Choose...</option>
                                                    <option value="pur_order" >Purchase Order</option>
                                                    <option value="yarnPurchaseContract" >Yarn Contract</option>
                                                    <option value="fabricPurchaseContract" >Fabric Contract</option>

                                                  </select>
                                                </div>
                                                <div class="col-lg-1">                                                
                                                  <label>Po/Cont#</label>
                                                  <input type="text" class="form-control input-sm  num" id="txtPo">                                                
                                                </div>
                                              </div>

                                              <div class="row">

                                                <div class="col-lg-4">
                                                  <div class="form-group">
                                                    <label>Party Name</label>
                                                    <div class="input-group" >
                                                      <select class="form-control select2" id="party_dropdown" >
                                                        <option value="" disabled="" selected="">Choose party</option>
                                                        ';foreach ($parties as $party): ;echo '                                                          <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                      </select>
                                                      <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                                      data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                    </div>
                                                  </div>


                                                </div>
  
                        ';if ($name == 'admin') {;echo '
                          <div class="col-lg-3">                                                
                          <label>Warehouse</label>
                          <select class="form-control select2" id="dept_dropdown">
                            <option value="" selected="" disabled="">Choose Warehouse</option>
                            ';foreach ($departments as $department): ;echo '                                <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                            ';endforeach ;echo '                            </select>                            
                        </div>	

                      ';}else{;echo '	
                        <div class="col-lg-3">                                                
                            <label>Warehouse</label>
                            <select class="form-control select2" id="dept_dropdown">
                              <option value="';echo $this->session->userdata('uname');;echo '" selected="';echo $this->session->userdata('uname');;echo '">';echo $this->session->userdata('uname');;echo'</option>
                              </select>                            
                          </div>
                      ';};echo '
                                                <div class="col-lg-2">                                                
                                                  <label>Rack Location</label>
                                                  <input class=\'form-control input-sm \' type=\'text\' list="receivers" id=\'receivers_list\'>
                                                  <datalist id=\'receivers\'>
                                                    ';foreach ($receivers as $receiver): ;echo '                                                      <option value="';echo $receiver['received_by'];;echo '">
                                                      ';endforeach ;echo '                                                    </datalist>                                                
                                                  </div>                                    

                                                  <div class="col-lg-3">                                                
                                                    <label>Through</label>
                                                    <div class="input-group" >
                                                      <select class="form-control input-sm select2" id="transporter_dropdown">
                                                        <option value="" disabled="" selected="">Choose transporter</option>
                                                        ';foreach ($transporters as $transporter): ;echo '                                                          <option value="';echo $transporter['transporter_id'];;echo '">';echo $transporter['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                      </select>
                                                      <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AddTransportModel" data-toggle="modal" href="#AddTransportModel" rel="tooltip"
                                                      data-placement="top" data-original-title="Add Transporter" data-toggle="tooltip" data-placement="bottom" title="Add New Transporter">+</a>
                                                    </div>                                               
                                                  </div>
                                                </div>                                        

                                                <div class="row" style="margin-top:0px;">
                                                  <div class="col-lg-1">                                                
                                                    <label>Inv/Gp#</label>
                                                    <input type="text" class="form-control input-sm  num" id="txtInvNo">                                                
                                                  </div>
                                                  <div class="col-lg-2">                                                
                                                    <label>Due Date</label>
                                                    <input class="form-control input-sm" type="date" id="due_date" value="';echo date('Y-m-d');;echo '">                                                
                                                  </div>                                           

                                                  <div class="col-lg-1">                                                
                                                    <label>WO#</label>
                                                    <input type="text" class="form-control input-sm " id="txtOrderNo">    
                                                  </div>
                                                  <div class="col-lg-2">                                                
                                                    <label>GP Type</label>
                                                    <select class="form-control" id="rgp_dropdown">

                                                      <option value="returnable" selected="">returnable</option>
                                                      <option value="non returnable" selected="">non returnable</option>
                                                    </select>                                               
                                                  </div>
                                                  <div class="col-lg-2">                                                
                                                    <label>Vehicle#</label>
                                                    <input class=\'form-control input-sm \' type=\'text\' list="vehicles" id=\'txtVehicle\'>
                                                    <datalist id=\'vehicles\'>
                                                      ';foreach ($vehicles as $vehicle): ;echo '                                                        <option value="';echo $vehicle['prepared_by'];;echo '">
                                                        ';endforeach ;echo '                                                      </datalist>                                                
                                                    </div>

                                                    <div class="col-lg-4">                                            

                                                      <label>Remarks</label>
                                                      <input type="text" class="form-control input-sm " id="txtRemarks">                                                                                                                                                                             
                                                    </div>
                                                    <div class="row">                                     
                                                    </div>


                                                    <div class="row">
                                                      <div class="col-lg-12">                        
                                                        <div class="tab-content">
                                                          <div class="tab-pane active fade in" id="itemadd">
                                                            <div class="container-wrap">
                                                              <div class="row">
                                                                <div class="col-lg-1 hide" >
                                                                  <label for="">Item Id</label>
                                                                  <div class="input-group">


                                                                    <select class="form-control select2" id="itemid_dropdown">
                                                                      <option value="" disabled="" selected="">Item Id</option>
                                                                      ';foreach ($items as $item): ;echo '                                                                        <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_id'];;echo '</option>
                                                                      ';endforeach ;echo '                                                                    </select>
                                                                  </div>
                                                                </div>
                                                                <div class="col-lg-5 hide" >
                                                                  <label for="" id="" >Item Description</label>
                                                                  <div class="input-group" >
                                                                    <select class="form-control select2" id="item_dropdown">
                                                                      <option value="" disabled="" selected="">Item description</option>
                                                                      ';foreach ($items as $item): ;echo '                                                                        <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '">';echo $item['item_des'];;echo '</option>
                                                                      ';endforeach ;echo '                                                                    </select>
                                                                    <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                                    data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                                  </div>
                                                                </div>

                                                                <div class="col-lg-2" >
                                                                  <label for="">Article</label>
                                                                  <select class="form-control select2" id="article_dropdown">
                                                                    <option value="" disabled="" selected="">Article</option>
                                                                    ';foreach ($short_codes as $item): ;echo '                                                                      <option value="';echo $item['vrnoa'];;echo '">';echo $item['short_code'];;echo '</option>
                                                                    ';endforeach ;echo '                                                                  </select>

                                                                </div>

                                                                <div class="col-lg-5">
                                                                  <label for="">Item Detail<img id="imgItemLoader" 
                                                                    class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>

                                                                    <input type="text" class="form-control" id="txtItemId">
                                                                    <input id="hfItemId" type="hidden" value="" />
                                                                    <input id="hfItemSize" type="hidden" value="" />
                                                                    <input id="hfItemBid" type="hidden" value="" />
                                                                    <input id="hfItemUom" type="hidden" value="" />
                                                                    <input id="hfItemUname" type="hidden" value="" />

                                                                    <input id="hfItemPrate" type="hidden" value="" />
                                                                    <input id="hfItemGrWeight" type="hidden" value="" />
                                                                    <input id="hfItemStQty" type="hidden" value="" />
                                                                    <input id="hfItemStWeight" type="hidden" value="" />
                                                                    <input id="hfItemLength" type="hidden" value="" />
                                                                    <input id="hfItemCatId" type="hidden" value="" />
                                                                    <input id="hfItemSubCatId" type="hidden" value="" />
                                                                    <input id="hfItemDesc" type="hidden" value="" />
                                                                    <input id="hfItemShortCode" type="hidden" value="" />
                                                                    <input id="hfItemBarcode" type="hidden" value="" />




                                                                  </div>
                                                                  <div class="col-lg-1">
                                                                    <label for="">OrderQty</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtOrderQty">                                                    
                                                                  </div>

                                                                  <div class="col-lg-1">
                                                                    <label for="">Received</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtRecQty">                                                    
                                                                  </div>

                                                                  <div class="col-lg-1">
                                                                    <label for="">BalQty</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtBalQty">                                                    
                                                                  </div>

                                                                  <div class="col-lg-1">
                                                                    <label for="">Dozen</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtDozenQty">                                                    
                                                                  </div>
                                                                  <div class="col-lg-1">
                                                                    <label for="">Bag</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtBag">                                                    
                                                                  </div>
                                                                </div>
                                                                <div class="row">

                                                                  <div class="col-lg-1">
                                                                    <label for="">Qty</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtQty">                                                    
                                                                  </div>
                                                                  <div class="col-lg-1">
                                                                    <label for="">GW</label>                                                    
                                                                    <input type="text" class="form-control readonly num" id="txtGWeight" readonly="" tabindex="-1" >                                                    
                                                                  </div>
                                                                  <div class="col-lg-1">
                                                                    <label for="">Uom</label>                                                    
                                                                    <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                                                  </div>
                                                                  <div class="col-lg-1">
                                                                    <label for="">Weight</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtWeight">                                                    
                                                                  </div>
                                                                  <div class="col-lg-1 hidden">
                                                                    <label for="">Rate</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtPRate">                                                    
                                                                  </div>
                                                                  <div class="col-lg-1 hidden">
                                                                    <label for="">Amount</label>                                                    
                                                                    <input type="text" class="form-control readonly num" id="txtAmount" readonly="true" tabindex="-1">                                                    
                                                                  </div>
                                                                  <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                                    <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                                                  </div>                                                
                                                                </div>

                                                              </div>
                                                              <div class="row">
                                                                <div class="col-lg-12">
                                                                  <div id="no-more-tables">
                                                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table">
                                                                      <thead class="cf tbl_thead">
                                                                        <tr>
                                                                          <th class="numeric">Sr#</th>
                                                                          <th >Article</th>
                                                                          <th >Item Id</th>
                                                                          <th >Item Detail</th>
                                                                          

                                                                          <th class="numeric text-right">OrderQty</th>
                                                                          <th class="numeric text-right">Received</th>
                                                                          <th class="numeric text-right">BalQty</th>
                                                                          <th class="numeric text-right">Dozen</th>
                                                                          <th class="numeric text-right">Bag</th>
                                                                          <th class="numeric text-right">Qty</th>
                                                                          <th class="numeric text-right">Weight</th>
                                                                          <th class="numeric hidden">Rate</th>
                                                                          <th class="numeric hidden">Amount</th>
                                                                          <th class="hidden">Type</th>
                                                                          <th>Action</th>
                                                                        </tr>
                                                                      </thead>
                                                                      <tbody>

                                                                      </tbody>
                                                                      <tfoot class="tfoot_tbl">
                                                                        <tr>
                                                                          
                                                                          <td  dclass="numeric" colspan="7" >Total:</td>
                                                                          <td data-title="Dozen" dclass="numeric" id="txtTotalDozen"></td>
                                                                          <td data-title="Bag" dclass="numeric" id="txtTotalBag"></td>
                                                                          <td data-title="Qty" dclass="numeric" id="txtTotalQty"></td>
                                                                          <td data-title="Weight" dclass="numeric" id="txtTotalWeight"></td>                                   
                                                                          <td data-title="" dclass="numeric" class="numeric hidden"></td>
                                                                          <td data-title="Amount" dclass="numeric" class="numeric hidden" id="txtTotalAmount"></td>
                                                                          <td data-title="" dclass="numeric" class="numeric hidden"></td>
                                                                          <td data-title="" dclass="numeric"></td>
                                                                        </tr>
                                                                      </tfoot>

                                                                    </table>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>


                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- <div class="row"></div> -->
                                                  <!-- <div class="row"></div> -->






                                                </form> <!-- end of form -->

                                              </div>  <!-- end of panel-body -->
                                            </div>  <!-- end of panel -->
                                          </div>  <!-- end of col -->
                                          <!-- end of row -->

                                          <div class="row">
                                            <div class="col-lg-12">
                                              <div class="panel panel-default">
                                                <div class="panel-body">
                                                  <div class="row">                                    
                                                    <!-- <div class="col-lg-3">                                                    
                                                        <label>Total Weight</label>
                                                        <input type="text" class="form-control readonly num" id="txtTotalWeight" readonly="true" tabindex="-1">
                                                    </div>                                                
                                                    <div class="col-lg-3">                                                    
                                                        <label>Total Qty</label>
                                                        <input type="text" class="form-control readonly num" id="txtTotalQty" readonly="true" tabindex="-1">
                                                      </div> -->                                                
                                                      <div class="col-lg-3 hidden">                                                    
                                                        <label class="hidden">Total Amount</label>
                                                        <input type="text" class="form-control readonly num hidden" id="txtTotalAmount" readonly="true" tabindex="-1">
                                                      </div>
                                                      <div class="col-lg-3 hidden">                                                    
                                                        <label class="hidden">Less Amount</label>
                                                        <input type="text" class="form-control num hidden" id="txtPaid">
                                                      </div>                                                
                                                    </div>
                                                    <div class="row">                                           
                                                      <div class="col-lg-1 hidden">                                                    
                                                        <label class="hidden">Discount%</label>
                                                        <input type="text" class=" form-control num hidden"  id="txtDiscount">
                                                      </div>                                                
                                                      <div class="col-lg-2 hidden">                                                    
                                                        <label class="hidden">DiscAmount</label>
                                                        <input type="text" class=" form-control num hidden"  id="txtDiscAmount">
                                                      </div>
                                                      <div class="col-lg-1 hidden">                                                    
                                                        <label class="hidden">Expense%</label>
                                                        <input type="text" class=" form-control num hidden"  id="txtExpense">
                                                      </div>                                                
                                                      <div class="col-lg-2 hidden">                                                    
                                                        <label class="hidden">Exp Amount</label>
                                                        <input type="text" class=" form-control num hidden"  id="txtExpAmount">
                                                      </div>
                                                      <div class="col-lg-1 hidden">                                                    
                                                        <label class="hidden">Tax%</label>
                                                        <input type="text" class=" form-control num hidden"  id="txtTax">
                                                      </div>                                                
                                                      <div class="col-lg-2 hidden">                                                    
                                                        <label class="hidden">TaxAmount</label>
                                                        <input type="text" class=" form-control num hidden"  id="txtTaxAmount">
                                                      </div>

                                                      <div class="col-lg-3 hidden">                                                    
                                                        <label class="hidden">Net Amount</label>
                                                        <input type="text" class="form-control readonly hidden" id=\'txtNetAmount\' readonly="" tabindex="-1">
                                                        <!-- input type="text" class="form-control readonly num" id="txtUom" >                                                     -->
                                                      </div>
                                                      
                                                    </div>
                                                    <div class="row">                                                                                    
                                                      <div class="col-lg-10">


                                                        <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                        <a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['inwardvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['inwardvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['inwardvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['inwardvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                                        <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>

                                                        <div class="btn-group">
                                                          <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                          </button>
                                                          <ul class="dropdown-menu" role="menu">
                                                            <!-- <li ><a href="#" class="btnprintHeader"> Print with header</li> -->
                                                              <!-- <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li> -->
                                                              </ul>
                                                            </div>
                                                            <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
                                                            <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
                                                          </div>
                                                          <div class="col-lg-2 hidden">
                                                            <div class="form-group">                                                                
                                                              <div class="input-group">
                                                                <span class="switch-addon input-group-addon">Pre Bal?</span>
                                                                <input type="checkbox" checked="" class="bs_switch" id="switchPreBal">
                                                              </div>
                                                            </div>
                                                          </div>

                                                        </div>
                                                        <div class="row">
                                                          <div class="col-lg-3">
                                                            <div class="form-group">                                                                
                                                              <div class="input-group">
                                                                <span class="switch-addon input-group-addon">Print Header?</span>
                                                                <input type="checkbox" checked="" class="bs_switch" id="switchHeader">
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                            <div class="input-group">
                                                              <span class="input-group-addon">User: </span>
                                                              <input type="text" disabled="" class=" form-control"  id="txtUserName" >

                                                            </div>
                                                          </div>
                                                          

                                                          <div class="col-lg-3">
                                                            <div class="input-group">
                                                              <span class="input-group-addon">Posting Date: </span>
                                                              <input type="text" disabled="" class=" form-control"  id="txtPostingDate" >

                                                            </div>
                                                          </div> 
                                                          
                                                        </div>
                                                      </div>  <!-- end of row -->
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="tab-pane fade" id="Search">
                                                <div class="panel panel-default">
                                                  <div class="panel-body">
                                                    <div class="row">
                                                      <div class="col-lg-3">
                                                        <div class="input-group">
                                                          <span class="input-group-addon">From</span>
                                                          <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                                        </div>
                                                      </div>
                                                      <div class="col-lg-3">
                                                        <div class="input-group">
                                                          <span class="input-group-addon">To</span>
                                                          <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                                        </div>
                                                      </div>
                                                      <div class="col-lg-6">
                                                        <div class="pull-right">
                                                          <a href=\'\' class="btn btn-sm btn-success btnSearch" id="btnSearch" ><i class="fa fa-search"></i> Search</a>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-lg-12">

                                                        <div id="no-more-tables">
                                                          <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_tableReport">
                                                            <thead class="cf tbl_thead">
                                                              <tr>
                                                                <th>Vr#</th>
                                                                <th>Date</th>
                                                                <th class="numeric text-left">Party</th>
                                                                <th class="numeric text-left">Remarks</th>
                                                                <th class="numeric text-right">Dozen</th>
                                                                <th class="numeric text-right">Bag</th>
                                                                <th class="numeric text-right">Qty</th>
                                                                <th class="numeric text-right">Weight</th>

                                                                <!-- <th>Action</th> -->
                                                              </tr>
                                                            </thead>
                                                            <tbody id="saleRows" class="report-rows saleRows">

                                                            </tbody>


                                                          </table>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                          </div>

                                          <div class="col-md-2">

                                            <div class="row">
                                              <label>Stock Positons</label>
                                              <table class="table table-striped Lstocks_table font_tbl">
                                                <thead>
                                                  <tr>
                                                    <th>Location</th>
                                                    <th class="text-right">Qty</th>
                                                    <th class="text-right">Weight</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>

                                                  </tr>
                                                </tbody>
                                                <tfoot>
                                                  <tr>

                                                    <td class="text-right" colspan=\'\' >Totals</td>
                                                    <td class="TotalLstocks text-right"></td>
                                                    <td class="TotalLWeights text-right"></td>
                                                  </tr>
                                                </tfoot>
                                              </table>
                                            </div>
                                          </div>
                                        </div>

                                      </div>


                                    </div>  <!-- end of level 1-->
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="AddTransportModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="model-contentwrapper">
                                <div class="modal-header" style="background:#6cb936; color:white;">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                  <h3 id="myModalLabel">Add Transporter</h3>
                                </div>
                                <div class="modal-body" style="background:#E7F0EF;">

                                  <div class="form-group">


                                    <div class="row">
                                      <div class="col-lg-5">
                                        <label>Name</label>

                                        <input type="text" class="form-control input-sm " id="txtTransName">
                                      </div>
                                      <div class="col-lg-5 ">

                                       <label>Contact Person</label>

                                       <input type="text" class="form-control input-sm " id="txtContact">
                                     </div>
                                   </div>



                                   <div class="row">
                                    <div class="col-lg-5">
                                      <label>Phone</label>
                                      <input type="text" class="form-control input-sm " id="txtPhone">

                                    </div>
                                    <div class="col-lg-5 ">
                                      <label>Area Cover</label>
                                      <input type="text" class="form-control input-sm " id="txtAreaCover">
                                    </div>
                                  </div>

                                  <br>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <div class="pull-right">
                                  <a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
                                  <a class="btn btn-primary btnSaveTransporter addmodal"><i class="fa fa-plus"></i> Add</a>
                                </div>
                              </div>
                            </div>
</div><!-- transporter model -->';
?>