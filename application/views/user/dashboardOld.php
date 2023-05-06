

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!-- main content -->
<!-- <div id="main_wrapper">

  	<div class="page_content">

    	<div class="container">

		</div>

	</div>

</div> -->
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
<div class="container" id="content">

	<input type="hidden" name="cid" class="cid" value="';echo $this->session->userdata('company_id');;echo '">
	<!-- 
	    NOTE: Added just for the time being
	    TODO: Add Proper privilige checks 
	-->                 
	<div class="container">
		<!-- Only for admin -->
		';if ($this->session->userdata('user_type') === 'superadmin'): ;echo '		    <div class="row">
		        <div class="input-prepend">
		            <span class="add-on">Choose Company</span>
		            <select class="form-control"  name="company_id" id="drpCompanyId">
		                ';foreach ($companies as $company): ;echo '		                    <option value="';echo $company['company_id'];;echo '" ';echo ( $company['company_id'] === $this->session->userdata('company_id') ) ?'selected': '';;echo '>';echo $company['company_name'] ;echo '</option>
		                ';endforeach;;echo '		            </select>
		        </div>
		    </div>
		';endif;;echo '	</div>

	<div id="main">
		';if ($this->session->userdata('dashboard') !== 'false'): ;echo '			<div class="container">
				<div class="page-header">
					<div class="pull-left">
						<!-- <h1>Dashboard</h1> -->
					</div>


					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-lg-3 col-md-6">
									<div class="panel panel-default">
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
									<div class="panel panel-default">
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
									<div class="panel panel-default">
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
									<div class="panel panel-default">
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
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-lg-3 col-md-6">
									<div class="panel panel-default">
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
									<div class="panel panel-default">
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
									<div class="panel panel-default">
										<div class="stat_box stat_down">
											<div class="stat_ico color_a"><i class="glyphicon glyphicon-cloud"></i></div>
											<div class="stat_content">
												<span class="stat_count sales-sum">0</span>
												<span class="stat_name">Sale Return</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-6">
									<div class="panel panel-default">
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
						</div>
					</div>






					<!-- <div class="pull-right">
						<ul class="stats">
							<li class=\'blue\'>
								<i class="glyphicon glyphicon-star"></i>
								<div class="details">
									<span class="big pd_issue-sum">0.00</span>
									<span>Issue Cheques</span>
								</div>
							</li>
							<li class=\'blue\'>
								<i class="glyphicon glyphicon-star"></i>
								<div class="details">
									<span class="big pd_receive-sum">0.00</span>
									<span>Receive Cheques</span>
								</div>
							</li>
							<li class=\'green chknew1\'>
								<i class="glyphicon glyphicon-star"></i>
								<div class="details">
									<span class="big cash-sum">0.00</span>
									<span>Cash in hand</span>
								</div>
							</li>
							<li class=\'blue chknew\'>
								<i class="glyphicon glyphicon-star"></i>
								<div class="details">
									<span class="big sales-sum">0.00</span>
									<span>Net Sales</span>
								</div>
							</li>
							<li class=\'red chknew\'>
								<i class="glyphicon glyphicon-star"></i>
								<div class="details">
									<span class="big purchases-sum">0.00</span>
									<span>Net Purchases</span>
								</div>
							</li>
							<li class=\'green\'>
								<i class="glyphicon glyphicon-star"></i>
								<div class="details">
									<span class="big preturns-sum">0.00</span>
									<span>Net Purchase Return</span>
								</div>
							</li>
							<li class=\'blue chknew\'>
								<i class="glyphicon glyphicon-star"></i>
								<div class="details">
									<span class="big sreturns-sum">0.00</span>
									<span>Net Sale Return</span>
								</div>
							</li>
							<!-- <li class=\'orange\'>
								<i class="icon-calendar"></i>
								<div class="details">
									<span class="big">';echo $currDate;;echo '</span>
									<span>';echo $currDay;;echo '</span>
								</div>
							</li>
						</ul>
					</div> --> 
				</div>
				<!-- <div class="breadcrumbs">
					<ul>
						<li>
							<a href="more-login.html">Home</a>
							<i class="icon-angle-right"></i>
						</li>
						<li>
							<a href="index.html">Dashboard</a>
						</li>
					</ul>
					<div class="close-bread">
						<a href="#"><i class="icon-remove"></i></a>
					</div>
				</div> -->
		        
		        
		        <div class="row">
		        	<div class="col-lg-12 bar">
		        		<div class="input-prepend" style="padding: 10px; background: #368ee0;">
		        			<span class="add-on">Barcode</span>
		        			<input type="text" name="barcode" class="barcode-value" placeholder="Search voucher by barcode value!" />
		        		</div>
		        	</div>
		        </div>

		        <!-- Sales and Purchases stats row -->
		        <div class="row">
		            <!-- Sales -->
		            <div class="col-lg-6 sales">
		                <div class="box box-color box-bordered">
		                    <div class="box-title">
		                        <h3>
		                            <i class="icon-shopping-cart"></i>Sales</h3>
		                        <!-- <div class="actions">
		                            <a href="#" class="btn btn-mini content-refresh"><i class="icon-refresh"></i></a>
		                            <a href="#" class="btn btn-mini content-remove"><i class="icon-remove"></i></a><a
		                                href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i>
		                            </a>
		                        </div> -->
		                    </div>
		                    <div class="box-content">
		                        <div class="container">
		                            <div class="row">
		                                <div class="col-lg-2">
		                                    <select class="form-control" name="sales_view" id="sales-view" class="">
		                                        <option value="" disabled>Chose View fgfg</option>
		                                        <option value="tabular" selected>Tabular Form</option>
		                                        <option value="chart">Chart</option>
		                                    </select>
		                                </div>
		                                <div class="col-lg-2">
		                                    <select class="form-control" name="sales_period" id="sales-period" class="">
		                                        <option value="" disabled>Chose Period dfdf</option>
		                                        <option value="Yearly">Yearly</option>
		                                        <option value="Monthly">Monthly</option>
		                                        <option value="Weekly">Weekly</option>
		                                        <option value="Daily" selected>Daily</option>
		                                    </select>
		                                </div>
		                            </div>
		                        </div>
		                        <br>
		                        <table class="table table-hover table-bordered footable" id="sales-table" style="border: 1px solid #ccc;">
		                            <thead style=\'background-color:black !important;\'>
		                                <tr style=\'background-color:black !important;\'>
		                                    <th style=\'background-color:black !important;\'>Vr #
		                                    </th>
		                                    <th>Account
		                                    </th>
		                                    <th>Amount
		                                    </th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                            </tbody>
		                        </table>
		                        <div id="sales-graph">
		                        </div>
		                        <br />
		                        <p>
		                            <b>Sales</b> <span id="total-sales-amount"></span>
		                        </p>
		                    </div>
		                </div>
		            </div>

		            <!-- Purchases -->
		            <div class="col-lg-6 purchases">
		                <div class="box box-color box-bordered">
		                    <div class="box-title">
		                        <h3>
		                            <i class="icon-shopping-cart"></i>Purchases</h3>
		                        <!-- <div class="actions">
		                            <a href="#" class="btn btn-mini content-refresh"><i class="icon-refresh"></i></a>
		                            <a href="#" class="btn btn-mini content-remove"><i class="icon-remove"></i></a><a
		                                href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i>
		                            </a>
		                        </div> -->
		                    </div>
		                    <div class="box-content">
		                        <div class="container">
		                            <div class="row">
		                                <div class="col-lg-2">
		                                    <select class="form-control" name="purchases_view" id="purchases-view" class="span12">
		                                        <option value="" disabled>Chose View</option>
		                                        <option value="tabular" selected>Tabular Form</option>
		                                        <option value="chart">Chart</option>
		                                    </select>
		                                </div>
		                                <div class="col-lg-2">
		                                    <select class="form-control" name="purchases_period" id="purchases-period" class="span12">
		                                        <option value="" disabled>Chose Period</option>
		                                        <option value="Yearly">Yearly</option>
		                                        <option value="Monthly">Monthly</option>
		                                        <option value="Weekly">Weekly</option>
		                                        <option value="Daily" selected>Daily</option>
		                                    </select>
		                                </div>
		                            </div>
		                        </div>
		                        <br>
		                        <table class="table table-hover table-bordered footable" id="purchases-table">
		                            <thead>
		                                <tr>
		                                    <th data-class="expand">Account
		                                    </th>
		                                    <th>Amount
		                                    </th>
		                                    <th data-hide="phone,tablet">Stid#
		                                    </th>
		                                    <th data-hide="phone,tablet">Vr #
		                                    </th>
		                                    <th data-hide="phone,tablet">Party Id
		                                    </th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                            </tbody>
		                        </table>
		                        <div id="purchases-graph">
		                        </div>
		                        <br />
		                        <p>
		                            <b>Total Purchases</b> <span id="total-purchases-amount"></span>
		                        </p>
		                    </div>
		                </div>
		            </div>
		        </div>
				
				<!-- Receipts and Payments stats row -->
		        <div class="row">
		              <!-- Receipts -->
		            <div class="col-lg-6 receipts">
		                <div class="box box-color box-bordered">
		                    <div class="box-title">
		                        <h3>
		                            <i class="icon-shopping-cart"></i>Receipts</h3>
		                        <!-- <div class="actions">
		                            <a href="#" class="btn btn-mini content-refresh"><i class="icon-refresh"></i></a>
		                            <a href="#" class="btn btn-mini content-remove"><i class="icon-remove"></i></a><a
		                                href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i>
		                            </a>
		                        </div> -->
		                    </div>
		                    <div class="box-content">
		                        <div class="container">
		                            <div class="row">
		                                <div class="col-lg-2">
		                                    <select class="form-control" name="receipts_view" id="crvs-view" class="span12">
		                                        <option value="" disabled>Chose View</option>
		                                        <option value="tabular" selected>Tabular Form</option>
		                                        <option value="chart">Chart</option>
		                                    </select>
		                                </div>
		                                <div class="col-lg-2">
		                                    <select class="form-control" name="receipts_period" id="crvs-period" class="span12">
		                                        <option value="" disabled>Chose Period</option>
		                                        <option value="Yearly">Yearly</option>
		                                        <option value="Monthly">Monthly</option>
		                                        <option value="Weekly">Weekly</option>
		                                        <option value="Daily" selected>Daily</option>
		                                    </select>
		                                </div>
		                            </div>
		                        </div>
		                        <br>
		                        <table class="table table-hover table-bordered footable" id="crvs-table">
		                            <thead>
		                                <tr>
		                                    <th data-class="expand">Account</th>
		                                    <th>Amount</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                            </tbody>
		                        </table>
		                        <div id="crvs-graph">
		                        </div>
		                        <br />
		                        <p>
		                            <b>Total Receipts</b> <span id="total-crvs-amount"></span>
		                        </p>
		                    </div>
		                </div>
		            </div>
		            
		            <!-- Payments -->
		            <div class="col-lg-6 payments">
		                <div class="box box-color box-bordered">
		                    <div class="box-title">
		                        <h3>
		                            <i class="icon-shopping-cart"></i>Payments</h3>
		                        <!-- <div class="actions">
		                            <a href="#" class="btn btn-mini content-refresh"><i class="icon-refresh"></i></a>
		                            <a href="#" class="btn btn-mini content-remove"><i class="icon-remove"></i></a><a
		                                href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i>
		                            </a>
		                        </div> -->
		                    </div>
		                    <div class="box-content">
		                        <div class="container">
		                            <div class="row">
		                                <div class="col-lg-2">
		                                    <select class="form-control" name="payments_view" id="cpvs-view" class="span12">
		                                        <option value="" disabled>Chose View</option>
		                                        <option value="tabular" selected>Tabular Form</option>
		                                        <option value="chart">Chart</option>
		                                    </select>
		                                </div>
		                                <div class="col-lg-2">
		                                    <select class="form-control" name="payments_period" id="cpvs-period" class="span12">
		                                        <option value="" disabled>Chose Period</option>
		                                        <option value="Yearly">Yearly</option>
		                                        <option value="Monthly">Monthly</option>
		                                        <option value="Weekly">Weekly</option>
		                                        <option value="Daily" selected>Daily</option>
		                                    </select>
		                                </div>
		                            </div>
		                        </div>
		                        <br>
		                        <table class="table table-hover table-bordered footable" id="cpvs-table">
		                            <thead>
		                                <tr>
		                                    <th data-class="expand">Account</th>
		                                    <th>Amount</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                            </tbody>
		                        </table>
		                        <div id="cpvs-graph">
		                        </div>
		                        <br />
		                        <p>
		                            <b>Total Payments</b> <span id="total-cpvs-amount"></span>
		                        </p>
		                    </div>
		                </div>
		            </div>
		        </div>

				<!-- Issue and Receive Cheques row -->
		        <div class="row">
		              <!-- Receipts -->
		            <div class="col-lg-6 pd_issue-pane">
		                <div class="box box-color box-bordered">
		                    <div class="box-title">
		                        <h3>
		                            <i class="icon-shopping-cart"></i>Cheque Issue</h3>
		                    </div>
		                    <div class="box-content">
		                        <table class="table table-hover table-bordered footable" id="pd_issue-table" style="border:1px solid #ccc !important;">
		                            <thead>
		                                <tr>
		                                	<th>Date</th>
		                                	<th>Mature Date</th>
		                                	<th>Vr#</th>
		                                    <th>Cheque#</th>
		                                    <th>Party</th>
		                                    <th>Bank</th>
		                                    <th>Amount</th>
		                                </tr>
		                            </thead>
		                            <tbody class="pd_issueRows">
		                            </tbody>
		                        </table>
		                    </div>
		                </div>
		            </div>
		            
		            <div class="col-lg-6 pd_receive-pane">
		                <div class="box box-color box-bordered">
		                    <div class="box-title">
		                        <h3>
		                            <i class="icon-shopping-cart"></i>Cheque Receive</h3>
		                    </div>
		                    <div class="box-content">
		                        <table class="table table-hover table-bordered footable" id="pd_receive-table" style="border:1px solid #ccc !important;">
		                            <thead>
		                                <tr>
		                                	<th>Date</th>
		                                	<th>Mature Date</th>
		                                	<th>Vr#</th>
		                                    <th>Cheque#</th>
		                                    <th>Party</th>
		                                    <th>Bank</th>
		                                    <th>Amount</th>
		                                </tr>
		                            </thead>
		                            <tbody class="pd_receiveRows">
		                            </tbody>
		                        </table>
		                    </div>
		                </div>
		            </div>
		        </div>


			</div>
		';else : ;echo '			<div class="container">
				<div class="row">
					<div class="dashboard-logo">
						<img src="';echo base_url('application/assets/img/dashboard-logo.png');;echo '" alt="" />
					</div>
				</div>
			</div>
		';endif;
;echo '	</div>
</div>
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/general.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/dashboard.js');;echo '"></script>';
?>