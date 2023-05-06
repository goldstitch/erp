

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
				<h1 class="page_title">Job Card</h1>
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
                                        <input type="number" class="form-control input-sm VoucherNo" id="txtVrnoa" >
                                      
                                      </div>

                                      <div class="col-lg-1">
                                      <label class="">Sample Card Id</label>
                                      <input type="text" class="form-control input-sm" id="s_id" >
                                    </div>
                                      
                                      <div class="col-lg-4">
                                        <label class="">Job Detail</label>
                                        <input type="text" class="form-control input-sm" id="detail" >
                                      </div>

                                    <div class="col-lg-2">

                                    <label for="">Finsihed Item<img id="imgItemLoader" 
                                    class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
                                    <input type="text" class="form-control" id="txtItemId" >
                                    <input id="hfItemId2" type="hidden" value="" />

        
                                  </div>

                                      <div class="col-lg-2">
                                      <label class="">Design Article</label>
                                      <input type="text" class="form-control input-sm" id="design_no" >
                                    </div>

                                      <div class="col-lg-2">
                                      <label>Emp Id</label>
                                      <input type="number" class="form-control" id="emp_id">
                                    </div>


                    </div>

							<div class="row">

                            <div class="col-lg-2">
                              <label class="">Empolyee</label>
                              <input type="text" class="form-control input-sm" id="emp" readonly="">
                            </div>

                            <div class="col-lg-2">
                              <label class="">Department</label>
                              <input type="text" class="form-control input-sm" id="dept" readonly="">
                            </div>

                            <div class="col-lg-2">
                            <label class="">Rate</label>
                            <input type="number" class="form-control input-sm " id="rate" >
                            </div> 
                                            
                            <div class="col-lg-2">
                            <label class="">QTY</label>
                            <input type="number" class="form-control input-sm " id="qty"  >
                            </div> 

                            <div class="col-lg-2">
                            <label class="">Amount</label>
                            <input type="number" class="form-control input-sm " id="amount"  readonly="">
                            </div> 
                              
                            <div class="col-lg-2">
                            <label class="">Start Date</label>
                            <input class="form-control input-sm" type="date" id="s_date" value="';echo date('Y-m-d');;echo '" >
                            </div>    



                          <div class="col-lg-2">
                          <label class="">End Date</label>
                          <input class="form-control input-sm" type="date" id="e_date" value="';echo date('Y-m-d');;echo '" >
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
                            <div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table1">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >ID</th>
                                                <th >Sample_Id</th>
                                                <th >Job_Detail</th>
                                                <th >Article</th>
                                                <th >Employee</th>
                                                <th >Dept</th>
                                                <th >Item Desc</th>
                                                <th >Qty</th>
                                                <th >Rate</th>
                                                <th >Amount</th>
                                                <th >Start Date</th>
                                                <th >End Date</th>
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