

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
	<title class="shadowhead">Salary Sheet</title>

	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<style>
		body {
			color: #333;
			font-family: tahoma !important;
			font-size: 10px;
		}
		.xs-small {
			font-size: 8px;
		}
		.small {
			font-size: 10px;
		}
		.medium {
			font-size: 11px;
		}
		#wrap {
			margin-top: 20px;
			margin-bottom: 20px;
		}
		.center{
			text-align: right;
		}
		.text-left{
			text-align: left;
		}

		.table {
			width: 100%;
		}
		thead{
			clear: both !important;
		}
		.table td {
			padding-left: 5px !important;
			padding-top: 0px !important;
			padding-bottom: 0px !important;
			padding-right: 0px !important;
			border-top: none;
			/*border: 1px solid #333;*/
			border: none;
		}
		.table tr {
			border-top: 1px; ;
		}
		.borderr {
			border: 1px solid black;
			clear: both !important;
		}
		.table .thead {
			background: rgb(215, 215, 230);
		}
		.paddingspace {
			padding: 3px !important;
		}
		.bold {
			font-weight: bold;
		}
		#printdate {
			display: block;
			text-align: right;
			padding-right: 145px;
			font-size: 14px;
			padding-bottom: 6px;
		}
		#heading{
			background: #eee !important;
			margin-bottom: 15px;
		}
		#headingtitle {
			text-align: center;
			display: block;
			font-size: 16px;
			padding: 5px 0px 5px 0px;
		}
		.dept_name_head {
			padding-left: 32px;
			font-weight: bold;
			padding-top: 6px;
			padding-bottom: 6px;
		}
		.text-right {
			
			text-align: right !important;
		}

		@media print {
			.btnPdfDownload {
				display: none;
			}
			@page {
				size: landscape;
			}
			body {
				-webkit-print-color-adjust: exact;
				-moz-print-color-adjust: exact;
			}
			#heading{
				background: #eee !important;
				margin-bottom: 15px;
			}
			#headingtitle {
				text-align: center;
				display: block;
				font-size: 16px;
				padding: 5px 0px 5px 0px;
			}
		}

        tr{
            page-break-inside: avoid;
        }

        @media print {
            thead {display: table-header-group;}
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

			<span id=\'printdate\'>Print Date:</span>
			<div id=\'heading\'>
				<span id=\'headingtitle\'>Salary Sheet For The Month Of <span id=\'month\'></span>, <span id=\'year\'></span> </span>
			</div>

			<div class="salarysheet-container">
				<table id="salarysheet" >
				</table>
			</div>
	</div>


	<script src=\'../../../assets/js/jquery.min.js\'></script>
	<script src=\'../../../assets/bootstrap/js/bootstrap.min.js\'></script>

	<script>

		var opener = window.opener;
		$(opener.$(\'#salary_table\').html()).appendTo(\'#salarysheet\');
		$(\'td\').addClass(\'center\');
		$(\'th\').addClass(\'center\');
		$(\'th\').addClass(\'paddingspace\');
		$(\'<th class="center">Signature</th>\').insertAfter($(\'#salarysheet thead tr th\').last());
		$(\'#salarysheet tbody tr\').each(function(index, elem) {
			$(\'<td class="center"></td>\').insertAfter( $(elem).find(\'td\').last());
		});
		// $(\'*\').removeAttr(\'style\');
		// $(\'#salarysheet thead th\').eq(5).text("Abs");
		// $(\'#salarysheet thead th\').eq(12).text("OT");
		// $(\'#salarysheet thead th\').eq(22).text("Social Sec");
		$(\'.dept_name\').closest(\'td\').hide();
		$(\'.absent\').closest(\'td\').hide();
        $(\'.leave_wp\').closest(\'td\').hide();
        $(\'.leave_wop\').closest(\'td\').hide();
        $(\'.leave_gholiday\').closest(\'td\').hide();
        $(\'.leave_outdoor\').closest(\'td\').hide();
        $(\'.leave_sleave\').closest(\'td\').hide();
        $(\'.rest_days\').closest(\'td\').hide();
        $(\'.work_days\').closest(\'td\').hide();
        // $(\'.overtime\').closest(\'td\').hide();
        $(\'.balance\').closest(\'td\').hide();
        $(\'.penalty\').closest(\'td\').hide();
        $(\'.eobi\').closest(\'td\').hide();
        $(\'.insurance\').closest(\'td\').hide();
        $(\'.socialsec\').closest(\'td\').hide();

        $(\'.so\').closest(\'td\').addClass(\'text-left\');
        $(\'.name\').closest(\'td\').addClass(\'text-left\');
        $(\'.designation\').closest(\'td\').addClass(\'text-left\');
        $(\'.staff_id\').closest(\'td\').addClass(\'text-left\');
        $(\'.sorting_1\').closest(\'td\').addClass(\'text-left\');


        $(\'thead th\').closest(\'th\').addClass(\'borderr\');

		$(\'thead th\').eq(\'1\').hide();

		var dept_name = "";
		var gross_bsalary =0;
		var gross_paiddays =0;
		var gross_salary =0;
		var gross_othours =0;
		var gross_otamount =0;
		var gross_inventive =0;
		var gross_gsalary =0;
		var gross_advance =0;
		var gross_loan =0;
		var gross_netsalary =0;

		var net_bsalary =0;
		var net_paiddays =0;
		var net_salary =0;
		var net_othours =0;
		var net_otamount =0;
		var net_inventive =0;
		var net_gsalary =0;
		var net_advance =0;
		var net_loan =0;
		var net_netsalary =0;

		
		var lng = $(\'#salarysheet\').find(\'tbody tr\').length;;

		$(\'#salarysheet tbody tr\').each(function(index, elem) {
			var d_name = $(elem).find(\'td\').eq(1).text().trim();
			if (dept_name != d_name) {
				if(index!=0){
					$(\'<tr style="font-size:10px !important;font-weight:bolder !important; color:red; border-top:1px solid black;"> <td colspan="5" class="text-right">Total:</td><td colspan="1" class="text-right">\'+ gross_bsalary +\'</td> <td colspan="1" class="text-right">\'+ \'\' +\'</td><td colspan="1" class="text-right">\'+ gross_salary +\'</td><td colspan="1" class="text-right">\'+ gross_othours +\'</td><td colspan="2" class="text-right">\'+ gross_otamount +\'</td><td colspan="1" class="text-right">\'+ gross_inventive +\'</td><td colspan="1" class="text-right">\'+ gross_gsalary +\'</td><td colspan="1" class="text-right">\'+ gross_advance +\'</td><td colspan="1" class="text-right">\'+ gross_loan +\'</td><td colspan="1" class="text-right">\'+ gross_netsalary +\'</td><td></td></tr>\').insertBefore($(elem).closest(\'tr\'));	
				}
				dept_name = d_name;
				$(\'<tr style="font-size:12px !important;font-weight:bolder !important; color:green; border-bottom:1px solid black;"><td colspan="24" class="dept_name_head">\'+ dept_name +\'</td></tr>\').insertBefore($(elem).closest(\'tr\'));

				gross_bsalary =0;
				gross_paiddays =0;
				gross_salary =0;
				gross_othours =0;
				gross_otamount =0;
				gross_inventive =0;
				gross_gsalary =0;
				gross_advance =0;
				gross_loan =0;
				gross_netsalary =0;
			}

			gross_bsalary +=parseFloat($(elem).find(\'td\').eq(6).text().trim());
			gross_paiddays +=parseFloat($(elem).find(\'td\').eq(15).text().trim());
			gross_salary +=parseFloat($(elem).find(\'td\').eq(16).text().trim());
			gross_othours +=parseFloat($(elem).find(\'td\').eq(17).text().trim());
			gross_otamount +=parseFloat($(elem).find(\'td\').eq(19).text().trim());
			gross_inventive +=parseFloat($(elem).find(\'td\').eq(20).text().trim());
			gross_gsalary +=parseFloat($(elem).find(\'td\').eq(21).text().trim());
			gross_advance +=parseFloat($(elem).find(\'td\').eq(22).text().trim());
			gross_loan +=parseFloat($(elem).find(\'td\').eq(23).text().trim());
			gross_netsalary +=parseFloat($(elem).find(\'td\').eq(29).text().trim());

			net_bsalary +=parseFloat($(elem).find(\'td\').eq(6).text().trim());
			net_paiddays +=parseFloat($(elem).find(\'td\').eq(15).text().trim());
			net_salary +=parseFloat($(elem).find(\'td\').eq(16).text().trim());
			net_othours +=parseFloat($(elem).find(\'td\').eq(17).text().trim());
			net_otamount +=parseFloat($(elem).find(\'td\').eq(19).text().trim());
			net_inventive +=parseFloat($(elem).find(\'td\').eq(20).text().trim());
			net_gsalary +=parseFloat($(elem).find(\'td\').eq(21).text().trim());
			net_advance +=parseFloat($(elem).find(\'td\').eq(22).text().trim());
			net_loan +=parseFloat($(elem).find(\'td\').eq(23).text().trim());
			net_netsalary +=parseFloat($(elem).find(\'td\').eq(29).text().trim());

			if(index == lng-1 ){
					$(\'<tr style="font-size:10px !important;font-weight:bolder !important; color:red; border:1px solid black; "> <td colspan="5" class="text-right">Grand Total:</td><td colspan="1" class="text-right">\'+ parseFloat(net_bsalary).toFixed(2) +\'</td> <td colspan="1" class="text-right">\'+ \'\' +\'</td><td colspan="1" class="text-right">\'+ net_salary +\'</td><td colspan="1" class="text-right">\'+ net_othours +\'</td><td colspan="2" class="text-right">\'+ net_otamount +\'</td><td colspan="1" class="text-right">\'+ net_inventive +\'</td><td colspan="1" class="text-right">\'+ net_gsalary +\'</td><td colspan="1" class="text-right">\'+ net_advance +\'</td><td colspan="1" class="text-right">\'+ net_loan +\'</td><td colspan="1" class="text-right">\'+ net_netsalary +\'</td><td></td></tr>\').insertAfter($(elem).closest(\'tr\'));	
					$(\'<tr style="font-size:10px !important;font-weight:bolder !important; color:black; border-top:1px solid black; "> <td colspan="5" class="text-right">Total:</td><td colspan="1" class="text-right">\'+ gross_bsalary +\'</td> <td colspan="1" class="text-right">\'+ \'\' +\'</td><td colspan="1" class="text-right">\'+ gross_salary +\'</td><td colspan="1" class="text-right">\'+ gross_othours +\'</td><td colspan="2" class="text-right">\'+ gross_otamount +\'</td><td colspan="1" class="text-right">\'+ gross_inventive +\'</td><td colspan="1" class="text-right">\'+ gross_gsalary +\'</td><td colspan="1" class="text-right">\'+ gross_advance +\'</td><td colspan="1" class="text-right">\'+ gross_loan +\'</td><td colspan="1" class="text-right">\'+ gross_netsalary +\'</td><td></td></tr>\').insertAfter($(elem).closest(\'tr\'));	


				}


		});

		var months = [\'January\', \'February\', \'March\', \'April\', \'May\', \'June\', \'July\', \'August\', \'September\', \'October\', \'November\', \'December\'];
    	var d = new Date();
    	

    	// for converting 0 => -
    	$(\'#salarysheet tbody tr\').each(function(){
    		$(this).find(\'td\').each(function(){
    			var txt =  $(this).text().trim();
    			if (txt=="0" || txt=="0.00") $(this).text("-");
    		});
    	});
    	
    	var etype = opener.$(\'.page_title\').text();
    	$(\'.shadowhead\').html(etype);
    	$(\'#headingtitle\').html(etype + \' For The Month Of \'  + months[d.getMonth()] + \', \' + d.getFullYear()  );
    	// $(\'#year\').text();
    	// $(\'#month\').text(]);
		window.print();

		$(\'.btnPdfDownload\').on(\'click\', function(e) {
			e.preventDefault();
		});

        var head = $(\'table thead tr\');
        $( "tbody tr:nth-child(30)" ).after(head.clone());
        $( "tbody tr:nth-child(68n)" ).after(head.clone());

	</script>
</body>
</html>';
?>