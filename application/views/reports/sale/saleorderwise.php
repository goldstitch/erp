

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="voucher-vhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td>{{{NAME}}}</td>
     <td class="tblInvoice"></td>
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
     <td>Total</td>
     <td>{{ VOUCHER_QTY_SUM }}</td>
     <td style="text-align:right !important;"></td>
     <td class="text-right" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
  </tr>
</script>
<script id="general-head-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort">Sr# </th>
        <th class="no_sort" style="width: 100px;">Date </th>
        <th class="no_sort">Vr# </th>
        <th class="no_sort">Type </th>
        <th class="no_sort" style="width:400px;">Item </th>
        <th class="no_sort">Qty </th>
        <th class="no_sort">Rate </th>
        <th class="no_sort">Amount </th>
    </tr>
</script>
<script id="general-item-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{VRDATE}}</td>
     <td>{{{VRNOA}}}</td>
     <td>{{NAME}}</td>
     <td>{{DESCRIPTION}}</td>
     <td>{{QTY}}</td>
     <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
     <td class="text-right" style="text-align:right !important;">{{AMOUNT}}</td>
  </tr>
</script>
<script id="summary-head-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort">Sr# </th>
        <th class="no_sort">Type </th>
        <th class="no_sort">Qty </th>
        <th class="no_sort">Net Amount </th>
    </tr>
</script>
<script id="summary-item-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{NAME}}</td>
     <td>{{QTY}}</td>
     <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
  </tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Sale Order Wise Report</h1>
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
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="pull-right">
                                                <a href=\'\' class="btn btn-primary btn-sm btnSearch">Show Report</a>
                                                <a href=\'\' class="btn btn-success btn-sm btnReset">Reset Filters</a>
                                                <a href=\'\' class="btn btn-success btn-sm btnPrint">Print Report</a>
                                            </div>
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
                                        <div class="col-lg-9">
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
                                        <div class="col-lg-12">
                                            <table id="datatable_example" class="table table-striped full table-bordered">
                                                <thead class=\'dthead\'>
                                                </thead>
                                                <tbody id="saleRows" class="report-rows">
                                                </tbody>
                                            </table>
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
</div>';
?>