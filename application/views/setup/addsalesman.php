

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
				<h1 class="page_title">Add New Sales Man</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tabs_a">
					<li class="active"><a data-toggle="tab" href="#add_salesman">Add Update Salesman</a></li>
					<li class=""><a data-toggle="tab" href="#view_all">View All</a></li>
				</ul>
				<div class="tab-content">
					<div id="add_salesman" class="tab-pane fade active in">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">

										<form action="">

											<div class="row">
												<div class="col-lg-2">
													<div class="input-group">
														<div class="input-group-addon id-addon">Vr#</div>
														<input type="number" class="form-control input-sm num txtidupdate" id="txtId">
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
														<input type="text" class="form-control input-sm" id="txtName">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Designation</div>
														<input type="text" class="form-control input-sm" id="txtDesignation">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-8">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Address</div>
														<input type="text" class="form-control input-sm" id="txtAddress">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Phone Res</div>
														<input type="text" class="form-control input-sm" id="txtPhoneRes">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Mobile</div>
														<input type="text" class="form-control input-sm" id="txtMobile">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Recovey(%)</div>
														<input type="text" class="form-control input-sm num" id="txtRecovery">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Sales(%)</div>
														<input type="text" class="form-control input-sm num" id="txtSales">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-12">
													<div class="pull-right">
														<a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['salesman']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['salesman']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['salesman']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['salesman']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
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
													<th style=\'background: #368EE0;\'>Address</th>
													<th style=\'background: #368EE0;\'>Designation</th>
													<th style=\'background: #368EE0;\'>Phone Res</th>
													<th style=\'background: #368EE0;\'>Mobile</th>
													<th style=\'background: #368EE0;\'>Sales</th>
													<th style=\'background: #368EE0;\'>Recovery</th>
													<th style=\'background: #368EE0;\'></th>
												</tr>
											</thead>
											<tbody>
												';if (count($salesmen) >0): ;echo '													';$counter = 1;foreach ($salesmen as $salesman): ;echo '														<tr>
															<td>';echo $counter++;;echo '</td>
															<td>';echo $salesman['name'];;echo '</td>
															<td>';echo $salesman['address'];;echo '</td>
															<td>';echo $salesman['designation'];;echo '</td>
															<td>';echo $salesman['phone_res'];;echo '</td>
															<td>';echo $salesman['mobile'];;echo '</td>
															<td>';echo $salesman['sales'];;echo '</td>
															<td>';echo $salesman['recovery'];;echo '</td>
															<td><a href="" class="btn btn-sm btn-primary btn-edit-dept showallupdatebtn" data-officer_id="';echo $salesman['officer_id'];;echo '"><span class="fa fa-edit"></span></a></td>
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