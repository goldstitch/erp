

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h3>Payables / Receiveables</h3>
			<div class="">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#payablesTab" data-toggle="tab">Payables</a></li>
					<li><a href="#receiveablesTab" data-toggle="tab">Receiveables</a></li>
				</ul>
			</div>
			<div class="tab-content">
				<div class="tab-pane active" id="payablesTab">
					<!-- <a href="#" class="btn btn-primary btnprint" style="margin-bottom: 10px;">Print</a> -->
					<table class="table table-bordered table-hover table-striped tblPayable">
						<thead>
							<tr>
								<th>#</th>
								<th>Account</th>
								<th>Address</th>
								<th>Email</th>
								<th>Mobile</th>
								<!-- <th>Phone#</th> -->
								<th>Balance</th>
							</tr>
						</thead>
						<tbody>
							';
$counter = 1;
foreach ($payables as $payable): ;echo '								<tr>
								  <td class="no_sort tblSerial">';echo $counter++;;echo '</td>
								  <td class="no_sort tblParty">';echo $payable['ACCOUNT_NAME'];;echo '</td>
								  <td class="no_sort tblAddress">';echo $payable['ADDRESS'] ?$payable['ADDRESS'] : '<span style="text-align:center; display:block;">-</span>';;echo '</td>
								  <td class="no_sort tblEmail">';echo $payable['EMAIL'] ?$payable['EMAIL'] : '<span style="text-align:center; display:block;">-</span>';;echo '</td>
								  <td class="no_sort tblMobile">';echo $payable['MOBILE'] ?$payable['MOBILE'] : '<span style="text-align:center; display:block;">-</span>';;echo '</td>
								  <!-- <td class="no_sort tblPhone">';echo $payable['phone_off'] ?$payable['PHONE_OFF'] : '<span style="text-align:center; display:block;">-</span>';;echo '</td> -->
								  <td class="no_sort tblBalance" style="text-align:right; !important">';echo $payable['BALANCE'];;echo '</td>
								</tr>
							';endforeach;;echo '						</tbody>
					</table>
				</div>
				<div class="tab-pane" id="receiveablesTab">
					<!-- <a href="#" class="btn btn-primary btnprint" style="margin-bottom: 10px;">Print</a> -->
					<table class="table table-bordered table-hover table-striped tblReceiveable">
						<thead>
							<tr>
								<th>#</th>
								<th>Account</th>
								<th>Address</th>
								<th>Email</th>
								<th>Mobile</th>
								<!-- <th>Phone#</th> -->
								<th>Balance</th>
							</tr>
						</thead>
						<tbody>
							';
$counter = 1;
foreach ($receiveables as $receiveable): ;echo '								<tr>
								  <td class="no_sort tblSerial">';echo $counter++;;echo '</td>
								  <td class="no_sort tblParty">';echo $receiveable['ACCOUNT_NAME'];;echo '</td>
								  <td class="no_sort tblAddress">';echo $receiveable['ADDRESS'] ?$receiveable['ADDRESS'] : '<span style="text-align:center; display:block;">-</span>';;echo '</td>
								  <td class="no_sort tblEmail">';echo $receiveable['EMAIL'] ?$receiveable['EMAIL'] : '<span style="text-align:center; display:block;">-</span>';;echo '</td>
								  <td class="no_sort tblMobile">';echo $receiveable['MOBILE'] ?$receiveable['MOBILE'] : '<span style="text-align:center; display:block;">-</span>';;echo '</td>
								  <!-- <td class="no_sort tblPhone">';echo $receiveable['phone_off'] ?$receiveable['phone_off'] : '<span style="text-align:center; display:block;">-</span>';;echo '</td> -->
								  <td class="no_sort tblBalance" style="text-align:right; !important">';echo $receiveable['BALANCE'];;echo '</td>
								</tr>
							';endforeach;;echo '						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="';
;echo '"></script>
	<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
<script>
	$(document).ready(function () {
		$(\'.btnprint\').on(\'click\', function ( ) {
			window.open(base_url + \'application/views/reportPrints/payableReceivable.php\');
		});

		$(\'a[href="\' + window.location.hash + \'"]\').trigger(\'click\');
		
		// $(\'.tblPayable\').dataTable();
		// $(\'.tblReceiveable\').dataTable();
	});
</script>';
?>