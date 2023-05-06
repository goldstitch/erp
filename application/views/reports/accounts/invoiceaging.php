

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="ledger-template-head" type="text/x-handlebars-template">
  <tr>
      
      <th>Vr#</th>
      <th>Date</th>
      <th class="text-right"> Inv Amount</th>
      <th class="text-right"> Balance</th>
      <th class="text-right"> 0-30</th>
      <th class="text-right"> 31-60</th>
      <th class="text-right"> 61-90</th>
      <th class="text-right"> 91-120</th>
      <th class="text-right"> above-120</th>
      
  </tr>
</script>

<script id="ledger-template-head-2" type="text/x-handlebars-template">
  <tr>
      
      <th>Vr#</th>
      <th>Date</th>
      <th style="width:350px;">Account</th>
      <th>Days Passed</th>
      <th>Aging Date</th>
      <th>Invoice Amount</th>
      <th>Paid Amount</th>
      <th>Balance</th>
      
  </tr>
</script>


<script id="ledger-template" type="text/x-handlebars-template">
  <tr>
      
      <td>{{dcno}}</td>
      <td>{{date}}</td>
      <td class="text-right">{{ invoice_amount }}</td>
      <td class="text-right">{{ balance }}</td>
      <td class="text-right">{{ 0_30 }}</td>
      <td class="text-right">{{ 31_60 }}</td>
      <td class="text-right">{{ 61_90 }}</td>
      <td class="text-right">{{ 91_120 }}</td>
      <td class="text-right">{{ abov_120 }}</td>
      
  </tr>
</script>

<script id="ledger-template-sum" type="text/x-handlebars-template">
  <tr class="level3head tfoot_tbl odd">
      <td></td>
      <td>Total:</td>
      <td class="text-right">{{ inv }}</td>
      <td class="text-right">{{ net_balance }}</td>
      <td class="text-right">{{ gross_30 }}</td>
      <td class="text-right">{{ gross_60 }}</td>
      <td class="text-right">{{ gross_90 }}</td>
      <td class="text-right">{{ gross_120 }}</td>
      <td class="text-right">{{ gross_121 }}</td>
  </tr>
</script>

<script id="ledger-template-total-sum" type="text/x-handlebars-template">
  <tr class="group-total-row tfoot_tbl">
      <td></td>
      <td>Grand Total</td>
      <td class="text-right">{{ inv }}</td>
      <td class="text-right">{{ net_balance }}</td>
      <td class="text-right">{{ net_30 }}</td>
      <td class="text-right">{{ net_60 }}</td>
      <td class="text-right">{{ net_90 }}</td>
      <td class="text-right">{{ net_120 }}</td>
      <td class="text-right">{{ net_121 }}</td>
  </tr>
</script>


<script id="voucher-phead-template" type="text/x-handlebars-template">

    <tr class="level3head hightlight_tr odd">
        <td colspan="9">{{account}}</td>
    </tr>
</script>

<script id="voucher-phead-long-template" type="text/x-handlebars-template">

    <tr class="level3head hightlight_tr odd">
        
        <td colspan="9">{{account}}</td>
        
    </tr>
</script>

<script id="voucher-total-template" type="text/x-handlebars-template">
    <tr class="group-total-row tfoot_tbl">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Total Balance</td>
        <td style="text-align: right !important;">{{inv}}</td>
        <td style="text-align: right !important;">{{paid}}</td>
        <td style="text-align: right !important;">{{net_balance}}</td>
    </tr>
</script>


<script id="voucher-item-template" type="text/x-handlebars-template">

    <tr>
        <td>{{dcno}}</td>
        <td>{{date}}</td>
        <td>{{account}}</td>
        <td>{{days_passed}}</td>
        <td>{{due_date}}</td>
        <td style="text-align: right !important;">{{invoice_amount}}</td>
        <td style="text-align: right !important;">{{paid}}</td>
        <td style="text-align: right !important;">{{balance}}</td>
    </tr>
</script>



<script id="voucher-item-template2222" type="text/x-handlebars-template">
	<tr>
		<td>{{dcno}}</td>
		<td>{{vrdate}}</td>
		<td>{{account}}</td>
		<td>{{days_passed}}</td>
		<td>{{due_date}}</td>
		<td style="text-align: right !important;">{{invoice_amount}}</td>
		<td style="text-align: right !important;">{{paid}}</td>
		<td style="text-align: right !important;">{{balance}}</td>
	</tr>
</script>




