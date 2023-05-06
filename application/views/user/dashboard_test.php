

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


$desc = $this->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$reports = $desc['reports'];
$vouchers = $desc['vouchers'];
;echo '


<script id="cheque-row" type="text/x-handlebars-template">
	<tr>
	  <td>{{VRDATE}}</td>
	  <td>{{MATURE_DATE}}</td>
	  <td>{{DCNO}}</td>
	  <td>{{CHEQUE_NO}}</td>
	  <td>{{PARTY}}</td>
	  <td>{{BANK}}</td>
	  <td>{{AMOUNT}}</td>
	</tr>
</script>


<!-- //////////////////////////////// Start daily template ////////////////////////////////// -->

<script id="sp-daily-head-template" type="text/x-handlebars-template">
  <tr>
	 <th>Vr#</th>
	 <th>Account</th>
	 <th>Amount</th>
  </tr>
</script> 
<script id="sp-daily-template" type="text/x-handlebars-template">
  <tr>
	 <td>{{VRNOA}}</td>
	 <td class="account">{{ACCOUNT}}</td>
	 <td class="amount">{{NAMOUNT}}</td>
  </tr>
</script> 

<!-- ///////////////////////////// End Daily Template ////////////////////////// -->

<!-- ///////////////////// Start Weekly and Monthly Template /////////////////// -->
<script id="sp-weekly-monthly-head-template" type="text/x-handlebars-template">
  <tr>
	 <th>Mon</th>
	 <th>Tue</th>
	 <th>Wed</th>
	 <th>Thu</th>
	 <th>Fri</th>
	 <th>Sat</th>
	 <th>Sun</th>
  </tr>
</script>
<script id="sp-weekly-monthly-template" type="text/x-handlebars-template">
  <tr>
	 <td>{{Monday}}</td>
	 <td>{{Tuesday}}</td>
	 <td>{{Wednesday}}</td>
	 <td>{{Thursday}}</td>
	 <td>{{Friday}}</td>
	 <td>{{Saturday}}</td>
	 <td>{{Sunday}}</td>
  </tr>
</script>
<!-- /////////////////// End Weekly and Monthly Template ////////////////// -->

<!-- ///////////////////// Start Weekly and Monthly Template /////////////////// -->
<script id="sp-monthly-head-template" type="text/x-handlebars-template">
  <tr>
	 <th>Jan</th>
	 <th>Feb</th>
	 <th>Mar</th>
	 <th>Apr</th>
	 <th>May</th>
	 <th>Jun</th>
	 <th>Jul</th>
	 <th>Aug</th>
	 <th>Sep</th>
	 <th>Oct</th>
	 <th>Nov</th>
	 <th>Dec</th>
  </tr>
</script>
<script id="sp-monthly-template" type="text/x-handlebars-template">
  <tr>
	 <td>{{Jan}}</td>
	 <td>{{Feb}}</td>
	 <td>{{Mar}}</td>
	 <td>{{Apr}}</td>
	 <td>{{May}}</td>
	 <td>{{Jun}}</td>
	 <td>{{Jul}}</td>
	 <td>{{Aug}}</td>
	 <td>{{Sep}}</td>
	 <td>{{Oct}}</td>
	 <td>{{Nov}}</td>
	 <td>{{Dec}}</td>
  </tr>
</script>
<!-- /////////////////// End Weekly and Monthly Template ////////////////// -->


<!-- ///////////////////// Start Yearly Template /////////////////// -->
<script id="sp-yearly-head-template" type="text/x-handlebars-template">
	<tr>
		<th>Year</th>
		<th>Month</th>
		<th>Total Sale</th>
	</tr>
</script>
<script id="sp-yearly-template" type="text/x-handlebars-template">
	<tr>
		<td>{{Year}}</td>
		<td class="tdMonth">{{Month}}</td>
		<td class="tdMonthAmount" style="text-align:right;">{{TotalAmount}}</td>
	</tr>
