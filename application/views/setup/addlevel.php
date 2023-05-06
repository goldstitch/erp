

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
;echo '<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Levels</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-tabs" id="tabs_a">
						<li class="active"><a data-toggle="tab" href="#add_level1">Add Update Level 1</a></li>
						<li class=""><a data-toggle="tab" href="#view_all_level1">View All</a></li>
					</ul>
					<div class="tab-content">
						<div id="add_level1" class="tab-pane fade active in">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">

											<form action="">
	
												<div class="row"></div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-2">
														<div class="input-group">
															<span class="input-group-addon id-addon">Id</span>
															<input type="text" class="form-control input-sm" id="txtLevel1Id" disabled>
															<input type="hidden" id="txtMaxLevel1IdHidden">
															<input type="hidden" id="txtLevel1IdHidden">
															<input type="hidden" id="VoucherTypeHidden">

															<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
		                                                    <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
		                                                    <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-3">
														<div class="input-group">
															<span class="input-group-addon txt-addon">Bs Level:</span>
															<select class="form-control input-sm" id="Bslevel_dropdown">
																<option value="" disabled="" selected="">Choose Balance Sheet Level</option>
																<option value="ASSETS">ASSETS</option>
																<option value="LIABILITES">LIABILITES</option>
																<option value="INCOME">INCOME</option>
																<option value="EXPENSES">EXPENSES</option>
																<option value="EQUITY">EQUITY</option>
															</select>
														</div>														
													</div>
												</div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-3">
														<div class="input-group">
															<span class="input-group-addon txt-addon">Name</span>
															<input type="text" class="form-control input-sm" id="txtLevel1Name">
															<input type="hidden" id="txtLevel1NameHidden">
														</div>														
													</div>
												</div>

												<div class="row"></div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-3">
														<div class="pull-right">
															<a class="btn-sm btn btn-default btnSaveL1 btnSave" data-insertbtn=\'';echo $vouchers['level']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['level']['update'];;echo '\'><i class="fa fa-save"></i> Save Level</a>
															<a class="btn-sm btn btn-default btnResetL1 btnReset"><i class="fa fa-refresh"></i> Reset</a>
														</div>
													</div> 	<!-- end of col -->
												</div>	<!-- end of row -->
											</form>	<!-- end of form -->

										</div>	<!-- end of panel-body -->
									</div>	<!-- end of panel -->
								</div>  <!-- end of col -->
							</div>	<!-- end of row -->

						</div>	<!-- end of add_branch -->
						<div id="view_all_level1" class="tab-pane fade">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th>Id</th>
														<th>Level</th>
														<th>BsLevel</th>
														<th class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($l1s as $l1): ;echo '														<tr>
															<td>';echo $l1['l1'];;echo '</td>
															<td>';echo $l1['name'];;echo '</td>
															<td>';echo $l1['bslevel'];;echo '</td>
															<td><a href="" class="btn-sm btn btn-primary btn-edit-level1 showallupdatebtn" data-l1="';echo $l1['l1'];;echo '"><span class="fa fa-edit"></span></a></td>
														</tr>
													';endforeach ;echo '												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

						</div> <!-- end of search_branch -->
					</div>
				</div>	<!-- end of level 1-->
			</div>

			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-tabs" id="tabs_a">
						<li class="active"><a data-toggle="tab" href="#add_level2">Add Update Level 2</a></li>
						<li class=""><a data-toggle="tab" href="#view_all_level2">View All</a></li>
					</ul>
					<div class="tab-content">
						<div id="add_level2" class="tab-pane fade active in">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">

											<form action="">
	
												<div class="row"></div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-2">
														<div class="input-group">
															<span class="input-group-addon id-addon">Id</span>
															<input type="text" class="form-control input-sm" id="txtLevel2Id" disabled>
															<input type="hidden" id="txtMaxLevel2IdHidden">
															<input type="hidden" id="txtLevel2IdHidden">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-3">
														<div class="input-group">
															<span class="input-group-addon txt-addon">Level 1:</span>
															<select class="form-control input-sm" id="level1_dropdown">
																<option value="" disabled="" selected="">Choose associated Level 1</option>
																';$counter = 1;foreach ($l1s as $l1): ;echo '																	<option value="';echo $l1['l1'];;echo '">';echo $l1['name'];;echo '</option>
																';endforeach ;echo '															</select>
														</div>														
													</div>
												</div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-3">
														<div class="input-group">
															<span class="input-group-addon txt-addon">Name</span>
															<input type="text" class="form-control input-sm" id="txtLevel2Name">
															<input type="hidden" id="txtLevel2NameHidden">
														</div>														
													</div>
												</div>

												<div class="row"></div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-3">
														<div class="pull-right">
															<a class="btn-sm btn btn-default btnSaveL2 btnSave" data-insertbtn=\'';echo $vouchers['level']['insert'];;echo '\'><i class="fa fa-save"></i> Save Level</a>
															<a class="btn-sm btn btn-default btnResetL2 btnReset"><i class="fa fa-refresh"></i> Reset</a>
														</div>
													</div> 	<!-- end of col -->
												</div>	<!-- end of row -->
											</form>	<!-- end of form -->

										</div>	<!-- end of panel-body -->
									</div>	<!-- end of panel -->
								</div>  <!-- end of col -->
							</div>	<!-- end of row -->

						</div>	<!-- end of add_branch -->
						<div id="view_all_level2" class="tab-pane fade">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th>Sr#</th>
														<th>Level 2</th>
														<th>Level 1</th>
														<th class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($l2s as $l2): ;echo '														<tr>
															<td>';echo $l2['l2'];;echo '</td>
															<td>';echo $l2['level2_name'];;echo '</td>
															<td>';echo $l2['level1_name'];;echo '</td>
															<td><a href="" class="btn-sm btn btn-primary btn-edit-level2 showallupdatebtn" data-l2="';echo $l2['l2'];;echo '"><span class="fa fa-edit"></span></a></td>
														</tr>
													';endforeach ;echo '												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

						</div> <!-- end of search_branch -->
					</div>
				</div>	<!-- end of level 2-->
			</div>

			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-tabs" id="tabs_a">
						<li class="active"><a data-toggle="tab" href="#add_level3">Add Update Level 3</a></li>
						<li class=""><a data-toggle="tab" href="#view_all_level3">View All</a></li>
					</ul>
					<div class="tab-content">
						<div id="add_level3" class="tab-pane fade active in">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">

											<form action="">
	
												<div class="row"></div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-2">
														<div class="input-group">
															<span class="input-group-addon id-addon">Id</span>
															<input type="text" class="form-control input-sm" id="txtLevel3Id" disabled>
															<input type="hidden" id="txtMaxLevel3IdHidden">
															<input type="hidden" id="txtLevel3IdHidden">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-3">
														<div class="input-group">
															<span class="input-group-addon txt-addon">Level 2:</span>
															<select class="form-control input-sm" id="level2_dropdown">
																<option value="" disabled="" selected="">Choose associated Level 2</option>
																';$counter = 1;foreach ($l2s as $l2): ;echo '																	<option value="';echo $l2['l2'];;echo '">';echo $l2['level2_name'];;echo '</option>
																';endforeach ;echo '															</select>
														</div>														
													</div>
												</div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-3">
														<div class="input-group">
															<span class="input-group-addon txt-addon">Name</span>
															<input type="text" class="form-control input-sm" id="txtLevel3Name">
															<input type="hidden" id="txtLevel3NameHidden">
														</div>														
													</div>
												</div>

												<div class="row"></div>

												<div class="row">
													<div class="col-lg-2"></div>
													<div class="col-lg-3">
														<div class="pull-right">
															<a class="btn-sm btn btn-default btnSaveL3 btnSave" data-insertbtn=\'';echo $vouchers['level']['insert'];;echo '\'><i class="fa fa-save"></i> Save Level</a>
															<a class="btn-sm btn btn-default btnResetL3 btnReset" ><i class="fa fa-refresh"></i> Reset</a>
														</div>
													</div> 	<!-- end of col -->
												</div>	<!-- end of row -->
											</form>	<!-- end of form -->

										</div>	<!-- end of panel-body -->
									</div>	<!-- end of panel -->
								</div>  <!-- end of col -->
							</div>	<!-- end of row -->

						</div>	<!-- end of add_branch -->
						<div id="view_all_level3" class="tab-pane fade">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th>Sr#</th>
														<th>Level 3</th>
														<th>Level 2</th>
														<th class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($l3s as $l3): ;echo '														<tr>	
															<td>';echo $l3['l3'];;echo '</td>
															<td>';echo $l3['level3_name'];;echo '</td>
															<td>';echo $l3['level2_name'];;echo '</td>
															<td><a href="" class="btn-sm btn btn-primary btn-edit-level3 showallupdatebtn" data-l3="';echo $l3['l3'];;echo '"><span class="fa fa-edit"></span></a></td>
														</tr>
													';endforeach ;echo '												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

						</div> <!-- end of search_branch -->
					</div>
				</div>	<!-- end of level 2-->
			</div>
		</div>
	</div>
</div>';
?>