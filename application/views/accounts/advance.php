

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
				<h1 class="page_title">Advance Voucher</h1>
			</div>
			<div class="col-lg-9">
				<div class="pull-right">
					<a href=\'\' class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['advance']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
					<a href=\'\' class="btn btn-default btnDelete" data-deletetbtn=\'';echo $vouchers['advance']['delete'];;echo '\'><i class="fa fa-trash-o"></i> Delete</a>
					<a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print</a>
					<a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
				</div>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-md-12">

					<div class="row">
						<div class="col-lg-12">

							<ul class="nav nav-pills">
					            <li class="active"><a href="#addupdateAdvance" data-toggle="tab">Add/Update Advance</a></li>
					            <li><a href="#searchcash" data-toggle="tab">Search Advance</a></li>
				          	</ul>

				          	<div class="tab-content">
								<div class="tab-pane active" id="addupdateAdvance">
									<div class="panel panel-default">
										<div class="panel-body">

											<form action="">

												<div class="row">
													<div class="col-lg-2">
														<div class="input-group">
															<span class="input-group-addon id-addon">Vr#</span>
															<input type="number" id="txtId" class="form-control num txtidupdate" data-txtidupdate=\'';echo $vouchers['advance']['update'];;echo '\'>
															<input type="hidden" id="txtMaxIdHidden"/>
															<input type="hidden" id="txtIdHidden"/>
															<input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
															<input type="hidden" id="voucher_type_hidden">
															<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                                            <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                                            <input type="hidden" id="cashid" value="';echo $setting_configur[0]['cash'];;echo '">
														</div>
													</div>

													<div class="col-lg-1"></div>

													<div class="col-lg-3">
					                                    <div class="input-group">
					                                        <span class="input-group-addon txt-addon">Date</span>
					                                        ';if ($vouchers['date_close']['insert'] == 1){;echo '                                                                <input class="form-control input-sm" type="date" id="cur_date" value="';echo date('Y-m-d');;echo '" >
                                                            ';}else{;echo '                                                                <input class="form-control input-sm" type="date" id="cur_date" value="';echo date('Y-m-d');;echo '" readonly="">
                                                            ';};echo '
                                                            <input class="form-control input-sm hidden" type="date" id="chk_date" value="';echo date('Y-m-d');;echo '" >
					                                    </div>
					                                </div>

					                            </div>
												
												<div class="row">
													<div class="container-wrap">
														<div class="row">
								                            <div class="col-lg-2" style=\'width: 8%;\'>
							                                  	<select class="form-control select2" id="pid_dropdown">
							                                      	<option value="" disabled="" selected="">Choose Id</option>
							                                      	';foreach ($accounts as $account): ;echo '							                                          	<option value="';echo $account['pid'];;echo '">';echo $account['pid'];;echo '</option>
							                                      	';endforeach ;echo '							                                  	</select>
								                            </div>
								                            <div class="col-lg-3" style=\'width: 18%;\'>
							                                  	<select class="form-control select2" id="name_dropdown">
							                                  		<option value="" disabled="" selected="">Choose Account</option>
							                                      	';foreach ($accounts as $account): ;echo '							                                          	<option value="';echo $account['pid'];;echo '">';echo $account['name'];;echo '</option>
							                                      	';endforeach ;echo '							                                  	</select>
								                            </div>

								                            <div class="col-lg-2" style=\'width: 30%;\'>
						                                      	<div class="input-group">
						                                        	<span class="input-group-addon other-addon"><span class="glyphicon glyphicon-comment"></span></span>
						                                        	<input type="text" id="txtRemarks" class="form-control" placeholder="Remarks"/>
							                                    </div>
							                                </div>

							                                <div class="col-lg-2">
						                                      	<div class="input-group">
						                                        	<span class="input-group-addon other-addon">Inv#</span>
						                                        	<input type="text" id="txtInvNo" placeholder=\'Inv#\' class="form-control"/>
							                                    </div>
							                                </div>

							                                <div class="col-lg-2">
						                                      	<div class="input-group">
						                                        	<span class="input-group-addon amnt-addon"><span class="fa fa-money"></span></span>
						                                        	<input type="text" id="txtAmount" placeholder=\'Amount\' class="form-control num"  />
							                                    </div>
							                                </div>
								                            
									                        <div class="col-lg-1">
									                            <div class="input-group">
									                                <a href="" class="btn btn-primary" id="btnAddCash">+</a>
																</div>
									                        </div>
								                    	</div>
													</div>
												</div>
												<div class="row"></div>


												<div class="row">
						                            <div class="col-lg-12">
						                                <table class="table table-striped report-table" id="advance_table">
						                                    <thead>
						                                        <tr>
						                                            <th>AccId</th>
						                                            <th>Account Name</th>
						                                            <th>Remarks</th>
						                                            <th>Inv#</th>
						                                            <th>Amount</th>
						                                            <th class=\'text-center\'>Actions</th>
						                                        </tr>
						                                    </thead>
						                                    <tbody>

						                                    </tbody>
						                                </table>
						                            </div>
						                        </div>

						                        <div class="row">
						                        	<div class="col-lg-3" style="width:30%" >
	            	                                  	<select class="form-control" id="cash_dropdown" tabindex="6">
	            	                                  		<option value="" disabled="" selected="">Choose Cash Account</option>
	            	                                      	';foreach ($accountCashs as $accountCash): ;echo '	            	                                          	<option value="';echo $accountCash['pid'];;echo '">';echo $accountCash['name'];;echo '</option>
	            	                                      	';endforeach ;echo '	            	                                  	</select>
                		                            </div>
						                        	<div class="col-lg-3"></div>
						                        	<div class="col-lg-3">
						                        		<div class="input-group">
				                                        	<span class="input-group-addon">Net Amount</span>
				                                        	<input type="text" id="txtNetAmount" class="form-control" readonly/>
					                                    </div>
						                        	</div>
						                        </div>

												<div class="row">
													<div class="col-lg-12">
														<div class="pull-right">
															<a href=\'\' class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['advance']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
															<a href=\'\' class="btn btn-default btnDelete" data-deletetbtn=\'';echo $vouchers['advance']['delete'];;echo '\'><i class="fa fa-trash-o"></i> Delete</a>
															<a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print</a>
															<a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
														</div>
													</div> 	<!-- end of col -->
												</div>	<!-- end of row -->


											</form>	<!-- end of form -->

										</div>	<!-- end of panel-body -->
									</div>	<!-- end of panel -->
								</div>

								<div class="tab-pane" id="searchcash">
									<div class="panel panel-default">
										<div class="panel-body">
											
											<div class="row">
												<div class="col-lg-3">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">From</span>
				                                        <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
				                                    </div>
				                                </div>
				                                <div class="col-lg-3">
				                                    <div class="input-group">
				                                        <span class="input-group-addon">To</span>
				                                        <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
				                                    </div>
				                                </div>

				                                <div class="col-lg-2">
				                                	<a href=\'\' class="btn btn-default btnSearch"><i class="fa fa-search"></i> Search</a>
				                                </div>
											</div>

				                            <div class="row">
					                            <div class="col-lg-12">
					                                <table class="table table-striped" id="search_advance_table">
					                                    <thead>
					                                        <tr>
					                                        	<th>Vr#</th>
					                                            <th>VrDate</th>
					                                            <th>Party Name</th>
					                                            <th>Amount</th>
					                                            <th>Remarks</th>
					                                            <th class=\'text-center\'>Actions</th>
					                                        </tr>
					                                    </thead>
					                                    <tbody>
					                                    </tbody>
					                                </table>
					                            </div>
					                        </div>

										</div>	<!-- end of panel-body -->
									</div>	<!-- end of panel -->
								</div>
				          	</div>

						</div>  <!-- end of col -->
					</div>	<!-- end of row -->

				</div>	<!-- end of level 1-->
			</div>
		</div>
	</div>
</div>';
?>