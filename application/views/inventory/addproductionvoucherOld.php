

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="generalConsume-head-template" type="text/x-handlebars-template">
      <tr>
          <th>Vr#</th>
          <th>Date</th>
          <th class="text-left">Remarks</th>
          <th class="text-left">Item</th>
          <th class="text-left">Sub Phase</th>
          <th class="numeric text-right">Qty</th>
          <th class="numeric text-right">Weight</th>
      </tr>
</script>
<script id="generalProduce-head-template" type="text/x-handlebars-template">
      <tr>
          <th>Vr#</th>
          <th>Date</th>
          <th class="text-left">Remarks</th>
          <th class="text-left">Item</th>
          <th class="text-left">Sub Phase</th>
          <th class="numeric text-right">Qty</th>
          <th class="numeric text-right">Dozen</th>
          <th class="numeric text-right">Weight</th>
          <th class="numeric text-right">Rate</th>
          <th class="numeric text-right">P Amount</th>
          <th class="numeric text-right">Cost</th>
          <th class="text-left">Employee</th>
          <th class="numeric text-right">L Rate</th>
          <th class="numeric text-right">No of Machines</th>
          <th class="numeric text-right">L Amount</th>
      </tr>
</script>
<script id="voucherCounsume-item-template" type="text/x-handlebars-template">
  <tr>
     <td>{{{VRNOA}}}</td>
     <td>{{VRDATE}}</td>
     <td>{{REMARKS}}</td>
     <td>{{ITEMNAME}}</td>
     <td>{{SUBPHASE}}</td>
     <td class="text-right">{{QTY}}</td>
     <td class="text-right">{{WEIGHT}}</td>
   
   
  </tr>
</script>
<script id="voucherProduce-item-template" type="text/x-handlebars-template">
  <tr>
     <td>{{{VRNOA}}}</td>
     <td>{{VRDATE}}</td>
     <td>{{REMARKS}}</td>
     <td>{{ITEMNAME}}</td>
     <td>{{SUBPHASE}}</td>
     <td class="text-right">{{QTY}}</td>
     <td class="text-right">{{DOZEN}}</td>
     <td class="text-right">{{WEIGHT}}</td>
     <td class="text-right">{{RATE}}</td>
     <td class="text-right">{{PAMOUNT}}</td>
     <td class="text-right">{{COST}}</td>
     <td>{{EMPLOYEE}}</td>
     <td class="text-right">{{LRATE}}</td>
     <td class="text-right">{{MACHINES}}</td>
     <td class="text-right">{{LAMOUNT}}</td>
  </tr>
</script>
<script id="voucherCounsume-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     
     <td class="tblInvoice"></td>
     <td></td>
     <td class="printRemove"></td>
     <td class="printRemove"></td>
     <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
     <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
  </tr>
</script>
<script id="voucherProduce-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     
     <td class="tblInvoice"></td>
     <td></td>
     <td class="printRemove"></td>
     <td class="printRemove"></td>
     <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
     <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_DOZEN_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
     <td class="printRemove"></td>
     <td class="text-right txtbold">{{ VOUCHER_PAMOUNT_SUM }}</td>
     <td></td>
     <td class="printRemove"></td>
     <td class="printRemove"></td>
     <td class="text-right txtbold">{{ VOUCHER_MACHINES_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_LAMOUNT_SUM }}</td>
  </tr>
</script>
';
$desc = $this->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$vouchers = $desc['vouchers'];
;echo '<div id="AccountAddModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="AccountAddModelLabel" aria-hidden="true">
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
                        ';foreach ($l3s as $l3): ;echo '                        <option value="';echo $l3['l3'];;echo '" data-level2="';echo $l3['level2_name'];;echo '" data-level1="';echo $l3['level1_name'];;echo '">';echo $l3['level3_name'] ;echo '</option>
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
<div id="ItemAddModel" class="modal hide fade" role="dialog" aria-labelledby="ItemAddModelLabel" aria-hidden="true">
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
                        ';endforeach ;echo '                      </select>
                    </div>
                    <div class="col-lg-6">
                      <label>Sub Catgeory</label>
                      <select class="form-control input-sm select2" id="subcategory_dropdown" tabindex="3">
                        <option value="" disabled="" selected="">Choose sub category</option>
                        ';foreach ($subcategories as $subcategory): ;echo '                        <option value="';echo $subcategory['subcatid'];;echo '">';echo $subcategory['name'];;echo '</option>
                        ';endforeach ;echo '                      </select>
                    </div>
                  </div>    
                  <div class="row">
                    <div class="col-lg-6">
                      <label>Brand</label>
                      <select class="form-control input-sm select2" id="brand_dropdown" tabindex="4">
                        <option value="" disabled="" selected="">Choose brand</option>
                        ';foreach ($brands as $brand): ;echo '                        <option value="';echo $brand['bid'];;echo '">';echo $brand['name'];;echo '</option>
                        ';endforeach ;echo '                      </select>
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

