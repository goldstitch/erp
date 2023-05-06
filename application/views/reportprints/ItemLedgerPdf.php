

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
	<title>Item Ledger Report</title>

	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">

	<style>
		* { margin: 0; padding: 0; font-family: tahoma; }
		body { font-size:10px; font-family: tahoma !important; }
	p { margin: 0; /* line-height: 17px; */ }
	.field {font-weight: bold; display: inline-block; width: 100px; } 
	.field1 {font-weight: bold; display: inline-block; width: 150px; } 
	.voucher-table{ border-collapse: collapse; }
	/*table { width: 100%; border: .5px solid black; border-collapse:collapse; table-layout:fixed; margin-left:1px;margin-top:20px;}*/
	table { width: 100% !important; border: 1px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:0px}
	th { border: 0.5px solid black; padding: 5px; }
	td { /*text-align: center;*/ vertical-align: top;  }
	td:first-child { text-align: left; }
	.voucher-table thead th {background: grey; }
	.voucher-table{margin-top: -29px !important;  } 
	.voucher-table{  }
	tfoot {border-top: 0.5px solid black; } 
	.bold-td { font-weight: bold; border-bottom: 0px solid black;}
	.nettotal { font-weight: bold; font-size: 10px !important; border-top: 0.5px solid black; }
	.invoice-type { border-bottom: .5px solid black; }
	.relative { position: relative; }
	.signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
	.signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
	.inv-leftblock { width: 280px; }
	.text-left { text-align: left !important; }
	.text-right { text-align: right !important; }
	td {font-size: 9px; font-family: tahoma; line-height: 14px; padding: 4px; } 
	.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
	.inwords, .remBalInWords { text-transform: uppercase; }
	.barcode { margin: auto; }
	h3.invoice-type {font-size: 10px; line-height: 10px; text-align: center !important;}
	.extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; margin: 5px 0px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;}
	.nettotal { color: red; font-size: 9px;}
	.remainingBalance { font-weight: bold; color: blue;}
	.centered { margin: auto; }
	p { position: relative; font-size: 10px; }
	thead th { font-size: 10px; font-weight: bold; padding: 5px; border: 0.5px solid !important; }
	.fieldvalue.cust-name {position: absolute; width: 497px; } 
	@media print {
		.noprint, .noprint * { display: none; }
	}
	.pl20 { padding-left: 10px !important;}
	.pl40 { padding-left: 20px !important;}

	.barcode { float: right; }
	.item-row td { font-size: 9px; padding: 3px; border: 0.5px solid black;}


	h3.invoice-type { border: none !important; margin: 0px !important; position: relative; top: 0px; }
	tfoot tr td { font-size: 10px; padding: 5px;  }
	.nettotal, .subtotal, .vrqty,.vrweight { font-size: 10px !important; font-weight: bold !important;}

	tr { page-break-inside: avoid;	}
	.txtbold{font-weight: bold !important;}
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
					<div class="row-fluid">
						<h3 class="invoice-type text-center">';echo $title;;echo '</h3>
					</div>
					<div class="span12">
						<div class="block pull-left inv-leftblock" style="width:100px !important; display:inline !important;">
							<span class="field1">Dated From: </span><span class="fieldvalue inv-date">';echo date('d-M-y',strtotime($from)) .' - To - '.date('d-M-y',strtotime($to));;echo '</span>
						</div>
					</div>
					<div class="span12">
						<div class="block pull-left inv-leftblock" style="width:100px !important; display:inline !important;">
							<span class="field1">Item: </span><span class="fieldvalue inv-date">';echo $vrdetail[0]['item_des'] .', ( Uom:'.$vrdetail[0]['uom'] .' )';;echo '</span>
						</div>
					</div>
				</div>
				<br>
				<br>
				<br>

				<div class="row-fluid">
					<table class="voucher-table" style="clear: both !important;">
						<thead style="color:white !important; " >
							
								<tr>
									<th style=" width: 60px !important; ">Date</th>
									<th style=" width: 70px; ">Vr#</th>
									<th style=" width: 100px;" >Account</th>
									<th style=" width: 60px; ">Location</th>
									<th style=" width: 40px; ">Rate</th>
									<th style=" width: 60px; ">In</th>
									<th style=" width: 60px; ">Out</th>
									<th style=" width: 60px; ">Balance</th>
									<th style=" width: 60px; ">WeightIn</th>
									<th style=" width: 60px; ">WeightOut</th>
									<th style=" width: 60px; ">Balance</th>
								</tr>
							</thead>

							<tbody>
								<tr class="item-row">
									<td > ';echo date('d-M-y',strtotime($date_start));;echo '</td>
									<td 	class=\'text-left\' > </td>
									<td  class=\'text-left\' >Opening</td>
									<td  class=\'text-left\'></td>
									<td  class="text-right"></td>
									<td  class="text-right">';echo ($OpeningQty >0?number_format($OpeningQty,2):'-');;echo '</td>
									<td  class="text-right">';echo ($OpeningQty <0?number_format(abs($OpeningQty),2):'-');;echo '</td>
									<td  class="text-right">';echo ($OpeningQty !=0?number_format($OpeningQty):'-');;echo '</td>
									<td  class="text-right">';echo ($OpeningWeight>0?number_format($OpeningWeight,2):'-');;echo '</td>
									<td  class="text-right">';echo ($OpeningWeight<0?number_format(abs($OpeningWeight),2):'-');;echo '</td>
									<td  class="text-right">';echo ($OpeningWeight !=0?number_format($OpeningWeight,2):'-');;echo '</td>
								</tr>
								';
