

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
				<h1 class="page_title">Material Demand Note</h1>
			</div>
		</div>
	</div>

	<div class="page_content">

			<div class="col-md-12">

										<div class="row">
											<p></p>
                        <div class="col-lg-2">
                          <label class="VoucherNoLable">Sr#</label>
                          <input type="number" class="form-control input-sm VoucherNo" id="txtVrnoa" >
                        </div>
                        
                        <div class="col-lg-2">
                          <label class="">Design</label>
                          <input type="text" class="form-control input-sm" id="design" >
                        </div>

                        <div class="col-lg-2" hidden>
                          <input type="text" class="form-control input-sm" id="qty_" >
                        </div>

                        <div class="col-lg-2" hidden>
                          <input type="text" class="form-control input-sm" id="rate_" >
                        </div>

                        <div class="col-lg-2" hidden>
                        <input type="text" class="form-control input-sm" id="cost_" >
                        </div>


                        <div class="col-lg-2">
                          <label class="">Date</label>
                          <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                        </div>


                              <div class="container">
                                <div class="pull-right">
                                  <label>&nbsp</label>
                                  <a class="btn btn-sm btn-default btnSave" ><i class="fa fa-save"></i> &nbspSave &nbsp</a>
                                  <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i>&nbsp Delete&nbsp </a>
                                  <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i>&nbsp Reset &nbsp</a>
                                </div>
                              </div>

                    
												
    
											</div>

		
                  </div>
								<div class="row">
											<div class="panel panel-default">
												<div class="panel-body">
                         
							<div class="col-lg-12">
              <h2>Material</h2>
							<div id="no-more-tables">
                <table class="table table-striped" id="purchase_table6">
									<thead class="cf tbl_thead">
										<tr>
											<th>Sr#</th>
                      <th>Design Id</th>
											<th>Material</th>
											<th>Unit</th>
                      <th>Size</th>
                      <th>Req.Qty</th>
											<th>In Stock</th>
                      <th>Stock Location</th>
                      <th>Total QTY</th>
											<th>Issue Qty</th>
                      <th></th>
										</tr>
									</thead>
										<tbody>

									</tbody>
								</table>
							</div>

              <label> </label>     
          


					
                        <p></p>

                        

                        <p></p>


                        </div>
                            
                        

								</div>

							

						</div>
					</form>   <!-- end of form -->
				</div>  <!-- end of col -->
			</div>  <!-- end of container fluid -->
		</div>   <!-- end of page_content -->
	</div>
</div>
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
';
?>