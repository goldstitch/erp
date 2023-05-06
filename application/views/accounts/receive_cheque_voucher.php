


<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


$desc = $this->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$vouchers = $desc['vouchers'];
;echo '<script id="cheque-template" type="text/x-handlebars-template">
  <tr>
   <td class="ucase">{{DCNO}}</td>
   <td class="ucase">{{VRDATE}}</td>
   <td class="ucase">{{ACCOUNT}}</td>
   <td class="ucase">{{BANK_NAME}}</td>
   <td class="ucase">{{CHEQUE_NO}}</td>
   <td class="ucase">{{CHEQUE_DATE}}</td>
   <td class="ucase text-right">{{AMOUNT}}</td>
   <td class="ucase">{{STATUS}}</td>
   <td class="ucase">{{PARTY_NAME}}</td>
   <td class="ucase">{{POST}}</td>
   <td class="ucase" style="text-align: center;width:20px;"><a href="#" id="btn-edit-sale" class="btn btn-sm btn-primary " class="text-right" data-dcno="{{DCNO}}"><span class="fa fa-edit"></</a></td>
   </tr>
 </script>
 <!-- main content -->
 <div id="main_wrapper">
  <div id="AccountAddModel" class="modal hide fade"  role="dialog" aria-labelledby="AccountAddModelLabel"
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
                      <input type="text" id="txtAccountName" class="form-control" placeholder="Account Name" maxlength="50" tabindex="101">
                    </div>
                    <div class="col-lg-6">
                      <label>Acc Type3</label>
                      <select class="form-control input-sm select2"  id="txtLevel3" tabindex="102">
                        <option value="" disabled="" selected="">Choose Account Type</option>
                        ';foreach ($l3s as $l3): ;echo '                          <option value="';echo $l3['l3'];;echo '" data-level2="';echo $l3['level2_name'];;echo '" data-level1="';echo $l3['level1_name'];;echo '">';echo $l3['level3_name'] ;echo '</option>
                        ';endforeach ;echo '                      </select>
                    </div>
                    <div class="col-lg-12">
                      <span><b>Type 2 &rarr; </b><span id="txtselectedLevel2"> </span> <span><b>Type 1 &rarr; </b><span id="txtselectedLevel1"> </span>
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
          <a class="btn btn-success btnSaveM btn-sm" tabindex="103" data-insertbtn="1"><i class="fa fa-save"></i> Save</a>
          <a class="btn btn-warning btnResetM btn-sm" tabindex="104"><i class="fa fa-refresh"></i> Reset</a>
          <a class="btn btn-danger btn-sm" data-dismiss="modal" tabindex="105" ><i class="fa fa-times"></i> Close</a>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="page_bar">
  <div class="row">
    <div class="col-md-4">
      <h1 class="page_title">Post Dated Cheque Receive</h1>
    </div>
    <div class="col-lg-8">
      <div class="pull-right">
        <a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
        <a href=\'\' class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['chequereceiptvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['chequereceiptvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['chequereceiptvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['chequereceiptvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
        <a href=\'\' class="btn btn-default btnDelete" ><i class="fa fa-trash-o"></i> Delete F12</a>
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li ><a href="#" class="btnPrintAccountVoucher">Account Voucher</li>


            </ul>
          </div>


          <a href=\'#party-lookup\' data-toggle="modal" class="btn btn-default btnSearch"><i class="fa fa-search"></i> Account Search F1</a>

        </div>
      </div>  
    </div>
  </div>

  <div class="page_content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">

          <div class="row">
            <div class="col-lg-12">

              <ul class="nav nav-pills">
                <li class="active"><a href="#addupdateCash" data-toggle="tab">Add/Update Cheque</a></li>
                <li><a href="#searchcash" data-toggle="tab">Search Cheques</a></li>
              </ul>

              <div class="tab-content">
                <div class="tab-pane active" id="addupdateCash">
                  <div class="panel panel-default">
                    <div class="panel-body">

                      <form action="">

                        <div class="row">
                          <div class="col-lg-2">
                            <div class="input-group">
                              <span class="input-group-addon id-addon">Vr#</span>
                              <input type="number" id="txtId" class="form-control num"/>
                              <input type="hidden" id="txtMaxIdHidden"/>
                              <input type="hidden" id="txtIdHidden"/>
                              <input type="hidden" id="voucher_type_hidden"/>
                              <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                              <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                              <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                              <input type="hidden" id="taxid" value="';echo $setting_configur[0]['tax_chq_rec'];;echo '">

                            </div>
                          </div>

                          <div class="col-lg-4"></div>

                          <div class="col-lg-3">
                            <div class="input-group">
                              <span class="input-group-addon txt-addon">Date</span>

                              <input class="form-control input-sm" type="date" id="cur_date" value="';echo date('Y-m-d');;echo '">

                              <input class="form-control input-sm hidden" type="date" id="chk_date" value="';echo date('Y-m-d');;echo '">

                            </div>



                          </div>

                        </div>

                        <legend style=\'margin-top: 35px;\'>Received From</legend>

                        <div class="row">
                          <div class="col-lg-3">
                            <label for="">Party Name <img id="imgPartyLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style ="    font-size: 16px !important;"id="partyBalance"></span></label>
                            <div class="input-group" >
                              <input type="text" class="form-control" id="txtPartyId">
                              <input id="hfPartyId" type="hidden" value="" />
                              <input id="hfPartyBalance" type="hidden" value="" />
                              <input id="hfPartyCity" type="hidden" value="" />
                              <input id="hfPartyAddress" type="hidden" value="" />
                              <input id="hfPartyCityArea" type="hidden" value="" />
                              <input id="hfPartyMobile" type="hidden" value="" />
                              <input id="hfPartyUname" type="hidden" value="" />
                              <input id="hfPartyLimit" type="hidden" value="" />
                              <input id="hfPartyName" type="hidden" value="" />
                              <input id="txtHiddenEditQty" type="hidden" value="" />
                              <input id="txtHiddenEditRow" type="hidden" value="" />


                              <a  tabindex="-1" class="btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                              data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)"> <span class="side_icon glyphicon glyphicon-user">+</a>
                              </div>
                            </div>               

                            <div class="col-lg-3">
                              <label>Bank Name</label>
                              <input type="text" list=\'banks\' class=\'form-control\'  id=\'tobank_dropdown\'>
                              <datalist id=\'banks\'>
                                ';foreach ($banks as $bank): ;echo '                                  <option value="';echo $bank['bank_name'];;echo '">
                                  ';endforeach ;echo '                                </datalist>
                              </div>
                              <div class="col-lg-2">
                                <label>Cheque#/Slip#</label>
                                <input type="text" class="form-control" id="txtChequeNo"/>
                              </div>

                              <div class="col-lg-2">
                                <label>Cheque Date</label>
                                <input class="form-control input-sm" type="date" id="cheque_date" value="';echo date('Y-m-d');;echo '">
                              </div>
                              <div class="col-lg-1">
                                <label>Inv#</label>
                                <input type="text" class="form-control" id="txtSlipNo"/>
                              </div>
                              <div class="col-lg-1">
                                <label>Wo#</label>
                                <input type="text" class="form-control" id="txtwoNo"/>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-2">
                                <label>Status</label>
                                <select class="form-control" id="status_dropdown">
                                  <option value="pending" selected="">Pending</option>
                                  <option value="cleared">Cleared</option>
                                  <option value="dishonored">Dishonored</option>
                                </select>
                              </div>
                              <div class="col-lg-1">
                                <label>Amount</label>
                                <input type="text" class="form-control num" id="txtAmount"/>
                              </div>

                              <div class="col-lg-1">                                                    
                                <label>Tax%</label>
                                <input type="text" class=" form-control num"  id="txtTax">
                              </div>                                                
                              <div class="col-lg-1">                                                    
                                <label>TaxAmount</label>
                                <input type="text" class=" form-control num"  id="txtTaxAmount">
                              </div>

                              <div class="col-lg-1">                                                    
                                <label>NetAmount</label>
                                <input type="text" class=" form-control num"  id="txtNetAmount">
                              </div>

                              <div class="col-lg-2">
                                <label>Note</label>
                                <input type="text" class="form-control" id="txtNote"/>
                              </div>
                              <div class="col-lg-4">
                                <label>Remarks</label>
                                <input type="text" class="form-control" id="txtRemarks"/>
                              </div>
                            </div>

                            <legend style=\'margin-top: 35px;\'>Received To</legend>

                            <div class="row">
                              <div class="col-lg-4">

                               <label for="">Bank Account <img id="imgBankLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
                               <input type="text" class="form-control" id="txtBankId">
                               <input id="hfBankId" type="hidden" value="" />
                               <input id="hfBankName" type="hidden" value="" />
                             </div>
                             <div class="col-lg-2">
                              <label>Mature Date</label>


                              <input class="form-control input-sm" type="date" id="mature_date" value="';echo date('Y-m-d');;echo '">
                            </div>
                            <div class="col-lg-2">                                                        
                              <div class="control-group">
                                <label class="control-label">Action<small><!-- More information here --></small></label>
                                <!-- <div class="controls"> -->
                                  <label class="radio">
                                    <input type="radio" class="postType" name="post" value="unpost" checked="checked"> Un Post
                                  </label>
                                  <label class="radio">
                                    <input type="radio" class="postType" name="post" value="ledger_post"> Post in Ledger
                                  </label>
                                  <!-- </div> -->
                                </div>
                              </div>
                              <div class="col-lg-3"> </div>

                            </div>

                            <div id="party-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header" style="background:#64b92a !important; color:white !important;padding-bottom:20px !important;">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h3 id="myModalLabel">Party Lookup</h3>
                                  </div>

                                  <div class="modal-body">
                                    <table class="table table-striped modal-table" id ="tblAccounts">

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

                                      </tbody>
                                    </table>
                                  </div>
                                  <div class="modal-footer">

                                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">


                              <div class="col-lg-12">
                                <div class="pull-right">
                                  <a href=\'\' class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['chequereceiptvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['chequereceiptvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['chequereceiptvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['chequereceiptvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                  <a href=\'\' class="btn btn-default btnDelete" ><i class="fa fa-trash-o"></i> Delete F12</a>
                                  <a href=\'\' class="btn btn-default btnPrint btnPrint1" ><i class="fa fa-print"></i> Print F9</a>
                                  <a href=\'\' class="btn btn-default btnPrint btnPrintAccount" ><i class="fa fa-print"></i> Account Voucher</a>
                                  <a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                  <a href=\'#party-lookup\' data-toggle="modal" class="btn btn-default btnsearchparty"><i class="fa fa-search"></i> Account Search F1</a>
                                  <!-- <a href=\'\' class="btn btn-default btnPartySearch"><i class="fa fa-search"></i> Account Search F1</a> -->
                                  <!-- <a href="#party-lookup" data-toggle="modal" class="btn btn-default btnSearch"><i class="fa fa-search"></i>Account Lookup F1</a> -->
                                </div>
                              </div>  <!-- end of col -->
                            </div>  <!-- end of row -->
                            <div class="row">




                              <div class="col-lg-2">
                                <div class="form-group">                                                                
                                  <div class="input-group">
                                    <span class="switch-addon">Print Header?</span>
                                    <input type="checkbox" checked="" class="bs_switch" id="switchPrintHeader">
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-1"></div>
                              <div class="col-lg-3">
                                <div class="input-group">
                                  <span class="input-group-addon">User: </span>
                                  <input type="text" class=" form-control"  id="txtUserName" >

                                </div>
                              </div>
                              <div class="col-lg-3">
                                <div class="input-group">
                                  <span class="input-group-addon">Posting: </span>
                                  <input type="text" class=" form-control"  id="txtPostingDate" >

                                </div>
                              </div>                                             
                            </div>

                          </form> <!-- end of form -->

                        </div>  <!-- end of panel-body -->
                      </div>  <!-- end of panel -->
                    </div>

                    <div class="tab-pane" id="searchcash">
                      <div class="panel panel-default">
                        <div class="panel-body">

                          <div class="row">
                            <div class="col-lg-3">
                              <div class="input-group">
                                <label>From</label>
                                <input class="form-control ts_datepicker" type="text" id="from_date">
                              </div>
                            </div>
                            <div class="col-lg-3">
                              <div class="input-group">
                                <label>To</label>
                                <input class="form-control ts_datepicker" type="text" id="to_date">
                              </div>
                            </div>

                            <div class="col-lg-2">
                              <a href=\'\' class="btn btn-default btnSearch"><i class="fa fa-search"></i> Search</a>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              <table id="datatable_Cheques" class="table table-striped full table-bordered">
                                <thead>
                                  <tr>
                                    <th style="">Vr#
                                    </th>
                                    <th class="no_sort">Date
                                    </th>
                                    <th class="no_sort">Account
                                    </th>
                                    <th class="">Bank Name
                                    </th>
                                    <th class="">Cheque#
                                    </th>
                                    <th class="">ChqDate
                                    </th>
                                    <th class="">Amount
                                    </th>
                                    <th class="">Status
                                    </th>
                                    <th class="">Party Name
                                    </th>
                                    <th class="">Led Post
                                    </th>
                                    <th class="">Actions
                                    </th>
                                  </tr>
                                </thead>
                                <tbody id="VoucherRows">
                                </tbody>
                              </table>
                            </div>
                          </div>

                        </div>  <!-- end of panel-body -->
                      </div>  <!-- end of panel -->
                    </div>
                  </div>

                </div>  <!-- end of col -->
              </div>  <!-- end of row -->

            </div>  <!-- end of level 1-->
          </div>
        </div>
      </div>
    </div>';
?>