$serial = 1;
$RTotalQty = $OpeningQty;
$RTotalWeight =$OpeningWeight;
$Total_Qty = 0.00;
$Total_Weight = 0.00;
$Total_Qty_Out = 0.00;
$Total_Weight_Out = 0.00;
if (empty($vrdetail)) {
}
else{
foreach ($vrdetail as $row): 
$RTotalQty += $row['qty'];
$RTotalWeight += $row['weight'];
$Total_Qty += ($row['qty'] >0?$row['qty']:0);
$Total_Qty_Out += ($row['qty'] <0?$row['qty']:0);
$Total_Weight += ($row['weight']>0 ?$row['weight']:0);
$Total_Weight_Out += ($row['weight']<0 ?$row['weight']:0);
;echo '										<tr  class="item-row">
											<td > ';echo date('d/M/y',strtotime($row['date']));;echo '</td>
											<td 	class=\'text-left\' >';echo strtoupper( substr($row['etype'],0,6) .'-'.$row['vrnoa']);;echo ' </td>
											<td  class=\'text-left\' >';echo $row['party_name'];;echo '</td>
											<td  class=\'text-left\'>';echo $row['name'];;echo '</td>
											<td  class="text-right">';echo number_format($row['rate'],2);;echo '</td>
											<td  class="text-right">';echo ($row['qty'] >0?number_format($row['qty'],2):'-');;echo '</td>
											<td  class="text-right">';echo ($row['qty'] <0?number_format(abs($row['qty']),0):'-');;echo '</td>
											<td  class="text-right">';echo ($RTotalQty !=0?number_format($RTotalQty):'-');;echo '</td>
											<td  class="text-right">';echo ($row['weight']>0?number_format($row['weight'],2):'-');;echo '</td>
											<td  class="text-right">';echo ($row['weight']<0?number_format(abs($row['weight']),2):'-');;echo '</td>
											<td  class="text-right">';echo ($RTotalWeight !=0?number_format($RTotalWeight,2):'-');;echo '</td>
										</tr>
									';endforeach ;echo '									';
;echo '


									<tr  class="item-row">

										<td class="text-right txtbold" colspan="5">Total</td>
										<td class="text-right txtbold" >';echo  number_format($Total_Qty,2);;echo '</td>
										<td class="text-right txtbold" >';echo  number_format($Total_Qty_Out,2);;echo '</td>
										<td class="text-right txtbold "></td>
										<td class="text-right txtbold" >';echo  number_format($Total_Weight,2);;echo '</td>
										<td class="text-right txtbold" >';echo  number_format($Total_Weight_Out,2);;echo '</td>
										<td class="text-right txtbold "></td>
									</tr>

								';};echo '							</tbody>
						</table>
					</div>
					
					<br> 
					<br> 
					<div class="row-fluid">
						<div class="span12">
							<table class="signature-fields">
								<thead>
									<tr>
										<th>Approved By</th>
										<td></td>
										<th>Received By</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="row-fluid">
						<p>
							<span class="loggedin_name">User: ';echo $user;;echo '</span>&nbsp &nbsp &nbsp &nbsp &nbsp
							<span class="loggedin_name">Unit: ';echo $this->session->userdata('company_name');;echo '</span><br>
							<!-- <span class="website">Sofware By: www.alnaharsolution.com</span> -->
						</p>
					</div>

				</div>
			</div>
		</div>
	</body>
	</html>	';
?>