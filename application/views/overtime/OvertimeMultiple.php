

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
			<div class="col-lg-3">
				<h1 class="page_title">Over Time Posting</h1>
			</div>
			<div class="col-lg-9">
				<div class="pull-right">
					<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['overtime']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
					<a class="btn btn-default btnDelete" data-deletetbtn=\'';echo $vouchers['overtime']['delete'];;echo '\'><i class="fa fa-trash-o"></i> Delete</a>
					<a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
				</div>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs hidden" id="tabs_a">
					<li class="active"><a data-toggle="tab" href="#add_overtime">Add Update Overtime</a></li>
					<li class=""><a data-toggle="tab" href="#view_all">View All</a></li>
				</ul>
				<div class="tab-content">
					<div id="add_overtime" class="tab-pane fade active in">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">

										<form action="">

											<div class="row">
												<div class="col-lg-2">
													<div class="input-group">
														<span class="input-group-addon id-addon">Vr#</span>
														<input type="number" class="form-control num txtidupdate" data-txtidupdate=\'';echo $vouchers['overtime']['update'];;echo '\' id="txtId">
														<input type="hidden" id="txtMaxIdHidden">
														<input type="hidden" id="txtIdHidden">
														

														<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
														<input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
														<input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">


													</div>
												</div>
												<!-- <div class="col-lg-2"></div> -->
												<div class="col-lg-3">
													<div class="input-group">
														<span class="input-group-addon fancy-addon">Date</span>
														<input class="form-control " type="date" id="cur_date" value="';echo date('Y-m-d');;echo '">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-2">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Staff Id</span>
														<select class="form-control select2" id="staffId_dropdown">
															<option value="" disabled="" selected="">Choose id</option>
															';foreach ($staffs as $staff): ;echo '																<option value="';echo $staff['staid'];;echo '" data-did=\'';echo $staff['did'];;echo '\' data-dept_name=\'';echo $staff['dept_name'];;echo '\' data-fname=\'';echo $staff['fname'];;echo '\' data-name=\'';echo $staff['name'];;echo '\' data-type=\'';echo $staff['type'];;echo '\' data-shift_name=\'';echo $staff['shift_name'];;echo '\' data-shid=\'';echo $staff['shid'];;echo '\'>';echo $staff['staid'];;echo '</option>
															';endforeach ;echo '														</select>
													</div>
												</div>

												<div class="col-lg-4">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Staff</span>
														<select class="form-control select2" id="staff_dropdown">
															<option value="" disabled="" selected="">Choose staff</option>
															';foreach ($staffs as $staff): ;echo '																<option value="';echo $staff['staid'];;echo '" data-did=\'';echo $staff['did'];;echo '\' data-dept_name=\'';echo $staff['dept_name'];;echo '\' data-fname=\'';echo $staff['fname'];;echo '\' data-name=\'';echo $staff['name'];;echo '\' data-type=\'';echo $staff['type'];;echo '\' data-shift_name=\'';echo $staff['shift_name'];;echo '\' data-shid=\'';echo $staff['shid'];;echo '\'>';echo $staff['name'];;echo '</option>
															';endforeach ;echo '														</select>
													</div>
												</div>
												

												<div class="col-lg-3">
													<div class="input-group">
														<span class="input-group-addon">Department</span>
														<select class="form-control select2" id="dept_dropdown">
															<option value=""  selected="">Choose Department</option>
															';foreach ($departments as $department): ;echo '																<option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
															';endforeach ;echo '														</select>
													</div>
													
												</div>

												<div class="col-lg-3">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Remarks</span>
														<input type="text" class="form-control" id="txtRemarks">
													</div>
												</div>

											</div>

											

											<div class="row hidden">
												<div class="col-lg-4">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Approved By</span>
														<input type="text" class="form-control" id="txtApprovedBy">
													</div>
												</div>
											</div>

											<div class="row hidden">
												<div class="col-lg-4">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Reason</span>
														<input type="text" class="form-control" id="txtReason">
													</div>
												</div>
											</div>



											<div class="row hidden">
												<div class="col-lg-4">
													<div class="input-group">
														<span class="input-group-addon fancy-addon">OT Hour</span>
														<!-- <input type="text" class="form-control num" id="txtOTHour" maxlength="2"> -->
														<input type="text" class="form-control num" id="txtOTHour" maxlength="4">
													</div>
												</div>
											</div>

											


											<div class="row">

												<div class="col-lg-12">
													<div class="panel panel-default">
														<div class="panel-body">
															<table class="table table-striped table-hover" id=\'atnd-table\'>
																<thead class="thead">
																	<tr>
																		<th>Sr#</th>
																		<th>Name</th>
																		<th>FName</th>
																		<th>Deptartment</th>
																		<th>Shift</th>
																		<th>AprovedBy</th>
																		<th>Reason</th>
																		<th>OTHours</th>
																		<th>Action</th>

																	</tr>

																</thead>

																<tfoot class="tfoot_tbl">
																	<tr>
																		<td class="text-right" colspan="7">Totals</td>
																		
																		<td class="text-right txtTotalOT"></td>
																		
																		<td></td>
																	</tr>
																</tfoot> 


															</table>

														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-12">
													<div class="pull-right">
														<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['overtime']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
														<a class="btn btn-default btnDelete" data-deletetbtn=\'';echo $vouchers['overtime']['delete'];;echo '\'><i class="fa fa-trash-o"></i> Delete</a>
														<a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
													</div>
												</div> 	<!-- end of col -->
											</div>	<!-- end of row -->

										</form>	<!-- end of form -->

									</div>	<!-- end of panel-body -->
								</div>	<!-- end of panel -->
							</div>  <!-- end of col -->
						</div>	<!-- end of row -->

					</div>	<!-- end of add_branch -->
					<div id="view_all" class="tab-pane fade">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<table class="table table-striped table-hover ar-datatable">
											<thead>
												<tr>
													<td>Sr#</td>
													<td>Name</td>
													<td>Father Name</td>
													<td>Aproved By</td>
													<td>Reason</td>
													<td>Reamrks</td>
													<td>OT Hours</td>
													<td></td>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;foreach ($overtimes as $overtime): ;echo '												<tr>
													<td>';echo $counter++;;echo '</td>
													<td>';echo $overtime['name'];;echo '</td>
													<td>';echo $overtime['fname'];;echo '</td>
													<td>';echo $overtime['approved_by'];;echo '</td>
													<td>';echo $overtime['reason'];;echo '</td>
													<td>';echo $overtime['remarks'];;echo '</td>
													<td>';echo $overtime['othour'];;echo '</td>

													<td><a href="" class="btn btn-primary btn-edit-overtime showallupdatebtn"  data-dcno="';echo $overtime['dcno'];;echo '"><span class="fa fa-edit"></span></a></td>
												</tr>
											';endforeach ;echo '										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div> <!-- end of search_branch -->
			</div>
		</div>
	</div>
</div>
</div>';
?>