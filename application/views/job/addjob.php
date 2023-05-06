

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
				<h1 class="page_title">Add Job</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">

				<form action="">

					<div class="row">

						<div class="panel panel-default">
							<div class="panel-body">

								<div class="row">
									<div class="col-lg-12">
										<div class="row">
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon id-addon">Job#</span>
                                                    <input type="text" class="form-control" id="txtVrnoa" >
                                                    <input type="hidden" id="txtMaxVrnoaHidden">
                                                    <input type="hidden" id="txtVrnoaHidden">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Date</span>
                                                    <input class="form-control" type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Vr#</span>
                                                    <input type="text" class="form-control" id="txtVrno" readonly=\'true\'  style=\'border: 1px solid #AD7C7C; color: #000; background: white;\'>
                                                    <input type="hidden" id="txtMaxVrnoHidden">
                                                    <input type="hidden" id="txtVrnoHidden">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">

                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Party Name</span>
                                                    <select class="form-control select2" id="party_dropdown">
                                                        <option value="" disabled="" selected="">Choose party</option>
                                                        ';foreach ($parties as $party): ;echo '                                                            <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>

                                            </div>
                                        </div>

										<div class="row">
											<div class="col-lg-12">
												<div class="input-group">
													<span class="input-group-addon">Remarks</span>
													<input type="text" class="form-control" id="txtRemarks"/>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-12">
												<textarea id="other_textarea" cols="30" rows="6" class="form-control" placeholder=\'Other Description\'></textarea>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-3">
                                                <label>Job Type</label>
                                                <div class="form-group">
													<label class="radio-inline">
														<input type="radio" name="job_type" id="radio_trf" value="TRF" checked="">
														TRF
													</label>
													<label class="radio-inline">
														<input type="radio" name="job_type" id="radio_sgp" value="SGO">
														SGP
													</label>
												</div>
                                            </div>
										</div>

										<div class="row">
											<div class="col-lg-3">
												<div class="input-group">
													<span class="input-group-addon txt-addon">Type</span>
													<input type="text" list="types" class="form-control" id="list_type"/>
													<datalist id=\'types\'>
													</datalist>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="input-group">
													<span class="input-group-addon txt-addon">Status</span>
													<input type="text" list="statuses" class="form-control" id="list_status"/>
													<datalist id=\'statuses\'>
													</datalist>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Cost Account</span>
                                                    <select class="form-control select2" id="costaccount_dropdown">
                                                        <option value="" disabled="" selected="">Choose party</option>
                                                        ';foreach ($parties as $party): ;echo '                                                            <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                            </div>
										</div>

										<div class="row">
											<div class="col-lg-12">
												<div class="pull-right">													
	                                                <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
	                                                <a class="btn btn-primary btnSave"><i class="fa fa-save"></i> Save Changes</a>
												</div>
                                            </div>
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
</div>';
?>