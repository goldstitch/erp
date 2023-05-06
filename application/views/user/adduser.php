

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
;echo '<!-- main content -->

<div id="main_wrapper">
  	<div class="page_bar">
    	<div class="row">
      		<div class="col-md-12">
        		<h1 class="page_title">Add User</h1>
      		</div>
    	</div>
  	</div>
  	<div class="page_content">
    	<div class="container-fluid">

			<div class="row">
		      	<div class="col-md-12">

		        	<form action="">

						<div class="row">
							<div class="panel panel-default">
								<div class="panel-body">

									<div class="row">
										<div class="col-lg-2">
											<div class="input-group">
				                            	<span class="input-group-addon">User Id</span>
				                            	<input type="number" class="form-control num txtidupdate" id="txtId" data-txtidupdate=\'';echo $vouchers['user']['update'];;echo '\'>
			                                    <input type="hidden" id="txtMaxIdHidden">
			                                    <input type="hidden" id="txtIdHidden">
			                                    
			                                    <input type="hidden" name="uuid" id="uuid" value="';echo $this->session->userdata('uid');;echo '">
                                                <input type="hidden" name="uuname" id="uuname" value="';echo $this->session->userdata('uname');;echo '">
                                                <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
					                        </div>
										</div>										
									</div>
									<div class="row">
										<div class="col-lg-4">
				                          	<div class="input-group">
				                            	<span class="input-group-addon">User Name</span>
				                            	<input type="text" class="form-control" id="txtUsername">
					                        </div>
				                        </div>
									</div>
									<div class="row">
										<div class="col-lg-4">
				                          	<div class="input-group">
				                            	<span class="input-group-addon">Password</span>
				                            	<input type="password" class="form-control" id="txtPassowrd">
					                        </div>
				                        </div>
									</div>
									<div class="row">
										<div class="col-lg-4">
				                          	<div class="input-group">
				                            	<span class="input-group-addon">Full Name</span>
				                            	<input type="text" class="form-control" id="txtFullName">
					                        </div>
				                        </div>
									</div>
									<div class="row">
										<div class="col-lg-4">
				                          	<div class="input-group">
				                            	<span class="input-group-addon">Email</span>
				                            	<input type="text" class="form-control" id="txtEmail">
					                        </div>
				                        </div>
									</div>
									<div class="row">
										<div class="col-lg-4">
				                          	<div class="input-group">
				                            	<span class="input-group-addon">Mobile#</span>
				                            	<input type="text" class="form-control num" id="txtMobileNo">
					                        </div>
				                        </div>
									</div>
									<div class="row">
										<div class="col-lg-4">
											<div class="input-group">
												<span class="input-group-addon">Role</span>
												<select class="form-control" id="role_dropdown">
													<option value="" disabled="" selected="">Choose role</option>
													';foreach ($pgroups as $rolegroup): ;echo '										
														<option value="';echo $rolegroup['rgid'];;echo '">';echo $rolegroup['name'];;echo '</option>
													';endforeach;;echo '												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
											<div class="input-group">
												<span class="input-group-addon">Company</span>
												<select class="form-control" id="company_dropdown">
													<option value="" disabled="" selected="">Choose Company</option>
													';foreach ($companies as $company): ;echo '										
														<option value="';echo $company['company_id'];;echo '">';echo $company['company_name'];;echo '</option>
													';endforeach;;echo '												</select>
											</div>
										</div>
										<div class="col-lg-3" >
		                                    <div class="input-group">
		                                        <span class="input-group-addon">User: </span>
		                                        <select class="form-control " disabled="" id="user_dropdown">
		                                            <option value="" disabled="" selected="">...</option>
		                                            ';foreach ($userone as $user): ;echo '		                                                <option value="';echo $user['uid'];;echo '">';echo $user['uname'];;echo '</option>
		                                            ';endforeach;;echo '		                                        </select>
		                                    </div>
                                        </div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<div class="pull-right">
												<!-- <a href=\'\' class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['add_new_user']['insert'];;echo '\'> <i class="fa fa-save"></i> -->
												<a href=\'\' class="btn btn-default btnSave"  <i class="fa fa-save"></i>
													Save F10
												</a>
												<a href=\'\' class="btn btn-default btnReset"> <i class="fa fa-refresh"></i>
													Reset F5
												</a>
											</div>
										</div>
									</div> <!-- end of row -->

								</div>
							</div>

						</div>

		        	</form>   <!-- end of form -->

		      	</div>  <!-- end of col -->
	      	</div>

    	</div>  <!-- end of container fluid -->
  	</div>   <!-- end of page_content -->
</div>';
?>