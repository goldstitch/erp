

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
				<h1 class="page_title">Staff Status Report</h1>
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
										<span class="input-group-addon">Department</span>
										<select class="form-control" id="dept_dropdown">
		                                  	<option value="all" selected="">Choose department</option>
		                                  	';foreach ($departments as $department): ;echo '		                                      	<option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
		                                  	';endforeach ;echo '		                                </select>
									</div>
								</div>								
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon">Status</span>
										<select class="form-control" id="status_dropdown">		                                    
		                                    <option value="1">Active</option>
		                                    <option value="0">Inactive</option>
		                                    <option value="-1">All</option>
		                                </select>
									</div>
								</div>
								<div class="col-lg-6">
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

					<div class="panel panel-default">
						<div class="panel-body">
							
								<table class="table table-striped table-hover" id="staff-table">
									<thead>
										<tr>
											<th style="width: 4%;">Sr#</th>
											<th style="width: 4%;">Id</th>
											<th>Name</th>
											<th>Designation</th>
											<th>Department</th>
											<th>Mobile</th>
											<th>Salary</th>
											<th>Address</th>
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