

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
				<h1 class="page_title">Department Listings</h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="pull-right">
						<a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print</a>
                    </div>
				</div>
			</div>
			<div class="row">
					<div class="panel panel-default">
						<div class="panel-body">
							
								<table class="table table-striped table-hover ar-datatable">
									<thead>
										<tr>
											<th>Sr#</th>
											<th>Name</th>
											<th>Strength</th>
											<th>Description</th>
										</tr>
									</thead>
									<tbody>
										';$counter = 1;foreach ($departments as $department): ;echo '											<tr>
												<td>';echo $counter++;;echo '</td>
												<td>';echo $department['name'];;echo '</td>
												<td>';echo $department['strength'];;echo '</td>
												<td>';echo $department['description'];;echo '</td>
											</tr>
										';endforeach ;echo '									</tbody>
								</table>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>';
?>