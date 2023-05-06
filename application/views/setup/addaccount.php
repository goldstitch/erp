

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
			<div class="col-md-12">
				<h1 class="page_title">Add Account</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">

				<form action="">

					<ul class="nav nav-pills">
						<li class="active"><a href="#basicInformation" data-toggle="tab">Basic Information</a></li>
						<li><a href="#detailedInformation" data-toggle="tab">Detailed Information</a></li>
						<li><a href="#allaccounts" data-toggle="tab">All Accounts</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active fade in" id="basicInformation">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">

											<div class="row">

												<div class="col-lg-3">
													<div class="input-group">
														<span class="input-group-addon id-addon">Id (Auto)</span>
														<input type="number" class="form-control input-sm num" id="txtAccountId">
														<input type="hidden" id="txtMaxAccountIdHidden">
														<input type="hidden" id="txtAccountIdHidden">
														<input type="hidden" id="VoucherTypeHidden">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<div class="col-lg-3">
															<div class="input-group">
																<span class="switch-addon input-group-addon">Is active?</span>
																<input type="checkbox" checked="" class="bs_switch" id="switchGender">
															</div>
														</div>
													</div>
												</div>

												<div class="col-lg-4"></div>

												<div class="col-lg-3">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Account Id</span>
														<select class="form-control input-sm"  id="drpacid">
															<option value="" disabled="" selected="">Choose Account Id</option>
															';foreach ($accounts as $account): ;echo '																<option value="';echo $account['pid'];;echo '" >';echo $account['account_id'] ;echo '</option>
															';endforeach ;echo '														</select>
													</div>
												</div>

											</div>

											<div class="row">
												<div class="col-lg-5">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Name</span>
														<input type="text" class="form-control input-sm" id="txtName">
														<input type="hidden" class="form-control input-sm" id="txtNameHidden">
													</div>
												</div>

												<div class="col-lg-1"></div>

												<div class="col-lg-3">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Quick Search</span>


														<input type="text" class="form-control" id="txtQSId">
														<input id="hfQSId" type="hidden" value="" />
														<input id="hfQSBalance" type="hidden" value="" />
														<input id="hfQSCity" type="hidden" value="" />
														<input id="hfQSAddress" type="hidden" value="" />
														<input id="hfQSCityArea" type="hidden" value="" />
														<input id="hfQSMobile" type="hidden" value="" />
														<input id="hfQSUname" type="hidden" value="" />

														<input id="hfQSName" type="hidden" value="" />



														<label><img id="imgQSLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>

													</div>

												</div>
												
											</div>

											<div class="row hide">
												<div class="col-lg-5">
													<div class="input-group">
														<select class="form-control input-sm"  id="allNames">
															';foreach ($names as $name): ;echo '																<option value="';echo $name['name'];;echo '">';echo $name['name'];;echo '</option>
															';endforeach ;echo '														</select>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-5">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Address</span>
														<!-- <input type="text" class="form-control input-sm" placeholder="Address of Party" id="txtAddress"> -->
														<textarea class="form-control input-sm" row="8" placeholder="Address of Party" id="txtAddress"></textarea>
														<!-- <input type="text" class="form-control input-sm" placeholder="Address of Party" id="txtAddress"> -->
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-5">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Mobile #</span>
														<input type="text" class="form-control input-sm" id="txtMobileNo">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-5">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Credit Limit</span>
														<input type="text" class="form-control input-sm num" id="txtLimit">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-5">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Acc Type</span>
														<select class="form-control input-sm"  id="txtLevel3">
															<option value="" disabled="" selected="">Choose Account Type</option>
															';foreach ($l3s as $l3): ;echo '																<option value="';echo $l3['l3'];;echo '" data-level2="';echo $l3['level2_name'];;echo '" data-level1="';echo $l3['level1_name'];;echo '">';echo $l3['level3_name'] ;echo '</option>
															';endforeach ;echo '														</select>
													</div>
												</div>
												<div class="col-lg-6">
													<span><b>Type 2 &rarr; </b><span id="txtselectedLevel2"> </span></span> <span><b>Type 1 &rarr; </b><span id="txtselectedLevel1"> </span></span>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-2">
													<a href="" class="btn btn-sm btn-primary" id="addMoreInf"><i class="fa fa-th-list"></i> Add More Detail</a>
												</div>
											</div>
											<div id="party-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															<h3 id="myModalLabel">Party Lookup</h3>
														</div>

														<div class="modal-body">
															<table class="table table-striped modal-table">
																<!-- <table class="table table-bordered table-striped modal-table"> -->
																	<thead>
																		<tr style="font-size:16px;">
																			<th>Id</th>
																			<th>Name</th>
																			<th>Type</th>
																			<th>Mobile</th>
																			<th>Address</th>
																			<th style=\'width:3px;\'>Actions</th>
																		</tr>
																	</thead>
																	<tbody>
																		';foreach ($accounts as $party): ;echo '																			<tr>
																				<td width="14%;">
																					';echo $party['pid'];;echo '																					<input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
																				</td>
																				<td>';echo $party['name'];;echo '</td>
																				<td>';echo $party['level3_name'];;echo '</td>
																				<td>';echo $party['mobile'];;echo '</td>
																				<td>';echo $party['address'];;echo '</td>
																				<td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa-li fa fa-check-square"></i></a></td>
																			</tr>
																		';endforeach ;echo '																	</tbody>
																</table>
															</div>
															<div class="modal-footer">
																<!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
																<button class="btn btn-primary" data-dismiss="modal">Cancel</button>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">

														<div class="pull-right">
															<a class="btn btn-sm btn-default btnSave" data-insertbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['account']['update'];;echo '\'><i class="fa fa-save"></i> Save F10</a>
															<a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>

															<a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
															<a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
														</div>

													</div>
												</div>    <!-- end of button row -->

											</div>
										</div>
									</div>
								</div>  <!-- end of row 1 of basic information -->

							</div>    <!-- end of basicInformation -->

							<div class="tab-pane fade" id="detailedInformation">
								<div class="row">
									<div class="col-lg-12">
										<div class="panel panel-default">
											<div class="panel-body">

												<div class="row">
													<div class="col-lg-5">
														<div class="input-group">
															<span class="input-group-addon txt-addon">Contact Person</span>
															<input type="text" class="form-control input-sm"  placeholder="Contact Person" id="txtContactPerson">
														</div>
													</div>

													<div class="col-lg-5">
														<div class="input-group">
															<span class="input-group-addon txt-addon" placeholder="City Area">City Area</span>
															<input type="text" class=\'form-control input-sm\' placeholder="City Area" id="txtCityArea" list=\'areas\'>
															<datalist id="areas">
																';foreach ($cityareas as $cityarea): ;echo '																	';if ($cityarea['cityarea'] !== ''): ;echo '																		<option value="';echo $cityarea['cityarea'];;echo '">
																		';endif ;echo '																	';endforeach ;echo '																</datalist>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-lg-5">
															<div class="input-group">
																<span class="input-group-addon txt-addon">Email</span>
																<input type="text" class="form-control input-sm" placeholder="Email Address" id="txtEmail">
															</div>
														</div>

														<div class="col-lg-5">
															<div class="input-group">
																<span class="input-group-addon txt-addon">CNIC/STRN#</span>
																<input type="text" class="form-control input-sm" placeholder="CNIC"  id="txtCNIC">
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-lg-5">
															<div class="input-group">
																<span class="input-group-addon txt-addon">Phone</span>
																<input type="text" class="form-control input-sm num" placeholder="Phone Office" id="txtPhoneNo">
															</div>
														</div>
														<div class="col-lg-5">
															<div class="input-group">
																<span class="input-group-addon txt-addon">NTN</span>
																<input type="text" class="form-control input-sm" placeholder="National Tax Number" id="txtNTN">
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-lg-5">
															<div class="input-group">
																<span class="input-group-addon txt-addon" placeholder="City">City</span>
																<input type="text" class=\'form-control input-sm\' placeholder="City" id="txtCity" list=\'cities\'>
																<datalist id="cities">
																	';foreach ($cities as $city): ;echo '																		';if ($city['city'] !== ''): ;echo '																			<option value="';echo $city['city'];;echo '">
																			';endif ;echo '																		';endforeach ;echo '																	</datalist>
																</div>
															</div>

															<div class="col-lg-5">
																<div class="input-group">
																	<span class="input-group-addon txt-addon">Type</span>
																	<input type="text" class=\'form-control input-sm\' placeholder="Type" id="txtType" list=\'types\'>
																	<datalist id="types">
																		';foreach ($typess as $typee): ;echo '																			';if ($typee['etype'] !== ''): ;echo '																				<option value="';echo $typee['etype'];;echo '">
																				';endif ;echo '																			';endforeach ;echo '																		</datalist>
																	</div>
																</div>
															</div>

															<div class="row">
																<div class="col-lg-5">
																	<div class="input-group">
																		<span class="input-group-addon txt-addon">Fax</span>
																		<input type="text" class="form-control input-sm num" placeholder="Fax Number" id="txtFax">
																	</div>
																</div>
																<div class="col-lg-5">
																	<div class="input-group">
																		<span class="input-group-addon txt-addon">Country</span>
																		<input type="text" class=\'form-control input-sm\' placeholder="Country" id="txtCountry" list=\'countries\'>
																		<datalist id="countries">
																			';foreach ($countries as $country): ;echo '																				';if ($country['country'] !== ''): ;echo '																					<option value="';echo $country['country'];;echo '">
																					';endif ;echo '																				';endforeach ;echo '																			</datalist>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>    <!-- end of salary -->

											<div class="tab-pane fade" id="allaccounts">

												<div class="row">
													<div class="col-lg-12">
														<div class="panel panel-default">
															<div class="panel-body">
																<table class="table table-striped table-hover ar-datatable" id="partylisttable" >
																	<thead>
																		<tr>
																			<th>Sr#</th>
																			<th>Name</th>
																			<th>Mobile#</th>
																			<th>Address</th>
																			<th>Level 3</th>
																			<th></th>
																		</tr>
																	</thead>
																	<tbody>
																		';$counter = 1;foreach ($accounts as $account): ;echo '																		<tr>
																			<td>';echo $counter++;;echo '</td>
																			<td>';echo $account['name'];;echo '</td>
																			<td>';echo $account['mobile'];;echo '</td>
																			<td>';echo $account['address'];;echo '</td>
																			<td>';echo $account['level3_name'];;echo '</td>
																			<td><a href="" class="btn btn-sm btn-primary btn-edit-account showallupdatebtn" data-pid="';echo $account['pid'];;echo '" data-showallupdatebtn=';echo $vouchers['account']['update'];;echo '><span class="fa fa-edit"></span></a></td>
																		</tr>
																	';endforeach ;echo '																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>

										</div>    <!-- end of admissionTest -->
									</div>

								</form>   <!-- end of form -->

							</div>  <!-- end of col -->
						</div>  <!-- end of container fluid -->
					</div>   <!-- end of page_content -->
				</div>';
?>