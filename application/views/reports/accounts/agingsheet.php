
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="ledger-template" type="text/x-handlebars-template">
  <tr>
      <td>{{PID}}</td>
      <td>{{ACCOUNT}}</td>
      <td class="text-right">{{ CURRENT_BALANCE }}</td>
      <!-- <td class="text-right">{{ LESSTHAN_15_DAYS }}</td> -->
      <td class="text-right">{{ 15_DAYS }}</td>
      <td class="text-right">{{ 30_DAYS }}</td>
      <td class="text-right">{{ 45_DAYS }}</td>
      <td class="text-right">{{ 60_DAYS }}</td>
      <td class="text-right">{{ 75_DAYS }}</td>
      <td class="text-right">{{ 90_DAYS }}</td>
      <td class="text-right">{{ 105_DAYS }}</td>
      <td class="text-right">{{ 120_DAYS }}</td>
      <td class="text-right">{{ LESSTHAN_120_DAYS }}</td>
  </tr>
</script>

<script id="ledger-template-sum" type="text/x-handlebars-template">
  <tr>
      <td></td>
      <td>Total:</td>
      <td class="text-right">{{ SUM_CURRENT_BALANCE }}</td>
      <!-- <td class="text-right">{{ SUM_LESSTHAN_15_DAYS }}</td> -->
      <td class="text-right">{{ SUM_15_DAYS }}</td>
      <td class="text-right">{{ SUM_30_DAYS }}</td>
      <td class="text-right">{{ SUM_45_DAYS }}</td>
      <td class="text-right">{{ SUM_60_DAYS }}</td>
      <td class="text-right">{{ SUM_75_DAYS }}</td>
      <td class="text-right">{{ SUM_90_DAYS }}</td>
      <td class="text-right">{{ SUM_105_DAYS }}</td>
      <td class="text-right">{{ SUM_120_DAYS }}</td>
      <td class="text-right">{{ SUM_LESSTHAN_120_DAYS }}</td>
  </tr>
</script>

