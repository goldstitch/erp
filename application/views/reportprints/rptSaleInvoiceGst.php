

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
			 thead th { font-size: 10px !important; font-weight: bold !important; padding: 10px !important; }
			 .fieldvalue { font-size:12px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 10px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			.signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.subtotalend { font-size: 10px !important; font-weight: bold !important;text-align: right !important; }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 10px !important; font-weight: bold !important;text-align: right !important; color: red;}
			.suplier-buyer{width: 100%;display: inline-block;border: 0px solid black;}
			.supplier{width: 50%;float: left !important;}
			.buyer{width: 50%;float: left !important; }
			.supplier-table{width: 100%;border-collapse: none !important;border: 1px solid black;}
			.buyer-table{width: 10%;border-collapse: none !important;border: 1px solid black;}
			table{border: 1px solid black;}
             tr { page-break-inside: avoid;	}
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					<div class="row-fluid">
						<div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>
					</div>
					<div class="row-fluid">
						<h3 class="invoice-type text-right" style="text-transform:capitalize; border:none !important; margin: 0px !important; position: relative; top: 12px !important; ">';echo $etype .' Tax Invoice';;echo '</h3>
					</div>
				<!-- 	<div class="row-fluid relative">
						<div class="span12">
								<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">
									<p><span class="field">Invoice#</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['vrnoa'];;echo '</span></p>									
									<p><span class="field">Date:</span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</span></p>
									<p><span class="field ">Customer:</span><span class="fieldvalue cust-name">';echo $vrdetail[0]['party_name'];;echo '</span></p>
									<p><span class="field">WO#</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['workorderno'];;echo '</span></p>
									<p><span class="field">Remarks:</span><span class="fieldvalue cust-mobile">';echo $vrdetail[0]['remarks'];;echo '</span></p>
									
								</div>
								<div class="block pull-right" style="width:280px !important; float: right; display:inline !important;">
									<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative; top: 12px !important; ">';echo $title;;echo '</h3>
								</div>
						</div>
					</div> -->
					<div class="row">
						<table class="header-table">
							<thead>
								<tr style="color:black !important;border:1px solid white; ">
									<th class="text-left" style=" width: 9px; " >Invoice#</th>
									<th class="text-left font-normal" style=" width: 20px; " >';echo $vrdetail[0]['vrno'];;echo '</th>
									<th class="text-left" style=" width: 9px; ">Date</th>
									<th class="text-left font-normal" style=" width: 20px; text-align:left; ">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</th>
									<th class="text-left" style=" width: 20px; ">WO#</th>
									<th class="text-left font-normal" style=" width: 20px; text-align:left; ">';echo $vrdetail[0]['workorderno'];;echo '</th>
								</tr>
							</thead>

							<tbody>
								
								
									<tr  class="item-row">
									  
									</tr>
							
							</tbody>
							
						</table>
					</div>
					<div class="suplier-buyer">
					    <div class="supplier">
					        <table class="supplier-table">
					           <col style="width:10%">
					           <col style="width:30%">
					            <thead>
					                <tr style="">
					                    <th class="text-center" style="" colspan="2" >Supplier Name & Address</th>
					                    
					            
					                </tr>
					            </thead>

					            <tbody>
					                

					                ';
foreach ($vrdetail as $row):
;echo '					                    <tr  class="item-row">
					                       <td class=\'text-left bold-td\' style="width:5px;"> Company</td>
					                       <td class=\'text-left\'>';echo $row['company_name'];;echo '</td>
					                    </tr>
					                    <tr  class="item-row">
					                       <td class=\'text-left bold-td\'>Address</td>
					                       <td class=\'text-left\'>';echo $row['comp_address'];;echo '</td>
					                    </tr>
					                    <tr  class="item-row">
					                       <td class=\'text-left bold-td\'>Contact</td>
					                       <td class=\'text-left\'>';echo $row['comp_contact'];;echo '</td>
					                    </tr>
					                    <tr  class="item-row">
					                       <td class=\'text-left bold-td\'>STRN:</td>
					                       <td class=\'text-left\'>';echo $row['comp_strn'];;echo '</td>
					                    </tr>
					                    <tr  class="item-row">
					                       <td class=\'text-left bold-td\'>NTN:</td>
					                       <td class="text-left">';echo $row['comp_ntn'];;echo '</td>
					                    </tr>
					                ';
