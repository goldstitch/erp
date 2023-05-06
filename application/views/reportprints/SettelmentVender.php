
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
	    <link rel="stylesheet" href="';echo base_url('assets/css/bootstrap.min.css');;echo '">
	    <link rel="stylesheet" href="';echo base_url('assets/css/bootstrap-responsive.min.css');;echo '">
		<style>
			 * { margin: 0; padding: 0; font-family: tahoma !important; }
			 body { font-size:10px !important; }
			 p { margin: 0 !important; /* line-height: 17px !important; */ }
			 .field { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .fieldvalue { font-size:10px !important; display: inline-block !important; width: 500px !important; } 
			 .field1 { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: none !important; }
			 table { width: 100% !important; border: 2px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
			 table .foot_summary { width: 100% !important; border: none; margin-left:1px}
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
			 .text-center { text-align: center !important; }			 
			 td {font-size: 10px !important; font-family: tahoma !important; line-height: 14px !important; padding: 4px !important; } 
			 .rcpt-header { width: 550px !important; margin: auto !important; display: block !important; }
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {font-size: 16px !important; line-height: 24px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 10px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 10px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto !important; }
			 p { position: relative !important; font-size: 10px !important; }
			 thead th { font-size: 10px !important; font-weight: bold !important; padding: 10px !important; }

			 .fieldvalueold { font-size:10px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 10px !important; padding: 10px !important; border-top: 1px solid black !important;}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 1px solid black !important;}

			.rcpt-header { width: 305px !important; margin: 0px !important; display: inline !important; position: absolute !important; top: 0px !important; right: 0px !important; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 10px !important; font-weight: bold !important;}
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					<div class="row-fluid top-img-head">
						<div class="span12">
							<div class="span12"><img  class="logo-img" src="';echo $header_img;;echo '" width="800px;" alt="" ></div>
						</div>
					</div>
					<div class="row-fluid">
							<h3 class="invoice-type text-center">';echo $title;;echo '</h3>
					</div>

					<div class="row-fluid">
						<div class="span6">
							<p><span class="field">Vr#</span><span class="fieldvalue inv-vrnoa">';echo $main[0]['vrnoa'];;echo '</span></p>									
							<p><span class="field">Date:</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($main[0]['vrdate']));;echo '</span></p>
							<p ><span class="field ">Vendor:</span><span class="fieldvalue cust-name" style="font-size:14px !important;">';echo $main[0]['party_name'];;echo '</span></p>
							<p><span class="field ">WO#</span><span class="fieldvalue cust-name">';echo $main[0]['workorder'];;echo '</span></p>
							<p><span class="field ">Contract#</span><span class="fieldvalue cust-name">';echo $main[0]['inv_no'];;echo '</span></p>
						
							<p><span class="field">Remarks:</span><span class="fieldvalue cust-mobile">';echo $main[0]['remarks'];;echo '</span></p>
						</div>
					</div>
					<br>
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr>
									<th style=" width: 10px; ">Sr#</th>
									<th style=" width: 100px; text-align:left;">Description</th>
									<th style=" width: 50px; text-align:left;">Phase</th>
									<th style=" width: 20px; text-align:right;">Dozen</th>
									<th style=" width: 20px; text-align:right;">Bag</th>
									<th style=" width: 20px; text-align:right;">Qty</th>
									<th style=" width: 40px; text-align:right;">Weight</th>
									<th style=" width: 30px; text-align:right;">Rate</th>
									<th style=" width: 40px; text-align:right;">Amount</th>
								</tr>
							</thead>

							<tbody>
								
								';
$serial = 1;
$netQty = 0;
$netDozen = 0;
$netBag = 0;
$netAmount=0;
$netWeight=0;
foreach ($vrdetail as $row):
if($row['type']!=='less'){
$netQty += $row['qty'];
$netDozen += $row['dozen'];
$netBag += $row['bag'];
$netAmount += $row['s_amount'];
$netWeight += $row['weight'];
;echo '									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
									   <td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
									   <td class=\'text-centre\'>';echo $row['phase_name'];;echo '</td>
									   <td class=\'text-right\'>';echo number_format($row['dozen'],0);;echo '</td>
									   <td class=\'text-right\'>';echo number_format($row['bag'],0);;echo '</td>
									   <td class=\'text-right\'>';echo number_format($row['qty'],0);;echo '</td>
									   <td class=\'text-right\'>';echo number_format($row['weight'],0);;echo '</td>
									   <td class=\'text-right\'>';echo number_format($row['s_rate'],2);;echo '</td>
									   <td class="text-right">';echo number_format($row['s_amount'],0);;echo '</td> 
									</tr>
									
								';}endforeach;echo '							</tbody>
							<tfoot>
								<tr class="foot-comments">
									<td class="subtotal bold-td text-right" colspan="3">Subtotal:</td>
									<td class="subtotal bold-td text-right">';echo number_format($netDozen,0);;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format($netBag,0);;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format($netQty,0);;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format($netWeight,0);;echo '</td>
									<td class="subtotal bold-td text-right"></td>
									<td class="subtotal bold-td text-right">';echo number_format($netAmount,0);;echo '</td>
								</tr>
							</tfoot>
						</table>
						<br>
						<div class="row-fluid">
							<div class="span6">
								<table class="voucher-table">
									<thead>
										<tr>
											<th class="text-left">From</th>
											<th class="text-left">To</th>
											<th class="text-right">OpQty</th>
											<th class="text-right">In</th>
											<th class="text-right">Out</th>
											<th class="text-right">Balance</th>
											<th class="text-right">Amount</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left">';echo date('d-M-y',strtotime($main[0]['due_date']));;echo '</td>
											<td class="text-left">';echo date('d-M-y',strtotime($main[0]['bilty_date']));;echo '</td>
											<td class="text-right">';echo $main[0]['bilty_no'];;echo '</td>
											<td class="text-right">';echo $main[0]['order_no'];;echo '</td>
											<td class="text-right">';echo $main[0]['freight'];;echo '</td>
											<td class="text-right">';echo $main[0]['salebillno'];;echo '</td>
											<td class="text-right">';echo $main[0]['weight'];;echo '</td>
										</tr>
									</tbody>
									<thead style="border-top: 1px solid black !important;">
										<tr>
											<th class="text-left">Tanka%</th>
											<th class="text-left">Tanka Dozen</th>
											<th class="text-right">Tanka @</th>
											<th class="text-right">Tanka Amount</th>
											<th class="text-right">Tax%</th>
											<th class="text-right">Tax Amount</th>
											<th class="text-right">Paid</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="text-left">';echo $main[0]['discp'];;echo '</td>
											<td class="text-left">';echo $main[0]['discount'];;echo '</td>
											<td class="text-right">';echo $main[0]['exppercent'];;echo '</td>
											<td class="text-right">';echo $main[0]['expense'];;echo '</td>
											<td class="text-right">';echo $main[0]['taxpercent'];;echo '</td>
											<td class="text-right">';echo $main[0]['tax'];;echo '</td>
											<td class="text-right">';echo $main[0]['paid'];;echo '</td>
										</tr>
										<tr>
											<td class="pull-right" colspan="5"></td>
											<td class="pull-right" colspan="1" style="font-size:12px !importan;font-weight:bolder !important;">Net Amount</td>											
											<td class="text-right" colspan="1" style="font-size:12px !importan;font-weight:bolder !important;">';echo  $main[0]['namount'];;echo '</td>
										</tr>
									</tbody>

								</table>
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