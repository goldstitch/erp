

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
				<h1 class="page_title">Discount Form</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
			
			<input class="form-control input-sm" type="hidden" id="current_date" value="';echo date('Y-m-d');;echo '" >
				<ul class="nav nav-tabs" id="tabs_a">
					<li class=""><a data-toggle="tab" href="#view_all">All items</a></li>
					
				</ul>
				<div class="tab-content">
					<div id="add_item" class="tab-pane fade active in">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
									 <h4><b>Enter Item Discount : </b></pre> <input type="number" id="disc" value=""> <a href=\'\' class="btn btn-sm btn-info btnupdate"><i class="fa fa-edit"></i>&nbsp;Update All</a></h4>
									 <div class="row">
									 <div class="col-lg-6 pull-left">
									 <h4><b>Time Limited Discount : </b></pre> <input type="number" id="ldisc" value=""> <a href="" class="btn btn-sm btn-info btnupdate"><i class="fa fa-edit"></i>&nbsp;Update All</a></h4>
							        	</div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
												<input class="form-control input-sm" type="date" id="from" value="" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                            <input class="form-control input-sm" type="date" id="to" value="" >
                                            </div>
                                        </div>

                                       

                                    </div>
									
									<table class="table table-striped table-hover ar-datatable" id ="disc_table">
									<thead>
										<tr>
											<th style=\'background: #368EE0;\'>Sr#</th>
											<th style=\'background: #368EE0;\'>Item_Id</th>
											<th style=\'background: #368EE0;\'>Item_Name</th>
											<th style=\'background: #368EE0;\'>Location Wise</th>
											<th style=\'background: #368EE0;\'>Old Discount</th>
											<th style=\'background: #368EE0;\'>New Discount</th>
							           
											
										</tr>
									</thead>
									<tbody>
										';if (count($item) >0): ;echo '													';$counter = 1;foreach ($item as $items): ;echo '	
																							<tr>
													<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  ';echo $counter++;;echo '</td>
													<td >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ';echo $items['item_id'];;echo '</td>
													<td >&nbsp&nbsp&nbsp&nbsp ';echo $items['item_des'];;echo '</td>
													<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ';echo $items['name'];;echo'</td>
													<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ';echo $items['item_discount'];;echo'</td>
													<td class="td';echo $items['name'];;echo'';echo $items['item_id'];;echo '">           null</td>
													
											<td><div class="btn btn-sm btn-primary btn-edit-dept showallupdatebtn" data-transporter_id="';echo $items['item_id'];;echo '" data-transporter2_id="';echo $items['godown_id'];;echo '" data-transporter3_id="';echo $items['name'];;echo '" data-transporter4_id="';echo $items['item_discount'];;echo '" data-transporter5_id="';echo $items['item_des'];;echo '"><span class="fa fa-edit"></span></div></td>

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
<script src="';echo base_url('assets/js/app_modules/discount.js');;echo '"></script>
<script src="';echo base_url('assets/js/ddtf.js');;echo '"></script>

;'

?>

<script>$('#disc_table').ddTableFilter();</script>