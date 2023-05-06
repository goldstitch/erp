

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
			<div class="col-md-12">
				<h1 class="page_title">Add New Item</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">

				<form action="">

					<ul class="nav nav-pills">
						<li class="active hidden"><a href="#additem" data-toggle="tab">Add Item</a></li>
						<li class="hidden"><a href="#viewall" data-toggle="tab">View All</a></li>
					</ul>

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
											
											<div class="col-lg-9">

												<div class="row">
													<div class="col-lg-2">
														<label>Id</label>
														<input type="number" class="form-control input-sm num" id="txtId">
														<input type="hidden" id="txtMaxIdHidden">
														<input type="hidden" id="txtIdHidden">
														<input type="hidden" id="VoucherTypeHidden">

														<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
														<input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
														<input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
													</div>
													<div class="col-lg-1">
														
													</div>
													<div class="col-lg-3">
														<label>Is active?</label>
														<input type="checkbox" checked="" class="bs_switch active_switch" id="active">
													</div>
													<div class="col-lg-3">
														<label>Date</label>
														<input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
													</div>
													<!-- <div class="col-lg-3">
														<label>Item Code</label>
														<input type="text" list=\'ic_dropdowns\' class="form-control input-sm" id="ic_dropdown"/>
														<datalist id=\'ic_dropdowns\'>
															';foreach ($item_codes as $item_code): ;echo '																<option value="';echo $item_code['item_code'];;echo '">
															';endforeach ;echo '														</datalist>
													</div> -->
													<div class="col-lg-3">
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
														<select class="form-control input-sm select2" id="category_dropdown">
															<!-- <option value="" disabled="" selected="">Choose Category</option>
															';foreach ($categories as $category): ;echo '																<option value="';echo $category['catid'];;echo '">';echo $category['name'];;echo '</option>
															';endforeach ;echo ' -->
														</select>
													</div>
													<div class="col-lg-2">
														<label>Sub Catgeory</label>
														<select class="form-control input-sm select2" id="subcategory_dropdown">
															<!-- <option value="" disabled="" selected="">Choose Category</option>
															';foreach ($subcategories as $category): ;echo '																<option value="';echo $category['subcatid'];;echo '">';echo $category['name'];;echo '</option>
															';endforeach ;echo ' -->
														</select>
													</div>
													<div class="col-lg-2">
														<label>Spec</label>
														<input type="text" list=\'models\' class="form-control input-sm" id="txtModel"/>
														<datalist id=\'models\'>
															
														</datalist>
													</div>
													<div class="col-lg-1">
														<label>Size</label>

														<input type="text" list=\'sizes\' class="form-control input-sm" id="txtPacking"/>
														<datalist id=\'sizes\'>
															';foreach ($sizes as $type): ;echo '																<option value="';echo $type['size'];;echo '">
																';endforeach ;echo '															</datalist>


														</div>

														<div class="col-lg-1">

															<label>Color</label>
															<input type="text" list=\'type\' class="form-control input-sm" id="txtBarcode"/>
															<datalist id=\'type\'>
																';foreach ($types as $type): ;echo '																	<option value="';echo $type['barcode'];;echo '">
																	';endforeach ;echo '																</datalist>

															</div>




															<div class="col-lg-3">

																<label>Brand</label>
																<select class="form-control input-sm select2" id="brand_dropdown">
																	
																</select>

															</div>
														</div>

														<div class="row">
															<div class="col-lg-6">
																<label>Description</label>
																<input type="text" class="form-control input-sm" id="txtDescription"/>
																<input type="hidden" class="form-control input-sm" id="txtDescriptionHidden"/>
															</div>
															<div class="col-lg-2">
																<label>Article No</label>
																<input type="text" class="form-control input-sm" id="txtArticleNo"/>
															</div>
															<div class="col-lg-4">
																<label>Remarks</label>
																<input type="text" class="form-control input-sm" id="txtRemarks"/>
															</div>
														</div>

														<div class="row hide">
															<select class="form-control input-sm" id="alldescription_dropdown">
																';foreach ($items as $item): ;echo '																	<option value="';echo $item['description'];;echo '">';echo $item['description'];;echo '</option>
																';endforeach ;echo '															</select>
														</div>

														<div class="row hide">
															<select class="form-control input-sm" id="allcodes_dropdown">
																';foreach ($items as $item): ;echo '																	<option value="';echo $item['item_code'];;echo '">';echo $item['item_code'];;echo '</option>
																';endforeach ;echo '															</select>
														</div>

													</div>
													<div class="col-lg-3">
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
													<div class="col-lg-2">
														<label>UOM</label>
														<input type="text" class=\'form-control input-sm\' placeholder="Uom" id="uom_dropdown" list=\'uoms\'>
														<datalist id="uoms">
															';foreach ($uoms as $uom): ;echo '																';if ($uom['uom'] !== ''): ;echo '																	<option value="';echo $uom['uom'];;echo '">
																	';endif ;echo '																';endforeach ;echo '															</datalist>
														</div>
														<div class="col-lg-2">
															<label>Pur Price</label>
															<input class="form-control input-sm num" type="text" id="txtPurPrice">
														</div>
														<div class="col-lg-2">
															<label>Net Weight</label>
															<input class="form-control input-sm num" type="text" id="txtNetWeight">
														</div>
														<div class="col-lg-2">
															<label>Gram Weight</label>
															<input class="form-control input-sm num" type="text" id="txtGrWeight">
														</div>
													</div>

													<div class="row">
														<div class="col-lg-2">
															<label>Sale Price 1</label>
															<input class="form-control input-sm num" type="text" id="txtSalePrice">
														</div>

														<div class="col-lg-2">
															<label>Sale Price 2</label>
															<input class="form-control input-sm num" type="text" id="txtDiscount">
														</div>

														<div class="col-lg-2">
															<label>Sale Price 3</label>
															<input class="form-control input-sm num" type="text" id="txtComm">
														</div>

											<!-- <div class="col-lg-2">
												<label>Currencey</label>
	
												<select class="form-control input-sm select2" id="curencey_dropdown">
													<option value="" disabled="" selected="">Choose Currency</option>
													';foreach ($currenceys as $currencey): ;echo '														<option value="';echo $currencey['id'];;echo '">';echo $currencey['name'];;echo '</option>
													';endforeach ;echo '												</select>
											</div> -->

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
														';foreach ($parties as $party): ;echo '															<option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
														';endforeach ;echo '													</select>
												</div>
											</div>

											<div class="col-lg-4">
												<div class="input-group">
													<span class="input-group-addon">Credit</span>
													<select class="form-control input-sm" id="credit_dropdown">
														<option value="" disabled="" selected="">Choose credit party</option>
														';foreach ($parties as $party): ;echo '															<option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
														';endforeach ;echo '													</select>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
							<div id="item-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<h3 id="myModalLabel">item Lookup</h3>
										</div>

										<div class="modal-body">
											<table class="table table-striped modal-table" id="tbItems">
											
												<thead>
													<tr style="font-size:14px;">
														<th>Id</th>
														<th class="text-left">Article</th>
														<th>Description</th>
														<th>Catagory</th>
														<th>Specs</th>
														<th>Size</th>
														<th>Color</th>
														<th width="5px">Actions</th>
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
								<div class="pull-right">
									<a class="btn btn-sm btn-default btnSave" data-insertbtn=\'';echo $vouchers['item']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['item']['update'];;echo '\'><i class="fa fa-save"></i> Save F10</a>
									<a href=\'\' class="btn btn-sm btn-default btnReset">
										<i class="fa fa-refresh"></i>
										Reset F5</a>

										<a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
										
										<a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
										<!-- <a href=\'\' class="btn btn-sm btn-default btnPrint"> <i class="fa fa-print"></i>Print F9</a> -->
									</div>

								</div>    <!-- end of a href=\'\' row -->

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
															<th style=\'background: #368EE0;\'>Article#</th>
															<th style=\'background: #368EE0;\'>Category</th>
															<th style=\'background: #368EE0;\'>Sub Category</th>
															<th>Specs</th>
															<th>Size</th>
															<th>Color</th>
															<th style=\'background: #368EE0;\'>Brand</th>
															<th style=\'background: #368EE0;\'>Description</th>
															<th style=\'background: #368EE0;\'>SRate</th>
															<th style=\'background: #368EE0;\'>PRate</th>
															<th style=\'background: #368EE0;\'></th>
														</tr>
													</thead>
													<tbody>
														';$counter = 1;foreach ($items as $item): ;echo '														<tr>
															<td>';echo $counter++;;echo '</td>
															<td>';echo $item['artcile_no'];;echo '</td>
															<td>';echo $item['category_name'];;echo '</td>
															<td>';echo $item['subcategory_name'];;echo '</td>
															<td>';echo $item['model'];;echo '</td>
															<td>';echo $item['size'];;echo '</td>
															<td>';echo $item['barcode'];;echo '</td>
															<td>';echo $item['brand_name'];;echo '</td>
															<td>';echo $item['item_des'];;echo '</td>
															<td>';echo round(floatval($item['srate']),2);;echo '</td>
															<td>';echo round(floatval($item['cost_price']),2);;echo '</td>
															<td><a href="" class="btn btn-sm btn-primary btn-edit-item" data-itemid="';echo $item['item_id'];;echo '"><span class="fa fa-edit"></span></a></td>
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

';
?>