

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Report</title>
	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

	<div id=\'heading\'>
		<span id=\'headingtitle\'></span>
	</div>

	<p id="print_date" class=\'center\'></p>
	
	<table>
		
	</table>

	<script src=\'../../../assets/js/jquery.min.js\'></script>
	<script src=\'../../../assets/bootstrap/js/bootstrap.min.js\'></script>

	<script>
		var opener = window.opener;
		opener.$(\'#report-table\').html().appendTo(\'#report\');

		var from = opener.$(\'#from_date\').val().trim();
		var to = opener.$(\'#to_date\').val().trim();

		$(\'#print_date\').text(from + " To " + to);

		window.print();
	</script>

</body>
</html>';
?>