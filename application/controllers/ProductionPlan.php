
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
		* { margin: 0; padding: 0; font-family: tahoma !important; }
			 body {  margin: 0 !important; font-size:18px !important; }
			 p { margin: 0 !important; /* line-height: 17px !important; */ }
			 .field { font-size:18px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .field1 { font-size:18px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: collapse; }
			 table { width: 100% !important; border: 1px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:0px}
			 th {  padding: 5px !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child {  }
			 /*.voucher-table thead th {background: #ccc !important; } */
			 .voucher-table thead th {background: grey; } 
			 tfoot {border-top: 0px solid black !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 18px !important; border-top: 0px solid black !important; }
			 .invoice-type { border-bottom: 0px solid black !important; }
			 .relative { position: relative !important; }
			 .signature-fields{ font-size: 18px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			 .signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			 .inv-leftblock { width: 280px !important; }
			 .text-left { text-align: left !important; }
			 .text-centre { text-align: center !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 18px !important; font-family: tahoma !important; line-height: 10px !important; padding: 4px !important; } 
			 
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {border: none !important; margin: 0px !important; position: relative !important; top: 34px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 18px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 18px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto; }
			 p { position: relative !important; font-size: 18px !important; }
			 thead th { font-size: 22px !important; color: black !important; font-weight: bold !important; padding: 10px !important; }
			 .fieldvalue { font-size:18px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .text-centre{text-align: center !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 18px !important; padding: 10px !important; border-top: 0px solid black !important;}
			.footer_company td { font-size: 18px !important; padding: 10px !important; border-top: 0px solid black !important;}

			.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px;}
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 18px !important; padding: 10px !important;  }
			.subtotalend { font-size: 18px !important; font-weight: bold !important;text-align: right !important; }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 18px !important; font-weight: bold !important;text-align: right !important; color: red;}
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
			/* #footer{
				position:fixed;
				left:0px;
				bottom:0px;
				margin-top: 950px;
				width:100%;
				background:white;
				line-height:30px;
				color:black;
				font-size:16px;
			}
			#footer span{padding-left:20px;}
			#footer p{padding: 0px 0px 0px 0px;  } */
			.header{border:1px solid black;}
			.header-title{background-color: black;color: white;padding: 14px;}
			.float-right{float:right !important;}
			.text-center{text-align: center !important;}
			.header-heading{font-size: 20px;font-weight: bolder;}

			

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

		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row-fluid" >
				<div class="span12 centered">
					<div class="row-fluid">
						<!-- <div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div> -->
						<div class="span12 text-center header-heading"><img class="" src="" alt="">';echo $vrdetail[0]['company_name'];;echo '</div>
						 <!-- <div class="span12"><h3 style="font-size: 16px !important; line-height: 24px !important;" > cf Gloves</h3></div> -->
					</div>
					<div class="">
					</div>
						<div class="row-fluid relative">
							<div class="span12">
								<div class="block inv-leftblock float-right" style="width:250px !important; display:inline !important;">
									<p><span class="field">Po#</span><span class="fieldvalue inv-vrnoa"></span>';echo $vrdetail[0]['cpono'];;echo '</p>									
									<p><span class="field">Date:</span><span class="fieldvalue inv-date">';echo 'HE/'.$vrdetail[0]['vrnoa'] .'/'.substr($vrdetail[0]['vrdate'],2,2) .'/'.$vrdetail[0]['party_id'] ;;echo '</span></p>
								</div>
							</div>
						</div>
					
					<br>
					<br>
					<br>
					
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr style="">
									<th style=" width: 40px; text-align:right; color:white !important; ">کل کا ر ٹو ن  </th>
									<th style=" width: 30px; text-align:left; color:white !important;">پرچئ</th>
									<th style=" width: 40px; color:white !important; " class=\'text-right\'>کل  د ر جن</th>
									<th style=" width: 20px; color:white !important; " class=\'text-left\'>لیبل</th>
									<th style=" width: 80px; color:white !important;" class=\'text-right\'>گلو سٹا ئل</th>
									<th style=" width: 40px; color:white !important;" class=\'text-right\'>#ارٹیکل</th>
									<th style=" width: 10px; color:white !important;" class=\'text-right\'>Sr#</th>
								</tr>
							</thead>

							<tbody>
								
								
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
									   <td class=\'text-right\'>';echo number_format(abs($row['ctn_qty']),2);;echo '</td>
									   <td class=\'text-left\'>';echo $row['parchi'];;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['dzn_qty']),2);;echo '</td>
									   <td class=\'text-left\'>';echo $row['label2'];;echo '</td>
									   <td class=\'text-right\'>';echo $row['item_name'];;echo '</td>
									   <td class=\'text-right\'>';echo $row['artcile_no'];;echo '</td>
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
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
									<td class="subtotalend bold-td text-right">';echo number_format($netCtn_Qty,2);;echo '</td>
									<td class="subtotalend bold-td text-right">';;echo '</td>
									<td class="subtotalend bold-td text-right">';echo number_format($netDzn_Qty,2);;echo '</td>
									<td class="subtotalend bold-td text-right"></td>
									<td class="subtotalend bold-td text-right"></td>
									<td class="subtotalend bold-td text-right"></td>
									<td class="subtotalend bold-td text-right"></td>
								</tr>
								
							


							</tfoot>
						</table>
					</div>
				
					<br>
					<br>
					 
					
				</div>
			</div>
			<div class="shipment-date">
				';echo "Shipment Date : ".substr($vrdetail[0]['bilty_date'],0,10);;echo '			</div>
		
		

			<!-- <div id="footer">
					 
					    	<span class="loggedin_name">User:';echo $user;;echo '</span>
			</div> -->

		</div>
   <!--  <div class="" id="footerUpper">
    		
    </div> -->
    
    
	</body>
</html>
';
?>