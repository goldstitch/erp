

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<style>
    .span12 { margin-left: 0 !important; }
</style>
<script id="ledger-level0-template" type="text/x-handlebars-template">
    <tr class=\'level0head\'>
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L0NAME}}</td>
        <td class="L0HeadSum" style="text-align: right !important;"></td>
    </tr>
</script>

<script id="ledger-level1-template" type="text/x-handlebars-template">
    <tr class=\'level1head\'>
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L1NAME}}</td>
        <td class="L1HeadSum" style="text-align: right !important;"></td>
    </tr>
</script>
<script id="ledger-finalsum-template" type="text/x-handlebars-template">
    <tr class=\'finalsum never-hide\'>
        <td style="text-align: right !important;">Total: </td>
        <td style="text-align: right !important;"></td>
        <td class="netAmount" style="text-align: right !important;"></td>
    </tr>
</script>
<script id="ledger-level2-template" type="text/x-handlebars-template">
    <tr class=\'level2head\'>
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L2NAME}}</td>
        <td class="L2HeadSum" style="text-align: right !important;"></td>
    </tr>
</script>
<script id="ledger-level3-template" type="text/x-handlebars-template">
    <tr class=\'level3head\'>
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L3NAME}}</td>
        <td class="L3HeadSum" style="text-align: right !important;"></td>
    </tr>
</script>
<script id="ledger-template" type="text/x-handlebars-template">
  <tr class=\'level4row\'>
     <td>{{ACCOUNT_ID}}</td>
     <td>{{PARTY_NAME}}</td>
     <td class="text-right amount" style="text-align:right !important;">{{AMOUNT}}</td>
  </tr>
</script>
<script id="stock-template" type="text/x-handlebars-template">
  <tr>
     <th class="no_sort" style="width: 50px;">Sr#</th>
        <th class="no_sort" style="width: 50px;">ItemId</th>
        <th class="no_sort" style="width: 60px;">Article# </th>
        <th class="no_sort" style="width: 900px;">Description </th>
        <th class="no_sort" style="width: 50px;">Uom </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Qty </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Weight </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Cost </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Value </th>
  </tr>
</script> 
<script id="general-grouptotal-template-value" type="text/x-handlebars-template">
  <tr class="finalsum">
     <td></td>
     <td></td>
     <td></td>
     
     <td style="text-align:right !important;">{{TOTAL}}</td>
     <td></td>
     <td style="text-align:right !important;">{{TOTAL_QTY}}</td>
     <td style="text-align:right !important;">{{TOTAL_WEIGHT}}</td>
     <td></td>
     <td style="text-align:right !important;">{{TOTAL_AMOUNT}}</td>
  </tr>
</script>

<script id="general-vhead-template-value" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td></td>
     <td>{{GROUP1}}</td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
  </tr>
</script>
<script id="general-item-template-value" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{ITEM_ID}}</td>
     <td>{{ARTICLE}}</td>
     <td>{{DESCRIPTION}}</td>
     <td>{{UOM}}</td>
     <td style="text-align:right !important;">{{QTY}}</td>
     <td style="text-align:right !important;">{{WEIGHT}}</td>
     <td style="text-align:right !important;">{{COST}}</td>
     <td style="text-align:right !important;">{{VALUE}}</td>
  </tr>
</script>
<script id="general-head-template-value" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort" style="width: 50px;">Sr#</th>
        <th class="no_sort" style="width: 50px;">ItemId</th>
        <th class="no_sort" style="width: 60px;">Article# </th>
        <th class="no_sort" style="width: 900px;">Description </th>
        <th class="no_sort" style="width: 50px;">Uom </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Qty </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Weight </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Cost </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Value </th>
    </tr>
</script>

<script id="expense-template" type="text/x-handlebars-template">
  <tr>
     <td>{{NAME}}</td>
     <td class="text-right" style="text-align:right !important;">{{AMOUNT}}</td>
  </tr>
