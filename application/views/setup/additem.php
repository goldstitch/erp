

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
				<h1 class="page_title">Add New Item</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">

				<form action="">



					<div class="tab-content">
						<div class="tab-pane active fade in" id="additem">

							<div class="row">

								<div class="panel panel-default">
									<div class="panel-body">
										<!-- <button type="button" class="alert-message" data-dismiss="alert">
										  <span aria-hidden="true">&times;</span>
										  <span class="sr-only">Close</span>
										</button> -->
										<div class="row">
											
											<div class="col-lg-12">

												<div class="row">
													<div class="col-lg-2">
														<label >Id</label>
														<input type="number" class="form-control input-sm num VoucherNo" id="txtId">
														<input type="hidden" id="txtMaxIdHidden">
														<input type="hidden" id="txtIdHidden">
														<input type="hidden" id="VoucherTypeHidden">

														<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
														<input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
														<input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
														<input type="hidden" name="txtcomponyName" id="txtcomponyName" value="';echo $this->session->userdata('barcode_print');;echo '">

														<input type="hidden" id="inventory_id" value="';echo $setting_configur[0]['inventory_id'];;echo '">

														<input type="hidden" id="income_id" value="';echo $setting_configur[0]['income_id'];;echo '">
														<input type="hidden" id="cost_id" value="';echo $setting_configur[0]['cost_id'];;echo '">

														<input type="hidden" id="cost_name" value="';echo $setting_configur[0]['cost_name'];;echo '">

														<input type="hidden" id="income_name" value="';echo $setting_configur[0]['income_name'];;echo '">

														<input type="hidden" id="inventory_name" value="';echo $setting_configur[0]['inventory_name'];;echo '">
														
													</div>
													<div class="col-lg-1">
													</div>
													<div class="col-lg-2">
														<label>Is active?</label>
														<input type="checkbox" checked="" class="bs_switch active_switch" id="active">
													</div>
													<div class="col-lg-2">
														<label>Is Inventory Item?</label>
														<input type="checkbox" checked="" class="bs_switch active_Inventory_switch" id="Inventory_active">
													</div>
													<div class="col-lg-2">
														<label>Date</label>
														<input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
													</div>
													<div class="col-lg-3" >
														<label for="">Quick Search<img id="imgItemLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>

														<input type="text" class="form-control" id="txtItemId">
														<input id="hfItemId" type="hidden" value="" />
													</div>

													

													<div class="col-lg-3 hide">
														<label>Item Code</label>
														<select class="form-control input-sm select2" id="ic_dropdown">
															<option value="" disabled="" selected="">Choose Item Code</option>
															';foreach ($items as $item): ;echo '																<option value="';echo $item['item_id'];;echo '">';echo $item['item_code'];;echo '</option>
															';endforeach ;echo '														</select>
													</div>
													
												</div>

												<div class="row">
													<div class="col-lg-3">
														<label>Category</label>
														<div class="input-group" >
															<select class="form-control input-sm select2" id="category_dropdown" >
																<!-- <option value="" disabled="" selected="">Choose Category</option>
																';foreach ($categories as $category): ;echo '																	<option value="';echo $category['catid'];;echo '">';echo $category['name'];;echo '</option>
																	';endforeach ;echo ' -->
																</select>
																<a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;height: 33px !important;" id="A2" data-target="#CategoryModel" data-toggle="modal" href="#CategoryModel" rel="tooltip"
																data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
															</div>
														</div>
														<div class="col-lg-3">
															<label>Sub Category</label>
															<div class="input-group" >
																<select class="form-control input-sm select2" id="subcategory_dropdown">
																<!-- <option value="" selected="">Choose Sub Category</option>
																';foreach ($subcategories as $subcategory): ;echo '																	<option value="';echo $subcategory['subcatid'];;echo '">';echo $subcategory['name'];;echo '</option>
																	';endforeach ;echo ' -->
																</select>
																<a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;height: 33px !important;" id="A2" data-target="#SubCategory" data-toggle="modal" href="#SubCategory" rel="tooltip"
																data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
															</div>
														</div>

														
														<div class="col-lg-3">
															<label>Brand</label>
															<div class="input-group" >
																<select class="form-control input-sm select2" id="brand_dropdown">
																<!-- <option value="" selected="">Choose brand</option>
																';foreach ($brands as $brand): ;echo '																	<option value="';echo $brand['bid'];;echo '">';echo $brand['name'];;echo '</option>
																	';endforeach ;echo ' -->
																</select>
																<a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;height: 33px !important;" id="A2" data-target="#Brand" data-toggle="modal" href="#Brand" rel="tooltip"
																data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
															</div>
														</div>
														<div class="col-lg-3">
															<label>Made</label>
															<div class="input-group" >
																<select class="form-control input-sm select2" id="made_dropdown">
																<!-- <option value="" selected="">Choose made</option>
																';foreach ($mades as $made): ;echo '																	<option value="';echo $made['made_id'];;echo '">';echo $made['name'];;echo '</option>
																	';endforeach ;echo ' -->
																</select>
																<a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;height: 33px !important;" id="A2" data-target="#madeModel" data-toggle="modal" href="#madeModel" rel="tooltip"
																data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
															</div>
														</div>
														
													</div>

													<div class="row">
														
														
														<div class="col-lg-2" >
															<label>Gender</label>
															<input type="text" list=\'modellist\' class="form-control input-sm" id="txtModel"/>
															<datalist id=\'modellist\'>
																';foreach ($models as $model): ;echo '																	<option value="';echo $model['model'];;echo '">
																	';endforeach ;echo '																</datalist>
															</div>
															<div class="col-lg-1">
																<label>PO#</label>
																<input  list=\'sizelist\' class="form-control input-sm" type="text" id="txtPacking">
																<datalist id=\'sizelist\'>
																	';foreach ($sizes as $model): ;echo '																		<option value=\'';echo $model['size'];;echo '\'>
																		';endforeach ;echo '																	</datalist>
																</div>
																<div class="col-lg-1">
																	<label>Article</label>
																	<input type="text"  class="form-control input-sm" id="txtShortCode"/>


																</div>
																<div class="col-lg-2">
																	<label>BarCode</label>
																	<input type="text" class="form-control input-sm" id="txtItemBarCode" />
																</div>
																<div class="col-lg-3">
																	<label>Description</label>
																	<input type="text" class="form-control input-sm" id="txtDescription" />
																	<input type="hidden" class="form-control input-sm" id="txtDescriptionHidden" />
																</div>
																<div class="col-lg-3" >
																	<label for="">Supplier <img id="imgPartyLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
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

																	</div>

																</div>
																<div class="col-lg-6 hidden">
																	<label>Mulitpul Des</label>
																	<input type="text" class="form-control input-sm" id="txtMultipul_Des" />
																	<input type="hidden" class="form-control input-sm" id="txtDescriptionHidden" />
																</div>

																<div class="col-lg-3 hidden">
																	<label>Urdu Description</label>
																	<input type="text" class="form-control input-sm txtUrduRight" id="txtUrduName">

																</div>
															</div>

															<div class="row hide">
																<select class="form-control input-sm" id="alldescription_dropdown">
																	';foreach ($items as $item): ;echo '																		<option value="';echo $item['description'];;echo '">';echo $item['description'];;echo '</option>
																	';endforeach ;echo '																</select>
															</div>

															<div class="row hide">
																<select class="form-control input-sm" id="allcodes_dropdown">
																	';foreach ($items as $item): ;echo '																		<option value="';echo $item['item_code'];;echo '">';echo $item['item_code'];;echo '</option>
																	';endforeach ;echo '																</select>
															</div>
															<div class="row">
																<div class="col-lg-4">
																	<label>Size</label>
																	<div class="input-group" >
																		<select class="form-control input-sm select2" multiple="true" id="Size_dropdown" >

																			';foreach ($Sizes as $Size): ;echo '																				<option value="';echo $Size['size_id'];;echo '">';echo $Size['name'];;echo '</option>
																			';endforeach ;echo '																		</select>
																		<a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;height: 33px !important;" id="A2" data-target="#SizeModel" data-toggle="modal" href="#SizeModel" rel="tooltip"
																		data-placement="top" data-original-title="Add Size" data-toggle="tooltip" data-placement="bottom" title="Add New Size">+</a>
																	</div>
																</div>

																<div class="col-lg-5">
																	<label>Color</label>
																	<div class="input-group" >
																		<select class="form-control input-sm select2" multiple="true" id="Color_dropdown" >

																			';foreach ($Colors as $Color): ;echo '																				<option value="';echo $Color['color_id'];;echo '">';echo $Color['name'];;echo '</option>
																			';endforeach ;echo '																		</select>
																		<a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;height: 33px !important;" id="A2" data-target="#ColorModel" data-toggle="modal" href="#ColorModel" rel="tooltip"
																		data-placement="top" data-original-title="Add color" data-toggle="tooltip" data-placement="bottom" title="Add New Color">+</a>
																	</div>
																</div>
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
															<input type="text" class="form-control input-sm" id="rate" />
														    </div>

															<div class="col-lg-2">
															<label>Unit QTY</label>
															<input type="text" class="form-control input-sm" id="qty" />
														    </div>

															
															<div class="col-lg-2">
															<label>Per Unit Price</label>
															<input type="text" class="form-control input-sm" id="per_unit_rate" readonly=""/>
														    </div>


															<div class="col-lg-2" >
																<label>Copy From Id</label>
																<input type="text" class="form-control input-sm num" id="txtIdCopy">
															</div>



														</div>

														<div class="col-lg-3" >
															<div class="row" >
																
															</div>
														</div>


														<div class="col-lg-3 hide">
															<div style="background: #F5F6F7;padding: 15px;border: 1px solid #ccc;box-shadow: 1px 1px 1px #000;">
																<div class="row">
																	<div class="col-lg-12">
																		<div class="studentImageWrap">
																			<img src="';echo base_url('assets/img/blank_image.png');;echo '" alt="Item Image" style="margin: auto;display: block;" id="itemImageDisplay">
																		</div>
																	</div>
																</div>

																<div class="row">
																	<div class="col-lg-12">
																		<input type="file" id="itemImage">
																	</div>
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>

										</div>

										<div class="row">
											<div class="panel panel-default">
												<div class="panel-body">


													<div class="row">
														<div class="col-lg-2">
															<label>Min Level</label>
															<input class="form-control input-sm num" type="text" id="txtMinLevel">
														</div>
														<div class="col-lg-2">
															<label>Max Level</label>
															<input class="form-control input-sm num" type="text" id="txtMaxLevel">
														</div>
														<div class="col-lg-1">
															<label>UOM</label>
															<input type="text" class=\'form-control input-sm\' placeholder="Uom" id="uom_dropdown" list=\'uoms\'>
															<datalist id="uoms">
																';foreach ($uoms as $uom): ;echo '																	';if ($uom['uom'] !== ''): ;echo '																		<option value="';echo $uom['uom'];;echo '">
																		';endif ;echo '																	';endforeach ;echo '																</datalist>
															</div>
															<div class="col-lg-1">
																<label>Sub UOM</label>
																<input type="text" class=\'form-control input-sm\' placeholder="SubUom" id="sub_uom_dropdown" list=\'sub_uoms\'>
																<datalist id="sub_uoms">
																	';foreach ($sub_uoms as $uom): ;echo '																		';if ($uom['uom'] !== ''): ;echo '																			<option value="';echo $uom['sub_uom'];;echo '">
																			';endif ;echo '																		';endforeach ;echo '																	</datalist>
																</div>

																<div class="col-lg-1">
																	<label>Gr Weight</label>
																	<input class="form-control input-sm num" type="text" id="txtGrWeight">
																</div>
																
																<div class="col-lg-1">
																	<label>Pur Price</label>
																	<input class="form-control input-sm num" type="text" id="txtPurPrice" >
																</div>
																<div class="col-lg-2 hide">
																	<label>Net Weight</label>
																	<input class="form-control input-sm num" type="text" id="txtNetWeight">
																</div>
																


																<div class="col-lg-2">
																	<label>Retail Price</label>
																	<input class="form-control input-sm num" type="text" id="txtSalePrice" >
																</div>

																<div class="col-lg-2">
																	<label>Pcs Rate</label>
																	<input class="form-control input-sm num" type="text" id="txtDiscount">
																</div>
															</div>


															<div class="row">


																<div class="col-lg-2">
																	<label>Wholesale Price</label>
																	<input class="form-control input-sm num" type="text" id="txtComm">
																</div>
																<div class="col-lg-2">
																	<label>Sale Price 3</label>
																	<input class="form-control input-sm num" type="text" id="txtPackings">
																</div>
																<div class="col-lg-2 hide">
																	<label>Sale Price 4</label>
																	<input class="form-control input-sm num" type="text" id="txtPackings">
																</div>

																<div class="col-lg-2">
																	<label>Sale Discount%</label>
																	<input class="form-control input-sm num" type="text" id="txtDiscountPer">
																</div>
																<div class="col-lg-2">
																	<label>Purchase Discount%</label>
																	<input class="form-control input-sm num" type="text" id="txtPurDiscountPer">
																</div>
																<div class="col-lg-4">
																	<label>Remarks</label>
																	<input type="text" class="form-control input-sm" id="txtRemarks"/>
																</div> 

															</div>
															<div class="row">
																<div class="col-lg-2">
																	<label>StockQty</label>
																	<input class="form-control input-sm num" disabled="" type="text" id="txtStockQty">
																</div>
																<div class="col-lg-2">
																	<label>AvgRate</label>
																	<input class="form-control input-sm num" disabled="" type="text" id="txtAvgRate">
																</div>
															</div>

															<div class="row">

																<legend style=\'margin-top: 30px;\'>Accounts Transactions</legend>


																<div class="col-lg-4">

																	<label for="">Inventory <img id="imgInventoryLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
																	<input type="text" class="form-control" id="txtInventoryId">
																	<input id="hfInventoryId" type="hidden" value="" />
																	<input id="hfInventoryName" type="hidden" value="" />


																</div>

																<div class="col-lg-4">
																	<label for="">Income <img id="imgIncomeLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
																	<input type="text" class="form-control" id="txtIncomeId">
																	<input id="hfIncomeId" type="hidden" value="" />
																	<input id="hfIncomeName" type="hidden" value="" />



																</div>

																<div class="col-lg-4">
																	<label for="">Cost <img id="imgCostLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
																	<input type="text" class="form-control" id="txtCostId">
																	<input id="hfCostId" type="hidden" value="" />
																	<input id="hfCostName" type="hidden" value="" />
																</div>


															</div>
														</div>
													</div>
												</div>
												

											</div>
										</div>
									</div>

									<div class="row hide">
										<div class="panel panel-default">
											<div class="panel-body">


												<div class="row">
													<div class="col-lg-4">
														<div class="input-group">
															<span class="input-group-addon">Debit</span>
															<select class="form-control input-sm" id="debit_dropdown">
																<option value="" disabled="" selected="">Choose debit party</option>
																';foreach ($parties as $party): ;echo '																	<option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
																';endforeach ;echo '															</select>
														</div>
													</div>

													<div class="col-lg-4">
														<div class="input-group">
															<span class="input-group-addon">Credit</span>
															<select class="form-control input-sm" id="credit_dropdown">
																<option value="" disabled="" selected="">Choose credit party</option>
																';foreach ($parties as $party): ;echo '																	<option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
																';endforeach ;echo '															</select>
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
									<div id="item-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header" style="background:#64b92a !important; color:white !important;padding-bottom:20px !important;"> 
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<h3 id="myModalLabel">item Lookup</h3>
												</div>

												<div class="modal-body">
													<table class="table table-striped modal-table" id="tbItems">


														<thead>
															<tr style="font-size:16px;">
																<th>Id</th>
																<th>Short</th>
																<th>Description</th>
																<th>Category</th>
																<th>Brand</th>
																<th>Made</th>
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
									<div id="print-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<h3 id="myModalLabel">How Many Barcode Your Want To Print</h3>
												</div>

												<div class="modal-body">
													<div class="col-lg-12">
														<label>How many prints do you want.?</label>
														<input type="text" class="form-control input-sm num" id="txtprint">
													</div>
												</div>
												<div class="modal-footer">
													<!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
													<button class="btn btn-primary btnPrint" data-dismiss="modal">Ok</button>
													<button class="btn btn-primary" data-dismiss="modal">Cancel</button>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="pull-right">
											<a class="btn btn-sm btn-default btnSave" data-insertbtn=\'';echo $vouchers['item']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['item']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['item']['delete'];;echo '\' tabindex=\'6\'><i class="fa fa-save"></i> Save F10</a>
											<a href=\'\' class="btn btn-sm btn-default btnReset">
												<i class="fa fa-refresh"></i>
											Reset F5</a>
											<a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>

											<a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchitem "><i class="fa fa-search"></i>Item Lookup F2</a>
											<!-- <a href=\'\' class="btn btn-sm btn-default btnPrint"> <i class="fa fa-print"></i>Print F9</a> -->
											<a href="#print-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchitem"><i class="fa fa-barcode"></i>Barcode F9</a>
											<a href="#Image-lookup" data-toggle="modal" class="btn btn-sm btn-default  btnattachimage"><i class="fa fa-camera"></i>Attach Image</a>
										</div>

									</div>    <!-- end of a href=\'\' row -->

									<div class="row">
										<div class="col-lg-3">
											<div class="input-group">
												<span class="input-group-addon">User: </span>
												<input type="text" disabled="" class=" form-control"  id="txtUserName" >

											</div>
										</div>
										

										<div class="col-lg-3">
											<div class="input-group">
												<span class="input-group-addon">Posting Date: </span>
												<input type="text" disabled="" class=" form-control"  id="txtPostingDate" >

											</div>
										</div> 
									</div>

									<div class="row">
										<div class="col-lg-4">

										<label>Avg Rate Detail</label>
										<table class="table table-striped Lstocks_table">
											<thead>
												<tr>
													<th class="text-left">Sr#</th>

													<th class="text-left">Item</th>
													<th class="text-right">Qty</th>
													<th class="text-right">AvgRate</th>
														<th class="text-right">Action</th>
													
												</tr>
											</thead>
											<tbody>
												<tr>

												</tr>
											</tbody>
											<tfoot>
												<tr>

													<td class="text-right txtbold" colspan=\'2\' >Totals</td>
													<td class="TotalLstocks text-right txtbold"></td>
													<td class="TotalLstocksValue text-right txtbold"></td>
												</tr>
											</tfoot>
										</table>
									</div>
									</div>



								</div>

								<div class="tab-pane fade" id="viewall">

									<div class="row">
										<div class="col-lg-12">
											<div class="panel panel-default">
												<div class="panel-body">
													<table class="table table-striped table-hover ar-datatable">
														<thead>
															<tr>
																<th style=\'background: #368EE0;\'>Sr#</th>
																<th style=\'background: #368EE0;\'>Category</th>
																<th style=\'background: #368EE0;\'>Sub Category</th>
																<th style=\'background: #368EE0;\'>Brand</th>
																<th style=\'background: #368EE0;\'>Description</th>
																<th style=\'background: #368EE0;\'>SRate</th>
																<th style=\'background: #368EE0;\'>PRate</th>
																<th style=\'background: #368EE0;\'></th>
															</tr>
														</thead>
														<tbody>
															';$counter = 1;foreach ($items as $item): ;echo '															<tr>
																<td>';echo $counter++;;echo '</td>
																<td>';echo $item['category_name'];;echo '</td>
																<td>';echo $item['subcategory_name'];;echo '</td>
																<td>';echo $item['brand_name'];;echo '</td>
																<td>';echo $item['item_des'];;echo '</td>
																<td>';echo round(floatval($item['srate']),2);;echo '</td>
																<td>';echo round(floatval($item['cost_price']),2);;echo '</td>
																<td><a href="" class="btn btn-sm btn-primary btn-edit-item" data-itemid="';echo $item['item_id'];;echo '"><span class="fa fa-edit"></span></a></td>
															</tr>
														';endforeach ;echo '													</tbody>
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

		<div id="UOM" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="model-contentwrapper">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Add UOM</h3>
				</div>
				<div class="modal-body">

					<div class="input-group">
						<span class="input-group-addon">UOM</span>
						<input type="text" class="form-control input-sm" id="txtNewUOM">
					</div>
				</div>
				<div class="modal-footer">
					<div class="pull-right">
						<a class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
						<a class="btn btn-sm btn-default btnNewUOM"><i class="fa fa-plus"></i> Add</a>
					</div>
				</div>
			</div>
		</div>

		<div id="CategoryModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="model-contentwrapper">
				<div class="modal-header" style="background:#428bca; color:white;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Add Category</h3>
				</div>
				<div class="modal-body" style="background:#E7F0EF;">
					
					<div class="form-group">
						<div class="row">
							<div class="col-lg-5">
								<label>Name</label>
								<input type="hidden" id="txtCatIdHidden">
								<input type="text" class="form-control" id="txtName">
							</div>
							<div class="col-lg-5 hide">
								<label>Description</label>
								<input type="text" class="form-control" id="txtDescription">
							</div>
						</div><br>
					</div>
				</div>
				<div class="modal-footer">
					<div class="pull-right">
						<a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
						<a class="btn btn-primary btnNewCategory addmodal"><i class="fa fa-plus"></i> Add</a>
					</div>
				</div>
			</div>
		</div><!-- category model -->
		<div id="ColorModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="model-contentwrapper">
				<div class="modal-header" style="background:#428bca; color:white;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Add Color</h3>
				</div>
				<div class="modal-body" style="background:#E7F0EF;">
			<!-- <div class="form-group">
				<label>Category</label>
				<input type="text" class="form-control" id="txtNewCategory">
			</div> -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-5">
						<label>Name</label>
						<input type="hidden" id="txtColIdHidden">
						<input type="text" class="form-control" id="txtColName">
					</div>
					<div class="col-lg-5 hide">
						<label>Description</label>
						<input type="text" class="form-control" id="txtDescription">
					</div>
				</div><br>
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
				<a class="btn btn-primary btnNewColor addmodal"><i class="fa fa-plus"></i> Add</a>
			</div>
		</div>
	</div>
