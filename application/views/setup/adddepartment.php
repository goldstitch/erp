

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
				<h1 class="page_title">Add Warehouse</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tabs_a">
					<li class="active"><a data-toggle="tab" href="#add_dept">Add Update Warehouse</a></li>
					<li class=""><a data-toggle="tab" href="#view_all">View All</a></li>
				</ul>
				<div class="tab-content">
					<div id="add_dept" class="tab-pane fade active in">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">

										<form action="">

											<div class="row">
												<div class="col-lg-2">
													<div class="input-group">
														<div class="input-group-addon id-addon">Dept. Id</div>
														<input type="number" class="form-control input-sm num" id="txtId">
														<input type="hidden" id="txtIdHidden">
														<input type="hidden" id="txtMaxIdHidden">
														<input type="hidden" id="vouchertypehidden">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Name</div>
														<input type="text" class="form-control input-sm" id="txtName">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Strength</div>
														<input type="text" class="form-control input-sm num" id="txtStrength">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-3">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Description</div>
														<input type="text" class="form-control input-sm" id="txtDescription">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-12">
													<div class="pull-right">
														<a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['warehouse']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['warehouse']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['warehouse']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
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
													<th style=\'background: #368EE0;\'>Strength</th>
													<th style=\'background: #368EE0;\'>Description</th>
													<th style=\'background: #368EE0;\'></th>
												</tr>
											</thead>
											<tbody>
												';$counter = 1;foreach ($departments as $department): ;echo '													<tr>
														<td>';echo $counter++;;echo '</td>
														<td>';echo $department['name'];;echo '</td>
														<td>';echo $department['strength'];;echo '</td>
														<td>';echo $department['description'];;echo '</td>
														<td><a href="" class="btn btn-sm btn-primary btn-edit-dept" data-did="';echo $department['did'];;echo '"><span class="fa fa-edit"></span></a></td>
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