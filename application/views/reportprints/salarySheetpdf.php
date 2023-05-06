
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
		<title>Salary Sheet</title>

		<style>
			 * { margin: 0; padding: 0; font-family: tahoma !important; margin-bottom:1px !important; }
			 body { font-size:14px !important; }
			 p { margin: 0 !important; /* line-height: 17px !important; */ }
			 .field { font-size:12px !important; font-weight: bold !important; display: inline-block !important; width: 100px !important; } 
			 .field1 { font-size:12px !important; font-weight: bold !important; display: inline-block !important; width: 150px !important; } 
			 .voucher-table{ border-collapse: none !important; }
			 table { width: 100% !important; border: 1px solid black !important; border-collapse:collapse !important; table-layout:fixed !important; margin-left:1px}
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
			 td {font-size: 14px !important; font-family: tahoma !important; line-height: 14px !important; padding: 4px !important; }
			 .rcpt-header { width: 550px !important; margin: auto !important; display: block !important; }
			 .inwords, .remBalInWords { text-transform: uppercase !important; }
			 .barcode { margin: auto !important; }
			 h3.invoice-type {font-size: 16px !important; line-height: 24px !important;}
			 .extra-detail span { background: #7F83E9 !important; color: white !important; padding: 5px !important; margin-top: 17px !important; display: block !important; margin: 5px 0px !important; font-size: 12px !important; text-transform: uppercase !important; letter-spacing: 1px !important;}
			 .nettotal { color: red !important; font-size: 12px !important;}
			 .remainingBalance { font-weight: bold !important; color: blue !important;}
			 .centered { margin: auto !important; }
			 p { position: relative !important; font-size: 12px !important; }
			 thead th { font-size: 14px !important; font-weight: bold !important; padding: 10px !important; }
			 .fieldvalue { font-size:12px !important; position: absolute !important; width: 497px !important; }

			 @media print {
			 	.noprint, .noprint * { display: none !important; }
			 }
			 .pl20 { padding-left: 20px !important;}
			 .pl40 { padding-left: 40px !important;}
				
			.barcode { float: right !important; }
			.item-row td { font-size: 14px !important; padding: 10px !important; border-top: 1px solid black !important;}
			.item-row-subtotal {font-size:14px !important;font-weight:bolder !important; color:red; border-top:1px solid black;}

			.footer_company td { font-size: 8px !important; padding: 10px !important; border-top: 1px solid black !important;}

			.rcpt-header { width: 305px !important; margin: 0px !important; display: inline !important; position: absolute !important; top: 0px !important; right: 0px !important; }
			h3.invoice-type { border: none !important; margin: 0px !important; position: relative !important; top: 34px !important; }
			tfoot tr td { font-size: 10px !important; padding: 10px !important;  }
			.nettotal, .subtotal, .vrqty,.vrweight { font-size: 12px !important; font-weight: bold !important;}
			#headingtitle {
			text-align: center;
			display: block;
			font-size: 16px;
			padding: 5px 0px 5px 0px;
		}
		#printdate {
			display: block;
			text-align: right;
			padding-right: 0px;
			font-size: 14px;
			padding-bottom: 6px;
		}
		#heading{
			background: #eee !important;
			margin-bottom: 15px;
		}
		.dept_name_head {
			padding-left: 32px;
			font-weight: bold;
			padding-top: 6px;
			padding-bottom: 6px;
			font-size: 16px !important ;
		}
		.text-right {
			
			text-align: right !important;
		}
		tr{ page-break-inside: avoid;}

         tfoot tr td{
             font-size: 14px !important;
         }
		</style>
	</head>
	<body>
		<div class="container-fluid" style="">
			<div class="row-fluid">
				<div class="span12 centered">
					<div class="row-fluid">
						<h3 class="" style="font-size:30px; font-weight:boldger; text-align:center;">';echo $company_name;;echo '</h3>
					</div>
					<span id=\'printdate\' >Print Date: ';echo date('d-M-Y');;echo '</span>
					<div id=\'heading\'>
						<span id=\'headingtitle\'>Salary Sheet For The Month Of <span id=\'month\'>';echo date('M, Y',strtotime($vrdetail[0]['dts'] ));;echo '</span> </span>
					</div>
					<br>
					<br>
					<br>
					<div class="row-fluid">
						<table class="voucher-table">
							<thead>
								<tr>
									<th style=" width: 35px; ">Sr#</th>
									<th style=" width: 30px; text-align:right; ">Id</th>
									<th style=" width: 120px; text-align:left">Employee Name</th>
									<th style=" width: 100px; text-align:left">S/D/W/O</th>
									<th style=" width: 100px; text-align:left">Designation</th>
									<th style=" width: 130px; text-align:right">Basic Salary</th>
									<th style=" width: 50px; text-align:right">Paid Days</th>
									<th style=" width: 130px; text-align:right">Salary</th>
									<th style=" width: 50px; text-align:right">Ot Hour</th>
									<th style=" width: 50px; text-align:right">Ot Rate</th>
									<th style=" width: 70px; text-align:right">Ot Amount</th>
									<th style=" width: 60px; text-align:right">Incentive</th>
									<th style=" width: 60px; text-align:right">Penalty</th>

									<th style=" width: 130px; text-align:right">G Salary</th>
									<th style=" width: 70px; text-align:right">Advance</th>
									<th style=" width: 130px; text-align:right">Loan Deduction</th>
									<th style=" width: 130px; text-align:right">Net Salary</th>
									<th style=" width: 100px; text-align:right">Signature</th>
								</tr>
							</thead>
							<tbody>
								';
