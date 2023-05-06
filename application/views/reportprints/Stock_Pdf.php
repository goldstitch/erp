
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
			 body { font-size:12px; }
			 p { margin: 0; /* line-height: 17px; */ }
			 .field {font-weight: bold; display: inline-block; width: 100px; } 
			 .field1 {font-weight: bold; display: inline-block; width: 150px; } 
			 .voucher-table{ border-collapse: none; }
			 table { width: 100%; border: 2px solid black; border-collapse:collapse; table-layout:fixed; margin-left:1px;margin-top:20px;}
			 th {  padding: 5px; }
			 td { /*text-align: center;*/ vertical-align: top;  }
			 td:first-child { text-align: left; }
			 .voucher-table thead th {font-size: 15px !important; color: red; } 
			 tfoot {border-top: 1px solid black; } 
			 .bold-td { font-weight: bold; border-bottom: 0px solid black;}
			 .nettotal { font-weight: bold; font-size: 11px !important; border-top: 1px solid black; }
			 .invoice-type { border-bottom: 1px solid black; }
			 .relative { position: relative; }
			 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
			 .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px; }
			 .inv-leftblock { width: 280px; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 10px; font-family: tahoma; line-height: 14px; padding: 4px; } 
			 /*.rcpt-header { width: 550px; margin: auto; display: block; }*/
			 .rcpt-header { width: 550px !important; margin: auto !important; display: block !important; }
			 .inwords, .remBalInWords { text-transform: uppercase; }
			 .barcode { margin: auto; }
			 h3.invoice-type {font-size: 30px; line-height: 30px;}
			 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; margin: 5px 0px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;}
			 .nettotal { color: red; font-size: 12px;}
			 .remainingBalance { font-weight: bold; color: blue;}
			 .centered { margin: auto; }
			 p { position: relative; font-size: 16px; }
			 thead th { font-size: 13px; font-weight: bold; padding: 10px; }
			 .fieldvalue.cust-name {position: absolute; width: 497px; } 
			 @media print {
			 	.noprint, .noprint * { display: none; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right; }
			.item-row td { font-size: 13px; padding: 10px; border-top: 1px solid black;}
			.group-tot td {color: green; text-align: left; font-size: 13px; font-weight: bold; padding: 10px; border-top: 1px solid black;}
			.group-hd td {background: #ccc; text-align: left !important; font-size: 13px; font-weight: bold; padding: 10px; border-top: 1px solid black;}

			/*.rcpt-header { width: 305px !important; margin: 0px; display: inline; position: absolute; top: 0px; right: 0px; }*/
			.rcpt-header { width: 305px !important; margin: 0px !important; display: inline !important; position: absolute !important; top: 0px !important; right: 0px !important; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative; top: 34px; }
			tfoot tr td { font-size: 13px; padding: 10px;  }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 14px !important; font-weight: bold !important;}
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					<!-- <div class="row-fluid top-img-head" style="display:none; padding-top: 15px; padding-bottom: 15px;">
						<div class="span12">
							<img src="#" class="top-head" alt="">
						</div>
					</div> -->
					<div class="row-fluid relative">
						<div class="span12">
								<h3> <p><span style="font-size:30px" class="fieldvalue11 1inv-date">';echo $title;;echo '</span></p></h3>
								<div> </div>
								<br>
								<div class="block pull-left inv-leftblock" style="width:150px !important; display:inline !important;">
								<!-- <h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative; top: 100px; ">';echo $title;;echo '</h3> -->
								
								<p><span class="field1">Dated From: </span><span class="fieldvalue inv-date">';echo $date_between;;echo '</span></p>
								

								</div>
								<div class="block pull-right" style="width:180px !important; float: right; display:inline !important;">
									<!-- <div class="span12"><img style="border:none !important; float:right; width:350px !important;height:100px;" class="rcpt-header logo-img" src="';echo $header_img;;echo '" alt=""></div>					 -->
									<div class="span12"><img style="float:right; width:280px !important;" class="rcpt-header logo-img" src="';echo $header_img;;echo '" alt=""></div>
								</div>
						</div>
					</div>
					<br>
					<br>
					<br>
					
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr>
									<th style=" width: 20px; text-align:left;  ">Sr#</th>
									<th style=" width: 200px; text-align:left;">Descripton</th>									
									<th style=" width: 60px; text-align:right;">Qty</th>
									<th style=" width: 60px; text-align:right;">Weight</th>									
								</tr>
							</thead>

							<tbody>
								
								';
$serial = 0;
$Total_Qty = 0.00;
$Total_Weight = 0.00;
$Sub_Qty = 0.00;
$Sub_Weight = 0.00;
$v_now='';
$v_now_pre='';
if (empty($vrdetail)) {
}
else{
foreach ($vrdetail as $row): 								
$serial += 1;
if($what=='item'){
$v_now_pre=$row['DESCRIPTION'];
}else{
$v_now_pre=$row['NAME'];
}
if($v_now!== $v_now_pre){
if($serial !==1){
;echo '										  	<tr style="amountborder-bottom:1px dotted #ccc;" class="group-tot">
												<!-- <td class="bold-td"></td> -->
												<td class="text-right " colspan="2">Total:</td>
												<td class="text-right" >';echo  number_format($Sub_Qty,2);;echo '</td>
												<td class="text-right" >';echo  number_format($Sub_Weight,2);;echo '</td>									
											</tr>
										  ';
$Sub_Qty=0;
$Sub_Weight=0;
}
$v_now= $v_now_pre;
;echo '										<tr class="group-hd">
											   <td colspan="4" class="text-right">';echo $v_now_pre;;echo '</td>  
										</tr>
										';
}
;echo '									
									<tr style="amountborder-bottom:1px dotted #ccc;" class="item-row">
									   <td > ';echo $serial;;echo '</td>									   
									   <td  class=\'text-left\'>';echo ($what !=='item'?$row['DESCRIPTION']:$row['NAME']) ;;echo '</td>
									   <td  class="text-right">';echo ($row['QTY']!=0?number_format($row['QTY'],2):'-');;echo '</td>
									   <td  class="text-right">';echo ($row['WEIGHT']!=0?number_format($row['WEIGHT'],2):'-');;echo '</td>  
									</tr>
								';
$Total_Qty += $row['QTY'];
$Total_Weight += $row['WEIGHT'];
$Sub_Qty += $row['QTY'];
$Sub_Weight += $row['WEIGHT'];
endforeach ;echo '								';
;echo '							</tbody>
							<tfoot>
							<!-- 	<tr class="foot-comments">
									<td class="vrqty bold-td text-right">';
;echo '</td>
									<td class="bold-td text-right" colspan="3">Subtotal</td>
									<td class="bold-td"></td>
								</tr> -->
								<tr style="amountborder-bottom:1px dotted #ccc;" class="group-tot">
									<!-- <td class="bold-td"></td> -->
									<td class="text-right " colspan="2">Grand Total:</td>
									<td class="text-right" >';echo  number_format($Total_Qty,2);;echo '</td>
									<td class="text-right" >';echo  number_format($Total_Weight,2);;echo '</td>									
								</tr>
							</tfoot>
							';};echo '						</table>
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
					<div class="row-fluid">
						<div class="span12">
							<table class="signature-fields">
								<thead>
									<tr>
										<th>Approved By</th>
										<th>Accountant</th>
										<th>Received By</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="row-fluid">
						<p>
							<span class="loggedin_name">User: ';echo $user;;echo '</span><br>
							<span class="website">Sofware By: www.alnaharsolution.com</span>
						</p>
					</div>

				</div>
			</div>
		</div>
	</body>
	</html>	';
?>