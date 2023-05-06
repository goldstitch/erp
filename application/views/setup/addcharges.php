

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
				<h1 class="page_title">Charges</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tabs_a">
					<li class="active"><a data-toggle="tab" href="#add_charges">Add Update Charges</a></li>
					<li class=""><a data-toggle="tab" href="#view_all">View All</a></li>
				</ul>
				<div class="tab-content">
					<div id="add_charges" class="tab-pane fade active in">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">

										<form action="">

											<div class="row">
												<div class="col-lg-2">
													<div class="input-group">
														<span class="input-group-addon id-addon">Id</span>
														<input type="text" class="form-control num txtidupdate" id="txtChargeId" data-txtidupdate=\'';echo $vouchers['charges_voucher']['update'];;echo '\'>
														<input type="hidden" id="txtMaxChargeIdHidden">
														<input type="hidden" id="txtChargeIdHidden">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Type</span>
														<select class="form-control" id="txtChargeType">
															<option value="" disabled="" selected="">Choose Type</option>
															';foreach ($chargeTypes as $chargeType): ;echo '																<option value="';echo $chargeType['type'];;echo '">';echo $chargeType['type'];;echo '</option>
															';endforeach ;echo '														</select>
														<div class="input-group-btn">
															<a href="#chargeTypeModel" class="btn btn-primary" data-toggle="modal" id="btnAddChargeType">+</a>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Account</span>
														<select class="form-control" id="txtAccountName">
															<option value="" disabled="" selected="">Choose Account</option>
															';foreach ($parties as $party): ;echo '																<option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
															';endforeach ;echo '														</select>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Particulars</span>
														<input type="text" class="form-control" id="txtParticulars">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<span class="input-group-addon txt-addon">Charges</span>
														<input type="text" class="form-control num" id="txtCharge">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-6">
													<div class="pull-right">
														<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['charges_voucher']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
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
													<td>Type</td>
													<td>Particulars</td>
													<td>Charges</td>
													<td></td>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;foreach ($charges as $charge): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo $charge['type'];;echo '</td>
														<td>';echo $charge['description'];;echo '</td>
														<td>';echo $charge['charges'];;echo '</td>
														<td><a href="" class="btn btn-primary btn-edit-charge showallupdatebtn" data-chid="';echo $charge['chid'];;echo '" data-showallupdatebtn=';echo $vouchers['charges_voucher']['update'];;echo '><span class="fa fa-edit"></span></a></td>
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
</div>


<div id="chargeTypeModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="model-contentwrapper">
		<div class="modal-header">
	  		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	  		<h3 id="myModalLabel">Add Charge Type</h3>
		</div>
		<div class="modal-body">

			<div class="input-group">
				<span class="input-group-addon">Type</span>
				<input type="text" class="form-control" id="txtTypeNew">
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<a class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
				<a class="btn btn-default btnNewChargeType"><i class="fa fa-plus"></i> Add</a>
			</div>
		</div>
	</div>
</div>';
?>