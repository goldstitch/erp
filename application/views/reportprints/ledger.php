

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!DOCTYPE html>
<html>
<head>
	<title>Account Ledger</title>

	<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
	    <link rel="stylesheet" href="../../assets/css/bootstrap-responsive.min.css">

	<style>
		 * { margin: 0; padding: 0; font-family: tahoma; }
		 body { font-size:12px; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
		th { border: 1px solid black; padding: 5px; }
		td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: 1px solid black;}
		@media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 .centered { margin: auto; }
		 @page{margin:0px auto !important;}
		 .rcpt-header { margin: auto; display: block; }
		 td:first-child { text-align: left; }
		 .field {font-weight: bold; display: inline-block; width: 80px; } 
		 .voucher-table thead th {background: #ccc; padding:3px; text-align: center; font-size: 12px;} 
		 tfoot {border-top: 1px solid black; } 
		 .bold-td { font-weight: bold; border-bottom: 1px solid black;}
		 .nettotal { font-weight: bold; font-size: 14px; border-top: 1px solid black; }
		 .invoice-type { border-bottom: 1px solid black; }
		 .relative { position: relative; }
		 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
		 .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px; }
		 .inv-leftblock { width: 280px; }
		 .text-left { text-align: left !important; }
		 .text-right { text-align: right !important; }
		 td {font-size: 10px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase;} 
		 .rcpt-header { width: 450px; margin: auto; display: block; }
		 .inwords, .remBalInWords { text-transform: uppercase; }
		 .barcode { margin: auto; }
		 h3.invoice-type {font-size: 20px; width: 209px; line-height: 24px;}
		 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; } 
		 .nettotal { color: red; }
		 .remainingBalance { font-weight: bold; color: blue;}
		 .centered { margin: auto; }
		 p { position: relative; }
		 .fieldvalue.cust-name {position: absolute; width: 497px; } 
		 .shadowhead { padding-bottom: 5px; text-align: right;margin-top: -12px !important;} 
		 .logo-img { width: 170px; }
	</style>
