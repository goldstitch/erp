

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
			/*.voucher-table thead tr td{border:1px solid black;}*/
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

			tr { page-break-inside: avoid;	}
			.foo-cer{
				font-size: 10px;
				font-weight: bold;
				
			}
            .voucher-table thead tr td{
				border:1px solid black;
			}
            .voucher-table thead tr th{
				border:1px solid black;
			}
            .voucher-table tfoot tr td{
                border:1px solid black;
            }
		</style>
	</head>
	<body>
		<div class="container-fluid" >
			<div class="row-fluid" >
				<div class="span12 centered">
					<!-- <div class="row-fluid">
						<div class="span12"><img class="rcpt-header" src="';
;echo '" alt=""></div>
						 <div class="span12"><h3 style="font-size: 16px !important; line-height: 24px !important;" > cf Gloves</h3></div>
					</div> -->
					<div class="">
						<h3 class="invoice-type" style="text-align:center !important; font-size: 16px !important;" ><span class="header-title">Packing List</span></h3>
					</div>
					';if ($title != ''):  ;echo '						<div class="row-fluid" style="margin-top: -41px;margin-bottom:-5px;border-top:1px solid black;">
							<div class="span12 header">
								<table class="header_tbl">
									<thead>
										<tr>
											<th style=" width: 120px; text-align:left; font-size:12px !important;">Consignee:</th>
											<th></th>
											<th ></th>
											<th ></th>
											<th style=" width: 120px; text-align:right; font-size:12px !important;padding-right:87px !important;">PL </th>
											<th style="text-align:left; font-size:11px;font-weight:normal !important;padding-left:3px !important;">';echo 'HE/'.$vrdetail[0]['sale_invoice_no'] .'/'.substr($vrdetail[0]['vrdate'],2,2) .'/'.$vrdetail[0]['party_id'] ;;echo '</th>
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
											<td style="text-align:left;font-size:11px !important;font-weight:normal;padding-left:3px !important;">';echo (substr($vrdetail[0]['edate'],0,10)=="0000-00-00"?"": date('d-M-y',strtotime($vrdetail[0]['edate'])));;echo '</td>
										</tr>
										<tr>
											<td style=" width: 120px !important; text-align:left;font-size:12px !important;font-weight:bolder !important; " colspan="1">Shipment By:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['transporter_name'];;echo '</td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Payment Terms:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['payment_term'];;echo '</td>
										</tr>
										<!--  -->
										<tr>
											<td style=" width: 1200px !important; text-align:left;font-size:12px !important;font-weight:bolder !important; " >Shipment From:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['shippment_from'];;echo '</td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">Shipment Term:</td>
											<td style="text-align:left;" style="font-size:18px !important;">';echo $vrdetail[0]['delivery_term'];;echo '</td>
										</tr>
										
										<tr>
											<td style=" width: 120px !important; text-align:left;font-size:12px !important;font-weight:bolder !important; ">To:</td>
											<td style="text-align:left;">';echo $vrdetail[0]['shippment_to'];;echo '</td>
											<td colspan="2"></td>
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">';echo ($vrdetail[0]['lc_no']!==''?"Lc#":"") ;echo '</td>
											<td style="text-align:left;" style="font-size:18px !important;">';echo $vrdetail[0]['lc_no'];;echo '</td>
										</tr>
										<tr>
											<td style=" width: 120px !important; text-align:left;font-size:12px !important;font-weight:bolder !important; " >Remarks:</td>
											<td style="text-align:left !important;" colspan="3">';echo $vrdetail[0]['remarkspacking'];;echo '</td>
											
											<td style=" width: 120px; text-align:left; font-size:12px !important;font-weight:bolder;padding-left:17px !important;font-weight:bolder;">';echo ($vrdetail[0]['lc_no']!==''?"Lc Date:":"") ;echo '</td>
											<td style="text-align:left;" style="font-size:18px !important;">';echo (substr($vrdetail[0]['lc_date'],0,10)=="0000-00-00"?"": date('d-M-y',strtotime($vrdetail[0]['lc_date']))) ;;echo '</td>
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
										<!-- <tr>
											<td style=" width: 100px !important; text-align:left; font-size:12px !important;font-weight:bolder !important; ">Shipment By : </td>
											<td>';
;echo '</td>
											<td></td>								
											<td></td>								
											<td></td>								
											<td></td>								
										</tr>
										<tr >
											<td style=" width: 100px !important; text-align:left; font-size:12px !important;font-weight:bolder !important; ">From : </td>
											<td>';
;echo '</td>
											<td colspan=\'5\' style=" width: 100px !important; text-align:left; font-size:8px; "></td>
										</tr>
										<tr >
											<td style=" width: 100px !important; text-align:left; font-size:12px !important;font-weight:bolder !important; ">To : </td>
											<td>';
;echo '</td>
											<td colspan=\'5\' style=" width: 100px !important; text-align:left; font-size:8px; "></td>
										</tr> -->
										<!-- <tr >
											<td colspan=\'5\' style="font-size:12px !important;font-weight:bolder !important;" class="text-right" >Export Registration No</td>								
											<td  colspan=\'1\' style="text-align:left;" >';
;echo '</td>							
										</tr> -->
										<!-- <tr >
											<td colspan=\'1\' style="font-size:12px !important;font-weight:bolder !important;" class="text-left" >Remarks</td>								
											<td  colspan=\'5\' style="text-align:left;" >';
