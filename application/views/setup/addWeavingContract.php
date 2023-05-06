

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
;echo '<style type="text/css">
	.input-group-addon {
		font-size: 12px!important;
		padding: 6px 6px;
	}
	.input-sm{
		font-size: 20px !important;
    	font-weight: bold;
	}

	.txtdate{
		font-size: 14px !important;
    	font-weight: normal !important;
	}

</style>
<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-6">
				<h1 class="page_title">Add Weaving Contract</h1>
			</div>
			<div class="col-lg-6 pull-right">
				
				<a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['weavingcontract']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['weavingcontract']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['weavingcontract']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['weavingcontract']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
				<a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
				<a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
				<a class="btn btn-sm btn-default btnPrint"><i class="fa fa-print"></i> Print F9</a>

				
			</div> 
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs hidden" id="tabs_a">
					<li class="active"><a data-toggle="tab" href="#add_weaving_contract">Add Weaving Contract</a></li>
					<li class=""><a data-toggle="tab" href="#view_all">View All</a></li>
				</ul>
				<div class="tab-content">
					<div id="add_weaving_contract" class="tab-pane fade active in">
						<form action="">

							<div class="row">
								<div class="col-lg-7">
									<div class="panel panel-default">
										<div class="panel-body">



											<div class="row">
												<div class="col-lg-6">
													<div class="input-group">
														<div class="input-group-addon id-addon">Vr#</div>
														<input type="number" class="form-control input-sm  num txtidupdate" id="txtId">
														<input type="hidden" id="txtIdHidden">
														<input type="hidden" id="txtMaxIdHidden">
														<input type="hidden" id="vouchertypehidden">

														<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
														<input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
														<input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

													</div>
												</div>

												<div class="col-lg-6">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Date</div>
														<input type="date" value="';echo date("Y-m-d");;echo '" class="form-control input-sm txtdate" id="vrdate">


													</div>
												</div>

											<!-- 	<div class="col-lg-2">
													<div class="input-group">
														<div class="input-group-addon id-addon">Is active?</div>

														
														<input type="checkbox" checked="" class="bs_switch active_switch" id="active">
													</div>
												</div> -->

											</div>
											<fieldset>
												<legend>Mandatory Fields</legend>
												<div class="row">
													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Supplier<span id="partyBalance"></span>

															</div>
															<input type="text" class="form-control" id="txtPartyId" >
															<img id="imgPartyLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '">
															<input id="hfPartyId" type="hidden" value="" />
															<input id="hfPartyBalance" type="hidden" value="" />
															<input id="hfPartyCity" type="hidden" value="" />
															<input id="hfPartyAddress" type="hidden" value="" />
															<input id="hfPartyCityArea" type="hidden" value="" />
															<input id="hfPartyMobile" type="hidden" value="" />
															<input id="hfPartyUname" type="hidden" value="" />
															<input id="hfPartyLimit" type="hidden" value="" />
															<input id="hfPartyName" type="hidden" value="" />
															<input id="txtHiddenEditQty" type="hidden" value="" />
															<input id="txtHiddenEditRow" type="hidden" value="" />


															
														</div>
													</div>
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Credit Limit:</div>
															<input typ="number" disabled name="creditlimit" class="form-control input-sm" id="creditlimit">
														</div>
													</div>
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Account Balance:</div>
															<input typ="number" disabled name="accountbalance" class="form-control input-sm" id="accountbalance">
														</div>
													</div>
												</div>
												



												<div class="row">
													<div class="col-lg-4">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Contract#</div>
															<input typ="text" name="contract_no" class="form-control input-sm" id="contract_no">
														</div>
													</div>


													<div class="col-lg-4">
														<div class="input-group">
															<div class="input-group-addon txt-addon">
															Contract Date:</div>
															<input type="date" value="';echo date("Y-m-d");;echo '" class="form-control input-sm txtdate" id="contract_date">
															
															
														</div>
													</div>
													<div class="col-lg-4">
														<div class="input-group">
															<div class="input-group-addon txt-addon" >Due Date:</div>
															<input type="date" value="';echo date("Y-m-d");;echo '" class="form-control input-sm txtdate" id="duedate">
															
															
														</div>
													</div>


												</div>


												<div class="row">
													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Broker<span id=""></span>

															</div>
															<input type="text" class="form-control" id="txtBrokerId" >
															<img id="imgBrokerLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"><input id="hfBrokerId" type="hidden" value="" />
															<input id="hfBrokerBalance" type="hidden" value="" />
															<input id="hfBrokerCity" type="hidden" value="" />
															<input id="hfBrokerAddress" type="hidden" value="" />
															<input id="hfBrokerCityArea" type="hidden" value="" />
															<input id="hfBrokerMobile" type="hidden" value="" />
															<input id="hfBrokerUname" type="hidden" value="" />
															<input id="hfBrokerLimit" type="hidden" value="" />
															<input id="hfBrokerName" type="hidden" value="" />
															<input id="txtHiddenEditQty" type="hidden" value="" />
															<input id="txtHiddenEditRow" type="hidden" value="" />


															
														</div>
													</div>

													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Finish Item:<span id=""></span>

															</div>
															<input type="text" class="form-control" id="txtItemId" >
															<img id="imgItemLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '">
															<input id="hfItemId" type="hidden" value="" />
															<input id="hfItemBalance" type="hidden" value="" />
															<input id="hfItemCity" type="hidden" value="" />
															<input id="hfItemAddress" type="hidden" value="" />
															<input id="hfItemCityArea" type="hidden" value="" />
															<input id="hfItemMobile" type="hidden" value="" />
															<input id="hfItemUname" type="hidden" value="" />
															<input id="hfItemLimit" type="hidden" value="" />
															<input id="hfItemName" type="hidden" value="" />
															<input id="txtHiddenEditQty" type="hidden" value="" />
															<input id="txtHiddenEditRow" type="hidden" value="" />


															
														</div>
													</div>
												</div>


												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Remarks:</div>
															<input type="text" class="form-control input-sm" id="remarks">
														</div>
													</div>
												</div>



											</fieldset>

											<fieldset style="">
												<legend style="font-size:20px;">Contract Detail:</legend>
												<div class="row">
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Read:</div>
															<input type="text" class="form-control input-sm num" id="read">
														</div>
													</div>

													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Pick:</div>
															<input type="text" class="form-control input-sm num" id="pick">
														</div>
													</div>
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Warp:</div>
															<input type="text" class="form-control input-sm num" id="warp">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Weft:</div>
															<input type="text" class="form-control input-sm num" id="weft">
														</div>
													</div>
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Width:</div>
															<input type="text" class="form-control input-sm num" id="width">
														</div>
													</div>
													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Finish Qty:</div>
															<input type="text" class="form-control input-sm num" id="qty">
															<div class="input-group-addon ">MTR </div>
														</div>
													</div>
												</div>


												<div class="row">
													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Yarn Warp:<span id=""></span>

															</div>
															<input type="text" class="form-control" id="txtYarnId" >
															<img id="imgYarnLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '">
															<input id="hfYarnId" type="hidden" value="" />
															<input id="hfYarnBalance" type="hidden" value="" />
															<input id="hfYarnCity" type="hidden" value="" />
															<input id="hfYarnAddress" type="hidden" value="" />
															<input id="hfYarnCityArea" type="hidden" value="" />
															<input id="hfYarnMobile" type="hidden" value="" />
															<input id="hfYarnUname" type="hidden" value="" />
															<input id="hfYarnLimit" type="hidden" value="" />
															<input id="hfYarnName" type="hidden" value="" />
															<input id="txtHiddenEditQty" type="hidden" value="" />
															<input id="txtHiddenEditRow" type="hidden" value="" />


															
														</div>
													</div>

													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Yarn Weft:<span id=""></span>

															</div>
															<input type="text" class="form-control" id="txtYarnwId" >
															<img id="imgYarnwLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '">
															<input id="hfYarnwId" type="hidden" value="" />
															<input id="hfYarnwBalance" type="hidden" value="" />
															<input id="hfYarnwCity" type="hidden" value="" />
															<input id="hfYarnwAddress" type="hidden" value="" />
															<input id="hfYarnwCityArea" type="hidden" value="" />
															<input id="hfYarnwMobile" type="hidden" value="" />
															<input id="hfYarnwUname" type="hidden" value="" />
															<input id="hfYarnwLimit" type="hidden" value="" />
															<input id="hfYarnwName" type="hidden" value="" />
															<input id="txtHiddenEditQty" type="hidden" value="" />
															<input id="txtHiddenEditRow" type="hidden" value="" />


															
														</div>
													</div>
												</div>



												

											</fieldset>


											<fieldset>
												<legend>Calculation</legend>



												<div class="row">
													<div class="col-lg-3" style="margin-top: 20px;">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Tot Req Bag:</div>
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">
														<center>Warp</center>
														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="bagwarp">
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">
														<center>Weft</center>
														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="bagwept">
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;">
														<center>Total</center>
														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="bagtotal">
														</div>
													</div>
												</div>

												<!-- Weight/40 Meter: -->
												<div class="row">
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Weight/Meter:</div>
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="weight40warp">
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="weight40weft">
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;">
														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="weighttotal">
														</div>
													</div>
												</div>


												<!-- RATE -->

												<div class="row">
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Rate:</div>
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="ratewarp">
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="rateweft">
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;">
														<div class="input-group">
															<input type="text" class="form-control input-sm num" disabled id="ratetotal">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Yarn Value/40 Mtr:</div>
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num" disabled id="valueyarn40warp">
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num" disabled id="valueyarn40weft">
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;">
														<div class="input-group">
															<input type="text" class="form-control input-sm num" disabled id="valueyarntotal">
														</div>
													</div>
												</div>

												
												<div class="row">
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Conversion <br>Charges /Pick:</div>
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="conversionchargespick">
														</div>
													</div>

													<div class="col-lg-2" style="padding-left:0px;">

														
													</div>

													<div class="col-lg-4" style="padding-left:0px;">
														<div class="input-group">
															<div class="input-group-addon txt-addon num">Con Ch/Mtr:</div>
															<input type="text" class="form-control input-sm num" disabled id="conversionchargesmeter">
														</div>
													</div>
												</div>
												<!-- Conversion Charges /40 Meter -->
												<div class="row">
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Con Ch/40 Mtr:</div>
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px">

														<div class="input-group">
															<input type="text" class="form-control input-sm num" disabled id="conversion40meter">
														</div>
													</div>
												</div>

												<!-- Gery Fabric Rate /Meter: -->
												<div class="row">
													<div class="col-lg-3" >
														<div class="input-group">
															<div class="input-group-addon txt-addon">Grey Fabric<br> Rate /Meter:</div>
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num" id="greyfabricratemeter">
														</div>
													</div>

													<div class="col-lg-2">

														
													</div>

													<div class="col-lg-4" style="padding-left:0px;">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Fabric Value:</div>
															<input type="text" class="form-control input-sm" id="greyfabricValue">
														</div>
													</div>

													
												</div>
												<!-- Deduction Meter: -->

												<div class="row">
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Deduction Meter:</div>
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num"  id="deductionmeter">
														</div>
													</div>

													<div class="col-lg-2">

														
													</div>

													<div class="col-lg-4" style="padding-left:0px;">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Looms Plan:</div>
															<input type="text" class="form-control input-sm" id="loomsplan">
														</div>
													</div>

												</div>

												<div class="row">
													<div class="col-lg-3" >
														<div class="input-group">
															<div class="input-group-addon txt-addon">Looms Used:</div>
														</div>
													</div>

													<div class="col-lg-3" style="padding-left:0px;padding-right: 0px;">

														<div class="input-group">
															<input type="text" class="form-control input-sm num"  id="noofloomsused">
														</div>
													</div>
												</div>

												<div class="row">
									<div class="col-lg-12">
										<div class="pull-right">
											<a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['weavingcontract']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['weavingcontract']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['weavingcontract']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['weavingcontract']['print'];;echo '\'><i class="fa fa-save"></i> Save F10</a>
											<a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
											<a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
				<a class="btn btn-sm btn-default btnPrint"><i class="fa fa-print"></i> Print F9</a>

										</div>
									</div> 	
								</div>



											</fieldset>







										</div>	<!-- end of panel-body -->
									</div>	<!-- end of panel -->
								</div>  <!-- end of col -->

								<div class="col-lg-5">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="row">

												<div class="col-lg-7"><div class="input-group">
													<table class="table table-striped table-hover">
														<thead>
															<tr>
																<th style=\'background: #368EE0;\'>Sr#</th>
																<th style=\'background: #368EE0;\'>Name</th>
																<th style=\'background: #368EE0;\'>Active</th>

																<th style=\'background: #368EE0;\'></th>
															</tr>
														</thead>
														<tbody>

														</tbody>
													</table>

												</div></div>
												<div class="col-lg-5">
													<a class="btn btn-sm btn-primary" ><i class="fa fa-save"></i>Weaving Contract</a>

													<fieldset style=""><legend>Print Option</legend>
														<div class="form-check">
															<label class="form-check-label" for="exampleRadios2">

																<input class="form-check-input" type="radio" name="exampleRadios" value=""> PrintOut
																<input class="form-check-input" type="radio" name="exampleRadios" value=""> Prevoius
															</label>

															<label class="form-check-label" for="exampleRadios2">

																<input class="form-check-input position-static"  type="checkbox" id="blankCheckbox" value="" aria-label="..."> Print Prevoius Balance
															</label>

															<label class="form-check-label" for="exampleRadios2">

																<input class="form-check-input position-static"  type="checkbox" id="blankCheckbox" value="" aria-label="..."> With Header
															</label>
														</div>
													</fieldset>

												</div>


											</div>

											<div class="row">
												<div class="col-lg-6">
													<fieldset style=""><legend>Contact Summary</legend>
														<div class="row">
															<div class="col-lg-12">
																<div class="input-group">
																	<div class="input-group-addon txt-addon">Cont Qty:</div>
																	<input type="text" class="form-control input-sm" disabled id="contqty">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-12">
																<div class="input-group">
																	<div class="input-group-addon txt-addon">Received:</div>
																	<input type="text" class="form-control input-sm" disabled id="Issued">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-12">
																<div class="input-group">
																	<div class="input-group-addon txt-addon">Balance Qty:</div>
																	<input type="text" class="form-control input-sm" disabled id="balanceqty">
																</div>
															</div>
														</div>
													</fieldset>
												</div>


												<div class="col-lg-4">
													<fieldset style=""><legend>Status</legend>
														<div class="form-check">
															<label class="form-check-label" for="exampleRadios2">
																<input class="form-check-input" type="radio" name="exampleRadios" value=""> Running
															</label>
															<label class="form-check-label" for="exampleRadios2">
																<input class="form-check-input" type="radio" name="exampleRadios" value="">Complete
															</label>
															<label class="form-check-label" for="exampleRadios2">
																<input class="form-check-input" type="radio" name="exampleRadios" value="">Cancel
															</label>
														</div>
													</fieldset>
												</div>






											</div>
										</div>
									</div></div>
								</div>



								


							</form>
						</div>	<!-- end of add_branch -->

					</div>
				</div>
			</div>
		</div>
	</div>';
?>