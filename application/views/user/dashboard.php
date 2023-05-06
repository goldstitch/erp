<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


$desc = $this->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$reports = $desc['reports'];
$vouchers = $desc['vouchers'];
$Date_Close = $this->session->userdata('date_close');
;echo '
<script id="general-head-template" type="text/x-handlebars-template">
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
   <td></td>
   <td class="tblInvoice"></td>
   <td></td>
   <td></td>
   <td></td>
   <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
   <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
   <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
   <td style="text-align:right !important;"></td>
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
    <th class="no_sort" style="width:400px;">Cust Art# </th>
    <th class="no_sort" style="width:400px;">Cust Item </th>
    <th class="no_sort" style="width:400px;">Art# </th>
    <th class="no_sort" style="width:400px;">Item </th>
    <th class="no_sort printRemove" style="width:100px;">Remarks </th>
    <th class="no_sort" style="width:50px;">Currencey </th>
    <th class="no_sort" style="width: 100px;">Dozen </th>
    <th class="no_sort" style="width: 100px;">Qty </th>
    <th class="no_sort" style="width: 100px;">Weight </th>
    <th class="no_sort" style="width: 70px;">FRate </th>
    <th class="no_sort" style="width: 70px;">Rate </th>
    <th class="no_sort" style="width: 100px;">Exl Amount </th>
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
   <td>{{CUSTART}}</td>
   <td>{{CUSTITEM}}</td>
   <td>{{ART}}</td>
   <td>{{DESCRIPTION}}</td>
   <td class="printRemove">{{REMARKS}}</td>
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
   <td></td>
   <td class="tblInvoice"></td>
   <td></td>
   <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
   <td class="text-right txtbold">{{ VOUCHER_DOZEN_SUM }}</td>
   <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
   <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
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

<script id="cheque-row" type="text/x-handlebars-template">
	<tr>
	  <td>{{VRDATE}}</td>
	  <td>{{MATURE_DATE}}</td>
	  <td>{{DCNO}}</td>
	  <td>{{CHEQUE_NO}}</td>
	  <td>{{PARTY}}</td>
	  <td>{{BANK}}</td>
	  <td>{{AMOUNT}}</td>
	</tr>
</script>


<!-- //////////////////////////////// Start daily template ////////////////////////////////// -->

<script id="sp-daily-head-template" type="text/x-handlebars-template">
  <tr>
	 <th>Vr#</th>
	 <th>Account</th>
	 <th>Amount</th>
  </tr>
</script> 
<script id="sp-daily-template" type="text/x-handlebars-template">
  <tr>
	 <td>{{VRNOA}}</td>
	 <td class="account">{{ACCOUNT}}</td>
	 <td class="amount">{{NAMOUNT}}</td>
  </tr>
</script> 

<!-- ///////////////////////////// End Daily Template ////////////////////////// -->

<!-- ///////////////////// Start Weekly and Monthly Template /////////////////// -->
<script id="sp-weekly-monthly-head-template" type="text/x-handlebars-template">
  <tr>
	 <th>Mon</th>
	 <th>Tue</th>
	 <th>Wed</th>
	 <th>Thu</th>
	 <th>Fri</th>
	 <th>Sat</th>
	 <th>Sun</th>
  </tr>
</script>
<script id="sp-weekly-monthly-template" type="text/x-handlebars-template">
  <tr>
	 <td>{{Monday}}</td>
	 <td>{{Tuesday}}</td>
	 <td>{{Wednesday}}</td>
	 <td>{{Thursday}}</td>
	 <td>{{Friday}}</td>
	 <td>{{Saturday}}</td>
	 <td>{{Sunday}}</td>
  </tr>
</script>
<!-- /////////////////// End Weekly and Monthly Template ////////////////// -->

<!-- ///////////////////// Start Weekly and Monthly Template /////////////////// -->
<script id="sp-monthly-head-template" type="text/x-handlebars-template">
  <tr>
	 <th>Jan</th>
	 <th>Feb</th>
	 <th>Mar</th>
	 <th>Apr</th>
	 <th>May</th>
	 <th>Jun</th>
	 <th>Jul</th>
	 <th>Aug</th>
	 <th>Sep</th>
	 <th>Oct</th>
	 <th>Nov</th>
	 <th>Dec</th>
  </tr>
</script>
<script id="sp-monthly-template" type="text/x-handlebars-template">
  <tr>
	 <td>{{Jan}}</td>
	 <td>{{Feb}}</td>
	 <td>{{Mar}}</td>
	 <td>{{Apr}}</td>
	 <td>{{May}}</td>
	 <td>{{Jun}}</td>
	 <td>{{Jul}}</td>
	 <td>{{Aug}}</td>
	 <td>{{Sep}}</td>
	 <td>{{Oct}}</td>
	 <td>{{Nov}}</td>
	 <td>{{Dec}}</td>
  </tr>
