

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

;echo '
<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Document Receipt Form</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">

				<form action="">

					<div class="tab-content">
						<div class="tab-pane active fade in" id="basicInformation">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">


										<div class="col-lg-2">
											<label>Id (Auto)</label>
											<input type="number" class="form-control input-sm num" id="txtAccountId">
											<input type="hidden" id="txtid">
											<input type="hidden" id="txtAccountIdHidden">
											<input type="hidden" id="VoucherTypeHidden">
									    </div> 


										<div class="col-lg-2">
										    <label class="">Date</label>
										    <input class="form-control input-sm" type="date" id="date" value="';echo date('Y-m-d');;echo '" >
									    </div> 

										<div class="col-lg-3">
											<label>Name</label>
											<input type="text" class="form-control input-sm" id="name">
									    </div> 


										<div class="col-lg-3">
										    <label>Company Name </label>
											<input type="text" class="form-control input-sm" id="company">
										</div>

										<div class="col-lg-2">
											<label>Amount</label>
											<input type="number" class="form-control input-sm" id="amount">
									    </div>

										<div class="col-lg-3">
										    <label>Received By </label>
											<input type="text" class="form-control input-sm" id="by">
										</div>

										<div class="col-lg-3">
										    <label>Status</label>
											<select class="form-control select2" id="status">
											<option value="Received">Received</option>
											</select>
										</div>

										
										<div class="col-lg-12">
										<div class="pull-right">
											<a class="btn btn-sm btn-default btnSave" data-insertbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['account']['update'];;echo '\'><i class="fa fa-save"></i> Save F10</a>
											<a class="btn btn-sm btn-default btnupdate"><i class="fa fa-refresh"></i>Update</a>
											<a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
											<a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
									    </div>
										</div>  


									
									</div>
										

											

  <!-- end of button row -->
										<div class="row">
										<div class="col-lg-12">
											<div class="panel panel-default">
												<div class="panel-body">
													<table class="table table-striped table-hover ar-datatable">
														<thead>
															<tr>
																<th style=\'background: #368EE0;\'>Sr#</th>
																<th style=\'background: #368EE0;\'>ID</th>
																<th style=\'background: #368EE0;\'>Date</th>
																<th style=\'background: #368EE0;\'>Name</th>
																<th style=\'background: #368EE0;\'>Company</th>
																<th style=\'background: #368EE0;\'>Amount</th>
																<th style=\'background: #368EE0;\'>Received By</th>
																<th style=\'background: #368EE0;\'>Status</th>

															</tr>
														</thead>
														<tbody>
															';$counter = 1;foreach ($departments as $department): ;echo '													<tr>
																	<td >&nbsp&nbsp&nbsp';echo $counter++;;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'id'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'date'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'name'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'company'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'amount'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'sender'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'status'];;echo '</td>
																	<td><div class="btn btn-sm btn-primary btn-edit-dept showallupdatebtn" data-transporter_id="';echo $department['name'];;echo '" data-transporter2_id="';echo $department['date'];; echo '"  data-transporter4_id="';echo $department['id'];;echo '" data-transporter5_id="';echo $department['amount'];;echo '" data-transporter6_id="';echo $department['sender'];;echo '" data-transporter7_id="';echo $department['status'];;echo '" data-transporter8_id="';echo $department['company'];;echo '"   ><span class="fa fa-edit"></span></div></td>
																	
																</tr>
															';endforeach ;echo '											</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
											
										</div>
										
									</div>
								</div> 

							</div>    

							
						</div>  <!-- end of container fluid -->
	
					</div>   <!-- end of page_content -->
				</form>
			</div>
		</div>
	</div>			
</div>';
?>