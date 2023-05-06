

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
$vouchers = $desc['vouchers'];
;echo '
<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-lg-3">
				<h1 class="page_title">Salary Sheet</h1>
			</div>
			<div class="col-lg-9">
				<div class="pull-right">
                    <div class="btn-group">
                          <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                          <li ><a href="#" class="btnPrint"> Pdf F9</a></li>
                          <li ><a href="#" class="btnPrint2"> Html</a></li>
                            
                          </ul>
                    </div>
                	<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['salary_sheet']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['salary_sheet']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['salary_sheet']['delete'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
                    <a href="" class="btn btn-default btnDelete" data-deletetbtn=\'';echo $vouchers['salary_sheet']['delete'];;echo '\'><i class="fa fa-trash-o"></i> Delete</a>
                    <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
                </div>
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
								<div class="col-lg-2">
                                  	<div class="input-group">
                                      	<span class="input-group-addon id-addon">Vr#</span>
                                      	<input type="number" class="form-control num txtidupdate" data-txtidupdate=\'';echo $vouchers['salary_sheet']['update'];;echo '\' id="txtId">
                                      	<input type="hidden" id="txtMaxIdHidden">
                                      	<input type="hidden" id="txtIdHidden">
                                      	<input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
										<input type="hidden" id="voucher_type_hidden">
										<input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                        <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                        <input type="hidden" id="salaryid" value="';echo $setting_configur[0]['salary'];;echo '">
                                        <input type="hidden" id="salarypayableid" value="';echo $setting_configur[0]['salarypayable'];;echo '">

                                	</div>
								</div>
                            	<div class="col-lg-3">
                                	<div class="input-group">
                                    	<span class="input-group-addon txt-addon">From Month</span>
                                    	<input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                	</div>
                                </div>

                                <div class="col-lg-3">
                                	<div class="input-group">
                                    	<span class="input-group-addon txt-addon">To Month</span>
                                    	<input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                	</div>
                                </div>
                                <div class="col-lg-4">
									<div class="pull-right">
										<a class="btn btn-default btnSearch"><i class="fa fa-search"></i> Show</a>
									</div>
								</div>
							</div>

							<div class="row hide">
								<div class="col-lg-3">									
									<select class="form-control" id="name_dropdown">
	                                	';foreach ($accounts as $account): ;echo '                                          	<option value="';echo $account['pid'];;echo '">';echo $account['name'];;echo '</option>
                                      	';endforeach ;echo '	                                </select>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>	<!-- end of configuration -->

			<div class="row">
				<div class="col-lg-12">

					<div class="panel panel-default">
						<div class="panel-body">
							

							<div class="row" style=\'overflow-y: auto; min-height: 239px;\'>
								<div class="col-lg-12">									
									<table class="table table-striped table-hover" id="salary_table">
										
										<thead>
											<!--<th>Sr#</th>
											<th>Department</th>
											<th>Employee Name</th>
											<th>Designation</th>
											<th>Basic Salary</th>
											<th>Absents</th>
											<th>Leave WP</th>
											<th>Leave WOP</th>
											<th>Rest Days</th>
											<th>Work Days</th>
											<th>Paid Days</th>
											<th>Gross Salary</th>
											<th>Overtime</th>
											<th>OT Rate</th>
											<th>OT Amount</th>
											<th>Advance</th>
											<th>Loan Deduction</th>
											<th>Remaining Balance</th>
											<th>Incentive</th>
											<th>Penalty</th>
											<th>EOBI</th>
											<th>Insurance</th>
											<th>Social Security</th>
											<th>Net Salary</th>-->
                                            <th class=\'text-left\'>Sr#</th>
                                            <th class=\'text-left\'>Department</th>
                                            <th class=\'text-left\'>Id</th>
                                            <th class=\'text-left\'>Employee Name</th>
                                            <th class=\'text-left\'>S/D/W/O</th>
                                            <th class=\'text-left\'>Designation</th>
                                            <th class=\'text-right\'>Basic Salary</th>
                                            <th class=\'text-right hide\'>Absents</th>
                                            <th class=\'text-right hide\'>Leave WP</th>
                                            <th class=\'text-right hide\'>Leave WOP</th>
                                            <th class=\'text-right hide\'>Gusted Holiday</th>
                                            <th class=\'text-right hide\'>Outdoor</th>
                                            <th class=\'text-right hide\'>Short Leave</th>
                                            <th class=\'text-right hide\'>Rest Days</th>
                                            <th class=\'text-right hide\'>Work Days</th>
                                            <th class=\'text-right\'>Paid Days</th>
                                            <th class=\'text-right\'>Salary</th>
                                            <th class=\'text-right\'>Ot Hour</th>
                                            <th class=\'text-right\'>OT Rate</th>
                                            <th class=\'text-right\'>OT Amount</th>
                                            <th class=\'text-right\'>Incentive</th>
                                            <th class=\'text-right\'>G Salary</th>
                                            <th class=\'text-right\'>Advance</th>
                                            <th class=\'text-right\'>Loan Deduction</th>
                                            <th class=\'text-right hide\'>Remaining Balance</th>
                                            <th class=\'text-right\'>Penalty</th>
                                            <th class=\'text-right hide\'>EOBI</th>
                                            <th class=\'text-right hide\'>Insurance</th>
                                            <th class=\'text-right hide\'>Social Security</th>
                                            <th class=\'text-right\'>Net Salary</th>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="pull-right">
										<a class="btn btn-default btnPrintSlips" data-printtbtn=\'';echo $vouchers['salary_sheet']['print'];;echo '\'><i class="fa fa-print"></i> Print Slips</a>
					                    <div class="btn-group">
					                          <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
					                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					                            <span class="caret"></span>
					                            <span class="sr-only">Toggle Dropdown</span>
					                          </button>
					                          <ul class="dropdown-menu" role="menu">
					                          <li ><a href="#" class="btnPrint"> Pdf F9</a></li>
					                          <li ><a href="#" class="btnPrint2"> Html</a></li>
					                            
					                          </ul>
					                    </div>
					                	<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['salary_sheet']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['salary_sheet']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['salary_sheet']['delete'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
					                    <a href="" class="btn btn-default btnDelete" data-deletetbtn=\'';echo $vouchers['salary_sheet']['delete'];;echo '\'><i class="fa fa-trash-o"></i> Delete</a>
					                    <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
					                </div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<style>
    .well-sm
    {
        display: block !important;
        background: transparent !important;
    }
    .clearfix
    {
        height: 54px;
    }
    .well
    {
        margin-bottom: -5px !important;
    }
    td:contains-selector(span.hide) { display:none !important; }
</style>
<input id="hfSalaryPlane" type="hidden" value="';echo $salaryPlane;;echo '">';
?>