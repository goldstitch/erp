
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<!-- /** remove page url **\\ -->
<head>
	<title class="shadowhead">Report</title>

	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">

	<style>

		* { margin: 0; padding: 0; font-family: tahoma; }
		body { font-size:14px; }
	p { margin: 0; /* line-height: 17px; */ }
	table { width: 100%; border: none !important; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
	th { border: 1px solid black; padding: 5px; }
	td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: none !important;word-wrap:break-word;}
	tr{page-break-inside: avoid;}
	a:after { display:none; }
	.printRemove11 { display:none; }
	@media print {
		thead.htmlRows1{display: table-header-group !important; border-top: 0.5px solid black !important;border-left: 0.5px solid !important;border-right: 0.5px solid !important;}
		thead:nth-child(2){border-top: 0.5px solid black !important;}
		.noprint, .noprint * { display: none; }
	}

	@page{margin-top: 5mm ; margin-left: 5mm !important;margin-right: 5mm !important;margin-bottom: 10mm;  }


	thead:nth-child(2){border-top: 0.5px solid black !important;}

	.tfoot_tbl{color: red;background-color: white;font-weight: bold; text-align: right;}
	.centered { margin: auto; }
	.subsum_tr { background: #ece7e7f2 !important; }
	.subsum_tr td { background: #ece7e7f2 !important;  border: none; font-weight: bold !important;}


	.hightlight_tr td { border: none !important;  background: rgb(79, 156, 98) !important; color: white; font-weight: bold; }
	.finalsum td { background: #f3c791 !important;  border: none; font-weight: bold !important;}


	.rcpt-header { margin: auto; display: block; }
	

	.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black; }
	.finalsum, .level2head,.level1head,.level3head {border-top: 0.5px solid black;}
	.hightlight_tr td {border-top: 0.5px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black; }
	.finalsum td {border-top: 0.5px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(250, 250, 250); color: black; }
	.field {font-weight: bold; display: inline-block; width: 80px; } 
	.voucher-table thead th {background: #ccc; padding:3px; text-align: center; font-size: 12px;} 
	tfoot {border-top: 0.5px solid black; } 
	.bold-td { font-weight: bold; border-bottom: 1px solid black;}
	.nettotal { font-weight: bold; font-size: 14px; border-top: 0.5px solid black; }
	.invoice-type { border-bottom: 1px solid black; }
	.relative { position: relative; }
	.signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
	.signature-fields th {border: 0px; border-top: 0.5px solid black; border-spacing: 10px; }
	.inv-leftblock { width: 280px; }
	.text-left { text-align: left !important; }
	.text-right { text-align: right !important; }
	td {font-size: 12px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase;border-left: 0.5px solid !important;border-right: 0.5px solid !important;border-top: 0.5px solid !important;border-bottom: 0.5px solid !important; } 
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
	.shadowhead { border-bottom: 0px solid black; padding-bottom: 5px; text-transform: capitalize !important; } 
	.AccName { border-bottom: 0px solid black; padding-bottom: 5px; font-size: 16px; } 
	h2 {
		page-break-before: always;
	}

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
								<h3 class="text-center AccName txtbold printRemove11">.</h3>
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
								<p class="text-right"><strong><span class="Balance"></span></strong><strong><span class="BalanceTot">[]</strong></span></p>
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
									<th style="border-top: 0.5px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By</th>
									<th style="border:1px solid white;"></th>
									<th style="border-top: 0.5px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>
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
			function getMonthName (monthNum) {
				switch(monthNum) {
					case 1 :
					return \'Jan\';
					break;
					case 2 :
					return \'Feb\';
					break;
					case 3 :
					return \'Mar\';
					break;
					case 4 :
					return \'Apr\';
					break;
					case 5 :
					return \'May\';
					break;
					case 6 :
					return \'Jun\';
					break;
					case 7 :
					return \'Jul\';
					break;
					case 8 :
					return \'Aug\';
					break;
					case 9 :
					return \'Sep\';
					break;
					case 10 :
					return \'Oct\';
					break;
					case 11 :
					return \'Nov\';
					break;
					case 12 :
					return \'Dec\';
					break;
				}
			}

			$(function(){



				var opener = window.opener;

				var fromDate = opener.$(\'#from_date\').val();
				var company_name = opener.$(\'#company_name\').val();
				var toDate = opener.$(\'#to_date\').val();

				var dateParts = [];
				var separator = ( fromDate.indexOf(\'/\') === -1 ) ? \'-\' : \'/\';
				dateParts = fromDate.split(separator);
				var fromDate = dateParts[2] + \'-\' + getMonthName(parseInt(dateParts[1], 10)) + \'-\' + dateParts[0];

				var dateParts = [];
				var separator = ( toDate.indexOf(\'/\') === -1 ) ? \'-\' : \'/\';
				dateParts = toDate.split(separator);
				var toDate = dateParts[2] + \'-\' + getMonthName(parseInt(dateParts[1], 10)) + \'-\' + dateParts[0];



				var etype = opener.$(\'.page_title\').text();
				if (opener.$(\'#datatable_example\').is(\':visible\')) {
					var parentRows = opener.$(".saleRows tr");
					var rowsHtml = \'\';

				// var parentRows1 = \'\';
				var parentRows1 = opener.$(".dthead tr").html();
				// parentRows1.find(\'.printRemove\').remove();
				$(\'.htmlRows1\').append(parentRows1);
				$(".htmlRows1").find(\'.printRemove\').remove();

				
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
				$(\'.AccName\').removeClass(\'printRemove11\');
				$(\'.toDate\').html(toDate);
				$(\'.BalanceTot\').html( op + \', \' + db +\', \'+ cr +\', \'+ cls );
				$(\'.AccName\').html(\'Account: \'  + opener.$(\'#name_dropdown\').find(\'option:selected\').text() +\' - \'+ opener.$(\'#name_dropdown\').val());
			}else if (etype==\'Item Ledger Report\'){

				var op=\'Op Qty: \';
				var cls=\'Op Weight: \';
				var uom=opener.$(\'#item_dropdown\').find(\'option:selected\').data(\'uom\');
				// var db=\'Total Debit: \';
				// var cr=\'Total Credit: \';

				op = op + opener.$(\'#Opening_Qty\').val();
				cls = cls + opener.$(\'#Opening_Weight\').val();
				// db = db + opener.$(\'.net-debit\').text();
				// cr = cr + opener.$(\'.net-credit\').text();
				$(\'.AccName\').removeClass(\'printRemove11\');
				$(\'.toDate\').html(toDate + \',  \' +op + \', \'+ cls);
				// $(\'.BalanceTot\').html( op + \', \'+ cls );
				$(\'.AccName\').html(\' \'  + ((opener.$(\'#party_dropdown\').val())? \'Account:\' + opener.$(\'#party_dropdown\').find(\'option:selected\').text():\'\') +\' ,  \'+ ((opener.$(\'#item_dropdown\').val())?  \'Item: \' + opener.$(\'#item_dropdown\').find(\'option:selected\').text() + \'(Uom: \' + uom +\')\':\'\' ) +\' ,  \'+ ((opener.$(\'#unit_dropdown\').val())? \'Unit: \' + opener.$(\'#unit_dropdown\').val():\'\' ) );
			}else if (etype==\'Order Wise Profit Loss\'){

				var op =\'Total Expenses: \';
				var cls =\'Total Income: \';
				var profit =\'Total Profit: \';
				var other_income =\'Other Income: \';


				

				op = op + opener.$(\'#txtTotalExpenses\').val();
				cls = cls + opener.$(\'#txtTotalIncome\').val();
				profit = profit + opener.$(\'#txtTotalProfit\').val();

				other_income = other_income + opener.$(\'#txtTotalOtherIncome\').val();


				
				
				$(\'.BalanceTot\').html(op + \'<br> \'+ cls + \'<br> \'+ profit + \'<br> \'+ other_income);
				$(\'.Balance\').html( \'Order#\' + opener.$(\'#drpOrderNo\').val() + \'<br>\');


			}else{
				$(\'.toDate\').html(toDate + \', \' + what + \' wise.      (Unit: \' + company_name + \')\' );
			}
			var dept= opener.$(\'#drpdepartId\').find(\'option:selected\').text();
			var item= opener.$(\'#drpitemID\').find(\'option:selected\').text();

			
			var user= opener.$(\'#drpuserId\').find(\'option:selected\').text();
			var staf= opener.$(\'#drpStaffId\').find(\'option:selected\').text();

			var stftype= opener.$(\'#drpStaffType\').find(\'option:selected\').text();
			var brand= opener.$(\'#drpbrandID\').find(\'option:selected\').text();

			var category= opener.$(\'#drpCatogeoryid\').find(\'option:selected\').text();
			var subcat= opener.$(\'#drpSubCat\').find(\'option:selected\').text();

			var uom= opener.$(\'#drpUom\').find(\'option:selected\').text();

			var party= opener.$(\'#drpAccountID\').find(\'option:selected\').text();
			var city= opener.$(\'#drpCity\').find(\'option:selected\').text();
			var area= opener.$(\'#drpCityArea\').find(\'option:selected\').text();
			var l1= opener.$(\'#drpl1Id\').find(\'option:selected\').text();
			var l2= opener.$(\'#drpl2Id\').find(\'option:selected\').text();
			var l3= opener.$(\'#drpl3Id\').find(\'option:selected\').text();



			var desc="";
			if(party){
				desc += "(Party: " + party + ") , ";	
			}
			if(city){
				desc += "(City: " + city + ") , ";	
			}
			if(area){
				desc += "(Area: " + area + ") , ";	
			}
			if(l1){
				desc += "(l1: " + l1 + ") , ";	
			}
			if(l2){
				desc += "(l2: " + l2 + ") , ";	
			}

			if(l3){
				desc += "(l3: " + l3 + ") , ";	
			}

			

			if(dept){
				desc += "(Dept: " + dept + ") , ";	
			}
			
			if(item){
				desc += "(Item: " + item + ") , ";	
			}
			if(user){
				desc += "(User: " + user + ") , ";	
			}
			if(staf){
				desc += "(Staff: " + staf + ") , ";	
			}
			if(stftype){
				desc += "(SType: " + stftype + ") , ";	
			}

			if(category){
				desc += "(Category: " + category + ") , ";	
			}
			if(subcat){
				desc += "(SubCat: " + subcat + ") , ";	
			}
			if(brand){
				desc += "(Brand: " + brand + ") , ";	
			}
			if(uom){
				desc += "(Uom: " + uom + ") , ";	
			}
			
			if (etype !==\'Order Wise Profit Loss\'){
				// $(\'.BalanceTot\').html( desc );
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