

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
	<title>Account Ledger</title>

	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">

	<style type="text/css">	
			* { margin: 0; padding: 0; font-family: tahoma; }
			 body { font-size:20px; }
			 p { margin: 0; /* line-height: 17px; */ }
			 .field { font-size:14px; font-weight: bold; display: inline-block; width: 150px; } 
			 .voucher-table{ border-collapse: collapse; }
			 table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed;margin-top: 0%;}
			 th { border: 1px solid black; padding: 5px; font-weight: bold !important; }
			 td { /*text-align: center;*/ vertical-align: top; /*padding: 5px 10px;*/ border-left: 1px solid black; border-top: 1px solid black;}
			 tr{page-break-inside: avoid !important;}
			 td:first-child { text-align: left; }
			 .voucher-table thead th {background: #ccc; } 
			 tfoot {border-top: 1px solid black; } 
			 .bold-td { font-weight: bold; border-bottom: 1px solid black;}
			 .nettotal { font-weight: bold; font-size: 11px !important; border-top: 1px solid black; }
			 .invoice-type { border-bottom: 1px solid black; }
			 .relative { position: relative; }
			 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
			 .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px; }
			 .inv-leftblock { width: 280px; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 12px; font-family: tahoma; line-height: 14px; padding: 4px; } 
			 
			 .inwords, .remBalInWords { text-transform: uppercase; }
			 .barcode { margin: auto; }
			 h3.invoice-type {font-size: 16px; line-height: 10px;}
			 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; margin: 5px 0px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;}
			 .nettotal { color: red; font-size: 10px;}
			 .remainingBalance { font-weight: bold; color: blue;}
			 .centered { margin: auto; }
			 p { position: relative; font-size: 10px; }
			 thead th { font-size: 13px; font-weight: normal; }
			 .fieldvalue { font-size:14px !important; position: absolute; width: 497px; } 
			 .cust-name { font-size:14px !important; position: absolute; width: 497px; } 
			 @media print {
			 	.noprint, .noprint * { display: none; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right; }
			.item-row td { font-size: 14px; padding: 10px;}

			.rcpt-header { width: 900px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative; top: 0px; }
			tfoot tr td { font-size: 12px; padding: 5px; }
			.nettotal, .subtotal, .vrqty { font-size: 12px !important; font-weight: normal !important;}
			
			/* Report Fixed Footer */
			#footer{
				position:fixed;
				left:0px;
				bottom:0px;
				width:100%;
				background:white;
				line-height:30px;
				color:black;
				font-size:8px;
			}
			#footer span{padding-left:20px;}

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
							<div class="block pull-left inv-leftblock" style="width:150px !important; display:inline !important; font-size:12px;">
								<p><span class="field">Account Title:</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['party_name'];;echo '</span></p>									
								<p><span class="field">Account Code:</span><span class="fieldvalue inv-date">';echo $pledger[0]['acc_id'];;echo '</span></p>
								<p><span class="field">Address:</span><span class="fieldvalue inv-date">';echo $pledger[0]['address'];;echo '</span></p>
								<p><span class="field">Contact:</span><span class="fieldvalue inv-date">';echo $pledger[0]['contact'];;echo '</span></p>
								<p><span class="field">Dated From: </span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($from)) .' - To - '.date('d-M-y',strtotime($to));;echo '</span></p>
							</div>
							<div class="block pull-right" >
								
								<h3 class=" text-right" style="border:none !important; margin: 0px !important; position: relative; top: 0px; font-size:24px !important; ">';echo $title;;echo '</h3>
							</div>
						</div>
					</div>
					
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr>
									
									<th style=" width: 90px; ">Date</th>
									<th style=" width: 120px; ">Voucher</th>
									<th style=" width: 300px; ">Description</th>
									<th style=" width: 90px; ">Inv/Chq#</th>
									<th style=" width: 50px; ">WO#</th>

									<th style=" width: 90px; ">Debit</th>
									<th style=" width: 90px; ">Credit</th>
									<th style=" width: 90px; ">Balance</th>
									<th style=" width: 30px; ">D/C</th>
								</tr>
							</thead>

							<tbody>
								<tr style="border-bottom:1px dotted #ccc;" class="item-row">
									
									<td class="text-left " ></td>
									<td class="text-left " ></td>
									
									<td class="text-left " >Opening Balance</td>
									<td class="text-left " ></td>
									<td class="text-left " ></td>

									<td class="text-left " ></td>
									<td class="text-left " ></td>
									<td class="text-right " >';echo ($previousBalance!=0?number_format($previousBalance,0):'-');;echo '</td>
									<td class="text-right " >';echo ($previousBalance<0?"Cr":"Dr");;echo '</td>
								</tr>
								';
$serial = 1;
$Total_Debit = 0.00;
$Total_Credit = 0.00;
$Rtotal = 0.00;
$Rtotal= $previousBalance;
if (empty($pledger)) {
}
else{
foreach ($pledger as $row): 
$Total_Debit += $row['debit'];
$Total_Credit += $row['credit'];
$Rtotal += $row['debit']-$row['credit'];
;echo '									
									<tr style="border-bottom:1px dotted #ccc;" class="item-row">
									   
									   <td > ';echo date('d-M-y',strtotime($row['date'])) ;;echo '</td>
									   <td 	class=\'text-left\' >';echo $row['etype'] .'-'.$row['dcno'];;echo ' </td>
									   <td  class=\'text-left\'>';echo $row['description'];;echo '</td>
									   <td  class=\'text-left\'>';echo $row['chq_no'] .'-'.$row['invoice'] ;;echo '</td>
									   <td  class=\'text-left\'>';echo $row['wo'] ;;echo '</td>

									   <td  class="text-right">';echo ($row['debit']!=0?number_format($row['debit'],0):'-');;echo '</td>
									   <td  class="text-right">';echo ($row['credit']!=0?number_format($row['credit'],0):'-');;echo '</td>
									   <td  class="text-right">';echo ($Rtotal!=0?number_format($Rtotal,0):'-');;echo '</td>
									   <td  class="text-right">';echo ($Rtotal<0?"Cr":"Dr");;echo '</td>									   
									</tr>

								';endforeach ;echo '								';
;echo '							
							
							
								<tr style="border-bottom:1px dotted #ccc; border-top:1px solid black !important;" class="item-row">
									
									<td class="bold-td"></td>
									<td class="text-right " colspan="4" style="font-weight: bold !important; ">Total</td>
									<td class="text-right " style="font-weight: bold !important; ">';echo ($Total_Debit!=0?number_format($Total_Debit,0):'-');;echo '</td>
									<td class="text-right " style="font-weight: bold !important; ">';echo ($Total_Credit!=0?number_format($Total_Credit,0):'-');;echo '</td>
									<td class="text-right" style="font-weight: bold !important; ">';echo ($Rtotal!=0?number_format($Rtotal,0):'-');;echo '</td>
									<td class="text-right" style="font-weight: bold !important; ">';echo ($Rtotal<0?"Cr":"Dr");;echo '</td>
								</tr>
							</tbody>
							';};echo '						</table>
					</div>
					
					<div id="footer11">
			    		<span class="loggedin_name">User: ';echo $user;;echo '</span>
						<!-- <span class="website">Software By: www.alnaharsolution.com</span> -->
					</div>
					<!-- <div class="row-fluid">
						<p>
							<span class="loggedin_name">User: ';echo $user;;echo '</span><br>
							<span class="website">Sofware By: www.alnaharsolution.com</span>
						</p>
					</div> -->

				</div>
			</div>
		</div>
    	
	</body>
</html>
';
?>