</div><!-- color model -->
<div id="SizeModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="model-contentwrapper">
		<div class="modal-header" style="background:#428bca; color:white;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Add Size</h3>
		</div>
		<div class="modal-body" style="background:#E7F0EF;">
			<!-- <div class="form-group">
				<label>Category</label>
				<input type="text" class="form-control" id="txtNewCategory">
			</div> -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-5">
						<label>Name</label>
						<input type="hidden" id="txtSzIdHidden">
						<input type="text" class="form-control" id="txtSzName">
					</div>
					<div class="col-lg-5 hide">
						<label>Description</label>
						<input type="text" class="form-control" id="txtDescription">
					</div>
				</div><br>
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
				<a class="btn btn-primary btnNewSize addmodal"><i class="fa fa-plus"></i> Add</a>
			</div>
		</div>
	</div>
</div><!-- color model -->

<div id="SubCategory" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="model-contentwrapper">
		<div class="modal-header" style="background:#428bca; color:white;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Add Sub Category</h3>
		</div>
		<!-- <div class="modal-body" style="background:#E7F0EF;">
			<div class="form-group">
				<label>Sub Category</label>
				<input type="text" class="form-control" id="txtNewSubCategory">
			</div>
		</div> -->
		<div class="modal-body" style="background:#E7F0EF;">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-5">
						<label>Name</label>
						<input type="text" class="form-control" id="txtSubName">
						<input type="hidden" id="txtSubIdHidden">
					</div>
					<div class="col-lg-5 hide">
						<label>Description</label>
						<input type="text" class="form-control" id="txtSubDescription">
					</div>
				<!-- <div class="col-lg-6">
					<label>Category</label>
					<select class="form-control" id="sub_category_dropdown">
						<option value="" disabled="" selected="">Choose Category</option>
						';
