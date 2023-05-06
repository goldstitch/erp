

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
	<title>Account List</title>

	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">

	<style>

		* { margin: 0; padding: 0; font-family: tahoma; }
		body { font-size:14px; margin-top: -50px !important;
			margin-bottom: 0px !important;
			margin-left: 0px !important;
			margin-right: 0px !important; }

			table { width: 100%; border: none !important; border-collapse:collapse; border-collapse: collapse; }
			th { border: 1px solid black; padding: 5px; }
			td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ border-top: 1px solid black !important;}
			@media print {
				.noprint, .noprint * { display: none; }
			}
			.centered { margin: auto; }
			@page{margin-top: 5mm; margin-left: 5mm;margin-right: 5mm;margin-bottom: 10mm; size !important:  auto !important;  }

			.rcpt-header { margin: auto; display: block; }
			td:first-child { text-align: left; }

			.subsum_tr td, .netsum_tr td { border-top:1px solid black !important; border-bottom:1px solid black; }
			.level2head,.level1head,.level3head {border-top: 1px solid black;}
			.finalsum,.hightlight_tr td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(226, 226, 226); color: black;font-weight: bold !important; }
			.finalsum td {border-top: 1px solid black; border-left:0 !important; border-right: 0 !important; border-bottom: 1px solid black; background: rgb(250, 250, 250); color: black; }
			.field {font-weight: bold; display: inline-block; width: 80px; } 
			.voucher-table thead th {background: #ccc; padding:3px; text-align: center; font-size: 14px;} 
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
			td {font-size: 14px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase;    border-right: none solid;    border-bottom: 1px solid; border-left:  1px solid; border-right: 1px solid;} 
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
			@media print {
				a[href]:after {
					content: none !important;
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
							<table class="voucher-table">
								<thead class="htmlRows1" style="padding-top: 20px !important;">

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
					<table class="signature-fields">
						<thead>
							<tr>
								<th style="border-top: 1px solid black; border-left: 1px solid white; border-right: none solid white; border-bottom: 1px solid white;">Prepared By</th>
								<th style="border:1px solid white;"></th>
								<th style="border-top: 1px solid black; border-left: 1px solid white; border-right: none solid white; border-bottom: 1px solid white;">Received By</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			
			
			<div class="row-fluid">
				<p>
					<span class="footer_username"></span><br>
					<span class="footer_company">Sofware By: www.alnaharsolution.com,</span>
				</p>
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
			

			var etype =\'Account List\';


			
				var parentRows = opener.$("#chartOfAccountRows tr");
				var rowsHtml = \'\';

				var parentRows1 = \'\';
				var parentRows1 = opener.$(".dthead tr").clone();
				
				$(\'.htmlRows1\').append(parentRows1);
				$(".htmlRows1").find(\'.printRemove\').remove();
				
				var netBalance = 0;
				var parentCopy = opener.$(\'#chartOfAccountRows tr\').clone();
				parentCopy.find(\'.printRemove\').remove();

				

				$(\'#htmlRows\').append(parentCopy);
		
			

		

			
			$(\'.shadowhead\').html(etype);

			$(\'.footer_username\').html(user_name);

			
		});
</script>
</body>
</html>';
?>