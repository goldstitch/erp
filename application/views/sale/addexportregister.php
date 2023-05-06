

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
;echo '<!-- main content -->
<div id="main_wrapper">
	<div class="page_bar">
		<div class="row">
			<div class="col-md-6">
				<h1 class="page_title"><i class="fa fa-file-text"></i>  Export Register</h1>
			</div>
			<div class="col-md-6">
				<div class="pull-right">
					<a href=\'\' class="btn btn-sm btn-default btnReset">
						<i class="fa fa-refresh"></i>
					Reset F5</a>
					<a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\'
                   data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\'
                   data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\'
                   data-insertbtn=\'';echo $vouchers['exportregistervoucher']['insert'];;echo '\'
                   data-updatebtn=\'';echo $vouchers['exportregistervoucher']['update'];;echo '\'
                   data-deletebtn=\'';echo $vouchers['exportregistervoucher']['delete'];;echo '\'
                   data-printbtn=\'';echo $vouchers['exportregistervoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
					<a class="btn btn-sm btn-default btnDelete" data-insertbtn=\'';echo $vouchers['item']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['item']['update'];;echo '\'><i class="fa fa-times"></i> Delete</a>
					<a class="btn btn-sm btn-default btnPrint" data-insertbtn=\'';echo $vouchers['item']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['item']['update'];;echo '\'><i class="fa fa-print "></i> Print</a>
					
					<!-- <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
					<a href=\'\' class="btn btn-sm btn-default btnPrint"> <i class="fa fa-print"></i>Print F9</a> -->
				</div>
			</div>
		</div>
	</div>
	<div class="page_content" style="margin-top:-40px;">
		<div class="container-fluid">
			<div class="col-md-12">
				<form action="">
					<ul class="nav nav-pills">
			            <li class="active"><a href="#additem" data-toggle="tab"><i class="fa fa-file-text"></i> Export Register</a></li>
			            <li><a href="#viewall" data-toggle="tab">View All</a></li>
			        </ul>
			        <div class="tab-content" style="margin-top:-14px;">
            			<div class="tab-pane active fade in" id="additem">
							<div class="row">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-12">
												<div class="row">
													<div class="col-lg-1">
															<label>Vr#</label>
															<input type="number" class="form-control num" id="txtId">
															<input type="hidden" id="txtMaxIdHidden">
															<input type="hidden" id="txtIdHidden">
															<input type="hidden" id="VoucherTypeHidden">

															<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
		                                                    <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
		                                                    <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
													</div>
													<div class="col-lg-3 col-lg-offset-1">
														<label>Date</label>
														<div class="input-group">
														<div class="input-group-addon" style="width:20px !important;"><i style=\'font-size:15px;\' class="fa fa-calendar"></i></div>
													       ';if ($vouchers['date_close']['insert'] == 1){;echo '                                                                <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                                                            ';}else{;echo '                                                                <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" readonly="">
                                                            ';};echo '													      
													    </div>
													</div>
													
												</div>
												<div class="row">
													<div class="col-lg-2">
														<label>Inv Date</label>
														<input class="form-control" type="date" id="inv_date" value="';echo date('Y-m-d');;echo '">
													</div>
													<div class="col-lg-1">
														<label>PI#</label>
														<input type="text" class="form-control" id="txtPiNo"/>
													</div>
													<div class="col-lg-2">
														<label>Advance Payment</label>
														<input type="text" class="form-control" id="txtAdvancePmnt"/>
													</div>
													<div class="col-lg-1 fa_wid">
														<label>Inv#</label>
														<input type="text" class="form-control" id="txtInvNo"/>
													</div>
													<div class="col-lg-1 fa_wid">
														<label>E-Form#</label>
														<input type="text" class="form-control" id="txtEFormNo"/>
													</div>
													<div class="col-lg-1 fa_wid">
														<label>CTN#</label>
														<input type="text" class="form-control" id="txtCtnNo"/>
													</div>
													<div class="col-lg-1 fa_wid">
														<label>Inv Value</label>
														<input type="text" class="form-control" id="txtInvValue"/>
													</div>
													<div class="col-lg-2">
														<label>LCL/FCL shipment</label>
														<input type="text" class="form-control" id="txtlcl"/>
													</div>
													<!-- <div class="col-lg-2">
														<label>Foreign Date</label>
														<input class="form-control" type="date" id="foreign_date" value="';
;echo '">
													</div> -->
												</div>
												<div class="row">
													<div class="col-lg-2">
														<label>Deliver Date</label>
														<input class="form-control" type="date" id="deliver_date" value="';echo date('Y-m-d');;echo '">
													</div>
													<div class="col-lg-1">
														<label>Container#</label>
														<input type="text" class="form-control" id="txtContainerNo"/>
													</div>
													<div class="col-lg-1">
														<label>BL#</label>
														<input type="text" class="form-control" id="txtBlNo"/>
													</div>
													<div class="col-lg-3">
														<label>Routing Bank</label>
														<input class=\'form-control\' type=\'text\' list="routing" id=\'routing_dropdown\'>
                                                        <datalist id=\'routing\'>
                                                            ';foreach ($categories as $category): ;echo '                                                                <option value="';echo $category['name'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist> 
													</div> 
													<div class="col-lg-3">
														<label>Payment Shipping</label>
														<input class=\'form-control\' type=\'text\' list="payment" id=\'payment_dropdown\'>
                                                        <datalist id=\'payment\'>
                                                            ';foreach ($categories as $category): ;echo '                                                                <option value="';echo $category['name'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist> 
													</div>
													<div class="col-lg-1">
														<label>DHL#</label>
														<input type="text" class="form-control" id="txtDhlNo"/>
													</div> 
												</div>
												<div class="row">
													<div class="col-lg-2">
														<label>GD Date</label>
														<input class="form-control" type="text" id="txtGdNo" value="">
														
													</div>
													<div class="col-lg-2">
														<label>Received Payment</label>
														<input type="text" class="form-control" id="txtRecPaymentNo"/>
													</div>
													<div class="col-lg-3">
														<label>Received Date</label>
														<input class="form-control" type="date" id="received_date" value="';echo date('Y-m-d');;echo '">
													</div>
													<div class="col-lg-3">
														<label>Transport</label>
														<input type="text" class="form-control" id="txtTransport"/>
													</div>
													<div class="col-lg-2">
														<label for="">&nbsp;</label>
														<div class="form-group">
															<label class="checkbox-inline">
																<input type="checkbox" id="txtTrnsprtStatus" value="option1"> Transport Status
															</label>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top:0px;">
													<div class="col-lg-2">
														<label>Sea Freight</label>
														<input type="text" class="form-control" id="txtFreight"/>
													</div>
													<div class="col-lg-2">
														<label for="">&nbsp;</label>
														<div class="form-group">
															<label class="checkbox-inline">
																<input type="checkbox" id="txtFreightStatus" value="option1"> Freight Status
															</label>
														</div>
													</div>
													<div class="col-lg-2">
														<label>For Warder</label>
														<input type="text" class="form-control" id="txtWarder"/>
													</div>
													<div class="col-lg-2">
														<label for="">&nbsp;</label>
														<div class="form-group">
															<label class="checkbox-inline">
																<input type="checkbox" id="txtWarderStatus" value="option1"> Warder Status
															</label>
														</div>
													</div>
													<div class="col-lg-2">
														<label>Clearing Agent</label>
														<input type="text" class="form-control" id="txtClringAgent"/>
													</div>
													<div class="col-lg-2">
														<label for="">&nbsp;</label>
														<div class="form-group">
															<label class="checkbox-inline">
																<input type="checkbox" id="txtAgentStatus" value="option1"> Agent Status
															</label>
														</div>
													</div>
												</div>
												<div class="row" style="margin-top:0px;">
													<div class="col-lg-3">
														<label>Rebate Doc</label>
														<input class=\'form-control\' type=\'text\' list="rebate" id=\'rebate_dropdown\'>
                                                        <datalist id=\'rebate\'>
                                                            ';foreach ($categories as $category): ;echo '                                                                <option value="';echo $category['name'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist> 
													</div>
													<div class="col-lg-3">
														<label>Sale Tax Doc</label>
														<input class=\'form-control\' type=\'text\' list="saletax" id=\'saletax_dropdown\'>
                                                        <datalist id=\'saletax\'>
                                                            ';foreach ($categories as $category): ;echo '                                                                <option value="';echo $category['name'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist>  
										
													</div>
													<div class="col-lg-3">
														<label>Yarn</label>
                                                        <input class=\'form-control\' type=\'text\' list="yarn" id=\'Yyrn_dropdown\'>
                                                        <datalist id=\'yarn\'>
                                                            ';foreach ($categories as $category): ;echo '                                                                <option value="';echo $category['name'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist>  
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="pull-right" style="margin-top:-30px;">
									<a href=\'\' class="btn btn-sm btn-default btnReset">
										<i class="fa fa-refresh"></i>
									Reset F5</a>
									<a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\'
                   data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\'
                   data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\'
                   data-insertbtn=\'';echo $vouchers['exportregistervoucher']['insert'];;echo '\'
                   data-updatebtn=\'';echo $vouchers['exportregistervoucher']['update'];;echo '\'
                   data-deletebtn=\'';echo $vouchers['exportregistervoucher']['delete'];;echo '\'
                   data-printbtn=\'';echo $vouchers['exportregistervoucher']['print'];;echo '\'><i class="fa fa-save"></i> Save F10</a>
									<a class="btn btn-sm btn-default
									 btnDelete" data-insertbtn=\'';echo $vouchers['item']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['item']['update'];;echo '\'><i class="fa fa-times"></i> Delete</a>
									<a class="btn btn-sm btn-default btnPrint" data-insertbtn=\'';echo $vouchers['item']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['item']['update'];;echo '\'><i class="fa fa-print "></i> Print</a>
								</div>
							</div>    <!-- end of a href=\'\' row -->
            			</div>
            			<div class="tab-pane fade" id="viewall" style="margin-left:-11px;">
            				<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<table class="table table-striped table-hover ar-datatable">
												<thead>
													<tr>
														<th style=\'background: #368EE0;\' class=\'text-center\'>Sr#</th>
														<th style=\'background: #368EE0;\'>Tab 1</th>
														<th style=\'background: #368EE0;\'>Tab 2</th>
														<th style=\'background: #368EE0;\'>Tab 3</th>
														<th style=\'background: #368EE0;\'>Tab 4</th>
														<th style=\'background: #368EE0;\'>Action</th>
													</tr>
												</thead>
												<tbody>
													';$counter = 1;foreach ($exports as $export): ;echo '														<tr class=\'tebl-row\'>
															<td style="width:10px !important; " class=\'text-center\'>';echo $counter++;;echo '</td>
															<td>
																<ul class=\'tabl-ul\'>
																	<li><b>Inv Date :</b> ';echo $export['inv_date'];;echo '</li>
																	<li><b>PI# :</b> ';echo $export['pi'];;echo '</li>
																	<li><b>Advance Payment :</b> ';echo $export['advance'];;echo '</li>
																	<li><b>Inv# :</b> ';echo $export['inv_no'];;echo '</li>
																	<li><b>E-Form# :</b> ';echo $export['eform'];;echo '</li>
																	<li><b>CTN# :</b> ';echo $export['ctn'];;echo '</li>
																</ul>
															</td>
															<td>
																<ul class=\'tabl-ul\'>
																	<li><b>Inv Value :</b> ';echo $export['value_amount'];;echo '</li>
																	<li><b>Deliver Date :</b> ';echo $export['delivery_date'];;echo '</li>
																	<li><b>Container# :</b> ';echo $export['container_no'];;echo '</li>
																	<li><b>BL# :</b> ';echo $export['bl_no'];;echo '</li>
																	<li><b>Routing Bank :</b> ';echo $export['routing_bank'];;echo '</li>
																	<li><b>Payment Shipping :</b> ';echo $export['payment_doc'];;echo '</li>
																</ul>
															</td>
															<td>
																<ul class=\'tabl-ul\'>
																	<li><b>DHL# :</b> ';echo $export['dhl_no'];;echo '</li>
																	<li><b>GD# :</b> ';echo $export['gd_date'];;echo '</li>
																	<li><b>Received Payment :</b> ';echo $export['received_payment'];;echo '</li>
																	<li><b>Transport :</b> ';echo $export['transport'];;echo '</li>
																	<li><b>Sea Freight :</b> ';echo $export['sea_freight'];;echo '</li>
																	<li><b>For Warder :</b> ';echo $export['forwader'];;echo '</li>
																</ul>
															</td>
															<td>
																<ul class=\'tabl-ul\'>
																	<li><b>Clearing Agent :</b> ';echo $export['clrearing_agent'];;echo '</li>
																	<li><b>Rebate Doc :</b> ';echo $export['rebate_doc'];;echo '</li>
																	<li><b>Sale Tax Doc :</b> ';echo $export['saletax_doc'];;echo '</li>
																	<li><b>Yarn :</b> ';echo $export['yarn'];;echo '</li>
																</ul>
															</td>
															<td><a href="" class="btn btn-sm btn-default btn-edit-export" data-export="';echo $export['id'];;echo '"><span class="fa fa-edit"></span></a></td>
														</tr>
													';endforeach ;echo '												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

            			</div>
						<!-- end view all -->

				</form>   <!-- end of form -->

			</div>  <!-- end of col -->
		</div>  <!-- end of container fluid -->
	</div>   <!-- end of page_content -->
</div>

';
?>