
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
		<title>Stock Transfer</title>

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
			 table { width: 100% !important; border: 2px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
			 th {  padding: 5px !important; }
			 td { /*text-align: center !important;*/ vertical-align: top !important;  }
			 td:first-child { text-align: left !important; }
			 .voucher-table thead th {background: #ccc !important; } 
			 tfoot {border-top: 1px solid black !important; } 
			 .bold-td { font-weight: bold !important; border-bottom: 0px solid black !important;}
			 .nettotal { font-weight: bold !important; font-size: 11px !important; border-top: 1px solid black !important; }
			 .invoice-type { border-bottom: 1px solid black !important; }
			 .relative { position: relative !important; }
			 .signature-fields{ font-size: 10px; border: none !important; border-spacing: 20px !important; border-collapse: separate !important;} 
			 .signature-fields th {border: 0px !important; border-top: 1px solid black !important; border-spacing: 10px !important; }
			 .inv-leftblock { width: 280px !important; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td {font-size: 12px !important; font-family: tahoma !important; line-height: 14px !important; padding: 4px !important; } 
			 .rcpt-header { width: 550px !important; margin: auto !important; display: block !important; }
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {font-size: 16px !important; line-height: 24px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 12px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto !important; }
			 p { position: relative !important; font-size: 12px !important; }
			 thead th { font-size: 12px !important; font-weight: bold !important; padding: 10px !important;border: 1px solid !important }
			 .fieldvalue { font-size:12px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 12px !important; padding: 10px !important; border-top: 1px solid black !important; border: 1px solid !important}
			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 1px solid black !important;}

			.rcpt-header { width: 305px !important; margin: 0px !important; display: inline !important; position: absolute !important; top: 0px !important; right: 0px !important; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 12px !important; font-weight: bold !important;}
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					<div class="row-fluid top-img-head">
						<div class="span12">
							<div class="span12"><img  class="logo-img" src="';echo $header_img;;echo '" width="700px;" alt="" ></div>
						</div>
					</div>
					<div class="row-fluid relative">
						<div class="span12">

								<div class="block pull-right" style="width:280px !important; float: right; display:inline !important;">
									
									<!-- <div class="span12"><img style="float:right; width:280px !important;" class="rcpt-header logo-img" src="';echo $header_img;;echo '" alt=""></div> -->
									<h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important; position: relative; top: 12px !important; ">';echo $title;;echo '</h3>
									<br>
								</div>
						</div>
					</div>
					<br>
					<br>
					<br>
				
				<h3>Item Wise</h3>
				<br>
   
				<div class="row-fluid">
				<table class="voucher-table">
					<thead>
						<tr>
							<th style=" width: 10px; ">Sr#</th>
							<th style=" width: 13px; text-align:left;">Item_Id</th>
							<th style=" width: 40px; text-align:left ;">Item_desc</th>
							<th style=" width: 15px; text-align:left;">Unit</th>
							<th style=" width: 20px; text-align:left;">Req Qty</th>
						</tr>
					</thead>

					<tbody>
						
						';
				$serial = 1;
				$netQty = 0;
				$netAmount=0;
				$netWeight=0;
				foreach ($rdetail as $row):
				$netQty += abs($row['req_qty']);
				;echo '									<tr  class="item-row">
							   <td class=\'text-centre\'>';echo $serial++;;echo '</td>
							   
							   <td class=\'text-centre\'>';echo $row['item_id'];;echo '</td>
							   <td class=\'text-left\'>';echo $row['item_desc'];;echo '</td>
							   <td class=\'text-left\'>';echo (($row['unit']));;echo '</td>
							   <td class="text-left">';echo (($row['req_qty']));;echo '</td>
							</tr>
							
						';endforeach;echo '							</tbody>
				</table>
			</div>
			<br>
			<h3>Sample Wise</h3>
			<br>
					
					
				<div class="row-fluid">
					<table class="voucher-table">
						<thead>
							<tr>
								<th style=" width: 10px; ">Sr#</th>
								<th style=" width: 15px; text-align:left; ">Sample_Id</th>
								<th style=" width: 10px; ">Qty</th>
								<th style=" width: 13px; text-align:left;">Item_Id</th>
								<th style=" width: 40px; text-align:left ;">Item_desc</th>
								<th style=" width: 15px; text-align:left;">Unit</th>
								<th style=" width: 20px; text-align:left;">Req Qty</th>
							</tr>
						</thead>

						<tbody>
							
							';
					$serial = 1;
					$netQty = 0;
					$netAmount=0;
					$netWeight=0;
					foreach ($vrdetail as $row):
					$netQty += abs($row['req_qty']);
					;echo '									<tr  class="item-row">
								   <td class=\'text-centre\'>';echo $serial++;;echo '</td>
								   <td class=\'text-centre\'>';echo $row['sample_id'];;echo '</td>
								   <td class=\'text-centre\'>';echo $row['qty'];;echo '</td>
								   <td class=\'text-centre\'>';echo $row['item_id'];;echo '</td>
								   <td class=\'text-left\'>';echo $row['item_desc'];;echo '</td>
								   <td class=\'text-left\'>';echo (($row['unit']));;echo '</td>
								   <td class="text-left">';echo (($row['req_qty']));;echo '</td>
								</tr>
								
							';endforeach;echo '							</tbody>
						<tfoot>
							<tr class="foot-comments">
								
								<td class="subtotal bold-td text-right"></td>
								<td class="subtotal bold-td text-right"></td>
								<td class="subtotal bold-td text-right"></td>
								<td class="subtotal bold-td text-right" colspan="3">Subtotal:</td>
								<td class="subtotal bold-td text-left">';echo number_format($netQty,2);;echo '</td>
							</tr>
						</tfoot>
					</table>
				</div>
					<!-- <div class="row-fluid">
						<div class="span12 add-on-detail1" style="margin-top: 10px;">
							<p class="" style="text-transform1: uppercase;">
								<strong>In words: </strong> <span class="inwords"></span>';echo strtoupper($amtInWords);;echo ' &nbsp; ONLY <br>
								<br>
								';if ( $pre_bal_print==1  ){;echo '									<!-- <p><span class="field1">Previous Balance:</span><span class="fieldvalue inv-vrnoa">';echo number_format($previousBalance,0);;echo '</span></p>
									<p><span class="field1">This Invoice:</span><span class="fieldvalue inv-date">';echo number_format($vrdetail[0]['namount'],0);;echo '</span></p>
									<p><span class="field1">Current Balance:</span><span class="fieldvalue cust-name">';echo number_format($vrdetail[0]['namount']+$previousBalance,2) ;;echo '</span></p> -->
								';};;echo '							</p>
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
							<span class="footer_company">User:';echo $user;;echo '</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<span class="footer_company">, Unit:';echo $this->session->userdata('company_name');;echo '</span>
							<!-- <span class="footer_company">Sofware By: www.alnaharsolution.com</span> -->
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>';
?>