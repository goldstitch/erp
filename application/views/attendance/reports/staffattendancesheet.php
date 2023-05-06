

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
				<h1 class="page_title">Attendance Leave Status</h1>
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
	                                    
	                                    <input class="form-control input-sm" type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
	                                </div>
	                            </div>
								<div class="col-lg-3">
	                                <div class="input-group">
	                                    <span class="input-group-addon">To</span>
	                                    
	                                    <input class="form-control input-sm" type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
	                                </div>
	                            </div>
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon">Department</span>
										<select class="form-control select2" id="dept_dropdown">
		                                  	<option value="" disabled="" selected="">Choose department</option>
		                                  	';foreach ($departments as $department): ;echo '		                                      	<option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
		                                  	';endforeach ;echo '		                                </select>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon">staff Id</span>
										<select class="form-control select2" id="staff_dropdown">
		                                    <option value="" disabled="" selected="">Choose staff Id</option>
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
	            						Show</a>
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

							<table class="table table-striped table-hover center" id="atnd-table">
								<thead>
									<tr>
										<th rowspan=\'2\'>Sr#</th>
										<th rowspan=\'2\'>Id</th>
										<th rowspan=\'2\'>Name</th>
										<th rowspan=\'2\'>Designation</th>
										<th colspan=\'3\' class=\'text-center\'>Paid</th>
									</tr>
									<tr>
										<th>Allow</th>
										<th>Avail</th>
										<th>Rem</th>
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