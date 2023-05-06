

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
    <th class="no_sort" style="width: 70px;">Date </th>
    <th class="no_sort">Vr# </th>
    <th class="no_sort" style="width: 200px; ">Account </th>
    <th class="no_sort" style="width:400px;">Item </th>
    <th class="no_sort printRemove" style="width:100px;">Remarks </th>
    <th class="no_sort" style="width: 100px;">Qty </th>
    <th class="no_sort" style="width: 100px;">Weight </th>
    <th class="no_sort" style="width: 70px;">Rate </th>
    <th class="no_sort" style="width: 100px;">Amount </th>
  </tr>
</script>
<script id="generalsaleorder-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort">Sr# </th>
    <th class="no_sort" style="width: 70px;">Date </th>
    <th class="no_sort">Vr# </th>
    <th class="no_sort" style="width: 200px; ">Account </th>
    <th class="no_sort" style="width:400px;">Cust Art# </th>
    <th class="no_sort" style="width:400px;">Cust Item </th>
    <th class="no_sort" style="width:400px;">Art# </th>
    <th class="no_sort" style="width:400px;">Item </th>
    <th class="no_sort printRemove" style="width:100px;">Remarks </th>
    <th class="no_sort" style="width:50px;">Currencey </th>
    <th class="no_sort" style="width: 100px;">Ctn </th>
    <th class="no_sort" style="width: 100px;">Dozen </th>
    <th class="no_sort" style="width: 100px;">Qty </th>
    <th class="no_sort" style="width: 100px;">Weight </th>
    <th class="no_sort" style="width: 70px;">FRate </th>
    <th class="no_sort" style="width: 70px;">LRate </th>
    <th class="no_sort" style="width: 100px;">Amount </th>
  </tr>
