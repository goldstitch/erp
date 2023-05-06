

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="ledger-level3-template" type="text/x-handlebars-template">
    <tr class=\'level3head\' style="color:blue; font-weight: bolder;">
        <td></td>
        <td class=\'text-right\'>{{TOTAL}}</td>
        <td class=\'text-right\'>{{DEBIT}}</td>
        <td class=\'text-right\'>{{CREDIT}}</td>
        <td class=\'text-right\'>{{PERCENT}}</td>

    </tr>
</script>

<script id="ledger-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{PARTY_NAME}}</td>
   <td class="text-right">{{DEBIT}}</td>
   <td class="text-right">{{CREDIT}}</td>
   <td class=\'text-right\'>{{PERCENT}}</td>

</tr>
</script>



<script id="ledger-level1-template" type="text/x-handlebars-template">
    <tr class=\'level1head\' style="color:red; font-weight: bolder;">
        <td></td>
        <td>{{L3NAME}}</td>
        <td></td>
        <td></td>
        <td></td>

    </tr>
</script>

<script id="ledger-finalsum-template" type="text/x-handlebars-template">
    <tr class=\'finalsum\' style="color:black; font-weight: bolder;">
        <td></td>
        <td style="text-align: right !important;">Grand Total: </td>
        <td style="text-align: right !important;">{{DEBIT}}</td>
        <td style="text-align: right !important;">{{CREDIT}}</td>
        <td class=\'text-right\'>{{AGE}}</td>

    </tr>
</script>

<script id="ledger-level2-template" type="text/x-handlebars-template">
    <tr class=\'level2head\' style="color:green; font-weight: bolder;">
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L2NAME}}</td>
        <td style="text-align: right !important;">{{L2DebSUM}}</td>
        <td style="text-align: right !important;">{{L2CredSUM}}</td>
    </tr>
</script>





<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Order Wise Profit Loss</h1>
            </div>
        </div>

    </div>

    <div class="page_content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row hide">
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-addon txt-addon">From</span>
                                        <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-addon txt-addon">To</span>
                                        <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                            <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                            <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Work Order# </label>
                                    <select id="drpOrderNo" data-placeholder="Choose Order#....." class="form-control select2" >
                                        <option value="-1" disabled selected>Chose Order#</option>
                                        ';foreach ($Orders as $order): ;echo '                                            <option  value="';echo $order['vrnoa'];;echo '">';echo  $order['party_name']   ;;echo '</option>
                                        ';endforeach;;echo '                                                
                                    </select>
                                </div>

                                <div class="col-lg-6">
                                    <div class="pull-right">

                                        <div class="btn-group">
                                          <a class="btn btn-default btnSearch"><i class="fa fa-search"></i> Show F6</a>
                                          <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                          <a class="btn btn-default btnPrint2 btnPrintHtml"><i class="fa fa-print"></i> Print F9</a>

                                          <!-- <a  class="btbtn btn-default btnPrintHtml" ><i class="fa fa-print"></i>Print F9</a> -->
                                          <!-- <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" class="btnPrintHtml">Print</a></li>
                                            <li><a href="#" class="btnPrintExcel">Excel</a></li>

                                        </ul> -->
                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Account Wise Detail</legend>

                        <table id="datatable_example" class="table full table-bordered table-striped table-hover saleRows">
                            <thead>
                                <th class="no_sort text-left" style="width:80px;">Sr#</th>

                                <th class="no_sort text-left" style="width:600px;">Account Detail</th>
                                <th class="no_sort text-left" style="width:200px;">Debit</th>
                                <th class="no_sort text-right" style="width:200px;">Credit</th>
                                <th class="no_sort text-right" style="width:80px;">%Age</th>
                            </thead>
                            <tbody class="trialBalRows">                    
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Summary</legend>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <span class="input-group-addon txt-addon VoucherNoLable">Expenses: </span>
                                    <input type="text" class="form-control input-sm VoucherNo" id="txtTotalExpenses">

                                </div>
                            </div>
                        </div>

                         <div class="row">
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <span class="input-group-addon txt-addon VoucherNoLable">Income: </span>
                                    <input type="text" class="form-control input-sm VoucherNo" id="txtTotalIncome">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <span class="input-group-addon txt-addon VoucherNoLable">Profit: </span>
                                    <input type="text" class="form-control input-sm VoucherNo" id="txtTotalProfit">

                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <span class="input-group-addon txt-addon VoucherNoLable">Other Income: </span>
                                    <input type="text" class="form-control input-sm VoucherNo" id="txtTotalOtherIncome">

                                </div>
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