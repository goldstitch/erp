

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="general-head-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort">Sr# </th>
        <th class="no_sort" style="width: 100px;">Date </th>
        <th class="no_sort">Vr# </th>
        <th class="no_sort">Inv Date </th>
        <th class="no_sort">PI# </th>
        <th class="no_sort">Advance Payment </th>
        <th class="no_sort">Inv# </th>
        <th class="no_sort">E-Form# </th>
        <th class="no_sort">CTN# </th>
        <th class="no_sort">Inv Value </th>
        <th class="no_sort">Deliver Date </th>
        <th class="no_sort">Container# </th>
        <th class="no_sort">BL# </th>
        <th class="no_sort">Routing Bank</th>
        <th class="no_sort">Payment Shipping </th>
        <th class="no_sort">DHL#</th>
        <th class="no_sort">GD Date </th>
        <th class="no_sort">Received Payment </th>
        <th class="no_sort">Received Date </th>
        <th class="no_sort">Transport </th>
        <th class="no_sort">Sea Freight </th>
        <th class="no_sort">For Warder </th>
        <th class="no_sort">Clearing Agent </th>
        <th class="no_sort">Rebate Doc </th>
        <th class="no_sort">Sale Tax Doc </th>
        <th class="no_sort">Yarn </th>

    </tr>
</script>
<script id="voucher-item-template" type="text/x-handlebars-template">
  <tr>
        <td>{{SERIAL}}</td>
        <td>{{VRDATE}}</td>
        <td>{{{VRNOA}}}</td>
        <td>{{INVDATE}}</td>
        <td>{{PINO}}</td>
        <td>{{ADVANCEPAYMENT}}</td>
        <td>{{INVNO}}</td>
        <td>{{EFORMNO}}</td>
        <td>{{CTNNO}}</td>
        <td>{{INVVALUE}}</td>
        <td>{{DELIVERDATE}}</td>
        <td>{{CONTAINERNO}}</td>
        <td>{{BLNO}}</td>
        <td>{{ROUTINGBANK}}</td>
        <td>{{PAYMENTSHIPPING}}</td>
        <td>{{DHLNO}}</td>
        <td>{{GDDATE}}</td>
        <td>{{RECEIVEDPAYMENT}}</td>
        <td>{{RECEIVEDDATE}}</td>
        <td>{{TRANSPORT}}</td>
        <td>{{SEAFREIGHT}}</td>
        <td>{{FORWARDEN}}</td>
        <td>{{CLEARINGAGENT}}</td>
        <td>{{REBATEDOC}}</td>
        <td>{{SALETAXDOC}}</td>
        <td>{{YARN}}</td>
  </tr>
</script>
<script id="voucher-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
      <th class="no_sort">Sr# </th>
      <th class="no_sort">Description</th>
      <th class="no_sort">Advance Payment </th>
      <th class="no_sort">Payment Shipping </th>
      <th class="no_sort">Received Payment </th>
      <th class="no_sort">Transport </th>
  </tr>
</script>
<script id="voucher-itemsummary-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{DESCRIPTION}}</td>
     <td class="text-right">{{ADVANCEPAYMENT}}</td>
     <td class="text-right">{{PAYMENTSHIPPING}}</td>
     <td class="text-right" style="text-align:right !important;">{{RECEIVEDPAYMENT}}</td>
     <td class="text-right" style="text-align:right !important;">{{TRANSPORT}}</td>
  </tr>
</script>

<script id="voucher-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td>{{NAME}}</td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
  </tr>
</script>
<script id="voucher-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td>{{DESCRIPTION}}</td>
     <td class="printRemove"></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
  </tr>
</script>
<script id="summary-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td>{{VRDATE}}</td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
  </tr>
</script>
<script id="summary-dateitem-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{DATE}}</td>
     <td>{{ADVANCEPAYMENT}}</td>
     <td class="text-right" style="text-align:right !important;">{{PAYMENTSHIPPING}}</td>
     <td class="text-right" style="text-align:right !important;">{{RECEIVEDPAYMENT}}</td>
     <td class="text-right" style="text-align:right !important;">{{TRANSPORT}}</td>
  </tr>
</script>
<script id="voucher-vhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td  colspan="7"></td>
     <td></td>
     <td>{{{VRNOA1}}}</td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
  </tr>
</script>
<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     <td></td>
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td></td>
     <td></td>
     <td>{{ TOTAL_SALARY }}</td>
     <td class="printRemove"></td>
     <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
     <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
     <td style="text-align:right !important;"></td>
     <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
  </tr>
</script>

<script id="voucher-sum_summary-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     <td ></td>
     <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
     <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
     <td style="text-align:right !important;"></td>
     <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
  </tr>
</script>


