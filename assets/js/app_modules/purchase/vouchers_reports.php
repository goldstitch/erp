

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
	<title class="shadowhead">Daybook Report</title>

	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">

	<style>

		 * { margin: 0; padding: 0; font-family: tahoma; }
		 body { font-size:12px; }
		 p { margin: 0; /* line-height: 17px; */ }
		table { width: 100%; border: none !important; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
		th { border: 1px solid black; padding: 5px; }
		td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: none !important;}
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
	
	 
	

	<div class="container-fluid" style="margin-top:10px;">
		<!-- <div class="row-fluid">
			<div class="span12 centered"> -->
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
								<h3 class="text-center shadowhead txtbold">[Title]</h3>
								<!-- <h3 class="text-center AccName txtbold">.</h3> -->
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
								<table class="voucher-table">
									<thead class="htmlRows1">
										<!-- <col style="width:50px" />
										<col style="width:65px" />
										<col style="width:80px" />
										<col />
										<col style="width:100px;" />
										<col style="width:50px;" />
										<col style="width:65px;" />
										<col style="width:100px;" />
										
										<tr>
											<th style="width:50px;">Sr# </th>
									        <th style="width:65px;">Date </th>
									        <th style="width:80px;">Vr# </th>
									        <th >Account </th>
									        <th style="width:100px;">Item </th>
									        <th style="width:50px;">Qty </th>
									        <th style="width:65px;">Rate </th>
									        <th style="width:100px;">Amount </th>
										</tr> -->
									</thead>
									<tbody id="htmlRows">
										
									</tbody>
								</table>
								<p class="text-center"><span class="Balance"><strong></strong><span class="BalanceTot">[]</span></p>
							</div>
							<div class="span12 htmlCharts">
								
							</div>
						</div>
					</div>
				</div>
				<br>
				<!-- <p><strong>Note:</strong>  Here please find our acount statement and check it, if any discrepancy please let it be known within a week. Otherwise it would be assumed that our statement is correct. Thanks!</p> -->
				<br>
				<br>
				<br>
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
		<!-- </div>
	</div> -->
	<script type="text/javascript" src="../../../assets/js/jquery.min.js"></script>
	<script src="../../../assets/js/handlebars.js"></script>

	<script type="text/javascript">
		$(function(){
			
			
			var opener = window.opener;
			
			var fromDate = opener.$(\'#from_date\').val();
			var company_name = opener.$(\'#company_name\').val();
			var toDate = opener.$(\'#to_date\').val();

			var etype = opener.$(\'.page_title\').text();
			if (opener.$(\'#datatable_example\').is(\':visible\')) {
				var parentRows = opener.$(".saleRows tr");
				var rowsHtml = \'\';

				var parentRows1 = \'\';
				var parentRows1 = opener.$(".dthead tr").html();
				// parentRows1.find(\'.printRemove\').remove();
				$(\'.htmlRows1\').append(parentRows1);

				
				var netBalance = 0;
				var parentCopy = opener.$(\'.saleRows tr\').clone();
				parentCopy.find(\'.printRemove\').remove();
				

				$(\'#htmlRows\').append(parentCopy);
		    }
		    var what =opener.$(\'.btnSelCre.btn-primary\').text().split(\'Wise\')[0].trim().toLowerCase();

			// Charts 
			if(opener.$(\'.tab-content\').is(\':visible\')){
				var charts = opener.$(\'.tab-content\').clone();

				// alert(charts);
				// console.log(charts);
				$(\'.htmlCharts\').append(charts);

			}
			// End Charts
			$(\'.fromDate\').html(fromDate);
			if (etype==\'Account Ledger\'){
				var op=\'Op Balance: \';
				var cls=\'Cl Balnce: \';
				var db=\'Total Debit: \';
				var cr=\'Total Credit: \';

				op = op + opener.$(\'.opening-bal\').text();
				cls = cls + opener.$(\'.running-total\').text();
				db = db + opener.$(\'.net-debit\').text();
				cr = cr + opener.$(\'.net-credit\').text();

				$(\'.toDate\').html(toDate);
				$(\'.BalanceTot\').html( op + \', \' + db +\', \'+ cr +\', \'+ cls );
				$(\'.AccName\').html(\'Account: \'  + opener.$(\'#name_dropdown\').find(\'option:selected\').text() +\' - \'+ opener.$(\'#name_dropdown\').val());
			}else{
				$(\'.toDate\').html(toDate + \', \' + what + \' wise.      (Unit: \' + company_name + \')\' );
				}
			
			// alert(parentCopy);
			$(\'.shadowhead\').html(etype);
			// $(\'.shadowhead1\').html(etype);
			// $(\'.netBalance\').html(netBal);
			
		});
	</script>
</body>
</html>';
?>