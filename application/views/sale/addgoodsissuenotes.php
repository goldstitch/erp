
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
                <h1 class="page_title">Goods Issue Notes Voucher</h1>
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
                                                    <input type="text" class="form-control" id="txtVrnoa" >
                                                    <input type="hidden" id="txtMaxVrnoaHidden">
                                                    <input type="hidden" id="txtVrnoaHidden">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
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

                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Party Name</span>
                                                    <select class="form-control select2" id="party_dropdown">
                                                        <option value="" disabled="" selected="">Choose party</option>
                                                        ';foreach ($parties as $party): ;echo '                                                            <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">C/O</span>
                                                    <select class="form-control select2" id="coparty_dropdown">
                                                        <option value="" disabled="" selected="">Choose party</option>
                                                        ';foreach ($parties as $party): ;echo '                                                            <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Received By</span>
                                                    <input class=\'form-control\' type=\'text\' list="receivers" id=\'receivers_list\'>
                                                    <datalist id=\'receivers\'>
                                                        ';foreach ($receivers as $receiver): ;echo '                                                            <option value="';echo $receiver['received_by'];;echo '">
                                                        ';endforeach ;echo '                                                    </datalist>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Transporter</span>
                                                    <select class="form-control" id="transporter_dropdown">
                                                        <option value="" disabled="" selected="">Choose transporter</option>
                                                        ';foreach ($transporters as $transporter): ;echo '                                                            <option value="';echo $transporter['transporter_id'];;echo '">';echo $transporter['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Bilty#</span>
                                                    <input type="text" class="form-control num" id="txtBiltyNo">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Bilty Date</span>
                                                    <input class="form-control ts_datepicker" type="text" id="bilty_date">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Remarks</span>
                                                    <input type="text" class="form-control" id="txtRemarks">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">SO#</span>
                                                    <input type="text" class="form-control" id="txtSONo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"></div>

                                        <div class="container-wrap">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div class="input-group">
                                                        <select class="form-control select2" id="itemid_dropdown">
                                                            <option value="" disabled="" selected="">Item Id</option>
                                                            ';foreach ($items as $item): ;echo '                                                                <option value="';echo $item['item_id'];;echo '" data-prate="';echo $item['cost_price'];;echo '">';echo $item['item_id'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="form-control select2" id="item_dropdown">
                                                        <option value="" disabled="" selected="">Item description</option>
                                                        ';foreach ($items as $item): ;echo '                                                            <option value="';echo $item['item_id'];;echo '" data-prate="';echo $item['cost_price'];;echo '">';echo $item['item_des'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <select class="form-control select2" id="dept_dropdown">
                                                        <option value="" disabled="" selected="">Location</option>
                                                        ';foreach ($departments as $department): ;echo '                                                            <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-2" style=\'width: 13%;\'>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'>Qty</span>
                                                        <input type="text" class="form-control num" id="txtQtyApp">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2" style=\'width: 12%;\'>
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'>@</span>
                                                        <input type="text" class="form-control num" id="txtPrate">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'>Amount</span>
                                                        <input type="text" class="form-control num" id="txtSAmount" readonly="true" style=\'border: 1px solid #AD7C7C; color: #000; background: white;\'>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">                                                    
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
                                                            <th>Location</th>
                                                            <th>Qty</th>
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
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
                                                    <a class="btn btn-primary btnSave"><i class="fa fa-save"></i> Save Changes</a>
                                                    <a class="btn btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete</a>
                                                    <a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print</a>
                                                </div>
                                            </div>
                                        </div>  <!-- end of col -->

                                        <div class="col-lg-7">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon fancy-addon">Qty</span>
                                                        <input type="text" class="form-control num" id="txtGQty" readonly="true" style=\'border: 1px solid #AD7C7C; color: #000; background: white;\'>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon fancy-addon">Amnt</span>
                                                        <input type="text" class="form-control num" id="txtGAmnt" readonly="true" style=\'border: 1px solid #AD7C7C; color: #000; background: white;\'>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon other-addon">Freight</span>
                                                        <input type="text" class="form-control num" id="txtGFreight" style=\'border: 1px solid #AD7C7C; color: #000; background: white;\'>
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