<script id="summary-body-template" type="text/x-handlebars-template">
    <tr>
        <td class="no_sort">{{SERIAL}}</td>
        <td>{{{VRNOA}}}</td>
        <td class="no_sort" style="width:400px;">{{NAME}}</td>
        <td class="no_sort text-right" style="text-align:right !important;">{{QTY}}</td>
        <td class="no_sort text-right" style="text-align:right !important;">{{RATE}}</td>
        <td class="no_sort text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
    </tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title" style="text-transform:capitalize;">Export Register Report</h1>
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
                                                <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                            <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                            <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                            <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
                                            <input type="hidden" name="company_name" id="company_name" value="';echo $this->session->userdata('company_name');;echo '">

                                            <input type="hidden" name="etype" id="etype" value="export_register">
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="pull-right">
                                                <!-- <a href=\'\' class="btn btn-sm btn-success btnSearch" id="btnChart" ><i class="fa fa-bar-chart-o"></i> Show Chart F4</a> -->
                                                <a href=\'\' class="btn btn-sm btn-success btnSearch" id="btnSearch" ><i class="fa fa-search"></i> Show Report F6</a>
                                                <a href=\'\' class="btn btn-sm btn-success btnReset" id="btnReset"> <i class="fa fa-refresh"></i>Reset Filters F5</a>
                                                <!-- <a href=\'\' class="btn btn-sm btn-success " id="btnPrint"><i class="fa fa-print"></i>Print F9</a>
                                                <a href=\'\' class="btn btn-sm btn-success " id="btnPrint2"><i class="fa fa-print"></i>Pdf F8</a> -->
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-primary btn-lg btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                  <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                  </button>
                                                  <ul class="dropdown-menu" role="menu">
                                                    <li ><a href="#" class="btnPrint">Print F9</a></li>
                                                    <li ><a href="#" class="btnPrint2">Pdf F8</a></li>
                                                    <li ><a href="#" class="btnPrintExcel">Excel</a></li>
                                                    <li ><a data-toggle="modal" href="#addEmail" rel="tooltip"
                                                                        data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</a></li>
                                                  </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <legend style=\'margin-top: 30px;\'>Selection Criteria</legend>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Voucher Wise</a>
                                            <a href=\'\' class="btn btn-primary btn-sm btnSelCre">PI Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Invoice Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">BL Wise</a>
                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt" id="Radio1" value="detailed" checked="checked">
                                                    Detailed
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt" id="Radio2" value="summary">
                                                    Summary
                                                </label>
                                            </div>
                                        </div>
                                      <!--  <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt2" id="Radio3" value="produce" checked="checked">
                                                    Produce
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt2" id="Radio4" value="consume">
                                                    Consume
                                                </label>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-6">
                                            <div class="container-fluid">
                                                <div class="pull-right">
                                                    <ul class="stats">
                                                        <li class=\'blue\'>
                                                            <i class="fa fa-money"></i>
                                                            <div class="details">
                                                                <span class="big grand-total">0.00</span>
                                                                <span>Grand Total</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="htmlexportPDF">
                                            <div class="col-lg-12 tableDate disp">
                                                <table id="datatable_example" class="table table-striped full table-bordered ">
                                               
                                                    <thead class=\'dthead\'>
                                                    </thead>
                                                    <tbody id="saleRows" class="report-rows saleRows">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="chart_tabs" class="disp" >

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li id="line_list" role="presentation" class="active"><a href="#area_chart" aria-controls="line_chart" role="tab" data-toggle="tab" data-identifier="area">Area Chart</a></li>
                                            <li role="presentation"><a href="#line_chart" aria-controls="area_chart" role="tab" data-toggle="tab" data-identifier="line">Line Chart</a></li>
                                            <li role="presentation"><a href="#bar_chart" aria-controls="bar_chart" role="tab" data-toggle="tab" data-identifier="bar">Bar Chart</a></li>
                                            <li role="presentation"><a href="#donut_chart" aria-controls="donut_chart" role="tab" data-toggle="tab" data-identifier="donut">Donut Chart</a></li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="area_chart">
                                                <p>
                                                <h4 align="center"> Area Chart</h4>
                                                <div id="myfirstareachart" style="height: 200px;"></div>
                                                </p>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="line_chart">
                                                <p>
                                                <h4 align="center">  Line Chart</h4>
                                                <div id="myfirstlinechart" style="height: 200px;"></div>
                                                </p>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="bar_chart">
                                                <p>
                                                <h4 align="center">  Bar Chart</h4>
                                                <div id="myfirstbarchart" style="height: 200px;"></div>
                                                </p>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="donut_chart">
                                                <p>
                                                <h4 align="center">  Donut Chart</h4>
                                                <div id="myfirstdonutchart" style="height: 200px;"></div>
                                                </p>
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