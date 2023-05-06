

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
<html class="zoom">
<head>
	<meta charset="UTF-8">
	<title>';echo isset($title)?$title :'SKILL TECH CONSULTING ';;echo '</title>
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">



	<!-- bootstrap framework -->
	<link href="';echo base_url('assets/bootstrap/css/bootstrap.min.css');;echo '" rel="stylesheet" media="screen">

	<!-- custom icons -->
	<!-- font awesome icons -->
	<link href="';echo base_url('assets/icons/font-awesome/css/font-awesome.min.css');;echo '" rel="stylesheet" media="screen">
	<!-- <link href="';echo base_url('assets/css/font-awesome.min.css');;echo '" rel="stylesheet" media="screen"> -->
	<!-- ionicons -->
	<link href="';echo base_url('assets/icons/ionicons/css/ionicons.min.css');;echo '" rel="stylesheet" media="screen">


	<!-- datatables -->
	<link rel="stylesheet" href="';echo base_url('assets/lib/DataTables/media/css/jquery.dataTables.min.css');;echo '">
	<link rel="stylesheet" href="';echo base_url('assets/lib/DataTables/extensions/TableTools/css/dataTables.tableTools.min.css');;echo '">
	<link rel="stylesheet" href="';echo base_url('assets/lib/DataTables/extensions/Scroller/css/dataTables.scroller.min.css');;echo '">
	<!-- flags -->
	<link rel="stylesheet" href="';echo base_url('assets/icons/flags/flags.css');;echo '">
	<!-- datepicker -->
	<link rel="stylesheet" href="';echo base_url('assets/lib/bootstrap-datepicker/css/datepicker3.css');;echo '">
	<!-- bootstrap switches -->
	<link href="';echo base_url('assets/lib/bootstrap-switch/build/css/bootstrap3/bootstrap-switch.css');;echo '" rel="stylesheet">
	<!-- multiselect, tagging -->
	<link rel="stylesheet" href="';echo base_url('assets/lib/select2/select2.css');;echo '">

	<!-- main stylesheet -->


	<link href="';echo base_url('assets/css/style_22.css');;echo '" rel="stylesheet" media="screen">
	<link href="';echo base_url('assets/css/sweet-alert.css');;echo '" rel="stylesheet" media="screen">
	<!-- custom css -->
	<link href="';echo base_url('assets/css/custom.css');;echo '" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="';echo base_url('assets/css/morris.css');;echo '">
	
	<link rel="stylesheet" href="';echo base_url('assets/lib/autocomplete/jquery.auto-complete.css');;echo '">
	
	<link href="';echo base_url('assets/css/jquery-confirm.min.css');;echo '" rel="stylesheet" media="screen">

	<script>
		var base_url = \'';echo base_url();;echo '\';
	</script>

</head>
<body>
	<body>
		<div class="loader">
			<div class="loader_overlay"></div>
			<img class="loader_img" src="';echo base_url('assets/img/ajaxloader.png');;echo '" alt="">
		</div>
		<!-- top bar -->
		<!-- <header class="navbar navbar-fixed-top" role="banner">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="';echo base_url('index.php/');;echo '" class="navbar-brand"><img src="';echo base_url('assets/img/header-logo.png');;echo '" alt="Logo"></a>
				</div>
				<ul class="nav navbar-nav navbar-right" style=\'margin-top: 6px;\'>
					<li><a href="';echo base_url('index.php/user/logout') ;echo '"><span class="navbar_el_icon ion-log-out"></span> <span class="navbar_el_title">Logout</span></a></li>
				</ul>
			</div>
		</header> -->
		<header class="navbar navbar-fixed-top" role="banner">
			<div class="container-fluid">
				<div class=\'row\'>
					<div class=\'col-lg-12 visible-lg\' >
						<a href="';echo base_url('index.php/');;echo '" class="navbar-brand"><img src="';echo base_url('assets/img/header-logo.png');;echo '" alt="Logo"></a>
						<ul class=\'main-nav wall_btn\' style=\'display:inline-flex;color:white;margin-top:10px;list-style: none;\'>
						<li class="active">
						<a href="#">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a>
					    </li>
							<li class="active">
								<a href="';echo base_url('index.php/wall');;echo '" style=\'color:white !important;\'><i class="fa fa-rss"></i> Wall</a>
							</li>

							<li class="active">
								<a href="';echo base_url('index.php/user/dashboard');;echo '" style=\'color:white !important;\'><i class="fa fa-home"></i> Home</a>
							</li>
							
							<li class="active login_info">
								<a href="" style=\'color:white !important;\'><i class="fa fa-user"></i>';echo ' Login as '.$this->session->userdata('uname') .'. From: '.$this->session->userdata('company_name') ;;echo '</a>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right log_out" style=\'margin-top: 6px;\'>
							<li><a href="';echo base_url('index.php/user/logout') ;echo '"><span class="navbar_el_icon ion-log-out"></span> <span class="navbar_el_title">Logout</span></a></li>
						</ul>
						<ul id="nav" class="nav navbar-nav navbar-right trans" style=\'margin-top: 6px;\'>
							<li class="payables">
								
							</li>
							<li class="receivables">
							
							</li>
							<li class="stocknotifs">
								
							</li>
										<!-- 			<li id="notification_li">
														<span id="notification_count">3</span>
														<a href="#" id="notificationLink">Notificationss</a>

														<div id="notificationContainer">
														<div id="notificationTitle">Notifications</div>
														<div id="notificationsBody" class="notifications"></div>
														<div id="notificationFooter"><a href="#">See All</a></div>
														</div>

													</li> -->
														<!-- <li class="notification-li">
															<div class="notification-conatiner">
																<div class="notification-header">
																	Notifications
																</div>
																<div class="notification-body">
																	
																</div>
																<div class="notification-footer">
																	<a href="#" title="">See all Notfication</a>
																</div>										
															</div>
														</li>
													</li> -->

													<!-- <li><a href="';echo base_url('index.php/user/logout') ;echo '"><span class="navbar_el_icon ion-log-out"></span> <span class="navbar_el_title">Logout</span></a></li> -->
												</ul>
											</div>
										</div>
				<!-- <div class="navbar-header">
					
			</div> -->
			<input type="hidden" name="unameh" id="unameh" value="';echo $this->session->userdata('uname');;echo '">
			<input type="hidden" name="cidh" id="cidh" value="';echo $this->session->userdata('company_id');;echo '">
		</div>
	</header>';
?>