;echo '							<option value="';
;echo '">';
;echo '</option>
						';
;echo '					</select>
				</div> -->
			</div><br>
		</div>
		<!-- <div class="form-group">
			<div class="row">
				
			</div><br>
		</div> -->
	</div>
	<div class="modal-footer">
		<div class="pull-right">
			<a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
			<a class="btn btn-primary addmodal btnNewSubCategory"><i class="fa fa-plus"></i> Add</a>
		</div>
	</div>
</div><!--model-contentwrapper-->
</div><!-- sub category modal-->


<div id="Brand" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="model-contentwrapper">
		<div class="modal-header" style="background:#428bca; color:white;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Add Brand</h3>
		</div>
		<div class="modal-body" style="background:#E7F0EF;">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-5">
						<label>Name</label>
						<input type="text" class="form-control" id="txtBrandName">
						<input type="hidden" id="txtBrandIdHidden">
					</div>
					<div class="col-lg-5 hide">
						<label>Description</label>
						<input type="text" class="form-control" id="txtBrandDescription">
					</div>
				</div><br>
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
				<a class="btn btn-primary addmodal btnNewBrand"><i class="fa fa-plus"></i> Add</a>
			</div>
		</div>
	</div>
</div><!-- brand-model -->

<div id="madeModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="model-contentwrapper">
		<div class="modal-header" style="background:#428bca; color:white;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Add Made</h3>
		</div>
		<div class="modal-body" style="background:#E7F0EF;">
			<!-- <div class="form-group">
				<label>Category</label>
				<input type="text" class="form-control" id="txtNewCategory">
			</div> -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-5">
						<label>Name</label>
						<input type="hidden" id="txtMadeIdHidden">
						<input type="text" class="form-control" id="txtMadeName">
					</div>
					<div class="col-lg-5 hide">
						<label>Description</label>
						<input type="text" class="form-control" id="txtMadeDescription">
					</div>
				</div><br>
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
				<a class="btn btn-primary btnNewMade addmodal"><i class="fa fa-plus"></i> Add</a>
			</div>
		</div>
	</div>
