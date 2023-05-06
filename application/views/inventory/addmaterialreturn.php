

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
     <td>{{ITEMNAME}}</td>
     <td>{{REMARKS}}</td>
     <td class="text-right">{{QTY}}</td>
     <td class="text-right">{{WEIGHT}}</td>
     <td class="text-right">{{AMOUNT}}</td>
 </tr>
</script>
<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">

     <td class="tblInvoice"></td>
     <td class="tblInvoice"></td>
     <td class="tblInvoice"></td>
     <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
     <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_QTY_SUM }}</td>
     <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_WEIGHT_SUM }}</td>
     <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_AMOUNT_SUM }}</td>
 </tr>
</script>
';
$desc = $this->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$vouchers = $desc['vouchers'];
;echo '

<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-4">
                <h1 class="page_title">Material Return Voucher</h1>
            </div>
            <div class="col-lg-8">
                <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['materialreturnvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['materialreturnvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['materialreturnvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['materialreturnvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                <a class="btn btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li ><a href="#" class="btnprintAccount"> Account Print</a></li>
                    <!-- <li ><a href="#" class="btnPrint"> Print with header</li> -->
                        <!-- <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li> -->
                        </ul>
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

                                                                <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                                                <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                                                <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                                                                <input type="hidden" name="edit_qty" id="edit_qty" value="0">
                                                                <input type="hidden" name="edit_weight" id="edit_weight" value="0">

                                                                </div>
                                                            </div>
                                                       

                                                            <div class="col-lg-3">
                                                                <div class="input-group">
                                                                    
                                                                    <span class="input-group-addon txt-addon VoucherNoLable">Date</span>
                                                                    ';if ($vouchers['date_close']['insert'] == 1){;echo '                                                                        <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                                                                    ';}else{;echo '                                                                        <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" readonly="">
                                                                    ';};echo '                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon txt-addon VoucherNoLable">Vr#</span>
                                                                        
                                                                        <input type="text" class="form-control" id="txtVrno" readonly=\'true\'>
                                                                        <input type="hidden" id="txtMaxVrnoHidden">
                                                                        <input type="hidden" id="txtVrnoHidden">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <label>Checked By</label>
                                                                        <input class=\'form-control\' type=\'text\' list="checkers" id=\'checkers_list\'>
                                                                        <datalist id=\'checkers\'>
                                                                            ';foreach ($receivers as $receiver): ;echo '                                                                                <option value="';echo $receiver['received_by'];;echo '">
                                                                                ';endforeach ;echo '                                                                            </datalist>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label>WO#</label>
                                                                            <input type="text" class="form-control" id="txtWorkOrder">
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <label>Remarks</label>
                                                                            <input type="text" class="form-control" id="txtRemarks">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row"></div>

                                                                    <div class="container-wrap">
                                                                        <div class="row">

                                                                            <div class="col-lg-7">
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

                                                                            <div class="col-lg-1" >
                                                                                <label> Uom</label>
                                                                                <input type="text" class="form-control num" id="txtUom" readonly="" tabindex="-1">
                                                                            </div>
                                                                            <div class="col-lg-2">
                                                                                <label>Work Detail </label>
                                                                                <input class=\'form-control\' type=\'text\' list="workdetails" id=\'workdetail_list\' placeholder=\'Work Detail\'>
                                                                                <datalist id=\'workdetails\'>
                                                                                    ';foreach ($workdetails as $workdetail): ;echo '                                                                                        <option value="';echo $workdetail['workdetail'];;echo '"></option>
                                                                                    ';endforeach ;echo '                                                                                </datalist>
                                                                            </div>
                                                                            <div class="col-lg-2">
                                                                                <label>Receiver </label>
                                                                                <input class=\'form-control\' type=\'text\' list="itemreceivers" id=\'itemreceivers_list\' placeholder=\'Received By\'>
                                                                                <datalist id=\'itemreceivers\'>
                                                                                    ';foreach ($itemreceivers as $itemreceiver): ;echo '                                                                                        <option value="';echo $itemreceiver['received_by'];;echo '"></option>
                                                                                    ';endforeach ;echo '                                                                                </datalist>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">

                                                                            <div class="col-lg-3">
                                                                                <label>Department </label>
                                                                                <select class="form-control select2" id="dept_dropdown">
                                                                                    <option value="" disabled="" selected="">Department</option>
                                                                                    ';foreach ($departments as $department): ;echo '                                                                                        <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                                                    ';endforeach ;echo '                                                                                </select>
                                                                            </div>

                                                                            <div class="col-lg-2" >
                                                                                <label> Qty</label>
                                                                                <input type="text" class="form-control num" id="txtSQty">
                                                                            </div>
                                                                            <div class="col-lg-2" >
                                                                                <label> Weight</label>
                                                                                <input type="text" class="form-control num" id="txtWeight">
                                                                            </div>
                                                                            <div class="col-lg-1">
                                                                                <label>Cost </label>
                                                                                <input type="text" class="form-control num" id="txtRate">
                                                                            </div>
                                                                            <div class="col-lg-2">
                                                                                <label>Amount</label>
                                                                                <input type="text" class="form-control num" id="txtAmount" readonly="true" tabindex="-1">
                                                                            </div>
                                                                            <div class="col-lg-1">
                                                                                <label>Add </label>
                                                                                <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row"></div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div id="no-more-tables">
                                                                                <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table">
                                                                                    <thead class="cf tbl_thead">
                                                                                        <tr>
                                                                                            <th>Sr#</th>
                                                                                            <th>Item Name</th>
                                                                                            <th>Location</th>
                                                                                            <th>Uom</th>
                                                                                            <th>Work Detail</th>
                                                                                            <th>Received By</th>
                                                                                            <th class="numeric text-right">Qty</th>
                                                                                            <th class="numeric text-right">Weight</th>
                                                                                            <th class="numeric text-right">Cost</th>
                                                                                            <th class="numeric text-right">Amount</th>
                                                                                            <th>Action</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>

                                                                                    </tbody>
                                                                                    <tfoot class="tfoot_tbl">
                                                                                     <tr>
                                                                                         <td data-title="" class="numeric"></td>                                   
                                                                                         <td data-title="" class="numeric" ></td>
                                                                                         <td data-title="" class="numeric"></td>                                   
                                                                                         <td data-title="" class="numeric" ></td>
                                                                                         <td data-title="" class="numeric"></td>                                   
                                                                                         <td data-title="" class="numeric" >Total:</td>  
                                                                                         <td data-title="Qty" class="numeric" id="txtGQty"></td>
                                                                                         <td data-title="Weight" class="numeric" id="txtGWeight"></td>
                                                                                         <td data-title="" class="numeric"></td>
                                                                                         <td data-title="Amount" class="numeric" id="txtGAmnt"></td> 
                                                                                         <td data-title="" class="numeric"></td> 
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
                                                                <div class="col-lg-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                                            <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['materialreturnvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['materialreturnvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['materialreturnvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['materialreturnvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                                                            <a class="btn btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                                                            <div class="btn-group">
                                                                                <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                                  <span class="caret"></span>
                                                                                  <span class="sr-only">Toggle Dropdown</span>
                                                                              </button>
                                                                              <ul class="dropdown-menu" role="menu">
                                                                                <li ><a href="#" class="btnprintAccount"> Account Print</a></li>
                                                                                <!-- <li ><a href="#" class="btnPrint"> Print with header</li> -->
                                                                                    <!-- <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li> -->
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>  <!-- end of col -->

                                             <!--    <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon fancy-addon">Qty</span>
                                                        <input type="text" class="form-control num" id="txtGQty" readonly="true" tabindex="-1">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon fancy-addon">Weight</span>
                                                        <input type="text" class="form-control num" id="txtGWeight" readonly="true" tabindex="-1">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon fancy-addon" style=\'min-width:0px;\'>Net Amount</span>
                                                        <input type="text" class="form-control num" id="txtGAmnt" readonly="true" tabindex="-1">
                                                    </div>
                                                </div> -->
                                            </div>  <!-- end of row -->
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">                                                                
                                                        <div class="input-group">
                                                          <span class="switch-addon input-group-addon">Print Header?</span>
                                                          <input type="checkbox" checked="" class="bs_switch" id="switchHeader">
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="col-lg-3">in
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
                                                <th>Vr#</th>
                                                <th>Date</th>
                                                <th class="text-left">Item</th>
                                                <th class="text-left">Remarks</th>
                                                <th class="numeric text-right">Qty</th>
                                                <th class="numeric text-right">Weight</th>
                                                <th class="numeric text-right">Amount</th>
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
            <label>Last Rate</label>
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
            <tfoot>
                <tr>
                    <td>Total</td>
                    <td class="TotalLrate"></td>
                </tr>
            </tfoot>
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
</div>
</div>';
?>