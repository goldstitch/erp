

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Order Parts Detail</h1>
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
                                                    <span class="input-group-addon id-addon">OPD#</span>
                                                    <input type="number" class="form-control" id="txtVrnoa" >
                                                    <input type="hidden" id="txtMaxVrnoaHidden">
                                                    <input type="hidden" id="txtVrnoaHidden">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Vr#</span>
                                                    <input type="text" class="form-control" id="txtVrno" readonly=\'true\'>
                                                    <input type="hidden" id="txtMaxVrnoHidden">
                                                    <input type="hidden" id="txtVrnoHidden">
                                                </div>
                                            </div>
                                            <div class="col-lg-1"></div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Date</span>
                                                     ';if ($vouchers['date_close']['insert'] == 1){;echo '                                                        <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" >
                                                    ';}else{;echo '                                                        <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '" readonly="">
                                                    ';};echo '                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Party Name</span>
                                                    <select class="form-control" id="party_dropdown">
                                                        <option value="" disabled="" selected="">Choose party</option>
                                                        ';foreach ($parties as $party): ;echo '                                                            <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Warehouse</span>
                                                    <select class="form-control select2" id="dept_dropdown">
                                                        <option value="" selected="" disabled="">Choose Warehouse</option>
                                                        ';foreach ($departments as $department): ;echo '                                                            <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Remarks</span>
                                                    <input type="text" class="form-control" id="txtRemarks">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"></div>

                                        <div class="container-wrap">
                                            <div class="row">
                                                <div class="col-lg-2" style=\'margin-top: 21px;\'>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'><span class="fa fa-barcode"></span></span>
                                                        <select class="form-control select2" id="itemid_dropdown">
                                                            <option value="" disabled="" selected="">Item Id</option>
                                                            ';foreach ($items as $item): ;echo '                                                                <option value="';echo $item['item_id'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '">';echo $item['item_id'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3" style=\'margin-top: 21px;\'>
                                                    <select class="form-control select2" id="item_dropdown">
                                                        <option value="" disabled="" selected="">Item description</option>
                                                        ';foreach ($items as $item): ;echo '                                                            <option value="';echo $item['item_id'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '">';echo $item['item_des'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Qty</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control num" id="txtQty">
                                                    </div>
                                                </div>
                                                 <div class="col-lg-1">
                                                    <label for="">GW</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control readonly num" id="txtGWeight" readonly="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Weight</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control num" id="txtWeight">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Rate</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control num" id="txtPRate">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="">Amount</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control readonly num" id="txtAmount" readonly="true">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1" style=\'margin-top: 21px;\'>
                                                    <div class="input-group">
                                                        <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                                    </div>
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
                                                            <th>Item Detail</th>
                                                            <th>Qty</th>
                                                            <th>Weight</th>
                                                            <th>Rate</th>
                                                            <th>Amount</th>
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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="row"></div>
                                            <div class="row"></div>
                                            <div class="row"></div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
                                                    <a class="btn btn-primary btnSave"><i class="fa fa-save"></i> Save Changes</a>
                                                    <a class="btn btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete</a>
                                                    <!-- <a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print</a> -->
                                                </div>
                                            </div>
                                        </div>  <!-- end of col -->

                                        <div class="col-lg-7">
                                            <div class="row">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-3">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width:0px;\'>Total Qty</span>
                                                        <input type="text" class="form-control readonly num" id="txtTotalQty" readonly="true">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width:0px;\'>Total Amount</span>
                                                        <input type="text" class="form-control readonly num" id="txtTotalAmount" readonly="true" style=\'width: 164px;\'>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Discount%</span>
                                                        <input class=" form-control" style=\'min-width: 0px;width: 180px;\' id="txtDiscount">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Net Amount</span>
                                                        <input type="text" class="form-control readonly num" id=\'txtNetAmount\'>
                                                    </div>
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