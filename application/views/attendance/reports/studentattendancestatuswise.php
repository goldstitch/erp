


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
				<h1 class="page_title">Student Attendance Status Wise</h1>
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
	                                    <span class="input-group-addon">From</span>
	                                    <input class="form-control ts_datepicker datepicker" type="text" id="from_date">
	                                </div>
	                            </div>

	                            <div class="col-lg-3">
	                                <div class="input-group">
	                                    <span class="input-group-addon">To</span>
	                                    <input class="form-control ts_datepicker datepicker" type="text" id="to_date">
	                                </div>
	                            </div>
							</div>

							<div class="row">
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon">Course</span>
										<select class="form-control" id="course_dropdown">
		                                  	<option value="" disabled="" selected="">Choose Course</option>
		                                  	';foreach ($courses as $course): ;echo '		                                      	<option value="';echo $course['cmid'];;echo '">';echo $course['name'];;echo '</option>
		                                  	';endforeach ;echo '		                                </select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon">Std. Id</span>
										<select class="form-control" id="stdid_dropdown">
		                                    <option value="" disabled="" selected="">Choose student Id</option>
		                                </select>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon">Status</span>
										<select class="form-control" id="status_dropdown">
		                                    <option value="Present">Present</option>
		                                    <option value="Absent">Absent</option>
		                                    <option value="Leave">Leave</option>
		                                    <option value="-1">All</option>
		                                </select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="pull-right">
										<a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print</a>
										<a href=\'\' class="btn btn-default btnSearch">
	              							<i class="fa fa-search"></i>
	            						Search</a>
	            						<a href="" class="btn btn-default btnReset">
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

							<table class="table table-striped table-hover" id="atnd-table">
								<thead>
									<tr>
										<th>Sr#</th>
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