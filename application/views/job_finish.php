

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
				<h1 class="page_title">Update Job Card</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">

							<div class="row">

								<div class="panel panel-default">
									<div class="panel-body">
										<!-- <button type="button" class="alert-message" data-dismiss="alert">
										  <span aria-hidden="true">&times;</span>
										  <span class="sr-only">Close</span>
										</button> -->
										<div class="row">
											
                                        <div class="col-lg-1">

                                        <label class="VoucherNoLable">Sr#</label>
                                        <input type="number" class="form-control input-sm VoucherNo" id="id" >
                                      
                                      </div>
                                      
                                      <div class="col-lg-3">
                                        <label class="">Job Detail</label>
                                        <input type="text" class="form-control input-sm" id="detail" readonly="">
                                      </div>

                                      <div class="col-lg-2">
                                      <label class="">Empolyee</label>
                                      <input type="text" class="form-control input-sm" id="emp" >
                                      </div>

                                    <div class="col-lg-2">
                                        <label class="">Department</label>
                                        <input type="text" class="form-control input-sm" id="dept" >
                                    </div>
                
                                      <div class="col-lg-2">
                                      <label class="">Rate</label>
                                      <input type="number" class="form-control input-sm " id="rate" readonly="">
                                      </div> 

                                      <div class="col-lg-2">
                                      <label class="">QTY</label>
                                      <input type="number" class="form-control input-sm " id="qty"  readonly="">
                                      </div> 
                                
     
                                      


                     
                    </div>

							<div class="row">

                            <div class="col-lg-2">
                            <label class="">Amount</label>
                            <input type="number" class="form-control input-sm " id="amount" readonly="">
                            </div> 
                              
                            <div class="col-lg-2">
                            <label class="">Start Date</label>
                            <input class="form-control input-sm" type="date" id="s_date" value="';echo date('Y-m-d');;echo '" readonly="">
                            </div>   

                          <div class="col-lg-2">
                          <label class="">End Date</label>
                          <input class="form-control input-sm" type="date" id="e_date" value="';echo date('Y-m-d');;echo '" readonly="" >
                          </div>
    
                          <div class="col-lg-2">
                            <label class="">Status</label>
                            <select class="form-control select2" id="status">
                            <option value="Early">Early</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Pending">Pending</option>
                            <option value="late">Late</option>
                            
                            </select>
                          </div>  
                          
                          <div class="col-lg-2">
                          <label class="">Finish Date</label>
                          <input class="form-control input-sm" type="date" id="f_date" value="';echo date('Y-m-d');;echo '"  >
                          </div>   

                          <div class="col-lg-2">
                          <label class="">Received Qty</label>
                          <input class="form-control input-sm" type="number" id="r_qty"   >
                          </div>   

                          <div class="col-lg-2">
                          <label class="">Balance</label>
                          <input class="form-control input-sm" type="number" id="balance" readonly="">
                          </div>
                          
                          <div class="col-lg-2">   
                          <label for="">Add</label>                         
                          <a class="btn btn-primary btnAdd2 addmodal"><i class="fa fa-plus"></i></a>
                          </div>

                            <div class="container">
                                <div class="pull-right">
                                    <label>&nbsp</label>
                                    <a class="btn btn-sm btn-default btnupdate" ><i class="fa fa-save"></i> &nbspUpdate &nbsp</a>
                                    <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i>&nbsp Reset &nbsp</a>
                                    
                                </div>
                            </div>


							</div>
                            <div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table2">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >ID</th>
                                                <th >Job_Detail</th>
                                                <th >Empolyee</th>
                                                <th >dept</th>
                                                <th >Qty</th>
                                                <th >Rate</th>
                                                <th >Amount</th>
                                                <th >Start Date</th>
                                                <th >End Date</th>
                                                <th >Received</th>
                                                <th >Balance</th>
                                                <th >Status</th>
                                                <th>Action</th>
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
					</form>   <!-- end of form -->
				</div>  <!-- end of col -->
			</div>  <!-- end of container fluid -->
		</div>   <!-- end of page_content -->
	</div>
</div>
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
';
?>