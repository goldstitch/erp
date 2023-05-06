

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

	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">


	<style type="text/css">	
		* { margin: 0; padding: 2px; font-family: tahoma !important; }
			 body { font-size:8px !important; margin-top: 0px; }
			 p { margin: 0 !important; /* line-height: 17px !important; */ }
			 .field { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .field1 { font-size:10px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: collapse; }
			 table { width: 100% !important; border: 1px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:0px}
			 th {  padding: 0px !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child {  }
			 /*.voucher-table thead th {background: #ccc !important; } */
			 .voucher-table thead th {background: grey;} 
			 tfoot {border-top: 0px solid black !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 11px !important; border-top: 0px solid black !important; }
			 
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
			 
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 10px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 10px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto; }
			 p { position: relative !important; font-size: 10px !important; }
			 thead th { font-size: 11px !important; color: black !important; font-weight: bold !important; padding: 10px !important; }
			 .headerrr td{background: grey; font-size: 11px !important; color: black !important; font-weight: bold !important; padding: 10px !important; padding-top: 15px !important; padding-bottom: 15px !important; color:white !important; }
			 .fieldvalue { font-size:10px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .text-centre{text-align: center !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 10px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 0px solid black !important;}

			/*.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }*/
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: -1px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.subtotalend { font-size: 10px !important; font-weight: bold !important; }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 10px !important; font-weight: bold !important;text-align: right !important; color: red;}
			.newtbl tbody tr td{border:1px solid black !important;}
			.header_tbl{border: none !important; padding-left:0px !important; }
			.header{border: 1px solid black;}
			/*.voucher-table tbody tr td{border-right: 1px solid black !important; }
			.voucher-table tfoot tr td{border-right: 1px solid black !important; }*/
			.voucher-table{margin-top: -30px !important;  }
			.voucher-table thead tr td{border:1px solid black;}
			.row-bank{width: 100%;}
			/*.bank_detail{width: 50%;border: 1px solid black;}*/
			.bank_detail{width: 50%;}

			/* Report Fixed Footer */
			#footer{
				position:fixed;
				left:0px;
				bottom:0px;
				margin-top: 950px;
				width:100%;
				background:white;
				line-height:30px;
				color:black;
				font-size:8px;
			}
			#footer span{padding-left:20px;}
			#footer p{padding: 0px 0px 0px 0px;  }
			.header{border:1px solid black;}
			.header-title{background-color: black;color: white;padding: 14px;}
			.bod-cr tr td{border:1px solid black;}
			

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
			#footerUpper p{padding: 0px 0px 0px 0px;  }*/
			tr { page-break-inside: avoid;	}
			.foo-cer{
				font-size: 10px;
				font-weight: bold;
				
			}
			.bod-cr tr th{
				border:1px solid black;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid" >
			<div class="row-fluid" >
				<div class="span12 centered">
					<!--<div class="row-fluid">
						<div class="span12"><img class="rcpt-header" src="';
;echo '" alt=""></div>-->
						 <!-- <div class="span12"><h3 style="font-size: 16px !important; line-height: 24px !important;" > cf Gloves</h3></div> -->
					<!--</div>-->
					<div class="">
						<h3 class="invoice-type" style="text-align:center !important; font-size: 16px !important;" ><span class="header-title">COMERCIAL INVOICE</span></h3>
					</div>
					';if ($title != ''):  ;echo '						<div class="row-fluid" style="margin-top: -41px;margin-bottom:-5px;border-top:1px solid black;">
							<div class="span12 header">
								<table class="header_tbl">
									<thead>
										<tr>
											<th style=" width: 100px; text-align:left; font-size:12px !important;">Consignee:</th>
											<th></th>
											<th  ></th>
											<th ></th>
											<th style=" width: 120px; text-align:right; font-size:12px !important;padding-right:87px !important;">PL </th>
											<th style="text-align:left; font-size:11px;font-weight:normal !important;padding-left:3px !important;">';
;echo '</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style=" width: 220px; text-align:left; font-size:9px;" colspan="4"  rowspan="3">';echo $vrdetail[0]['party_name'] ."<br/><br/>".nl2br( $vrdetail[0]['party_address'] );;echo '</td>
											<td style="width: 120px; text-align:left; font-size:12px !important;padding-left:18px !important;font-weight:bolder;" >Date:</td>
											<td style="text-align:left;font-size:11px !important;font-weight:normal;padding-left:3px !important;">';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</td>
										</tr>
										<tr>
											<td style=" width: 120px !important; text-align:left; font-size:12px !important;padding-left:18px !important;font-weight:bolder;" >E Form No:</td>
											<td>';echo $vrdetail[0]['eform_no'];;echo '</td>
										</tr>
										<tr>
											<td style=" width: 120px; text-align:left; font-size:12px !important;padding-left:18px !important;font-weight:bolder;" >Date:</td>
											<td style="text-align:left;font-size:11px !important;font-weight:normal;padding-left:3px !important;">';echo (substr($vrdetail[0]['edate'],0,10)=="0000-00-00"?"": substr($vrdetail[0]['edate'],0,10));;echo '</td>
										</tr>
										<tr>
											<td style="text-align:left; " colspan="2"></td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Payment Terms:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['payment_term'];;echo '</td>
										</tr>
										<!--  -->
										<tr>
											<td style="text-align:left; " colspan="2"></td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Shipment Term:</td>
											<td style="text-align:left;" style="font-size:18px !important;">';echo $vrdetail[0]['delivery_term'];;echo '</td>
										</tr>
										<tr>
											<td style=" width: 120px !important; text-align:left;font-size:12px !important;font-weight:bolder !important; " colspan="2">NOTIFY PARTY</td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Shipment By:</td>
											<td style="text-align:left;" style="font-size:18px !important;">';echo $vrdetail[0]['transporter_name'];;echo '</td>
										</tr>
										<!--  -->
										<tr>
											<td style="text-align:left; " colspan="2">';
;echo '</td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Shipment From:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['shippment_from'];;echo '</td>
										</tr>
										<tr>
											<td style="text-align:left; " colspan="2">';
;echo '</td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Port of Discharge:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['port_of_discharge'];;echo '</td>
										</tr>
							
									</tbody>
								</table>
								
								<table class="header_tbl">
									<thead>
									</thead>
									<tbody>
										<tr>
											<td style=" width: 120px !important; text-align:left;font-size:12px !important;font-weight:bolder !important; "></td>
											<td>';
;echo '</td>
											<td> </td>								
											<td></td>								
											<td ></td>								
											<td ></td>								
										</tr>
										
									</tbody>
								</table>
								<table class="header_tbl">
									<thead>
									</thead>
									<tbody>
										<tr>
											<td style=" width: 200px !important; text-align:right;font-size:12px !important;font-weight:bolder !important; ">Export Registration No: ';echo $vrdetail[0]['export_register_no'];;echo '</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
					';endif;;echo ' 
					<br>
					<br>
					<br>
					<div class="row-fluid">
						<table class="voucher-table">
							<thead style="clear: both !important;" class=\'bod-cr\'>
								<tr >
									<th style=" width: 50px; text-align:left; color:white !important; ">Marks & Numbers</th>
									<th style=" width: 100px; text-align:left; color:white !important;">Description of Goods</th>
									<th style=" width: 40px; color:white !important; " class=\'text-right\'>DPR</th>
									<!--<th style=" width: 30px; color:white !important; " class=\'text-right\'>Qty</th>--> 
									<th style=" width: 30px; color:white !important; " class=\'text-right\'>CTN</th>
									<th style=" width: 35px; color:white !important;" class=\'text-right\'>USD/FOB</th>
									<th style=" width: 40px; color:white !important;" class=\'text-right\'>Amount USD FOB</th>
									<!-- <th style=" width: 30px; " class=\'text-right\'>Amount</th> -->
								</tr>
							<!-- </thead> -->
							</thead>
							<tbody class=\'bod-cr\'>
								';
$serial = 1;
$netCtn = 0;
$netUSD = 0;
;echo '							';foreach ($vrdetail as $data ) {;echo '								<tr>
									<td><b>PO:</b>';echo $data['po'];;echo '<br> <b>Qty:</b>';echo abs($data['qty']);;echo ' </td>
									<td><b>';echo $data['ctn_qty'];;echo ' CTN CONTAINS</b> <br> ';echo $data['item_name'];;echo ' </td>
									<td></td>
									<td class=\'text-right\'>';echo $data['ctn_qty'];;echo '</td>
									<td class=\'text-right\'>';echo $data['frate'];;echo '</td>
									<td class=\'text-right\'>';echo $data['amount'];;echo '</td>
								</tr>

							';
$netUSD += abs($data['amount']);
$netCtn += abs($data['ctn_qty']);
};echo '							</tbody>
							<tfoot class=\'bod-cr\'>
								<tr class="foot-comments1">
									<td class="subtotalend bold-td" colspan="2"></td>
									<td class="subtotalend bold-td text-right">';
;echo '</td>
									<!-- <td class="subtotalend bold-td text-right">';
;echo '</td> -->
									<td class="subtotalend bold-td text-right">';echo number_format($netCtn,0);;echo '</td>
									<td class="subtotalend bold-td" style="text-align:right;">Total USD FOB';;echo '</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netUSD,2);;echo '</td>
									<!-- <td class="subtotalend bold-td text-right">';
;echo '</td> -->
								</tr>
								
								

								</tfoot>
						</table>
					</div>
					
					
					<span class=\'foo-cer\'>IT IS CERTIFIED THAT THE GOODS ARE OF <BR> ';echo $data['made_in'];;echo ' ORIGIN</span>
                    <table style="border-color: transparent !important;  height: 100px;">
                        <tr>
                            <td>
                                <div class="row-bank">
                                    <div class="bank_detail">
                                        <p>';
;echo '</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

					
				</div>
			</div>
			
			

		</div>
   <!--  <div class="" id="footerUpper">
    		
    </div> -->
    
    
	</body>
</html>
';
?>