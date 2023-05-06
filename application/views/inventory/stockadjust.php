

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/



;echo '<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">stock Adjustment Form</h1>
			</div>
		</div>


	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">
				
				<div class="tab-content">
					<div id="add_item" class="tab-pane fade active in">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel panel-default">
									<div class="panel-body">
									 <h4><b>Enter Adjustment Value : </b></pre> <input type="number" id="qty" value="">  
									 <div class="col-lg-3">
									   <div class="input-group">
										 <span class="input-group-addon txt-addon VoucherNoLable">Date</span>
					                  	<input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
								   </div></h4>
									 
						
									 <div class="row">
                           
                   <table class="table table-striped table-hover ar-datatable" id ="disc_table">
                   <thead>
                     <tr>
                       <th style=\'background: #368EE0;\'>Sr#</th>
					   <th style=\'background: #368EE0;\'>Item Id</th>
					   <th style=\'background: #368EE0;\'>Item Des</th>
                       <th style=\'background: #368EE0;\'>location</th>
                       <th style=\'background: #368EE0;\'>qty</th>
                       
          
                          
                       
                     </tr>
                   </thead>
                   <tbody>
                     ';if (count($item) >0): ;echo '													';$counter = 1;foreach ($item as $items): ;echo '	
                                               <tr>
                           <td>&nbsp&nbsp&nbsp&nbsp&nbsp  ';echo $counter++;;echo '</td>
						   
                           <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ';echo $items['item_id'];;echo'</td>
                           <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ';echo $items['NAME'];;echo'</td>
                           <td >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ';echo $items['dept_name'];;echo '</td>
                           <td >&nbsp&nbsp&nbsp&nbsp ';echo $items['qty'];;echo '</td>
						   <td><div class="btn btn-sm btn-primary btnadjust showallupdatebtn" data-transporter_id="';echo $items['item_id'];;echo '" data-transporter2_id="';echo $items['did'];;echo '" data-transporter3_id="';echo $items['qty'];;echo '"><span class="fa fa-edit"></span></div></td>
 
                         </tr>
                       ';endforeach ;echo '												';endif ;echo '											</tbody>
                 </table>
							</div>
									</div>
								</div>
							</div> 
						</div>

					</div> <!-- end of search_branch -->
				</div>
			</div>
		</div>
	</div>
</div>
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
<script src="';echo base_url('assets/js/app_modules/inventory/addstocktransfer.js');;echo '"></script>
<script src="';echo base_url('assets/js/ddtf.js');;echo '"></script>

;'

?>

<script>$('#disc_table').ddTableFilter();</script>