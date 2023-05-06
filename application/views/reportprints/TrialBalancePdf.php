

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
		 body { font-size:10px; }
		 p { margin: 0; /* line-height: 17px; */ }
		 .field {font-weight: bold; display: inline-block; width: 150px; } 
		 .voucher-table{ border-collapse: collapse; }
		 table { width: 100%; border: none; border-collapse:collapse; table-layout:fixed;margin-top: 8%;}
		 th { border: 0px solid black; padding: 5px; }
		 td { /*text-align: center;*/ vertical-align: top; /*padding: 5px 10px;*/ border-left: 0px solid black; border-right: 0px solid black;}
		 td:first-child { text-align: left; }
		 .voucher-table thead th {background: #ccc; } 
		 tfoot {border-top: 1px solid black; } 
		 .bold-td { font-weight: bold; border-bottom: 1px solid black;}
		 .nettotal { font-weight: bold; font-size: 11px !important; border-top: 1px solid black; }
		 .invoice-type { border-bottom: 1px solid black; }
		 .relative { position: relative; }
		 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
		 .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px; font-size:12px }
		 .inv-leftblock { width: 280px; }
		 .text-left { text-align: left !important; }
		 .text-right { text-align: right !important; }
		 td {font-size: 8px; font-family: tahoma; line-height: 14px; padding: 4px; } 
		 
		 .inwords, .remBalInWords { text-transform: uppercase; }
		 .barcode { margin: auto; }
		 h3.invoice-type {font-size: 20px;}
		 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; margin: 5px 0px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;}
		 .nettotal { color: red; font-size: 12px;}
		 .l1row { color: red; font-size: 10px;font-weight: bold;}
		 .l1row-right { color: red; font-size: 10px;font-weight: bold;text-align: right;}

		 .l2row { color: green; font-size: 10px;font-weight: bold;}
		 .l2row-right { color: green; font-size: 10px;font-weight: bold;text-align: right;}

		 .l3row { color: blue; font-size: 10px;font-weight: bold;}
		 .l3row-right { color: blue; font-size: 10px;font-weight: bold;text-align: right;}

		 .remainingBalance { font-weight: bold; color: blue;}
		 .centered { margin: auto; }
		 p { position: relative; font-size: 16px; }
		 thead th { font-size: 14px; font-weight: bold; }
		 .fieldvalue.cust-name {position: absolute; width: 497px; } 
		 @media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 .pl20 { padding-left: 20px !important;}
		 .pl40 { padding-left: 40px !important;}
			
		.barcode { float: right; }
		.item-row td { font-size: 12px; padding: 5px; border: none;}

		.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
		h3.invoice-type { font-size: 26px; border: none !important; margin: 0px !important; position: relative; }
		tfoot tr td { font-size: 13px; padding: 5px; }
		.nettotal, .subtotal, .vrqty { font-size: 14px !important; font-weight: normal !important;}
	</style>
</head>
<body>
	<div class="container-fluid" style="">
<div class="row-fluid">
	<div class="span12 centered">
		<div class="row-fluid">
			<div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>
						 <!-- <div class="span12"><h3 style="font-size: 16px !important; line-height: 24px !important;" > cf Gloves</h3></div> -->
		</div>
		<div class="row-fluid relative">
			<div class="span12">
					<div class="block pull-left inv-leftblock" style="width:150px !important; display:inline !important;">
						<h3 class="invoice-type text-left">';echo $title;;echo '</h3>
						<p><span class="field">Dated From: </span><span class="fieldvalue inv-date">';echo $date_between;;echo '</span></p>
					</div>
					<!-- <div class="block pull-right" style="width:300px !important; float: right; display:inline !important;">
						<div class="span12"><img style="float:right; width:350px !important;height:80px;" class="rcpt-header logo-img" src="';echo $header_img;;echo '" alt=""></div>
						
					</div> -->
			</div>
		</div>
		
		
		<div class="row-fluid">
			<table class="voucher-table">
				<thead>
					<tr>
						<th style=" width: 80px; ">Acc Id</th>
						<th style=" width: 250px; ">Account Title</th>
						<th style=" width: 80px; ">Debit</th>
						<th style=" width: 80px; ">Credit</th>
					</tr>
				</thead>

		<tbody>
			
			';
