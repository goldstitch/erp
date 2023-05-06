

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
	table { width: 100% !important; border: 1px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
	th {  padding: 5px !important;  border-left: 1px solid black !important; line-height: 12px !important;}
	td { /*text-align: center !important;*/ vertical-align: top !important;  }
	td:first-child { text-align: left !important; }
	.voucher-table thead th {background: #ccc !important; } 
	tfoot {border-top: 1px solid black !important; } 
	.bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
	.nettotal { font-weight: bold !important; font-size: 9px !important; border-top: 1px solid black !important; }
	.invoice-type { border-bottom: 1px solid black !important; }
	.relative { position: relative !important; }
	.signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
	.signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
	.inv-leftblock { width: 280px !important; }
	.text-left { text-align: left !important; }
	.text-right { text-align: right !important; }
	td {font-size: 10px !important; font-family: tahoma !important; line-height: 12px !important; padding: 4px !important; } 
	.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
	.inwords, .remBalInWords { text-transform: uppercase !important; }
	.barcode { margin: auto !important; }
	h3.invoice-type {font-size: 16px !important; line-height: 40px !important;}
	

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
	.item-row td { font-size: 10px !important; padding: 10px !important; border-top: 1px solid black !important; border-left: 1px solid black !important; line-height: 12px !important;}
	.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 1px solid black !important;}


	h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
	tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
	.nettotal, .subtotal, .vrqty,.vrweight { font-size: 10px !important; font-weight: bold !important;}
	tr{ page-break-inside: avoid;}

	tfoot { display: table-row-group }
	.foot-total td { border-top: 1px solid !important;border-left: 1px solid !important;font-weight: bold !important; line-height: 8px !important;}
	.txtbold{font-weight: bold !important;}

	.text-center{text-align: center !important;}

</style>
</head>
<body>
	<div class="container-fluid" style="">
		<div class="row-fluid">
			<div class="span12 centered">
				<div class="row-fluid">
					<div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>

				</div>
				<div class="" style="width:280px !important; float: center; display:inline !important;">
					<h3 class="invoice-type text-center" style="border:none !important; margin: 0px !important; position: relative; top: 0px !important; font-size:20px !important; ">';echo $title;;echo '</h3>
				</div>

				<div class="row-fluid relative">
					<div class="span12">


						<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">

							<table class="voucher-table">


								<tbody>


									<tr  class="item-row">
										<td class=\'text-left txtbold\' width="10">Vr#</td>
										<td class=\'text-left\' width="20">';echo $vrdetail[0]['vrnoa'];;echo '</td>
										<td class=\'text-left txtbold\' width="5">Date:</td>
										<td class=\'text-right\' width="10">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</td>
										<td class=\'text-left txtbold\' width="10">WorkOrder#</td>
										<td class=\'text-left\' width="50">';echo $vrdetail[0]['worder'];;echo '</td>
										
									</tr>

									<tr  class="item-row">
										<td class=\'text-left txtbold\'>Party Name:</td>
										<td colspan="3" class=\'text-left\'>';echo $vrdetail[0]['partyname'];;echo '</td>
										
										<td class=\'text-left txtbold\'>Remarks:</td>
										<td class=\'text-left\'>';echo $vrdetail[0]['remarks'];;echo '</td>
										
									</tr>
									

									
								</tbody>
								
							</table>

						</div>
						
					</div>
				</div>
				<br>
				

				


				<div class="row-fluid">
					<table class="voucher-table">
						<div class="row-fluid fieldHeading" > Fabric Detail </div>
						<thead>
							<tr>
								<th style=" width: 10px; ">Sr#</th>
								<th style=" width: 100px; text-align:left; ">Fabric</th>
								<th style=" width: 20px; text-align:left; ">Gsm</th>
								<th style=" width: 20px; text-align:left; ">Width</th>

								<th style=" width: 15px; " class=\'text-right\'>Gross Kg</th>
								<th style=" width: 20px; " class="text-left">Net/Pc</th>
								<th style=" width: 20px; " class="text-left">Wastage%</th>
								<th style=" width: 20px; " class="text-left">Gross/Pc</th>

								<th style=" width: 30px; " class="text-left">Used For</th>
								

								
								
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
											<tr class="foot-total">
												<td class="subtotal bold-td text-right" colspan="4">Sub Total:</td>
												

												<td class="subtotal bold-td text-right">';echo number_format($grossQtyFabrics,2);;echo '</td>
												<td class="subtotal bold-td text-right" colspan="4"></td>
												
											</tr>

										';}
$grossQtyFabrics=0;
$grAmountFabrics=0;;echo '
										<tr class="foot-total">
											<td class="subtotal bold-td text-left" colspan="9">';echo $row['item_name_article'];echo '</td>
										</tr>
										';
$preArticle = $row['item_name_article'];
}
$netQty += abs($row['qtyfabric']);
$grossQtyFabrics += abs($row['qtyfabric']);
;echo '									<tr  class="item-row">
										<td class=\'text-left\'>';echo $serial++;;echo '</td>
										
										
										<td class=\'text-left\'>';echo $row['fabric_name'];;echo '</td>
										<td class=\'text-left\'>';echo $row['gsm'];;echo '</td>
										<td class=\'text-left\'>';echo $row['width'];;echo '</td>

										<td class=\'text-right\'>';echo number_format(abs($row['qtyfabric']),2);;echo '</td>
										<td class=\'text-left\'>';echo $row['qtyf'];;echo '</td>
										<td class=\'text-left\'>';echo $row['rate2'];;echo '</td>
										<td class=\'text-left\'>';echo $row['qtyf'] +($row['qtyf'] * $row['rate2']/100) ;;echo '</td>
										<td class=\'text-left\'>';echo $row['used_for'];;echo '</td>
										

										
										
									</tr>
									';$serial+=1;}endforeach
