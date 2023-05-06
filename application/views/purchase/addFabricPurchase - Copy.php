

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
     <td class="text-right">{{DICP}}</td>
     <td class="text-right">{{DICA}}</td>
     <td class="text-right">{{TAXP}}</td>
     <td class="text-right">{{TAXA}}</td>
     <td class="text-right printRemove">{{EXPP}}</td>
     <td class="text-right printRemove">{{EXPA}}</td>
     <td class="text-right">{{PAID}}</td>
     <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
   
  </tr>
</script>
<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     
     <td class="tblInvoice"></td>
     <td></td>
     <td class="printRemove"></td>
     <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
     <td class="text-right txtbold">{{ VOUCHER_DISCOUNTP_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_DISCOUNTA_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_TAXP_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_TAXA_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_EXP_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_EXPA_SUM }}</td>
     <td class="txtbold" style="text-align:right !important;">{{ VOUCHER_PAID_SUM }}</td>
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
                    <tr >
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
                    <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa fa-check"></i></a></td>
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
                    <td>
                    ';echo $item['item_id'];;echo '                    <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                    </td>
                    <td>';echo $item['artcile_no'];;echo '</td>
                    <td>';echo $item['item_des'];;echo '</td>
                    <td>';echo $item['item_code'];;echo '</td>
                    <td>';echo $item['uom'];;echo '</td>
                    <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa fa-check"></i></a></td>
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
            <div class="col-md-4">
                <h1 class="page_title">Fabric Purchase Voucher</h1>
            </div>
            <div class="col-lg-8">
                <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['fabricpurchase']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['fabricpurchase']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['fabricpurchase']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['fabricpurchase']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                <!-- <a class="btn btn-sm btn-default btnPrint"><i class="fa fa-print"></i> Print F9</a>                                     -->
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li ><a href="#" class="btnprintAccount"> Account Prints</a></li>
                    
                  </ul>
                </div>
                <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
                <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-warning btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
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
                                                            <span class=" ">Sr#</span>
                                                            <input type="number" class="form-control input-sm " id="txtVrnoa" >
                                                            <input type="hidden" id="txtMaxVrnoaHidden">
                                                            <input type="hidden" id="txtVrnoaHidden">
                                                            <input type="hidden" id="voucher_type_hidden">

                                                            <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                                            <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                                            <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                                                            <input type="hidden" id="purchaseid" value="';echo $setting_configur[0]['purchase'];;echo '">
                                                            <input type="hidden" id="fabricpurchaseid" value="';echo $setting_configur[0]['fabricpurchase'];;echo '">
                                                            <input type="hidden" id="discountid" value="';echo $setting_configur[0]['discount'];;echo '">
                                                            <input type="hidden" id="expenseid" value="';echo $setting_configur[0]['expenses'];;echo '">
                                                            <input type="hidden" id="taxid" value="';echo $setting_configur[0]['tax'];;echo '">
                                                            <input type="hidden" id="cashid" value="';echo $setting_configur[0]['cash'];;echo '">
                                                            <input type="hidden" id="commissionid" value="';echo $setting_configur[0]['commission'];;echo '">

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
                                                            ';if ($vouchers['date_close']['insert'] == 1){;echo '                                                                <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                                                            ';}else{;echo '                                                                <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" readonly="">
                                                            ';};echo '                                                        <!-- </div> -->
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    
                                                    <div class="col-lg-4">
                                                        <label>Party</label>
                                                        <div class="input-group" >
                                                        <select class="form-control input-sm  select2" id="party_dropdown">
                                                            <option value="" selected="" disabled="">Party</option>
                                                            ';foreach ($parties as $party): ;echo '                                                                <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                        <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                                        data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                        </div>                                                
                                                    </div>
                                                    <div class="col-lg-2">                                                
                                                        <label>Broker</label>
                                                        <select class="form-control input-sm select2" id="broker">
                                                            <option value="" selected="" disabled="">Broker</option>
                                                            ';foreach ($brokers as $broker): ;echo '                                                                <option value="';echo $broker['officer_id'];;echo '">';echo $broker['name'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>                                               
                                                    </div>  
                                                    <div class="col-lg-2">                                                
                                                        <label>Approved By</label>
                                                        <input type="text" list=\'approved\' class="form-control input-sm" id="approvedBy"  />
                                                        <datalist id=\'approved\'>
                                                            ';foreach ($approvedby as $approv): ;echo '                                                                <option value="';echo $approv['approved_by'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist>
                                                    </div>                                                     
                                                    <div class="col-lg-2">                                                
                                                        <label>Prepared By</label>
                                                        <input type="text" list=\'prepared\' class="form-control input-sm" id="preparedBy"  />
                                                        <datalist id=\'prepared\'>
                                                            ';foreach ($preparedby as $pre): ;echo '                                                                <option value="';echo $pre['prepared_by'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist>
                                                    </div>
                                                    <div class="col-lg-2">                                                
                                                        <label>WO#</label>
                                                        <select class="form-control select2" id="txtWono">
                                                            <option value="" selected="" disabled="">WO#</option>
                                                            ';foreach ($worder as $wo): ;echo '                                                                <option value="';echo $wo['vrnoa'];;echo '">';echo $wo['vrnoa'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label>Cont#</label>
                                                        <input type="text"  class="form-control input-sm num" id="txtContract" readonly="" />
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>IGP#</label>
                                                        <input type="text"  class="form-control input-sm num" id="txtIgp" />
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <label>Remarks</label>
                                                        <input type="text"  class="form-control input-sm" id="txtRemarks" />
                                                        
                                                    </div>
                                                </div>                                   
                                                <!-- <div class="row"></div> -->
                                                <div class="container-wrap">
                                                    <div class="row">

                                                        <div class="col-lg-2" >
                                                            <label for="">Item Code</label>
                                                            <div class="input-group">
                                                                
                                                                <!-- <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span> -->
                                                                <select class="form-control select2" id="itemid_dropdown">
                                                                    <option value="" disabled="" selected="">Item Id</option>
                                                                    ';foreach ($items as $item): ;echo '                                                                        <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-brand="';echo $item['brand_name'];;echo '">';echo $item['item_id'];;echo '</option>
                                                                    ';endforeach ;echo '                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4" >
                                                            <label for="">Item Description</label>
                                                            <div class="input-group" >
                                                            <select class="form-control select2" id="item_dropdown">
                                                                <option value="" disabled="" selected="">Item description</option>
                                                                ';foreach ($items as $item): ;echo '                                                                    <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-brand="';echo $item['brand_name'];;echo '">';echo $item['item_des'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                            <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                            data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label for="">Uom</label>                                                    
                                                            <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                                        </div>
                                                       <!--  <div class="col-lg-1" >
                                                            <label for="">Color</label>
                                                            <div class="input-group" >
                                                            <select class="form-control select2" id="txtColor">
                                                                <option value="" disabled="" selected="">color</option>
                                                                ';foreach ($colors as $col): ;echo '                                                                    <option value="';echo $col['id'];;echo '">';echo $col['name'];;echo '</option>
                                                                ';endforeach ;echo '                                                            </select>
                                                            </div>
                                                        </div> -->
                                                       <!--  <div class="col-lg-2">
                                                            <label for="">Brand</label>    -->                                                 
                                                            <!-- <input type="text" class="form-control num" id="txtBrand">   
                                                            <label>Approved By</label> -->
                                                           <!--  <input type="text" list=\'brand\' class="form-control " id="txtBrand"  />
                                                            <datalist id=\'brand\'>
                                                            ';foreach ($brands as $brand): ;echo '                                                                <option value="';echo $brand['brand'];;echo '">
                                                            ';endforeach ;echo '                                                            </datalist>                                                 
                                                        </div> -->
                                                    <div class="col-lg-1">
                                                        <label>Bolt</label>
                                                        <input type="text" list=\'count\' class="form-control input-sm" id="txtBolt" />
                                                       <!--  <datalist id=\'count\'>
                                                            ';foreach ($counts as $count): ;echo '                                                                <option value="';echo $count['count'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist> -->
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label>Qty</label>
                                                        <input type="text" list=\'pick\' class="form-control input-sm num" id="txtQtyGross" />
                                                        <!-- <datalist id=\'pick\'>
                                                            ';foreach ($picks as $pick): ;echo '                                                                <option value="';echo $pick['pick'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist> -->
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label>Less</label>
                                                        <input type="text" list=\'reed\' class="form-control input-sm num" id="txtLess" />
                                                        <!-- <datalist id=\'reed\'>
                                                            ';foreach ($reeds as $reed): ;echo '                                                                <option value="';echo $reed['reed'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist> -->
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <label>Shortage</label>
                                                        <input type="text" list=\'width\' class="form-control input-sm num" id="txtShortage" />
                                                        <!-- <datalist id=\'width\'>
                                                            ';foreach ($widths as $width): ;echo '                                                                <option value="';echo $width['width'];;echo '">
                                                            ';endforeach ;echo '                                                        </datalist> -->
                                                    </div>
                                                                                               
                                                    </div>
                                                    <div class="row">
                                                        <!-- <div class="col-lg-1">
                                                            <label for="">Quality</label>                                                    
                                                            <input type="text" class="form-control num" id="txtQlty">                                                    
                                                        </div> -->
                                                        <div class="col-lg-2">
                                                            <label for="">Net Qty</label>                                                    
                                                            <input type="text" class="form-control num" id="txtQty">                                                    
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label for="">Rate</label>                                                    
                                                            <input type="text" class="form-control num" id="txtPRate">                                                    
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Weight</label>                                                    
                                                            <input type="text" class="form-control num" id="txtWeight">                                                    
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="">Amount</label>                                                    
                                                            <input type="text" class="form-control readonly num" id="txtAmount" readonly="true" tabindex="-1">                                                    
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
                                                        <table class="col-lg-12 table-bordered table-striped table-condensed cf " id="sale_table">
                                                            <thead class="cf">
                                                                <tr>
                                                                    <th class="numeric text-right">Sr#</th>
                                                                    <th>Id</th>
                                                                    <th>Item Detail</th>
                                                                    <th>UOM</th>
                                                                    <th class="numeric text-right">Bolt</th>
                                                                    <th class="numeric text-right">Qty</th>
                                                                    <th class="numeric text-right">Less</th>
                                                                    <th class="numeric text-right">Shortage</th>
                                                                    <th class="numeric text-right">Net Qty</th>
                                                                    <th class="numeric text-right">Weight</th>
                                                                    <th class="numeric text-right">Rate</th>
                                                                    <th class="numeric text-right">Amount</th>
                                                                    <th class="numeric text-right">Work Order#</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                            <tfoot class="tfoot_tbl">
                                                                <tr>
                                                                    <td data-title="" class="text-right" colspan="8">Totals</td>
                                                                    <td data-title="Qty" class="text-right numeric txtTotalQty"></td>
                                                                    <td data-title="Weight" class="text-right numeric txtTotalWeight"></td>
                                                                    <td data-title="" class="text-right numeric txtTotalRate"></td>
                                                                    <td data-title="Amount" class="text-right numeric txtTotalAmount"></td>
                                                                    <td data-title=""></td>
                                                                    <td data-title=""></td>
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
                                                                                                
                                              <!--   <div class="col-lg-3">                                                    
                                                    <label>Total Qty</label>
                                                    <input type="text" class="form-control readonly num" id="txtTotalQty" readonly="true" tabindex="-1">
                                                </div>  
                                                <div class="col-lg-3">                                                    
                                                    <label>Total Weight</label>
                                                    <input type="text" class="form-control readonly num" id="txtTotalWeight" readonly="true" tabindex="-1">
                                                </div>                                              
                                                <div class="col-lg-3">                                                    
                                                    <label>Total Amount</label>
                                                    <input type="text" class="form-control readonly num" id="txtTotalAmount" readonly="true" tabindex="-1">
                                                </div> -->
                                                <div class="col-lg-3">                                                    
                                                    <label>Paid</label>
                                                    <input type="text" class="form-control num" id="txtPaid">
                                                </div>
                                                <div class="col-lg-3">                                                    
                                                    <label>Freight</label>
                                                    <input type="text" class="form-control num" id="txtFreight">
                                                </div>                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <label>Dispatch Address</label>
                                                    <input type="text" list=\'dispatch_address\' class="form-control input-sm" id="txtDisAddress" />
                                                    <datalist id=\'dispatch_address\'>
                                                            ';foreach ($dispatch_addresss as $dispatch_address): ;echo '                                                                <option value="';echo $dispatch_address['dispatch_address'];;echo '">
                                                            ';endforeach ;echo '                                                    </datalist>

                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Delivery Schedule</label>
                                                    <input type="text" list=\'delivery_term\' class="form-control input-sm" id="txtDelSchedule" />
                                                    <datalist id=\'delivery_term\'>
                                                            ';foreach ($delivery_terms as $delivery_term): ;echo '                                                                <option value="';echo $delivery_term['delivery_term'];;echo '">
                                                            ';endforeach ;echo '                                                    </datalist>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Payment Terms</label>
                                                    <input type="text" list=\'payment_term\' class="form-control input-sm" id="txtPayTerms" />
                                                    <datalist id=\'payment_term\'>
                                                            ';foreach ($payment_terms as $payment_term): ;echo '                                                                <option value="';echo $payment_term['payment_term'];;echo '">
                                                            ';endforeach ;echo '                                                    </datalist>
                                                </div>
                                                                        
                                            </div>
                                            <div class="row">                                           
                                                <div class="col-lg-1">                                                    
                                                    <label>Disc%</label>
                                                    <input type="text" class=" form-control num"  id="txtDiscount">
                                                </div>                                                
                                                <div class="col-lg-2">                                                    
                                                    <label>Discount</label>
                                                    <input type="text" class=" form-control num"  id="txtDiscAmount">
                                                </div>
                                                <div class="col-lg-1">                                                    
                                                    <label>Comm%</label>
                                                    <input type="text" class=" form-control num"  id="txtExpense">
                                                </div>                                                
                                                <div class="col-lg-2">                                                    
                                                    <label>Comm Amount</label>
                                                    <input type="text" class=" form-control num"  id="txtExpAmount">
                                                </div>
                                                <div class="col-lg-1">                                                    
                                                    <label>GST%</label>
                                                    <input type="text" class=" form-control num"  id="txtTax">
                                                </div>                                                
                                                <div class="col-lg-2">                                                    
                                                    <label>GST Amount</label>
                                                    <input type="text" class=" form-control num"  id="txtTaxAmount">
                                                </div>

                                                <div class="col-lg-3">                                                    
                                                    <label>Net Amount</label>
                                                    <input type="text" class="form-control readonly " id=\'txtNetAmount\' readonly="" tabindex="-1">
                                                    <!-- input type="text" class="form-control readonly num" id="txtUom" >                                                     -->
                                                </div>
                                                
                                            </div>
                                            <div class="row">                                                                                    
                                                <div class="col-lg-12">
                                                    <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                    <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['fabricpurchase']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['fabricpurchase']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['fabricpurchase']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['fabricpurchase']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                                    <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                                    <!-- <a class="btn btn-sm btn-default btnPrint"><i class="fa fa-print"></i> Print F9</a>                                     -->
                                                    <div class="btn-group">
                                                      <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                      </button>
                                                      <ul class="dropdown-menu" role="menu">
                                                        <li ><a href="#" class="btnprintAccount"> Account Prints</a></li>
                                                        
                                                      </ul>
                                                    </div>
                                                    <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
                                                    <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-warning btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
                                                </div>
                                            </div>
                                            <div class="row">   
                                                <div class="col-lg-2">
                                                    <div class="form-group">                                                                
                                                        <div class="input-group">
                                                          <span class="switch-addon input-group-addon">Pre Bal?</span>
                                                          <input type="checkbox" checked="" class="bs_switch" id="switchPreBal">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-1"></div>
                                                
                                                <div class="col-lg-3" >
                                                    <div class="input-group">
                                                        <span class="input-group-addon">User: </span>
                                                        <select class="form-control " disabled="" id="user_dropdown">
                                                            <option value="" disabled="" selected="">...</option>
                                                            ';foreach ($userone as $user): ;echo '                                                                <option value="';echo $user['uid'];;echo '">';echo $user['uname'];;echo '</option>
                                                            ';endforeach;;echo '                                                        </select>
                                                    </div>
                                                </div>                                           
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">                                                                
                                                        <div class="input-group">
                                                          <span class="switch-addon input-group-addon">Print Header?</span>
                                                          <input type="checkbox" checked="" class="bs_switch" id="switchHeader">
                                                        </div>
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
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
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
                                                            <th class="numeric text-right">Disc%</th>
                                                            <th class="numeric text-right">Disc</th>
                                                            <th class="numeric text-right">Tax%</th>
                                                            <th class="numeric text-right">Tax</th>
                                                            <th class="numeric text-right">Exp%</th>
                                                            <th class="numeric text-right">Exp</th>
                                                            <th class="numeric text-right">Received</th>
                                                            <th class="numeric text-right">Net Amount</th>
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
                        <label>Last 5 Purchase Rates</label>
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
                </div>

                </div>  <!-- end of level 1-->
            </div>
        </div>
    </div>
</div>';
?>