</script> 
<div id="main_wrapper">
<div class="container-fluid">   
    
    <!-- <input type="hidden" name="cid" class="cid" value="';echo $this->session->userdata('company_id');;echo '"> -->

    <!-- Take the globally set company id if the user is super admin and normal user id if other -->
    <!-- <input type="hidden" name="cid" class="cid" value="';echo (($this->session->userdata('user_type') === 'Super Admin') &&($this->session->userdata('fix_company_id') !== false)) ?$this->session->userdata('fix_company_id') : $this->session->userdata('company_id');;echo '"> -->

    <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
    <input type="hidden" name="usertype" id="usertype" value="';echo $this->session->userdata('usertype');;echo '">

    <input type="hidden" name="hfCostOfGoodsSold" class="hfCostOfGoodsSold" value="">
    <input type="hidden" name="hfOperatingExpenses" class="hfOperatingExpenses" value="">
    <input type="hidden" name="hfFinanceCost" class="hfFinanceCost" value="">
    <input type="hidden" name="hfNetWPPF" class="hfNetWPPF" value="">
    <input type="hidden" name="hfNetPFT" class="hfNetPFT" value="">
    <!-- 
        NOTE: Added just for the time being
        TODO: Add Proper privilige checks 
    -->                                    
    <!-- Only for admin -->
    <br>
    <br>
    ';if ($this->session->userdata('usertype') === 'Super Admin'): ;echo '        <div class="row fixCompanyHide">
            <div class="input-group">
                <span class="input-group-addon">Chose Unit</span>
                
                <select name="company_id" id="drpCompanyId">
                    <option value=""> All</option>
                    ';foreach ($companies as $company): ;echo '                        <option value="';echo $company['company_id'];;echo '" ';echo ( $company['company_id'] === $this->session->userdata('user_type') ) ?'selected': '';;echo '>';echo $company['company_name'] ;echo '</option>
                    ';endforeach;;echo '                </select>
            </div>
        </div>
    ';endif;;echo '
    <div class="row">
        <div class="col-lg-12">
            <div class="box paint_hover">
                <div class="title">
                    <h3>Detailed Profit/Loss
                    </h3>
                </div>
                <div class="box box-color box-bordered">
                    <div class="box-title">
                        <h5 style="color: white;">Select the filters</h5>
                    </div>
                    <div class="=container-fluid box-content">

                    <div class="row dates-row" style="background: #F5DFDF; padding: 20px 0px 10px; text-align: center; margin-bottom: 15px; ">
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">From</span>
                                    <input type="date" id="from" class="form-control input-sm" value="';echo date('Y-m-d');;echo '" />

                                    <input type="date" id="fromOther" class="form-control input-sm hidden" value="';echo date('Y-m-d');;echo '" />

                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">To</span>
                                    <input type="date" id="to" class="date" value="';echo date('Y-m-d');;echo '" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a href="#" class="btn btn-primary show-rept">Show Report</a>
                                <a href="#" id="btnReset" class="btn btn-danger reload reset-rept">Reset Filters</a>
                                <!-- <a href="#" class="btnProfitLossSheet btn btn-success">Profit/Loss Sheet</a> -->
                                <a href="#" id="btnReset" class="btn btn-info print-normal-pls">Print Profit Loss</a>
                            </div>
                        </div>
                        <div class="row ra-inputs">
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">Opening Stock</span>
                                    <input class="form-control" type="text" name="opening_stock" id="inpOpeningStock" readonly="readonly">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">Purchase</span>
                                    <input class="form-control" type="text" name="purchase" id="inpPurchase" >
                                    <!-- <input class="form-control ts_datepicker" type="text" id="from_date"> -->
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">-Purchase Return</span>
                                    <input class="form-control" type="text" name="purchase_return" id="inpPurchaseReturn" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">=Net Purchase</span>
                                    <input class="form-control" type="text" name="net_purchase" id="inpNetPurchase" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">Gross Profit/Loss</span>
                                    <input class="form-control" type="text" name="gross_profit_loss" id="inpGrossProfitLoss" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">Sale</span>
                                    <input class="form-control" type="text" name="sale" id="inpSale" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">-Sale Return</span>
                                    <input class="form-control" type="text" name="sale_return" id="inpSaleReturn" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">=Net Sale</span>
                                    <input class="form-control" type="text" name="net_sale" id="inpNetSale" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">Closing Stock</span>
                                    <input class="form-control" type="text" name="closing_stock" id="inpClosingStock" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">Other Income</span>
                                    <input class="form-control" type="text" name="other_income" id="inpOtherIncome" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">Total Expenses</span>
                                    <input class="form-control" type="text" name="total_expenses" id="inpTotalExpenses" >
                                </div>
                            </div>
                        </div>
                        <div class="row ra-inputs">
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">Total</span>
                                    <input class="form-control" type="text" name="total_col_1" id="totalCol1" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon" style="width: 204px !important; font-weight:bolder !important;">Total</span>
                                    <input class="form-control" type="text" name="total_col_2" id="totalCol2" >
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="add-on highlight span5" style="width: 204px !important; font-weight:bolder !important; color:red !important; font-size:18px !important;">Net Profit/Loss</span>
                                    <input class="form-control" type="text" style="font-weight:bolder !important; color:black !important; font-size:18px !important;" name="net_profit_loss" id="netProfitLoss" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="content pls">
                    <div class="row">

                        <div class="box gradient">
                            <div class="title">
                            </div>
                            <!-- End .title -->
                            
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#expenseSheet" data-toggle="tab">Expense Sheet</a></li>
                                    <li class=""><a href="#incomeSheet" data-toggle="tab">Other Income</a></li>
                                    <li class=""><a href="#openingStock" data-toggle="tab">Opening Stock</a></li>
                                    <li class=""><a href="#closingStock" data-toggle="tab">Closing Stock</a></li>
                                    <li><a href="#balanceSheet" id="bal-sheet" data-toggle="tab">Balance Sheet</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="expenseSheet">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#" class="btn btn-primary btn-print-expense-sheet">Print</a>
                                            </div>
                                        </div>
                                        <br>
                                        <table class="expenseTable table table-striped full table-bordered">
                                            <thead>
                                                <tr>
                                                    <!-- <th class="no_sort">Sr#
                                                    </th> -->
                                                    <th style="width:80%;">Account</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="expenseRows">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="incomeSheet">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#" class="btn btn-primary btn-print-income-sheet">Print</a>
                                            </div>
                                        </div>
                                        <br>
                                        <table class="incomeTable table table-striped full table-bordered">
                                            <thead>
                                                <tr>
                                                    <!-- <th class="no_sort">Sr#
                                                    </th> -->
                                                    <th style="width:80%;">Account</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="incomeRows">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="openingStock">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#" class="btn btn-primary btn-print-opening-stock">Print</a>
                                            </div>
                                        </div>
                                        <br>
                                        <table id="datatable_example" class="table table-striped full table-bordered">
                                            <thead class=\'dthead\'>
                                                
                                            </thead>
                                            <tbody id="openingStockRows" class="report-rows openingStockRows">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="closingStock">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#" class="btn btn-primary btn-print-closing-stock">Print</a>
                                            </div>
                                        </div>
                                        <br>
                                        <table id="datatable_example" class="table table-striped full table-bordered">
                                            <thead class=\'dthead\'>
                                               
                                            </thead>
                                            <tbody id="closingStockRows" class="report-rows closingStockRows">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="balanceSheet">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="input-group input-append ">
                                                        <span class="input-group-addon">View Detail</span>
                                                        <select name="view_type" id="drpViewType">
                                                            <option value="detail">Detailed</option>
                                                            <option value="summary">Summary</option>
                                                        </select>
                                                        <a href="#" class="btn btn-info btn-level0-view">Level-0</a>
                                                        <a href="#" class="btn btn-info btn-level1-view">Level-1</a>
                                                        <a href="#" class="btn btn-warning btn-level2-view">Level-2</a>
                                                        <a href="#" class="btn btn-primary btn-level3-view">Level-3</a>
                                                        <!-- <a href="#" class="btn btn-success btn-level4-view">Level-4</a> -->
                                                        <a href="#" class="btn btn-info btn-detailed-view">Detailed</a>
                                                        <a href="#" class="btn btn-primary btnPrintBalSheet">Print Balance Sheet</a>
                                                    </div>
                                                    <!-- <div class="input-group">
                                                        <span class="input-group-addon">View Type</span>
                                                    </div> -->
                                                </div>
                                                <!-- <div class="col-lg-4">
                                                    <label class="radio" for="summaryView">
                                                        <input type="radio" class="viewType" name="view_type" value="summary">
                                                        Summary View
                                                    </label>
                                                    <label class="radio" for="detailedView">
                                                        <input type="radio" class="viewType" name="view_type" value="detailed">
                                                        Detailed View
                                                    </label>
                                                </div> -->
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <h4>Assets : <span class="upperasstotal"></span></h4>
                                                    <table id="datatable_Vouchers" class="table full table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr class="never-hide">
                                                                <th class="no_sort" style="width:90px;">Account Id</th>
                                                                <th class="no_sort">Account Name</th>
                                                                <th style="width:100px;">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="ASSETSRows">
                                                            
                                                        </tbody>
                                                        <tfoot id="assetsFoot">
                                                            <tr class=\'stockhead never-hide\'>
                                                                <td>00</td>
                                                                <td>Closing Stock</td>
                                                                <td class="closingStockBalSheet" style="text-align: right !important;"></td>
                                                            </tr>
                                                            <!-- <tr class="never-hide">
                                                                <td class="text-right">Closing Stock</td>
                                                                <td></td>
                                                                <td class="text-right closingStockBalSheet"></td>
                                                            </tr class="never-hide"> -->
                                                            <tr class="never-hide">
                                                                <td class="text-right">Net Total</td>
                                                                <td></td>
                                                                <td class="text-right netAssetsTotal"></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h4>Liabilities : <span class="upperliabtotal"></span></h4>
                                                    <table id="datatable_Vouchers" class="table full table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr class="never-hide">
                                                                <th class="no_sort" style="width:82px;">Account Id</th>
                                                                <th class="no_sort">Account Name</th>
                                                                <th style="width:100px;">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="LIABILITIESRows">
                                                            
                                                        </tbody>
                                                        <tfoot id="liabilitiesFoot">
                                                            <tr class=\'stockhead never-hide\'>
                                                                <td>00</td>
                                                                <td>Profit/Loss</td>
                                                                <td class="plsBalSheet" style="text-align: right !important;"></td>
                                                            </tr>
                                                            <!-- <tr class="never-hide">
                                                                <td class="text-right">Profit/Loss</td>
                                                                <td></td>
                                                                <td class="text-right plsBalSheet"></td>
                                                            </tr> -->
                                                            <tr class="never-hide">
                                                                <td class="text-right">Net Total</td>
                                                                <td></td>
                                                                <td class="text-right netLiabilityTotal"></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End row -->
                            </div>
                            <!-- End .content -->
                        </div>
                        <!-- End box -->
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- End .content -->
    </div>
</div>
</div>
';
?>