</script>
<!-- /////////////////// End Weekly and Monthly Template ////////////////// -->


<!-- ///////////////////// Start Yearly Template /////////////////// -->
<script id="sp-yearly-head-template" type="text/x-handlebars-template">
	<tr>
		<th>Year</th>
		<th>Month</th>
		<th>Total Sale</th>
	</tr>
</script>
<script id="sp-yearly-template" type="text/x-handlebars-template">
	<tr>
		<td>{{Year}}</td>
		<td class="tdMonth">{{Month}}</td>
		<td class="tdMonthAmount" style="text-align:right;">{{TotalAmount}}</td>
	</tr>
</script>

<!-- /////////////////// End Yearly Template ////////////////// -->

	<link href="';echo base_url('assets/css/style_dashbord.css');;echo '" rel="stylesheet" media="screen">
	<style>
		.table.dataTable .sorting_asc {
	padding-right: 0px !important;
	white-space: nowrap;
		}
	</style>
	</div>
	<div class="container-fluid" id="content">

	<div class="row" style="margin:40px 0px 0px 0px; ">
					<div class="col-sm-12">
					
						
							
						
						<div class="metro-nav" style="margin-left:12px">

						<div class="metro-nav-block nav-olive">
						<a data-original-title="" href="';echo ($vouchers['account']['account'] == 1) ?base_url('index.php/account/add'):'';;echo '">
							<i class="fa fa-users"></i>
							<div class="info">';;echo '</div>
							<div class="status">';echo ($vouchers['account']['account'] == 1)?"Add New Account":'';;echo '</div>
						</a>
					</div><!-- metro-nav -->
				
				
					
					

							<div class="metro-nav-block nav-block-grey ">
								<a data-original-title="" href="';echo ($vouchers['salevoucher']['salevoucher'] == 1)?base_url('index.php/saleorder/Sale_Invoice') :'';;echo '">
									<i class="fa fa-pencil-square-o"></i>
									<div class="info"></div>
									<div class="status">';echo ($vouchers['salevoucher']['salevoucher'] == 1)?"Sale Voucher":'';;echo '</div>
								</a>
							</div><!-- metro-nav -->
	
							<div class="metro-nav-block nav-light-blue double">
								<a data-original-title="" href="';echo ($vouchers['cash_payment_receipt']['cash_payment_receipt'] == 1)?base_url('index.php/payment') :'';;echo '">
								<span class="badge">';echo $no;;echo '</span>
									<i class="fa fa-money"></i>
									<div class="info">';
;echo '</div>
									<div class="status">';echo ($vouchers['cash_payment_receipt']['cash_payment_receipt'] == 1)?"Cash Payment/Receipt":'';;echo '</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-light-green">
							
								<a data-original-title="" href="';echo ($vouchers['jvvoucher']['jvvoucher'] == 1)?base_url('index.php/jv') :'';;echo '">
								<span class="badge">';echo $no_1;;echo '</span>
									<i class="ion-social-buffer"></i>
									<div class="info">';
;echo '</div>
									<div class="status">';echo ($vouchers['jvvoucher']['jvvoucher'] == 1)?"Journal Voucher":'';;echo '</div>
								</a>
							</div><!-- metro-nav -->
							
						<div class="metro-nav">
							<div class="metro-nav-block nav-block-green double">
								<a data-original-title="" href="';echo ($reports['account_ledger'] == 1)?base_url('index.php/report/accountLedger') :'';;echo '">
								
									<i class="fa fa-book"></i>
									<div class="info">';
;echo '</div>
									<div class="status">';echo ($reports['account_ledger'] == 1)?"Account Ledger":'';;echo '</div>
								</a>
							</div><!-- metro-nav -->
							



							<div class="metro-nav-block nav-block-red">
								<a data-original-title="" href="';echo ($reports['stockreport'] == 1)?base_url('index.php/report/stock') :'';;echo '">
									<i class="fa fa-bar-chart-o"></i>
									<div class="info">';
;echo '</div>
									<div class="status">';echo ($reports['stockreport'] == 1)?"Stock Report":'';;echo '</div>
								</a>
							</div><!--metro-nav-block-->

							<div class="metro-nav-block nav-block-yellow">
							<a data-original-title="" href="';echo ($vouchers['purchasevoucher']['purchasevoucher'] == 1)?base_url('index.php/purchase') :'';;echo '">
								<i class="fa fa-shopping-cart"></i>
								<div class="info">';
;echo '</div>
								<div class="status">';echo ($vouchers['purchasevoucher']['purchasevoucher'] == 1)?"Purchase Voucher":'';;echo '</div>
							</a>
						</div><!-- metro-nav -->
						<div class="metro-nav-block nav-olive">
						<a data-original-title="" href="';echo ($reports['vendorledgerreport'] == 1)?base_url('index.php/report/VendoritemLedger') :'';;echo '">
							<i class="ion-ios7-personadd"></i>
							<div class="info"><!--';
