

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
	<title>Daybook Report</title>

	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">

	<style>

		* { margin: 0; padding: 0; font-family: tahoma; }
		 body { font-size:12px; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: none !important; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
		th { border: 1px solid black; padding: 5px; }
		td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: none !important;}
		a:after { display:none; }
		.printRemove11 { display:none; }
		@media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 .tfoot_tbl{color: red;background-color: white;font-weight: bold; text-align: right;}
		 .centered { margin: auto; }
		 @page{margin:10px auto !important; }
		 .rcpt-header { margin: auto; display: block; }
		 td:first-child { text-align: left; }
	
		.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black; }
		.finalsum, .level2head,.level1head,.level3head {border-top: 1px solid black;}
		.hightlight_tr td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black; }
		.finalsum td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(250, 250, 250); color: black; }
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
		 .shadowhead { border-bottom: 0px solid black; padding-bottom: 5px; } 
		 .AccName { border-bottom: 0px solid black; padding-bottom: 5px; font-size: 16px; } 

		 .txtbold { font-weight: bolder; } 
	</style>
</head>
<body>
	<script id="tblrow-template" type="text/x-handlebars-template">
	  <tr>
	     <td>{{SERIAL}}</td>
	     <td>{{DATE}}</td>
	     <td>{{VRNOA}}</td>
	     <td>{{PARTY}}</td>
	     <td>{{CREDIT}}</td>
	     <td>{{DEBIT}}</td>
	  </tr>
	</script>
	<div class="container-fluid" style="margin-top:10px;">
		<div class="row-fluid">
			<div class="span12 centered">
				<!-- <div class="row-fluid"> -->
					<!-- <div class="span2"></div> -->
					<!-- <div class="span12"><img class="rcpt-header" src="../../assets/img/rcpt-header.png" alt=""></div> -->
					<!-- <div class="spn2"></div> -->
				<!-- </div> -->
				<!-- <div class="row-fluid relative">
					<div class="span12">
							<div class="block pull-left inv-leftblock">
								<p><span class="field">A/C Title</span><span class="fieldvalue accountTitle">[A/C Title]</span></p>
								<p><span class="field">A/C Code</span><span class="fieldvalue accountCode">[A/C Code]</span></p>
								<p><span class="field">Address</span><span class="fieldvalue address">[Address]</span></p>
								<p><span class="field">Contact #</span><span class="fieldvalue contactNum">[Contact #]</span></p>
							</div>
							<div class="block pull-right">
								<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important;"></h3>
							</div>
					</div>
				</div> -->
				<div class="row-fluid">
					<div class="span12 centered">
<!-- 						<div class="row-fluid">
							<div class="span12 text-center">
								<h3 class="text-center shadowhead">[Payable/Receivable]</h3>
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
							</div>
						</div> -->
						<br>
						<div class="row-fluid">
							<div class="span12">
								<table class="voucher-table">
									<thead>
										<col style="width:50px" />
										<col style="width:65px" />
										<col style="width:80px" />
										<col />
										<col />
										<col style="width:100px;" />
										<col style="width:100px;" />
										<col style="width:100px;" />
										<col style="width:100px;" />

										<tr>
											<th colspan="9">
												<h3 class="text-center shadowhead">[Payable/Receivable]</h3>
												<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
											</th>
										</tr>
										<tr>
											<th style="width:40px;">#</th>
											<th style="width:55px;">Date</th>
											<th style="width: 125px;">Vr #</th>
											<th>Account</th>
											<th>Remarks</th>
											<th style="width:100px;">Chq#</th>
											<th style="width:100px;">ChqDate</th>
											<th style="width:100px;">Credit</th>
											<th style="width:100px;">Debit</th>
										</tr>
									</thead>
									<tbody id="htmlRows">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<br>
				<!-- <p><strong>Note:</strong>  Here please find our acount statement and check it, if any discrepancy please let it be known within a week. Otherwise it would be assumed that our statement is correct. Thanks!</p> -->
				<br>
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
	<script type="text/javascript" src="../../../assets/js/jquery.min.js"></script>
	<script src="../../../assets/js/handlebars.js"></script>

	<script type="text/javascript">
		$(function(){
			
			var opener = window.opener;
			
			var fromDate = opener.$(\'#from\').val();
			var toDate = opener.$(\'#to\').val();			
			var etype = opener.$(\'input[name=etype]:checked\').val().toUpperCase();
			// var etype = acct.getEtype();
			var netBal = opener.$(\'.netamt_td\').text().trim();

			var parentRows = opener.$(\'.parentTableRows tr\');

			var rowsHtml = \'\';

			var netBalance = 0;

			var parentCopy = opener.$(\'.parentTableRows tr\').clone();

			parentCopy.find(\'.printRemove\').remove();

			/*$(parentRows).each(function( index, elem ){

				var obj = {};

				obj.SERIAL = $(elem).find(\'.tblSerial\').text().trim();
				obj.PARTY = $(elem).find(\'.tblParty\').text().trim();
				obj.BALANCE = $(elem).find(\'.tblBalance\').text().trim();

				netBalance += parseFloat(obj.BALANCE);

				var handler = $(\'#tblrow-template\').html();
				var template = Handlebars.compile(handler);
				var html = template(obj);

				rowsHtml += html;
			});	*/
			$(\'#htmlRows\').append(parentCopy);

			$(\'.fromDate\').html(fromDate);
			$(\'.toDate\').html(toDate);
			// $(\'.shadowhead\').html((etype.toLowerCase() === \'daybook\') ? \'Daybook Report\' : \'JV Report\');
			var heading=\'\';
			if(etype.toLowerCase()==\'cpv\'){
				heading=\'Cash Payment\';
			}else if(etype.toLowerCase()==\'crv\'){
				heading=\'Cash Receipt\';
			}else if(etype.toLowerCase()==\'expense\'){
				heading=\'Expense Report\';
			}else if(etype.toLowerCase()==\'jv\'){
				heading=\'JV\';
			}else if(etype.toLowerCase()==\'bpv\'){
				heading=\'Bank Payment\';
			}else if(etype.toLowerCase()==\'brv\'){
				heading=\'Bank Receipt\';
			}else if(etype.toLowerCase()==\'daybook\'){
				heading=\'Daybook \';
			}else if(etype.toLowerCase()==\'payable\'){
				heading=\'Payable\';
			}else if(etype.toLowerCase()==\'receivable\'){
				heading=\'Receivable\';
			}
			$(\'.shadowhead\').html(heading  + \' Report\');
			$(\'.netBalance\').html(netBal);

		});
	</script>
</body>
</html>';
?>