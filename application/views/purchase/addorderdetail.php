

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
                                                    ';foreach ($l3s as $l3): ;echo '                                                        <option value="';echo $l3['l3'];;echo '" data-level2="';echo $l3['level2_name'];;echo '" data-level1="';echo $l3['level1_name'];;echo '">';echo $l3['level3_name'] ;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
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
                                                    ';foreach ($categories as $category): ;echo '                                                        <option value="';echo $category['catid'];;echo '">';echo $category['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Sub Catgeory</label>
                                                <select class="form-control input-sm select2" id="subcategory_dropdown" tabindex="3">
                                                    <option value="" disabled="" selected="">Choose sub category</option>
                                                    ';foreach ($subcategories as $subcategory): ;echo '                                                        <option value="';echo $subcategory['subcatid'];;echo '">';echo $subcategory['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
                                            </div>
                                        </div>    
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label>Brand</label>
                                                <select class="form-control input-sm select2" id="brand_dropdown" tabindex="4">
                                                    <option value="" disabled="" selected="">Choose brand</option>
                                                    ';foreach ($brands as $brand): ;echo '                                                        <option value="';echo $brand['bid'];;echo '">';echo $brand['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Type</label>
                                                <input type="text" list=\'type\' class="form-control input-sm" id="txtBarcode" tabindex="5" />
                                                <datalist id=\'type\'>
                                                    ';foreach ($types as $type): ;echo '                                                        <option value="';echo $type['barcode'];;echo '">
                                                    ';endforeach ;echo '                                                </datalist>
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
                                                    ';foreach ($uoms as $uom): ;echo '                                                        ';if ($uom['uom'] !== ''): ;echo '                                                            <option value="';echo $uom['uom'];;echo '">
                                                        ';endif ;echo '                                                    ';endforeach ;echo '                                                </datalist>
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
                <h1 class="page_title">Order Detail Required Material</h1>
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
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon id-addon">PO #</span>
                                                    <input type="number" class="form-control input-sm " id="txtVrnoa" >
                                                    <input type="hidden" id="txtMaxVrnoaHidden">
                                                    <input type="hidden" id="txtVrnoaHidden">
                                                    <input type="hidden" id="voucher_type_hidden">

                                                    <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                                    <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                                    <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                                                    <input type="hidden" id="purchaseid" value="';echo $setting_configur[0]['purchase'];;echo '">
                                                    <input type="hidden" id="discountid" value="';echo $setting_configur[0]['discount'];;echo '">
                                                    <input type="hidden" id="expenseid" value="';echo $setting_configur[0]['expenses'];;echo '">
                                                    <input type="hidden" id="taxid" value="';echo $setting_configur[0]['tax'];;echo '">
                                                    <input type="hidden" id="cashid" value="';echo $setting_configur[0]['cash'];;echo '">

                                                </div>
                                            </div>
                                        <!--     <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Vr#</span>
                                                    <input type="text" class="form-control input-sm " id="txtVrno" readonly=\'true\'>
                                                    <input type="hidden" id="txtMaxVrnoHidden">
                                                    <input type="hidden" id="txtVrnoHidden">
                                                </div>
                                            </div>  -->                                              
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Date</span>
                                                    <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
                                                </div>
                                            </div>
                                        </div>
