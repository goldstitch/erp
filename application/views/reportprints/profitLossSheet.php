

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
	<title>Profit Loss Sheet</title>

	<!-- <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap-responsive.min.css">
	 -->
	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">

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
		 @page{margin:0px auto;}
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
		 td {font-size: 14px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase; padding-top: 10px; padding-bottom: 10px;} 
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
	<div class="container-fluid" style="margin-top:10px;">
		<div class="row-fluid">
			<div class="span12 centered">
				<!-- <div class="row-fluid"> -->
					<!-- <div class="span2"></div> -->
					<!-- <div class="span12"><img class="rcpt-header" src="../../assets/img/rcpt-header.png" alt=""></div> -->
					<!-- <div class="spn2"></div> -->
				<!-- </div> -->
				<div class="row-fluid">
					<div class="span12 centered">
						<div class="row-fluid">
							<div class="span12 text-center">
								<h3 class="text-center shadowhead">Profit Loss Sheet</h3>
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
							</div>
						</div>
						<br>
						<div class="row-fluid">
							<div class="span12">
								<table class="voucher-table">
									<tbody id="htmlRows">
										<tr>
											<td colspan="3"><strong>Sale</strong></td>
											<td class="sale text-right"></td>
										</tr>
										<tr>
											<td colspan="3"><strong>Cost of Goods Sold</strong></td>
											<td class="costOfGoodsSold text-right"></td>
										</tr>
										<tr>
											<td colspan="3"><strong>Gross Profit/loss</strong></td>
											<td class="grossPls text-right" style="border-top:1px solid black;"></td>
										</tr>
										<tr style="border-top:1px solid black;">
											<td colspan="3"><strong>Operating Expenses</strong></td>
											<td class="operatingExpenses text-right" style=""></td>
										</tr>
										<tr>
											<td colspan="3"><strong>Operating Profi/ Loss</strong></td>
											<td class="operatingPls text-right" style="border-top:1px solid black;"></td>
										</tr>
										<tr>
											<td colspan="3"><strong>Other Income</strong></td>
											<td class="otherIncome text-right" style=""></td>
										</tr>
										<tr>
											<td colspan="3"><strong>Finance Cost</strong></td>
											<td class="financeCost text-right" style=""></td>
										</tr>
										<tr>
											<td colspan="3"><strong>Worker Profit Participation Fund:</strong></td>
											<td class="wppf text-right" style=""></td>
										</tr>
										<tr style="">
											<td colspan="3"><strong>Profit Loss Before Taxation</strong></td>
											<td class="plsBeforeTax text-right" style="border-top:1px solid black;"></td>
										</tr>
										<tr style="">
											<td colspan="3"><strong>Provision for Taxation</strong></td>
											<td class="pft text-right" style="border-top:1px solid black;"></td>
										</tr>
										<tr style="border-top:1px solid black;">
											<td colspan="3" style="padding: 10px; font-size:15px;"><strong>Net Income Profit/Loss</strong></td>
											<td class="netPls text-right" style="padding: 15px 5px;font-size:15px; border-top:1px solid black;"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
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
									<th style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Approved By</th>
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

			$(\'.sale\').html( parseFloat(opener.profitLoss.sale).toFixed(4) );
			$(\'.costOfGoodsSold\').html( parseFloat(opener.profitLoss.costOfGoodsSold).toFixed(4) );
			$(\'.grossPls\').html( parseFloat(opener.profitLoss.grossPls).toFixed(4) );
			$(\'.operatingExpenses\').html( parseFloat(opener.profitLoss.operatingExpenses).toFixed(4) );
			$(\'.operatingPls\').html( parseFloat(opener.profitLoss.operatingPls).toFixed(4) );
			$(\'.otherIncome\').html( parseFloat(opener.profitLoss.otherIncome).toFixed(4) );
			$(\'.financeCost\').html( parseFloat(opener.profitLoss.financeCost).toFixed(4) );
			$(\'.wppf\').html( parseFloat(opener.profitLoss.wppf).toFixed(4) );
			$(\'.plsBeforeTax\').html( parseFloat(opener.profitLoss.plsBeforeTax).toFixed(4) );
			$(\'.pft\').html( parseFloat(opener.profitLoss.pft).toFixed(4) );
			$(\'.netPls\').html( parseFloat(opener.profitLoss.netPls).toFixed(4) );

			$(\'.fromDate\').html(fromDate);
			$(\'.toDate\').html(toDate);

			window.print();
		});
	</script>
</body>
</html>';
?>