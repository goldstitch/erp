

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/



$name = $this->session->userdata('uname'); 
;echo '<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Price Adjustment</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
			
				<div class="tab-content">
					<div id="add_item" class="tab-pane fade active in">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
									<div class="pull-right" >
									<h4><b>Print Report </b></pre>   <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button></h4>
									</div>
									 <h4><b>Item Retail Price : </b></pre> <input type="number" id="r_price" value=""> <a href=\'\' class="btn btn-sm btn-info btnupdate"><i class="fa fa-edit"></i>&nbsp;Update All</a></h4>
									 <div class="row">
									 <div class="col-lg-3 pull-right">
									  <input class="form-control input-sm" type="hidden" id="current_date" value="';echo date('Y-m-d');;echo '" >
									  </div>
									  </div>
									 <div class="col-lg-6 pull-left">
									 <h4><b>&nbspItem Wholesale Price: </b></pre> <input type="number" id="w_price" value=""> <a href="" class="btn btn-sm btn-info btnupdate"><i class="fa fa-edit"></i>&nbsp;Update All</a></h4>
							         </div>
                                    
                                        </div>

                                       

                                    </div>
									';if ($name == 'admin') {;echo '
										<table class="table table-striped table-hover ar-datatable" id ="disc_table">
									<thead>
										<tr>
											<th style=\'background: #368EE0;\'>Sr</th>
											<th style=\'background: #368EE0;\'>Location</th>
											<th style=\'background: #368EE0;\'>Item_Id & Name</th>
											<th style=\'background: #368EE0;\'>Pur_Price</th>
											<th style=\'background: #368EE0;\'>W_Price</th>
											<th style=\'background: #368EE0;\'>W_Price New</th>
											<th style=\'background: #368EE0;\'>R_Price</th>
											<th style=\'background: #368EE0;\'>R_Price New</th>
											
							           
											
										</tr>
									</thead>
									<tbody>
										';if (count($item) >0): ;echo '													';$counter = 1;foreach ($item as $items): ;echo '	
																							<tr>
													<td>';echo $counter++;;echo '</td>
													<td>';echo $items['name'];;echo'</td>
													<td >&nbsp&nbsp';echo $items['item_id'];;echo '&nbsp&nbsp&nbsp&nbsp';echo $items['item_des'];;echo '</td>
													<td>';echo $items['cost'];;echo'</td>
													<td>';echo $items['srate2'];;echo'</td>
													<td class="td';echo $items['name'];;echo'';echo $items['item_id'];;echo '';echo $items['srate2'];;echo'">null</td>
													<td>';echo $items['srate'];;echo '</td>
													<td class="td';echo $items['name'];;echo'';echo $items['item_id'];;echo '';echo $items['srate'];;echo'">null</td>
													
											<td><div class="btn btn-sm btn-primary btn_price showallupdatebtn" data-transporter_id="';echo $items['item_id'];;echo '" data-transporter2_id="';echo $items['item_barcode'];;echo '" data-transporter3_id="';echo $items['name'];;echo '" data-transporter4_id="';echo $items['srate2'];;echo '" data-transporter5_id="';echo $items['srate'];;echo '" data-transporter6_id="';echo $items['item_des'];;echo '"><span class="fa fa-edit"></span></div></td>

												</tr>
											';endforeach ;echo '												';endif ;echo '											</tbody>
								</table>
									
										
									';}else{;echo '	
										<table class="table table-striped table-hover ar-datatable" id ="disc_table">
									<thead>
										<tr>
											<th style=\'background: #368EE0;\'>Sr</th>
											<th style=\'background: #368EE0;\'>Location</th>
											<th style=\'background: #368EE0;\'>Item_Id & Name</th>
											<th style=\'background: #368EE0;\'>W_Price</th>
											<th style=\'background: #368EE0;\'>W_Price New</th>
											<th style=\'background: #368EE0;\'>R_Price</th>
											<th style=\'background: #368EE0;\'>R_Price New</th>
											
							           
											
										</tr>
									</thead>
									<tbody>
										';if (count($item) >0): ;echo '													';$counter = 1;foreach ($item as $items): ;echo '	
																							<tr>
													<td>';echo $counter++;;echo '</td>
													<td>';echo $items['name'];;echo'</td>
													<td >&nbsp&nbsp';echo $items['item_id'];;echo '&nbsp&nbsp&nbsp&nbsp';echo $items['item_des'];;echo '</td>
													<td>';echo $items['cost'];;echo'</td>
													<td>';echo $items['srate2'];;echo'</td>
													<td class="td';echo $items['name'];;echo'';echo $items['item_id'];;echo '';echo $items['srate2'];;echo'">null</td>
													<td>';echo $items['srate'];;echo '</td>
													<td class="td';echo $items['name'];;echo'';echo $items['item_id'];;echo '';echo $items['srate'];;echo'">null</td>
													
											<td><div class="btn btn-sm btn-primary btn_price showallupdatebtn" data-transporter_id="';echo $items['item_id'];;echo '" data-transporter2_id="';echo $items['item_barcode'];;echo '" data-transporter3_id="';echo $items['name'];;echo '" data-transporter4_id="';echo $items['srate2'];;echo '" data-transporter5_id="';echo $items['srate'];;echo '"><span class="fa fa-edit"></span></div></td>

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
<script src="';echo base_url('assets/js/app_modules/discount.js');;echo '"></script>
<script src="';echo base_url('assets/js/ddtf.js');;echo '"></script>

;'

?>

<script>$('#disc_table').ddTableFilter();</script>