<!-- 
                                        <div class="row">
                                            
                                            <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Party Name</label>
                                                <div class="input-group" >
                                                    <select class="form-control select2" id="party_dropdown11" >
                                                        <option value="" disabled="" selected="">Choose party</option>
                                                        ';foreach ($parties as $party): ;echo '                                                            <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                    <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                                data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                </div>
                                              </div>
                     
                                                
                                            </div>
                                            

                                            <div class="col-lg-3">                                                
                                                <label>Warehouse</label>
                                                <div class="input-group" >
                                                <select class="form-control select2" id="dept_dropdown">
                                                    <option value="" selected="" disabled="">Choose Warehouse</option>
                                                    ';foreach ($departments as $department): ;echo '                                                        <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
                                                <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#GodownAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                                data-placement="top" data-original-title="Add Department" data-toggle="tooltip" data-placement="bottom" title="Add New Department Quick">+</a>
                                                </div>                            
                                            </div>
                                            <div class="col-lg-2">                                                
                                                <label>Received By</label>
                                                <input class=\'form-control input-sm \' type=\'text\' list="receivers" id=\'receivers_list\'>
                                                <datalist id=\'receivers\'>
                                                    ';foreach ($receivers as $receiver): ;echo '                                                        <option value="';echo $receiver['received_by'];;echo '">
                                                    ';endforeach ;echo '                                                </datalist>                                                
                                            </div>                                    
                                                                                 
                                            <div class="col-lg-3">                                                
                                                <label>Through</label>
                                                <select class="form-control select2" id="transporter_dropdown">
                                                    <option value="" disabled="" selected="">Choose transporter</option>
                                                    ';foreach ($transporters as $transporter): ;echo '                                                        <option value="';echo $transporter['transporter_id'];;echo '">';echo $transporter['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>                                               
                                            </div>
                                        </div>  --> 
                                        <div class="row"></div>                                      

                                        <div class="row" style="margin-top:0px;">
                                            <div class="col-lg-2">                                                
                                                <label>Consignee</label>
                                                <input type="text" class="form-control input-sm  num" id="txtInvNo">                                                
                                            </div>
                                            <div class="col-lg-2">                                                
                                                <label>Work Order No</label>
                                                <input class="form-control input-sm" type="text" id="txtWorkOrderNo">                                                
                                            </div>                                           
                                            <div class="col-lg-2">                                                
                                                <label>Shippment Date</label>
                                                <input type="text" class="form-control input-sm " id="txtOrderNo">    
                                            </div>  
                                            <div class="col-lg-2">                                                
                                                <label>Total CTN Order</label>
                                                <input type="text" class="form-control input-sm " id="txtOrderNo">    
                                            </div>                                                                                
                                            <!-- <div class="col-lg-3" >
                                                <label for="" id="stqty_lbls">Finished Item</label>
                                                <div class="input-group" >
                                                <select class="form-control select2" id="Finishitem_dropdown">
                                                    <option value="" disabled="" selected="">Item description</option>
                                                    ';foreach ($items as $item): ;echo '                                                        <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';