;echo '</td>							
										</tr> -->
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
							<thead style="clear: both !important;" class=\'bod\'>
								<tr >
									<!-- <th style=" width: 10px; " >Sr#</th> -->
									<th style=" width: 60px; color:white !important;" class=\'text-center\'>Marks</th>
									<th style=" width: 140px; text-align:left; color:white !important;">Description</th>
									<!--<th style=" width: 30px; color:white !important; " class=\'text-right\'>Qty</th>--> 
									<th style=" width: 30px; color:white !important;" class=\'text-center\'>Colour</th>
									<th style=" width: 35px; color:white !important;" class=\'text-center\'>Size</th>
									<th style=" width: 40px; color:white !important;" class=\'text-center\'>DPR/Ctn</th>
									<!-- <th style=" width: 40px; color:white !important;" class=\'text-right\'>No of Ctn</th> -->
									<th style=" width: 40px; color:white !important;" class=\'text-right\'>Total Ctn</th>
									<th style=" width: 50px; color:white !important;" class=\'text-right\'>Total Dozen</th>
									

									<!-- <th style=" width: 30px; " class=\'text-right\'>Amount</th> -->
								</tr>
							<!-- </thead> -->
							</thead>
							<tbody class=\'bod\'>
							';
$serial = 1;
$netCtn = 0;
$netDozen = 0;
$netDpr = 0;
;echo '                            <tr>
                                <td colspan="7">
                                    <b>PO: ';echo $vrdetail[0]['ordno'];;echo '</b>
                                </td>
                            </tr>
							';foreach ($vrdetail as $data ) {;echo '								<tr>
									<td style="text-align: center; ">';echo $data['ctnmarking'];;echo '</td>
									<td>';echo $data['artcile_no_cus'];;echo '</td>
									<td style="text-align:center;">';echo $data['color'];;echo '</td>
									<td style="text-align:center;">';echo $data['size'];;echo '</td>
									<td style="text-align:center;">';echo (abs($data['dozen'])!=0 &&abs($data['ctn_qty'])!=0?(float)abs($data['dozen']) / (float)abs($data['ctn_qty']): '');;echo '</td>
									<!-- <td style="text-align:right;">';echo $data['noofctn'];;echo '</td> -->
									<td style="text-align:right;">';echo number_format($data['ctn_qty'],0);;echo '</td>
									<td style="text-align:right;">';echo number_format($data['dozen'],0);;echo '</td>
									
								</tr>

							';
$netDozen += abs($data['dozen']);
$netCtn += abs($data['ctn_qty']);
$netDpr +=(abs($data['dozen'])!=0 &&abs($data['ctn_qty'])!=0?(float)abs($data['dozen']) / (float)abs($data['ctn_qty']): '');
};echo '								
							</tbody>
							<tfoot class=\'bod\'>
							
								<tr class="foot-comments1">
									<td class="subtotalend bold-td" colspan="1">Container#<br/> ';echo $vrdetail[0]['container_no'];;echo '<br>';echo $vrdetail[0]['made_in'];;echo '</td>
									<td class="subtotalend bold-td text-left" style="text-align:left !important;" colspan="6">Total Net Weight:';echo $vrdetail[0]['net_weight'];;echo ' <br/>Total Gross Weight:';echo $vrdetail[0]['gross_weight'];;echo ' </td>
				<!-- 					<td class="subtotalend bold-td text-right"></td>
									<td class="subtotalend bold-td text-right"></td>
									<td class="subtotalend bold-td text-right"></td>
									<td class="subtotalend bold-td text-right"></td> -->
									<!-- <td class="subtotalend bold-td text-right">';echo number_format($netAmount,2);;echo '</td> -->
								</tr>
								<tr class="foot-comments1">
									<td class="subtotalend bold-td" colspan="1">H.S Code No: 6116.9200</td>
									<td class="subtotalend bold-td" colspan="3"></td>
									<td class="subtotalend bold-td" style="text-align:right;">Totals</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netCtn,0);;echo '</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netDozen,0);;echo '</td>
									
									<!-- <td class="subtotalend bold-td text-right">';
;echo '</td> -->
								</tr>
								

							</tfoot>
							<!-- </tfoot> -->
							</tbody>
								
							<!--</tfoot> -->
						</table>
					</div>
					<!-- <div class="row-fluid">
						<div class="span12 add-on-detail1" style="margin-top: 10px;">
							<p class="" style="text-transform1: uppercase;">
								<strong>In words: </strong> <span class="inwords"></span>';
;echo 'ONLY <br>
								<br>
								';if ( $pre_bal_print==1  ){;echo '									<p><span class="field1">Previous Balance:</span><span class="fieldvalue inv-vrnoa">';
;echo '</span></p>
									<p><span class="field1">This Invoice:</span><span class="fieldvalue inv-date">';
;echo '</span></p>
									<p><span class="field1">Current Balance:</span><span class="fieldvalue cust-name">';
;echo '</span></p>
								';};;echo '							</p>
						</div>
					</div> -->
					<!-- End row-fluid -->
					
					<span class=\'foo-cer\'>IT IS CERTIFIED THAT THE GOODS ARE OF PAKISTAN ORIGIN</span>
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
			
			<div id="footer1">
		    	<div class="span12">
					<table class="signature-fields">
						<thead>
							<tr>
								<td></td>
								<td></td>
								<th>For CHINIOT FABRICS</th>
							</tr>
						</thead>
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