$dept_name = "";
$gross_bsalary =0;
$gross_paiddays =0;
$gross_salary =0;
$gross_othours =0;
$gross_otamount =0;
$gross_inventive =0;
$gross_penalty =0;
$gross_gsalary =0;
$gross_advance =0;
$gross_loan =0;
$gross_netsalary =0;
$index = -1;
$serial = 1;
$basalry = 0;
$pdays = 0;
$salary = 0;
$othour = 0;
$otamount = 0;
$incentive = 0;
$penalty=0
$gsalary = 0;
$advance = 0;
$ldeduction = 0;
$netsalary = 0;
foreach ($vrdetail as $row):
$index++;
$d_name = $row['department_name'];
if ($dept_name != $d_name) {
if($index!=0){
;echo '											<tr style="font-size:14px !important;font-weight:bolder !important; color:red; border-top:1px solid black; "> <td colspan="5" class="text-right" style="text-align:right !important;">Total:</td><td class="text-right">';echo ($gross_bsalary != '0')?$gross_bsalary : '-';;echo '</td><td class="text-right"></td><td class="text-right">';echo ($gross_salary != '0')?$gross_salary : '-';;echo '</td><td class="text-right">';echo ($gross_othours != '0')?$gross_othours : '-';;echo ' </td><td colspan="2" class="text-right">';echo ($gross_otamount != '0')?$gross_otamount : '-';;echo '</td>
												<td class="text-right">';echo ($gross_inventive != '0')?$gross_inventive : '-';;echo '</td>
												<td class="text-right">';echo ($gross_penalty != '0')?$gross_penalty : '-';;echo '</td>

												<td class="text-right">';echo ($gross_gsalary != '0')?$gross_gsalary : '-';;echo '</td><td class="text-right">';echo ($gross_advance != '0')?$gross_advance : '-';;echo '</td><td class="text-right">';echo ($gross_loan != '0')?$gross_loan : '-';echo '</td><td class="text-right">';echo ($gross_netsalary != '0')?$gross_netsalary : '-';;echo '</td><td></td></tr>	
										';}
$dept_name = $d_name;
;echo '	
											<tr style="font-size:116px !important;font-weight:bolder !important; color:green; border-bottom:1px solid black;"><td colspan="17" class="dept_name_head">';echo $dept_name ;echo '</td></tr>

										';
$gross_bsalary =0;
$gross_paiddays =0;
$gross_salary =0;
$gross_othours =0;
$gross_otamount =0;
$gross_inventive =0;
$gross_penalty =0;
$gross_gsalary =0;
$gross_advance =0;
$gross_loan =0;
$gross_netsalary =0;
}
$gross_bsalary += $row['bsalary'];
$gross_paiddays += $row['paid_days'];
$gross_salary += $row['gross_salary'];
$gross_othours += $row['othour'];
$gross_otamount += $row['overtime'];
$gross_inventive += $row['incentive'];
$gross_penalty += $row['penalty'];
$gross_gsalary += ($row['gross_salary'] +$row['incentive'] +$row['overtime']);
$gross_advance += $row['advance'];
$gross_loan += $row['loan_deduction'];
$ldeduction = $ldeduction +$row['loan_deduction'];
$gross_netsalary += $row['net_salary'];
$basalry += $row['bsalary'];
$pdays += $row['paid_days'];
$salary += $row['gross_salary'];
$othour += $row['othour'];
$otamount += $row['overtime'];
$incentive += $row['incentive'];
$penalty += $row['penalty'];
$gsalary += ($row['gross_salary'] +$row['incentive'] +$row['overtime']);
$advance += $row['advance'];
$netsalary += $row['net_salary'];
;echo '									<tr  class="item-row">
									   <td class=\'text-left\'>';echo $serial++;;echo '</td>
									   <td class=\'text-left\'>';echo $row['staid'];;echo '</td>
									   <td class=\'text-centre\'>';echo $row['name'];;echo '</td>
									   <td class=\'text-right\'>';echo $row['fname'];;echo '</td>
									   <td class=\'text-right\'>';echo $row['designation'];;echo '</td>
									   <td class="text-right">';echo ($row['bsalary']!= '0.00')?number_format(($row['bsalary']),2) : '-';;echo '</td>
									   <td class="text-right">';echo ($row['paid_days']-(int)($row['paid_days']) !=0 )?number_format(($row['paid_days']),1) : number_format(($row['paid_days']),0);;echo '</td>
									   <td class="text-right">';echo ($row['gross_salary']!= '0.00')?number_format(($row['gross_salary']),2) : '-';;echo '</td>
									   <td class="text-right">';echo ($row['othour']!= '0.00')?number_format(($row['othour']),2) : '-';;echo '</td>
									   <td class="text-right">';echo ($row['otrate']!= '0.00')?number_format(($row['otrate']),2) : '-';;echo '</td>
									   <td class="text-right">';echo ($row['overtime']!= '0.00')?number_format(($row['overtime']),2) : '-';;echo '</td>
									   <td class="text-right">';echo ($row['incentive']!= '0.00')?number_format(($row['incentive']),2) : '-';;echo '</td>
									   <td class="text-right">';echo ($row['gross_salary'] +$row['incentive'] +$row['overtime'] != '0.00')?number_format(($row['gross_salary'] +$row['incentive'] +$row['overtime'] ),2) : '-';;echo '</td>
									   <td class="text-right">';echo ($row['advance']!= '0.00')?number_format(($row['advance']),2) : '-';;echo '</td>
									   <td class="text-right">';echo ($row['loan_deduction']!= '0.00')?number_format(($row['loan_deduction']),2) : '-';;echo '</td>
									   <td class="text-right">';echo ($row['net_salary']!= '0.00')?number_format(($row['net_salary']),2) : '-';;echo '</td>
									   <td class="text-right"></td>
									</tr>
								';endforeach;echo '								<tr class="item-row-subtotal" > <td colspan="5" class="text-right" style="text-align:right !important;">Total:</td><td class="text-right">';echo ($gross_bsalary != '0')?$gross_bsalary : '-';;echo '</td><td class="text-right"></td><td class="text-right">';echo ($gross_salary != '0')?$gross_salary : '-';;echo '</td><td class="text-right">';echo ($gross_othours != '0')?$gross_othours : '-';;echo ' </td><td colspan="2" class="text-right">';echo ($gross_otamount != '0')?$gross_otamount : '-';;echo '</td><td class="text-right">';echo ($gross_inventive != '0')?$gross_inventive : '-';;echo '</td><td class="text-right">';echo ($gross_gsalary != '0')?$gross_gsalary : '-';;echo '</td><td class="text-right">';echo ($gross_advance != '0')?$gross_advance : '-';;echo '</td><td class="text-right">';echo ($gross_loan != '0')?$gross_loan : '-';echo '</td><td class="text-right">';echo ($gross_netsalary != '0')?$gross_netsalary : '-';;echo '</td><td></td></tr>

							
							
								<tr style="font-size:20px !important;font-weight:bolder !important; color:black; border-top:1px solid black;">
									<td class="text-right"></td>
									<td class="text-right"></td>
									<td class="text-right"></td>
									<td class="text-right"></td>
									<td class="text-right">Grand Total:</td>
									<td class="text-right">';echo ($basalry != '0.00')?number_format($basalry,2) : '-';;echo '</td>
									<td class="text-right"></td>
									<td class="text-right">';echo ($salary != '0.00')?number_format($salary,2) : '-';;echo '</td>
									<td class="text-right">';echo ($othour != '0.00')?number_format($othour,2) : '-';;echo '</td>
									<td class="text-right"></td>
									<td class="text-right">';echo ($otamount != '0.00')?number_format($otamount,2) : '-';;echo '</td>
									<td class="text-right">';echo ($incentive != '0.00')?number_format($incentive,2) : '-';;echo '</td>
									<td class="text-right">';echo ($gsalary != '0.00')?number_format($gsalary,2) : '-';;echo '</td>
									<td class="text-right">';echo ($advance != '0.00')?number_format($advance,2) : '-';;echo '</td>
									<td class="text-right">';echo ($ldeduction != '0.00')?number_format($ldeduction,2) : '-';;echo '</td>
									<td class="text-right">';echo ($netsalary != '0.00')?number_format($netsalary,2) : '-';;echo '</td>
									<td class="text-right"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<br>
					<br>
				</div>
			</div>
		</div>
	</body>
	</html>';
?>