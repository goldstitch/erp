

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
			 .field { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .field1 { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: none !important; }
			 table { width: 100% !important; border: none !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
			 th {  padding: 3px !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child { text-align: left !important; }
			 .voucher-table thead th {background: #ccc !important; } 
			 tfoot {border-top: 0px solid black !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 11px !important; border-top: 0px solid black !important; }
			 .invoice-type { border-bottom: 1px solid black !important; }
			 .relative { position: relative !important; }
			 .signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			 .signature-fields th {border: 0px !important; border-top: 0px solid black !important; border-spacing: 10px !important; }
			 .inv-leftblock { width: 280px !important; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 10px !important; font-family: tahoma !important; line-height: 14px !important; padding: 2px !important; } 
			 
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {font-size: 12px !important; line-height: 10px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 3px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 9px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 9px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 /*.centered { margin: 0in 2.2in 6in 2.2in  !important; }*/
			 .centered { margin: 0px 80px 0px 80px  !important; }
			 p { position: relative !important; font-size: 9px !important; }
			 thead th { font-size: 9px !important; font-weight: bold !important; padding: 10px !important; }
			 .fieldvalue { font-size:10px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 9px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 0px solid black !important;}

			.rcpt-header { width: 550px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 9px !important; font-weight: bold !important;}
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<!-- <div class="span3 centered">
				</div> -->
				<div class="span6 centered">
					<div class="row-fluid">
						<div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>
						 <!-- <div class="span12"><h3 style="font-size: 16px !important; line-height: 24px !important;" > cf Gloves</h3></div> -->
					</div>
					<div class="row-fluid relative">
						<div class="span12">
								<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">
									<p><span class="field">';echo strtoupper($pledger[0]['etype']);;echo '#</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['dcno'];;echo '</span></p>									
									<p><span class="field">Date</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($pledger[0]['date']));;echo '</span></p>
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
									<th style=" width: 9px; padding: 0; ">#</th>
									<th style=" width: 100px; ">Account</th>
									<th style=" width: 100px; ">Remarks</th>
									<th style=" width: 16px; ">Inv#</th>
									<th style=" width: 40px; ">Amount</th>
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
if ($etype == 'cpv'and $row['debit']!=0 ) {
$amount= $row['debit'];
}else if ($etype == 'crv'and $row['credit']!=0) {
$amount= $row['credit'];
}
$Total_Amount += $amount;
if ($amount!=0){
;echo '									
									<tr style="amountborder-bottom:1px dotted #ccc;" class="item-row">
									   <td > ';echo $serial++;;echo '</td>
									   <td class=\'text-left\' >';echo $row['party_name'];;echo ' </td>
									   <td  class=\'text-left\'>';echo $row['description'];;echo '</td>
									   <td  class=\'text-right\'>';echo $row['invoice'];;echo '</td>
									   <td  class="text-right">';echo number_format($amount,2);;echo '</td>
									</tr>

								';}endforeach ;echo '								';
;echo '							
							
							<!-- 	<tr class="foot-comments">
									<td class="vrqty bold-td text-right">';
;echo '</td>
									<td class="bold-td text-right" colspan="3">Subtotal</td>
									<td class="bold-td"></td>
								</tr> -->
								<tr style="amountborder-bottom:2px dotted #ccc;" class="item-row">
									<td class="bold-td"></td>
									<td class="text-right " colspan="3">Total</td>
									<td class="text-right ">';echo number_format($Total_Amount,2);;echo '</td>
								</tr>
							</tbody>
							';};echo '						</table>
					</div>
					<div class="row-fluid">
						<div class="span12 add-on-detail" style="margin-top: 10px;">
							<p class="" style="text-transform: uppercase;">
								<!-- <strong>In words: </strong> <span class="inwords"></span>  ';echo  $Total_Amount;;echo ' ONLY <br>	 -->
							</p>
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
							
							<span class="loggedin_name item_row">User:';echo $user;;echo '</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<span class="loggedin_name item_row">, Unit:';echo $this->session->userdata('company_name');;echo '</span>
							
							<!-- <span class="website item_row">Sofware By: www.alnaharsolution.com</span> -->
						</p>
					</div>

				</div>
				<!-- <div class="span3 centered">
				</div> -->
			</div>
		</div>
		<script type="text/javascript" src="../../assets/js/app_modules/pdf_general.js"></script>
	</body>
	</html>	';
?>