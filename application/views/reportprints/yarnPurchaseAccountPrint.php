
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
			 * { margin: 0; padding: 0; font-family: tahoma !important; }
			 body { font-size:10px !important; }
			 p { margin: 0 !important; /* line-height: 17px !important; */ }
			 .field { font-size:12px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .field1 { font-size:12px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: none !important; }
			 table { width: 100% !important; border: none !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
			 th {  padding: 5px !important;border-top:1px solid black;border-bottom:1px solid black; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child {  }
			 tr{page-break-inside: avoid;}
			 /*.voucher-table thead th {background: #ccc !important; font-color :white !important; } */
			 .voucher-table thead th { font-color :white !important; } 
			 tfoot {border-top: none !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 11px !important; border-top: 0px solid black !important; }
			 .invoice-type { border-bottom: 0px solid black !important; }
			 .relative { position: relative !important; }
			  .signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			 .signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			 .inv-leftblock { width: 280px !important; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 .text-centre { text-align: center !important; }
			 td {font-size: 12px !important; font-family: tahoma !important; line-height: 14px !important; padding: 4px !important; } 
			 
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {font-size: 16px !important; line-height: 24px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 12px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto !important; }
			 p { position: relative !important; font-size: 12px !important; }
			 thead th { font-size: 12px !important; font-weight: bold !important; padding: 10px !important; }
			 .fieldvalue { font-size:12px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			/*.item-row td { font-size: 12px !important; padding: 10px !important; border-top: 0px solid black !important;}*/
			.item-row td { font-size: 12px !important; padding: 10px !important; border-top: none !important;}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: none !important;}

			.rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.subtotalend { font-size: 12px !important; font-weight: bold !important;text-align: right !important; }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 12px !important; font-weight: bold !important;text-align: right !important; color: red;}
			.header{width:100%;}
			.top{width: 100%;margin:0 auto;text-align: center;border-bottom: 1px solid black;padding-bottom: 5px;}
			.top h1{font-size: 32px;text-transform: uppercase;text-align: center !important;}
			.top h1 .print-date{float: right !important;font-size: 12px;font-weight: normal;}
			.clear{clear: both;}
			.bottom{width: 100%;padding-top: 10px;}
			.title{width: 67%;float: left;}

			.box{width: 30%;border:1px solid black;text-align: right;float: right;}
			.title h1 {text-transform: uppercase;text-decoration: underline;text-align: center;}
			.box-tbl td{padding: 15px;}
			.tbl-headings{border:none;margin-top:10px !important;}
			.tbl-headings tbody tr{border:none;}
			.detail{width: 100%;}
			.underline{text-decoration: underline;}
		
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					<div class="header clear">
<!-- 						<div class="top clear">
							<h1>cf Purchase Voucher<span class=\'print-date\'>Printed On : 04-12-2016</span> </h1>
							<h1>CHINIOT FABRICS </h1>
							<h2>Accounts Voucher</h2>
							

						</div> -->
						<div class="row-fluid">
							<div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>
						</div>
						<div class="bottom clear">
							<div class="title">
								<h1>';echo $title;;echo '</h1>
									';if ( $check==1  ){;echo '										<table class="tbl-headings">
											<tbody >
												<tr>
													<td style="width:30px;" class="text-left" >PO#</td>
													<td style="width:90px;" class="text-left">';echo $vrdetail[0]['ordno'];;echo '</td>
													<!-- <td style="width:30px;" class="text-left">Rate</td>
													<td style="width:90px;" class="text-left">5677</td> -->
													<td style="width:60px;" class="text-left">WO#</td>
													<td style="width:90px;" class="text-left">';echo $vrdetail[0]['workorderno'];;echo '</td>
												</tr>
											</tbody>
										</table>
									';};;echo '							</div>

							<div class="box">
								<table class="box-tbl">
									<tbody>
										<tr>
											<td class="text-left" >Voucher Number</td>
											<td class="text-right">';echo ($etype=='sale'?'HE/'.$vrdetail[0]['dcno'] .'/'.substr($vrdetail[0]['date'],2,2) .'/'.$vrdetail[0]['pid'] : $vrdetail[0]['dcno']);;echo '</td>
										</tr>
										<tr>
											<td class="text-left">Voucher Date</td>
											<td class="text-right">';echo date('d-M-y',strtotime($vrdetail[0]['date']));;echo '</td>
										</tr>
										<tr>
											<td class="text-left">Entry Date</td>
											<td class="text-right">';echo date('d-M-y',strtotime($vrdetail[0]['datetime']));;echo '</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- <div class="row-fluid">
						<div class="span12"><img class="rcpt-header" src="';
;echo '" alt=""></div>
					</div> -->
					<div class="row-fluid relative">
						<div class="span12">
							<!-- 	<div class="block pull-left inv-leftblock" style="width:250px !important; display:inline !important;">
									<p><span class="field">ssInvoice#</span><span class="fieldvalue inv-vrnoa">';
;echo '</span></p>									
									<p><span class="field">Date:</span><span class="fieldvalue inv-date">';
;echo '</span></p>
									<p><span class="field ">M/S:</span><span class="fieldvalue cust-name">';
;echo '</span></p>
									<p><span class="field ">WO#</span><span class="fieldvalue cust-name">';
;echo '</span></p>
									<p><span class="field">Remarks:</span><span class="fieldvalue cust-mobile">';
;echo '</span></p>
								</div> -->
								<!-- <div class="block pull-right" style="width:280px !important; float: right; display:inline !important;">
									<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative; top: 12px !important; ">';
;echo '</h3>
								</div> -->
						</div>
					</div>
					<br>
					<br>
					<br>
					<br/>
					<br/>
					<br/>
					<br/>
					
					<div class="row-fluid clear">

						<table class="voucher-table">
							<thead>
								<tr >
									<th style=" width: 20px; text-align:left; " >Code</th>
									<th style=" width: 50px; text-align:left; ">Description</th>
									<th style=" width: 40px;" class=\'text-left\'>Narration</th>
									<th style=" width: 20px;" class=\'text-right\'>Debit</th>
									<th style=" width: 20px;" class=\'text-right\'>Credit</th>
								
								</tr>
							</thead>

							<tbody>
								
								';
$serial = 1;
$netQty = 0;
$netDebit=0;
$netCredit=0;
$typee='';
$typee22='';
foreach ($vrdetail as $row):
;echo '										
									
									<tr  class="item-row">
									   <td class=\'text-left\'>';echo  substr($row['account_id'],9) ."<br/>".$row['pid']  ;echo '</td>
									   <td class=\'text-left\'>';echo substr($row['account_id'],9) ."<br/>".$row['name'];;echo '</td>
									   <td class=\'text-left\'>';echo $row['description'];;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['debit']),2);;echo '</td>
									   <td class=\'text-right\'>';echo number_format(abs($row['credit']),2);;echo '</td>
									   
									</tr>
									
								';
$netDebit += abs($row['debit']);
$netCredit += abs($row['credit']);
endforeach;echo '							</tbody>
							<tfoot>
								<tr class="foot-comments">
									<td style="text-align:left !important;border:none !important;" class="subtotalend bold-td text-left" colspan="">In Words</td>
									<td style="text-align:left !important;border:none !important;" class="subtotalend bold-td text-left underline" colspan="">';echo convert_number($netDebit).' '.'Only';;echo '</td>
									<td style="border-top:1px solid black !important;" class="subtotalend bold-td text-right" colspan="">Total:</td>
									<td style="border-top:1px solid black !important;" class="subtotalend bold-td text-right">';echo number_format($netDebit,2);;echo '</td>
									<td style="border-top:1px solid black !important;" class="subtotalend bold-td text-right">';echo number_format($netCredit,2);;echo '</td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="row-fluid">
						<div class="span12 add-on-detail1" style="margin-top: 10px;">
							<p class="" style="text-transform1: uppercase;">
								<!-- <strong>In words: </strong> <span class="inwords"></span>';echo convert_number($netDebit).' ';
;echo ' &nbsp; ONLY <br> -->
								<br>
									';
;echo '										';if ( $pre_bal_print==1  ){;echo '											<p><span class="field1">Previous Balance:</span><span class="fieldvalue inv-vrnoa">';
;echo '</span></p>
											<p><span class="field1">This Invoice:</span><span class="fieldvalue inv-date">';
;echo '</span></p>
											<p><span class="field1">Current Balance:</span><span class="fieldvalue cust-name">';
;echo '</span></p>
										';};;echo '									';
;echo '							</p>
						</div>
					</div>
					<!-- End row-fluid -->
					<br>
					<br>
					<!-- <div class="detail">
						<p>Detail : <span>A</span></p>
					</div> -->
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
							<span class="footer_company">User:';echo $user;;echo '</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<!-- <span class="footer_company">, Unit:';echo $this->session->userdata('company_name');;echo '</span> -->
						</p>
					</div>
					';
function convert_number($number) 
{
if (($number <0) ||($number >999999999)) 
{
throw new Exception("Number is out of range");
}
$Gn = floor($number / 1000000);
$number -= $Gn * 1000000;
$kn = floor($number / 1000);
$number -= $kn * 1000;
$Hn = floor($number / 100);
$number -= $Hn * 100;
$Dn = floor($number / 10);
$n = $number %10;
$res = "";
if ($Gn) 
{
$res .= convert_number($Gn) ." Million";
}
if ($kn) 
{
$res .= (empty($res) ?"": " ") .
convert_number($kn) ." Thousand";
}
if ($Hn) 
{
$res .= (empty($res) ?"": " ") .
convert_number($Hn) ." Hundred";
}
$ones = array("","One","Two","Three","Four","Five","Six",
"Seven","Eight","Nine","Ten","Eleven","Twelve","Thirteen",
"Fourteen","Fifteen","Sixteen","Seventeen","Eightteen",
"Nineteen");
$tens = array("","","Twenty","Thirty","Fourty","Fifty","Sixty",
"Seventy","Eigthy","Ninety");
if ($Dn ||$n) 
{
if (!empty($res)) 
{
$res .= " and ";
}
if ($Dn <2) 
{
$res .= $ones[$Dn * 10 +$n];
}
else 
{
$res .= $tens[$Dn];
if ($n) 
{
$res .= "-".$ones[$n];
}
}
}
if (empty($res)) 
{
$res = "zero";
}
return  strtoupper($res);
}
$cheque_amt = 8747484 ;
;echo '				</div>
			</div>
		</div>
	</body>
	</html>';
?>