

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Fixed Footer</title>
	<style type="text/css">	
		* { margin: 5px; padding: 0; font-family: tahoma !important; }
			 body {  margin: 0 !important; font-size:8px !important; }

		* { margin: 5px; padding: 2px; font-family: tahoma !important; }
			 body {  margin: 0px !important; font-size:8px !important; }

			 p { margin: 0 !important; /* line-height: 17px !important; */ }
			 .field { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .field1 { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: collapse; }
			 table { width: 100% !important; border: 1px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:0px}
			 th {  padding: 5px !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child {  }
			 /*.voucher-table thead th {background: #ccc !important; } */
			 .voucher-table thead th {background: grey; } 
			 tfoot {border-top: 0px solid black !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 11px !important; border-top: 0px solid black !important; }
			 .invoice-type { border-bottom: 0px solid black !important; }
			 .relative { position: relative !important; }
			 .signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			 .signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			 .inv-leftblock { width: 280px !important; }
			 .text-left { text-align: left !important; }
			 .text-centre { text-align: center !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 9px !important; font-family: tahoma !important; line-height: 10px !important; padding: 4px !important; } 
			 
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {border: none !important; margin: 0px !important; position: relative !important; top: -1px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 10px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 10px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto; }
			 p { position: relative !important; font-size: 10px !important; }
			 thead th { font-size: 11px !important; color: black !important; font-weight: bold !important; padding: 10px !important; }
			 .fieldvalue { font-size:10px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .text-centre{text-align: center !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 10px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 0px solid black !important;}

			.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: -1px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.subtotalend { font-size: 10px !important; font-weight: bold !important;}
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 10px !important; font-weight: bold !important;text-align: right !important; color: red;}
			.newtbl tbody tr td{border:1px solid black !important;}
			.header_tbl{border: none !important; padding-left:0px !important; }
			.header{border: 1px solid black;}
			/*.voucher-table tbody tr td{border-right: 1px solid black !important; }
			.voucher-table tfoot tr td{border-right: 1px solid black !important; }*/
			/*.voucher-table{border: }*/
			.row-bank{width: 100%;}
			/*.bank_detail{width: 50%;border: 1px solid black;}*/
			.bank_detail{width: 50%;}

			/* Report Fixed Footer */

			
			.header{border:1px solid black;}
			.header-title{background-color: black;color: white;padding: 14px;}
			.voucher-table{margin-top: -30px;}
			/*#footerUpper{
				position:fixed;
				left:0px;
				bottom:0px;
				width:100%;
				background:white;
				line-height:30px;
				color:black;
				font-size:10px;
				line-height: 25px;
			}
			#footerUpper p{padding: 0px 0px 0px 0px;  }*/						tr { page-break-inside: avoid;	}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row-fluid" >
				<div class="span12 centered">
					<!--<div class="row-fluid">
						<div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>-->
						 <!-- <div class="span12"><h3 style="font-size: 16px !important; line-height: 24px !important;" > cf Gloves</h3></div> -->
					<!--</div>-->
					<div class="">
						<h3 class="invoice-type" style="text-align:center !important; font-size: 16px !important;" ><span class="header-title">PROFORMA INVOICE</span></h3>
					</div>
					';if ($header === 'header'):  ;echo '						<div class="row-fluid" style="margin-top: -52px;">
							<div class="span12 header">
								<table class="header_tbl">
									<thead>
										<tr>
											<th style=" width: 100px; text-align:left; font-size:12px !important;">Consignee:</th>
											<th></th>
											<th  ></th>
											<th ></th>
											<th style=" width: 120px; text-align:right; font-size:12px !important;padding-right:82px !important;">Pi# </th>
											<th style="text-align:left; font-size:11px;font-weight:normal !important;">';echo 'HE/'.$vrdetail[0]['vrnoa'] .'/'.substr($vrdetail[0]['vrdate'],2,2) .'/'.$vrdetail[0]['party_id'] ;;echo '</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style=" width: 220px; text-align:left; font-size:9px;padding-left:12px !important;" colspan="4"  rowspan="3">';echo $vrdetail[0]['party_name'] .'<br><br>'.nl2br( $vrdetail[0]['party_address'] );;echo '</td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;padding-left:18px !important;font-weight:bolder;" >Pi Date:</td>
											<td style="text-align:left;font-size:11px !important;font-weight:normal;padding-left:10px !important;">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</td>
										</tr>
										<tr>
											<td style=" width: 120px; text-align:left; font-size:12px !important;padding-left:18px !important;font-weight:bolder;" >Date:</td>
											<td style="text-align:left;font-size:11px !important;font-weight:normal;padding-left:10px !important;">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</td>
										</tr>
										<tr>
											<td style=" width: 120px; text-align:left; font-size:12px !important;padding-left:18px !important;font-weight:bolder;" >Payment Terms:</td>
											<td style="text-align:left;font-size:11px !important;font-weight:bolder;padding-left:10px !important;">';echo $vrdetail[0]['payment_term'];;echo '</td>
										</tr>
										
										<tr>
											<td style="text-align:left; " colspan="2">';
;echo '</td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Export Reg#:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['export_register_no'];;echo '</td>
										</tr>
										<tr>
											<td style="text-align:left; " colspan="2">';
;echo '</td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Delivery Term:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['delivery_term'];;echo '</td>
										</tr>
										<tr>
											<td style="text-align:left; " colspan="2">';
;echo '</td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Currency:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['currencey_name'];;echo '</td>
										</tr>
										
							
									</tbody>
								</table>
								
								<table class="header_tbl" style="margin-top: -60px;">
									<thead>
									</thead>
									<tbody>
										<tr>
											<td style=" width: 120px !important; text-align:left; font-size:12px !important;font-weight:bolder !important; ">Shipment By : </td>
											<td>';echo $vrdetail[0]['transporter_name'];;echo '</td>
											<td></td>								
											<td></td>								
											<td></td>								
											<td></td>								
										</tr>
										<tr>
											<td style=" width: 120px !important; text-align:left;font-size:12px !important;font-weight:bolder !important; ">Shipment From : </td>
											<td>';echo $vrdetail[0]['shippment_from'];;echo '</td>
											<td> </td>								
											<td></td>								
											<td ></td>								
											<td ></td>								
										</tr>
										<tr >
											<td style=" width: 100px !important; text-align:left; font-size:12px !important;font-weight:bolder !important; ">Shipment To : </td>
											<td colspan=\'5\' style=" width: 100px !important; text-align:left; font-size:9px; ">';echo $vrdetail[0]['shippment_to'];;echo '</td>
										</tr>
										<tr>
											<td style=" width: 120px !important; text-align:left;font-size:12px !important;font-weight:bolder !important; ">Shipment Date : </td>
											<td>';echo substr($vrdetail[0]['bilty_date'],0,10);;echo '</td>
											<td> </td>								
											<td></td>								
											<td ></td>								
											<td ></td>								
										</tr>
										<tr >
											<td colspan=\'1\' style="font-size:12px !important;font-weight:bolder !important;" class="text-left" >Remarks</td>								
											<td  colspan=\'5\' style="text-align:left;" >';echo $vrdetail[0]['remarks'];;echo '</td>							
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
						<!-- <div class="row-fluid">
							<div class="span12">
								<table class="header_tbl">
									<thead>
										<tr>
											<th style=" width: 100px; text-align:left; ">CONSIGNEE :</th>
											<td style=" width: 120px; text-align:left; "></td>
											<th style=" width: 200px; text-align:center;background-color:black;color:white !important; ">PROFORMA INVOICE</th>
											<th ></th>
											<th style=" width: 90px; text-align:right; font-size:9px;">PI# </th>
											<th style="text-align:left; font-size:9px !important;font-weight:normal !important;">';echo 'HE/'.$vrdetail[0]['vrnoa'] .'/'.substr($vrdetail[0]['vrdate'],2,2) .'/'.$vrdetail[0]['party_id'] ;;echo '</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style=" width: 220px; text-align:left; font-size:9px !important;" colspan="4">';echo $vrdetail[0]['party_name'];;echo '</td>
											<td style=" width: 90px; text-align:right; font-size:12px !important;font-weight:bolder !important;" >PI Date:</td>
											<td style="text-align:left;">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</td>
										</tr>
										<tr>
											<td style="text-align:left; " colspan="2">';print nl2br( $vrdetail[0]['party_address'] );;echo '</th>
											<td style=" width: 280px !important; font-size:12px !important;font-weight:bolder !important;" colspan="2">Shipment By :';echo $vrdetail[0]['transporter_name'];;echo '</td>
											<th style=" width: 90px; text-align:right; font-size:12px !important;font-weight:bolder !important;">Payment Terms:</th>
											<td style="text-align:left;">';echo $vrdetail[0]['payment_term'];;echo '</td>
										</tr>
							
									</tbody>
								</table>
								
								<table class="header_tbl">
									<thead>
									</thead>
									<tbody>
										<tr>
											<th style=" width: 120px !important; text-align:left; font-size:12px !important;font-weight:bolder !important;">Shipment From : </th>
											<td>';echo $vrdetail[0]['shippment_from'];;echo '</td>
											<th  style=" width: 120px !important; text-align:left; font-size:12px !important;font-weight:bolder !important;">To : </th>								
											<td style="text-align:left;" >';echo $vrdetail[0]['shippment_to'];;echo '</td>								
											<th style=" width: 160px; font-size:12px !important;font-weight:bolder !important;" class="text-left" >Export Reg#</th>								
											<td style="text-align:left;" >';echo $vrdetail[0]['export_register_no'];;echo '</td>								
										</tr>
										<tr>
											<td style=" width: 100px !important; text-align:left; font-size:12px !important;font-weight:bolder !important; ">Currency : </td>
											<td>';echo $vrdetail[0]['currencey_name'];;echo '</td>
											<td  style=" width: 120px !important; text-align:left; font-size:12px !important;font-weight:bolder !important;">Shipment Date:</td>								
											<td style="text-align:left;" >';echo substr($vrdetail[0]['bilty_date'],0,10);;echo '</td>								
											<td style=" width: 160px; font-size:12px !important;font-weight:bolder !important;" class="text-left" >Delivery Term:</td>								
											<td style="text-align:left;" >';echo $vrdetail[0]['delivery_term'];;echo '</td>								
										</tr>
										<tr>
											<td style=" width: 100px !important; text-align:left; font-size:12px !important;font-weight:bolder !important; ">Remarks : </td>
											<td colspan="5">';echo $vrdetail[0]['remarks'];;echo '</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div> -->
					';endif;;echo ' 
					<br>
					<br>
					<br>
					
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr style="">
									<!-- <th style=" width: 10px; " >Sr#</th> -->
									<th style=" width: 50px; text-align:left; color:white !important; ">Marks & Number</th>
									<th style=" width: 100px; text-align:left; color:white !important;">Description of goods</th>
									<th style=" width: 40px; color:white !important; " class=\'text-right\'>Dozen</th>
									<th style=" width: 30px; color:white !important; " class=\'text-right\'>CTN Qty</th>
									<th style=" width: 35px; color:white !important;" class=\'text-right\'>Dzn Price</th>
									<th style=" width: 30px; color:white !important;" class=\'text-right\'>Amount</th>
									<!-- <th style=" width: 30px; " class=\'text-right\'>Amount</th> -->
								</tr>
							</thead>

							<tbody>
								<tr  class="item-row">
									<td class=\'text-left\' colspan="">P.O: ';echo $vrdetail[0]['cpono'];;echo '</td>
									<td class=\'text-left\' colspan=""></td>
									<td class=\'text-left\' colspan=""></td>
									<td class=\'text-left\' colspan=""></td>
									<td class=\'text-left\' colspan=""></td>
									<td class=\'text-left\' colspan=""></td>
								</tr>
								
								';
$serial = 1;
$netCtn_Qty = 0;
$netAmount=0;
$netWeight=0;
$netCtn_Qty = 0;
$netDzn_Qty = 0;
$netAmount=0;
$netWeight=0;
$netRate = 0;
$typee='';
$typee22='';
foreach ($vrdetail as $row):
;echo '											
									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $row['artcile_no_cus'];;echo '</td>
									   <td class=\'text-left\'>';echo $row['item_desc_cus'];;echo '</td>
									   
									   <td class=\'text-right\'>';echo number_format(abs($row['dzn_qty']),2);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['ctn_qty']),2);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['frate']),3);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(($row['lprate_m']!=0 ?$row['amount']/$row['lprate_m']:$row['amount']),2) .' '.$vrdetail[0]['cur_symbol'];;echo '</td>
									   <!-- <td class="text-right">';echo number_format(($row['amount']),2);;echo '</td> -->
									</tr>
									
								';