break;
endforeach;echo '					            </tbody>
					    
					        </table>
					    </div>
					    <div class="buyer">
					            <table class="buyer-table">
					                    <col style="width:10%">
					                    <col style="width:30%">
					                <thead>
					                    <tr style="">
					                        <th class="text-center" style="" colspan="2" >Buyers Name & Address</th>
					                        
					                
					                    </tr>
					                </thead>

					                <tbody>
					                    

					                    ';
foreach ($vrdetail as $row):
;echo '					                        <tr  class="item-row">
					                           <td class=\'text-left bold-td\' style="width:5px;"> M/S</td>
					                           <td class=\'text-left\'>';echo $row['party_name'];;echo '</td>
					                        </tr>
					                        <tr  class="item-row">
					                           <td class=\'text-left bold-td\'>Address</td>
					                           <td class=\'text-left\'>';echo $row['party_address'];;echo '</td>
					                        </tr>
					                        <tr  class="item-row">
					                           <td class=\'text-left bold-td\'>Phone#</td>
					                           <td class=\'text-left\'>';echo $row['party_phone'];;echo '</td>
					                        </tr>
					                        <tr  class="item-row">
					                           <td class=\'text-left bold-td\'>STRN:</td>
					                           <td class=\'text-left\'>';echo $row['party_strn'];;echo '</td>
					                        </tr>
					                        <tr  class="item-row">
					                           <td class=\'text-left bold-td\'>NTN:</td>
					                           <td class="text-left">';echo $row['party_ntn'];;echo '</td>
					                        </tr>
					                    ';
break;
endforeach;echo '					                </tbody>
					        
					            </table>
					    </div>
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
									<th style=" width: 30px; " class=\'text-right\'>Qty</th>
									<!-- <th style=" width: 18px; " class=\'text-right\'>Weight</th> -->
									<th style=" width: 15px; " class=\'text-right\'>Rate</th>
									<th style=" width: 30px; " class=\'text-right\'>Exl Amount</th>

									<th style=" width: 18px; " class=\'text-right\'>Gst%</th>
									<th style=" width: 15px; " class=\'text-right\'>Gst Value</th>
									<th style=" width: 30px; " class=\'text-right\'>Inc Amount</th>

								</tr>
							</thead>

							<tbody>
								
								';
$serial = 1;
$netQty = 0;
$netAmount=0;
$netWeight=0;
$netAmountInc=0;
$netGst=0;
$typee='';
$typee22='';
foreach ($vrdetail as $row):
;echo '									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
									   <td class=\'text-left\'>';echo $row['item_name'];;echo '</td>
									   <td class=\'text-centre\'>';echo $row['uom'];;echo '</td>
									   <td class=\'text-right\'>';echo ($row['uom']=='dozen'?number_format(abs($row['qty']/12),2):number_format(abs($row['qty']),0));;echo '</td>
									   <!-- // <td class=\'text-right\'>';echo number_format(abs($row['weight']),2);;echo '</td> -->
									   <td class=\'text-right\'>';echo number_format(($row['rate']),2);;echo '</td>
									   <td class="text-right">';echo number_format(($row['amount']),2);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['gstrate']),2);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(($row['gstamount']),2);;echo '</td>
									   <td class="text-right">';echo number_format(($row['netamount_d']),2);;echo '</td>
									</tr>
								';
