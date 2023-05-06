
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
		<title>Voucher</title>

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
			 table { width: 100% !important; border: 0.5px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:0.5px}
			 th {  padding: 5px !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 tr{page-break-inside: avoid;}
			 td:first-child { text-align: left !important; }
			 .voucher-table thead th {background: #ccc !important; } 
			 tfoot {border-top: 0.5px solid black !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 11px !important; border-top: 0.5px solid black !important; }
			 .invoice-type { border-bottom: 0.5px solid black !important; }
			 .relative { position: relative !important; }
			 .signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			 .signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			 .inv-leftblock { width: 280px !important; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 12px !important; font-family: tahoma !important; line-height: 14px !important; padding: 4px !important; } 
			 .rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {font-size: 16px !important; line-height: 24px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 12px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto !important; }
			 p { position: relative !important; font-size: 12px !important; }
			 thead th { font-size: 12px !important; font-weight: bold !important; padding: 10px !important; }
			 .fieldvalue { font-size:12px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 10px !important; padding: 10px !important; border-top: 0.5px solid black !important;}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 0.5px solid black !important;}

			
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 12px !important; font-weight: bold !important;}
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					<div class="row-fluid">
						<div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>
						 <!-- <div class="span12"><h3 style="font-size: 16px !important; line-height: 24px !important;" > cf Gloves</h3></div> -->
					</div>
					<div class="row-fluid relative">
						<div class="span12">
								<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">
									<p><span class="field">Invoice#</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['vrnoa'];;echo '</span></p>									
									<p><span class="field">Date:</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</span></p>
									<p><span class="field ">WO#</span><span class="fieldvalue cust-name">';echo $vrdetail[0]['workorder'];;echo '</span></p>
									<p><span class="field">Remarks:</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['remarks'];;echo '</span></p>
									<!-- <p><span class="field">Receipt By</span><span class="fieldvalue rcptBy">[Receipt By]</span></p> -->
								</div>
								<div class="block pull-right" style="width:280px !important; float: right; display:inline !important;">
									
									<!-- <div class="span12"><img style="float:right; width:280px !important;" class="rcpt-header logo-img" src="';echo $header_img;;echo '" alt=""></div> -->
									<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative; top: 12px !important; ">';echo $title;;echo '</h3>
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
									<th style=" width: 10px; ">#</th>
									<th style=" width: 100px; text-align:left; ">Description</th>
									<th class="text-left" style=" width: 22px; ">Uom</th>
									<th class="text-left" style=" width: 60px; ">Location</th>
									<th class="text-left" style=" width: 60px; ">Work Detrail</th>
									<th class="text-left" style=" width: 60px; ">Received By</th>
									<th class="text-right" style=" width: 20px; ">Qty</th>
									<th class="text-right" style=" width: 40px; ">Weight</th>
									<th class="text-right" style=" width: 40px; ">Cost</th>
									<th class="text-right" style=" width: 40px; ">Amount</th>
									
								</tr>
							</thead>

							<tbody>
								
								';
$serial = 1;
$netQty = 0;
$netAmount=0;
$netCost = 0;
$netWeight=0;
foreach ($vrdetail as $row):
$netQty += abs($row['s_qty']);
$netWeight += abs($row['weight']);
$netCost += abs($row['s_rate']);
$netAmount += $row['s_amount'];
;echo '									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
									   <td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
									   <td class=\'text-left\'>';echo $row['uom'];;echo '</td>
									   <td class=\'text-left\'>';echo $row['dept_name'];;echo '</td>
									   <td class=\'text-left\'>';echo $row['workdetail'];;echo '</td>
									   <td class=\'text-left\'>';echo $row['received'];;echo '</td>
									   <td class=\'text-right\' style="text-align: right !important;">';echo ($row['s_qty']!=0?number_format(abs($row['s_qty']),0):'-');;echo '</td>
									   <td class=\'text-right\' style="text-align: right !important;">';echo ($row['weight']!=0?number_format(abs($row['weight']),2):'-');;echo '</td>
									   <td class=\'text-right\'>';echo ($row['s_rate']!=0?number_format(abs($row['s_rate']),2):'-');;echo '</td>
									   <td class=\'text-right\'>';echo ($row['s_amount']!=0?number_format(abs($row['s_amount']),2):'-');;echo '</td>
									   
									</tr>
									
								';endforeach;echo '							
							
								<tr class="foot-comments" style="border-top: 0.5px solid black !important;">
									<td class="subtotal bold-td text-right" style="text-align: right !important;" colspan="6">Total:</td>
									<td class="subtotal bold-td text-right">';echo ($netQty!=0?number_format($netQty,0):'-');;echo '</td>
									<td class="subtotal bold-td text-right">';echo ($netWeight!=0?number_format($netWeight,2):'-');;echo '</td>
									<td class="subtotal bold-td text-right"></td>
									<td class="subtotal bold-td text-right">';echo ($netAmount!=0?number_format($netAmount,2):'-');;echo '</td>
									
								</tbody>
							</tfoot>
						</table>
					</div>
					<div class="row-fluid">
						<div class="span12 add-on-detail1" style="margin-top: 10px;">
							<p class="" style="text-transform1: uppercase;">
								<!-- <strong>In words: </strong> <span class="inwords"></span>';echo strtoupper($amtInWords);;echo ' &nbsp; ONLY <br> -->
								<br>
								';if ( $pre_bal_print==1  ){;echo '									<p><span class="field1">Previous Balance:</span><span class="fieldvalue inv-vrnoa">';echo number_format($previousBalance,0);;echo '</span></p>
									<p><span class="field1">This Invoice:</span><span class="fieldvalue inv-date">';echo number_format($vrdetail[0]['namount'],0);;echo '</span></p>
									<p><span class="field1">Current Balance:</span><span class="fieldvalue cust-name">';echo number_format($vrdetail[0]['namount']+$previousBalance,2) ;;echo '</span></p>
								';};;echo '							</p>
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
							<span class="footer_company">User:';echo $user;;echo '</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<span class="footer_company">, Unit:';echo $this->session->userdata('company_name');;echo '</span>
							<!-- <span class="footer_company">Sofware By: www.alnaharsolution.com</span> -->
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>';
?>