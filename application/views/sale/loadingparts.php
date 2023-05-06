

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

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Outward Voucher</h1>
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
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Vr#</span>
                                                    <input type="text" class="form-control input-sm " id="txtVrno" readonly=\'true\'>
                                                    <input type="hidden" id="txtMaxVrnoHidden">
                                                    <input type="hidden" id="txtVrnoHidden">
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
                                            
                                            <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Party Name</label>
                                                <div class="input-group" >
                                                    <select class="form-control  select2" id="party_dropdown" >
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
                                                <select class="form-control select2" id="dept_dropdown">
                                                    <option value="" selected="" disabled="">Choose Warehouse</option>
                                                    ';foreach ($departments as $department): ;echo '                                                        <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>                            
                                            </div>
                                            <div class="col-lg-2">                                                
                                                <label>Delivered By</label>
                                                <input class=\'form-control input-sm \' type=\'text\' list="receivers" id=\'receivers_list\'>
                                                <datalist id=\'receivers\'>
                                                    ';foreach ($receivers as $receiver): ;echo '                                                        <option value="';echo $receiver['received_by'];;echo '">
                                                    ';endforeach ;echo '                                                </datalist>                                                
                                            </div>                                    
                                                                                 
                                            <div class="col-lg-3">                                                
                                                <label>Through</label>
                                                <select class="form-control input-sm select2" id="transporter_dropdown">
                                                    <option value="" disabled="" selected="">Choose transporter</option>
                                                    ';foreach ($transporters as $transporter): ;echo '                                                        <option value="';echo $transporter['transporter_id'];;echo '">';echo $transporter['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>                                               
                                            </div>
                                        </div>                                        

                                        <div class="row" style="margin-top:0px;">
                                            <div class="col-lg-2">                                                
                                                <label>Inv#</label>
                                                <input type="text" class="form-control input-sm  num" id="txtInvNo">                                                
                                            </div>
                                            <div class="col-lg-2">                                                
                                                <label>Due Date</label>
                                                <input class="form-control input-sm" type="date" id="due_date" value="';echo date('Y-m-d');;echo '">                                                
                                            </div>                                           
                                            <div class="col-lg-3">                                                
                                                <label>WO#</label>
                                                <div class="input-group" >
                                                    <input type="text" class="form-control input-sm " id="txtOrderNo">     
                                                    <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#order-lookup"  data-toggle="modal" href="#order-lookup" rel="tooltip"
                                                    data-placement="top" data-original-title="Search Order" data-toggle="tooltip" data-placement="bottom" title="Search Order Status"><i class="fa fa-search"></i></a>

                                                    <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#orderloading-lookup"  data-toggle="modal" href="#orderloading-lookup" rel="tooltip"
                                                    data-placement="top" data-original-title="Search Order" data-toggle="tooltip" data-placement="bottom" title="Search Order Parts Loading"><i class="fa fa-th"></i></i></a>
                                                </div>
                                            </div>                                                                                
                                            <div class="col-lg-5">                                            

                                                <label>Remarks</label>
                                                <input type="text" class="form-control input-sm " id="txtRemarks">                                                                                                                                                                             
       
       <div class="row">                                     </div>
                                        </div>
                                        
                                    <div class="row">
                                            <div class="col-lg-12">                        
                                                <div class="tab-content">
                                                    <div class="tab-pane active fade in" id="itemadd">
                                                        <div class="container-wrap">
                                                            <div class="row">
                                                                <div class="col-lg-1" >
                                                                    <label for="">Item Id</label>
                                                                    <div class="input-group">
                                                                        
                                                                        <!-- <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span> -->
                                                                        <select class="form-control select2" id="itemid_dropdown">
                                                                            <option value="" disabled="" selected="">Item Id</option>
                                                                            ';foreach ($items as $item): ;echo '                                                                                <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_id'];;echo '</option>
                                                                            ';endforeach ;echo '                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4" >
                                                                    <label for="" id="stqty_lbl" >Item Description</label>
                                                                    <div class="input-group" >
                                                                    <select class="form-control select2" id="item_dropdown">
                                                                        <option value="" disabled="" selected="">Item description</option>
                                                                        ';foreach ($items as $item): ;echo '                                                                            <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '">';echo $item['item_des'];;echo '</option>
                                                                        ';endforeach ;echo '                                                                    </select>
                                                                    <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                                    data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <label for="">Qty</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtQty">                                                    
                                                                </div>
                                                                 <div class="col-lg-1">
                                                                    <label for="">GW</label>                                                    
                                                                    <input type="text" class="form-control readonly num" id="txtGWeight" readonly="" tabindex="-1">                                                    
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <label for="">Uom</label>                                                    
                                                                    <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <label for="">Weight</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtWeight">                                                    
                                                                </div>
                                                                <div class="col-lg-1 hidden">
                                                                    <label for="">Rate</label>                                                    
                                                                    <input type="text" class="form-control num" id="txtPRate">                                                    
                                                                </div>
                                                                <div class="col-lg-1 hidden">
                                                                    <label for="">Amount</label>                                                    
                                                                    <input type="text" class="form-control readonly num" id="txtAmount" readonly="true" tabindex="-1">                                                    
                                                                </div>
                                                                <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                                    <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                                                </div>                                                
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="no-more-tables">
                                                <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="numeric">Sr#</th>
                                                            <th >Item Detail</th>
                                                            <th class="numeric">Qty</th>
                                                            <th class="numeric">Weight</th>
                                                            <th class="numeric hidden">Rate</th>
                                                            <th class="numeric hidden">Amount</th>
                                                            <!-- <th >Type</th> -->
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
                                            </div>
                                        </div>
                                    </div>
                                        <!-- <div class="row"></div> -->
                                        <!-- <div class="row"></div> -->

                                        
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
                <th>Type</th>
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
                <td>';echo $party['level3_name'];;echo '</td>
                <td>';echo $party['mobile'];;echo '</td>
                <td>';echo $party['address'];;echo '</td>
                <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class=" ion-compose"></i></a></td>
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
<div id="orderloading-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 id="myModalLabel">Pending Order Parts Lookup</h3>
            </div>
            <div class="row">
                
                <div class="col-lg-3">                                                
                    <div class="input-group">
                        <span class="input-group-addon id-addon">Order#</span>
                        <select class="form-control select2" id="OrderRunning_dropdown">
                            <option value="" selected="" disabled="">select</option>
                            ';foreach ($orders_running as $order): ;echo '                                <option value="';echo $order['vrnoa'];;echo '">';echo $order['vrnoa'];;echo '</option>
                            ';endforeach ;echo '                        </select>                            
                    </div>
                </div>
                <div class="col-lg-6">
                    <a class="btn btn-sm btn-default btnShowLoading" ><i class="fa fa-search"></i> Show</a>
                    <a class="btn btn-sm btn-default btnAddLoading"><i class="fa fa-download"></i> Add</a>
                    <a class="btn btn-sm btn-default btnResetLoading"><i class="fa fa-refresh"></i>Reset</a>
                </div>
                

            </div>
                <div class="modal-body">
                    <div id="no-more-tables">
                    <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="loading_table">
                        <!-- <table class="table table-bordered table-striped modal-table"> -->
                        <thead class="cf">
                            <tr >
                            <!-- <th class="numeric">Sr#</th> -->
                            <th><input type="checkbox" id="selectall">Sr#</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Weight</th>
                            <th>Type</th>
                            <th>St Qty</th>
                            <th>St Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="modal-footer">
                <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="order-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 id="myModalLabel">Order Lookup</h3>
            </div>
            <div class="col-lg-3">                                                
                <div class="input-group">
                    <span class="input-group-addon id-addon">Order#</span>
                    <select class="form-control select2" id="OrderRunning_dropdown">
                        <option value="" selected="" disabled="">Choose Order#</option>
                        ';foreach ($orders_running as $order): ;echo '                            <option value="';echo $order['vrnoa'];;echo '">';echo $order['vrnoa'];;echo '</option>
                        ';endforeach ;echo '                    </select>                            
                </div>
            </div>
                <div class="modal-body">
                    <div id="no-more-tables">
                    <table class="col-lg-12 table-bordered table-striped table-condensed cf">
                        <!-- <table class="table table-bordered table-striped modal-table"> -->
                        <thead class="cf">
                            <tr >
                            <th class="numeric">Order#</th>
                            <th>Date</th>
                            <th>Party</th>
                            <th>City</th>
                            <th>Area</th>
                            <th>Remarks</th>
                            <th>Chooose</th>
                            </tr>
                        </thead>
                        <tbody>
                            ';foreach ($orders_running as $runningorder): ;echo '                                <tr>
                                    <td width="14%;" data-title=\'Order\'>
                                    ';echo $runningorder['vrnoa'];;echo '                                    <input type="hidden" name="orderid" value="';echo $runningorder['vrnoa'];;echo '">
                                    </td>
                                    <td data-title=\'Date\'>';echo $runningorder['vrdate'];;echo '</td>
                                    <td data-title=\'Party\'>';echo $runningorder['name'];;echo '</td>
                                    <td data-title=\'City\'>';echo $runningorder['city'];;echo '</td>
                                    <td data-title=\'Area\'>';echo $runningorder['cityarea'];;echo '</td>
                                    <td data-title=\'Remarks\'>';echo $runningorder['remarks'];;echo '</td>
                                    <td><a href="#" data-dismiss="modal" class="btn btn-primary populateOrder"><i class=" ion-search"></i></a></td>
                                </tr>
                            ';endforeach ;echo '                        </tbody>
                    </table>
                    </div>
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
                <th>Article#</th>
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
                <td>';echo $item['artcile_no'];;echo '</td>
                <td>';echo $item['item_des'];;echo '</td>
                <td>';echo $item['item_code'];;echo '</td>
                <td>';echo $item['uom'];;echo '</td>
                <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class=" ion-compose"></i></a></td>
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
                                    <div class="row">                                    
                                        <div class="col-lg-3">                                                    
                                            <label>Total Weight</label>
                                            <input type="text" class="form-control readonly num" id="txtTotalWeight" readonly="true" tabindex="-1">
                                        </div>                                                
                                        <div class="col-lg-3">                                                    
                                            <label>Total Qty</label>
                                            <input type="text" class="form-control readonly num" id="txtTotalQty" readonly="true" tabindex="-1">
                                        </div>                                                
                                        <div class="col-lg-3">                                                    
                                            <label class="hidden">Total Amount</label>
                                            <input type="text" class="form-control readonly num hidden" id="txtTotalAmount" readonly="true" tabindex="-1">
                                        </div>
                                        <div class="col-lg-3">                                                    
                                            <label class="hidden">Less Amount</label>
                                            <input type="text" class="form-control num hidden" id="txtPaid">
                                        </div>                                                
                                    </div>
                                    <div class="row">                                           
                                        <div class="col-lg-1">                                                    
                                            <label class="hidden">Discount%</label>
                                            <input type="text" class=" form-control num hidden"  id="txtDiscount">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label class="hidden">DiscAmount</label>
                                            <input type="text" class=" form-control num hidden"  id="txtDiscAmount">
                                        </div>
                                        <div class="col-lg-1">                                                    
                                            <label class="hidden">Expense%</label>
                                            <input type="text" class=" form-control num hidden"  id="txtExpense">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label class="hidden">Exp Amount</label>
                                            <input type="text" class=" form-control num hidden"  id="txtExpAmount">
                                        </div>
                                        <div class="col-lg-1">                                                    
                                            <label class="hidden">Tax%</label>
                                            <input type="text" class=" form-control num hidden"  id="txtTax">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label class="hidden">TaxAmount</label>
                                            <input type="text" class=" form-control num hidden"  id="txtTaxAmount">
                                        </div>

                                        <div class="col-lg-3">                                                    
                                            <label class="hidden">Net Amount</label>
                                            <input type="text" class="form-control readonly hidden" id=\'txtNetAmount\' readonly="" tabindex="-1">
                                            <!-- input type="text" class="form-control readonly num" id="txtUom" >                                                     -->
                                        </div>
                                        
                                    </div>
                                        <div class="row">                                                                                    
                                            <div class="col-lg-10">
                                                

                                                <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                <a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['orderpartsvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['orderpartsvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['orderpartsvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['orderpartsvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
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
                                            <div class="col-lg-2 hidden">
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