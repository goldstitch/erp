

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
				<h1 class="page_title">Production Calculation </h1>
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

                                          

                        <div class="col-lg-2">
                          <label class="">Article</label>
                          <select class="form-control select2" id="articles">
                          ';foreach ($arts as $item): ;echo ' <option value="';echo $item['name'];;echo '" >';echo $item['name'];;echo '</option>
                          ';endforeach ;echo '  </select>
                        </div>

                        <div class="col-lg-2">
                          <label>Category</label>
                          <select class="form-control select2" id="category_dropdown">
                          ';foreach ($cats as $item): ;echo ' <option value="';echo $item['name'];;echo '" >';echo $item['name'];;echo '</option>
                          ';endforeach ;echo '                    </select>
                        </div>
                            

                          <div class="col-lg-2">
                            <label>Color</label>
                            <select class="form-control select2" id="Color_dropdown">
                            ';foreach ($items as $item): ;echo ' <option value="';echo $item['name'];;echo '" >';echo $item['name'];;echo '</option>
                            ';endforeach ;echo '                    </select>
                          </div>

                    </div>

							        <div class="row">

                              <div class="col-lg-2">
                                <label>Total Material </label>
                                <input class="form-control input-sm" type="text" id="m_subtotal" readonly="true">
                              </div>

                              <div class="col-lg-2">
                                <label>Sample Production Cost </label>
                                <input class="form-control input-sm" type="text" id="total" readonly="true">
                              </div>

                              <div class="col-lg-2">
                                <label class="">No of Samples</label>
                                <input type="number" class="form-control input-sm" id="no" >
                              </div>

                              <div class="col-lg-2">

                              <label>Size</label>
                              <select class="form-control select2" id="Size_dropdown">
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                                <option value="Extra-Large">Extra-Large</option>
                                </select>
                              </div>



                              <div class="col-lg-1">   
                                <label for="">Add</label>                         
                                <a class="btn btn-primary btnAdd1 addmodal"><i class="fa fa-plus"></i></a>
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
              <h2>Production Cost</h2>
							<div id="no-more-tables">
								<table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table6">
									<thead class="cf tbl_thead">
										<tr>
											<th class="numeric">Sr#</th>
                      <th >Design Id</th>
											<th >Material Name</th>
											<th >Unit</th>
											<th >QTY</th>
											<th >Rate</th>
											<th >Cost</th>
											<th>Size</th>
                      <th>Amount</th>
                      <th>Material_Cost</th>
                      <th>Production_Cost</th>
										</tr>
									</thead>
										<tbody>

									</tbody>
								</table>
							</div>

              <label> </label>     
          
                            <div class="col-lg-3">
                            <label>Total Material Cost </label>
                            <input class="form-control input-sm" type="number" id="total_m"  readonly="true" value=0>
                            </div>
                            
                            <div class="col-lg-3">
                            <label>Total Production Cost </label>
                            <input class="form-control input-sm" type="number" id="total_p"  readonly="true" value=0>
                            </div>
                             <div class="row"></div>

					
                            <h2>Material Cost</h2>
							<div id="no-more-tables">
								<table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table7">
									<thead class="cf tbl_thead">
										<tr>
											<th class="numeric">Sr#</th>
											<th >Material Name</th>
											<th >Unit</th>
											<th >QTY</th>
											<th >Rate</th>
											<th >Cost</th>
											<th>Remarks</th>
										</tr>
									</thead>
										<tbody>

									</tbody>
								</table>
							</div>
						

					
                        
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