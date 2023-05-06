

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
	    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	    <link rel="stylesheet" href="../../assets/css/bootstrap-responsive.min.css">
	    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">

		<style>
			 * { margin: 0; padding: 0; font-family: tahoma !important; }
			 body { font-size:10px !important; }
			 p { margin: 0 !important; /* line-height: 17px !important; */ }
			 .field { font-size:12px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .field1 { font-size:12px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: none !important; }
			 table { width: 100% !important; border: 2px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
			 th {  padding: 5px !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child { text-align: left !important; }
			 .voucher-table thead th {background: #ccc !important; } 
			 tfoot {border-top: 1px solid black !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 11px !important; border-top: 1px solid black !important; }
			 .invoice-type { border-bottom: 1px solid black !important; }
			 .relative { position: relative !important; }
			 .signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			 .signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			 .inv-leftblock { width: 280px !important; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 12px !important; font-family: tahoma !important; line-height: 14px !important; padding: 4px !important; } 
			 .rcpt-header { width: 550px !important; margin: auto !important; display: block !important; }
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {font-size: 16px !important; line-height: 24px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 12px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto !important; }
			 p { position: relative !important; font-size: 12px !important; }
			 thead th { font-size: 12px !important; font-weight: bold !important; padding: 10px !important; border: 1px solid !important; }
			 .fieldvalue { font-size:12px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 12px !important; padding: 10px !important; border-top: 1px solid black !important; border: 1px solid !important;}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 1px solid black !important;}

			.rcpt-header { width: 305px !important; margin: 0px !important; display: inline !important; position: absolute !important; top: 0px !important; right: 0px !important; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 12px !important; font-weight: bold !important;}
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					<!-- <div class="row-fluid top-img-head" style="display:none; padding-top: 15px; padding-bottom: 15px;">
						<div class="span12">
							<img src="#" class="top-head" alt="">
						</div>
					</div> -->
					<div class="row-fluid relative">
						<div class="span12">
								<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">								
									
								</div>
								<div class="block pull-center" style="width:280px !important; float: center; display:inline !important;">
									<h3 class="invoice-type text-center" style="border:none !important; margin: 0px !important; position: center; top: 18px !important; ">Stock Adjustment Report </h3>
								</div>
						</div>
					</div>
					<br>
					<br>
					<br>
					
					<div class="row-fluid">
					<table class="voucher-table">
					<thead>
						<tr>

							<th style=" width: 10px; text-align:left;">Sr#</th>
									<th style=" width: 12px; text-align:left; ">Date</th>
									<th style=" width: 20px; text-align:left;">Location</th>
									<th style=" width: 50px; text-align:left; ">Item_Name</th>
									<th style=" width: 20px; text-align:left;">Quantity</th>
									<th style=" width: 20px; text-align:left;">Rate </th>
									<th style=" width: 20px; text-align:left;">Amount</th>
									<th style=" width: 20px; text-align:left;">Type</th>
						</tr>
					</thead>
					<tbody>
						';if (count($item) >0): ;echo '			';$counter = 1 ;$Qty=0;foreach ($item as $items): $Qty += ROUND($items['qty']);  ;echo '	
						
								<tr class="item-row">
									<td>';echo $counter++;;echo '</td>
									<td>';echo $items['vrdate'];;echo'</td>
									<td>';echo $items['name'];;echo '</td>
									<td >';echo $items['item_des'];;echo '</td>
									<td>';echo $items['qty'];;echo'</td>
									<td >';echo $items['rate'];;echo'</td>
									<td >';echo $items['trate'];;echo'</td>
									<td>';echo $items['atype'];;echo'</td>
								</tr>
							';endforeach ;echo '												';endif ;echo '											</tbody>
							<tfoot>
							<tr class="foot-comments">
								<td class="subtotal bold-td text-right" colspan="3">Subtotal:</td>
								<td class="subtotal bold-td text-right"></td>
								<td class="subtotal bold-td text-left">';echo number_format($Qty,0);;echo '</td>
								<td class="subtotal bold-td text-right"></td>
								<td class="subtotal bold-td text-right"></td>
								<td class="subtotal bold-td text-right"></td>
								
								
							</tr>
						</tfoot>

				</table>      
					</div>
					
					<!-- End row-fluid -->
					<br>
					<br>
				
					
				</div>
			</div>
		</div>
	</body>
	</html>';
?>