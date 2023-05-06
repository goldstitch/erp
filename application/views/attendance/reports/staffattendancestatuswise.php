

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Staff Attendance Report</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">

							<div class="row">
								<div class="col-lg-3">
	                                <div class="input-group">
	                                    <span class="input-group-addon txt-addon">From</span>
	                                    <!-- <input class="form-control ts_datepicker datepicker" type="text" id="from_date"> -->
	                                    <input class="form-control input-sm" type="date" id="from_date" value="';echo date('Y-m-d');;echo '" >
	                                </div>
	                            </div>

	                            <div class="col-lg-3">
	                                <div class="input-group">
	                                    <span class="input-group-addon txt-addon">To</span>
	                                    <!-- <input class="form-control ts_datepicker datepicker" type="text" id="to_date"> -->
	                                    <input class="form-control input-sm" type="date" id="to_date" value="';echo date('Y-m-d');;echo '" >

	                                </div>
	                            </div>
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon">Department</span>
										<select class="form-control select2" id="dept_dropdown">
		                                  	<option value="-1" selected="">All</option>
		                                  	';foreach ($departments as $department): ;echo '		                                      	<option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
		                                  	';endforeach ;echo '		                                </select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon">staff Id</span>
										<select class="form-control select2" id="staff_dropdown">
		                                    <option value="" disabled="" selected="">Choose staff Id</option>
		                                    ';foreach ($staffs as $staff): ;echo '		                                    	<option value="';echo $staff['staid'];;echo '">';echo $staff['staid'] ." - ".$staff['name'];;echo '</option>
		                                    ';endforeach ;echo '		                                </select>
									</div>
									<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                    <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                    <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
                                    <input type="hidden" name="company_name" id="company_name" value="';echo $this->session->userdata('company_name');;echo '">
								</div>
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon">Status</span>
										<select class="form-control select2" id="status_dropdown">
		                                    <option value="-1" selected="">All</option>
		                                    <option value="Present">Present</option>
											<option value="Absent">Absent</option>
											<option value="Paid Leave">Paid Leave</option>
											<option value="Unpaid Leave">Unpaid Leave</option>
											<option value="Rest Day">Rest</option>
											<option value="Gusted Holiday">Gusted Leave</option>
											<option value="Short Leave">Short Leave</option>
											<option value="Outdoor">Outdoor</option>
		                                </select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="pull-right">
										<a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print</a>
										<a href=\'\' class="btn btn-primary btnSearch">
	              							<i class="fa fa-search"></i>
	            						Show</a>
	            						<a href="" class="btn btn-danger btnReset">
					                      	<i class="fa fa-refresh"></i>
					                    Reset</a>
				                    </div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
                                <div class="pull-right acc_ledger">
                                    <ul class="stats">
                                        <li class=\'blue\'>
                                            <div class="details">
                                                <span class="big Presents">0</span>
                                                <span style="font-weight:bolder !important; font-size: 14px !important;">Presents</span>
                                            </div>
                                        </li>
                                        <li class=\'red\'>
                                            <div class="details">
                                                <span class="big Absents">0</span>
                                                <span style="font-weight:bolder !important; font-size: 14px !important;">Absents</span>
                                            </div>
                                        </li>
                                        <li class=\'green\'>
                                            <div class="details">
                                                <span class="big Paid-Leave">0</span>
                                                <span style="font-weight:bolder !important; font-size: 14px !important;">Paid Leave</span>
                                            </div>
                                        </li>
                                        <li class=\'brown\'>
                                            <div class="details">
                                                <span class="big Unpaid-Leave">0</span>
                                                <span style="font-weight:bolder !important; font-size: 14px !important;">Unpaid Leave</span>
                                            </div>
                                        </li>
                                        <li class=\'blue\'>
                                            <div class="details">
                                                <span class="big Rest-Day">0</span>
                                                <span style="font-weight:bolder !important; font-size: 14px !important;"> Rest Day</span>
                                            </div>
                                        </li>
                                        <li class=\'red\'>
                                            <div class="details">
                                                <span class="big Gusted-Holiday">0</span>
                                                <span style="font-weight:bolder !important; font-size: 14px !important;">Gusted Holiday</span>
                                            </div>
                                        </li>
                                        <li class=\'green\'>
                                            <div class="details">
                                                <span class="big Short-Leave">0</span>
                                                <span style="font-weight:bolder !important; font-size: 14px !important;">Short Leave</span>
                                            </div>
                                        </li>
                                        <li class=\'brown\'>
                                            <div class="details">
                                                <span class="big Outdoor">0</span>
                                                <span style="font-weight:bolder !important; font-size: 14px !important;">Outdoor</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
							</div>
							<div class="row">
							</div>
							<table class="table table-striped table-hover" id="atnd-table">
								<thead>
									<tr>
										<th>Sr#</th>
										<th>Vr#</th>
										<th>Date</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>';
?>