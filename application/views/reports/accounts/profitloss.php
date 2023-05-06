
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
     <td>{{SERIAL}}</td>
     <td>{{VRDATE}}</td>
     <td>{{{VRNOA}}}</td>
     <td>{{NAME}}</td>
     <td>{{DESCRIPTION}}</td>
     <td class="print-hide" style="display:none;">{{REMARKS}}</td>
     <td>{{QTY}}</td>
     <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
     <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
     <td class="text-right" style="text-align:right !important;">{{PRATE}}</td>
     <td class="text-right" style="text-align:right !important;">{{PLS}}</td>
     <td class="text-right" style="text-align:right !important;">{{PLSPERC}}</td>
     <td class="sman-visible" style="text-align:right !important;">{{SALEMAN_PROFIT}}</td>
  </tr>
</script>
<script id="voucher-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td>{{DESCRIPTION}}</td>
     <td class="print-hide" style="display:none;"></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
     <td></td>
     <td class="sman-visible"></td>
  </tr>
</script>
<script id="voucher-vhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td>{{{VRNOA}}}</td>
     <td class="print-hide" style="display:none;"></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
     <td></td>
     <td class="sman-visible"></td>
  </tr>
</script>
<script id="voucher-smanhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td></td>
     <td>{{SALEMAN}}</td>
     <td class="print-hide" style="display:none;"></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
     <td></td>
     <td class="sman-visible"></td>
  </tr>
</script>
<script id="voucher-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td></td>
     <td>{{NAME}}</td>
     <td class="print-hide" style="display:none;"></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
     <td></td>
     <td class="sman-visible"></td>
  </tr>
</script>
<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     <td></td>
     <td></td>
     <td></td>
     <td class="print-hide" style="display:none;"></td>
     <td></td>
     <td></td>
     <td></td>
     <td style="text-align:right !important;">Total:</td>
     <td class="text-right" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
     <td></td>
     <td class="text-right" style="text-align:right !important;">{{ PLS_SUM }}</td>
     <td></td>
     <td class="sman-visible" style="text-align: right !important;">{{SMAN_PLS_SUM}}</td>
  </tr>
</script>
<script id="net-sum-template" type="text/x-handlebars-template">
  <tr class="finalfinalsum">
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td class="print-hide" style="display:none;"></td>
     <td></td>
     <td></td>
     <td style="text-align:right !important;">Net:</td>
     <td class="text-right" style="text-align:right !important;">{{ NETSUM }}</td>
     <td></td>
     <td class="text-right" style="text-align:right !important;">{{ NET_PLS_SUM }}</td>
     <td></td>
     <td class="sman-visible">{{ SMAN_NETPLS_SUM }}</td>
  </tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Item wise profit/loss</h1>
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
                                                <!-- <a href=\'\' class="btn btn-success btn-sm btnPrint">Print Report</a> -->
                                                <div class="btn-group">
                                                      <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
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
                                            </div>
                                        </div>
                                    </div>

                                    <legend style=\'margin-top: 30px;\'>Selection Criteria</legend>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="" class="btn filter-records-btn btn-sm transaction-btn btn-primary">Voucher Wise</a>
                                            <a href="" class="btn filter-records-btn btn-sm party-btn">Party Wise</a>
                                            <a href="" class="btn filter-records-btn btn-sm item-btn">Item Wise</a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p><strong class="pls_field">Net PLS: </strong> <span class="top-netpls">0</span>/=</p>
                                            <p><strong class="pls_field">Net Amount: </strong> <span class="top-netAmt">0</span>/=</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div class="row-fluid mb10">
                                                <div class="span10 cols_options">
                                                    <h3>Show Columns</h3>
                                                    <div class="row-fluid">
                                                        <div class="span6">
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="sr_column" data-columnno="0" />
                                                                Serial #
                                                            </label>
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="date_column" data-columnno="1" />
                                                                Date
                                                            </label>
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="vrno_column" data-columnno="2" />
                                                                Voucher #
                                                            </label>
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="descrip_column" data-columnno="3" />
                                                                Item Description
                                                            </label>
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="pname_column" data-columnno="4" />
                                                                Party Name
                                                            </label>
                                                        </div>
                                                        <div class="span6">
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="qty_column" data-columnno="5" />
                                                                Quantity
                                                            </label>
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="rate_column" data-columnno="6" />
                                                                Rate
                                                            </label>
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="fed_column" data-columnno="7" />
                                                                FED
                                                            </label>
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="amount_column" data-columnno="8" />
                                                                Amount Excl. GST
                                                            </label>
                                                            <label class="checkbox">
                                                                <input type="checkbox" class="col_control" checked="checked" name="inclgst_column" data-columnno="9" />
                                                                Amount Incl. GST
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="content top">
                                                <table id="datatable_example" class="table table-striped full table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="no_sort">Sr#
                                                            </th>
                                                            <th class="no_sort" style="width: 100px;">Date
                                                            </th>
                                                            <th class="no_sort">Vr#
                                                            </th>
                                                            <th class="no_sort" style="width: 200px; ">Party
                                                            </th>
                                                            <th class="no_sort" style="width:300px;">Item
                                                            </th>
                                                            <th class="no_sort print-hide" style="display:none;">Remarks
                                                            </th>
                                                            <th class="no_sort">Qty
                                                            </th>
                                                            <th class="no_sort">Rate
                                                            </th>
                                                            <th class="no_sort">Amount
                                                            </th>
                                                            <th class="no_sort">PRate
                                                            </th>
                                                            <th class="no_sort">PLS
                                                            </th>
                                                            <th class="no_sort">PLS %
                                                            </th>
                                                            <th class="no_sort sman-visible">Sman PLS
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="saleRows">
                                                    </tbody>
                                                </table>
                                                <!-- End row-fluid -->
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