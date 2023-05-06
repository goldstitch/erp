

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
	<title>Trial Balance Report</title>

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
		}
		.level1head td { background: #2d2d2d !important;color: white !important;border: none !important; }
		.level2head td { background: grey !important;border: none !important;color: white !important; }
		.level3head td { background: lightgrey !important;color: black;border: none !important; }
		.finalsum td {background: wheat !important;}

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
			.spec1 {
				background: #756565 !important;
				color: #fff;
				text-align: left;
				padding-left:10px;
			}
			.spec2 {
				background: rgba(90, 96, 111, 0.5) !important;
				color: #fff;
				text-align: left;
				padding-left:10px;
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
			.level1head td { background: #2d2d2d !important;color: white !important;border: none !important; }
			.level2head td { background: grey !important;border: none !important;color: white !important; }
			.level3head td { background: lightgrey !important;color: black;border: none !important; }
			.finalsum td {background: wheat !important;}
		}
	</style>
</head>
<body>

	<div id="wrap">
		<div class="container-fluid">

			<div id=\'heading\'>
				<span id=\'headingtitle\'>Trial Balance Report</span>
			</div>

			<div class="staffstatus-container">
				<table id="staffstatus" border=\'1px\' style=\'width: 100%;\'>
				</table>
			</div>
	</div>


	<script src=\'../../../assets/js/jquery.min.js\'></script>
	<script src=\'../../../assets/bootstrap/js/bootstrap.min.js\'></script>

	<script>

		var opener = window.opener;
		$(opener.$(\'table\').html()).appendTo(\'#staffstatus\');
		$(\'td\').addClass(\'center\');
		$(\'th\').addClass(\'center\');
		$(\'th\').addClass(\'paddingspace\');
		$(\'#headingtitle\').text(opener.$(\'.page_title\').text().trim());

		window.print();

		$(\'.btnPdfDownload\').on(\'click\', function(e) {
			e.preventDefault();
		});
	</script>
</body>
</html>';
?>