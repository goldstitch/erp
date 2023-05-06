

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="pr-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort" style="width:20px;">Sr#</th>
    <th class="no_sort">Account</th>
    <th class="no_sort">Address</th>
    <th class="no_sort">Email</th>
    <th class="no_sort">Contact</th>
    <th class="no_sort">Phone</th>
    <th class="no_sort" style="text-align:right; !important">Balance</th>
  </tr>
</script>
<script id="pr-row-template" type="text/x-handlebars-template">
  <tr>
    <td class="no_sort tblSerial">{{SERIAL}}</td>
    <td class="no_sort tblParty">{{PARTY}}</td>
    <td class="no_sort tblAddress">{{ADDRESS}}</td>
    <td class="no_sort tblEmail">{{EMAIL}}</td>
    <td class="no_sort tblMobile">{{MOBILE}}</td>
    <td class="no_sort tblPhone">{{PHONE_OFF}}</td>
    <td class="no_sort tblBalance" style="text-align:right; !important">{{BALANCE}}</td>
  </tr>
</script>
<script id="pr-netsum-template" type="text/x-handlebars-template">
  <tr class="subsum_tr">
    <td class="no_sort"></td>
    <td class="no_sort"></td>
    <td class="no_sort"></td>
    <td class="no_sort"></td>
    <td class="no_sort"></td>
    <td class="no_sort text-right">Net</td>
    <td class="no_sort netamt_td" style="text-align:right; !important">{{NETSUM}}</td>
  </tr>
</script>
<script id="db-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort" style="width:20px;">Sr#</th>
    <th class="no_sort" style="width:50px; !important">Date</th>

    <th class="no_sort" style="width:280px; !important" >Account</th>
    <th class="no_sort">Remarks</th>
    <th class="no_sort">Vr#</th>
    <th class="no_sort">Inv#</th>
    <th class="no_sort">Contra Account</th>

    <th class="no_sort dont-show">Etype</th>
    <th class="no_sort">WO</th>
    <th class="no_sort">Debit</th>
    <th class="no_sort">Credit</th>
  </tr>
</script>
<script id="db-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td class="dont-show"></td>
    <td>{{PARTY}}</td>
    <td class="printRemove"></td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="db-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td style="text-transform:uppercase;">{{{VRNOA}}}</td>
    <td class="dont-show"></td>
    <td class="printRemove"></td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="db-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td class="">{{DATE1}}</td>
    <td></td>
    <td></td>
    <td></td>

    <td class="dont-show"></td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="bpv-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort" style="width:30px;">Sr</th>
    <th class="no_sort">Date</th>
    <th class="no_sort">Voucher#</th>
    <th class="no_sort">Account</th>
    <th class="no_sort printRemove">Remarks</th>
    <th class="no_sort">Cheq#</th>
    <th class="no_sort">Cheq Date </th>
    <th class="no_sort text-right">Credit</th>
    <th class="no_sort text-right">Debit</th>
  </tr>
</script>
<script id="jv-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort" style="width:20px;">Sr#</th>
    <th class="no_sort">Date</th>
    <th class="no_sort">Voucher#</th>
    <th class="no_sort">Account</th>
    <th class="no_sort printRemove">Remarks</th>
    <th class="no_sort">Credit</th>
    <th class="no_sort">Debit</th>
  </tr>
</script>

<script id="jv-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td>{{PARTY}}</td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="bpv-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td>{{PARTY}}</td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="jv-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td>{{{VRNOA}}}</td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="bpv-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td>{{{VRNOA}}}</td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="jv-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td>{{DATE1}}</td>
    <td class=""></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="bpv-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td>{{DATE1}}</td>
    <td class=""></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="payment-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort" style="width:20px;">Sr#</th>
    <th class="no_sort">Date</th>
    <th class="no_sort">Voucher#</th>
    <th class="no_sort">Account</th>
    <th class="no_sort">Remarks</th>
    <th class="no_sort text-right">Amount</th>
  </tr>
</script>
<script id="db-row-template" type="text/x-handlebars-template">
  <tr>
    <td>{{SERIAL}}</td>
    <td>{{DATE}}</td>
    <td>{{PARTY}}</td>
    <td class="">{{REMARKS}}</td>
    <td style="text-transform:uppercase;">{{{VRNOA}}}</td>
    <td>{{INVOICE}}</td>
    <td>{{PARTY2}}</td>
    <td class="printRemove dont-show">{{ETYPE}}</td>
    <td class="text-left">{{WO}}</td>
    <td class="text-right">{{DEBIT}}</td>
    <td class="text-right">{{CREDIT}}</td>
  </tr>
