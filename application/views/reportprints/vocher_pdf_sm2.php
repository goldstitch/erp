

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
			 * { margin: 0; padding: 0; font-family: tahoma !important; }
			 body { font-size:8px !important; }
			 p { margin: 0 !important; /* line-height: 10px !important; */ }
			 .field { font-size:12px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .field1 { font-size:12px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: none !important; }
			 table { width: 99.9% !important; border: none !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
			 th {  padding: 3px !important; border: 0.5px solid !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child { text-align: left !important; }
			 .voucher-table thead th {background: #ccc !important; } 
			 tfoot {border-top: 0px solid black !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 12px !important; border-top: 0px solid black !important; }
			 .invoice-type { border-bottom: 0.5px solid black !important; }
			 .relative { position: relative !important; }
			 .signature-fields{ font-size: 12px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			 .signature-fields th {border: 0px !important; border-top: 0px solid black !important; border-spacing: 10px !important; }
			 .inv-leftblock { width: 280px !important; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 12px !important; font-family: tahoma !important; line-height: 10px !important; padding: 2px !important; border: 0.5px solid !important;} 
			 
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {font-size: 16px !important; line-height: 10px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 3px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 12px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 /*.centered { margin: 0in 2.2in 6in 2.2in  !important; }*/
			 /*.centered { margin: 0px 80px 0px 80px  !important; }*/
			 .centered { margin: auto; }
			 p { position: relative !important; font-size: 12px !important; }
			 thead th { font-size: 12px !important; font-weight: bold !important; padding: 5px !important; }
			 .fieldvalue { font-size:12px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 12px !important; padding: 6px !important; border-top: 0px solid black !important;}
			.footer_company td { font-size: 12px !important; padding: 6px !important; border-top: 0px solid black !important;}
			.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			/*.rcpt-header { width: 550px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }*/
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 12px !important; padding: 6px !important;  }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 12px !important; font-weight: bold !important;}
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
									<p><span class="field">';echo $etype ;echo ' #</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['vrnoa'];;echo '</span></p>
									<p><span class="field">Date:</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</span></p>
									
									<p><span class="field">Due Date:</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($vrdetail[0]['bilty_date']));;echo '</span></p>

									<p><span class="field ">Customer:</span><span class="fieldvalue cust-name" style="font-size: 12px !important; font-weight:bolder !important;">';echo $vrdetail[0]['party_name'];;echo '</span></p>
									<p><span class="field">Vehicle#</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['prepared_by'];;echo '</span></p>
									<p><span class="field">Invoice#</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['bilty_no'];;echo '</span></p>
									';if($etype=='inward'||$etype=='outward'){;echo '										<p><span class="field">Po/Cont#</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['approved_by'] .'  -  '.$vrdetail[0]['inv_no'];;echo '</span></p>
									';};echo '									<p><span class="field">Type:</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['etype2'];;echo '</span></p>
									<p><span class="field">Remarks:</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['remarks'];;echo '</span></p>
									
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
						<table class="voucher-table">
							<thead>
								<tr>
									<th style=" width:8px; ">#</th>
									<th style=" width: 50px; text-align:left; ">Description</th>
									<th style=" width: 10px; ">Uom</th>
									<th style=" width: 20px; text-align:right;">Dozen</th>
									<th style=" width: 20px; text-align:right;">Bag</th>
									<th style=" width: 15px; ">Qty</th>
									<th style=" width: 18px; ">Weight</th>
									
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
$netQty += abs($row['qty']);
$netDozen += abs($row['dozen']);
$netBag += abs($row['bag']);
$netAmount += $row['s_amount'];
$netWeight += abs($row['weight']);
;echo '									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
									   <td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
									   <td class=\'text-centre\'>';echo $row['uom'];;echo '</td>
									   <td class=\'text-right\'>';echo ($row['dozen']!=0?number_format(abs($row['dozen']),2):'-');;echo '</td>
									   <td class=\'text-right\'>';echo ($row['bag']!=0?number_format(abs($row['bag']),2):'-');;echo '</td>
									   <td class=\'text-right\'>';echo ($row['qty']!=0?number_format(abs($row['qty']),0):'-');;echo '</td>
									   <td class=\'text-right\'>';echo ($row['weight']!=0?number_format(abs($row['weight']),2):'-');;echo '</td>
									
									</tr>
									
								';endforeach;echo '							</tbody>
							<tfoot>
								<tr class="foot-comments">
									<td class="text-left" colspan="2"><b>WO#</b>&nbsp;&nbsp;&nbsp;&nbsp;';echo $vrdetail[0]['workorder'];;echo '</td>
									
									<td class="subtotal bold-td text-right" colspan="1">Total:</td>
									<td class="subtotal bold-td text-right">';echo ($netDozen!=0?number_format($netDozen,2) :'-');;echo '</td>
									<td class="subtotal bold-td text-right">';echo ($netBag!=0?number_format($netBag,2):'-');;echo '</td>
									<td class="subtotal bold-td text-right">';echo ($netQty!=0?number_format($netQty,0):'-');;echo '</td>
									<td class="subtotal bold-td text-right">';echo ($netWeight!=0?number_format($netWeight,2):'-');;echo '</td>
									
								</tr>
								
							</tfoot>
						</table>
					</div>
					<div class="row-fluid">
						
					</div>
					<!-- End row-fluid -->
					<br>
					<br>
					<div class="row-fluid">
						<div class="span12">
							<table class="signature-fields">
								<thead>
									<tr>
										';if($etype == 'inward'){;echo '											<th style="border-top: 0.5px solid !important; border-bottom: none !important; ">Prepared By</th>
										';}else{;echo '											<th style="border-top: 0.5px solid !important; border-bottom: none !important; ">Approved By</th>
										';};echo '										<td style="border: none !important;"></td>
										<th style="border-top: 0.5px solid !important; border-bottom: none !important; ">Received By</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="row-fluid">
						<p>
							<span class="footer_company">User:';echo $user;;echo '</span>
							<!-- <span class="footer_company">, Unit:';echo $this->session->userdata('company_name');;echo '</span> -->
							<!-- <span class="footer_company">Software By: www.alnaharsolution.com</span> -->
						</p>
					</div>
				</div>
			</div>
		</div>
		
	</body>
	</html>';
?>