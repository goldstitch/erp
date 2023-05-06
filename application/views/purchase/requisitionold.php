

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
                <h1 class="page_title">Requisition Voucher</h1>
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
                                                    <span class="input-group-addon id-addon">Requisition#</span>
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
                                                    <span class="input-group-addon txt-addon">Noted By</span>
                                                    <input type="text" list=\'notedby\' id=\'txtNotedBy\' class="form-control">
                                                    <datalist id=\'notedby\'>
                                                        ';foreach ($notedbys as $notedby): ;echo '                                                            <option value="';echo $notedby['noted_by'];;echo '">
                                                        ';endforeach ;echo '                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Demand#</span>
                                                    <input type="text" class="form-control num" id="txtDemandNo">
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
                                                    <span class="input-group-addon txt-addon">Location</span>
                                                    <select class="form-control select2" id="dept_dropdown">
                                                        <option value="" disabled="" selected="">Choose location</option>
                                                        ';foreach ($departments as $department): ;echo '                                                            <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"></div>
                                        <div class="row"></div>

                                        <div class="container-wrap">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div class="input-group">
                                                        <select class="form-control select2" id="itemid_dropdown">
                                                            <option value="" disabled="" selected="">Item Id</option>
                                                            ';foreach ($items as $item): ;echo '                                                                <option value="';echo $item['item_id'];;echo '" data-stock="';echo $item['stock'];;echo '" data-prate="';echo $item['prate'];;echo '">';echo $item['item_id'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="form-control select2" id="item_dropdown">
                                                        <option value="" disabled="" selected="">Item description</option>
                                                        ';foreach ($items as $item): ;echo '                                                            <option value="';echo $item['item_id'];;echo '" data-stock="';echo $item['stock'];;echo '" data-prate="';echo $item['prate'];;echo '">';echo $item['description'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'>Stk</span>
                                                        <input type="text" class="form-control num" id="txtStk" style="width: 45px;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'>PRate</span>
                                                        <input type="text" class="form-control num" id="txtPRate">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'>Qty</span>
                                                        <input type="text" class="form-control num" id="txtSQty">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'>Remarks</span>
                                                        <input type="text" class="form-control" id="txtSRemarks">
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
                                                <table class="table table-striped" id="requisition_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr#</th>
                                                            <th>Item Code</th>
                                                            <th>Item Detail</th>
                                                            <th>Location</th>
                                                            <th>Stock</th>
                                                            <th>PRate</th>
                                                            <th>Qty</th>
                                                            <th>Remarks</th>
                                                            <th></th>
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
                                        <div class="col-lg-5"></div>
                                        <div class="col-lg-2">
                                            <div class="pull-right">
                                                <div class="input-group">
                                                    <span class="input-group-addon fancy-addon" style=\'min-width:0px;\'>Qty</span>
                                                    <input type="text" class="form-control num" id="txtGQty" readonly="true">
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