

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
				<h1 class="page_title">Eobi Contribution Report</h1>
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
                                    	<input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                	</div>
                                </div>

                                <div class="col-lg-3">
                                	<div class="input-group">
                                    	<span class="input-group-addon txt-addon">To</span>
                                    	<input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                	</div>
                                </div>
							</div>
							<div class="row">
								<div class="col-lg-4">
									<div class="input-group">
										<span class="input-group-addon fancy-addon">Department</span>
										<select class="form-control" id="dept_dropdown">
											<option value="-1" selected="">All</option>
		                                	';foreach ($departments as $department): ;echo '	                                          	<option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
	                                      	';endforeach ;echo '		                                </select>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="input-group">
										<span class="input-group-addon fancy-addon">Account</span>
										<select class="form-control" id="name_dropdown">
											<option value="-1" selected="">All</option>
		                                	';foreach ($staffs as $staff): ;echo '	                                          	<option value="';echo $staff['staid'];;echo '">';echo $staff['name'];;echo '</option>
	                                      	';endforeach ;echo '		                                </select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="pull-right">
										<a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print</a>
										<a class="btn btn-default btnSearch"><i class="fa fa-search"></i> Show</a>
										<a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
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

							<table class="table table-striped table-hover ar-datatable rptTable" id="report-table">
								<thead>
									<tr>
										<th>Sr#</th>
										<th>Sid</th>
										<th>Name</th>
										<th>Father Name</th>
										<th>Designation</th>
										<th>Department</th>
										<th>Gross Salary</th>
										<th>Net Salary</th>
										<th>Employee 1% Contribution</th>
										<th>Employer 5% Contribution</th>
										<th>Total 6% Contribution</th>
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