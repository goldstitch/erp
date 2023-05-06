

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
				<h1 class="page_title">Adda & Stone Work Material</h1>
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
											<input type="hidden" id="txtMaxAccountIdHidden">
											<input type="hidden" id="txtAccountIdHidden">
											<input type="hidden" id="VoucherTypeHidden">
									    </div> 


										<div class="col-lg-2">
											<label>Code</label>
											<input type="text" class="form-control input-sm" id="code">
									    </div> 

										<div class="col-lg-2">
											<label>Name</label>
											<input type="text" class="form-control input-sm" id="name">
									    </div> 


										<div class="col-lg-2">
										<label>Unit</label>
										<div class="input-group">
											<select class="form-control input-sm" id="unit">
												<option value="" disabled="" selected="">Choose unit</option>
												<option value="box">box</option>	
												<option value="bundle">bundle</option>
												<option value="packet">packet</option>
												<option value="psc">psc</option>
												<option value="inch">inch</option>
												<option value="meter">meter</option>
												<option value="yard">yard</option>
											</select>
											</div>														
										</div>

										<div class="col-lg-2">
											<label>Unit Rate</label>
											<input type="number" class="form-control input-sm" id="rate">
									    </div>

										<div class="col-lg-2">
										    <label>Unit QTY</label>
											<input type="number" class="form-control input-sm" id="qty">
										</div>

										<div class="col-lg-2">
										    <label>Per Unit Rate </label>
											<input type="number" class="form-control input-sm" id="perunitrate" readonly="">
										</div>

										
										<div class="col-lg-12">
										<div class="pull-right">
									
											<a class="btn btn-sm btn-default btnupdate"><i class="fa fa-refresh"></i>Update</a>
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
																<th style=\'background: #368EE0;\'>Code</th>
																<th style=\'background: #368EE0;\'>Name</th>
																<th style=\'background: #368EE0;\'>Unit</th>
																<th style=\'background: #368EE0;\'>Unit Qty</th>
																<th style=\'background: #368EE0;\'>Rate</th>
																<th style=\'background: #368EE0;\'>Per Unit Rate</th>

															</tr>
														</thead>
														<tbody>
															';$counter = 1;foreach ($departments as $department): ;echo '													<tr>
																	<td >&nbsp&nbsp&nbsp';echo $counter++;;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'id'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'code'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'name'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'unit'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'qty'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'rate'];;echo '</td>
																	<td>&nbsp&nbsp&nbsp';echo $department[ 'per_unit_rate'];;echo '</td>
																	<td><div class="btn btn-sm btn-primary btn-edit-dept showallupdatebtn" data-transporter_id="';echo $department['name'];;echo '" data-transporter2_id="';echo $department['code'];; echo '"  data-transporter4_id="';echo $department['id'];;echo '" data-transporter5_id="';echo $department['rate'];;echo '" data-transporter6_id="';echo $department['qty'];;echo '" data-transporter7_id="';echo $department['per_unit_rate'];;echo '" data-transporter8_id="';echo $department['unit'];;echo '"   ><span class="fa fa-edit"></span></div></td>
																	
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