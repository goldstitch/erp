

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
      		<div class="col-md-12">
        		<h1 class="page_title">Privillage Group</h1>
      		</div>
    	</div>
  	</div>

  	<div class="page_content">
    	<div class="container-fluid">

			<div class="row">
		      	<div class="col-md-12">

		        	<form action="">

						<div class="row">
							<div class="col-lg-1">
                            	<label for="">Group Id</label>
                            	<input type="number" class="form-control num txtidupdate" id="txtId" data-txtidupdate=\'';echo $vouchers['previllages']['update'];;echo '\'>
                                <input type="hidden" id="txtMaxIdHidden">
                                <input type="hidden" id="txtIdHidden">
                                <input type="hidden" id="vouchertypehidden">
							</div>
							<div class="col-lg-3">
                            	<label for="">Group Name</label>
                            	<input type="text" class="form-control" id="txtName">
	                        </div>
							<div class="col-lg-8">
								<div class="pull-right">
									<a href=\'\' class="btn btn-default btn-lg btnSave" data-insertbtn=\'';echo $vouchers['previllages']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['previllages']['update'];;echo '\'> <i class="fa fa-save"></i>
										Save F10
									</a>
									<a href=\'\' class="btn btn-default btn-lg btnReset"> <i class="fa fa-refresh"></i>
										Reset F5
									</a>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="panel panel-default">
								<div class="panel-body">

									<div class="row">
										<div class="col-lg-12">
											<span><a href="#" id=\'checkAll\'>Check All</a></span> / <span><a href="#"  id=\'uncheckAll\'>Uncheck All</a></span>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6 columns col1">
											<span class=\'txtshadow\'>Vouchers</span>
											<hr>
											<div class="vrprivillages"></div>
										</div>

										<div class="col-lg-6 columns col2">
											<span class=\'txtshadow\'>Reports</span>
											<hr>
											<div class="rptprivillages"></div>
										</div>
									</div>

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