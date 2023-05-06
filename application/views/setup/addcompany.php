

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
				<h1 class="page_title">Add Unit</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tabs_a">
					<li class="active"><a data-toggle="tab" href="#add_unit">Add Update Unit</a></li>
					<li class=""><a data-toggle="tab" href="#view_all">View All</a></li>
				</ul>
				<div class="tab-content">
					<div id="add_unit" class="tab-pane fade active in">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">

										<form action="">

											<div class="row">
												<div class="col-lg-2">
													<div class="input-group">
														<div class="input-group-addon id-addon">Vr#</div>
														<input type="number" class="form-control input-sm  num txtidupdate" id="txtId">
														<input type="hidden" id="txtIdHidden">
														<input type="hidden" id="txtMaxIdHidden">
														<input type="hidden" id="vouchertypehidden">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Name</div>
														<input type="text" class="form-control input-sm " id="txtName">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Contact Person</div>
														<input type="text" class="form-control input-sm " id="txtContact">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Phone</div>
														<input type="text" class="form-control input-sm " id="txtPhone">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Address</div>
														<input type="text" class="form-control input-sm " id="txtAreaCover">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">NTN</div>
														<input type="text" class="form-control input-sm" id="txtNtn">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">STRN</div>
														<input type="text" class="form-control input-sm" id="txtStrn">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-5">
													<div class="input-group">
						                            	<span class="input-group-addon txt-addon">Foot Note</span>
						                            	<!-- <input type="text" class="form-control input-sm" placeholder="Address of Party" id="txtAddress"> -->
						                            	<textarea class="form-control input-sm" row="8" placeholder="Foot Note" id="txtfootnote"></textarea>
						                            	<!-- <input type="text" class="form-control input-sm" placeholder="Address of Party" id="txtAddress"> -->
						                            </div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-5">
													<div class="input-group">
						                            	<span class="input-group-addon txt-addon">Bank Info</span>
						                            	<!-- <input type="text" class="form-control input-sm" placeholder="Address of Party" id="txtAddress"> -->
						                            	<textarea class="form-control input-sm" row="8" placeholder="Bank Information" id="txtbank"></textarea>
						                            	<!-- <input type="text" class="form-control input-sm" placeholder="Address of Party" id="txtAddress"> -->
						                            </div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-12">
													<div class="pull-right">
														<a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['unit']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['unit']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['unit']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['unit']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
														<a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
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
													<th style=\'background: #368EE0;\'>Sr#</th>
													<th style=\'background: #368EE0;\'>Name</th>
													<th style=\'background: #368EE0;\'>Contact Person</th>
													<th style=\'background: #368EE0;\'>Phone</th>
													<th style=\'background: #368EE0;\'>Address</th>
													<th style=\'background: #368EE0;\'>Ntn</th>
													<th style=\'background: #368EE0;\'>Strn</th>
													<th style=\'background: #368EE0;\'></th>
												</tr>
											</thead>
											<tbody>
												';if (count($units) >0): ;echo '													';$counter = 1;foreach ($units as $unit): ;echo '														<tr>
															<td>';echo $counter++;;echo '</td>
															<td>';echo $unit['company_name'];;echo '</td>
															<td>';echo $unit['contact_person'];;echo '</td>
															<td>';echo $unit['contact'];;echo '</td>
															<td>';echo $unit['address'];;echo '</td>
															<td>';echo $unit['ntn'];;echo '</td>
															<td>';echo $unit['strn'];;echo '</td>
															<td><a href="" class="btn btn-sm btn-primary btn-edit-dept showallupdatebtn" data-company_id="';echo $unit['company_id'];;echo '"><span class="fa fa-edit"></span></a></td>
														</tr>
													';endforeach ;echo '												';endif ;echo '											</tbody>
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