

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
                                            <div class="col-lg-6">
                                                <label>Sale Price 1</label>
                                                <input class="form-control input-sm num" type="text" id="txtSalePrice" tabindex="6">
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Pur Price</label>
                                                <input class="form-control input-sm num" type="text" id="txtPurPrice" tabindex="7">
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
                    ';foreach ($items as $item): ;echo '                    <tr>
                    <td width="14%;">
                    ';echo $item['item_id'];;echo '                    <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                    </td>
                    <td>';echo $item['item_des'];;echo '</td>
                    <td>';echo $item['item_code'];;echo '</td>
                    <td>';echo $item['uom'];;echo '</td>
                    <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa-li fa fa-check-square"></i></a></td>
                    </tr>
                    ';endforeach ;echo '                    </tbody>
                    </table>
                    </div>
                    <div class="modal-footer">
                    <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
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
                    ';foreach ($parties as $party): ;echo '                    <tr>
                    <td width="14%;">
                    ';echo $party['pid'];;echo '                    <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                    </td>
                    <td>';echo $party['name'];;echo '</td>
                    <td>';echo $party['mobile'];;echo '</td>
                    <td>';echo $party['address'];;echo '</td>
                    <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa-li fa fa-check-square"></i></a></td>
                    </tr>
                    ';endforeach ;echo '                    </tbody>
                    </table>
                    </div>
                    <div class="modal-footer">
                    <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Work Order Voucher</h1>
            </div>
        </div>
    </div>
    <div class="page_content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-10">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <form action="">

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon id-addon">Sr#</span>
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
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Work Order #</span>
                                                    <input type="text" class="form-control input-sm " id="txtworkOrderNo">    
                                                </div>
                                                <!-- <label>Work Order #</label> -->
                                               <!--  <div class="input-group">
                                                    <span class="input-group-addon">Vr#</span>
                                                    <input type="text" class="form-control input-sm " id="txtVrno" readonly=\'true\'>
                                                    <input type="hidden" id="txtMaxVrnoHidden">
                                                    <input type="hidden" id="txtVrnoHidden">
                                                </div> -->
                                            </div>  
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Invoice #</span>
                                                        <input type="text" class="form-control input-sm  num" id="txtInvNo">                                                
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Date</span>
                                                    <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
                                                </div>
                                            </div>
                                        </div>

                                <div class="row">
                                  <!--   
                                    <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Party Name</label>
                                        <div class="input-group" >
                                            <select class="form-control  select2" id="party_dropdown" >
                                                <option value="" disabled="" selected="">Choose party</option>
                                                ';foreach ($parties as $party): ;echo '                                                    <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                ';endforeach ;echo '                                            </select>
                                            <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                        data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                        </div>
                                      </div>
             
                                        
                                    </div> -->
                                            
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Party Name</label>
                                                    <div class="input-group" >
                                                        <select class="form-control  select2" id="party_dropdown" >
                                                            <option value="" disabled="" selected="">Choose party</option>
                                                            ';foreach ($parties as $party): ;echo '                                                                <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                        <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                                    data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                    </div>
                                                  </div>
                                            
                                                
                                            </div>
                                            <div class="col-lg-5">                                            
                                                <label>Address</label>
                                                <input type="text" class="form-control input-sm " id="txtAddress">                                                                                                                                                                             
                                            </div>
                                            <!-- <div class="col-lg-3">                                                
                                                <label>Warehouse</label>
                                                <select class="form-control select2" id="dept_dropdown">
                                                    <option value="" selected="" disabled="">Choose Warehouse</option>
                                                    ';foreach ($departments as $department): ;echo '                                                        <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>                            
                                            </div> -->
                                           <!--  <div class="col-lg-4">                                                
                                                <label>Received By</label>
                                                <input class=\'form-control input-sm \' type=\'text\' list="receivers" id=\'receivers_list\'>
                                                <datalist id=\'receivers\'>
                                                    ';foreach ($receivers as $receiver): ;echo '                                                        <option value="';echo $receiver['received_by'];;echo '">
                                                    ';endforeach ;echo '                                                </datalist>                                                
                                            </div>  -->                                   
                                                                                 
                                          <!--   <div class="col-lg-3">                                                
                                                <label>Through</label>
                                                <select class="form-control input-sm  select2" id="transporter_dropdown">
                                                    <option value="" disabled="" selected="">Choose transporter</option>
                                                    ';foreach ($transporters as $transporter): ;echo '                                                        <option value="';echo $transporter['transporter_id'];;echo '">';echo $transporter['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>                                               
                                            </div> -->
                                        </div>                                        

                                        <div class="row" style="margin-top:0px;">
                                            <!-- <div class="col-lg-2">                                                
                                                <label>Inv#</label>
                                                <input type="text" class="form-control input-sm  num" id="txtInvNo">                                                
                                            </div> -->
                                         <!--    <div class="col-lg-2">                                                
                                                <label>Due Date</label>
                                                <input class="form-control input-sm" type="date" id="due_date" value="';echo date('Y-m-d');;echo '">                                                
                                            </div>    -->                                        
                                                                                                                         
                                            <div class="col-lg-9">                                            
                                                <label>Description</label>
                                                <input type="text" class="form-control input-sm " id="txtDescription">                                                                                                                                                                             
                                            </div>
                                        </div>
                                        <!-- <div class="row"></div> -->

                                        <div class="container-wrap">
                                            <div class="row">
                                               <!--  <div class="col-lg-1" >
                                                    <label for="">Item Id</label>
                                                    <div class="input-group">
                                                        
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span>
                                                        <select class="form-control select2" id="itemid_dropdown">
                                                            <option value="" disabled="" selected="">Item Id</option>
                                                            ';foreach ($items as $item): ;echo '                                                                <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '">';echo $item['item_id'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="col-lg-3" >
                                                    <label for="">Item Description</label>
                                                    <div class="input-group" >
                                        <select class="form-control select2" id="item_dropdown">
                                            <option value="" disabled="" selected="">Item description</option>
                                            ';foreach ($items as $item): ;echo '                                                <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '">';echo $item['item_des'];;echo '</option>
                                            ';endforeach ;echo '                                        </select>
                                                    <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                    data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1" >
                                                    <label for=""> Color</label>
                                                    <div class="input-group">
                                                        
                                                        <!-- <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span> -->
                                                        <select class="form-control select2" id="color_dropdown">
                                                            <option value="" disabled="" selected="">Color</option>
                                                            ';foreach ($colors as $color): ;echo '                                                                <option value="';echo $color['id'];;echo '"  >';echo $color['name'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Uom</label>                                                    
                                                    <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Qty</label>                                                    
                                                    <input type="text" class="form-control num" id="txtQty">                                                    
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Rate</label>                                                    
                                                    <input type="text" class="form-control num" id="txtPRate">                                                    
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="">Amount</label>                                                    
                                                    <input type="text" class="form-control readonly num" id="txtAmount" readonly="true" tabindex="-1">                                                    
                                                </div>
                                                <!-- <div class="col-lg-1">
                                                    <label for="">Weight</label>                                                    
                                                    <input type="text" class="form-control num" id="txtWeight">                                                    
                                                </div> -->

                                              <!--    <div class="col-lg-1">
                                                    <label for="">GW</label>                                                    
                                                    <input type="text" class="form-control readonly num" id="txtGWeight" readonly="" tabindex="-1">                                                    
                                                </div> -->
                                               <!--  <div class="col-lg-1">
                                                    <label for="">Last Rate</label>                                                    
                                                    <input type="text" class="form-control num" id="txtPRate">                                                    
                                                </div> -->
                                                 <!--  <div class="col-lg-2">
                                                    <label for="">Last Vendor</label>                                                    
                                                    <input type="text" class="form-control num" id="txtVendor">                                                    
                                                </div>   -->
                                                <div class="col-lg-2">
                                                    <label for="">Stock</label>                                                    
                                                    <input type="text" class="form-control num" id="txtStock">                                                    
                                                </div>
                                                <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                    <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <!-- <div class="row"></div> -->
                                        <!-- <div class="row"></div> -->

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="no-more-tables">
                                                <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table">
                                                    <thead class="cf">
                                                        <tr>
                                                            <th class="numeric">Sr#</th>
                                                            <th >Item Detail</th>
                                                            <th >Color</th>
                                                            <!-- <th >UOM</th> -->
                                                            <th class="numeric">Qty</th>
                                                            <th class="numeric">Rate</th>
                                                            <th class="numeric">Amount</th>
                                                            <th class="numeric">Stock</th>
                                                            <th >Action</th>
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
                                       <!--  <div class="col-lg-3">                                                    
                                            <label>Total Weight</label>
                                            <input type="text" class="form-control readonly num" id="txtTotalWeight" readonly="true" tabindex="-1">
                                        </div>   -->                                              
                                        <div class="col-lg-3">                                                    
                                            <label>Total Qty</label>
                                            <input type="text" class="form-control readonly num" id="txtTotalQty" readonly="true" tabindex="-1">
                                        </div>                                                
                                        <div class="col-lg-3">                                                    
                                            <label>Total Amount</label>
                                            <input type="text" class="form-control readonly num" id="txtTotalAmount" readonly="true" tabindex="-1">
                                        </div>
                                     <!--    <div class="col-lg-3">                                                    
                                            <label>Paid</label>
                                            <input type="text" class="form-control num" id="txtPaid">
                                        </div>    -->                                             
                                    </div>
                                    <div class="row">    
                                        <div class="col-lg-3">                                                    
                                            <label>Delivery Charges%</label>
                                            <input type="text" class=" form-control num"  id="txtDelivery">
                                        </div>                                         
                                        <div class="col-lg-1">                                                    
                                            <label>Discount%</label>
                                            <input type="text" class=" form-control num"  id="txtDiscount">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label>DiscAmount</label>
                                            <input type="text" class=" form-control num"  id="txtDiscAmount">
                                        </div>
                                       <!--  <div class="col-lg-1">                                                    
                                            <label>Expense%</label>
                                            <input type="text" class=" form-control num"  id="txtExpense">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label>Exp Amount</label>
                                            <input type="text" class=" form-control num"  id="txtExpAmount">
                                        </div> -->
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
                                            <!-- input type="text" class="form-control readonly num" id="txtUom" >                                                    
                                        <!-- </div>  -->
                                        
                                    </div>
                                        <div class="row">                                                                                    
                                            <div class="col-lg-10">
                                                <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['purchaseorder']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['purchaseorder']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['purchaseorder']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['purchaseorder']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                                <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                                
                                                <div class="btn-group">
                                                      <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                      <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                      </button>
                                                      <ul class="dropdown-menu" role="menu">
                                                        <li ><a href="#" class="btnprintHeader"> Print with header</li>
                                                        <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li>
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
                <div class="col-md-2">
                    <div class="row">
                        <label>Last Rate</label>
                         <table class="table table-striped Lrates_table">
                            <thead>
                                <tr>
                                  <th>Sr #</th>
                                  <th>L Rates</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td class="TotalLrate"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        <label>Last Stock</label>
                         <table class="table table-striped Lstocks_table">
                            <thead>
                                <tr>
                                  <th>Stock</th>
                                  <th>Weight</th>
                                  <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    
                                    <td class="text-right" colspan=\'2\' >Total Stock</td>
                                    <td class="TotalLstocks"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                </div>  <!-- end of level 1-->
            </div>
        </div>
    </div>
</div>';
?>