$serial = 1;
$Total_Debit = 0.00;
$Total_CREDIT = 0.00;
$Rtotal = 0.00;
$l1='';
$l2='';
$l3='';
if (empty($pledger)) {
}
else{
foreach ($pledger as $row): 
$Total_Debit += $row['DEBIT'];
$Total_CREDIT += $row['CREDIT'];
;echo '				';if ($l1 !=$row['L1'] ){;echo '					<tr  class="item-row">
					   <td 	class=\'l1row\' >';echo $row['L1'];;echo ' </td>
					   <td  class=\'l1row\'>';echo $row['L1NAME'];;echo '</td>
					   <td  class="l1row-right">';echo ($row['L1DebSUM']!=0 ?number_format($row['L1DebSUM'],2):'-');;echo '</td>
					   <td  class="l1row-right">';echo ($row['L1CredSUM']!=0 ?number_format($row['L1CredSUM'],2):'-');;echo '</td>
					</tr>

				';$l1= $row['L1'];}
;echo '				 ';if ($l2 !=$row['L2'] ){;echo '					<tr  class="item-row">
					   <td 	class=\'l2row\' >';echo $row['L1'] .'-'.$row['L2'] ;;echo ' </td>
					   <td  class=\'l2row\'>';echo $row['L2NAME'];;echo '</td>
					   <td  class="l2row-right">';echo ($row['L2DebSUM']!=0 ?number_format($row['L2DebSUM'],2):'-');;echo '</td>
					   <td  class="l2row-right">';echo ($row['L2CredSUM']!=0 ?number_format($row['L2CredSUM'],2):'-');;echo '</td>
					</tr>

				';$l2= $row['L2'];}
;echo '				 ';if ($l3 !=$row['L3'] ){;echo '					<tr  class="item-row">
					   <td 	class=\'l3row\' >';echo $row['L1'].'-'.$row['L2'].'-'.$row['L3'];;echo ' </td>
					   <td  class=\'l3row\'>';echo $row['L3NAME'];;echo '</td>
					   <td  class="l3row-right">';echo ($row['L3DebSUM']!=0 ?number_format($row['L3DebSUM'],2):'-');;echo '</td>
					   <td  class="l3row-right">';echo ($row['L3CredSUM']!=0 ?number_format($row['L3CredSUM'],2):'-');;echo '</td>
					</tr>

				';$l3= $row['L3'];}
;echo '				<tr  class="item-row">
				   <td 	class=\'text-left\' >';echo $row['ACCOUNT_ID'];;echo ' </td>
				   <td  class=\'text-left\'>';echo $row['PARTY_NAME'];;echo '</td>
				   <td  class="text-right">';echo ($row['DEBIT']!=0 ?number_format($row['DEBIT'],2):'-');;echo '</td>
				   <td  class="text-right">';echo ($row['CREDIT']!=0 ?number_format($row['CREDIT'],2):'-');;echo '</td>
				</tr>

			';endforeach ;echo '			';
;echo '		</tbody>
				<tfoot>
				<!-- 	<tr class="foot-comments">
						<td class="vrqty bold-td text-right">';
;echo '</td>
						<td class="bold-td text-right" colspan="3">Subtotal</td>
						<td class="bold-td"></td>
					</tr> -->
				</tfoot>
					<tr  class="item-row">
						<!-- <td class="bold-td"></td> -->
						<td class="text-right " colspan="2">Total</td>
						<td class="text-right ">';echo number_format($Total_Debit,2);;echo '</td>
						<td class="text-right ">';echo number_format($Total_CREDIT,2);;echo '</td>
					</tr>
				
				';};echo '			</table>
		</div>
		<!-- <div class="row-fluid">
			<div class="span12 add-on-detail" style="margin-top: 10px;">
				<p class="" style="text-transform: uppercase;">
					<strong>In words: </strong> <span class="inwords"></span>  ';echo $Total_Amount;;echo ' ONLY <br>	
				</p>
			</div>
		</div> -->
		<!-- End row-fluid -->
		
		
		<div class="row-fluid">
			<p>
				<span class="loggedin_name">User: ';echo $user;;echo '</span><br>
				<!-- <span class="website">Software By: www.alnaharsolution.com</span> -->
			</p>
		</div>

	</div>
</div>
</div>
</body>
</html>	';
?>