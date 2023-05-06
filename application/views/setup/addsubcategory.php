

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
				<h1 class="page_title">Add Sub Category</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tabs_a">
					<li class="active"><a data-toggle="tab" href="#add_category">Add/Update Sub Category</a></li>
					<li class=""><a data-toggle="tab" href="#view_all">View All</a></li>
				</ul>
				<div class="tab-content">
					<div id="add_category" class="tab-pane fade active in">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">

										<form action="">

											<div class="row">
												<div class="col-lg-2">
													<div class="input-group">
														<div class="input-group-addon id-addon">Id (Auto)</div>
														<input type="number" class="form-control input-sm num" id="txtId">
														<input type="hidden" id="txtIdHidden">
														<input type="hidden" id="txtMaxIdHidden">
														<input type="hidden" id="vouchertypehidden">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Name</div>
														<input type="text" class="form-control input-sm" id="txtName">
													</div>
												</div>
											</div>
	
											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<span class="input-group-addon">Category</span>
														<select class="form-control input-sm input-sm" id="category_dropdown">
															<option value="" disabled="" selected="">Choose Category</option>
															';foreach ($categories as $category): ;echo '																<option value="';echo $category['catid'];;echo '">';echo $category['name'];;echo '</option>
															';endforeach ;echo '														</select>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Description</div>
														<input type="text" class="form-control input-sm" id="txtDescription">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-12">
													<div class="pull-right">
														<!-- <a class="btn btn-default btn-sm btnSave"><i class="fa fa-save"></i> Save Changes</a> -->
														<a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['subcatagory']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['subcatagory']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['subcatagory']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['subcatagory']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
														<a class="btn btn-default btn-sm btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
														<a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
													</div>
												</div> 	<!-- end of col -->
											</div>	<!-- end of row -->
										</form>	<!-- end of form -->

									</div>	<!-- end of panel-body -->
								</div>	<!-- end of panel -->
							</div>  <!-- end of col -->
						</div>	<!-- end of row -->

					</div>	<!-- end of add_branch -->
					<div id="view_all" class="tab-pane fade">

						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<table class="table table-striped table-hover ar-datatable">
											<thead>
												<tr>
													<th style=\'background: #368EE0;\'>Sr#</th>
													<th style=\'background: #368EE0;\'>Category</th>
													<th style=\'background: #368EE0;\'>Subcategory</th>
													<th style=\'background: #368EE0;\'>Description</th>
													<th style=\'background: #368EE0;\'></th>
												</tr>
											</thead>
											<tbody>
												';if (isset($subcategories)): ;echo '													';$counter = 1;foreach ($subcategories as $subcategory): ;echo '														<tr>
															<td>';echo $counter++;;echo '</td>
															<td>';echo $subcategory['category_name'];;echo '</td>
															<td>';echo $subcategory['name'];;echo '</td>
															<td>';echo $subcategory['description'];;echo '</td>
															<td><a href="" class="btn btn-sm btn-primary btn-edit-cat" data-subcatid="';echo $subcategory['subcatid'];;echo '"><span class="fa fa-edit"></span></a></td>
														</tr>
													';endforeach ;echo '												';endif ;echo '											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

					</div> <!-- end of search_branch -->
				</div>
			</div>
		</div>
	</div>
</div>';
?>