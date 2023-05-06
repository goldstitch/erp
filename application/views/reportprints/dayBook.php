

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
		 body { font-size:12px; color: black !important;}
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
		 
	@page{margin-top: 5mm ; margin-left: 3mm !important;margin-right: 3mm !important;margin-bottom: 10mm;  }

		 .rcpt-header { width: 900px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
		 
		 td:first-child { text-align: left; }
	
		.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black; }
		.finalsum, .level2head,.level1head,.level3head {border-top: 1px solid black;}
		.hightlight_tr td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black; }
		.finalsum td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(250, 250, 250); color: black; }
		 .field {font-weight: bold; display: inline-block; width: 80px; } 
		 .voucher-table thead th {background: #ccc; padding:3px; text-align: center; font-size: 12px; color: black !important;} 
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
		 td {font-size: 10px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase;border: 0.5px solid !important; color: black !important;} 
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
				<div class="row">
					<div class="col-lg-12">
						<img class="rcpt-header" src="../../../assets/img/pic1.png" alt="">
					</div>
				</div>

				<div class="row-fluid">
					<div class="span12 centered">

						<br>
						<div class="row-fluid">
							<div class="span12">
								<table class="voucher-table">
									<thead>
										<col style="width:30px" />
										<col style="width:60px" />
										
										<col />
										<col />
										<col style="width:60px" />
										<col style="width:60px" />


										<col style="width:50px" />
										<col style="width:40px;" />
										<col style="width:70px;" />
										<col style="width:70px;" />

										<tr>
											<th colspan="10">
												<h3 class="text-center shadowhead">[Payable/Receivable]</h3>
												<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
											</th>
										</tr>
										<tr>
											<th style="width:40px;">#</th>
											<th style="width:55px;">Date</th>
											

											<th>Account</th>
											<th>Remarks</th>
											<th style="width: 125px;">Vr#</th>										

											<th style="width: 125px;">Inv#</th>
											<th style="width: 125px;">Contra Acc</th>
											<th style="width:50px;">WO#</th>

											<th style="width:100px;">Debit</th>
											<th style="width:100px;">Credit</th>
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
				<br>
				<div class="row-fluid">
					<div class="span12">
						<table class="">
							<thead>
								<tr>
									<th class=\'text-right\' >Purchase</th>
									<th class=\'text-right\' >Sale</th>
									<th class=\'text-right\' >Purchase Return</th>
									<th class=\'text-right\' >Sale Return</th>
									<th class=\'text-right\' >Cash Sale</th>
									<th class=\'text-right\' >Sale Discount</th>
								</tr>
								<tr>
									<td class=\'text-right tblPurchase\'></td>
									<td class=\'text-right tblSale\'></td>
									<td class=\'text-right tblPurchaseReturn\'></td>
									<td class=\'text-right tblSaleReturn\'></td>
									<td class=\'text-right tblCashSale\'></td>
									<td class=\'text-right tblSaleDiscount\'></td>
								</tr>
								<tr>
									<th class=\'text-right\' >Opening Cash</th>
									<th class=\'text-right\' >Closing Cash</th>
									<th class=\'text-right\' >Payments</th>
									<th class=\'text-right\' >Receipts</th>

								</tr>
								<tr>
									<td class=\'text-right tblOpeningCash\'></td>
									<td class=\'text-right tblClosingCash\'></td>
									<td class=\'text-right tblPayments\'></td>
									<td class=\'text-right tblReceipts\'></td>
									

								</tr>
							</thead>
							
								
								
							
						</table>
					</div>
				</div>

				<br>
				<br>
				<legend>Cash and Bank Detail</legend>
				<div class="row-fluid">
					<div class="span12">
						<table class="">
							<thead>
								<tr>
									<th style="width:40px;">#</th>
									<th style="">Account</th>
									<th class="text-right" style="width: 125px;">Opening</th>
									<th class="text-right" style="width: 125px;">Debit</th>
									<th class="text-right" style="width:125px;">Credit</th>
									<th class="text-right" style="width:125px;">Balance</th>
								</tr>
							</thead>
							<tbody id="htmlRows2">

							</tbody>
							<tfoot id="htmlRows3">

							</tfoot>
							
						</table>
					</div>
				</div>


				
				<br>
				<div class="row-fluid">
					<div class="span12">
						<table class="signature-fields">
							<thead>
								<tr>
									<th style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By1</th>
									<th style="border:1px solid white;"></th>
									<th style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<br>
				<div class="row-fluid">
					<p>
						<span class="loggedin_name"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<span class="company_name"></span>
						
					</p>
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
			

			

			var sale = opener.$(\'.sales-sum\').html();
			var salereturn = opener.$(\'.salereturns-sum\').html();

			var discount = opener.$(\'.discount-sales-sum\').html();
			var cashsale = opener.$(\'.cash-sales-sum\').html();
			var purchasereturn = opener.$(\'.purchasereturns-sum\').html();
			var purchase = opener.$(\'.purchases-sum\').html();
			var cashclosing = opener.$(\'.closing-bal\').html();
			var cashopening = opener.$(\'.opening-bal\').html();
			var payments = opener.$(\'.payments-sum\').html();
			var receipts = opener.$(\'.receipts-sum\').html();


			$(\'.tblSale\').text(sale);

			$(\'.tblSaleReturn\').text(salereturn);
			$(\'.tblPurchase\').text(purchase);
			$(\'.tblPurchaseReturn\').text(purchasereturn);
			$(\'.tblCashSale\').text(cashsale);
			$(\'.tblSaleDiscount\').text(discount);
			$(\'.tblClosingCash\').text(cashclosing);
			$(\'.tblOpeningCash\').text(cashopening);
			$(\'.tblPayments\').text(payments);
			$(\'.tblReceipts\').text(receipts);
			

			var netBal = opener.$(\'.netamt_td\').text().trim();

			var parentRows = opener.$(\'.parentTableRows tr\');

			var rowsHtml = \'\';

			var netBalance = 0;

			var parentCopy = opener.$(\'.parentTableRows tr\').clone();

			parentCopy.find(\'.printRemove\').remove();

				
			$(\'#htmlRows\').append(parentCopy);


			var parentCopy2 = opener.$(\'.cb_tbody tr\').clone();
			$(\'#htmlRows2\').append(parentCopy2);

			var parentCopy3 = opener.$(\'.cb_tfoot tr\').clone();
			$(\'#htmlRows3\').append(parentCopy3);
			
			$(\'.fromDate\').html(fromDate);
			$(\'.toDate\').html(toDate);
		
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
		$(\'.loggedin_name\').html(\'User: \' + opener.$(\'#uname\').val().trim());
	    $(\'.company_name\').html(\'Unit: \' + opener.$(\'#company_name\').val().trim());
	    window.print();
	</script>
</body>
</html>';
?>