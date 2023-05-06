

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

	<div class="container-fluid" id="content">
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left" style="padding-left: 6%;">
						<h1><i class="fa fa-cogs" style=\'font-size:30px;\'></i> CHINIOT FABRICS</h1>
					</div>
					<input type="hidden" name="cid" class="cid" value="';echo $this->session->userdata('company_id');;echo '">
				</div><!-- page-headrer -->
				
					
						
					
			
			
				<div class="row" style="margin:-30px 0px 0px 90px;">
					<div class="col-sm-12">
						<div class="row-fluid">
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-default bg_color_panel">
									<div class="stat_box stat_up">
										<div class="stat_ico color_f"><i class="glyphicon glyphicon-book"></i></div>
										<div class="stat_content">
											<span class="stat_count pd_receive-sum">0</span>
											<span class="stat_name">Cheque Receive</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-default bg_color_panel">
									<div class="stat_box stat_up">
										<div class="stat_ico color_g"><i class="ion-ios7-cart-outline"></i></div>
										<div class="stat_content">
											<span class="stat_count expenses-sum">0</span>
											<span class="stat_name">Expenses</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-default bg_color_panel">
									<div class="stat_box stat_down">
										<div class="stat_ico color_a"><i class="ion-ios7-cart-outline"></i></div>
										<div class="stat_content">
											<span class="stat_count sales-sum">0</span>
											<span class="stat_name">Sale</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-default bg_color_panel">
									<div class="stat_box stat_up">
										<div class="stat_ico color_d"><i class="ion-ios7-email-outline"></i></div>
										<div class="stat_content">
											<span class="stat_count preturns-sum">0</span>
											<span class="stat_name">Purchase Return</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-default bg_color_panel">
									<div class="stat_box stat_up">
										<div class="stat_ico color_f"><i class="glyphicon glyphicon-book"></i></div>
										<div class="stat_content">
											<span class="stat_count big pd_issue-sum">0</span>
											<span class="stat_name">Cheque Issue</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-default bg_color_panel">
									<div class="stat_box stat_up">
										<div class="stat_ico color_g"><i class="ion-clipboard"></i></div>
										<div class="stat_content">
											<span class="stat_count cash-sum ">0</span>
											<span class="stat_name">Cash In Hand</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-default bg_color_panel">
									<div class="stat_box stat_down">
										<div class="stat_ico color_a"><i class="glyphicon glyphicon-cloud"></i></div>
										<div class="stat_content">
											<span class="stat_count sreturns-sum">0</span>
											<span class="stat_name">Sale Return</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6">
								<div class="panel panel-default bg_color_panel">
									<div class="stat_box stat_up">
										<div class="stat_ico color_d"><i class="glyphicon glyphicon-cloud"></i></div>
										<div class="stat_content">
											<span class="stat_count purchases-sum">0</span>
											<span class="stat_name">Purchae</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<ul class="tiles">
							<li class="orange high long">
								<a href="';echo base_url('index.php/setup/addmachine');;echo '">
									<span class=\'count\'>
										<i class="fa fa-shopping-cart"></i></span>
									<span class=\'name\'>Add New Machine</span>
								</a>
							</li>
							<li class="blue">
								<a href="';echo base_url('index.php/setup/addcolor');;echo '">
									<span>
										<i class="fa fa-users"></i>
									</span>
									<span class=\'name\'>Add New Color</span>
								</a>
							</li>
							<li class="red">
								<a href="';echo base_url('index.php/payroll/addgroup');;echo '">
									<span class=\'count\'>
										<i class="fa fa-envelope"></i></span>
									<span class=\'name\'>Add New Group</span>
								</a>
							</li>
							<li class="blue long">
								<a href="';echo base_url('index.php/payroll/addshift');;echo '">
									<span class=\'nopadding\'>
									</span>
									<span class=\'count\'>
										<i class="fa fa-search"></i>
										<span class="name">Add New Shift</span>
									</span>
								</a>
							</li>
							<li class="green long">
								<a href="';echo base_url('index.php/setup/adddepartment');;echo '">
									<span>
										<i class="fa fa-globe"></i>
									</span>
									<span class=\'name\'>Add New Department</span>
								</a>
							</li>
							<li class="brown">
								<a href="';echo base_url('index.php/sale/addsalevoucher');;echo '">
									<span class=\'count\'>
										<i class="fa fa-bolt"></i></span>
									<span class=\'name\'>Sale Voucher</span>
								</a>
							</li>
							<li class="brown">
								<a href="';echo base_url('index.php/sale/addsalereturn');;echo '">
									<span class=\'count\'>
										<i class="fa fa-bolt"></i></span>
									<span class=\'name\'>Sale Return Voucher</span>
								</a>
							</li>
							<li class="teal long">
								<a href="';echo base_url('index.php/purchase/addpurchaseyarn');;echo '">
									<span class=\'count\'>
										<i class="fa fa-cloud-upload"></i></span>
									<span class=\'name\'>Purchase Yarn Voucher</span>
								</a>
							</li>
							<li class="blue">
								<a href="';echo base_url('index.php/setup/ratiovoucher');;echo '">
									<span>
										<i class="fa fa-cogs"></i>
									</span>
									<span class=\'name\'>Ratio Voucher</span>
								</a>
							</li>
							<li class="magenta">
								<a href="';echo base_url('index.php/accounts/addjournalvoucher');;echo '">
									<span>
										<i class="fa fa-star"></i>
									</span>
									<span class=\'name\'>Journal Voucher</span>
								</a>
							</li>
							<li class="pink long">
								<a href="';echo base_url('index.php/packingvoucher');;echo '">
									<span>
										<i class="fa fa-money"></i>
									</span>
									<span class=\'name\'>Packing Voucher</span>
								</a>
							</li>
							<li class="blue">
								<a href="';echo base_url('index.php/foldingvoucher');;echo '">
									<span>
										<i class="fa fa-wrench"></i>
									</span>
									<span class=\'name\'>Folding Voucher</span>
								</a>
							</li>
							<li class="lime">
								<a href="';echo base_url('index.php/pressvoucher');;echo '">
									<span>
										<i class="fa fa-dashboard"></i>
									</span>
									<span class=\'name\'>Press Voucher</span>
								</a>
							</li>
							<li class="orange">
								<a href="';echo base_url('index.php/payroll/overtime');;echo '">
									<span>
										<i class="fa fa-sign-out"></i>
									</span>
									<span class=\'name\'>Over Time</span>
								</a>
							</li>
							<li class="red long">
								<a href="';echo base_url('index.php/purchase/addpurchasereturnyarn');;echo '">
									<span>
										<i class="fa fa-money"></i>
									</span>
									<span class=\'name\'>Purchase Return</span>
								</a>
							</li>
							<li class="blue">
								<a href="';echo base_url('index.php/payroll/attendence');;echo '">
									<span>
										<i class="fa fa-phone"></i>
									</span>
									<span class=\'name\'>Attendance</span>
								</a>
							</li>
							<li class="red">
								<a href="';echo base_url('index.php/payroll/salarysheet');;echo '">
									<span class=\'count\'>
										<i class="fa fa-envelope"></i></span>
									<span class=\'name\'>Salery Sheet</span>
								</a>
							</li>
							<li class="green long">
								<a href="';echo base_url('index.php/yarn/addyarnsalevoucher');;echo '">
									<span>
										<i class="fa fa-globe"></i>
									</span>
									<span class=\'name\'>Yarn Sale Voucher</span>
								</a>
							</li>
						</ul>
					</div><!-- end of col -->
				</div><!-- end of row -->
			</div><!-- container-fluid -->
		</div><!-- main -->
	</div><!-- container-fluid -->
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/general.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/dashboard.js');;echo '"></script>';
?>