</script>
<!-- /////////////////// End Yearly Template ////////////////// -->
	<link href="';echo base_url('assets/css/style_dashbord.css');;echo '" rel="stylesheet" media="screen">
	<style>
		.table.dataTable .sorting_asc {
	padding-right: 0px !important;
	white-space: nowrap;
		}
	</style>
	<div class="container-fluid" id="content">
		<div id="main">
			<div class="container-fluid main_contents">
				<div class="page-header">
					<div class="pull-left" style="padding-left: 7%;">
						<!-- <a class="btn btn-default btn_wrench"><i class="ion-wrench"></i></a> -->
						<h1 style="font-family:open sans;"><i class="fa fa-xing-square"></i> CHINIOT FABRICS <small class="small_text">(Business Management Software)</small></h1>
					</div>
					<input type="hidden" name="cid" class="cid" value="';echo $this->session->userdata('company_id');;echo '">
				</div><!-- page-headrer -->

				<!--.................................TOP TILES .........................................-->

				<div class="row metronav_row" style="margin:-20px 0px 0px 90px;">
					<div class="col-sm-12">
						<div class="metro-nav">
							<div class="metro-nav-block nav-block-orange">
								<a data-original-title="" href="';echo base_url('index.php/setup/addmachine');;echo '">
									<i class="fa fa-industry"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Add New Machine</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-olive">
								<a data-original-title="" href="';echo base_url('index.php/color') ;echo '">
									<i class="fa fa-tint"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Add New Color</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-block-yellow">
								<a data-original-title="" href="';echo base_url('index.php/payroll/addgroup');;echo '">
									<i class="fa fa-users"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Add New Group</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-block-green double">
								<a data-original-title="" href="';echo base_url('index.php/payroll/addshift');;echo '">
					  			<i class="fa fa-tachometer"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Add New Shift</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-block-red">
								<a data-original-title="" href="';echo base_url('index.php/setup/adddepartment');;echo '">
									<i class="fa fa-trello"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Add New Department</div>
								</a>
							</div><!-- metro-nav -->
						</div><!-- metro-nav -->
						<div class="metro-nav">
							<div class="metro-nav-block nav-block-grey ">
								<a data-original-title="" href="';echo base_url('index.php/sale/addsalevoucher');;echo '">
									<i class="fa fa-money"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Sale Voucher</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-light-purple">
								<a data-original-title="" href="';echo base_url('index.php/sale/addsalereturn');;echo '">
									<i class="fa fa-xing-square"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Sale Return Voucher</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-light-blue double">
								<a data-original-title="" href="';echo base_url('index.php/purchase/addpurchaseyarn');;echo '">
									<i class="fa fa-money"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Purchase Yarn Voucher</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-light-green">
								<a data-original-title="" href="';echo base_url('index.php/setup/ratiovoucher');;echo '">
									<i class="fa fa-bar-chart-o"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Ratio Voucher</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-light-brown">
								<a data-original-title="" href="';echo base_url('index.php/accounts/addjournalvoucher');;echo '">
									<i class="fa fa-cloud-upload"></i>
									<div class="info"><!-- ';
;echo ' --></div>
									<div class="status">Journal Voucher</div>
								</a>
							</div><!-- metro-nav -->
						</div><!-- metro-nav -->
						<div class="metro-nav">
							<div class="metro-nav-block nav-block-green double">
								<a data-original-title="" href="';echo base_url('index.php/packingvoucher');;echo '">
									<i class="fa fa-shopping-cart"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Packing Voucher</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-block-orange">
								<a data-original-title="" href="';echo base_url('index.php/foldingvoucher');;echo '">
									<i class="ion-social-buffer"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Folding Voucher</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-block-red">
								<a data-original-title="" href="';echo base_url('index.php/pressvoucher');;echo '">
									<i class="fa fa-list"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Press Voucher</div>
								</a>
							</div><!--metro-nav-block-->
							<div class="metro-nav-block nav-olive">
								<a data-original-title="" href="';echo base_url('index.php/payroll/overtime');;echo '">
									<i class="ion-ios7-personadd"></i>
									<div class="info"><!--';
;echo '--></div>
									<div class="status">Over Time</div>
								</a>
							</div><!-- metro-nav -->
							<div class="metro-nav-block nav-block-yellow">
								<a data-original-title="" href="';echo base_url('index.php/purchase/addpurchasereturnyarn');;echo '">
									<i class="ion-social-buffer"></i>
									<div class="info">';