</script>
<script id="bpv-row-template" type="text/x-handlebars-template">
  <tr>
    <td>{{SERIAL}}</td>
    <td>{{DATE}}</td>
    <td>{{{VRNOA}}}</td>
    <td>{{PARTY}}</td>
    <td class="">{{REMARKS}}</td>
    <td class="text-right">{{CHQNO}}</td>
    <td class="">{{CHQDATE}}</td>
    <td class="text-right">{{CREDIT}}</td>
    <td class="text-right">{{DEBIT}}</td>
  </tr>
</script>
<script id="jv-row-template" type="text/x-handlebars-template">
  <tr>
    <td>{{SERIAL}}</td>
    <td>{{DATE}}</td>
    <td>{{{VRNOA}}}</td>
    <td>{{PARTY}}</td>
    <td class="">{{REMARKS}}</td>
    <td class="text-right">{{CREDIT}}</td>
    <td class="text-right">{{DEBIT}}</td>
  </tr>
</script>
<script id="jv-subsum-template" type="text/x-handlebars-template">
  <tr class="subsum_tr">
    <td></td>
    <td></td>
    <td></td>
    <td class=""></td>
    <td class="text-right">Sub</td>
    <td class="text-right">{{SUB_CREDIT}}</td>
    <td class="text-right">{{SUB_DEBIT}}</td>
  </tr>
</script>
<script id="bpv-subsum-template" type="text/x-handlebars-template">
  <tr class="subsum_tr">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class=""></td>
    <td class="text-right">Sub</td>
    <td class="text-right">{{SUB_CREDIT}}</td>
    <td class="text-right">{{SUB_DEBIT}}</td>
  </tr>
</script>
<script id="daybook-subsum-template" type="text/x-handlebars-template">
  <tr class="subsum_tr">
    <td></td>
    <td></td>
    <td></td>

    <td class="dont-show"></td>
    <td class=""></td>
    <td class="printRemove"></td>
    <td class="text-left"></td>
    <td class="text-left"></td>


    <td class="text-right txtbold">Sub Total:</td>

    <td class="text-right txtbold">{{SUB_DEBIT}}</td>
    <td class="text-right txtbold">{{SUB_CREDIT}}</td>
  </tr>
</script>
<script id="daybook-netsum-template" type="text/x-handlebars-template">
  <tr class="netsum_tr">
    <td></td>
    <td></td>
    <td></td>
    
    <td class="dont-show"></td>
    <td class=""></td>
    <td class="text-left"></td>
    
    <td class="printRemove"></td>
    <td class="text-left"></td>
    <td class="text-right txtbold">Grand Total</td>
    <td class="text-right txtbold">{{NET_DEBIT}}</td>
    <td class="text-right txtbold">{{NET_CREDIT}}</td>
  </tr>
</script>
<script id="jv-netsum-template" type="text/x-handlebars-template">
  <tr class="netsum_tr">
    <td></td>
    <td></td>
    <td></td>
    <td class="printRemove"></td>
    <td class="text-right">Net Amount</td>
    <td class="text-right">{{NET_CREDIT}}</td>
    <td class="text-right">{{NET_DEBIT}}</td>
  </tr>
</script>
<script id="bpv-netsum-template" type="text/x-handlebars-template">
  <tr class="netsum_tr">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class=""></td>
    <td class="text-right">Net Amount</td>
    <td class="text-right">{{NET_CREDIT}}</td>
    <td class="text-right">{{NET_DEBIT}}</td>
  </tr>
</script>
<script id="payment-row-template" type="text/x-handlebars-template">
  <tr>
    <td>{{SERIAL}}</td>
    <td>{{DATE}}</td>
    <td>{{{VRNOA}}}</td>
    <td>{{PARTY}}</td>
    <td>{{REMARKS}}</td>
    <td class="text-right">{{AMOUNT}}</td>
  </tr>
</script>
<script id="payment-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td>{{PARTY}}</td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="payment-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td>{{{VRNOA}}}</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="payment-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td>{{DATE1}}</td>
    <td></td>
    <td></td>
  </tr>
</script>
<script id="payment-netsum-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-weight:bold; text-align:right; color:white;">Net Total</td>
    <td class="text-right">{{NETSUM}}</td>
  </tr>
</script>
<script id="payment-subsum-template" type="text/x-handlebars-template">
  <tr class="subsum_tr">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-weight:bold; text-align:right; color:black;">Sub Total</td>
    <td class="text-right">{{SUBSUM}}</td>
  </tr>
