<?php


$name = $this->session->userdata('uname'); 	
;echo '<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Stock Transfer Balance Report</h1>
			</div>
		</div>
	</div>
	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				
				<div class="tab-content">
					<div id="add_item" class="tab-pane fade active in">
					<div class="row">
												<div class="col-lg-">
													<div class="input-group">
														<div class="input-group-addon id-addon">Sender</div>&nbsp&nbsp
														<input type="text" id="snd" value="">&nbsp&nbsp&nbsp&nbsp&nbsp <div class="input-group-addon txt-addon">QTY_SEND</div>&nbsp&nbsp<input type="text" id="snd_qty" value="">&nbsp&nbsp&nbsp&nbsp&nbsp <div class="input-group-addon txt-addon">Allocate</div>&nbsp&nbsp<input type="number" id="b_snd" value="">  &nbsp&nbsp&nbsp&nbsp <div class="col-lg-3">
														<div class="input-group">
															<span class="input-group-addon txt-addon">Action</span>
															<select class="form-control input-sm"  id="action">
																<option value="Choose Action" selected="Choose Action">Choose Action</option>
																<option value="add"  selected="">Add back</option>
																<option value="less"  selected="">Less back</option>														</select>
														</div>
													</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-1">
													<div class="input-group">
														<div class="input-group-addon txt-addon">Receiver</div>&nbsp&nbsp
														<input type="text" id="rec" value="">&nbsp&nbsp&nbsp&nbsp&nbsp <div class="input-group-addon txt-addon">QTY_Receive</div>&nbsp&nbsp<input type="text" id="rec_qty" value="">&nbsp&nbsp&nbsp&nbsp&nbsp<div class="input-group-addon txt-addon">Allocate</div>&nbsp&nbsp<input type="number" id="b_rec" value="" disabled="true">  &nbsp&nbsp&nbsp&nbsp<a class="btn btn-sm btn-default btnupdate"><i></i> Update</a>
													</div>
												</div>
											</div>

											
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
									 
                                    </div>
									
                                    
                        ';if ($name == 'admin') {;echo '
							<table class="table table-striped table-hover ar-datatable" id ="disc_table">
							<thead>
								<tr>
									<th style=\'background: #368EE0;\'>Sr#</th>
									<th style=\'background: #368EE0;\'>Voucher Id</th>
									<th style=\'background: #368EE0;\'>Item_Name</th>
									<th style=\'background: #368EE0;\'>Send From</th>
									<th style=\'background: #368EE0;\'>Qty</th>
									<th style=\'background: #368EE0;\'>Receive From</th>
									<th style=\'background: #368EE0;\'>QTY</th>
									<th style=\'background: #368EE0;\'>Date</th>
									<th style=\'background: #368EE0;\'>Balance</th>

								</tr>
							</thead>
							<tbody>
								';if (count($item) >0): ;echo '													';$counter = 1;foreach ($item as $items): ;echo '	
										<tr>
											<td>&nbsp&nbsp&nbsp ';echo $counter++;;echo '</td>
											<td >&nbsp&nbsp&nbsp';echo $items['vrnoa'];;echo '</td>
											<td >';echo $items['item_name'];;echo '</td>
											<td>&nbsp&nbsp&nbsp';echo $items['dept_from'];;echo'</td>
											<td>&nbsp&nbsp&nbsp';echo $items['receive'];;echo'</td>
											<td>&nbsp&nbsp&nbsp';echo $items['dept_to'];;echo'</td>
											<td>&nbsp&nbsp&nbsp';echo $items['qty'];;echo'</td>
											<td>';echo $items['vrdate'];;echo'</td>
											<td class="td';echo $items['vrnoa'];;echo'">&nbsp&nbsp&nbsp';echo  $items['balance'];;echo'</td>
											<td><div class="btn btn-sm btn-primary btnallocate showallupdatebtn" data-transporter_id="';echo $items['vrnoa'];;echo '" data-transporter2_id="';echo $items['qty'];;echo '" data-transporter3_id="';echo $items['balance'];;echo '" data-transporter4_id="';echo $items['dept_from'];;echo '"data-transporter5_id="';echo $items['dept_to'];;echo '"data-transporter6_id="';echo $items['receive'];;echo '" data-transporter7_id="';echo $items['qty'];;echo '" ><span>ALLOCATE</span></div></td>		

										</tr>
									';endforeach ;echo '												';endif ;echo '											</tbody>
						</table>                      
                                   
							';}else{;echo '	
								<table class="table table-striped table-hover ar-datatable" id ="disc_table">
								<thead>
									<tr>
										<th style=\'background: #368EE0;\'>Sr#</th>
										<th style=\'background: #368EE0;\'>Voucher Id</th>
										<th style=\'background: #368EE0;\'>Item_Name</th>
										<th style=\'background: #368EE0;\'>Send From</th>
										<th style=\'background: #368EE0;\'>Receive From</th>
										<th style=\'background: #368EE0;\'>Date</th>
										<th style=\'background: #368EE0;\'>QTY</th>
										<th style=\'background: #368EE0;\'>Receive</th>
										<th style=\'background: #368EE0;\'>Balance</th>
	
									</tr>
								</thead>
								<tbody>
									';if (count($item) >0): ;echo '													';$counter = 1;foreach ($item as $items): ;echo '	
																						<tr>
												<td>&nbsp&nbsp&nbsp ';echo $counter++;;echo '</td>
												<td >&nbsp&nbsp&nbsp';echo $items['vrnoa'];;echo '</td>
												<td > ';echo $items['item_name'];;echo '</td>
												<td>&nbsp&nbsp&nbsp';echo $items['dept_to'];;echo'</td>
												<td>&nbsp&nbsp&nbsp';echo $items['dept_from'];;echo'</td>
												<td>';echo $items['vrdate'];;echo'</td>
												<td>&nbsp&nbsp&nbsp';echo $items['receive'];;echo'</td>
												<td class="td';echo $items['vrnoa'];;echo'">&nbsp&nbsp&nbsp';echo  $items['qty'];;echo'</td>
												<td class="td';echo $items['vrnoa'];;echo'">&nbsp&nbsp&nbsp';echo  $items['balance'];;echo'</td>
												
	
											</tr>
										';endforeach ;echo '												';endif ;echo '											</tbody>
							</table>                     

							';};echo '

									
							</div>
									</div>
								</div>
							</div> 
						</div>

					</div> <!-- end of search_branch -->
				</div>
			</div>
		</div>
	</div>
</div>
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/difference.js');;echo '"></script>
<script src="';echo base_url('assets/js/ddtf.js');;echo '"></script>

;'

?>

<script>$('#disc_table').ddTableFilter();</script>