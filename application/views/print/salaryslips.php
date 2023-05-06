

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
	<title>Salary Slips</title>

	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<style>
		body {
			color: #333;
			font-family: tahoma !important;
			font-size: 10px;
		}
		.paidopt {
			margin-bottom: 2px;
			text-align: right;
			margin-right: 2px;
		}
		.paiddate {
			font-size: 12px;
			font-weight: bold;
			font-family: sans-serif;
		}
		.paiddatevalue {
			width: 118px;
			border-bottom: 1px solid #000;
			display: inline-block;
			margin-left: 5px;
		}
		.salaryslip {
			display: inline-block;
			width: 350px;
			margin-right: 40px;
			margin-bottom: 50px;
			border: 1px solid !important;
		}
		tr {
			line-height: 22px;
		}
		.about {
			font-weight: bold;
			width: 115px;
			display: block;
			font-size: 11px;
			font-family: sans-serif;
		}
		.title {
			background: blue;
			color: #fff;
			padding: 5px 6px 5px 6px;
			font-size: 12px;
			border-radius: 2px;
			margin-bottom: 10px;
			display: block;
			text-align: center;
		}
		.empinf, .salaryinfo {
			margin-bottom: 8px;
			padding:3px;
		}
		.value {
			font-size: 11px;
			font-family: sans-serif;
			min-width: 50px;
		}
		.netsalhead {
			font-size: 12px;
			font-weight: bold;
			font-family: sans-serif;
			display: inline-block;
			margin-right: 5px;
		}
		.netsalval{
			font-size: 16px;
			font-weight: bold;
			font-family: sans-serif;
		}

		@media print {
			.btnPdfDownload {
				display: none;
			}
			@page {
				size: portrait;
			}
			body {
				-webkit-print-color-adjust: exact;
				-moz-print-color-adjust: exact;
			}
			.title {
				background: blue !important;
				color: #fff !important;
				padding: 5px 6px 5px 6px;
				font-size: 12px;
				border-radius: 2px;
				margin-bottom: 10px;
				display: block;
				text-align: center;
			}
		}
	</style>
