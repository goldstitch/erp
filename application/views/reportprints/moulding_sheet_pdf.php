

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
			 * { margin: 0; padding: 0; font-family: tahoma; }
			 body { font-size:12px; }
			 p { margin: 0; /* line-height: 17px; */ }
			 .field {font-weight: bold; display: inline-block; width: 100px; } 
			 .field1 {font-weight: bold; display: inline-block; width: 150px; } 
			 .voucher-table{ border-collapse: none; }
			 table { width: 100%; border: 2px solid black; border-collapse:collapse; table-layout:fixed; margin-left:1px}
			 th {  padding: 5px; }
			 td { /*text-align: center;*/ vertical-align: top;  }
			 td:first-child { text-align: left; }
			 .voucher-table thead th {background: #ccc; } 
			 tfoot {border-top: 1px solid black; } 
			 .bold-td { font-weight: bold; border-bottom: 0px solid black;}
			 .nettotal { font-weight: bold; font-size: 11px !important; border-top: 1px solid black; }
			 .invoice-type { border-bottom: 1px solid black; }
			 .relative { position: relative; }
			 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
			 .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px; }
			 .inv-leftblock { width: 280px; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 10px; font-family: tahoma; line-height: 14px; padding: 4px; } 
			 .rcpt-header { width: 550px; margin: auto; display: block; }
			 .inwords, .remBalInWords { text-transform: uppercase; }
			 .barcode { margin: auto; }
			 h3.invoice-type {font-size: 20px; line-height: 24px;}
			 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; margin: 5px 0px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;}
			 .nettotal { color: red; font-size: 12px;}
			 .remainingBalance { font-weight: bold; color: blue;}
			 .centered { margin: auto; }
			 p { position: relative; font-size: 16px; }
			 thead th { font-size: 13px; font-weight: bold; padding: 10px; }
			 .fieldvalue.cust-name {position: absolute; width: 497px; }
			 @media print {
			 	.noprint, .noprint * { display: none; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right; }
			.item-row td { font-size: 15px; padding: 10px; border-top: 1px solid black;}

			.rcpt-header { width: 305px !important; margin: 0px; display: inline; position: absolute; top: 0px; right: 0px; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative; top: 34px; }
			tfoot tr td { font-size: 13px; padding: 10px;  }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 14px !important; font-weight: bold !important;}
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
									<p><span class="field">Vr#</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['vrnoa'];;echo '</span></p>									
									<p><span class="field">Date:</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</span></p>
									<p><span class="field ">Employee:</span><span class="fieldvalue cust-name">';echo $vrdetail[0]['party_name'];;echo '</span></p>
									<p><span class="field">Remarks:</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['remarks'];;echo '</span></p>
									<!-- <p><span class="field">Receipt By</span><span class="fieldvalue rcptBy">[Receipt By]</span></p> -->
								</div>
								<div class="block pull-right" style="width:280px !important; float: right; display:inline !important;">
									<div class="span12"><img style="float:right; width:280px !important;" class="rcpt-header logo-img" src="';echo $header_img;;echo '" alt=""></div>
									<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative; top: 18px; ">';echo $title;;echo '</h3>
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
									<th style=" width: 10px; ">Sr#</th>
									<th style=" width: 100px; text-align:left; ">Description</th>
									<th style=" width: 20px; ">Uom</th>
									<th style=" width: 15px; ">Qty</th>
									<th style=" width: 18px; ">Weight</th>
									<th style=" width: 15px; ">Mould@</th>
									<th style=" width: 25px; ">M Amount</th>
									<th style=" width: 15px; ">Dhary@</th>
									<th style=" width: 25px; ">D Amount</th>
								</tr>
							</thead>

							<tbody>
								
								';
