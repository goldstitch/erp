
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="voucher-item-template" type="text/x-handlebars-template">
  <tr>
     <td>{{{VRNOA}}}</td>
     <td>{{VRDATE}}</td>
     <td>{{PARTYNAME}}</td>
     <td>{{REMARKS}}</td>
     <td class="text-right">{{ITEM_NAME}}</td>
     <td class="text-right">{{UOM}}</td>
     <td class="text-right">{{QTY}}</td>
     <td class="text-right">{{DOZEN}}</td>
     <td class="text-right ">{{BAG}}</td>
     <td class="text-right ">{{WEIGHT}}</td>
     <td class="text-right">{{RATE}}</td>
     <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
   
  </tr>
</script>


<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     
     <td class="tblInvoice"></td>
     <td></td>
     <td class=""></td>
     <td class=""></td>
     <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
     <td class="text-right txtbold"></td>
     <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_DOZEN_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_BAG_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
     <td class="text-right txtbold"></td>
     <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
  </tr>
</script>
';
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
    <div id="issueRecieve-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <th>Item Id</th>
                    <th>Name</th>
                    <th>Item Description</th>
                    <th>Uom</th>
                    <th>Workorder</th>
                    <th>Qty</th>
                    <th>Weight</th>
                    <!-- <th style=\'width:3px;\'>Actions</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    ';foreach ($partyvendors as $party): ;echo '                    <tr>
                    <td >
                    ';echo $party['item_id'];;echo '                    <input type="hidden" name="hfModalissueitem_Id" value="';echo $party['item_id'];;echo '">
                    </td>
                    <td>';echo $party['name'];;echo '</td>
                    <td>';echo $party['item_des'];;echo '</td>
                    <td>';echo $party['uom'];;echo '</td>
                    <td>';echo $party['workorder'];;echo '</td>
                    <td class="text-right">';echo $party['qty'];;echo '</td>
                    <td class="text-right">';echo $party['weight'];;echo '</td>
                    <!-- <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa fa-search"></i></a></td> -->
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
                    ';foreach ($parties as $party): ;echo '                    <tr>
                    <td >
                    ';echo $party['pid'];;echo '                    <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                    </td>
                    <td>';echo $party['name'];;echo '</td>
                    <td>';echo $party['level3_name'];;echo '</td>
                    <td>';echo $party['mobile'];;echo '</td>
                    <td>';echo $party['address'];;echo '</td>
                    <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa fa-search"></i></a></td>
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
                    <tr >
                    <th>Id</th>
                    <th>Article#</th>
                    <th>Description</th>
                    <th>Code</th>
                    <th>Uom</th>
                    <th style=\'width:3px;\'>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    ';foreach ($items as $item): ;echo '                    <tr>
                    <td >
                    ';echo $item['item_id'];;echo '                    <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                    </td>
                    <td>';echo $item['artcile_no'];;echo '</td>
                    <td>';echo $item['item_des'];;echo '</td>
                    <td>';echo $item['item_code'];;echo '</td>
                    <td>';echo $item['uom'];;echo '</td>
                    <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa fa-search"></i></a></td>
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
                <h1 class="page_title">Gloves Contract </h1>
            </div>
        </div>
    </div>
    <div class="page_content">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-12">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#Main" data-toggle="tab">Main</a></li>
                        <li><a href="#Search" data-toggle="tab">Search</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <div class="tab-content">
                        <div class="tab-pane active fade in" id="Main">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">

                                            <form action="">

                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <!-- <div class="input-group"> -->
                                                            <span class="">Sr#</span>
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

                                                             <input type="hidden" name="edit_qty" id="edit_qty" value="0">
                                                            <input type="hidden" name="edit_weight" id="edit_weight" value="0">

                                                        <!-- </div> -->
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <!-- <div class="input-group"> -->
                                                            <span class="">Vr#</span>
                                                            <input type="text" class="form-control input-sm " id="txtVrno" readonly=\'true\'>
                                                            <input type="hidden" id="txtMaxVrnoHidden">
                                                            <input type="hidden" id="txtVrnoHidden">
                                                        <!-- </div> -->
                                                    </div>                                               
                                                    <div class="col-lg-3">
                                                        <!-- <div class="input-group"> -->
                                                            <span class="">Date</span>
                                                            <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
                                                        <!-- </div> -->
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- <div class="col-lg-2">                                                
                                                        <label>Type</label>
                                                        <select class="form-control  select2" id="pType_dropdown">
                                                            <option value="" disabled="" selected="">Choose Type</option>
                                                            ';foreach ($typess as $types): ;echo '                                                                <option value="';echo $types['etype'];;echo '">';echo $types['etype'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>                                               
                                                    </div> -->
                                                   <!--  <div class="col-lg-3">
                                                    <div class="input-group">
                                                        <label>Party Name</label>
                                                        <div class="input-group" >
                                                            <select class="form-control select2" id="party_dropdown11" >
                                                                <option value="" disabled="" selected="">Choose party</option>
                                                                ';foreach ($parties as $party): ;echo '                                                                    <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                            <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                                        data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                        </div>
                                                      </div>
                             
                                                        
                                                    </div> -->
                                                     <div class="col-lg-6" >
                                                            <label>Party Name</label>
                                                            <div class="input-group" >
                                                            <select class="form-control select2" id="party_dropdown11" >
                                                                <option value="" disabled="" selected="">Choose party</option>
                                                                ';foreach ($parties as $party): ;echo '                                                                    <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                            <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" title="Add New Account Quick (F3)">+</a>
                                                         <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#issueRecieve-lookup" data-toggle="modal" href="#addCategory" rel="tooltip"
                                                        data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)"><i class="fa fa-search"></i></a>
                                                            </div>
                                                        </div>
                                                    

                                                    <div class="col-lg-3 hide">                                                
                                                        <label>Warehouse</label>
                                                        <div class="input-group" >
                                                        <select class="form-control select2" id="dept_dropdown">
                                                            <option value="" selected="" disabled="">Choose Warehouse</option>
                                                            ';foreach ($departments as $department): ;echo '                                                                <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                        <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#GodownAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                                        data-placement="top" data-original-title="Add Department" data-toggle="tooltip" data-placement="bottom" title="Add New Department Quick">+</a>
                                                        </div>                            
                                                    </div>
                                                    <div class="col-lg-2 hide">                                                
                                                        <label>Issued By</label>
                                                        <input class=\'form-control \' type=\'text\' list="receivers" id=\'receivers_list\'>
                                                        <datalist id=\'receivers\'>
                                                            ';foreach ($receivers as $receiver): ;echo '                                                                <option value="';echo $receiver['received_by'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist>                                                
                                                    </div>                                    
                                                                                         
                                                   
                                                <!-- </div>                                        

                                                <div class="row"> -->
                                                 <div class="col-lg-2 hide">                                                
                                                        <label>Through</label>
                                                        <select class="form-control select2" id="transporter_dropdown">
                                                            <option value="" disabled="" selected="">Choose transporter</option>
                                                            ';foreach ($transporters as $transporter): ;echo '                                                                <option value="';echo $transporter['transporter_id'];;echo '">';echo $transporter['name'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>                                               
                                                    </div>
                                                    <div class="col-lg-1 hide">                                                
                                                        <label>Contract#</label>
                                                        <input type="text" class="form-control input-sm" id="txtInvNo">                                                
                                                    </div>
                                                    <div class="col-lg-2 hide">                                                
                                                        <label>Due Date</label>
                                                        <input class="form-control input-sm" type="date" id="due_date" value="';echo date('Y-m-d');;echo '">                                                
                                                    </div>                                           
                                                    <div class="col-lg-1">                                                
                                                        <label>WO#</label>
                                                        <input type="text" class="form-control input-sm " id="txtOrderNo">    
                                                    </div>                                                                                
                                                    <div class="col-lg-4">                                            
                                                        <label>Remarks</label>
                                                        <input type="text" class="form-control input-sm " id="txtRemarks">                                                                                                                                                                             
                                                    </div>
                                                </div>
                                                <!-- <div class="row"></div> -->

                                                <div class="container-wrap">
                                                    <div class="row">
                                                        <div class="col-lg-2" >
                                                            <label for="">Item Id</label>
                                                            <select class="form-control select2" id="itemid_dropdown">
                                                                <option value="" disabled="" selected="">Item Id</option>
                                                                ';foreach ($items as $item): ;echo '                                                                    <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo ' " data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_id'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                        </div>
                                                        <div class="col-lg-4" >
                                                            <label for="" id="stqty_lbl">Item</label>
                                                            <div class="input-group" >
                                                            <select class="form-control select2" id="item_dropdown" style="width: 250px">
                                                                <option value="" disabled="" selected="">Item description</option>
                                                                ';foreach ($items as $item): ;echo '                                                                    <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_des'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                            <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                            data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">                                                
                                                           <label>Phase</label>
                                                            <select class="form-control select2" id="phase_dropdown">
                                                                <option value="" selected="" disabled="">Phase</option>
                                                                ';foreach ($phase as $phases): ;echo '                                                                    <option value="';echo $phases['id'];;echo '">';echo $phases['name'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>                                          
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Uom</label>                                                    
                                                            <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Dzn Qty</label>                                                    
                                                            <input type="text" class="form-control num" id="txtDozenQty">                                                    
                                                        </div>
                                                    </div>
                                                    <div class="row">   
                                                        <div class="col-lg-2">
                                                            <label for="">Qty</label>                                                    
                                                            <input type="text" class="form-control num" id="txtQty">                                                    
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Req Wt</label>                                                    
                                                            <input type="text" class="form-control num" id="txtReqWeight">                                                    
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Wastage%</label>                                                    
                                                            <input type="text" class="form-control num" id="txtWastage">                                                    
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Weight</label>
                                                            <input type="text" class="form-control num" id="txtWeight">
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Rate</label>
                                                            <input type="text" class="form-control num" id="txtPRate">
                                                        </div>
                                                        <div class="col-lg-2 amnt_width" >
                                                            <label for="">Amount</label>
                                                            <input type="text" class="form-control readonly num" id="txtAmount" readonly="true" tabindex="-1">
                                                        </div>


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label for="">Bag Wt</label>
                                                            <input type="text" class="form-control num" id="txtBagWeight">
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Bag Rt</label>
                                                            <input type="text" class="form-control num" id="txtBagRate">
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Req Bag</label>                                                    
                                                            <input type="text" class="form-control num" id="txtBag">                                                    
                                                        </div>
                                                        <div class="col-lg-2" >
                                                            <label for="">Item Id</label>
                                                            <select class="form-control select2" id="itemid_dropdown1">
                                                                <option value="" disabled="" selected="">Item Id</option>
                                                                ';foreach ($items as $item): ;echo '                                                                    <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo ' " data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_id'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                        </div>
                                                        <div class="col-lg-4" >
                                                            <label for="" id="stqty_lbl">Item</label>
                                                            <div class="input-group" >
                                                            <select class="form-control select2" id="item_dropdown1" style="width: 250px;">>
                                                                <option value="" disabled="" selected="">Item description</option>
                                                                ';foreach ($items as $item): ;echo '                                                                    <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_des'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                            <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                            data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-2">                                                
                                                           <label>Phase</label>
                                                            <select class="form-control select2" id="phase_dropdown1">
                                                                <option value="" selected="" disabled="">Phase</option>
                                                                ';foreach ($phase as $phases): ;echo '                                                                    <option value="';echo $phases['id'];;echo '">';echo $phases['name'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>                                          
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Weight</label>
                                                            <input type="text" class="form-control num" id="txtGrossWeight">                                                    
                                                        </div>
                                                        <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                            <a href="" class="btn btn-primary" id="btnAdd" style="position: relative; top: 10px;">+</a>
                                                        </div>         
                                                    </div>
                                                </div>
                                                <!-- <div class="row"></div> -->
                                                <!-- <div class="row"></div> -->
                                                
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        
                                                        <div id="no-more-tables">
                                                        <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table">
                                                            <thead class="cf tbl_thead">
                                                                <tr>
                                                                    <th>Sr#</th>
                                                                    <th style="width:100px;">Item Detail</th>
                                                                    <th>Phase</th>
                                                                    <th class="numeric text-right">Dozen</th>
                                                                    <th class="numeric text-right">Qty</th>
                                                                    <th class="numeric" style=\'text-align:right;width:60px;\'>Req Wt</th>
                                                                    <th class="numeric" style=\'text-align:right;\'>Wastage%</th>
                                                                    <th class="numeric" style=\'text-align:right;width:60px;\'>Bag Rt</th>
                                                                    <th class="numeric" style=\'text-align:right;width:60px;\'>Bag Wt</th>
                                                                    <th class="numeric" style=\'text-align:right;\'>Weight</th>
                                                                    <th class="numeric" style=\'text-align:right;\'>Rate</th>
                                                                    <th class="numeric" style=\'text-align:right;\'>Amount</th>
                                                                    <th class="numeric" style=\'text-align:right;\'>Req Bag</th>
                                                                    <th style="width:100px;">Item Detail</th>
                                                                    <th>Phase</th>
                                                                    <th class="numeric text-right">GWeight</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                           <tfoot class="tfoot_tbl">
                                                                <tr>
                                                                <td data-title="" class="numeric"></td>                                   
                                                                <td data-title="" class="numeric" ></td>
                                                                <td data-title="" class="numeric" >Total:</td>  
                                                                <td data-title="Dozen" class="numeric" id="txtTotalDozen"></td>
                                                                <td data-title="Qty" class="numeric" id="txtTotalQty"></td>
                                                                <td data-title="" class="numeric"></td>                                   
                                                                <td data-title="" class="numeric" ></td>
                                                                <td data-title="" class="numeric"></td>                                   
                                                                <td data-title="" class="numeric" ></td>
                                                                <td data-title="Weight" class="numeric" id="txtTotalWeight"></td>                                   
                                                                <td data-title="" class="numeric" ></td>
                                                                <td data-title="Amount" class="numeric" id="txtTotalAmount"></td>
                                                                <td data-title="Bag" class="numeric" id="txtTotalBag"></td>
                                                                <td data-title="" class="numeric"></td>
                                                                <td data-title="" class="numeric"></td>
                                                                <td data-title="" class="numeric"></td>
                                                                <td data-title="" class="numeric"></td>
                                                                </tr>
                                                            </tfoot>

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
                                               
                                                <div class="hide col-lg-2 amnt_width" >                                                    
                                                    <label>Paid</label>
                                                    <input type="text" class="form-control num" id="txtPaid" style=\'text-align:right;\'>
                                                </div> 
                                                 <div class="hide col-lg-1">                                                    
                                                    <label>Discount%</label>
                                                    <input type="text" class=" form-control num"  id="txtDiscount" style=\'text-align:right;\'>
                                                </div>                                                
                                                <div class="hide col-lg-2 amnt_width">                                                    
                                                    <label>DiscAmount</label>
                                                    <input type="text" class=" form-control num"  id="txtDiscAmount" style=\'text-align:right;\'>
                                                </div> 
                                                  <div class="hide col-lg-1">                                                    
                                                    <label>Expense%</label>
                                                    <input type="text" class=" form-control num"  id="txtExpense" style=\'text-align:right;\'>
                                                </div>                                                
                                                <div class="hide col-lg-2 amnt_width">                                                    
                                                    <label>Exp Amount</label>
                                                    <input type="text" class=" form-control num"  id="txtExpAmount" style=\'text-align:right;\'>
                                                </div>
                                                <div class="hide col-lg-1">                                                    
                                                    <label>Tax%</label>
                                                    <input type="text" class=" form-control num"  id="txtTax" style=\'text-align:right;\'>
                                                </div>   
                                                <div class="hide col-lg-2 amnt_width">                                                    
                                                    <label>TaxAmount</label>
                                                    <input type="text" class=" form-control num"  id="txtTaxAmount" style=\'text-align:right;\'>
                                                </div>

                                                <div class="col-lg-2 amnt_width">                                                    
                                                    <label>Net Amount</label>
                                                    <input type="text" class="form-control readonly " id=\'txtNetAmount\' readonly="" tabindex="-1" style=\'text-align:right;\'>
                                                    <!-- input type="text" class="form-control readonly num" id="txtUom" >                                                     -->
                                                </div>                                                          
                                            </div>
                                
                                            <div class="row">                                                                                    
                                                <div class="col-lg-12">
                                                    <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                    <a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['vendorcontract']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['vendorcontract']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['vendorcontract']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['vendorcontract']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                                    <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                                    
                                                    <div class="btn-group">
                                                          <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                          <button type="button" class="btn btn-primary btn-sm dropdown-toggle btn_right_print" data-toggle="dropdown" aria-expanded="false">
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                          </button>
                                                          <ul class="dropdown-menu" role="menu">
                                                            <!-- <li ><a href="#" class="btnprintHeader">With header</li> -->
                                                            <!-- <li ><a href="#" class="btnprintwithOutHeader">With out header</li> -->
                                                            <!-- <li ><a href="#" class="btnprint_sm">Small</li> -->
                                                            <!-- <li ><a href="#" class="btnprint_sm_withOutHeader">Small with out header </li> -->
                                                            <!-- <li ><a href="#" class="btnprint_sm_rate">Small with out rate</li> -->
                                                            <!-- <li ><a href="#" class="btnprint_sm_withOutHeader_rate">Small with out header and rate </li> -->
                                                          </ul>
                                                    </div>
                                                    <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
                                                    <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
                                                </div>
                                                                                           
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
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
                                                <div class="col-lg-4" >
                                                    <div class="input-group">
                                                        <span class="input-group-addon">User: </span>
                                                        <select class="form-control " disabled="" id="user_dropdown">
                                                            <option value="" disabled="" selected="">...</option>
                                                            ';foreach ($userone as $user): ;echo '                                                                <option value="';echo $user['uid'];;echo '">';echo $user['uname'];;echo '</option>
                                                            ';endforeach;;echo '                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>  <!-- end of row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Search">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="pull-right">
                                                <a href=\'\' class="btn btn-sm btn-success btnSearch" id="btnSearch" ><i class="fa fa-search"></i> Search</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            
                                            <div id="no-more-tables">
                                                <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_tableReport">
                                                    <thead class="cf tbl_thead">
                                                        <tr>
                                                            <th>Vr#</th>
                                                            <th>Date</th>
                                                            <th class="numeric text-left">Party</th>
                                                            <th class="numeric text-left">Remarks</th>
                                                            <th class="numeric text-left">Item</th>
                                                            <th class="numeric text-left">Uom</th>
                                                            <th class="numeric text-right">Qty</th>
                                                            <th class="numeric text-right">Dozen</th>
                                                            <th class="numeric text-right">Bag</th>
                                                            <th class="numeric text-right">Weight</th>
                                                            <th class="numeric text-right">Rate</th>
                                                            <th class="numeric text-right">Amount</th>
                                                            <!-- <th>Action</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="saleRows" class="report-rows saleRows">

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
    
                <div class="col-md-2">
                    <div class="row">
                        <label>Last Rates</label>
                         <table class="table table-striped Lrates_table font_tbl">
                            <thead>
                                <tr>
                                  <th>Vr #</th>
                                  <th>Date</th>
                                  <th class="text-right">Qty</th>
                                  <th class="text-right">Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                </tr>
                            </tbody>
                          <!--   <tfoot>
                                <tr>
                                    <td class="text-right" colspan=\'2\' >Total</td>
                                    <td class="TotalLrate"></td>
                                    <td class="TotalQty"></td>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                    <div class="row">
                        <label>Stock Positons</label>
                         <table class="table table-striped Lstocks_table font_tbl">
                            <thead>
                                <tr>
                                  <th>Location</th>
                                  <th class="text-right">Qty</th>
                                  <th class="text-right">Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    
                                    <td class="text-right" colspan=\'\' >Totals</td>
                                    <td class="TotalLstocks text-right"></td>
                                    <td class="TotalLWeights text-right"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        <label>Vendor Stock</label>
                         <table class="table table-striped Lvendors_table font_tbl">
                            <thead>
                                <tr>
                                  <th>Work Order</th>
                                  <th class="text-right">Qty</th>
                                  <th class="text-right">Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    
                                    <td class="text-right" colspan=\'\' >Totals</td>
                                    <td class="TotalLvendorstocks text-right"></td>
                                    <td class="TotalLvendorWeights text-right"></td>
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