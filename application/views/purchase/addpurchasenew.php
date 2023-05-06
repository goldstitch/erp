

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<div id="main_wrapper">
			<div class="page_content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-lg-6">
											<h2 style="color:black;">Sale Voucher</h2>
										</div><!-- end of col-lg-6 -->
										<div class="col-lg-6">
											<div class="pull-right">
												<a href="#" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-floppy-saved"></span> Save</a>
	        								<a href="#" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-refresh"></span>Reset</a>
	        								<a href="#" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-trash"></span> Delete</a>
											</div><!-- pull-right -->	
                 						</div><!-- end of col -->
									</div><!-- end of row -->
								</div><!-- panel-heading -->
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12">
											<form role="form">
												<div class="form-group">
													<div class="row">
														<div class="col-lg-1">
															<label>Voucher#</label>
															<input class="form-control" type="text">
														</div>
														<div class="col-lg-1">
															<label>Invoice#</label>
															<input class="form-control" type="text">
														</div>
														<div class="col-lg-2">
															<label>Date</label>
															<input class="form-control ts_datepicker" type=\'date\'>
														</div>
														<div class="col-lg-3">
															<label>Party Name</label>
															<select class="form-control">
																<option></option>
																option
															</select>
														</div>
													</div>
												</div><!-- form-group -->
												<div class="form-group">
													<div class="row">
														<div class="col-lg-7">
															<label>Description</label>
															<input class="form-control" type="text">
														</div>
													</div>
												</div><!-- form-group -->
											</form>
										</div><!-- end of col-12 -->
									</div><!-- end of row -->
								</div><!--- panel-body -->
								<div class="panel-body" style="margin:10px 0px 0px 0px;">
									<div class="row">
										<div class="col-lg-12">
											<form role="form">
												<div class="form-group" style="margin:-20px 0px 15px 0px;">
													<div class="row">
														<div class="col-lg-1" style=\'width:130px;\'>
															<label>Item#</label>
															<select class="form-control">
																<option>1</option>
																<option>2</option>
																<option>3</option>
															</select>
														</div>
														<div class="col-lg-3">
															<label>Product</label>
															<select class="form-control">
																<option selected disabled>Select Product</option>
																<option>Jackets</option>
																<option>Shirts</option>
																<option>Pants</option>
																<option>Belts</option>
															</select>
														</div>
														<div class="col-lg-1">
															<label>UOM</label>
															<input type="text" class="form-control">
														</div>
														<div class="col-lg-1" style=\'width:120px;\'>
															<label>Quantity</label>
															<input type="text" class="form-control">
														</div>
														<div class="col-lg-1" style=\'width:120px;\'>
															<label>Weight</label>
															<input class="form-control" type="text">
														</div>
														<div class="col-lg-1" style=\'width:120px;\'>
															<label>Rate</label>
															<input class="form-control" type="text">
														</div>
														<div class="col-lg-1" style=\'width:140px;\'>
															<label>Amount</label>
															<input class="form-control" type="text">
														</div>
														<div class="col-lg-1" style="margin:30px 0px 0px 10px;">
															<a class="btn btn-primary">
																<span class="glyphicon glyphicon-plus"></span> Add
																</a>
														</div>
													</div>
												</div><!-- form-group -->
											</form>
										</div><!-- col-lg-12 -->
										<div class="panel-body" style="margin:70px 0px -30px 0px;">
											<table class="table table-striped tdatatable"> 
												<thead>
													<tr>
														<th>Item#</th>
														<th>Product</th>
														<th>UOM</th>
														<th>Quantity</th>
														<th>Weight</th>
														<th>Rate</th>
														<th>Amount</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>3</td>
														<td>Jackets</td>
														<td>2</td>
														<td>987</td>
														<td>2</td>
														<td>987</td>
														<td>00</td>

														<td>
															<button class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></button> <button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
														</td>
													</tr>


												</tbody>
												<tfoot style=\'border-top:1px solid !important;\'>
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td style=\'color:red !important;\'>Qty:</td>
														<td></td>
														<td style=\'color:red !important;\'>Rate:</td>
														<td style=\'color:red !important;\'>Amount:</td>
														<td></td>
													</tr>
												</tfoot>
											</table>
										</div><!-- panel-body -->
									</div><!-- end of row -->
								</div><!-- panel-body -->
								<div class="row" style=\'margin:5px -25px;\'>
									<div class="col-lg-12">
										<div class="panel panel-primary">
											<div class="panel-body" style=\'border:1px solid !important;\'>
												<div class="row">
													<div class="col-lg-12">
														<form role="form" style=\'margin:0px;\'>
															<div class="form-group">
																<div class="row">
																	<div class="col-lg-1" style=\'width:130px;\'>
																		<label style=\'color:red !important;\'>G.Amount</label>
																		<input type="text" class="form-control">
																	</div>
																	<div class="col-lg-1">
																		<label style=\'color:red !important;\'>Freight</label>
																		<input type="text" class="form-control">
																	</div>
																	<div class="col-lg-1">
																		<label style=\'color:red !important;\'>Discount</label>
																		<input type="text" class="form-control">
																	</div>
																	<div class="col-lg-1" style=\'width:120px;\'>
																		<label style=\'color:red !important;\'>Disc%</label>
																		<input type="text" class="form-control">
																	</div>
																	<div class="col-lg-1" style=\'width:120px;\'>
																		<label style=\'color:red !important;\'>Tax</label>
																		<input class="form-control" type="text">
																	</div>
																	<div class="col-lg-1" style=\'width:140px;\'>
																		<label style=\'color:red !important;\'>Net Amount</label>
																		<input class="form-control" type="text">
																	</div>
																	<div class="col-lg-2 pull-right">
																		<label>User</label>
																		<select class="form-control">
																			<option>1</option>
																			<option>2</option>
																			<option>3</option>
																		</select>
																	</div>
																</div>
															</div><!-- form-group -->
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="margin:10px 0px 0px 0px;">
									<div class="col-lg-12">
										<div class="pull-right">
											<a href="#" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-floppy-saved"></span> Save</a>
			        						<a href="#" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-refresh"></span>Reset</a>
			        						<a href="#" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-trash"></span> Delete</a>
										</div><!--pull-right -->
									</div><!-- end of col-lg- 12 -->
								</div><!-- end of row -->
							</div><!-- panel -->
						</div><!-- end of col -->
					</div><!-- end of row -->
				</div><!-- container-fluid -->
			</div><!-- page-content -->
		</div><!-- main-wrapper -->';
?>