</head>
<body>
	<script id="ledger-template" type="text/x-handlebars-template">
	  <tr>
	     <td>{{VRDATE}}</td>
	     <td>{{VRNOA}}</td>
	     <td style="display:none;">{{ETYPE}}</td>
	     <td>{{DESCRIPTION}}</td>
	     <td class="text-right" style="text-align:right !important;">{{DEBIT}}</td>
	     <td class="text-right" style="text-align:right !important;">{{CREDIT}}</td>
	     <td class="text-right" style="text-align:right !important;">{{RTOTAL}}</td>
	  </tr>
	</script>
	<div class="container-fluid" style="margin-top:20px;">
		<div class="row-fluid">
			<div class="span12 centered">
				<div class="row-fluid" style="display:none;">
					<!-- <div class="span2"></div> -->
					<div class="span12"><img class="rcpt-header" src="../../assets/img/rcpt-header.png" alt=""></div>
					<!-- <div class="spn2"></div> -->
				</div>
				<div class="row-fluid relative">
					<div class="span12">
							<div class="block pull-left inv-leftblock">
								<p><span class="field">A/C Title</span><span class="fieldvalue accountTitle">[A/C Title]</span></p>
								<p><span class="field">A/C Code</span><span class="fieldvalue accountCode">[A/C Code]</span></p>
								<p><span class="field">Address</span><span class="fieldvalue address">[Address]</span></p>
								<p><span class="field">Contact #</span><span class="fieldvalue contactNum">[Contact #]</span></p>
							</div>
							<div class="block pull-right">
								<img src="header.png" alt="" class="logo-img" />
								<!-- <h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important;"></h3> -->
							</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 centered">
						<div class="row-fluid">
							<div class="span12 text-center" style="margin-top: 10px;">
								<p style="line-height: 0px;padding-top: 13px;text-align: left;position: absolute;"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p><h3 class="text-center shadowhead">Ledger of Account</h3>
							</div>
						</div>
						<br>
						<div class="row-fluid" style="position: relative;margin-top: -26px;">
							<div class="span12">
								<table class="voucher-table">
									<thead>
										<th>DATE</th>
										<th>Vr#</th>
										<th style="display:none;">TYPE</th>
										<th style="width:260px;">Particulars</th>
										<th>DEBIT</th>
										<th>CREDIT</th>
										<th>BALANCE</th>
									</thead>
									<tbody id="htmlRows">
										
									</tbody>
									<tfoot class="netRows">
										<td colspan="3" class="text-right"><strong>Total</strong></td>
										<td class=\'text-right netDebit\'></td>
										<td class=\'text-right netCredit\'></td>
										<td class=\'text-right netBalance\'></td>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
				<br>
				<p><strong>Note:</strong>  Here please find our acount statement and check it, if any discrepancy please let it be known within a week. Otherwise it would be assumed that our statement is correct. Thanks!</p>
				<br>
				<br><br>
				<div class="row-fluid">
					<div class="span12">
						<table class="signature-fields">
							<thead>
								<tr>
									<th style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By</th>
									<th style="border:1px solid white;"></th>
									<th style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/handlebars.js"></script>

	<script type="text/javascript">
		$(function(){
			
			var opener = window.opener;
			
			var fromDate = opener.$(\'#txtStart\').val();
			var toDate = opener.$(\'#txtEnd\').val();
			var accountTitle = opener.$(\'#drpAccId option:selected\').text();
			var accountCode = opener.$(\'#drpAccId option:selected\').data(\'acccode\');
			var contact = opener.$(\'#drpAccId option:selected\').data(\'contact\');
			var address = opener.$(\'#drpAccId option:selected\').data(\'address\');

			contact = ( $.trim(contact) === \'\' ) ? \'N/A\' :  $.trim(contact);

			var ledgerRows = opener.$(\'.ledgerRows tr\');

			var rowsHtml = \'\';

			var netDebit = 0;
			var netCredit = 0;
			var netBalance = 0;

			$(ledgerRows).each(function( index, elem ){

				var obj = {};

				obj.VRDATE = $(elem).find(\'.vrdate\').text();

				obj.VRNOA = $(elem).find(\'.vrnoa\').text();				
				var vr = obj.VRNOA.split(\'-\')[0];
				//alert(obj.VRNOA);
				if (obj.VRNOA.toString().search("pd_issue") != \'-1\') {
					obj.VRNOA = vr + "-PDI";
				} else if(obj.VRNOA.toString().search("pd_receive") != \'-1\') {
					obj.VRNOA = vr + "-PDR";
				} else if(obj.VRNOA.toString().search("purchasereturn") != \'-1\') {
					obj.VRNOA = vr + "-PURRET";
				} else if(obj.VRNOA.toString().search("purchase") != \'-1\') {
					obj.VRNOA = vr + "-PUR";
				} else if(obj.VRNOA.toString().search("salereturn") != \'-1\') {
					obj.VRNOA = vr + "-SLRET";
				}


				obj.ETYPE = $(elem).find(\'.etype\').text();
				obj.DESCRIPTION = $(elem).find(\'.description\').text();
				obj.DEBIT = $(elem).find(\'.debit\').text();
				obj.CREDIT = $(elem).find(\'.credit\').text();
				obj.RTOTAL = $(elem).find(\'.rtotal\').text();

				netDebit += parseFloat(obj.DEBIT);
				netCredit += parseFloat(obj.CREDIT);

				if (index === ( ledgerRows.length-1 )) {
					netBalance = obj.RTOTAL;
				};

				var handler = $(\'#ledger-template\').html();
				var template = Handlebars.compile(handler);
				var html = template(obj);

				rowsHtml += html;
			});	

			$(\'#htmlRows\').append(rowsHtml);

			$(\'.accountTitle\').html(accountTitle);
			$(\'.accountCode\').html(accountCode);
			$(\'.address\').html( ($.trim(address) === \'\') ? \'N/A\' : $.trim(address));
			$(\'.contactNum\').html(contact);
			$(\'.fromDate\').html(fromDate);
			$(\'.toDate\').html(toDate);

			// var header_img = opener.$(\'.header_img\').val();
			// $(\'img.logo-img\').prop(\'src\', \'../../assets/uploads/header_imgs/\' + header_img );

			$(\'.netDebit\').html(netDebit);
			$(\'.netCredit\').html(netCredit);
			$(\'.netBalance\').html(netBalance)
		});
	</script>
</body>
</html>';
?>