</head>
<body>

	<div id="wrap">
		<div class="container-fluid">

			<div class="row divider hide">
				<div class="col-lg-12">
					<a class="btn btn-default btnPdfDownload"><i class="fa fa-download"></i> PDF Download</a>
				</div>
			</div>

			<div class="salaryslips-container">
				
			</div>
	</div>


	<script src=\'../../../assets/js/jquery.min.js\'></script>
	<script src=\'../../../assets/bootstrap/js/bootstrap.min.js\'></script>

	<script>

		var opener = window.opener;
		var slip = "";

		function getMonthName (monthNum) {
				switch(monthNum) {
					case 1 :
					return \'Jan\';
					break;
					case 2 :
					return \'Feb\';
					break;
					case 3 :
					return \'Mar\';
					break;
					case 4 :
					return \'Apr\';
					break;
					case 5 :
					return \'May\';
					break;
					case 6 :
					return \'Jun\';
					break;
					case 7 :
					return \'Jul\';
					break;
					case 8 :
					return \'Aug\';
					break;
					case 9 :
					return \'Sep\';
					break;
					case 10 :
					return \'Oct\';
					break;
					case 11 :
					return \'Nov\';
					break;
					case 12 :
					return \'Dec\';
					break;
				}
			}
		opener.$(\'#salary_table tbody tr\').each(function(index, elem) {
			var staid 		= $.trim($(this).find(\'.name\').data(\'staid\'));
			var name 		= $.trim($(this).find(\'.name\').text());
			var dept 		= $.trim($(this).find(\'.dept_name\').text());
			var designation = $.trim($(this).find(\'.designation\').text());

			var bsalary = $.trim($(this).find(\'.bsalary\').text());
			var gross_salary = $.trim($(this).find(\'.gross_salary\').text());
			var leave_wop = $.trim($(this).find(\'.leave_wop\').text());
			var absent = $.trim($(this).find(\'.absent\').text());
			var leave_wp = $.trim($(this).find(\'.leave_wp\').text());
			var paid_days = $.trim($(this).find(\'.paid_days\').text());
			var work_days = $.trim($(this).find(\'.work_days\').text());
			var rest_days = $.trim($(this).find(\'.rest_days\').text());
			var othour = $.trim($(this).find(\'.othour\').text());
			var otrate = $.trim($(this).find(\'.otrate\').text());
			var overtime = $.trim($(this).find(\'.overtime\').text());
			var advance = $.trim($(this).find(\'.advance\').text());
			var loan_deduction = $.trim($(this).find(\'.loan_deduction\').text());
			var eobi = $.trim($(this).find(\'.eobi\').text());
			var incentive = $.trim($(this).find(\'.incentive\').text());

			var penalty = $.trim($(this).find(\'.penalty\').text());
			var insurance = $.trim($(this).find(\'.insurance\').text());
			var socialsec = $.trim($(this).find(\'.socialsec\').text());

			var deduction = parseFloat(penalty) + parseFloat(insurance) + parseFloat(socialsec);

			var net_salary = $.trim($(this).find(\'.net_salary\').text());

			slip += 	"<div class=\'salaryslip\'>"+
					"<img class=\'rcpt-header\' src=\'../../../assets/img/an.png\' alt=\'\' style=\'    height: 150px !important;\'> "+
								"<div class=\'empinf\'>"+
									"<table>"+
										"<tr class=\'\'>"+
											"<td><span class=\'about\'>Sid</span></td>"+
											"<td><span class=\'value\'>"+ staid +"</span></td>"+
										"</tr>"+
										"<tr>"+
											"<td><span class=\'about\'>Name and Cnic:</span></td>"+
											"<td><span class=\'value\'>"+ name +"</span></td>"+
										"</tr>"+
										"<tr>"+
											"<td><span class=\'about\'>Designation</span></td>"+
											"<td><span class=\'value\'>"+ designation +"</span></td>"+
										"</tr>"+
										"<tr>"+
											"<td><span class=\'about\'>Department</span></td>"+
											"<td><span class=\'value\'>"+ dept +"</span></td>"+
										"</tr>"+
										"<tr>"+
											"<td><span class=\'about\'>Month&Year</span></td>"+
											"<td><span class=\'month\'></span>, <span class=\'year\'></span></td>"+
										"</tr>"+
									"</table>"+
								"</div>"+
				
								"<div class=\'salaryinfo\'>"+
									"<table>"+
										"<tr>"+
											"<td class=\'about\'>B Salary</td>"+
											"<td class=\'value\'>"+ bsalary +"</td>"+
											"<td class=\'about\'>House Rent</td>"+
											"<td class=\'value\'> - </td>"+
										"</tr>"+
										"<tr>"+
											"<td class=\'about\'>Other Allowances</td>"+
											"<td class=\'value\'> - </td>"+
											"<td class=\'about\'>Gross Salary</td>"+
											"<td class=\'value\'>"+ gross_salary +"</td>"+
										"</tr>"+
										"<tr>"+
											"<td class=\'about\'>Absent</td>"+
											"<td class=\'value\'>"+ absent +"</td>"+
											"<td class=\'about\'>Paid Leave</td>"+
											"<td class=\'value\'>"+ leave_wp +"</td>"+
										"</tr>"+
										"<tr>"+
											"<td class=\'about\'>Rest Days</td>"+
											"<td class=\'value\'>"+ rest_days +"</td>"+
											"<td class=\'about\'>Work Days</td>"+
											"<td class=\'value\'>"+ work_days +"</td>"+
										"</tr>"+
										"<tr>"+
											"<td class=\'about\'>Paid Days</td>"+
											"<td class=\'value\'>"+ work_days +"</td>"+
											"<td class=\'about\'>Unpaid Leave</td>"+
											"<td class=\'value\'>"+ leave_wop +"</td>"+
										"</tr>"+
										"<tr>"+
											"<td class=\'about\'>OT Houe</td>"+
											"<td class=\'value\'>"+ othour +"</td>"+
											"<td class=\'about\'>OT Rate</td>"+
											"<td class=\'value\'>"+ otrate +"</td>"+
										"</tr>"+
										"<tr>"+
											"<td class=\'about\'>Overtime</td>"+
											"<td class=\'value\'>"+ overtime +"</td>"+
											"<td class=\'about\'>Advance</td>"+
											"<td class=\'value\'>"+ advance +"</td>"+
										"</tr>"+
										"<tr>"+
											"<td class=\'about\'>Deduction</td>"+
											"<td class=\'value\'>"+ loan_deduction +"</td>"+
											"<td class=\'about\'>EOBI</td>"+
											"<td class=\'value\'>"+ eobi +"</td>"+
										"</tr>"+
										"<tr>"+
											"<td class=\'about\'>Other Deduction</td>"+
											"<td class=\'value\'>"+ deduction +"</td>"+
											"<td class=\'about\'>Incentive</td>"+
											"<td class=\'value\'>"+ incentive +"</td>"+
										"</tr>"+
									"</table>"+
								"</div>"+
								"<p><span class=\'netsalhead\'>Net Salary:</span><span class=\'netsalval\'>"+ net_salary +"</span></p>"+
							"</div>";

		});

		$(slip).appendTo(\'.salaryslips-container\');
		

		var months = [\'January\', \'February\', \'March\', \'April\', \'May\', \'June\', \'July\', \'August\', \'September\', \'October\', \'November\', \'December\'];
  		
  		var d = new Date();

  		var C_Date = opener.$(\'#to_date\').val();
		var separator = ( C_Date.indexOf(\'/\') === -1 ) ? \'-\' : \'/\';
		dateParts = C_Date.split(separator);

  		$(\'.year\').text(dateParts[0]);
  		$(\'.month\').text(getMonthName(parseInt(dateParts[1], 10)));

		window.print();

		$(\'.btnPdfDownload\').on(\'click\', function(e) {
			e.preventDefault();
		});
	</script>
</body>
</html>';
?>