;echo '" data-stqty="';
;echo '" data-stweight="';
;echo '" >';echo $item['item_des'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
                                                <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-2">                                            
                                                <label>Mode</label>
                                                <input type="text" class="form-control input-sm " id="txtRemarks">                                                                                                                                                                             
                                            </div>
                                        </div>
                                        <!-- <div class="row"></div> -->
                                        <div class="row"></div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="nav nav-pills">
                                                  <li class="active"><a href="#Product" data-toggle="tab" class="custHeadProduct">Product</a></li>
                                                  <li><a href="#Material" data-toggle="tab" class="custHeadScrap">Material</a></li>
                                                  <li><a href="#Packing" data-toggle="tab" class="custHeadScrap">Packing</a></li>
                                                  <li ><a href="#Labour" data-toggle="tab" class="custHeadSale">Phase Wise Labour Rate</a></li>
                                                </ul>  
                                              </div>
                                        </div>
                                        <div class="tab-content">
                                        <!-- Start Product  -->
                                            <div class="tab-pane active fade in" id="Product">
                                             <div class="container-wrap">
                                                        <div class="row">

                                                            <div class="col-lg-3" >
                                                                <label for="">Item Description</label>
                                                                <div class="input-group">
                                                                    
                                                                    <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span>
                                                                    <select class="form-control select2" id="itemid_dropdownMaterial">
                                                                        <option value="" disabled="" selected="">Item Description</option>
                                                                        ';foreach ($items as $item): ;echo '                                                                            <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';
;echo ' " data-stqty="';
;echo '" data-stweight="';
;echo '" >';echo $item['item_des'];;echo '</option>
                                                                        ';endforeach ;echo '                                                                    </select>
                                                                </div>
                                                            </div>
                                                         
                                                            <div class="col-lg-1">
                                                                <label for="">Uom</label>                                                    
                                                                <input type="text" class="form-control readonly num" id="txtUomMaterial" readonly="" tabindex="-1">                                                    
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <label for="">Qty</label>                                                    
                                                                <input type="text" class="form-control num" id="txtQtyMaterial">                                                    
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
                                                                            <th>Item Detail</th>
                                                                            <th>UOM</th>
                                                                            <th class="numeric">Qty</th>
                                                                            <th class="numeric">Rate</th>
                                                                            <th class="numeric">Amount</th>
                                                                            <th>Action</th>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                

                                                                </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                           <!--          <div class="row">

                                                        <div class="col-lg-3" >
                                                            <label for="">Articale</label>
                                                            <div class="input-group">
                                                                
                                                                <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span>
                                                                <select class="form-control select2" id="itemid_dropdownMaterial">
                                                                    <option value="" disabled="" selected="">Articale</option>
                                                                    ';foreach ($items as $item): ;echo '                                                                        <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';
;echo ' " data-stqty="';
;echo '" data-stweight="';
;echo '" >';echo $item['item_des'];;echo '</option>
                                                                    ';endforeach ;echo '                                                                </select>
                                                            </div>
                                                        </div>
                                                     
                                                        <div class="col-lg-3">
                                                            <label for="">Specification</label>                                                    
                                                            <input type="text" class="form-control num" id="txtProductSpecificaton"  >                                                    
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-1">
                                                            <label for="">Size</label>                                                    
                                                            <input type="text" class="form-control num" id="txtProductSize">                                                    
                                                        </div>
                                                        
                                                    
                                                        <div class="col-lg-2">
                                                            <label for="">Linear Weight</label>                                                    
                                                            <input type="text" class="form-control num" id="txtProductLinearWieght">                                                    
                                                        </div>
                                                      
                                                       
                                                        <div class="col-lg-1">
                                                            <label for="">DotWeight</label>                                                    
                                                            <input type="text" class="form-control num" id="txtProductDotWeight"  tabindex="-1">                                                    
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Total Dozen</label>                                                    
                                                            <input type="text" class="form-control num" id="txtTotalDozen">                                                    
                                                        </div>
                                                        
                                                        
                                                        <div class="col-lg-2">
                                                            <label for="">Total Weight</label>                                                    
                                                            <input type="text" class="form-control num" id="txtProductTotalWieght"  tabindex="-1">                                                    
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label for="">Qty</label>                                                    
                                                            <input type="text" class="form-control num" id="txtProductQty"  tabindex="-1">                                                    
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label for="">Rate</label>                                                    
                                                            <input type="text" class="form-control num" id="txtProductRate"  tabindex="-1">                                                    
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label for="">Amount</label>                                                    
                                                            <input type="text" class="form-control readonly num" id="txtProductAmount" readonly="true" tabindex="-1">                                                    
                                                        </div>


                                                        <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                            <a href="" class="btn btn-primary" id="btnAddProduct">+</a>
                                                        </div>                                                
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            
                                                            <div id="no-more-tables">
                                                            <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Material_table">
                                                                <thead class="cf">
                                                                        <th>Sr#</th>
                                                                        <th>Articale</th>
                                                                        <th>Specification</th>
                                                                        <th class="numeric">Size</th>
                                                                        <th class="numeric">Linear Weight</th>
                                                                        <th class="numeric">Dot Weight</th>
                                                                        <th class="numeric">Total Dozen</th>
                                                                        <th class="numeric">Total Weight</th>
                                                                        <th class="numeric">Quantity</th>
                                                                        <th class="numeric">Rate</th>
                                                                        <th class="numeric">Amount</th>
                                                                        <th>Action</th>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            

                                                            </table>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                            </div>
                                            </div>
                                        <!-- ENd Product -->
                                        <!-- Start Material -->
                                            <div class="tab-pane fade " id="Material">
                                             <div class="container-wrap">
                                                <div class="row">

                                                    <div class="col-lg-3" >
                                                        <label for="">Item Description</label>
                                                        <div class="input-group">
                                                            
                                                            <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span>
                                                            <select class="form-control select2" id="itemid_dropdownMaterial">
                                                                <option value="" disabled="" selected="">Item Description</option>
                                                                ';foreach ($items as $item): ;echo '                                                                    <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';
;echo ' " data-stqty="';
;echo '" data-stweight="';
;echo '" >';echo $item['item_des'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                        </div>
                                                    </div>
                                                 
                                                    <div class="col-lg-1">
                                                        <label for="">Uom</label>                                                    
                                                        <input type="text" class="form-control readonly num" id="txtUomMaterial" readonly="" tabindex="-1">                                                    
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label for="">Qty</label>                                                    
                                                        <input type="text" class="form-control num" id="txtQtyMaterial">                                                    
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
                                                                    <th>Item Detail</th>
                                                                    <th>UOM</th>
                                                                    <th class="numeric">Qty</th>
                                                                    <th class="numeric">Rate</th>
                                                                    <th class="numeric">Amount</th>
                                                                    <th>Action</th>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        

                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Start yarn -->

                                                 <!--   <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><i class="ion-android-settings"></i> Yarn</h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                        <div class="col-lg-2">
                                                                            <label for="">Yarn Bag</label>                                                    
                                                                            <input type="text" class="form-control num" id="txtYarnBag"  tabindex="-1">                                                    
                                                                        </div>
                                                                       <div class="col-lg-2">
                                                                           <label for="">Yarn Color</label>                                                    
                                                                           <input type="text" class="form-control num" id="txtYarnColor"  tabindex="-1">                                                    
                                                                       </div>
                                                                       <div class="col-lg-2">
                                                                           <label for="">Yarn Count</label>                                                    
                                                                           <input type="text" class="form-control num" id="txtYarnCount">                                                    
                                                                       </div>
                                                                       
                                                                   
                                                                       <div class="col-lg-2">
                                                                           <label for="">Yarn Ratio</label>                                                    
                                                                           <input type="text" class="form-control num" id="txtYarnRatio">                                                    
                                                                       </div>
                                                                     
                                                                       <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                                           <a href="" class="btn btn-primary" id="btnAddPacking">+</a>
                                                                       </div>  
                                                                </div>
                                                            </div> 
                                                        </div>                                             
                                                   </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            
                                                            <div id="no-more-tables">
                                                            <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Packing_table">
                                                                <thead class="cf">
                                                                    <tr>
                                                                        <th>Sr#</th>
                                                                        <th>Yarn Bag</th>
                                                                        <th>Yarn Color</th>
                                                                        <th class="numeric">Yarn Count</th>
                                                                        <th class="numeric">Yarn Ratio</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                <!-- End Yarn -->
                                                <!-- Start Elastic -->
                                                   <!-- <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><i class="ion-android-settings"></i> Elastic</h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                        <div class="col-lg-2">
                                                                            <label for="">Elastic Bag</label>                                                    
                                                                            <input type="text" class="form-control num" id="txtElasticBag"  tabindex="-1">                                                    
                                                                        </div>
                                                                       <div class="col-lg-2">
                                                                           <label for="">Elastic Color</label>                                                    
                                                                           <input type="text" class="form-control num" id="txtElasticColor"  tabindex="-1">                                                    
                                                                       </div>
                                                                       <div class="col-lg-2">
                                                                           <label for="">Elastic Count</label>                                                    
                                                                           <input type="text" class="form-control num" id="txtElasticCount">                                                    
                                                                       </div>
                                                                       
                                                                   
                                                                       <div class="col-lg-2">
                                                                           <label for="">Elastic Ratio</label>                                                    
                                                                           <input type="text" class="form-control num" id="txtElasticRatio">                                                    
                                                                       </div>
                                                                     
                                                                       <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                                           <a href="" class="btn btn-primary" id="btnAddPacking">+</a>
                                                                       </div>  
                                                                </div>
                                                            </div> 
                                                        </div>                                             
                                                   </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            
                                                            <div id="no-more-tables">
                                                            <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Packing_table">
                                                                <thead class="cf">
                                                                    <tr>
                                                                        <th>Sr#</th>
                                                                        <th>Elastic Bag</th>
                                                                        <th>Elastic Color</th>
                                                                        <th class="numeric">Elastic Count</th>
                                                                        <th class="numeric">Elastic Ratio</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>

                                                            </table>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                <!-- End Elastic -->
                                                <!-- Start Polyster -->
                                                   <!-- <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><i class="ion-android-settings"></i> Polyster</h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                        <div class="col-lg-2">
                                                                            <label for="">Polyster Bag</label>                                                    
                                                                            <input type="text" class="form-control num" id="txtUomPacking" tabindex="-1">                                                    
                                                                        </div>
                                                                       <div class="col-lg-2">
                                                                           <label for="">Polyster Color</label>                                                    
                                                                           <input type="text" class="form-control num" id="txtUomPacking" tabindex="-1">                                                    
                                                                       </div>
                                                                       <div class="col-lg-2">
                                                                           <label for="">Polyster Count</label>                                                    
                                                                           <input type="text" class="form-control num" id="txtQtyPacking">                                                    
                                                                       </div>
                                                                       
                                                                   
                                                                       <div class="col-lg-2">
                                                                           <label for="">Polyster Ratio</label>                                                    
                                                                           <input type="text" class="form-control num" id="txtPRatePacking">                                                    
                                                                       </div>
                                                                     
                                                                       <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                                           <a href="" class="btn btn-primary" id="btnAddPacking">+</a>
                                                                       </div>  
                                                                </div>
                                                            </div> 
                                                        </div>                                             
                                                   </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            
                                                            <div id="no-more-tables">
                                                            <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="Packing_table">
                                                                <thead class="cf">
                                                                    <tr>
                                                                        <th>Sr#</th>
                                                                        <th>Item Detail</th>
                                                                        <th>UOM</th>
                                                                        <th class="numeric">Qty</th>
                                                                        <th class="numeric">Rate</th>
                                                                        <th class="numeric">Amount</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>

                                                            </table>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                <!-- End Polyster -->
                                            </div>
                                            </div>
                                        <!-- End Material -->
                                        <!-- Start Packing -->
                                            <div class="tab-pane fade " id="Packing">
                                             <div class="container-wrap">
                                                    <div class="row">

                                                        <div class="col-lg-3" >
                                                            <label for="">Item Description</label>
                                                            <div class="input-group">
                                                                
                                                                <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span>
                                                                <select class="form-control select2" id="itemid_dropdownMaterial">
                                                                    <option value="" disabled="" selected="">Item Description</option>
                                                                    ';foreach ($items as $item): ;echo '                                                                        <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';
;echo ' " data-stqty="';
;echo '" data-stweight="';
;echo '" >';echo $item['item_des'];;echo '</option>
                                                                    ';endforeach ;echo '                                                                </select>
                                                            </div>
                                                        </div>
                                                     
                                                        <div class="col-lg-1">
                                                            <label for="">Uom</label>                                                    
                                                            <input type="text" class="form-control readonly num" id="txtUomMaterial" readonly="" tabindex="-1">                                                    
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label for="">Qty</label>                                                    
                                                            <input type="text" class="form-control num" id="txtQtyMaterial">                                                    
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
                                                                        <th>Item Detail</th>
                                                                        <th>UOM</th>
                                                                        <th class="numeric">Qty</th>
                                                                        <th class="numeric">Rate</th>
                                                                        <th class="numeric">Amount</th>
                                                                        <th>Action</th>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            

                                                            </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  <!--  <div class="row">

                                                    
                                                        <div class="col-lg-2">
                                                            <label for="">Poly Bag</label>                                                    
                                                            <input type="text" class="form-control num" id="txtUomPacking" tabindex="-1">                                                    
                                                        </div>
                                                       <div class="col-lg-2">
                                                           <label for="">Uom</label>                                                    
                                                           <input type="text" class="form-control num" id="txtUomPacking" tabindex="-1">                                                    
                                                       </div>
                                                       <div class="col-lg-2">
                                                           <label for="">Label</label>                                                    
                                                           <input type="text" class="form-control num" id="txtQtyPacking">                                                    
                                                       </div>
                                                       
                                                   
                                                       <div class="col-lg-2">
                                                           <label for="">Paper Slip</label>                                                    
                                                           <input type="text" class="form-control num" id="txtPRatePacking">                                                    
                                                       </div>
                                                     
                                                      
                                                       <div class="col-lg-2">
                                                           <label for="">Carton Quantity</label>                                                    
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
                                                                    <tr>
                                                                        <th>Sr#</th>
                                                                        <th>Poly Bag</th>
                                                                        <th>UOM</th>
                                                                        <th class="">Label</th>
                                                                        <th class="">Paper Slip</th>
                                                                        <th class="">Carton Quantity</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                             

                                                            </table>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                            </div>
                                            </div>
                                        <!-- End Pacing -->

                                        <!-- Start Labour Rate -->
                                            <div class="tab-pane fade " id="Labour">
                                             <div class="container-wrap">
                                                    <div class="row">

                                                        <!-- <div class="col-lg-2" >
                                                            <label for="">Item Id</label>
                                                            <div class="input-group">
                                                                
                                                                <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span>
                                                                <select class="form-control select2" id="itemid_dropdown">
                                                                    <option value="" disabled="" selected="">Item Id</option>
                                                                    ';foreach ($items as $item): ;echo '                                                                        <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo ' " data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_id'];;echo '</option>
                                                                    ';endforeach ;echo '                                                                </select>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-lg-3" >
                                                            <label for="" id="stqty_lbll">Sub Phase</label>
                                                            <div class="input-group" >
                                                            <select class="form-control select2" id="subPhase_dropdown">
                                                                <option value="" disabled="" selected="">Select Sub Phase</option>
                                                                ';foreach ($subPhases as $subPhases): ;echo '                                                                    <option value="';echo $subPhases['id'];;echo '">';echo $subPhases['name'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                            <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                            data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label for="">Uom</label>                                                    
                                                            <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label for="">Rate</label>                                                    
                                                            <input type="text" class="form-control num" id="txtPRate">                                                    
                                                        </div>
                                                        <div class="col-lg-2">
                                                                <label>Calculation Method</label>
                                                                <input type="text" list=\'Caltype\' class="form-control input-sm" id="txtCalculationMethod">
                                                                <datalist id=\'Caltype\'>
                                                                    ';foreach ($calulationMethods as $calulationMethods): ;echo '                                                                        <option value="';echo $calulationMethods['calculationmethod'];;echo '">
                                                                    ';endforeach ;echo '                                                                </datalist>
                                                        </div>
                                                         <div class="col-lg-1">
                                                            <label for="">Rate 2</label>                                                    
                                                            <input type="text" class="form-control readonly num" id="txtRate2"  tabindex="-1">                                                    
                                                        </div>
                                                        <!-- <div class="col-lg-1">
                                                            <label for="">Amount</label>                                                    
                                                            <input type="text" class="form-control readonly num" id="txtAmount" readonly="true" tabindex="-1">                                                    
                                                        </div> -->
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
                                                                        <th>Sub Phase</th>
                                                                        <th>UOM</th>
                                                                        <th class="numeric">Rate</th>
                                                                        <th class="">Calculation Method</th>
                                                                        <th class="numeric">Rate 2</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                               <!--  <tfoot style=\'border-top:1px solid !important;\'>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td style=\'color:red !important; text-align:right;\'>Total:</td>                                                            
                                                                        <td style=\'color:red !important;\'></td>
                                                                        <td style=\'color:red !important;\'></td>
                                                                        <td></td>                                                                  
                                                                        <td style=\'color:red !important;\'></td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tfoot> -->

                                                            </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            </div>
                                        <!-- End Labour Rate -->
                                        </div>

                                        <!-- <div class="row"></div> -->
                                        <!-- <div class="row"></div> -->
                                        
                                        <!-- <div class="row">
                                            <div class="col-lg-12">
                                                
                                                <div id="no-more-tables">
                                                <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th>Sr#</th>
                                                            <th>Item Detail</th>
                                                            <th class="numeric">Qty</th>
                                                            <th class="numeric">Weight</th>
                                                            <th class="numeric">Rate</th>
                                                            <th class="numeric">Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                 

                                                </table>
                                                </div>
                                            </div>
                                        </div> -->
<div id="party-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 id="myModalLabel">Party Lookup</h3>
            </div>

                <div class="modal-body">
                <table class="table table-striped modal-table">
                <!-- <table class="table table-bordered table-striped modal-table"> -->
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
                ';foreach ($parties as $party): ;echo '                <tr>
                <td width="14%;">
                ';echo $party['account_id'];;echo '                <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                </td>
                <td>';echo $party['name'];;echo '</td>
                <td>';echo $party['mobile'];;echo '</td>
                <td>';echo $party['address'];;echo '</td>
                <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa fa-search"></i></a></td>
                </tr>
                ';endforeach ;echo '                </tbody>
                </table>
                </div>
                <div class="modal-footer">
                <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
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
                ';foreach ($items as $item): ;echo '                <tr>
                <td width="14%;">
                ';echo $item['item_id'];;echo '                <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                </td>
                <td>';echo $item['item_des'];;echo '</td>
                <td>';echo $item['item_code'];;echo '</td>
                <td>';echo $item['uom'];;echo '</td>
                <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa fa-search"></i></a></td>
                </tr>
                ';endforeach ;echo '                </tbody>
                </table>
                </div>
                <div class="modal-footer">
                <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
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
                                   <!--  <div class="row">                                    
                                                                              
                                        <div class="col-lg-3">                                                    
                                            <label>Finished Qty</label>
                                            <input type="text" class="form-control readonly num" id="txtFinishedQty" readonly="true" tabindex="-1">
                                        </div>                                                
                                        <div class="col-lg-3">                                                    
                                            <label>Total Cost</label>
                                            <input type="text" class="form-control readonly num" id="txtTotalCost" readonly="true" tabindex="-1">
                                        </div>
                                                                          
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>Prepared By</label>
                                            
                                           <input type="text" list=\'prepareBy\' class="form-control input-sm" id="txtPreparedBy">
                                           <datalist id=\'prepareBy\'>
                                               ';foreach ($PreparedBys as $PreparedBy): ;echo '                                                   <option value="';echo $PreparedBy['prepareBy'];;echo '">
                                               ';endforeach ;echo '                                           </datalist>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>Approved By</label>
                                               <input type="text" list=\'ApprovedBy\' class="form-control input-sm" id="txtApprovedBy">
                                               <datalist id=\'ApprovedBy\'>
                                                   ';foreach ($ApprovedBys as $ApprovedBy): ;echo '                                                       <option value="';echo $ApprovedBy['approveBy'];;echo '">
                                                   ';endforeach ;echo '                                               </datalist>
                                        </div>
                                    </div> -->
                                    <!-- <div class="row">                                           
                                        <div class="col-lg-1">                                                    
                                            <label>Discount%</label>
                                            <input type="text" class=" form-control num"  id="txtDiscount">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label>DiscAmount</label>
                                            <input type="text" class=" form-control num"  id="txtDiscAmount">
                                        </div>
                                        <div class="col-lg-1">                                                    
                                            <label>Expense%</label>
                                            <input type="text" class=" form-control num"  id="txtExpense">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label>Exp Amount</label>
                                            <input type="text" class=" form-control num"  id="txtExpAmount">
                                        </div>
                                        <div class="col-lg-1">                                                    
                                            <label>Tax%</label>
                                            <input type="text" class=" form-control num"  id="txtTax">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label>TaxAmount</label>
                                            <input type="text" class=" form-control num"  id="txtTaxAmount">
                                        </div>

                                        <div class="col-lg-3">                                                    
                                            <label>Net Amount</label>
                                            <input type="text" class="form-control readonly " id=\'txtNetAmount\' readonly="" tabindex="-1">
                                        </div>
                                        
                                    </div> -->
                                        <div class="row">                                                                                    
                                            <div class="col-lg-10">
                                                <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                <a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['purchasevoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['purchasevoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['purchasevoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['purchasevoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                                <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                                
                                                <div class="btn-group">
                                                      <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                      <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                      </button>
                                                      <ul class="dropdown-menu" role="menu">
                                                        <li ><a href="#" class="btnprintHeader">With header</li>
                                                        <li ><a href="#" class="btnprintwithOutHeader">With out header</li>
                                                        <li ><a href="#" class="btnprint_sm">Small</li>
                                                        <li ><a href="#" class="btnprint_sm_withOutHeader">Small with out header </li>
                                                        <li ><a href="#" class="btnprint_sm_rate">Small with out rate</li>
                                                        <li ><a href="#" class="btnprint_sm_withOutHeader_rate">Small with out header and rate </li>
                                                      </ul>
                                                </div>
                                                <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
                                                <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">                                                                
                                                    <div class="input-group">
                                                      <span class="switch-addon input-group-addon">Pre Bal?</span>
                                                      <input type="checkbox" checked="" class="bs_switch" id="switchPreBal">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2" >
                                                <div class="input-group">
                                                    <span class="input-group-addon">User: </span>
                                                    <select class="form-control " disabled="" id="user_dropdown">
                                                        <option value="" disabled="" selected="">...</option>
                                                        ';foreach ($userone as $user): ;echo '                                                            <option value="';echo $user['uid'];;echo '">';echo $user['uname'];;echo '</option>
                                                        ';endforeach;;echo '                                                    </select>
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
</div>';
?>