<div id="main_wrapper">
<div class="page_content">
<div class="container-fluid">
    
    <input type="hidden" name="cid" class="cid" value="';echo $this->session->userdata('company_id');;echo '">
    <input type="hidden" name="company_name" id="company_name" value="';echo $this->session->userdata('company_name');;echo '">
    <input type="hidden" name="usertype" id="usertype" value="';echo $this->session->userdata('usertype');;echo '">
    <!-- 
        NOTE: Added just for the time being
        TODO: Add Proper privilige checks 
    -->                                    
    <!-- Only for admin -->
    ';if ($this->session->userdata('usertype') === 'Super Admin'): ;echo '        <div class="row">
            <div class="input-group">
                <span class="input-group-addon">Chose Unit</span>
                <select name="company_id" id="drpCompanyId">
                    <option value=""> All </option>
                    ';foreach ($companies as $company): ;echo '                        <option value="';echo $company['company_id'];;echo '" ';echo ( $company['company_id'] === $this->session->userdata('usertype') ) ?'selected': '';;echo '>';echo $company['company_name'] ;echo '</option>
                    ';endforeach;;echo '                </select>
            </div>
        </div>
    ';endif;;echo '
    <div class="row">
        <div class="col-lg-12">
            <div class="box paint_hover">
                
                <div class="page_bar">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page_title reportType" style="text-transform:capitalize;">Creditors Aging Sheet</h1>
                        </div>
                    </div>
                </div>
               <div class="content">
                <form class="form-horizontal cmxform" id="itemDetailValidation"  
                action="">
                                 <div class="row">
                                     <div class="container-fluid">
                                        <div class="col-lg-12">
                                            <div class="col-lg-3 dont-show">
                                                <div class="input-group">
                                                    <span class="input-group-addon">From</span>
                                                    <input type="date" id="txtStart" placeholder="Starting Date" required class="form-control input-sm" value="';echo date('Y-m-d') ;echo '">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                
                                                    <label >Till Date: </label>  
                                                    <input type="date" id="txtEnd" placeholder="End date" class="form-control input-sm" value="';echo date('Y-m-d') ;echo '">
                                                
                                            </div>

                                            <!-- <div class="col-lg-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Party:</span>
                                                    <select id="drpAccId"  name="drpAccId" data-placeholder="Choose a Name..."   class="form-control select2" >
                                                        <option value="">All Parties</option>
                                                        ';foreach ($parties as $party): ;echo '                                                            <option data-address="';echo $party['address'];;echo '" data-accCode="';echo $party['account_id'];;echo '" data-contact="';echo $party['mobile'];;echo '" value="';echo $party['pid'] ;echo '">';echo $party['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-3" >
                                              <label >Account
                                              </label>                    
                                              <select  class="form-control input-sm select2" multiple="true" id="drpAccId" data-placeholder="Choose account ....">
                                                 <!-- <option></option> -->
                                                  ';foreach( $parties as $party):         ;echo '                                                     <option data-address="';echo $party['address'];;echo '" data-accCode="';echo $party['account_id'];;echo '" data-contact="';echo $party['mobile'];;echo '" value="';echo $party['pid'] ;echo '">';echo $party['name'];;echo '</option>
                                                  ';endforeach                ;echo '  
                                              </select>   
                                            </div>

                                            <div class="col-lg-2 l3debitors hide" >
                                              <label >Level Debitors
                                              </label>                    
                                              <select  class="form-control input-sm select2" multiple="true" id="drpl3Iddebitors" data-placeholder="Choose debtors....">
                                                 <!-- <option></option> -->
                                                  ';foreach( $l3sDebitors as $l3):         ;echo '                                                     <option value=';echo $l3['l3'];echo '><span>';echo $l3['level3_name'];;echo '</span></option>
                                                  ';endforeach                ;echo '  
                                              </select>   
                                            </div>
                                            <div class="col-lg-2 l3creditors" >
                                              <label >Level Creditors
                                              </label>                    
                                              <select  class="form-control input-sm select2" multiple="true" id="drpl3Idcreditors" data-placeholder="Choose creditors....">
                                                 <!-- <option></option> -->
                                                  ';foreach( $l3sCreditors as $l3):         ;echo '                                                     <option value=';echo $l3['l3'];echo '><span>';echo $l3['level3_name'];;echo '</span></option>
                                                  ';endforeach                ;echo '  
                                              </select>   
                                            </div>
                                        </div>
                                        <div class="row">
                                            <legend href=\'\' style=\'margin-top: 30px;\'>Report Type</legend>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label for="creditorsAging" class="radio">
                                                    <input type="radio" name="aging_type" id="creditorsAging" class="aging_type" value="creditors" checked="checked" />
                                                    Creditors Aging Sheet
                                                </label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="debitorsAging" class="radio">
                                                    <input type="radio" name="aging_type" id="debitorsAging" class="aging_type" value="debtors" />
                                                    Debitors Aging Sheet
                                                </label>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="col-lg-1">
                                                <label for="creditorsAging" class="radio" style="color: red !important;font-weight:bolder;font-size:12px;">
                                                    <input type="radio" name="aging_type_new" id="BalanceRadio" class="aging_type1" value="Balance_Wise" checked="checked" />
                                                    Balance Wise
                                                </label>
                                            </div>
                                            <div class="col-lg-1">
                                                <label for="debitorsAging" class="radio" style="color: red !important;font-weight:bolder;font-size:12px;">
                                                    <input type="radio" name="aging_type_new" id="DateRadio" class="aging_type12" value="Date_Wise" />
                                                    Date Wise
                                                </label>
                                            </div>

                                            <div class="col-lg-1"></div>

                                            <div class="col-lg-2">
                                                <label for="creditorsAging" class="radio" style="color: green !important;font-weight:bolder;font-size:12px;">
                                                    <input type="radio" name="balance_type_new" id="withZeroRadio" class="aging_type1" value="zero"  />
                                                    With Zero Balance
                                                </label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="debitorsAging" class="radio" style="color: green !important;font-weight:bolder;font-size:12px;">
                                                    <input type="radio" name="balance_type_new" id="withoutZeroRadio" class="aging_type12" value="withoutzero" checked="checked" />
                                                    Without Zero Balance
                                                </label>
                                            </div>


                                        </div>
                                    </div>
                                <br />
                                
                                    <div class="row">
                                        <div class="col-lg-12">
                                           

                                            <a href=\'\'  class="btn btn-default btn-sm btnSearch show-report btnShow">
                                                Show</a>
                                            <a href=\'\'   class="btn btn-default btn-sm btnReset">
                                                Reset</a>
                                            <a href=\'\'  class="btn btn-default btn-sm btnPrint">
                                                Print</a>
                                           
                                            <a href="" class="btn btn-default btn-sm btnPrint3 btnExcel">Excel</a>
                                          
                                        </div>
                                    </div>
                                
                                <div class="container-fluid dont-show">
                                    <div class="pull-right">
                                        <ul class="stats">
                                            <li class=\'blue\'>
                                                <i class="icon-money"></i>
                                                <div class="details">
                                                    <span class="big opening-bal">0.00</span>
                                                    <span>Opening Balance</span>
                                                </div>
                                            </li>
                                            <li class=\'blue\'>
                                                <i class="icon-money"></i>
                                                <div class="details">
                                                    <span class="big net-debit">0.00</span>
                                                    <span>Total Debit</span>
                                                </div>
                                            </li>
                                            <li class=\'blue\'>
                                                <i class="icon-money"></i>
                                                <div class="details">
                                                    <span class="big net-credit">0.00</span>
                                                    <span>Total Credit</span>
                                                </div>
                                            </li>
                                            <li class=\'blue\'>
                                                <i class="icon-money"></i>
                                                <div class="details">
                                                    <span class="big running-total">0.00</span>
                                                    <span>Closing Balance</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            
                        
                    
                </div>
            </div>
        </div>
            
   
</form>
</div>
</div>
</div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            
            <table id="datatable_example" class="table full table-bordered table-striped table-hover">
                <thead>
                    <th style="width:5px;">Acid</th>
                    <th class="no_sort" style="width:150px;">Account</th>
                    <th>Current Balance</th>
                    <!-- <th>Less Than 15 Days</th> -->
                    <th>15 Days</th>
                    <th>30 Days</th>
                    <th>45 Days</th>
                    <th>60 Days</th>
                    <th>75 Days</th>
                    <th>90 Days</th>
                    <th>105 Days</th>
                    <th>120 Days</th>
                    <th>Over 120 Days</th>
                </thead>
                <tbody class="ledgerRows saleRows">
                    
                </tbody>
            </table>

        </div>
    </div>
</div>


<div id="addEmail" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            ×</button>
        <h3 id="myModalLabel">Email</h3>
    </div>
    <div class="modal-body">
        <div style="padding: 10px;">
            <div class="form-row control-group row">
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
</div>

';
?>