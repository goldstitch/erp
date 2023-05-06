

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
			 .field {font-weight: bold; display: inline-block; width: 100px; } 
			 .voucher-table{ border-collapse: collapse; }
			 table { width: 100%; border: 0.5px solid black; border-collapse:collapse; table-layout:fixed;margin-top: 8%;}
			 th { border: 0.5px solid black; padding: 5px; }
			 td { /*text-align: center;*/ vertical-align: top; /*padding: 5px 10px;*/ border-left: 0.5px solid black;}
			 td:first-child { text-align: left; }
			 .voucher-table thead th {background: #ccc; } 
			 tfoot {border-top: 0.5px solid black; } 
			 .bold-td { font-weight: bold; border-bottom: 1px solid black;}
			 .nettotal { font-weight: bold; font-size: 11px !important; border-top: 1px solid black; }
			 .invoice-type { border-bottom: 1px solid black; }
			 .relative { position: relative; }
			 .signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			 .signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			 .inv-leftblock { width: 280px; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 10px; font-family: tahoma; line-height: 14px; padding: 4px; } 
			 .rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			 .inwords, .remBalInWords { text-transform: uppercase; }
			 .barcode { margin: auto; }
			 h3.invoice-type {font-size: 20px; line-height: 24px;}
			 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; margin: 5px 0px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;}
			 .nettotal { color: red; font-size: 10px;}
			 .remainingBalance { font-weight: bold; color: blue;}
			 .centered { margin: auto; }
			 p { position: relative; font-size: 10px; }
			 thead th { font-size: 10px; font-weight: normal; }
			 .fieldvalue.cust-name {position: absolute; width: 497px; } 
			 @media print {
			 	.noprint, .noprint * { display: none; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right; }
			.item-row td { font-size: 10px; padding: 5px;}

			
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative; top: 34px; }
			tfoot tr td { font-size: 10px; padding: 5px; }
			.nettotal, .subtotal, .vrqty { font-size: 10px !important; font-weight: normal !important;}
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
								<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">
									<span class="field">';echo strtoupper($pledger[0]['etype']) .'#';;echo '</span><span class="fieldvalue inv-vrnoa">';echo $pledger[0]['dcno'];;echo '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span class="field">Date</span><span class="fieldvalue inv-date">';echo date( 'd-M-Y ',strtotime( $pledger[0]['date']));;echo '</span>
									<!-- <input type="date" name="" value="" placeholder=""> -->
								</div>
								<div class="block pull-right" style="width:400px !important; float: right; display:inline !important;">
									<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative; top: 20px; ">';echo $title;;echo '</h3>
								</div>
						</div>
					</div>
					<br>
					<br>
					
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr>
									<th class="text-center" style=" width: 9px; padding: 0; ">Sr#</th>
									<th class="text-left" style=" width: 30px; ">Chq Date</th>
									<th class="text-left" style=" width: 80px; ">Account</th>
									<th class="text-left" style=" width: 80px; ">Remarks</th>
									<th style=" width: 20px; ">Inv#</th>
									<th style=" width: 40px; ">Wo#</th>
									<th style=" width: 40px; ">Cheq#</th>
									<th  class="text-right" style=" width: 40px; ">Debit</th>
									<th  class="text-right" style=" width: 40px; ">Credit</th>
								</tr>
							</thead>

							<tbody>
								
								';
$serial = 1;
$Total_Debit = 0.00;
$Total_Credit = 0.00;
if (empty($pledger)) {
}
else{
foreach ($pledger as $row): 
$Total_Debit += $row['debit'];
$Total_Credit += $row['credit'];
;echo '									
									<tr style="amountborder-bottom:0.5px dotted #ccc;" class="item-row">
									   <td > ';echo $serial++;;echo '</td>
									   <td  class=\'text-left\'>';echo $row['chq_date'];;echo '</td>
									   <td class=\'text-left\' >';echo $row['party_name'];;echo ' </td>
									   <td  class=\'text-left\'>';echo $row['description'];;echo '</td>
									   <td  class=\'text-right\'>';echo $row['invoice'];;echo '</td>
									   <td  class=\'text-right\'>';echo $row['wo'];;echo '</td>
									   <td  class=\'text-right\'>';echo $row['chq_no'];;echo '</td>
									   <td  class="text-right">';echo number_format($row['debit'],2);;echo '</td>
									   <td  class="text-right">';echo number_format($row['credit'],2);;echo '</td>
									</tr>

								';endforeach ;echo '								';
;echo '							
							
							<!-- 	<tr class="foot-comments">
									<td class="vrqty bold-td text-right">';
;echo '</td>
									<td class="bold-td text-right" colspan="3">Subtotal</td>
									<td class="bold-td"></td>
								</tr> -->
								<tr style="amountborder-bottom:0.5px dotted #ccc;" class="item-row">
									<td class="bold-td"></td>
									<td class="text-right " colspan="6">Total</td>
									<td class="text-right ">';echo number_format($Total_Debit,2);;echo '</td>
									<td class="text-right ">';echo number_format($Total_Credit,2);;echo '</td>
								</tr>
							</tbody>
							';};echo '						</table>
						<strong>In words: </strong> <span class="inwords"></span>';echo strtoupper($amtInWords);;echo ' &nbsp; ONLY <br>
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
										<th>Prepared By</th>
										<th>Checked By</th>
										<th>GM Finance</th>
										<th>Director</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="row-fluid">
						<p>
							<span class="loggedin_name">User:';echo $user;;echo '</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<!-- <span class="loggedin_name">, Unit:';echo $this->session->userdata('company_name');;echo '</span> -->
							<!-- <span class="website">Sofware By: www.alnaharsolution.com</span> -->
						</p>
					</div>

				</div>
			</div>
		</div>
	</body>
	</html>	';
?>