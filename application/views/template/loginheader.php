

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
$this->output->set_header('Pragma: no-cache');
;echo '
<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8">
		<title>ERP SKILLTECHCONSULTING</title>
		<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">

		<link rel="shortcut icon" href="';echo base_url('assets/img/header-logo mainnn.png');;echo '">

		<!-- bootstrap framework -->
		<link href="';echo base_url('assets/bootstrap/css/bootstrap.min.css');;echo '" rel="stylesheet" media="screen">
		<!-- custom css -->
		<link href="';echo base_url('assets/css/plugins/datepicker/datepicker.css');;echo '" rel="stylesheet" media="screen">

		<link href="';echo base_url('assets/css/custom.css');;echo '" rel="stylesheet" media="screen">
		<link href="';echo base_url('assets/css/login.css') ;echo '" rel="stylesheet">


	<link rel="stylesheet" href="';echo base_url('assets/logincss/css-font-awesome.css') ;echo '">
	<link rel="stylesheet" href="';echo base_url('assets/logincss/animate.css-animate.css') ;echo '">
	<link rel="stylesheet" href="';echo base_url('assets/logincss/css-bootstrap.css') ;echo '">
	<link rel="stylesheet" href="';echo base_url('assets/logincss/pe-icons-pe-icon-7-stroke.css') ;echo '">
	<link rel="stylesheet" href="';echo base_url('assets/logincss/pe-icons-helper.css') ;echo '">
	<link rel="stylesheet" href="';echo base_url('assets/logincss/stroke-icons-style.css') ;echo '">
	<link rel="stylesheet" href="';echo base_url('assets/logincss/styles-style.css') ;echo '">
	
	<script>
		var base_url = \'';echo base_url();;echo '\';
	</script></head>

	<body class="blank body_bgd">
	</body>
</html>';
?>