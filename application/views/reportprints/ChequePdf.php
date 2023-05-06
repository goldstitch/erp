
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
		<title>Cheque</title>

	    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
	    <link
	     rel="stylesheet" href="../../assets/css/bootstrap-responsive.min.css">

		<style>
			 * { margin: 0; padding: 0; font-family: tahoma; }
			 body { font-size:12px; font-family: tahoma !important }
			 p { margin: 0; /* line-height: 17px; */ }
			 .field {font-weight: bold; display: inline-block; width: 80px; } 
			 .voucher-table{ border-collapse: collapse; }
			 table { width: 100%; border-collapse:collapse; table-layout:fixed;}
			 .tblField {font-weight: bold; font-size: 13px; }
			 .tblValue {border-bottom: 1px solid black !important; }
			 th { border: 1px solid black; padding: 5px; }
			 td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ }
			 td:first-child { text-align: left; }
			 .voucher-table thead th {background: #ccc; } 
			 tfoot {border-top: 1px solid black; } 
			 .bold-td { font-weight: bold; border-bottom: 1px solid black;}
			 .nettotal { font-weight: bold; font-size: 14px; border-top: 1px solid black; }
			 .invoice-type { border-bottom: 1px solid black; }
			 .relative { position: relative; }
			 .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
			 .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px; }
			 .inv-leftblock { width: 280px; }
			 .text-left { text-align: left !important; }
			 .text-right { text-align: right !important; }
			 td { font-family: tahoma; line-height: 14px; padding: 4px; border:none !important;} 
			 
			 .inwords, .remBalInWords { text-transform: uppercase; }
			 .barcode { margin: auto; }
			 h3.invoice-type {font-size: 20px; width: 209px; line-height: 24px;}
			 .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; } 
			 .nettotal { color: red; }
			 .remainingBalance { font-weight: bold; color: blue;}
			 .centered { margin: auto; }
			 p { position: relative; }
			 .fieldvalue.cust-name {position: absolute; width: 497px; } 
			 @media print {
			 	.noprint, .noprint * { display: none; }
			 }
			 @page{margin:0px auto;}
			 .tblHead {padding-top: 24px; padding-bottom: 15px; font-weight: bold; font-size: 15px; color: blue; }
			 td{padding-bottom: 10px; vertical-align: bottom !important; text-transform: uppercase;}
			 /*.voucherType {text-align: center !important; color: rgb(228, 19, 19); text-decoration: underline; padding-top: 0px; padding-bottom: 15px; }*/
			 .voucherType { text-align: center !important; color: rgb(228, 19, 19); text-decoration: none; padding-top: 0px;  font-size: 20px; font-weight: bold; position: relative;  }
			 .barcode { margin: 0; float: right;}

			 .rcpt-header { width: 1000px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }

		</style>	
	</head>
	<body>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12 centered">
					<div class="row-fluid">
						<div class="span12"><img class="rcpt-header" src="';echo $header_img;;echo '" alt=""></div>
					</div>

					<div class="row-fluid">
						<div class="span6">
							<h3 class="voucherType">';echo $title;;echo '</h3>
						</div>
						
						
					</div>
					<br><br>
					
					<div class="row-fluid">
						<table class="voucher-table">
							<thead></thead>
							<tbody>
								
								<tr>
									<td class="tblField">Vr#</td>
									<td class="tblValue tblDcno">';echo $pos_pd_cheque['dcno'];;echo '</td>
									<td class="tblField"></td>
									<td class="tblField">Date:</td>
									<td class="tblValue tblDate">';echo date('d-M-y',strtotime($pos_pd_cheque['vrdate']));;echo '</td>
								</tr>
								<tr>
									<td class="tblHead" colspan="5">Party Information</td>
								</tr>
								<tr>
									<td class="tblField">Party Name</td>
									<td class="tblValue tblPartyName" colspan="4">';echo $pos_pd_cheque['partyName'];;echo '</td>
								</tr>
								<tr>
									<td class="tblField">Bank Name</td>
									<td class="tblValue tblBankName" colspan="4">';echo $pos_pd_cheque['bank_name'];;echo '</td>
								</tr>
								<tr>
									<td class="tblField">Cheque #</td>
									<td class="tblValue tblChequeNo" colspan="2">';echo $pos_pd_cheque['cheque_no'] ?$pos_pd_cheque['cheque_no'] : '-- N/A --';;echo '</td>
									<td class="tblField">Cheque Date</td>
									<td class="tblValue tblChequeDate">';echo $pos_pd_cheque['cheque_date'] ?$pos_pd_cheque['cheque_date'] : '-- N/A --';;echo '</td>
								</tr>
								<tr>
									<td class="tblField">Slip #</td>
									<td class="tblValue tblSlipNo" colspan="2">';echo $pos_pd_cheque['slip_no'] ?$pos_pd_cheque['slip_no'] : '-- N/A --';;echo '</td>
									<td class="tblField">Status</td>
									<td class="tblValue tblStatus">';echo $pos_pd_cheque['status'] ?$pos_pd_cheque['status'] : '-- N/A --';;echo '</td>
								</tr>
								<tr>
									<td class="tblField">Amount</td>
									<td class="tblValue tblAmount" colspan="2">';echo $pos_pd_cheque['amount'];;echo '</td>
									<td colspan="2"><strong>In words: </strong> <span class="inwords"></span>';echo strtoupper($amtInWords);;echo ' &nbsp; ONLY </td>
								</tr>
								<tr>
									<td class="tblField">Tax</td>
									<td class="tblValue tblTax" colspan="2">';echo $pos_pd_cheque['taxpercent'] .'% '.$pos_pd_cheque['tax'];;echo '</td>
									<td colspan="1"><strong>NetAmount:</strong></td>

									<td class="tblValue tblStatus">';echo number_format($pos_pd_cheque['amount']-$pos_pd_cheque['tax'],0);;echo '</td>

								</tr>

								<tr>
									<td class="tblField">Note: </td>
									<td class="tblValue tblNote" colspan="4">';echo $pos_pd_cheque['note'] ?$pos_pd_cheque['note'] : '-- N/A --';;echo '</td>
								</tr>
								<tr>
									<td class="tblField">Remarks: </td>
									<td class="tblValue tblRemarks" colspan="4">';echo $pos_pd_cheque['remarks'] ?$pos_pd_cheque['remarks'] : '-- N/A --';;echo '</td>
								</tr>
								<tr>
									<td class="tblHead" colspan="5">Bank Information</td>
								</tr>
								<tr>
									<td class="tblField">Account: </td>
									<td class="tblValue tblPartyIdVr" colspan="4">';echo $pos_pd_cheque['partyName2'];;echo '</td>
								</tr>
								<tr>
									<td class="tblField">Mature Date</td>
									<td class="tblValue tblMatureDate" colspan="2">';echo $pos_pd_cheque['mature_date'] ?$pos_pd_cheque['mature_date'] : '-- N/A --';;echo '</td>
									<td class="tblField">Ledger Posting</td>
									<td class="tblValue tblLedgerPosting">';echo $pos_pd_cheque['post'];;echo '</td>
								</tr>

								<tr>
								<td class="tblField"></td>
								</tr>
								<tr>
								<td class="tblField"></td>
								</tr>
								<tr>
								<td class="tblField"></td>
								</tr>
								<tr>
								<td class="tblField"></td>
								</tr>
								<!-- <div class="row-fluid"> -->
						<!-- <div class="span12"> -->
							<table class="signature-fields">
								<thead>
									<tr>
										<th>Approved By</th>
										<th>Accountant</th>
										<th>Received By</th>
									</tr>
								</thead>
							</table>
						<!-- </div> -->
					<!-- </div> -->

								<tr>
									
									<!-- <td class="tblField">Software By: www.alnaharsolution.com.</td> -->
									<td class="tblValue1 tblMatureDate" colspan="3">';
;echo '</td>
									<td class="tblField">User: </td>

									<td class="tblValue tblLedgerPosting"  colspan="3">';echo $user;;echo '</td>

								</tr>
								<tr>
									
									<!-- <td class="tblField">Software By: www.alnaharsolution.com.</td> -->
									<td class="tblValue1 tblMatureDate" colspan="3">';
;echo '</td>
									<td class="tblField">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Unit: </td>

									<td class="tblValue tblLedgerPosting"  colspan="3">';echo $this->session->userdata('company_name');;echo '</td>

								</tr>


							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>	';
?>