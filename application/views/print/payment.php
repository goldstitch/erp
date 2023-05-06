

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
	<title>Payment Report</title>

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
			background: #eee;
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
				background: #eee !important;
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
				<span id=\'headingtitle\'></span>
			</div>

			<p id="print_date" class=\'center\'></p>

			<div class="report-container">
				<table id="report" border=\'1px\'>
				</table>
			</div>
	</div>


	<script src=\'../../../assets/js/jquery.min.js\'></script>
	<script src=\'../../../assets/bootstrap/js/bootstrap.min.js\'></script>

	<script>
		var opener = window.opener;
		$(opener.$(\'table\').html()).appendTo(\'#report\');
		$(\'#headingtitle\').text(opener.$(\'.page_title\').text().trim());
		$(\'td\').addClass(\'center\');
		$(\'th\').addClass(\'center\');
		$(\'th\').addClass(\'paddingspace\');

		var from = opener.$(\'#from_date\').val().trim();
		var to = opener.$(\'#to_date\').val().trim();

		$(\'#print_date\').text(from + " To " + to);

		if (opener.$(\'.page_title\').text().trim().search(\'Contribution Report\') != -1) {

			$(\'.dept_name\').closest(\'td\').hide();
			$(\'thead th\').eq(\'5\').hide();
			var dept_name = "";
			$(\'#report tbody tr\').each(function(index, elem) {
				var d_name = $(elem).find(\'td\').eq(5).text().trim();
				if (dept_name != d_name) {
					dept_name = d_name;
					$(\'<tr><td colspan="24" class="dept_name_head">\'+ dept_name +\'</td></tr>\').insertBefore($(elem).closest(\'tr\'));
				}
			});
		}

		window.print();
	</script>
</body>
</html>';
?>