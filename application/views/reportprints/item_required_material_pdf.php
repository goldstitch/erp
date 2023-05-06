

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
	body { font-size:9px !important;font-family: tahoma !important; }
p { margin: 0 !important; /* line-height: 17px !important; */ }
.field { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
.fieldHeading { font-size:14px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
.field1 { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
.voucher-table{ border-collapse: none !important; width:99% !important;  }
table { width: 100% !important; border: 0.5px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
th {  padding: 5px !important; }
td { /*text-align: center !important;*/ vertical-align: top !important;  }
td:first-child { text-align: left !important; }
.voucher-table thead th {background: #ccc !important; } 
tfoot {border-top: 0.5px solid black !important; } 
.bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
.nettotal { font-weight: bold !important; font-size: 9px !important; border-top: 0.5px solid black !important; }
.invoice-type { border-bottom: 0.5px solid black !important; }
.relative { position: relative !important; }
.signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
.signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
.inv-leftblock { width: 280px !important; }
.text-left { text-align: left !important; }
.text-right { text-align: right !important; }
td {font-size: 10px !important; font-family: tahoma !important; line-height: 14px !important; padding: 4px !important; } 
.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
.inwords, .remBalInWords { text-transform: uppercase !important; }
.barcode { margin: auto !important; }
h3.invoice-type {font-size: 16px !important; line-height: 24px !important;}
.extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 10px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
.nettotal { color: red !important; font-size: 10px !important;}
.remainingBalance { font-weight: bold !important; color: blue !important;}
.centered { margin: auto !important; }
p { position: relative !important; font-size: 10px !important; }
thead th { font-size: 10px !important; font-weight: bold !important; padding: 10px !important; }
.fieldvalue { font-size:10px !important; position: absolute !important; width: 497px !important; }

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
.nettotal, .subtotal, .vrqty,.vrweight { font-size: 10px !important; font-weight: bold !important;}
tr{ page-break-inside: avoid;}

tfoot { display: table-row-group }


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
							<p><span class="field">Vr#</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['vrnoa'];;echo '</span></p>									
							<p><span class="field">Date:</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</span></p>
							<p><span class="field">WorkOrder#</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['worder'];;echo '</span></p>
							<p><span class="field ">Party Name:</span><span class="fieldvalue cust-name">';echo $vrdetail[0]['partyname'];;echo '</span></p>
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
						<div class="row-fluid fieldHeading" > Items </div>
						<thead>
							<tr>
								<th style=" width: 10px; ">Sr#</th>
								<th style=" width: 20px; ">Article#</th>
								<th style=" width: 100px; text-align:left; ">Description</th>
								<th style=" width: 10px; " class="text-left" >Uom</th>
								<th style=" width: 15px; " class=\'text-right\'>Dozen</th>
								<th style=" width: 15px; " class=\'text-right\'>Qty</th>
								<th style=" width: 15px; " class=\'text-right\'>Rate</th>
								<th style=" width: 30px; " class=\'text-right\'>Amount</th>
							</tr>
						</thead>
						<tbody>
							';
$serial = 1;
$netQty = 0;
$netDozen = 0;
$netAmount=0;
$grossQty = 0;
$grAmount=0;
$preArticle="";
$add_flg='0';
$grDozen = 0;
$netWeight=0;
foreach ($vrdetail as $row):
if( $row['detype']=='item'){
if($row['short_code'] !== $preArticle){
if($serial!=1){;echo '
											<tr class="foot-comments">
												<td class="subtotal bold-td text-right" colspan="4">Sub Total:</td>
												<td class="subtotal bold-td text-right">';echo number_format($grDozen,2);;echo '</td>
												<td class="subtotal bold-td text-right">';echo number_format($grossQty,0);;echo '</td>
												<td class="subtotal bold-td text-right"></td>
												<td class="subtotal bold-td text-right">';echo number_format($grAmount,2);;echo '</td>
											</tr>

										';}
$grossQty=0;
$grDozen=0;
$grAmount=0;
$preArticle = $row['short_code'];
}
$grAmount += $row['amount'];
$grossQty += abs($row['qty']);
$netQty += abs($row['qty']);
$netDozen += abs($row['qty']/12);
$grDozen += abs($row['qty']/12);
$netAmount += $row['amount'];
$netWeight += abs($row['weight']);
;echo '
									<tr  class="item-row">
										<td class=\'text-left\'>';echo $serial;;echo '</td>
										<td class=\'text-left\'>';echo $row['short_code'];;echo '</td>

										<td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
										<td class=\'text-left\'>';echo $row['uom'];;echo '</td>
										<td class=\'text-right\'>';echo ($row['qty']<>0 ?number_format(abs($row['qty']/12),2) :0 );;echo '</td>
										<td class=\'text-right\'>';echo number_format(abs($row['qty']),0);;echo '</td>
										<td class=\'text-right\'>';echo number_format(($row['rate']),2);;echo '</td>
										<td class="text-right">';echo number_format(($row['amount']),2);;echo '</td>
									</tr>
								';$serial+=1;}endforeach;echo '
								<tr class="foot-comments">
											<td class="subtotal bold-td text-right" colspan="4">Sub Total:</td>
											<td class="subtotal bold-td text-right">';echo number_format($grDozen,2);;echo '</td>
											<td class="subtotal bold-td text-right">';echo number_format($grossQty,0);;echo '</td>
											<td class="subtotal bold-td text-right"></td>
											<td class="subtotal bold-td text-right">';echo number_format($grAmount,2);;echo '</td>
										</tr>

							</tbody>
							<tfoot>
								<tr class="foot-comments">
									<td class="subtotal bold-td text-right" colspan="4">Grand Total:</td>
									<td class="subtotal bold-td text-right">';echo number_format($netDozen,2);;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format($netQty,0);;echo '</td>
									<td class="subtotal bold-td text-right"></td>
									<td class="subtotal bold-td text-right">';echo number_format($netAmount,2);;echo '</td>
								</tr>
							</tfoot>
						</table>
					</div>
					<br>
					<br>

					<div class="row-fluid">
						<table class="voucher-table">
							<div class="row-fluid fieldHeading" > Material </div>
							<thead>
								<tr>
									<th style=" width: 10px; ">Sr#</th>
									<th style=" width: 30px; text-align:left; ">Article</th>
									<th style=" width: 100px; text-align:left; ">Description</th>
									<th style=" width: 20px; " class="text-left">Uom</th>
									<th style=" width: 30px; " class="text-left">Used For</th>
									<th style=" width: 15px; " class=\'text-right\'>Qty</th>
									<th style=" width: 15px; " class=\'text-right\'>Rate</th>
									<th style=" width: 30px; " class=\'text-right\'>Amount</th>
								</tr>
							</thead>
							<tbody>
								';
$serial = 1;
$netQty = 0;
$grossQty = 0;
$netAmountMaterial=0;
$grAmountMaterial=0;
$preArticle="";
$add_flg='0';
$netWeight=0;
foreach ($vrdetail as $row):
if( $row['detype']=='material'){
if($row['item_name_article'] !== $preArticle){
if($serial!=1){;echo '
												<tr class="foot-comments">
													<td class="subtotal bold-td text-right" colspan="5">Sub Total:</td>
													<td class="subtotal bold-td text-right">';echo number_format($grossQty,0);;echo '</td>
													<td class="subtotal bold-td text-right"></td>
													<td class="subtotal bold-td text-right">';echo number_format($grAmountMaterial,2);;echo '</td>
												</tr>

											';}
$grossQty=0;
$grAmountMaterial=0;
$preArticle = $row['item_name_article'];
}
$netQty += abs($row['qty']);
$netAmountMaterial += $row['amount'];
$netWeight += abs($row['weight']);
$grAmountMaterial += $row['amount'];
$grossQty += abs($row['qty']);
;echo '
										<tr  class="item-row">
											<td class=\'text-left\'>';echo $serial;;echo '</td>
											<td class=\'text-left\'>';echo $row['item_name_article'];;echo '</td>

											<td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
											<td class=\'text-left\'>';echo $row['uom'];;echo '</td>
											<td class=\'text-left\'>';echo $row['used_for'];;echo '</td>

											<td class=\'text-right\'>';echo number_format(abs($row['qty']),0);;echo '</td>
											<td class=\'text-right\'>';echo number_format(($row['rate']),2);;echo '</td>
											<td class="text-right">';echo number_format(($row['amount']),2);;echo '</td>
										</tr>
										';$serial+=1;}endforeach
;echo '
										<tr class="foot-comments">
											<td class="subtotal bold-td text-right" colspan="5">Sub Total:</td>
											<td class="subtotal bold-td text-right">';echo number_format($grossQty,0);;echo '</td>
											<td class="subtotal bold-td text-right"></td>
											<td class="subtotal bold-td text-right">';echo number_format($grAmountMaterial,2);;echo '</td>
										</tr>

									</tbody>
									<tfoot>
										<tr class="foot-comments">
											<td class="subtotal bold-td text-right" colspan="5">Grand Total:</td>
											<td class="subtotal bold-td text-right">';echo number_format($netQty,0);;echo '</td>
											<td class="subtotal bold-td text-right"></td>
											<td class="subtotal bold-td text-right">';echo number_format($netAmountMaterial,2);;echo '</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<br>
							<br>

							<div class="row-fluid">
								<table class="voucher-table">
									<div class="row-fluid fieldHeading" > Yarn </div>
									<thead>
										<tr>
											<th style=" width: 10px; ">Sr#</th>
											<th style=" width: 30px; text-align:left; ">Article</th>
											<th style=" width: 100px; text-align:left; ">Description</th>
											<th style=" width: 20px; " class="text-left">Uom</th>
											<th style=" width: 30px; " class="text-left">Used For</th>

											<th style=" width: 15px; " class=\'text-right\'>Qty</th>
											<th style=" width: 15px; " class=\'text-right\'>Rate</th>
											<th style=" width: 30px; " class=\'text-right\'>Amount</th>
										</tr>
									</thead>
									<tbody>
										';
$serial = 1;
$netQty = 0;
$netAmountFabric=0;
$netWeight=0;
$grAmountFabrics=0;
$grossQtyFabrics=0;
$preArticle="";
foreach ($vrdetail as $row):
if( $row['detype']=='fabric'){
if($row['item_name_article'] !== $preArticle){
if($serial!=1){;echo '
														<tr class="foot-comments">
															<td class="subtotal bold-td text-right" colspan="5">Sub Total:</td>
															<td class="subtotal bold-td text-right">';echo number_format($grossQtyFabrics,2);;echo '</td>
															<td class="subtotal bold-td text-right"></td>
															<td class="subtotal bold-td text-right">';echo number_format($grAmountFabrics,2);;echo '</td>
														</tr>

													';}
$grossQtyFabrics=0;
$grAmountFabrics=0;
$preArticle = $row['item_name_article'];
}
$netQty += abs($row['qty']);
$netAmountFabric += $row['amount'];
$netWeight += abs($row['weight']);
$grossQtyFabrics += abs($row['qty']);
$grAmountFabrics += $row['amount'];
;echo '												<tr  class="item-row">
													<td class=\'text-left\'>';echo $serial++;;echo '</td>
													<td class=\'text-left\'>';echo $row['item_name_article'];;echo '</td>

													<td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
													<td class=\'text-left\'>';echo $row['uom'];;echo '</td>
													<td class=\'text-left\'>';echo $row['used_for'];;echo '</td>
													<td class=\'text-right\'>';echo number_format(abs($row['qty']),2);;echo '</td>
													<td class=\'text-right\'>';echo number_format(($row['rate']),2);;echo '</td>
													<td class="text-right">';echo number_format(($row['amount']),2);;echo '</td>
												</tr>
												';$serial+=1;}endforeach
;echo '
												<tr class="foot-comments">
													<td class="subtotal bold-td text-right" colspan="5">Sub Total:</td>
													<td class="subtotal bold-td text-right">';echo number_format($grossQtyFabrics,2);;echo '</td>
													<td class="subtotal bold-td text-right"></td>
													<td class="subtotal bold-td text-right">';echo number_format($grAmountFabrics,2);;echo '</td>
												</tr>
											</tbody>
											<tfoot>
												<tr class="foot-comments">
													<td class="subtotal bold-td text-right" colspan="5">Grand Total:</td>
													<td class="subtotal bold-td text-right">';echo number_format($netQty,2);;echo '</td>
													<td class="subtotal bold-td text-right"></td>
													<td class="subtotal bold-td text-right">';echo number_format($netAmountFabric,2);;echo '</td>
												</tr>
											</tfoot>
										</table>
									</div>
									<br>
									<br>

									<div class="row-fluid">
										<table class="voucher-table">
											<div class="row-fluid fieldHeading" > Packing </div>
											<thead>
												<tr>
													<th style=" width: 10px; ">Sr#</th>
													<th style=" width: 30px; text-align:left; ">Article</th>
													<th style=" width: 100px; text-align:left; ">Description</th>
													<th style=" width: 20px; ">Uom</th>
													<th style=" width: 30px; " class=\'text-left\'>Used For</th>
													<th style=" width: 15px; " class=\'text-right\'>Qty</th>
													<th style=" width: 15px; " class=\'text-right\'>Rate</th>
													<th style=" width: 30px; " class=\'text-right\'>Amount</th>
												</tr>
											</thead>
											<tbody>
												';
$serial = 1;
$netQty = 0;
$netAmountPacking=0;
$netWeight=0;
$grossQtyPacking=0;
$netAmountPacking=0;
$grAmountPacking=0;
$preArticle="";
foreach ($vrdetail as $row):
if( $row['detype']=='packing'){
if($row['item_name_article'] !== $preArticle){
if($serial!=1){;echo '
																<tr class="foot-comments">
																	<td class="subtotal bold-td text-right" colspan="5">Sub Total:</td>
																	<td class="subtotal bold-td text-right">';echo number_format($grossQtyPacking,0);;echo '</td>
																	<td class="subtotal bold-td text-right"></td>
																	<td class="subtotal bold-td text-right">';echo number_format($grAmountPacking,2);;echo '</td>
																</tr>

															';}
$grossQtyPacking=0;
$grAmountPacking=0;
$preArticle = $row['item_name_article'];
}
$netQty += abs($row['qty']);
$netAmountPacking += $row['amount'];
$netWeight += abs($row['weight']);
$grAmountPacking += $row['amount'];
$grossQtyPacking += abs($row['qty']);
;echo '														<tr  class="item-row">
															<td class=\'text-left\'>';echo $serial++;;echo '</td>
															<td class=\'text-left\'>';echo $row['item_name_article'];;echo '</td>

															<td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
															<td class=\'text-centre\'>';echo $row['uom'];;echo '</td>
															<td class=\'text-left\'>';echo $row['used_for'];;echo '</td>
															<td class=\'text-right\'>';echo number_format(abs($row['qty']),0);;echo '</td>
															<td class=\'text-right\'>';echo number_format(($row['rate']),2);;echo '</td>
															<td class="text-right">';echo number_format(($row['amount']),2);;echo '</td>
														</tr>
														';$serial+=1;}endforeach
;echo '
														<tr class="foot-comments">
															<td class="subtotal bold-td text-right" colspan="5">Sub Total:</td>
															<td class="subtotal bold-td text-right">';echo number_format($grossQtyPacking,0);;echo '</td>
															<td class="subtotal bold-td text-right"></td>
															<td class="subtotal bold-td text-right">';echo number_format($grAmountPacking,2);;echo '</td>
														</tr>
													</tbody>
													<tfoot>
														<tr class="foot-comments">
															<td class="subtotal bold-td text-right" colspan="5">Grand Total:</td>
															<td class="subtotal bold-td text-right">';echo number_format($netQty,0);;echo '</td>
															<td class="subtotal bold-td text-right"></td>
															<td class="subtotal bold-td text-right">';echo number_format($netAmountPacking,2);;echo '</td>
														</tr>
													</tfoot>
												</table>
											</div>
											<br>
											<br>
											<div class="row-fluid">
												<table class="voucher-table">
													<div class="row-fluid fieldHeading" > Labour </div>
													<thead>
														<tr>
															<th style=" width: 10px; ">Sr#</th>
															<th style=" width: 70px; text-align:left; ">Article#</th>


															<th style=" width: 70px; text-align:left; ">Phase</th>
															<th style=" width: 15px; " class=\'text-right\'>Qty</th>

															<th style=" width: 30px; " class=\'text-right\'>DozenRate</th>
															
															<th style=" width: 30px; ">PcsRate</th>

															<th style=" width: 30px; " class=\'text-right\'>Amount</th>

														</tr>
													</thead>
													<tbody>
														';
$serial = 1;
$netrate = 0;
$netrate2=0;
$grossrate = 0;
$grossrate2=0;
$qtyGross=0;
$qtyNet=0;
$netWeight=0;
$netAmountLabour=0;
$grAmount=0;
$preArticle="";
foreach ($vrdetailLabour as $row):
if( $row['detype']=='labour'){
if($row['item_name_article'] !== $preArticle){
if($serial!=1){;echo '
																		<tr class="foot-comments">
																			<td colspan="3" class="subtotal bold-td text-right">Sub Total:</td>

																			<td class="subtotal bold-td text-right">';echo number_format($qtyGross,2);;echo '</td>
																			<td class=""></td>
																			<td class=""></td>
																			<td class="subtotal bold-td text-right">';echo number_format($grAmount,2);;echo '</td>

																		</tr>

																	';}
$qtyGross=0;
$grAmount=0;
$preArticle = $row['item_name_article'];
}
$qtyGross += abs($row['qty']);
$grAmount += $row['amount'];
$qtyNet += abs($row['qty']);
$netAmountLabour += $row['amount'];
;echo '																<tr  class="item-row">
																	<td class=\'text-left\'>';echo $serial++;;echo '</td>
																	<td class=\'text-left\'>';echo $row['item_name_article'];;echo '</td>
																	<td class=\'text-left\'>';echo $row['subphase_name'];;echo '</td>


																	<td class=\'text-right\'>';echo number_format(($row['qty']),2);;echo '</td>
																	<td class=\'text-right\'>';echo number_format(($row['rate']),2);;echo '</td>

																	<td class=\'text-right\'>';echo number_format(($row['rate2']),2);;echo '</td>
																	<td class=\'text-right\'>';echo number_format(($row['amount']),2);;echo '</td>
																</tr>
																';$serial+=1;}endforeach
;echo '
																<tr class="foot-comments">
																	<td colspan="3" class="subtotal bold-td text-right">Sub Total:</td>

																	<td class="subtotal bold-td text-right">';echo number_format($qtyGross,2);;echo '</td>
																	<td class=""></td>
																	<td class=""></td>
																	<td class="subtotal bold-td text-right">';echo number_format($grAmount,2);;echo '</td>

																</tbody>
																<tfoot>
																	<tr class="foot-comments">
																		<td colspan="3" class="subtotal bold-td text-right">Grand Total:</td>

																		<td class="subtotal bold-td text-right">';echo number_format($qtyNet,2);;echo '</td>
																		<td class=""></td>
																		<td class=""></td>
																		<td class="subtotal bold-td text-right">';echo number_format($netAmountLabour,2);;echo '</td>
																	</tfoot> 

																</table>
																

															</div>

															<!-- End row-fluid -->
															<br>
															<br>

															<div class="row-fluid">
																<table class="voucher-table">
																	<div class="row-fluid fieldHeading" > Embelishment </div>
																	<thead>
																		<tr>
																			<th style=" width: 10px; ">Sr#</th>
																			<th style=" width: 70px; text-align:left; ">Article#</th>


																			<th style=" width: 70px; text-align:left; ">Phase</th>
																			<th style=" width: 15px; " class=\'text-right\'>Qty</th>

																			<th style=" width: 30px; " class=\'text-right\'>DozenRate</th>

																			<th style=" width: 30px; ">PcsRate</th>

																			<th style=" width: 30px; " class=\'text-right\'>Amount</th>

																		</tr>
																	</thead>
																	<tbody>
																		';
$serial = 1;
$netrate = 0;
$netrate2=0;
$grossrate = 0;
$grossrate2=0;
$qtyGross=0;
$qtyNet=0;
$netWeight=0;
$netAmountEmbelishment=0;
$grAmount=0;
$preArticle="";
foreach ($vrdetailEbelishment as $row):
if( $row['detype']=='embelishment'){
if($row['item_name_article'] !== $preArticle){
if($serial!=1){;echo '
																						<tr class="foot-comments">
																							<td colspan="3" class="subtotal bold-td text-right">Sub Total:</td>

																							<td class="subtotal bold-td text-right">';echo number_format($qtyGross,2);;echo '</td>
																							<td class=""></td>
																							<td class=""></td>
																							<td class="subtotal bold-td text-right">';echo number_format($grAmount,2);;echo '</td>

																						</tr>

																					';}
$qtyGross=0;
$grAmount=0;
$preArticle = $row['item_name_article'];
}
$qtyGross += abs($row['qty']);
$grAmount += $row['amount'];
$qtyNet += abs($row['qty']);
$netAmountEmbelishment += $row['amount'];
;echo '																				<tr  class="item-row">
																					<td class=\'text-left\'>';echo $serial++;;echo '</td>
																					<td class=\'text-left\'>';echo $row['item_name_article'];;echo '</td>
																					<td class=\'text-left\'>';echo $row['subphase_name'];;echo '</td>


																					<td class=\'text-right\'>';echo number_format(($row['qty']),2);;echo '</td>
																					<td class=\'text-right\'>';echo number_format(($row['rate']),2);;echo '</td>

																					<td class=\'text-right\'>';echo number_format(($row['rate2']),2);;echo '</td>
																					<td class=\'text-right\'>';echo number_format(($row['amount']),2);;echo '</td>
																				</tr>
																				';$serial+=1;}endforeach
;echo '
																				<tr class="foot-comments">
																					<td colspan="3" class="subtotal bold-td text-right">Sub Total:</td>

																					<td class="subtotal bold-td text-right">';echo number_format($qtyGross,2);;echo '</td>
																					<td class=""></td>
																					<td class=""></td>
																					<td class="subtotal bold-td text-right">';echo number_format($grAmount,2);;echo '</td>

																				</tbody>
																				<tfoot>
																					<tr class="foot-comments">
																						<td colspan="3" class="subtotal bold-td text-right">Grand Total:</td>

																						<td class="subtotal bold-td text-right">';echo number_format($qtyNet,2);;echo '</td>
																						<td class=""></td>
																						<td class=""></td>
																						<td class="subtotal bold-td text-right">';echo number_format($netAmountEmbelishment,2);;echo '</td>
																					</tfoot> 

																				</table>


																			</div>

																			<!-- End row-fluid -->
																			<br>
																			<br>


																			<div class="row-fluid">
																<table class="voucher-table">
																	<div class="row-fluid fieldHeading" > Fabrication </div>
																	<thead>
																		<tr>
																			<th style=" width: 10px; ">Sr#</th>
																			<th style=" width: 70px; text-align:left; ">Article#</th>


																			<th style=" width: 70px; text-align:left; ">Phase</th>
																			<th style=" width: 15px; " class=\'text-right\'>Qty</th>

																			<th style=" width: 30px; " class=\'text-right\'>DozenRate</th>

																			<th style=" width: 30px; ">PcsRate</th>

																			<th style=" width: 30px; " class=\'text-right\'>Amount</th>

																		</tr>
																	</thead>
																	<tbody>
																		';
$serial = 1;
$netrate = 0;
$netrate2=0;
$grossrate = 0;
$grossrate2=0;
$qtyGross=0;
$qtyNet=0;
$netWeight=0;
$netAmountFabrication=0;
$grAmount=0;
$preArticle="";
foreach ($vrdetailFabrication as $row):
if( $row['detype']=='fabrication'){
if($row['item_name_article'] !== $preArticle){
if($serial!=1){;echo '
																						<tr class="foot-comments">
																							<td colspan="3" class="subtotal bold-td text-right">Sub Total:</td>

																							<td class="subtotal bold-td text-right">';echo number_format($qtyGross,2);;echo '</td>
																							<td class=""></td>
																							<td class=""></td>
																							<td class="subtotal bold-td text-right">';echo number_format($grAmount,2);;echo '</td>

																						</tr>

																					';}
$qtyGross=0;
$grAmount=0;
$preArticle = $row['item_name_article'];
}
$qtyGross += abs($row['qty']);
$grAmount += $row['amount'];
$qtyNet += abs($row['qty']);
$netAmountFabrication += $row['amount'];
;echo '																				<tr  class="item-row">
																					<td class=\'text-left\'>';echo $serial++;;echo '</td>
																					<td class=\'text-left\'>';echo $row['item_name_article'];;echo '</td>
																					<td class=\'text-left\'>';echo $row['subphase_name'];;echo '</td>


																					<td class=\'text-right\'>';echo number_format(($row['qty']),2);;echo '</td>
																					<td class=\'text-right\'>';echo number_format(($row['rate']),2);;echo '</td>

																					<td class=\'text-right\'>';echo number_format(($row['rate2']),2);;echo '</td>
																					<td class=\'text-right\'>';echo number_format(($row['amount']),2);;echo '</td>
																				</tr>
																				';$serial+=1;}endforeach
;echo '
																				<tr class="foot-comments">
																					<td colspan="3" class="subtotal bold-td text-right">Sub Total:</td>

																					<td class="subtotal bold-td text-right">';echo number_format($qtyGross,2);;echo '</td>
																					<td class=""></td>
																					<td class=""></td>
																					<td class="subtotal bold-td text-right">';echo number_format($grAmount,2);;echo '</td>

																				</tbody>
																				<tfoot>
																					<tr class="foot-comments">
																						<td colspan="3" class="subtotal bold-td text-right">Grand Total:</td>

																						<td class="subtotal bold-td text-right">';echo number_format($qtyNet,2);;echo '</td>
																						<td class=""></td>
																						<td class=""></td>
																						<td class="subtotal bold-td text-right">';echo number_format($netAmountFabrication,2);;echo '</td>
																					</tfoot> 

																				</table>


																			</div>

																			<!-- End row-fluid -->
																			<br>
																			<br>

																			<div class="row-fluid">
																				<table class="voucher-table">
																					<div class="row-fluid fieldHeading" >ItemSummary </div>
																					<thead>
																						<tr>
																							<th style=" width: 10px; ">Sr#</th>
																							<th style=" width: 30px; text-align:left; ">Article</th>
																							<th style=" width: 100px; text-align:left; ">Description</th>
																							<th style=" width: 20px; ">Uom</th>
																							<th style=" width: 15px; " class=\'text-right\'>Qty</th>

																							<th style=" width: 30px; " class=\'text-right\'>Amount</th>
																						</tr>
																					</thead>
																					<tbody>
																						';
$serial = 1;
$netQty = 0;
$netAmountSummary=0;
$netWeight=0;
$grossQtyPacking=0;
$netAmountSummary=0;
$grAmountSummary=0;
$preArticle="";
foreach ($VoucherSummary as $row):
if($row['item_name_article'] !== $preArticle){
if($serial!=1){;echo '
																									<tr class="foot-comments">
																										<td class="subtotal bold-td text-right" colspan="4">Sub Total:</td>
																										<td class="subtotal bold-td text-right">';echo number_format($grossQtyPacking,0);;echo '</td>

																										<td class="subtotal bold-td text-right">';echo number_format($grAmountSummary,2);;echo '</td>
																									</tr>

																								';}
$grossQtyPacking=0;
$grAmountSummary=0;
$preArticle = $row['item_name_article'];
}
$netQty += abs($row['qty']);
$netAmountSummary += $row['amount'];
$grAmountSummary += $row['amount'];
$grossQtyPacking += abs($row['qty']);
;echo '																							<tr  class="item-row">
																								<td class=\'text-left\'>';echo $serial++;;echo '</td>
																								<td class=\'text-left\'>';echo $row['item_name_article'];;echo '</td>

																								<td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
																								<td class=\'text-centre\'>';echo $row['uom'];;echo '</td>

																								<td class=\'text-right\'>';echo number_format(abs($row['qty']),0);;echo '</td>

																								<td class="text-right">';echo number_format(($row['amount']),2);;echo '</td>
																							</tr>
																							';$serial+=1;endforeach
;echo '
																							<tr class="foot-comments">
																								<td class="subtotal bold-td text-right" colspan="4">Sub Total:</td>
																								<td class="subtotal bold-td text-right">';echo number_format($grossQtyPacking,0);;echo '</td>

																								<td class="subtotal bold-td text-right">';echo number_format($grAmountSummary,2);;echo '</td>
																							</tr>
																						</tbody>
																						<tfoot>
																							<tr class="foot-comments">
																								<td class="subtotal bold-td text-right" colspan="4">Grand Total:</td>
																								<td class="subtotal bold-td text-right">';echo number_format($netQty,0);;echo '</td>

																								<td class="subtotal bold-td text-right">';echo number_format($netAmountSummary,2);;echo '</td>
																							</tr>
																						</tfoot>

																					</table>
																				</div>

																				<br>
																				<br>

																				<div class="row-fluid">
																				<table class="voucher-table">
																					<div class="row-fluid fieldHeading" >ArticleSummary </div>
																					<thead>
																						<tr>
																							<th style=" width: 10px; ">Sr#</th>
																							<th style=" width: 30px; text-align:left; ">Article</th>
																							<th style=" width: 30px; text-align:right; ">Sale</th>
																							<th style=" width: 30px; ">Material</th>
																							<th style=" width: 30px; " class=\'text-right\'>Fabric</th>

																							<th style=" width: 30px; " class=\'text-right\'>Packing</th>
																							
																							<th style=" width: 30px; " class=\'text-right\'>Labour</th>
																							<th style=" width: 30px; " class=\'text-right\'>Embelishment</th>
																							<th style=" width: 30px; " class=\'text-right\'>Fabrication</th>

																							<th style=" width: 30px; " class=\'text-right\'>Profit</th>

																						</tr>
																					</thead>
																					<tbody>
																						';
$serial =1;
$sale = 0;
$material=0;
$fabric=0;
$labour=0;
$embelishment=0;
$fabrication=0;
$packing=0;
$profit=0;
foreach ($ArticleSummary as $row):
$sale += $row['sale_amount'];
$material += $row['material_amount'];
$fabric += $row['fabric_amount'];
$packing += $row['packing_amount'];
$labour += $row['labour_amount'];
$embelishment += $row['embelishment_amount'];
$fabrication += $row['fabrication_amount'];
$profit += $row['profit'];
;echo '																							<tr  class="item-row">
																								<td class=\'text-left\'>';echo $serial;;echo '</td>
																								<td class=\'text-left\'>';echo $row['short_code'];;echo '</td>

																								<td class=\'text-right\'>';echo number_format($row['sale_amount'],0) .'/'.number_format($row['sale_qty'],0) ;;echo '</td>
																								<td class=\'text-right\'>';echo number_format($row['material_amount'],0).'/'.number_format($row['material_qty'],0);;echo '</td>

																								<td class=\'text-right\'>';echo number_format($row['fabric_amount'],0).'/'.number_format($row['fabric_qty'],0);;echo '</td>

																								<td class="text-right">';echo number_format(($row['packing_amount']),0).'/'.number_format($row['packing_qty'],0);;echo '</td>

																								<td class="text-right">';echo number_format(($row['labour_amount']),0).'/'.number_format($row['labour_qty'],0);;echo '</td>
																								<td class="text-right">';echo number_format(($row['embelishment_amount']),0).'/'.number_format($row['embelishment_qty'],0);;echo '</td>

																								<td class="text-right">';echo number_format(($row['fabrication_amount']),0).'/'.number_format($row['fabrication_qty'],0);;echo '</td>

																								<td class="text-right">';echo number_format(($row['profit']),0);;echo '</td>
																							</tr>
																							';$serial+=1;endforeach
;echo '
																						</tbody>
																						<tfoot>
																							<tr class="foot-comments">
																								<td class="subtotal bold-td text-right" colspan="2">Total:</td>
																								<td class="subtotal bold-td text-right">';echo number_format($sale,0);;echo '</td>

																								<td class="subtotal bold-td text-right">';echo number_format($material,0);;echo '</td>
																								<td class="subtotal bold-td text-right">';echo number_format($fabric,0);;echo '</td>
																								<td class="subtotal bold-td text-right">';echo number_format($packing,0);;echo '</td>
																								<td class="subtotal bold-td text-right">';echo number_format($labour,0);;echo '</td>
																								<td class="subtotal bold-td text-right">';echo number_format($embelishment,0);;echo '</td>

																								<td class="subtotal bold-td text-right">';echo number_format($fabrication,0);;echo '</td>

																								<td class="subtotal bold-td text-right">';echo number_format($profit,0);;echo '</td>
																							</tr>
																						</tfoot>

																					</table>
																				</div>

																				<br>
																				<br>


																				<div class="row-fluid relative">
																					<div class="span12">
																						<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">
																							<p><span class="field">Order:</span><span class="fieldvalue inv-vrnoa">';echo number_format(($netAmount),2);;echo ' &nbsp $</span></p>									
																							<p><span class="field">Material:</span><span class="fieldvalue inv-date">';echo number_format(($netAmountMaterial),2);;echo ' &nbsp Rs</span></p>

																							<p><span class="field">Fabric:</span><span class="fieldvalue inv-date">';echo number_format(($netAmountFabric),2);;echo ' &nbsp Rs</span></p>

																							<p><span class="field">Packing:</span><span class="fieldvalue inv-vrnoa">';echo number_format(($netAmountPacking),2);;echo '&nbsp Rs</span></p>
																							<p><span class="field">Labour:</span><span class="fieldvalue cust-name">';echo number_format($netAmountLabour,0);;echo '&nbsp Rs</span></p>

																							<p><span class="field">Embelishment:</span><span class="fieldvalue cust-name">';echo number_format($netAmountEmbelishment,0);;echo '&nbsp Rs</span></p>

																							<p><span class="field">Fabrication:</span><span class="fieldvalue cust-name">';echo number_format($netAmountFabrication,0);;echo '&nbsp Rs</span></p>


																							<p><span class="field">Total:</span><span class="fieldvalue cust-mobile">';echo number_format(($netAmountPacking+$netAmountMaterial+$netAmountLabour+$netAmountEmbelishment+$netAmountFabrication+$netAmountFabric),2);;echo '&nbsp Rs</span></p>

																						</div>
																					</div>
																				</div>

																				<div class="row-fluid">
																					<div class="span12">
																						<table class="signature-fields">
																							<thead>
																								<tr>
																									<th>Approved By</th>
																									<td></td>
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