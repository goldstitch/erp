

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!doctype html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>';echo $title;;echo '</title>

	    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	    <link rel="stylesheet" href="../../assets/css/bootstrap-responsive.min.css">

	    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">

		<style>
			 * { margin: 0; padding: 0; font-family: tahoma; }
			 body { font-size:10px; font-family: tahoma !important;}
			 p { margin: 0; /* line-height: 17px; */ }
			 .field {font-weight: bold; display: inline-block; width: 120px; } 
			 .voucher-table{ border-collapse: collapse; }
			 table { width: 100%; border: 0.5px solid black; border-collapse:collapse; table-layout:fixed;margin-top: 8%;}
			 th { border: 0.5px solid black; padding: 5px; }
			 td { /*text-align: center;*/ vertical-align: top; /*padding: 5px 10px;*/ border-left: 0.5px solid black;}
			 td:first-child { text-align: left; }
			 .voucher-table thead th {background: #ccc; } 
			 tfoot {border-top: 0.5px solid black; } 
			 .bold-td { font-weight: bold; border-bottom: 0.5px solid black;}
			 .nettotal { font-weight: bold; font-size: 10px !important; border-top: 0.5px solid black; }
			 .invoice-type { border-bottom: 0.5px solid black; }
			 .relative { position: relative; }
			 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
			 .signature-fields th {border: 0px; border-top: 0.5px solid black; border-spacing: 10px; }
			 .inv-leftblock { width: 280px; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 12px; font-family: tahoma; line-height: 14px; padding: 4px; } 
			 .rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			 .inwords, .remBalInWords { text-transform: uppercase; }
			 .barcode { margin: auto; }
			 h3.invoice-type {font-size: 16px; line-height: 24px;}
			 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; margin: 5px 0px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;}
			 .nettotal { color: red; font-size: 10px;}
			 .remainingBalance { font-weight: bold; color: blue;}
			 .centered { margin: auto; }
			 p { position: relative; font-size: 12px; }
			 thead th { font-size: 13px; font-weight: normal; }
			 .fieldvalue.cust-name {position: absolute; width: 520px; } 
			 @media print {
			 	.noprint, .noprint * { display: none; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right; }
			.item-row td { font-size: 12px; padding: 10px;}

			
			h3.invoice-type { border: none !important; margin: 0px !important;  top: 0px; }
			tfoot tr td { font-size: 10px; padding: 5px; }
			.nettotal, .subtotal, .vrqty { font-size: 10px !important; font-weight: normal !important;}
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					</div>
						<img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>
					</div>
				</div>
				<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative;">';echo $title;;echo '</h3>
					

				
					
					
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr>

								<th style=" width: 10px; text-align:left;">ID</th>
								<th style=" width: 60px; text-align:left;">Design no</th>
								<th style=" width: 30px; text-align:left;">Design Type</th>
								<th style=" width: 30px; text-align:left;">Fabric Type</th>
								<th style=" width: 30px; text-align:left;">Fabric Unit</th>
								<th style=" width: 30px; text-align:left;">Fabric QTY</th>
								<th style=" width: 30px; text-align:left;">Fabric Cost</th>
								<th style=" width: 30px; text-align:left;">EMB Cost</th>
								<th style=" width: 30px; text-align:left;">Stitch Cost</th>
								<th style=" width: 30px; text-align:left;">Total Cost</th>

								</tr>
							</thead>

							<tbody>
								
								';
$serial = 1;
$Total_Amount = 0.00;
if (empty($pledger)) {
}
else{
foreach ($pledger as $row): 
$amount  = 0.00;

$amount= $row['id'];

$Total_Amount += $amount;
if ($amount!=0){
;echo '									
									<tr style="border-bottom:0.5px dotted #ccc;" class="item-row">
									   <td>';echo $row['id'];;echo'</td>
									   <td>';echo $row['design_no'];;echo '</td>
									   <td>';echo $row['type'];;echo'</td>
									   <td>';echo $row['fabric_type'];;echo'</td>
									   <td>';echo $row['fabric_unit'];;echo'</td>
									   <td>';echo $row['fabric_qty'];;echo '</td>
									   <td>';echo $row['fabric_cost'];;echo '</td>
									   <td>';echo $row['emb_cost'];;echo '</td>
									   <td>';echo $row['stitch_cost'];;echo '</td>
									   <td>';echo $row['total_cost'];;echo '</td>
									</tr>

								';}endforeach ;echo '								';
;echo '							
							
							<!-- 	<tr class="foot-comments">
									<td class="vrqty bold-td text-right">';
;echo '</td>
									<td class="bold-td text-right" colspan="3">Subtotal</td>
									<td class="bold-td"></td>
								</tr> -->

							</tbody>
							';};echo '						</table>
					</div>
					<div class="row-fluid">
						<div class="span12 add-on-detail" style="margin-top: 10px;">
							
						</div>
					</div>
					<!-- End row-fluid -->
					<br> 
					<br> 
					<div class="row-fluid">
						<div class="span12">
							<table class="signature-fields">
								<thead>
									<tr>
										<th>Approved By</th>
										<th>Accountant</th>
										<th>Received By</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="row-fluid">
						<p>
							
						
						
							<!-- <span class="website">Sofware By: www.alnaharsolution.com</span> -->
						</p>
					</div>

				</div>
			</div>
		</div>
		<script type="text/javascript" src="../../assets/js/app_modules/pdf_general.js"></script>
	</body>
	</html>	';
?>