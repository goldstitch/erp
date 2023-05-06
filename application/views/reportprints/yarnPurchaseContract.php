

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
			 body { font-size:14px !important; }
			 p { margin: 0 !important; /* line-height: 17px !important; */ }
			 .field { font-size:14px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .field1 { font-size:14px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: none !important; }
			 .header-table{ border-collapse: none !important;}
			 .header-table thead th {background: white !important;border: none;font-size: 13px !important;  } 
			 .font-normal{font-weight: 100;}
			 table { width: 100% !important; border: 1px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
			 th {  padding: 5px !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child {  }
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
			 h3.invoice-type {font-size: 16px !important; line-height: 24px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 10px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 10px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto !important; }
			 p { position: relative !important; font-size: 10px !important; }
			 thead th { font-size: 14px !important; font-weight: bold !important; padding: 10px !important; }
			 .fieldvalue { font-size:14px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 12px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			.signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			/*.rcpt-header { width: 8px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }*/
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
			.border{border:1px solid red;}
			.header{width: 50%;}
			.header-field{width: 90%;float: left !important;}
			.header-terms{width: 10%;float: left !important; }
			.clear{clear: both;}
			.padd-left{padding-left: 40px;}
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
						<div class="span12 header">
							<div class="header-field">
								<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">
									';if ($etype == 'yarnPurchaseContract') {;echo '										<p><span class="field">Contact#</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['vrnoa'];;echo '</span></p>
									';}else{;echo '									<p><span class="field">Vr#</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['vrnoa'];;echo '</span></p>					
									';};echo '									<p><span class="field">Date:</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</span></p>
									<p><span class="field ">Customer:</span><span class="fieldvalue cust-name">';echo $vrdetail[0]['party_name'];;echo '</span></p>
									';if($etype=='yarnPurchase'||$etype=='fabricPurchase'){;echo '										<p><span class="field">Igp#</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['order_vrno'];;echo '</span></p>
									';};echo '									<p><span class="field">Remarks:</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['remarks'];;echo '</span></p>
								</div>
							</div>
							<div class="header-terms" style="white-space: nowrap;">
								<p><span class="field">Payment Terms:</span><span class="fieldvalue cust-mobile padd-left" style="white-space: nowrap;">';echo ($vrdetail[0]['payment_term']?$vrdetail[0]['payment_term']:'-');;echo '</span></p>
								<p><span class="field">Delivery Terms:</span><span class="fieldvalue cust-mobile padd-left" style="white-space: nowrap;">';echo ($vrdetail[0]['delivery_term']?$vrdetail[0]['delivery_term']:'-');;echo '</span></p>
							</div>	
						</div>
						<div class="clear">
							
						</div>
								<div class="block pull-right" style="width:280px !important; float: right; display:inline !important;">
									<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative; top: 12px !important; ">';echo $title;;echo '</h3>
								</div>
								';
;echo '						</div>
					</div>
				
					
					<br>
					<br>
					<br>
					
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr style="color:white !important;">
									<th style=" width: 10px; " >Sr#</th>
									<th style=" width: 70px; text-align:left; ">Description</th>
									<th style=" width: 10px; ">Uom</th>
									<th style=" width: 15px; " class=\'text-right\'>Qty</th>
									<th style=" width: 18px; " class=\'text-right\'>Weight</th>
									<th style=" width: 15px; " class=\'text-right\'>Rate</th>
									<th style=" width: 30px; " class=\'text-right\'>Amount</th>
									';
;echo '									<th style=" width: 10px; ">WO#</th>
									';
;echo '								</tr>
							</thead>

							<tbody>
								
								';
$serial = 1;
$netQty = 0;
$netAmount=0;
$netWeight=0;
$typee='';
$typee22='';
foreach ($vrdetail as $row):
;echo '									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
									   <td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
									   <td class=\'text-centre\'>';echo $row['uom'];;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['qty']),0);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['weight']),2);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(($row['rate']),2);;echo '</td>
									   <td class="text-right">';echo number_format(($row['amount']),2);;echo '</td>
									   ';
;echo '									   <td class=\'text-right\'>';echo $row['dwork_orderno'];;echo '</td>
									   ';
;echo '									</tr>
								';
$netQty += abs($row['qty']);
$netAmount += $row['amount'];
$netWeight += abs($row['weight']);
endforeach;echo '							</tbody>
							<tfoot>
								<tr class="foot-comments">
									<td class="subtotalend bold-td text-right" colspan="3">Subtotal:</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netQty,0);;echo '</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netWeight,2);;echo '</td>
									<td class="subtotalend bold-td text-right"></td>
									<td class="subtotalend bold-td text-right">';echo number_format($netAmount,2);;echo '</td>
									';
;echo '									<td class="subtotalend bold-td text-right"></td>
									';
;echo '								</tr>
								';if(intval($vrdetail[0]['freight'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="5">Freight:</td>
									<td class="subtotal bold-td text-right"></td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['freight']),2);;echo '</td>
									
									<td class="subtotal bold-td text-right"></td>
									
								</tr>
								';};echo '								';if(intval($vrdetail[0]['discount'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="5">Discount:</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['discp']),2) .'% ';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['discount']),2);;echo '</td>
									
									<td class="subtotal bold-td text-right"></td>
									
								</tr>
								';};echo '								';if(intval($vrdetail[0]['expense'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="5">Expense:</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['exppercent']),2) .'% ';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['expense']),2);;echo '</td>
									
									<td class="subtotal add-lower text-right"></td>
									
								</tr>
								';};echo '								';if(intval($vrdetail[0]['tax'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="5">Tax:</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['taxpercent']),2) .'% ';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['tax']),2);;echo '</td>
									
									<td class="subtotal bold-td text-right"></td>
									
								</tr>
								';};echo '								';if(!(intval($vrdetail[0]['tax'])==0 &&intval($vrdetail[0]['discount'])==0 &&intval($vrdetail[0]['expense'])==0 &&intval($vrdetail[0]['paid'])==0 &&intval($vrdetail[0]['freight'])==0) ){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="5">NetAmount:</td>
									<td class="subtotal bold-td text-right"></td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['namount']),2);;echo '</td>
									
									<td class="subtotal bold-td text-right"></td>
									
								</tr>
								';};echo '

							</tfoot>
						</table>
					</div>
					<div class="row-fluid">
						<div class="span12 add-on-detail1" style="margin-top: 10px;">
							<p class="" style="text-transform1: uppercase;">
								<strong>In words: </strong> <span class="inwords"></span>';echo strtoupper($amtInWords);;echo ' &nbsp; ONLY <br>
								<br>
								';if ( $pre_bal_print==1  ){;echo '									<p><span class="field1">Previous Balance:</span><span class="fieldvalue inv-vrnoa">';echo number_format($previousBalance,0);;echo '</span></p>
									<p><span class="field1">This Invoice:</span><span class="fieldvalue inv-date">';echo number_format($vrdetail[0]['namount'],0);;echo '</span></p>
									<p><span class="field1">Current Balance:</span><span class="fieldvalue cust-name">';echo number_format($vrdetail[0]['namount']+$previousBalance,2) ;;echo '</span></p>
								';};;echo '							</p>
						</div>
						<div class="span12">
							<strong>Dispatch Address: </strong> <span class="inwords"></span>';echo $vrdetail[0]['dispatch_address'];;echo ' <br>
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
										<th>Prepared By</th>
										<td></td>
										<th>Checked By</th>
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