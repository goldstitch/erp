

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

;echo '
<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Return Document Receipt Form</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">

				<form action="">

					<div class="tab-content">
						<div class="tab-pane active fade in" id="basicInformation">

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-body">


										<div class="col-lg-2">
											<label>Receipt Serial</label>
											<input type="number" class="form-control input-sm num" id="txtid">
									    </div> 


										<div class="col-lg-2">
										    <label class="">Return Date</label>
										    <input class="form-control input-sm" type="date" id="date" value="';echo date('Y-m-d');;echo '" >
									    </div> 

										<div class="col-lg-3">
											<label>Name</label>
											<input type="text" class="form-control input-sm" id="name" readonly="">
									    </div> 


										<div class="col-lg-3">
										    <label>Company Name </label>
											<input type="text" class="form-control input-sm" id="company" readonly="">
										</div>

										<div class="col-lg-2">
											<label>Amount</label>
											<input type="number" class="form-control input-sm" id="amount" readonly="">
									    </div>

										<div class="col-lg-3">
										    <label>Received By </label>
											<input type="text" class="form-control input-sm" id="by" readonly="">
										</div>


										
										<div class="col-lg-12">
										<div class="pull-right">	<a class="btn btn-sm btn-default btnupdate_return"><i class="fa fa-refresh"></i>Update</a>
											<a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
									    </div>
										</div>  


									
									</div>
										

											

  <!-- end of button row -->
									<div class="row">

									<div class="col-lg-12">
									<p></p>
										<div id="no-more-tables">
											<table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table1">
												<thead class="cf tbl_thead">
													<tr>
													<th >Sr#</th>
													<th >ID</th>
													<th >Date</th>
													<th >Name</th>
													<th >Company</th>
													<th >Amount</th>
													<th >Received By</th>
													<th >Return Date</th>
													<th >Status</th>
													<th >Action</th>
													</tr>
												</thead>
													<tbody>
		
												</tbody>
											</table>
										</div>
									</div>

									</div>


											
										</div>
										
									</div>
								</div> 

							</div>    

							
						</div>  <!-- end of container fluid -->
	
					</div>   <!-- end of page_content -->
				</form>
			</div>
		</div>
	</div>			
</div>';
?>