</script>
<script id="vouchersaleorder-item-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{VRDATE}}</td>
   <td>{{{VRNOA}}}</td>
   <td>{{NAME}}</td>
   <td>{{CUSTART}}</td>
   <td>{{CUSTITEM}}</td>
   <td>{{ART}}</td>
   <td>{{DESCRIPTION}}</td>
   <td class="printRemove">{{REMARKS}}</td>
   <td>{{CURRENCY}}</td>
   <td class="text-right">{{CTN}}</td>
   <td class="text-right">{{DOZEN}}</td>
   <td class="text-right">{{QTY}}</td>
   <td class="text-right">{{WEIGHT}}</td>
   <td class="text-right" style="text-align:right !important;">{{FRATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
 </tr>
</script>
<script id="vouchersaleorder-vhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
   <td></td>
   <td></td>
   <td class="tblInvoice"></td>
   <td>{{{VRNOA1}}}</td>
   <td></td>
   <td class="printRemove"></td>
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
<script id="vouchersaleorder-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
   <td></td>
   <td></td>
   <td class="tblInvoice"></td>
   <td></td>
   <td class="printRemove"></td>
  
   <td></td>
   <td class="tblInvoice"></td>
   <td></td>
   <td></td>
   <td></td>
   <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
   <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
   <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
   <td style="text-align:right !important;"></td>
    <td></td>
   <td style="text-align:right !important;"></td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
 </tr>
</script>
<!-- Sale -->
<script id="generalsale-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort">Sr# </th>
    <th class="no_sort" style="width: 70px;">Date </th>
    <th class="no_sort">Vr# </th>
    <th class="no_sort" style="width: 200px; ">Account </th>
    <th class="no_sort" style="width:400px;">Art# </th>
    <th class="no_sort" style="width:400px;">Item </th>
    <th class="no_sort printRemove" style="width:100px;">Remarks </th>
    <th class="no_sort" style="width:50px;">Currencey </th>
    <th class="no_sort" style="width: 100px;">Dozen </th>
    <th class="no_sort" style="width: 100px;">Weight </th>
    <th class="no_sort" style="width: 100px;">Qty </th>
    <th class="no_sort" style="width: 70px;">Rate </th>
    
    <th class="no_sort" style="width: 100px;">Gross Amount</th>
    <th class="no_sort" style="width:400px;">Disc %</th>
    <th class="no_sort" style="width: 70px;">Disc Total</th>
    <th class="no_sort" style="width:400px;">Disc Amount</th>
    <th class="no_sort" style="width: 100px;">GST% </th>
    <th class="no_sort" style="width: 100px;">GST </th>
    <th class="no_sort" style="width: 100px;">Inc Amount </th>
  </tr>
</script>
<script id="vouchersale-item-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{VRDATE}}</td>
   <td>{{{VRNOA}}}</td>
   <td>{{NAME}}</td>
   <td>{{ART}}</td>
   <td>{{DESCRIPTION}}</td>
   <td class="printRemove">{{REMARKS}}</td>
   <td>{{CURRENCY}}</td>
   <td class="text-right">{{DOZE}}</td>
   <td class="text-right">{{WEIGHT}}</td>
   <td class="text-right">{{QTY}}</td>
   <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{EXLAMOUNT}}</td>
   <td>{{CUSTITEM}}</td>
   <td class="text-right" style="text-align:right !important;">{{FRATE}}</td>
   <td class="text-right">{{DOZEN}}</td>
   <td class="text-right" style="text-align:right !important;">{{GSTP}}</td>
   <td class="text-right" style="text-align:right !important;">{{GST}}</td>
   <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
 </tr>
</script>
<script id="vouchersale-vhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
   <td></td>
   <td></td>
   <td class="tblInvoice"></td>
   <td>{{{VRNOA1}}}</td>
   <td></td>
   <td class="printRemove"></td>
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
<script id="vouchersale-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
   <td></td>
   <td></td>
   <td class="tblInvoice"></td>
   <td></td>
   <td class="printRemove"></td>
  
   <td></td>
   <td class="tblInvoice"></td>
   <td></td>
   <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
   <td class="text-right txtbold">{{ VOUCHER_DOZEN_SUM }}</td>
   <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
   <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
   <td></td>
   <td></td>
   <td></td>
   <td style="text-align:right !important;">{{ VOUCHER_EXLAMOUNT_SUM }}</td>
   <td style="text-align:right !important;"></td>
   <td style="text-align:right !important;">{{ VOUCHER_GST_SUM }}</td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
 </tr>
</script>
<!-- End Sale -->
<!-- Summary Sale -->
<script id="summarysale-godownhead-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort" style="width: 70px;">Sr# </th>
    <th class="no_sort" style="width: 400px;">Description</th>
    <th class="no_sort" style="width: 100px;">Currencey</th>
    <th class="text-right" style="width: 150px;" >Dozen </th>
    <th class="text-right" style="width: 150px;" >Qty </th>
    <th class="text-right" style="width: 150px;" >Weight </th>
    <th class="text-right" style="width: 100px;">FRate </th>
    <th class="text-right" style="width: 100px;">Rate </th>
    <th class="text-right" style="width: 150px;">Exl Amount </th>
    <th class="text-right" style="width: 150px;">GST% </th>
    <th class="text-right" style="width: 150px;">GST </th>
    <th class="text-right" style="width: 150px;">Inc Amount </th>
  </tr>
</script>
<script id="voucher-itemsummarysale-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{DESCRIPTION}}</td>
   <td>{{CURRENCY}}</td>
   <td class="text-right">{{DOZEN}}</td>
   <td class="text-right">{{QTY}}</td>
   <td class="text-right">{{WEIGHT}}</td>
   <td class="text-right" style="text-align:right !important;">{{FRATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{EXLAMOUNT}}</td>
   <td class="text-right" style="text-align:right !important;">{{GSTP}}</td>
   <td class="text-right" style="text-align:right !important;">{{GST}}</td>
   <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
 </tr>
</script>
<script id="voucher-sum_summarysale-template" type="text/x-handlebars-template">
  <tr class="finalsum">
   <td ></td>
   <td ></td>
   <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
   <td class="text-right txtbold">{{ VOUCHER_DOZEN_SUM }}</td>
   <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
   <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
   <td style="text-align:right !important;"></td>
   <td style="text-align:right !important;"></td>
   <td class="text-right txtbold">{{ VOUCHER_EXLAMOUNT_SUM }}</td>
   <td style="text-align:right !important;"></td>
   <td class="text-right txtbold">{{ VOUCHER_EXLAMOUNT_SUM }}</td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
 </tr>
</script>
<!-- End Summary Sale -->
<!-- Summary Saleorder -->
<script id="summarysaleorder-godownhead-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort" style="width: 70px;">Sr# </th>
    <th class="no_sort" style="width: 400px;">Description</th>
    <th class="no_sort" style="width: 100px;">Currencey</th>
    <th class="text-right" style="width: 150px;" >Ctn </th>
    <th class="text-right" style="width: 150px;" >Dozen </th>
    <th class="text-right" style="width: 150px;" >Qty </th>
    <th class="text-right" style="width: 150px;" >Weight </th>
    <th class="text-right" style="width: 100px;">FRate </th>
    <th class="text-right" style="width: 100px;">LRate </th>
    <th class="text-right" style="width: 150px;">Amount </th>
  </tr>
</script>
<script id="voucher-itemsummarysaleorder-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{DESCRIPTION}}</td>
   <td>{{CURRENCY}}</td>
   <td class="text-right">{{CTN}}</td>
   <td class="text-right">{{DOZEN}}</td>
   <td class="text-right">{{QTY}}</td>
   <td class="text-right">{{WEIGHT}}</td>
   <td class="text-right" style="text-align:right !important;">{{FRATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
 </tr>
</script>
<script id="voucher-sum_summarysaleorder-template" type="text/x-handlebars-template">
  <tr class="finalsum">
   <td ></td>
   <td ></td>
   <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
   <td class="text-right txtbold"></td>
   <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
   <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
   <td style="text-align:right !important;"></td>
   <td style="text-align:right !important;"></td>
   <td style="text-align:right !important;"></td>
   <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
 </tr>
</script>
<!-- End Summary Sale)rder -->

<script id="summary-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort">Sr# </th>
    <th class="no_sort">Vr# </th>
    <th class="no_sort">Account </th>
    <th class="no_sort">Qty </th>
    <th class="no_sort">Rate </th>
    <th class="no_sort">Amount </th>
  </tr>
</script>
<script id="summary-godownhead-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort" style="width: 70px;">Sr# </th>
    <th class="no_sort" style="width: 400px;">Description</th>
    <th class="text-right" style="width: 150px;" >Qty </th>
    <th class="text-right" style="width: 150px;" >Weight </th>
    <th class="text-right" style="width: 100px;">Rate </th>
    <th class="text-right" style="width: 150px;">Amount </th>
  </tr>
</script>

<script id="summary-godownitem-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{NAME}}</td>
   <td>{{QTY}}</td>
   <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
 </tr>
</script>
<script id="voucher-item-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{VRDATE}}</td>
   <td>{{{VRNOA}}}</td>
   <td>{{NAME}}</td>
   <td>{{DESCRIPTION}}</td>
   <td class="printRemove">{{REMARKS}}</td>
   <td class="text-right">{{QTY}}</td>
   <td class="text-right">{{WEIGHT}}</td>
   <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
 </tr>
</script>

<script id="voucher-itemsummary-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{DESCRIPTION}}</td>
   <td class="text-right">{{QTY}}</td>
   <td class="text-right">{{WEIGHT}}</td>
   <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
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
<script id="voucher-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <th class="no_sort">Sr# </th>
    <th class="no_sort">Date</th>
    <th class="no_sort">Qty </th>
    <th class="no_sort">Rate </th>
    <th class="no_sort">Amount </th>
  </tr>
</script>
<script id="summary-dateitem-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{DATE}}</td>
   <td>{{QTY}}</td>
   <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
   <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
 </tr>
</script>
<script id="voucher-vhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
   <td></td>
   <td></td>
   <td class="tblInvoice"></td>
   <td>{{{VRNOA1}}}</td>
   <td></td>
   <td class="printRemove"></td>
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
        <h1 class="page_title" >';echo $title;;echo '</h1>
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
                      <input type="hidden" name="etype" id="etype" value="';echo $etype;;echo '">
                    </div>
                    <div class="col-lg-3">
                      <div class="input-group">
                        <span class="input-group-addon">To</span>
                        <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                      </div>
                    </div>
                    
                    <div class="col-lg-6">
                      <div class="pull-right">
                        <a href=\'\' class="btn btn-sm btn-default btnSearch" id="btnChart" ><i class="fa fa-bar-chart-o"></i> Show Chart F4</a>
                        <a href=\'\' class="btn btn-sm btn-default btnSearch" id="btnSearch" ><i class="fa fa-search"></i> Show Report F6</a>
                        <a href=\'\' class="btn btn-sm btn-default btnReset" id="btnReset"> <i class="fa fa-refresh"></i>Reset Filters F5</a>
                                                <!-- <a href=\'\' class="btn btn-sm btn-primary " id="btnPrint"><i class="fa fa-print"></i>Print F9</a>
                                                  <a href=\'\' class="btn btn-sm btn-primary " id="btnPrint2"><i class="fa fa-print"></i>Pdf F8</a> -->
                                                  <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-lg btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                    <button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                      <li ><a href="#" class="btnPrint">Print F9</li>
                                                        <li ><a href="#" class="btnPrint2">Pdf F8</li>
                                                          <li ><a href="#" class="btnPrintExcel">Excel</li>
                                                            <li ><a data-toggle="modal" href="#addEmail" rel="tooltip"
                                                              data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</li>
                                                            </ul>
                                                          </div>

                                                        </div>
                                                      </div>
                                                    </div>

                                                    <legend style=\'margin-top: 30px;\'>Selection Criteria</legend>
                                                    <div class="row">
                                                      <div class="col-lg-12">
                                                        <a href=\'\' class="btn btn-primary btn-sm btnSelCre">Voucher Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Account Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Godown Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Item Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">User Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Year Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Month Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">WeekDay Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Date Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Rate Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Wo Wise</a>

                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Catagory Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">SubCatagory Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Brand Wise</a>
                                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Made Wise</a>


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

                                                      <div class="col-lg-9 hide">
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
                                                    <!-- Advanced Panels -->
                                                    <div class="row">
                                                      <div class="col-lg-12">
                                                        <div class="row">
                                                          <div class="col-lg-12">
                                                            <button type="button" class="btn btnAdvaced">Advanced</button>
                                                          </div>
                                                        </div>
                                                        <div class="panel-group panel-group1 panelDisplay" id="accordion" role="tablist" aria-multiselectable="true">
                                                          <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingOne">
                                                              <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                                  General
                                                                </a>
                                                              </h4>
                                                            </div>
                                                            <div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                              <div class="panel-body">
                                                                <form class="form-group">
                                                                  <div class="row">
                                                                    <div class="col-lg-12">
                                                                      
                                                                      
                                                                      <div class="col-lg-3">
                                                                        <label >Choose WareHouse </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpdepartId" data-placeholder="Choose Item....">
                                                                         
                                                                          
                                                                        </select>    
                                                                      </div>
                                                                      
                                                                      <div class="col-lg-3" >
                                                                        <label >Choose User</label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpuserId" data-placeholder="Choose User....">
                                                                         
                                                                          ';foreach( $userone as $user):         ;echo '                                                                           <option value=';echo $user['uid'];echo '><span>';echo $user['uname'];;echo '</span></option>
                                                                         ';endforeach                ;echo '  
                                                                       </select>   
                                                                     </div>
                                                                   </div>
                                                                 </div>
                                                               </form>
                                                               <div class="row">
                                                                
                                                                <button class="btn btn-primary col-lg-2 col-lg-offset-10" id="reset_criteria">Reset Criteria</button>
                                                                
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="panel panel-default">
                                                          <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title">
                                                              <a data-toggle="collapse" data-parent="#accordion" href="#collapsetwo" aria-expanded="false" aria-controls="collapsetwo">
                                                                Item
                                                              </a>
                                                            </h4>
                                                          </div>
                                                          <div id="collapsetwo" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="panel-body">
                                                              <form class="form-group">
                                                                <div class="row">
                                                                  <div class="col-lg-12">
                                                                    <div class="col-lg-3" >
                                                                      <label for="">Item<img id="imgItemLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>

                                                                      <input type="text" class="form-control" id="txtItemId">
                                                                      <input id="hfItemId" type="hidden" value="" />
                                                                    </div>
                                                                    <div class="col-lg-3" >
                                                                      <label >Brand</label>        
                                                                      <select  class="form-control input-sm select2 " multiple="true" id="drpbrandID" data-placeholder="Choose Brand....">
                                                                       
                                                                       
                                                                      </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                      <label >Category </label>                    
                                                                      <select  class="form-control input-sm select2" multiple="true" id="drpCatogeoryid" data-placeholder="Choose category....">
                                                                       
                                                                        
                                                                      </select>           
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                      <label >Sub Category</label>                    
                                                                      <select  class="form-control input-sm select2" multiple="true" id="drpSubCat" data-placeholder="Choose SubCatagory....">
                                                                       
                                                                        
                                                                      </select>    
                                                                    </div>
                                                                    
                                                                    <div class="col-lg-1" >
                                                                      <label >UOM</label>                    
                                                                      <select  class="form-control input-sm select2" multiple="true" id="drpUom" data-placeholder="Choose UOM....">
                                                                       
                                                                        
                                                                      </select>   
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </form>
                                                              
                                                            </div>
                                                          </div>

                                                        </div>
                                                        <div class="panel panel-default">
                                                          <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title">
                                                              <a data-toggle="collapse" data-parent="#accordion" href="#collapsethree" aria-expanded="false" aria-controls="collapsethree">
                                                                Account
                                                              </a>
                                                            </h4>
                                                          </div>
                                                          <div id="collapsethree" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="panel-body">
                                                              <form class="form-group">
                                                                <div class="row">
                                                                  <div class="col-lg-12">
                                                                    <div class="col-lg-2" >
                                                                      <label >Account Name
                                                                      </label>        
                                                                      <select  class="form-control input-sm select2 " multiple="true" id="drpAccountID" data-placeholder="Choose Party....">
                                                                       
                                                                        
                                                                      </select>
                                                                    </div>
                                                                    <div class="col-lg-2" >
                                                                      <label >City</label>        
                                                                      <select  class="form-control input-sm select2 " multiple="true" id="drpCity" data-placeholder="Choose city....">
                                                                       
                                                                        
                                                                      </select>
                                                                    </div>

                                                                    <div class="col-lg-2">
                                                                      <label >Area</label>                    
                                                                      <select  class="form-control input-sm select2" multiple="true" id="drpCityArea" data-placeholder="Choose Area....">
                                                                       
                                                                        
                                                                      </select>           
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                      <label >Level 1</label>                    
                                                                      <select  class="form-control input-sm select2" multiple="true" id="drpl1Id" data-placeholder="Choose level1....">
                                                                       
                                                                        
                                                                      </select>    
                                                                    </div>
                                                                    
                                                                    <div class="col-lg-2" >
                                                                      <label >Level 2</label>                    
                                                                      <select  class="form-control input-sm select2" multiple="true" id="drpl2Id" data-placeholder="Choose Level2....">
                                                                       
                                                                        
                                                                      </select>   
                                                                    </div>
                                                                    <div class="col-lg-2" >
                                                                      <label >Level 3</label>                    
                                                                      <select  class="form-control input-sm select2" multiple="true" id="drpl3Id" data-placeholder="Choose Level3....">
                                                                       
                                                                        
                                                                      </select>   
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </form>
                                                              
                                                            </div>
                                                          </div>
                                                          
                                                        </div>
                                                      </div>

                                                    </div>
                                                  </div>
                                                  <!-- End Advanced Panels -->

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
                                                  <div role="tabpanel" id="chart_tabs" class="disp"  style="color:red;">

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