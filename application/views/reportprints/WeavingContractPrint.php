
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
	<meta charset="utf-8">


	
	<link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../../assets/bootstrap/js/bootstrap.min.js">
	


	<style type=\'text/css\'>
		
		@media print {
		    /*  .headr_detail {
		        background:rgb(0, 6, 128) !important;
		        }*/
		      /*.th_text{
			color: rgb(182, 75, 75) !important;
			}*/
			.newone {
				/*background:rgb(0, 6, 128) !important;*/
				/*height: 40px !important;*/
				padding: 0px 0px 20px 0px !important; 

			}
			.dis-detail{
				/*font-weight: bold !important;*/
				font-size: 14px;
				font-family: \'Tahoma\' !important;
			}
		}
		@media print {
			.headr_detail span h1 b{
				/*color: white !important;*/
				z-index: 2000 !important;

			}
			.newone2{
				z-index: 1000 !important;
			}
		}
		@media print {
		      /*.vrNo{
		        color: red !important;
		        }*/
		    }
		    @media print {
		      /*.th_text{
		        color: rgb(182, 75, 75) !important;
		        }*/
		    }
		    .table thead tr th{
		    	border-bottom: 1px solid black !important;
		    	border-top: 1px solid black !important;
		    	border-left:1px solid !important;
		    	font-weight: normal !important;
		    }
		    .table > tfoot > tr > td {
		    	padding: 2px;
		    	line-height: 1.42857143;
		    	vertical-align: top;
		    	border-top: 1px solid black;
		    	font-family: tahoma !important;
		    }
		    .table > tbody > tr > td{
		    	padding: 0px !important;
		    }
		    .table tbody tr td{
		    	border-top: 0px !important;
		    }
		    .table_size td{
		    	border-left:1px solid !important;
		    }
		    tfoot{
		    	border-top:1px solid; 
		    }

		    .header_heading1 b{font-size:24px !important;font-family:arial !important;text-align: -webkit-center !important;}
		    .header_p{font-family: arial !important;text-align: center !important;line-height: 7px; }
		    body, h1, h2, h3, h4, h5, h6, p, span,table,tbody,tr,td,th,tfoot, input, title {
		    	font-family: Tahoma !important;
		    }
		    span{
		    	font-size: 14px;
		    }
		    th {
		    	font-size: 14px !important;
		    }
		    td {
		    	font-size: 14px !important;
		    }
		    h1{
		    	font-size: 14px;
		    }
		    .th_text{
		    	/*color: rgb(182, 75, 75) !important;*/
		    }
		    thead > tr > th{
		    	padding: 0px !important;
		    }
		    tbody > tr > td{
		    	padding: 0px !important;
		    }
		    .myrows > .row-content > td{
		    	border-top: 1px solid black !important;
		    }
		    .table_size_new > tfoot > tr > td{
		    	font-size: 11px !important;
		    	padding-bottom: 0px !important;
		    }
		    .hdshowHide{
		    	display:none !important;
		    }

		    .rcpt-header { width: 700px !important; margin: 0px; display: inline;  top: 0px; right: 0px; }

		    .txtbold{font-weight: bold;}

		    @page{margin-top: 5mm; margin-left: 100mm;margin-right: 10mm;margin-bottom: 2mm; size :  auto !important;  }

		</style>
	</head>

	<body>
		<div class="container" style="margin-top:-10px;     margin-left: 30px !important;">
			<div class="row">
				<div class="col-xs-12">
					<div class="row hd">
						<div class="col-lg-12">
							<img class="rcpt-header" src="../../../assets/img/pic1.png" alt="">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 headr_detail newone" style="height: 40px;">
							<span>
								<h1 class="text-center newone newone2" style="margin:0px 0px 15px 0px;text-align:center !important;font-weight:bold !important;font-family: \'Tahoma\' !important;"><b style="font-size:20px !important;position:relative;top:0px;font-weight:bold !important;" class="set PageTitle">Weaving Contract</b></h1>
							</span>
						</div>
					</div><!-- end of row -->
					<br>
					<br>

					<div class="row">
						<div class="col-lg-12">
							<table class="table" style="margin-bottom: 0px;margin-top:0px;width: 100% !important;">
								<tr>
									<td style="width: 50px !important;"><span style=""><b>Vr#</b> </span></td>
									<td style="width: 170px !important;text-align:left !important;"><span class="vrNo"></span></td>
									
									<td style="width: 50px !important;"><span style=""><b>Contract#</b> </span></td>
									<td style="width: 170px !important;text-align:left !important;"><span class="contract_no"></span></td>

								</tr>

								<tr>
									<td style="width: 50px !important;text-align:left;"><span style=""><b> Voucher Date 	&nbsp;	&nbsp;</b></span></td>
									<td style="width: 170px !important;text-align:left;"><span class="c_date" ></span></td>

									
									<td style="width: 80px !important;text-align:left;"><span style=""><b> Contract Date 	&nbsp;	&nbsp;</b></span></td>
									<td style="width: 80px !important;text-align:left;"><span class="contractdate" ></span></td>
								</tr>
								<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
								<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>

								

								<tr>
									<td style="width: 10px !important;"><span style=""><b>Party:</b> </span></td>
									<td colspan="3" style="width: 170px !important;text-align:left !important;"><span class="partyname"></span></td>
									
								</tr>

								<tr>
									<td style="width: 10px !important;"><span style=""><b>Quality:</b> </span></td>
									<td colspan="3" style="width: 170px !important;text-align:left !important;"><span class="itemname"></span></td>
									
								</tr>

								<tr>
									<td style="width: 10px !important;"><span style=""><b>Calculation:</b> </span></td>
									<td colspan="3" style="width: 170px !important;text-align:left !important;"><span class="calculation"></span></td>
									
								</tr>

								<tr>
									<td style="width: 10px !important;"><span style=""><b>Yarn Warp:</b> </span></td>
									<td style="width: 170px !important;text-align:left !important;"><span class="yarnwarp"></span></td>
									<td style="width: 80px !important;text-align:left;"><span style=""><b> Yarn Weft: 	&nbsp;	&nbsp;</b></span></td>
									<td style="width: 80px !important;text-align:left;"><span class="yarnweft" ></span></td>
								</tr>

								<tr>
									<td style="width: 10px !important;"><span style=""><b>Fabric Qty:</b> </span></td>
									<td style="width: 170px !important;text-align:left !important;"><span class="qty"></span></td>
									<td style="width: 80px !important;text-align:left;"><span style=""><b> Due Date: 	&nbsp;	&nbsp;</b></span></td>
									<td style="width: 80px !important;text-align:left;"><span class="duedate" ></span></td>
								</tr>







							</table>
						</div>
					</div>

					<br>
								<br>
								<br>

					<div class="row">
						<div class="col-lg-12">
							<table class="table table_size" style="width: 95% !important;border:1px solid !important;margin:0px 0px 0px 0px !important;">
								<thead style="background:#E8E8E8;">
									<tr style="font-family: \'Tahoma\';"> 
										<th style="width:30px;" class="text-center"></th>
										<th style="width:30px !important;" class="text-center txtbold">Warp</th>
										<th style="width:30px !important;" class="text-center txtbold">Weft</th>
										<th style="width:30px !important;" class="text-center txtbold">Total</th>
										



									</tr>
								</thead>
								<tbody class="myrows">
									<tr style="border-top:1px solid black !important;">
										<td  class="text-center txtbold">Total Bag Required:</td>
										<td  class="text-center  bagwarp"></td>
										<td  class="text-center  bagwept"></td>
										<td  class="text-center  bagtotal"></td>
									</tr>

									<tr style="border-top:1px solid black !important;">
										<td  class="text-center txtbold">Weight/Meter:</td>
										<td  class="text-center  weight40warp"></td>
										<td  class="text-center  weight40weft"></td>
										<td  class="text-center  weighttotal"></td>
									</tr>


									<tr style="border-top:1px solid black !important;">
										<td  class="text-center txtbold">Rate:</td>
										<td  class="text-center  ratewarp"></td>
										<td  class="text-center  rateweft"></td>
										<td  class="text-center  ratetotal"></td>
									</tr>


									<tr style="border-top:1px solid black !important;">
										<td  class="text-center txtbold">Yarn Value/40 Mtr:</td>
										<td  class="text-center  valueyarn40warp"></td>
										<td  class="text-center  valueyarn40weft"></td>
										<td  class="text-center  valueyarntotal"></td>
									</tr>


									<tr style="border-top:1px solid black !important;">
										<td  class="text-center txtbold">Conversion Charges /Pick:</td>
										<td  class="text-center  conversionchargespick"></td>
										<td  class="text-center "></td>
										<td  class="text-center "></td>
									</tr>



									<tr style="border-top:1px solid black !important;">
										<td  class="text-center txtbold">Con Ch/Mtr:</td>
										<td  class="text-center  conversionchargesmeter"></td>
										<td  class="text-center txtbold ">Con Ch/40 Mtr</td>
										<td  class="text-center  conversion40meter"></td>
									</tr>

									<tr style="border-top:1px solid black !important;">
										<td  class="text-center txtbold">Grey Fabric Rate /Meter:</td>
										<td  class="text-center  greyfabricratemeter"></td>
										<td  class="text-center  "></td>
										<td  class="text-center  "></td>
									</tr>

									<tr style="border-top:1px solid black !important;">
										<td  class="text-center txtbold">Grey Fabric Value:</td>
										<td  class="text-center txtbold greyfabricValue"></td>
										<td  class="text-center txtbold "></td>
										<td  class="text-center txtbold "></td>
									</tr>

								
								</tbody>
								
							</table>
						</div>
					</div>


					


				</div>

			</div>



			<br>
			<div class="row">
				<div class="col-lg-12" style="margin-top:0px;">
					<table class="table">
						<tfoot style="border:none !important;">
							<tr>

								<td class="text-left" style="border-top:none;width: 340px;text-align: left;"><b>Powered By: www.alnaharsolution.com</b></td>

							</tr>
						</tfoot>
					</table>
				</div>
			</div>

		</div><!--container-fluid -->
		<script type="text/javascript" src="../../../assets/js/jquery.min.js"></script>
		<script src="../../../assets/js/handlebars.js"></script>

		<script type="text/javascript">
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
			$(function(){

				var opener = window.opener;
				var serialno = opener.$(\'#txtIdHidden\').val();


				var C_Date = opener.$(\'#vrdate\').val();
				var dateParts = [];
				// var hd = (opener.$(\'#switchPrintHeader\').bootstrapSwitch(\'state\') === true) ? \'1\' : \'0\';

				var separator = ( C_Date.indexOf(\'/\') === -1 ) ? \'-\' : \'/\';

				dateParts = C_Date.split(separator);
				var C_Date =dateParts[2] + \'-\' + getMonthName(parseInt(dateParts[1], 10)) + \'-\' +  dateParts[0]  ;


				$(\'.vrNo\').html(serialno);


				$(\'.c_date\').html(C_Date);


				var contractdate = opener.$(\'#contract_date\').val();
				dateParts = [];
				separator = ( contractdate.indexOf(\'/\') === -1 ) ? \'-\' : \'/\';
				dateParts = contractdate.split(separator);
				contractdate =dateParts[2] + \'-\' + getMonthName(parseInt(dateParts[1], 10)) + \'-\' +  dateParts[0]  ;
				$(\'.contractdate\').html(contractdate);


				var duedate = opener.$(\'#duedate\').val();
				dateParts = [];
				separator = ( duedate.indexOf(\'/\') === -1 ) ? \'-\' : \'/\';
				dateParts = duedate.split(separator);
				duedate =dateParts[2] + \'-\' + getMonthName(parseInt(dateParts[1], 10)) + \'-\' +  dateParts[0]  ;
				$(\'.duedate\').html(duedate);




				var contract_no = opener.$(\'#contract_no\').val();
				$(\'.contract_no\').html(contract_no);

				


				var partyname = opener.$(\'#txtPartyId\').val(); 
				$(\'.partyname\').html(partyname);

				var itemname = opener.$(\'#txtItemId\').val(); 
				$(\'.itemname\').html(itemname);


				var calculation = opener.$(\'#read\').val() +\'<b> X </b>\'+ opener.$(\'#pick\').val() +\'<b> / </b>\'+ opener.$(\'#warp\').val() +\'<b> X </b>\'+ opener.$(\'#weft\').val() +\'<b> = </b>\'+ opener.$(\'#width\').val()   ; 
				$(\'.calculation\').html(calculation);


				var yarnwarp = opener.$(\'#txtYarnId\').val(); 
				$(\'.yarnwarp\').html(yarnwarp);

				var yarnweft = opener.$(\'#txtYarnwId\').val(); 
				$(\'.yarnweft\').html(yarnweft);


				var qty = opener.$(\'#qty\').val(); 
				$(\'.qty\').html(qty);



				var bagwarp = opener.$(\'#bagwarp\').val(); 
				$(\'.bagwarp\').html(bagwarp);

				var bagwept = opener.$(\'#bagwept\').val(); 
				$(\'.bagwept\').html(bagwept);


				var bagtotal = opener.$(\'#bagtotal\').val(); 
				$(\'.bagtotal\').html(bagtotal);



				var weight40warp = opener.$(\'#weight40warp\').val(); 
				$(\'.weight40warp\').html(weight40warp);

				var weight40weft = opener.$(\'#weight40weft\').val(); 
				$(\'.weight40weft\').html(weight40weft);


				var weighttotal = opener.$(\'#weighttotal\').val(); 
				$(\'.weighttotal\').html(weighttotal);



				var ratewarp = opener.$(\'#ratewarp\').val(); 
				$(\'.ratewarp\').html(ratewarp);

				var rateweft = opener.$(\'#rateweft\').val(); 
				$(\'.rateweft\').html(rateweft);


				var ratetotal = opener.$(\'#ratetotal\').val(); 
				$(\'.ratetotal\').html(ratetotal);


				var valueyarn40warp = opener.$(\'#valueyarn40warp\').val(); 
				$(\'.valueyarn40warp\').html(valueyarn40warp);

				var valueyarn40weft = opener.$(\'#valueyarn40weft\').val(); 
				$(\'.valueyarn40weft\').html(valueyarn40weft);


				var valueyarntotal = opener.$(\'#valueyarntotal\').val(); 
				$(\'.valueyarntotal\').html(valueyarntotal);



				var conversionchargespick = opener.$(\'#conversionchargespick\').val(); 
				$(\'.conversionchargespick\').html(conversionchargespick);

				var conversionchargesmeter = opener.$(\'#conversionchargesmeter\').val(); 
				$(\'.conversionchargesmeter\').html(conversionchargesmeter);


				var conversion40meter = opener.$(\'#conversion40meter\').val(); 
				$(\'.conversion40meter\').html(conversion40meter);


				var greyfabricratemeter = opener.$(\'#greyfabricratemeter\').val(); 
				$(\'.greyfabricratemeter\').html(greyfabricratemeter);

				var greyfabricValue = opener.$(\'#greyfabricValue\').val(); 
				$(\'.greyfabricValue\').html(greyfabricValue);

				window.print();


			});
		</script>
	</body>
	</html>
';
?>