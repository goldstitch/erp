

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
   <td class="text-right">{{QTY}}</td>
   <td class="text-right">{{WEIGHT}}</td>
   <td class="text-right">{{RATE}}</td>
   <td class="text-right">{{LVENDOR}}</td>
   <td class="text-right printRemove">{{LSTOCK}}</td>
 </tr>
</script>
<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">

   <td class="tblInvoice"></td>
   <td></td>
   <td class="tblInvoice"></td>
   <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
   <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
   <td></td>
   <td class="tblInvoice"></td>
   <td></td>
 </tr>
</script>
';
$desc = $this->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$name = $this->session->userdata('uname'); 
$vouchers = $desc['vouchers'];
;echo  '
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
                        <option value="" disabled="" selected="">Choose Account Type</option>
                        ';foreach ($l3s as $l3): ;echo '                          <option value="';echo $l3['l3'];;echo '" data-level2="';echo $l3['level2_name'];;echo '" data-level1="';echo $l3['level1_name'];;echo '">';echo $l3['level3_name'] ;echo '</option>
                        ';endforeach ;echo '                      </select>
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

                    </select>
                  </div>
                  <div class="col-lg-6">
                    <label>Sub Catgeory</label>
                    <select class="form-control input-sm select2" id="subcategory_dropdown" tabindex="3">

                    </select>
                  </div>
                </div>    
                <div class="row">
                  <div class="col-lg-6">
                    <label>Brand</label>
                    <select class="form-control input-sm select2" id="brand_dropdown" tabindex="4">

                    </select>
                  </div>
                  <div class="col-lg-6">
                    <label>Type</label>
                    <input type="text" list=\'type\' class="form-control input-sm" id="txtBarcode" tabindex="5" />
                    <datalist id=\'type\'>
                      ';foreach ($types as $type): ;echo '                        <option value="';echo $type['barcode'];;echo '">
                        ';endforeach ;echo '                      </datalist>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <label>Sale Price 1</label>
                      <input class="form-control input-sm num" type="text" id="txtSalePrice" tabindex="6">
                    </div>
                    <div class="col-lg-6">
                      <label>Pur Price</label>
                      <input class="form-control input-sm num" type="text" id="txtPurPrice" tabindex="7">
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
                <th>Description</th>
                <th>Code</th>
                <th>Uom</th>
                <th style=\'width:3px;\'>Actions</th>
              </tr>
            </thead>
            <tbody>
              ';foreach ($items as $item): ;echo '                <tr>
                  <td width="14%;">
                    ';echo $item['item_id'];;echo '                    <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                  </td>
                  <td>';echo $item['item_des'];;echo '</td>
                  <td>';echo $item['item_code'];;echo '</td>
                  <td>';echo $item['uom'];;echo '</td>
                  <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa-li fa fa-check-square"></i></a></td>
                </tr>
              ';endforeach ;echo '            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
          <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
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
                  <th>Mobile</th>
                  <th>Address</th>
                  <th style=\'width:3px;\'>Actions</th>
                </tr>
              </thead>
              <tbody>
                ';foreach ($parties as $party): ;echo '                  <tr>
                    <td width="14%;">
                      ';echo $party['pid'];;echo '                      <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                    </td>
                    <td>';echo $party['name'];;echo '</td>
                    <td>';echo $party['mobile'];;echo '</td>
                    <td>';echo $party['address'];;echo '</td>
                    <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa-li fa fa-check-square"></i></a></td>
                  </tr>
                ';endforeach ;echo '              </tbody>
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
        <div class="col-md-3">
          <h1 class="page_title">Requisition Voucher</h1>
        </div>
        <div class="col-lg-9 pull-right">
          <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
          <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['requisition']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['requisition']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['requisition']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['requisition']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
          <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>

          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">

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
                              <div class="input-group">

                                <span class="input-group-addon txt-addon VoucherNoLable">Sr#</span>

                                <input type="number" class="form-control input-sm VoucherNo" id="txtVrnoa" >
                                <input type="hidden" id="txtMaxVrnoaHidden">
                                <input type="hidden" id="txtVrnoaHidden">
                                <input type="hidden" id="voucher_type_hidden">

                                <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">



                              </div>
                            </div>

                            <div class="col-lg-2">

                             <div class="input-group">

                              <span class="input-group-addon txt-addon VoucherNoLable">Vr#</span>
                              <input type="text" class="form-control input-sm " id="txtVrno" readonly=\'true\'>
                              <input type="hidden" id="txtMaxVrnoHidden">
                              <input type="hidden" id="txtVrnoHidden">

                            </div>                                               
                          </div>

                          <div class="col-lg-3">

                            <div class="input-group">

                              <span class="input-group-addon txt-addon VoucherNoLable">Date</span>
                              ';if ($vouchers['date_close']['insert'] == 1){;echo '                                <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                              ';}else{;echo '                                <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" readonly="">
                              ';};echo '                              <!-- </div> -->
                            </div>
                          </div>

                          <div class="col-lg-2 hide">

                            <div class="input-group">

                              <span class="input-group-addon txt-addon VoucherNoLable">IRM#</span>
                              <input type="text" class="form-control input-sm num" id="txtIrm" >
                            </div>
                          </div>    

                          <div class="col-lg-3">                       

                            <div class="input-group">

                              <span class="input-group-addon txt-addon">Work Order#</span>
                              <div class="input-group">                                                

                                <input type="text" class="form-control input-sm num " id="txtworkOrderNo">
                                <a href="#bulkitem-lookup" data-toggle="modal" class="btn btn-sm btn-default btnBulkItemsSearch "><i class="fa fa-search"></i>Show</a>

                              </div>    
                            </div>    

                          </div>

                        </div>

                        <div class="row">

                        ';if ($name == 'admin') {;echo '
                          <div class="col-lg-3">                                                
                          <label>Warehouse</label>
                          <select class="form-control select2" id="dept_dropdown">
                            ';foreach ($departments as $department): ;echo '                                <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                            ';endforeach ;echo '                            </select>                            
                        </div>	

                      ';}else{;echo '	
                        <div class="col-lg-3">                                                
                            <label>Warehouse</label>
                            <select class="form-control select2" id="dept_dropdown">
                            <option value="" disabled="" selected="">Choose Warehouse</option>
                            <option value="';echo $did;;echo'">';echo $this->session->userdata('uname');;echo'</option>
                            </select>                              
                          </div>
                      ';};echo '
                          
                          <div class="col-lg-4">                                                
                            <label>Received By</label>
                            <input class=\'form-control input-sm \' type=\'text\' list="receivers" id=\'receivers_list\'>
                            <datalist id=\'receivers\'>
                              ';foreach ($receivers as $receiver): ;echo '                                <option value="';echo $receiver['received_by'];;echo '">
                                ';endforeach ;echo '                              </datalist>                                                
                            </div>                                    
                            <div class="col-lg-2">                                                
                              <label>Due Date</label>
                              <input class="form-control input-sm" type="date" id="due_date" value="';echo date('Y-m-d');;echo '">                                                
                            </div>                                           

                            <div class="col-lg-3">                                            
                              <label>Remarks</label>
                              <input type="text" class="form-control input-sm " id="txtRemarks">                                                                                                                                                                             
                            </div>

                          </div>                                        

                          <div class="row hide" style="margin-top:0px;">
                            <div class="col-lg-2">                                                
                              <label>Inv#</label>
                              <input type="text" class="form-control input-sm  num" id="txtInvNo">                                                
                            </div>

                          </div>


                          <div class="container-wrap">
                            <div class="row">


                              <div class="col-lg-2" >
                                <label for="">Article</label>
                                <select class="form-control select2" id="article_dropdown">
                                  <option value="" disabled="" selected="">Article</option>
                                  ';foreach ($short_codes as $item): ;echo '                                    <option value="';echo $item['vrnoa'];;echo '">';echo $item['short_code'];;echo '</option>
                                  ';endforeach ;echo '                                </select>

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

                                  <input id="hfItemInventoryId" type="hidden" value="" />
                                  <input id="hfItemCostId" type="hidden" value="" />




                                </div>
                                <div class="col-lg-1">
                                  <label for="">Uom</label>                                                    
                                  <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                </div>
                                

                                <div class="col-lg-1">
                                  <label for="">Qty</label>                                                    
                                  <input type="text" class="form-control num" id="txtQty">                                                    
                                </div>
                                
                                <div class="col-lg-1">
                                  <label for="">Weight</label>                                                    
                                  <input type="text" class="form-control num" id="txtWeight">                                                    
                                </div>
                                <div class="col-lg-1">
                                  <label for="">L PRate</label>                                                    
                                  <input type="text" class="form-control num" id="txtPRate">                                                    
                                </div>
                                </div>
                                <div class="row">

                                <div class="col-lg-2">
                                  <label for="">Last Vendor</label>                                                    
                                  <input type="text" class="form-control" id="txtVendor">
                                </div>
                                <div class="col-lg-1">
                                  <label for="">L Stock</label>                                                    
                                  <input type="text" class="form-control num" id="txtStock">                                                    
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
                                    <thead class="cf">
                                      <tr>
                                        <th class="numeric text-left">Sr#</th>
                                        <th >Article</th>
                                        <th >Item Detail</th>
                                        <th >Uom</th>

                                        <th class="numeric text-right">Qty</th>
                                        <th class="numeric text-right">Weight</th>
                                        <th class="numeric text-right">Rate</th>
                                        <th class="text-left">L Vendor</th>
                                        <th class="numeric text-right">L Stock</th>
                                        <th >Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot class="tfoot_tbl cf">
                                      <tr>
                                        <td data-title="" class="text-right" colspan="4">Totals</td>
                                        <td data-title="Qty" class="text-right numeric txtTotalQty"></td>
                                        <td data-title="Weight" class="text-right numeric txtTotalWeight"></td>
                                        <td data-title="" class="text-right txtTotalRate"></td>
                                        <td data-title="" class="text-right txtTotalDiscount"></td>
                                        <td data-title="" class="text-right txtTotalAmount"></td>
                                        <td></td>
                                      </tr>
                                    </tfoot>

                                  </table>
                                </div>
                              </div>
                            </div>





                          </form> <!-- end of form -->

                        </div>  <!-- end of panel-body -->
                      </div>  <!-- end of panel -->
                    </div>  <!-- end of col -->
                  </div>  <!-- end of row -->

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <div class="row">                                    

                          </div>
                          <div class="row">                                           


                          </div>
                          <div class="row">                                                                                    
                            <div class="col-lg-10">
                              <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                              <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['requisition']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['requisition']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['requisition']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['requisition']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                              <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>

                              <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                  <span class="caret"></span>
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">

                                </ul>
                              </div>
                              <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
                              <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
                            </div>
                            <div class="col-lg-2 hide">
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
                            <div class="col-lg-3" >
                              <div class="input-group">
                                <span class="input-group-addon">User: </span>
                                <select class="form-control " disabled="" id="user_dropdown">
                                  <option value="" disabled="" selected="">...</option>
                                  ';foreach ($userone as $user): ;echo '                                    <option value="';echo $user['uid'];;echo '">';echo $user['uname'];;echo '</option>
                                  ';endforeach;;echo '                                </select>
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
                                  <th class="numeric text-right">Qty%</th>
                                  <th class="numeric text-right">Weight</th>
                                  <th class="numeric text-right">Rate</th>
                                  <th class="numeric text-right">Lvendor</th>
                                  <th class="numeric text-right">Lstock</th>
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
                <label>Last 5 Purchase Rates</label>
                <table class="table table-striped Lrates_table font_tbl">
                  <thead>
                    <tr>
                      <th>Vr #</th>
                      <th>Date</th>
                      <th class="text-right">Qty</th>
                      <th class="text-right">Rate</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>

                    </tr>
                  </tbody>
                       
                            </table>
                          </div>
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

                                  <td class="text-right txtbold" colspan=\'\' >Totals</td>
                                  <td class="TotalLstocks text-right txtbold"></td>
                                  <td class="TotalLWeights text-right txtbold"></td>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                      </div>  <!-- end of level 1-->
                    </div>
                  </div>
                </div>
              </div>

              <div id="bulkitem-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header" style="background:#64b92a !important; color:white !important;padding-bottom:20px !important;">
                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <h3 id="myModalLabel">Select Items Lookup</h3>
                    </div>

                    <div class="modal-body">
                      <div class="row">
                        <div class="col-lg-3">
                          <label >WorkOrder#</label>                    
                          <input type="text" class="form-control input-sm num" id="txtworkOrderNo2" disabled="">
                        </div>
                        <div class="col-lg-3"></div>

                        

                      </div>
                      <div class="row">
                        <div class="col-lg-3">
                          <label >Catogeory</label>                    
                          <select  class="form-control input-sm select2" multiple="true" id="drpCatogeoryid" data-placeholder="Choose Category....">

                          </select>           
                        </div>
                        <div class="col-lg-3">
                          <label >Sub Catogeory</label>                    
                          <select  class="form-control input-sm select2" multiple="true" id="drpSubCat" data-placeholder="Choose SubCategory....">
                          </select>    
                        </div>

                        <div class="col-lg-3" >
                          <label >Brand</label>        
                          <select  class="form-control input-sm select2 " multiple="true" id="drpbrandID" data-placeholder="Choose Brand....">
                          </select>
                        </div>
                        
                      </div>

                    </div>
                    <div class="modal-footer">

                      <button class="btn btn-primary btnGetItemsModel" data-get="modal">Show</button>
                      <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>

;'
?>