$netCtn_Qty += abs($row['ctn_qty']);
$netDzn_Qty += abs($row['dzn_qty']);
$netRate += abs($row['rate']);
$netAmount += ($row['lprate_m']!=0 ?$row['amount']/$row['lprate_m']:$row['amount']);
$netWeight += abs($row['weight']);
endforeach;echo '							</tbody>
							<tfoot>
								<tr class="foot-comments">
									<td class="subtotalend bold-td" colspan="1">H.S Code No: 6116.9200</td>
									<td class="subtotalend bold-td text-right" colspan="1">Subtotal:</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netDzn_Qty,2);;echo '</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netCtn_Qty,2);;echo '</td>
									<td class="subtotalend bold-td text-right">';;echo '</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netAmount,2) .' '.$vrdetail[0]['cur_symbol'];;echo '</td>
									<!-- <td class="subtotalend bold-td text-right">';echo number_format($netAmount,2);;echo '</td> -->
								</tr>
								
								';if(intval($vrdetail[0]['discount'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="4">Discount:</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['discp']),2) .'% ';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['discount']),2);;echo '</td>
								</tr>
								';};echo '								';if(intval($vrdetail[0]['expense'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="4">Expense:</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['exppercent']),2) .'% ';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['expense']),2);;echo '</td>
								</tr>
								';};echo '								';if(intval($vrdetail[0]['tax'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="4">Tax:</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['taxpercent']),2) .'% ';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['tax']),2);;echo '</td>
								</tr>
								';};echo '								';if(intval($vrdetail[0]['paid'])!=0){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="4">Advance:</td>
									<td class="subtotal bold-td text-right">';;echo '</td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['paid']),2) .' '.$vrdetail[0]['cur_symbol'];;echo '</td>
								</tr>
								';};echo '								';if(!(intval($vrdetail[0]['tax'])==0 &&intval($vrdetail[0]['discount'])==0 &&intval($vrdetail[0]['expense'])==0 &&intval($vrdetail[0]['paid'])==0) ){;echo '								<tr>
									<td class="subtotal bold-td text-right discount-td " colspan="4">Net Amount:</td>
									<td class="subtotal add-lower text-right"></td>
									<td class="subtotal bold-td text-right">';echo number_format(($vrdetail[0]['namount']),2) .' '.$vrdetail[0]['cur_symbol'];;echo '</td>
								</tr>
								';};echo '

							</tfoot>
						</table>
					</div>
					<!-- <div class="row-fluid">
						<div class="span12 add-on-detail1" style="margin-top: 10px;">
							<p class="" style="text-transform1: uppercase;">
								<strong>In words: </strong> <span class="inwords"></span>';echo strtoupper($amtInWords);;echo ' &nbsp; ONLY <br>
								<br>
								';if ( $pre_bal_print==1  ){;echo '									<p><span class="field1">Previous Balance:</span><span class="fieldvalue inv-vrnoa">';echo number_format($previousBalance,0);;echo '</span></p>
									<p><span class="field1">This Invoice:</span><span class="fieldvalue inv-date">';echo number_format($vrdetail[0]['namount'],0);;echo '</span></p>
									<p><span class="field1">Current Balance:</span><span class="fieldvalue cust-name">';echo number_format($vrdetail[0]['namount']+$previousBalance,2) ;;echo '</span></p>
								';};;echo '							</p>
						</div>
					</div> -->
					<!-- End row-fluid -->
                    <table style="border-color: transparent !important; height: 100px;">
                        <tr>
                            <td>
                                <div class="row-bank">
                                    <div class="bank_detail">
                                        <p>';print nl2br( $vrdetail[0]['bank_detail'] );;echo '</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
				</div>
			</div>
			
			<!-- <div id="footer1">
		    	<div class="span12">
					<table class="signature-fields">
						<thead>
							<tr>
								<th>Buyer Signature</th>
								<td></td>
								<th>Seller Signature</th>
							</tr>
						</thead>
					</table>
				</div>
			</div> -->
<!-- 
			<div id="footer">
		    	<div class="span12">
					<table class="signature-fields">
						<thead>
							<tr>
								<th>';echo $vrdetail[0]['party_name'];;echo '</th>
								<td></td>
								<th>CHINIOT FABRICS</th>
							</tr>
						</thead>
					</table>
				</div>
		    	<p class="text-centre">';print nl2br( $vrdetail[0]['foot_note'] );;echo '</p><br>
		    	<span class="loggedin_name">User:';echo $user;;echo '</span>
			</div> -->

		</div>
   <!--  <div class="" id="footerUpper">
    		
    </div> -->
    
    
	</body>
</html>';
?>