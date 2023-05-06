

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
                       ';foreach ($l3s as $l3): ;echo '                         <option value="';echo $l3['l3'];;echo '" data-level2="';echo $l3['level2_name'];;echo '" data-level1="';echo $l3['level1_name'];;echo '">';echo $l3['level3_name'] ;echo '</option>
                      ';endforeach ;echo '                   </select>
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
                    ';foreach ($categories as $category): ;echo '                      <option value="';echo $category['catid'];;echo '">';echo $category['name'];;echo '</option>
                   ';endforeach ;echo '                </select>
             </div>
             <div class="col-lg-6">
               <label>Sub Catgeory</label>
               <select class="form-control input-sm select2" id="subcategory_dropdown" tabindex="3">
                 <option value="" disabled="" selected="">Choose sub category</option>
                 ';foreach ($subcategories as $subcategory): ;echo '                   <option value="';echo $subcategory['subcatid'];;echo '">';echo $subcategory['name'];;echo '</option>
                ';endforeach ;echo '             </select>
          </div>
       </div>    
       <div class="row">
          <div class="col-lg-6">
            <label>Brand</label>
            <select class="form-control input-sm select2" id="brand_dropdown" tabindex="4">
              <option value="" disabled="" selected="">Choose brand</option>
              ';foreach ($brands as $brand): ;echo '                <option value="';echo $brand['bid'];;echo '">';echo $brand['name'];;echo '</option>
             ';endforeach ;echo '          </select>
       </div>
       <div class="col-lg-6">
         <label>Type</label>
         <input type="text" list=\'type\' class="form-control input-sm" id="txtBarcode" tabindex="5" />
         <datalist id=\'type\'>
           ';foreach ($types as $type): ;echo '             <option value="';echo $type['barcode'];;echo '">
             ';endforeach ;echo '          </datalist>
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
           ';foreach ($uoms as $uom): ;echo '             ';if ($uom['uom'] !== ''): ;echo '               <option value="';echo $uom['uom'];;echo '">
               ';endif ;echo '            ';endforeach ;echo '         </datalist>
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
   <a class="btn btn-success btnSaveMItem btn-sm" data-insertbtn="1" tabindex="9"><i class="fa fa-save"></i> Save</a>
   <a class="btn btn-warning btnResetMItem btn-sm" tabindex="10"><i class="fa fa-refresh"></i> Reset</a>
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
             ';foreach ($parties as $party): ;echo '                <tr>
                   <td >
                      ';echo $party['pid'];;echo '                      <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                   </td>
                   <td>';echo $party['name'];;echo '</td>
                   <td>';echo $party['level3_name'];;echo '</td>
                   <td>';echo $party['mobile'];;echo '</td>
                   <td>';echo $party['address'];;echo '</td>
                   <!-- <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa-li fa fa-check-square"></i></a></td> -->
                   <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa-li fa fa-check-square"></i></a></td>
                </tr>
             ';endforeach ;echo '          </tbody>
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
                      ';echo $item['item_id'];;echo '                      <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                   </td>
                   <td>';echo $item['artcile_no'];;echo '</td>
                   <td>';echo $item['item_des'];;echo '</td>
                   <td>';echo $item['item_code'];;echo '</td>
                   <td>';echo $item['uom'];;echo '</td>
                   <!-- <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa-li fa fa-check-square"></i></a></td> -->
                   <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa-li fa fa-check-square"></i></a></td>
                </tr>
             ';endforeach ;echo '          </tbody>
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
     <h1 class="page_title">Sale Order Voucher</h1>
  </div>
  <div class="col-lg-8">
     <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
     <a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['saleordervoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['saleordervoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['saleordervoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['saleordervoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
     <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>

     <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
         <span class="caret"></span>
         <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu">
         <li ><a href="#" class="btnPrintPerformaHeader">Performa </li>
      </ul>
   </div>
   <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
   <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-info btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
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
                      <span class="VoucherNoLable">Order#</span>
                      <input type="number" class="form-control input-sm VoucherNo" id="txtVrnoa" >
                      <input type="hidden" id="txtMaxVrnoaHidden">
                      <input type="hidden" id="txtVrnoaHidden">
                      <input type="hidden" id="voucher_type_hidden">
                      <input type="hidden" id="voucher_bulk_hidden">


                      <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                      <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                      <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                      <input type="hidden" name="search_item_cus" id="search_item_cus" value="">
                      <!-- Print Table Headings -->
                      <input type="hidden" name="tblprintArticleNo" id="tblprintArticleNo" value="آرٹیکل">
                      <input type="hidden" name="tblprintDescription" id="tblprintDescription" value="گلو سٹا ئل">
                      <input type="hidden" name="tblprintLabel" id="tblprintLabel" value="لیبل">
                      <input type="hidden" name="tblprintTDozen" id="tblprintTDozen" value="کل  د ر جن">
                      <input type="hidden" name="tblprintParchi" id="tblprintParchi" value="پرچئ">
                      <input type="hidden" name="tblprinTCarton" id="tblprinTCarton" value="کل کا ر ٹو ن  ">
                      <input type="hidden" name="tblprinTSrNumber" id="tblprinTSrNumber" value="نمبر شمار">
                      <!-- End Print Table Headings -->
                                                                        <!-- <input type="hidden" id="purchaseid" value="';echo $setting_configur[0]['purchase'];;echo '">
                                                                        <input type="hidden" id="discountid" value="';echo $setting_configur[0]['discount'];;echo '">
                                                                        <input type="hidden" id="expenseid" value="';echo $setting_configur[0]['expenses'];;echo '">
                                                                        <input type="hidden" id="taxid" value="';echo $setting_configur[0]['tax'];;echo '">
                                                                        <input type="hidden" id="cashid" value="';echo $setting_configur[0]['cash'];;echo '"> -->

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
                                                                   <div class="col-lg-2">
                                                                      <!-- <div class="input-group"> -->
                                                                      <span class="">Date</span>
                                                                      ';if ($vouchers['date_close']['insert'] == 1){;echo '                                                                      <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                                                                      ';}else{;echo '                                                                      <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" readonly="">
                                                                      ';};echo '                                                                      <!-- </div> -->
                                                                   </div>
                                                                   <div class="col-lg-2">
                                                                      <!-- <div class="input-group"> -->
                                                                      <span class="">Shipment Date</span>
                                                                      <input class="form-control input-sm" type="date" id="due_date" value="';echo date('Y-m-d');;echo '">                                                
                                                                      <!-- </div> -->
                                                                   </div>
                                                                   <div class="col-lg-2">                                                
                                                                      <span>Order</span>
                                                                      <select class="form-control" id="status_list" >
                                                                       <option value="New"> New </option>
                                                                       <option value="Running"> Running </option>
                                                                       <option value="Delivered"> Delivered </option>
                                                                       <option value="Cancel"> Cancel </option>
                                                                    </select>                                                
                                                                 </div>

                                                                 <div class="col-lg-2 hide">
                                                                   <div class="form-group">
                                                                     <span class="">Order Status</span>
                                                                     <div class="input-group">
                                                                      <!-- <span class="switch-addon input-group-addon">Order Status</span> -->
                                                                      <input type="checkbox" checked="" name="switchActive" class="bs_switch" id="switchActive">
                                                                   </div>
                                                                </div>
                                                             </div>
                                                          </div>

                                                          <div class="row">

                                                           <div class="col-lg-2 hide">                                                
                                                              <label>Type</label>
                                                              <select class="form-control input-sm  select2" id="pType_dropdown">
                                                                <option value="" disabled="" selected="">Choose Type</option>
                                                                ';foreach ($typess as $types): ;echo '                                                                  <option value="';echo $types['etype'];;echo '">';echo $types['etype'];;echo '</option>
                                                               ';endforeach ;echo '                                                            </select>                                               
                                                         </div>

                                                         <div class="col-lg-4">
                                                          <div class="form-group">
                                                            <label>Party Name</label>
                                                            <div class="input-group" >
                                                              <select class="form-control select2" id="party_dropdown" >
                                                                <option value="" disabled="" selected="">Choose party</option>
                                                                ';foreach ($parties as $party): ;echo '                                                                  <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                               ';endforeach ;echo '                                                            </select>
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
                                                         ';foreach ($departments as $department): ;echo '                                                           <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                     </select>
                                                     <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="A2" data-target="#GodownAddModel" data-toggle="modal" href="#addCategory" rel="tooltip"
                                                     data-placement="top" data-original-title="Add Department" data-toggle="tooltip" data-placement="bottom" title="Add New Department Quick">+</a>
                                                  </div>                            
                                               </div>


                                               <div class="col-lg-2">
                                                <label for="">-</label>                    

                                                <a href="#bulkitem-lookup" data-toggle="modal" class="btn btn-sm btn-default btnBulkItemsSearch "><i class="fa fa-search"></i>Get Bulk Items</a>

                                             </div>


                                             <label style="visibility: hidden;"  >Warehouse</label>

                                             <input type="button" class="btn btn-primary others" value="Others">
                                             <div id="toggleDemo" class="col-lg-12 collapse" style="background-color: aliceblue;padding-bottom: 9px;">
                                                <div class="col-lg-2">                                                
                                                  <label>Authorized By</label>
                                                  <input class=\'form-control input-sm \' type=\'text\' list="receivers" id=\'receivers_list\'>
                                                  <datalist id=\'receivers\'>
                                                    ';foreach ($receivers as $receiver): ;echo '                                                      <option value="';echo $receiver['received_by'];;echo '">
                                                      ';endforeach ;echo '                                                   </datalist>                                                
                                                </div>                                    

                                                <div class="col-lg-2">                                                
                                                  <label>Through</label>
                                                  <select class="form-control input-sm  select2" id="transporter_dropdown">
                                                    <option value="" disabled="" selected="">Choose transporter</option>
                                                    ';foreach ($transporters as $transporter): ;echo '                                                      <option value="';echo $transporter['transporter_id'];;echo '">';echo $transporter['name'];;echo '</option>
                                                   ';endforeach ;echo '                                                </select>                                               
                                             </div>
                                             <div class="col-lg-2">                                                
                                               <label>Shippment From</label>
                                               <input class=\'form-control input-sm \' type=\'text\' list="ShipmentFrom" id=\'txtShipmentFrom\'>
                                               <datalist id=\'ShipmentFrom\'>
                                                 ';foreach ($shippmentFroms as $shippmentFrom): ;echo '                                                   <option value="';echo $shippmentFrom['shippment_from'];;echo '">
                                                   ';endforeach ;echo '                                                </datalist>                                                
                                             </div> 
                                             <div class="col-lg-2">                                                
                                               <label>Shippment To </label>
                                               <input class=\'form-control input-sm \' type=\'text\' list="ShipmentTo" id=\'txtShipmentTo\'>
                                               <datalist id=\'ShipmentTo\'>
                                                 ';foreach ($shippmentTos as $shippmentTo): ;echo '                                                   <option value="';echo $shippmentTo['shippment_to'];;echo '">
                                                   ';endforeach ;echo '                                                </datalist>                                                
                                             </div>  
                                             <div class="col-lg-2">                                                
                                               <label>CPO#</label>
                                               <input class=\'form-control input-sm\' type=\'text\'  id=\'txtCPONo\'>
                                            </div> 
                                            <div class="col-lg-2">                                                
                                               <label>Tax Status</label>
                                               <input class=\'form-control input-sm \' type=\'text\' list="TaxStatus" id=\'txtTaxStatus\'>
                                               <datalist id=\'TaxStatus\'>
                                                 ';foreach ($tax_statuss as $tax_status): ;echo '                                                   <option value="';echo $tax_status['tax_status'];;echo '">
                                                   ';endforeach ;echo '                                                </datalist>                                                
                                             </div> 
                                             <div class="col-lg-2">                                                
                                               <label>Salesman</label>
                                               <select class="form-control input-sm  select2" id="salesman_dropdown">
                                                 <option value="" disabled="" selected="">Choose Salesman</option>
                                                 ';foreach ($salesmen as $salesmen): ;echo '                                                   <option value="';echo $salesmen['officer_id'];;echo '">';echo $salesmen['name'];;echo '</option>
                                                ';endforeach ;echo '                                             </select>                                               
                                          </div>
                                          <div class="col-lg-2">                                            
                                            <label>Exp Reg#</label>
                                            <!-- <input type="text" class="form-control input-sm " id="txtExportRegistrationNo"> -->
                                            <input class=\'form-control input-sm \' type=\'text\' list="expreg" id=\'txtExportRegistrationNo\'>
                                            <datalist id=\'expreg\'>
                                              ';foreach ($expregs as $expreg): ;echo '                                                <option value="';echo $expreg['export_register_no'];;echo '">
                                                ';endforeach ;echo '                                             </datalist>                                                                                                                                                                                
                                          </div> 
                                          <div class="col-lg-2">                                                
                                            <label>Currencey</label>
                                            <select class="form-control input-sm  select2" id="currency_dropdown">
                                              <option value="" disabled="" selected="">Choose Currencey</option>
                                              ';foreach ($currenceys as $currencey): ;echo '                                                <option value="';echo $currencey['id'];;echo '">';echo $currencey['name'];;echo '</option>
                                             ';endforeach ;echo '                                          </select>                                               
                                       </div>
                                       <div class="col-lg-2">                                                
                                         <label>Exch Rate</label>
                                         <input class=\'form-control input-sm num\' type=\'text\'  id=\'txtExchangeRate\'>
                                      </div>
                                      <div class="col-lg-3">                                            
                                         <input type="hidden" class="form-control input-sm " id="txtOrderNo">
                                         <label>Remarks</label>
                                         <input type="text" class="form-control input-sm " id="txtRemarks">                                                                                                                                                                             
                                      </div>
                                   </div>
                                </div>    


                                <div class="row">
                                   <div class="col-lg-12">                        
                                     <div class="tab-content">
                                       <div class="tab-pane active fade in" id="itemadd">
                                         <div class="container-wrap">
                                           <div class="row">
                                             <div class="col-lg-2" >
                                               <label for="">Cus Art#</label>
                                               <select class="form-control select2" id="itemid_dropdown_cus">
                                                 <option value="" disabled="" selected="">Item Id</option>
                                                 ';foreach ($items as $item): ;echo '                                                   <option value="';echo $item['item_id'];;echo '" data-size="';echo $item['size'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-srate="';echo $item['srate'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '">';echo $item['artcile_no'];;echo '</option>
                                                ';endforeach ;echo '                                             </select>
                                          </div>
                                          <div class="col-lg-4" >
                                            <label for="" id="item_cus">Cus Item</label>
                                            <div class="input-group" >
                                               <select class="form-control select2" id="item_dropdown_cus">
                                                 <option value="" disabled="" selected="">Item description</option>
                                                 ';foreach ($items as $item): ;echo '                                                   <option value="';echo $item['item_id'];;echo '" data-size="';echo $item['size'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-srate="';echo $item['srate'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_des'];;echo '</option>
                                                ';endforeach ;echo '                                             </select>
                                             <a  tabindex="-1" class="input-group-addon btn btn-primary active" style="min-width:40px !important;" id="item_lookup_cus" data-target=""  data-toggle="modal" href="" rel="tooltip"
                                             data-placement="top" data-original-title="Search Order" data-toggle="tooltip" data-placement="bottom" title=""><i class="fa fa-search"></i></a>
                                          </div>
                                       </div>
                                       <div class="col-lg-2">
                                         <label for="">Article#</label>
                                         <select class="form-control select2" id="itemid_dropdown">
                                           <option value="" disabled="" selected="">Item Id</option>
                                           ';foreach ($items as $item): ;echo '                                             <option value="';echo $item['item_id'];;echo '" data-size="';echo $item['size'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-srate="';echo $item['srate'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '">';echo $item['artcile_no'];;echo '</option>
                                          ';endforeach ;echo '                                       </select>
                                    </div>
                                    <div class="col-lg-4" >
                                      <label for="" id="item_des">Item</label>
                                      <select class="form-control select2" id="item_dropdown">
                                        <option value="" disabled="" selected="">Item description</option>
                                        ';foreach ($items as $item): ;echo '                                          <option value="';echo $item['item_id'];;echo '" data-size="';echo $item['size'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-srate="';echo $item['srate'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '" >';echo $item['item_des'];;echo '</option>
                                       ';endforeach ;echo '                                    </select>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-lg-1">
                                   <label for="">Ctn</label>                                                    
                                   <input type="text" class="form-control num" id="txtCottonQty">                                                    
                                </div>
                                <div class="col-lg-1">
                                   <label for="">Dozen</label>                                                    
                                   <input type="text" class="form-control num" id="txtDozenQty">                                                    
                                </div>
                                <div class="col-lg-2">
                                   <label for="">Qty</label>                                                    
                                   <input type="text" class="form-control num" id="txtQty">                                                    
                                </div>
                                <div class="col-lg-1 hide">
                                   <label for="">GW</label>                                                    
                                   <input type="text" class="form-control readonly num" id="txtGWeight" readonly="" tabindex="-1">                                                    
                                </div>
                                <div class="col-lg-1 hide">
                                   <label for="">Uom</label>                                                    
                                   <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                </div>

                                <div class="col-lg-2">
                                   <label for="">Weight</label>                                                    
                                   <input type="text" class="form-control num" id="txtWeight">                                                    
                                </div>
                                <div class="col-lg-1">
                                   <label for="">FRate</label>                                                    
                                   <input type="text" class="form-control num" id="txtFRate">
                                </div>
                                <div class="col-lg-2">
                                   <label for="">LRate</label>                                                    
                                   <input type="text" class="form-control num" id="txtPRate">                                                    
                                </div>
                                <div class="col-lg-2">
                                   <label for="">Amount</label>                                                    
                                   <input type="text" class="form-control readonly num" id="txtAmount" readonly="true" tabindex="-1">                                                    
                                </div>
                                <div class="col-lg-1">
                                   <label for="">Add</label>                                                   
                                   <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                </div>
                             </div>
                             <div class="row hide">    
                              <div class="col-lg-2">
                                <div class="form-group">
                                  <label for="">Label</label>
                                  <input type="checkbox" checked="" class="bs_switch" id="switchLabel">
                               </div>
                            </div>

                            <div class="col-lg-3">
                             <label for="">Parchi</label>                                                    
                             <input type="text" class="form-control" id="txtParchi" >                                                    
                          </div>

                       </div>

                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div id="no-more-tables">
                           <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table">
                             <thead>
                               <tr>
                                 <th class="numeric text-right">Sr#</th>
                                 <th >Cus Art#</th>
                                 <th >Cus Item Detail</th>
                                 <th >Article#</th>
                                 <th >Item Detail</th>
                                 <th class="numeric text-right">Ctn</th>
                                 <th class="numeric text-right">Dozen</th>
                                 <th class="numeric text-right">Qty</th>
                                 <th class="numeric text-right">Weight</th>
                                 <th class="numeric text-right">FRate</th>
                                 <th class="numeric text-right">LRate</th>
                                 <th class="numeric text-right">Amount</th>
                                 <th class="numeric text-right">FAmount</th>

                                 <th class="hide">Label</th>
                                 <th class="hide">Parchi</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>

                           </tbody>
                           <tfoot class="tfoot_tbl">
                            <tr>
                              <td data-title="" class="text-right numeric" colspan="5">Totals</td>
                              <td data-title="CTN" class="text-right numeric txtTotalCtn"></td>
                              <td data-title="Dozen" class="text-right numeric txtTotalDzn"></td>
                              
                              <td data-title="Qty" class="text-right numeric txtTotalQty"></td>
                              <td data-title="Weight" class="text-right numeric txtTotalWeight"></td>
                              <td data-title="Frate" class="text-right numeric txtTotalFRate1"></td>
                              <td data-title="" class="text-right numeric txtTotalRate"></td>
                              <td data-title="Amount" class="text-right numeric txtTotalAmount"></td>
                              <td data-title="FAmount" class="text-right numeric txtTotalFRate"></td>

                              <td><a href=\'\' class=\'btn btn-primary btnRefreshTotal\'><span class=\'fa fa-refresh\'></span></a> </td>
                              
                              
                           </tr>
                        </tfoot>

                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="tab-pane fade" id="itemless">
           <div class="container-wrap">
             <div class="row">
               <div class="col-lg-2" >
                 <label for="">Item Id</label>
                 <div class="input-group">

                   <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span>
                   <select class="form-control select2" id="less_itemid_dropdown">
                     <option value="" disabled="" selected="">Item Id</option>
                     ';foreach ($items as $item): ;echo '                       <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '">';echo $item['item_id'];;echo '</option>
                    ';endforeach ;echo '                 </select>
              </div>
           </div>
           <div class="col-lg-3" >
              <label for="">Item Description</label>
              <div class="input-group" >
                 <select class="form-control select2" id="less_item_dropdown">
                   <option value="" disabled="" selected="">Item description</option>
                   ';foreach ($items as $item): ;echo '                     <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '">';echo $item['item_des'];;echo '</option>
                  ';endforeach ;echo '               </select>
               <a class="input-group-addon btn btn-primary active"   tabindex="-1" style="min-width:40px !important;" id="less_A3" data-target="#ItemAddModel" data-toggle="modal" href="#addItem" rel="tooltip"
               data-placement="top" data-original-title="Add Item" data-toggle="tooltip" data-placement="bottom" title="Add New Account Quick (F3)">+</a>
            </div>
         </div>
         <div class="col-lg-1">
           <label for="">Qty</label>                                                    
           <input type="text" class="form-control num" id="less_txtQty">                                                    
        </div>
        <div class="col-lg-1">
           <label for="">GW</label>                                                    
           <input type="text" class="form-control readonly num" id="less_txtGWeight" readonly="" tabindex="-1">                                                    
        </div>
        <div class="col-lg-1">
           <label for="">Uom</label>                                                    
           <input type="text" class="form-control readonly num" id="less_txtUom" readonly="" tabindex="-1">                                                    
        </div>
        <div class="col-lg-2">
           <label for="">Weight</label>                                                    
           <input type="text" class="form-control num" id="less_txtWeight">                                                    
        </div>
        <div class="col-lg-1">
           <label for="">Rate</label>                                                    
           <input type="text" class="form-control num" id="less_txtPRate">                                                    
        </div>
        <div class="col-lg-1">
           <label for="">Amount</label>                                                    
           <input type="text" class="form-control readonly num" id="less_txtAmount" readonly="true" tabindex="-1">                                                    
        </div>
        <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
           <a href="" class="btn btn-primary" id="less_btnAdd">+</a>
        </div>                                                
     </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div id="no-more-tables">
         <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table_less">
           <thead class="cf">
             <tr>
               <th class="numeric">Sr#</th>
               <th >Item Detail</th>
               <th class="numeric">Cotton Qty</th>
               <th class="numeric">Dozen Qty</th>
               <th class="numeric">Qty</th>
               <th class="numeric">Weight</th>
               <th class="numeric">Rate</th>
               <th class="numeric">Amount</th>
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
                                                                          </div>
                                                                       </div>
                                                                    </div>
                                                                 </div>
                                                                 <!-- <div class="row"></div> -->
                                                                 <!-- <div class="row"></div> -->





                                                              </form> <!-- end of form -->

                                                           </div>  <!-- end of panel-body -->
                                                        </div>  <!-- end of panel -->
                                                     </div>  <!-- end of col -->
                                                  </div>  <!-- end of row -->

                                                  <div class="row">
                                                    <div class="col-lg-12">
                                                      <div class="panel panel-default">
                                                        <div class="panel-body">
                                                          <!-- <div class="row">                                     -->
                                                           <!--  <div class="col-lg-3">                                                    
                                                                <label>Total Weight</label>
                                                                <input type="text" class="form-control readonly num" id="txtTotalWeight" readonly="true" tabindex="-1">
                                                            </div>                                                
                                                            <div class="col-lg-3">                                                    
                                                                <label>Total Qty</label>
                                                                <input type="text" class="form-control readonly num" id="txtTotalQty" readonly="true" tabindex="-1">
                                                            </div>                                                
                                                            <div class="col-lg-3">                                                    
                                                                <label>Total Amount</label>
                                                                <input type="text" class="form-control readonly num" id="txtTotalAmount" readonly="true" tabindex="-1">
                                                             </div> -->

                                                             <!-- </div> -->
                                                             <div class="row">                                           
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
                                                                 <!-- input type="text" class="form-control readonly num" id="txtUom" >                                                     -->
                                                              </div>

                                                           </div>
                                                           <div class="row">
                                                            <div class="col-lg-3">
                                                              <label>Delivery Term</label>
                                                              <input type="text" list=\'DeliveryTerms\' class=\'form-control\'  id=\'txtDeliveryTerm\'>
                                                              <datalist id=\'DeliveryTerms\'>
                                                                ';foreach ($DeliveryTerms as $DeliveryTerm): ;echo '                                                                  <option value="';echo $DeliveryTerm['delivery_term'];;echo '">
                                                                  ';endforeach ;echo '                                                               </datalist>
                                                               <!-- <input type="text" class="form-control" id=\'txtDeliveryTerm\'> -->
                                                            </div>
                                                            <div class="col-lg-3">
                                                              <label>Payment Term</label>
                                                              <input type="text" list=\'PaymentTerms\' class=\'form-control\'  id=\'txtPaymentTerm\'>
                                                              <datalist id=\'PaymentTerms\'>
                                                                ';foreach ($PaymentTerms as $PaymentTerm): ;echo '                                                                  <option value="';echo $PaymentTerm['payment_term'];;echo '">
                                                                  ';endforeach ;echo '                                                               </datalist>
                                                               <!-- <input type="text" class="form-control" id=\'txtPaymentTerm\'> -->
                                                            </div>
                                                            <div class="col-lg-3">                                                    
                                                              <label>Advance Amount</label>
                                                              <input type="text" class="form-control num" id="txtPaid">
                                                           </div> 
                                                        </div>
                                                        <div class="row">                                                                                    
                                                           <div class="col-lg-12">
                                                             <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                             <a class="btn btn-sm btn-default btnSave" data-savegodownbtn=\'';echo $vouchers['warehouse']['insert'];;echo '\' data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['saleordervoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['saleordervoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['saleordervoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['saleordervoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                                             <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>

                                                             <div class="btn-group">
                                                                <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                 <span class="caret"></span>
                                                                 <span class="sr-only">Toggle Dropdown</span>
                                                              </button>
                                                              <ul class="dropdown-menu" role="menu">
                                                                 <li ><a href="#" class="btnPrintPerformaHeader">Performa </li>
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
                                                        ';foreach ($userone as $user): ;echo '                                                          <option value="';echo $user['uid'];;echo '">';echo $user['uname'];;echo '</option>
                                                       ';endforeach;;echo '                                                    </select>
                                                 </div>
                                              </div>                                             
                                           </div>
                                        </div>  <!-- end of row -->
                                     </div>
                                  </div>
                               </div>
                            </div>
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
                        </div>
                     </div>  <!-- end of level 1-->
                  </div>
               </div>
            </div>
         </div>

         <div id="bulkitem-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background:#64b92a !important; color:white !important;padding-bottom:20px !important;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 id="myModalLabel">Select Items Lookup</h3>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                          <label >Catogeory</label>                    
                          <select  class="form-control input-sm select2" multiple="true" id="drpCatogeoryid" data-placeholder="Choose Category....">

                          </select>           
                      </div>
                      <div class="col-lg-6">
                        <label >Sub Catogeory</label>                    
                        <select  class="form-control input-sm select2" multiple="true" id="drpSubCat" data-placeholder="Choose SubCategory....">
                        </select>    
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-3" >
                        <label >Brand</label>        
                        <select  class="form-control input-sm select2 " multiple="true" id="drpbrandID" data-placeholder="Choose Brand....">
                        </select>
                    </div>

                    <div class="col-lg-3" >
                        <label >Article</label>        
                        <select  class="form-control input-sm select2 " multiple="true" id="DrpArticles" data-placeholder="Choose Article....">
                        </select>
                    </div>

                    

                    <div class="col-lg-3" >
                        <label >Gender</label>                    
                        <select  class="form-control input-sm select2" multiple="true" id="drpColor" data-placeholder="Choose Gender....">
                        </select>   
                    </div>
                    <div class="col-lg-3" >
                      <label >PO#</label>                    
                      <select  class="form-control input-sm select2" multiple="true" id="drpSize" data-placeholder="Choose PO#....">
                      </select>   
                  </div>
              </div>

          </div>
          <div class="modal-footer">

            <button class="btn btn-primary btnGetItemsModel" data-get="modal">Show</button>
            <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</div>
</div>';
?>