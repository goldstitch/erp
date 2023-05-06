
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

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Recipe Costing</h1>
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
                                                    <input type="number" class="form-control input-sm" id="txtId" >
                                                    <input type="hidden" id="txtMaxIdHidden">
                                                    <input type="hidden" id="txtIdHidden">
                                                    <input type="hidden" id="vouchertypehidden">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">                                                
                                                <label>Finished Item *</label>
                                                <select class="form-control input-sm select2" id="recipe_dropdown">
                                                    <option value="" disabled="" selected="">Choose item</option>
                                                    ';foreach ($items as $item): ;echo '                                                        <option value="';echo $item['item_id'];;echo '">';echo $item['item_des'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
                                                <input type="hidden" class="form-control input-sm" id="txtRecipeHidden">
                                            </div>
                                            <div class="col-lg-3">                                                
                                                <label>Noted By</label>
                                                <input type="text" class="form-control input-sm" id="txtNotedBy">                                                
                                            </div>
                                            <div class="col-lg-5">
                                                <label>Remarks</label>
                                                <input type="text" class="form-control input-sm" id="txtRemarks">
                                            </div>
                                        </div>

                                        <div class="row"></div>

                                        <div class="container-wrap">
                                            <div class="row">
                                                <div class="col-lg-2">                                     
                                                    <label>Code</label>
                                                    <select class="form-control select2" id="itemid_dropdown">
                                                        <option value="" disabled="" selected="">Item Id</option>
                                                        ';foreach ($items as $item): ;echo '                                                            <option value="';echo $item['item_id'];;echo '" data-grweight="';echo $item['grweight'];;echo '" data-uom="';echo $item['uom'];;echo '">';echo $item['item_id'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-3" >
                                                    <label>Item*</label>
                                                    <select class="form-control select2" id="item_dropdown">
                                                        <option value="" disabled="" selected="">Item description</option>
                                                        ';foreach ($items as $item): ;echo '                                                            <option value="';echo $item['item_id'];;echo '" data-grweight="';echo $item['grweight'];;echo '"  data-uom="';echo $item['uom'];;echo '">';echo $item['item_des'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>Uom</label>
                                                    <input type="text" class="form-control input-sm" id="txtUom" readonly="" tabindex="-1">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>Qty</label>                                                    
                                                    <input type="text" class="form-control input-sm num" id="txtQty">                                                    
                                                </div>
                                                 <div class="col-lg-1">
                                                    <label>GW</label>                                                    
                                                    <input type="text" class="form-control input-sm readonly num" id="txtGWeight" readonly="" tabindex="-1">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>Weight</label>
                                                    <input type="text" class="form-control input-sm num" id="txtWeight">
                                                </div>
                                                <div class="col-lg-1" >
                                                    <label>Add</label>
                                                    <a href="" class="btn btn-sm btn-primary" id="btnAdd">+</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"></div>
                                        <div class="row"></div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-striped" id="recipe_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr#</th>
                                                            <th>Item Detail</th>
                                                            <th>Uom</th>
                                                            <th>Qty</th>
                                                            <th>Weight</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </form> <!-- end of form -->

                                </div>  <!-- end of panel-body -->
                            </div>  <!-- end of panel -->
                        </div>  <!-- end of col -->
                    </div>  <!-- end of row -->
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
                <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa-li fa fa-check-square"></i></a></td>
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
                <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa-li fa fa-check-square"></i></a></td>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    
                                    <div class="row">
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-2">                                                    
                                            <label>Total Qty</label>
                                            <input type="text" class="form-control input-sm num" id="txtTotalQty">                                                    
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Total Weight</label>
                                            <input type="text" class="form-control input-sm num" id="txtTotalWeight">
                                        </div>
                                        <!-- <div class="col-lg-4"></div> -->
                                        <div class="col-lg-2">
                                            <label>Finished Qty</label>
                                            <input type="text" class="form-control input-sm num" id="txtFQty">
                                        </div>
                                        <div class="col-lg-2">
                                            <label>Finished Weight</label>
                                            <input type="text" class="form-control input-sm num" id="txtFWeight">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <!-- <div class="row"></div>
                                            <div class="row"></div>
                                            <div class="row"></div>
                                            <div class="row"></div> -->
                                            <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                            <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['recipee']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['recipee']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['recipee']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['recipee']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                            <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                            <a class="btn btn-sm btn-default btnPrint"><i class="fa fa-print"></i> Delete F9</a>
                                            <!-- <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a> -->
                                            <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
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