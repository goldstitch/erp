

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
				<h1 class="page_title">Add Staff</h1>
			</div>
			<div class="col-lg-9">
				<div class="pull-right">
					<a href=\'\' class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['staff']['insert'];;echo '\'><i class="fa fa-save"></i>Save</a>
					<a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i>Reset</a>
				</div>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">

				<form action="">

					<ul class="nav nav-pills">
						<li class="active"><a href="#basicInformation" data-toggle="tab">Basic Information</a></li>
						<li><a href="#salarydeductions" data-toggle="tab">Salary &amp; Deductions</a></li>
						<li><a href="#qualification" data-toggle="tab">Qualifications</a></li>
						<li><a href="#experience" data-toggle="tab">Experience</a></li>
						<li><a href="#viewall" data-toggle="tab">Staff List</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="basicInformation">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">

											<div class="row">
												<div class="col-lg-9">

													<div class="row"></div>
													<div class="row"></div>
													<div class="row"></div>
													<div class="row"></div>
													<div class="row">

														<div class="col-lg-3">
															<div class="input-group">
																<span class="input-group-addon">Id</span>
																<input type="number" class="form-control num showallupdatebtn" id="txtStaffId" data-showallupdatebtn=\'';echo $vouchers['staff']['update'];;echo '\'>
																<input type="hidden" id="txtMaxStaffIdHidden">
																<input type="hidden" id="txtStaffIdHidden">
																<input type="hidden" id="txtPIdHidden">

																<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
																<input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
																<input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

															</div>


														</div>

														<div class="col-lg-4">
															<div class="form-group">
																<div class="input-group input-group-block">
																	<span class="switch-addon">Is active?</span>
																	<input type="checkbox" checked="" class="bs_switch active_switch" id="gender">
																</div>
															</div>
														</div>
													</div>

													<div class="row">

														<div class="col-lg-4">
															<div class="input-group">
																<span class="input-group-addon">Date</span>
																<input class="form-control " type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
															</div>
														</div>
														<!-- <div class="col-lg-1"></div> -->
														<div class="col-lg-4">
															<div class="input-group">
																<span class="input-group-addon">Type</span>
																<select class="form-control select2" id="type_dropdown">
																	<option value="" disabled="" selected="">Choose Type</option>
																	';foreach ($types as $type): ;echo '																		<option value="';echo $type['type'];;echo '">';echo $type['type'];;echo '</option>
																	';endforeach ;echo '																</select>
																<span class="input-group-btn">
																	<a href="#TypeModel" data-toggle="modal" class="btn btn-primary">+</a>
																</span>
															</div>
														</div>

														<div class="col-lg-4">
															<div class="input-group">
																<span class="input-group-addon">Agreement</span>
																<select class="form-control select2" id="agreement_dropdown">
																	<option value="" disabled="" selected="">Choose Agreement</option>
																	';foreach ($agreements as $agreement): ;echo '																		<option value="';echo $agreement['agreement'];;echo '">';echo $agreement['agreement'];;echo '</option>
																	';endforeach ;echo '																</select>
																<span class="input-group-btn">
																	<a href="#AgreementModel" data-toggle="modal" class="btn btn-primary">+</a>
																</span>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-lg-5">
															<div class="input-group">
																<span class="input-group-addon">Department</span>
																<select class="form-control select2" id="dept_dropdown">
																	<option value="" disabled="" selected="">Choose Department</option>
																	';foreach ($departments as $department): ;echo '																		<option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
																	';endforeach ;echo '																</select>
															</div>
														</div>
														<div class="col-lg-4">
															<div class="input-group">
																<span class="input-group-addon">Designation</span>
																<!-- <input type="text" class="form-control" id="txtDesignation"> -->
																<input type="text" list=\'desig\' class="form-control input-sm" id="txtDesignation" />
																<datalist id=\'desig\'>
																	';foreach ($desigs as $desig): ;echo '																		<option value="';echo $desig['designation'];;echo '">
																		';endforeach ;echo '																	</datalist>

																</div>
															</div>
															<div class="col-lg-3">
																<div class="input-group">
																	<span class="input-group-addon">Machine Id</span>
																	<input type="text" class="form-control" id="txtMachineId">
																</div>
															</div>
														</div>
													</div>
													<div class="col-lg-3">
														<div style="background: #F5F6F7;padding: 15px;border: 1px solid #ccc;box-shadow: 1px 1px 1px #000;">
															<div class="row">
																<div class="col-lg-12">
																	<div class="studentImageWrap">
																		<img src="';echo base_url('assets/img/student.jpg');;echo '" alt="student" style="margin: auto;display: block;" id="staffImageDisplay">
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-lg-12">
																	<input type="file" id="staffImage">
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>  <!-- end of row 1 of basic information -->

								<div class="row">
									<div class="col-lg-6">
										<div class="panel panel-default">
											<div class="panel-heading">General Information</div>

											<div class="panel-body">

												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<span class="input-group-addon">Name</span>
															<input type="text" class="form-control" placeholder="Staff name" id="txtName"/>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<span class="input-group-addon">Father Name</span>
															<input type="text" class="form-control" placeholder="Father name" id="txtFatherName">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<span class="input-group-addon">Gender</span>
															<select class="form-control" id="gender_dropdown">
																<option value=\'male\'>Male</option>
																<option value=\'female\'>Female</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<span class="input-group-addon">Martial Status</span>
															<select class="form-control" id="marital_dropdown">
																<option value=\'single\'>Single</option>
																<option value=\'married\'>Married</option>
																<option value=\'divorced\'>Divorced</option>
																<option value=\'widowed\'>Widowed</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<span class="input-group-addon">Religion</span>
															<select class="form-control" id="religion_dropdown">
																<option value="" disabled="" selected="">Choose Religion</option>
																';foreach ($religions as $religion): ;echo '																	<option value="';echo $religion['religion'];;echo '">';echo $religion['religion'];;echo '</option>
																';endforeach ;echo '															</select>
															<span class="input-group-btn">
																<a href="#ReligionModel" data-toggle="modal" class="btn btn-primary">+</a>
															</span>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<span class="input-group-addon">CNIC</span>
															<input class="form-control num" type="text" placeholder="Staff national ID card no" id="txtcnic">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<span class="input-group-addon">Blood Group</span>

															<input type="text" list=\'blood_groups\' class="form-control input-sm" id="txtBloodGroup" />
															<datalist id=\'blood_groups\'>
																';foreach ($blood_groups as $blood_groups): ;echo '																	<option value="';echo $blood_groups['blood_group'];;echo '">
																	';endforeach ;echo '																</datalist>

															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-6">
															<div class="input-group">
																<span class="input-group-addon">Date of Birth</span>
																<input class="form-control" type="date" id="birth_date" value="';echo date('Y-m-d');;echo '">
															</div>
														</div>

														<div class="col-lg-6">
															<div class="input-group">
																<span class="input-group-addon">Date of Joining</span>
																<input class="form-control" type="date" id="joining_date" value="';echo date('Y-m-d');;echo '">
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>    <!-- end of general information -->
										<div class="col-lg-6">
											<div class="row">
												<div class="col-lg-12">
													<div class="panel panel-default">
														<div class="panel-heading">Contact Information</div>

														<div class="panel-body">
															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Address</span>
																		<input type="text" class="form-control" placeholder="Home address" id="txtAddress">
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Emergency<br>Contact</span>
																		<input type="text" class="form-control num" placeholder="Phone no" id="txtPhoneNo">
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Mobile No</span>
																		<input type="text" class="form-control num" placeholder="Mobile No" id="txtMobileNo">
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
														<div class="panel-heading">Bank Account Information</div>
														<div class="panel-body">
															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Bank Name</span>
																		<select class="form-control" id="bank_dropdown">
																			<option value="" disabled="" selected="">Choose Bank</option>
																			';foreach ($banks as $bank): ;echo '																				<option value="';echo $bank['bankname'];;echo '">';echo $bank['bankname'];;echo '</option>
																			';endforeach ;echo '																		</select>
																		<span class="input-group-btn">
																			<a href="#BankModel" data-toggle="modal" class="btn btn-primary">+</a>
																		</span>
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Account #</span>
																		<input type="text" class="form-control" id="txtAccountNo">
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Salary</span>
																		<input type="text" class="form-control" id="txtSalary" value="0" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>    <!-- end of contact information -->
									</div>  <!-- end of row general information -->

									<div class="row">
										<div class="col-lg-6">
											<div class="panel panel-default">
												<div class="panel-heading">Shift Information</div>
												<div class="panel-body">
													<div class="row">
														<div class="col-lg-6">
															<div class="input-group">
																<span class="input-group-addon">Shift Group</span>
																<select class="form-control" id="shiftgroup_dropdown">
																	<option value="" disabled="" selected="">Choose shift group</option>
																	';foreach ($shiftGroups as $shiftGroup): ;echo '																		<option value="';echo $shiftGroup['gid'];;echo '" data-date="';echo substr($shiftGroup['date'],0,10);;echo '">';echo $shiftGroup['name'];;echo '</option>
																	';endforeach ;echo '																</select>
															</div>
														</div>

														<div class="col-lg-6">
															<div class="input-group">
																<span class="input-group-addon">Shift Date</span>
																<input class="form-control ts_datepicker" type="text" id="shiftgroup_date">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>



								</div>    <!-- end of basicInformation -->

								<div class="tab-pane" id="salarydeductions">

									<div class="row">
										<div class="col-lg-8">
											<div class="row">
												<div class="col-lg-12">	              				
													<div class="panel panel-default">
														<div class="panel-heading">Salary</div>
														<div class="panel-body">
															<div class="row">
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon">PS</span>
																		<input type="text" class="form-control num" id=\'txtbs\'>
																	</div>
																</div>									
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon">Basic Pay</span>
																		<input type="text" class="form-control num calc" id=\'txtbpay\' value="0">
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon">Conv. Allow.</span>
																		<input type="text" class="form-control num calc" id=\'txtconvallow\'>
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon">House Rent</span>
																		<input type="text" class="form-control num calc" id=\'txthrent\'>
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon">Entertainment</span>
																		<input type="text" class="form-control num calc" id=\'txtentertain\'>
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon">Med. Allow.</span>
																		<input type="text" class="form-control num calc" id=\'txtmedallow\'>
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon">Other</span>
																		<input type="text" class="form-control num calc" id=\'txtadhoc1\'>
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="input-group pull-right">
																		<span class="input-group-addon other-addon">Gross Pay</span>
																		<input type="text" class="form-control num" readonly="readonly" id=\'txttotalpay\'>
																	</div>
																</div>
															</div>
														</div>
													</div>	              			
												</div>
											</div>
											<div class="row">
												<div class="col-lg-5">
													<div class="panel panel-default">
														<div class="panel-heading">Allowed Leaves</div>
														<div class="panel-body">

															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Casual Leaves</span>
																		<input class="form-control num" type="text" id="txtAldLeaves" maxlength="3">
																	</div>
																</div>
															</div>



															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Medical Leaves</span>
																		<input class="form-control num" type="text" id="txtAldMedLeaves" maxlength="3">
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Unpaid Leaves</span>
																		<input class="form-control num" type="text" id="txtAldUnpaidLeaves" maxlength="3">
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-addon">Rest Day</span>
																		<select class="form-control select2" id="restday_dropdown">
																		<option value="" >Choose Rest Day</option>
																			
																			<option value="Monday">Monday</option>
																			<option value="Tuesday">Tuesday</option>
																			<option value="Wednesday">Wednesday</option>
																			<option value="Thursday">Thursday</option>
																			<option value="Friday" >Friday</option>
																			<option value="Saturday">Saturday</option>
																			<option selected value="Sunday">Sunday</option>
																			
																		</select>
																	</div>
																</div>
															</div>


														</div>
													</div>
												</div>

												<div class="col-lg-7">
													<div class="panel panel-default">
														<div class="panel-heading">Over Time</div>
														<div class="panel-body">
															<div class="row">
																<div class="col-lg-7">
																	<div class="row">
																		<div class="col-lg-3">
																			<label for="otallowed">
																				<input type="radio" id="otallowed" name="ot" value="otallowed">
																				Allowed
																			</label>
																		</div>

																		<div class="col-lg-4">
																			<label for="otnotallowed">
																				<input type="radio" id="otnotallowed" name="ot" value="otnotallowed" checked="checked">
																				Not Allowed
																			</label>
																		</div>
																	</div>
																</div>

																<div class="col-lg-5">
																	<div class="input-group">
																		<span class="input-group-addon">OT Rate</span>
																		<input class="form-control num" type="text" id="txtOTRate">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="col-lg-4">
											<div class="panel panel-default">
												<div class="panel-heading">Deductions</div>
												<div class="panel-body">	              				
													<div class="row">
														<div class="col-lg-12">
															<div class="input-group">
																<span class="input-group-addon cus-group-addon2">EOBI</span>
																<input type="text" class="form-control num calc2" id=\'txteobi\'>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<div class="input-group">
																<span class="input-group-addon cus-group-addon2">Social Security</span>
																<input type="text" class="form-control num calc2" id=\'txtsocialsecurity\'>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<div class="input-group">
																<span class="input-group-addon cus-group-addon2">Insurance</span>
																<input type="text" class="form-control num calc2" id=\'txtinsurance\'>
															</div>
														</div>
													</div>

													<div class="row">
														<hr>
														<div class="col-lg-10">
															<div class="input-group">
																<span class="input-group-addon">Total Deductions</span>
																<input type="text" class="form-control" readonly="readonly" id=\'txttdeduc\'>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-10">
															<div class="input-group">
																<span class="input-group-addon">Net Pay</span>
																<input type="text" class="form-control" readonly="readonly" id=\'txtnetpay\'>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>




								</div>    <!-- end of salary -->

								<div class="tab-pane" id="qualification">
									<div class="row">
										<div class="col-lg-12">
											<div class="panel panel-default">
												<div class="panel-body">
													<div class="row">

														<div class="col-lg-3" style="">
															<div class="input-group">
																<span class="input-group-addon">Quali.</span>
																<input type="text" class="form-control input-sm" style="width:170px;" id=\'txtQuali\'>
															</div>
														</div>

														<div class="col-lg-3" style="">
															<div class="input-group">
																<span class="input-group-addon">Division</span>
																<input type="text" class="form-control input-sm" style="width:60px;" id=\'txtDivision\'>
															</div>
														</div>

														<div class="col-lg-2" style="">
															<div class="input-group" >
																<span class="input-group-addon">Year</span>
																<input type="text" class="form-control input-sm num" style="width:80px;" id=\'txtYear\'>
															</div>
														</div>
														<div class="col-lg-4" style="">
															<div class="input-group">
																<span class="input-group-addon">Name of Insti.</span>
																<input type="text" class="form-control input-sm" style="width:170px;" id=\'txtInstitute\'>
															</div>
														</div>
														<div class="col-lg-3" style="">
															<div class="input-group">
																<span class="input-group-addon">Major Subjects</span>
																<input type="text" class="form-control input-sm" style="width:228px;" id=\'txtMSubjects\'>
															</div>
														</div>
														<div class="col-lg-1">
															<div class="input-group">
																<a href=\'\' class="btn btn-primary input-sm" id=\'btnAddQuali\'>+</a>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<table class="table table-striped table-hover" id=\'qualification-table\'>
																<thead>
																	<tr>
																		<th class="thwidth3">Qualification/Job</th>
																		<th class="thwidth4">Division</th>
																		<th class="thwidth5">Year</th>
																		<th class="thwidth6">Name of Institution</th>
																		<th class="thwidth2">Major Subjects</th>
																		<th></th>
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
									</div>  <!-- end of admission test row 2 -->
								</div>     <!-- end of familyBackground -->

								<div class="tab-pane" id="experience">

									<div class="row">
										<div class="col-lg-12">
											<div class="panel panel-default">
												<div class="panel-body">
													<div class="row">
														<div class="col-lg-5">
															<div class="input-group">
																<span class="input-group-addon">Job Held</span>
																<input type="text" class="form-control" id=\'txtJobHeld\'>
															</div>
														</div>
														<div class="col-lg-2">
															<div class="input-group">
																<span class="input-group-addon">From</span>
																<input class="form-control ts_datepicker" type="text" id=\'from_date\'>
															</div>
														</div>
														<div class="col-lg-2">
															<div class="input-group">
																<span class="input-group-addon">To</span>
																<input class="form-control ts_datepicker" type="text" id=\'to_date\'>
															</div>
														</div>
														<div class="col-lg-2">
															<div class="input-group">
																<span class="input-group-addon">Pay Draws</span>
																<input type="text" class="form-control num" id=\'txtPayDraws\'>
															</div>
														</div>
														<div class="col-lg-1">
															<div class="input-group">
																<a href=\'\' class="btn btn-primary" id=\'btnAddExp\'>+</a>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<table class="table table-striped table-hover" id=\'experience-table\'>
																<thead>
																	<tr>
																		<th>Job Held</th>
																		<th>From</th>
																		<th>To</th>
																		<th>Pay Draws</th>
																		<th></th>
																	</tr>
																</thead>
																<tbody></tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>  <!-- end of admission test row 2 -->

								</div>    <!-- end of admissionTest -->

								<div id="viewall" class="tab-pane fade">

									<div class="row" id="staff-lookup">
										<div class="col-lg-12">
											<div class="panel panel-default">
												<div class="panel-body">
													<table class="table table-striped table-hover ar-datatable">
														<thead>
															<tr>
																<th>Sr#</th>
																<th>Sid</th>
																<th>Name</th>
																<th>Father Name</th>
																<th>Designation</th>
																<th>Department</th>
																<th>Shift</th>
																<th>Salary</th>
																<th></th>
															</tr>
														</thead>
														<tbody>
															';$counter = 1;foreach ($staffs as $staff): ;echo '															<tr>
																<td>';echo $counter++;;echo '</td>
																<td>';echo $staff['staid'];;echo '</td>
																<td>';echo $staff['name'];;echo '</td>
																<td>';echo $staff['fname'];;echo '</td>
																<td>';echo $staff['designation'];;echo '</td>
																<td>';echo $staff['dept_name'];;echo '</td>
																<td>';echo $staff['shift_name'];;echo '</td>
																<td>';echo $staff['bpay'];;echo '</td>
																<!-- <td><a href="" class="btn btn-primary btn-edit-staff showallupdatebtn" data-showallupdatebtn=';echo $vouchers['staff']['update'];;echo ' data-staid="';echo $staff['staid'];;echo '"><span class="fa fa-edit"></span></a></td> -->
																<td><a href="" class="btn btn-primary btn-edit-staff showallupdatebtn" data-showallupdatebtn="" data-staid="';echo $staff['staid'];;echo '"><span class="fa fa-edit"></span></a></td>
															</tr>
														';endforeach ;echo '													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

							</div> <!-- end of search_branch -->
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<a href=\'\' class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['staff']['insert'];;echo '\'>
											<i class="fa fa-save"></i>
											Save</a>
											<a href=\'\' class="btn btn-default btnReset">
												<i class="fa fa-refresh"></i>
												Reset</a>
											</div>
										</div>
									</div>
								</div>    <!-- end of a href=\'\' row -->


							</form>   <!-- end of form -->

						</div>  <!-- end of col -->
					</div>  <!-- end of container fluid -->
				</div>   <!-- end of page_content -->
			</div>

			<div id="TypeModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="model-contentwrapper">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">Add Type</h3>
					</div>
					<div class="modal-body">

						<div class="input-group">
							<span class="input-group-addon">Type</span>
							<input type="text" class="form-control" id="txtNewType">
						</div>
					</div>
					<div class="modal-footer">
						<div class="pull-right">
							<a class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
							<a class="btn btn-default btnNewType"><i class="fa fa-plus"></i> Add</a>
						</div>
					</div>
				</div>
			</div>

			<div id="AgreementModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="model-contentwrapper">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">Add Agreement</h3>
					</div>
					<div class="modal-body">

						<div class="input-group">
							<span class="input-group-addon">Agreement</span>
							<input type="text" class="form-control" id="txtNewAgreement">
						</div>
					</div>
					<div class="modal-footer">
						<div class="pull-right">
							<a class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
							<a class="btn btn-default btnNewAgreement"><i class="fa fa-plus"></i> Add</a>
						</div>
					</div>
				</div>
			</div>

			<div id="ReligionModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="model-contentwrapper">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">Add Religion</h3>
					</div>
					<div class="modal-body">

						<div class="input-group">
							<span class="input-group-addon">Religion</span>
							<input type="text" class="form-control" id="txtNewReligion">
						</div>
					</div>
					<div class="modal-footer">
						<div class="pull-right">
							<a class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
							<a class="btn btn-default btnNewReligion"><i class="fa fa-plus"></i> Add</a>
						</div>
					</div>
				</div>
			</div>

			<div id="BankModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="model-contentwrapper">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">Add Bank</h3>
					</div>
					<div class="modal-body">

						<div class="input-group">
							<span class="input-group-addon">Bank</span>
							<input type="text" class="form-control" id="txtNewBank">
						</div>
					</div>
					<div class="modal-footer">
						<div class="pull-right">
							<a class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
							<a class="btn btn-default btnNewBank"><i class="fa fa-plus"></i> Add</a>
						</div>
					</div>
				</div>
			</div>

			<style>
				.well-sm {display: block !important; background: transparent !important;}
				.clearfix{height: 54px;}
				.well{margin-bottom: -5px !important;}
			</style>
';
?>