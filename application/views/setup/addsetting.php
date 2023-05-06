

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
				<h1 class="page_title">Settings</h1>
			</div>
			<div class="col-lg-9">
				<div class="pull-right">
					<a class="btn btn-default btnSave" data-insertbtn=\'';echo $vouchers['department']['insert'];;echo '\'><i class="fa fa-save"></i> Save Changes</a>
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

								<form action="">

									<div class="row">
										<div class="col-lg-3">
											<div class="input-group" >
												<span class="input-group-addon" style="width: 293px;">Salary Calculation</span>
	                                          	<select class="form-control" id="sal_dropdown">
	                                          		';if ($sal_calc == "monthday"): ;echo '	                                            		<option value=\'monthday\' selected="">Month Day</option>
	                                            		<option value=\'30days\'>30 Days</option>
	                                          		';else: ;echo '	                                          			<option value=\'monthday\'>Month Day</option>
	                                            		<option value=\'30days\' selected="">30 Days</option>
	                                          		';endif;;echo '	                                          	</select>
											</div>
										</div>
									</div>

								</form>	<!-- end of form -->

							</div>	<!-- end of panel-body -->
						</div>	<!-- end of panel -->
					</div>  <!-- end of col -->
				</div>	<!-- end of row -->


			</div>
		</div>
	</div>
</div>';
?>