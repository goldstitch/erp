

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
;echo '
<div id="main" style=\'margin-right:10px;\'>
		<input type="hidden" id="user_rights" value="';echo $reports['dashboard'];;echo '">
		';if ($reports['dashboard'] == 1): ;echo '			<div class="container">
				<div class=\'row\' style="margin-top:20px;margin-left:5px;">
					<div class=\'col-lg-12\'>
						<ul class="stats">
							<li class=\'satgreen\' style="background-color:#333333;">
								<i class="fa fa-money"></i>
								<div class="details">
									<span class="big sales-sum">0</span>
									<span>Sale</span>
								</div>
							</li>
							<li class=\'satgreen\' style="background-color:#666666;">
								<i class="fa fa-calendar"></i>
								<div class="details">
									<span class="big purchases-sum">0</span>
									<span>Purchase</span>
								</div>
							</li>
							<li class=\'satgreen\' style="background-color:#56af45;">
								<i class="fa fa-money"></i>
								<div class="details">
									<span class="big cash-sum">0</span>
									<span>Cash In Hand</span>
								</div>
							</li>
							<li class=\'satgreen\' style="background-color:#e63a3a;">
								<i class="fa fa-calendar"></i>
								<div class="details">
									<span class="big pd_issue-sum">0</span>
									<span>Cheque Issue</span>
								</div>
							</li>
							<li class=\'satgreen\' style="background-color:#333333;">
								<i class="fa fa-money"></i>
								<div class="details">
									<span class="big pd_receive-sum">0</span>
									<span>Cheque Receive</span>
								</div>
							</li>
							<li class=\'satgreen\' style="background-color:#666666;">
								<i class="fa fa-calendar"></i>
								<div class="details">
									<span class="big expenses-sum">0</span>
									<span>Expenses</span>
								</div>
							</li>
						</ul>
					</div>
				</div>


				<div class="row" style=\'margin-right:0px;margin-top:-20px;\'>
					<div class="col-sm-6">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Sales
								</h3>
								<div class="actions">
									<a href="#" class="btn btn-mini content-refresh">
										<i class="fa fa-refresh"></i>
									</a>
									<a href="#" class="btn btn-mini content-remove">
										<i class="fa fa-times"></i>
									</a>
									<a href="#" class="btn btn-mini content-slideUp">
										<i class="fa fa-angle-down"></i>
									</a>
								</div>
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										<div class="left">
											<select name="category" class=\'chosen-select\' data-nosearch="true" style="width:150px;">
												<option value="1">Visits</option>
												<option value="2">New Visits</option>
												<option value="3">Unique Visits</option>
												<option value="4">Pageviews</option>
											</select>
										</div>
										<div class="right">
											<span class="big sales-sumc">0</span>
											<span>
												<i class="fa fa-arrow-circle-up"></i>
											</span>
										</div>
									</div>
									<div class="bottom">
										<div class="flot medium" id="flot-audience"></div>
									</div>
									<div class="bottom">
										<ul class="stats-overview">
											<li>
												<span class="name">
													Visits
												</span>
												<span class="value">
													250000
												</span>
											</li>
											<li>
												<span class="name">
													Pages / Visit
												</span>
												<span class="value">
													25.25
												</span>
											</li>
											<li>
												<span class="name">
													Avg. Duration
												</span>
												<span class="value">
													00:06:41
												</span>
											</li>
											<li>
												<span class="name">
													% New Visits
												</span>
												<span class="value">
													67,35%
												</span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="box box-color lightred box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									HDD usage
								</h3>
								<div class="actions">
									<a href="#" class="btn btn-mini content-refresh">
										<i class="fa fa-refresh"></i>
									</a>
									<a href="#" class="btn btn-mini content-remove">
										<i class="fa fa-times"></i>
									</a>
									<a href="#" class="btn btn-mini content-slideUp">
										<i class="fa fa-angle-down"></i>
									</a>
								</div>
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										<div class="left">
											<select name="category" class=\'chosen-select\' data-nosearch="true" style="width:150px;">
												<option value="1">Today</option>
												<option value="2">Yesterday</option>
												<option value="3">Last week</option>
												<option value="4">Last month</option>
											</select>
										</div>
										<div class="right">
											50%
											<span>
												<i class="fa fa-arrow-circle-right"></i>
											</span>
										</div>
									</div>
									<div class="bottom">
										<div class="flot medium" id="flot-hdd"></div>
									</div>
									<div class="bottom">
										<ul class="stats-overview">
											<li>
												<span class="name">
													Usage
												</span>
												<span class="value">
													50%
												</span>
											</li>
											<li>
												<span class="name">
													Usage % / User
												</span>
												<span class="value">
													0.031
												</span>
											</li>
											<li>
												<span class="name">
													Avg. Usage %
												</span>
												<span class="value">
													60%
												</span>
											</li>
											<li>
												<span class="name">
													Idle Usage %
												</span>
												<span class="value">
													12%
												</span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row" style=\'margin-right:0px;margin-top:-20px;\'>
					<div class="col-sm-6">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Production Progress
								</h3>
								<div class="actions">
									<a href="#" class="btn btn-mini content-refresh">
										<i class="fa fa-refresh"></i>
									</a>
									<a href="#" class="btn btn-mini content-remove">
										<i class="fa fa-times"></i>
									</a>
									<a href="#" class="btn btn-mini content-slideUp">
										<i class="fa fa-angle-down"></i>
									</a>
								</div>
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										<div class="left">
											<select name="category" class=\'chosen-select\' data-nosearch="true" style="width:150px;">
												<option value="1">Visits</option>
												<option value="2">New Visits</option>
												<option value="3">Unique Visits</option>
												<option value="4">Pageviews</option>
											</select>
										</div>
										<div class="right sales-sum">
											0
											<span>
												<i class="fa fa-arrow-circle-up"></i>
											</span>
										</div>
									</div>
									<div class="bottom">
										<div class="flot medium" id="flot-audience"></div>
									</div>
									<div class="bottom">
										<ul class="stats-overview">
											<li>
												<span class="name">
													Visits
												</span>
												<span class="value">
													11,251
												</span>
											</li>
											<li>
												<span class="name">
													Pages / Visit
												</span>
												<span class="value">
													8.31
												</span>
											</li>
											<li>
												<span class="name">
													Avg. Duration
												</span>
												<span class="value">
													00:06:41
												</span>
											</li>
											<li>
												<span class="name">
													% New Visits
												</span>
												<span class="value">
													67,35%
												</span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<input type="hidden" name="cid" class="cid" value="';echo $this->session->userdata('company_id');;echo '">
						<div class="box box-color lightred box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									HDD usage
								</h3>
								<div class="actions">
									<a href="#" class="btn btn-mini content-refresh">
										<i class="fa fa-refresh"></i>
									</a>
									<a href="#" class="btn btn-mini content-remove">
										<i class="fa fa-times"></i>
									</a>
									<a href="#" class="btn btn-mini content-slideUp">
										<i class="fa fa-angle-down"></i>
									</a>
								</div>
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										<div class="left">
											<select name="category" class=\'chosen-select\' data-nosearch="true" style="width:150px;">
												<option value="1">Today</option>
												<option value="2">Yesterday</option>
												<option value="3">Last week</option>
												<option value="4">Last month</option>
											</select>
										</div>
										<div class="right">
											50%
											<span>
												<i class="fa fa-arrow-circle-right"></i>
											</span>
										</div>
									</div>
									<div class="bottom">
										<div class="flot medium" id="flot-hdd"></div>
									</div>
									<div class="bottom">
										<ul class="stats-overview">
											<li>
												<span class="name">
													Usage
												</span>
												<span class="value">
													100%
												</span>
											</li>
											<li>
												<span class="name">
													Usage % / User
												</span>
												<span class="value">
													0.20
												</span>
											</li>
											<li>
												<span class="name">
													Avg. Usage %
												</span>
												<span class="value">
													60%
												</span>
											</li>
											<li>
												<span class="name">
													Idle Usage %
												</span>
												<span class="value">
													12%
												</span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				';else : ;echo '					<div class="container">
						<div class="row">
							<div class="dashboard-logo">
								<img src="';echo base_url('application/assets/img/blank.gif');;echo '" alt="" />
							</div>
						</div>
					</div>
				';endif;
;echo '			</div>
	</div>
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/general.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/dashboard.js');;echo '"></script>';
?>