

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
				<h1 class="page_title">Sample Card</h1>
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
                                        <input type="number" class="form-control input-sm VoucherNo" id="id" >
                                      
                                      </div>
                        
          
                                        
                                      <div class="col-lg-2">
                                      <label class=""> Date</label>
                                      <input class="form-control input-sm" type="date" id="s_date" value="';echo date('Y-m-d');;echo '" >
                                      </div>    
          
                                                                            
                                      <div class="col-lg-2">
                                        <label class="">Design No</label>
                                        <input type="text" class="form-control input-sm" id="design_no" >
                                      </div>
                                      
                                      
                                      <div class="col-lg-2">
                                      <label class="">Design Type</label>
                                      <input type="text" class="form-control input-sm" id="type" >
                                      </div>

                                      <div class="col-lg-2">
                                      <label class="">Fabric Type</label>
                                      <input type="text" class="form-control input-sm" id="f_type" >
                                      </div>


                                      <div class="col-lg-2">

                                      <label for="">Finsihed Item<img id="imgItemLoader" 
                                      class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
                                      <input type="text" class="form-control" id="txtItemId">
                                      <input id="hfItemId2" type="hidden" value="" />
                                      <input id="hfItemSize" type="hidden" value="" />

          
                                    </div>


                                      



                                
                     
                    </div>

							<div class="row">

                                                    


                                                
              <div class="col-lg-2">
              <label class="">Fabric Unit</label>
              <select class="form-control select2" id="f_unit">
              <option value="Yard">Yard</option>
              <option value="Meter">Meter</option>

              </select>
              </div>  

                        <div class="col-lg-2">
                        <label class="">Fabric QTY </label>
                        <input type="number" class="form-control input-sm " id="f_qty"  >
                        </div> 

                        
                        <div class="col-lg-2">
                        <label class="">Fabric Cost Per Pcs</label>
                        <input type="number" class="form-control input-sm " id="fabric_cost" readonly="" value =0>
                        </div> 

                          <div class="col-lg-2">
                          <label class="">EMB Cost Per Pcs</label>
                          <input type="number" class="form-control input-sm " id="emb_cost" readonly="" value =0 >
                          </div> 
    
                          <div class="col-lg-2">
                          <label class="">Stitch Cost Per Pcs</label>
                          <input type="number" class="form-control input-sm " id="stitch_cost" value =0 >
                          </div> 

                          <div class="col-lg-2">
                          <label class="">Total Cost Per Pcs</label>
                          <input type="number" class="form-control input-sm " id="total_cost" readonly="" >
                          </div> 


                          <div class="col-lg-2">
                          <label class="">Consumption </label>
                          <select class="form-control select2" id="consumption">
                          <option value="Fabric">Fabric</option>
                          <option value="Embellishment">Embellishment</option>
                          </select>
                          </div>   

                          <div class="col-lg-3">

                            <label for="">Item Description<img id="imgItemLoader" 
                            class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
                            <input type="text" class="form-control" id="desc">
                            <input id="hfItemId" type="hidden" value="" />
                            <input id="hfItemSize" type="hidden" value="" />
                            <input id="hfItemBid" type="hidden" value="" />
                            <input id="hfItemUom" type="hidden" value="" />
                            <input id="hfItemUname" type="hidden" value="" />
                            <input id="hfItemPrate" type="hidden" value="" />
                            <input id="hfItemGrWeight" type="hidden" value="" />
                            <input id="hfItemStQty" type="hidden" value="" />
                            <input id="hfItemStWeight" type="hidden" value="" />
                            <input id="hfItemLength" type="hidden" value="" />
                            <input id="hfItemCatId" type="hidden" value="" />
                            <input id="hfItemSubCatId" type="hidden" value="" />
                            <input id="hfItemDesc" type="hidden" value="" />
                            <input id="hfItemShortCode" type="hidden" value="" />
                            <input id="hfItemBarcode" type="hidden" value="" />
                            <input id="hfItemInventoryId" type="hidden" value="" />
                            <input id="hfItemCostId" type="hidden" value="" />

                          </div>
                     

                          <div class="col-lg-1" hidden>
                          <label class="">Description</label>
                          <select class="form-control select2" id="desc1">
                          <option value="Lawn">Lawn</option>
                          <option value="Cotton">Cotton</option>
                          <option value="Chiffon">Chiffon</option>
                          <option value="Cambric">Cambric</option>
                          <option value="Silk">Silk</option>


                          <option value="Grip_Burbery">Grip_Burbery</option>
                          <option value="Georgett_Brown">Georgett_Brown</option>
                          <option value="Shirt_Facing">Shirt_Facing</option>
                          <option value="Croshia_Button">Croshia_Button</option>

                          <option value="Raw_Silk">Raw_Silk</option>
                          <option value="Cotton_Silk">Cotton_Silk</option>
                          <option value="Medium_Silk">Medium_Silk</option>
                          <option value="Viscose">Viscose</option>
                          <option value="Organza">Organza</option>
                          <option value="Jamawar">Jamawar</option>
                          <option value="Cancan">Cancan</option>
                          <option value="Net">Net</option>
                          <option value="Dobby_Lawn">Dobby_Lawn</option>
                          <option value="Khaddar">Khaddar</option>
                          <option value="Linen">Linen</option>
                          <option value="Karandi">Karandi</option>
                          <option value="Toile">Toile</option>
                          <option value="Twilll">Twilll</option>
                          <option value="Marina">Marina</option>
                          <option value="Cottel">Cottel</option>
                          <option value="Georgette">Georgette</option>
                          <option value="Velvet">Velvet</option>

                          <option value="Pashmina">Pashmina</option>
                          <option value="Cotton_Karandi">Cotton_Karandi</option>
                          <option value="Zari_Net">Zari_Net</option>
                          <option value="Woven_Net">Woven_Net</option>
                          <option value="Fancy_Organza">Fancy_Organza</option>
                          <option value="Cotton_Net">Cotton_Net</option>
                          <option value="Dobby_Viscose">Dobby_Viscose</option>
                          <option value="Cotton_Jacquard">Cotton_Jacquard</option>
                          <option value="Lawn_Jacquard">Lawn_Jacquard</option>
                          <option value="Organza_Jacquard">Organza_Jacquard</option>
                          <option value="Chantilly">Chantilly</option>
                          <option value="Shamoz">Shamoz</option>
                          <option value="Cotton_Jeans">Cotton_Jeans</option>
                          <option value="Canvas">Canvas</option>
                          <option value="Crepe">Crepe</option>
                          <option value="Jersey">Jersey</option>
                          <option value="Leather">Leather</option>
                          <option value="Wool">Wool</option>
                          <option value="Polyester">Polyester</option>
                          <option value="Stin">Stin</option>
                          <option value="Taffeta">Taffeta</option>
                          <option value="Chenille">Chenille</option>
                          <option value="Fur">Fur</option>
                          <option value="Tissue">Tissue</option>
                          <option value="Nylon">Nylon</option>
                          <option value="Muslin">Muslin</option>
                          <option value="Lace">Lace</option>
                          <option value="Eint">Eint</option>
                          <option value="Pearls">Pearls</option>
                          <option value="Sitara">Sitara</option>
                          <option value="Chorsee">Chorsee</option>
                          <option value="Cut_dana">Cut_dana</option>
                          <option value="Drops">Drops</option>
                          <option value="Pearl_drops">Pearl_drops</option>
                          <option value="Crystal_drops">Crystal_drops</option>
                          <option value="Latkan">Latkan</option>
                          <option value="Tessel">Tessel</option>
                          <option value="Stones">Stones</option>
                          <option value="Metal_pieces">Metal_pieces</option>

                          </select>
                        </div>   

  

                        
                        <div class="col-lg-2">
                        <label class="">Parts Detail</label>
                        <select class="form-control select2" id="parts">
                        <option value="Front">Front</option>
                        <option value="Back">Back</option>
                        <option value="Arms">Arms</option>
                        <option value="Side_Panel">Side_Panel</option>
                        <option value="Headscarf">Headscarf</option>
                        <option value="Shirt">Shirt</option>
                        <option value="Trouser">Trouser</option>
                        <option value="Doptta">Doptta</option>
                        <option value="Facing">Facing</option>
                        <option value="Lehnga">Lehnga</option>
                        <option value="Can_can">Can_can</option>
                        </select>
                      </div>    

                      
                      <div class="col-lg-2">
                      <label class="">Rate</label>
                      <input type="number" class="form-control input-sm " id="rate"  >
                      </div> 

                      <div class="col-lg-2">
                      <label class="">QTY</label>
                      <input type="number" class="form-control input-sm " id="qty_"  >
                      </div> 


                      <div class="col-lg-2">
                      <label class="">Amount</label>
                      <input type="number" class="form-control input-sm " id="amount" readonly="" >
                      </div> 
    
                          
                          <div class="col-lg-1">   
                          <label for="">Add</label>                         
                          <a class="btn btn-primary btnAdd1 addmodal"><i class="fa fa-plus"></i></a>
                          </div>

                          

                            <div class="container">
                                <div class="pull-right">
                                    <label>&nbsp</label>
                                    <a class="btn btn-sm btn-default btnSave" ><i class="fa fa-save"></i> &nbspSave &nbsp</a>
                                    <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i>&nbsp Delete&nbsp </a>
                                    <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i>&nbsp Reset &nbsp</a>
                                    <a class="btn btn-sm btn-default btntotal"><i class="fa fa-save"></i>&nbsp Total &nbsp</a>
                                    <a class="btn btn-sm btn-default btnprint"><i class="fa fa-refresh"></i>&nbsp Print &nbsp</a>
                                    
                                </div>
                            </div>




							</div>
                            <div class="col-lg-12">
							<p></p>
                                <div id="no-more-tables">
                                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table1">
                                        <thead class="cf tbl_thead">
                                            <tr>
                                                <th class="numeric">Sr#</th>
                                                <th >Consumption</th>
                                                <th >Description</th>
                                                <th >Part</th>
                                                <th >QTY</th>
                                                <th >Rate</th>
                                                <th >Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                            <tbody>

                                        </tbody>
                                    </table>
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
	</div>
</div>
<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
';
?>