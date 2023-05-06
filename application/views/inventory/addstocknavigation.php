

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
                <h1 class="page_title">Stock Transfer Voucher</h1>
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
                                                    <span class="input-group-addon id-addon">Prod#</span>
                                                    <input type="number" class="form-control" id="txtVrnoa" >
                                                    <input type="hidden" id="txtMaxVrnoaHidden">
                                                    <input type="hidden" id="txtVrnoaHidden">
                                                    <input type="hidden" id="voucher_type_hidden">

                                                    <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                                    <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                                    <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Date</span>
                                                    <input class="form-control" type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Vr#</span>
                                                    <input type="text" class="form-control" id="txtVrno" readonly=\'true\'>
                                                    <input type="hidden" id="txtMaxVrnoHidden">
                                                    <input type="hidden" id="txtVrnoHidden">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label>Received By</label>
                                                <input class=\'form-control\' type=\'text\' list="receivers" id=\'receivers_list\'>
                                                <datalist id=\'receivers\'>
                                                    ';foreach ($receivers as $receiver): ;echo '                                                        <option value="';echo $receiver['received_by'];;echo '">
                                                    ';endforeach ;echo '                                                </datalist>
                                            </div>  
                                            <div class="col-lg-6">
                                                <label>Remarks</label>
                                                <input type="text" class="form-control" id="txtRemarks">
                                            </div>
                                        </div>

                                        <div class="row"></div>

                                        <div class="container-wrap">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <label>Item Id</label>
                                                    <select class="form-control select2" id="itemid_dropdown">
                                                        <option value="" disabled="" selected="">Item Id</option>
                                                        ';foreach ($items as $item): ;echo '                                                            <option value="';echo $item['item_id'];;echo '" data-uom="';echo $item['uom'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '">';echo $item['item_id'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label id ="stqty_lbl">Item Description</label>
                                                    <select class="form-control select2" id="item_dropdown">
                                                        <option value="" disabled="" selected="">Item description</option>
                                                        ';foreach ($items as $item): ;echo '                                                            <option value="';echo $item['item_id'];;echo '" data-uom="';echo $item['uom'];;echo '" data-stqty="';echo $item['stqty'];;echo '" data-stweight="';echo $item['stweight'];;echo '">';echo $item['item_des'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Location From</label>
                                                    <select class="form-control select2" id="deptfrom_dropdown">
                                                        <option value="" disabled="" selected="">Location From</option>
                                                        ';foreach ($departments as $department): ;echo '                                                            <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-1" >
                                                    <label>Uom</label>
                                                    <input type="text" class="form-control num" id="txtUOM" readonly="true" tabindex="-1">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>Qty</label>
                                                    <input type="text" class="form-control num" id="txtSQty">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>Weight</label>
                                                    <input type="text" class="form-control num" id="txtWeight">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Location To</label>
                                                    <select class="form-control select2" id="deptto_dropdown">
                                                        <option value="" disabled="" selected="">Location To</option>
                                                        ';foreach ($departments as $department): ;echo '                                                            <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>Add</label>
                                                    <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"></div>
                                        <div class="row"></div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-striped" id="purchase_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr#</th>
                                                            <th>Item Name</th>
                                                            <th>Location From</th>
                                                            <th>UOM</th>
                                                            <th>Qty</th>
                                                            <th>Weight</th>
                                                            <th>Location To</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="saleRows">

                                                    </tbody>
                                                </table>
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
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                    <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['navigationvoucher']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['navigationvoucher']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['navigationvoucher']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['navigationvoucher']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                                    <a class="btn btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                          <span class="caret"></span>
                                                          <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li ><a href="#" class="btnPrint"> Print with header</li>
                                                            <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  <!-- end of col -->
                                        <div class="col-lg-2">
                                            <div class="input-group">
                                                <span class="input-group-addon fancy-addon" >Qty</span>
                                                <input type="text" class="form-control num" id="txtGQty" readonly="true" tabindex="-1">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="input-group">
                                                <span class="input-group-addon fancy-addon" >Weight</span>
                                                <input type="text" class="form-control num" id="txtGWeight" readonly="true" tabindex="-1">
                                            </div>
                                        </div>
                                    </div>  <!-- end of row -->
                                    <div class="row">
                                        <div class="col-lg-3" >
                                            <div class="input-group">
                                                <span class="input-group-addon">User: </span>
                                                <select class="form-control " disabled="" id="user_dropdown">
                                                    <option value="" disabled="" selected="">...</option>
                                                    ';foreach ($userone as $user): ;echo '                                                        <option value="';echo $user['uid'];;echo '">';echo $user['uname'];;echo '</option>
                                                    ';endforeach;;echo '                                                </select>
                                            </div>
                                        </div>
                                    </div>
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