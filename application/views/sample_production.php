

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
;echo '
<!-- main content -->
<div id="main_wrapper">

	<div class="page_bar">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page_title">Sample production </h1>
			</div>
		</div>
	</div>

	<div class="page_content">
		<div class="container-fluid">

			<div class="col-md-12">

							<div class="row">

								<div class="panel panel-default">
									<div class="panel-body">
										<!-- <button type="button" class="alert-message" data-dismiss="alert">
										  <span aria-hidden="true">&times;</span>
										  <span class="sr-only">Close</span>
										</button> -->
										<div class="row">
											
                      <div class="col-lg-2">

                        <label class="VoucherNoLable">Sr#</label>
                        <input type="number" class="form-control input-sm VoucherNo" id="txtVrnoa" >
                      
                      </div>
                      
                      <div class="col-lg-2">
                        <label class="">Design</label>
                        <input type="text" class="form-control input-sm" id="design" >
                      </div>

                      <div class="col-lg-2">
                        <label class="">Code</label>
                        <input type="number" class="form-control input-sm " id="code"  readonly="true">
                      </div> 

                      <div class="col-lg-2">
                      <label class="">Designer Name</label>
                      <input type="text" class="form-control input-sm " id="dname" >
                    </div> 

                      <div class="col-lg-2">
                        <label class="">Date</label>
                        <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
					  </div>

                      <div class="col-lg-2">
                        <label class="">Sample unit</label>
                        <select class="form-control select2" id="sunit">
                        <option value="INCH">INCH</option>
                        <option value="METER">METER</option>
                        <option value="PCS">PCS</option>
                        <option value="YARD">YARD</option>
                        </select>
                      </div>                                               



                     
                    </div>

							<div class="row">


                            <div class="col-lg-2">
                            <label class="">Article</label>
                            <select class="form-control select2" id="articles">
                                ';foreach ($arts as $item): ;echo ' <option value="';echo $item['name'];;echo '" >';echo $item['name'];;echo '</option>
                                ';endforeach ;echo '  </select>
                            </div>

								<div class="col-lg-3">
								<label>Category</label>
                                <select class="form-control select2" id="category_dropdown">
                                ';foreach ($cats as $item): ;echo ' <option value="';echo $item['name'];;echo '" >';echo $item['name'];;echo '</option>
                                ';endforeach ;echo '                    </select>
							    </div>
                                    

                            <div class="col-lg-3">

                              <label>Size</label>
                              <select class="form-control select2" id="Size_dropdown">
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                                <option value="Extra-Large">Extra-Large</option>
								</select>
  
                            </div>
  
                          <div class="col-lg-3">
                            <label>Color</label>
                            <select class="form-control select2" id="Color_dropdown">
                            ';foreach ($items as $item): ;echo ' <option value="';echo $item['name'];;echo '" >';echo $item['name'];;echo '</option>
                            ';endforeach ;echo '                    </select>
                          </div>

                            <div class="container">
                                <div class="pull-right">
                                    <label>&nbsp</label>
                                    <a class="btn btn-sm btn-default btnSave" ><i class="fa fa-save"></i> &nbspSave &nbsp</a>
                                    <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i>&nbsp Delete&nbsp </a>
                                    <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i>&nbsp Reset &nbsp</a>
                                    
                                </div>
                            </div>


							</div>

								</div>
								</div>
								</div>

										<div class="row">
											<div class="panel panel-default">
												<div class="panel-body">

                          <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Embroidory</a></li>
                            <li><a data-toggle="tab" href="#menu9">Digital Printing</a></li>
                            <li><a data-toggle="tab" href="#menu2">Fabric & Dying</a></li>
                            <li><a data-toggle="tab" href="#menu3">Cutting & Stitching</a></li>
                            <li><a data-toggle="tab" href="#menu4">Stitching Accessories</a></li>
                            <li><a data-toggle="tab" href="#menu5">Embellishment</a></li>
							<li><a data-toggle="tab" href="#menu6">Press & Packing</a></li>
                            <li><a data-toggle="tab" href="#menu8">Material</a></li>
                            <li><a data-toggle="tab" href="#menu7">Summary</a></li>
  
                          </ul>
                        
                          <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">

                            <div class="col-lg-2">
                            <label>Employee Name</label>
                            <select class="form-control select2" id="emb_name">
                            <option value="" disabled="" selected="">Choose Employee</option>
                            ';foreach ($emb_name as $emb_name): ;echo ' <option value="';echo $emb_name['name'];;echo '" >';echo $emb_name['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

                            <div class="col-lg-2">
                            <label>Fabric Name</label>
                            <select class="form-control select2" id="emb_fname">
                            <option value="" disabled="" selected="">Choose Fabric</option>
                            ';foreach ($fabrics as $fabric): ;echo ' <option value="';echo $fabric['name'];;echo '" data-unit="';echo $fabric['unit'];;echo '">';echo $fabric['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>


                            <div class="col-lg-2">
                            <label>Part Discription</label>
							<select class="form-control select2" id="emb_discription">
                            <option value="" disabled="" selected="">Choose Embroidory</option>
                            ';foreach ($embs as $emb): ;echo ' <option value="';echo $emb['name'];;echo '" data-cost="';echo $emb['cost'];;echo '">';echo $emb['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

                            <div class="col-lg-2">
                            <label>Thread Name</label>
							<select class="form-control select2" id="emb_tname">
                            <option value="" disabled="" selected="">Choose Thread</option>
                            ';foreach ($threads as $thread): ;echo ' <option value="';echo $thread['name'];;echo '" data-rate="';echo $thread['per_unit_rate'];;echo '">';echo $thread['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

                            <div class="col-lg-2">
                            <label>Thread Rate</label>
                            <input class="form-control input-sm" type="number" id="emb_trate"  readonly="true">
                            </div>

                            
                            <div class="col-lg-2">
                            <label>Emb INCH</label>
                            <input class="form-control input-sm" type="number" id="emb_inch">
                            </div>


                            <div class="col-lg-2">
                            <label>Per Stitch Cost</label>
                            <input class="form-control input-sm" type="number" id="emb_stitch" readonly="">
                            </div>

                            <div class="col-lg-2">
                            <label>Stitches qty</label>
                            <input class="form-control input-sm" type="number" id="emb_qty">
                            </div>


                            <div class="col-lg-2">
                            <label>EMB Cost</label>
                            <input class="form-control input-sm" type="number" id="emb_cost" value=0 readonly="true">
                            </div>




                            <div class="col-lg-3">
                            <label>Remarks</label>
                            <input class="form-control input-sm" type="text" id="emb_remark">
                            </div>

							<div class="col-lg-1">   
                            <label for="">Add</label>                         
							<a class="btn btn-primary btnAdd1 addmodal"><i class="fa fa-plus"></i></a>
							</div>

						
                        
							<div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table1">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >Employee Name</th>
                                                <th >Fabric</th>
                                                <th >Part</th>
                                                <th >Emb INCH</th>
                                                <th >Per Stitch Cost</th>
                                                <th >Stitch qty</th>
                                                <th >Emb cost</th>
                                                <th >Thread Name</th>
                                                <th >Thread Rate</th>
												<th >Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

							<div class="col-lg-3">
                            <label>Total</label>
                            <input class="form-control input-sm" type="number" id="emb_total"  readonly="true">
                            </div>

                            <div class="col-lg-2">   
                            <label for="">Total_Cost </label>                         
                            <a class="btn btn-primary get_emb" >Fetch </a>
                            </div>

                            </div>



                            <div id="menu9" class="tab-pane fade ">

                            <div class="col-lg-2">
                            <label>Employee Name</label>
                            <select class="form-control select2" id="dig_name">
                            <option value="" disabled="" selected="">Choose Employee</option>
                            ';foreach ($dig_name as $dig_name): ;echo ' <option value="';echo $dig_name['name'];;echo '" >';echo $dig_name['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

                            <div class="col-lg-2">
                            <label>Fabric Name</label>
                            <select class="form-control select2" id="dig_fname">
                            <option value="" disabled="" selected="">Choose Fabric</option>
                            ';foreach ($fabrics as $fabric): ;echo ' <option value="';echo $fabric['name'];;echo '" data-unit="';echo $fabric['unit'];;echo '">';echo $fabric['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>


                            <div class="col-lg-2">
                            <label>Part Discription</label>
							<select class="form-control select2" id="dig_discription">
                            <option value="" disabled="" selected="">Choose Embroidory</option>
                            ';foreach ($embs as $emb): ;echo ' <option value="';echo $emb['name'];;echo '" data-cost="';echo $emb['cost'];;echo '">';echo $emb['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>


                            <div class="col-lg-2">
                            <label>Cost</label>
                            <input class="form-control input-sm" type="number" id="dig_cost"  >
                            </div>

                            <div class="col-lg-3">
                            <label>Remarks</label>
                            <input class="form-control input-sm" type="text" id="dig_remark">
                            </div>

							<div class="col-lg-1">   
                            <label for="">Add</label>                         
							<a class="btn btn-primary btnAdd8 addmodal"><i class="fa fa-plus"></i></a>
							</div>
                        
							<div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table8">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >Employee Name</th>
                                                <th >Fabric</th>
                                                <th >Part</th>
                                                <th >Cost</th>
												<th >Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

							<div class="col-lg-3">
                            <label>Total</label>
                            <input class="form-control input-sm" type="number" id="dig_total"  readonly="true">
                            </div>

                            <div class="col-lg-2">   
                            <label for="">Total_Cost </label>                         
                            <a class="btn btn-primary get_digital" >Fetch </a>
                            </div>
                             
                              
                            </div>
                           
                            <div id="menu2" class="tab-pane fade">
                              

                            <div class="col-lg-2">
                            <label>Fabric Name</label>
                            <select class="form-control select2" id="f_name">
                            <option value="" disabled="" selected="">Choose Fabric</option>
                            ';foreach ($fabrics as $fabric): ;echo ' <option value="';echo $fabric['name'];;echo '" data-unit="';echo $fabric['unit'];;echo '" data-rate="';echo $fabric['per_unit_rate'];;echo '">';echo $fabric['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

                            <div class="col-lg-2">
                            <label>Unit</label>
                            <input class="form-control input-sm" type="text" id="f_unit" readonly="">
                            </div>

							<div class="col-lg-2">
                            <label>Rate</label>
                            <input class="form-control input-sm" type="number" id="f_rate" readonly="">
                            </div>

                            <div class="col-lg-2" >
                            <label>QTY</label>
                            <input class="form-control input-sm" type="text" id="f_qty">
                            </div>

							<div class="col-lg-2">
                            <label>Fabric Cost</label>
                            <input class="form-control input-sm" type="number" id="f_cost" value=0 readonly="">
                            </div>

                            <div class="col-lg-2">
                            <label>Remarks</label>
                            <input class="form-control input-sm" type="text" id="f_remarks">
                            </div>

                            <div class="col-lg-2">
                            <label>Employee Name</label>
                            <select class="form-control select2" id="fab_name">
                            <option value="" disabled="" selected="">Choose Employee</option>
                            ';foreach ($dye_name as $dye_name): ;echo ' <option value="';echo $dye_name['name'];;echo '" >';echo $dye_name['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

                            <div class="col-lg-2">
                            <label>Dying Name</label>
							<select class="form-control select2" id="f_dyename">
                            <option value="" disabled="" selected="">Choose Dyeing</option>
                            ';foreach ($fabrics as $fabric): ;echo ' <option value="';echo $fabric['name'];;echo '"  data-rate="';echo $fabric['dye_rate'];;echo '">';echo $fabric['name'];;echo '-';echo $fabric['dye_unit'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>
                            

							<div class="col-lg-2">
                            <label>Dying Rate</label>
                            <input class="form-control input-sm" type="number" id="f_dyerate"  readonly="true">
                            </div>

                            <div class="col-lg-1">
                            <label>Dying unit</label>
                            <input class="form-control input-sm" type="number" id="f_dyeunit" >
                            </div>


							<div class="col-lg-2">
                            <label>Dying cost</label>
                            <input class="form-control input-sm" type="number" id="f_dyecost" readonly="" value =0 readonly="">
                            </div>

							<div class="col-lg-2">
                            <label>Total</label>
                            <input class="form-control input-sm" type="number" id="f_total" readonly="">
                            </div>

							

							<div class="col-lg-1">   
                            <label for="">Add</label>                                                  
                          	<a class="btn btn-primary btnAdd2 addmodal"><i class="fa fa-plus"></i></a>
							</div>
                            
							<div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table2">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >Employee Name</th>
                                                <th >Fabric </th>
                                                <th >Unit</th>
                                                <th >Rate</th>
                                                <th >QTY</th>
                                                <th >Fabric cost</th>
                                                <th >Dying</th>
                                                <th >Dying rate</th>
                                                <th >Dying unit</th>
                                                <th >Dying cost</th>
                                                <th >Total cost</th>
												<th >Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

							<div class="col-lg-2">
                            <label>Estimated Time </label>
                            <input class="form-control input-sm" type="text" id="f_esttime">
                            </div>

							<div class="col-lg-2">
                            <label>Fab Total</label>
                            <input class="form-control input-sm" type="number" id="ftotal"  readonly="true">
                            </div>

							<div class="col-lg-2">
                            <label>Dying Total</label>
                            <input class="form-control input-sm" type="number" id="f_dyetotal"  readonly="true">
                            </div>

							<div class="col-lg-2">
                            <label>Sub Total</label>
                            <input class="form-control input-sm" type="number" id="f_subtotal"  readonly="true">
                            </div>

                            <div class="col-lg-2">   
                            <label for="">Total_Cost </label>                         
                            <a class="btn btn-primary get_fab" >Fetch </a>
                            </div>

                            </div>
                            <div id="menu3" class="tab-pane fade">

                            <div class="col-lg-2">
                                <label>Type</label>
                                <select class="form-control select2" id="c_disc">
                                <option value="Cutting">Cutting</option>
                                <option value="hamering">Hamering</option>
                                <option value="stichting">Stichting</option>
                                <option value="overlocking">Overlocking</option>
                                </select>
                            </div> 

                            <div class="col-lg-2">
                            <label>Employee Name</label>
                            <select class="form-control select2" id="c_name">
                            <option value="" disabled="" selected="">Choose Employee</option>
                            ';foreach ($cut_name as $cut_name): ;echo ' <option value="';echo $cut_name['name'];;echo '">';echo $cut_name['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>


                            <div class="col-lg-3">
                            <label>Part Name</label>
                            <select class="form-control select2" id="c_part">
                            <option value="" disabled="" selected="">Choose Part</option>
                            ';foreach ($cut_detail as $cut_detail): ;echo ' <option value="';echo $cut_detail['part'];;echo '" data-rate="';echo $cut_detail['rate'];;echo '">';echo $cut_detail['part'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

							<div class="col-lg-2">
                            <label>Rate</label>
                            <input class="form-control input-sm" type="number" id="c_price" readonly="true">
                            </div>

							 
							<div class="col-lg-2">
                            <label>Remarks</label>
                            <input class="form-control input-sm" type="text" id="c_remark">
                            </div>

							<div class="col-lg-1">   
                            <label for="">Add</label>                                                  
							<a class="btn btn-primary btnAdd3 addmodal"><i class="fa fa-plus"></i></a>
							</div>

							<div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table3">
                                        <thead class="cf tbl_thead">
                                            <tr>

                                                <th class="numeric">Sr#</th>
                                                <th >Discription</th>
                                                <th >Employee Name</th>
                                                <th >part</th>
                                                <th >rate</th>
												<th >Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

							<div class="col-lg-3">
                            <label>Sub Total</label>
                            <input class="form-control input-sm" type="number" id="subtotal"  readonly="true">
                            </div>

                            <div class="col-lg-2">   
                            <label for="">Total_Cost </label>                         
                            <a class="btn btn-primary get_cut" >Fetch </a>
                            </div>

                            </div>

                            
                            <div id="menu4" class="tab-pane fade">
                            
                            <div class="col-lg-2">
                            <label>Name</label>
                            <select class="form-control select2" id="s_name">
                            <option value="" disabled="" selected="">Choose Accessories</option>
                            ';foreach ($accessories as $accessories): ;echo ' <option value="';echo $accessories['name'];;echo '" data-unit="';echo $accessories['unit'];;echo '" data-rate="';echo $accessories['per_unit_rate'];;echo '">';echo $accessories['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

                            <div class="col-lg-2">
                            <label>Unit </label>
                            <input type="text" class="form-control input-sm" id="s_unit" readonly="">
                            </div>

                            <div class="col-lg-2">
                            <label>Per Unit Rate </label>
                            <input type="text" class="form-control input-sm" id="s_perunitrate" readonly="">
                            </div>
                            
                            <div class="col-lg-2">
                                <label>Qty</label>
                                <input type="text" class="form-control input-sm" id="s_qty">
                            </div>

							<div class="col-lg-2">
							<label>Accessories cost</label>
                            <input class="form-control input-sm" type="number" id="s_cost" value=0 readonly="">
                            </div>

                            <div class="col-lg-2">
                            <label>Remarks</label>
                            <input class="form-control input-sm" type="text" id="s_remarks">
                            </div>
                             
                            <div class="col-lg-2">
                            <label>Employee Name</label>
                            <select class="form-control select2" id="e_name">
                            <option value="" disabled="" selected="">Choose Employee</option>
                            ';foreach ($dyer_name as $dyer_name): ;echo ' <option value="';echo $dyer_name['name'];;echo '" >';echo $dyer_name['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>


                            <div class="col-lg-2">
                            <label>Dying Name</label>
                            <select class="form-control select2" id="s_dyename">
                            <option value="" disabled="" selected="">Choose Accessories</option>
                            ';foreach ($material as $material): ;echo ' <option value="';echo $material['name'];;echo '" data-rate="';echo $material['rate'];;echo '">';echo $material['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>


							<div class="col-lg-2">
                            <label>Dying cost</label>
                            <input class="form-control input-sm" type="number" id="s_dyecost" value=0 >
                            </div>
                            
							<div class="col-lg-2">
                            <label>Total Cost</label>
                            <input class="form-control input-sm" type="number" id="s_totalcost" readonly="">
                            </div>

						

							<div class="col-lg-1">   
                            <label for="">Add</label>                                                  
							<a class="btn btn-primary btnAdd4 addmodal"><i class="fa fa-plus"></i></a>
							</div>

							<div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table4">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >Name</th>
                                                <th >Unit</th>
                                                <th >Rate</th>
                                                <th >Qty</th>
                                                <th >Cost</th>
                                                <th >Employee Name</th>
                                                <th >Dying</th>
                                                <th >Dying cost</th>
                                                <th >Total cost</th>
												<th >Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

							<div class="col-lg-3">
                            <label>Sub Total </label>
                            <input class="form-control input-sm" type="number" id="sub_total"  readonly="true">
                            </div>

                            <div class="col-lg-2">   
                            <label for="">Total_Cost </label>                         
                            <a class="btn btn-primary get_acc" >Fetch </a>
                            </div>

                            </div>
                            <div id="menu5" class="tab-pane fade">

                            <div class="col-lg-2">
                            <label class="">Embell Type</label>
                            <select class="form-control select2" id="embell_type">
                            <option value="" disabled="" selected="">Embellishment Type</option>
                            <option value="Adda_work">Adda_work</option>
                            <option value="Stone_work">Stone_work</option>
                            </select>
                            </div>  

                            <div class="col-lg-2">
                            <label>Employee Name</label>
                            <select class="form-control select2" id="embell_name">
                            <option value="" disabled="" selected="">Choose Employee</option>
                            ';foreach ($embell_name as $embell_name): ;echo ' <option value="';echo $embell_name['name'];;echo '" >';echo $embell_name['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

                            <div class="col-lg-2">
                            <label>Part</label>
							<select class="form-control select2" id="e_disc">
                            <option value="" disabled="" selected="">Choose Part</option>
                            ';foreach ($embells as $embell): ;echo ' <option value="';echo $embell['name'];;echo '" >';echo $embell['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>
                            
							<div class="col-lg-2">
							<label>Per Hour rate</label>
                            <input class="form-control input-sm" type="number" id="e_phrate">
                            </div>

							<div class="col-lg-2">
                            <label>No.Labour</label>
                            <input class="form-control input-sm" type="number" id="e_labour">
                            </div>

                            <div class="col-lg-2">
                            <label>Working Hours</label>
                            <input class="form-control input-sm" type="number" id="e_hours">
                            </div>

                            <div class="col-lg-2">
                            <label>labour Cost</label>
                            <input class="form-control input-sm" type="number" id="e_labour_cost" readonly="">
                            </div>

                            <div class="col-lg-2">
                            <label>Kaviya Cost</label>
                            <input class="form-control input-sm" type="number" id="e_kaviya" value=0>
                            </div>


							<div class="col-lg-1">   
                            <label for="">Add</label>                                                  
							<a class="btn btn-primary btnAdd5 addmodal"><i class="fa fa-plus"></i></a>
							</div>

							<div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table5">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >Type</th>
                                                <th >Name</th>
                                                <th >Part</th>
                                                <th >Per Hour Rate</th>
                                                <th >Labours</th>
                                                <th >Hours</th>
                                                <th >Labours cost</th>
                                                <th >Kaviya cost</th>
    
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <p></p>

                            <div class="col-lg-2">
                            <label class="">Material Type</label>
                            <select class="form-control select2" id="m_type">
                            <option value="" disabled="" selected="">Material Type</option>
                            <option value="Adda_work">Adda_work</option>
                            <option value="Stone_work">Stone_work</option>
                            </select>
                            </div>  

                            <div class="col-lg-3">
                            <label>Adda Material</label>
                            <select class="form-control select2" id="adda">
                            <option value="" disabled="" selected="">Adda Material</option>
                            ';foreach ($adda as $adda): ;echo ' <option value="';echo $adda['name'];;echo '" data-rate="';echo $adda['per_unit_rate'];;echo '" data-unit="';echo $adda['unit'];;echo '">';echo $adda['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>


                            <div class="col-lg-2">
                            <label>Unit </label>
                            <input type="text" class="form-control input-sm" id="ebl_unit" readonly="">
                            </div>


                            <div class="col-lg-2">
                            <label>Per Unit Rate</label>
                            <input type="text" class="form-control input-sm" id="ebl_rate" readonly="">
                            </div>
                            
                            <div class="col-lg-2">
                                <label>Qty</label>
                                <input type="text" class="form-control input-sm" id="ebl_qty">
                            </div>

							<div class="col-lg-2">
							<label>Material cost</label>
                            <input class="form-control input-sm" type="number" id="ebl_cost" value=0 readonly="">
                            </div>
                            <p></p>

							<div class="col-lg-2">   
                            <label for="">Add</label>                                                  
							<a class="btn btn-primary btnAdd9 addmodal"><i class="fa fa-plus"></i></a>
							</div>

                            <div class="col-lg-12">

                                <div id="no-more-tables">
                                    <table class="col-lg-8 table-bordered table-striped table-condensed cf" id="purchase_table9">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >Type</th>                                               
                                                <th >Material</th>
                                                <th >Unit</th>
                                                <th >Per Unit rate</th>
                                                <th >Material Qty</th>
                                                <th >Material Cost</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="col-lg-3">
							<label>Total_material</label>
                            <input class="form-control input-sm" type="text" id="e_total_material">
                            </div>


							<div class="col-lg-3">
                            <label>Sub Total</label>
                            <input class="form-control input-sm" type="number" id="subtotal_"  readonly="true">
                            </div>

                            <div class="col-lg-2">   
                            <label for="">Total_Cost </label>                         
                            <a class="btn btn-primary get_embell" >Fetch </a>
                            </div>
                             

                            </div>


                            <div id="menu6" class="tab-pane fade">


                            <div class="col-lg-2">
                            <label>Action Type</label>
                                <select class="form-control select2" id="p_type">
                                <option value="" disabled="" selected="">Select Type</option>
                                <option value="Press">Press</option>
                                <option value="Pack">Pack</option>
                                </select>
                            </div> 


                            <div class="col-lg-2">
                            <label>Employee Name</label>
                            <select class="form-control select2" id="p_name">
                            <option value="" disabled="" selected="">Select Employee</option>
                            ';foreach ($pack_name as $pack_name): ;echo ' <option value="';echo $pack_name['name'];;echo '" >';echo $pack_name['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>
                            
							<div class="col-lg-2">
							<label>Rate</label>
                            <input class="form-control input-sm" type="number" id="p_rate">
                            </div>

							<div class="col-lg-2">
                            <label>QTY</label>
                            <input class="form-control input-sm" type="number" id="p_qty">
                            </div>

							<div class="col-lg-2">
							<label>Cost</label>
                            <input class="form-control input-sm" type="number" id="p_cost" value=0 readonly="">
                            </div>

							<div class="col-lg-1">   
                            <label for="">Add</label>                                                  
							<a class="btn btn-primary btnAdd6 addmodal"><i class="fa fa-plus"></i></a>
							</div>

							<div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table6">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >Type</th>
                                                <th >Name</th>
                                                <th >Rate</th>
                                                <th >Quantity</th>
                                                <th >Cost</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <p></p>


                            <div class="col-lg-3">
                            <label>Packing Materials</label>
                            <select class="form-control select2" id="p_material">
                            <option value="" disabled="" selected="">Select Material</option>
                            ';foreach ($packing as $packing): ;echo ' <option value="';echo $packing['name'];;echo '" data-cost="';echo $packing['per_unit_rate'];;echo '">';echo $packing['name'];;echo '</option>
                            ';endforeach ;echo '</select> 
                            </div>

							<div class="col-lg-2">
                            <label>Rate</label>
                            <input class="form-control input-sm" type="number" id="p_mrate" readonly ="">
                            </div>

							<div class="col-lg-2">
							<label>Qty</label>
                            <input class="form-control input-sm" type="number" id="p_mqty">
                            </div>

                            <div class="col-lg-2">
                            <label>Cost</label>
                            <input class="form-control input-sm" type="text" id="p_mcost" readonly ="">
                            </div>

							<div class="col-lg-1">   
                            <label for="">Add</label>                                                  
							<a class="btn btn-primary btnAdd10 addmodal"><i class="fa fa-plus"></i></a>
							</div>
                            <p></p>
                            <div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-7 table-bordered table-striped table-condensed cf" id="purchase_table10">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >Material</th>
                                                <th >Rate</th>
                                                <th >Qty</th>
                                                <th >Cost</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <p></p>

                            <div class="col-lg-3">
                            <label>Total</label>
                            <input class="form-control input-sm" type="number" id="press_total"  readonly="true">
                            </div>

                            <div class="col-lg-2">   
                            <label for="">Total_Cost </label>                         
                            <a class="btn btn-primary get_press" >Fetch </a>
                            </div>
                            
                            </div>

                           
							<div id="menu7" class="tab-pane fade">
							           
							<h3>&nbsp&nbspSummary</h3>

							<div class="col-lg-2">
                            <label>Embroidory Cost</label>
                            <input class="form-control input-sm" type="number" id="embd_cost"  readonly="true">
                            </div>

                            <div class="col-lg-2">
                            <label>Digital_Printing Cost</label>
                            <input class="form-control input-sm" type="number" id="digital_cost"  readonly="true">
                            </div>

                            <div class="col-lg-2">
                            <label>Fabric & Dying Cost</label>
                            <input class="form-control input-sm" type="number" id="dye_cost"  readonly="true">
                            </div>

                            <div class="col-lg-2">
                            <label>Cutting & Stitching Cost </label>
                            <input class="form-control input-sm" type="number" id="stitch_cost"  readonly="true">
                            </div>

							<div class="col-lg-2">
                            <label> Stitching Accessories</label>
                            <input class="form-control input-sm" type="number" id="acesr_cost" readonly="true">
                            </div>

                            <div class="col-lg-2">
                            <label>Embellishment Cost </label>
                            <input class="form-control input-sm" type="number" id="embel_cost" readonly="true">
                            </div>

                            <div class="col-lg-2">
                            <label>Press & Packing</label>
                            <input class="form-control input-sm" type="number" id="pack_cost" readonly="true">
                            </div>

							<div class="col-lg-2">
                            <label>Operations Cost</label>
                            <input class="form-control input-sm" type="number" id="operate" value=0>
                            </div>
							<div class="col-lg-2">
                            <label>R & D Cost</label>
                            <input class="form-control input-sm" type="number" id="RD" value=0>
                            </div>
							<div class="col-lg-2">
                            <label>FOH Cost</label>
                            <input class="form-control input-sm" type="number" id="FOD" value=0>
                            </div>

							<div class="col-lg-3">
                            <label>10 % N.Loss</label>
                            <input class="form-control input-sm" type="number" id="loss">
                            </div>

                            <div class="col-lg-2">
                            <label>Total Material Cost</label>
                            <input class="form-control input-sm" type="number" id="Material_expense" readonly="">
                            </div>


							<div class="col-lg-2">
                            <label>Total Production Cost </label>
                            <input class="form-control input-sm" type="number" id="G_Total" readonly="true">
                            </div>

							<div class="col-lg-2">   
                            <label for="">Grand Total</label>                         
							<a class="btn btn-primary btn_gtotal addmodal">Calculate</a>
							</div>

                            </div>
                            <div id="menu8" class="tab-pane fade">
							<div class="col-lg-12">
							<p></p>
							<div id="no-more-tables">
								<table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table7">
									<thead class="cf tbl_thead">
										<tr>
											<th class="numeric">Sr#</th>
                                            <th >Material_Type</th> 
											<th >Material_Name</th>
											<th >Unit</th>
											<th >QTY</th>
											<th >Rate</th>
											<th >Cost</th>
											<th>Remarks</th>
										</tr>
									</thead>
										<tbody>

									</tbody>
								</table>
							</div>
						</div>

						<div class="col-lg-3">
						<label>Total Material Cost</label>
						<input class="form-control input-sm" type="text" id="m_subtotal" readonly="">
						</div>
                        
                        <p></p>

                        <div class="col-lg-3">   
                        <label for="">Total Cost</label>                         
                        <a class="btn btn-primary btn_total_material addmodal" >Fetch</a>
                        </div>


                        <div class="col-lg-2">   
                        <label for="">Fetch Material</label>                         
                        <a class="btn btn-primary get_material" >Fetch </a>
                        </div>

         

                        <p></p>


                        </div>
                            
                        

								</div>

							

						</div>
					</form>   <!-- end of form -->
				</div>  <!-- end of col -->
			</div>  <!-- end of container fluid -->
		</div>   <!-- end of page_content -->
	</div>
</div>
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
';
?>