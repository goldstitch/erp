

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!doctype html>
<html>
	
	<head>
		<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">
		<!-- <link rel="stylesheet" href="css/bootstrap.css"> -->

		<link href=\'http://fonts.googleapis.com/css?family=Open+Sans\' rel=\'stylesheet\'>
		<style type="text/css" media="print">
			.tabl-ul{
				 list-style-type:none;width:230px;
			}
			#footer { position:absolute; width:100%; height:100px; }
			thead{
				background:#E8E8E8 !important;border-top:1px solid black !important;
			}
		</style>
		<style type="text/css">
			.tabl-ul{
				 list-style-type:none;width:230px;
			}
			#footer { position:absolute; width:100%; height:100px; }
		</style>
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js" type="text/javascript"></script>
	</head>

	<body>
		<div class="container" style="margin-top:40px;">
			<div class="row">
				<div class="col-xs-12">

					<div class="row">
						<div class="col-xs-6">
							<span style="font-weight:bold;font-family: \'Open Sans\', sans-serif;">Invoice# : <span class=\'invoiceno\'></span></span><br>
							<span style="font-weight:bold;font-family: \'Open Sans\', sans-serif;">Date : <span class=\'current_date\'></span></span>
						</div>
						<div class="col-xs-6 pull-right">
							<div class="header pull-right">
								<div class="headerLogo ">
									<span class="logo"><img class="img_logo" src="img/header-logo.png"></span>			
								</div>
							</div><!--end of header -->
						</div><!-- end of col-->
					</div><!-- end of row-fluid -->

					<div class="row">
						<div class="col-xs-12">
							<span>
								<h3 style="font-weight:bold;font-family: \'Open Sans\', sans-serif;text-align:center;">Export Register</h3>
							</span>
						</div><!-- end of col -->
					</div><!-- end of row -->
					<div class="row">
						<div class="col-lg-12">
							<table class="table table-bordered">
								<thead style="background:#E8E8E8;border-top:1px solid black;">
									<tr style="font-family: \'Open Sans\', sans-serif;"> 
										<th style="width:40px; border:1px solid black;" class="text-center">Sr#</th>
										<th style="width:120px; border:1px solid black;" class="text-center">Tab 1</th>
										<th style="width: 125px; border:1px solid black;" class="text-center">Tab 2</th>
										<th style="width:100px; border:1px solid black;" class="text-center">Tab 3</th>
										<th style="width:100px; border:1px solid black;" class="text-center">Tab 3</th>

									</tr>
								</thead>
								<tbody style="border-top:1px solid black;">
									<tr>
										<td style="width:10px !important;line-height:110px; " class=\'text-center srno\'></td>
										<td>
											<ul class=\'tabl-ul\'>
												<li><b>Inv Date :</b><span class=\'inv_date\'></span> </li>
												<li><b>PI# :</b> <span class=\'pi\'></span> </li>
												<li><b>Advance Payment :</b> <span class=\'advancepay\'></span> </li>
												<li><b>Inv# :</b> <span class=\'invno\'></span> </li>
												<li><b>E-Form# :</b> <span class=\'eformno\'></span></li>
												<li><b>CTN# :</b> <span class=\'ctnno\'></span> </li>
											</ul>
										</td>
										<td>
											<ul class=\'tabl-ul\'>
												<li><b>Inv Value :</b> <span class=\'invalue\'></span> </li>
												<li><b>Deliver Date :</b> <span class=\'delive_date\'></span> </li>
												<li><b>Container# :</b> <span class=\'contNo\'></span> </li>
												<li><b>BL# :</b> <span class=\'Blno\'></span> </li>
												<li><b>Routing Bank :</b> <span class=\'rout_bank\'></span> </li>
												<li><b>Payment Shipping :</b> <span class=\'pay_shiping\'></span> </li>
											</ul>
										</td>
										<td>
											<ul class=\'tabl-ul\'>
												<li><b>DHL# :</b> <span class=\'dhlno\'></span></li>
												<li><b>GD# :</b> <span class=\'gdno\'></span> </li>
												<li><b>Received Payment :</b> <span class=\'rec_pay\'></span> </li>
												<li><b>Transport :</b> <span class=\'transprt\'></span> </li>
												<li><b>Sea Freight :</b> <span class=\'sea_frt\'></span></li>
												<li><b>For Warder :</b> <span class=\'for_wardn\'></span></li>
											</ul>
										</td>
										<td>
											<ul class=\'tabl-ul\'>
												<li><b>Clearing Agent :</b> <span class=\'clearng_agent\'></span></li>
												<li><b>Rebate Doc :</b> <span class=\'rebate_doc\'></span></li>
												<li><b>Sale Tax Doc :</b> <span class=\'sale_tax\'></span></li>
												<li><b>Yarn :</b> <span class=\'yarn\'></span></li>
											</ul>
										</td>
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>	
				</div><!-- end of col -->
			</div><!-- row-fluid -->

			<div class="row">
				<div class="col-xs-12">
					<table class="table table-bordered"  style="margin-top:60px !important;border-color:black !important;">
						<thead>
							<tr>
								<th class="col-xs-4 text-center" style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;font-family: \'Open Sans\', sans-serif;">Prepared By</th>
								<th style="border:1px solid white;"></th>
								<th class="col-xs-4 text-center" style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;font-family: \'Open Sans\', sans-serif;">Received By</th>
							</tr>
						</thead>
					</table>
				</div><!-- end of col -->
			</div><!-- row-fluid -->
	
		</div><!--container-fluid -->

		<div class="row" id="footer">
			<div class="col-lg-11 col-lg-offset-1">
				<h6>User: Admin</h6>
			</div>
		</div>

		<script type="text/javascript">
 		// 	x = $(\'#footer\').height()+20; // +20 gives space between div and footer
			// y = $(window).height();

			// if (x+100<=y){ // 100 is the height of your footer
			//     $(\'#footer\').css(\'top\', y+220+\'px\');// again 100 is the height of your footer
			//     $(\'#footer\').css(\'display\', \'block\');
			// }else{
			//     $(\'#footer\').css(\'top\', x+\'px\');
			//     $(\'#footer\').css(\'display\', \'block\');
			// }



			// });

			$(function(){
				var opener = window.opener;
				var invoiceno = opener.$(\'#txtId\').val();
				var currentdate = opener.$(\'#current_date\').val();
				var srno = opener.$(\'#txtId\').val();
				var invdate = opener.$(\'#inv_date\').val();
				var pi = opener.$(\'#txtPiNo\').val();
				var advancepay = opener.$(\'#txtAdvancePmnt\').val();
				var invno = opener.$(\'#txtInvNo\').val();
				var eformno = opener.$(\'#txtEFormNo\').val();
				var ctnno = opener.$(\'#txtCtnNo\').val();
				var invalue = opener.$(\'#txtInvValue\').val();
				var delivedate = opener.$(\'#deliver_date\').val();
				var contNo = opener.$(\'#txtContainerNo\').val();
				var Blno = opener.$(\'#txtBlNo\').val();
				var routbank = opener.$(\'#routing_dropdown\').val();
				var payshiping = opener.$(\'#payment_dropdown\').val();
				var dhlno = opener.$(\'#txtDhlNo\').val();
				var gdno = opener.$(\'#txtGdNo\').val();
				var recpay = opener.$(\'#txtRecPaymentNo\').val();
				var transprt = opener.$(\'#txtTransport\').val();
				var seafrt = opener.$(\'#txtFreight\').val();
				var forwardn = opener.$(\'#txtWarder\').val();
				var clearngagent = opener.$(\'#txtClringAgent\').val();
				var rebatedoc = opener.$(\'#rebate_dropdown\').val();
				var saletax = opener.$(\'#saletax_dropdown\').val();
				var yarn = opener.$(\'#Yyrn_dropdown\').val();

				$(\'.invoiceno\').html(invoiceno);
				$(\'.current_date\').html(currentdate);

				$(\'.srno\').html(srno);
				$(\'.inv_date\').html(invdate);
				$(\'.pi\').html(pi);
				$(\'.advancepay\').html(advancepay);
				$(\'.invno\').html(invno);
				$(\'.eformno\').html(eformno);
				$(\'.ctnno\').html(ctnno);
				$(\'.invalue\').html(invalue);
				$(\'.delive_date\').html(delivedate);
				$(\'.contNo\').html(contNo);
				$(\'.Blno\').html(Blno);
				$(\'.rout_bank\').html(routbank);
				$(\'.pay_shiping\').html(payshiping);
				$(\'.dhlno\').html(dhlno);
				$(\'.gdno\').html(gdno);
				$(\'.rec_pay\').html(recpay);
				$(\'.transprt\').html(transprt);
				$(\'.sea_frt\').html(seafrt);
				$(\'.for_wardn\').html(forwardn);
				$(\'.clearng_agent\').html(clearngagent);
				$(\'.rebate_doc\').html(rebatedoc);
				$(\'.sale_tax\').html(saletax);
				$(\'.yarn\').html(yarn);
			});
		</script>
	</body>
</html>
';
?>