$netQty += abs($row['qty']);
$netAmount += $row['amount'];
$netWeight += abs($row['weight']);
$netGst += $row['gstamount'];
$netAmountInc+= abs($row['netamount_d']);
endforeach;echo '							</tbody>
							<tfoot>
								<tr class="foot-comments">
									<td class="subtotalend bold-td text-right" colspan="3">Subtotal:</td>
									<td class="subtotalend bold-td text-right">';number_format($netQty,0);;echo '</td>
									<!-- <td class="subtotalend bold-td text-right">';echo number_format($netWeight,2);;echo '</td> -->
									<td class="subtotalend bold-td text-right"></td>
									<td class="subtotalend bold-td text-right">';echo number_format($netAmount,2);;echo '</td>
									<td class="subtotalend bold-td text-right"></td>
									<td class="subtotalend bold-td text-right">';echo number_format($netGst,2);;echo '</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netAmountInc,2);;echo '</td>
								</tr>
								
								';if(intval($vrdetail[0]['discount'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="7">Discount:</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['discp']),2) .'% ';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['discount']),2);;echo '</td>
								</tr>
								';};echo '								';if(intval($vrdetail[0]['expense'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="7">Expense:</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['exppercent']),2) .'% ';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['expense']),2);;echo '</td>
								</tr>
								';};echo '								';if(intval($vrdetail[0]['tax'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="7">Further Tax:</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['taxpercent']),2) .'% ';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['tax']),2);;echo '</td>
								</tr>
								';};echo '								';if(!(intval($vrdetail[0]['tax'])==0 &&intval($vrdetail[0]['discount'])==0 &&intval($vrdetail[0]['expense'])==0 &&intval($vrdetail[0]['paid'])==0) ){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="7">NetAmount:</td>
									<td class="subtotal add-lower text-right"></td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['namount']),2);;echo '</td>
								</tr>
								';};echo '

							</tfoot>
						</table>
					</div>
					<div class="row-fluid">
						<div class="span12 add-on-detail1" style="margin-top: 10px;">
							<p class="" style="text-transform1: uppercase;">
								<strong>In words: </strong> <span class="inwords"></span>';echo strtoupper($amtInWords);;echo ' &nbsp; ONLY/- <br>
								<br>
								';if ( $pre_bal_print==1  ){;echo '									<p><span class="field1">Previous Balance:</span><span class="fieldvalue inv-vrnoa">';echo number_format($previousBalance,0);;echo '</span></p>
									<p><span class="field1">This Invoice:</span><span class="fieldvalue inv-date">';echo number_format($vrdetail[0]['namount'],0);;echo '</span></p>
									<p><span class="field1">Current Balance:</span><span class="fieldvalue cust-name">';echo number_format($vrdetail[0]['namount']+$previousBalance,2) ;;echo '</span></p>
								';};;echo '							</p>
						</div>
					</div>
					<br>
					<br>
					<div class="row-fluid">
						<div class="span12 add-on-detail1" style="margin-top: 10px;">
							<p class="" style="text-transform1: uppercase;">
									<p><span class="field1">Remarks:</span><span class="fieldvalue inv-vrnoa">';echo $vrdetail[0]['remarks'];;echo '</span></p>
							</p>
						</div>
					</div>
					<!-- End row-fluid -->
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<div class="row-fluid">
						<div class="span12">
							<table class="signature-fields">
								<thead>
									<tr>
										<td></td>
										<td></td>
										<th>Authorised Signature</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<table class="signature-fields">
								<thead>
									<tr>
										<td></td>
										<td></td>
										<td style="text-align:center; font-size:18px;font-weight:bold;">For CHINIOT FABRICS</td>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<!--<div class="row-fluid">
						<p>
							 <span class="footer_company">User:';echo $user;;echo '</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<span class="footer_company">, Unit:';echo $this->session->userdata('company_name');;echo '</span> 
							 <span class="footer_company">Sofware By: www.alnaharsolution.com</span> 
						</p>
					</div>-->
				</div>
			</div>
		</div>
	</body>
	</html>';
?>