</div><!-- made model -->

<div id="departmentModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="model-contentwrapper">
		<div class="modal-header" style="background:#428bca; color:white;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Add Department</h3>
		</div>
		<div class="modal-body" style="background:#E7F0EF;">
			<!-- <div class="form-group">
				<label>Category</label>
				<input type="text" class="form-control" id="txtNewCategory">
			</div> -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-5">
						<label>Name</label>
						<input type="hidden" id="txtDepartmentIdHidden">
						<input type="text" class="form-control" id="txtDepartmentName">
					</div>
				</div><br>
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
				<a class="btn btn-primary btnNewDepartment addmodal"><i class="fa fa-plus"></i> Add</a>
			</div>
		</div>
	</div>
</div><!-- made model -->
<div id="Image-lookup" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="AccountAddModelLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background:#64b92a !important; color:white !important;padding-bottom:20px !important;">
				<button type="button" class="modal-button cellRight modal-close pull-right btn-close" data-dismiss="modal"><span class="fa fa-times" style="font-size:26px; "></span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="AccountAddModelLabel">Attach Image</h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row-fluid">
						<div class="col-lg-12 ">
							<form role="form">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-3">
											<div class="input-group">
												<span  class="input-group-addon txt-Id">Voucher(Id)</span>
												<input type="number" class="form-control input-sm num" id="txtVrnoa" readonly="">
												<input type="hidden" id="txtVrnoaMAxHidden">
												<input type="hidden" id="txtVrnoaHidden">
												<input type="hidden" id="VoucherTypeHidden">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
											<div style="background: #F5F6F7;padding: 15px;border: 1px solid #ccc;box-shadow: 1px 1px 1px #000;">
												<div class="row">
													<div class="col-lg-12">
														<div class="studentImageWrap">
															<img src="';echo base_url('assets/img/blank_image.png');;echo '" alt="attach Image" style="margin: auto;display: block;" id="attach1ImageDisplay">
														</div>
													</div>
												</div>

												<div class="row">
                                                    <!-- <div class="col-lg-2">

                                                       <a   class="btn btn-danger removeimage1 btn-sm"><i class="fa fa-times"></i></a>

                                                   </div> -->
                                                   <div class="col-lg-6">

                                                   	<a  class="btn btn-primary" type="button" onclick="document.getElementById(\'attach1Image\').click(); return false;"><i class="fa fa-camera"></i></a> <input id="attach1Image" type="file" style="visibility: hidden; display: none;" />
                                                   </div>
                                               </div> 
                                           </div>
                                       </div>
                                       <div class="col-lg-4">
                                       	<div style="background: #F5F6F7;padding: 15px;border: 1px solid #ccc;box-shadow: 1px 1px 1px #000;">
                                       		<div class="row">
                                       			<div class="col-lg-12">
                                       				<div class="studentImageWrap"> 
                                       					<img src="';echo base_url('assets/img/blank_image.png');;echo '" alt="attach Image" style="margin: auto;display: block;" id="attach2ImageDisplay">
                                       				</div>
                                       			</div>
                                       		</div>

                                       		<div class="row">
                                       			<div class="col-lg-12">
                                       				<a  class="btn btn-primary" type="button" onclick="document.getElementById(\'attach2Image\').click(); return false;"><i class="fa fa-camera"></i></a> 
                                       				<input type="file" style="visibility: hidden; display: none;"  id="attach2Image">
                                       			</div>
                                       		</div> 
                                       	</div>

                                       </div>
                                       <div class="col-lg-4">
                                       	<div style="background: #F5F6F7;padding: 15px;border: 1px solid #ccc;box-shadow: 1px 1px 1px #000;">
                                       		<div class="row">
                                       			<div class="col-lg-12">
                                       				<div class="studentImageWrap">
                                       					<img src="';echo base_url('assets/img/blank_image.png');;echo '" alt="attach Image" style="margin: auto;display: block;" id="attach3ImageDisplay">
                                       				</div>
                                       			</div>
                                       		</div>

                                       		<div class="row">
                                       			<div class="col-lg-12">
                                       				<a  class="btn btn-primary" type="button" onclick="document.getElementById(\'attach3Image\').click(); return false;"><i class="fa fa-camera"></i></a>

                                       				<input type="file" style="visibility: hidden; display: none;" id="attach3Image">
                                       			</div>
                                       		</div> 
                                       	</div>

                                       </div>
                                   </div>
                                   <div class="row">
                                   	<div class="col-lg-4">
                                   		<div style="background: #F5F6F7;padding: 15px;border: 1px solid #ccc;box-shadow: 1px 1px 1px #000;">
                                   			<div class="row">
                                   				<div class="col-lg-12">
                                   					<div class="studentImageWrap">
                                   						<img src="';echo base_url('assets/img/blank_image.png');;echo '" alt="attach Image" style="margin: auto;display: block;" id="attach4ImageDisplay">
                                   					</div>
                                   				</div>
                                   			</div>

                                   			<div class="row">
                                   				<div class="col-lg-12">
                                   					<a  class="btn btn-primary" type="button" onclick="document.getElementById(\'attach4Image\').click(); return false;"><i class="fa fa-camera"></i></a>

                                   					<input type="file" style="visibility: hidden; display: none;" id="attach4Image">
                                   				</div>
                                   			</div> 
                                   		</div>

                                   	</div>

                                   	<div class="col-lg-4">
                                   		<div style="background: #F5F6F7;padding: 15px;border: 1px solid #ccc;box-shadow: 1px 1px 1px #000;">
                                   			<div class="row">
                                   				<div class="col-lg-12">
                                   					<div class="studentImageWrap">
                                   						<img src="';echo base_url('assets/img/blank_image.png');;echo '" alt="attach Image" style="margin: auto;display: block;" id="attach5ImageDisplay">
                                   					</div>
                                   				</div>
                                   			</div>

                                   			<div class="row">
                                   				<div class="col-lg-12">
                                   					<a  class="btn btn-primary" type="button" onclick="document.getElementById(\'attach5Image\').click(); return false;"><i class="fa fa-camera"></i></a>
                                   					<input type="file" style="visibility: hidden; display: none;" id="attach5Image">
                                   				</div>
                                   			</div> 
                                   		</div>

                                   	</div>
                                   	<div class="col-lg-4">
                                   		<div style="background: #F5F6F7;padding: 15px;border: 1px solid #ccc;box-shadow: 1px 1px 1px #000;">
                                   			<div class="row">
                                   				<div class="col-lg-12">
                                   					<div class="studentImageWrap">
                                   						<img src="';echo base_url('assets/img/blank_image.png');;echo '" alt="attach Image" style="margin: auto;display: block;" id="attach6ImageDisplay">
                                   					</div>
                                   				</div>
                                   			</div>

                                   			<div class="row">
                                   				<div class="col-lg-12">
                                   					<a  class="btn btn-primary" type="button" onclick="document.getElementById(\'attach6Image\').click(); return false;"><i class="fa fa-camera"></i></a>

                                   					<input type="file" style="visibility: hidden; display: none;" id="attach6Image">
                                   				</div>
                                   			</div> 
                                   		</div>

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
           		<a href="" class="btn btn-success btnSaveImage btn-sm" data-dismiss="modal" data-insertbtn="1" tabindex="7"><i class="fa fa-save"></i> Save</a>
           		<a href="" class="btn btn-warning btnResetImage btn-sm" tabindex="8"><i class="fa fa-refresh" ></i> Reset</a>
           		<a href="" class="btn btn-danger btn-sm" data-dismiss="modal" tabindex="9"><i class="fa fa-times"></i> Close</a>
           	</div>
           </div>
       </div>
   </div>
</div>


<div id="UpdateCostModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="model-contentwrapper">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Update Item Cost</h3>
		</div>
		<div class="modal-body" style="background:#E7F0EF;">

			<div class="form-group">
				<div class="row">
					<div class="col-lg-12">
						<label>Item</label>
						
						<input type="text" class="form-control" id="txtItemDescriptionUpdate">
						

					</div>
					
				</div>
				<div class="row">
					<div class="col-lg-3">
						<label>Avg Cost</label>
						
						<input type="text" class="form-control num" id="txtAvgRateUpdte">
						<input type="hidden" class="form-control hide" id="txtItemIdHidden">

					</div>
					<div class="col-lg-3">
						<label>Qty</label>
						<input type="text" class="form-control num" id="txtStockQtyUpdate">
					</div>
				</div><br>
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
				<a class="btn btn-primary btnUpdateCost addmodal"><i class="fa fa-plus"></i> Update</a>
			</div>
		</div>
	</div>
</div>';
?>