;echo '
									<tr class="foot-total">
										<td class="subtotal bold-td text-right" colspan="4">Sub Total:</td>


										<td class="subtotal bold-td text-right">';echo number_format($grossQtyFabrics,2);;echo '</td>
										<td class="subtotal bold-td text-right" colspan="4"></td>
										
									</tr>
								</tbody>
								<tfoot>
									<tr class="foot-total">
										<td class="subtotal bold-td text-right" colspan="4">Grand Total:</td>
										<td class="subtotal bold-td text-right">';echo number_format($netQty,2);;echo '</td>
										<td class="subtotal bold-td text-right" colspan="4"></td>
										
									</tr>
								</tfoot>
							</table>
						</div>
						<br>
						

						<div class="row-fluid">

							<table style="border:none !important; width:100% !important; border: none !important; ">
					<tbody>
						<th class="text-left" style=" width: 500px;border: none !important; ">Fabric Composition Detail</th>
						<th class="text-left" style=" width: 300px; border: none !important;">Yarn Detail</th>
						<tr>
							<td>

						

								<table class="voucher-table" style="width: 100% !important;">
									
									

									<thead>
										<tr>
											<th style=" width: 10px; ">Sr#</th>
											<th style=" width: 100px; text-align:left; ">Fabric</th>
											<th style=" width: 200px; text-align:left; ">Yarn Detail</th>
											<th style=" width: 30px; " class="text-right">Tot Bag</th>
											
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
foreach ($FabricYarnSummary as $row):
$netQty += abs($row['qty']);
;echo '											<tr  class="item-row">
												<td class=\'text-left\'>';echo $serial++;;echo '</td>
												<td class=\'text-left\'>';echo $row['fabric_name'];;echo '</td>
												<td class=\'text-left\'>';echo $row['yarn_name'];;echo '</td>
												<td class=\'text-right\'>';echo number_format(abs($row['qty']),2);;echo '</td>
											</tr>
											';$serial+=1;endforeach 
;echo '
										</tbody>
										<tfoot>
											<tr class="foot-total">
												<td class="subtotal bold-td text-right" colspan="3">Grand Total:</td>
												<td class="subtotal bold-td text-right">';echo number_format($netQty,2);;echo '</td>

											</tr>
										</tfoot>
									</table>
								</div>
									
									</td>
						<td>

									<table class="voucher-table" style="width: 100% !important;">
										
										<thead>
											<tr>
												<th style=" width: 10px; ">Sr#</th>
												<th style=" width: 100px; text-align:left; ">Yarn</th>
												<th style=" width: 20px; " class="text-right">Bag</th>

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
foreach ($YarnSummary as $row):
$netQty += abs($row['qty']);
;echo '												<tr  class="item-row">
													<td class=\'text-left\'>';echo $serial++;;echo '</td>
													<td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
													<td class=\'text-right\'>';echo number_format(abs($row['qty']),2);;echo '</td>
												</tr>
												';$serial+=1;endforeach 
;echo '
											</tbody>
											<tfoot>
												<tr class="foot-total">
													<td class="subtotal bold-td text-right" colspan="2">Grand Total:</td>
													<td class="subtotal bold-td text-right">';echo number_format($netQty,2);;echo '</td>

												</tr>
											</tfoot>
										</table>
									</td>
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
													<th>Prepared By</th>
													<th>Approved By</th>
													<th>Checked By</td>
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

										</p>
									</div>
								</div>
							</div>
						</div>
					</body>
					</html>';
?>