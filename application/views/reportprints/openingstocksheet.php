
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
	<title>Opening Stock Sheet</title>

	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">

	<style>
		 * { margin: 0; padding: 0; font-family: tahoma; }
		 body { font-size:12px; }
		 .never-hide { border-top: 1px solid black; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; none; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
		th { border: 1px solid black; padding: 5px; }
		td { /*text-align: center;*/ vertical-align: top; /*padding: 5px 10px;*/ border-top: 1px solid black;}
		@media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 .hightlight_tr{background-color: gray !important; font-weight: bolder;font-size: 18px !important;}
		 .centered { margin: auto; }
		 @page{margin:10px auto;}
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
		 .inv-leftblock { width: 310px; }
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
		 .shadowhead { border-bottom: 1px solid black; padding-bottom: 5px; }
		 .level1head td, .level2head td, .level3head td, .stockhead td { font-weight: bold; }
		 .netAssetsTotal, .netLiabilityTotal { font-weight: bold; }
	</style>
</head>
<body>
	<div class="container-fluid" style="margin-top:10px;">
		<div class="row-fluid">
			<div class="span12 centered">
				<div class="row-fluid">
					<div class="span12 centered">
						<!-- <div class="row-fluid">
							<div class="span12 text-center">
								<h3 class="text-center shadowhead">Closing Stock Sheet</h3>
								To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
							</div>
						</div>
						<br>
						<div class="row-fluid">
							<div class="span6">
								<h4>Assets</h4>
							</div>
							<div class="span6">
								<h4>Liabilities</h4>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span6 assetsTable"></div>
							<div class="span6 liabilityTable"></div>
						</div> -->
						<table>
							<thead>
								
								<col style="width: 10px;" />
								<col style="width: 10px;" />
								<col style="width: 20px;" />
								<col style="width: 60px;" />
								<col style="width: 10px;" />
								<col style="width: 20px;" />
								<col style="width: 20px;" />
								<col style="width: 20px;" />
								<col style="width: 20px;" />

								<tr>
									<th colspan="9">
										<div class="span12 text-center">
											<h3 class="text-center shadowhead">Opening Stock Sheet</h3>
											<p>From:-</strong><span class="fromDate">[0000/00/00]</span></span>
											To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
										</div>
									</th>
								</tr>
								<tr>
									<th>#</th>
									<th>Id</th>
									<th>Article#</th>
									<th>Item</th>
									<th>Uom</th>
									<th>Qty</th>
									<th>Weight</th>
									<th>Rate</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody class="stockRows">
							</tbody>
						</table>
					</div>
				</div>
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
	<script type="text/javascript" src="../../../assets/js/jquery.min.js"></script>
	<script src="../../../assets/js/handlebars.js"></script>

	<script type="text/javascript">
		$(function(){
			
			var opener = window.opener;
			
			var toDate = opener.$(\'#to\').val();
			var fromDate = opener.$(\'#from\').val();
			var stockRows = opener.$(\'#closingStockRows tr\').clone();

			$(\'.stockRows\').html(stockRows);
			$(\'.toDate\').html(toDate);
			$(\'.fromDate\').html(fromDate);
		});
	</script>
</body>
</html>';
?>