<!-- main content -->
<div id="main_wrapper">
<div class="page_bar">
  <div class="row">
    <div class="col-md-4">
      <h1 class="page_title">Production Voucher</h1>
    </div>
    <div class="col-lg-8">
       <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
       <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['productionvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['productionvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['productionvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['productionvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
       <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
       <div class="btn-group">
         <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
         <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
           <span class="caret"></span>
           <span class="sr-only">Toggle Dropdown</span>
         </button>
         <ul class="dropdown-menu" role="menu">
           <!-- <li ><a href="#" class="btnprintHeader"> Print with header</li> -->
           <!-- <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li> -->
         </ul>
       </div>
      <!--  <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a> -->
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
                             <div class="col-lg-12">
                               <div class="form-group">
                                 <div class="row">
                                   <div class="col-lg-1">
                                     <label>Sr#</label>
                                       <input type="number" class="form-control input-sm " id="txtVrnoa" >
                                       <input type="hidden" id="txtMaxVrnoaHidden">
                                       <input type="hidden" id="txtVrnoaHidden">
                                       <input type="hidden" id="voucher_type_hidden">
                                       <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                       <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                       <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                                       <input type="hidden" name="edit_qty" id="edit_qty" value="0">
                                        <input type="hidden" name="edit_weight" id="edit_weight" value="0">

                                     </div>
                                     <div class="col-lg-2"> 
                                       <label>Date</label>
                                        ';if ($vouchers['date_close']['insert'] == 1){;echo '                                            <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                                        ';}else{;echo '                                            <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" readonly="">
                                        ';};echo '                                     </div>
                                   </div>
                                 </div>
                                 <div class="form-group">
                                   <div class="row">
                                     <div class="col-lg-2">                                                
                                       <label>Work Order#</label>
                                       <select class="form-control input-sm select2 select_bg" id="worder">
                                         <option value="" selected="" disabled="">Work Order</option>
                                         ';foreach ($worder as $workorder): ;echo '                                         <option value="';echo $workorder['vrnoa'];;echo '">';echo $workorder['vrnoa'];;echo '</option>
                                         ';endforeach ;echo '                                       </select>                                               
                                     </div>
                                     <!-- <div class="col-lg-3" >
                                       <label>Party Name</label>
                                       <div class="input-group" >
                                       <select class="form-control select2" id="party_dropdown11" >
                                           <option value="" disabled="" selected="">Choose party</option>
                                           ';foreach ($parties as $party): ;echo '                                               <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                           ';endforeach ;echo '                                       </select>
                                       <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#AccountAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                   data-placement="top" data-original-title="Add Category" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                       </div>
                                   </div> -->
                                     <div class="col-lg-2">                                                
                                       <label>Received By</label>
                                       <input class=\'form-control \' type=\'text\' list="receivers" id=\'receivers_list\'>
                                       <datalist id=\'receivers\'>
                                           ';foreach ($receivers as $receiver): ;echo '                                               <option value="';echo $receiver['received_by'];;echo '">
                                           ';endforeach ;echo '                                       </datalist>                                                
                                     </div>   
                                     <div class="col-lg-2">                                                
                                       <label>Department</label>
                                       <select class="form-control input-sm select2 select_bg" id="godown">
                                         <option value="" disabled="" selected="">Choose department</option>
                                         ';foreach ($location as $godown): ;echo '                                         <option value="';echo $godown['did'];;echo '">';echo$godown['name'];;echo '</option>
                                         ';endforeach ;echo '                                       </select>
                                     </div>
                                     <div class="col-lg-2">                                                
                                       <label>Shift</label>
                                       <select class="form-control input-sm select2 select_bg" id="shift_dropdown">
                                         <option value="" disabled="" selected="">Choose Shift</option>
                                         ';foreach ($shifts as $Shift): ;echo '                                         <option value="';echo $Shift['shid'];;echo '">';echo $Shift['name'];;echo '</option>
                                         ';endforeach ;echo '                                       </select>
                                     </div>

                                     <div class="col-lg-4">
                                       <label>Remarks</label>
                                       <input type="text" class="form-control" id=\'remarks\'>
                                     </div>
                                   </div>
                                 </div>
                                     
                               </div>
                             </div>                                     
                             <br>
                             <div class="row">
                               <div class="col-lg-12">
                                 <div role="tabpanel">
                                     <!-- Nav tabs -->
                                     <ul class="nav nav-tabs" role="tablist">
                                       <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Consumed</a></li>
                                       <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Produce</a></li>
                                     </ul>

                                     <!-- Tab panes -->
                                     <div class="tab-content" style="background:whitesmoke;">
                                       <div role="tabpanel" class="tab-pane active" id="home">
                                         <div class="row-fluid">
                                           <div class="col-lg-12">
                                             <div class="form-group">
                                               <div class="row">
                                                <div class="col-lg-1">
                                                   <label for="">Id</label>
                                                   <select class="form-control select2" id="itemid_dropdown">
                                                     <option value="" disabled="" selected="">Id</option>
                                                     ';foreach ($items as $item): ;echo '                                                     <option value="';echo $item['item_id'];;echo '" data-uom="';echo $item['uom'];echo '" >';echo $item['item_id'];;echo '</option>
                                                     ';endforeach ;echo '                                                   </select>
                                                 </div> 
                                                 <div class="col-lg-4" >
                                                   <label for="" id="stqty_lbl">Item</label>
                                                   <div class="input-group" >
                                                   <select class="form-control select2 itemss" id="item_dropdown">
                                                       <option value="" disabled="" selected="">Item description</option>
                                                       ';foreach ($items as $item): ;echo '                                                           <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_des'];;echo '</option>
                                                       ';endforeach ;echo '                                                   </select>
                                                   <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                   data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                   </div>
                                                 </div>
                                                 <div class="col-lg-2">                                                
                                                    <label>Sub Phase</label>
                                                    <select class="form-control select2" id="phase_dropdown">
                                                       <option value="" selected="" disabled="">Phase</option>
                                                       ';foreach ($phase as $phases): ;echo '                                                           <option value="';echo $phases['id'];;echo '">';echo $phases['name'];;echo '</option>
                                                       ';endforeach ;echo '                                                    </select>                                          
                                                   </div>
                                                 <div class="col-lg-1">
                                                   <label for="">Uom</label>                                                    
                                                   <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                                 </div>
                                                  
                                                 <div class="col-lg-1">
                                                   <label for="">Qty</label>                                                    
                                                   <input type="text" class="form-control readonly num" id="txtQty" >                                                    
                                                 </div>
                                                 <div class="col-lg-1">
                                                   <label for="">Dozen</label>                                                    
                                                   <input type="text" class="form-control readonly num" id="txtDozen" > 
                                                 </div>
                                                 <div class="col-lg-1">
                                                   <label for="">Weight</label>                                                    
                                                   <input type="text" class="form-control num" id="txtWeight">                                                    
                                                 </div>
                                                <!--  <div class="col-lg-1">
                                                   <label for="">Rate</label>                                                    
                                                   <input type="text" class="form-control readonly num" id="txtPRate" >                                                    
                                                 </div>
                                                 <div class="col-lg-1">
                                                   <label for="">Amount</label>                                                    
                                                   <input type="text" class="form-control num" id="txtAmount" readonly="true">                                                    
                                                 </div> -->
                                                 <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                   <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                                 </div> 
                                               </div>
                                             </div>
                                           </div>
                                         </div>
                                         <div class="row">
                                           <div class="col-lg-12">
                                             <div id="no-more-tables">
                                               <table class="col-lg-12 table-bordered table-striped table-condensed cf " id="purchase_table">
                                                 <thead class="cf">
                                                   <tr>
                                                       <th>Sr#</th>
                                                       <th>Id</th>
                                                       <th>Item Detail</th>
                                                       <th>Sub Phase</th>
                                                       <th class="numeric" style=\'text-align:right;\'>Qty</th>
                                                       <th class="numeric" style=\'text-align:right;\'>Dozen</th>
                                                       <th class="numeric" style=\'text-align:right;\'>Weight</th>
                                                       <th>Action</th>
                                                   </tr>
                                                 </thead>
                                                 <tbody id="table">

                                                 </tbody>  
                                                 <tfoot class="tfoot_tbl cf">
                                                     <tr>
                                                       <td></td>
                                                       <td></td>                                   
                                                       <td ></td>
                                                       <td >Total:</td>  
                                                       <td class="numeric" id="txtTotalQty" ></td>
                                                       <td class="numeric" id="txtTotalDozen" ></td>
                                                       <td class="numeric" id="txtTotalWeight" ></td>                                   
                                                       <td ></td>
                                                     </tr>
                                                 </tfoot>       
                                               </table>
                                             </div>
                                           </div>
                                         </div>
                                         
                                       </div>
                                       <div role="tabpanel" class="tab-pane" id="profile">
                                         <div class="row-fluid">
                                           <div class="col-lg-12">
                                             <div class="form-group">
                                               <div class="row">
                                                 <div class="col-lg-1" >
                                                   <label for="" id="stqty_lbl1">Id</label>
                                                   
                                                   <select class="form-control select2 itemss" id="itemid_dropdown1">
                                                       <option value="" disabled="" selected="">Item id</option>
                                                       ';foreach ($items as $item): ;echo '                                                           <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_id'];;echo '</option>
                                                       ';endforeach ;echo '                                                   </select>
                                                   
                                                 </div>

                                                 <div class="col-lg-5" >
                                                   <label for="" id="stqty_lbl1">Item</label>
                                                   <div class="input-group" >
                                                   <select class="form-control select2 itemss" id="item_dropdown1">
                                                       <option value="" disabled="" selected="">Item description</option>
                                                       ';foreach ($items as $item): ;echo '                                                           <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_des'];;echo '</option>
                                                       ';endforeach ;echo '                                                   </select>
                                                   <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
                                                   data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
                                                   </div>
                                                 </div>
                                                 <div class="col-lg-2">                                                
                                                    <label>Sub Phase</label>
                                                    <select class="form-control select2" id="phase_dropdown1">
                                                       <option value="" selected="" disabled="">Phase</option>
                                                       ';foreach ($phase as $phases): ;echo '                                                           <option value="';echo $phases['id'];;echo '">';echo $phases['name'];;echo '</option>
                                                       ';endforeach ;echo '                                                    </select>                                          
                                                   </div>
                                                   <div class="col-lg-1">
                                                     <label for="">Uom</label>                                                    
                                                     <input type="text" class="form-control readonly num" id="txtUom1" readonly="" tabindex="-1">                                                    
                                                   </div>
                                                    
                                                     <div class="col-lg-1">
                                                       <label for="">Qty</label>                                                    
                                                       <input type="text" class="form-control readonly num" id="txtQty1" >                                                    
                                                     </div>
                                                     <div class="col-lg-1">
                                                       <label for="">Dozen</label>                                                    
                                                       <input type="text" class="form-control readonly num" id="txtDozenQty1" >                                                    
                                                     </div>
                                                     <div class="col-lg-1">
                                                       <label for="">Weight</label>                                                    
                                                       <input type="text" class="form-control num" id="txtWeight1">                                                    
                                                     </div>    
                                                      <div class="col-lg-1 hide">
                                                       <label for="">Rate</label>                                                    
                                                       <input type="text" class="form-control num" id="txtPRate1">                                                    
                                                     </div> 
                                                     <div class="col-lg-1 hide">
                                                       <label for="">P Amount</label>                                                    
                                                       <input type="text" class="form-control num" id="txtAmount1" readonly="">                                                    
                                                     </div>
                                                     <div class="col-lg-1 hide">
                                                       <label for="">Cost</label>                                                    
                                                       <input type="text" class="form-control num" id="txtCost1">                                                    
                                                     </div>
                                                     
                                                   </div>
                                                   <div class="row">
                                                     <div class="col-lg-3">
                                                       <label for="">Employee</label>                                                          
                                                         <select class="form-control select2" id="employee">
                                                         <option value="" disabled="" selected="">Employee</option>
                                                         ';foreach ($staffs as $staff): ;echo '                                                         <option value="';echo $staff['staid'];;echo '" data-did="';echo $staff['did'];;echo '" data-designation="';echo $staff['designation'];;echo '" data-type="';echo $staff['type'];;echo '">';echo $staff['name'];;echo '</option>
                                                         ';endforeach ;echo '                                                         </select>                                                     
                                                     </div>    
                                                     <div class="col-lg-1">
                                                       <label for="">L Rate</label>                                                    
                                                       <input type="text" class="form-control num" id="txtLRate1">                                                    
                                                     </div>
                                                     <div class="col-lg-1">
                                                       <label for=""> Amount</label>                                                    
                                                       <input type="text" class="form-control num" id="txtLAmount1" readonly="">                                                    
                                                     </div>
                                                     <div class="col-lg-2">
                                                       <label for="">No of Machines</label>                                                    
                                                       <input type="text" class="form-control num" id="txtnoofMachines">                                                    
                                                     </div>
                                                     <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                       <a href="" class="btn btn-primary" id="btnAdd1">+</a>
                                                     </div> 
                                                   </div>
                                                 </div>
                                               </div>
                                             </div>
                                             <div class="row">
                                               <div class="col-lg-12">
                                                 <div id="no-more-tables">
                                                   <table class="col-lg-12 table-bordered table-striped table-condensed cf " id="sale_table">
                                                     <thead class="cf">
                                                      
                                                       <tr>
                                                         <th>Sr#</th>
                                                         <th>Id</th>
                                                         <th>Item Detail</th>
                                                         <th>Sub Phase</th>
                                                         <th class="numeric" style=\'text-align:right;\'>Qty</th>
                                                         <th class="numeric" style=\'text-align:right;\'>Dozen</th>
                                                         <th class="numeric" style=\'text-align:right;\'>Weight</th>
                                                         <th class="numeric hide" style=\'text-align:right;\'>Rate</th>
                                                         <th class="numeric hide" style=\'text-align:right;\'>P Amount</th>
                                                         <th class="numeric hide" style=\'text-align:right;\'>Cost</th>
                                                         <th>Employee</th>
                                                         <th class="numeric" style=\'text-align:right;\'>Rate</th>
                                                         <th class="numeric" style=\'text-align:right;\'>Amount</th>
                                                         <th class="numeric" style=\'text-align:right;\'>NOM</th>
                                                         <th>Action</th>
                                                       </tr>
                                                     </thead>
                                                     <tbody id="ptable">

                                                     </tbody>     
                                                     <tfoot class="tfoot_tbl cf" >
                                                                 <tr>
                                                                 <td></td>                                   
                                                                 <td ></td>
                                                                 <td ></td>
                                                                 <td >Total:</td>  
                                                                 <td id="txtTotalQty1" ></td>
                                                                 <td id="txtTotalDozne1"></td>
                                                                 <td id="txtTotalWeight1"></td>                                   
                                                                 <td class="hide" ></td>
                                                                 <td class="hide" id="txtTotalAmount1"></td>
                                                                 <td class="hide"></td>
                                                                 <td></td>
                                                                 <td></td>
                                                                 <td id="txtTotalLAmount1"></td>
                                                                 <td id="txtTotalMachines"></td>
                                                                 <td></td>
                                                                 </tr>
                                                      </tfoot>
                                                   </table>
                                                 </div>
                                               </div>
                                             </div>
                                             
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
                                             ';foreach ($parties as $party): ;echo '                                             <tr>
                                               <td width="14%;">
                                               ';echo $party['pid'];;echo '                                               <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                                               </td>
                                               <td>';echo $party['name'];;echo '</td>
                                               <td>';echo $party['mobile'];;echo '</td>
                                               <td>';echo $party['address'];;echo '</td>
                                               <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa fa-check"></i></a></td>
                                             </tr>
                                             ';endforeach ;echo '                                           </tbody>
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
                                             ';foreach ($items as $item): ;echo '                                             <tr>
                                               <td width="14%;">
                                                 ';echo $item['item_id'];;echo '                                                 <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                                               </td>
                                               <td>';echo $item['item_des'];;echo '</td>
                                               <td>';echo $item['item_code'];;echo '</td>
                                               <td>';echo $item['uom'];;echo '</td>
                                               <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa fa-check"></i></a></td>
                                             </tr>
                                             ';endforeach ;echo '                                           </tbody>
                                         </table>
                                       </div>
                                       <div class="modal-footer">
                                         <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                       </div>
                                     </div>
                                   </div>
                                 </div>
                               </form><!-- end of form -->
                             </div><!-- end of panel-body -->
                           </div><!-- end of panel -->
                         </div><!-- end of col -->
                       </div><!-- end of row -->
                       <div class="row">
                         <div class="col-lg-12">
                           <div class="panel panel-default">
                             <div class="panel-body">
                               <div class="row">
                                 <div class="col-lg-12">                                 
                                   <div class="col-lg-2">
                                     <label>Approved By</label>
                                     <input class=\'form-control\' type=\'text\' list="approved" id=\'approved_list\'>
                                     <datalist id=\'approved\'>
                                         ';foreach ($approved_by as $approved): ;echo '                                             <option value="';echo $approved['approved_by'];;echo '">
                                         ';endforeach ;echo '                                     </datalist>
                             </div> 
                             <div class="col-lg-2">
                                 <label>Prepared By</label>
                                 <input class=\'form-control\' type=\'text\' list="prepared" id=\'prepared_list\'>
                                 <datalist id=\'prepared\'>
                                     ';foreach ($prepared_by as $prepared): ;echo '                                         <option value="';echo $prepared['prepared_by'];;echo '">
                                     ';endforeach ;echo '                                 </datalist>
                             </div>                                       
                                 </div>
                                 <div class="col-lg-6">                 
                                 <!--   -->
                                 </div>
                               </div>            
                               <div class="row">                                                                                    
                                 <div class="col-lg-12">
                                   <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                   <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['productionvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['productionvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['productionvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['productionvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                   <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                   <div class="btn-group">
                                     <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                     <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                       <span class="caret"></span>
                                       <span class="sr-only">Toggle Dropdown</span>
                                     </button>
                                     <ul class="dropdown-menu" role="menu">
                                       <!-- <li ><a href="#" class="btnprintHeader"> Print with header</li> -->
                                       <!-- <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li> -->
                                     </ul>
                                   </div>
                                  <!--  <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a> -->
                                   <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-warning btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
                                 </div>                     
                               </div>
                               <div class="row">
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
                               </div>
                             </div><!-- end of row -->
                           </div>
                         </div>
                       </div>
                     <!-- </div> -->
                   </div><!-- end of level 1-->
                 <!-- </div> -->
               <!-- </div> -->
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
                                  <div class="col-lg-4">
                                     <label class="radio-inline">
                                       <input type="radio" name="optradio" value="consume">Consume
                                     </label>
                                     <label class="radio-inline">
                                       <input type="radio" name="optradio" value="produce">Produce
                                     </label>
                                  </div>
                                  <div class="col-lg-2">
                                      <div class="pull-right">
                                          <a href=\'\' class="btn btn-sm btn-success btnSearch" id="btnSearch" ><i class="fa fa-search"></i> Search</a>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-12">
                                      
                                      <div id="no-more-tables">
                                          <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_tableReport">
                                              <thead class="cf tbl_thead dthead"> 
                                                <!--   <tr>
                                                      <th>Vr#</th>
                                                      <th>Date</th>
                                                      <th class="text-left">Remarks</th>
                                                      <th class="text-left">Item</th>
                                                      <th class="text-left">Sub Phase</th>
                                                      <th class="numeric text-right">Qty</th>
                                                      <th class="numeric text-right">Weight</th>
                                                  </tr> -->
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
                  <div class="partydisp disp">
                      <label style="font-weight:bolder !important;">Employee Detail </label>
                      <div id="employee_p"></div>
                  </div>
              </div>
             <div class="row">
                 <label>Last Rate</label>
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
                     <tfoot>
                         <tr>
                             <td>Total</td>
                             <td class="TotalLrate"></td>
                         </tr>
                     </tfoot>
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

      </div>
    </div>
  ';
?>