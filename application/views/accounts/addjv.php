

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
<script id="voucher-total-template" type="text/x-handlebars-template">
	<tr class="group-total-row tfoot_tbl">
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>Total Balance</td>
		<td style="text-align: right !important;">{{net_balance}}</td>
		<td></td>
	</tr>
</script>
<script id="voucher-item-template" type="text/x-handlebars-template">
	<tr>
		<td class="dcno" data-dcno={{dcno1}} data-wo={{wo}} >{{dcno}}</td>
		<td>{{date}}</td>
		<td class="account" data-pid={{pid}} >{{account}}</td>
		<td>{{days_passed}}</td>
		<td>{{due_date}}</td>
		<td style="text-align: right !important;">{{invoice_amount}}</td>
		<td style="text-align: right !important;">{{paid}}</td>
		<td class="balance" style="text-align: right !important;">{{balance}}</td>
		<td  style="text-align: right !important;"><input type="checkbox" id="chk" class="status_chkbx" style=\'height: 30px !important;width: 30px !important;\'/> </td>
	</tr>
</script>




<!-- main content -->
<div id="main_wrapper">
	<div id="AccountAddModel" class="modal hide fade"  role="dialog" aria-labelledby="AccountAddModelLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header" style="background:#76c143;color:white;padding-bottom:20px;">
				<button type="button" class="modal-button cellRight modal-close pull-right btn-close" data-dismiss="modal"><span class="fa fa-times" style="font-size:26px; "></span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="AccountAddModelLabel">Add New Account</h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row-fluid">
						<div class="col-lg-9 col-lg-offset-1">
							<form role="form">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-6">
											<label for="exampleInputEmail1">Name</label>
											<input type="text" id="txtAccountName" class="form-control" placeholder="Account Name" maxlength="50" tabindex="101">
										</div>
										<div class="col-lg-6">
											<label>Acc Type3</label>
											<select class="form-control input-sm select2"  id="txtLevel3" tabindex="102">
												<option value="" disabled="" selected="">Choose Account Type</option>
												';foreach ($l3s as $l3): ;echo '													<option value="';echo $l3['l3'];;echo '" data-level2="';echo $l3['level2_name'];;echo '" data-level1="';echo $l3['level1_name'];;echo '">';echo $l3['level3_name'] ;echo '</option>
												';endforeach ;echo '											</select>
										</div>
										<div class="col-lg-12">
											<span><b>Type 2 &rarr; </b><span id="txtselectedLevel2"> </span></span> <span><b>Type 1 &rarr; </b><span id="txtselectedLevel1"> </span></span>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>       
			</div>
			<div class="modal-footer">
				<div class="pull-right">
					<a class="btn btn-success btnSaveM btn-sm" tabindex="103" data-insertbtn="1"><i class="fa fa-save"></i> Save</a>
					<a class="btn btn-warning btnResetM btn-sm" tabindex="104"><i class="fa fa-refresh"></i> Reset</a>
					<a class="btn btn-danger btn-sm" data-dismiss="modal" tabindex="105" ><i class="fa fa-times"></i> Close</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="page_bar">
	<div class="row">
		<div class="col-md-4">
			<h1 class="page_title">Journal Voucher</h1>
		</div>
		<div class="col-lg-8">
			<div class="pull-right">
			<h1 id="payment_no"></h1>
			<a href=\'\' class="btn btn-default btnpost"><i><span class="badge">';echo $no_1;;echo '</span></i>Unpost</a>
		     	<a href=\'\' class="btn btn-default btnpost"><i></i>Post</a>
				<a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
				<a href=\'\' class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\'  data-insertbtn=\'';echo $vouchers['jvvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['jvvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['jvvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['jvvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
				<a href=\'\' class="btn btn-default btnDelete" ><i class="fa fa-trash-o"></i> Delete F12</a>
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
					<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li ><a href="#" class="btnprintAccount"> Account Prints</a></li>
						<!-- <li ><a href="#" class="btnprint">With header</li> -->
							<!-- <li ><a href="#" class="btnprintwithOutHeader">With out header</li> -->
							</ul>
						</div>


						<!-- <a href=\'\' class="btn btn-default btnPartySearch"><i class="fa fa-search"></i> Account Search F1</a> -->
						<a href="#party-lookup" data-toggle="modal" class="btn btn-default fat-btn"><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
					</div>
				</div> 	<!-- end of col -->
			</div>
		</div>

		<div class="page_content">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<div class="row">
							<div class="col-lg-12">

								<ul class="nav nav-pills">
									<li class="active"><a href="#addupdateJV" data-toggle="tab">Add/Update JV</a></li>
									<li><a href="#searchcash" data-toggle="tab">Search JV</a></li>
								</ul>

								<div class="tab-content">
									<div class="tab-pane active" id="addupdateJV">
										<div class="panel panel-default">
											<div class="panel-body">

												<form action="">

													<div class="row">
														<div class="col-lg-2">
															<div class="input-group">
																<span class="input-group-addon id-addon VoucherNoLable">Sr#</span>
																<input type="number" id="txtId" class="form-control input-sm  num txtidupdate VoucherNo" data-txtidupdate=';
;echo '/>
																<input type="hidden" id="txtMaxIdHidden"/>
																<input type="hidden" id="txtIdHidden"/>
																<input type="hidden" id="voucher_type_hidden"/>

																<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
																<input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
																<input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

															</div>
														</div>

														<div class="col-lg-2"></div>

														<div class="col-lg-3">
															<div class="input-group">
																<span class="input-group-addon txt-addon VoucherNoLable">Date</span>
																<input class="form-control input-sm" type="date" id="cur_date" value="';echo date('Y-m-d');;echo '" >
																<input class="form-control input-sm hidden" type="date" id="chk_date" value="';echo date('Y-m-d');;echo '" >

															</div>
														</div>
														<div class="col-lg-2"></div>
														<div class="col-lg-2">
															<a href=\'\'  class="btn btn-default btnInvoice" ><i class="fa fa-book fa-fw"></i> Pending Invoice F7</a>
														</div>



													</div>

													<div class="row"></div>
													<div class="container-wrap">
														<div class="row">
															<div class="col-lg-3" >
																<label for="">Party Name <img id="imgPartyLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style ="    font-size: 16px !important;"id="partyBalance"></span></label>
																<div class="input-group" >
																	<input type="text" class="form-control" id="txtPartyId">
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


																	<a  tabindex="-1" class="btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
																	data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)"> <span class="side_icon glyphicon glyphicon-user">+</a>
																	</div>
																</div>

																<div class="col-lg-2" >
																	<label>Description</label>
																	<input type="text" id="txtRemarks" class="form-control input-sm " placeholder="Remarks"/>
																</div>

																<div class="col-lg-1" >
																	<label>Inv/Chq#</label>
																	<input type="text" id="txtInvNo" placeholder=\'Inv#\' class="form-control input-sm "/>
																</div>
																<div class="col-lg-1" >
																	<label>Wo#</label>
																	<input type="text" id="txtwoNo" placeholder=\'Wo#\' class="form-control input-sm "/>
																</div>

																<div class="col-lg-2" >
																	<label>Debit</label>
																	<input type="text" id="txtDebit" placeholder=\'Debit\' class="form-control input-sm  num text-right"/>
																</div>

																<div class="col-lg-2" >
																	<label>Credit</label>
																	<input type="text" id="txtCredit" placeholder=\'Credit\' class="form-control input-sm  num text-right"/>
																</div>

																<div class="col-lg-1">
																	<label>Add</label>
																	<a href="" class="btn btn-sm btn-primary" id="btnAddCash"><i class="fa fa-arrow-circle-down"></i></a>
																</div>
															</div>
														</div>
														<div class="row"></div>


														<div class="row">
															<div class="col-lg-12">
																<table class="table table-striped" id="cash_table">
																	<thead>
																		<tr>
																			<th>Sr#</th>

																			<th>AccId</th>
																			<th>Account Name</th>
																			<th>Remarks</th>
																			<th>Inv#</th>
																			<th>Wo#</th>
																			<th class="text-right">Debit</th>
																			<th class="text-right">Credit</th>
																			<th class=\'text-center\'>Actions</th>
																		</tr>
																	</thead>
																	<tbody>

																	</tbody>
																	<tfoot class="tfoot_tbl">
																		<tr>
																			<td class="text-right" colspan="6">Totals</td>
																			<td class="text-right txtNetDebit"></td>
																			<td class="text-right txtNetCredit"></td>
																			<td></td>
																			<td></td>
																		</tr>
																	</tfoot>
																</table>
															</div>
														</div>
														<div id="party-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
															<div class="modal-dialog modal-lg">
																<div class="modal-content">
																	<div class="modal-header" style="background:#64b92a !important; color:white !important;padding-bottom:20px !important;">
																		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
																		<h3 id="myModalLabel">Party Lookup</h3>
																	</div>

																	<div class="modal-body">
																		<table class="table table-striped modal-table" id ="tblAccounts">

																			<thead>
																				<tr style="font-size:16px;">
																					<th>Id</th>
																					<th>Name</th>
																					<th>Mobile</th>
																					<th>Address</th>
																					<th style=\'width:3px;\'>Actions</th>
																				</tr>
																			</thead>
																			<tbody>

																			</tbody>
																		</table>
																	</div>
																	<div class="modal-footer">

																		<button class="btn btn-primary" data-dismiss="modal">Cancel</button>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-2">
																<div class="form-group">                                                                
																	<div class="input-group">
																		<span class="switch-addon">Print Header?</span>
																		<input type="checkbox" checked="" class="bs_switch" id="switchPrintHeader">
																	</div>
																</div>
															</div>
															<div class="col-lg-1"></div>
															<div class="col-lg-3">
																<div class="input-group">
																	<span class="input-group-addon">User: </span>
																	<input type="text" class=" form-control"  id="txtUserName" >

																</div>
															</div>
															<div class="col-lg-1"></div>

															<div class="col-lg-3">
																<div class="input-group">
																	<span class="input-group-addon">Posting Date: </span>
																	<input type="text" class=" form-control"  id="txtPostingDate" >

																</div>
															</div> 

														</div>

														<div class="row">
															<div class="col-lg-12">
																<div class="pull-right">
																	<a href=\'\' class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['jvvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['jvvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['jvvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['jvvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
																	<a href=\'\' class="btn btn-default btnDelete" ><i class="fa fa-trash-o"></i> Delete F12</a>
																	<a href=\'\' class="btn btn-default btnPrint" ><i class="fa fa-print"></i> Print F9</a>
																	<a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
																	<!-- <a href=\'\' class="btn btn-default btnPartySearch"><i class="fa fa-search"></i> Account Search F1</a> -->
																	<a href="#party-lookup" data-toggle="modal" class="btn btn-default fat-btn btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
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
																<input class="form-control input-sm  ts_datepicker" type="text" id="from_date">
															</div>
														</div>
														<div class="col-lg-3">
															<div class="input-group">
																<span class="input-group-addon">To</span>
																<input class="form-control input-sm  ts_datepicker" type="text" id="to_date">
															</div>
														</div>

														<div class="col-lg-2">
															<a href=\'\' class="btn btn-sm btn-default btnSearch"><i class="fa fa-search"></i> Search</a>
														</div>
													</div>

													<div class="row">
														<div class="col-lg-12">
															<table class="table table-striped" id="search_cash_table">
																<thead>
																	<tr>
																		<th>Vr#</th>
																		<th>VrDate</th>
																		<th>Party Name</th>
																		<th>Debit</th>
																		<th>Credit</th>
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
		</div>

<div id="invoice-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row">
						<div class="col-lg-5">
							<h3 id="myModalLabel">Invoice Lookup</h3>
						</div>
						
						<div class="col-lg-2">
							<a href=\'\'  class="btn btn-default btnInvoice" ><i class="fa fa-book fa-fw"></i> Search</a>
						</div>
						

						<div class="col-lg-3">
							<label for="cpv" class="radio cpvRadio">
								<input type="radio" id="cpv" class="cpv" name="vrEtype" value="cpv"  checked="checked">
								Payable
							</label>
							<label for="crv" class="radio crvRadio">
								<input type="radio" id="crv" class="crv" name="vrEtype" value="crv">
								Receiveable
							</label>
						</div>
					</div>

				</div>


				<div class="modal-body">
					<table id="datatable_example" class="table full table-bordered table-striped table-hover ">
						<thead class="dthead">
							<tr >
								<th>Vr#</th>
								<th>Date</th>
								<th>Account</th>
								<th>Days Passed</th>
								<th>Aging Date</th>
								<th>Invoice Amount</th>
								<th>Paid Amount</th>
								<th>Balance</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody class="saleRows">

						</tbody>
						<tfoot class="dtFooter">

						</tfoot>
					</table>
				</div>
				<div class="modal-footer">
					<div class="col-lg-3">
						<button class="btn btn-primary" data-dismiss="modal">Cancel</button>
						<button class="btn btn-primary SelectBtn" >Select</button>
					</div>
					<div class="col-lg-4 pull-right">
						<div class="input-group">
							<span class="input-group-addon">Total Amount:</span>
							<input type="text" id="txtNetAmountInvoice" class="form-control"  style="font-weight:bolder !important; font-size:20px !important;" tabindex="-1"/>
						</div>
					</div>                      	
				</div>
			</div>
		</div>
	</div>';
?>