;echo '--></div>
							<div class="status">';echo ($reports['vendorledgerreport'] == 1)?"Vendor Ledger":'';;echo '</div>
						</a>
					</div><!-- metro-nav -->
							
					</div>

					</div><!-- end of col -->

		<div id="main">
		<div class="col-sm-6" style="background-color:">

		
			<div class="container-fluid">
			


				<!--...................................ACCORDIANS FOR TRANSCTIONS..................................-->

                 <br>
				<div class="row-fluid" >
					<div class="row-fluid">
						<div class="col-md-14" >

						
						
							<h4 class="text-primary" style="font-family:open sans;"><i class="fa fa-industry"></i> <b>I</b>nventory</h4>

							<!--.....................................PURCHASE ACCORDIANS.......................................-->

							<div class="panel-group" id="accordion_a">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_1" style="background: #5A6062 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-md-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-shopping-cart" style="color:#90906F;"></i></span> Purchase
													</div>
													<div class="col-md-3" style="font-size:12px !important;">
														<span>Total:</span> : <span class="purchases-sum"> 00</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_1" class="panel-collapse collapse">
										<div class="panel-body">
										  <div id="no-more-tables">
										  <table class="table table-striped table-hover">
												<thead class="cf">
													<tr>
														<th class="numeric" style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Time</th>
														<th style=\'background: #368EE0;\'>User</th>
														<th style=\'background: #368EE0;\'>Party</th>
														<th class="numeric"style=\'background: #368EE0;\' class="text-left">Discount</th>
														<th class="numeric"style=\'background: #368EE0;\' class="text-left">Commission</th>
														<th class="numeric"style=\'background: #368EE0;\' class="text-left">Tax</th>
														<th class="numeric"style=\'background: #368EE0;\' class="text-right">Net Amount</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($purchases as $Yarnpurchase): $tot +=$Yarnpurchase['namount'];;echo '														<tr>
															<td class="numeric" data-title="Vr#"><a href= "';echo base_url() ."index.php/purchase?vrnoa=".$Yarnpurchase['vrnoa'] ;;echo '"> </a> ';echo $Yarnpurchase['vrnoa'];;echo '</td>
															<td data-title="Time">';echo $Yarnpurchase['date_time'];;echo '</td>
															<td data-title="User">';echo $Yarnpurchase['user_name'];;echo '</td>
															<td data-title="Account">';echo $Yarnpurchase['party_name'];;echo '</td>
															<td class="numeric" data-title="Disc">
																<span class="text-primary"><b>';echo $Yarnpurchase['discp'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['discount'];;echo '</b></span></li>
															</td>
															<td class="numeric" data-title="Comm">
																<span class="text-primary"><b>';echo $Yarnpurchase['exppercent'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['expense'];;echo '</b></span>
															</td>
															<td class="numeric" data-title="Tax">
																<span class="text-primary"><b>';echo $Yarnpurchase['taxpercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['tax'];;echo '</b></span></li>
															</td>
															<td class="numeric" data-title="NetAmount" style="text-align:right;">';echo $Yarnpurchase['namount'];;echo '</td>
														</tr>
													';endforeach  ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="purchases-sum-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
									</div>
								</div>

							<!--......................................PURCHASE YARN ACCORDIANS..................................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_2" style="background:#747672 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-md-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-shopping-cart" style="color:#90906F;"></i></span> Yarn Purchase
													</div>
													<div class="col-md-3" style="font-size:12px !important;">
														<span>Total:</span> : <span class="yarnpurchases-sum"> 00</span>

													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_2" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="no-more-tables">
											<table class="table table-striped table-hover">
												<thead class="cf">
													<tr>
														<th class="numeric" style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Time</th>
														<th style=\'background: #368EE0;\'>User</th>
														<th style=\'background: #368EE0;\'>Party</th>
														<th class="numeric" style=\'background: #368EE0;\' class="text-left">Discount</th>
														<th class="numeric" style=\'background: #368EE0;\' class="text-left">Commission</th>
														<th class="numeric" style=\'background: #368EE0;\' class="text-left">Tax</th>
														<th class="numeric" style=\'background: #368EE0;\' class="text-right">Net Amount</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($Yarnpurchases as $Yarnpurchase): $tot +=$Yarnpurchase['namount'];;echo '														<tr>
															<td class="numeric" data-title="Vr#"><a href= "';echo base_url() ."index.php/yarnPurchase?vrnoa=".$Yarnpurchase['vrnoa'] ;;echo '"></a> ';echo $Yarnpurchase['vrnoa'];;echo '</td>
															<td data-title="Time">';echo $Yarnpurchase['date_time'];;echo '</td>
															<td data-title="User">';echo $Yarnpurchase['user_name'];;echo '</td>
															<td data-title="Account">';echo $Yarnpurchase['party_name'];;echo '</td>
															<td data-title="Disc"class="numeric">
																<span class="text-primary"><b>';echo $Yarnpurchase['discp'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['discount'];;echo '</b></span></li>
															</td>
															<td data-title="Comm"class="numeric">
																<span class="text-primary"><b>';echo $Yarnpurchase['exppercent'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['expense'];;echo '</b></span>
															</td>
															<td data-title="Tax" class="numeric">
																<span class="text-primary"><b>';echo $Yarnpurchase['taxpercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['tax'];;echo '</b></span></li>
															</td>
															<td class="numeric" data-title="NetAmount" style="text-align:right;">';echo $Yarnpurchase['namount'];;echo '</td>
														</tr>
													';endforeach  ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span>Total Yarn Purchase</span> : <span class="yarnpurchases-sum-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
									</div>
								</div>

							<!--.................................FABRIC PURCHASE ACCORDIANS .....................................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_3" style="background:#8D9389 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-md-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-shopping-cart" style="color:#90906F;"></i></span> Fabric Purchase
													</div>
													<div class="col-md-3" style="font-size:12px !important;">
														<span>Total:</span> : <span class="fabricpurchases-sum"> 00</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_3" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="no-more-tables">
											<table class="table table-striped table-hover">
											<thead class="cf">
													<tr>
														<th style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Time</th>
														<th style=\'background: #368EE0;\'>User</th>
														<th style=\'background: #368EE0;\'>Party</th>
														<th style=\'background: #368EE0;\' class="text-left">Discount</th>
														<th style=\'background: #368EE0;\' class="text-left">Commission</th>
														<th style=\'background: #368EE0;\' class="text-left">Tax</th>
														<th style=\'background: #368EE0;\' class="text-right">Net Amount</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($FabricPurchases as $Yarnpurchase): $tot +=$Yarnpurchase['namount'];;echo '														<tr>
															<td data-title="Vr#" ><a href= "';echo base_url() ."index.php/fabricPurchase?vrnoa=".$Yarnpurchase['vrnoa'] ;;echo '"></a> ';echo $Yarnpurchase['vrnoa'];;echo '</td>
															<td data-title="Time">';echo $Yarnpurchase['date_time'];;echo '</td>
															<td data-title="User">';echo $Yarnpurchase['user_name'];;echo '</td>
															<td data-title="Account">';echo $Yarnpurchase['party_name'];;echo '</td>
															<td data-title="Disc"class="numeric">
																<span class="text-primary"><b>';echo $Yarnpurchase['discp'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['discount'];;echo '</b></span></li>
															</td>
															<td data-title="Comm"class="numeric">
																<span class="text-primary"><b>';echo $Yarnpurchase['exppercent'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['expense'];;echo '</b></span>
															</td>
															<td data-title="Tax" class="numeric">
																<span class="text-primary"><b>';echo $Yarnpurchase['taxpercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['tax'];;echo '</b></span></li>
															</td>
															<td class="numeric" data-title="NetAmount" style="text-align:right;">';echo $Yarnpurchase['namount'];;echo '</td>
														</tr>
													';endforeach  ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="fabricpurchases-sum-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
										</table>
										</div>
									</div>
								</div>
							</div>

							<!--...........................................SALES ACCORDIANS...............................-->

							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_4" style="background:#B1B8AD !important; color:white;font-family:open sans;height: 40px;">
											<div class="row">
												<div class="col-md-9">
													<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-pencil-square-o" style="color:#90906F;"></i></span> Sale
												</div>
												<div class="col-md-3" style="font-size:12px !important;">
													<span>Total:</span> : <span class="sales-sum"> 00</span>
												</div>
											</div>
										</a>
									</h4>
								</div>
								<div id="accordion_a_4" class="panel-collapse collapse">
									<div class="panel-body">
										<div id="no-more-tables">
										<table class="table table-striped table-hover">
											<thead class="cf">
													<tr>
														<th class="numeric" style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Time</th>
														<th style=\'background: #368EE0;\'>User</th>
														<th style=\'background: #368EE0;\'>Party</th>
														<th class="numeric" style=\'background: #368EE0;\' class="text-left">Discount</th>
														<th class="numeric" style=\'background: #368EE0;\' class="text-left">Commission</th>
														<th style=\'background: #368EE0;\' class="text-left numeric">Tax</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Net Amount</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($sales as $Yarnpurchase): $tot +=$Yarnpurchase['namount'];;echo '														<tr>
															<td data-title="Vr#" class="numeric"><a href= "';echo base_url() ."index.php/saleorder/Sale_Invoice?vrnoa=".$Yarnpurchase['vrnoa'] ;;echo '"></a> ';echo $Yarnpurchase['vrnoa'];;echo '</td>
															<td data-title="Time" >';echo $Yarnpurchase['date_time'];;echo '</td>
															<td data-title="User" >';echo $Yarnpurchase['user_name'];;echo '</td>
															<td data-title="Account" >';echo $Yarnpurchase['party_name'];;echo '</td>
															<td data-title="Disc" class="numeric">
																<span class="text-primary"><b>';echo $Yarnpurchase['discp'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['discount'];;echo '</b></span></li>
															</td>
															<td data-title="Comm" class="numeric">
																<span class="text-primary"><b>';echo $Yarnpurchase['exppercent'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['expense'];;echo '</b></span>
															</td>
															<td data-title="Tax" class="numeric">
																<span class="text-primary"><b>';echo $Yarnpurchase['taxpercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['tax'];;echo '</b></span></li>
															</td>
															<td data-title="NetAmount" class="numeric" style="text-align:right;">';echo $Yarnpurchase['namount'];;echo '</td>
														</tr>
													';endforeach  ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="sales-sum-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
										</table>
										</div>
									</div>
								</div>
							</div>

							<!--......................................SALE ORDER ACCORDIANS.................................-->

							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_5" style="background:#CAD0C6 !important; color:white;font-family:open sans;height: 40px;">
											<div class="row">
												<div class="col-md-9">
													<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-file-text" style="color:#90906F;"></i></span> <span style="font-size:15px !important;">Sale Order</span>
												</div>
												<div class="col-md-3" style="font-size:12px !important;">
													<span>Total:</span> : <span class="saleOrder-sum"> 00</span>
												</div>
											</div>
										</a>
									</h4>
								</div>
								<div id="accordion_a_5" class="panel-collapse collapse">
									<div class="panel-body">
										<div id="no-more-tables">
										<table class="table table-striped table-hover">
											<thead class="cf">
													<tr>
														<th class="numeric" style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Time</th>
														<th style=\'background: #368EE0;\'>User</th>
														<th style=\'background: #368EE0;\'>Party</th>
														<th class="numeric" style=\'background: #368EE0;\' class="text-left">Discount</th>
														<th class="numeric" style=\'background: #368EE0;\' class="text-left">Commission</th>
														<th style=\'background: #368EE0;\' class="text-left numeric">Tax</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Net Amount</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($saleOrders as $Yarnpurchase): $tot +=$Yarnpurchase['namount'];;echo '														<tr>
															<td data-title="Vr#" class="numeric" ><a href= "';echo base_url() ."index.php/saleorder?vrnoa=".$Yarnpurchase['vrnoa'] ;;echo '"></a> ';echo $Yarnpurchase['vrnoa'];;echo '</td>
															<td data-title="Time">';echo $Yarnpurchase['date_time'];;echo '</td>
															<td data-title="User">';echo $Yarnpurchase['user_name'];;echo '</td>
															<td data-title="Account">';echo $Yarnpurchase['party_name'];;echo '</td>
															<td data-title="Disc" class="numeric" >
																<span class="text-primary"><b>';echo $Yarnpurchase['discp'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['discount'];;echo '</b></span></li>
															</td>
															<td data-title="Comm" class="numeric" >
																<span class="text-primary"><b>';echo $Yarnpurchase['exppercent'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['expense'];;echo '</b></span>
															</td>
															<td data-title="Tax" class="numeric" >
																<span class="text-primary"><b>';echo $Yarnpurchase['taxpercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger text-right"><b>';echo $Yarnpurchase['tax'];;echo '</b></span></li>
															</td>
															<td data-title="NetAmount" class="numeric"  style="text-align:right;">';echo $Yarnpurchase['namount'];;echo '</td>
														</tr>
													';endforeach  ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="saleOrder-sum-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<div class="row-fluid">
					<div class="col-md-14">
						<h4 class="text-primary" style="font-family:open sans;"><i class="fa fa-building"></i> <b>A</b>ccounts</h4>
						<div class="panel-group" id="accordion_a">

							<!--..........................................PAYMENTS ACCORDIANS................................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_6" style="background: #CAD0C6 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-md-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-money" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Payments
													</div>
													<div class="col-md-3" style="font-size:12px !important;">
														<span>Total :</span> : <span class="sum_payments">0</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_6" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="no-more-tables">
											<table class="table table-striped table-hover">
												<thead class="cf">
													<tr>
														<th class="numeric" style=\'background: #368EE0;\' >Vr#</th>
														<th style=\'background: #368EE0;\' >Time</th>
														<th style=\'background: #368EE0;\' >User</th>
														<th style=\'background: #368EE0;\'>Account Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th class="numeric" style=\'background: #368EE0;\'>Inv#</th>
														<th class="numeric" style=\'background: #368EE0;\'>WO#</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Debit</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Credit</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($paymentss as $receipt):$tot +=$receipt['debit'];;echo '														<tr>
															<td data-title="Vr#" class="numeric"><a href= "';echo base_url() ."index.php/payment?vrnoa=".$receipt['dcno'] ."&etype=cpv";;echo '"></a> ';echo $receipt['dcno'];;echo '</td>
															<td data-title="Time" >';echo $receipt['date_time'];;echo '</td>
															<td data-title="User" >';echo $receipt['user_name'];;echo '</td>
															<td data-title="Account" >';echo $receipt['party_name'];;echo '</td>
															<td data-title="Remarks" >';echo $receipt['description'];;echo '</td>
															<td class="numeric" data-title="Inv#" >';echo $receipt['invoice'];;echo '</td>
															<td class="numeric" data-title="Wo#" >';echo $receipt['wo'];;echo '</td>
															<td data-title="Debit"  class="text-primary text-right numeric"><b>';echo $receipt['debit'];;echo '</b></td>
															<td data-title="Credit"  class="text-danger text-right numeric"><b>';echo $receipt['credit'];;echo '</b></td>
															
														</tr>
													';endforeach ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="sum_payments-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
									</div>
								</div>

								<!--...........................................RECEIPTS ACCORDIANS..............................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_7" style="background:#B1B8AD !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-md-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-money" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Receipts
													</div>
													<div class="col-md-3" style="font-size:12px !important;">
														<span>Total:</span> : <span class="sum_receipts"> </span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_7" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="no-more-tables">
											<table class="table table-striped table-hover">
												<thead class="cf">
													<tr>
														<th class="numeric" style=\'background: #368EE0;\' >Vr#</th>
														<th style=\'background: #368EE0;\' >Time</th>
														<th style=\'background: #368EE0;\' >User</th>
														<th style=\'background: #368EE0;\'>Account Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th class="numeric" style=\'background: #368EE0;\'>Inv#</th>
														<th class="numeric" style=\'background: #368EE0;\'>WO#</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Debit</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Credit</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($receiptss as $receipt): $tot +=$receipt['debit'];;echo '														<tr>
															<td data-title="Vr#" class="numeric" ><a href= "';echo base_url() ."index.php/payment?vrnoa=".$receipt['dcno'] ."&etype=crv";;echo '"></a> ';echo $receipt['dcno'];;echo '</td>
															<td data-title="Time" >';echo $receipt['date_time'];;echo '</td>
															<td data-title="User" >';echo $receipt['user_name'];;echo '</td>
															<td data-title="Account" >';echo $receipt['party_name'];;echo '</td>
															<td data-title="Remarks" >';echo $receipt['description'];;echo '</td>
															<td class="numeric" data-title="Inv#" >';echo $receipt['invoice'];;echo '</td>
															<td class="numeric" data-title="Wo#" >';echo $receipt['wo'];;echo '</td>
															<td data-title="Debit"  class="text-primary text-right numeric"><b>';echo $receipt['debit'];;echo '</b></td>
															<td data-title="Credit"  class="text-danger text-right numeric"><b>';echo $receipt['credit'];;echo '</b></td>
															
														</tr>
													';endforeach ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="sum_receipts-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
									</div>
								</div>

								<!--.............................................CHEQUE ISSUE ACCORDIANS ...........................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
										<span class="badge">';echo $no;;echo '</span>
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_bpv" style="background:#8D9389 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
												
													<div class="col-md-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-building" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Bank Payments
														
													</div> 
													<div class="col-md-3" style="font-size:12px !important;">
														<span>Total:</span> : <span class="bpv-sum">0</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_bpv" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="no-more-tables">
											<table class="table table-striped table-hover">
												<thead class="cf">
													<tr>
														<th class="numeric" style=\'background: #368EE0;\' >Vr#</th>
														<th style=\'background: #368EE0;\' >Time</th>
														<th style=\'background: #368EE0;\' >Ptype</th>
														<th style=\'background: #368EE0;\'>Account Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th class="numeric" style=\'background: #368EE0;\'>Chq#</th>
														<th class="numeric" style=\'background: #368EE0;\'>ChqDate</th>
														<th class="numeric" style=\'background: #368EE0;\'>Inv#</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Debit</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Credit</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($bpvs as $receipt): $tot +=$receipt['debit'];;echo '														<tr>
															<td data-title="Vr#" class="numeric"><a href="http://localhost:8080/naeel1/index.php/jv/bpv?vrnoa=';echo$receipt['dcno'];echo'">';echo $receipt['dcno'];;echo '</a></td>
															<td data-title="Time" >';echo $receipt['date_time'];;echo '</td>
															<td data-title="User" >';echo $receipt['ptype'];;echo '</td>
															<td data-title="Account" >';echo $receipt['party_name'];;echo '</td>
															<td data-title="Remarks" >';echo $receipt['description'];;echo '</td>
															<td class="numeric"  data-title="Chq#" >';echo $receipt['chq_no'];;echo '</td>
															<td class="numeric"  data-title="ChqDate" >';echo $receipt['chq_date'];;echo '</td>
															<td class="numeric"  data-title="Inv#" >';echo $receipt['invoice'];;echo '</td>
															<td data-title="Debit"  class="text-primary text-right numeric"><b>';echo $receipt['debit'];;echo '</b></td>
															<td data-title="Credit"  class="text-danger text-right numeric"><b>';echo $receipt['credit'];;echo '</b></td>
															
														</tr>
													';endforeach ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="bpv-sum-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">

										<span class="badge">';echo $no_1 ;;echo '</span>
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_brv" style="background:#8D9389 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-md-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-building" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Bank Receipts
													</div> 
													<div class="col-md-3" style="font-size:12px !important;">
														<span>Total:</span> : <span class="brv-sum">0</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_brv" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="no-more-tables">
											<table class="table table-striped table-hover">
												<thead class="cf">
													<tr>
														<th class="numeric" style=\'background: #368EE0;\' >Vr#</th>
														<th style=\'background: #368EE0;\' >Time</th>
														<th style=\'background: #368EE0;\' >User</th>
														<th style=\'background: #368EE0;\'>Account Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th class="numeric" style=\'background: #368EE0;\'>Chq#</th>
														<th class="numeric" style=\'background: #368EE0;\'>ChqDate</th>
														<th class="numeric" style=\'background: #368EE0;\'>Inv#</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Debit</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Credit</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($brvs as $receipt): $tot +=$receipt['debit'];;echo '														<tr>
													<td data-title="Vr#" class="numeric"><a href="http://localhost:8080/naeel1/index.php/jv/brv?vrnoa=';echo$receipt['dcno'];echo'">';echo $receipt['dcno'];;echo '</a></td>
															<td data-title="Time" >';echo $receipt['date_time'];;echo '</td>
															<td data-title="User" >';echo $receipt['ptype'];;echo '</td>
															<td data-title="Account" >';echo $receipt['party_name'];;echo '</td>
															<td data-title="Remarks" >';echo $receipt['description'];;echo '</td>
															<td class="numeric"  data-title="Chq#" >';echo $receipt['chq_no'];;echo '</td>
															<td class="numeric"  data-title="ChqDate" >';echo $receipt['chq_date'];;echo '</td>
															<td class="numeric"  data-title="Inv#" >';echo $receipt['invoice'];;echo '</td>
															<td   data-title="Debit"  class="text-primary text-right numeric"><b>';echo $receipt['debit'];;echo '</b></td>
															<td   data-title="Credit"  class="text-danger text-right numeric"><b>';echo $receipt['credit'];;echo '</b></td>
															
														</tr>
													';endforeach ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="brv-sum-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_8" style="background:#8D9389 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-md-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-newspaper-o" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Cheque Issue
													</div> 
													<div class="col-md-3" style="font-size:12px !important;">
														<span>Total:</span> : <span class="pd_issue-sum">0</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_8" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="no-more-tables">
											<table class="table table-striped table-hover">
												<thead class="cf">
													<tr>
														<th class="numeric" style=\'background: #368EE0;\' >Vr#</th>
														<th style=\'background: #368EE0;\' >Time</th>
														<th style=\'background: #368EE0;\' >User</th>
														<th style=\'background: #368EE0;\'>Account Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th class="numeric" style=\'background: #368EE0;\'>Chq#</th>
														<th class="numeric"  style=\'background: #368EE0;\'>ChqDate</th>
														<th class="numeric" style=\'background: #368EE0;\'>Inv#</th>
														<th class="numeric" style=\'background: #368EE0;\'>WO#</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Debit</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Credit</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($cheqIssues as $receipt): $tot +=$receipt['debit'];;echo '														<tr>
															<td data-title="Vr#" class="numeric"><a href= "';echo base_url() ."index.php/payment/chequeIssue?vrnoa=".$receipt['dcno'] ;;echo '"></a> ';echo $receipt['dcno'];;echo '</td>
															<td data-title="Time">';echo $receipt['date_time'];;echo '</td>
															<td data-title="User">';echo $receipt['user_name'];;echo '</td>
															<td data-title="Account">';echo $receipt['party_name'];;echo '</td>
															<td data-title="Remarks">';echo $receipt['description'];;echo '</td>
															<td data-title="chq#" class="numeric">';echo $receipt['chq_no'];;echo '</td>
															<td data-title="ChqDate">';echo $receipt['chq_date'];;echo '</td>
															<td data-title="Inv#" class="numeric">';echo $receipt['invoice'];;echo '</td>
															<td data-title="Wo" class="numeric">';echo $receipt['wo'];;echo '</td>
															<td data-title="Debit" class="text-primary text-righ numerict"><b>';echo $receipt['debit'];;echo '</b></td>
															<td data-title="Credit" class="text-danger text-right numeric"><b>';echo $receipt['credit'];;echo '</b></td>
															
														</tr>
													';endforeach ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="pd_issue-sum-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
											</table>
											</div>
										</div>
									</div>
								</div>

								<!--.........................................CHEQUE RECEIVE ACCORDIANS...............................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_9" style="background:#747672 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-md-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-newspaper-o" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Cheque Receives
													</div>
													<div class="col-md-3" style="font-size:12px !important;">
														<span>Total:</span> : <span class="pd_receive-sum"> 0</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_9" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="no-more-tables">
											<table class="table table-striped table-hover">
												<thead class="cf">
													<tr>
														<th class="numeric"style=\'background: #368EE0;\' >Vr#</th>
														<th style=\'background: #368EE0;\' >Time</th>
														<th style=\'background: #368EE0;\' >User</th>
														<th style=\'background: #368EE0;\'>Account Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th class="numeric" style=\'background: #368EE0;\'>Chq#</th>
														<th class="numeric" style=\'background: #368EE0;\'>ChqDate</th>
														<th class="numeric" style=\'background: #368EE0;\'>Inv#</th>
														<th class="numeric" style=\'background: #368EE0;\'>WO#</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Debit</th>
														<th style=\'background: #368EE0;\' class="text-right numeric">Credit</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;$tot=0;foreach ($chequeReceives as $receipt): $tot +=$receipt['debit'];;echo '														<tr>
															<td data-title="Vr#" class="numeric"><a href= "';echo base_url() ."index.php/payment/chequeReceive?vrnoa=".$receipt['dcno'] ;;echo '"></a> ';echo $receipt['dcno'];;echo '</td>
															<td data-title="Time">';echo $receipt['date_time'];;echo '</td>
															<td data-title="User">';echo $receipt['user_name'];;echo '</td>
															<td data-title="Account">';echo $receipt['party_name'];;echo '</td>
															<td data-title="Remarks">';echo $receipt['description'];;echo '</td>
															<td data-title="chq#" class="numeric">';echo $receipt['chq_no'];;echo '</td>
															<td data-title="ChqDate">';echo $receipt['chq_date'];;echo '</td>
															<td data-title="Inv#" class="numeric">';echo $receipt['invoice'];;echo '</td>
															<td data-title="Wo" class="numeric">';echo $receipt['wo'];;echo '</td>
															<td data-title="Debit" class="text-primary text-righ numerict"><b>';echo $receipt['debit'];;echo '</b></td>
															<td data-title="Credit" class="text-danger text-right numeric"><b>';echo $receipt['credit'];;echo '</b></td>
															
														</tr>
													';endforeach ;echo '												</tbody>
												<tfoot class="hidden">
													<tr>
														<td><span></span> : <span class="pd_receive-sum-val">';echo $tot;;echo '</span></td>
													</tr>
												</tfoot>
										</table>
										</div>
									</div>
								</div>
							</div>

							<!--....................................EXPENSES ACCORDIANS...............................-->

							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_10" style="background:#5A6062 !important; color:white;font-family:open sans;height: 40px;">
											<div class="row">
												<div class="col-md-9">
													<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-xing-square" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Expenses
												</div>
												<div class="col-md-3" style="font-size:12px !important;">
													<span>Total:</span> : <span class="expenses-sum">0</span>
												</div>
											</div>
										</a>
									</h4>
								</div>
								<div id="accordion_a_10" class="panel-collapse collapse">
									<div class="panel-body">
										<div id="no-more-tables">
										<table class="table table-striped table-hover">
											<thead class="cf">
												<tr>
													<th class="numeric" style=\'background: #368EE0;\'>Vr#</th>
													<th style=\'background: #368EE0;\'>Party Name</th>
													<th class="numeric" style=\'background: #368EE0;\'>Amount</th>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;$tot=0;foreach ($expensess as $expenses): $tot +=$expenses['AMOUNT'];;echo '													<tr>
														<td data-title="Vr#" class="numeric">';echo $counter++;;echo '</td>
														<td data-title="Account">';echo $expenses['NAME'];;echo '</td>
														<td data-title="Amount" class="text-primary numeric"><b>';echo $expenses['AMOUNT'];;echo '</b></td>
													</tr>
												';endforeach ;echo '											</tbody>
											<tfoot class="hidden">
												<tr>
													<td><span></span> : <span class="expenses-sum-val">';echo $tot;;echo '</span></td>
												</tr>
											</tfoot>
										</table>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
</div>

				<!--.................................TOP TILES .........................................-->
			

				
		</div>
	</div>
	<div class="col-md-6">
	<div class="container"  >

		<h2>Charts Dashboard</h2>   
		<button type="button" class="btn btn-info btnchart">Purchase</button>
		<button type="button" class="btn btn-info btnsalechart">Sales</buton>
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
	  </div>
    </div>
	</div>  <!-- end of panel-body -->
  </div>  <!-- end of panel -->




</div>  <!-- end of col -->
</div>  <!-- end of row -->

  
			
	
<!--<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/general.js');;echo '"></script>
-->
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/general.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/dashboard.js');;echo '"></script>
<script src="';$this->session->set_userdata('date_close','');;echo '"></script>
';
?>