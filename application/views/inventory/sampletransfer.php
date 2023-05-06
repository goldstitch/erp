

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
   <td>{{{SERIAL}}}</td>
   <td>{{VRDATE}}</td>
   <td>{{ITEMNAME}}</td>
   <td>{{DEPTFROM}}</td>
   <td>{{UOM}}</td>
   <td class="text-right">{{QTY}}</td>
   <td class="text-right">{{WEIGHT}}</td>
   <td>{{DEPTTO}}</td>
 </tr>
</script>
<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">

   <td class="tblInvoice"></td>
   <td></td>
   <td class="tblInvoice"></td>
   <td></td>
   <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
   <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_WEIGHT_SUM }}</td>
   <td class="tblInvoice"></td>
   <td></td>
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

  <div class="page_bar">
    <div class="row">
      <div class="col-md-4">
        <h1 class="page_title">Sample Issuance Voucher</h1>
      </div>
      <div class="col-lg-8">
        <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
        <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['navigationvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['navigationvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['navigationvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['navigationvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
        <a class="btn btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
          <button type="button" class="btn btn-primary btn-sm dropdown-toggle btn_right_print" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <!-- <li ><a href="#" class="btnPrint"> Print with header</li> -->
              <!-- <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li> -->
              </ul>
            </div>
            <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
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
                    <tr >
                      <th>Id</th>
                      <th>Article#</th>
                      <th>Description</th>
                      <th>Code</th>
                      <th>Uom</th>
                      <th style=\'width:3px;\'>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    ';foreach ($items as $item): ;echo '                      <tr>
                        <td >
                          ';echo $item['item_id'];;echo '                          <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                        </td>
                        <td>';echo $item['artcile_no'];;echo '</td>
                        <td>';echo $item['item_des'];;echo '</td>
                        <td>';echo $item['item_code'];;echo '</td>
                        <td>';echo $item['uom'];;echo '</td>
                        <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa fa-search"></i></a></td>
                      </tr>
                    ';endforeach ;echo '                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
              </div>
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
                                    <input type="number" class="form-control VoucherNo" id="txtVrnoa" >
                                    <input type="hidden" id="txtMaxVrnoaHidden">
                                    <input type="hidden" id="txtVrnoaHidden">
                                    <input type="hidden" id="voucher_type_hidden">
                                    <input type="hidden" id="stock" value="">
                                    <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                    <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                    <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                                  </div>
                                </div>
                                <div class="col-lg-2">
                                  <div class="input-group">
                                    <span class="input-group-addon txt-addon VoucherNoLable">Vr#</span>
                                    <input type="text" class="form-control" id="txtVrno" readonly=\'true\'>
                                    <input type="hidden" id="txtMaxVrnoHidden">
                                    <input type="hidden" id="txtVrnoHidden">
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="input-group">
                                    <span class="input-group-addon txt-addon VoucherNoLable">Date</span>
                                    ';if ($vouchers['date_close']['insert'] == 1){;echo '                                      <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                                    ';}else{;echo '                                      <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" readonly="">
                                    ';};echo '                                  </div>
                                </div>

                                </div>

                    
        
     


                      <div class="row">

                      <div class="col-lg-1">
                      <label>Job Id</label>
                      <input type="text" class="form-control" id="job_id">
                    </div>  

                        <div class="col-lg-1">
                        <label> Id</label>
                        <input type="number" class="form-control" id="issue_id">
                      </div>

                      


                        <div class="col-lg-3">
                          <label>Issue By</label>
                          <input type="text" class="form-control" id="issue" readonly="">
                        </div>  

							  	<div class="col-lg-1">
                                    <label>Receiver Id</label>
                                    <input type="number" class="form-control" id="emp_id">
                                  </div>

								 <div class="col-lg-3">
									  <label>Received By</label>
									  <input type="text" class="form-control" id="receiver" readonly="">
                                  </div>  

				                 <div class="col-lg-2">
                                    <label>Item Barcode</label>
                                    <input type="number" class="form-control" id="barcode">
                                  </div>



                                  
                                  

                                  <div class="col-lg-2">
                                  <label>Job Qty</label>
                                  <input type="text" class="form-control" id="txtjobQty" readonly="">
                                </div>
                                  <div class="col-lg-5">
                                    <label>Remarks</label>
                                    <input type="text" class="form-control" id="txtRemarks">
                                  </div>




                                </div>

                                <div class="row"></div>

                                <div class="container-wrap">
                                  <div class="row">
                                    <div class="col-lg-3">
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
                                      <div class="col-lg-2">
                                        <label>Location From</label>
                                        <input type="text" class="form-control num" id="deptfrom_dropdown"  readonly="">
                                      </div>
                                      <div class="col-lg-1" >
                                        <label>Uom</label>
                                        <input type="text" class="form-control num" id="txtUOM" readonly="true" tabindex="-1">
                                      </div>

                                      <div class="col-lg-1">
                                        <label>Qty</label>
                                        <input type="text" class="form-control num" id="txtSQty">
                                      </div>

                                      <div class="col-lg-1">
                                        <label>Weight</label>
                                        <input type="text" class="form-control num" id="txtWeight">
                                      </div>
                                      <div class="col-lg-2">
                                        <label>Location To</label>
                                        <input type="text" class="form-control num" id="deptto_dropdown"  readonly="">
                                     </select>
                                      </div>
                                      <div class="col-lg-1">
                                        <label>Add</label>
                                        <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row"></div>

                                  <div class="row">
                                    <div class="col-lg-12">
                                      <div id="no-more-tables">
                                        <table class="table table-striped table-bordered" id="purchase_table">
                                          <thead class="cf tbl_thead">
                                            <tr>
                                              <th data-title=\'Sr#\'>Sr#</th>
                                              <th data-title=\'Description\'>Item Name</th>
                                              <th data-title=\'From\'>Location From</th>
                                              <th data-title=\'UOM\'>UOM</th>
                                              <th data-title=\'Weight\' style=\'text-align:right;\'>Qty</th>
                                              <th data-title=\'Weight\' style=\'text-align:right;\'>Weight</th>
                                              <th data-title=\'To\'>Location To</th>
                                              <th data-title=\'Action\'>Action</th>
                                            </tr>
                                          </thead>
                                          <tbody class="saleRows">

                                          </tbody>
                                          <tfoot class="tfoot_tbl">
                                            <td data-title="" class="numeric"></td>
                                            <td data-title="" class="numeric"></td>
                                            <td data-title="" class="numeric"></td>
                                            <td data-title="" class="numeric" style=\'color:red !important; text-align:right;\'>Total:</td>
                                            <td data-title="Qty" class="numeric" id="txtGQty" style=\'text-align:right;\'></td><!-- <input type="text" class="form-control num" id="txtGQty" readonly="true" tabindex="-1" style=\'text-align:right;\'></td> -->
                                            <td data-title="" class="numeric"></td>
                                            <td data-title="" class="numeric"></td>
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
                          <div class="col-lg-12" style="margin-top:-30px;">
                            <div class="panel panel-default">
                              <div class="panel-body">

                                <div class="row">

                                  <div class="col-lg-2 hide">

                                    <label>Wastage%</label>
                                    <input type="text" class="form-control num" id="txtPWeight" style=\'text-align:right;\'>

                                  </div>
                                  <div class="col-lg-2 hide">

                                    <label>Weight</label>
                                    <input type="text" class="form-control num" id="txtAWeight" style=\'text-align:right;\'>

                                  </div>
                                  <div class="col-lg-2 hide">

                                    <label>Net Weight</label>
                                    <input type="text" class="form-control num" id="txtNWeight" readonly="true" style=\'text-align:right;\'>

                                  </div>
                                  <div class="col-lg-2">
                                    <label>Approved By</label>
                                    <input class=\'form-control\' type=\'text\' list="approved" id=\'approved_list\'>
                                    <datalist id=\'approved\'>
                                      ';foreach ($approvedby as $approved): ;echo '                                        <option value="';echo $approved['approved_by'];;echo '">
                                        ';endforeach ;echo '                                      </datalist>
                                    </div> 
                                    <div class="col-lg-2">
                                      <label>Prepared By</label>
                                      <input class=\'form-control\' type=\'text\' list="prepared" id=\'prepared_list\'>
                                      <datalist id=\'prepared\'>
                                        ';foreach ($preparedby as $prepared): ;echo '                                          <option value="';echo $prepared['prepared_by'];;echo '">
                                          ';endforeach ;echo '                                        </datalist>
                                      </div>

                                    </div>  <!-- end of row -->
                                    <div class="row">
                                     <div class="col-lg-8">
                                      <div class="row">
                                        <div class="col-lg-12">
                                          <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                          <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['navigationvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['navigationvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['navigationvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['navigationvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                          <a class="btn btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                          <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle btn_right_print" data-toggle="dropdown" aria-expanded="false">
                                              <span class="caret"></span>
                                              <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                              <!-- <li ><a href="#" class="btnPrint"> Print with header</li> -->
                                                <!-- <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li> -->
                                                </ul>
                                              </div>
                                              <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
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
                                        <div class="col-lg-2"> </div>
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
                                    </div>
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
                                              <th>Sr#</th>
                                              <th>Vrdate</th>
                                              <th>Item Name</th>
                                              <th>Location From</th>
                                              <th>UOM</th>
                                              <th style=\'text-align:right;\'>Qty</th>
                                              <th style=\'text-align:right;\'>Weight</th>
                                              <th>Location To</th>
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

                        </div>  <!-- end of level 1-->

                        <div class="col-md-2">

                          <div class="row">
                            <label>Stock Positons</label>
                            <table class="table table-striped Lstocks_table font_tbl">
                              <thead>
                                <tr>
                                  <th>Item</th>
                                  <th class="text-left">Qty</th>
                                  <th class="text-right">location</th>
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
                                </tr>
                              </tfoot>
                            </table>
                          </div>




                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
?>