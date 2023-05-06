

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
	<title>Staff Status Report</title>

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
			text-align: center;
		}
		.table {
			width: 100%;
		}
		.table td {
			padding-left: 5px !important;
			padding-top: 0px !important;
			padding-bottom: 0px !important;
			padding-right: 0px !important;
			border-top: none;
			border: 1px solid #333;
		}
		.table tr {
			border: 1px solid #333;
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
			margin-bottom: 3px;
		}
		.headingtitle {
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
		.spec {
			background: rgba(90, 96, 111, 0.5) !important;
			color: #fff !important;
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
			.spec {
				background: rgba(90, 96, 111, 0.5) !important;
				color: #fff !important;
			}
			.headingtitle {
				text-align: center;
				display: block;
				font-size: 16px;
				padding: 5px 0px 5px 0px;
			}
			#heading{
				background: #eee !important;
				margin-bottom: 3px;
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

			<div id=\'heading\'>
				<span class=\'headingtitle\'></span>
			</div>
			<div id="subheading">
				<span class=\'headingtitle\'></span>
			</div>
			<div class="row">
                &nbsp&nbsp&nbsp
                <span style="font-weight:bolder !important; font-size: 14px !important;">Presents:</span>
                <span class="Presents">0</span>&nbsp

                <span style="font-weight:bolder !important; font-size: 14px !important;">Absents:</span>
                <span class="Absents">0</span>&nbsp
                <span style="font-weight:bolder !important; font-size: 14px !important;">Paid Leave:</span>
                <span class="Paid-Leave">0</span>&nbsp
                <span style="font-weight:bolder !important; font-size: 14px !important;">Unpaid Leave:</span>
                <span class="Unpaid-Leave">0</span>&nbsp
                <span style="font-weight:bolder !important; font-size: 14px !important;"> Rest Day:</span>
                <span class="Rest-Day">0</span>&nbsp
                <span style="font-weight:bolder !important; font-size: 14px !important;">Gusted Holiday:</span>
                <span class="Gusted-Holiday">0</span>&nbsp
                <span style="font-weight:bolder !important; font-size: 14px !important;">Short Leave:</span>
                <span class="Short-Leave">0</span>&nbsp
                <span style="font-weight:bolder !important; font-size: 14px !important;">Outdoor:</span>
                <span class="Outdoor">0</span>&nbsp
			</div>
			<div class="atnd-container">
				<table id="atnd" border=\'1px\' style=\'width: 100%;\'>
				</table>
			</div>
			<br>
			<div class="row-fluid">
				<p>
					<span class="loggedin_name"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
					<span class="company_name"></span>
					
				</p>
			</div>
	</div>


	<script src=\'../../../assets/js/jquery.min.js\'></script>
	<script src=\'../../../assets/bootstrap/js/bootstrap.min.js\'></script>

	<script>
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
		var opener = window.opener;
		$(opener.$(\'#atnd-table\').html()).appendTo(\'#atnd\');
		$(\'td\').addClass(\'center\');
		$(\'th\').addClass(\'center\');
		$(\'th\').addClass(\'paddingspace\');
		$(\'#atnd thead tr th\').addClass(\'spec\');
		$(\'.headingtitle\').text(opener.$(\'.page_title\').text().trim());
		if(opener.$(\'.page_title\').text().trim()==\'Staff Attendance Report\'){
			var fromDate = opener.$(\'#from_date\').val();
			var toDate = opener.$(\'#to_date\').val();

			var dateParts = [];
			var separator = ( fromDate.indexOf(\'/\') === -1 ) ? \'-\' : \'/\';
			dateParts = fromDate.split(separator);
			var fromDate = dateParts[2] + \'-\' + getMonthName(parseInt(dateParts[1], 10)) + \'-\' + dateParts[0];

			var dateParts = [];
			var separator = ( toDate.indexOf(\'/\') === -1 ) ? \'-\' : \'/\';
			dateParts = toDate.split(separator);
			var toDate = dateParts[2] + \'-\' + getMonthName(parseInt(dateParts[1], 10)) + \'-\' + dateParts[0];

			$(\'#subheading .headingtitle\').text(fromDate + " To " + toDate);		
		}else{
			$(\'#subheading .headingtitle\').text("Month - Year: " + opener.$(\'.month_year_picker\').val());		
		}
		$(document).attr(\'title\', opener.$(\'.page_title\').text().trim());

		$(\'.Presents\').html(opener.$(\'.Presents\').html().trim());
	    $(\'.Absents\').html(opener.$(\'.Absents\').html().trim());
	    $(\'.Paid-Leave\').html(opener.$(\'.Paid-Leave\').html().trim());
	    $(\'.Unpaid-Leave\').html(opener.$(\'.Unpaid-Leave\').html().trim());
	    $(\'.Rest-Day\').html(opener.$(\'.Rest-Day\').html().trim());
	    $(\'.Gusted-Holiday\').html(opener.$(\'.Gusted-Holiday\').html().trim());
	    $(\'.Short-Leave\').html(opener.$(\'.Short-Leave\').html().trim());
	    $(\'.Outdoor\').html(opener.$(\'.Outdoor\').html().trim());

	    $(\'.loggedin_name\').html(\'User: \' + opener.$(\'#uname\').val().trim());
	    $(\'.company_name\').html(\'Unit: \' + opener.$(\'#company_name\').val().trim());
	    

		window.print();

		$(\'.btnPdfDownload\').on(\'click\', function(e) {
			e.preventDefault();
		});
	</script>
</body>
</html>';
?>