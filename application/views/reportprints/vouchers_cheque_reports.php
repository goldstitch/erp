
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
	<title class="page_title">Accounts Reports</title>

	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">

	<style>

	* { margin: 0; padding: 0; font-family: tahoma; }
	body { font-size:12px; }
p { margin: 0; /* line-height: 17px; */ }
table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
th { border: 1px solid black; padding: 5px; }
td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-left: 1px solid black;border-bottom: 1px solid;}
@media print {
	.noprint, .noprint * { display: none; }
}
.centered { margin: auto; }

@page{margin-top: 5mm; margin-left: 5mm;margin-right: 5mm;margin-bottom: 5mm; size !important:  auto !important;  }
.rcpt-header { margin: auto; display: block; }
td:first-child { text-align: left; }

.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black; }

.hightlight_tr td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226) !important; color: black; }
.finalsum td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: grey !important; color: black; }
.field {font-weight: bold; display: inline-block; width: 80px; } 
.voucher-table thead th {background: #ccc !important; padding:3px; text-align: center; font-size: 12px;} 
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
.extra-detail span { background: #7F83E9 !important; color: white; padding: 5px; margin-top: 17px; display: block; } 
.nettotal { color: red; }
.remainingBalance { font-weight: bold; color: blue;}
.centered { margin: auto; }
p { position: relative; }
.fieldvalue.cust-name {position: absolute; width: 497px; } 
.shadowhead { border-bottom: 0px solid black; padding-bottom: 5px; } 
.AccName { border-bottom: 0px solid black; padding-bottom: 5px; font-size: 16px; } 

.txtbold { font-weight: bolder; } 
.uomStock{ width: 70px !important; }
.srStock{ width : 30px !important;}
.descriptionStock{ width : 200px !important;}
.qtyStock{ width : 70px !important;}
.headingBold{ font-weight: bold; font-size: 11px !important;  }

@media print {
				a[href]:after {
					content: none !important;
				}
			}
@media print {
			body {
				-webkit-print-color-adjust: exact;
			}
		}



</style>
</head>
<body>
	

	

	<div class="container-fluid" style="margin-top:10px;">
		
				<div class="row-fluid">
					<div class="span12 centered">

						<br>
						<div class="row-fluid">
							<div class="span12">
								<h3 class="text-center shadowhead txtbold">[Title]</h3>
								<h3 class="text-center AccName txtbold">.</h3>
								<p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
								<table class="voucher-table">
									<thead class="htmlRows1">
									
									</thead>
									<tbody id="htmlRows">
										
									</tbody>
								</table>
								
							</div>
							<div class="span12 htmlCharts">
								
							</div>
						</div>
					</div>
				</div>
				<br>
				
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
			var toDate = opener.$(\'#to_date\').val();			
			var etype = opener.$(\'.page_title\').text();

			if (opener.$(\'#datatable_inventory\').is(\':visible\')) {
				var parentRows = opener.$(".saleRows tr");
				var rowsHtml = \'\';

				var parentRows1 = \'\';
				var parentRows1 = opener.$(".dthead tr").clone();
				
				$(\'.htmlRows1\').append(parentRows1);
				$(".htmlRows1").find(\'.printRemove\').remove();
				
				
				// var parentCopy = opener.$(\'.saleRows tr\').clone();
				// parentCopy.find(\'.printRemove\').remove();

				

				// $(\'#htmlRows\').append(parentCopy);
			}
			var what =opener.$(\'.btnSelCre.btn-primary\').text().split(\'Wise\')[0].trim().toLowerCase();

			
			$(\'.fromDate\').html(fromDate);
			
			$(\'.toDate\').html(toDate); 
			
			$(\'.shadowhead\').html(etype);
			$(\'.page_title\').html(etype);

			window.print();
			
			
		});
	</script>
</body>
</html>';
?>