

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
			<h3>Minimum Stock Alerts</h3>			
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th style="width: 300px;">Product</th>
						<th style="width: 300px;">Supplier</th>
						<th>Current Stock</th>
						<th>Minimum Level</th>
						<th>Order Value</th>
						<th>@ Pur.</th>
					</tr>
				</thead>
				<tbody>
						';foreach ($notifications as $notif): ;echo '							<tr>
								<th class="rows-th">';echo $notif['description'];;echo '</th>	
								<td style="">';echo $notif['supplier'];;echo '</td>	
								<td style="text-align: right !important;">';echo $notif['curr_stock'];;echo '</td>	
								<td style="text-align: right !important;">';echo $notif['min_level'];;echo '</td>	
								<td style="text-align: right !important;">';echo $notif['order_value'];;echo '</td>	
								<td style="text-align: right !important;">';echo $notif['prate'];;echo '</td>	
							</tr>
						';endforeach ;echo '				</tbody>
			</table>
		</div>
	</div>
</div>
';
?>