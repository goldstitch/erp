

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Account Ledger</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
                            	<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
                            	<div class="col-lg-2">
                                	<label>From</label>
                                	<input class="form-control" type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                </div>
                                <div class="col-lg-2">
                                	<label>To</label>
                                	<input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                </div>
								<div class="col-lg-3">
									<label>Account</label>
									<div class="input-group" >
										<select class="form-control select2" id="name_dropdown">
											<option value="" disabled="" selected="">Choose account</option>
		                                	';foreach ($parties as $party): ;echo '	                                          	<option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
	                                      	';endforeach ;echo '		                                </select>
		                                <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#party-lookup" data-toggle="modal" href="#addCategory" rel="tooltip"
	                                    data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Search Account (F1)"><i class="fa fa-search"></i></a>
                                    </div>
								</div>
<div id="party-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 id="myModalLabel">Party Lookup</h3>
            </div>

                <div class="modal-body">
                <table class="table table-striped modal-table">
                <!-- <table class="table table-bordered table-striped modal-table"> -->
                <thead>
                <tr style="font-size:16px;">
                <th>Id</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Address</th>
                <th style=\'width:3px;\'>Actions</th>
                </tr>
                </thead>
                <tbody>
                ';foreach ($parties as $party): ;echo '                <tr>
                <td width="14%;">
                ';echo $party['account_id'];;echo '                <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                </td>
                <td>';echo $party['name'];;echo '</td>
                <td>';echo $party['mobile'];;echo '</td>
                <td>';echo $party['address'];;echo '</td>
                <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa-li fa fa-check-square"></i></a></td>
                </tr>
                ';endforeach ;echo '                </tbody>
                </table>
                </div>
                <div class="modal-footer">
                <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
								<div class="col-lg-5">
									<label>.</label>
									<div class="pull-right">
										<a class="btn btn-default btnSearch"><i class="fa fa-search"></i> Show F6</a>
										<a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
										<div class="btn-group">
                                          <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                          </button>
                                          <ul class="dropdown-menu" role="menu">
                                            <li ><a href="#" class="btnPrint3">Print F7</li>
                                            <li ><a href="#" class="btnPrint">Pdf F8</li>
                                            <li><a href="#" class="btnPrintExcel">Excel</li>
                                            <li><a data-toggle="modal" href="#addEmail" rel="tooltip"
                                                        data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</li>
                                          </ul>
                                        </div>
										<a class="btn btn-default btnPrint2"><i class="fa fa-print"></i> Account Flow F8</a>
										
									</div>
								</div>
                                 
                                 
                              
													
													<div class="col-lg-3">
                                                    <label></label>
                                                    <label>Select Status</label>
														<div class="input-group">
                                                        <select class="form-control input-sm" id="status_dropdown">
                                                        <option value="1">All</option>
                                                        <option value="posted">Posted</option>
                                                        <option value="unpost">Unposted</option>
															</select>
														</div>														
													</div>
												

                                

                        
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">

							<div class="row">
                                <div class="pull-right acc_ledger">
                                    <ul class="stats">
                                        <li class=\'blue\'>
                                            <div class="details">
                                                <span class="big opening-bal">0.00</span>
                                                <span>Opening Balance</span>
                                            </div>
                                        </li>
                                        <li class=\'red\'>
                                            <div class="details">
                                                <span class="big net-debit">0.00</span>
                                                <span>Total Debit</span>
                                            </div>
                                        </li>
                                        <li class=\'green\'>
                                            <div class="details">
                                                <span class="big net-credit">0.00</span>
                                                <span>Total Credit</span>
                                            </div>
                                        </li>
                                        <li class=\'brown\'>
                                            <div class="details">
                                                <span class="big running-total">0.00</span>
                                                <span>Closing Balance</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
							</div>
							
							<div class="row">
                            <div id="no-more-tables">								
								<table class="col-lg-12 table-bordered table-striped table-condensed cf" id="datatable_example">
									<thead class="cf dthead">
										<tr>
											<th class="numeric">Sr#</th>
                                            <th >Unit</th>
                                            <th width="50">Date</th>
					 						<th class="numeric">Voucher</th>
											<th >Description</th>
                                            <th >Status</th>
                                            <th >Inv/Chq#</th>
                                            <th >WO#</th>

											<th style="text-align: right;" class="numeric">Debit</th>
											<th style="text-align: right;" class="numeric">Credit</th>
											<th style="text-align: right;" class="numeric">Total</th>
                                            <th >Dr/Cr</th>
										</tr>
									</thead>
									<tbody class="report-rows saleRows">
									</tbody>
								</table>
                            </div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="addEmail" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background:#76c143;color:white;padding-bottom:20px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×</button>
                <h3 id="myModalLabel">Email</h3>
            </div>

            <div class="modal-body">
                <div style="padding: 10px;">
                    <div class="form-row control-group row-fluid">
                        <label>Enter email address here:</label>
                        <input id="txtAddEmail" type="text" style="width: 80%;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">
                    Close</button>
                <button id="btnSendEmail" class="btn btn-primary">
                    Send</button>
            </div>
        </div>
    </div>
</div>';
?>