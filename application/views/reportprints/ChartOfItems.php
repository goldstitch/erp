

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
		 .field {font-weight: bold; display: inline-block; width: 150px; } 
		 .voucher-table{ border-collapse: collapse; }
		 table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed;margin-top: 8%;}
		 th { border: 1px solid black; padding: 5px; }
		 td { /*text-align: center;*/ vertical-align: top; /*padding: 5px 10px;*/ border-left: 1px solid black;}
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
		 .rcpt-header { width: 450px; margin: auto; display: block; }
		 .inwords, .remBalInWords { text-transform: uppercase; }
		 .barcode { margin: auto; }
		 h3.invoice-type {font-size: 20px;}
		 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; margin: 5px 0px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;}
		 .nettotal { color: red; font-size: 12px;}
		 .group1row { color: red; font-size: 10px;font-weight: bold;}
		 .group1row-right { color: red; font-size: 10px;font-weight: bold;text-align: right;}

		 .l2row { color: green; font-size: 10px;font-weight: bold;}
		 .l2row-right { color: green; font-size: 10px;font-weight: bold;text-align: right;}

		 .l3row { color: blue; font-size: 10px;font-weight: bold;}
		 .l3row-right { color: blue; font-size: 10px;font-weight: bold;text-align: right;}

		 .remainingBalance { font-weight: bold; color: blue;}
		 .centered { margin: auto; }
		 p { position: relative; font-size: 16px; }
		 thead th { font-size: 16px; font-weight: bold; }
		 .fieldvalue.cust-name {position: absolute; width: 497px; } 
		 @media print {
		 	.noprint, .noprint * { display: none; }
		 }
		 .pl20 { padding-left: 20px !important;}
		 .pl40 { padding-left: 40px !important;}
			
		.barcode { float: right; }
		.item-row td { font-size: 15px; padding: 10px;}

		.rcpt-header { width: 205px !important; margin: 0px; display: inline; position: absolute; top: 0px; right: 0px; }
		h3.invoice-type { font-size: 26px; border: none !important; margin: 0px !important; position: relative; }
		tfoot tr td { font-size: 13px; padding: 5px; }
		.nettotal, .subtotal, .vrqty { font-size: 14px !important; font-weight: normal !important;}
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
					<div class="block pull-left inv-leftblock" style="width:150px !important; display:inline !important;">
						<h3 class="invoice-type text-left">';echo $title;;echo '</h3>
						<!-- <p><span class="field">Dated From: </span><span class="fieldvalue inv-date">';echo $date_between;;echo '</span></p> -->
					</div>
					<div class="block pull-right" style="width:300px !important; float: right; display:inline !important;">
						<div class="span12"><img style="float:right; width:350px !important;height:80px;" class="rcpt-header logo-img" src="';echo $header_img;;echo '" alt=""></div>
						
					</div>
			</div>
		</div>
		
		
		<div class="row-fluid">
			<table class="voucher-table">
				<thead>
					<tr>
						<th style=" width: 80px; ">Id</th>
						<th style=" width: 100px; ">Code</th>
						<th style=" width: 100px; ">Brand</th>
						<th style=" width: 100px; ">Article#</th>
						<th style=" width: 250px; ">Description</th>
						<th style=" width: 80px; ">Uom</th>
						<th style=" width: 80px; ">Price</th>
						<th style=" width: 100px; ">Weight</th>
					</tr>
				</thead>

		<tbody>
			
			';
$serial = 1;
$group1='';
if (empty($items)) {
}
else{
foreach ($items as $row): 
;echo '				';if ($group1 !=$row['category_name'] ){;echo '					<tr style="amountborder-bottom:1px dotted #ccc;" class="item-row">
					   <td 	class=\'group1row\' >';echo $row['category_name'];;echo ' </td>
					</tr>

				';$group1= $row['category_name'];}
;echo '				<tr style="amountborder-bottom:1px dotted #ccc;" class="item-row">
				   <td 	class=\'text-left\' >';echo $row['item_id'];;echo ' </td>
				   <td  class=\'text-left\'>';echo $row['item_code'];;echo '</td>
				   <td  class=\'text-left\'>';echo $row['artcile_no'];;echo '</td>
				   <td  class="text-right">';echo ($row['item_description']);;echo '</td>
				   <td  class="text-right">';echo ($row['uom']);;echo '</td>
				   <td  class="text-right">';echo ($row['srate']);;echo '</td>
				</tr>
			';endforeach ;echo '		</tbody>
				';};echo '			</table>
		</div>
		<br> 
		<br> 
		<br> 
		<br> 
		<div class="row-fluid">
			<div class="span12">
				<table class="signature-fields">
					<thead>
						<tr>
							<th >Prepared By</th>
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