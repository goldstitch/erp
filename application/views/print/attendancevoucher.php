

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
	<title>Attendance Voucher</title>

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
		.htsubtext {
			display: block;
			padding-bottom: 5px;
			padding-left: 10px;
			padding-top: 5px;
			padding-right: 5px;
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

			<span id=\'printdate\'>Print Date: <span class="txtprintDate">';echo date('Y-m-d');;echo '</span></span>
			<div id=\'heading\'>
				<span id=\'headingtitle\'>Attendance Voucher</span>
				<span class=\'htsubtext\' id=\'vrno\'>Voucher#: </span>
				<span class=\'htsubtext\' id=\'vrdate\'>Voucher Date: </span>
			</div>

			<div class="attend-container">
				<table id="attend" border=\'1px\'>
				</table>
			</div>
	</div>


	<script src=\'../../../assets/js/jquery.min.js\'></script>
	<script src=\'../../../assets/bootstrap/js/bootstrap.min.js\'></script>

	<script>

		var opener = window.opener;
		$(opener.$(\'#atnd-table\').html()).appendTo(\'#attend\');
		$(\'td\').addClass(\'center\');
		$(\'th\').addClass(\'center\');
		$(\'th\').addClass(\'paddingspace\');
		$(\'#vrno\').text("Voucher#: " + opener.$(\'#txtdcnoHidden\').val());
		$(\'#vrdate\').text("Voucher Date: : " + opener.$(\'#current_date\').val());
		
		//$(\'*\').removeAttr(\'style\');
		$(\'.dept_name\').closest(\'td\').hide();
		$(\'thead th\').eq(\'1\').hide();

		var dept_name = "";
		$(\'#attend tbody tr\').each(function(index, elem) {
			var d_name = $(elem).find(\'td\').eq(1).text().trim();
			if (dept_name != d_name) {
				dept_name = d_name;
				$(\'<tr><td colspan="5" class="dept_name_head">\'+ dept_name +\'</td></tr>\').insertBefore($(elem).closest(\'tr\'));
			}
		});

		$(\'#attend tbody tr input\').each(function(index, elem){    
			var val = $(elem).val(); 
			$(elem).closest(\'tr\').find(\'td\').last().text(val); 
			$(elem).remove();        
		});

		window.print();

		$(\'.btnPdfDownload\').on(\'click\', function(e) {
			e.preventDefault();
		});
	</script>
</body>
</html>';
?>