

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
;echo '<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-6">
				<h1 class="page_title">Fabric Receive Voucher</h1>
			</div>
			<div class="col-lg-6 pull-right">
				
				<a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['fabricreceivevoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['fabricreceivevoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['fabricreceivevoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['fabricreceivevoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
				<a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
				<a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
				<a class="btn btn-sm btn-default  btnPrint"><i class="fa fa-print"></i> Print F9</a>
				<a class="btn btn-sm btn-default  btnprintAccount"><i class="fa fa-print"></i> Account Voucher</a>

              

				
			</div> 
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs hidden" id="tabs_a">
					<li class="active"><a data-toggle="tab" href="#add_weaving_contract">Add Fabric Receive</a></li>
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
														<div class="input-group-addon txt-addon ">Vr#</div>
														<input type="number" class="form-control input-sm  num txtidupdate VoucherNo" id="txtId">
														<input type="hidden" id="txtIdHidden">
														<input type="hidden" id="txtMaxIdHidden">
														<input type="hidden" id="vouchertypehidden">

														<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
														<input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
														<input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

														<input type="hidden" id="purchaseid" value="';echo $setting_configur[0]['purchase'];;echo '">
														<input type="hidden" id="discountid" value="';echo $setting_configur[0]['discount'];;echo '">
														<input type="hidden" id="expenseid" value="';echo $setting_configur[0]['expenses'];;echo '">
														<input type="hidden" id="taxid" value="';echo $setting_configur[0]['tax'];;echo '">
														<input type="hidden" id="cashid" value="';echo $setting_configur[0]['cash'];;echo '">
														<input type="hidden" id="wipid" value="';echo $setting_configur[0]['wip'];;echo '">
														<input type="hidden" id="incometaxid" value="';echo $setting_configur[0]['furthertax'];;echo '">




													</div>
												</div>

												<div class="col-lg-6">
													<div class="input-group">
														<div class="input-group-addon txt-addon ">Date</div>
														<input type="date" value="';echo date("Y-m-d");;echo '" class="form-control input-sm" id="vrdate">


													</div>
												</div>


											</div>
											<fieldset>
												<legend>Mandatory Fields</legend>
												
												<div class="row">
													

													<div class="col-lg-6">                                                
														<div class="input-group">
															<div class="input-group-addon txt-addon">
															Contract#</div>
															<select class="form-control select2" id="contract_no">
																<option value="" disabled="" selected="">Choose Contract</option>
																';foreach ($contracts as $contract): ;echo '																	<option value="';echo $contract['contract_id'];;echo '">';echo $contract['contract_no'];;echo '</option>
																';endforeach ;echo '															</select>                                               
														</div>
													</div>




													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-addon txt-addon">
															Cont Date:</div>
															<input type="date" value="';echo date("Y-m-d");;echo '" class="form-control input-sm" id="contract_date">
															
															
														</div>
													</div>
													<div class="col-lg-4 hide">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Due Date:</div>
															<input type="date" value="';echo date("Y-m-d");;echo '" class="form-control input-sm" id="duedate">
															
															
														</div>
													</div>


												</div><br>

												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Account<span id="partyBalance"></span>

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
												</div><br>


												<div class="row">
													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-addon txt-addon">StockLocation</div>
															<select class="form-control select2" id="dept_dropdown">
																<option value="" selected="" disabled="">Choose Warehouse</option>
																';foreach ($departments as $department): ;echo '																	';$selectedDepartment = ($department['did'] == 1) ?"selected":"";;echo '																	<option ';echo $selectedDepartment;;echo ' selected=" " value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
																';endforeach ;echo '															</select>
														</div>
													</div>

													<div class="col-lg-6">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Remarks:</div>
															<input type="text" class="form-control input-sm" id="remarks">
														</div>
													</div>

													
												</div>



											</fieldset>

											<fieldset style="">
												<legend style="font-size:20px;">Fabric Detail:</legend>
												

												<div class="row">
													<div class="col-lg-12">
														<div class="input-group">
															<div class="input-group-addon txt-addon">Fabric Quality<span id=""></span>

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
															<input id="hfYarnGrWeight" type="hidden" value="" />

															<input id="hfYarnInventoryId" type="hidden" value="" />


															
														</div>
													</div>
												</div><br>
												<div class="row">
													<div class="col-lg-4">

														<div class="input-group">
															<div class="input-group-addon txt-addon ">TotalMeter</div>

															<input type="text" class="form-control input-sm num" id="txtTotalMeter">
														</div>
													</div>

													<div class="col-lg-4">

														<div class="input-group">
															<div class="input-group-addon txt-addon ">Weight</div>

															<input type="text" class="form-control input-sm num" id="txtWeight">
														</div>
													</div>

													<div class="col-lg-4">

														<div class="input-group">
															<div class="input-group-addon txt-addon ">KP#</div>
															<input type="text" class="form-control input-sm num" id="txtKP">
														</div>
													</div>

													
												</div><br>

												
												<div class="row">

													<div class="col-lg-4" >

														<div class="input-group">
															<div class="input-group-addon txt-addon ">Bail</div>
															<input type="text" class="form-control input-sm num" id="txtBail">
														</div>
													</div>


													<div class="col-lg-4">

														<div class="input-group">
															<div class="input-group-addon txt-addon ">L/S</div>

															<input type="text" class="form-control input-sm num" id="txtLS">
														</div>
													</div>

													

													

													
												</div><br>


												<div class="row">
													<div class="col-lg-8">
														<div class="input-group">
															<div class="input-group-addon txt-addon">A Grade Item<span id=""></span>

															</div>
															<input type="text" class="form-control" id="txtAGradeItemId" >
															<img id="imgYarnwLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '">
															<input id="hfAGradeItemId" type="hidden" value="" />
															<input id="hfAGradeItemwBalance" type="hidden" value="" />
															<input id="hfAGradeItemwCity" type="hidden" value="" />
															<input id="hfAGradeItemwAddress" type="hidden" value="" />
															<input id="hfAGradeItemwCityArea" type="hidden" value="" />
															<input id="hfAGradeItemwMobile" type="hidden" value="" />
															<input id="hfAGradeItemwUname" type="hidden" value="" />
															<input id="hfAGradeItemwLimit" type="hidden" value="" />
															<input id="hfAGradeItemwName" type="hidden" value="" />
															<input id="hfAGradeItemwGrWeight" type="hidden" value="" />


															<input id="hfAGradeItemWeftInventoryId" type="hidden" value="" />
															


															
														</div>
													</div>

													<div class="col-lg-4">

														<div class="input-group">
															<div class="input-group-addon txt-addon ">A Grade</div>

															<input type="text" class="form-control input-sm num" id="txtAGrade">
														</div>
													</div>

												</div><br>

												<div class="row">
														<div class="col-lg-8">
														<div class="input-group">
															<div class="input-group-addon txt-addon">B Grade Item<span id=""></span>

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
																	
														</div>
													</div>
													<div class="col-lg-4">

														<div class="input-group">
															<div class="input-group-addon txt-addon ">B Grade</div>

															<input type="text" class="form-control input-sm num" id="txtBGrade">
														</div>
													</div>

												</div><br>

												<div class="row">
													<div class="col-lg-8">
														<div class="input-group">
															<div class="input-group-addon txt-addon">C Grade Item<span id=""></span>

															</div>
															<input type="text" class="form-control" id="txtCGradeItemId" >
															<img id="imgYarnwLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '">
															<input id="hfCGradeItemwId" type="hidden" value="" />
															<input id="hfCGradeItemwBalance" type="hidden" value="" />
															<input id="hfCGradeItemwCity" type="hidden" value="" />
															<input id="hfCGradeItemwAddress" type="hidden" value="" />
															<input id="hfCGradeItemwCityArea" type="hidden" value="" />
															<input id="hfCGradeItemwMobile" type="hidden" value="" />
															<input id="hfCGradeItemwUname" type="hidden" value="" />
															<input id="hfCGradeItemwLimit" type="hidden" value="" />
															<input id="hfCGradeItemwName" type="hidden" value="" />
															<input id="hfCGradeItemwGrWeight" type="hidden" value="" />


															<input id="hfCGradeItemWeftInventoryId" type="hidden" value="" />
															


															
														</div>
													</div>
													<div class="col-lg-4">

														<div class="input-group">
															<div class="input-group-addon txt-addon ">C Grade</div>

															<input type="text" class="form-control input-sm num"  id="txtCGrade">
														</div>
													</div>
												</div>	

											</fieldset><br>


											<fieldset>
												<legend>Calculation</legend>



												<div class="row">
													


													<div class="col-lg-6">
														
														<div class="input-group">
															<div class="input-group-addon txt-addon ">FreshFabric</div>
															<input type="text" class="form-control input-sm num" id="txtFreshFabric">
														</div>
													</div>

													<div class="col-lg-6">

														<div class="input-group">
															<div class="input-group-addon txt-addon ">PP#</div>

															<input type="text" class="form-control input-sm num" id="txtPP" >
														</div>
													</div>

													
													

												</div><br>


												<div class="row">
													
													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">Ch/Pick</div>

															<input type="text" class="form-control input-sm num"  id="txtChPick">
														</div>
													</div>

													<div class="col-lg-3">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">Ch/Mtr</div>

															<input type="text" class="form-control input-sm num"  id="txtChMtr">
														</div>
													</div>
													<div class="col-lg-6 ">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">Amount</div>

															<input type="text" class="form-control input-sm num TotalBold" disabled id="txtAmount">
														</div>
													</div>
												</div><br>

												<div class="row">

													<div class="col-lg-4">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">Sale Tax</div>

															<input type="text" class="form-control input-sm num"  id="txtSaleTax" style="width: 40px !important;" placeholder="%">
															<input type="text" class="form-control input-sm num TotalBold" disabled="" id="txtSaleTaxValue">
														</div>
													</div>

													<div class="col-lg-4">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">Income Tax</div>

															<input type="text" class="form-control input-sm num"  id="txtIncomeTax" style="width: 40px !important;" placeholder="%">
															<input type="text" class="form-control input-sm num TotalBold" disabled="" id="txtIncomeTaxValue">
														</div>
													</div>

													<div class="col-lg-4">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">NetAmount</div>

															<input type="text" class="form-control input-sm num TotalBold" disabled id="txtNetAmount">
														</div>
													</div>

												</div><br>

												<div class="row">

													<div class="col-lg-4 ">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">WrapBag</div>

															<input type="text" class="form-control input-sm num" id="bagwarp">
														</div>
													</div>

													

													<div class="col-lg-4">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">WeftBag</div>

															<input type="text" class="form-control input-sm num" id="bagwept">
														</div>
													</div>

												</div><br>

												<div class="row">

													<div class="col-lg-4 ">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">YarnBag</div>

															<input type="text" class="form-control input-sm num" disabled="" id="txtYarnBag">
														</div>
													</div>

													

													<div class="col-lg-4">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">YarnRate</div>
															<input type="text" class="form-control input-sm num" id="txtYarnRate">
															
														</div>
													</div>

													<div class="col-lg-4">
														<div class="input-group">
															<div class="input-group-addon txt-addon ">Amount</div>

															<input type="text" class="form-control input-sm num TotalBold" disabled="" id="txtYarnAmount">
														</div>
													</div>

												</div><br>

												<div class="row">
													<div class="col-lg-12">
														<div class="pull-right">
															<a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['fabricreceivevoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['fabricreceivevoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['fabricreceivevoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['fabricreceivevoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
															<a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
															<a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
															<a class="btn btn-sm btn-default  btnPrint"><i class="fa fa-print"></i> Print F9</a>
				<a class="btn btn-sm btn-default  btnprintAccount"><i class="fa fa-print"></i> Account Voucher</a>
															
															
														</div>
													</div> 	
												</div><br>
												<div class="row">
													<div class="col-lg-2 hide">
														<div class="form-group">                                                                
															<div class="input-group">
																<span class="switch-addon">Pre Bal?</span>
																<input type="checkbox" checked="" class="bs_switch" id="switchPreBal">
															</div>
														</div>
													</div>



													<div class="col-lg-2">

														<div class="input-group">
															<span class="switch-addon">Print Header?</span>
															<input type="checkbox" checked="" class="bs_switch" id="switchPrintHeader">

														</div>
													</div>
													<div class="col-lg-2"></div>
													<div class="col-lg-4">
														<div class="input-group">
															<span class="input-group-addon txt-addon" style="margin-left: 20px !important">User: </span>
															<input type="text" disabled="" class=" form-control"  id="txtUserName" >

														</div>
													</div>
													<div class="col-lg-4">
														<div class="input-group">
															<span class="input-group-addon txt-addon">Posting: </span>
															<input type="text" disabled="" class=" form-control"  id="txtPostingDate" >

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

												<div class="col-lg-5 hide"><div class="input-group">
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
												<div class="col-lg-7">
													<a class="btn btn-sm btn-primary" ><i class="fa fa-save"></i>Weaving Contract</a>

													<fieldset style=""><legend>Print Option</legend>
														<div class="form-check">
															<label class="form-check-label" for="exampleRadios2">

																<input class="form-check-input" type="radio" name="exampleRadios" value=""> PrintOut
																<input class="form-check-input" type="radio" name="exampleRadios" value=""> Prevoius
															</label>

															<label class="form-check-label" for="exampleRadios2">

																<input class="form-check-input position-static"  type="checkbox" id="blankCheckbox1" value="" aria-label="..."> Print Prevoius Balance
															</label>

															<label class="form-check-label" for="exampleRadios2">

																<input class="form-check-input position-static"  type="checkbox" id="blankCheckbox2" value="" aria-label="..."> With Header
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
																	<div class="input-group-addon txt-addon ">Total Meter</div>
																	<input type="text" class="form-control input-sm" disabled id="contqty">

																	<input type="hidden" class="form-control input-sm num" id="txtContractTotalBag">
																	<input type="hidden" class="form-control input-sm num" id="txtContractWrapBag">
																	<input type="hidden" class="form-control input-sm num" id="txtContractWeftBag">

																</div>
															</div>
														</div><br>

														
													

														<div class="row">
															<div class="col-lg-12">
																<div class="input-group">
																	<div class="input-group-addon txt-addon ">Receive Meter</div>
																	<input type="text" class="form-control input-sm" disabled id="txtReceiveMeter">
																</div>
															</div>
														</div><br>
														<div class="row">
															<div class="col-lg-12">
																<div class="input-group">
																	<div class="input-group-addon txt-addon ">Balance</div>
																	<input type="text" class="form-control input-sm" disabled id="balanceqty">
																</div>
															</div>
														</div>
													</fieldset>
												</div>


												<div class="col-lg-4 hide">
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