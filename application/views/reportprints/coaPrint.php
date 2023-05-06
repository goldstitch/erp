

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
	<title>Chart Of Accounts</title>

	<link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">

	<style>

		 * { margin: 0; padding: 0; font-family: tahoma; }
		 body { font-size:12px; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
		th { border: 1px solid black; padding: 5px; }
		td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: 1px solid black; color: black !important; }
		@media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 a:link:after { display:none !important; }
		 .centered { margin: auto; }
		 @page{margin:10px auto !important; }
		 .rcpt-header { margin: auto; display: block; }
		 td:first-child { text-align: left; }
	
		.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black; }

		.hightlight_tr td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black; }
		.info td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(100, 100, 100); color: black; }
		.success td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(150, 150, 150); color: black; }
		.active td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black; }

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
		 td {font-size: 12px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase;} 
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
		 .shadowhead { border-bottom: 1px solid black; padding-bottom: 5px; } 
	</style>
</head>
<body>
	<script id="tblrow-template" type="text/x-handlebars-template">
	  <tr>
			<td >{{ITEM_ID}}</td>
		    <td >{{ITEM_CODE}}</td>
		    <td >{{BRAND}}</td>
		    <td >{{DESCRIPTION}}</td>
		    <td >{{UOM}}</td>
		    <td >{{RATE}}</td>
		    <td >{{WEIGHT}}</td>
	  </tr>
	</script>
	<div class="container-fluid" style="margin-top:10px;">
		<div class="row-fluid">
			<div class="span12 centered">
				
					<div class="span12 centered">
						
						<div class="row-fluid">
							<div class="span12">
								<table class="voucher-table">
									<thead>
										<col style="width:150px;">
										<col >
										<col style="width: 100px;">

										
										<tr>
											<th colspan="3">
												<h3 class="text-center shadowhead">[Cash Report]</h3>
												
											</th>
										</tr>
										<tr>
											<th style="width:150px;">Code</th>
											<th>Description</th>
											<th>Active</th>

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
			
			// var fromDate = opener.$(\'#from\').val();
			// var toDate = opener.$(\'#to\').val();			
			// var etype = opener.$(\'input[name=etype]:checked\').val().toUpperCase();

			var netBal = opener.$(\'.netamt_td\').text().trim();

			var parentRows = opener.$(\'#chartOfAccountRows tr\');

			var rowsHtml = \'\';

			var netBalance = 0;

			var parentCopy = opener.$(\'#chartOfAccountRows tr\').clone();

			parentCopy.find(\'.printRemove\').remove();
			var head = \'Chart Of Accounts\';

			$(\'#htmlRows\').append(parentCopy);

			// $(\'.fromDate\').html(fromDate);
			// $(\'.toDate\').html(toDate);
			$(\'.shadowhead\').html( head );
			// $(\'.netBalance\').html(netBal);

		});
	</script>
</body>
</html>';
?>