$serial = 1;
$netQty = 0;
$netAmount=0;
$netAmountDhary=0;
$netWeight=0;
foreach ($vrdetail as $row):
$netQty += abs($row['qty']);
$netAmount += $row['s_amount'];
$netAmountDhary += $row['s_damount'];
$netWeight += abs($row['weight']);
;echo '									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
									   <td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
									   <td class=\'text-right\'>';echo $row['uom'];;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['qty']),0);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['weight']),2);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(($row['s_rate']),2);;echo '</td>
									   <td class="text-right">';echo number_format(($row['s_amount']),2);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(($row['s_discount']),2);;echo '</td>
									   <td class="text-right">';echo number_format(($row['s_damount']),2);;echo '</td>
									</tr>
									
								';endforeach;echo '							</tbody>
							<tfoot>
								<tr class="foot-comments">
									<td class="bold-td text-right" colspan="3">Subtotal:</td>
									<td class="vrqty bold-td text-right">';echo number_format($netQty,0);;echo '</td>
									<td class="vrweight bold-td text-right">';echo number_format($netWeight,2);;echo '</td>
									<td class="vrrate bold-td text-right" colspan="4"></td>
								</tr>
								<tr>
									<td class="bold-td text-right" >Mould=></td>
									<td class="bold-td text-right" >Amount:</td>
									<td class="subtotal bold-td text-right">';echo number_format($netAmount,2);;echo '</td>
									<td class="bold-td text-right discount-td">Bonus:</td>
									<td class="vrweight bold-td text-right">';echo number_format(($vrdetail[0]['discp']),2);;echo '</td>
									<td class="bold-td text-right discount-td " >Deduction:</td>
									<td class="vrweight bold-td text-right">';echo number_format(($vrdetail[0]['expense']),2);;echo '</td>
									<td class="bold-td text-right discount-td ">Total:</td>
									<td class="vrweight bold-td text-right">';echo number_format($vrdetail[0]['expense']+$vrdetail[0]['discp']+$netAmount,2);;echo '</td>
								</tr>
								<tr>
									<td class="vrrate bold-td text-right">Dhary=></td>
									<td class="vrrate bold-td text-right">Amount:</td>
									<td class="subtotal bold-td text-right">';echo number_format($netAmountDhary,2);;echo '</td>
									<td class="bold-td text-right discount-td">Bonus:</td>
									<td class="vrweight bold-td text-right">';echo number_format(($vrdetail[0]['taxpercent']),2);;echo '</td>
									<td class="bold-td text-right discount-td">Deduction:</td>
									<td class="vrweight bold-td text-right">';echo number_format(($vrdetail[0]['exppercent']),2);;echo '</td>
									<td class="bold-td text-right discount-td">Total:</td>
									<td class="vrweight bold-td text-right">';echo number_format($vrdetail[0]['exppercent']+$vrdetail[0]['taxpercent']+$netAmountDhary,2);;echo '</td>
								</tr>
								<tr>
									<td class="bold-td text-right discount-td " colspan="4">Cash Paid:</td>
									<td class="vrweight bold-td text-right">';echo number_format(($vrdetail[0]['paid']),2);;echo '</td>
									<td class="bold-td text-right discount-td"></td>
									<td class="bold-td text-right discount-td " colspan="2">NetAmount:</td>
									<td class="vrweight bold-td text-right">';echo number_format(($vrdetail[0]['namount']),2);;echo '</td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="row-fluid">
						<div class="span12 add-on-detail1" style="margin-top: 10px;">
							<p class="" style="text-transform1: uppercase;">
								<strong>In words: </strong> <span class="inwords"></span>';echo strtoupper($amtInWords);;echo ' &nbsp; ONLY <br>
								<br>
								';if ( $pre_bal_print==1  ){;echo '									<p><span class="field1">Previous Balance:</span><span class="fieldvalue inv-vrnoa">';number_format($previousBalance,0);;echo '</span></p>
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
							<span class="loggedin_name">User:';echo $user;;echo '</span><br>
							<span class="website">Sofware By: www.alnaharsolution.com</span>
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>';
?>