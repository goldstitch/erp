<?php



;echo '<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Stock Adjustment Report</h1>
			</div>
		</div>
	</div>
	<div class="page_content">
		<div class="container-fluid">
		<div class="panel-body">
									 <h4><b>Print Report </b></pre>   <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button></h4>
									 </div>

			<div class="col-md-12">
					<div id="add_item" class="tab-pane fade active in">
						<div class="row">
							<div class="col-lg-12">
									<div class="panel-body">
									 
                                    </div>
									
							<table class="table" id ="disc_table">
							<thead>
								<tr>
									<th style=\'background: #368EE0;\'>Sr</th>
									<th style=\'background: #368EE0;\'>Date</th>
									<th style=\'background: #368EE0;\'>Location</th>
									<th style=\'background: #368EE0;\'>Item_Name</th>
									<th style=\'background: #368EE0;\'>QTY</th>
									<th style=\'background: #368EE0;\'>Rate</th>
									<th style=\'background: #368EE0;\'>Amount</th>
									<th style=\'background: #368EE0;\'>Type</th>
								
								</tr>
							</thead>
							<tbody>
								';if (count($item) >0): ;echo '			';$counter = 1 ;$Qty=0;foreach ($item as $items): $Qty += ROUND($items['qty']);  ;echo '	
								
										<tr>
											<td>&nbsp&nbsp&nbsp ';echo $counter++;;echo '</td>
											<td>&nbsp&nbsp&nbsp';echo $items['vrdate'];;echo'</td>
											<td >&nbsp&nbsp&nbsp';echo $items['name'];;echo '</td>
											<td >';echo $items['item_des'];;echo '</td>
											<td>';echo $items['qty'];;echo'</td>
											<td >';echo $items['rate'];;echo'</td>
											<td >';echo $items['trate'];;echo'</td>
											<td>';echo $items['atype'];;echo'</td>
											
											
										</tr>
									';endforeach ;echo '												';endif ;echo '											</tbody>
									
	<tfoot>
	<tr class="foot-comments">
		<td class="subtotal bold-td text-right" colspan="4">Total</td>
		<td class="subtotal bold-td text-left" >';echo number_format($Qty,0);;echo '</td>
	
	</tr>
</tfoot>
						</table>                      

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