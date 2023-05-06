

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
				<h1 class="page_title">Allot Shift Group</h1>
			</div>
			<div class="col-lg-9">
				<div class="pull-right">
					<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['allot_shift_group']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
					<a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
				</div>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tabs_a">
					<li class=""><a data-toggle="tab" href="#add_allotshiftgroup">Add Update Allot Shift Group</a></li>
					<li class="active"><a data-toggle="tab" href="#view_all">List</a></li>
				</ul>
				<div class="tab-content">
					<div id="add_allotshiftgroup" class="tab-pane fade">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">

										<form action="">

											<div class="row">
												<div class="col-lg-2">
													<div class="input-group">
														<div class="input-group-addon id-addon">Id</div>
														<input type="number" class="form-control num txtidupdate" data-txtidupdate=\'';echo $vouchers['allot_shift_group']['update'];;echo '\' id="txtId">
														<input type="hidden" id="txtIdHidden">
														<input type="hidden" id="txtMaxIdHidden">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-3">
				                                    <div class="input-group">
				                                        <span class="input-group-addon txt-addon">Date</span>
				                                        <input class="form-control " type="date" id="cur_date" value="';echo date('Y-m-d');;echo '">
				                                    </div>
				                                </div>
			                                </div>
			                                
											<div class="row">
				                                <div class="col-lg-3">
				                                   <div class="input-group">
				                                        <span class="input-group-addon txt-addon shiftgroup-addon" data-gid=\'\'>Shift Group</span>
				                                        <select class="form-control" id="shiftgroup_dropdown">
				                                          	<option value="" disabled="" selected="">Choose shift group</option>
				                                          	';foreach ($shiftGroups as $shiftGroup): ;echo '				                                              	<option value="';echo $shiftGroup['gid'];;echo '">';echo $shiftGroup['name'];;echo '</option>
				                                          	';endforeach ;echo '				                                        </select>
				                                    </div>
				                                </div>
			                               	</div>

											<div class="row">
				                                <div class="col-lg-3">
				                                   <div class="input-group">
				                                        <span class="input-group-addon txt-addon">Shift</span>
				                                        <select class="form-control" id="shift_dropdown">
				                                          	<option value="" disabled="" selected="">Choose shift</option>
				                                          	';foreach ($shifts as $shift): ;echo '				                                              	<option value="';echo $shift['shid'];;echo '">';echo $shift['name'];;echo '</option>
				                                          	';endforeach ;echo '				                                        </select>
				                                    </div>
				                                </div>
			                                </div>


											<div class="row">
												<div class="col-lg-12">
													<div class="pull-right">
														<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['allot_shift_group']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
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
					<div id="view_all" class="tab-pane fade active in">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<table class="table table-striped table-hover ar-datatable">
											<thead>
												<tr>
													<th>Sr#</th>
													<th>Shift Group</th>
													<th>Shift</th>
													<th>Time In</th>
													<th>Time Out</th>
													<th>Rest Time Out</th>
													<th>Rest Time Out</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;foreach ($allotShiftGroups as $allotShiftGroup): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo substr($allotShiftGroup['shiftgroup_name'],0,10);;echo '</td>
														<td>';echo $allotShiftGroup['shift_name'];;echo '</td>
														<td>';echo $allotShiftGroup['tin'];;echo '</td>
														<td>';echo $allotShiftGroup['tout'];;echo '</td>
														<td>';echo $allotShiftGroup['resin'];;echo '</td>
														<td>';echo $allotShiftGroup['resout'];;echo '</td>
														<!-- <td><a href="" class="btn btn-primary btn-edit-allotShiftGroup showallupdatebtn" data-showallupdatebtn=';echo $vouchers['allot_shift_group']['update'];;echo ' data-id="';echo $allotShiftGroup['id'];;echo '"><span class="fa fa-edit"></span></a></td> -->
														<td><a href="" class="btn btn-primary btn-edit-allotShiftGroup showallupdatebtn" data-showallupdatebtn="" data-id="';echo $allotShiftGroup['id'];;echo '"><span class="fa fa-edit"></span></a></td>
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