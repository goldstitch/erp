
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

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

	<style>
		 * { margin: 0; padding: 0; font-family: tahoma; }
		 body { font-size:12px;  }
		 p { margin: 0; /* line-height: 17px; */ }
		 .field {font-weight: bold; display: inline-block; width: 150px; } 
		 .voucher-table{ border-collapse: collapse; }
		 table { width: 100%; border:none; border-collapse:collapse; table-layout:fixed;margin-top: 8%;}
		 th { }
		 tr{ page-break-inside: avoid;}
		 td { /*text-align: center;*/ vertical-align: top; /*padding: 5px 10px;*/ border-left: 1px solid black;}
		 td:first-child { text-align: left; }
		 .voucher-table thead th { } 
		 .headerrr {background: #ccc; border: 1px solid black; padding: 5px; } 
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
		 td {font-size: 8px; font-family: tahoma; line-height: 14px; padding: 5px; } 
		 
		 .inwords, .remBalInWords { text-transform: uppercase; }
		 .barcode { margin: auto; }
		 h3.invoice-type {font-size: 20px; line-height: 24px;}
		 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; margin: 5px 0px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;}
		 .nettotal { color: red; font-size: 12px;}
		 .l1row { color: red; font-size: 9px;font-weight: bold;}
		 .l1row-right { color: red; font-size: 9px;font-weight: bold;text-align: right !important;}

		 .l2row { color: green; font-size: 9px;font-weight: bold;}
		 .l2row-right { color: green; font-size: 9px;font-weight: bold;text-align: right !important;}

		 .l3row { color: blue; font-size: 9px;font-weight: bold;}
		 .l3row-right { color: blue; font-size: 9px;font-weight: bold;text-align: right !important;}

		 .remainingBalance { font-weight: bold; color: blue;}
		 .centered { margin: auto; }
		 p { position: relative; font-size: 16px; }
		 thead th { }
		 .headerrr td { font-size: 12px; font-weight: bold; }

		 .fieldvalue.cust-name {position: absolute; width: 497px; } 
		 @media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 .pl20 { padding-left: 20px !important;}
		 .pl40 { padding-left: 40px !important;}
			
		.barcode { float: right; }
		.item-row td { font-size: 12px; padding: 5px; border: none;}
		.grandrow-right { color: black; font-size: 9px;font-weight: bold;text-align: right !important; border: none !important;}
		.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
		h3.invoice-type {font-size: 26px; border: none !important; margin: 0px !important; position: relative;  }
		tfoot tr td { font-size: 13px; padding: 5px; }
		.nettotal, .subtotal, .vrqty { font-size: 14px !important; font-weight: normal !important;}
		table {margin-right: 200px !important;}
	</style>
	<script type="text/javascript">
		function subst() {
		  var vars={};
		  var x=document.location.search.substring(1).split(\'&\');
		  for (var i in x) {var z=x[i].split(\'=\',2);vars[z[0]] = unescape(z[1]);}
		  var x=[\'frompage\',\'topage\',\'page\',\'webpage\',\'section\',\'subsection\',\'subsubsection\'];
		  for (var i in x) {
		    var y = document.getElementsByClassName(x[i]);
		    for (var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
		  }
		}
		var div = document.getElementById(\'mydiv\');

		div.innerHTML = div.innerHTML + \'Extra stuff\';
	</script>
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
										
					<tr class="headerrr">
						<th style="width: 120px;">Acc Id</th>
						<th style="width: 500px;">Account Title</th>
						<th style="width: 120px;">Debit</th>
						<th style="width: 120px;">Credit</th>
					</tr>
				
			</thead>

			<tbody>
				
		
			
			';
$serial_l1 = 0;
$serial_l2 = 0;
$serial_l3 = 0;
$Total_Debit = 0.00;
$Total_Credit = 0.00;
$Total_Debit_l1 = 0.00;
$Total_Credit_l1 = 0.00;
$Total_Debit_l2 = 0.00;
$Total_Credit_l2 = 0.00;
$Total_Debit_l3 = 0.00;
$Total_Credit_l3 = 0.00;
$Rtotal = 0.00;
$l1='';
$l2='';
$l3='';
$l1_name='';
$l2_name='';
$l3_name='';
if (empty($pledger)) {
}
else{
foreach ($pledger as $row): 
if($row['debit']+$row['credit']!=0){
;echo '				';if ($l1 !=$row['l1'] ){
if ($l3 !=$row['l3'] ){
if ($serial_l3 !==0){
;echo '							<tr  class="item-row" style="border-top: 1px solid black;">
								   <td 	class=\'l3row-right\' colspan="2" >';echo $l3_name .' Subtotal: ';;echo ' </td>
								   <td  class=\'l3row-right\'>';echo number_format($Total_Debit_l3,0);;echo '</td>
								   <td  class="l3row-right">';echo number_format($Total_Credit_l3,0);;echo '</td>
							</tr>
							';
$Total_Debit_l3=0;
$Total_Credit_l3=0;
$serial_l3=0;
}}
if ($l2 !=$row['l2'] ){
if ($serial_l2 !==0){;echo '						  <tr  class="item-row" style="border-top: 1px solid black;">
								   <td 	class=\'l2row-right\' colspan="2" >';echo $l2_name .' Subtotal: ';;echo ' </td>
								   <td  class=\'l2row-right\'>';echo number_format($Total_Debit_l2,0);;echo '</td>
								   <td  class="l2row-right">';echo number_format($Total_Credit_l2,0);;echo '</td>
							</tr>
							';
$Total_Debit_l2=0;
$Total_Credit_l2=0;
$serial_l2=0;
}}
if ($serial_l1 !==0){;echo '						
						<tr  class="item-row" style="border-top: 1px solid black;">
						   <td 	class=\'l1row-right\' colspan="2" >';echo $l1_name .' Subtotal: ';;echo ' </td>
						   <td  class=\'l1row-right\'>';echo number_format($Total_Debit_l1,0);;echo '</td>
						   <td  class="l1row-right">';echo number_format($Total_Credit_l1,0);;echo '</td>
						</tr>
					';
$Total_Debit_l1=0;
$Total_Credit_l1=0;
$serial_l1=0;
}
;echo '					<tr  class="item-row">
					   <td 	class=\'l1row\' >';echo $row['l1'];;echo ' </td>
					   <td  class=\'l1row\'>';echo $row['leve1'];;echo '</td>
					   <td  class="l1row-right">';;echo '</td>
					   <td  class="l1row-right">';;echo '</td>
					</tr>
				';$l1= $row['l1'];$l1_name= $row['leve1'];}
if ($l2 !=$row['l2'] ){
if ($l3 !=$row['l3'] ){
if ($serial_l3 !==0){
;echo '							<tr  class="item-row" style="border-top: 1px solid black;">
							   <td 	class=\'l3row-right\' colspan="2" >';echo $l3_name .' Subtotal: ';;echo ' </td>
							   <td  class=\'l3row-right\' >';echo number_format($Total_Debit_l3,0);;echo '</td>
							   <td  class="l3row-right">';echo number_format($Total_Credit_l3,0);;echo '</td>
							</tr>
							';
$Total_Debit_l3=0;
$Total_Credit_l3=0;
$serial_l3=0;
}}
if ($serial_l2 !==0){;echo '				  	<tr class="item-row" style="border-top: 1px solid black;">
						   <td 	class=\'l2row-right\' colspan="2" >';echo $l2_name .' Subtotal: ';;echo ' </td>
						   <td  class=\'l2row-right\'>';echo number_format($Total_Debit_l2,0);;echo '</td>
						   <td  class="l2row-right">';echo number_format($Total_Credit_l2,0);;echo '</td>
					</tr>
					';
$Total_Debit_l2=0;
$Total_Credit_l2=0;
$serial_l2=0;
};echo '					<tr  class="item-row">
					   <td 	class=\'l2row\' >';echo $row['l1'] .'-'.$row['l2'] ;;echo ' </td>
					   <td  class=\'l2row\'>';echo $row['level2'];;echo '</td>
					   <td  class="l2row-right">';;echo '</td>
					   <td  class="l2row-right">';;echo '</td>
					</tr>

				';$l2= $row['l2'];$l2_name= $row['level2'];}
if ($l3 !=$row['l3'] ){
if ($serial_l3 !==0){
;echo '					<tr  class="item-row" style="border-top: 1px solid black;">
						   <td 	class=\'l3row-right\' colspan="2" >';echo $l3_name .' Subtotal: ';;echo ' </td>
						   <td  class=\'l3row-right\'>';echo number_format($Total_Debit_l3,0);;echo '</td>
						   <td  class="l3row-right">';echo number_format($Total_Credit_l3,0);;echo '</td>
					</tr>
					';
$Total_Debit_l3=0;
$Total_Credit_l3=0;
$serial_l3=0;
};echo '					<tr  class="item-row">
					   <td 	class=\'l3row\' >';echo $row['l1'].'-'.$row['l2'].'-'.$row['l3'];;echo ' </td>
					   <td  class=\'l3row\'>';echo $row['level3'];;echo '</td>
					   <td  class="l3row-right">';;echo '</td>
					   <td  class="l3row-right">';;echo '</td>
					</tr>
				';$l3= $row['l3'];$l3_name= $row['level3'];}
;echo '				<tr class="item-row">
				   <td 	class=\'text-left\' >';echo $row['account_id'];;echo ' </td>
				   <td  class=\'text-left\' >';echo $row['party_name'];;echo '</td>
				   <td  class="text-right">';echo ($row['debit']-$row['credit']>0 ?number_format($row['debit']-$row['credit'],0):'-');;echo '</td>
				   <td  class="text-right">';echo ($row['debit']-$row['credit']<0 ?number_format(abs($row['debit']-$row['credit']),0):'-');;echo '</td>
				</tr>
				';
$Total_Debit += ($row['debit']-$row['credit']>0 ?$row['debit']-$row['credit']:'0');
$Total_Credit += ($row['debit']-$row['credit']<0 ?abs($row['debit']-$row['credit']):'0');
$Total_Debit_l1 += ($row['debit']-$row['credit']>0 ?$row['debit']-$row['credit']:'0');
$Total_Credit_l1 += ($row['debit']-$row['credit']<0 ?abs($row['debit']-$row['credit']):'0');
$Total_Debit_l2 += ($row['debit']-$row['credit']>0 ?$row['debit']-$row['credit']:'0');
$Total_Credit_l2 += ($row['debit']-$row['credit']<0 ?abs($row['debit']-$row['credit']):'0');
$Total_Debit_l3 += ($row['debit']-$row['credit']>0 ?$row['debit']-$row['credit']:'0');
$Total_Credit_l3 += ($row['debit']-$row['credit']<0 ?abs($row['debit']-$row['credit']):'0');
$serial_l1 +=1;
$serial_l2 +=1;
$serial_l3 +=1;
}endforeach ;echo '			';if ($serial_l3 !==0){
;echo '							<tr  class="item-row" style="border-top: 1px solid black;">
								   <td 	class=\'l3row-right\' colspan="2" >';echo $l3_name .' Subtotal: ';;echo ' </td>
								   <td  class=\'l3row-right\'>';echo number_format($Total_Debit_l3,0);;echo '</td>
								   <td  class="l3row-right">';echo number_format($Total_Credit_l3,0);;echo '</td>
							</tr>
							';
$Total_Debit_l3=0;
$Total_Credit_l3=0;
$serial_l3=0;
}
if ($serial_l2 !==0){;echo '						  <tr  class="item-row" style="border-top: 1px solid black;">
								   <td 	class=\'l2row-right\' colspan="2" >';echo $l2_name .' Subtotal: ';;echo ' </td>
								   <td  class=\'l2row-right\'>';echo number_format($Total_Debit_l2,0);;echo '</td>
								   <td  class="l2row-right">';echo number_format($Total_Credit_l2,0);;echo '</td>
							</tr>
							';
$Total_Debit_l2=0;
$Total_Credit_l2=0;
$serial_l2=0;
}
if ($serial_l1 !==0){;echo '						<tr  class="item-row" style="border-top: 1px solid black;">
						   <td 	class=\'l1row-right\' colspan="2" >';echo $l1_name .' Subtotal: ';;echo ' </td>
						   <td  class=\'l1row-right\'>';echo number_format($Total_Debit_l1,0);;echo '</td>
						   <td  class="l1row-right">';echo number_format($Total_Credit_l1,0);;echo '</td>
						</tr>
					';
$Total_Debit_l1=0;
$Total_Credit_l1=0;
$serial_l1=0;
}
;echo '		</tbody>

				<tfoot>
				<!-- 	<tr class="foot-comments">
						<td class="vrqty bold-td text-right">';
;echo '</td>
						<td class="bold-td text-right" colspan="3">Subtotal</td>
						<td class="bold-td"></td>
					</tr> -->
				</tfoot>
					<tr  class="item-row" style="border-top: 2px solid black; border-bottem: 2px solid black;">
						<!-- <td class="bold-td"></td> -->
						<td class="grandrow-right" colspan="2">Grand Total:</td>
						<td class="grandrow-right ">';echo number_format($Total_Debit,0);;echo '</td>
						<td class="grandrow-right ">';echo number_format($Total_Credit,0);;echo '</td>
						
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
		<br> 
		<br> 
		<br> 
		<br> 
		
		<div class="row-fluid">
			<p>
				<span class="loggedin_name">User: ';echo $user;;echo '</span><br>
				<!-- <span class="website">Sofware By: www.alnaharsolution.com</span> -->
			</p>
		</div>

	</div>
</div>
</div>
</body>
</html>	';
?>