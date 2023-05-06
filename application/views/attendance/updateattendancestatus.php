
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
$vouchers = $desc['vouchers'];
;echo '
<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-lg-4">
				<h1 class="page_title">Update Attendance Status</h1>
			</div>
			<div class="col-lg-8">
				<div class="pull-right">
					<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['update_attendance_status']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
					<a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
				</div>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="row">

				<div class="col-lg-12">
					<div id="add_dept">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">

										<form action="">

											<div class="row">
												<div class="col-lg-6">
						                    		<div class="input-group">
						                                <span class="input-group-addon">Department</span>
						                                <select class="form-control" id="dept_dropdown" disabled="">
						                                	<option value="" disabled="" selected="">Choose Department</option>
						                                	';foreach ($departments as $department): ;echo '				                                              	<option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
				                                          	';endforeach ;echo '						                                </select>
						                            </div>
						                    	<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
		                                        <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
		                                        <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
						                    	</div>
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
					                                  	<span class="input-group-addon">Staff</span>
					                                  	<select class="form-control select2" id="id_dropdown">
					                                      	<option value="" disabled="" selected="">Choose Id</option>
					                                      	';foreach ($staffs as $staff): ;echo '					                                          	<option value="';echo $staff['staid'];;echo '" data-fname="';echo $staff['fname'];;echo '" data-did="';echo $staff['did'];;echo '" data-designation="';echo $staff['designation'];;echo '">';echo $staff['staid'];;echo '</option>
					                                      	';endforeach ;echo '					                                  	</select>
													</div>
					                            </div>
					                            <div class="col-lg-3">
				                                  	<select class="form-control select2" id="name_dropdown">
				                                  		<option value="" disabled="" selected="">Choose Staff</option>
				                                      	';foreach ($staffs as $staff): ;echo '				                                          	<option value="';echo $staff['staid'];;echo '" data-fname="';echo $staff['fname'];;echo '" data-did="';echo $staff['did'];;echo '" data-designation="';echo $staff['designation'];;echo '">';echo $staff['name'];;echo '</option>
				                                      	';endforeach ;echo '				                                  	</select>
					                            </div>
					                            <div class="col-lg-3">
						                            <div class="input-group">
						                                <span class="input-group-addon">Date</span>
						                                <input class="form-control " type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
						                            </div>
						                        </div>
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">S/O</div>
														<input type="text" class="form-control num" id="txtFname" disabled="">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Designation</div>
														<input type="text" class="form-control" id="txtDesignation" disabled="">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Status</span>
														<select class="form-control" id="status_dropdown">
											              	<option value="Present" selected="">Present</option>
											              	<option value="Absent">Absent</option>
											              	<option value="Paid Leave">Paid Leave</option>
											              	<option value="Unpaid Leave">Unpaid Leave</option>
											              	<option value="Rest Day">Rest Day</option>
											              	<option value="Gusted Holiday">Gusted Holiday</option>
											              	<option value="Short Leave">Short Leave</option>
											              	<option value="Outdoor">Outdoor</option>
											            </select>
													</div>
												</div>

												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Time In</div>
														<input class="form-control tp num" type="text" id="in_time">
													</div>
												</div>

												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Time Out</div>
														<input class="form-control tp num" type="text" id="out_time">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-6">													
													<div class="input-group">
														<div class="input-group-addon fancy-addon">Remarks</div>
														<input type="text" class="form-control" id="txtRemarks">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-12">
													<div class="pull-right">
														<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['department']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
														<a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
													</div>
												</div> 	<!-- end of col -->
											</div>	<!-- end of row -->
										</form>	<!-- end of form -->

									</div>	<!-- end of panel-body -->
								</div>	<!-- end of panel -->

								<div class="panel panel-default">
									<div class="panel-body">
										<table class="table table-striped table-hover" id=\'atnd-table\'>
											<thead>
												<tr>
													<th>Vr Date</th>
													<th>Vr#</th>													
													<th>Status</th>
													<th>Description</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>

							</div>  <!-- end of col -->
						</div>	<!-- end of row -->

					</div>
				</div>

			</div>
		</div>
	</div>
</div>';
?>