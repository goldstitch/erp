
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
<div id="main_wrapper">

  	<div class="page_bar">
    	<div class="row">
      		<div class="col-lg-3">
        		<h1 class="page_title">Staff Attendance</h1>
      		</div>
      		<div class="col-lg-9">
      			<div class="pull-right">
					<a class="btn btn-default btnPrint" data-printtbtn=\'';echo $vouchers['student']['print'];;echo '\'><i class="fa fa-print"></i> Print</a>
					<a href=\'\' class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['staff_attendance']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
					<a href="" class="btn btn-default btnDelete" data-deletetbtn=\'';echo $vouchers['staff_attendance']['delete'];;echo '\'><i class="fa fa-trash-o"></i> Delete</a>
					<a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
				</div>
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
								<div class="col-lg-2">
	                                <div class="input-group">
	                                    <span class="input-group-addon id-addon">Vr#</span>
	                                    <input type="number" class="form-control num txtidupdate" data-txtidupdate=\'';echo $vouchers['staff_attendance']['update'];;echo '\' id="txtdcno">
	                                    <input type="hidden" id="txtMaxdcnoHidden">
	                                    <input type="hidden" id="txtdcnoHidden">
	                                    <input type="hidden" id="voucher_type_hidden">

	                                    <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                        <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                        <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
                                        
	                                </div>
								</div>

								<div class="col-lg-3">
									<div class="input-group">
                                        <span class="input-group-addon txt-addon">Date</span>
                                        <input class="form-control " type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
                                    </div>
								</div>
								
								<div class="col-lg-7">									
									<div class="post-container hide">
										<div class="row">
											<div class="col-lg-5">
												<div class="input-group">
			                                        <span class="input-group-addon txt-addon">Start Date</span>
			                                        <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
			                                    </div>
											</div>
											<div class="col-lg-5">
												<div class="input-group">
			                                        <span class="input-group-addon txt-addon">End Date</span>
			                                        <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
			                                    </div>
											</div>
											<div class="col-lg-2">
												<div class="pull-right">
													<a href=\'\' class="btn btn-default btnPost">
				              							<i class="fa fa-search"></i>
				            						Post</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon txt-addon">Department</span>
										<select class="form-control select2" id="dept_dropdown">
							              	<option value="all" selected="">All</option>
							              	';foreach ($departments as $department): ;echo '							                  	<option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
							              	';endforeach ;echo '							            </select>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="input-group">
										<span class="input-group-addon txt-addon">Type</span>
										<select class="form-control" id="type_dropdown">
							              	<option value="all" selected="">All</option>
							              	';foreach ($types as $type): ;echo '							                  	<option value="';echo $type['type'];;echo '">';echo $type['type'];;echo '</option>
							              	';endforeach ;echo '							            </select>
									</div>
								</div>

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
                                    <label for="autoattendance">
                                        <input type="checkbox" id="autoattendance" name="aat" value="autoattendance">
                                        Auto Attendance
                                    </label>
                                </div>

                                <div class="col-lg-3">
									<div class="pull-right">
										<a href=\'\' class="btn btn-default btnSearch">
	              							<i class="fa fa-search"></i>
	            						Show</a>
									</div>
								</div>
							</div>

						</div>
					</div>

					

    			</div>	<!-- end of col-lg-12 -->
    		</div>	<!-- end of row -->

    		<div class="row">
    			<div class="col-lg-12">

					<div class="panel panel-default">
						<div class="panel-body">

							<table class="table table-striped table-hover ar-datatable" id=\'atnd-table\'>
								<thead>
									<tr>
										<th>Sr#</th>
										<th>Department</th>
										<th>Employee Name</th>
										<th>Designation</th>
										<th>Type</th>
										<th>Shift</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>

						</div>
					</div>

					<datalist id=\'status\'>						
						<option value="Present">
						<option value="Absent">
						<option value="Paid Leave">
						<option value="Unpaid Leave">
						<option value="Rest Day">
						<option value="Gusted Holiday">
						<option value="Short Leave">
						<option value="Outdoor">
					</datalist>

    			</div>
    		</div>

    		<div class="row">
				<div class="col-lg-12">
					<div class="pull-right">
						<a class="btn btn-default btnPrint" data-printtbtn=\'';echo $vouchers['student']['print'];;echo '\'><i class="fa fa-print"></i> Print</a>
						<a href=\'\' class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['staff_attendance']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
						<a href="" class="btn btn-default btnDelete" data-deletetbtn=\'';echo $vouchers['staff_attendance']['delete'];;echo '\'><i class="fa fa-trash-o"></i> Delete</a>
						<a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
					</div>
				</div> 	<!-- end of col -->
			</div>	<!-- end of row -->

    	</div>	<!-- end of container-fluid -->
    </div>	<!-- end of page_content -->
</div>';
?>