<div id="main_wrapper">

    <div class="page_bar" style="margin-top: 22px;">
        <div class="row-fluid">
            <div class="col-md-12">
                <h1 class="page_title" style="margin:-20px 0px 0px 0px;"><i class="fa fa-list"></i> Invoice Aging Report</h1>

            </div>
        </div>
    </div>

    <div class="page_content">
        <div class="container-fluid">
            ';if ($this->session->userdata('usertype') === 'Super Admin'): ;echo '                <div class="row">
                    <div class="input-group">
                        <span class="input-group-addon">Chose Unit</span>
                        <select name="company_id" id="drpCompanyId">
                            <option value=""> All </option>
                            ';foreach ($companies as $company): ;echo '                                <option value="';echo $company['company_id'];;echo '" ';echo ( $company['company_id'] === $this->session->userdata('user_type') ) ?'selected': '';;echo '>';echo $company['company_name'] ;echo '</option>
                            ';endforeach;;echo '                        </select>
                    </div>
                </div>
            ';endif;;echo '            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-body" style="margin-top: -20px;">

                                    <div class="row">
                                      <div class="col-lg-12">
                                           <div class="form-group">
                                            <div class="row">
                                              <div class="col-lg-2">
                                                <label>From</label>
                                                <span class="add-on"><i class="icon-calendar"></i></span>

                                                <input type="date" id="from_date" placeholder="Starting Date" required class="form-control" value="';echo date('Y-m-d');;echo '">

                                                

                                              </div>
                                              <div class="col-lg-2">
                                                <label>To</label>
                                                <span class="add-on"><i class="icon-calendar"></i></span>

                                                <input type="date" id="to_date" placeholder="End date" class="form-control" value="';echo date('Y-m-d');;echo '">

                                                

                                              </div>
                                              <div class="col-lg-2">
                                                <label>Report Type</label>
                                                <select name="drpReptType" id="reptType" class="form-control select2">
                                                  <option value="payables">Payables</option>
                                                  <option value="receiveables">Receiveables</option>
                                                </select>
                                              </div>
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
                                              <select  class="form-control input-sm select2" multiple="true" id="drpl3Iddebitors" data-placeholder="Choose debitors....">
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
                                          </div>
                                      </div>
                                    
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-2">
                                          <div class="form-group">
                                              <label class="radio-inline">
                                                  <input type="radio" name="rbRpt" id="Radio1" value="detailed" checked="checked" >
                                                  Detailed
                                              </label>
                                              <label class="radio-inline">
                                                  <input type="radio" name="rbRpt" id="Radio2"  value="summary">
                                                  Summary
                                              </label>
                                          </div>
                                    </div>
                                    <div class="col-lg-2">
                                          <div class="form-group">
                                              <label class="radio-inline">
                                                  <input type="radio" name="shortlong" id="Radio3" value="short" >
                                                  Short
                                              </label>
                                              <label class="radio-inline">
                                                  <input type="radio" name="shortlong" id="Radio4" checked="checked" value="long">
                                                  Long
                                              </label>
                                          </div>
                                    </div>

                                    <div class="col-lg-8">
                                    <div class="pull-right">
                                      
                                        
                                            <button id="btnShow" type="button" class="btn btn-secondary show-report btn-primary">
                                                <i class="fa fa-list"></i> Show</button>
                                            <button id="btnReset" type="reset" class="btn btn-secondary reload btn-danger">
                                                <i class="fa fa-refresh"></i> Reset</button>
                                            <button id="btnPrint" class="btn btn-secondary btn-success">
                                                <i class="fa fa-print"></i> Print</button>
                                            <input type="button" class="btn btn-info btnExcel" value="Export Excel" />
                                            <a id="btnEmail" class="btn btn-secondary btn-success" data-toggle="modal" data-target="#myModal" rel="tooltip"
                                                                    data-placement="top" data-original-title="Add Email"><i class="fa fa-envelope"></i> Email</a>
                                    
                                    
                                    </div>
                                    </div>
                                    </div>

                                    

                                    <div class="row">
        <div class="col-lg-12">
            
            <table id="datatable_example" class="table full table-bordered table-striped table-hover ">
                <thead class="dthead">
                    <tr >
                      <th>Vr#</th>
                      <th>Date</th>
                      <th style="width:350px;">Account</th>
                      <th>Days Passed</th>
                      <th>Aging Date</th>
                      <th>Invoice Amount</th>
                      <th>Paid Amount</th>
                      <th>Balance</th>
                    </tr>
                </thead>
                <tbody class="saleRows">
                    
                </tbody>
            </table>
            <div class="container-fluid">
    
    <input type="hidden" name="cid" class="cid" value="';echo $this->session->userdata('company_id');;echo '">
    <input type="hidden" name="company_name" id="company_name" value="';echo $this->session->userdata('company_name');;echo '">

    
    

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


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#368ee0;color:white;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope"></i> Email</h4>
      </div>
      <div class="modal-body">
      <div class="form-group">
      <div class="row">
      <div class="col-lg-10">
      <label>Enter email address here:</label>
      <input id="txtAddEmail" type="text" class="form-control">

      </div>
      </div>
      </div>
      </div>
      <div class="modal-footer">
        <div class="pull-right">
          <button id="btnSendEmail" class="btn btn-primary">
            <i class="fa fa-share"></i> Send</button>
           <button class="btn" data-dismiss="modal">
            <i class="fa fa-times-circle"></i> Close</button>
        
        </div>
        
      </div>
    </div>
  </div>
</div>';
?>