</script>
<!-- main content -->
<div id="main_wrapper">

  <div class="page_bar">
    <div class="row">
      <div class="col-md-12">
        <h1 class="page_title">Account Reports</h1>
      </div>
    </div>
  </div>

  <div class="page_content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">

          <div class="row">
            <div class="col-lg-12">


              <div class="panel panel-default">
                <div class="panel-body">

                  <div class="row">
                    <div class="col-lg-3">
                      <div class="input-group">
                        <span class="input-group-addon">From</span>
                        <input class="form-control" type="date" id="from" value="';echo date('Y-m-d');;echo '">
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="input-group">
                        <span class="input-group-addon">To</span>
                        <input class="form-control" type="date" id="to" value="';echo date('Y-m-d');;echo '">
                      </div>
                    </div>

                    <div class="col-lg-6 pull-right">
                      <a href="" class="btn btn-primary show-rept">Show Report</a>
                      <a href="" class="btn btn-danger reset-rept">Reset Filters</a>
                      
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm printCpvCrvBtn" ><i class="fa fa-save"></i>Print F9</button>
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#" class="btnPrintExcel">Excel</li>
                            <li><a data-toggle="modal" href="#addEmail" rel="tooltip"
                              data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</li>
                            </ul>
                          </div>
                          <a href="" class="printPayRcvBtn btn btn-primary" style="display:none;">Print Report</a>
                          <a href="" class="printDayBook btn btn-primary" style="display:none;">Print Report</a>
                        </div>

                      </div>

                      <legend style=\'\'><b>Report Type</b></legend>
                      <div class="row">
                        <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                        <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                        <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
                        <input type="hidden" name="company_name" id="company_name" value="';echo $this->session->userdata('company_name');;echo '">
                        <div class="col-lg-1">
                          <label for="cpv" class="radio cpvRadio">
                            <input type="radio" id="cpv" name="etype" value="cpv" checked="checked" />
                            Payment
                          </label>
                        </div>

                        <div class="col-lg-1">
                          <label for="crv" class="radio crvRadio">
                            <input type="radio" id="crv" name="etype" value="crv" />
                            Receipt
                          </label>
                        </div>
                        <div class="col-lg-1">
                          <label for="jv" class="radio crvRadio">
                            <input type="radio" id="jv" name="etype" value="jv" />
                            Jv
                          </label>
                        </div>
                        <div class="col-lg-2">
                          <label for="jv" class="radio crvRadio">
                            <input type="radio" id="bpv" name="etype" value="bpv" />
                            Bank Payment
                          </label>
                        </div>
                        <div class="col-lg-2">
                          <label for="jv" class="radio crvRadio">
                            <input type="radio" id="brv" name="etype" value="brv" />
                            Bank Receive
                          </label>
                        </div>

                        <div class="col-lg-1">
                          <label for="expense" class="radio crvRadio">
                            <input type="radio" id="expense" name="etype" value="expense" />
                            Expense
                          </label>
                        </div>
                        <div class="col-lg-1">
                          <label for="payable" class="radio crvRadio">
                            <input type="radio" id="payable" name="etype" value="payable" />
                            Payable
                          </label>
                        </div>
                        <div class="col-lg-1">
                          <label for="receiveable" class="radio crvRadio">
                            <input type="radio" id="receiveable" name="etype" value="receiveable" />
                            Receiveable
                          </label>
                        </div>
                        <div class="col-lg-1">
                          <label for="daybook" class="radio crvRadio">
                            <input type="radio" id="daybook" name="etype" value="daybook" />
                            Day Book
                          </label>
                        </div>
                      </div>

                      <legend style=\'\'><b>Group By</b></legend>
                      <div class="row btnSelCre">
                        <div class="col-lg-1">
                          <label for="date" class="radio cpvRadio">
                            <input type="radio" id=\'date\' name="grouping" value="date" checked="checked" />
                            Date Wise
                          </label>
                        </div>

                        <div class="col-lg-1">
                          <label for="voucher" class="radio crvRadio">
                            <input type="radio" id=\'voucher\' name="grouping"  value="invoice" />
                            Voucher Wise
                          </label>
                        </div>

                        <div class="col-lg-1">
                          <label for="party" class="radio crvRadio">
                            <input type="radio" id=\'party\' name="grouping"  value="party" />
                            Party Wise
                          </label>
                        </div>

                        <div class="col-lg-1">
                          <label for="user1" class="radio crvRadio">
                            <input type="radio" id=\'user1\' name="grouping"  value="user" />
                            User Wise
                          </label>
                        </div>

                        <div class="col-lg-1">
                          <label for="month" class="radio crvRadio">
                            <input type="radio" id=\'month\' name="grouping"  value="month" />
                            Month Wise
                          </label>
                        </div>

                        <div class="col-lg-2">
                          <label for="weekday" class="radio crvRadio">
                            <input type="radio" id=\'weekday\' name="grouping"  value="weekday" />
                            Weekday Wise
                          </label>
                        </div>

                        <div class="col-lg-1">
                          <label for="year" class="radio crvRadio">
                            <input type="radio" id=\'year\' name="grouping"  value="year" />
                            Year Wise
                          </label>
                        </div>
                        <div class="col-lg-1">
                          <label for="year" class="radio crvRadio">
                            <input type="radio" id=\'wo\' name="grouping"  value="wo" />
                            Wo Wise
                          </label>
                        </div>

                      </div>


                      <legend style=\'\'>Selection Criteria</legend>
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-lg-12">
                              <button type="button" class="btn btnAdvaced">Advanced</button>
                            </div>
                          </div>
                          <div class="panel-group panel-group1 panelDisplay" id="accordion" role="tablist" aria-multiselectable="true">


                            <div class="panel panel-default">

                              <div class="panel-body">
                                <form class="form-group">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <div class="col-lg-2" >
                                        <label >Account Name
                                        </label>        
                                        <select  class="form-control input-sm select2 " multiple="true" id="drpAccountID" data-placeholder="Choose Party....">

                                         ';foreach( $parties as $party):       ;echo '                                           <option value=';echo $party['pid'];echo '><span>';echo $party['name'];;echo '</span></option>
                                         ';endforeach                ;echo '                                       </select>
                                     </div>
                                     <div class="col-lg-2" >
                                      <label >City
                                      </label>        
                                      <select  class="form-control input-sm select2 " multiple="true" id="drpCity" data-placeholder="Choose city....">

                                       ';foreach( $cities as $citiy):       ;echo '                                         <option value=';echo $citiy['city'];echo '><span>';echo $citiy['city'];;echo '</span></option>
                                       ';endforeach                ;echo '                                     </select>
                                   </div>
                                   <div class="col-lg-2">
                                    <label >Area
                                    </label>                    
                                    <select  class="form-control input-sm select2" multiple="true" id="drpCityArea" data-placeholder="Choose Area....">

                                     ';foreach( $cityareas as $cityarea):         ;echo '                                       <option value=';echo $cityarea['cityarea'];echo '><span>';echo $cityarea['cityarea'];;echo '</span></option>
                                     ';endforeach                ;echo '                                   </select>           
                                 </div>
                                 <div class="col-lg-2">
                                  <label >Level 1
                                  </label>                    
                                  <select  class="form-control input-sm select2" multiple="true" id="drpl1Id" data-placeholder="Choose level1....">

                                   ';foreach( $l1s as $l1):         ;echo '                                     <option value=';echo $l1['l1'];echo '><span>';echo $l1['name'];;echo '</span></option>
                                   ';endforeach                ;echo '                                 </select>    
                               </div>

                               <div class="col-lg-2" >
                                <label >Level 2
                                </label>                    
                                <select  class="form-control input-sm select2" multiple="true" id="drpl2Id" data-placeholder="Choose level2....">

                                 ';foreach( $l2s as $l2):         ;echo '                                   <option value=';echo $l2['l2'];echo '><span>';echo $l2['level2_name'];;echo '</span></option>
                                 ';endforeach                ;echo '  
                               </select>   
                             </div>
                             <div class="col-lg-2" >
                              <label >Level 3
                              </label>                    
                              <select  class="form-control input-sm select2" multiple="true" id="drpl3Id" data-placeholder="Choose level3....">

                               ';foreach( $l3s as $l3):         ;echo '                                 <option value=';echo $l3['l3'];echo '><span>';echo $l3['level3_name'];;echo '</span></option>
                               ';endforeach                ;echo '  
                             </select>   
                           </div>

                           <div class="col-lg-3" >
                            <label >Choose User
                            </label>                    
                            <select  class="form-control input-sm select2" multiple="true" id="drpuserId" data-placeholder="Choose User....">

                             ';foreach( $userone as $user):         ;echo '                               <option value=';echo $user['uid'];echo '><span>';echo $user['uname'];;echo '</span></option>
                             ';endforeach                ;echo '  
                           </select>   
                         </div>

                         <div class="col-lg-3" >
                          <label >Choose Work Order#
                          </label>                    
                          <input type="text" class="form-control input-sm " placeholder="work order#...." id="txtWoNo">      
                        </div>

                      </div>
                    </div>



                  </div>

                </div>
              </div>

            </div>
          </div> 



          <div class="row">
            <div class="col-lg-12">

              <div class="container-fluid grand-debcred-block" style="display:none;">
                <div class="pull-right">
                  <ul class="stats">
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big grand-debit" readonly="" >0.00</span>
                        <span>Grand Debit</span>
                      </div>
                    </li>
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big grand-credit">0.00</span>
                        <span>Grand credit</span>
                      </div>
                    </li>
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big opening-bal">0.00</span>
                        <span>Previous Cash</span>
                      </div>
                    </li>
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big closing-bal">0.00</span>
                        <span>Current Cash</span>
                      </div>
                    </li>
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big purchases-sum">0.00</span>
                        <span>Purchase</span>
                      </div>
                    </li>
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big purchasereturns-sum">0.00</span>
                        <span>Purchase Return</span>
                      </div>
                    </li>
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big sales-sum">0.00</span>
                        <span>Sale</span>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <br>
              <div class="container-fluid grand-debcred-block" style="display:none;">
                <div class="pull-right">
                  <ul class="stats">
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big salereturns-sum">0.00</span>
                        <span>Sale Return</span>
                      </div>
                    </li>
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big payments-sum">0.00</span>
                        <span>Payment</span>
                      </div>
                    </li>
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big receipts-sum">0.00</span>
                        <span>Receipt</span>
                      </div>
                    </li>

                  </ul>
                </div>
              </div>

            </div>
          </div>

          <div class="row">
           <div class="col-lg-4 last_rate hide pull-right">

            <label class="">Cash and Banks</label>
            <table class="table table-striped cashbank_table" id="cashbank_table">
              <thead>
                <tr>
                  <th>Sr#</th>
                  <th>Account</th>
                  <th class="text-right">Opening</th>
                  <th class="text-right">Debit</th>
                  <th class="text-right">Credit</th>
                  <th class="text-right">Balance</th>

                </tr>
              </thead>
              <tbody class="cb_tbody">
                <tr>

                </tr>
              </tbody>
              <tfoot class="cb_tfoot">
                <tr>

                  <td class="text-right txtbold" colspan=\'2\' >Total:</td>
                  <td class="opening_cb text-right txtbold"></td>
                  <td class="debit_cb text-right txtbold"></td>
                  <td class="credit_cb text-right txtbold"></td>
                  <td class="balance_cb text-right txtbold"></td>


                </tr>
              </tfoot>


            </table>
          </div>


          <div class="row hide">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-9">
              <div class="container-fluid grand-amount-block">
                <div class="pull-right">
                  <ul class="stats">
                    <li class=\'blue\'>
                      <i class="fa fa-money"></i>
                      <div class="details">
                        <span class="big grand-amount">0.00</span>
                        <span>Grand Total</span>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">

              <div class="box gradient">
                <div class="title">

                </div>
                <!-- End .title -->
                <div class="content top">
                  <table id="cpv_datatable_example" class="table table-striped full">
                    <thead>
                      <tr>
                        <th class="no_sort">Sr#
                        </th>
                        <th class="no_sort">Date
                        </th>
                        <th class="no_sort">Voucher #
                        </th>
                        <th class="no_sort">Account
                        </th>
                        <th class="no_sort">Remarks
                        </th>
                        <th class="no_sort">Amount
                        </th>
                      </tr>
                    </thead>
                    <tbody id="CPVRows" class=\'parentTableRows\'>
                    </tbody>
                  </table>
                  <!-- End row-fluid -->
                </div>
                <!-- End .content -->
              </div>

            </div>
          </div>

        </div>  <!-- end of panel-body -->
      </div>  <!-- end of panel -->



    </div>  <!-- end of col -->
  </div>  <!-- end of row -->

</div>  <!-- end of level 1-->
</div>
</div>
</div>
</div>
<div id="addEmail" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header" style="background:#76c143;color:white;padding-bottom:20px;">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
      ×</button>
      <h3 id="myModalLabel">Email</h3>
    </div>

    <div class="modal-body">
      <div style="padding: 10px;">
        <div class="form-row control-group row-fluid">
          <label>Enter email address here:</label>
          <input id="txtAddEmail" type="text" style="width: 80%;">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal">
      Close</button>
      <button id="btnSendEmail" class="btn btn-primary">
      Send</button>
    </div>
  </div>
</div>
</div>';
?>