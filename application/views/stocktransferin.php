

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/



;echo '<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Stock Transfer In</h1>
			</div>
		</div>
	</div>
	<h4>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Total Unpost Voucher :';echo $count;;echo' </h4>
	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				<ul class="nav nav-tabs" id="tabs_a">
					<li class=""><a data-toggle="tab" href="#view_all">All items</a></li>
					
				</ul>
				<div class="tab-content">
					<div id="add_item" class="tab-pane fade active in">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
									 <h4><b>Enter Received Stock: </b></pre> <input type="number" id="rec" value=""></h4>
									 
                                    </div>
									
									<table class="table table-striped table-hover ar-datatable" id ="disc_table">
									<thead>
										<tr>
											<th style=\'background: #368EE0;\'>Sr#</th>
											<th style=\'background: #368EE0;\'>Transfer Id</th>
											<th style=\'background: #368EE0;\'>Item Id</th>
											<th style=\'background: #368EE0;\'> Item Description </th>
											<th style=\'background: #368EE0;\'>Receive From</th>
											<th style=\'background: #368EE0;\'>Date</th>
											<th style=\'background: #368EE0;\'>QTY</th>
											<th style=\'background: #368EE0;\'>Receive</th>
							           
											
										</tr>
									</thead>
									<tbody>
										';if (count($item) >0): ;echo '													';$counter = 1;foreach ($item as $items): ;echo '	
																							<tr>
													<td>&nbsp&nbsp&nbsp&nbsp&nbsp  ';echo $counter++;;echo '</td>
													<td >&nbsp&nbsp&nbsp&nbsp';echo $items['vrnoa'];;echo '</td>
													<td >&nbsp&nbsp&nbsp';echo $items['design_name'];;echo '</td>
													<td >&nbsp&nbsp&nbsp&nbsp ';echo $items['item_name'];;echo '</td>
													<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ';echo $items['dept_from'];;echo'</td>
													<td>&nbsp';echo $items['vrdate'];;echo'</td>
													<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ';echo $items['receive'];;echo'</td>
													<td class="td';echo $items['vrnoa'];;echo'">';echo  $items['qty'];;echo'</td>
													
											<td><div class="btn btn-sm btn-primary btn-edit-dept showallupdatebtn" data-transporter_id="';echo $items['vrnoa'];;echo '" data-transporter2_id="';echo $items['receive'];;echo '"><span class="fa fa-edit"></span></div></td>

												</tr>
											';endforeach ;echo '												';endif ;echo '											</tbody>
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
<script src="';echo base_url('assets/js/app_modules/stocktransferin.js');;echo '"></script>
<script src="';echo base_url('assets/js/ddtf.js');;echo '"></script>

;'

?>

<script>$('#disc_table').ddTableFilter();</script>