

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="cheque-template" type="text/x-handlebars-template">
  <tr>
   <td class="ucase">{{DCNO}}</td>
   <td class="ucase">{{VRDATE}}</td>
   <td class="ucase">{{ACCOUNT}}</td>
   <td class="ucase">{{BANK_NAME}}</td>
   <td class="ucase">{{SLIP_NO}}</td>
   <td class="ucase">{{WO}}</td>
   <td class="ucase">{{CHEQUE_NO}}</td>
   <td class="ucase">{{CHEQUE_DATE}}</td>
   <td class="ucase text-right">{{AMOUNT}}</td>
   <td class="ucase text-right">{{TAX}}</td>

   <td class="ucase">{{STATUS}}</td>
   <td class="ucase">{{PARTY_NAME}}</td>
   <td class="ucase">{{POST}}</td>
</tr>
</script>

<script id="group-head-template" type="text/x-handlebars-template">
  <tr class=\'hightlight_tr\'>
   <td ></td>
   <td ></td>
   <td >{{GROUP_NAME}}</td>
   <td ></td>
   <td ></td>
   <td ></td>
   <td ></td>
   <td ></td>
   <td class="text-right"></td>
   <td class="text-right"></td>

   <td ></td>
   <td ></td>
   <td ></td>
</tr>
</script>

<script id="total-template" type="text/x-handlebars-template">
  <tr class=\'finalsum\'>
   <td ></td>
   <td ></td>
   <td ></td>
   <td ></td>
   <td ></td>
   <td ></td>
   <td ></td>
   <td ><b>{{TOTAL}}</b></td>
   <td class="text-right"><b>{{AMOUNT}}</b></td>
   <td class="text-right"><b>{{TAX}}</b></td>

   <td ></td>
   <td ></td>
   <td ></td>
</tr>
</script>


