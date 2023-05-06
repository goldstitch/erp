

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
  <div id="AccountAddModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="AccountAddModelLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header" style="background:#76c143;color:white;padding-bottom:20px;">
        <button type="button" class="modal-button cellRight modal-close pull-right btn-close" data-dismiss="modal"><span class="fa fa-times" style="font-size:26px; "></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="AccountAddModelLabel">Add New Account</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="col-lg-9 col-lg-offset-1">
              <form role="form">
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Name</label>
                      <input type="text" id="txtAccountName" class="form-control" placeholder="Account Name" maxlength="50" tabindex="1">
                    </div>
                    <div class="col-lg-6">
                      <label>Acc Type3</label>
                      <select class="form-control input-sm "  id="txtLevel3" tabindex="2">
                        <option value="" disabled="" selected="">Choose Account Type</option>
                        ';foreach ($l3s as $l3): ;echo '                          <option value="';echo $l3['l3'];;echo '" data-level2="';echo $l3['level2_name'];;echo '" data-level1="';echo $l3['level1_name'];;echo '">';echo $l3['level3_name'] ;echo '</option>
                        ';endforeach ;echo '                      </select>
                    </div>
                    <div class="col-lg-12">
                      <span><b>Type 2 &rarr; </b><span id="txtselectedLevel2"> </span></span> <span><b>Type 1 &rarr; </b><span id="txtselectedLevel1"> </span></span>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>       
      </div>
      <div class="modal-footer">
        <div class="pull-right">
          <a class="btn btn-success btnSaveM btn-sm" data-insertbtn="1"><i class="fa fa-save"></i> Save</a>
          <a class="btn btn-warning btnResetM btn-sm"><i class="fa fa-refresh"></i> Reset</a>
          <a class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="ItemAddModel" class="modal hide fade" role="dialog" aria-labelledby="ItemAddModelLabel"
aria-hidden="true">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header" style="background:#76c143;color:white;padding-bottom:20px;">
      <button type="button" class="modal-button cellRight modal-close pull-right btn-close" data-dismiss="modal"><span class="fa fa-times" style="font-size:26px; "></span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="ItemAddModelLabel">Add New Item</h4>
    </div>
    <div class="modal-body">
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="col-lg-9 col-lg-offset-1">
            <form role="form">
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-12">
                    <label for="exampleInputEmail1">Description</label>
                    <input type="text" id="txtItemName" class="form-control" placeholder="Account Name" maxlength="50" tabindex="1">
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <label>Category</label>
                    <select class="form-control input-sm select2" id="category_dropdown" tabindex="2">
                      <option value="" disabled="" selected="">Choose Category</option>
                      ';foreach ($categories as $category): ;echo '                        <option value="';echo $category['catid'];;echo '">';echo $category['name'];;echo '</option>
                      ';endforeach ;echo '                    </select>
                  </div>
                  <div class="col-lg-6">
                    <label>Sub Catgeory</label>
                    <select class="form-control input-sm select2" id="subcategory_dropdown" tabindex="3">
                      <option value="" disabled="" selected="">Choose sub category</option>
                      ';foreach ($subcategories as $subcategory): ;echo '                        <option value="';echo $subcategory['subcatid'];;echo '">';echo $subcategory['name'];;echo '</option>
                      ';endforeach ;echo '                    </select>
                  </div>
                </div>    
                <div class="row">
                  <div class="col-lg-6">
                    <label>Brand</label>
                    <select class="form-control input-sm select2" id="brand_dropdown" tabindex="4">
                      <option value="" disabled="" selected="">Choose brand</option>
                      ';foreach ($brands as $brand): ;echo '                        <option value="';echo $brand['bid'];;echo '">';echo $brand['name'];;echo '</option>
                      ';endforeach ;echo '                    </select>
                  </div>
                  <div class="col-lg-6">
                    <label>Type</label>
                    <input type="text" list=\'type\' class="form-control input-sm" id="txtBarcode" tabindex="5" />
                    <datalist id=\'type\'>
                      ';foreach ($types as $type): ;echo '                        <option value="';echo $type['barcode'];;echo '">
                        ';endforeach ;echo '                      </datalist>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <label>Sale Price</label>
                      <input class="form-control input-sm num" type="text" id="txtSalePrice" tabindex="6">
                    </div>
                    <div class="col-lg-3">
                      <label>Pur Price</label>
                      <input class="form-control input-sm num" type="text" id="txtPurPrice" tabindex="7">
                    </div>
                    <div class="col-lg-6">
                      <label>UOM</label>
                      <input type="text" class=\'form-control input-sm\' tabindex="8" placeholder="Uom" id="uom_dropdown" list=\'uoms\'>
                      <datalist id="uoms">
                        ';foreach ($uoms as $uom): ;echo '                          ';if ($uom['uom'] !== ''): ;echo '                            <option value="';echo $uom['uom'];;echo '">
                            ';endif ;echo '                          ';endforeach ;echo '                        </datalist>
                      </div>
                    </div>

                  </div>
                </form>
              </div>
            </div>
          </div>       
        </div>
        <div class="modal-footer">
          <div class="pull-right">
            <a class="btn btn-success btnSaveMItem btn-sm" data-insertbtn="1" tabindex="8"><i class="fa fa-save"></i> Save</a>
            <a class="btn btn-warning btnResetMItem btn-sm" tabindex="9"><i class="fa fa-refresh"></i> Reset</a>
            <a class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="SubPhaseAddModel" class="modal hide fade" role="dialog" aria-labelledby="SubPhaseAddModelLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header" style="background:#68d120;color:white;padding-bottom:20px;">
        <button type="button" class="modal-button cellRight modal-close pull-right btn-close" data-dismiss="modal"><span class="fa fa-times" style="font-size:26px; "></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="SubPhaseAddModelLabel">Add New Sub Phase</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row-fluid">
            <div class="col-lg-9 col-lg-offset-1">
              <form role="form">
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-12">
                      <label for="exampleInputEmail1">Name</label>
                      <input type="text" id="txtPhaseName" class="form-control" placeholder="Account Name" maxlength="50" tabindex="1">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <label>Phase</label>
                      <select class="form-control input-sm select2" id="phase_dropdown" tabindex="2">


                      </select>
                    </div>

                  </div>    


                </div>
              </form>
            </div>
          </div>
        </div>       
      </div>
      <div class="modal-footer">
        <div class="pull-right">
          <a class="btn btn-success btnSaveSubPhase btn-sm" data-insertbtn="1" tabindex="8"><i class="fa fa-save"></i> Save</a>
          <a class="btn btn-warning btnResetSubPhase btn-sm" tabindex="9"><i class="fa fa-refresh"></i> Reset</a>
          <a class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
        </div>
      </div>
    </div>
  </div>
</div>



<div id="GodownAddModel" class="modal hide fade" role="dialog" aria-labelledby="GodownAddModelLabel"
aria-hidden="true">
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header" style="background:#76c143;color:white;padding-bottom:20px;">
      <button type="button" class="modal-button cellRight modal-close pull-right btn-close" data-dismiss="modal"><span class="fa fa-times" style="font-size:26px; "></span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="GodownAddModelLabel">Add New Department</h4>
    </div>
    <div class="modal-body">
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="col-lg-9 col-lg-offset-1">
            <form role="form">
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-12">
                    <label for="exampleInputEmail1">Description</label>
                    <input type="text" id="txtNameGodownAdd" class="form-control" placeholder="Department Name" maxlength="50" tabindex="1">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>       
    </div>
    <div class="modal-footer">
      <div class="pull-right">
        <a class="btn btn-success btnSaveMGodown btn-sm" data-insertbtn="1" tabindex="8"><i class="fa fa-save"></i> Save</a>
        <a class="btn btn-warning btnResetMGodown btn-sm" tabindex="9"><i class="fa fa-refresh"></i> Reset</a>
        <a class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
      </div>
    </div>
  </div>