;echo '</div>
									<div class="status">Purchase Return</div>
								</a>
							</div><!-- metronav -->
						</div><!-- metro-nav -->
					</div><!-- end of col -->
				</div><!-- end of row -->


				<!--...................................ACCORDIANS FOR TRANSCTIONS..................................-->


				<div class="row-fluid" style="margin:-30px 0px 0px 90px;">
					<div class="row-fluid">
						<div class="col-md-12 accordian_div">
							<h4 class="text-primary" style="font-family:open sans;"><i class="fa fa-industry"></i> <b>I</b>nventory</h4>

							<!--.....................................PURCHASE ACCORDIANS.......................................-->

							<div class="panel-group" id="accordion_a">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_1" style="background: #5A6062 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-lg-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-shopping-cart" style="color:#90906F;"></i></span> Purchase
													</div>
													<div class="col-lg-3" style="font-size:12px !important;">
														<span>Total Purchases</span> : <span class="purchases-sum"> 00</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_1" class="panel-collapse collapse">
										<div class="panel-body">
										  <table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
														<th style=\'background: #368EE0;\' class="text-left">Date</th>
														<th style=\'background: #368EE0;\'>Party</th>
														<th style=\'background: #368EE0;\' class="text-left">Remarks</th>
														<th style=\'background: #368EE0;\' class="text-center">Discount</th>
														<th style=\'background: #368EE0;\' class="text-center">Taxes</th>
														<th style=\'background: #368EE0;\' class="text-center">Expenses</th>
														<th style=\'background: #368EE0;text-align:right;\'>Net Amount</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($purchases as $purchase): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo $purchase['DATE'];;echo '</td>
														<td>';echo $purchase['party_name'];;echo '</td>
														<td style="text-align:left;">';echo $purchase['remarks'];;echo '</td>
														<td>
															<span class="text-primary"><b>';echo $purchase['discp'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
															<span class="text-danger"><b>';echo $purchase['discount'];;echo '</b></span>
														</td>
														<td>
															<span class="text-primary"><b>';echo $purchase['taxpercent'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
															<span class="text-danger"><b>';echo $purchase['tax'];;echo '</b></span>
														</td>
														<td>
															<span class="text-primary"><b>';echo $purchase['exppercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
															<span class="text-danger"><b>';echo $purchase['expense'];;echo '</b></span></li>
														</td>
														<td style="text-align:right;">';echo $purchase['namount'];;echo '</td>
													</tr>
													';endforeach ;echo '												</tbody>
											</table>
										</div>
									</div>
								</div>

							<!--......................................PURCHASE YARN ACCORDIANS..................................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_2" style="background:#747672 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-lg-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-shopping-cart" style="color:#90906F;"></i></span> Yarn Purchase
													</div>
													<div class="col-lg-3" style="font-size:12px !important;">
														<span>Total Yarn Purchase</span> : <span class="yarnpurchases-sum"> 00</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_2" class="panel-collapse collapse">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Date</th>
														<th style=\'background: #368EE0;\'>Party</th>
														<th style=\'background: #368EE0;\' class="text-left">Discount</th>
														<th style=\'background: #368EE0;\' class="text-left">Taxes</th>
														<th style=\'background: #368EE0;\' class="text-left">Expenses</th>
														<th style=\'background: #368EE0;\' class="text-right">Net Amount</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($Yarnpurchases as $Yarnpurchase): ;echo '														<tr>
															<td>';echo $counter++;;echo '</td>
															<td>';echo $Yarnpurchase['DATE'];;echo '</td>
															<td>';echo $Yarnpurchase['party_name'];;echo '</td>
															<td>
																<span class="text-primary"><b>';echo $Yarnpurchase['discp'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger"><b>';echo $Yarnpurchase['discount'];;echo '</b></span></li>
															</td>
															<td>
																<span class="text-primary"><b>';echo $Yarnpurchase['taxpercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger"><b>';echo $Yarnpurchase['tax'];;echo '</b></span></li>
															</td>
															<td>
																<span class="text-primary"><b>';echo $Yarnpurchase['exppercent'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
																<span class="text-danger"><b>';echo $Yarnpurchase['expense'];;echo '</b></span>
															</td>
															<td style="text-align:right;">';echo $Yarnpurchase['namount'];;echo '</td>
														</tr>
													';endforeach ;echo '												</tbody>
											</table>
										</div>
									</div>
								</div>

							<!--.................................FABRIC PURCHASE ACCORDIANS .....................................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_3" style="background:#8D9389 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-lg-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-shopping-cart" style="color:#90906F;"></i></span> Fabric Purchase
													</div>
													<div class="col-lg-3" style="font-size:12px !important;">
														<span>Total Fabric Purchase</span> : <span class="fabricpurchases-sum"> 00</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_3" class="panel-collapse collapse">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
											<thead>
												<tr>
													<th style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
													<th style=\'background: #368EE0;\'>Date</th>
													<th style=\'background: #368EE0;\'>Party</th>
													<th style=\'background: #368EE0;\' class="text-left">Discount</th>
													<th style=\'background: #368EE0;\' class="text-left">Taxes</th>
													<th style=\'background: #368EE0;\' class="text-left">Expenses</th>
													<th style=\'background: #368EE0;\' class="text-right">Net Amount</th>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;foreach ($FabricPurchases as $FabricPurchase): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo $FabricPurchase['DATE'];;echo '</td>
														<td>';echo $FabricPurchase['party_name'];;echo '</td>
														<td>
															<ul style="list-style-type:none;">
																<span class="text-primary"><b>';echo $FabricPurchase['discp'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger"><b>';echo $FabricPurchase['discount'];;echo '</b></span></li>
															</ul>
														</td>
														<td>
															<ul style="list-style-type:none;">
																<span class="text-primary"><b>';echo $FabricPurchase['taxpercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger"><b>';echo $FabricPurchase['tax'];;echo '</b></span></li>
															</ul>
														</td>
														<td>
															<ul style="list-style-type:none;">
																<span class="text-primary"><b>';echo $FabricPurchase['exppercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
																<span class="text-danger"><b>';echo $FabricPurchase['expense'];;echo '</b></span></li>
															</ul>
														</td>
														<td style="text-align:right;">';echo $FabricPurchase['namount'];;echo '</td>
													</tr>
												';endforeach ;echo '											</tbody>
										</table>
									</div>
								</div>
							</div>

							<!--...........................................SALES ACCORDIANS...............................-->

							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_4" style="background:#B1B8AD !important; color:white;font-family:open sans;height: 40px;">
											<div class="row">
												<div class="col-lg-9">
													<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-shopping-cart" style="color:#90906F;"></i></span> Sale
												</div>
												<div class="col-lg-3" style="font-size:12px !important;">
													<span>Total Sales</span> : <span class="sales-sum"> 00</span>
												</div>
											</div>
										</a>
									</h4>
								</div>
								<div id="accordion_a_4" class="panel-collapse collapse">
									<div class="panel-body">
										<table class="table table-striped table-hover ar-datatable">
											<thead>
												<tr>
													<th style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
													<th style=\'background: #368EE0;\'>Date</th>
													<th style=\'background: #368EE0;\'>Party</th>
													<th style=\'background: #368EE0;\' class="text-lefr">Discount</th>
													<th style=\'background: #368EE0;\' class="text-lefr">Taxes</th>
													<th style=\'background: #368EE0;\' class="text-lefr">Expenses</th>
													<th style=\'background: #368EE0;\' class="text-right">Net Amount</th>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;foreach ($sales as $sale): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo $sale['DATE'];;echo '</td>
														<td>';echo $sale['party_name'];;echo '</td>
														<td>
															<span class="text-primary"><b>';echo $sale['discp'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
															<span class="text-danger"><b>';echo $sale['discount'];;echo '</b></span>
														</td>
														<td>
															<span class="text-primary"><b>';echo $sale['taxpercent'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
															<span class="text-danger"> <b>';echo $sale['tax'];;echo '</b></span>
														</td>
														<td>
															<ul style="list-style-type:none;">
																<span class="text-primary"><b>';echo $sale['exppercent'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
																<span class="text-danger"><b>';echo $sale['expense'];;echo '</b></span>
															</ul>
														</td>
														<td style="text-align:right;">';echo $sale['namount'];;echo '</td>
													</tr>
												';endforeach ;echo '											</tbody>
										</table>
									</div>
								</div>
							</div>

							<!--......................................SALE ORDER ACCORDIANS.................................-->

							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_5" style="background:#CAD0C6 !important; color:white;font-family:open sans;height: 40px;">
											<div class="row">
												<div class="col-lg-9">
													<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-shopping-cart" style="color:#90906F;"></i></span> <span style="font-size:15px !important;">Sale Order</span>
												</div>
												<div class="col-lg-3" style="font-size:12px !important;">
													<span>Total Sale Order</span> : <span class="saleOrder-sum"> 00</span>
												</div>
											</div>
										</a>
									</h4>
								</div>
								<div id="accordion_a_5" class="panel-collapse collapse">
									<div class="panel-body">
										<table class="table table-striped table-hover ar-datatable">
											<thead>
												<tr>
													<th style=\'background: #368EE0;max-width:20px !important;\'>Vr#</th>
													<th style=\'background: #368EE0;\'>Date</th>
													<th style=\'background: #368EE0;\'>Party</th>
													<th style=\'background: #368EE0;\' class="text-left">Discount</th>
													<th style=\'background: #368EE0;\' class="text-left">Taxes</th>
													<th style=\'background: #368EE0;\' class="text-left">Expenses</th>
													<th style=\'background: #368EE0;\' class="text-right">Net Amount</th>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;foreach ($saleOrders as $saleOrder): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo $saleOrder['DATE'];;echo '</td>
														<td>';echo $saleOrder['party_name'];;echo '</td>
														<td>
															<span class="text-primary"><b>';echo $saleOrder['discp'];;echo '%</b></span>&nbsp;&nbsp;&nbsp;
															<span class="text-danger"><b>';echo $saleOrder['discount'];;echo '</b></span>
														</td>
														<td>
															<span class="text-primary"><b>';echo $saleOrder['taxpercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
															<span class="text-danger"><b>';echo $saleOrder['tax'];;echo '</b></span></li>
														</td>
														<td>
															<span class="text-primary"><b>';echo $saleOrder['exppercent'];;echo '%</b></span></li>&nbsp;&nbsp;&nbsp;
															<span class="text-danger"><b>';echo $saleOrder['expense'];;echo '</b></span></li>
														</td>
														<td style="text-align:right;">';echo $saleOrder['namount'];;echo '</td>
													</tr>
												';endforeach ;echo '											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<div class="row-fluid">
					<div class="col-md-12 accordian_div">
						<h4 class="text-primary" style="font-family:open sans;"><i class="fa fa-building-o"></i> <b>A</b>ccounts</h4>
						<div class="panel-group" id="accordion_a">

							<!--..........................................PAYMENTS ACCORDIANS................................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_6" style="background: #CAD0C6 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-lg-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-xing-square" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Payments
													</div>
													<div class="col-lg-3" style="font-size:12px !important;">
														<span>Total Payments</span> : <span class="sum_payments"></span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_6" class="panel-collapse collapse">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th style=\'background: #368EE0;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Party Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th style=\'background: #368EE0;\'>Debit</th>
														<th style=\'background: #368EE0;\'>Credit</th>
														<th style=\'background: #368EE0;\'>Deduction</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($paymentss as $payment): ;echo '														<tr>
															<td>';echo $counter++;;echo '</td>
															<td>';echo $payment['party_name'];;echo '</td>
															<td>';echo $payment['description'];;echo '</td>
															<td class="text-primary"><b>';echo $payment['debit'];;echo '</b></td>
															<td class="text-danger"><b>';echo $payment['credit'];;echo '</b></td>
															<td>';echo $payment['deduction'];;echo '</td>
														</tr>
													';endforeach ;echo '												</tbody>
											</table>
										</div>
									</div>
								</div>

								<!--...........................................RECEIPTS ACCORDIANS..............................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_7" style="background:#B1B8AD !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-lg-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-xing-square" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Receipts
													</div>
													<div class="col-lg-3" style="font-size:12px !important;">
														<span>Total Receipts</span> : <span class="sum_receipts"> </span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_7" class="panel-collapse collapse">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th style=\'background: #368EE0;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Party Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th style=\'background: #368EE0;\'>Debit</th>
														<th style=\'background: #368EE0;\'>Credit</th>
														<th style=\'background: #368EE0;\'>Deduction</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($receiptss as $receipt): ;echo '														<tr>
															<td>';echo $counter++;;echo '</td>
															<td>';echo $receipt['party_name'];;echo '</td>
															<td>';echo $receipt['description'];;echo '</td>
															<td class="text-primary"><b>';echo $receipt['debit'];;echo '</b></td>
															<td class="text-danger"><b>';echo $receipt['credit'];;echo '</b></td>
															<td>';echo $receipt['deduction'];;echo '</td>
														</tr>
													';endforeach ;echo '												</tbody>
											</table>
										</div>
									</div>
								</div>

								<!--.............................................CHEQUE ISSUE ACCORDIANS ...........................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_8" style="background:#8D9389 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-lg-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-xing-square" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Cheque Issue
													</div> 
													<div class="col-lg-3" style="font-size:12px !important;">
														<span>Total Cheque Issue</span> : <span class="pd_issue-sum"> 00</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_8" class="panel-collapse collapse">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th style=\'background: #368EE0;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Party Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th style=\'background: #368EE0;\'>Debit</th>
														<th style=\'background: #368EE0;\'>Credit</th>
														<th style=\'background: #368EE0;\'>Deduction</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($cheqIssues as $cheqIssue): ;echo '														<tr>
															<td>';echo $counter++;;echo '</td>
															<td>';echo $cheqIssue['party_name'];;echo '</td>
															<td>';echo $cheqIssue['description'];;echo '</td>
															<td class="text-primary"><b>';echo $cheqIssue['debit'];;echo '</b></td>
															<td class="text-danger"><b>';echo $cheqIssue['credit'];;echo '</b></td>
															<td>';echo $cheqIssue['deduction'];;echo '</td>
														</tr>
													';endforeach ;echo '												</tbody>
											</table>
										</div>
									</div>
								</div>

								<!--.........................................CHEQUE RECEIVE ACCORDIANS...............................-->

								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_9" style="background:#747672 !important; color:white;font-family:open sans;height: 40px;">
												<div class="row">
													<div class="col-lg-9">
														<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-xing-square" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Cheque Receives
													</div>
													<div class="col-lg-3" style="font-size:12px !important;">
														<span>Total Cheque Receives</span> : <span class="pd_receive-sum"> 00</span>
													</div>
												</div>
											</a>
										</h4>
									</div>
									<div id="accordion_a_9" class="panel-collapse collapse">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th style=\'background: #368EE0;\'>Vr#</th>
														<th style=\'background: #368EE0;\'>Party Name</th>
														<th style=\'background: #368EE0;\'>Remarks</th>
														<th style=\'background: #368EE0;\'>Debit</th>
														<th style=\'background: #368EE0;\'>Credit</th>
														<th style=\'background: #368EE0;\'>Deduction</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($chequeReceives as $chequeReceive): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo $chequeReceive['party_name'];;echo '</td>
														<td>';echo $chequeReceive['description'];;echo '</td>
														<td class="text-primary"><b>';echo $chequeReceive['debit'];;echo '</b></td>
														<td class="text-danger"><b>';echo $chequeReceive['credit'];;echo '</b></td>
														<td>';echo $chequeReceive['deduction'];;echo '</td>
													</tr>
												';endforeach ;echo '											</tbody>
										</table>
									</div>
								</div>
							</div>

							<!--....................................EXPENSES ACCORDIANS...............................-->

							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion_a" href="#accordion_a_10" style="background:#5A6062 !important; color:white;font-family:open sans;height: 40px;">
											<div class="row">
												<div class="col-lg-9">
													<span class="badge badge-primary" style="padding: 0px 6px 5px 6px;background:white !important;"><i class="fa fa-xing-square" style="color:#CECE28;"></i></span> <span style="font-size:15px !important;"> Expenses
												</div>
												<div class="col-lg-3" style="font-size:12px !important;">
													<span>Total Expenses</span> : <span class="expenses-sum"> 00</span>
												</div>
											</div>
										</a>
									</h4>
								</div>
								<div id="accordion_a_10" class="panel-collapse collapse">
									<div class="panel-body">
										<table class="table table-striped table-hover ar-datatable">
											<thead>
												<tr>
													<th style=\'background: #368EE0;\'>Vr#</th>
													<th style=\'background: #368EE0;\'>Party Name</th>
													<th style=\'background: #368EE0;\'>Amount</th>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;foreach ($expensess as $expenses): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo $expenses['name'];;echo '</td>
														<td class="text-primary"><b>';echo $expenses['amount'];;echo '</b></td>
													</tr>
												';endforeach ;echo '											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- container-fluid -->
	</div><!-- main -->
</div><!-- container-fluid -->

';
?>