<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Cheque Reports</h1>                
            </div>
        </div>
    </div>

    <div class="page_content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-addon txt-addon">From</span>
                                        <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                        <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                        <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                        <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-addon txt-addon">To</span>
                                        <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                    </div>
                                </div>

                                <div class="col-lg-6">

                                    <div class="input-group">
                                        <span class="input-group-addon txt-addon">Applied To:</span>
                                        <div class="col-lg-2">
                                            <label for="voucher" class="radio cpvRadio">
                                                <input type="radio" id=\'voucher\' name="date_type" value="voucher" checked="checked" /> 
                                                Voucher
                                            </label>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="cheque" class="radio crvRadio">
                                                <input type="radio" id=\'cheque\' name="date_type" value="cheque" /> 
                                                Cheque
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="mature" class="radio crvRadio">
                                                <input type="radio" id=\'mature\' name="date_type" value="mature" /> 
                                                Mature
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="pdci" class="radio cpvRadio" style="color:green !important;font-weight:bolder !important;">
                                                <input type="radio" id=\'pdci\' name="report_type" value="pd_issue" checked="checked" /> 
                                                Post dated Cheque Issue
                                            </label>
                                        </div>

                                        <div class="col-lg-6">
                                            <label for="pdcr" class="radio crvRadio" style="color:green !important;font-weight:bolder !important;">
                                                <input type="radio" id=\'pdcr\' name="report_type" value="pd_receive" /> 
                                                Post dated Cheque Receive
                                            </label>
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="radio-inline" style="color:red !important;font-weight:bolder !important;">
                                            <input type="radio" name="rbRpt" id="Radio1" value="detailed" checked="checked">
                                            Detailed
                                        </label>
                                        <label class="radio-inline" style="color:red !important;font-weight:bolder !important;">
                                            <input type="radio" name="rbRpt" id="Radio2" value="summary" >
                                            Summary
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="pull-right">

                                        <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                        <a class="btn btn-default btnSearch"><i class="fa fa-search"></i> Show F6</a>
                                        <div class="btn-group">
                                          <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" class="btnPrintExcel">Excel</a>></li>
                                            <li><a data-toggle="modal" href="#addEmail" rel="tooltip"
                                                data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</a></li>
                                            </ul>
                                        </div>

                                        
                                    </div>
                                </div>
                                
                            </div>
                            

                            <legend style=\'\'>Group By</legend>
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

                                <div class="col-lg-1">
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
                                <div class="col-lg-1">
                                    <label for="year" class="radio crvRadio">
                                        <input type="radio" id=\'wo\' name="grouping"  value="wo" />
                                        Cheque Wise
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

                                               ';foreach( $parties as $party):       ;echo '                                                 <option value=';echo $party['pid'];echo '><span>';echo $party['name'];;echo '</span></option>
                                             ';endforeach                ;echo '                                         </select>
                                     </div>

                                     <div class="col-lg-2" >
                                            <label >Bank Name
                                            </label>        
                                            <select  class="form-control input-sm select2 " multiple="true" id="drpBankId" data-placeholder="Choose Bank....">

                                               ';foreach( $parties as $party):       ;echo '                                                 <option value=';echo $party['pid'];echo '><span>';echo $party['name'];;echo '</span></option>
                                             ';endforeach                ;echo '                                         </select>
                                     </div>

                                     <div class="col-lg-2" >
                                      <label >City
                                      </label>        
                                      <select  class="form-control input-sm select2 " multiple="true" id="drpCity" data-placeholder="Choose city....">

                                         ';foreach( $cities as $citiy):       ;echo '                                           <option value=';echo $citiy['city'];echo '><span>';echo $citiy['city'];;echo '</span></option>
                                       ';endforeach                ;echo '                                   </select>
                               </div>
                               <div class="col-lg-2">
                                <label >Area
                                </label>                    
                                <select  class="form-control input-sm select2" multiple="true" id="drpCityArea" data-placeholder="Choose Area....">

                                   ';foreach( $cityareas as $cityarea):         ;echo '                                     <option value=';echo $cityarea['cityarea'];echo '><span>';echo $cityarea['cityarea'];;echo '</span></option>
                                 ';endforeach                ;echo '                             </select>           
                         </div>
                         <div class="col-lg-2">
                          <label >Level 1
                          </label>                    
                          <select  class="form-control input-sm select2" multiple="true" id="drpl1Id" data-placeholder="Choose level1....">

                             ';foreach( $l1s as $l1):         ;echo '                               <option value=';echo $l1['l1'];echo '><span>';echo $l1['name'];;echo '</span></option>
                           ';endforeach                ;echo '                       </select>    
                   </div>

                   <div class="col-lg-2" >
                    <label >Level 2
                    </label>                    
                    <select  class="form-control input-sm select2" multiple="true" id="drpl2Id" data-placeholder="Choose level2....">

                       ';foreach( $l2s as $l2):         ;echo '                         <option value=';echo $l2['l2'];echo '><span>';echo $l2['level2_name'];;echo '</span></option>
                     ';endforeach                ;echo '  
                 </select>   
             </div>
             <div class="col-lg-2" >
              <label >Level 3
              </label>                    
              <select  class="form-control input-sm select2" multiple="true" id="drpl3Id" data-placeholder="Choose level3....">

                 ';foreach( $l3s as $l3):         ;echo '                   <option value=';echo $l3['l3'];echo '><span>';echo $l3['level3_name'];;echo '</span></option>
               ';endforeach                ;echo '  
           </select>   
       </div>

       <div class="col-lg-3" >
        <label >Choose User
        </label>                    
        <select  class="form-control input-sm select2" multiple="true" id="drpuserId" data-placeholder="Choose User....">

           ';foreach( $userone as $user):         ;echo '             <option value=';echo $user['uid'];echo '><span>';echo $user['uname'];;echo '</span></option>
         ';endforeach                ;echo '  
     </select>   
 </div>

 <div class="col-lg-2" >
    <label >Cheque#
    </label>                    
    <input type="text" class="form-control" id="txtChequeNo" name="" value="">   
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

        <table id="datatable_inventory" class="table table-striped full table-bordered dthead">
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
                    <th class="">Inv#
                    </th>
                    <th class="">Wo#
                    </th>
                    <th class="">Cheque#
                    </th>
                    <th class="">ChqDate
                    </th>
                    <th class="">Amount
                    </th>
                    <th class="">Tax
                    </th>
                    <th class="">Status
                    </th>
                    <th class="">Deposited Account
                    </th>
                    <th class="">Led Post
                    </th>
                </tr>
            </thead>
            <tbody id="inventoryRows" class="saleRows">
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