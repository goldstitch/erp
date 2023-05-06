

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
					<div class="row-fluid">
						<div class="span12">
						<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">
					
					</div>
						<img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>
						<h2>';echo $title;;echo '</h2><br>
					</div>
					<div class="row-fluid relative">
						<div class="span12">
						
						
						<div class="block pull-left inv-leftblock" style="width:200px !important; display:inline !important;">
						  
							<span class="field">ID</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['id'];;echo '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<br><br>
							<span class="field">Design.no & Type</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['design_no'];;echo ' - ';echo $pledger[0]['type'];;echo '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp<br><br>
							<span class="field">Fabric Qty Per_Unit</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['fabric_type'];;echo '- ';echo $pledger[0]['fabric_qty'];;echo ' ';echo $pledger[0]['fabric_unit'];;echo '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp&nbsp<br><br>
							<span class="field">Sample Date</span><span class="fieldvalue inv-date">';echo date( 'd-M-Y ',strtotime( $pledger[0]['start_date']));;echo '</span><br><br>
							<span class="field">Fabric Cost Per Pcs</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['fabric_cost'];;echo '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp&nbsp<br><br>
							<span class="field">EMB Cost Per Pcs</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['emb_cost'];;echo '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp&nbsp<br><br>
							<span class="field">Stitch Cost Per Pcs</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['stitch_cost'];;echo '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp&nbsp<br><br>
							<span class="field">Total Cost Per Pcs</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['stitch_cost']+$pledger[0]['emb_cost']+$pledger[0]['fabric_cost'];;echo '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp&nbsp
							
						</div>

						


						</div>
					</div>
					<br>
					
					
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr>

								<th style=" width: 10px; text-align:left;">ID</th>
								<th style=" width: 60px; text-align:left;">Consumption</th>
								<th style=" width: 30px; text-align:left;">Description</th>
								<th style=" width: 30px; text-align:left;">Part</th>
								<th style=" width: 30px; text-align:left;">QTY</th>
								<th style=" width: 30px; text-align:left;">Rate</th>
								<th style=" width: 30px; text-align:left;">Amount</th>
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
								
								$amount= $row['amount'];
								
								$Total_Amount += $amount;
								if ($amount!=0){
								;echo '									
									<tr style="border-bottom:0.5px dotted #ccc;" class="item-row">
									   <td>';echo $row['id'];;echo'</td>
									   <td>';echo $row['consumption'];;echo '</td>
									   <td>';echo $row['description'];;echo'</td>
									   <td>';echo $row['part'];;echo'</td>
									   <td>';echo $row['qty'];;echo'</td>
									   <td>';echo $row['rate'];;echo '</td>
									   <td>';echo $row['amount'];;echo '</td>
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