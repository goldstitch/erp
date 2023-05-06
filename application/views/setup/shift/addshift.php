

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
				<h1 class="page_title">Add Shift</h1>
			</div>
			<div class="col-lg-9">
				<div class="pull-right">
					<a class="btn btn-primary btnSave" data-insertbtn=\'';echo $vouchers['shift']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
					<a class="btn btn-info btnReset"><i class="fa fa-refresh"></i> Reset</a>
				</div>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tabs_a">
					<li class=""><a data-toggle="tab" href="#add_shift">Add Update Shift</a></li>
					<li class="active"><a data-toggle="tab" href="#view_all">Shift List</a></li>
				</ul>
				<div class="tab-content">
					<div id="add_shift" class="tab-pane fade">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">

										<form action="">

											<div class="row">
												<div class="col-lg-2">
													<div class="input-group">
														<div class="input-group-addon id-addon">Id</div>
														<input type="number" class="form-control num txtidupdate" data-txtidupdate=\'';echo $vouchers['shift']['update'];;echo '\' id="txtId">
														<input type="hidden" id="txtIdHidden">
														<input type="hidden" id="txtMaxIdHidden">
													</div>
												</div>

												<div class="col-lg-9">
						                            <div class="form-group">
							                            <div class="input-group input-group-block" >
							                              <span class="switch-addon">Rest Time?</span>
							                              <input type="checkbox" class="bs_switch active_switch" id="restime_checkbox">
							                            </div>
						                            </div>
						                        </div>
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Name</div>
														<input type="text" class="form-control" id="txtName">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Time In</div>
														<input class="form-control tp num" type="text" id="in_time">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Time Out</div>
														<input class="form-control tp num" type="text" id="out_time">
													</div>
												</div>
											</div>

											<div class="row resttime">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Rest Time In</div>
														<input class="form-control tp num" type="text" id="resin_time">
													</div>
												</div>
											</div>

											<div class="row resttime">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Rest Time Out</div>
														<input class="form-control tp num" type="text" id="resout_time">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Shift Hour</div>
														<input class="form-control num" type="text" id="txtShiftHour">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-12">
													<div class="pull-right">
														<a class="btn btn-primary btnSave" data-insertbtn=\'';echo $vouchers['shift']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
														<a class="btn btn-info btnReset"><i class="fa fa-refresh"></i> Reset</a>
													</div>
												</div> 	<!-- end of col -->
											</div>	<!-- end of row -->
										</form>	<!-- end of form -->

									</div>	<!-- end of panel-body -->
								</div>	<!-- end of panel -->
							</div>  <!-- end of col -->
						</div>	<!-- end of row -->

					</div>	<!-- end of add_branch -->
					<div id="view_all" class="tab-pane fade active in">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<table class="table table-striped table-hover ar-datatable">
											<thead>
												<tr>
													<th>Sr#</th>
													<th>Name</th>
													<th>Time In</th>
													<th>Time Out</th>
													<th>Rest Time In</th>
													<th>Rest Time Out</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;foreach ($shifts as $shift): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo $shift['name'];;echo '</td>
														<td>';echo $shift['tin'];;echo '</td>
														<td>';echo $shift['tout'];;echo '</td>
														<td>';echo $shift['resin'];;echo '</td>
														<td>';echo $shift['resout'];;echo '</td>
														<!-- <td><a href="" class="btn btn-primary btn-edit-shift showallupdatebtn" data-showallupdatebtn=';echo $vouchers['shift']['update'];;echo ' data-shid="';echo $shift['shid'];;echo '"><span class="fa fa-edit"></span></a></td> -->
														<td><a href="" class="btn btn-primary btn-edit-shift showallupdatebtn" data-showallupdatebtn="" data-shid="';echo $shift['shid'];;echo '"><span class="fa fa-edit"></span></a></td>
													</tr>
												';endforeach ;echo '											</tbody>
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