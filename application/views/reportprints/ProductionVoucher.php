

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
			 .header-table{ border-collapse: none !important;}
			 .header-table thead th {background: white !important;border: none;font-size: 13px !important;  } 
			 .font-normal{font-weight: 100;}
			 table { width: 100% !important; border: 1px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
			 th {  padding: 5px !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child {  }
			 tr {page-break-inside: avoid;}
			 .voucher-table thead th {background: grey !important; } 
			 tfoot {border-top: 0px solid black !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 11px !important; border-top: 0px solid black !important; }
			 .invoice-type { border-bottom: 0px solid black !important; }
			 .relative { position: relative !important; }
			 .inv-leftblock { width: 280px !important; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 10px !important; font-family: tahoma !important; line-height: 14px !important; padding: 4px !important; } 
			 
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {font-size: 18px !important; line-height: 24px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 10px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 10px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto !important; }
			 p { position: relative !important; font-size: 10px !important; }
			 thead th { font-size: 10px !important; font-weight: bold !important; padding: 10px !important; }
			 .fieldvalue { font-size:12px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 10px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.footer_company td { font-size: 16px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			.signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.subtotalend { font-size: 10px !important; font-weight: bold !important;text-align: right !important; }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 10px !important; font-weight: bold !important;text-align: right !important; color: red;}
			.suplier-buyer{width: 100%;display: inline-block;border: 1px solid black;}
			.supplier{width: 50%;float: left !important;}
			.buyer{width: 50%;float: right !important; }
			.supplier-table{width: 100%;border: 1px solid black;}
			.buyer-table{width: 100%;border: 1px solid black;}
			/*.buyer-table,td {border: 1px solid black;}*/
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					<div class="row-fluid">
						<div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>
					</div>
					<div class="row-fluid relative">
						<div class="span12">
								<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">
									<p><span class="field">Invoice#</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['vrnoa'];;echo '</span></p>									
									<p><span class="field">Date:</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</span></p>
									<!-- <p><span class="field ">Customer:</span><span class="fieldvalue cust-name">';echo $vrdetail[0]['party_name'];;echo '</span></p> -->
									<p><span class="field">Remarks:</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['remarks'];;echo '</span></p>
									<!-- <p><span class="field">Receipt By</span><span class="fieldvalue rcptBy">[Receipt By]</span></p> -->
								</div>
								<div class="block pull-right" style="width:280px !important; float: right; display:inline !important;">
									<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative; top: 12px !important; ">';echo $title;;echo '</h3>
								</div>
						</div>
					</div>
					<br>
					<br>
					<br>
					
					<div class="row-fluid">
						<h3>Consume</h3>
						<table class="voucher-table">
							<thead>
								<tr>
									<th style=" width: 20px;text-align:left; ">Sr#</th>
									<th style=" width: 100px; text-align:left; ">Description</th>
									<th style=" width: 20px; text-align:left; ">Uom</th>
									<th style=" width: 50px; text-align:left;">Phase</th>
									<th style=" width: 30px; text-align:right;">Qty</th>
									<th style=" width: 30px; text-align:right;">Dozen</th>
									<th style=" width: 30px; text-align:right;">Weight</th>
								</tr>
							</thead>

							<tbody>
								
								';
$serial = 1;
$netQty = 0;
$netAmount=0;
$netWeight=0;
$netDozen=0;
foreach ($vrdetail as $row){
if($row['type']=='consume'){
$netQty += abs($row['s_qty']);
$netDozen += abs($row['dozen']);
$netWeight += abs($row['weight']);
;echo '									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
									   <td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
									   <td class=\'text-left\'>';echo $row['uom'];;echo '</td>
									   <td class=\'text-centre\'>';echo $row['phase_name'];;echo '</td>
									   <td class=\'text-right\'>';echo ($row['s_qty']!=0?number_format(abs($row['s_qty']),0):'-');;echo '</td>
									   <td class=\'text-right\'>';echo ($row['dozen']!=0?number_format(abs($row['dozen']),0):'-');;echo '</td>
									   <td class=\'text-right\' style="border-right: 1px solid !important;">';echo ($row['weight']!=0?number_format(abs($row['weight']),2):'-');;echo '</td>
									</tr>
									
								';}
};echo '							
							
								<tr class="foot-comments" style="border-top:0.5px solid black !important;">
									<td class="subtotal bold-td text-right" style="text-align:right !important;" colspan="4">Total:</td>
									<td class="subtotal bold-td text-right">';echo ($netQty!=0?number_format($netQty,0):'-');;echo '</td>
									<td class="subtotal bold-td text-right">';echo ($netDozen!=0?number_format($netDozen,0):'-');;echo '</td>
									<td class="subtotal bold-td text-right">';echo ($netWeight!=0?number_format($netWeight,2):'-');;echo '</td>
								</tr>
							</tbody>
						</table>
					</div>
					<br><br>

					<div class="row-fluid">
						<h3>Produce</h3>
						<table class="voucher-table">
							<thead>
								<tr>
									<th style="width:20px; text-align:left;">Sr#</th>
									<th style="width:150px; text-align:left; ">Description</th>
									<th style="width:50px; text-align:left;">Phase</th>
									<th style="width:70px;  text-align:right;">Qty</th>
									<th style="width:50px;  text-align:right;">Dozen</th>
									<th style="width:60px;  text-align:right;">Weight</th>
									
									<th style="width:60px; text-align:left;">Employee</th>
									<th style="width:40px;  text-align:right;">Rate</th>
									<th style="width:50px;  text-align:right;">Amount</th>
								</tr>
							</thead>

							<tbody >
								
								';
$serial = 1;
$netQty = 0;
$netDozen = 0;
$netPAmount=0;
$netLAmount=0;
$netWeight=0;
foreach ($vrdetail as $row){
if($row['type']=='produce'){
$netQty += abs($row['s_qty']);
$netDozen += abs($row['dozen']);
$netWeight += abs($row['weight']);
$netPAmount += $row['s_amount'];
$netLAmount += $row['lamount'];
;echo '									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
									   <td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
									   <td class=\'text-centre\'>';echo $row['phase_name'];;echo '</td>
									   <td class=\'text-right\'>';echo ($row['s_qty']!=0?number_format(abs($row['s_qty']),0):'-');;echo '</td>
									   <td class=\'text-right\'>';echo ($row['dozen']!=0?number_format(abs($row['dozen']),0):'-');;echo '</td>
									   <td class=\'text-right\'>';echo ($row['weight']!=0?number_format(abs($row['weight']),2):'-');;echo '</td>									   
									   <td class=\'text-left\'>';echo $row['empname'];;echo '</td>
									   <td class=\'text-right\'>';echo ($row['lrate']!=0?number_format(abs($row['lrate']),2):'-');;echo '</td>
									   <td class=\'text-right\'>';echo ($row['lamount']!=0?number_format(abs($row['lamount']),2):'-');;echo '</td>
									</tr>
								';}
};echo '							
							
								<tr class="foot-comments" style="border-top:0.5px solid black !important;">
									<td class="subtotal bold-td text-right" colspan="3" style="text-align:right !important;">Total:</td>
									<td class="subtotal bold-td text-right">';echo ($netQty!=0?number_format($netQty,0):'-');;echo '</td>
									<td class="subtotal bold-td text-right">';echo ($netDozen!=0?number_format($netDozen,0):'-');;echo '</td>
									<td class="subtotal bold-td text-right">';echo ($netWeight!=0?number_format($netWeight,2):'-');;echo '</td>
									
									<td class="subtotal bold-td text-right"></td>
									<td class="subtotal bold-td text-right"></td>
									<td class="subtotal bold-td text-right">';echo ($netLAmount!=0?number_format($netLAmount,2):'-');;echo '</td>
									
								</tr>
							</tbody>
						</table>
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