</div>
</div>

<div class="page_bar">
  <div class="row">
    <div class="col-md-12">
      <h1 class="page_title"> Item Required Material </h1>
    </div>
  </div>
</div>
<div class="page_content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-body">

                <form action="">

                  <div class="row">
                    <div class="col-lg-7">
                      <div class="row">

                        <div class="col-lg-3">

                          <label class="VoucherNoLable">Sr#</label>
                          <input type="number" class="form-control input-sm VoucherNo" id="txtVrnoa" >
                          <input type="hidden" id="txtMaxVrnoaHidden">
                          <input type="hidden" id="txtVrnoaHidden">
                          <input type="hidden" id="voucher_type_hidden">

                          <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                          <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                          <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">


                        </div>

                        <div class="col-lg-3">

                          <label class="">Date</label>
                          <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '">

                        </div>

                        <div class="col-lg-3">
                          <label for="" id="stqty_lbls">Work Order #</label>
                          <div class="input-group" >
                            <select class="form-control select2" id="wOrder_dropdown" >
                             <option value="" selected="" disabled="">Work Order</option>
                             ';foreach ($wOrder as $workorder): ;echo '                               <option value="';echo $workorder['vrnoa'];;echo '">';echo $workorder['vrnoa'];;echo '</option>
                             ';endforeach ;echo '                           </select>
                         </div>
                       </div>  
                       <div class="col-lg-3">
                        <label>Order Date</label>
                        <input class="form-control input-sm" type="date" id="wOrder_date" value="';echo date('Y-m-d');;echo '">
                      </div>

                    </div>


                    <div class="row">


                      <div class="col-lg-6">
                        <label for="" id="stqty_lbls">Party</label>

                        <select class="form-control input-sm  select2" id="party_dropdown">
                          <option value="" selected="" disabled="">Party</option>
                          ';foreach ($parties as $party): ;echo '                            <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                          ';endforeach ;echo '                        </select>


                      </div>
                      <div class="col-lg-6">                                            
                        <label>Remarks</label>
                        <input type="text" class="form-control input-sm " id="txtRemarks">                                                                                                                                                                             
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="row">

                      <div class="col-lg-6">

                        <label class="side_panel_heading">Article Color Summary</label>
                        <table class="table table-striped article_summary_color_table" id="article_summary_color_table">
                          <thead>
                            <tr>
                              <th>Sr#</th>
                              <th>Article</th>
                              <th>Article Color</th>

                              <th class="text-right">Qty</th>
                            </tr>
                          </thead>
                          <tbody class="article_color_tbody">
                            <tr>

                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>

                              <td class="text-right txtbold" colspan=\'3\' >Total:</td>
                              <td class="TotalQtyArticleColor text-right txtbold"></td>

                            </tr>
                          </tfoot>

                        </table>
                        
                      </div>
                      


                      <div class="col-lg-6">

                        <label class="side_panel_heading">Article Summary</label>
                        <table class="table table-striped article_summary_table" id="article_summary_table">
                          <thead>
                            <tr>
                              <th>Sr#</th>
                              <th>Article</th>
                              <th class="text-right">Qty</th>
                            </tr>
                          </thead>
                          <tbody class="article_tbody">
                            <tr>

                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>

                              <td class="text-right txtbold" colspan=\'2\' >Total:</td>
                              <td class="TotalQtyArticle text-right txtbold"></td>

                            </tr>
                          </tfoot>

                        </table>
                        
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row"></div>
                <div class="row">
                  <div class="col-lg-12">
                    <ul class="nav nav-pills">
                      <li class="active"><a href="#item" data-toggle="tab" class="item_tab">Item</a></li>
                      <li><a href="#Fabric" data-toggle="tab" class="custHeadFabric">Yarn</a></li>
                      <li ><a href="#Fabrication" data-toggle="tab" class="custHeadSale">Fabrication Detail</a></li>
                      <li><a href="#Material" data-toggle="tab" class="custHeadMaterial">Stitching Accessories</a></li>
                      
                      <li ><a href="#Embelishment" data-toggle="tab" class="custHeadSale">Embelishment Detail</a></li>
                      <li ><a href="#Labour" data-toggle="tab" class="custHeadSale">Phase Wise Labour Rate</a></li>
                      
                      <li><a href="#Packing" data-toggle="tab" class="custHeadScrap">Packing Accessories</a></li>
                      
                      <li ><a href="#Production_plan" data-toggle="tab" class="custHeadProductionPlan">Production Plan</a></li>
                    </ul>  
                  </div>
                </div>
                <div class="tab-content">
                 <div class="tab-pane active fade in" id="item">
                  <div class="container-wrap">
                    <div class="row">
                      <div class="col-lg-12">

                        <div id="no-more-tables">
                          <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="item_table">
                            <thead class="cf">
                              <th>Sr#</th>
                              <th style="width:100px;">Article#</th>
                              <th style="width:350px;">Item Detail</th>
                              <th>UOM</th>
                              <th class="numeric" style=\'text-align:right;\'>Qty</th>
                              <th class="numeric" style=\'text-align:right;\'>Rate</th>
                              <th class="numeric" style=\'text-align:right;\'>Amount</th>
                              <th>Action</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot class="tfoot_tbl cf">
                              <tr>
                                <td></td>                 
                                <td></td>                                   

                                <td style=\'color:red !important;\'></td>
                                <td style=\'color:red !important; text-align:right;\'>Total:</td>  
                                <td id="txtTotalQty2" style=\'color:red !important;text-align:right;background:white;\'></td>                                  
                                <td style=\'text-align:right;\'></td>
                                <td id="txtTotalAmount2" style=\'color:red !important;text-align:right;background:white;\'></td> 
                                <td></td>
                              </tr>
                            </tfoot>
                            

                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Start Matrial  -->
                <div class="tab-pane fade in" id="Material">
                 <div class="container-wrap">
                  <div class="row">

                    <div class="col-lg-2" >
                      <label for="">Article</label>
                      <select class="form-control select2" id="article_dropdownMaterial">
                        <option value="" disabled="" selected="">Article</option>
                        ';foreach ($short_codes as $item): ;echo '                          <option value="';echo $item['vrnoa'];;echo '">';echo $item['short_code'];;echo '</option>
                        ';endforeach ;echo '                      </select>
                      
                    </div>

                    <div class="col-lg-2" >
                      <label for="">Color</label>
                      <select class="form-control select2" id="color_dropdownMaterial">
                       
                      </select>

                    </div>

                    <div class="col-lg-3">
                      <label for="">Item Detail<img id="imgItemMaterialLoader" 
                        class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>

                        <input type="text" class="form-control" id="txtItemMaterialId">
                        <input id="hfItemMaterialId" type="hidden" value="" />
                        <input id="hfItemMaterialSize" type="hidden" value="" />
                        <input id="hfItemMaterialBid" type="hidden" value="" />
                        <input id="hfItemMaterialUom" type="hidden" value="" />
                        <input id="hfItemMaterialUname" type="hidden" value="" />

                        <input id="hfItemMaterialPrate" type="hidden" value="" />
                        <input id="hfItemMaterialGrWeight" type="hidden" value="" />
                        <input id="hfItemMaterialStQty" type="hidden" value="" />
                        <input id="hfItemMaterialStWeight" type="hidden" value="" />
                        <input id="hfItemMaterialLength" type="hidden" value="" />
                        <input id="hfItemMaterialCatId" type="hidden" value="" />
                        <input id="hfItemMaterialSubCatId" type="hidden" value="" />
                        <input id="hfItemMaterialDesc" type="hidden" value="" />
                        <input id="hfItemMaterialShortCode" type="hidden" value="" />
                        <input id="hfItemMaterialBarcode" type="hidden" value="" />

                        <input id="hfItemMaterialInventoryId" type="hidden" value="" />
                        <input id="hfItemMaterialCostId" type="hidden" value="" />




                      </div>




                      <div class="col-lg-2">
                        <label>Used For</label>
                        <div class="input-group" >
                          <select class="form-control input-sm select2" id="usedfor_dropdown">
                          </select>
                          <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;height: 33px !important;" id="A2" data-target="#usedForModel" data-toggle="modal" href="#usedForModel" rel="tooltip"
                          data-placement="top" data-original-title="Add New" data-toggle="tooltip" data-placement="bottom" title="Add New Used">+</a>
                        </div>
                      </div>

                      <div class="col-lg-1">
                        <label for="">Net/Pcs</label>                                                    
                        <input type="text" class="form-control num"  id="txtQtyMaterialPerPcs">                                                    
                      </div>

                      <div class="col-lg-1">
                        <label for="">Qty</label>                                                    
                        <input type="text" class="form-control num" id="txtQtyGrossMaterial">                                                    
                      </div>
                      <div class="col-lg-1">
                        <label for="">Wastage</label>                                                    
                        <input type="text" class="form-control num" id="txtWastageMaterial">                                                    
                      </div>

                      <div class="col-lg-1">
                        <label for="">GrossQty</label>                                                    
                        <input type="text" class="form-control num" readonly="" id="txtQtyMaterial">                                                    
                      </div>


                      <div class="col-lg-1">
                        <label for="">Rate</label>                                                    
                        <input type="text" class="form-control num" id="txtPRateMaterial">                                                    
                      </div>


                      <div class="col-lg-1">
                        <label for="">Amount</label>                                                    
                        <input type="text" class="form-control readonly num" id="txtAmountMaterial" readonly="true" tabindex="-1">                                                    
                      </div>
                      <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                        <a href="" class="btn btn-primary" id="btnAddMaterial">+</a>
                      </div>                                                
                    </div>

                    <div class="row">
                      <div class="col-lg-12">

                        <div id="no-more-tables">
                          <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Material_table">
                            <thead class="cf">
                              <th>Sr#</th>
                              <th>Article</th>
                              <th>Color</th>

                              <th>Item Detail</th>
                              <th>UOM</th>
                              <th>UsedFor</th>
                              <th class="numeric text-right">Net/Pcs</th>

                              <th class="numeric text-right">Qty</th>
                              <th class="numeric text-right">Wastage%</th>
                              <th class="numeric text-right">GrossQty</th>
                              <th class="numeric text-right">Rate</th>
                              <th class="numeric text-right">Amount</th>
                              <th>Action</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot class="tfoot_tbl cf">
                              <tr>
                                
                                <td colspan="7">Total:</td>  
                                <td class="text-right" id="txtTotalGrossQtyMaterial"></td>
                                <td ></td>
                                <td class="text-right" id="txtTotalQtyMaterial"></td>
                                <td ></td>
                                <td class="text-right" id="txtTotalAmountMaterial"></td> 
                                <td></td>
                              </tr>
                            </tfoot>

                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ENd Material -->


                <!-- Start Fabric  -->
                <div class="tab-pane fade in" id="Fabric">
                 <div class="container-wrap">
                  <div class="row">

                    <div class="col-lg-2" >
                      <label for="">Article &nbsp;&nbsp;&nbsp; <span class="ar_fab_stk"></span></label>
                      <select class="form-control select2" id="article_dropdownFabric">
                        <option value="" disabled="" selected="">Article</option>
                        ';foreach ($short_codes as $item): ;echo '                          <option value="';echo $item['vrnoa'];;echo '">';echo $item['short_code'];;echo '</option>
                        ';endforeach ;echo '                      </select>

                    </div>

                    <div class="col-lg-2" >
                      <label for="">Color</label>
                      <select class="form-control select2" id="color_dropdownFabric">
                        
                      </select>

                    </div>


                    <!-- <div class="col-lg-3">
                      <label for="">Fabric</label>



                      <select class="form-control select2" id="Fabric_dropdownFabric">
                        <option value="" disabled="" selected="">Item Description</option>
                        ';foreach ($items as $item): ;echo '                          <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" >';echo $item['item_des'];;echo '</option>
                        ';endforeach ;echo '                      </select>

                    </div> -->

                    <div class="col-lg-3">
                      <label for="">Fabric Detail<img id="imgItemFabricLoader" 
                        class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>



                        <input type="text" class="form-control" id="txtItemFabricId">
                        <input id="hfItemFabricId" type="hidden" value="" />
                        <input id="hfItemFabricSize" type="hidden" value="" />
                        <input id="hfItemFabricBid" type="hidden" value="" />
                        <input id="hfItemFabricUom" type="hidden" value="" />
                        <input id="hfItemFabricUname" type="hidden" value="" />

                        <input id="hfItemFabricPrate" type="hidden" value="" />
                        <input id="hfItemFabricGrWeight" type="hidden" value="" />
                        <input id="hfItemFabricStQty" type="hidden" value="" />
                        <input id="hfItemFabricStWeight" type="hidden" value="" />
                        <input id="hfItemFabricLength" type="hidden" value="" />
                        <input id="hfItemFabricCatId" type="hidden" value="" />
                        <input id="hfItemFabricSubCatId" type="hidden" value="" />
                        <input id="hfItemFabricDesc" type="hidden" value="" />
                        <input id="hfItemFabricShortCode" type="hidden" value="" />
                        <input id="hfItemFabricBarcode" type="hidden" value="" />

                        <input id="hfItemFabricInventoryId" type="hidden" value="" />
                        <input id="hfItemFabricCostId" type="hidden" value="" />




                      </div>

                      <div class="col-lg-1">
                        <label for="">GSM</label>                                                    
                        <input type="text" class="form-control num"  id="txtFabricGsm">
                      </div>
                      <div class="col-lg-1">
                        <label for="">Width</label>                                                    
                        <input type="text" class="form-control num"  id="txtFabricWidth">
                      </div>

                      <div class="col-lg-1">
                        <label for="">Color</label>                                                    
                        
                        <input type="text" list=\'fabric_color\' class="form-control input-sm" id="txtFabricColor"  />
                        <datalist id=\'fabric_color\'>
                          
                        </datalist>

                      </div>

                      <div class="col-lg-1">
                        <label for="">Net/Pcs</label>                                                    
                        <input type="text" class="form-control num"  id="txtQtyFabric">                                                    
                      </div>
                    </div>
                    <div class="row">

                      <div class="col-lg-1">
                        <label for="">Wastage%</label>                                                    
                        <input type="text" class="form-control num" id="txtWastageFabric">                                                    
                      </div>

                      <div class="col-lg-1">
                        <label for="">Gr Weight</label>                                                    
                        <input type="text" class="form-control num" disabled=""  id="txtQtyFabricWeight">                                                    
                      </div>


                      
                      
                    <!-- <div class="col-lg-3" >
                      <label for="">Yarn &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id=\'txtUomFabric\'></span></label>



                      <select class="form-control select2" id="itemid_dropdownFabric">
                        <option value="" disabled="" selected="">Item Description</option>
                        ';foreach ($items as $item): ;echo '                          <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" >';echo $item['item_des'];;echo '</option>
                        ';endforeach ;echo '                      </select>

                    </div> -->
                    <div class="col-lg-2">
                      <label>Used For</label>
                      <div class="input-group" >
                        <select class="form-control input-sm select2" id="usedfor_dropdownFabric">
                        </select>
                        <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;height: 33px !important;" id="A2" data-target="#usedForModel" data-toggle="modal" href="#usedForModel" rel="tooltip"
                        data-placement="top" data-original-title="Add New" data-toggle="tooltip" data-placement="bottom" title="Add New Used">+</a>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <label for="">Yarn Detail<img id="imgItemYarnLoader" 
                        class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>

                        <input type="text" class="form-control" id="txtItemYarnId">
                        <input id="hfItemYarnId" type="hidden" value="" />
                        <input id="hfItemYarnSize" type="hidden" value="" />
                        <input id="hfItemYarnBid" type="hidden" value="" />
                        <input id="hfItemYarnUom" type="hidden" value="" />
                        <input id="hfItemYarnUname" type="hidden" value="" />

                        <input id="hfItemYarnPrate" type="hidden" value="" />
                        <input id="hfItemYarnGrWeight" type="hidden" value="" />
                        <input id="hfItemYarnStQty" type="hidden" value="" />
                        <input id="hfItemYarnStWeight" type="hidden" value="" />
                        <input id="hfItemYarnLength" type="hidden" value="" />
                        <input id="hfItemYarnCatId" type="hidden" value="" />
                        <input id="hfItemYarnSubCatId" type="hidden" value="" />
                        <input id="hfItemYarnDesc" type="hidden" value="" />
                        <input id="hfItemYarnShortCode" type="hidden" value="" />
                        <input id="hfItemYarnBarcode" type="hidden" value="" />

                        <input id="hfItemYarnInventoryId" type="hidden" value="" />
                        <input id="hfItemYarnCostId" type="hidden" value="" />




                      </div>




                      

                      <div class="col-lg-1">
                        <label for="">%Age</label>                                                    
                        <input type="text" class="form-control num" id="txtPercentageFabric">                                                    
                      </div>

                      <div class="col-lg-1">
                        <label for="">NetQty</label>                                                    
                        <input type="text" class="form-control num" readonly="" id="txtQtyGrossFabric">                                                    
                      </div>





                      <div class="col-lg-1">
                        <label for="">Rate</label>                                                    
                        <input type="text" class="form-control num" id="txtPRateFabric">                                                    
                      </div>


                      <div class="col-lg-1">
                        <label for="">Amount</label>                                                    
                        <input type="text" class="form-control readonly num" id="txtAmountFabric" readonly="true" tabindex="-1">                                                    
                      </div>
                      <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                        <a href="" class="btn btn-primary" id="btnAddFabric">+</a>
                      </div>                                                
                    </div>

                    <div class="row">
                      <div class="col-lg-12">

                        <div id="no-more-tables">
                          <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Fabric_table">
                            <thead class="cf">
                              <th>Sr#</th>
                              <th>Article</th>
                              <th>Article Color</th>

                              <th>Fabric</th>
                              <th>GSM</th>
                              <th>Width</th>
                              <th>Color</th>

                              <th class="numeric text-right">Net/Pcs</th>
                              <th class="numeric text-right">Wastage%</th>
                              <th class="numeric text-right">GrossQty</th>
                              <th>UsedFor</th>
                              <th>Yarn</th>
                              <th class="numeric text-right">%Age</th>
                              <th class="numeric text-right">NetQty</th>
                              <th class="numeric text-right">Rate</th>
                              <th class="numeric text-right">Amount</th>
                              <th>Action</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot class="tfoot_tbl cf">
                              <tr>

                                <td colspan="7" class="text-right" >Total:</td>  
                                <td class="text-right" id="txtTotalGrossQtyFabric"></td>
                                <td></td>
                                <td class="text-right" id="txtTotalGrossQtyWeightFabric"></td>

                                <td></td>
                                <td></td>
                                <td class="text-right" id="txtTotalYarnPercentFabric"></td>
                                <td class="text-right" id="txtTotalQtyFabric"></td>
                                <td></td>
                                <td class="text-right" id="txtTotalAmountFabric"></td> 
                                <td></td>
                              </tr>
                            </tfoot>

                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ENd Fabric -->


                <!-- Start Packing  -->
                <div class="tab-pane fade in" id="Packing">
                 <div class="container-wrap">
                  <div class="row">

                    <div class="col-lg-2" >
                      <label for="">Article</label>
                      <select class="form-control select2" id="article_dropdownPacking">
                        <option value="" disabled="" selected="">Article</option>
                        ';foreach ($short_codes as $item): ;echo '                          <option value="';echo $item['vrnoa'];;echo '">';echo $item['short_code'];;echo '</option>
                        ';endforeach ;echo '                      </select>

                    </div>

                    <div class="col-lg-2" >
                      <label for="">Color</label>
                      <select class="form-control select2" id="color_dropdownPacking">
                        
                      </select>

                    </div>


              
                  <div class="col-lg-3">
                    <label for="">Item Detail<img id="imgItemPackingLoader" 
                      class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>

                      <input type="text" class="form-control" id="txtItemPackingId">
                      <input id="hfItemPackingId" type="hidden" value="" />
                      <input id="hfItemPackingSize" type="hidden" value="" />
                      <input id="hfItemPackingBid" type="hidden" value="" />
                      <input id="hfItemPackingUom" type="hidden" value="" />
                      <input id="hfItemPackingUname" type="hidden" value="" />

                      <input id="hfItemPackingPrate" type="hidden" value="" />
                      <input id="hfItemPackingGrWeight" type="hidden" value="" />
                      <input id="hfItemPackingStQty" type="hidden" value="" />
                      <input id="hfItemPackingStWeight" type="hidden" value="" />
                      <input id="hfItemPackingLength" type="hidden" value="" />
                      <input id="hfItemPackingCatId" type="hidden" value="" />
                      <input id="hfItemPackingSubCatId" type="hidden" value="" />
                      <input id="hfItemPackingDesc" type="hidden" value="" />
                      <input id="hfItemPackingShortCode" type="hidden" value="" />
                      <input id="hfItemPackingBarcode" type="hidden" value="" />

                      <input id="hfItemPackingInventoryId" type="hidden" value="" />
                      <input id="hfItemPackingCostId" type="hidden" value="" />




                    </div>



                    <div class="col-lg-2">
                      <label>Used For</label>
                      <div class="input-group" >
                        <select class="form-control input-sm select2" id="usedfor_dropdownPacking">
                        </select>
                        <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;height: 33px !important;" id="A2" data-target="#usedForModel" data-toggle="modal" href="#usedForModel" rel="tooltip"
                        data-placement="top" data-original-title="Add New" data-toggle="tooltip" data-placement="bottom" title="Add New Used">+</a>
                      </div>
                    </div>

                    <div class="col-lg-1">
                        <label for="">Net/Pcs</label>                                                    
                        <input type="text" class="form-control num"  id="txtQtyPackingPerPcs">                                                    
                    </div>

                    <div class="col-lg-1">
                      <label for="">Qty</label>                                                    
                      <input type="text" class="form-control num" id="txtQtyGrossPacking">                                                    
                    </div>
                    <div class="col-lg-1">
                      <label for="">Wastage</label>                                                    
                      <input type="text" class="form-control num" id="txtWastagePacking">                                                    
                    </div>

                    <div class="col-lg-1">
                      <label for="">GrossQty</label>                                                    
                      <input type="text" class="form-control num" readonly="" id="txtQtyPacking">                                                    
                    </div>


                    <div class="col-lg-1">
                      <label for="">Rate</label>                                                    
                      <input type="text" class="form-control num" id="txtPRatePacking">                                                    
                    </div>


                    <div class="col-lg-1">
                      <label for="">Amount</label>                                                    
                      <input type="text" class="form-control readonly num" id="txtAmountPacking" readonly="true" tabindex="-1">                                                    
                    </div>
                    <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                      <a href="" class="btn btn-primary" id="btnAddPacking">+</a>
                    </div>                                                
                  </div>

                  <div class="row">
                    <div class="col-lg-12">

                      <div id="no-more-tables">
                        <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Packing_table">
                          <thead class="cf">
                            <th>Sr#</th>
                            <th>Article</th>
                              <th>Article Color</th>

                            <th>Item Detail</th>
                            <th>UOM</th>
                            <th>UsedFor</th>
                            <th class="numeric text-right">Net/Pcs</th>

                            <th class="numeric text-right">Qty</th>
                            <th class="numeric text-right">Wastage%</th>
                            <th class="numeric text-right">GrossQty</th>
                            <th class="numeric text-right">Rate</th>
                            <th class="numeric text-right">Amount</th>
                            <th>Action</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot class="tfoot_tbl cf">
                            <tr>
                            

                              <td colspan="7" >Total:</td>  
                              <td class="text-right" id="txtTotalGrossQtyPacking"></td>
                              <td ></td>
                              <td class="text-right" id="txtTotalQtyPacking"></td>
                              <td ></td>
                              <td class="text-right" id="txtTotalAmountPacking"></td> 
                              <td></td>
                            </tr>
                          </tfoot>

                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ENd Packing -->

              <!-- Start Labour Rate -->
              <div class="tab-pane fade " id="Labour">
               <div class="container-wrap">
                <div class="row">

                 <div class="col-lg-1" >
                  <label for="">Article</label>
                  <select class="form-control select2" id="article_dropdownLabour">
                    <option value="" disabled="" selected="">Article</option>
                    ';foreach ($short_codes as $item): ;echo '                      <option value="';echo $item['vrnoa'];;echo '">';echo $item['short_code'];;echo '</option>
                    ';endforeach ;echo '                  </select>

                </div>

                <div class="col-lg-3" >
                  <label for="" id="stqty_lbll">Sub Phase</label>
                  <div class="input-group" >
                    <select class="form-control select2" id="subPhase_dropdown">
                      <option value="" disabled="" selected="">Select Sub Phase</option>
                      ';foreach ($subPhases as $subPhases): ;echo '                        <option value="';echo $subPhases['id'];;echo '">';echo $subPhases['name'];;echo '</option>
                      ';endforeach ;echo '                    </select>
                    <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#SubPhaseAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                    data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Phase(F3)">+</a>
                  </div>
                </div>
                <div class="col-lg-1 hide">
                  <label for="">Uom</label>                                                    
                  <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                </div>

                <div class="col-lg-1">
                  <label for="">Qty</label>                                                    
                  <input type="text" class="form-control num" id="txtQtyGrossLabour">                                                    
                </div>

                <div class="col-lg-1">
                  <label for="">Wastage</label>                                                    
                  <input type="text" class="form-control num" id="txtWastageLabour">                                                    
                </div>

                <div class="col-lg-1">
                  <label for="">GrossQty</label>                                                    
                  <input type="text" class="form-control num" readonly="" id="txtQtyLabour">                                                    
                </div>


                <div class="col-lg-1">
                  <label for="">DozenRate</label>                                                    
                  <input type="text" class="form-control num" id="txtPRate">                                                    
                </div>


            <!-- <div class="col-lg-2">
              <label>Calculation Method</label>
              <input type="text" list=\'Caltype\' class="form-control input-sm" id="txtCalculationMethod">
              <datalist id=\'Caltype\'>
                ';foreach ($calulationMethods as $calulationMethods): ;echo '                  <option value="';echo $calulationMethods['calculationmethod'];;echo '">
                  ';endforeach ;echo '                </datalist>
              </div> -->
              <div class="col-lg-1">
                <label for="">PcsRate</label>                                                    
                <input type="text" class="form-control readonly num" id="txtRate2"  tabindex="-1">                                                    
              </div>



              <div class="col-lg-1">
                <label for="">Amount</label>                                                    
                <input type="text" class="form-control readonly num" id="txtAmountLabour" readonly="true" tabindex="-1">                                                    
              </div>


              <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                <a href="" class="btn btn-primary" id="btnAddLabour">+</a>
              </div>                                                
            </div>

            <div class="row">
              <div class="col-lg-12">

                <div id="no-more-tables">
                  <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Labour_table">
                    <thead class="cf">
                      <tr>
                        <th>Sr#</th>
                        <th>Article</th>
                        <th>Sub Phase</th>
                        <th class="hide">UOM</th>
                        <th class="text-right">QtyGross</th>
                        <th class="text-right">Wastage</th>

                        <th class="text-right">Qty</th>

                        <th class="text-right">DozenRate</th>
                        <!-- <th class="">Calculation Method</th> -->
                        <th class="text-right">PcsRate</th>
                        <th class="text-right">Amount</th>

                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot class="tfoot_tbl cf">
                      <tr>
                        <td></td>        
                        <td></td>                                   

                        <td style=\'color:red !important;\'>Total:</td>
                        <td class="hide"></td>
                        <td id="txtTotalQtyGrossFabrication"></td>
                        <td id=""></td>
                        <td id="txtTotalQtyLabour"></td>                                  
                        <td id="txtTotalRate1"></td>                                  
                        <td class="hide"></td>
                        <td id="txtTotalRate2" class=""></td> 
                        <td id="txtTotalAmountLabour" class=""></td> 
                        <td></td>
                      </tr>
                    </tfoot>

                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Labour Rate -->


        <!-- Start Embelishment Rate -->
        <div class="tab-pane fade " id="Embelishment">
         <div class="container-wrap">
          <div class="row">

           <div class="col-lg-1" >
            <label for="">Article</label>
            <select class="form-control select2" id="article_dropdownEmbelishment">
              <option value="" disabled="" selected="">Article</option>
              ';foreach ($short_codes as $item): ;echo '                <option value="';echo $item['vrnoa'];;echo '">';echo $item['short_code'];;echo '</option>
              ';endforeach ;echo '            </select>

          </div>

          <div class="col-lg-3" >
            <label for="" id="stqty_lbll">Sub Phase</label>
            <div class="input-group" >
              <select class="form-control select2" id="subPhase_dropdown_Embelishment">
                <option value="" disabled="" selected="">Select Sub Phase</option>
                ';foreach ($subPhases22 as $subPhase): ;echo '                  <option value="';echo $subPhase['id'];;echo '">';echo $subPhase['name'];;echo '</option>
                ';endforeach ;echo '              </select>
              <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#SubPhaseAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
              data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Phase(F3)">+</a>
            </div>
          </div>

          <div class="col-lg-1 hide">
            <label for="">Uom</label>                                                    
            <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
          </div>

          <div class="col-lg-1">
            <label for="">Qty</label>                                                    
            <input type="text" class="form-control num" id="txtQtyGrossEmbelishment">                                                    
          </div>

          <div class="col-lg-1">
            <label for="">Wastage</label>                                                    
            <input type="text" class="form-control num" id="txtWastageEmbelishment">                                                    
          </div>

          <div class="col-lg-1">
            <label for="">GrossQty</label>                                                    
            <input type="text" class="form-control num" readonly="" id="txtQtyEmbelishment">                                                    
          </div>


          <div class="col-lg-1">
            <label for="">DozenRate</label>                                                    
            <input type="text" class="form-control num" id="txtPRateEmbelishment">                                                    
          </div>


            <!-- <div class="col-lg-2">
              <label>Calculation Method</label>
              <input type="text" list=\'Caltype\' class="form-control input-sm" id="txtCalculationMethod">
              <datalist id=\'Caltype\'>
                ';foreach ($calulationMethods as $calulationMethods): ;echo '                  <option value="';echo $calulationMethods['calculationmethod'];;echo '">
                  ';endforeach ;echo '                </datalist>
              </div> -->
              <div class="col-lg-1">
                <label for="">PcsRate</label>                                                    
                <input type="text" class="form-control readonly num" id="txtRate2Embelishment"  tabindex="-1">                                                    
              </div>



              <div class="col-lg-1">
                <label for="">Amount</label>                                                    
                <input type="text" class="form-control readonly num" id="txtAmountEmbelishment" readonly="true" tabindex="-1">                                                    
              </div>


              <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                <a href="" class="btn btn-primary" id="btnAddEmbelishment">+</a>
              </div>                                                
            </div>

            <div class="row">
              <div class="col-lg-12">

                <div id="no-more-tables">
                  <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Embelishment_table">
                    <thead class="cf">
                      <tr>
                        <th>Sr#</th>
                        <th>Article</th>
                        <th>Sub Phase</th>
                        <th class="hide">UOM</th>
                        <th class="text-right">QtyGross</th>
                        <th class="text-right">Wastage</th>
                        <th class="text-right">Qty</th>

                        <th class="text-right">DozenRate</th>
                        <!-- <th class="">Calculation Method</th> -->
                        <th class="text-right">PcsRate</th>
                        <th class="text-right">Amount</th>

                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot class="tfoot_tbl cf">
                      <tr>
                        <td></td>        
                        <td></td>                                   

                        <td style=\'color:red !important;\'>Total:</td>
                        <td class="hide"></td>
                        <td id="txtTotalQtyGrossFabrication"></td>
                        <td id=""></td>
                        <td id="txtTotalQtyEmbelishment"></td>                                  
                        <td id="txtTotalRate1Embelishment"></td>                                  
                        <td class="hide"></td>
                        <td id="txtTotalRate2Embelishment" class=""></td> 
                        <td id="txtTotalAmountEmbelishment" class=""></td> 
                        <td></td>
                      </tr>
                    </tfoot>

                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Embelishment Rate -->

        <!-- Start Fabrication Rate -->
        <div class="tab-pane fade " id="Fabrication">
         <div class="container-wrap">
          <div class="row">

           <div class="col-lg-1" >
            <label for="">Article</label>
            <select class="form-control select2" id="article_dropdownFabrication">
              <option value="" disabled="" selected="">Article</option>
              ';foreach ($short_codes as $item): ;echo '                <option value="';echo $item['vrnoa'];;echo '">';echo $item['short_code'];;echo '</option>
              ';endforeach ;echo '            </select>

          </div>

          <div class="col-lg-3" >
            <label for="" id="stqty_lbll">Sub Phase</label>
            <div class="input-group" >
              <select class="form-control select2" id="subPhase_dropdown_Fabrication">
                <option value="" disabled="" selected="">Select Sub Phase</option>
                ';foreach ($subPhases22 as $subPhase): ;echo '                  <option value="';echo $subPhase['id'];;echo '">';echo $subPhase['name'];;echo '</option>
                ';endforeach ;echo '              </select>
              <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#SubPhaseAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
              data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Phase(F3)">+</a>
            </div>
          </div>

          <div class="col-lg-1 hide">
            <label for="">Uom</label>                                                    
            <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
          </div>

          <div class="col-lg-1">
            <label for="">Qty</label>                                                    
            <input type="text" class="form-control num" id="txtQtyGrossFabrication">                                                    
          </div>

          <div class="col-lg-1">
            <label for="">Wastage</label>                                                    
            <input type="text" class="form-control num" id="txtWastageFabrication">                                                    
          </div>

          <div class="col-lg-1">
            <label for="">GrossQty</label>                                                    
            <input type="text" class="form-control num" readonly="" id="txtQtyFabrication">                                                    
          </div>


          <div class="col-lg-1">
            <label for="">DozenRate</label>                                                    
            <input type="text" class="form-control num" id="txtPRateFabrication">                                                    
          </div>


            <!-- <div class="col-lg-2">
              <label>Calculation Method</label>
              <input type="text" list=\'Caltype\' class="form-control input-sm" id="txtCalculationMethod">
              <datalist id=\'Caltype\'>
                ';foreach ($calulationMethods as $calulationMethods): ;echo '                  <option value="';echo $calulationMethods['calculationmethod'];;echo '">
                  ';endforeach ;echo '                </datalist>
              </div> -->
              <div class="col-lg-1">
                <label for="">PcsRate</label>                                                    
                <input type="text" class="form-control readonly num" id="txtRate2Fabrication"  tabindex="-1">                                                    
              </div>



              <div class="col-lg-1">
                <label for="">Amount</label>                                                    
                <input type="text" class="form-control readonly num" id="txtAmountFabrication" readonly="true" tabindex="-1">                                                    
              </div>


              <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                <a href="" class="btn btn-primary" id="btnAddFabrication">+</a>
              </div>                                                
            </div>

            <div class="row">
              <div class="col-lg-12">

                <div id="no-more-tables">
                  <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Fabrication_table">
                    <thead class="cf">
                      <tr>
                        <th>Sr#</th>
                        <th>Article</th>
                        <th>Sub Phase</th>
                        <th class="hide">UOM</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">QtyGross</th>
                        <th class="text-right">Wastage</th>
                        <th class="text-right">DozenRate</th>
                        <!-- <th class="">Calculation Method</th> -->
                        <th class="text-right">PcsRate</th>
                        <th class="text-right">Amount</th>

                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot class="tfoot_tbl cf">
                      <tr>
                        <td></td>        
                        <td></td>                                   

                        <td style=\'color:red !important;\'>Total:</td>
                        <td class="hide"></td>
                        <td id="txtTotalQtyGrossFabrication"></td>
                        <td id=""></td>                                  

                        <td id="txtTotalQtyFabrication"></td>                                  
                        <td id="txtTotalRate1Fabrication"></td>                                  
                        <td class="hide"></td>
                        <td id="txtTotalRate2Fabrication" class=""></td> 
                        <td id="txtTotalAmountFabrication" class=""></td> 
                        <td></td>
                      </tr>
                    </tfoot>

                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Fabrication Rate -->

        <!-- Start Labour Rate -->
        <div class="tab-pane fade " id="Production_plan">
          <div class="container-wrap">
            <div class="row">
              <div class="col-lg-2" >
                <label for="">Style No</label>
                <select class="form-control select2" id="itemid_dropdownProduction">
                  <option value="" disabled="" selected="">Item Id</option>
                  ';foreach ($items as $item): ;echo '                    <option value="';echo $item['item_id'];;echo '" data-size="';echo $item['size'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-srate="';echo $item['srate'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '">';echo $item['artcile_no'];;echo '</option>
                  ';endforeach ;echo '                </select>
              </div>
              <!-- <div class="col-lg-3" >
               <label for="">Item Description</label>
               <div class="input-group">                                              
                 <select class="form-control select2" id="item_dropdownProduction" style="width: 220px;">
                   <option value="" disabled="" selected="">Item Description</option>
                   ';foreach ($items as $item): ;echo '                     <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo ' " data-stqty="';echo $item['stqty'];;echo '" data-size="';echo $item['size'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_des'];;echo '</option>
                   ';endforeach ;echo '                 </select>
               </div>
             </div> -->

             <div class="col-lg-3">
              <label for="">Item Detail<img id="imgItemProductionLoader" 
                class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>

                <input type="text" class="form-control" id="txtItemProductionId">
                <input id="hfItemProductionId" type="hidden" value="" />
                <input id="hfItemProductionSize" type="hidden" value="" />
                <input id="hfItemProductionBid" type="hidden" value="" />
                <input id="hfItemProductionUom" type="hidden" value="" />
                <input id="hfItemProductionUname" type="hidden" value="" />

                <input id="hfItemProductionPrate" type="hidden" value="" />
                <input id="hfItemProductionGrWeight" type="hidden" value="" />
                <input id="hfItemProductionStQty" type="hidden" value="" />
                <input id="hfItemProductionStWeight" type="hidden" value="" />
                <input id="hfItemProductionLength" type="hidden" value="" />
                <input id="hfItemProductionCatId" type="hidden" value="" />
                <input id="hfItemProductionSubCatId" type="hidden" value="" />
                <input id="hfItemProductionDesc" type="hidden" value="" />
                <input id="hfItemProductionShortCode" type="hidden" value="" />
                <input id="hfItemProductionBarcode" type="hidden" value="" />

                <input id="hfItemProductionInventoryId" type="hidden" value="" />
                <input id="hfItemProductionCostId" type="hidden" value="" />




              </div>

              <div class="col-lg-1">
                <label for="">Weight</label>                                                    
                <input type="text" class="form-control" id="txtWeight">                                                    
              </div>
              <div class="col-lg-1">
                <label for="">Size</label>                                                    
                <input type="text" class="form-control" id="txtSize">                                                    
              </div>
              <div class="col-lg-1">
                <label for="">Label</label>                                                    
                <input type="text" list="labellist" class="form-control" id="txtLabel">
                <datalist id=\'labellist\'>
                  ';foreach ($labels as $label): ;echo '                    <option value="';echo $label['label'];;echo '">
                    ';endforeach ;echo '                  </datalist>
                </div>
                <div class="col-lg-2">
                  <label for="">Poly Bag Paper Slip</label>                                                    
                  <input type="text" list="pbpapersliplist" class="form-control" id="txtPolyBagPaperSlip">
                  <datalist id=\'pbpapersliplist\'>
                    ';foreach ($pbpaperslips as $pbpaperslip): ;echo '                      <option value="';echo $pbpaperslip['polybag_paperslip'];;echo '">
                      ';endforeach ;echo '                    </datalist>
                  </div>
                  <div class="col-lg-2">
                    <label for="">Poly Bag Sticker</label>                                                    
                    <input type="text" list="pbstickerlist" class="form-control" id="txtPolyBagSticker">
                    <datalist id=\'pbstickerlist\'>
                      ';foreach ($pbstickers as $pbsticker): ;echo '                        <option value="';echo $pbsticker['polybag_sticker'];;echo '">
                        ';endforeach ;echo '                      </datalist>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2">
                      <label for="">Carton Paper Slip</label>                                                    
                      <input type="text" list="ctnpapersliplist" class="form-control" id="txtCartonPaperSlip">
                      <datalist id=\'ctnpapersliplist\'>
                        ';foreach ($ctnpaperslips as $ctnpaperslip): ;echo '                          <option value="';echo $ctnpaperslip['carton_paperslip'];;echo '">
                          ';endforeach ;echo '                        </datalist>
                      </div>
                      <div class="col-lg-2">
                        <label for="">Carton Sticker</label>                                                    
                        <input type="text" list="ctnstickerlist" class="form-control" id="txtCartonSticker">
                        <datalist id=\'ctnstickerlist\'>
                         ';foreach ($ctnstickers as $ctnsticker): ;echo '                           <option value="';echo $ctnsticker['carton_sticker'];;echo '">
                           ';endforeach ;echo '                         </datalist>
                       </div>
                       <div class="col-lg-2">
                        <label for="">Poly Bag Packing</label>                                                    
                        <input type="text" list="pbpackinglist" class="form-control" id="txtPolyBagPacking">
                        <datalist id=\'pbpackinglist\'>
                          ';foreach ($pbpackings as $pbpacking): ;echo '                            <option value="';echo $pbpacking['polybag_packing'];;echo '">
                            ';endforeach ;echo '                          </datalist>
                        </div>
                        <div class="col-lg-2">
                          <label for="">Carton Packing</label>                                                    
                          <input type="text" list="ctnpackinglist" class="form-control" id="txtCartonPacking">
                          <datalist id=\'ctnpackinglist\'>
                            ';foreach ($ctnpackings as $ctnpacking): ;echo '                              <option value="';echo $ctnpacking['carton_packing'];;echo '">
                              ';endforeach ;echo '                            </datalist>
                          </div>
                          <div class="col-lg-2">
                            <label for="">Total Dozen</label>
                            <input type="text" class="form-control" id="txtTotalDozen">
                          </div>
                          <div class="col-lg-2">
                            <label for="">Total Carton</label>                                                    
                            <input type="text" class="form-control" id="txtTotalCarton">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-2">
                            <label for="">Carton Marking</label>
                            <input type="text" list="ctnmarkinglist" class="form-control" id="txtCartonMarking" style="width:160px;">
                            <datalist id=\'ctnmarkinglist\'>
                              ';foreach ($ctnmarkings as $ctnmarking): ;echo '                                <option value="';echo $ctnmarking['carton_marking'];;echo '">
                                ';endforeach ;echo '                              </datalist>
                            </div>
                            <div class="col-lg-1" style=\'margin-top: 31px;\'>
                              <a href="" class="btn btn-primary" id="btnAddProductionPlan">+</a>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">  
                              <div id="no-more-tables">
                                <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="ProductionPlan_table">
                                  <thead class="cf">
                                    <tr>
                                      <th>Sr#</th>
                                      <th style="width:65px;">Style No</th>
                                      <th style="width:150px;">Item Description</th>
                                      <th class="numeric" style=\'text-align:right;width:40px;\'>Weight</th>
                                      <th class="numeric" style=\'text-align:right;width:40px;\'>Size</th>
                                      <th style="width:80px;">Label</th>
                                      <th style="width:100px;">PolyBag Paper Slip</th>
                                      <th>PolyBag Sticker</th>
                                      <th>Carton Paper Slip</th>
                                      <th>Carton Sticker</th>
                                      <th>PolyBag Packing</th>
                                      <th>Carton Packing</th>
                                      <th>Total Dozen</th>
                                      <th>Total Carton</th>
                                      <th>Carton Marking</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                  <tfoot class="tfoot_tbl cf">
                                    <tr>
                                      <td></td>                                   
                                      <td style=\'color:red !important;\'></td>
                                      <td style=\'color:red !important; text-align:right;\'>Total:</td>  
                                      <td id="txtTotalWeight" style=\'color:red !important; text-align:right;background:white;\'></td>                                  
                                      <td id="txtTotalSize" style=\'color:red !important;text-align:right;background:white;\'></td> 
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td id="tdTotalDozen" style=\'color:red !important; background:white;\'></td>
                                      <td id="tdTotalCarton" style=\'color:red !important; background:white;\'></td>
                                      <td></td>
                                      <td></td>
                                    </tr>
                                  </tfoot>
                                </table>
                              </div>
                            </div>
                          </div>  
                        </div>
                      </div>
                      <!-- End Labour Rate -->
                    </div>

                    <div id="party-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h3 id="myModalLabel">Party Lookup</h3>
                          </div>

                          <div class="modal-body">
                            <table class="table table-striped modal-table">

                              <thead>
                                <tr style="font-size:16px;">
                                  <th>Id</th>
                                  <th>Name</th>
                                  <th>Mobile</th>
                                  <th>Address</th>
                                  <th style=\'width:3px;\'>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                ';foreach ($parties as $party): ;echo '                                  <tr>
                                    <td width="14%;">
                                      ';echo $party['account_id'];;echo '                                      <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                                    </td>
                                    <td>';echo $party['name'];;echo '</td>
                                    <td>';echo $party['mobile'];;echo '</td>
                                    <td>';echo $party['address'];;echo '</td>
                                    <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa fa-search"></i></a></td>
                                  </tr>
                                ';endforeach ;echo '                              </tbody>
                            </table>
                          </div>
                          <div class="modal-footer">

                            <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="item-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h3 id="myModalLabel">item Lookup</h3>
                          </div>

                          <div class="modal-body">
                            <table class="table table-striped modal-table">
                              <!-- <table class="table table-bordered table-striped modal-table"> -->
                                <thead>
                                  <tr style="font-size:16px;">
                                    <th>Id</th>
                                    <th>Description</th>
                                    <th>Code</th>
                                    <th>Uom</th>
                                    <th style=\'width:3px;\'>Actions</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  ';foreach ($items as $item): ;echo '                                    <tr>
                                      <td width="14%;">
                                        ';echo $item['item_id'];;echo '                                        <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                                      </td>
                                      <td>';echo $item['item_des'];;echo '</td>
                                      <td>';echo $item['item_code'];;echo '</td>
                                      <td>';echo $item['uom'];;echo '</td>
                                      <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa fa-search"></i></a></td>
                                    </tr>
                                  ';endforeach ;echo '                                </tbody>
                              </table>
                            </div>
                            <div class="modal-footer">

                              <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            </div>
                          </div>
                        </div>
                      </div>


                    </form> <!-- end of form -->

                  </div>  <!-- end of panel-body -->
                </div>  <!-- end of panel -->
              </div>  <!-- end of col -->
            </div>  <!-- end of row -->

            <div class="row">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-body">

                    <div class="row">
                      <div class="col-lg-3">
                        <label>Prepared By</label>

                        <input type="text" list=\'prepareBy\' class="form-control input-sm" id="txtPreparedBy">
                        <datalist id=\'prepareBy\'>
                         ';foreach ($PreparedBys as $PreparedBy): ;echo '                           <option value="';echo $PreparedBy['prepareBy'];;echo '">
                           ';endforeach ;echo '                         </datalist>
                       </div>
                       <div class="col-lg-3">
                        <label>Approved By</label>
                        <input type="text" list=\'ApprovedBy\' class="form-control input-sm" id="txtApprovedBy">
                        <datalist id=\'ApprovedBy\'>
                         ';foreach ($ApprovedBys as $ApprovedBy): ;echo '                           <option value="';echo $ApprovedBy['approveBy'];;echo '">
                           ';endforeach ;echo '                         </datalist>
                       </div>
                     </div>

                     <div class="row">                                                                                    
                      <div class="col-lg-10">
                        <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                        <a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-savesubphasebtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['sorequiredmaterial']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['sorequiredmaterial']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['sorequiredmaterial']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['sorequiredmaterial']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                        <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>

                        <div class="btn-group">
                          <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li ><a href="#" class="btnprintHeader">With header</a></li>

                            <li ><a href="#" class="btnprint_sm">Small</a></li>

                            <li ><a href="#" class="btnprint_sm_rate">Small with out rate</a></li>
                            <li ><a href="#" class="btnPrintProductionPlan">Production Plan</a></li>
                            <li ><a href="#" class="btnPrintFabricDemand">Print Demand</a></li>

                          </ul>
                        </div>
                        <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
                        <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
                      </div>


                    </div>
                    <div class="row">
                      <div class="col-lg-3 hide">
                        <div class="form-group">                                                                
                          <div class="input-group">
                            <span class="switch-addon input-group-addon">Pre Bal?</span>
                            <input type="checkbox" checked="" class="bs_switch" id="switchPreBal">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">                                                                
                          <div class="input-group">
                            <span class="switch-addon input-group-addon">Print Header?</span>
                            <input type="checkbox" checked="" class="bs_switch" id="switchHeader">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group">
                          <span class="input-group-addon">User: </span>
                          <input type="text" class=" form-control"  id="txtUserName" >

                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group">
                          <span class="input-group-addon">Posting: </span>
                          <input type="text" class=" form-control"  id="txtPostingDate" >

                        </div>
                      </div>

                    </div>
                  </div>  <!-- end of row -->
                </div>
              </div>
            </div>
          </div>

        </div>  <!-- end of level 1-->
      </div>
    </div>
  </div>
</div>

<div id="usedForModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="model-contentwrapper">
    <div class="modal-header" style="background:#64b92a; color:white;">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">Add New Used</h3>
    </div>
    <div class="modal-body" style="background:#E7F0EF;">

      <div class="form-group">
        <div class="row">
          <div class="col-lg-5">
            <label>Name</label>
            <input type="hidden" id="txtMadeIdHidden">
            <input type="text" class="form-control" id="txtUsedName">
          </div>
          <div class="col-lg-5">
            <label>Description</label>
            <input type="text" class="form-control" id="txtUsedDescription">
          </div>
        </div><br>
      </div>
    </div>
    <div class="modal-footer">
      <div class="pull-right">
        <a class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
        <a class="btn btn-primary btnNewUsed addmodal"><i class="fa fa-plus"></i> Add</a>
      </div>
    </div>
  </div>
</div>';
?>